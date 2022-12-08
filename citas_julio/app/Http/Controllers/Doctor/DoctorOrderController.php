<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Setting;
use App\Models\Package;
use App\Models\PaypalPayment;
use App\Models\StripePayment;
use App\Models\RazorpayPayment;
use App\Models\Flutterwave;
use App\Models\BankPayment;
use App\Models\PaystackAndMollie;
use App\Models\InstamojoPayment;
use App\Models\CurrencyCountry;
use App\Models\Currency;
use App\Mail\OrderSuccessfully;
use App\Helpers\MailHelper;
use App\Models\EmailTemplate;
use App\Models\Staff;
use App\Models\Chamber;
use Auth;
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
class DoctorOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:doctor');
    }

    public function index(){
        $doctor = Auth::guard('doctor')->user();
        $orders = Order::with('doctor')->orderBy('id','desc')->where('doctor_id', $doctor->id)->get();
        $setting = Setting::first();

        return view('doctor.order', compact('orders','setting'));
    }


    public function show($id){
        $doctor = Auth::guard('doctor')->user();
        $order = Order::with('doctor')->where(['order_id' => $id, 'doctor_id' => $doctor->id])->first();
        $setting = Setting::first();
        $user = $order->doctor;
        return view('doctor.show_order',compact('order','setting','user'));
    }


    public function pricingPlan(){
        $doctor = Auth::guard('doctor')->user();
        $currentOrder = Order::where(['doctor_id' => $doctor->id, 'status' => 1])->first();
        $packages = Package::where('status', 1)->get();
        $setting = Setting::first();
        return view('doctor.pricing_plan', compact('packages','setting','currentOrder'));
    }

    public function payment($slug){
        $paypal = PaypalPayment::first();
        $stripe = StripePayment::first();
        $razorpay = RazorpayPayment::first();
        $flutterwave = Flutterwave::first();
        $bank = BankPayment::first();
        $paystackAndMollie = PaystackAndMollie::first();
        $instamojo = InstamojoPayment::first();
        $setting = Setting::first();
        $package = Package::where(['slug' => $slug, 'status' => 1])->first();
        $doctor = Auth::guard('doctor')->user();
        return view('doctor.payment', compact('paypal','stripe','razorpay','bank','paystackAndMollie','flutterwave','instamojo','setting','package','doctor'));
    }

    public function paywithStripe(Request $request){

        $doctor = Auth::guard('doctor')->user();
        $package = Package::where(['slug' => $request->package_slug, 'status' => 1])->first();
        $setting = Setting::first();
        $total_price = $package->price;
        $stripe = StripePayment::first();
        $payableAmount = round($total_price * $stripe->currency_rate,2);

        Stripe\Stripe::setApiKey($stripe->stripe_secret);

        $result = Stripe\Charge::create ([
                "amount" => $payableAmount * 100,
                "currency" => $stripe->currency_code,
                "source" => $request->stripeToken,
                "description" => env('APP_NAME')
        ]);


        if($result->paid){
            $order = new Order();
            $order->order_id = substr(rand(0,time()),0,10);
            $order->doctor_id =  $doctor->id;
            $order->package_id = $package->id;
            $order->package_name =  $package->name;
            $order->purchase_date =  date('Y-m-d');
            $order->expired_day =  $package->expiration_day;
            $order->expired_date =  $package->expiration_day ==-1 ? null : date('Y-m-d', strtotime($package->expiration_day.' days'));
            $order->payment_method = 'Stripe';
            $order->transaction_id = $result->balance_transaction;
            $order->payment_status = 1;
            $order->amount = $package->price;
            $order->online_consulting = $package->online_consulting;
            $order->message_system = $package->message_system;
            $order->daily_appointment_qty = $package->daily_appointment_qty;
            $order->online_prescription = $package->online_prescription;
            $order->review_system = $package->review_system;
            $order->maximum_staff = $package->maximum_staff;
            $order->maximum_image = $package->maximum_image;
            $order->maximum_video = $package->maximum_video;
            $order->maximum_chamber = $package->maximum_chamber;
            $order->status = 1;
            $order->save();

            $doctor = Auth::guard('doctor')->user();
            $staffs = Staff::where('doctor_id', $doctor->id)->get();
            $chambers = Chamber::where('doctor_id', $doctor->id)->get();
            foreach($staffs as $indx => $staff){
                if($indx >= $order->maximum_staff) {
                    $staff->status = 0;
                    $staff->save();
                }
            }

            foreach($chambers as $indx => $chamber){
                if($indx >= $order->maximum_chamber) {
                    $chamber->status = 0;
                    $chamber->save();
                }
            }


            Order::where('doctor_id', $doctor->id)->where('id', '!=', $order->id)->update(['status' => 2]);

            MailHelper::setMailConfig();

            $template=EmailTemplate::where('id',6)->first();
            $subject=$template->subject;
            $message=$template->description;
            $message = str_replace('{{user_name}}',$doctor->name,$message);
            $message = str_replace('{{total_amount}}',$setting->currency_icon.$payableAmount,$message);
            $message = str_replace('{{payment_method}}','Stripe',$message);
            $message = str_replace('{{payment_status}}','Success',$message);
            $message = str_replace('{{order_date}}',$order->created_at->format('Y-m-d'),$message);
            $message = str_replace('{{expired_date}}',$order->expired_date ,$message);
            $message = str_replace('{{package_name}}',$order->package_name,$message);

            Mail::to($doctor->email)->send(new OrderSuccessfully($subject,$message));

            $notification = trans('user_validation.Payment Successfully');
            $notification = array('messege'=>$notification,'alert-type'=>'success');
            return redirect()->route('doctor.order')->with($notification);

        }else{
            $notification = trans('user_validation.Payment Faild');
            $notification = array('messege'=>$notification,'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }
    }

    public function payWithRazorpay(Request $request, $slug){
        $razorpay = RazorpayPayment::first();
        $input = $request->all();
        $api = new Api($razorpay->key,$razorpay->secret_key);
        $payment = $api->payment->fetch($input['razorpay_payment_id']);
        if(count($input)  && !empty($input['razorpay_payment_id'])) {
            try {
                $response = $api->payment->fetch($input['razorpay_payment_id'])->capture(array('amount'=>$payment['amount']));
                $payId = $response->id;

                $doctor = Auth::guard('doctor')->user();
                $package = Package::where(['slug' => $slug, 'status' => 1])->first();
                $setting = Setting::first();

                $order = new Order();
                $order->order_id = substr(rand(0,time()),0,10);
                $order->doctor_id =  $doctor->id;
                $order->package_id = $package->id;
                $order->package_name =  $package->name;
                $order->purchase_date =  date('Y-m-d');
                $order->expired_day =  $package->expiration_day;
                $order->expired_date =  $package->expiration_day ==-1 ? null : date('Y-m-d', strtotime($package->expiration_day.' days'));
                $order->payment_method = 'Razorpay';
                $order->transaction_id = $payId;
                $order->payment_status = 1;
                $order->amount = $package->price;
                $order->online_consulting = $package->online_consulting;
                $order->message_system = $package->message_system;
                $order->daily_appointment_qty = $package->daily_appointment_qty;
                $order->online_prescription = $package->online_prescription;
                $order->review_system = $package->review_system;
                $order->maximum_staff = $package->maximum_staff;
                $order->maximum_image = $package->maximum_image;
                $order->maximum_video = $package->maximum_video;
                $order->maximum_chamber = $package->maximum_chamber;
                $order->status = 1;
                $order->save();

                $doctor = Auth::guard('doctor')->user();
                $staffs = Staff::where('doctor_id', $doctor->id)->get();
                $chambers = Chamber::where('doctor_id', $doctor->id)->get();
                foreach($staffs as $indx => $staff){
                    if($indx >= $order->maximum_staff) {
                        $staff->status = 0;
                        $staff->save();
                    }
                }

                foreach($chambers as $indx => $chamber){
                    if($indx >= $order->maximum_chamber) {
                        $chamber->status = 0;
                        $chamber->save();
                    }
                }

                Order::where('doctor_id', $doctor->id)->where('id', '!=', $order->id)->update(['status' => 2]);

                MailHelper::setMailConfig();

                $template = EmailTemplate::where('id',6)->first();
                $subject = $template->subject;
                $message = $template->description;
                $message = str_replace('{{user_name}}',$doctor->name,$message);
                $message = str_replace('{{total_amount}}',$setting->currency_icon.$package->price,$message);
                $message = str_replace('{{payment_method}}','Razorpay',$message);
                $message = str_replace('{{payment_status}}','Success',$message);
                $message = str_replace('{{order_date}}',$order->created_at->format('Y-m-d'),$message);
                $message = str_replace('{{expired_date}}',$order->expired_date ,$message);
                $message = str_replace('{{package_name}}',$order->package_name,$message);

                Mail::to($doctor->email)->send(new OrderSuccessfully($subject,$message));

                $notification = trans('user_validation.Payment Successfully');
                $notification = array('messege'=>$notification,'alert-type'=>'success');
                return redirect()->route('doctor.order')->with($notification);

            }catch (Exception $e) {
                $notification = trans('user_validation.Payment Faild');
                $notification = array('messege'=>$notification,'alert-type'=>'error');
                return redirect()->back()->with($notification);
            }

        }
    }


    public function payWithFlutterwave(Request $request){
        $flutterwave = Flutterwave::first();
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

            $doctor = Auth::guard('doctor')->user();
            $package = Package::where(['slug' => $request->slug, 'status' => 1])->first();
            $setting = Setting::first();

            $order = new Order();
            $order->order_id = substr(rand(0,time()),0,10);
            $order->doctor_id =  $doctor->id;
            $order->package_id = $package->id;
            $order->package_name =  $package->name;
            $order->purchase_date =  date('Y-m-d');
            $order->expired_day =  $package->expiration_day;
            $order->expired_date =  $package->expiration_day ==-1 ? null : date('Y-m-d', strtotime($package->expiration_day.' days'));
            $order->payment_method = 'Flutterwave';
            $order->transaction_id = $tnx_id;
            $order->payment_status = 1;
            $order->amount = $package->price;
            $order->online_consulting = $package->online_consulting;
            $order->message_system = $package->message_system;
            $order->daily_appointment_qty = $package->daily_appointment_qty;
            $order->online_prescription = $package->online_prescription;
            $order->review_system = $package->review_system;
            $order->maximum_staff = $package->maximum_staff;
            $order->maximum_image = $package->maximum_image;
            $order->maximum_video = $package->maximum_video;
            $order->maximum_chamber = $package->maximum_chamber;
            $order->status = 1;
            $order->save();

            $doctor = Auth::guard('doctor')->user();
            $staffs = Staff::where('doctor_id', $doctor->id)->get();
            $chambers = Chamber::where('doctor_id', $doctor->id)->get();
            foreach($staffs as $indx => $staff){
                if($indx >= $order->maximum_staff) {
                    $staff->status = 0;
                    $staff->save();
                }
            }

            foreach($chambers as $indx => $chamber){
                if($indx >= $order->maximum_chamber) {
                    $chamber->status = 0;
                    $chamber->save();
                }
            }

            Order::where('doctor_id', $doctor->id)->where('id', '!=', $order->id)->update(['status' => 2]);

            MailHelper::setMailConfig();

            $template = EmailTemplate::where('id',6)->first();
            $subject = $template->subject;
            $message = $template->description;
            $message = str_replace('{{user_name}}',$doctor->name,$message);
            $message = str_replace('{{total_amount}}',$setting->currency_icon.$package->price,$message);
            $message = str_replace('{{payment_method}}','Flutterwave',$message);
            $message = str_replace('{{payment_status}}','Success',$message);
            $message = str_replace('{{order_date}}',$order->created_at->format('Y-m-d'),$message);
            $message = str_replace('{{expired_date}}',$order->expired_date ,$message);
            $message = str_replace('{{package_name}}',$order->package_name,$message);

            Mail::to($doctor->email)->send(new OrderSuccessfully($subject,$message));

            $notification = trans('user_validation.Payment Successfully');
            return response()->json(['status' => 'success' , 'message' => $notification]);
        }else{
            $notification = trans('user_validation.Payment Faild');
            return response()->json(['status' => 'faild' , 'message' => $notification]);
        }
    }


    public function payWithMollie(Request $request, $slug){

        $doctor = Auth::guard('doctor')->user();
        $package = Package::where(['slug' => $slug, 'status' => 1])->first();
        $setting = Setting::first();
        $total_price = $package->price;
        $mollie = PaystackAndMollie::first();
        $price = $total_price * $mollie->mollie_currency_rate;
        $price = round($price,2);


        $mollie_api_key = $mollie->mollie_key;
        $currency = strtoupper($mollie->mollie_currency_code);
        Mollie::api()->setApiKey($mollie_api_key);

        $payment = Mollie::api()->payments()->create([
            'amount' => [
                'currency' => $currency,
                'value' => '' . sprintf('%0.2f', $price) . '',
            ],
            'description' => env('APP_NAME'),
            'redirectUrl' => route('doctor.mollie-payment-success'),
        ]);

        $payment = Mollie::api()->payments()->get($payment->id);
        session()->put('payment_id',$payment->id);
        Session::put('package_slug', $package->slug);
        return redirect($payment->getCheckoutUrl(), 303);
    }

    public function molliePaymentSuccess(Request $request){
        $mollie = PaystackAndMollie::first();
        $mollie_api_key = $mollie->mollie_key;
        Mollie::api()->setApiKey($mollie_api_key);
        $payment = Mollie::api()->payments->get(session()->get('payment_id'));
        if ($payment->isPaid()){
            $slug = Session::get('package_slug');
            $doctor = Auth::guard('doctor')->user();
            $package = Package::where(['slug' => $slug, 'status' => 1])->first();
            $setting = Setting::first();

            $order = new Order();
            $order->order_id = substr(rand(0,time()),0,10);
            $order->doctor_id =  $doctor->id;
            $order->package_id = $package->id;
            $order->package_name =  $package->name;
            $order->purchase_date =  date('Y-m-d');
            $order->expired_day =  $package->expiration_day;
            $order->expired_date =  $package->expiration_day ==-1 ? null : date('Y-m-d', strtotime($package->expiration_day.' days'));
            $order->payment_method = 'Mollie';
            $order->transaction_id = session()->get('payment_id');
            $order->payment_status = 1;
            $order->amount = $package->price;
            $order->online_consulting = $package->online_consulting;
            $order->message_system = $package->message_system;
            $order->daily_appointment_qty = $package->daily_appointment_qty;
            $order->online_prescription = $package->online_prescription;
            $order->review_system = $package->review_system;
            $order->maximum_staff = $package->maximum_staff;
            $order->maximum_image = $package->maximum_image;
            $order->maximum_video = $package->maximum_video;
            $order->maximum_chamber = $package->maximum_chamber;
            $order->status = 1;
            $order->save();

            $doctor = Auth::guard('doctor')->user();
            $staffs = Staff::where('doctor_id', $doctor->id)->get();
            $chambers = Chamber::where('doctor_id', $doctor->id)->get();
            foreach($staffs as $indx => $staff){
                if($indx >= $order->maximum_staff) {
                    $staff->status = 0;
                    $staff->save();
                }
            }

            foreach($chambers as $indx => $chamber){
                if($indx >= $order->maximum_chamber) {
                    $chamber->status = 0;
                    $chamber->save();
                }
            }

            Order::where('doctor_id', $doctor->id)->where('id', '!=', $order->id)->update(['status' => 2]);

            MailHelper::setMailConfig();

            $template=EmailTemplate::where('id',6)->first();
            $subject=$template->subject;
            $message=$template->description;
            $message = str_replace('{{user_name}}',$doctor->name,$message);
            $message = str_replace('{{total_amount}}',$setting->currency_icon.$package->price,$message);
            $message = str_replace('{{payment_method}}','Mollie',$message);
            $message = str_replace('{{payment_status}}','Success',$message);
            $message = str_replace('{{order_date}}',$order->created_at->format('Y-m-d'),$message);
            $message = str_replace('{{expired_date}}',$order->expired_date ,$message);
            $message = str_replace('{{package_name}}',$order->package_name,$message);

            Mail::to($doctor->email)->send(new OrderSuccessfully($subject,$message));

            $notification = trans('user_validation.Payment Successfully');
            $notification = array('messege'=>$notification,'alert-type'=>'success');
            return redirect()->route('doctor.order')->with($notification);
        }else{
            $notification = trans('user_validation.Payment Faild');
            $notification = array('messege'=>$notification,'alert-type'=>'error');
            return redirect()->route('doctor.pricing-plan')->with($notification);
        }
    }


    public function payWithPayStack(Request $request){

        $doctor = Auth::guard('doctor')->user();
        $package = Package::where(['slug' => $request->slug, 'status' => 1])->first();
        $setting = Setting::first();
        $total_price = $package->price;

        $paystack = PaystackAndMollie::first();

        $reference = $request->reference;
        $transaction = $request->tnx_id;
        $secret_key = $paystack->paystack_secret_key;
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
            $order = new Order();
            $order->order_id = substr(rand(0,time()),0,10);
            $order->doctor_id =  $doctor->id;
            $order->package_id = $package->id;
            $order->package_name =  $package->name;
            $order->purchase_date =  date('Y-m-d');
            $order->expired_day =  $package->expiration_day;
            $order->expired_date =  $package->expiration_day ==-1 ? null : date('Y-m-d', strtotime($package->expiration_day.' days'));
            $order->payment_method = 'Paystack';
            $order->transaction_id = $transaction;
            $order->payment_status = 1;
            $order->amount = $package->price;
            $order->online_consulting = $package->online_consulting;
            $order->message_system = $package->message_system;
            $order->daily_appointment_qty = $package->daily_appointment_qty;
            $order->online_prescription = $package->online_prescription;
            $order->review_system = $package->review_system;
            $order->maximum_staff = $package->maximum_staff;
            $order->maximum_image = $package->maximum_image;
            $order->maximum_video = $package->maximum_video;
            $order->maximum_chamber = $package->maximum_chamber;
            $order->status = 1;
            $order->save();

            $doctor = Auth::guard('doctor')->user();
            $staffs = Staff::where('doctor_id', $doctor->id)->get();
            $chambers = Chamber::where('doctor_id', $doctor->id)->get();
            foreach($staffs as $indx => $staff){
                if($indx >= $order->maximum_staff) {
                    $staff->status = 0;
                    $staff->save();
                }
            }

            foreach($chambers as $indx => $chamber){
                if($indx >= $order->maximum_chamber) {
                    $chamber->status = 0;
                    $chamber->save();
                }
            }

            Order::where('doctor_id', $doctor->id)->where('id', '!=', $order->id)->update(['status' => 2]);

            MailHelper::setMailConfig();

            $template = EmailTemplate::where('id',6)->first();
            $subject = $template->subject;
            $message = $template->description;
            $message = str_replace('{{user_name}}',$doctor->name,$message);
            $message = str_replace('{{total_amount}}',$setting->currency_icon.$package->price,$message);
            $message = str_replace('{{payment_method}}','Paystack',$message);
            $message = str_replace('{{payment_status}}','Success',$message);
            $message = str_replace('{{order_date}}',$order->created_at->format('Y-m-d'),$message);
            $message = str_replace('{{expired_date}}',$order->expired_date ,$message);
            $message = str_replace('{{package_name}}',$order->package_name,$message);

            Mail::to($doctor->email)->send(new OrderSuccessfully($subject,$message));

            $notification = trans('user_validation.Payment Successfully');
            return response()->json(['status' => 'success' , 'message' => $notification]);
        }
    }


    public function payWithInstamojo($slug){

        $doctor = Auth::guard('doctor')->user();
        $package = Package::where(['slug' => $slug, 'status' => 1])->first();
        $setting = Setting::first();
        $total_price = $package->price;
        $amount_real_currency = $total_price;
        $instamojoPayment = InstamojoPayment::first();
        $price = $amount_real_currency * $instamojoPayment->currency_rate;
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
            'redirect_url' => route('doctor.instamojo-response'),
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
        Session::put('package_slug', $slug);
        return redirect($response->payment_request->longurl);
    }

    public function instamojoResponse(Request $request){
        $input = $request->all();
        $instamojoPayment = InstamojoPayment::first();
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
            return redirect()->route('doctor.pricing-plan')->with($notification);
        } else {
            $data = json_decode($response);
        }

        if($data->success == true) {
            if($data->payment->status == 'Credit') {
                $slug = Session::get('package_slug');
                $doctor = Auth::guard('doctor')->user();
                $package = Package::where(['slug' => $slug, 'status' => 1])->first();

                $order = new Order();
                $order->order_id = substr(rand(0,time()),0,10);
                $order->doctor_id =  $doctor->id;
                $order->package_id = $package->id;
                $order->package_name =  $package->name;
                $order->purchase_date =  date('Y-m-d');
                $order->expired_day =  $package->expiration_day;
                $order->expired_date =  $package->expiration_day ==-1 ? null : date('Y-m-d', strtotime($package->expiration_day.' days'));
                $order->payment_method = 'Instamojo';
                $order->transaction_id = $request->get('payment_id');
                $order->payment_status = 1;
                $order->amount = $package->price;
                $order->online_consulting = $package->online_consulting;
                $order->message_system = $package->message_system;
                $order->daily_appointment_qty = $package->daily_appointment_qty;
                $order->online_prescription = $package->online_prescription;
                $order->review_system = $package->review_system;
                $order->maximum_staff = $package->maximum_staff;
                $order->maximum_image = $package->maximum_image;
                $order->maximum_video = $package->maximum_video;
                $order->maximum_chamber = $package->maximum_chamber;
                $order->status = 1;
                $order->save();

                $doctor = Auth::guard('doctor')->user();
                $staffs = Staff::where('doctor_id', $doctor->id)->get();
                $chambers = Chamber::where('doctor_id', $doctor->id)->get();
                foreach($staffs as $indx => $staff){
                    if($indx >= $order->maximum_staff) {
                        $staff->status = 0;
                        $staff->save();
                    }
                }

                foreach($chambers as $indx => $chamber){
                    if($indx >= $order->maximum_chamber) {
                        $chamber->status = 0;
                        $chamber->save();
                    }
                }

                Order::where('doctor_id', $doctor->id)->where('id', '!=', $order->id)->update(['status' => 2]);

                MailHelper::setMailConfig();
                $setting = Setting::first();
                $template = EmailTemplate::where('id',6)->first();
                $subject = $template->subject;
                $message = $template->description;
                $message = str_replace('{{user_name}}',$doctor->name,$message);
                $message = str_replace('{{total_amount}}',$setting->currency_icon.$package->price,$message);
                $message = str_replace('{{payment_method}}','Instamojo',$message);
                $message = str_replace('{{payment_status}}','Success',$message);
                $message = str_replace('{{order_date}}',$order->created_at->format('Y-m-d'),$message);
                $message = str_replace('{{expired_date}}',$order->expired_date ,$message);
                $message = str_replace('{{package_name}}',$order->package_name,$message);

                Mail::to($doctor->email)->send(new OrderSuccessfully($subject,$message));


                $notification = trans('user_validation.Payment Successfully');
                $notification = array('messege'=>$notification,'alert-type'=>'success');
                return redirect()->route('user.order')->with($notification);
            }
        }

        $notification = trans('user_validation.Payment Faild');
        $notification = array('messege'=>$notification,'alert-type'=>'error');
        return redirect()->route('doctor.pricing-plan')->with($notification);

    }

    public function payWithBank(Request $request, $slug){
        $doctor=Auth::guard('doctor')->user();
        $rules = [
            'payment_details'=>'required',

        ];
        $customMessages = [
            'payment_details.required' => trans('user_validation.Payment detail is required'),
        ];
        $this->validate($request, $rules,$customMessages);
        $package = Package::where(['slug' => $slug, 'status' => 1])->first();
        $setting = Setting::first();


        $order = new Order();
        $order->order_id = substr(rand(0,time()),0,10);
        $order->doctor_id =  $doctor->id;
        $order->package_id = $package->id;
        $order->package_name =  $package->name;
        $order->purchase_date =  date('Y-m-d');
        $order->expired_day =  $package->expiration_day;
        $order->expired_date =  $package->expiration_day ==-1 ? null : date('Y-m-d', strtotime($package->expiration_day.' days'));
        $order->payment_method = 'Bank';
        $order->transaction_id = $request->payment_details;
        $order->payment_status = 0;
        $order->amount = $package->price;
        $order->online_consulting = $package->online_consulting;
        $order->message_system = $package->message_system;
        $order->daily_appointment_qty = $package->daily_appointment_qty;
        $order->online_prescription = $package->online_prescription;
        $order->review_system = $package->review_system;
        $order->maximum_staff = $package->maximum_staff;
        $order->maximum_image = $package->maximum_image;
        $order->maximum_video = $package->maximum_video;
        $order->maximum_chamber = $package->maximum_chamber;
        $order->status = 0;
        $order->save();

        MailHelper::setMailConfig();

        $template=EmailTemplate::where('id',6)->first();
        $subject=$template->subject;
        $message=$template->description;
        $message = str_replace('{{user_name}}',$doctor->name,$message);
        $message = str_replace('{{total_amount}}',$setting->currency_icon.$package->price,$message);
        $message = str_replace('{{payment_method}}','Bank',$message);
        $message = str_replace('{{payment_status}}','Pending',$message);
        $message = str_replace('{{order_date}}',$order->created_at->format('Y-m-d'),$message);
        $message = str_replace('{{expired_date}}',$order->expired_date ,$message);
        $message = str_replace('{{package_name}}',$order->package_name,$message);

        Mail::to($doctor->email)->send(new OrderSuccessfully($subject,$message));

        $notification = trans('user_validation.Order submited successfully. please wait for admin approval');
        $notification = array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->route('doctor.order')->with($notification);
    }

    public function freeTrail($slug){
        $doctor=Auth::guard('doctor')->user();
        $package = Package::where(['slug' => $slug, 'status' => 1])->first();
        $setting = Setting::first();

        $order = new Order();
        $order->order_id = substr(rand(0,time()),0,10);
        $order->doctor_id =  $doctor->id;
        $order->package_id = $package->id;
        $order->package_name =  $package->name;
        $order->purchase_date =  date('Y-m-d');
        $order->expired_day =  $package->expiration_day;
        $order->expired_date =  $package->expiration_day ==-1 ? null : date('Y-m-d', strtotime($package->expiration_day.' days'));
        $order->payment_method = 'Free Trail';
        $order->transaction_id = 'free_package';
        $order->payment_status = 1;
        $order->amount = $package->price;
        $order->online_consulting = $package->online_consulting;
        $order->message_system = $package->message_system;
        $order->daily_appointment_qty = $package->daily_appointment_qty;
        $order->online_prescription = $package->online_prescription;
        $order->review_system = $package->review_system;
        $order->maximum_staff = $package->maximum_staff;
        $order->maximum_image = $package->maximum_image;
        $order->maximum_video = $package->maximum_video;
        $order->maximum_chamber = $package->maximum_chamber;
        $order->status = 1;
        $order->save();

        $doctor = Auth::guard('doctor')->user();
        $staffs = Staff::where('doctor_id', $doctor->id)->get();
        $chambers = Chamber::where('doctor_id', $doctor->id)->get();
        foreach($staffs as $indx => $staff){
            if($indx >= $order->maximum_staff) {
                $staff->status = 0;
                $staff->save();
            }
        }

        foreach($chambers as $indx => $chamber){
            if($indx >= $order->maximum_chamber) {
                $chamber->status = 0;
                $chamber->save();
            }
        }

        Order::where('doctor_id', $doctor->id)->where('id', '!=', $order->id)->update(['status' => 2]);

        MailHelper::setMailConfig();

        $template=EmailTemplate::where('id',6)->first();
        $subject=$template->subject;
        $message=$template->description;
        $message = str_replace('{{user_name}}',$doctor->name,$message);
        $message = str_replace('{{total_amount}}',$setting->currency_icon.$package->price,$message);
        $message = str_replace('{{payment_method}}','Free Trail',$message);
        $message = str_replace('{{payment_status}}','Free Trail',$message);
        $message = str_replace('{{order_date}}',$order->created_at->format('Y-m-d'),$message);
        $message = str_replace('{{expired_date}}',$order->expired_date ,$message);
        $message = str_replace('{{package_name}}',$order->package_name,$message);

        Mail::to($doctor->email)->send(new OrderSuccessfully($subject,$message));

        $notification = trans('user_validation.Enrolled Successfully');
        $notification = array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->route('doctor.order')->with($notification);

    }

}
