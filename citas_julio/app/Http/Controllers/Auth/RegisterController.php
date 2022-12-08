<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Mail\UserRegistration;
use Auth;
use Mail;
use Str;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo=RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest:web');
    }

    public function registerForm(){
        return view('register');
    }

    public function storeRegister(Request $request){
        $rules=[
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required|min:4'
        ];
        $this->validate($request, $rules);

        $user=new User();
        $user->name=$request->name;
        $user->email=$request->email;
        $user->password=Hash::make($request->password);
        // $user->verify_token=Str::random(100);
        $user->status='1';
        $user->patient_id=date('Ymdhis');
        $user->save();

        $notification='Registro exitoso';
        return response()->json(['status' => 1, 'message' => $notification]);
    }
}
