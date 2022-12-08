<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Feature;
use Cache;
class FeatureController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $features = Feature::all();
        return view('admin.feature',compact('features'));
    }

    public function create()
    {
        return view('admin.create_feature');
    }


    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|unique:features',
            'icon' => 'required',
            'description' => 'required',
            'status' => 'required'
        ];
        $customMessages = [
            'title.required' => trans('admin_validation.Title is required'),
            'title.unique' => trans('admin_validation.Title already exist'),
            'icon.required' => trans('admin_validation.Icon is required'),
            'description.required' => trans('admin_validation.Description is required'),
        ];
        $this->validate($request, $rules,$customMessages);

        $feature = new Feature();
        $feature->title = $request->title;
        $feature->icon = $request->icon;
        $feature->description = $request->description;
        $feature->status = $request->status;
        $feature->save();

        $homepageFeatures = Feature::where('status', 1)->get();
        Cache::put('homepageFeatures', $homepageFeatures);

        $notification = trans('admin_validation.Created Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->route('admin.feature.index')->with($notification);
    }


    public function edit($id)
    {
        $feature = Feature::find($id);
        return view('admin.edit_feature',compact('feature'));
    }


    public function update(Request $request, $id)
    {
        $feature = Feature::find($id);
        $rules = [
            'title' => 'required|unique:features,title,'.$feature->id,
            'icon' => 'required',
            'description' => 'required',
            'status' => 'required'
        ];
        $customMessages = [
            'title.required' => trans('admin_validation.Title is required'),
            'title.unique' => trans('admin_validation.Title already exist'),
            'icon.required' => trans('admin_validation.Icon is required'),
            'description.required' => trans('admin_validation.Description is required'),
        ];
        $this->validate($request, $rules,$customMessages);

        $feature->title = $request->title;
        $feature->icon = $request->icon;
        $feature->description = $request->description;
        $feature->status = $request->status;
        $feature->save();

        $homepageFeatures = Feature::where('status', 1)->get();
        Cache::put('homepageFeatures', $homepageFeatures);

        $notification = trans('admin_validation.Update Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->route('admin.feature.index')->with($notification);
    }


    public function destroy($id)
    {
        $feature = Feature::find($id);
        $feature->delete();

        $homepageFeatures = Feature::where('status', 1)->get();
        Cache::put('homepageFeatures', $homepageFeatures);

        $notification = trans('admin_validation.Delete Successfully');
        $notification = array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->route('admin.feature.index')->with($notification);
    }

    public function changeStatus($id){
        $feature = Feature::find($id);
        if($feature->status == 1){
            $feature->status = 0;
            $feature->save();
            $message = trans('admin_validation.Inactive Successfully');
        }else{
            $feature->status = 1;
            $feature->save();
            $message = trans('admin_validation.Active Successfully');
        }
        $homepageFeatures = Feature::where('status', 1)->get();
        Cache::put('homepageFeatures', $homepageFeatures);
        return response()->json($message);
    }
}
