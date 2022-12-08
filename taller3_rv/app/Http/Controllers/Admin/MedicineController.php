<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Medicine;
use App\Models\Appointment;
use App\Models\Setting;
use Str;
class MedicineController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $medicines = Medicine::all();
        return view('admin.medicine', compact('medicines'));
    }



    public function store(Request $request)
    {
        $rules = [
            'name'=>'required'
        ];
        $customMessages = [
            'name.required' => trans('admin_validation.Name is required')
        ];
        $this->validate($request, $rules,$customMessages);

        $medicine = new Medicine();
        $medicine->name = $request->name;
        $medicine->slug = Str::slug($request->name);
        $medicine->save();

        $notification= trans('admin_validation.Created Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }

    public function update(Request $request,$id)
    {
        $medicine = Medicine::find($id);
        $rules = [
            'name'=>'required'
        ];
        $customMessages = [
            'name.required' => trans('admin_validation.Name is required'),
        ];
        $this->validate($request, $rules,$customMessages);

        $medicine->name = $request->name;
        $medicine->slug = Str::slug($request->name);
        $medicine->save();

        $notification= trans('admin_validation.Update Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }

    public function destroy($id)
    {
        $medicine = Medicine::find($id);
        $medicine->delete();

        $notification= trans('admin_validation.Delete Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }


    public function appointments(){
        $appointments = Appointment::orderBy('id', 'desc')->get();
        $setting = Setting::first();
        return view('admin.appointment', compact('appointments', 'setting'));
    }
}
