<?php

namespace App\Http\Controllers\Admin;

use App\Models\Setting;
use App\Models\Location;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Str;

class LocationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $setting=Setting::first();
        $locations=Location::with('doctors')->get();
        return view('admin.location', compact('setting', 'locations'));
    }

    public function store(Request $request)
    {
        $rules=[
            'name'=>'required|unique:locations',
            'status'=>'required',
        ];
        $this->validate($request, $rules);

        $location=new Location();
        $location->name=$request->name;
        $location->slug=Str::slug($request->name);
        $location->status=$request->status;
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
            'status'=>'required'
        ];
        $this->validate($request, $rules);

        $location->name=$request->name;
        $location->slug=Str::slug($request->name);
        $location->status=$request->status;
        $location->save();

        $notification='Edición Exitosa';
        $notification=array('messege' => $notification, 'alert-type' => 'success');
        return redirect()->back()->with($notification);
    }

    public function destroy($id)
    {
        $location=Location::find($id);
        $location->delete();

        $notification='Eliminación Exitosa';
        $notification=array('messege' => $notification, 'alert-type' => 'success');
        return redirect()->back()->with($notification);
    }

    public function changeStatus($id){
        $location=Location::find($id);
        if($location->status==1){
            $location->status=0;
            $location->save();
            $message='Desactivado Exitosamente';
        }else{
            $location->status=1;
            $location->save();
            $message='Activado Exitosamente';
        }
        return response()->json($message);
    }
}