<?php

namespace App\Http\Controllers\Doctor;

use App\Models\Staff;
use App\Models\Chamber;
use App\Models\Setting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Hash;
use File;

class StaffController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:doctor');
    }

    public function index(){
        $setting=Setting::first();
        $doctor=Auth::guard('doctor')->user();
        $staffs=Staff::where('doctor_id', $doctor->id)->get();
        $chambers=Chamber::where('doctor_id', $doctor->id)->get();
        return view('doctor.staff', compact('setting', 'staffs', 'chambers'));
    }

    public function store(Request $request){
        $doctor=Auth::guard('doctor')->user();
        $rules=[
            'name' => 'required',
            'email' => 'required|unique:staff',
            'password' => 'required|min:4',
        ];
        $this->validate($request, $rules);

        $staff=new Staff();
        $staff->doctor_id=$doctor->id;
        $staff->name=$request->name;
        $staff->email=$request->email;
        $staff->status=$request->status;
        $staff->chamber_id=$request->chamber;
        $staff->password=Hash::make($request->password);
        $staff->save();

        $notification='Registro Exitoso';
        $notification=array('messege' => $notification, 'alert-type' => 'success');
        return redirect()->back()->with($notification);
    }

    public function update(Request $request, $id){
        $rules=[
            'name' => 'required',
            'email' => 'required|unique:staff,email,'.$id,
            'password' => $request->password ? 'min:4' : '',
        ];
        $this->validate($request, $rules);

        $staff=Staff::find($id);
        $staff->chamber_id=$request->chamber;
        $staff->name=$request->name;
        $staff->email=$request->email;
        if($request->password){
            $staff->password =Hash::make($request->password);
        }
        $staff->save();

        $notification='Edición Exitosa';
        $notification=array('messege' => $notification, 'alert-type' => 'success');
        return redirect()->back()->with($notification);
    }

    public function destroy($id){
        $staff=Staff::find($id);
        $old_image=$staff->image;
        $staff->delete();
        if($old_image){
            if(File::exists(public_path().'/'.$old_image)){
                unlink(public_path().'/'.$old_image);
            }
        }

        $notification='Eliminación Exitosa';
        $notification=array('messege' => $notification, 'alert-type' => 'success');
        return redirect()->back()->with($notification);
    }

    public function changeStatus($id){
        $staff=Staff::find($id);
        if($staff->status==1){
            $staff->status=0;
            $staff->save();
            $message='Desactivado Exitosamente';
            return response()->json(['status' => 1 , 'message' => $message]);
        }else{
            $staff->status=1;
            $staff->save();
            $message='Activado Exitosamente';
            return response()->json(['status' => 1 , 'message' => $message]);
        }
    }
}