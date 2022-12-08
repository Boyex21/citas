<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Models\Setting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Hash;
use Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(){
        $setting=Setting::first();
        if(Auth::guard('admin')->user()->admin_type==1){
            $admins=Admin::orderBy('id', 'ASC')->get();
            return view('admin.admin', compact('setting', 'admins'));
        }
        return abort(404);
    }

    public function create(){
        $setting=Setting::first();
        if(Auth::guard('admin')->user()->admin_type==1){
            return view('admin.create_admin', compact('setting'));
        }
        return abort(404);
    }

    public function store(Request $request){
        $rules=[
            'name' => 'required',
            'email' => 'required|unique:admins',
            'password' => 'required|min:4',
        ];
        $this->validate($request, $rules);

        $admin=new Admin();
        $admin->name=$request->name;
        $admin->email=$request->email;
        $admin->status=$request->status;
        $admin->password=Hash::make($request->password);
        $admin->save();

        $notification='Registro Exitoso';
        $notification=array('messege' => $notification, 'alert-type' => 'success');
        return redirect()->back()->with($notification);
    }

    public function destroy($id){
        $admin=Admin::find($id);
        $old_image=$admin->image;
        $admin->delete();
        if($old_image){
            if(File::exists(public_path().'/'.$old_image)) {
                unlink(public_path().'/'.$old_image);
            }
        }
        $notification='Eliminación Exitosa';
        $notification=array('messege' => $notification, 'alert-type' => 'success');
        return redirect()->back()->with($notification);
    }

    public function changeStatus($id){
        $admin=Admin::find($id);
        if($admin->status==1){
            $admin->status=0;
            $admin->save();
            $message='Desactivado Exitosamente';
        }else{
            $admin->status=1;
            $admin->save();
            $message='Activado Exitosamente';
        }
        return response()->json($message);
    }
}
