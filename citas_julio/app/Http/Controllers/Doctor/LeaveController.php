<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Leave;
use Auth;
class LeaveController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:doctor');
    }

    public function index()
    {
        $leaves = Leave::where('doctor_id',Auth::guard('doctor')->user()->id)->get();

        return view('doctor.leave',compact('leaves'));
    }

    public function store(Request $request)
    {

        $rules = [
            'date'=>'required'
        ];
        $customMessages = [
            'date.required' => trans('user_validation.Date is required'),
        ];
        $this->validate($request, $rules, $customMessages);


        $doctor = Auth::guard('doctor')->user();
        $date = $request->date;
        $exist = Leave::where(['date' => $date, 'doctor_id' => $doctor->id])->count();
        if($exist ==0){
            $leave = new Leave();
            $leave->doctor_id = $doctor->id;
            $leave->date = $date;
            $leave->save();

            $notification = trans('user_validation.Created Successfully');
            $notification=array('messege'=>$notification,'alert-type'=>'success');
            return redirect()->route('doctor.leave.index')->with($notification);
        }else{

            $notification = trans('user_validation.Already exist');
            $notification = array('messege'=>$notification,'alert-type'=>'error');
            return redirect()->route('doctor.leave.index')->with($notification);
        }

    }


    public function update(Request $request, $id)
    {
        $rules = [
            'date'=>'required'
        ];
        $customMessages = [
            'date.required' => trans('user_validation.Date is required'),
        ];
        $this->validate($request, $rules, $customMessages);

        $leave = Leave::find($id);
        $leave->date = $request->date;
        $leave->save();

        $notification = trans('user_validation.Update Successfully');
        $notification = array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->route('doctor.leave.index')->with($notification);

    }

    public function destroy(Leave $leave)
    {
        $leave->delete();
        $notification = trans('user_validation.Delete Successfully');
        $notification = array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->route('doctor.leave.index')->with($notification);
    }
}
