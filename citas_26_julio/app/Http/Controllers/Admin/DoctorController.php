<?php

namespace App\Http\Controllers\Admin;

use App\Models\Staff;
use App\Models\Leave;
use App\Models\Doctor;
use App\Models\Setting;
use App\Models\Chamber;
use App\Models\Schedule;
use App\Models\Appointment;
use App\Models\PrescriptionMedicine;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use File;
use Hash;

class DoctorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function doctors(){
        $setting=Setting::first();
        $doctors=Doctor::orderBy('id', 'DESC')->get();
        return view('admin.doctor', compact('setting', 'doctors'));
    }

    public function doctorStore(Request $request){
        $rules=[
            'name' => 'required',
            'email' => 'required|unique:admins',
            'password' => 'required|min:4'
        ];
        $this->validate($request, $rules);

        $doctor=new Doctor();
        $doctor->name=$request->name;
        $doctor->email=$request->email;
        $doctor->status=$request->status;
        $doctor->password=Hash::make($request->password);
        $doctor->save();

        $notification='Registro Exitoso';
        $notification=array('messege' => $notification, 'alert-type' => 'success');
        return redirect()->back()->with($notification);
    }

    public function staff(){
        $setting=Setting::first();
        $staffs=Staff::orderBy('id', 'DESC')->get();
        return view('admin.staff', compact('setting', 'staffs'));
    }

    public function showDoctor($id){
        $setting=Setting::first();
        $doctor=Doctor::find($id);
        return view('admin.show_doctor', compact('setting', 'doctor'));
    }

    public function destroy($id){
        $doctor=Doctor::find($id);
        Chamber::where('doctor_id', $doctor->id)->delete();
        $appointments=Appointment::where('doctor_id', $doctor->id)->get();
        foreach($appointments as $appointment){
            PrescriptionMedicine::where('appointment_id', $appointment->id)->delete();
            $appointment->delete();
        }
        Schedule::where(['doctor_id' => $doctor->id])->delete();
        Leave::where(['doctor_id' => $doctor->id])->delete();

        $staffs=Staff::where('doctor_id', $doctor->id)->get();
        foreach($staffs as $staff){
            $old_image=$staff->image;
            $staff->delete();
            if($old_image){
                if(File::exists(public_path().'/'.$old_image)){
                    unlink(public_path().'/'.$old_image);
                }
            }
        }

        $old_image=$doctor->image;
        $doctor->delete();
        if($old_image){
            if(File::exists(public_path().'/'.$old_image)){
                unlink(public_path().'/'.$old_image);
            }
        }

        $notification='Eliminación Exitosa';
        $notification=array('messege' => $notification, 'alert-type' => 'success');
        return redirect()->route('admin.doctor')->with($notification);
    }

    public function changeStatus($id){
        $doctor=Doctor::find($id);
        if($doctor->status==1){
            $doctor->status=0;
            $doctor->save();
            $message='Desactivado Exitosamente';
        }else{
            $doctor->status=1;
            $doctor->save();
            $message='Activado Exitosamente';
        }
        return response()->json($message);
    }
}