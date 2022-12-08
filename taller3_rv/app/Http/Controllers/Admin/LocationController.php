<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Location;
use Str;
class LocationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $locations = Location::with('doctors')->get();
        return view('admin.location', compact('locations'));
    }



    public function store(Request $request)
    {
        $rules = [
            'name'=>'required|unique:locations',
            'status'=>'required',
        ];
        $customMessages = [
            'name.required' => trans('admin_validation.Name is required'),
            'name.unique' => trans('admin_validation.Name already exist'),
        ];
        $this->validate($request, $rules,$customMessages);

        $location = new Location();
        $location->name = $request->name;
        $location->slug = Str::slug($request->name);
        $location->status = $request->status;
        $location->save();

        $notification= trans('admin_validation.Created Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }

    public function update(Request $request,$id)
    {
        $location = Location::find($id);
        $rules = [
            'name'=>'required|unique:locations,name,'.$location->id,
            'status'=>'required',
        ];
        $customMessages = [
            'name.required' => trans('admin_validation.Name is required'),
            'name.unique' => trans('admin_validation.Name already exist'),
        ];
        $this->validate($request, $rules,$customMessages);

        $location->name = $request->name;
        $location->slug = Str::slug($request->name);
        $location->status = $request->status;
        $location->save();

        $notification= trans('admin_validation.Update Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }

    public function destroy($id)
    {
        $location = Location::find($id);
        $location->delete();

        $notification= trans('admin_validation.Delete Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }

    public function changeStatus($id){
        $location = Location::find($id);
        if($location->status==1){
            $location->status=0;
            $location->save();
            $message= trans('admin_validation.Inactive Successfully');
        }else{
            $location->status=1;
            $location->save();
            $message= trans('admin_validation.Active Successfully');
        }
        return response()->json($message);
    }
}
