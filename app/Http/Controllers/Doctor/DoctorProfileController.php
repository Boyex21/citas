<?php

namespace App\Http\Controllers\Doctor;

use App\Models\Staff;
use App\Models\Doctor;
use App\Models\Setting;
use App\Models\Chamber;
use App\Models\Location;
use App\Models\Department;
use App\Models\Appointment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Image;
use Auth;
use Hash;
use File;
use Str;

class DoctorProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:doctor');
    }

    public function dashboard(){
        $setting=Setting::first();
        $doctor=Auth::guard('doctor')->user();
        
        $todayAppointments=Appointment::whereDay('created_at', now()->day)->where('doctor_id', $doctor->id)->get();
        $appointments=Appointment::where('doctor_id', $doctor->id)->get();
        $monthlyAppointments=Appointment::whereMonth('created_at', now()->month)->where('doctor_id', $doctor->id)->get();
        $yearlyAppointments=Appointment::whereYear('created_at', now()->year)->where('doctor_id', $doctor->id)->get();
        
        $chambers=Chamber::where('doctor_id', $doctor->id)->get();
        $staffs=Staff::where('doctor_id', $doctor->id)->get();

        return view('doctor.dashboard', compact('setting', 'todayAppointments', 'appointments', 'monthlyAppointments', 'yearlyAppointments', 'chambers', 'staffs'));
    }

    public function myProfile(){
        $setting=Setting::first();
        $doctor=Auth::guard('doctor')->user();
        $locations=Location::where('status', 1)->get();
        $departments=Department::where('status', 1)->get();
        return view('doctor.my_profile', compact('setting', 'doctor', 'locations', 'departments'));
    }

    public function updateProfile(Request $request){
        $doctor=Auth::guard('doctor')->user();
        $rules=[
            'name'=>'required',
            'slug'=>'required|unique:doctors,slug,'.$doctor->id,
            'email'=>'required|unique:doctors,email,'.$doctor->id,
            'location_id' => 'required',
            'department_id' => 'required',
            'about' => 'required',
            'qualification' => 'required',
            'designation' => 'required',
            'address' => 'required',
        ];
        $this->validate($request, $rules);

        // inset user profile image
        if($request->file('image')){
            $old_image=$doctor->image;
            $user_image=$request->image;
            $extention=$user_image->getClientOriginalExtension();
            $image_name=Str::slug($request->name).date('-Y-m-d-h-i-s-').rand(999,9999).'.'.$extention;
            $image_name ='uploads/custom-images/'.$image_name;

            Image::make($user_image)->save(public_path().'/'.$image_name);

            $doctor->image=$image_name;
            $doctor->save();
            if($old_image){
                if(File::exists(public_path().'/'.$old_image))unlink(public_path().'/'.$old_image);
            }
        }

        $doctor->name=$request->name;
        $doctor->slug=$request->slug;
        $doctor->phone=$request->phone;
        $doctor->location_id=$request->location_id;
        $doctor->department_id=$request->department_id;
        $doctor->about=$request->about;
        $doctor->qualifications=$request->qualification;
        $doctor->designation=$request->designation;
        $doctor->address=$request->address;
        $doctor->profile_fillup=1;
        $doctor->save();

        $notification='Edición Exitosa';
        $notification=array('messege' => $notification, 'alert-type' => 'success');
        return redirect()->route('doctor.profile')->with($notification);
    }

    public function changePassword(){
        $setting=Setting::first();
        return view('doctor.change_password', compact('setting'));
    }

    public function updatePassword(Request $request){
        $doctor=Auth::guard('doctor')->user();
        $rules=[
            'password' => 'required|confirmed|min:4',
        ];
        $this->validate($request, $rules);

        $doctor->password=Hash::make($request->password);
        $doctor->save();

        $notification='Edición Exitosa';
        $notification=array('messege' => $notification, 'alert-type' => 'success');
        return redirect()->back()->with($notification);
    }
}