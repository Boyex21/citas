<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Team;
use File;
use Image;
use Str;
class TeamController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $teams = Team::all();
        return view('admin.team',compact('teams'));
    }

    public function create()
    {
        return view('admin.create_team');
    }


    public function store(Request $request)
    {
        $rules = [
            'image' => 'required',
            'status' => 'required',
        ];

        $customMessages = [
            'image.required' => trans('admin_validation.Image is required'),
        ];
        $this->validate($request, $rules,$customMessages);

        $team = new Team();
        if($request->image){
            $extention = $request->image->getClientOriginalExtension();
            $image_name = 'partner-'.date('Ymdhis').'.'.$extention;
            $image_name = 'uploads/custom-images/'.$image_name;
            Image::make($request->image)
                ->save(public_path().'/'.$image_name);
        }
        $team->link = $request->link;
        $team->image = $image_name;
        $team->status = $request->status;
        $team->save();

        $notification = trans('admin_validation.Created Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->route('admin.our-partner.index')->with($notification);
    }


    public function edit($id)
    {
        $team = Team::find($id);
        return view('admin.edit_team',compact('team'));
    }


    public function update(Request $request, $id)
    {
        $team = Team::find($id);


        if($request->image){
            $existing_image = $team->image;
            $extention = $request->image->getClientOriginalExtension();
            $image_name = 'Partner-'.date('Ymdhis').'.'.$extention;
            $image_name = 'uploads/custom-images/'.$image_name;
            Image::make($request->image)
                    ->save(public_path().'/'.$image_name);
            $team->image= $image_name;
            $team->save();
            if($existing_image){
                if(File::exists(public_path().'/'.$existing_image))unlink(public_path().'/'.$existing_image);
            }

        }

        $team->link = $request->link;
        $team->status = $request->status;
        $team->save();

        $notification = trans('admin_validation.Update Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->route('admin.our-partner.index')->with($notification);
    }


    public function destroy($id)
    {
        $team = Team::find($id);
        $existing_image = $team->image;
        $team->delete();
        if($existing_image){
            if(File::exists(public_path().'/'.$existing_image))unlink(public_path().'/'.$existing_image);
        }

        $notification = trans('admin_validation.Delete Successfully');
        $notification = array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->route('admin.our-partner.index')->with($notification);
    }

    public function changeStatus($id){
        $item = Team::find($id);
        if($item->status == 1){
            $item->status = 0;
            $item->save();
            $message = trans('admin_validation.Inactive Successfully');
        }else{
            $item->status = 1;
            $item->save();
            $message = trans('admin_validation.Active Successfully');
        }
        return response()->json($message);
    }
}
