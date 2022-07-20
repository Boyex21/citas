<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Hash;

class LoginController extends Controller
{

    use AuthenticatesUsers;
    protected $redirectTo = '/dashboard';

    public function __construct()
    {
        $this->middleware('guest:web')->except('userLogout');
    }

    public function loginPage(){
        return view('login');
    }

    public function storeLogin(Request $request){

        $rules = [
            'email'=>'required',
            'password'=>'required'
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
        $user = User::where('email',$request->email)->first();
        if($user){
            if($user->status==1){
                if(Hash::check($request->password,$user->password)){
                    if(Auth::guard('web')->attempt($credential,$request->remember)){
                        $notification = trans('Bienvenidos a Citas!');
                        return response()->json(['status' => 1, 'message' => $notification]);
                    }
                }else{
                    $notification = trans('user_validation.Credentials does not exist');
                    return response()->json(['status' => 0, 'message' => $notification]);
                }

            }else{
                $notification = trans('user_validation.Disabled Account');
                return response()->json(['status' => 0, 'message' => $notification]);
            }
        }else{
            $notification = trans('user_validation.Email does not exist');
            return response()->json(['status' => 0, 'message' => $notification]);
        }
    }

    public function userLogout(){
        Auth::guard('web')->logout();
        $notification = trans('user_validation.Logout Successfully');
        $notification = array('messege'=>$notification,'alert-type'=>'success');
        
        return redirect()->route('login')->with($notification);
    }

}
