<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Setting;
use App\Models\BannerImage;
use App\Models\Location;
use App\Models\Department;
use App\Models\DoctorSocialLink;
use App\Models\Appointment;
use App\Models\AppointmentOrder;
use App\Models\Chamber;
use App\Models\Staff;
use App\Models\DoctorReview;
use Str;
use Auth;
use Hash;
use Image;
use File;
class DoctorProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:doctor');
    }

    public function dashboard(){
        $doctor = Auth::guard('doctor')->user();
        $todayAppointments = Appointment::whereDay('created_at', now()->day)->where('doctor_id', $doctor->id)->get();

        $todayOrders = AppointmentOrder::with('doctor')->orderBy('id','desc')->whereDay('created_at', now()->day)->get();
        $orders = AppointmentOrder::with('doctor')->orderBy('id','desc')->where('doctor_id', $doctor->id)->get();
        $setting = Setting::first();
        $appointments = Appointment::where('doctor_id', $doctor->id)->get();

        $monthlyAppointments = Appointment::whereMonth('created_at', now()->month)->where('doctor_id', $doctor->id)->get();
        $yearlyAppointments = Appointment::whereYear('created_at', now()->year)->where('doctor_id', $doctor->id)->get();

        $chambers = Chamber::where('doctor_id', $doctor->id)->get();
        $staffs = Staff::where('doctor_id', $doctor->id)->get();

        return view('doctor.dashboard', compact('todayAppointments','todayOrders','orders','setting', 'appointments','monthlyAppointments', 'yearlyAppointments','chambers','staffs'));
    }

    public function myProfile(){
        $doctor = Auth::guard('doctor')->user();
        $defaultProfile = BannerImage::whereId('15')->first();

        $locations = Location::where('status', 1)->get();
        $departments = Department::where('status', 1)->get();
        return view('doctor.my_profile', compact('doctor','defaultProfile','locations','departments'));
    }

    public function updateProfile(Request $request){
        $doctor=Auth::guard('doctor')->user();
        $rules = [
            'name'=>'required',
            'slug'=>'required|unique:doctors,slug,'.$doctor->id,
            'email'=>'required|unique:doctors,email,'.$doctor->id,
            'fee' => 'required|numeric',
            'location_id' => 'required',
            'department_id' => 'required',
            'about' => 'required',
            'qualification' => 'required',
            'designation' => 'required',
            'address' => 'required',
        ];
        $customMessages = [
            'name.required' => trans('user_validation.Name is required'),
            'slug.required' => trans('user_validation.Slug is required'),
            'slug.unique' => trans('user_validation.Slug already exist'),
            'email.required' => trans('user_validation.Email is required'),
            'email.unique' => trans('user_validation.Email already exist'),
            'fee.required' => trans('user_validation.Fee is required'),
            'fee.numeric' => trans('user_validation.Fee must be a number'),
            'location_id.required' => trans('user_validation.Location is required'),
            'location_id.required' => trans('user_validation.Location is required'),
            'department_id.required' => trans('user_validation.Department is required'),
            'about.required' => trans('user_validation.About is required'),
            'address.required' => trans('user_validation.Address is required'),
            'qualification.required' => trans('user_validation.Qualification is required'),
            'designation.required' => trans('user_validation.Designation is required'),
        ];
        $this->validate($request, $rules,$customMessages);

        // inset user profile image
        if($request->file('image')){
            $old_image = $doctor->image;
            $user_image = $request->image;
            $extention = $user_image->getClientOriginalExtension();
            $image_name = Str::slug($request->name).date('-Y-m-d-h-i-s-').rand(999,9999).'.'.$extention;
            $image_name ='uploads/custom-images/'.$image_name;

            Image::make($user_image)
                ->save(public_path().'/'.$image_name);

            $doctor->image=$image_name;
            $doctor->save();
            if($old_image){
                if(File::exists(public_path().'/'.$old_image))unlink(public_path().'/'.$old_image);
            }
        }

        $doctor->name = $request->name;
        $doctor->slug = $request->slug;
        $doctor->phone = $request->phone;
        $doctor->fee = $request->fee;
        $doctor->location_id = $request->location_id;
        $doctor->department_id = $request->department_id;
        $doctor->about = $request->about;
        $doctor->qualifications = $request->qualification;
        $doctor->designation = $request->designation;
        $doctor->address = $request->address;
        $doctor->seo_title = $request->seo_title ? $request->seo_title : $request->name;
        $doctor->seo_description = $request->seo_description ? $request->seo_description : $request->name;
        $doctor->profile_fillup = 1;
        $doctor->save();

        $notification= trans('user_validation.Update Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->route('doctor.profile')->with($notification);
    }

    public function changePassword(){
        return view('doctor.change_password');
    }

    public function updatePassword(Request $request){
        $doctor=Auth::guard('doctor')->user();
        $rules = [
            'password' => 'required|confirmed|min:4',
        ];
        $customMessages = [
            'password.required' => trans('user_validation.Password is required'),
            'password.confirmed' => trans('user_validation.Confirm Password is required'),
            'password.min' => trans('user_validation.Password must be at least 4 characters'),
        ];
        $this->validate($request, $rules,$customMessages);

        $doctor->password = Hash::make($request->password);
        $doctor->save();

        $notification= trans('user_validation.Update Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }

    public function socailLink(){
        $doctor=Auth::guard('doctor')->user();
        $socialLinks = DoctorSocialLink::where('doctor_id', $doctor->id)->get();
        return view('doctor.social_link', compact('socialLinks'));
    }

    public function storeSocialLink(Request $request){
        $doctor=Auth::guard('doctor')->user();
        $socialLink = new DoctorSocialLink();
        $socialLink->link = $request->link;
        $socialLink->icon = $request->icon;
        $socialLink->doctor_id = $doctor->id;
        $socialLink->save();

        $notification= trans('user_validation.Created Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }


    public function deleteSocialLink($id){
        $socialLink = DoctorSocialLink::find($id);
        $socialLink->delete();

        $notification= trans('user_validation.Delete Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }


    public function review(){
        $doctor = Auth::guard('doctor')->user();
        $reviews = DoctorReview::orderBy('id', 'desc')->where('doctor_id', $doctor->id)->get();
        return view('doctor.review', compact('reviews'));
    }

}
