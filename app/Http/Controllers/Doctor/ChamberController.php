<?php

namespace App\Http\Controllers\Doctor;

use App\Models\Setting;
use App\Models\Chamber;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class ChamberController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:doctor');
    }

    public function index()
    {
        $setting=Setting::first();
        $doctor=Auth::guard('doctor')->user();
        $chambers=Chamber::with('staffs', 'appointments','schedules')->where('doctor_id', $doctor->id)->get();
        return view('doctor.chamber', compact('setting', 'chambers'));
    }

    public function store(Request $request)
    {
        $doctor=Auth::guard('doctor')->user();
        $chambers=Chamber::where('doctor_id', $doctor->id)->count();

        $rules=[
            'name'=>'required',
            'address'=>'required',
            'contact'=>'required',
            'status'=>'required'
        ];
        $this->validate($request, $rules);

        $doctor=Auth::guard('doctor')->user();
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

    public function update(Request $request,$id)
    {
        $rules = [
            'name'=>'required',
            'address'=>'required',
            'contact'=>'required',
            'status'=>'required'
        ];
        $this->validate($request, $rules);

        $doctor=Auth::guard('doctor')->user();
        $chamber=Chamber::where(['doctor_id' => $doctor->id, 'id' => $id])->first();
        $chamber->name=$request->name;
        $chamber->address=$request->address;
        $chamber->contact=$request->contact;
        $chamber->status=$request->status;
        $chamber->save();

        $notification='Edición Exitosa';
        $notification=array('messege' => $notification, 'alert-type' => 'success');
        return redirect()->back()->with($notification);
    }

    public function destroy($id){
        $chamber=Chamber::find($id);
        $chamber->delete();

        $notification='Eliminación Exitosa';
        $notification=array('messege' => $notification, 'alert-type' => 'success');
        return redirect()->back()->with($notification);
    }

    public function changeStatus($id){
        $chamber=Chamber::find($id);
        if($chamber->status==1){
            $chamber->status=0;
            $chamber->save();
            $message='Desactivado Exitosamente';
        }else{
            $chamber->status=1;
            $chamber->save();
            $message='Activado Exitosamente';
        }

        return response()->json($message);
    }

    public function setDefault($id){
        $doctor=Auth::guard('doctor')->user();
        Chamber::where('doctor_id', $doctor->id)->where('id', $id)->update(['is_default' => 1]);
        Chamber::where('doctor_id', $doctor->id)->where('id', '!=' , $id)->update(['is_default' => 0]);
        return response()->json(['status' => 1]);
    }
}