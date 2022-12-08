<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Mail\UserForgetPassword;
use Auth;
use Hash;
use Mail;
use Str;

class LoginController extends Controller
{
    use AuthenticatesUsers;
    
    protected $redirectTo='/user/dashboard';

    public function __construct()
    {
        $this->middleware('guest:web')->except('userLogout');
    }

    public function loginPage(){
        return view('login');
    }

    public function storeLogin(Request $request){
        $rules=[
            'email' => 'required',
            'password' => 'required'
        ];
        $this->validate($request, $rules);

        $credential=[
            'email' => $request->email,
            'password' => $request->password
        ];

        $user=User::where('email', $request->email)->first();
        if($user){
            if($user->status==1){
                if(Hash::check($request->password,$user->password)){
                    if(Auth::guard('web')->attempt($credential,$request->remember)){
                        $notification='Inicio de sesión exitoso';
                        return response()->json(['status' => 1, 'message' => $notification]);
                    }
                }else{
                    $notification='Las credenciales no existen';
                    return response()->json(['status' => 0, 'message' => $notification]);
                }

            }else{
                $notification='Cuenta deshabilitada';
                return response()->json(['status' => 0, 'message' => $notification]);
            }
        }else{
            $notification='El correo electrónico no existe';
            return response()->json(['status' => 0, 'message' => $notification]);
        }
    }

    public function forgetPage(){
        return view('forget_password');
    }

    public function sendForgetPassword(Request $request){
        $rules=[
            'email' => 'required'
        ];
        $this->validate($request, $rules);

        $user=User::where('email', $request->email)->first();
        if($user){
            $user->forget_password_token=Str::random(100);
            $user->save();

            $subject='Restablecer Contraseña';
            $message='<h4>Hola! <b>'.$user->name.'</b>,</h4><p>¿Quieres restablecer tu contraseña? Haga clic en el siguiente enlace y restablezca su contraseña.</p>';
            Mail::to($user->email)->send(new UserForgetPassword($message, $subject, $user));

            $notification='Enlace de restablecimiento de contraseña enviado a su correo electrónico.';
            $notification=array('messege' => $notification, 'alert-type' => 'success');
            return redirect()->back()->with($notification);

        }else{
            $notification='El correo electrónico no existe';
            $notification=array('messege' => $notification, 'alert-type' => 'error');
            return redirect()->back()->with($notification);
        }
    }

    public function resetPasswordPage($token){
        $user=User::where('forget_password_token', $token)->first();
        return view('reset_password', compact('user', 'token'));
    }

    public function storeResetPasswordPage(Request $request, $token){
        $rules=[
            'email' => 'required',
            'password' => 'required|min:4|confirmed'
        ];
        $this->validate($request, $rules);

        $user=User::where(['email' => $request->email, 'forget_password_token' => $token])->first();
        if($user){
            $user->password=Hash::make($request->password);
            $user->forget_password_token=null;
            $user->save();

            $notification='Restablecimiento de contraseña exitoso';
            $notification=array('messege' => $notification, 'alert-type' => 'success');
            return redirect()->route('login')->with($notification);
        }else{
            $notification='Ha ocurrido un error, intentalo nuevamente';
            $notification=array('messege' => $notification, 'alert-type' => 'error');
            return redirect()->route('login')->with($notification);
        }
    }

    public function userLogout(){
        Auth::guard('web')->logout();
        $notification='Sesión cerrada exitosamente';
        $notification=array('messege' => $notification, 'alert-type' => 'success');
        return redirect()->route('login')->with($notification);
    }
}
