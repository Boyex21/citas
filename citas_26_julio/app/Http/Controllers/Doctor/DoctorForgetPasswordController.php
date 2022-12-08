<?php

namespace App\Http\Controllers\Doctor;

use App\Models\Doctor;
use App\Models\Setting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use App\Mail\DoctorForgetPassword;
use Mail;
use Hash;
use Str;

class DoctorForgetPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    public function forgetPassword(){
        $setting=Setting::first();
        return view('doctor.auth.forget', compact('setting'));
    }

    public function sendForgetEmail(Request $request){
        $rules = [
            'email'=>'required'
        ];
        $this->validate($request, $rules);

        $staff=Doctor::where('email',$request->email)->first();
        if($staff){
            $staff->forget_password_token=Str::random(100);
            $staff->save();

            $subject='Restablecer Contraseña';
            $message='<h4>Hola! <b>'.$staff->name.'</b>,</h4><p>¿Quieres restablecer tu contraseña? Haga clic en el siguiente enlace y restablezca su contraseña.</p>';
            Mail::to($staff->email)->send(new DoctorForgetPassword($staff, $message, $subject));

            $notification='Enlace de restablecimiento de contraseña enviado a su correo electrónico.';
            $notification=array('messege' => $notification, 'alert-type' => 'success');
            return Redirect()->back()->with($notification);

        }else {
            $notification='El correo electrónico no existe';
            $notification=array('messege' => $notification, 'alert-type' => 'error');
            return Redirect()->back()->with($notification);
        }
    }

    public function resetPassword($token){
        $setting=Setting::first();
        $doctor=Doctor::where('forget_password_token',$token)->first();
        if($doctor){
            return view('doctor.auth.reset-pass',compact('setting', 'doctor', 'token'));
        }else{
            $notification='Token invalido';
            $notification=array('messege' => $notification, 'alert-type' => 'error');
            return Redirect()->route('doctor.forget-password')->with($notification);
        }
    }

    public function storeResetData(Request $request,$token){
        $rules=[
            'email'=>'required',
            'password'=>'required|confirmed|min:4'
        ];
        $this->validate($request, $rules);

        $doctor=Doctor::where('forget_password_token',$token)->first();
        if($doctor->email==$request->email){
            $doctor->password=Hash::make($request->password);
            $doctor->forget_password_token=null;
            $doctor->save();

            $notification='Restablecimiento de contraseña exitoso';
            $notification=array('messege'=>$notification,'alert-type'=>'success');
            return Redirect()->route('doctor.login')->with($notification);
        }else{
            $notification='Ha ocurrido un error, intentalo nuevamente';
            $notification=array('messege' => $notification, 'alert-type' => 'error');
            return back()->with($notification);
        }
    }
}