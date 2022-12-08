<?php

namespace App\Http\Controllers\Doctor;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
use Hash;
use App\Models\Doctor;
use App\Models\Setting;
class DoctorLoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::DOCTOR;

    public function __construct()
    {
        $this->middleware('guest:doctor')->except('doctorLogout');
    }

    public function doctorLoginPage(){
        $setting = Setting::first();
        return view('doctor.auth.login',compact('setting'));
    }


    public function storeLogin(Request $request){

        $rules = [
            'email'=>'required|email',
            'password'=>'required',
        ];

        $customMessages = [
            'email.required' => trans('user_validation.Email is required'),
            'password.required' => trans('user_validation.Password is required'),
        ];
        $this->validate($request, $rules,$customMessages);

        $credential=[
            'email'=> $request->email,
            'password'=> $request->password
        ];

        $isDoctor = Doctor::where('email',$request->email)->first();
        if($isDoctor){
            if($isDoctor->status==1){
                if(Hash::check($request->password,$isDoctor->password)){
                    if(Auth::guard('doctor')->attempt($credential,$request->remember)){
                        $notification= trans('user_validation.Login Successfully');
                        return response()->json(['success'=>$notification]);
                    }
                }else{
                    $notification= trans('user_validation.Invalid Password');
                    return response()->json(['error'=>$notification]);
                }
            }else{
                $notification= trans('user_validation.Inactive account');
                return response()->json(['error'=>$notification]);
            }
        }else{
            $notification= trans('user_validation.Invalid Email');
            return response()->json(['error'=>$notification]);
        }
    }

    public function doctorLogout(){
        Auth::guard('doctor')->logout();
        $notification= trans('user_validation.Logout Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->route('doctor.login')->with($notification);
    }
}
