<?php

namespace App\Http\Controllers\Staff;

use App\Models\Staff;
use App\Models\Setting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use App\Mail\StaffForgetPassword;
use Mail;
use Hash;
use Auth;
use Str;

class StaffForgetPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    public function forgetPassword(){
        $setting=Setting::first();
        return view('staff.auth.forget', compact('setting'));
    }

    public function sendForgetEmail(Request $request){
        $rules = [
            'email'=>'required'
        ];
        $this->validate($request, $rules);

        $staff = Staff::where('email',$request->email)->first();
        if($staff){
            $staff->forget_password_token=Str::random(100);
            $staff->save();

            $subject='Restablecer Contraseña';
            $message='<h4>Hola! <b>'.$staff->name.'</b>,</h4><p>¿Quieres restablecer tu contraseña? Haga clic en el siguiente enlace y restablezca su contraseña.</p>';
            Mail::to($staff->email)->send(new StaffForgetPassword($staff, $message, $subject));

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
        $staff=Staff::where('forget_password_token',$token)->first();
        if($staff){
            return view('staff.auth.reset-pass',compact('setting', 'staff', 'token'));
        }else{
            $notification='Token invalido';
            $notification=array('messege' => $notification, 'alert-type' => 'error');
            return redirect()->route('staff.forget-password')->with($notification);
        }
    }

    public function storeResetData(Request $request,$token){
        $rules = [
            'email'=>'required',
            'password'=>'required|confirmed|min:4'
        ];
        $this->validate($request, $rules);

        $staff=Staff::where('forget_password_token',$token)->first();
        if($staff->email==$request->email){
            $staff->password=Hash::make($request->password);
            $staff->forget_password_token=null;
            $staff->save();

            $notification='Restablecimiento de contraseña exitoso';
            $notification=array('messege' => $notification, 'alert-type' => 'success');
            return Redirect()->route('staff.login')->with($notification);
        }else{
            $notification='Ha ocurrido un error, intentalo nuevamente';
            $notification=array('messege' => $notification, 'alert-type' => 'error');
            return back()->with($notification);
        }
    }
}
