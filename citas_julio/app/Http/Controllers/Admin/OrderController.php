<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Staff;
use App\Models\Chamber;
use App\Models\Setting;
class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(){
        $orders = Order::with('doctor')->orderBy('id','desc')->get();
        $setting = Setting::first();
        return view('admin.order', compact('orders','setting'));
    }


    public function show($id){
        $order = Order::with('doctor')->find($id);
        $setting = Setting::first();
        $user = $order->doctor;
        return view('admin.show_order',compact('order','setting','user'));
    }

    public function approvedPayment ($id){
        $order = Order::with('doctor')->find($id);
        $order->payment_status = 1;
        $order->status = 1;
        $order->save();
        $doctor = $order->doctor;

        $staffs = Staff::where('doctor_id', $doctor->id)->get();
        $chambers = Chamber::where('doctor_id', $doctor->id)->get();
        foreach($staffs as $indx => $staff){
            if($indx >= $order->maximum_staff) {
                $staff->status = 0;
                $staff->save();
            }
        }

        foreach($chambers as $indx => $chamber){
            if($indx >= $order->maximum_chamber) {
                $chamber->status = 0;
                $chamber->save();
            }
        }

        Order::where('doctor_id', $doctor->id)->where('id', '!=', $order->id)->update(['status' => 2]);

        $notification = trans('admin_validation.Payment approved successfully');
        $notification = array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);

    }


    public function destroy($id){
        $order = Order::find($id);
        $order->delete();

        $notification = trans('admin_validation.Delete Successfully');
        $notification = array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->route('admin.order')->with($notification);

    }
}
