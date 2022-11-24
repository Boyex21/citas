<?php

namespace App\Http\Controllers\Staff;

use App\Models\Setting;
use App\Models\Location;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Str;

class StaffLocationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:staff');
    }

    public function index()
    {
        $setting=Setting::first();
        $locations=Location::all();
        return view('staff.location', compact('setting', 'locations'));
    }

    public function store(Request $request)
    {
        $rules=[
            'name'=>'required|unique:locations',
        ];
        $this->validate($request, $rules);

        $location=new Location();
        $location->name=$request->name;
        $location->slug=Str::slug($request->name);
        $location->status=1;
        $location->save();

        $notification='Registro Exitoso';
        $notification=array('messege' => $notification, 'alert-type' => 'success');
        return redirect()->back()->with($notification);
    }

    public function update(Request $request,$id)
    {
        $location=Location::find($id);
        $rules=[
            'name'=>'required|unique:locations,name,'.$location->id,
        ];
        $this->validate($request, $rules);

        $location->name=$request->name;
        $location->slug=Str::slug($request->name);
        $location->save();

        $notification='Edición Exitosa';
        $notification=array('messege' => $notification, 'alert-type' => 'success');
        return redirect()->back()->with($notification);
    }
}