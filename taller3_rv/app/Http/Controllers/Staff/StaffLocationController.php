<?php

namespace App\Http\Controllers\Staff;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Location;
use Str;
class StaffLocationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:staff');
    }

    public function index()
    {
        $locations = Location::all();
        return view('staff.location', compact('locations'));
    }



    public function store(Request $request)
    {
        $rules = [
            'name'=>'required|unique:locations',
        ];
        $customMessages = [
            'name.required' => trans('user_validation.Name is required'),
            'name.unique' => trans('user_validation.Name already exist'),
        ];
        $this->validate($request, $rules,$customMessages);

        $location = new Location();
        $location->name = $request->name;
        $location->slug = Str::slug($request->name);
        $location->status = 1;
        $location->save();

        $notification= trans('user_validation.Created Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }

    public function update(Request $request,$id)
    {
        $location = Location::find($id);
        $rules = [
            'name'=>'required|unique:locations,name,'.$location->id,
        ];
        $customMessages = [
            'name.required' => trans('user_validation.Name is required'),
            'name.unique' => trans('user_validation.Name already exist'),
        ];
        $this->validate($request, $rules,$customMessages);

        $location->name = $request->name;
        $location->slug = Str::slug($request->name);
        $location->save();

        $notification= trans('user_validation.Update Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }
}
