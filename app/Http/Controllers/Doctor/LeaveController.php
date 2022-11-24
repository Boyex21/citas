<?php

namespace App\Http\Controllers\Doctor;

use App\Models\Leave;
use App\Models\Setting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class LeaveController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:doctor');
    }

    public function index()
    {
        $setting=Setting::first();
        $leaves=Leave::where('doctor_id',Auth::guard('doctor')->user()->id)->get();
        return view('doctor.leave',compact('setting', 'leaves'));
    }

    public function store(Request $request)
    {
        $rules=[
            'date'=>'required'
        ];
        $this->validate($request, $rules);

        $doctor=Auth::guard('doctor')->user();
        $date=$request->date;
        $exist=Leave::where(['date' => $date, 'doctor_id' => $doctor->id])->count();
        if($exist==0){
            $leave=new Leave();
            $leave->doctor_id=$doctor->id;
            $leave->date=$date;
            $leave->save();

            $notification='Registrado Exitosamente';
            $notification=array('messege' => $notification, 'alert-type' => 'success');
            return redirect()->route('doctor.leave.index')->with($notification);
        }else{
            $notification='Ya existe en el sistema';
            $notification=array('messege' => $notification, 'alert-type' => 'error');
            return redirect()->route('doctor.leave.index')->with($notification);
        }
    }

    public function update(Request $request, $id)
    {
        $rules=[
            'date'=>'required'
        ];
        $this->validate($request, $rules);

        $leave=Leave::find($id);
        $leave->date=$request->date;
        $leave->save();

        $notification='Edición Exitosa';
        $notification=array('messege' => $notification, 'alert-type' => 'success');
        return redirect()->route('doctor.leave.index')->with($notification);
    }

    public function destroy(Leave $leave)
    {
        $leave->delete();
        $notification='Eliminación Exitosa';
        $notification=array('messege' => $notification, 'alert-type' => 'success');
        return redirect()->route('doctor.leave.index')->with($notification);
    }
}
