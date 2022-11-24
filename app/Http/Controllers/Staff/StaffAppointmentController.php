<?php

namespace App\Http\Controllers\Staff;

use App\Models\Day;
use App\Models\User;
use App\Models\Leave;
use App\Models\Doctor;
use App\Models\Chamber;
use App\Models\Setting;
use App\Models\Schedule;
use App\Models\Medicine;
use App\Models\Appointment;
use App\Models\PrescriptionMedicine;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Hash;

class StaffAppointmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:staff');
    }

    public function createAppointment(){
        $days=Day::all();
        $setting=Setting::first();
        $staff=Auth::guard('staff')->user();
        $doctor=Doctor::find($staff->doctor_id);
        $patients=User::where('status', 1)->orderBy('name', 'ASC')->get();
        if($staff->chamber_id==''){
            $chambers=Chamber::where('doctor_id', $doctor->id)->get();
        }else{
            $chambers=Chamber::where('doctor_id', $doctor->id)->where('id', $staff->chamber_id)->get();
        }
        return view('staff.create_appointment', compact('setting', 'days', 'patients', 'chambers'));
    }

    public function storeAppointment(Request $request){
        $staff=Auth::guard('staff')->user();
        $doctor=Doctor::find($staff->doctor_id);
        $todayAppointmentQty=Appointment::where('doctor_id', $doctor->id)->where('date', $request->date)->count();

        $day=Day::where('id',$request->day)->first();
        $schedules=Schedule::where(['doctor_id' => $doctor->id, 'day_id' => $day->id])->get();
        $schedule=Schedule::find($request->schedule);
        if($todayAppointmentQty<$schedule->appointment_limit) {
            $appointment=new Appointment();
            $appointment->doctor_id=$doctor->id;
            $appointment->user_id=$request->patient;
            $appointment->day_id=$schedule->day_id;
            $appointment->schedule_id=$schedule->id;
            $appointment->chamber_id=$schedule->chamber_id;
            $appointment->date=$request->date;
            $appointment->consultation_type=$request->consultation_type;
            $appointment->already_treated=0;
            $appointment->status=0;
            $appointment->save();

            $notification='Registro Exitoso';
            $notification=array('messege' => $notification, 'alert-type' => 'success');
            return redirect()->back()->with($notification);
        }else{
            $notification='Hoy no se puede hacer ninguna cita';
            $notification=array('messege' => $notification, 'alert-type' => 'error');
            return redirect()->back()->with($notification);
        }
    }

    public function getSchedule(Request $request){
        if($request->date){
            $staff=Auth::guard('staff')->user();
            $doctor=Doctor::find($staff->doctor_id);
            $leave=Leave::where(['doctor_id' => $doctor->id,'date' => $request->date])->count();

            if($leave==1){
                $response="<option>Seleccione</option>";
                return response()->json(['status' => 1, 'schedules' => $response, 'scheduleQty' => 0]);
            }

            $day=Day::where('id',$request->day)->first();
            $schedules=Schedule::where(['doctor_id' => $doctor->id, 'day_id' => $day->id, 'status' => 1, 'chamber_id' => $request->chamber])->get();

            $response="<option>Seleccione</option>";
            foreach($schedules as $schedule){
                $checkQty=Appointment::where('doctor_id', $doctor->id)->where('date', $request->date)->where('schedule_id' , $schedule->id)->count();
                $exist=$schedule->appointment_limit-$checkQty;
                $exist=$exist.' Citas';

                $start_time=date('h:i A', strtotime($schedule->start_time));
                $end_time=date('h:i A', strtotime($schedule->end_time));
                $response.='<option value="'.$schedule->id.'">'.$start_time.'-'.$end_time.' - ('. $exist .')</option>';
            }
            $scheduleQty=$schedules->count();

            return response()->json(['status' => 1, 'schedules' => $response, 'scheduleQty' => $scheduleQty]);
        }else{
            $notification='La fecha es obligatoria';
            return response()->json(['status' => 0, 'message' => $notification]);
        }
    }

    public function scheduleAvaibility(Request $request){
        if($request->schedule){
            $staff=Auth::guard('staff')->user();
            $doctor=Doctor::find($staff->doctor_id);
            $schedule=Schedule::find($request->schedule);
            $todayAppointmentQty=Appointment::where('doctor_id', $doctor->id)->where('date', $request->date)->count();
            if($todayAppointmentQty<$schedule->appointment_limit){
                return response()->json(['status' => 1]);
            }else{
                $notification='Hoy no se puede hacer ninguna cita en este horario';
                return response()->json(['status' => 0, 'message' => $notification]);
            }
        }else{
            $notification='El horario es obligatorio';
            return response()->json(['status' => 0, 'message' => $notification]);
        }
    }

    public function deleteAppointment($id){
        $staff=Auth::guard('staff')->user();
        $appointment=Appointment::where('doctor_id', $staff->doctor_id)->where('id', $id)->first();
        PrescriptionMedicine::where('appointment_id', $appointment->id)->delete();
        $appointment->delete();

        $notification='Eliminación Exitosa';
        $notification=array('messege' => $notification, 'alert-type' => 'success');
        return redirect()->route('staff.appointment')->with($notification);
    }

    public function prescription(){
        $setting=Setting::first();
        $staff=Auth::guard('staff')->user();
        $doctor=Doctor::find($staff->doctor_id);
        $prescriptions=Appointment::where('doctor_id', $doctor->id)->where('already_treated', 1)->orderBy('id', 'DESC')->get();
        return view('staff.prescription', compact('setting', 'prescriptions'));
    }

    public function todayAppointment(){
        $today=date('Y-m-d');
        $setting=Setting::first();
        $staff=Auth::guard('staff')->user();
        $doctor=Doctor::find($staff->doctor_id);
        if($staff->chamber_id==''){
            $appointments=Appointment::where('doctor_id', $staff->doctor_id)->where('date', $today)->orderBy('id', 'DESC')->get();
        }else{
            $appointments=Appointment::where('doctor_id', $staff->doctor_id)->where('date', $today)->where('chamber_id', $staff->chamber_id)->orderBy('id', 'DESC')->get();
        }
        return view('staff.today_appointment', compact('setting', 'appointments'));
    }

    public function appointment(){
        $setting=Setting::first();
        $staff=Auth::guard('staff')->user();
        $doctor=Doctor::find($staff->doctor_id);

        if($staff->chamber_id==''){
            $appointments=Appointment::where('doctor_id', $staff->doctor_id)->orderBy('id', 'DESC')->get();
        }else{
            $appointments=Appointment::where('doctor_id', $staff->doctor_id)->where('chamber_id', $staff->chamber_id)->orderBy('id', 'DESC')->get();
        }
        return view('staff.appointment', compact('setting', 'appointments'));
    }

    public function showAppointment($id){
        $setting=Setting::first();
        $staff=Auth::guard('staff')->user();
        $appointment=Appointment::where('doctor_id', $staff->doctor_id)->where('id', $id)->first();
        if($appointment->already_treated==1){
            return redirect()->route('staff.show-prescription', $id);
        }
        $medicines=Medicine::orderBy('name', 'ASC')->get();
        return view('staff.show_appointment', compact('setting', 'appointment', 'medicines'));
    }

    public function showPrescription($id){
        $setting=Setting::first();
        $staff=Auth::guard('staff')->user();
        $doctor=Doctor::find($staff->doctor_id);
        $appointment=Appointment::where('doctor_id', $staff->doctor_id)->where('id', $id)->first();
        return view('staff.show_prescription', compact('setting', 'doctor', 'appointment'));
    }

    public function editAppointment($id){
        $setting=Setting::first();
        $doctor=Auth::guard('doctor')->user();
        $medicines=Medicine::orderBy('name', 'ASC')->get();
        $appointment=Appointment::where('doctor_id', $doctor->id)->where('id', $id)->first();
        return view('doctor.edit_appointment', compact('setting', 'appointment', 'medicines'));
    }

    public function deleteExistMedicine($id){
        $prescribe=PrescriptionMedicine::find($id);
        $prescribe->delete();

        $notification='Eliminación Exitosa';
        return response()->json(['success' => $notification]);
    }

    public function updatePrescription(Request $request, $id){
        $doctor=Auth::guard('doctor')->user();
        $appointment=Appointment::where('doctor_id', $doctor->id)->where('id', $id)->first();
        $appointment->blood_pressure=$request->blood_pressure;
        $appointment->pulse_rate=$request->pulse_rate;
        $appointment->temperature=$request->temperature;
        $appointment->problem_description=$request->problem_description;
        $appointment->advice=$request->advice;
        $appointment->test=$request->test;
        $appointment->status=$request->status;
        $appointment->status=1;
        $appointment->already_treated=1;
        $appointment->save();
        $oldPrescribes=PrescriptionMedicine::where('appointment_id', $appointment->id)->get();
        foreach($request->medicines as $medicine){
            if($medicine){
                $prescribe=new PrescriptionMedicine();
                $prescribe->appointment_id=$appointment->id;
                $prescribe->medicine_name=$request->medicines[$index];
                $prescribe->dosage=$request->dosages[$index];
                $prescribe->number_of_day=$request->days[$index];
                $prescribe->comment=$request->comments[$index];
                $prescribe->time=$request->times[$index];
                $prescribe->save();
            }
        }

        foreach($oldPrescribes as $oldPrescribe){
            $oldPrescribe->delete();
        }

        $notification='Edición Exitosa';
        $notification=array('messege' => $notification, 'alert-type' => 'success');
        return redirect()->route('doctor.show-prescription', $id)->with($notification);
    }

    public function createPatient(Request $request){
        $staff=Auth::guard('staff')->user();
        $rules=[
            'name'=>'required',
            'email'=>'required|unique:users',
            'phone'=>'required',
            'age'=>'required',
            'weight'=>'required',
            'gender'=>'required',
        ];
        $this->validate($request, $rules);

        $user=new User();
        $user->name=$request->name;
        $user->email=$request->email;
        $user->password=Hash::make(1234);
        $user->phone=$request->phone;
        $user->age=$request->age;
        $user->weight=$request->weight;
        $user->gender=$request->gender;
        $user->status=1;
        $user->email_verified=1;
        $user->save();

        $patients=User::where('status', 1)->orderBy('name', 'ASC')->get();
        $response="<option>Seleccione</option>";
        foreach($patients as $index=> $patient){
            $response.='<option value="'.$patient->id.'">'.$patient->name.'-'.$patient->phone.'</option>';
        }

        return response()->json(['status' => 1, 'patients' => $response]);
    }
}