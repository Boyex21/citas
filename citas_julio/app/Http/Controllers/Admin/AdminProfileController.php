<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Image;
use Hash;
use Auth;
use File;
use Str;

class AdminProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(){
        $admin=Auth::guard('admin')->user();
        return view('admin.admin_profile', compact('admin'));
    }

    public function update(Request $request){
        $admin=Auth::guard('admin')->user();
        $rules = [
            'name'=>'required',
            'email'=>'required|unique:admins,email,'.$admin->id,
            'password'=>'confirmed',
        ];
        $this->validate($request, $rules);

        // inset user profile image
        if($request->file('image')){
            $old_image=$admin->image;
            $user_image=$request->image;
            $extention=$user_image->getClientOriginalExtension();
            $image_name=Str::slug($request->name).date('-Y-m-d-h-i-s-').rand(999,9999).'.'.$extention;
            $image_name='uploads/website-images/'.$image_name;

            Image::make($user_image)->save(public_path().'/'.$image_name);

            $admin->image=$image_name;
            $admin->save();
            if($old_image){
                if(File::exists(public_path().'/'.$old_image)) {
                    unlink(public_path().'/'.$old_image);
                }
            }
        }

        if($request->password){
            $admin->password=Hash::make($request->password);
        }
        $admin->name=$request->name;
        $admin->email=$request->email;
        $admin->save();

        $notification='Edición Exitosa';
        $notification=array('messege' => $notification, 'alert-type' => 'success');
        return redirect()->route('admin.profile')->with($notification);
    }
}