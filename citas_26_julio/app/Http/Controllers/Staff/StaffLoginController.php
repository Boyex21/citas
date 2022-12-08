<?php

namespace App\Http\Controllers\Staff;

use App\Models\Staff;
use App\Models\Setting;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
use Hash;

class StaffLoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::STAFF;

    public function __construct()
    {
        $this->middleware('guest:staff')->except('staffLogut');
    }

    public function staffLoginPage(){
        $setting=Setting::first();
        return view('staff.auth.login', compact('setting'));
    }

    public function storeLogin(Request $request){

        $rules=[
            'email'=>'required|email',
            'password'=>'required',
        ];
        $this->validate($request, $rules);

        $credential=[
            'email'=> $request->email,
            'password'=> $request->password
        ];

        $isStaff=Staff::where('email',$request->email)->first();
        if($isStaff){
            if($isStaff->status==1){
                if(Hash::check($request->password,$isStaff->password)){
                    if(Auth::guard('staff')->attempt($credential,$request->remember)){
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

    public function staffLogut(){
        Auth::guard('staff')->logout();
        $notification='Sesión cerrada exitosamente';
        $notification=array('messege' => $notification, 'alert-type' => 'success');
        return redirect()->route('staff.login')->with($notification);
    }
}
