<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Staff;
use App\Models\Setting;
use App\Models\BannerImage;
use App\Models\Location;
use App\Models\Department;
use App\Models\Appointment;
use App\Models\AppointmentOrder;
use App\Models\Chamber;
use App\Models\Doctor;
use Str;
use Auth;
use Hash;
use Image;
use File;
class StaffProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:staff');
    }

    public function dashboard(){
        $staff = Auth::guard('staff')->user();
        $doctor = Doctor::find($staff->doctor_id);

        $todayAppointments = Appointment::whereDay('created_at', now()->day)->where('doctor_id', $doctor->id)->get();

        $todayOrders = AppointmentOrder::with('doctor')->orderBy('id','desc')->whereDay('created_at', now()->day)->get();
        $orders = AppointmentOrder::with('doctor')->orderBy('id','desc')->where('doctor_id', $doctor->id)->get();
        $setting = Setting::first();
        $appointments = Appointment::where('doctor_id', $doctor->id)->get();

        $monthlyAppointments = Appointment::whereMonth('created_at', now()->month)->where('doctor_id', $doctor->id)->get();
        $yearlyAppointments = Appointment::whereYear('created_at', now()->year)->where('doctor_id', $doctor->id)->get();

        $chambers = Chamber::where('doctor_id', $doctor->id)->get();
        $staffs = Staff::where('doctor_id', $doctor->id)->get();

        return view('staff.dashboard', compact('todayAppointments','todayOrders','orders','setting', 'appointments','monthlyAppointments', 'yearlyAppointments','chambers','staffs'));
    }

    public function myProfile(){
        $staff = Auth::guard('staff')->user();
        $defaultProfile = BannerImage::whereId('15')->first();

        $locations = Location::where('status', 1)->get();
        $departments = Department::where('status', 1)->get();
        return view('staff.my_profile', compact('staff','defaultProfile','locations','departments'));
    }

    public function updateProfile(Request $request){
        $staff=Auth::guard('staff')->user();
        $rules = [
            'name'=>'required',
            'email'=>'required',
            'password'=> $request->password ? 'min:4|confirmed' : '',
        ];
        $customMessages = [
            'name.required' => trans('user_validation.Name is required'),
            'password.confirmed' => trans('user_validation.Password confirmation does not match'),
            'password.min' => trans('user_validation.Password must be at least 4 characters'),
        ];
        $this->validate($request, $rules,$customMessages);

        // inset user profile image
        if($request->file('image')){
            $old_image = $staff->image;
            $user_image = $request->image;
            $extention = $user_image->getClientOriginalExtension();
            $image_name = Str::slug($request->name).date('-Y-m-d-h-i-s-').rand(999,9999).'.'.$extention;
            $image_name ='uploads/custom-images/'.$image_name;

            Image::make($user_image)
                ->save(public_path().'/'.$image_name);

            $staff->image=$image_name;
            $staff->save();
            if($old_image){
                if(File::exists(public_path().'/'.$old_image))unlink(public_path().'/'.$old_image);
            }
        }

        $staff->name = $request->name;
        $staff->save();

        if($request->password){
            $staff->password = Hash::make($request->password);
            $staff->save();
        }

        $notification= trans('user_validation.Update Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->route('staff.profile')->with($notification);
    }
}
