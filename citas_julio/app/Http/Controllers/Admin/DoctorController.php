<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Staff;
use App\Models\Chamber;
use App\Models\DoctorReview;
use App\Models\DoctorPaypal;
use App\Models\DoctorStripe;
use App\Models\DoctorRazorpay;
use App\Models\DoctorFlutterwave;
use App\Models\DoctorBankPayment;
use App\Models\DoctorMollie;
use App\Models\DoctorPaystack;
use App\Models\DoctorInstamojo;
use App\Models\AppointmentOrder;
use App\Models\Appointment;
use App\Models\PrescriptionMedicine;
use App\Models\Schedule;
use App\Models\ZoomCredential;
use App\Models\ZoomMeeting;
use App\Models\Order;
use App\Models\MeetingHistory;
use App\Models\DoctorSocialLink;
use App\Models\ImageGallery;
use App\Models\VideoGallery;
use App\Models\Leave;
use File;
class DoctorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function doctors(){
        $doctors = Doctor::orderBy('id', 'desc')->get();
        return view('admin.doctor', compact('doctors'));
    }

    public function staff(){
        $staffs = Staff::orderBy('id', 'desc')->get();
        return view('admin.staff', compact('staffs'));
    }

    public function chamber(){
        $chambers = Chamber::orderBy('id', 'desc')->get();
        return view('admin.chamber', compact('chambers'));
    }



    public function showDoctor($id){
        $doctor = Doctor::find($id);
        return view('admin.show_doctor', compact('doctor'));
    }

    public function destroy($id){
        $doctor = Doctor::find($id);
        $paypal = DoctorPaypal::where('doctor_id', $doctor->id)->delete();
        $stripe = DoctorStripe::where('doctor_id', $doctor->id)->delete();
        $razorpay = DoctorRazorpay::where('doctor_id', $doctor->id)->delete();
        $flutterwave = DoctorFlutterwave::where('doctor_id', $doctor->id)->delete();
        $bank = DoctorBankPayment::where('doctor_id', $doctor->id)->delete();
        $mollie = DoctorMollie::where('doctor_id', $doctor->id)->delete();
        $paystack = DoctorPaystack::where('doctor_id', $doctor->id)->delete();
        $instamojo = DoctorInstamojo::where('doctor_id', $doctor->id)->delete();
        Order::where('doctor_id', $doctor->id)->delete();
        Chamber::where('doctor_id', $doctor->id)->delete();
        AppointmentOrder::where('doctor_id', $doctor->id)->delete();
        $appointments = Appointment::where('doctor_id', $doctor->id)->get();
        foreach($appointments as $appointment){
            PrescriptionMedicine::where('appointment_id', $appointment->id)->delete();
            $appointment->delete();
        }
        Schedule::where(['doctor_id' => $doctor->id])->delete();
        ZoomCredential::where('doctor_id',$doctor->id)->delete();
        Leave::where(['doctor_id' => $doctor->id])->delete();
        ZoomMeeting::where('doctor_id',$doctor->id)->delete();
        MeetingHistory::where('doctor_id',$doctor->id)->delete();
        DoctorSocialLink::where('doctor_id', $doctor->id)->delete();
        VideoGallery::where('doctor_id', $doctor->id)->delete();
        DoctorReview::where('doctor_id', $doctor->id)->delete();

        $images = ImageGallery::where('doctor_id', $doctor->id)->get();
        foreach($images as $gallery){
            $old_image = $gallery->image;
            $gallery->delete();
            if($old_image){
                if(File::exists(public_path().'/'.$old_image))unlink(public_path().'/'.$old_image);
            }
        }

        $staffs = Staff::where('doctor_id', $doctor->id)->get();
        foreach($staffs as $staff){
            $old_image = $staff->image;
            $staff->delete();
            if($old_image){
                if(File::exists(public_path().'/'.$old_image))unlink(public_path().'/'.$old_image);
            }
        }

        $old_image = $doctor->image;
        $doctor->delete();
        if($old_image){
            if(File::exists(public_path().'/'.$old_image))unlink(public_path().'/'.$old_image);
        }


        $notification = trans('admin_validation.Delete Successfully');
        $notification = array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->route('admin.doctor')->with($notification);

    }

    public function changeStatus($id){
        $doctor = Doctor::find($id);
        if($doctor->status == 1){
            $doctor->status = 0;
            $doctor->save();
            $message = trans('admin_validation.Inactive Successfully');
        }else{
            $doctor->status = 1;
            $doctor->save();
            $message = trans('admin_validation.Active Successfully');
        }
        return response()->json($message);
    }


    public function review(){
        $reviews = DoctorReview::orderBy('id', 'desc')->get();
        return view('admin.review', compact('reviews'));
    }

    public function changeReviewStatus($id){
        $review = DoctorReview::find($id);
        if($review->status == 1){
            $review->status = 0;
            $review->save();
            $message = trans('admin_validation.Inactive Successfully');
        }else{
            $review->status = 1;
            $review->save();
            $message = trans('admin_validation.Active Successfully');
        }
        return response()->json($message);
    }

    public function reviewDelete($id){
        $review = DoctorReview::find($id);
        $review->delete();
        $notification= trans('admin_validation.Delete Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }

}
