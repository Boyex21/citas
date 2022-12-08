<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Chamber;
use App\Models\Order;
use Auth;
class ChamberController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:doctor');
    }

    public function index()
    {
        $doctor = Auth::guard('doctor')->user();
        $chambers = Chamber::with('staffs', 'appointments','schedules')->where('doctor_id', $doctor->id)->get();

        return view('doctor.chamber', compact('chambers'));
    }


    public function store(Request $request)
    {
        $doctor = Auth::guard('doctor')->user();
        $chambers = Chamber::where('doctor_id', $doctor->id)->count();
        $activeOrder = Order::where('doctor_id', $doctor->id)->where('status', 1)->first();

        if(!$activeOrder){
            $notification = trans('user_validation.Something Went Wrong');
            $notification=array('messege'=>$notification,'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }

        if($activeOrder->maximum_chamber != -1){
            if($chambers >= $activeOrder->maximum_chamber){
                $notification = trans('user_validation.You can not make any chamber');
                $notification=array('messege'=>$notification,'alert-type'=>'error');
                return redirect()->back()->with($notification);
            }
        }


        $rules = [
            'name'=>'required',
            'address'=>'required',
            'contact'=>'required',
            'status'=>'required'
        ];

        $customMessages = [
            'name.required' => trans('user_validation.Name is required'),
            'address.required' => trans('user_validation.Address is required'),
            'contact.required' => trans('user_validation.Contact is required'),
            'status.required' => trans('user_validation.Status is required'),
        ];
        $this->validate($request, $rules,$customMessages);

        $doctor = Auth::guard('doctor')->user();
        $isChamber = Chamber::where('doctor_id', $doctor->id)->count();
        $chamber = new Chamber();
        $chamber->doctor_id = $doctor->id;
        $chamber->name = $request->name;
        $chamber->contact = $request->contact;
        $chamber->address = $request->address;
        $chamber->status = $request->status;
        $chamber->is_default = $isChamber == 0 ? 1 : 0;
        $chamber->save();

        $notification= trans('user_validation.Created Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
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

        $customMessages = [
            'name.required' => trans('user_validation.Name is required'),
            'address.required' => trans('user_validation.Address is required'),
            'contact.required' => trans('user_validation.Contact is required'),
            'status.required' => trans('user_validation.Status is required'),
        ];
        $this->validate($request, $rules,$customMessages);

        $doctor = Auth::guard('doctor')->user();
        $chamber = Chamber::where(['doctor_id' => $doctor->id, 'id' => $id])->first();
        $chamber->name = $request->name;
        $chamber->address = $request->address;
        $chamber->contact = $request->contact;
        $chamber->status = $request->status;

        if($request->status == 1){
            $doctor = Auth::guard('doctor')->user();
            $activeOrder = Order::where('doctor_id', $doctor->id)->where('status', 1)->first();
            $qty = Chamber::where('doctor_id', $doctor->id)->where('status', 1)->count();
            if($activeOrder){

                if($activeOrder->maximum_chamber == -1){
                    $chamber->status = $request->status;
                    $chamber->save();

                    $notification= trans('user_validation.Updated Successfully');
                    $notification=array('messege'=>$notification,'alert-type'=>'success');
                    return redirect()->back()->with($notification);
                }else{
                    if($qty >= $activeOrder->maximum_chamber){
                        $notification = trans('user_validation.You can not change status for your pricing plan limitation');
                        $notification=array('messege'=>$notification,'alert-type'=>'error');
                        return redirect()->back()->with($notification);
                    }else{
                        $chamber->status = $request->status;
                        $chamber->save();

                        $notification= trans('user_validation.Updated Successfully');
                        $notification=array('messege'=>$notification,'alert-type'=>'success');
                        return redirect()->back()->with($notification);
                    }
                }

            }else{
                $notification = trans('user_validation.Something Went Wrong');
                $notification=array('messege'=>$notification,'alert-type'=>'error');
                return redirect()->back()->with($notification);
            }

        }
        $chamber->status = $request->status;
        $chamber->save();

        $notification= trans('user_validation.Updated Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }

    public function destroy($id){
        $chamber = Chamber::find($id);
        $chamber->delete();

        $notification = trans('user_validation.Delete Successfully');
        $notification = array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }

    public function changeStatus($id){
        $chamber = Chamber::find($id);
        if($chamber->status==1){
            $chamber->status=0;
            $chamber->save();
            $message= trans('user_validation.Inactive Successfully');
        }else{
            $chamber->status=1;
            $chamber->save();
            $message= trans('user_validation.Active Successfully');
        }

        return response()->json($message);
    }

    public function setDefault($id){
        $doctor = Auth::guard('doctor')->user();
        Chamber::where('doctor_id', $doctor->id)->where('id', $id)->update(['is_default' => 1]);
        Chamber::where('doctor_id', $doctor->id)->where('id', '!=' , $id)->update(['is_default' => 0]);
        return response()->json(['status' => 1]);
    }


}
