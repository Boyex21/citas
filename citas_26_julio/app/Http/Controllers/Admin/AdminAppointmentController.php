<?php

namespace App\Http\Controllers\Admin;

use App\Models\Day;
use App\Models\User;
use App\Models\Leave;
use App\Models\Doctor;
use App\Models\Setting;
use App\Models\Chamber;
use App\Models\Schedule;
use App\Models\Medicine;
use App\Models\Appointment;
use App\Models\PrescriptionMedicine;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Auth;
use Hash;

class AdminAppointmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(){
        $setting=Setting::first();
        $appointments=Appointment::orderBy('id', 'DESC')->get();
        return view('admin.appointment', compact('setting', 'appointments'));
    }

    public function createAppointment(){
        $days=Day::all();
        $setting=Setting::first();
        $doctors=Doctor::orderBy('id', 'DESC')->get();
        $patients=User::where('status', 1)->orderBy('name', 'ASC')->get();
        return view('admin.create_appointment', compact('setting', 'doctors', 'days', 'patients'));
    }

    public function getChamber(Request $request){
        if($request->doctor){
            $doctor=Doctor::where('id', $request->doctor)->first();
            $chambers=Chamber::where(['doctor_id' => $doctor->id, 'status' => 1])->get();

            $response="<option>Seleccione</option>";
            foreach($chambers as $chamber){
                $response.='<option value="'.$chamber->id.'">'.$chamber->name.'</option>';
            }

            return response()->json(['status' => 1, 'chambers' => $response]);
        }else{
            $notification='El doctor es obligatorio';
            return response()->json(['status' => 0, 'message' => $notification]);
        }
    }

    public function getSchedule(Request $request){
        if($request->date){
            $doctor=Doctor::where('id', $request->doctor)->first();
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
                $response.='<option value="'.$schedule->id.'">'.$start_time.'-'.$end_time.' - ('.$exist.')</option>';
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
            $doctor=Doctor::where('id', $request->doctor)->first();
            $schedule=Schedule::find($request->schedule);
            $todayAppointmentQty=Appointment::where('doctor_id', $doctor->id)->where('date', $request->date)->where('schedule_id' , $schedule->id)->count();
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

    public function storeAppointment(Request $request){
        $doctor=Doctor::where('id', $request->doctor)->first();
        $day=Day::where('id',$request->day)->first();
        $schedules=Schedule::where(['doctor_id' => $doctor->id, 'day_id' => $day->id])->get();
        $schedule=Schedule::find($request->schedule);
        $todayAppointmentQty=Appointment::where('doctor_id', $doctor->id)->where('date', $request->date)->where('schedule_id' , $schedule->id)->count();
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
}