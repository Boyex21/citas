<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\BannerImage;
use App\Models\Message;
use App\Models\User;
use Auth;
class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:doctor');
    }

    public function index(){
        $doctor = Auth::guard('doctor')->user();
        $users = Appointment::with('user')->where('doctor_id',$doctor->id)->groupBy('user_id')->select('user_id')->get();
        $defaultProfile = BannerImage::whereId('15')->first();
        return view('doctor.message', compact('users','defaultProfile'));
    }

    public function loadChatBox($id){
        $defaultProfile = BannerImage::whereId('15')->first();
        $user = User::find($id);
        $user_id = $user->id;
        $doctor = Auth::guard('doctor')->user();
        $auth = $doctor;
        $my_id = $doctor->id;
        Message::where(['doctor_id' => $my_id,'user_id' => $user_id])->update(['doctor_view'=>1]);
        $messages = Message::where(['doctor_id' => $my_id,'user_id' => $user_id])->get();

        return view('doctor.chat_box', compact('user','auth','messages','defaultProfile'));
    }


    public function sendMessage(Request $request){

        $this->validate($request,[
            'user_id' => 'required',
            'message' => 'required'
        ]);

        $doctor = Auth::guard('doctor')->user();
        $message = new Message();
        $message->user_id = $request->user_id;
        $message->doctor_id = $doctor->id;
        $message->send_doctor = $doctor->id;
        $message->message = $request->message;
        $message->doctor_view = 1;
        $message->save();

        $defaultProfile = BannerImage::whereId('15')->first();
        $auth = $doctor;
        return view('doctor.single_message', compact('message', 'auth', 'defaultProfile'));
    }

    public function readAllMessage(){
        $doctor = Auth::guard('doctor')->user();
        $my_id = $doctor->id;
        Message::where(['doctor_id' => $my_id])->update(['doctor_view'=>1]);

        return back();
    }

    public function loadNewMessage(){
        return view('doctor.new_message');
    }
}
