<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ZoomCredential;
use Auth;
class ZoomCredentialController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:doctor');
    }


    public function index(){
        $doctor = Auth::guard('doctor')->user();
        $credential = ZoomCredential::where('doctor_id',$doctor->id)->first();

        return view('doctor.zoom_credential', compact('credential'));
    }

    public function store(Request $request){
        $rules = [
            'api_key' => 'required',
            'api_secret' => 'required',
        ];
        $customMessages = [
            'api_key.required' => trans('user_validation.Api key is required'),
            'api_secret.required' => trans('user_validation.Api secret is required'),
        ];
        $this->validate($request, $rules,$customMessages);

        $doctor = Auth::guard('doctor')->user();
        $credential = ZoomCredential::where('doctor_id',$doctor->id)->first();

        if($credential){
            $credential->zoom_api_key = $request->api_key;
            $credential->zoom_api_secret = $request->api_secret;
            $credential->status = $request->status ? 1 : 0;
            $credential->save();

            $notification = trans('user_validation.Update Successfully');
            $notification = array('messege'=>$notification,'alert-type'=>'success');
            return redirect()->back()->with($notification);
        }else{
            $credential = new ZoomCredential();
            $credential->doctor_id = $doctor->id;
            $credential->zoom_api_key = $request->api_key;
            $credential->zoom_api_secret = $request->api_secret;
            $credential->status = $request->status ? 1 : 0;
            $credential->save();

            $notification = trans('user_validation.Create Successfully');
            $notification = array('messege'=>$notification,'alert-type'=>'success');
            return redirect()->back()->with($notification);
        }


    }
}
