<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Appointment;
use App\Models\DoctorReview;
use App\Models\AppointmentOrder;
use App\Models\PrescriptionMedicine;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Image;
use Mail;
use File;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(){
        $customers=User::where('status', 1)->orderBy('id', 'DESC')->get();
        return view('admin.customer', compact('customers'));
    }

    public function pendingCustomerList(){
        $customers=User::where('status', 0)->orderBy('id', 'DESC')->get();
        return view('admin.customer', compact('customers'));
    }

    public function show($id){
        $customer=User::find($id);
        if($customer){
            return view('admin.show_customer', compact('customer'));
        }

        $notification='Ha ocurrido un error, intentelo nuevamente';
        $notification=array('messege' => $notification, 'alert-type' => 'error');
        return redirect()->route('admin.customer-list')->with($notification);
    }

    public function destroy($id)
    {
        $user=User::find($id);
        DoctorReview::where('user_id', $user->id)->delete();
        AppointmentOrder::where('user_id', $user->id)->delete();
        $appointments=Appointment::where('user_id', $user->id)->get();
        foreach($appointments as $appointment){
            PrescriptionMedicine::where('appointment_id', $appointment->id)->delete();
            $appointment->delete();
        }

        $user_image=$user->image;
        $user->delete();
        if($user_image){
            if(File::exists(public_path().'/'.$user_image)){
                unlink(public_path().'/'.$user_image);
            }
        }

        $notification='Eliminación Exitosa';
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }

    public function changeStatus($id){
        $customer=User::find($id);
        if($customer->status==1){
            $customer->status=0;
            $customer->save();
            $message='Desactivado Exitosamente';
        }else{
            $customer->status=1;
            $customer->save();
            $message='Activado Exitosamente';
        }
        return response()->json($message);
    }
}
