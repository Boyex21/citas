<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;
use Str;
class StaffDepartmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:staff');
    }

    public function index()
    {
        $departments = Department::all();
        return view('staff.department', compact('departments'));
    }


    public function store(Request $request)
    {
        $rules = [
            'name'=>'required|unique:departments',
        ];
        $customMessages = [
            'name.required' => trans('user_validation.Name is required'),
            'name.unique' => trans('user_validation.Name already exist'),
        ];
        $this->validate($request, $rules,$customMessages);

        $department = new Department();
        $department->name = $request->name;
        $department->slug = Str::slug($request->name);
        $department->status = 1;
        $department->save();

        $notification= trans('user_validation.Created Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }

    public function update(Request $request,$id)
    {
        $department = Department::find($id);
        $rules = [
            'name'=>'required|unique:departments,name,'.$department->id,
        ];
        $customMessages = [
            'name.required' => trans('user_validation.Name is required'),
            'name.unique' => trans('user_validation.Name already exist'),
        ];
        $this->validate($request, $rules,$customMessages);

        $department->name = $request->name;
        $department->slug = Str::slug($request->name);
        $department->save();

        $notification= trans('user_validation.Update Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }

}
