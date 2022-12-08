<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

use Illuminate\Http\Request;
use App\Mail\DoctorForgetPassword;
use App\Helpers\MailHelper;
use App\Models\Doctor;
use App\Models\EmailTemplate;
use Str;
use Mail;
use Hash;
use Auth;
use App\Models\Setting;

class DoctorForgetPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    public function forgetPassword(){
        $setting = Setting::first();
       return view('doctor.auth.forget',compact('setting'));
   }


   public function sendForgetEmail(Request $request){
        $rules = [
            'email'=>'required'
        ];

        $customMessages = [
            'email.required' => trans('user_validation.Email is required'),
        ];
        $this->validate($request, $rules,$customMessages);

        MailHelper::setMailConfig();
        $staff = Doctor::where('email',$request->email)->first();
        if($staff){
            $staff->forget_password_token=Str::random(100);
            $staff->save();

            $template=EmailTemplate::where('id',1)->first();
            $message=$template->description;
            $subject=$template->subject;
            $message=str_replace('{{name}}',$staff->name,$message);

            Mail::to($staff->email)->send(new DoctorForgetPassword($staff,$message,$subject));

            $notification= trans('user_validation.Forget password link send your email');
            $notification=array('messege'=>$notification,'alert-type'=>'success');
            return Redirect()->back()->with($notification);

        }else {
            $notification= trans('user_validation.email does not exist');
            $notification=array('messege'=>$notification,'alert-type'=>'error');
            return Redirect()->back()->with($notification);
        }
    }


    public function resetPassword($token){
        $doctor = Doctor::where('forget_password_token',$token)->first();
        if($doctor){
            $setting = Setting::first();
            return view('doctor.auth.reset-pass',compact('doctor','token','setting'));
        }else{
            $notification='invalid token';
            $notification=array('messege'=>$notification,'alert-type'=>'error');
            return Redirect()->route('doctor.forget-password')->with($notification);
        }
    }

    public function storeResetData(Request $request,$token){

        $rules = [
            'email'=>'required',
            'password'=>'required|confirmed|min:4'
        ];
        $customMessages = [
            'email.required' => trans('user_validation.Email is required'),
            'password.required' => trans('user_validation.Password is required'),
            'password.confirmed' => trans('user_validation.Password deos not match'),
            'password.min' => trans('user_validation.Password must be 4 characters'),
        ];
        $this->validate($request, $rules,$customMessages);

        $doctor = Doctor::where('forget_password_token',$token)->first();
        if($doctor->email==$request->email){
            $doctor->password=Hash::make($request->password);
            $doctor->forget_password_token=null;
            $doctor->save();

            $notification= trans('user_validation.Password Reset Successfully');
            $notification=array('messege'=>$notification,'alert-type'=>'success');
            return Redirect()->route('doctor.login')->with($notification);
        }else{
            $notification= trans('user_validation.Something went wrong');
            $notification=array('messege'=>$notification,'alert-type'=>'error');
            return back()->with($notification);
        }
    }
}
