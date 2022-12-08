<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Medicine;
use Str;
class DoctorMedicineController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:doctor');
    }

    public function index()
    {
        $medicines = Medicine::all();
        return view('doctor.medicine', compact('medicines'));
    }



    public function store(Request $request)
    {
        $rules = [
            'name'=>'required'
        ];
        $customMessages = [
            'name.required' => trans('user_validation.Name is required')
        ];
        $this->validate($request, $rules,$customMessages);

        $medicine = new Medicine();
        $medicine->name = $request->name;
        $medicine->slug = Str::slug($request->name);
        $medicine->save();

        $notification= trans('user_validation.Created Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }

    public function storeUsingAjax(Request $request)
    {
        $rules = [
            'name'=>'required'
        ];
        $customMessages = [
            'name.required' => trans('user_validation.Name is required')
        ];
        $this->validate($request, $rules,$customMessages);

        $medicine = new Medicine();
        $medicine->name = $request->name;
        $medicine->slug = Str::slug($request->name);
        $medicine->save();

        $medicines = Medicine::orderBy('name', 'asc')->get();
        $html = "<option>".trans('user_validation.Select')."</option>";
        foreach($medicines as $medicine){
            $html .= "<option value=".$medicine->name.">".$medicine->name."</option>";
        }

        return response()->json(['status' => 1, 'medicines'=>$html]);
    }



    public function update(Request $request,$id)
    {
        $medicine = Medicine::find($id);
        $rules = [
            'name'=>'required'
        ];
        $customMessages = [
            'name.required' => trans('user_validation.Name is required'),
        ];
        $this->validate($request, $rules,$customMessages);

        $medicine->name = $request->name;
        $medicine->slug = Str::slug($request->name);
        $medicine->save();

        $notification= trans('user_validation.Update Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }

    public function destroy($id)
    {
        $medicine = Medicine::find($id);
        $medicine->delete();

        $notification= trans('user_validation.Delete Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }
}
