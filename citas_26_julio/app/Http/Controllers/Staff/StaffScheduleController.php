<?php

namespace App\Http\Controllers\Staff;

use App\Models\Day;
use App\Models\Doctor;
use App\Models\Setting;
use App\Models\Chamber;
use App\Models\Schedule;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class StaffScheduleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:staff');
    }

    public function index(){
        $setting=Setting::first();
        $staff=Auth::guard('staff')->user();
        $doctor=Doctor::find($staff->doctor_id);
        if($staff->chamber_id==''){
            $schedules=Schedule::with('appointments')->where('doctor_id', $staff->doctor_id)->get();
        }else{
            $schedules=Schedule::with('appointments')->where('doctor_id', $staff->doctor_id)->where('chamber_id', $staff->chamber_id)->get();
        }
        return view('staff.schedule', compact('setting', 'schedules'));
    }

    public function create(){
        $days=Day::all();
        $setting=Setting::first();
        $staff=Auth::guard('staff')->user();
        $doctor=Doctor::find($staff->doctor_id);
        if($staff->chamber_id==''){
            $chambers=Chamber::where('doctor_id', $doctor->id)->get();
        }else{
            $chambers=Chamber::where('doctor_id', $doctor->id)->where('id', $staff->chamber_id)->get();
        }
        return view('staff.create_schedule', compact('setting', 'days', 'chambers'));
    }

    public function store(Request $request){
        $staff=Auth::guard('staff')->user();
        $rules=[
            'day'=>'required',
            'start_time'=>'required',
            'end_time'=>'required',
            'appointment_limit'=>'required',
            'status'=>'required',
            'chamber'=>'required'
        ];
        $this->validate($request, $rules);

        $schedule=new Schedule();
        $schedule->doctor_id=$staff->doctor_id;
        $schedule->day_id=$request->day;
        $schedule->chamber_id=$request->chamber;
        $schedule->start_time=$request->start_time;
        $schedule->end_time=$request->end_time;
        $schedule->status=$request->status;
        $schedule->appointment_limit=$request->appointment_limit;
        $schedule->save();

        $notification='Registro Exitoso';
        $notification=array('messege' => $notification, 'alert-type' => 'success');
        return redirect()->back()->with($notification);
    }

    public function edit($id){
        $setting=Setting::first();
        $staff=Auth::guard('staff')->user();
        $doctor=Doctor::find($staff->doctor_id);
        $days=Day::all();
        $schedule=Schedule::find($id);
        if($staff->chamber_id==''){
            $chambers=Chamber::where('doctor_id', $doctor->id)->get();
        }else{
            $chambers=Chamber::where('doctor_id', $doctor->id)->where('id', $staff->chamber_id)->get();
        }
        return view('staff.edit_schedule', compact('setting', 'days', 'schedule','chambers'));
    }

    public function update(Request $request, $id){
        $staff=Auth::guard('staff')->user();
        $rules=[
            'day'=>'required',
            'start_time'=>'required',
            'end_time'=>'required',
            'appointment_limit'=>'required',
            'status'=>'required',
            'chamber'=>'required',
        ];
        $this->validate($request, $rules);

        $schedule=Schedule::find($id);
        $schedule->doctor_id=$staff->doctor_id;
        $schedule->chamber_id=$request->chamber;
        $schedule->day_id=$request->day;
        $schedule->start_time=$request->start_time;
        $schedule->end_time=$request->end_time;
        $schedule->status=$request->status;
        $schedule->appointment_limit=$request->appointment_limit;
        $schedule->save();

        $notification='Edición Exitosa';
        $notification=array('messege' => $notification, 'alert-type' => 'success');
        return redirect()->route('staff.schedule.index')->with($notification);
    }

    public function destroy($id){
        $schedule=Schedule::find($id);
        $schedule->delete();

        $notification='Eliminación Exitosa';
        $notification=array('messege' => $notification, 'alert-type' => 'success');
        return redirect()->route('staff.schedule.index')->with($notification);
    }

    public function changeStatus($id){
        $schedule=Schedule::find($id);
        if($schedule->status==1){
            $schedule->status=0;
            $schedule->save();
            $message='Desactivado Exitosamente';
        }else{
            $schedule->status=1;
            $schedule->save();
            $message='Activado Exitosamente';
        }

        return response()->json($message);
    }
}