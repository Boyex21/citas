<?php

namespace App\Http\Controllers\Doctor;

use App\Models\Setting;
use App\Models\Department;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Str;

class DoctorDepartmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:doctor');
    }

    public function index()
    {
        $setting=Setting::first();
        $departments=Department::all();
        return view('doctor.department', compact('setting', 'departments'));
    }

    public function store(Request $request)
    {
        $rules=[
            'name'=>'required|unique:departments',
        ];
        $this->validate($request, $rules);

        $department=new Department();
        $department->name=$request->name;
        $department->slug=Str::slug($request->name);
        $department->status=1;
        $department->save();

        $notification='Registro Exitoso';
        $notification=array('messege' => $notification, 'alert-type' => 'success');
        return redirect()->back()->with($notification);
    }

    public function update(Request $request,$id)
    {
        $department=Department::find($id);
        $rules=[
            'name'=>'required|unique:departments,name,'.$department->id,
        ];
        $this->validate($request, $rules);

        $department->name=$request->name;
        $department->slug=Str::slug($request->name);
        $department->save();

        $notification='Edición Exitosa';
        $notification=array('messege' => $notification, 'alert-type' => 'success');
        return redirect()->back()->with($notification);
    }
}