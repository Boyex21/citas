<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HomePageOneVisibility;
use App\Models\HomepageContent;
use Cache;
use Image;
use File;
class HomepageVisibilityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(){
        $sections = HomePageOneVisibility::all();
        return view('admin.home_page_one_visibility', compact('sections'));
    }

    public function update(Request $request, $id){
        $rules = [
            'qty' => $request->status ? 'required' : '',
        ];
        $customMessages = [
            'qty.required' => trans('admin_validation.Quantity is required')
        ];
        $this->validate($request, $rules,$customMessages);

        $section = HomePageOneVisibility::find($id);
        $section->qty = $request->qty;
        $section->status = $request->status ? 1 : 0;
        $section->save();

        $sectionsVisibility = HomePageOneVisibility::all();
        Cache::put('sectionsVisibility', $sectionsVisibility);

        $notification= trans('admin_validation.Update Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }

    public function homepageContent(){
        $contents = HomepageContent::all();
        return view('admin.homepage_content', compact('contents'));
    }

    public function updateHomepageContent(Request $request, $id){
        $rules = [
            'title' => 'required',
            'description' => 'required'
        ];
        $customMessages = [
            'title.required' => trans('admin_validation.Title is required'),
            'description.required' => trans('admin_validation.Description is required'),
        ];
        $this->validate($request, $rules,$customMessages);

        $content = HomepageContent::find($id);
        $content->title = $request->title;
        $content->description = $request->description;
        $content->save();

        if($content->id == 5){
            if($request->image){
                $exist_banner = $content->image;
                $extention = $request->image->getClientOriginalExtension();
                $banner_name = 'subscribe'.date('-Y-m-d-h-i-s-').rand(999,9999).'.'.$extention;
                $banner_name = 'uploads/website-images/'.$banner_name;
                Image::make($request->image)
                    ->save(public_path().'/'.$banner_name);
                $content->image = $banner_name;
                $content->save();
                if($exist_banner){
                    if(File::exists(public_path().'/'.$exist_banner))unlink(public_path().'/'.$exist_banner);
                }
            }
        }

        $notification = trans('admin_validation.Update Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);

    }
}
