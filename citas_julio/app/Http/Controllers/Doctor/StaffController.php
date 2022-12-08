<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Staff;
use App\Models\Chamber;
use App\Models\Order;
use Auth;
use Hash;
use File;
class StaffController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:doctor');
    }

    public function index(){
        $doctor = Auth::guard('doctor')->user();
        $staffs = Staff::where('doctor_id', $doctor->id)->get();
        $chambers = Chamber::where('doctor_id', $doctor->id)->get();
        return view('doctor.staff', compact('staffs','chambers'));
    }

    public function store(Request $request){
        $doctor = Auth::guard('doctor')->user();
        $activeOrder = Order::where('doctor_id', $doctor->id)->where('status', 1)->first();
        $qty = Staff::where('doctor_id', $doctor->id)->count();

        if(!$activeOrder){
            $notification = trans('user_validation.Something Went Wrong');
            $notification=array('messege'=>$notification,'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }

        if($activeOrder->maximum_staff != -1){
            if($activeOrder->maximum_staff <= $qty){
                $notification = trans('user_validation.You can not added any staff for your pricing plan limitation');
                $notification=array('messege'=>$notification,'alert-type'=>'error');
                return redirect()->back()->with($notification);
            }
        }


        $rules = [
            'name' => 'required',
            'email' => 'required|unique:staff',
            'password' => 'required|min:4',
        ];
        $customMessages = [
            'name.required' => trans('user_validation.Name is required'),
            'email.required' => trans('user_validation.Email is required'),
            'email.unique' => trans('user_validation.Email already exist'),
            'password.required' => trans('user_validation.Password is required'),
            'password.min' => trans('user_validation.Password Must be 4 characters'),
        ];
        $this->validate($request, $rules,$customMessages);

        $staff = new Staff();
        $staff->doctor_id =$doctor->id;
        $staff->name =$request->name;
        $staff->email =$request->email;
        $staff->status =$request->status;
        $staff->chamber_id =$request->chamber;
        $staff->password =Hash::make($request->password);
        $staff->save();

        $notification = trans('user_validation.Create Successfully');
        $notification = array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }

    public function update(Request $request, $id){
        $rules = [
            'name' => 'required',
            'email' => 'required|unique:staff,email,'.$id,
            'password' => $request->password ? 'min:4' : '',
        ];
        $customMessages = [
            'name.required' => trans('user_validation.Name is required'),
            'email.required' => trans('user_validation.Email is required'),
            'email.unique' => trans('user_validation.Email already exist'),
            'password.min' => trans('user_validation.Password Must be 4 characters'),
        ];
        $this->validate($request, $rules,$customMessages);

        $doctor = Auth::guard('doctor')->user();
        $staff = Staff::find($id);
        $staff->chamber_id = $request->chamber;
        $staff->name = $request->name;
        $staff->email = $request->email;
        if($request->password){
            $staff->password =Hash::make($request->password);
        }
        $staff->save();

        $notification = trans('user_validation.Update Successfully');
        $notification = array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }

    public function destroy($id){
        $staff = Staff::find($id);
        $old_image = $staff->image;
        $staff->delete();
        if($old_image){
            if(File::exists(public_path().'/'.$old_image))unlink(public_path().'/'.$old_image);
        }

        $notification = trans('user_validation.Delete Successfully');
        $notification = array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }


    public function changeStatus($id){

        $staff = Staff::find($id);
        if($staff->status==1){
            $staff->status=0;
            $staff->save();
            $message= trans('user_validation.Inactive Successfully');
            return response()->json(['status' => 1 , 'message' => $message]);
        }else{
            $doctor = Auth::guard('doctor')->user();
            $activeOrder = Order::where('doctor_id', $doctor->id)->where('status', 1)->first();
            $qty = Staff::where('doctor_id', $doctor->id)->where('status', 1)->count();

            if($activeOrder){
                if($activeOrder->maximum_staff == -1){
                    $staff->status=1;
                    $staff->save();
                    $message= trans('user_validation.Active Successfully');
                    return response()->json(['status' => 1 , 'message' => $message]);
                }else{
                    if($qty >= $activeOrder->maximum_staff){
                        $notification = trans('user_validation.You can not change status for your pricing plan limitation');
                        return response()->json(['status' => 0 , 'message' => $notification]);
                    }else{
                        $staff->status=1;
                        $staff->save();
                        $message= trans('user_validation.Active Successfully');
                        return response()->json(['status' => 1 , 'message' => $message]);
                    }
                }

            }else{
                $message = trans('user_validation.Something Went Wrong');
                return response()->json(['status' => 0 , 'message' => $message]);
            }
        }
    }
}
