<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Achievement;
use Cache;
class AchievementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $achievements = Achievement::all();
        return view('admin.achievement',compact('achievements'));
    }

    public function create()
    {
        return view('admin.create_achievement');
    }


    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|unique:achievements',
            'icon' => 'required',
            'qty' => 'required',
            'status' => 'required'
        ];
        $customMessages = [
            'title.required' => trans('admin_validation.Title is required'),
            'title.unique' => trans('admin_validation.Title already exist'),
            'icon.required' => trans('admin_validation.Icon is required'),
            'qty.required' => trans('admin_validation.Quantity is required'),
        ];
        $this->validate($request, $rules,$customMessages);

        $achievement = new Achievement();
        $achievement->title = $request->title;
        $achievement->icon = $request->icon;
        $achievement->qty = $request->qty;
        $achievement->status = $request->status;
        $achievement->save();

        $homepageAchievements = Achievement::where('status', 1)->get();
        Cache::put('homepageAchievements', $homepageAchievements);

        $notification = trans('admin_validation.Created Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->route('admin.achievement.index')->with($notification);
    }


    public function edit($id)
    {
        $achievement = Achievement::find($id);
        return view('admin.edit_achievement',compact('achievement'));
    }


    public function update(Request $request, $id)
    {
        $achievement = Achievement::find($id);
        $rules = [
            'title' => 'required|unique:achievements,title,'.$achievement->id,
            'icon' => 'required',
            'qty' => 'required',
            'status' => 'required'
        ];
        $customMessages = [
            'title.required' => trans('admin_validation.Title is required'),
            'title.unique' => trans('admin_validation.Title already exist'),
            'icon.required' => trans('admin_validation.Icon is required'),
            'qty.required' => trans('admin_validation.Quantity is required'),
        ];
        $this->validate($request, $rules,$customMessages);

        $achievement->title = $request->title;
        $achievement->icon = $request->icon;
        $achievement->qty = $request->qty;
        $achievement->status = $request->status;
        $achievement->save();

        $homepageAchievements = Achievement::where('status', 1)->get();
        Cache::put('homepageAchievements', $homepageAchievements);

        $notification = trans('admin_validation.Update Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->route('admin.achievement.index')->with($notification);
    }


    public function destroy($id)
    {
        $achievement = Achievement::find($id);
        $achievement->delete();

        $homepageAchievements = Achievement::where('status', 1)->get();
        Cache::put('homepageAchievements', $homepageAchievements);

        $notification = trans('admin_validation.Delete Successfully');
        $notification = array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->route('admin.achievement.index')->with($notification);
    }

    public function changeStatus($id){
        $achievement = Achievement::find($id);
        if($achievement->status == 1){
            $achievement->status = 0;
            $achievement->save();
            $message = trans('admin_validation.Inactive Successfully');
        }else{
            $achievement->status = 1;
            $achievement->save();
            $message = trans('admin_validation.Active Successfully');
        }
        $homepageAchievements = Achievement::where('status', 1)->get();
        Cache::put('homepageAchievements', $homepageAchievements);

        return response()->json($message);
    }
}
