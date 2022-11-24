<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Models\Admin;
use App\Models\Setting;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use App\Mail\AdminForgetPassword;
use Mail;
use Hash;
use Auth;
use Str;

class AdminForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    public function forgetPassword(){
        $setting=Setting::first();
        return view('admin.auth.forget', compact('setting'));
    }

    public function sendForgetEmail(Request $request){
        $rules=[
            'email'=>'required'
        ];
        $this->validate($request, $rules);

        $admin=Admin::where('email',$request->email)->first();
        if($admin){
            $admin->forget_password_token=Str::random(100);
            $admin->save();

            $subject='Restablecer Contraseña';
            $message='<h4>Hola! <b>'.$admin->name.'</b>,</h4><p>¿Quieres restablecer tu contraseña? Haga clic en el siguiente enlace y restablezca su contraseña.</p>';
            Mail::to($admin->email)->send(new AdminForgetPassword($admin, $message, $subject));

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
        $admin=Admin::where('forget_password_token',$token)->first();
        if($admin){
            return view('admin.auth.reset-pass',compact('setting', 'admin', 'token'));
        }else{
            $notification='Token invalido';
            $notification=array('messege' => $notification, 'alert-type' => 'error');
            return Redirect()->route('admin.forget-password')->with($notification);
        }
    }

    public function storeResetData(Request $request,$token){
        $rules=[
            'email'=>'required',
            'password'=>'required|confirmed|min:4'
        ];
        $this->validate($request, $rules);

        $admin=Admin::where('forget_password_token',$token)->first();
        if($admin->email==$request->email){
            $admin->password=Hash::make($request->password);
            $admin->forget_password_token=null;
            $admin->save();

            $notification='Restablecimiento de contraseña exitoso';
            $notification=array('messege' => $notification, 'alert-type' => 'success');
            return Redirect()->route('admin.login')->with($notification);
        }else{
            $notification='Ha ocurrido un error, intentalo nuevamente';
            $notification=array('messege' => $notification, 'alert-type' => 'error');
            return back()->with($notification);
        }
    }
}