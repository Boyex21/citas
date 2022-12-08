<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\Setting;
use Str;
class PackageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(){
        $packages = Package::with('orders')->get();
        $setting = Setting::first();
        return view('admin.package', compact('packages', 'setting'));
    }

    public function create(){
        return view('admin.create_package');
    }

    public function store(Request $request){
        $rules = [
            'name'=>'required|unique:packages',
            'price'=>'required',
            'expiration_day'=>'required',
            'daily_appointment_qty'=>'required',
            'maximum_chamber'=>'required',
            'maximum_staff'=>'required',
            'online_consulting'=>'required',
            'message_system'=>'required',
            'status'=>'required',
            'maximum_image'=>'required',
            'maximum_video'=>'required',
        ];

        $customMessages = [
            'name.required' => trans('admin_validation.Name is required'),
            'name.unique' => trans('admin_validation.Name already exist'),
            'price.required' => trans('admin_validation.Price is required'),
            'expiration_day.required' => trans('admin_validation.Expiration day is required'),
            'daily_appointment_qty.required' => trans('admin_validation.Daily maximum qty is required'),
            'maximum_chamber.required' => trans('admin_validation.Maximum Chamber is required'),
            'maximum_staff.required' => trans('admin_validation.Maximum staff is required'),
            'maximum_image.required' => trans('admin_validation.Maximum Image is required'),
            'maximum_video.required' => trans('admin_validation.Maximum video is required'),
        ];

        $this->validate($request, $rules, $customMessages);

        $package = new Package();
        $package->name = $request->name;
        $package->slug = Str::slug($request->name);
        $package->price = $request->price;
        $package->expiration_day = $request->expiration_day;
        $package->daily_appointment_qty = $request->daily_appointment_qty;
        $package->maximum_chamber = $request->maximum_chamber;
        $package->maximum_staff = $request->maximum_staff;
        $package->maximum_image = $request->maximum_image;
        $package->maximum_video = $request->maximum_video;
        $package->online_consulting = $request->online_consulting;
        $package->message_system = $request->message_system;
        $package->status = $request->status;
        $package->save();

        $notification = trans('admin_validation.Create Successfully');
        $notification = array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->route('admin.pricing-plan.index')->with($notification);
    }

    public function edit($id){
        $package = Package::find($id);
        return view('admin.edit_package', compact('package'));
    }

    public function update(Request $request, $id){

        $package = Package::find($id);
        $rules = [
            'name'=>'required|unique:packages,name,'.$package->id,
            'price'=>'required',
            'expiration_day'=>'required',
            'daily_appointment_qty'=>'required',
            'maximum_staff'=>'required',
            'maximum_chamber'=>'required',
            'online_consulting'=>'required',
            'message_system'=>'required',
            'status'=>'required',
            'maximum_image'=>'required',
            'maximum_video'=>'required',
        ];

        $customMessages = [
            'name.required' => trans('admin_validation.Name is required'),
            'name.unique' => trans('admin_validation.Name already exist'),
            'price.required' => trans('admin_validation.Price is required'),
            'expiration_day.required' => trans('admin_validation.Expiration day is required'),
            'daily_appointment_qty.required' => trans('admin_validation.Daily maximum qty is required'),
            'maximum_staff.required' => trans('admin_validation.Maximum staff is required'),
            'maximum_chamber.required' => trans('admin_validation.Maximum chamber is required'),
            'maximum_image.required' => trans('admin_validation.Maximum Image is required'),
            'maximum_video.required' => trans('admin_validation.Maximum video is required'),
        ];

        $this->validate($request, $rules, $customMessages);

        $package->name = $request->name;
        $package->slug = Str::slug($request->name);
        $package->price = $request->price;
        $package->expiration_day = $request->expiration_day;
        $package->daily_appointment_qty = $request->daily_appointment_qty;
        $package->maximum_staff = $request->maximum_staff;
        $package->maximum_chamber = $request->maximum_chamber;
        $package->maximum_image = $request->maximum_image;
        $package->maximum_video = $request->maximum_video;
        $package->online_consulting = $request->online_consulting;
        $package->message_system = $request->message_system;
        $package->status = $request->status;
        $package->save();

        $notification = trans('admin_validation.Update Successfully');
        $notification = array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->route('admin.pricing-plan.index')->with($notification);
    }


    public function destroy($id){
        $package = Package::find($id);
        $package->delete();

        $notification = trans('admin_validation.Delete Successfully');
        $notification = array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->route('admin.pricing-plan.index')->with($notification);
    }


    // manage blog status
    public function changeStatus($id){
        $package = Package::find($id);
        if($package->status==1){
            $package->status=0;
            $notification = trans('admin_validation.Inactive successfully');
            $message=$notification;
        }else{
            $package->status=1;
            $notification = trans('admin_validation.Active successfully');
            $message=$notification;
        }
        $package->save();
        return response()->json($message);

    }
}
