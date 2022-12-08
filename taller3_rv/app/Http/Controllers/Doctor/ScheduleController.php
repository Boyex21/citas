<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\Chamber;
use App\Models\Day;
use Auth;
class ScheduleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:doctor');
    }

    public function index(){
        $doctor = Auth::guard('doctor')->user();
        $schedules = Schedule::with('appointments')->where('doctor_id', $doctor->id)->get();

        return view('doctor.schedule', compact('schedules'));
    }

    public function create(){
        $doctor = Auth::guard('doctor')->user();
        $days = Day::all();
        $chambers = Chamber::where('doctor_id', $doctor->id)->get();
        return view('doctor.create_schedule', compact('days','chambers'));
    }

    public function store(Request $request){

        $doctor = Auth::guard('doctor')->user();

        $rules = [
            'day'=>'required',
            'start_time'=>'required',
            'end_time'=>'required',
            'appointment_limit'=>'required',
            'status'=>'required',
            'chamber'=>'required',
        ];
        $customMessages = [
            'day.required' => trans('user_validation.Day is required'),
            'start_time.required' => trans('user_validation.Start time is required'),
            'end_time.required' => trans('user_validation.End time is required'),
            'appointment_limit.required' => trans('user_validation.Appointment limit is required'),
            'chamber.required' => trans('user_validation.Chamber is required'),
        ];

        $this->validate($request, $rules, $customMessages);

        $schedule = new Schedule();
        $schedule->doctor_id = $doctor->id;
        $schedule->day_id = $request->day;
        $schedule->chamber_id = $request->chamber;
        $schedule->start_time = $request->start_time;
        $schedule->end_time = $request->end_time;
        $schedule->status = $request->status;
        $schedule->appointment_limit = $request->appointment_limit;
        $schedule->save();

        $notification= trans('user_validation.Created Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);

    }

    public function edit($id){
        $days = Day::all();
        $schedule = Schedule::find($id);
        $doctor = Auth::guard('doctor')->user();
        $chambers = Chamber::where('doctor_id', $doctor->id)->get();
        return view('doctor.edit_schedule', compact('days', 'schedule','chambers'));
    }

    public function update(Request $request, $id){
        $doctor = Auth::guard('doctor')->user();

        $rules = [
            'day'=>'required',
            'start_time'=>'required',
            'end_time'=>'required',
            'appointment_limit'=>'required',
            'status'=>'required',
            'chamber'=>'required',
        ];
        $customMessages = [
            'day.required' => trans('user_validation.Day is required'),
            'start_time.required' => trans('user_validation.Start time is required'),
            'end_time.required' => trans('user_validation.End time is required'),
            'appointment_limit.required' => trans('user_validation.Appointment limit is required'),
            'chamber.required' => trans('user_validation.Chamber is required'),
        ];

        $this->validate($request, $rules, $customMessages);

        $schedule = Schedule::find($id);
        $schedule->doctor_id = $doctor->id;
        $schedule->chamber_id = $request->chamber;
        $schedule->day_id = $request->day;
        $schedule->start_time = $request->start_time;
        $schedule->end_time = $request->end_time;
        $schedule->status = $request->status;
        $schedule->appointment_limit = $request->appointment_limit;
        $schedule->save();

        $notification= trans('user_validation.Update Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->route('doctor.schedule.index')->with($notification);
    }

    public function destroy($id){
        $schedule = Schedule::find($id);
        $schedule->delete();

        $notification= trans('user_validation.Delete Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->route('doctor.schedule.index')->with($notification);
    }


    public function changeStatus($id){
        $schedule = Schedule::find($id);
        if($schedule->status==1){
            $schedule->status=0;
            $schedule->save();
            $message= trans('user_validation.Inactive Successfully');
        }else{
            $schedule->status=1;
            $schedule->save();
            $message= trans('user_validation.Active Successfully');
        }

        return response()->json($message);
    }


}
