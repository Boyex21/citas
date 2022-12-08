<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\BreadcrumbImage;
use App\Models\AppointmentOrder;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\DoctorReview;
use App\Models\MeetingHistory;
use Illuminate\Pagination\Paginator;
use App\Models\Setting;
use App\Models\GoogleRecaptcha;
use App\Models\BannerImage;
use App\Models\User;
use App\Rules\Captcha;
use Image;
use File;
use Str;
use Hash;
use Slug;
use PDF;
use App\Events\SellerToUser;

class UserProfileController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function dashboard(){
        $user = Auth::guard('web')->user();
        $appointments = $appointments = Appointment::orderBy('id','desc')->where('user_id', $user->id)->get();
        $banner = BreadcrumbImage::where(['id' => 9])->first();
        return view('user.dashboard', compact('banner', 'appointments'));
    }


    public function appointment(){
        Paginator::useBootstrap();
        $user = Auth::guard('web')->user();
        $appointments = Appointment::orderBy('id','desc')->where('user_id', $user->id)->paginate(10);
        $setting = Setting::first();
        $banner = BreadcrumbImage::where(['id' => 9])->first();
        return view('user.appointment', compact('appointments','setting','banner'));
    }

    public function showAppointment($id){
        $user = Auth::guard('web')->user();
        $banner = BreadcrumbImage::where(['id' => 9])->first();
        $appointment = Appointment::where('id', $id)->where('user_id', $user->id)->first();
        $doctor = Doctor::where('id', $appointment->doctor_id)->first();
        $setting = Setting::first();

        if($appointment->already_treated == 0){
            $notification = trans('user_validation.Something Went Wrong');
            $notification=array('messege'=>$notification,'alert-type'=>'error');
            return redirect()->route('user.appointment')->with($notification);
        }

        return view('user.show_appointment', compact('appointment','setting','banner','doctor','user'));
    }




    public function transaction(){
        Paginator::useBootstrap();
        $user = Auth::guard('web')->user();
        $orders = AppointmentOrder::orderBy('id','desc')->where('user_id', $user->id)->paginate(10);
        $setting = Setting::first();
        $banner = BreadcrumbImage::where(['id' => 9])->first();
        return view('user.transaction', compact('orders','setting','banner'));
    }






    public function myProfile(){
        $user = Auth::guard('web')->user();
        $defaultProfile = BannerImage::whereId('15')->first();
        $banner = BreadcrumbImage::where(['id' => 9])->first();
        return view('user.my_profile', compact('user','defaultProfile','banner'));
    }

    public function updateProfile(Request $request){
        $user = Auth::guard('web')->user();
        $rules = [
            'name'=>'required',
            'email'=>'required|unique:users,email,'.$user->id,
            'address'=>'required',
            'phone'=>'required',
            'age'=>'required',
            'weight'=>'required',
            'gender'=>'required',
        ];
        $customMessages = [
            'name.required' => trans('user_validation.Name is required'),
            'email.required' => trans('user_validation.Email is required'),
            'email.unique' => trans('user_validation.Email already exist'),
            'address.required' => trans('user_validation.Address is required'),
            'phone.required' => trans('user_validation.Phone is required'),
            'age.required' => trans('user_validation.Age is required'),
            'weight.required' => trans('user_validation.Weight is required'),
            'gender.required' => trans('user_validation.Gender is required'),
        ];
        $this->validate($request, $rules,$customMessages);

        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->age = $request->age;
        $user->weight = $request->weight;
        $user->gender = $request->gender;
        $user->fillup = 1;
        $user->save();

        if($request->file('image')){
            $old_image=$user->image;
            $user_image=$request->image;
            $extention=$user_image->getClientOriginalExtension();
            $image_name= Str::slug($request->name).date('-Y-m-d-h-i-s-').rand(999,9999).'.'.$extention;
            $image_name='uploads/custom-images/'.$image_name;

            Image::make($user_image)
                ->save(public_path().'/'.$image_name);

            $user->image=$image_name;
            $user->save();
            if($old_image){
                if(File::exists(public_path().'/'.$old_image))unlink(public_path().'/'.$old_image);
            }
        }

        $notification = trans('user_validation.Update Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }


    public function changePassword(){
        $banner = BreadcrumbImage::where(['id' => 9])->first();
        return view('user.change_password', compact('banner'));
    }

    public function updatePassword(Request $request){
        $rules = [
            'current_password'=>'required',
            'password'=>'required|min:4|confirmed',
        ];
        $customMessages = [
            'current_password.required' => trans('user_validation.Current password is required'),
            'password.required' => trans('user_validation.Password is required'),
            'password.min' => trans('user_validation.Password minimum 4 character'),
            'password.confirmed' => trans('user_validation.Confirm password does not match'),
        ];
        $this->validate($request, $rules,$customMessages);

        $user = Auth::guard('web')->user();
        if(Hash::check($request->current_password, $user->password)){
            $user->password = Hash::make($request->password);
            $user->save();
            $notification = 'Password change successfully';
            $notification = array('messege'=>$notification,'alert-type'=>'success');
            return redirect()->back()->with($notification);
        }else{
            $notification = trans('user_validation.Current password does not match');
            $notification = array('messege'=>$notification,'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }
    }

    public function stateByCountry($id){
        $states = CountryState::where(['status' => 1, 'country_id' => $id])->get();
        $response='<option value="0">Select a State</option>';
        if($states->count() > 0){
            foreach($states as $state){
                $response .= "<option value=".$state->id.">".$state->name."</option>";
            }
        }
        return response()->json(['states'=>$response]);
    }

    public function cityByState($id){
        $cities = City::where(['status' => 1, 'country_state_id' => $id])->get();
        $response='<option value="0">Select a City</option>';
        if($cities->count() > 0){
            foreach($cities as $city){
                $response .= "<option value=".$city->id.">".$city->name."</option>";
            }
        }
        return response()->json(['cities'=>$response]);
    }


    public function downloadInvoice($code){
        $user = Auth::guard('web')->user();
        $setting = Setting::first();
        $item = OrderItem::where(['user_id' => $user->id, 'purchase_code' => $code])->first();
        if($item){
            $product = Product::find($item->product_id);
            $data = [
                'package' => $item->package_name,
                'purchase_code' => $item->purchase_code,
                'product_name' => $item->product_name,
                'created_at' => $item->created_at->format('Y-m-d'),
                'url' => route('shop.detail', $product->slug),
                'logo' => $setting->logo,
            ];
            $pdf = PDF::loadView('user.invoice', $data);
            return $pdf->download($item->product_name.'.'.'pdf');
        }else{
            abort(404);
        }
    }

    public function review(){
        Paginator::useBootstrap();
        $user = Auth::guard('web')->user();
        $reviews = DoctorReview::where(['status' => 1, 'user_id' => $user->id])->orderBy('id', 'desc')->paginate(10);
        $banner = BreadcrumbImage::where(['id' => 9])->first();
        return view('user.review', compact('user','banner','reviews'));
    }


    public function meetingHistory(){
        Paginator::useBootstrap();
        $user = Auth::guard('web')->user();
        $histories = MeetingHistory::where('user_id',$user->id)->orderBy('meeting_time','desc')->paginate(10);
        $banner = BreadcrumbImage::where(['id' => 9])->first();

        return view('user.meeting_history', compact('user','banner','histories'));
    }

    public function upcomingMeeting(){
        Paginator::useBootstrap();
        $user = Auth::guard('web')->user();
        $histories = MeetingHistory::where('user_id',$user->id)->orderBy('meeting_time','desc')->paginate(10);
        $banner = BreadcrumbImage::where(['id' => 9])->first();

        return view('user.upcoming_meeting', compact('user','banner','histories'));
    }


}
