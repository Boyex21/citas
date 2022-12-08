<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use Illuminate\Http\Request;
use Image;
use File;
use Str;
class AboutUsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $about = AboutUs::first();
        return view('admin.about-us',compact('about'));
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'about_description' => 'required',
        ];
        $customMessages = [
            'description.required' => trans('admin_validation.Description is required'),
        ];
        $this->validate($request, $rules,$customMessages);

        $aboutUs = AboutUs::find($id);
        if($request->image){
            $exist_banner = $aboutUs->about_image;
            $extention = $request->image->getClientOriginalExtension();
            $banner_name = 'About-us-foreground-'.date('Y-m-d-h-i-s-').'.'.$extention;
            $banner_name = 'uploads/website-images/'.$banner_name;
            Image::make($request->image)
                ->save(public_path().'/'.$banner_name);
                $aboutUs->about_image = $banner_name;
                $aboutUs->save();

            if(File::exists(public_path($exist_banner)))unlink(public_path($exist_banner));

        }

        if($request->background_image){
            $exist_banner = $aboutUs->background_image;
            $extention = $request->background_image->getClientOriginalExtension();
            $banner_name = 'About-us-background-'.date('Y-m-d-h-i-s-').'.'.$extention;
            $banner_name = 'uploads/website-images/'.$banner_name;
            Image::make($request->background_image)
                ->save(public_path().'/'.$banner_name);
                $aboutUs->background_image = $banner_name;
                $aboutUs->save();
            if(File::exists(public_path($exist_banner)))unlink(public_path($exist_banner));
        }

        $aboutUs->about_description = $request->about_description;
        $aboutUs->save();

        $notification = trans('admin_validation.Updated Successfully');
        $notification = array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }

    public function updateMission(Request $request, $id){
        $rules = [
            'mission_description' => 'required',
        ];
        $customMessages = [
            'mission_description.required' => trans('admin_validation.Description is required'),
        ];
        $this->validate($request, $rules,$customMessages);

        $aboutUs = AboutUs::find($id);

        if($request->image){
            $exist_banner = $aboutUs->mission_image;
            $extention = $request->image->getClientOriginalExtension();
            $banner_name = 'About-us-mission-'.date('Y-m-d-h-i-s-').'.'.$extention;
            $banner_name = 'uploads/website-images/'.$banner_name;
            Image::make($request->image)
                ->save(public_path().'/'.$banner_name);
                $aboutUs->mission_image = $banner_name;
                $aboutUs->save();

            if(File::exists(public_path($exist_banner)))unlink(public_path($exist_banner));

        }

        $aboutUs->mission_description = $request->mission_description;
        $aboutUs->save();

        $notification = trans('admin_validation.Updated Successfully');
        $notification = array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }

    public function updateVision(Request $request, $id){
        $rules = [
            'vision_description' => 'required',
        ];
        $customMessages = [
            'vision_description.required' => trans('admin_validation.Description is required'),
        ];
        $this->validate($request, $rules,$customMessages);

        $aboutUs = AboutUs::find($id);

        if($request->image){
            $exist_banner = $aboutUs->vision_image;
            $extention = $request->image->getClientOriginalExtension();
            $banner_name = 'About-us-mission-'.date('Y-m-d-h-i-s-').'.'.$extention;
            $banner_name = 'uploads/website-images/'.$banner_name;
            Image::make($request->image)
                ->save(public_path().'/'.$banner_name);
                $aboutUs->vision_image = $banner_name;
                $aboutUs->save();

            if(File::exists(public_path($exist_banner)))unlink(public_path($exist_banner));

        }

        $aboutUs->vision_description = $request->vision_description;
        $aboutUs->save();

        $notification = trans('admin_validation.Updated Successfully');
        $notification = array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }


}
