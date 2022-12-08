<?php

namespace App\Http\Controllers\Staff;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
use Hash;
use App\Models\Staff;
use App\Models\Setting;
class StaffLoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::STAFF;

    public function __construct()
    {
        $this->middleware('guest:staff')->except('staffLogut');
    }

    public function staffLoginPage(){
        $setting = Setting::first();
        return view('staff.auth.login',compact('setting'));
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

        $isStaff = Staff::where('email',$request->email)->first();
        if($isStaff){
            if($isStaff->status==1){
                if(Hash::check($request->password,$isStaff->password)){
                    if(Auth::guard('staff')->attempt($credential,$request->remember)){
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

    public function staffLogut(){
        Auth::guard('staff')->logout();
        $notification= trans('user_validation.Logout Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->route('staff.login')->with($notification);
    }
}
