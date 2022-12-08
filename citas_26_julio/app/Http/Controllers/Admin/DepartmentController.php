<?php

namespace App\Http\Controllers\Admin;

use App\Models\Setting;
use App\Models\Department;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Str;

class DepartmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $setting=Setting::first();
        $departments=Department::with('doctors')->get();
        return view('admin.department', compact('setting', 'departments'));
    }

    public function store(Request $request)
    {
        $rules = [
            'name'=>'required|unique:departments',
            'status'=>'required',
        ];
        $this->validate($request, $rules);

        $department=new Department();
        $department->name=$request->name;
        $department->slug=Str::slug($request->name);
        $department->status=$request->status;
        $department->save();

        $notification='Registro Exitoso';
        $notification=array('messege' => $notification, 'alert-type' => 'success');
        return redirect()->back()->with($notification);
    }

    public function update(Request $request, $id)
    {
        $department=Department::find($id);
        $rules=[
            'name'=>'required|unique:departments,name,'.$department->id,
            'status'=>'required',
        ];
        $this->validate($request, $rules);

        $department->name=$request->name;
        $department->slug=Str::slug($request->name);
        $department->status=$request->status;
        $department->save();

        $notification='Edición Exitosa';
        $notification=array('messege' => $notification, 'alert-type' => 'success');
        return redirect()->back()->with($notification);
    }

    public function destroy($id)
    {
        $department=Department::find($id);
        $department->delete();

        $notification='Eliminación Exitosa';
        $notification=array('messege' => $notification, 'alert-type' => 'success');
        return redirect()->back()->with($notification);
    }

    public function changeStatus($id){
        $department=Department::find($id);
        if($department->status==1){
            $department->status=0;
            $department->save();
            $message='Desactivado Exitosamente';
        }else{
            $department->status=1;
            $department->save();
            $message='Activado Exitosamente';
        }
        return response()->json($message);
    }
}