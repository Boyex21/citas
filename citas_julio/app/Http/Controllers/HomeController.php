<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\MaintainanceText;
use App\Models\Location;
use App\Models\Department;
use App\Models\Doctor;
use App\Mail\SubscriptionVerification;
use App\Mail\ContactMessageInformation;
use App\Models\Setting;
use App\Models\Order;
use App\Models\Leave;
use App\Models\Appointment;
use App\Models\Schedule;
use App\Models\Day;
use App\Models\Chamber;
use Mail;
use Str;
use Session;
use Carbon\Carbon;
use Route;
use Cache;
use File;
use Image;
use Auth;

class HomeController extends Controller
{
    public function getSchedule(Request $request){
        if($request->date){
            $doctor = Doctor::find($request->doctor_id);

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
            $doctor = Doctor::find($request->doctor_id);
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


    public function createAppointment(Request $request){
        $rules = [
            'consultation_type'=>'required',
            'chamber'=>'required',
            'doctor_id'=>'required',
            'date'=>'required',
            'schedule'=>'required',

        ];
        $customMessages = [
            'consultation_type.required' => trans('user_validation.Consultation type is required'),
            'chamber.required' => trans('user_validation.Chamber is required'),
            'doctor_id.required' => trans('user_validation.Doctor is required'),
            'date.required' => trans('user_validation.Date is required'),
            'schedule.required' => trans('user_validation.Schedule is required'),
        ];
        $this->validate($request, $rules,$customMessages);


        $schedule = Schedule::find($request->schedule);
        $doctor = Doctor::find($request->doctor_id);
        $department = Department::find($doctor->department_id);
        $chamber = Chamber::find($request->chamber);


        $data['id'] = rand(22,222);// it is mendetory
        $data['name'] = $doctor->name;
        $data['qty'] = 1;
        $data['price'] = $doctor->fee;
        $data['weight'] = 0; // it is mendetory
        $data['options']['doctor_id'] = $doctor->id;
        $data['options']['department'] = $department->name;
        $data['options']['location'] = $doctor->location->location;
        $data['options']['location_id'] = $doctor->location->id;
        $data['options']['chamber'] = $chamber->name;
        $data['options']['chamber_id'] = $chamber->id;
        $data['options']['date'] = $request->date;
        $start_time = date('h:i A', strtotime($schedule->start_time));
        $end_time = date('h:i A', strtotime($schedule->end_time));
        $data['options']['schedule'] = $start_time.'-'.$end_time;
        $data['options']['schedule_id'] = $schedule->id;
        $data['options']['day_id'] = $schedule->day_id;
        $data['options']['consultation_type'] = $request->consultation_type;

        Session::put('appointment', $data);
        $notification = trans('user_validation.Appointment created successfully');
        $notification = array('messege'=>$notification,'alert-type'=>'success');

        return redirect()->route('payment')->with($notification);
    }
}