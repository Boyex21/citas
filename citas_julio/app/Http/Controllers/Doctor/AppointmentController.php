<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AppointmentOrder;
use App\Models\Appointment;
use App\Models\Medicine;
use App\Models\PrescriptionMedicine;
use App\Models\Setting;
use App\Models\User;
use App\Models\Chamber;
use App\Models\Schedule;
use App\Models\Day;
use App\Models\Order;
use Auth;

use App\Mail\AppointmentNotification;
use App\Helpers\MailHelper;
use App\Models\EmailTemplate;
use App\Models\ZoomCredential;
use App\Models\Leave;
use Mail;
use Hash;
use Session;

class AppointmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:doctor');
    }


    public function createAppointment(){
        $doctor = Auth::guard('doctor')->user();
        $patients = User::where('status', 1)->orderBy('name', 'asc')->get();
        $chambers = Chamber::where('doctor_id', $doctor->id)->get();
        $credential = ZoomCredential::where('doctor_id',$doctor->id)->first();
        $activeOrder = Order::where('doctor_id', $doctor->id)->where('status', 1)->first();

        $isShow = true;
        if ($activeOrder) {
            if($activeOrder->expired_date){
                if(date('Y-m-d') > $activeOrder->expired_date)  $isShow = false;
            }

        }else $isShow = false;

        if(!$isShow){
            $notification= trans('user_validation.Your subscription has expired. Please renew your subscription plan');
            $notification=array('messege'=>$notification,'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }

        return view('doctor.create_appointment', compact('patients','chambers','credential','activeOrder'));
    }

    public function getSchedule(Request $request){
        if($request->date){
            $doctor = Auth::guard('doctor')->user();

            $activeOrder = Order::where('doctor_id', $doctor->id)->where('status', 1)->first();

            if(!$activeOrder){
                $notification = trans('user_validation.Something went wrong');
                return response()->json(['status' => 0, 'message' => $notification]);
            }

            $leave= Leave::where(['doctor_id' => $doctor->id,'date' => $request->date])->count();

            if($leave == 1){
                $response = "<option>".trans('user_validation.Select Schedule')."</option>";
                return response()->json(['status' => 1, 'schedules' => $response, 'scheduleQty' => 0]);
            }

            $todayAppointmentQty = Appointment::where('doctor_id', $doctor->id)->where('date', $request->date)->count();

            if($activeOrder->daily_appointment_qty == -1){
                $day = date('l',strtotime($request->date));
                $day = Day::where('day',$day)->first();
                $schedules = Schedule::where(['doctor_id' => $doctor->id, 'day_id' => $day->id, 'status' => 1, 'chamber_id' => $request->chamber])->get();

                $response = "<option>".trans('user_validation.Select Schedule')."</option>";
                foreach($schedules as $index=> $schedule){
                    $checkQty = Appointment::where('doctor_id', $doctor->id)->where('date', $request->date)->where('schedule_id' , $schedule->id)->count();
                    $exist = $schedule->appointment_limit - $checkQty;
                    $exist = $exist.' '.trans('user_validation.Seats');

                    $start_time = date('h:i A', strtotime($schedule->start_time));
                    $end_time = date('h:i A', strtotime($schedule->end_time));
                    $response.='<option value="'.$schedule->id.'">'.$start_time.'-'.$end_time. ' - ('. $exist .')' .'</option>';
                }
                $scheduleQty = $schedules->count();

                return response()->json(['status' => 1, 'schedules' => $response, 'scheduleQty' => $scheduleQty]);
            }else{
                if($todayAppointmentQty < $activeOrder->daily_appointment_qty){
                    $day = date('l',strtotime($request->date));
                    $day = Day::where('day',$day)->first();
                    $schedules = Schedule::where(['doctor_id' => $doctor->id, 'day_id' => $day->id, 'status' => 1, 'chamber_id' => $request->chamber])->get();

                    $response = "<option>".trans('user_validation.Select Schedule')."</option>";
                    foreach($schedules as $index=> $schedule){
                        $checkQty = Appointment::where('doctor_id', $doctor->id)->where('date', $request->date)->where('schedule_id' , $schedule->id)->count();
                        $exist = $schedule->appointment_limit - $checkQty;
                        $exist = $exist.' '.trans('user_validation.Seats');

                        $start_time = date('h:i A', strtotime($schedule->start_time));
                        $end_time = date('h:i A', strtotime($schedule->end_time));
                        $response.='<option value="'.$schedule->id.'">'.$start_time.'-'.$end_time. ' - ('. $exist .')' .'</option>';
                    }
                    $scheduleQty = $schedules->count();

                    return response()->json(['status' => 1, 'schedules' => $response, 'scheduleQty' => $scheduleQty]);

                }else{
                    $notification = trans('user_validation.Today you can not make any appointment');
                    return response()->json(['status' => 0, 'message' => $notification]);
                }
            }


        }else{
            $notification = trans('user_validation.Date is required');
            return response()->json(['status' => 0, 'message' => $notification]);
        }
    }


    public function scheduleAvaibility(Request $request){
        if($request->schedule){

            $doctor = Auth::guard('doctor')->user();
            $schedule = Schedule::find($request->schedule);
            $todayAppointmentQty = Appointment::where('doctor_id', $doctor->id)->where('date', $request->date)->where('schedule_id' , $schedule->id)->count();
            if($todayAppointmentQty < $schedule->appointment_limit){
                return response()->json(['status' => 1]);
            }else{
                $notification = trans('user_validation.Today you can not make any appointment under this schedule');
                return response()->json(['status' => 0, 'message' => $notification]);
            }
        }else{
            $notification = trans('user_validation.Schedule is required');
            return response()->json(['status' => 0, 'message' => $notification]);
        }
    }

    public function storeAppointment(Request $request){

        $doctor = Auth::guard('doctor')->user();

        $activeOrder = Order::where('doctor_id', $doctor->id)->where('status', 1)->first();
        $todayAppointmentQty = Appointment::where('doctor_id', $doctor->id)->where('date', $request->date)->count();

        if($activeOrder->daily_appointment_qty == -1){
            $day = date('l',strtotime($request->date));
            $day = Day::where('day',$day)->first();
            $schedules = Schedule::where(['doctor_id' => $doctor->id, 'day_id' => $day->id])->get();
            $schedule = Schedule::find($request->schedule);
            $todayAppointmentQty = Appointment::where('doctor_id', $doctor->id)->where('date', $request->date)->where('schedule_id' , $schedule->id)->count();
            if($todayAppointmentQty < $schedule->appointment_limit) {
                $order = new AppointmentOrder();
                $order->user_id  = $request->patient;
                $order->doctor_id = $doctor->id;
                $order->invoice_id = date('Ymdhis').rand(9,99);
                $order->total_fee = $doctor->fee;
                $order->appointment_qty = 1;
                $order->payment_method = 'Hand Cash';
                $order->payment_status = 1;
                $order->transaction_id = 'hand_cash';
                $order->status = 1;
                $order->save();

                $appointment = new Appointment();
                $appointment->doctor_id = $doctor->id;
                $appointment->appointment_order_id = $order->id;
                $appointment->user_id = $request->patient;
                $appointment->day_id = $schedule->day_id;
                $appointment->schedule_id = $schedule->id;
                $appointment->chamber_id = $schedule->chamber_id;
                $appointment->date = $request->date;
                $appointment->fee = $doctor->fee;
                $appointment->consultation_type = $request->consultation_type;
                $appointment->already_treated = 0;
                $appointment->status = 0;
                $appointment->save();

                $setting = Setting::first();
                $user = User::find($request->patient);
                $template = EmailTemplate::where('id',9)->first();
                $message = $template->description;
                $subject = $template->subject;
                $message = str_replace('{{patient_name}}',$user->name,$message);
                $message = str_replace('{{doctor_name}}',$doctor->name,$message);
                $message = str_replace('{{date}}',$request->date,$message);
                $start_time = date('h:i A', strtotime($schedule->start_time));
                $end_time = date('h:i A', strtotime($schedule->end_time));
                $message = str_replace('{{schedule}}',$start_time.' - '.$end_time,$message);
                $total_amount = $setting->currency_icon. $appointment->fee;
                $message = str_replace('{{fee}}',$total_amount,$message);
                $message = str_replace('{{chamber}}',$schedule->chamber->name,$message);

                MailHelper::setMailConfig();
                Mail::to($user->email)->send(new AppointmentNotification($message,$subject));


                $notification = trans('user_validation.Appointment created successfully');
                $notification=array('messege'=>$notification,'alert-type'=>'success');
                return redirect()->back()->with($notification);
            }else{
                $notification = trans('user_validation.Today you can not make any appointment');
                $notification=array('messege'=>$notification,'alert-type'=>'error');
                return redirect()->back()->with($notification);
            }

        }else{
            if($todayAppointmentQty < $activeOrder->daily_appointment_qty){
                $day = date('l',strtotime($request->date));
                $day = Day::where('day',$day)->first();
                $schedules = Schedule::where(['doctor_id' => $doctor->id, 'day_id' => $day->id])->get();
                $schedule = Schedule::find($request->schedule);
                $todayAppointmentQty = Appointment::where('doctor_id', $doctor->id)->where('date', $request->date)->where('schedule_id' , $schedule->id)->count();
                if($todayAppointmentQty < $schedule->appointment_limit) {
                    $order = new AppointmentOrder();
                    $order->user_id  = $request->patient;
                    $order->doctor_id = $doctor->id;
                    $order->invoice_id = date('Ymdhis').rand(9,99);
                    $order->total_fee = $doctor->fee;
                    $order->appointment_qty = 1;
                    $order->payment_method = 'Hand Cash';
                    $order->payment_status = 1;
                    $order->transaction_id = 'hand_cash';
                    $order->status = 1;
                    $order->save();

                    $appointment = new Appointment();
                    $appointment->doctor_id = $doctor->id;
                    $appointment->appointment_order_id = $order->id;
                    $appointment->user_id = $request->patient;
                    $appointment->day_id = $schedule->day_id;
                    $appointment->schedule_id = $schedule->id;
                    $appointment->chamber_id = $schedule->chamber_id;
                    $appointment->date = $request->date;
                    $appointment->fee = $doctor->fee;
                    $appointment->consultation_type = $request->consultation_type;
                    $appointment->already_treated = 0;
                    $appointment->status = 0;
                    $appointment->save();

                    $setting = Setting::first();
                    $user = User::find($request->patient);
                    $template = EmailTemplate::where('id',9)->first();
                    $message = $template->description;
                    $subject = $template->subject;
                    $message = str_replace('{{patient_name}}',$user->name,$message);
                    $message = str_replace('{{doctor_name}}',$doctor->name,$message);
                    $message = str_replace('{{date}}',$request->date,$message);
                    $start_time = date('h:i A', strtotime($schedule->start_time));
                    $end_time = date('h:i A', strtotime($schedule->end_time));
                    $message = str_replace('{{schedule}}',$start_time.' - '.$end_time,$message);
                    $total_amount = $setting->currency_icon. $appointment->fee;
                    $message = str_replace('{{fee}}',$total_amount,$message);
                    $message = str_replace('{{chamber}}',$schedule->chamber->name,$message);

                    MailHelper::setMailConfig();
                    Mail::to($user->email)->send(new AppointmentNotification($message,$subject));


                    $notification = trans('user_validation.Appointment created successfully');
                    $notification=array('messege'=>$notification,'alert-type'=>'success');
                    return redirect()->back()->with($notification);
                }else{
                    $notification = trans('user_validation.Today you can not make any appointment');
                    $notification=array('messege'=>$notification,'alert-type'=>'error');
                    return redirect()->back()->with($notification);
                }
            }else{
                $notification = trans('user_validation.Today you can not make any appointment');
                $notification=array('messege'=>$notification,'alert-type'=>'error');
                return redirect()->back()->with($notification);
            }
        }

    }


    public function payment(){
        $doctor = Auth::guard('doctor')->user();
        $payments = AppointmentOrder::with('appointments')->where('doctor_id', $doctor->id)->orderBy('id', 'desc')->get();
        $setting = Setting::first();
        $title = trans('user_validation.Payment History');
        return view('doctor.appointment_payment', compact('payments', 'setting', 'title'));
    }

    public function pendingPayment(){
        $doctor = Auth::guard('doctor')->user();
        $payments = AppointmentOrder::with('appointments')->where('doctor_id', $doctor->id)->where('payment_status', 0)->orderBy('id', 'desc')->get();
        $setting = Setting::first();
        $title = trans('user_validation.Pending Payment');
        return view('doctor.appointment_payment', compact('payments', 'setting', 'title'));
    }

    public function showPayment($invoice_id){
        $doctor = Auth::guard('doctor')->user();
        $payment = AppointmentOrder::with('appointments')->where('doctor_id', $doctor->id)->where('invoice_id', $invoice_id)->first();
        $setting = Setting::first();
        return view('doctor.show_payment', compact('payment', 'setting'));
    }

    public function paymentApproved($id){
        $payment = AppointmentOrder::find($id);
        $payment->status = 1;
        $payment->payment_status = 1;
        $payment->save();

        $notification = trans('user_validation.Payment approved successfully');
        $notification = array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }

    public function deletePayment($id){

        $doctor = Auth::guard('doctor')->user();
        $payment = AppointmentOrder::where('doctor_id', $doctor->id)->where('id', $id)->first();

        $appointments = Appointment::where('appointment_order_id', $id)->get();
        foreach($appointments as $appointment){
            PrescriptionMedicine::where('appointment_id', $appointment->id)->delete();
            $appointment->delete();
        }
        $payment->delete();

        $notification= trans('user_validation.Delete Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->route('doctor.appointment-payment')->with($notification);

    }

    public function deleteAppointment($id){
        $doctor = Auth::guard('doctor')->user();
        $appointment = Appointment::where('doctor_id', $doctor->id)->where('id', $id)->first();
        $appointment_order_id = $appointment->appointment_order_id;
        $appointment_fee = $appointment->fee;
        PrescriptionMedicine::where('appointment_id', $appointment->id)->delete();
        $appointment->delete();

        $order = AppointmentOrder::find($appointment_order_id);
        $order->delete();

        $notification= trans('user_validation.Delete Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->route('doctor.appointment')->with($notification);
    }

    public function prescription(){
        $doctor = Auth::guard('doctor')->user();
        $prescriptions = Appointment::where('doctor_id', $doctor->id)->where('already_treated', 1)->orderBy('id', 'desc')->get();
        $setting = Setting::first();
        return view('doctor.prescription', compact('prescriptions', 'setting'));
    }

    public function todayAppointment(Request $request){
        $doctor = Auth::guard('doctor')->user();
        $today = date('Y-m-d');

        if($request->chamber){
            Session::put('chamber_id', $request->chamber);
        }

        if(Session::get('chamber_id')){
            $chamber_id = Session::get('chamber_id');
            if($chamber_id == -1){
                $appointments = Appointment::where('doctor_id', $doctor->id)->where('date', $today)->orderBy('id', 'desc')->get();
            }else{
                $appointments = Appointment::where('doctor_id', $doctor->id)->where('date', $today)->where('chamber_id', $chamber_id)->orderBy('id', 'desc')->get();
            }
        }else{
            $appointments = Appointment::where('doctor_id', $doctor->id)->where('date', $today)->orderBy('id', 'desc')->get();
        }

        $setting = Setting::first();
        $title = trans('user_validation.Today Appointment');
        $chambers = Chamber::where('doctor_id', $doctor->id)->get();
        return view('doctor.today_appointment', compact('appointments', 'setting', 'title','chambers'));
    }



    public function appointment(Request $request){

        $doctor = Auth::guard('doctor')->user();

        if($request->chamber){
            Session::put('chamber_id', $request->chamber);
        }

        if(Session::get('chamber_id')){
            $chamber_id = Session::get('chamber_id');
            if($chamber_id == -1){
                $appointments = Appointment::where('doctor_id', $doctor->id)->orderBy('id', 'desc')->get();
            }else{
                $appointments = Appointment::where('doctor_id', $doctor->id)->where('chamber_id', $chamber_id)->orderBy('id', 'desc')->get();
            }
        }else{
            $appointments = Appointment::where('doctor_id', $doctor->id)->orderBy('id', 'desc')->get();
        }

        $setting = Setting::first();
        $title = trans('user_validation.Appointment History');
        $chambers = Chamber::where('doctor_id', $doctor->id)->get();
        return view('doctor.appointment', compact('appointments', 'setting', 'title','chambers'));
    }

    public function showAppointment($id){
        $doctor = Auth::guard('doctor')->user();
        $appointment = Appointment::where('doctor_id', $doctor->id)->where('id', $id)->first();
        if($appointment->already_treated == 1){
            return redirect()->route('doctor.show-prescription', $id);
        }
        $setting = Setting::first();
        $medicines = Medicine::orderBy('name', 'asc')->get();
        return view('doctor.show_appointment', compact('appointment', 'setting', 'medicines'));
    }

    public function storePrescription(Request $request, $id){

        $doctor = Auth::guard('doctor')->user();
        $appointment = Appointment::where('doctor_id', $doctor->id)->where('id', $id)->first();
        $appointment->blood_pressure = $request->blood_pressure;
        $appointment->pulse_rate = $request->pulse_rate;
        $appointment->temperature = $request->temperature;
        $appointment->problem_description = $request->problem_description;
        $appointment->advice = $request->advice;
        $appointment->test = $request->test;
        $appointment->status = $request->status;
        $appointment->status = 1;
        $appointment->already_treated = 1;
        $appointment->next_visit_time = $request->next_visit_time;
        $appointment->next_visit_qty = $request->next_visit_qty;
        $appointment->save();

        foreach($request->medicines as $index => $medicine){
            if($medicine){
                $prescribe = new PrescriptionMedicine();
                $prescribe->appointment_id = $appointment->id;
                $prescribe->medicine_name = $request->medicines[$index];
                $prescribe->dosage = $request->dosages[$index];
                $prescribe->number_of_day = $request->days[$index];
                $prescribe->comment = $request->comments[$index];
                $prescribe->time = $request->times[$index];
                $prescribe->save();
            }
        }

        $notification= trans('user_validation.Prescription Created Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->route('doctor.show-prescription', $id)->with($notification);

    }

    public function showPrescription($id){
        $doctor = Auth::guard('doctor')->user();
        $appointment = Appointment::where('doctor_id', $doctor->id)->where('id', $id)->first();
        $setting = Setting::first();

        return view('doctor.show_prescription', compact('doctor', 'appointment', 'setting'));
    }

    public function editAppointment($id){
        $doctor = Auth::guard('doctor')->user();
        $appointment = Appointment::where('doctor_id', $doctor->id)->where('id', $id)->first();
        $setting = Setting::first();
        $medicines = Medicine::orderBy('name', 'asc')->get();
        return view('doctor.edit_appointment', compact('appointment', 'setting', 'medicines'));
    }

    public function deleteExistMedicine($id){
        $prescribe = PrescriptionMedicine::find($id);
        $prescribe->delete();

        $notification = trans('user_validation.Removed Successfully');
        return response()->json(['success'=>$notification]);
    }

    public function updatePrescription(Request $request, $id){
        $doctor = Auth::guard('doctor')->user();
        $appointment = Appointment::where('doctor_id', $doctor->id)->where('id', $id)->first();
        $appointment->blood_pressure = $request->blood_pressure;
        $appointment->pulse_rate = $request->pulse_rate;
        $appointment->temperature = $request->temperature;
        $appointment->problem_description = $request->problem_description;
        $appointment->advice = $request->advice;
        $appointment->test = $request->test;
        $appointment->status = $request->status;
        $appointment->status = 1;
        $appointment->already_treated = 1;
        $appointment->next_visit_time = $request->next_visit_time;
        $appointment->next_visit_qty = $request->next_visit_qty;
        $appointment->save();
        $oldPrescribes = PrescriptionMedicine::where('appointment_id', $appointment->id)->get();
        foreach($request->medicines as $index => $medicine){
            if($medicine){
                $prescribe = new PrescriptionMedicine();
                $prescribe->appointment_id = $appointment->id;
                $prescribe->medicine_name = $request->medicines[$index];
                $prescribe->dosage = $request->dosages[$index];
                $prescribe->number_of_day = $request->days[$index];
                $prescribe->comment = $request->comments[$index];
                $prescribe->time = $request->times[$index];
                $prescribe->save();
            }
        }


        foreach($oldPrescribes as $oldPrescribe){
            $oldPrescribe->delete();
        }

        $notification= trans('user_validation.Prescription Update Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->route('doctor.show-prescription', $id)->with($notification);
    }


    public function createPatient(Request $request){
        $staff=Auth::guard('staff')->user();
        $rules = [
            'name'=>'required',
            'email'=>'required|unique:users',
            'phone'=>'required',
            'age'=>'required',
            'weight'=>'required',
            'gender'=>'required',
        ];
        $customMessages = [
            'name.required' => trans('user_validation.Name is required'),
            'email.required' => trans('user_validation.Email is required'),
            'email.unique' => trans('user_validation.Email already exist'),
            'phone.required' => trans('user_validation.Phone is required'),
            'age.required' => trans('user_validation.Age is required'),
            'weight.required' => trans('user_validation.Weight is required'),
            'gender.required' => trans('user_validation.Gender is required'),
        ];
        $this->validate($request, $rules,$customMessages);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make(1234);
        $user->phone = $request->phone;
        $user->age = $request->age;
        $user->weight = $request->weight;
        $user->gender = $request->gender;
        $user->status = 1;
        $user->email_verified = 1;
        $user->save();


        $patients = User::where('status', 1)->orderBy('name', 'asc')->get();

        $response = "<option>".trans('user_validation.Select Patient')."</option>";
        foreach($patients as $index=> $patient){
            $response.='<option value="'.$patient->id.'">'.$patient->name.'-'.$patient->phone.'</option>';
        }

        return response()->json(['status' => 1, 'patients' => $response]);

    }


}
