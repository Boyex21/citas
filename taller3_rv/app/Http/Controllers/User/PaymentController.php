<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BreadcrumbImage;
use Auth;
use App\Models\Setting;
use App\Models\StripePayment;
use App\Models\BankPayment;
use App\Models\PaypalPayment;
use App\Models\RazorpayPayment;
use App\Models\Flutterwave;
use App\Models\PaystackAndMollie;
use App\Models\InstamojoPayment;
use App\Models\Doctor;
use App\Models\DoctorPaypal;
use App\Models\DoctorStripe;
use App\Models\DoctorRazorpay;
use App\Models\DoctorFlutterwave;
use App\Models\DoctorBankPayment;
use App\Models\DoctorMollie;
use App\Models\DoctorPaystack;
use App\Models\DoctorInstamojo;
use App\Models\CurrencyCountry;
use App\Models\Currency;
use App\Models\AppointmentOrder;
use App\Models\Appointment;
use App\Models\Schedule;
use App\Mail\AppointmentNotification;
use App\Models\Product;
use App\Mail\OrderSuccessfully;
use App\Helpers\MailHelper;
use App\Models\EmailTemplate;
use Mail;
Use Stripe;
use Cart;
use Session;
use Str;
use Razorpay\Api\Api;
use Exception;
use Redirect;
use Carbon\Carbon;
use Mollie\Laravel\Facades\Mollie;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }
    public function payment(){
        $banner = BreadcrumbImage::where(['id' => 15])->first();
        $appointment = Session::get('appointment');
        if(!$appointment){
            $notification = trans('user_validation.Your appointment list is empty');
            $notification = array('messege'=>$notification,'alert-type'=>'error');
            return redirect()->route('our-experts')->with($notification);
        }
        $setting = Setting::first();
        $stripe = StripePayment::first();
        $bankPayment = BankPayment::first();
        $paypal = PaypalPayment::first();
        $razorpay = RazorpayPayment::first();
        $flutterwave = Flutterwave::first();
        $paystack = PaystackAndMollie::first();
        $mollie = PaystackAndMollie::first();
        $instamojo = InstamojoPayment::first();


        $doctor = Doctor::find($appointment['options']['doctor_id']);

        $doctor_paypal = DoctorPaypal::where('doctor_id', $doctor->id)->first();
        $doctor_stripe = DoctorStripe::where('doctor_id', $doctor->id)->first();
        $doctor_razorpay = DoctorRazorpay::where('doctor_id', $doctor->id)->first();
        $doctor_flutterwave = DoctorFlutterwave::where('doctor_id', $doctor->id)->first();
        $doctor_bank = DoctorBankPayment::where('doctor_id', $doctor->id)->first();
        $doctor_mollie = DoctorMollie::where('doctor_id', $doctor->id)->first();
        $doctor_paystack = DoctorPaystack::where('doctor_id', $doctor->id)->first();
        $doctor_instamojo = DoctorInstamojo::where('doctor_id', $doctor->id)->first();

        $countires = CurrencyCountry::orderBy('name','asc')->get();
        $currencies = Currency::orderBy('name','asc')->get();
        $user = Auth::guard('web')->user();

        return view('payment', compact('banner','appointment','setting','stripe','bankPayment','paypal','razorpay','flutterwave','paystack','mollie','instamojo','doctor_paypal','doctor_stripe','doctor_razorpay','doctor_flutterwave','doctor_bank','doctor_mollie','doctor_paystack','doctor_instamojo','user'));
    }


    public function paymentWithBank(Request $request){

        $data = Session::get('appointment');
        if(!$data){
            $notification = trans('user_validation.Your appointment list is empty');
            $notification = array('messege'=>$notification,'alert-type'=>'error');
            return redirect()->route('our-experts')->with($notification);
        }

        $rules = [
            'tnx_info'=>'required',
        ];
        $this->validate($request, $rules);

        $user = Auth::guard('web')->user();
        $doctor = Doctor::find($data['options']['doctor_id']);

        $total_fee = str_replace( array( '\'', '"', ',' , ';', '<', '>' ), '', $data['price']);
        $setting = Setting::first();

        $order = new AppointmentOrder();
        $invoice_id = substr(rand(0,time()),0,10);
        $order->invoice_id = $invoice_id;
        $order->user_id = $user->id;
        $order->doctor_id = $data['options']['doctor_id'];
        $order->total_fee = $total_fee;
        $order->appointment_qty = 1;
        $order->transaction_id = $request->tnx_info;
        $order->payment_method = 'Bank Payment';
        $order->payment_status = 0;
        $order->status = 0;
        $order->save();

        $appointment = new Appointment();
        $appointment->doctor_id = $data['options']['doctor_id'];
        $appointment->appointment_order_id = $order->id;
        $appointment->user_id = $user->id;
        $appointment->day_id = $data['options']['day_id'];
        $appointment->schedule_id = $data['options']['schedule_id'];
        $appointment->chamber_id = $data['options']['chamber_id'];
        $appointment->consultation_type = $data['options']['consultation_type'];
        $appointment->date = $data['options']['date'];
        $appointment->fee = $data['price'];
        $appointment->already_treated = 0;
        $appointment->status = 0;
        $appointment->save();

        $schedule = Schedule::find($data['options']['schedule_id']);

        $setting = Setting::first();
        $template = EmailTemplate::where('id',9)->first();
        $message = $template->description;
        $subject = $template->subject;
        $message = str_replace('{{patient_name}}',$user->name,$message);
        $message = str_replace('{{doctor_name}}',$doctor->name,$message);
        $message = str_replace('{{date}}',$data['options']['date'],$message);
        $start_time = date('h:i A', strtotime($schedule->start_time));
        $end_time = date('h:i A', strtotime($schedule->end_time));
        $message = str_replace('{{schedule}}',$start_time.' - '.$end_time,$message);
        $total_amount = $setting->currency_icon. $appointment->fee;
        $message = str_replace('{{fee}}',$total_amount,$message);
        $message = str_replace('{{chamber}}',$schedule->chamber->name,$message);

        MailHelper::setMailConfig();
        Mail::to($user->email)->send(new AppointmentNotification($message,$subject));
        Session::forget('appointment');

        $notification = trans('user_validation.Order submited successfully. please wait for admin approval');
        $notification = array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->route('user.transaction')->with($notification);
    }


    public function paymentWithStripe(Request $request){

        $data = Session::get('appointment');
        if(!$data){
            $notification = trans('user_validation.Your appointment list is empty');
            $notification = array('messege'=>$notification,'alert-type'=>'error');
            return redirect()->route('our-experts')->with($notification);
        }

        $user = Auth::guard('web')->user();
        $doctor = Doctor::find($data['options']['doctor_id']);

        $total_fee = str_replace( array( '\'', '"', ',' , ';', '<', '>' ), '', $data['price']);
        $setting = Setting::first();

        $stripe = DoctorStripe::where('doctor_id', $doctor->id)->first();
        $payableAmount = round($total_fee * $stripe->currency_rate,2);

        Stripe\Stripe::setApiKey($stripe->stripe_secret);

        $result = Stripe\Charge::create ([
                "amount" => $payableAmount * 100,
                "currency" => $stripe->currency_code,
                "source" => $request->stripeToken,
                "description" => env('APP_NAME')
        ]);

        if($result->paid){
            $order = new AppointmentOrder();
            $invoice_id = substr(rand(0,time()),0,10);
            $order->invoice_id = $invoice_id;
            $order->user_id = $user->id;
            $order->doctor_id = $data['options']['doctor_id'];
            $order->total_fee = $total_fee;
            $order->appointment_qty = 1;
            $order->transaction_id = $result->balance_transaction;
            $order->payment_method = 'Stripe';
            $order->payment_status = 1;
            $order->status = 1;
            $order->save();

            $appointment = new Appointment();
            $appointment->doctor_id = $data['options']['doctor_id'];
            $appointment->appointment_order_id = $order->id;
            $appointment->user_id = $user->id;
            $appointment->day_id = $data['options']['day_id'];
            $appointment->schedule_id = $data['options']['schedule_id'];
            $appointment->chamber_id = $data['options']['chamber_id'];
            $appointment->consultation_type = $data['options']['consultation_type'];
            $appointment->date = $data['options']['date'];
            $appointment->fee = $data['price'];
            $appointment->already_treated = 0;
            $appointment->status = 0;
            $appointment->save();

            $schedule = Schedule::find($data['options']['schedule_id']);

            $setting = Setting::first();
            $template = EmailTemplate::where('id',9)->first();
            $message = $template->description;
            $subject = $template->subject;
            $message = str_replace('{{patient_name}}',$user->name,$message);
            $message = str_replace('{{doctor_name}}',$doctor->name,$message);
            $message = str_replace('{{date}}',$data['options']['date'],$message);
            $start_time = date('h:i A', strtotime($schedule->start_time));
            $end_time = date('h:i A', strtotime($schedule->end_time));
            $message = str_replace('{{schedule}}',$start_time.' - '.$end_time,$message);
            $total_amount = $setting->currency_icon. $appointment->fee;
            $message = str_replace('{{fee}}',$total_amount,$message);
            $message = str_replace('{{chamber}}',$schedule->chamber->name,$message);

            MailHelper::setMailConfig();
            Mail::to($user->email)->send(new AppointmentNotification($message,$subject));
            Session::forget('appointment');

            $notification = trans('user_validation.Payment Successfully');
            $notification = array('messege'=>$notification,'alert-type'=>'success');
            return redirect()->route('user.transaction')->with($notification);
        }else{
            $notification = trans('user_validation.Payment Faild');
            $notification = array('messege'=>$notification,'alert-type'=>'error');
            return redirect()->route('our-experts')->with($notification);
        }

    }


    public function payWithRazorpay(Request $request){

        $data = Session::get('appointment');
        if(!$data){
            $notification = trans('user_validation.Your appointment list is empty');
            $notification = array('messege'=>$notification,'alert-type'=>'error');
            return redirect()->route('our-experts')->with($notification);
        }

        $razorpay = DoctorRazorpay::first();
        $input = $request->all();
        $api = new Api($razorpay->key,$razorpay->secret_key);
        $payment = $api->payment->fetch($input['razorpay_payment_id']);
        if(count($input)  && !empty($input['razorpay_payment_id'])) {
            try {
                $response = $api->payment->fetch($input['razorpay_payment_id'])->capture(array('amount'=>$payment['amount']));
                $payId = $response->id;

                $user = Auth::guard('web')->user();
                $doctor = Doctor::find($data['options']['doctor_id']);

                $total_fee = str_replace( array( '\'', '"', ',' , ';', '<', '>' ), '', $data['price']);
                $setting = Setting::first();

                $order = new AppointmentOrder();
                $invoice_id = substr(rand(0,time()),0,10);
                $order->invoice_id = $invoice_id;
                $order->user_id = $user->id;
                $order->doctor_id = $data['options']['doctor_id'];
                $order->total_fee = $total_fee;
                $order->appointment_qty = 1;
                $order->transaction_id = $payId;
                $order->payment_method = 'Razorpay';
                $order->payment_status = 1;
                $order->status = 1;
                $order->save();

                $appointment = new Appointment();
                $appointment->doctor_id = $data['options']['doctor_id'];
                $appointment->appointment_order_id = $order->id;
                $appointment->user_id = $user->id;
                $appointment->day_id = $data['options']['day_id'];
                $appointment->schedule_id = $data['options']['schedule_id'];
                $appointment->chamber_id = $data['options']['chamber_id'];
                $appointment->consultation_type = $data['options']['consultation_type'];
                $appointment->date = $data['options']['date'];
                $appointment->fee = $data['price'];
                $appointment->already_treated = 0;
                $appointment->status = 0;
                $appointment->save();

                $schedule = Schedule::find($data['options']['schedule_id']);

                $setting = Setting::first();
                $template = EmailTemplate::where('id',9)->first();
                $message = $template->description;
                $subject = $template->subject;
                $message = str_replace('{{patient_name}}',$user->name,$message);
                $message = str_replace('{{doctor_name}}',$doctor->name,$message);
                $message = str_replace('{{date}}',$data['options']['date'],$message);
                $start_time = date('h:i A', strtotime($schedule->start_time));
                $end_time = date('h:i A', strtotime($schedule->end_time));
                $message = str_replace('{{schedule}}',$start_time.' - '.$end_time,$message);
                $total_amount = $setting->currency_icon. $appointment->fee;
                $message = str_replace('{{fee}}',$total_amount,$message);
                $message = str_replace('{{chamber}}',$schedule->chamber->name,$message);

                MailHelper::setMailConfig();
                Mail::to($user->email)->send(new AppointmentNotification($message,$subject));
                Session::forget('appointment');

                $notification = trans('user_validation.Payment Successfully');
                $notification = array('messege'=>$notification,'alert-type'=>'success');
                return redirect()->route('user.transaction')->with($notification);

            }catch (Exception $e) {
                $notification = trans('user_validation.Payment Faild');
                $notification = array('messege'=>$notification,'alert-type'=>'error');
                return redirect()->route('our-experts')->with($notification);
            }

        }
    }


    public function payWithFlutterwave(Request $request){

        $data = Session::get('appointment');

        $flutterwave = DoctorFlutterwave::first();
        $curl = curl_init();
        $tnx_id = $request->tnx_id;
        $url = "https://api.flutterwave.com/v3/transactions/$tnx_id/verify";
        $token = $flutterwave->secret_key;
        curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Content-Type: application/json",
            "Authorization: Bearer $token"
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $response = json_decode($response);
        if($response->status == 'success'){

            $user = Auth::guard('web')->user();
            $doctor = Doctor::find($data['options']['doctor_id']);

            $total_fee = str_replace( array( '\'', '"', ',' , ';', '<', '>' ), '', $data['price']);
            $setting = Setting::first();

            $order = new AppointmentOrder();
            $invoice_id = substr(rand(0,time()),0,10);
            $order->invoice_id = $invoice_id;
            $order->user_id = $user->id;
            $order->doctor_id = $data['options']['doctor_id'];
            $order->total_fee = $total_fee;
            $order->appointment_qty = 1;
            $order->transaction_id = $tnx_id;
            $order->payment_method = 'Flutterwave';
            $order->payment_status = 1;
            $order->status = 1;
            $order->save();

            $appointment = new Appointment();
            $appointment->doctor_id = $data['options']['doctor_id'];
            $appointment->appointment_order_id = $order->id;
            $appointment->user_id = $user->id;
            $appointment->day_id = $data['options']['day_id'];
            $appointment->schedule_id = $data['options']['schedule_id'];
            $appointment->chamber_id = $data['options']['chamber_id'];
            $appointment->consultation_type = $data['options']['consultation_type'];
            $appointment->date = $data['options']['date'];
            $appointment->fee = $data['price'];
            $appointment->already_treated = 0;
            $appointment->status = 0;
            $appointment->save();

            $schedule = Schedule::find($data['options']['schedule_id']);

            $setting = Setting::first();
            $template = EmailTemplate::where('id',9)->first();
            $message = $template->description;
            $subject = $template->subject;
            $message = str_replace('{{patient_name}}',$user->name,$message);
            $message = str_replace('{{doctor_name}}',$doctor->name,$message);
            $message = str_replace('{{date}}',$data['options']['date'],$message);
            $start_time = date('h:i A', strtotime($schedule->start_time));
            $end_time = date('h:i A', strtotime($schedule->end_time));
            $message = str_replace('{{schedule}}',$start_time.' - '.$end_time,$message);
            $total_amount = $setting->currency_icon. $appointment->fee;
            $message = str_replace('{{fee}}',$total_amount,$message);
            $message = str_replace('{{chamber}}',$schedule->chamber->name,$message);

            MailHelper::setMailConfig();
            Mail::to($user->email)->send(new AppointmentNotification($message,$subject));
            Session::forget('appointment');

            $notification = trans('user_validation.Payment Successfully');
            return response()->json(['status' => 'success' , 'message' => $notification]);
        }else{
            $notification = trans('user_validation.Payment Faild');
            return response()->json(['status' => 'faild' , 'message' => $notification]);
        }
    }


    public function payWithPayStack(Request $request){

        $paystack = DoctorPaystack::first();
        $data = Session::get('appointment');

        $reference = $request->reference;
        $transaction = $request->tnx_id;
        $secret_key = $paystack->secret_key;
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.paystack.co/transaction/verify/$reference",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_SSL_VERIFYHOST =>0,
            CURLOPT_SSL_VERIFYPEER =>0,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer $secret_key",
                "Cache-Control: no-cache",
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        $final_data = json_decode($response);
        if($final_data->status == true) {
            $user = Auth::guard('web')->user();
            $doctor = Doctor::find($data['options']['doctor_id']);

            $total_fee = str_replace( array( '\'', '"', ',' , ';', '<', '>' ), '', $data['price']);
            $setting = Setting::first();

            $order = new AppointmentOrder();
            $invoice_id = substr(rand(0,time()),0,10);
            $order->invoice_id = $invoice_id;
            $order->user_id = $user->id;
            $order->doctor_id = $data['options']['doctor_id'];
            $order->total_fee = $total_fee;
            $order->appointment_qty = 1;
            $order->transaction_id = $transaction;
            $order->payment_method = 'Paystack';
            $order->payment_status = 1;
            $order->status = 1;
            $order->save();

            $appointment = new Appointment();
            $appointment->doctor_id = $data['options']['doctor_id'];
            $appointment->appointment_order_id = $order->id;
            $appointment->user_id = $user->id;
            $appointment->day_id = $data['options']['day_id'];
            $appointment->schedule_id = $data['options']['schedule_id'];
            $appointment->chamber_id = $data['options']['chamber_id'];
            $appointment->consultation_type = $data['options']['consultation_type'];
            $appointment->date = $data['options']['date'];
            $appointment->fee = $data['price'];
            $appointment->already_treated = 0;
            $appointment->status = 0;
            $appointment->save();

            $schedule = Schedule::find($data['options']['schedule_id']);

            $setting = Setting::first();
            $template = EmailTemplate::where('id',9)->first();
            $message = $template->description;
            $subject = $template->subject;
            $message = str_replace('{{patient_name}}',$user->name,$message);
            $message = str_replace('{{doctor_name}}',$doctor->name,$message);
            $message = str_replace('{{date}}',$data['options']['date'],$message);
            $start_time = date('h:i A', strtotime($schedule->start_time));
            $end_time = date('h:i A', strtotime($schedule->end_time));
            $message = str_replace('{{schedule}}',$start_time.' - '.$end_time,$message);
            $total_amount = $setting->currency_icon. $appointment->fee;
            $message = str_replace('{{fee}}',$total_amount,$message);
            $message = str_replace('{{chamber}}',$schedule->chamber->name,$message);

            MailHelper::setMailConfig();
            Mail::to($user->email)->send(new AppointmentNotification($message,$subject));
            Session::forget('appointment');

            $notification = trans('user_validation.Payment Successfully');
            return response()->json(['status' => 'success' , 'message' => $notification]);
        }
    }


    public function payWithMollie(Request $request){
        $data = Session::get('appointment');
        if(!$data){
            $notification = trans('user_validation.Your appointment list is empty');
            $notification = array('messege'=>$notification,'alert-type'=>'error');
            return redirect()->route('our-experts')->with($notification);
        }

        $user = Auth::guard('web')->user();
        $doctor = Doctor::find($data['options']['doctor_id']);
        $total_fee = str_replace( array( '\'', '"', ',' , ';', '<', '>' ), '', $data['price']);
        $setting = Setting::first();

        $mollie = DoctorMollie::first();
        $price = $total_fee * $mollie->currency_rate;
        $price = round($price,2);


        $mollie_api_key = $mollie->mollie_key;
        $currency = strtoupper($mollie->currency_code);
        Mollie::api()->setApiKey($mollie_api_key);

        $payment = Mollie::api()->payments()->create([
            'amount' => [
                'currency' => $currency,
                'value' => '' . sprintf('%0.2f', $price) . '',
            ],
            'description' => env('APP_NAME'),
            'redirectUrl' => route('mollie-payment-success'),
        ]);

        $payment = Mollie::api()->payments()->get($payment->id);
        session()->put('payment_id',$payment->id);
        return redirect($payment->getCheckoutUrl(), 303);
    }

    public function molliePaymentSuccess(Request $request){

        $data = Session::get('appointment');
        if(!$data){
            $notification = trans('user_validation.Your appointment list is empty');
            $notification = array('messege'=>$notification,'alert-type'=>'error');
            return redirect()->route('our-experts')->with($notification);
        }

        $mollie = DoctorMollie::first();
        $mollie_api_key = $mollie->mollie_key;
        Mollie::api()->setApiKey($mollie_api_key);
        $payment = Mollie::api()->payments->get(session()->get('payment_id'));
        if ($payment->isPaid()){
            $user = Auth::guard('web')->user();
            $doctor = Doctor::find($data['options']['doctor_id']);

            $total_fee = str_replace( array( '\'', '"', ',' , ';', '<', '>' ), '', $data['price']);
            $setting = Setting::first();

            $order = new AppointmentOrder();
            $invoice_id = substr(rand(0,time()),0,10);
            $order->invoice_id = $invoice_id;
            $order->user_id = $user->id;
            $order->doctor_id = $data['options']['doctor_id'];
            $order->total_fee = $total_fee;
            $order->appointment_qty = 1;
            $order->transaction_id = session()->get('payment_id');
            $order->payment_method = 'Mollie';
            $order->payment_status = 1;
            $order->status = 1;
            $order->save();

            $appointment = new Appointment();
            $appointment->doctor_id = $data['options']['doctor_id'];
            $appointment->appointment_order_id = $order->id;
            $appointment->user_id = $user->id;
            $appointment->day_id = $data['options']['day_id'];
            $appointment->schedule_id = $data['options']['schedule_id'];
            $appointment->chamber_id = $data['options']['chamber_id'];
            $appointment->consultation_type = $data['options']['consultation_type'];
            $appointment->date = $data['options']['date'];
            $appointment->fee = $data['price'];
            $appointment->already_treated = 0;
            $appointment->status = 0;
            $appointment->save();

            $schedule = Schedule::find($data['options']['schedule_id']);

            $setting = Setting::first();
            $template = EmailTemplate::where('id',9)->first();
            $message = $template->description;
            $subject = $template->subject;
            $message = str_replace('{{patient_name}}',$user->name,$message);
            $message = str_replace('{{doctor_name}}',$doctor->name,$message);
            $message = str_replace('{{date}}',$data['options']['date'],$message);
            $start_time = date('h:i A', strtotime($schedule->start_time));
            $end_time = date('h:i A', strtotime($schedule->end_time));
            $message = str_replace('{{schedule}}',$start_time.' - '.$end_time,$message);
            $total_amount = $setting->currency_icon. $appointment->fee;
            $message = str_replace('{{fee}}',$total_amount,$message);
            $message = str_replace('{{chamber}}',$schedule->chamber->name,$message);

            MailHelper::setMailConfig();
            Mail::to($user->email)->send(new AppointmentNotification($message,$subject));
            Session::forget('appointment');

            $notification = trans('user_validation.Payment Successfully');
            $notification = array('messege'=>$notification,'alert-type'=>'success');
            return redirect()->route('user.transaction')->with($notification);

        }else{
            $notification = trans('user_validation.Payment Faild');
            $notification = array('messege'=>$notification,'alert-type'=>'error');
            return redirect()->route('our-experts')->with($notification);
        }
    }

    public function payWithInstamojo(){

        $data = Session::get('appointment');
        if(!$data){
            $notification = trans('user_validation.Your appointment list is empty');
            $notification = array('messege'=>$notification,'alert-type'=>'error');
            return redirect()->route('our-experts')->with($notification);
        }

        $user = Auth::guard('web')->user();
        $doctor = Doctor::find($data['options']['doctor_id']);
        $total_fee = str_replace( array( '\'', '"', ',' , ';', '<', '>' ), '', $data['price']);
        $setting = Setting::first();


        $instamojoPayment = DoctorInstamojo::first();
        $price = $total_fee * $instamojoPayment->currency_rate;
        $price = round($price,2);

        $environment = $instamojoPayment->account_mode;
        $api_key = $instamojoPayment->api_key;
        $auth_token = $instamojoPayment->auth_token;

        if($environment == 'Sandbox') {
            $url = 'https://test.instamojo.com/api/1.1/';
        } else {
            $url = 'https://www.instamojo.com/api/1.1/';
        }

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url.'payment-requests/');
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER,
            array("X-Api-Key:$api_key",
                "X-Auth-Token:$auth_token"));
        $payload = Array(
            'purpose' => env("APP_NAME"),
            'amount' => $price,
            'phone' => '918160651749',
            'buyer_name' => Auth::user()->name,
            'redirect_url' => route('instamojo-response'),
            'send_email' => true,
            'webhook' => 'http://www.example.com/webhook/',
            'send_sms' => true,
            'email' => Auth::user()->email,
            'allow_repeated_payments' => false
        );
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
        $response = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response);
        return redirect($response->payment_request->longurl);
    }

    public function instamojoResponse(Request $request){
        $data = Session::get('appointment');
        if(!$data){
            $notification = trans('user_validation.Your appointment list is empty');
            $notification = array('messege'=>$notification,'alert-type'=>'error');
            return redirect()->route('our-experts')->with($notification);
        }

        $input = $request->all();
        $instamojoPayment = DoctorInstamojo::first();
        $environment = $instamojoPayment->account_mode;
        $api_key = $instamojoPayment->api_key;
        $auth_token = $instamojoPayment->auth_token;

        if($environment == 'Sandbox') {
            $url = 'https://test.instamojo.com/api/1.1/';
        } else {
            $url = 'https://www.instamojo.com/api/1.1/';
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url.'payments/'.$request->get('payment_id'));
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER,
            array("X-Api-Key:$api_key",
                "X-Auth-Token:$auth_token"));
        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        if ($err) {
            $notification = trans('user_validation.Payment Faild');
            $notification = array('messege'=>$notification,'alert-type'=>'error');
            return redirect()->route('our-experts')->with($notification);
        } else {
            $data = json_decode($response);
        }

        if($data->success == true) {
            if($data->payment->status == 'Credit') {
                $data = Session::get('appointment');
                $user = Auth::guard('web')->user();
                $doctor = Doctor::find($data['options']['doctor_id']);

                $total_fee = str_replace( array( '\'', '"', ',' , ';', '<', '>' ), '', $data['price']);
                $setting = Setting::first();

                $order = new AppointmentOrder();
                $invoice_id = substr(rand(0,time()),0,10);
                $order->invoice_id = $invoice_id;
                $order->user_id = $user->id;
                $order->doctor_id = $data['options']['doctor_id'];
                $order->total_fee = $total_fee;
                $order->appointment_qty = 1;
                $order->transaction_id = $request->get('payment_id');
                $order->payment_method = 'Instamojo';
                $order->payment_status = 1;
                $order->status = 1;
                $order->save();

                $appointment = new Appointment();
                $appointment->doctor_id = $data['options']['doctor_id'];
                $appointment->appointment_order_id = $order->id;
                $appointment->user_id = $user->id;
                $appointment->day_id = $data['options']['day_id'];
                $appointment->schedule_id = $data['options']['schedule_id'];
                $appointment->chamber_id = $data['options']['chamber_id'];
                $appointment->consultation_type = $data['options']['consultation_type'];
                $appointment->date = $data['options']['date'];
                $appointment->fee = $data['price'];
                $appointment->already_treated = 0;
                $appointment->status = 0;
                $appointment->save();

                $schedule = Schedule::find($data['options']['schedule_id']);

                $setting = Setting::first();
                $template = EmailTemplate::where('id',9)->first();
                $message = $template->description;
                $subject = $template->subject;
                $message = str_replace('{{patient_name}}',$user->name,$message);
                $message = str_replace('{{doctor_name}}',$doctor->name,$message);
                $message = str_replace('{{date}}',$data['options']['date'],$message);
                $start_time = date('h:i A', strtotime($schedule->start_time));
                $end_time = date('h:i A', strtotime($schedule->end_time));
                $message = str_replace('{{schedule}}',$start_time.' - '.$end_time,$message);
                $total_amount = $setting->currency_icon. $appointment->fee;
                $message = str_replace('{{fee}}',$total_amount,$message);
                $message = str_replace('{{chamber}}',$schedule->chamber->name,$message);

                MailHelper::setMailConfig();
                Mail::to($user->email)->send(new AppointmentNotification($message,$subject));
                Session::forget('appointment');

                $notification = trans('user_validation.Payment Successfully');
                $notification = array('messege'=>$notification,'alert-type'=>'success');
                return redirect()->route('user.transaction')->with($notification);
            }
        }

        $notification = trans('user_validation.Payment Faild');
        $notification = array('messege'=>$notification,'alert-type'=>'error');
        return redirect()->route('our-experts')->with($notification);

    }

    public function paymentWithHandCash(){
        $data = Session::get('appointment');
        if(!$data){
            $notification = trans('user_validation.Your appointment list is empty');
            $notification = array('messege'=>$notification,'alert-type'=>'error');
            return redirect()->route('our-experts')->with($notification);
        }

        $user = Auth::guard('web')->user();
        $doctor = Doctor::find($data['options']['doctor_id']);

        $total_fee = str_replace( array( '\'', '"', ',' , ';', '<', '>' ), '', $data['price']);
        $setting = Setting::first();

        $order = new AppointmentOrder();
        $invoice_id = substr(rand(0,time()),0,10);
        $order->invoice_id = $invoice_id;
        $order->user_id = $user->id;
        $order->doctor_id = $data['options']['doctor_id'];
        $order->total_fee = $total_fee;
        $order->appointment_qty = 1;
        $order->transaction_id = 'hand_cash';
        $order->payment_method = 'Hand Cash';
        $order->payment_status = 0;
        $order->status = 0;
        $order->save();

        $appointment = new Appointment();
        $appointment->doctor_id = $data['options']['doctor_id'];
        $appointment->appointment_order_id = $order->id;
        $appointment->user_id = $user->id;
        $appointment->day_id = $data['options']['day_id'];
        $appointment->schedule_id = $data['options']['schedule_id'];
        $appointment->chamber_id = $data['options']['chamber_id'];
        $appointment->consultation_type = $data['options']['consultation_type'];
        $appointment->date = $data['options']['date'];
        $appointment->fee = $data['price'];
        $appointment->already_treated = 0;
        $appointment->status = 0;
        $appointment->save();

        $schedule = Schedule::find($data['options']['schedule_id']);

        $setting = Setting::first();
        $template = EmailTemplate::where('id',9)->first();
        $message = $template->description;
        $subject = $template->subject;
        $message = str_replace('{{patient_name}}',$user->name,$message);
        $message = str_replace('{{doctor_name}}',$doctor->name,$message);
        $message = str_replace('{{date}}',$data['options']['date'],$message);
        $start_time = date('h:i A', strtotime($schedule->start_time));
        $end_time = date('h:i A', strtotime($schedule->end_time));
        $message = str_replace('{{schedule}}',$start_time.' - '.$end_time,$message);
        $total_amount = $setting->currency_icon. $appointment->fee;
        $message = str_replace('{{fee}}',$total_amount,$message);
        $message = str_replace('{{chamber}}',$schedule->chamber->name,$message);

        MailHelper::setMailConfig();
        Mail::to($user->email)->send(new AppointmentNotification($message,$subject));
        Session::forget('appointment');

        $notification = trans('user_validation.Appointment created successfully');
        $notification = array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->route('user.transaction')->with($notification);
    }
}
