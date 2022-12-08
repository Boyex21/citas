<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ZoomMeeting;
use App\Models\ZoomCredential;
use App\Traits\ZoomMeetingTrait;
use App\Models\Appointment;
use App\Models\EmailTemplate;
use App\Models\MeetingHistory;
use App\Models\User;
use App\Models\Order;
use App\Mail\SendZoomMeetingLink;
use App\Helpers\MailHelper;
use DateTime;
use DateTimeZone;
use Carbon\Carbon;
use Auth;
use Mail;
class MeetingController extends Controller
{
    use ZoomMeetingTrait;

    const MEETING_TYPE_INSTANT = 1;
    const MEETING_TYPE_SCHEDULE = 2;
    const MEETING_TYPE_RECURRING = 3;
    const MEETING_TYPE_FIXED_RECURRING_FIXED = 8;

    public function __construct()
    {
        $this->middleware('auth:doctor');
    }


    public function index(){
        $doctor=Auth::guard('doctor')->user();
        $meetings = ZoomMeeting::where('doctor_id',$doctor->id)->orderBy('start_time','desc')->get();

        return view('doctor.zoom_meeting',compact('meetings'));
    }


    public function createForm(){
        $doctor = Auth::guard('doctor')->user();
        $appointments = Appointment::where('doctor_id',$doctor->id)->select('user_id')->groupBy('user_id')->get();
        $patients = $appointments;
        $users = User::whereIn('id',$patients)->get();
        $activeOrder = Order::where('doctor_id', $doctor->id)->where('status', 1)->first();
        $isShow = true;

        if ($activeOrder) {
            if($activeOrder->expired_date){
                if(date('Y-m-d') > $activeOrder->expired_date)  $isShow = false;
            }

        }else $isShow = false;

        if(!$isShow){
            $notification= trans('user_validation.Your subscription has expired. Please renew your subscription plan');
            $notification=array('messege'=>$notification,'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }

        return view('doctor.create_zoom_meeting',compact('patients','users'));
    }

    public function store(Request $request)
    {
        $rules = [
            'topic'=>'required',
            'patient'=>'required',
            'start_time'=>'required',
            'duration'=>'required|numeric',
        ];

        $customMessages = [
            'topic.required' => trans('user_validation.Topic is required'),
            'patient.required' => trans('user_validation.Patient is required'),
            'start_time.required' => trans('user_validation.Start time is required'),
            'duration.required' => trans('user_validation.Duration is required'),
        ];

        $this->validate($request, $rules, $customMessages);

        $doctor = Auth::guard('doctor')->user();
        $data = array();
        $data['start_time'] = $request->start_time;
        $data['topic'] = $request->topic;
        $data['duration'] = $request->duration;
        $data['agenda'] = $doctor->name;
        $data['host_video'] = 1;
        $data['participant_video'] = 1;
        $response = $this->create($data);

        if($response['success']){
            $meeting = new ZoomMeeting();
            $meeting->doctor_id = $doctor->id;
            $meeting->start_time = date('Y-m-d H:i:s',strtotime($response['data']['start_time'])) ;
            $meeting->topic = $request->topic;
            $meeting->duration = $request->duration;
            $meeting->meeting_id = $response['data']['id'];
            $meeting->password = $response['data']['password'];
            $meeting->join_url = $response['data']['join_url'];
            $meeting->save();

            $user = User::where('id',$request->patient)->first();
            $meeting_link = $response['data']['join_url'];

            $history = new MeetingHistory();
            $history->doctor_id = $doctor->id;
            $history->user_id = $user->id;
            $history->meeting_id = $meeting->meeting_id;
            $history->meeting_time = date('Y-m-d H:i:s',strtotime($meeting->start_time));
            $history->duration = $meeting->duration;
            $history->save();

            // send email
            $template = EmailTemplate::where('id',10)->first();
            $message = $template->description;
            $subject = $template->subject;
            $message = str_replace('{{patient_name}}',$user->name,$message);
            $message = str_replace('{{doctor_name}}',$doctor->name,$message);
            $message = str_replace('{{meeting_schedule}}',date('Y-m-d h:i:A',strtotime($meeting->start_time)),$message);
            MailHelper::setMailConfig();
            Mail::to($user->email)->send(new SendZoomMeetingLink($subject,$message,$meeting_link));

            $notification = trans('user_validation.Created Successfully');
            $notification = array('messege'=>$notification,'alert-type'=>'success');
            return redirect()->route('doctor.zoom-meeting')->with($notification);
        }else{

            $notification = trans('user_validation.Something Went Wrong');
            $notification = array('messege'=>$notification,'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }

    }

    public function editForm($id){
        $doctor = Auth::guard('doctor')->user();

        $activeOrder = Order::where('doctor_id', $doctor->id)->where('status', 1)->first();
        $isShow = true;
        if ($activeOrder) {
            if(date('Y-m-d') > $activeOrder->expired_date)  $isShow = false;
        }else $isShow = false;

        if(!$isShow){
            $notification= trans('user_validation.Your subscription has expired. Please renew your subscription plan');
            $notification=array('messege'=>$notification,'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }

        $meeting = ZoomMeeting::where(['id' => $id, 'doctor_id' => $doctor->id])->first();
        if($meeting){
            $appointments = Appointment::where('doctor_id',$doctor->id)->select('user_id')->groupBy('user_id')->get();
            $patients = $appointments;
            $users = User::whereIn('id',$patients)->get();
            return view('doctor.edit_zoom_meeting',compact('meeting','users'));
        }else{
            $notification = trans('user_validation.Something Went Wrong');
            $notification = array('messege'=>$notification,'alert-type'=>'error');
            return redirect()->route('doctor.zoom-meeting')->with($notification);
        }

    }
    public function updateMeeting($id, Request $request)
    {

        $rules = [
            'patient'=>'required',
            'topic'=>'required',
            'start_time'=>'required',
            'duration'=>'required|numeric',
        ];

        $customMessages = [
            'patient.required' => trans('user_validation.Patient is required'),
            'topic.required' => trans('user_validation.Topic is required'),
            'start_time.required' => trans('user_validation.Start time is required'),
            'duration.required' => trans('user_validation.Duration is required'),
        ];

        $this->validate($request, $rules, $customMessages);

        $doctor = Auth::guard('doctor')->user();
        $data = array();
        $data['start_time'] = $request->start_time;
        $data['topic'] = $request->topic;
        $data['duration'] = $request->duration;
        $data['agenda'] = $doctor->name;
        $data['host_video'] = 1;
        $data['participant_video'] = 1;

        $response=$this->update($id, $data);

        if($response['success']){
            $success = $response['data'];
            $meeting = ZoomMeeting::where('meeting_id',$id)->first();
            $meeting->doctor_id = $doctor->id;
            $meeting->start_time = date('Y-m-d H:i:s',strtotime($success['data']['start_time']));
            $meeting->topic = $request->topic;
            $meeting->duration = $request->duration;
            $meeting->meeting_id = $success['data']['id'];
            $meeting->password = $success['data']['password'];
            $meeting->join_url = $success['data']['join_url'];
            $meeting->save();

            $user = User::where('id',$request->patient)->first();
            $meeting_link = $success['data']['join_url'];
            $history = new MeetingHistory();
            $history->doctor_id = $doctor->id;
            $history->user_id = $user->id;
            $history->meeting_id = $meeting->meeting_id;
            $history->meeting_time = date('Y-m-d H:i:s',strtotime($meeting->start_time));
            $history->duration = $meeting->duration;
            $history->save();
            // send email
            $template = EmailTemplate::where('id',10)->first();
            $message = $template->description;
            $subject = $template->subject;
            $message = str_replace('{{patient_name}}',$user->name,$message);
            $message = str_replace('{{doctor_name}}',$doctor->name,$message);
            $message = str_replace('{{meeting_schedule}}',date('Y-m-d h:i:A',strtotime($meeting->start_time)),$message);
            MailHelper::setMailConfig();
            Mail::to($user->email)->send(new SendZoomMeetingLink($subject,$message,$meeting_link));


            $notification = trans('user_validation.Update Successfully');
            $notification = array('messege'=>$notification,'alert-type'=>'success');
            return redirect()->route('doctor.zoom-meeting')->with($notification);
        }else{

            $notification = trans('user_validation.Something Went Wrong');
            $notification=array('messege'=>$notification,'alert-type'=>'error');
            return redirect()->route('doctor.zoom-meetings')->with($notification);
        }
    }

    public function destroy($id)
    {
        $meeting = ZoomMeeting::find($id);
        $response = $this->delete($meeting->meeting_id);
        if($response['success']){

            MeetingHistory::where('meeting_id',$meeting->meeting_id)->delete();
            $meeting_id = $meeting->meeting_id;

            ZoomMeeting::where('meeting_id',$meeting_id)->delete();

            $notification = trans('user_validation.Delete Successfully');
            $notification = array('messege'=>$notification,'alert-type'=>'success');
            return redirect()->route('doctor.zoom-meeting')->with($notification);
        }else{
            $notification = trans('user_validation.Something Went Wrong');
            $notification = array('messege'=>$notification,'alert-type'=>'error');
            return redirect()->route('doctor.zoom-meeting')->with($notification);
        }
    }

    public function meetingHistory(){
        $doctor = Auth::guard('doctor')->user();
        $histories = MeetingHistory::where('doctor_id',$doctor->id)->orderBy('meeting_time','desc')->get();
        return view('doctor.meeting_history',compact('histories'));
    }

    public function upCommingMeeting(){
        $doctor = Auth::guard('doctor')->user();
        $histories = MeetingHistory::where('doctor_id',$doctor->id)->orderBy('meeting_time','desc')->get();
        return view('doctor.upcomming_zoom_meeting',compact('histories'));
    }
}
