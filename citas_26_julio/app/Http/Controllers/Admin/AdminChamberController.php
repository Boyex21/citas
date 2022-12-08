<?php

namespace App\Http\Controllers\Admin;

use App\Models\Doctor;
use App\Models\Setting;
use App\Models\Chamber;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class AdminChamberController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(){
        $setting=Setting::first();
        $doctors=Doctor::orderBy('id', 'DESC')->get();
        $chambers=Chamber::orderBy('id', 'DESC')->get();
        return view('admin.chamber', compact('setting', 'doctors', 'chambers'));
    }

    public function store(Request $request)
    {
        $doctor=Doctor::where('id', $request->doctor)->firstOrFail();
        $rules=[
            'name'=>'required',
            'address'=>'required',
            'contact'=>'required',
            'status'=>'required'
        ];
        $this->validate($request, $rules);

        $isChamber=Chamber::where('doctor_id', $doctor->id)->count();
        $chamber=new Chamber();
        $chamber->doctor_id=$doctor->id;
        $chamber->name=$request->name;
        $chamber->contact=$request->contact;
        $chamber->address=$request->address;
        $chamber->status=$request->status;
        $chamber->is_default=$isChamber==0 ? 1 : 0;
        $chamber->save();

        $notification='Registro Exitoso';
        $notification=array('messege' => $notification, 'alert-type' => 'success');
        return redirect()->back()->with($notification);
    }
}