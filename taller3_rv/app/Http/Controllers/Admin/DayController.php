<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Day;
class DayController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $days = Day::all();
        return view('admin.day', compact('days'));
    }

    public function update(Request $request,$id)
    {
        $day = Day::find($id);
        $rules = [
            'custom_day'=>'required|unique:days,custom_day,'.$day->id,
        ];
        $customMessages = [
            'custom_day.required' => trans('admin_validation.Custom Name is required'),
            'custom_day.unique' => trans('admin_validation.Custom Name already exist'),
        ];
        $this->validate($request, $rules,$customMessages);

        $day->custom_day = $request->custom_day;
        $day->save();

        $notification= trans('admin_validation.Update Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }

}
