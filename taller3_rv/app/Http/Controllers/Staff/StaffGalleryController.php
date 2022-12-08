<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ImageGallery;
use App\Models\VideoGallery;
use App\Models\Order;
use App\Models\Doctor;
use App\Models\DoctorSocialLink;
use Str;
use Image;
use File;
use Auth;
class StaffGalleryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:staff');
    }

    public function imageGallery(){
        $staff = Auth::guard('staff')->user();
        $images = ImageGallery::where('doctor_id', $staff->doctor_id)->get();

        return view('staff.image_gallery', compact('images'));
    }

    public function storeImageGallery(Request $request){
        $staff = Auth::guard('staff')->user();
        $activeOrder = Order::where('doctor_id', $staff->doctor_id)->where('status', 1)->first();
        $qty = ImageGallery::where('doctor_id', $staff->doctor_id)->count();
        if(!$activeOrder){
            $notification = trans('user_validation.Something Went Wrong');
            $notification=array('messege'=>$notification,'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }

        if($activeOrder->maximum_image != -1){
            if($activeOrder->maximum_image <= $qty){
                $notification = trans('user_validation.You can not upload any image for your pricing plan limitation');
                $notification=array('messege'=>$notification,'alert-type'=>'error');
                return redirect()->back()->with($notification);
            }
        }

        $doctor = Doctor::find($staff->doctor_id);
        $image = $request->image;
        $extention = $image->getClientOriginalExtension();
        $image_name = Str::slug($doctor->name).'gallery-image-'.date('Ymdhis').'.'.$extention;
        $image_name = 'uploads/custom-images/'.$image_name;

        Image::make($image)
            ->save(public_path().'/'.$image_name);

        $gallery = new ImageGallery();
        $gallery->doctor_id = $doctor->id;
        $gallery->image = $image_name;
        $gallery->save();

        $notification = trans('user_validation.Uploaded Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }

    public function deleteImageGallery($id){
        $gallery = ImageGallery::find($id);
        $old_image = $gallery->image;
        $gallery->delete();
        if($old_image){
            if(File::exists(public_path().'/'.$old_image))unlink(public_path().'/'.$old_image);
        }

        $notification = trans('user_validation.Delete Successfully');
        $notification = array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);

    }

    public function videoGallery(){
        $staff = Auth::guard('staff')->user();
        $videos = VideoGallery::where('doctor_id', $staff->doctor_id)->get();

        return view('staff.video_gallery', compact('videos'));
    }

    public function storeVideoGallery(Request $request){
        $staff = Auth::guard('staff')->user();
        $activeOrder = Order::where('doctor_id', $staff->doctor_id)->where('status', 1)->first();
        $qty = VideoGallery::where('doctor_id', $staff->doctor_id)->count();
        if(!$activeOrder){
            $notification = trans('user_validation.Something Went Wrong');
            $notification=array('messege'=>$notification,'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }

        if($activeOrder->maximum_video != -1){
            if($activeOrder->maximum_video <= $qty){
                $notification = trans('user_validation.You can not upload any video for your pricing plan limitation');
                $notification=array('messege'=>$notification,'alert-type'=>'error');
                return redirect()->back()->with($notification);
            }
        }

        $valid = preg_match("/^(https?\:\/\/)?(www\.)?(youtube\.com|youtu\.be)\/watch\?v\=\w+$/", $request->link);
        if ($valid) {
            $video = new VideoGallery();
            $video->doctor_id = $staff->doctor_id;
            $video->video_link = $request->link;
            $video->save();
            $notification = trans('user_validation.Created Successfully');
            $notification = array('messege'=>$notification,'alert-type'=>'success');
            return redirect()->back()->with($notification);
        } else {
            $notification = trans('user_validation.Please provide your valid youtube url');
            $notification = array('messege'=>$notification,'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }
    }


    public function deleteVideoGallery($id){
        $video = VideoGallery::find($id);
        $video->delete();

        $notification = trans('user_validation.Delete Successfully');
        $notification = array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }

    public function socailLink(){
        $staff = Auth::guard('staff')->user();
        $socialLinks = DoctorSocialLink::where('doctor_id', $staff->doctor_id)->get();
        return view('staff.social_link', compact('socialLinks'));
    }

    public function storeSocialLink(Request $request){
        $staff = Auth::guard('staff')->user();
        $socialLink = new DoctorSocialLink();
        $socialLink->link = $request->link;
        $socialLink->icon = $request->icon;
        $socialLink->doctor_id = $staff->doctor_id;
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

}
