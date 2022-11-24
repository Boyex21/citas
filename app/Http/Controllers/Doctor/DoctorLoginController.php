<?php

namespace App\Http\Controllers\Doctor;

use App\Models\Doctor;
use App\Models\Setting;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
use Hash;

class DoctorLoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo=RouteServiceProvider::DOCTOR;

    public function __construct()
    {
        $this->middleware('guest:doctor')->except('doctorLogout');
    }

    public function doctorLoginPage(){
        $setting=Setting::first();
        return view('doctor.auth.login', compact('setting'));
    }


    public function storeLogin(Request $request){
        $rules=[
            'email' => 'required|email',
            'password' => 'required',
        ];
        $this->validate($request, $rules);

        $credential=[
            'email' => $request->email,
            'password' => $request->password
        ];

        $isDoctor=Doctor::where('email',$request->email)->first();
        if($isDoctor){
            if($isDoctor->status==1){
                if(Hash::check($request->password,$isDoctor->password)){
                    if(Auth::guard('doctor')->attempt($credential,$request->remember)){
                        $notification='Inicio de sesión exitoso';
                        return response()->json(['success' => $notification]);
                    }
                }else{
                    $notification='Las credenciales son invalidas';
                    return response()->json(['error' => $notification]);
                }
            }else{
                $notification='Cuenta deshabilitada';
                return response()->json(['error' => $notification]);
            }
        }else{
            $notification='El correo electrónico no existe';
            return response()->json(['error' => $notification]);
        }
    }

    public function doctorLogout(){
        Auth::guard('doctor')->logout();
        $notification='Sesión cerrada exitosamente';
        $notification=array('messege' => $notification, 'alert-type' => 'success');
        return redirect()->route('doctor.login')->with($notification);
    }
}