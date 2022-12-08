<?php

namespace App\Http\Controllers\User;

use App\Models\Doctor;
use App\Models\Setting;
use App\Models\Appointment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Image;
use Auth;
use File;
use Hash;
use Str;

class UserProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function dashboard(){
        $user=Auth::guard('web')->user();
        $appointments=Appointment::orderBy('id', 'DESC')->where('user_id', $user->id)->get();
        return view('user.dashboard', compact('user', 'appointments'));
    }

    public function appointment(){
        Paginator::useBootstrap();
        $user=Auth::guard('web')->user();
        $appointments=Appointment::orderBy('id', 'DESC')->where('user_id', $user->id)->paginate(10);
        return view('user.appointment', compact('user', 'appointments'));
    }

    public function showAppointment($id){
        $setting=Setting::first();
        $user=Auth::guard('web')->user();
        $appointment=Appointment::where('id', $id)->where('user_id', $user->id)->firstOrFail();
        $doctor=Doctor::where('id', $appointment->doctor_id)->first();

        if($appointment->already_treated==0){
            $notification=trans('user_validation.Something Went Wrong');
            $notification=array('messege' => $notification, 'alert-type' => 'error');
            return redirect()->route('user.appointment')->with($notification);
        }

        return view('user.show_appointment', compact('setting', 'user', 'appointment', 'doctor'));
    }

    public function myProfile(){
        $user=Auth::guard('web')->user();
        return view('user.my_profile', compact('user'));
    }

    public function updateProfile(Request $request){
        $user=Auth::guard('web')->user();
        $rules = [
            'name' => 'required',
            'email' => 'required|unique:users,email,'.$user->id,
            'address' => 'required',
            'phone' => 'required',
            'age' => 'required',
            'weight' => 'required',
            'gender' => 'required',
        ];
        $this->validate($request, $rules);

        $user->name=$request->name;
        $user->phone=$request->phone;
        $user->address=$request->address;
        $user->age=$request->age;
        $user->weight=$request->weight;
        $user->gender=$request->gender;
        $user->fillup=1;
        $user->save();

        if($request->file('image')){
            $old_image=$user->image;
            $user_image=$request->image;
            $extention=$user_image->getClientOriginalExtension();
            $image_name= Str::slug($request->name).date('-Y-m-d-h-i-s-').rand(999,9999).'.'.$extention;
            $image_name='uploads/custom-images/'.$image_name;

            Image::make($user_image)->save(public_path().'/'.$image_name);

            $user->image=$image_name;
            $user->save();
            if($old_image){
                if(File::exists(public_path().'/'.$old_image))unlink(public_path().'/'.$old_image);
            }
        }

        $notification='Actualización exitosa';
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }

    public function changePassword(){
        $user=Auth::guard('web')->user();
        return view('user.change_password', compact('user'));
    }

    public function updatePassword(Request $request){
        $rules = [
            'current_password' => 'required',
            'password' => 'required|min:4|confirmed',
        ];
        $this->validate($request, $rules);

        $user=Auth::guard('web')->user();
        if(Hash::check($request->current_password, $user->password)){
            $user->password=Hash::make($request->password);
            $user->save();
            $notification='Cambio de contraseña exitoso';
            $notification=array('messege' => $notification, 'alert-type' => 'success');
            return redirect()->back()->with($notification);
        }else{
            $notification='La contraseña actual no coincide';
            $notification=array('messege' => $notification, 'alert-type' => 'error');
            return redirect()->back()->with($notification);
        }
    }
}