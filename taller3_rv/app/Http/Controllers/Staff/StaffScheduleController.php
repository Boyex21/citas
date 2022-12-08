<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\Chamber;
use App\Models\Day;
use App\Models\Doctor;
use Auth;
class StaffScheduleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:staff');
    }

    public function index(){

        $staff = Auth::guard('staff')->user();
        $doctor = Doctor::find($staff->doctor_id);
        if($staff->chamber_id == -1){
            $schedules = Schedule::with('appointments')->where('doctor_id', $staff->doctor_id)->get();
        }else{
            $schedules = Schedule::with('appointments')->where('doctor_id', $staff->doctor_id)->where('chamber_id', $staff->chamber_id)->get();
        }


        return view('staff.schedule', compact('schedules'));
    }

    public function create(){

        $staff = Auth::guard('staff')->user();
        $doctor = Doctor::find($staff->doctor_id);

        $staff = Auth::guard('staff')->user();
        $days = Day::all();
        if($staff->chamber_id == -1){
            $chambers = Chamber::where('doctor_id', $doctor->id)->get();
        }else{
            $chambers = Chamber::where('doctor_id', $doctor->id)->where('id', $staff->chamber_id)->get();
        }
        return view('staff.create_schedule', compact('days','chambers'));
    }

    public function store(Request $request){

        $staff = Auth::guard('staff')->user();

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
        $schedule->doctor_id = $staff->doctor_id;
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
        $staff = Auth::guard('staff')->user();
        $doctor = Doctor::find($staff->doctor_id);
        $days = Day::all();
        $schedule = Schedule::find($id);
        $staff = Auth::guard('staff')->user();
        if($staff->chamber_id == -1){
            $chambers = Chamber::where('doctor_id', $doctor->id)->get();
        }else{
            $chambers = Chamber::where('doctor_id', $doctor->id)->where('id', $staff->chamber_id)->get();
        }
        return view('staff.edit_schedule', compact('days', 'schedule','chambers'));
    }

    public function update(Request $request, $id){
        $staff = Auth::guard('staff')->user();

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
        $schedule->doctor_id = $staff->doctor_id;
        $schedule->chamber_id = $request->chamber;
        $schedule->day_id = $request->day;
        $schedule->start_time = $request->start_time;
        $schedule->end_time = $request->end_time;
        $schedule->status = $request->status;
        $schedule->appointment_limit = $request->appointment_limit;
        $schedule->save();

        $notification= trans('user_validation.Update Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->route('staff.schedule.index')->with($notification);
    }

    public function destroy($id){
        $schedule = Schedule::find($id);
        $schedule->delete();

        $notification= trans('user_validation.Delete Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->route('staff.schedule.index')->with($notification);
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
