<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceImageGallery;
use App\Models\Servicevideo;
use App\Models\ServiceFaq;
use Illuminate\Http\Request;
use Image;
use File;
use Str;
use Cache;
class ServiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $services = Service::all();
        return view('admin.service',compact('services'));
    }

    public function create()
    {
        return view('admin.create_service');
    }


    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|unique:services',
            'icon' => 'required',
            'short_description' => 'required',
            'description' => 'required',
            'status' => 'required',
            'images' => 'required',
        ];
        $customMessages = [
            'name.required' => trans('admin_validation.Name is required'),
            'name.unique' => trans('admin_validation.Name already exist'),
            'icon.required' => trans('admin_validation.Icon is required'),
            'description.required' => trans('admin_validation.Description is required'),
            'short_description.required' => trans('admin_validation.Short Description is required'),
            'image.required' => trans('admin_validation.Image is required'),
        ];
        $this->validate($request, $rules,$customMessages);


        $service = new Service();
        $service->name = $request->name;
        $service->slug = Str::slug($request->name);
        $service->icon = $request->icon;
        $service->description = $request->description;
        $service->short_description = $request->short_description;
        $service->status = $request->status;
        $service->show_homepage = $request->show_homepage;
        $service->seo_title = $request->seo_title ? $request->seo_title : $request->name;
        $service->seo_description = $request->seo_description ? $request->seo_description : $request->name;
        $service->save();


        if($request->images){
            foreach($request->images as $image) {
                $extention = $image->getClientOriginalExtension();
                $banner_name = Str::slug($service->name).date('Y-m-d-h-i-s-').rand(999,9999).'.'.$extention;
                $banner_name = 'uploads/custom-images/'.$banner_name;
                Image::make($image)
                    ->save(public_path().'/'.$banner_name);

                $gallery = new ServiceImageGallery();
                $gallery->service_id = $service->id;
                $gallery->image = $banner_name;
                $gallery->save();
            }
        }


        $notification = trans('admin_validation.Created Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->route('admin.service.index')->with($notification);
    }


    public function edit($id)
    {
        $service = Service::find($id);
        return view('admin.edit_service',compact('service'));
    }


    public function update(Request $request, $id)
    {
        $service = Service::find($id);
        $rules = [
            'name' => 'required|unique:services,name,'.$service->id,
            'icon' => 'required',
            'short_description' => 'required',
            'description' => 'required',
            'status' => 'required',
        ];
        $customMessages = [
            'name.required' => trans('admin_validation.Name is required'),
            'name.unique' => trans('admin_validation.Name already exist'),
            'icon.required' => trans('admin_validation.Icon is required'),
            'description.required' => trans('admin_validation.Description is required'),
            'short_description.required' => trans('admin_validation.Short Description is required'),
        ];
        $this->validate($request, $rules,$customMessages);

        $service->name = $request->name;
        $service->slug = Str::slug($request->name);
        $service->icon = $request->icon;
        $service->description = $request->description;
        $service->short_description = $request->short_description;
        $service->status = $request->status;
        $service->show_homepage = $request->show_homepage;
        $service->seo_title = $request->seo_title ? $request->seo_title : $request->name;
        $service->seo_description = $request->seo_description ? $request->seo_description : $request->name;
        $service->save();

        $notification = trans('admin_validation.Update Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->route('admin.service.index')->with($notification);
    }


    public function destroy($id)
    {
        $service = Service::find($id);
        $service->delete();

        $galleries = ServiceImageGallery::where('service_id', $id)->get();
        foreach($galleries as $gallery){
            if($gallery->image){
                if(File::exists(public_path().'/'.$gallery->image))unlink(public_path().'/'.$gallery->image);
            }
            $gallery->delete();
        }

        Servicevideo::where('service_id', $id)->delete();
        ServiceFaq::where('service_id', $id)->delete();

        $notification = trans('admin_validation.Delete Successfully');
        $notification = array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->route('admin.service.index')->with($notification);
    }

    public function changeStatus($id){
        $service = Service::find($id);
        if($service->status == 1){
            $service->status = 0;
            $service->save();
            $message = trans('admin_validation.Inactive Successfully');
        }else{
            $service->status = 1;
            $service->save();
            $message = trans('admin_validation.Active Successfully');
        }

        $menuServices = Service::where('status',1)->select('name','slug')->get();
        Cache::put('menuServices', $menuServices);

        return response()->json($message);
    }

    public function gallery($id){
        $service = Service::find($id);
        if($service){
        $galleries = ServiceImageGallery::where('service_id', $id)->get();
        return view('admin.service_image_gallery', compact('service','galleries'));
        }else{
            $notification = trans('admin_validation.Something went wrong');
            $notification=array('messege'=>$notification,'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }
    }

    public function storeGalleryImage(Request $request){
        $rules = [
            'image' => 'required',
        ];
        $this->validate($request, $rules);

        $service = Service::find($request->service_id);
        if($service){
            if($request->image){
                $image = $request->image;
                $extention = $image->getClientOriginalExtension();
                $image_name = Str::slug($service->name).date('Y-m-d-h-i-s-').rand(999,9999).'.'.$extention;
                $image_name = 'uploads/custom-images/'.$image_name;

                Image::make($image)
                        ->save(public_path().'/'.$image_name);
                $gallery = new ServiceImageGallery();
                $gallery->service_id = $request->service_id;
                $gallery->image = $image_name;
                $gallery->save();

                $notification = trans('admin_validation.Uploaded Successfully');
                $notification=array('messege'=>$notification,'alert-type'=>'success');
                return redirect()->back()->with($notification);
            }
        }else{
            $notification = trans('admin_validation.Something went wrong');
            $notification=array('messege'=>$notification,'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }
    }

    public function deleteImage($id){
        $gallery = ServiceImageGallery::find($id);
        $old_image = $gallery->image;
        $gallery->delete();
        if($old_image){
            if(File::exists(public_path().'/'.$old_image))unlink(public_path().'/'.$old_image);
        }

        $notification = trans('admin_validation.Delete Successfully');
        $notification = array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }

    public function video($id){
        $service = Service::find($id);
        if($service){
            $videos = Servicevideo::where('service_id', $id)->get();
            return view('admin.service_video', compact('service','videos'));
        }else{
            $notification = trans('admin_validation.Something went wrong');
            $notification=array('messege'=>$notification,'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }
    }

    public function storeVideo(Request $request){
        $rules = [
            'link' => 'required'
        ];
        $this->validate($request, $rules);

        $valid = preg_match("/^(https?\:\/\/)?(www\.)?(youtube\.com|youtu\.be)\/watch\?v\=\w+$/", $request->link);
        if ($valid) {
            $video = new Servicevideo();
            $video->service_id = $request->service_id;
            $video->video_link = $request->link;
            $video->save();
            $notification = trans('admin_validation.Created Successfully');
            $notification = array('messege'=>$notification,'alert-type'=>'success');
            return redirect()->back()->with($notification);
        } else {
            $notification = trans('admin_validation.Please provide your valid youtube url');
            $notification = array('messege'=>$notification,'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }
    }


    public function deleteVideo($id){
        $video = Servicevideo::find($id);
        $video->delete();
        $notification = trans('admin_validation.Delete Successfully');
        $notification = array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }

    public function faq($id){
        $service = Service::find($id);
        if($service){
            $faqs = ServiceFaq::where('service_id', $id)->get();
            return view('admin.service_faq', compact('service','faqs'));
        }else{
            $notification = trans('admin_validation.Something went wrong');
            $notification=array('messege'=>$notification,'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }
    }

    public function storeFaq(Request $request){
        $rules = [
            'question'=>'required',
            'answer'=>'required',
        ];
        $customMessages = [
            'question.required' => trans('admin_validation.Question is required'),
            'answer.required' => trans('admin_validation.Answer is required')
        ];
        $this->validate($request, $rules,$customMessages);

        $faq = new ServiceFaq();
        $faq->question = $request->question;
        $faq->answer = $request->answer;
        $faq->service_id = $request->service_id;
        $faq->save();

        $notification= trans('admin_validation.Created Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }

    public function updateFaq(Request $request, $id){
        $rules = [
            'question'=>'required',
            'answer'=>'required',
        ];
        $customMessages = [
            'question.required' => trans('admin_validation.Question is required'),
            'answer.required' => trans('admin_validation.Answer is required')
        ];
        $this->validate($request, $rules,$customMessages);

        $faq = ServiceFaq::find($id);
        $faq->question = $request->question;
        $faq->answer = $request->answer;
        $faq->service_id = $request->service_id;
        $faq->save();

        $notification= trans('admin_validation.Update Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }

    public function deleteFaq($id){
        $faq = ServiceFaq::find($id);
        $faq->delete();

        $notification= trans('admin_validation.Delete Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }
}
