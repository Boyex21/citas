<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\BannerImage;
use App\Models\Message;
use App\Models\User;
use App\Models\banner;
use App\Models\BreadcrumbImage;
use App\Models\Doctor;
use Auth;
use App\Events\UserToExpert;
use App\Providers\PusherConfig;
use Pusher;

class UserMessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function index(){
        $user = Auth::guard('web')->user();
        $doctors = Appointment::with('doctor')->where('user_id',$user->id)->groupBy('doctor_id')->select('doctor_id')->get();
        $defaultProfile = BannerImage::whereId('15')->first();
        $banner = BreadcrumbImage::where(['id' => 9])->first();

        return view('user.message', compact('banner', 'doctors', 'user', 'defaultProfile'));
    }

    public function loadChatBox($id){
        $doctor = Doctor::where('id', $id)->first();
        $doctor_id = $doctor->id;
        $user = Auth::guard('web')->user();
        Message::where(['user_id' => $user->id, 'doctor_id' => $doctor_id])->update(['user_view'=>1]);
        $messages = Message::where(['user_id' => $user->id, 'doctor_id' => $doctor_id])->get();
        $defaultProfile = BannerImage::whereId('15')->first();
        $auth = $user;

        return view('user.chat_box', compact('messages', 'defaultProfile', 'doctor', 'auth' ));
    }

    public function sendMessage(Request $request){

        $this->validate($request,[
            'doctor_id' => 'required',
            'message' => 'required'
        ]);

        $auth = Auth::guard('web')->user();
        $message = new Message();
        $message->user_id = $auth->id;
        $message->doctor_id = $request->doctor_id;
        $message->send_user = $auth->id;
        $message->message = $request->message;
        $message->user_view = 1;
        $message->save();

        $defaultProfile = BannerImage::whereId('15')->first();


        $data = ['user_id' => $auth->id, 'doctor_id' => $request->doctor_id];
        $doctor = Doctor::find($request->doctor_id);
        event(new UserToExpert($doctor, $data));

        return view('user.chat_message_list', compact('auth','message','defaultProfile'));
    }
}
