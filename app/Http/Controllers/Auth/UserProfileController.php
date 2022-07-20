<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Hash;

class UserProfileController extends Controller
{

    public function __construct()
    {
        //$this->middleware('auth:web');
    }

    public function dashboard(){
        return view('dashboard');
    }

    public function miPerfil(){
        $user = Auth::guard('web')->user();
        return view('user.mi_perfil', compact('user'));
    }
    
    public function updatePerfil(Request $request){
        $user = Auth::guard('web')->user();
        $rules = [
            'cedula'=>'required',
            'name'=>'required',
            'email'=>'required|unique:users,email,'.$user->id,
            'address'=>'required',
            'phone'=>'required',
            'city'=>'required',
            'born'=>'required',
            'gender'=>'required',
        ];
        $customMessages = [
            'cedula.required' => trans('user_validation.Cedula is required'),
            'name.required' => trans('user_validation.Nombre is required'),
            'email.required' => trans('user_validation.Email is required'),
            'email.unique' => trans('user_validation.Email already exist'),
            'address.required' => trans('user_validation.Dirección is required'),
            'phone.required' => trans('user_validation.Teléfono is required'),
            'city.required' => trans('user_validation.Ciudad is required'),
            'born.required' => trans('user_validation.Nacimiento is required'),
            'gender.required' => trans('user_validation.Género is required'),
        ];
        $this->validate($request, $rules,$customMessages);
        
        $user->cedula = $request->cedula;
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->city = $request->city;
        $user->born = $request->born;
        $user->gender = $request->gender;
        $user->status = 1;
        $user->save();

        if($request->file('image')){
            $old_image=$user->image;
            $user_image=$request->image;
            $extention=$user_image->getClientOriginalExtension();
            $image_name= Str::slug($request->name).date('-Y-m-d-h-i-s-').rand(999,9999).'.'.$extention;
            $image_name='uploads/custom-images/'.$image_name;

            Image::make($user_image)
                ->save(public_path().'/'.$image_name);

            $user->image=$image_name;
            $user->save();
            if($old_image){
                if(File::exists(public_path().'/'.$old_image))unlink(public_path().'/'.$old_image);
            }
        }

        $notification = trans('user_validation.Update Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }
    
    public function cambiarContrasena(){
        return view('user.cambiar_contrasena');
    }

    public function updateContrasena(Request $request){
        $rules = [
            'current_password'=>'required',
            'password'=>'required|min:4|confirmed',
        ];
        $customMessages = [
            'current_password.required' => trans('user_validation.Contraseña actual is required'),
            'password.required' => trans('user_validation.Password is required'),
            'password.min' => trans('user_validation.Password minimum 4 character'),
            'password.confirmed' => trans('user_validation.Confirm password does not match'),
        ];
        $this->validate($request, $rules,$customMessages);

        $user = Auth::guard('web')->user();
        if(Hash::check($request->current_password, $user->password)){
            $user->password = Hash::make($request->password);
            $user->save();
            $notification = 'Password change successfully';
            $notification = array('messege'=>$notification,'alert-type'=>'success');
            return redirect()->back()->with($notification);
        }else{
            $notification = trans('user_validation.Current password does not match');
            $notification = array('messege'=>$notification,'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }
    }
    
    public function cita(){
        Paginator::useBootstrap();
        $user = Auth::guard('web')->user();
        $citas = Appointment::orderBy('id','desc')->where('user_id', $user->id)->paginate(10);
        $setting = Setting::first();
        return view('user.appointment', compact('citas','setting'));
    }

    public function mostrarCita($id){
        $user = Auth::guard('web')->user();
        $appointment = Appointment::where('id', $id)->where('user_id', $user->id)->first();
        $doctor = Doctor::where('id', $appointment->doctor_id)->first();
        $setting = Setting::first();

        if($appointment->already_treated == 0){
            $notification = trans('user_validation.Something Went Wrong');
            $notification=array('messege'=>$notification,'alert-type'=>'error');
            return redirect()->route('user.appointment')->with($notification);
        }

        return view('user.show_appointment', compact('appointment','setting','banner','doctor','user'));
    }
    
}
