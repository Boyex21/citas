<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;
use App\Models\MaintainanceText;
use Image;
use File;
use Str;
use Cache;
class SliderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(){
        $sliders = Slider::all();
        $content = MaintainanceText::first();
        return view('admin.slider', compact('sliders', 'content'));
    }

    public function create(){
        return view('admin.create_slider');
    }

    public function store(Request $request){
        $rules = [
            'slider_image' => 'required',
            'status' => 'required',
            'serial' => 'required',
        ];
        $customMessages = [
            'slider_image.required' => trans('admin_validation.Slider image is required'),
            'status.required' => trans('admin_validation.Status is required'),
            'serial.required' => trans('admin_validation.Serial is required'),
        ];
        $this->validate($request, $rules,$customMessages);

        $slider = new Slider();
        if($request->slider_image){
            $extention = $request->slider_image->getClientOriginalExtension();
            $slider_image = 'Slider'.date('Ymdhis').'.'.$extention;
            $slider_image = 'uploads/custom-images/'.$slider_image;
            Image::make($request->slider_image)
                ->save(public_path().'/'.$slider_image);
            $slider->image = $slider_image;
        }

        $slider->serial = $request->serial;
        $slider->status = $request->status;
        $slider->save();

        $notification= trans('admin_validation.Created Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }

    public function edit($id){
        $slider = Slider::find($id);
        return view('admin.edit_slider', compact('slider'));
    }

    public function update(Request $request, $id){
        $rules = [
            'status' => 'required',
            'serial' => 'required',
        ];
        $customMessages = [
            'status.required' => trans('admin_validation.Status is required'),
            'serial.required' => trans('admin_validation.Serial is required'),
        ];
        $this->validate($request, $rules,$customMessages);

        $slider = Slider::find($id);
        if($request->slider_image){
            $existing_slider = $slider->image;
            $extention = $request->slider_image->getClientOriginalExtension();
            $slider_image = 'Slider-'.date('Ymdhis').'.'.$extention;
            $slider_image = 'uploads/custom-images/'.$slider_image;

            Image::make($request->slider_image)
                    ->save(public_path().'/'.$slider_image);
            $slider->image = $slider_image;
            $slider->save();
            if($existing_slider){
                if(File::exists(public_path().'/'.$existing_slider))unlink(public_path().'/'.$existing_slider);
            }
        }

        $slider->serial = $request->serial;
        $slider->status = $request->status;
        $slider->save();

        $notification= trans('admin_validation.Update Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->route('admin.slider.index')->with($notification);
    }




    public function destroy($id){
        $slider = Slider::find($id);
        $existing_slider = $slider->image;
        $slider->delete();
        if($existing_slider){
            if(File::exists(public_path().'/'.$existing_slider))unlink(public_path().'/'.$existing_slider);
        }

        $notification= trans('admin_validation.Delete Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->route('admin.slider.index')->with($notification);
    }


    public function changeStatus($id){
        $slider = Slider::find($id);
        if($slider->status==1){
            $slider->status=0;
            $slider->save();
            $message= trans('admin_validation.Inactive Successfully');
        }else{
            $slider->status=1;
            $slider->save();
            $message= trans('admin_validation.Active Successfully');
        }

        return response()->json($message);
    }

    public function updateSliderContent(Request $request){
        $rules = [
            'slider_title' => 'required',
            'slider_description' => 'required',
        ];
        $customMessages = [
            'slider_title.required' => trans('admin_validation.Slider title is required'),
            'slider_description.required' => trans('admin_validation.Slider descirption is required'),
        ];
        $this->validate($request, $rules,$customMessages);

        $content = MaintainanceText::first();
        $content->slider_title = $request->slider_title;
        $content->slider_description = $request->slider_description;
        $content->save();

        $notification= trans('admin_validation.Update Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);

    }

}
