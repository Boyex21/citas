<?php

namespace App\Http\Controllers\Doctor;

use App\Models\Day;
use App\Models\Setting;
use App\Models\Chamber;
use App\Models\Schedule;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class ScheduleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:doctor');
    }

    public function index(){
        $setting=Setting::first();
        $doctor=Auth::guard('doctor')->user();
        $schedules=Schedule::with('appointments')->where('doctor_id', $doctor->id)->get();
        return view('doctor.schedule', compact('setting', 'schedules'));
    }

    public function create(){
        $days=Day::all();
        $setting=Setting::first();
        $doctor=Auth::guard('doctor')->user();
        $chambers=Chamber::where('doctor_id', $doctor->id)->get();
        return view('doctor.create_schedule', compact('setting', 'days', 'chambers'));
    }

    public function store(Request $request){
        $doctor=Auth::guard('doctor')->user();
        $rules=[
            'day'=>'required',
            'start_time'=>'required',
            'end_time'=>'required',
            'appointment_limit'=>'required',
            'status'=>'required',
            'chamber'=>'required',
        ];
        $this->validate($request, $rules);

        $schedule=new Schedule();
        $schedule->doctor_id=$doctor->id;
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
        $days=Day::all();
        $setting=Setting::first();
        $schedule=Schedule::find($id);
        $doctor=Auth::guard('doctor')->user();
        $chambers=Chamber::where('doctor_id', $doctor->id)->get();
        return view('doctor.edit_schedule', compact('setting', 'days', 'schedule', 'chambers'));
    }

    public function update(Request $request, $id){
        $doctor=Auth::guard('doctor')->user();
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
        $schedule->doctor_id=$doctor->id;
        $schedule->chamber_id=$request->chamber;
        $schedule->day_id=$request->day;
        $schedule->start_time=$request->start_time;
        $schedule->end_time=$request->end_time;
        $schedule->status=$request->status;
        $schedule->appointment_limit=$request->appointment_limit;
        $schedule->save();

        $notification='Edición Exitosa';
        $notification=array('messege' => $notification, 'alert-type' => 'success');
        return redirect()->route('doctor.schedule.index')->with($notification);
    }

    public function destroy($id){
        $schedule=Schedule::find($id);
        $schedule->delete();

        $notification='Eliminación Exitosa';
        $notification=array('messege' => $notification, 'alert-type' => 'success');
        return redirect()->route('doctor.schedule.index')->with($notification);
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