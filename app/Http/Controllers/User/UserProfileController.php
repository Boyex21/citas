<?php

namespace App\Http\Controllers\User;

use App\Models\Day;
use App\Models\File as DocumentFile;
use App\Models\Leave;
use App\Models\Doctor;
use App\Models\Setting;
use App\Models\Chamber;
use App\Models\Document;
use App\Models\Schedule;
use App\Models\Appointment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Image;
use Auth;
use File;
use Hash;
use Str;

class UserProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function dashboard(){
        $setting=Setting::first();
        $user=Auth::guard('web')->user();
        $appointments=Appointment::orderBy('id', 'DESC')->where('user_id', $user->id)->get();
        return view('user.dashboard', compact('setting', 'user', 'appointments'));
    }

    public function appointment(){
        $setting=Setting::first();
        Paginator::useBootstrap();
        $user=Auth::guard('web')->user();
        $appointments=Appointment::orderBy('id', 'DESC')->where('user_id', $user->id)->paginate(10);
        return view('user.appointment', compact('setting', 'user', 'appointments'));
    }

    public function createAppointment(){
        $days=Day::all();
        $setting=Setting::first();
        $user=Auth::guard('web')->user();
        $doctors=Doctor::orderBy('id', 'DESC')->get();
        return view('user.create_appointment', compact('setting', 'user', 'doctors', 'days'));
    }

    public function getChamber(Request $request){
        if($request->doctor){
            $doctor=Doctor::where('id', $request->doctor)->first();
            $chambers=Chamber::where(['doctor_id' => $doctor->id, 'status' => 1])->get();

            $response="<option>Seleccione</option>";
            foreach($chambers as $chamber){
                $response.='<option value="'.$chamber->id.'">'.$chamber->name.'</option>';
            }

            return response()->json(['status' => 1, 'chambers' => $response]);
        }else{
            $notification='El doctor es obligatorio';
            return response()->json(['status' => 0, 'message' => $notification]);
        }
    }

    public function getSchedule(Request $request){
        if($request->date){
            $doctor=Doctor::where('id', $request->doctor)->first();
            $leave=Leave::where(['doctor_id' => $doctor->id,'date' => $request->date])->count();

            if($leave==1){
                $response="<option>Seleccione</option>";
                return response()->json(['status' => 1, 'schedules' => $response, 'scheduleQty' => 0]);
            }

            $day=Day::where('id',$request->day)->first();
            $schedules=Schedule::where(['doctor_id' => $doctor->id, 'day_id' => $day->id, 'status' => 1, 'chamber_id' => $request->chamber])->get();

            $response="<option>Seleccione</option>";
            foreach($schedules as $schedule){
                $checkQty=Appointment::where('doctor_id', $doctor->id)->where('date', $request->date)->where('schedule_id' , $schedule->id)->count();
                $exist=$schedule->appointment_limit-$checkQty;
                $exist=$exist.' Citas';

                $start_time=date('h:i A', strtotime($schedule->start_time));
                $end_time=date('h:i A', strtotime($schedule->end_time));
                $response.='<option value="'.$schedule->id.'">'.$start_time.'-'.$end_time.' - ('.$exist.')</option>';
            }
            $scheduleQty=$schedules->count();

            return response()->json(['status' => 1, 'schedules' => $response, 'scheduleQty' => $scheduleQty]);
        }else{
            $notification='La fecha es obligatoria';
            return response()->json(['status' => 0, 'message' => $notification]);
        }
    }

    public function scheduleAvaibility(Request $request){
        if($request->schedule){
            $doctor=Doctor::where('id', $request->doctor)->first();
            $schedule=Schedule::find($request->schedule);
            $todayAppointmentQty=Appointment::where('doctor_id', $doctor->id)->where('date', $request->date)->where('schedule_id' , $schedule->id)->count();
            if($todayAppointmentQty<$schedule->appointment_limit){
                return response()->json(['status' => 1]);
            }else{
                $notification='Hoy no se puede hacer ninguna cita en este horario';
                return response()->json(['status' => 0, 'message' => $notification]);
            }
        }else{
            $notification='El horario es obligatorio';
            return response()->json(['status' => 0, 'message' => $notification]);
        }
    }

    public function storeAppointment(Request $request){
        $user=Auth::guard('web')->user();
        $doctor=Doctor::where('id', $request->doctor)->first();
        $day=Day::where('id',$request->day)->first();
        $schedules=Schedule::where(['doctor_id' => $doctor->id, 'day_id' => $day->id])->get();
        $schedule=Schedule::find($request->schedule);
        $todayAppointmentQty=Appointment::where('doctor_id', $doctor->id)->where('date', $request->date)->where('schedule_id' , $schedule->id)->count();
        if($todayAppointmentQty<$schedule->appointment_limit) {
            $appointment=new Appointment();
            $appointment->doctor_id=$doctor->id;
            $appointment->user_id=$user->id;
            $appointment->day_id=$schedule->day_id;
            $appointment->schedule_id=$schedule->id;
            $appointment->chamber_id=$schedule->chamber_id;
            $appointment->date=$request->date;
            $appointment->consultation_type=$request->consultation_type;
            $appointment->already_treated=0;
            $appointment->status=0;
            $appointment->save();

            $notification='Registro Exitoso';
            $notification=array('messege' => $notification, 'alert-type' => 'success');
            return redirect()->back()->with($notification);
        }else{
            $notification='Hoy no se puede hacer ninguna cita';
            $notification=array('messege' => $notification, 'alert-type' => 'error');
            return redirect()->back()->with($notification);
        }
    }

    public function showAppointment($id){
        $setting=Setting::first();
        $user=Auth::guard('web')->user();
        $appointment=Appointment::where('id', $id)->where('user_id', $user->id)->firstOrFail();
        $doctor=Doctor::where('id', $appointment->doctor_id)->first();

        if($appointment->already_treated==0){
            $notification='Ha ocurrido un error, intentelo nuevamente.';
            $notification=array('messege' => $notification, 'alert-type' => 'error');
            return redirect()->route('user.appointment')->with($notification);
        }

        return view('user.show_appointment', compact('setting', 'user', 'appointment', 'doctor'));
    }


// FUNCION EXTRA PARA EL USUARIO PACIENTE === INICIO

    public function documents(){
        $setting=Setting::first();
        Paginator::useBootstrap();
        $user=Auth::guard('web')->user();
        $documents=Document::with(['files'])->orderBy('id', 'DESC')->where('user_id', $user->id)->paginate(10);
        return view('user.documents', compact('setting', 'user', 'documents'));
    }

    public function createDocument(){
        $setting=Setting::first();
        $user=Auth::guard('web')->user();
        // $doctors=Doctor::select('doctors.*', 'appointments.doctor_id', 'appointments.user_id', 'users.id as user')->join('appointments', 'doctors.id', 'appointments.doctor_id')->join('users', 'appointments.user_id', 'users.id')->groupBy('doctors.id')->get();
        
        $doctors=Doctor::select('doctors.*', 'appointments.doctor_id', 'appointments.user_id', 'users.id as user')->join('appointments', 'doctors.id', 'appointments.doctor_id')->join('users', 'appointments.user_id', 'users.id')->where('users.id', $user->id)->groupBy('doctors.id')->get();
        return view('user.create_document', compact('setting', 'user', 'doctors'));
    }

    public function storeDocument(Request $request){
        $user=Auth::guard('web')->user();
        $rules=[
            'doctor' => 'required',
            'description' => 'required',
            'files' => 'required|array',
            'files.*' => 'required'
        ];
        $this->validate($request, $rules);

        $document=new Document();
        $document->description=$request->description;
        $document->user_id=$user->id;
        $document->doctor_id=$request->doctor;
        $document->save();

        if ($request->has('files')) {
            foreach (request('files') as $file) {
                DocumentFile::create(['file' => $file, 'document_id' => $document->id])->save();
            }
        }

        $notification='Registro exitoso';
        $notification=array('messege' => $notification, 'alert-type' => 'success');
        return redirect()->back()->with($notification);
    }

    public function showDocument($id){
        $setting=Setting::first();
        $user=Auth::guard('web')->user();
        $document=Document::with(['files'])->where('id', $id)->where('user_id', $user->id)->firstOrFail();
        return view('user.show_document', compact('setting', 'user', 'document'));
    }



    public function fileStore(Request $request) {
        if ($request->hasFile('file')) {
            $file=$request->file('file');
            $name=time().'_'.Str::slug($file->getClientOriginalName(), "-").".".$file->getClientOriginalExtension();
            $file->move(public_path().'/uploads/documents/', $name);
            
            return response()->json(['status' => true, 'name' => $name]);
        }

        return response()->json(['status' => false]);
    }

    public function fileEdit(Request $request) {
        $document=Document::where('id', request('id'))->first();
        if (!is_null($document)) {
            if ($request->hasFile('file')) {
                $file=$request->file('file');
                $name=time().'_'.$document->id.".".$file->getClientOriginalExtension();
                $file->move(public_path().'/uploads/documents/', $name);

                $file=DocumentFile::create(['document_id' => $document->id, 'file' => $name]);
                if ($file) {
                    return response()->json(['status' => true, 'name' => $name, 'id' => $document->id]);
                }
            }
        }

        return response()->json(['status' => false]);
    }

    public function fileDestroy(Request $request) {
        $document=Document::where('id', request('id'))->first();
        if (!is_null($document)) {
            $file=DocumentFile::where('document_id', $document->id)->where('file', request('url'))->first();
            if (!is_null($file)) {
                $file->delete();

                if ($file) {
                    if (file_exists(public_path().'/uploads/documents/'.request('url'))) {
                        unlink(public_path().'/uploads/documents/'.request('url'));
                    }

                    return response()->json(['status' => true]);
                }
            }
        }

        return response()->json(['status' => false]);
    }

    public function editDocument($id){
        $setting=Setting::first();
        $user=Auth::guard('web')->user();
        $document=Document::where('id', $id)->firstOrFail();
        // $doctors=Doctor::select('doctors.*', 'appointments.doctor_id', 'appointments.user_id', 'users.id as user')->join('appointments', 'doctors.id', 'appointments.doctor_id')->join('users', 'appointments.user_id', 'users.id')->groupBy('doctors.id')->get();
        $doctors=Doctor::select('doctors.*', 'appointments.doctor_id', 'appointments.user_id', 'users.id as user')->join('appointments', 'doctors.id', 'appointments.doctor_id')->join('users', 'appointments.user_id', 'users.id')->where('users.id', $user->id)->groupBy('doctors.id')->get();
        return view('user.edit_document', compact('setting', 'user', 'document', 'doctors'));
    }

    public function updateDocument(Request $request, $id){
        $user=Auth::guard('web')->user();
        $rules=[
            'doctor' => 'required',
            'description' => 'required'
        ];
        $this->validate($request, $rules);

        $document=Document::where('user_id', $user->id)->where('id', $id)->first();
        $document->description=$request->description;
        $document->doctor_id=$request->doctor;
        $document->save();
        
        $notification='Edición Exitosa';
        $notification=array('messege' => $notification, 'alert-type' => 'success');
        return redirect()->route('user.documents.index', $id)->with($notification);
    }

    public function deleteDocument($id){
        $user=Auth::guard('web')->user();
        $document=Document::where('user_id', $user->id)->where('id', $id)->first();
        DocumentFile::where('document_id', $document->id)->delete();
        $document->delete();

        $notification='Eliminación Exitosa';
        $notification=array('messege' => $notification, 'alert-type' => 'success');
        return redirect()->route('user.documents.index')->with($notification);
    }


// FUNCION EXTRA PARA EL USUARIO



    public function myProfile(){
        $setting=Setting::first();
        $user=Auth::guard('web')->user();
        return view('user.my_profile', compact('setting', 'user'));
    }

    public function updateProfile(Request $request){
        $user=Auth::guard('web')->user();
        $rules=[
            'name' => 'required',
            'email' => 'required|unique:users,email,'.$user->id,
            'address' => 'required',
            'phone' => 'required',
            'age' => 'required',
            'weight' => 'required',
            'gender' => 'required',
        ];
        $this->validate($request, $rules);

        $user->name=$request->name;
        $user->phone=$request->phone;
        $user->address=$request->address;
        $user->age=$request->age;
        $user->weight=$request->weight;
        $user->gender=$request->gender;
        $user->patient_id=$request->cedula;
        $user->fillup=1;
        $user->save();

        if($request->file('image')){
            $old_image=$user->image;
            $user_image=$request->image;
            $extention=$user_image->getClientOriginalExtension();
            $image_name= Str::slug($request->name).date('-Y-m-d-h-i-s-').rand(999,9999).'.'.$extention;
            $image_name='uploads/custom-images/'.$image_name;

            Image::make($user_image)->save(public_path().'/'.$image_name);

            $user->image=$image_name;
            $user->save();
            if($old_image){
                if(File::exists(public_path().'/'.$old_image))unlink(public_path().'/'.$old_image);
            }
        }

        $notification='Actualización exitosa';
        $notification=array('messege' => $notification, 'alert-type' => 'success');
        return redirect()->back()->with($notification);
    }

    public function changePassword(){
        $setting=Setting::first();
        $user=Auth::guard('web')->user();
        return view('user.change_password', compact('setting', 'user'));
    }

    public function updatePassword(Request $request){
        $rules=[
            'current_password' => 'required',
            'password' => 'required|min:4|confirmed'
        ];
        $this->validate($request, $rules);

        $user=Auth::guard('web')->user();
        if(Hash::check($request->current_password, $user->password)){
            $user->password=Hash::make($request->password);
            $user->save();
            $notification='Cambio de contraseña exitoso';
            $notification=array('messege' => $notification, 'alert-type' => 'success');
            return redirect()->back()->with($notification);
        }else{
            $notification='La contraseña actual no coincide';
            $notification=array('messege' => $notification, 'alert-type' => 'error');
            return redirect()->back()->with($notification);
        }
    }
}