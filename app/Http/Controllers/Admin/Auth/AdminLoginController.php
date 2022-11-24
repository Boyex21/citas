<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Models\Admin;
use App\Models\Setting;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
use Hash;

class AdminLoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo=RouteServiceProvider::ADMIN;

    public function __construct()
    {
        $this->middleware('guest:admin')->except('adminLogout');
    }

    public function adminLoginPage(){
        $setting=Setting::first();
        return view('admin.auth.login',compact('setting'));
    }

    public function storeLogin(Request $request){
        $rules=[
            'email'=>'required|email',
            'password'=>'required'
        ];
        $this->validate($request, $rules);

        $credential=[
            'email'=> $request->email,
            'password'=> $request->password
        ];

        $isAdmin=Admin::where('email',$request->email)->first();
        if($isAdmin){
            if($isAdmin->status==1){
                if(Hash::check($request->password,$isAdmin->password)){
                    if(Auth::guard('admin')->attempt($credential,$request->remember)){
                        $notification='Inicio de sesión exitoso';
                        return response()->json(['success'=>$notification]);
                    }
                }else{
                    $notification='Las credenciales son invalidas';
                    return response()->json(['error'=>$notification]);
                }
            }else{
                $notification='Cuenta deshabilitada';
                return response()->json(['error'=>$notification]);
            }
        }else{
            $notification='El correo electrónico no existe';
            return response()->json(['error'=>$notification]);
        }
    }

    public function adminLogout(){
        Auth::guard('admin')->logout();
        $notification='Sesión cerrada exitosamente';
        $notification=array('messege' => $notification, 'alert-type' => 'success');
        return redirect()->route('admin.login')->with($notification);
    }
}