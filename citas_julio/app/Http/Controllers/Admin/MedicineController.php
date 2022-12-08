<?php

namespace App\Http\Controllers\Admin;

use App\Models\Setting;
use App\Models\Medicine;
use App\Models\Appointment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Str;

class MedicineController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $medicines=Medicine::all();
        return view('admin.medicine', compact('medicines'));
    }

    public function store(Request $request)
    {
        $rules = [
            'name'=>'required'
        ];
        $this->validate($request, $rules);

        $medicine=new Medicine();
        $medicine->name=$request->name;
        $medicine->slug=Str::slug($request->name);
        $medicine->save();

        $notification='Registro Exitoso';
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }

    public function update(Request $request,$id)
    {
        $medicine=Medicine::find($id);
        $rules=[
            'name'=>'required'
        ];
        $this->validate($request, $rules);

        $medicine->name=$request->name;
        $medicine->slug=Str::slug($request->name);
        $medicine->save();

        $notification='Edición Exitosa';
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }

    public function destroy($id)
    {
        $medicine=Medicine::find($id);
        $medicine->delete();

        $notification='Eliminación Exitosa';
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }

    public function appointments(){
        $setting=Setting::first();
        $appointments=Appointment::orderBy('id', 'desc')->get();
        return view('admin.appointment', compact('appointments', 'setting'));
    }
}
