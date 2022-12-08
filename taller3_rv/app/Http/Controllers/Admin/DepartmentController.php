<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;
use Str;
class DepartmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $departments = Department::with('doctors')->get();
        return view('admin.department', compact('departments'));
    }


    public function create()
    {
        return view('admin.create_faq');
    }


    public function store(Request $request)
    {
        $rules = [
            'name'=>'required|unique:departments',
            'status'=>'required',
        ];
        $customMessages = [
            'name.required' => trans('admin_validation.Name is required'),
            'name.unique' => trans('admin_validation.Name already exist'),
        ];
        $this->validate($request, $rules,$customMessages);

        $department = new Department();
        $department->name = $request->name;
        $department->slug = Str::slug($request->name);
        $department->status = $request->status;
        $department->save();

        $notification= trans('admin_validation.Created Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }

    public function update(Request $request,$id)
    {
        $department = Department::find($id);
        $rules = [
            'name'=>'required|unique:departments,name,'.$department->id,
            'status'=>'required',
        ];
        $customMessages = [
            'name.required' => trans('admin_validation.Name is required'),
            'name.unique' => trans('admin_validation.Name already exist'),
        ];
        $this->validate($request, $rules,$customMessages);

        $department->name = $request->name;
        $department->slug = Str::slug($request->name);
        $department->status = $request->status;
        $department->save();

        $notification= trans('admin_validation.Update Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }

    public function destroy($id)
    {
        $department = Department::find($id);
        $department->delete();

        $notification= trans('admin_validation.Delete Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }

    public function changeStatus($id){
        $department = Department::find($id);
        if($department->status==1){
            $department->status=0;
            $department->save();
            $message= trans('admin_validation.Inactive Successfully');
        }else{
            $department->status=1;
            $department->save();
            $message= trans('admin_validation.Active Successfully');
        }
        return response()->json($message);
    }
}
