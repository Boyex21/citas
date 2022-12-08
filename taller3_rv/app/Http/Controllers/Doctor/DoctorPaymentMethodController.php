<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
use App\Models\Setting;
use Image;
use File;
use Auth;
class DoctorPaymentMethodController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:doctor');
    }

    public function index(){
        $doctor = Auth::guard('doctor')->user();

        $paypal = DoctorPaypal::where('doctor_id', $doctor->id)->first();
        $stripe = DoctorStripe::where('doctor_id', $doctor->id)->first();
        $razorpay = DoctorRazorpay::where('doctor_id', $doctor->id)->first();
        $flutterwave = DoctorFlutterwave::where('doctor_id', $doctor->id)->first();
        $bank = DoctorBankPayment::where('doctor_id', $doctor->id)->first();
        $mollie = DoctorMollie::where('doctor_id', $doctor->id)->first();
        $paystack = DoctorPaystack::where('doctor_id', $doctor->id)->first();
        $instamojo = DoctorInstamojo::where('doctor_id', $doctor->id)->first();

        $countires = CurrencyCountry::orderBy('name','asc')->get();
        $currencies = Currency::orderBy('name','asc')->get();
        $setting = Setting::first();
        return view('doctor.payment_method', compact('paypal','stripe','razorpay','bank','mollie','flutterwave','instamojo','countires','currencies','setting','paystack'));
    }

    public function updatePaypal(Request $request){

        $rules = [
            'paypal_client_id' => 'required',
            'paypal_secret_key' => 'required',
            'account_mode' => 'required',
            'country_name' => 'required',
            'currency_name' => 'required',
            'currency_rate' => 'required',
        ];
        $customMessages = [
            'paypal_client_id.required' => trans('user_validation.Paypal client id is required'),
            'paypal_secret_key.required' => trans('user_validation.Paypal secret key is required'),
            'account_mode.required' => trans('user_validation.Account mode is required'),
            'country_name.required' => trans('user_validation.Country name is required'),
            'currency_name.required' => trans('user_validation.Currency name is required'),
            'currency_rate.required' => trans('user_validation.Currency rate is required'),
        ];
        $this->validate($request, $rules,$customMessages);
        $doctor = Auth::guard('doctor')->user();
        $paypal = DoctorPaypal::where('doctor_id', $doctor->id)->first();
        $doctor = Auth::guard('doctor')->user();
        if($paypal){
            $paypal->doctor_id = $doctor->id;
            $paypal->client_id = $request->paypal_client_id;
            $paypal->secret_id = $request->paypal_secret_key;
            $paypal->account_mode = $request->account_mode;
            $paypal->country_code = $request->country_name;
            $paypal->currency_code = $request->currency_name;
            $paypal->currency_rate = $request->currency_rate;
            $paypal->status = $request->status ? 1 : 0;
            $paypal->save();
        }else{
            $paypal = new DoctorPaypal();
            $paypal->doctor_id = $doctor->id;
            $paypal->client_id = $request->paypal_client_id;
            $paypal->secret_id = $request->paypal_secret_key;
            $paypal->account_mode = $request->account_mode;
            $paypal->country_code = $request->country_name;
            $paypal->currency_code = $request->currency_name;
            $paypal->currency_rate = $request->currency_rate;
            $paypal->status = $request->status ? 1 : 0;
            $paypal->save();
        }

        $notification=trans('user_validation.Updated Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }

    public function updateStripe(Request $request){

        $rules = [
            'stripe_key' => 'required',
            'stripe_secret' => 'required',
            'country_name' => 'required',
            'currency_name' => 'required',
            'currency_rate' => 'required',
        ];
        $customMessages = [
            'stripe_key.required' => trans('user_validation.Stripe key is required'),
            'stripe_secret.required' => trans('user_validation.Stripe secret is required'),
            'country_name.required' => trans('user_validation.Country name is required'),
            'currency_name.required' => trans('user_validation.Currency name is required'),
            'currency_rate.required' => trans('user_validation.Currency rate is required'),
        ];
        $this->validate($request, $rules,$customMessages);

        $doctor = Auth::guard('doctor')->user();
        $stripe = DoctorStripe::where('doctor_id', $doctor->id)->first();
        if($stripe){
            $stripe->doctor_id = $doctor->id;
            $stripe->stripe_key = $request->stripe_key;
            $stripe->stripe_secret = $request->stripe_secret;
            $stripe->country_code = $request->country_name;
            $stripe->currency_code = $request->currency_name;
            $stripe->currency_rate = $request->currency_rate;
            $stripe->status = $request->status ? 1 : 0;
            $stripe->save();
        }else{
            $stripe = new DoctorStripe();
            $stripe->doctor_id = $doctor->id;
            $stripe->stripe_key = $request->stripe_key;
            $stripe->stripe_secret = $request->stripe_secret;
            $stripe->country_code = $request->country_name;
            $stripe->currency_code = $request->currency_name;
            $stripe->currency_rate = $request->currency_rate;
            $stripe->status = $request->status ? 1 : 0;
            $stripe->save();
        }


        $notification=trans('user_validation.Updated Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }

    public function updateRazorpay(Request $request){
        $rules = [
            'razorpay_key' => 'required',
            'razorpay_secret' => 'required',
            'currency_rate' => 'required',
            'currency_name' => 'required',
            'country_name' => 'required',
        ];
        $customMessages = [
            'razorpay_key.required' => trans('user_validation.Razorpay key is required'),
            'razorpay_secret.required' => trans('user_validation.Razorpay secret is required'),
            'country_name.required' => trans('user_validation.Country name is required'),
            'currency_name.required' => trans('user_validation.Currency name is required'),
            'currency_rate.required' => trans('user_validation.Currency rate is required'),
        ];
        $this->validate($request, $rules,$customMessages);

        $doctor = Auth::guard('doctor')->user();
        $razorpay = DoctorRazorpay::where('doctor_id', $doctor->id)->first();
        if($razorpay){
            $razorpay->doctor_id = $doctor->id;
            $razorpay->key = $request->razorpay_key;
            $razorpay->secret_key = $request->razorpay_secret;
            $razorpay->currency_rate = $request->currency_rate;
            $razorpay->country_code = $request->country_name;
            $razorpay->currency_code = $request->currency_name;
            $razorpay->status = $request->status ? 1 : 0;
            $razorpay->save();
        }else{
            $razorpay = new DoctorRazorpay();
            $razorpay->doctor_id = $doctor->id;
            $razorpay->key = $request->razorpay_key;
            $razorpay->secret_key = $request->razorpay_secret;
            $razorpay->currency_rate = $request->currency_rate;
            $razorpay->country_code = $request->country_name;
            $razorpay->currency_code = $request->currency_name;
            $razorpay->status = $request->status ? 1 : 0;
            $razorpay->save();
        }

        $notification=trans('user_validation.Update Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }

    public function updateBank(Request $request){
        $rules = [
            'account_info' => 'required'
        ];
        $customMessages = [
            'account_info.required' => trans('user_validation.Account information is required'),
        ];
        $this->validate($request, $rules,$customMessages);
        $doctor = Auth::guard('doctor')->user();
        $bank = DoctorBankPayment::where('doctor_id', $doctor->id)->first();
        if($bank){
            $bank->doctor_id = $doctor->id;
            $bank->account_info = $request->account_info;
            $bank->status = $request->status ? 1 : 0;
            $bank->save();
        }else{
            $bank = new DoctorBankPayment();
            $bank->doctor_id = $doctor->id;
            $bank->account_info = $request->account_info;
            $bank->status = $request->status ? 1 : 0;
            $bank->hand_cash_status = 0;
            $bank->save();
        }

        $notification=trans('user_validation.Update Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);

    }

    public function updateMollie(Request $request){
        $rules = [
            'mollie_key' => $request->status ? 'required' : '',
            'mollie_currency_rate' => $request->status ? 'required|numeric' : '',
            'mollie_country_name' => $request->status ? 'required' : '',
            'mollie_currency_name' => $request->status ? 'required' : ''
        ];

        $customMessages = [
            'mollie_key.required' => trans('user_validation.Mollie key is required'),
            'mollie_country_name.required' => trans('user_validation.Country name is required'),
            'mollie_currency_name.required' => trans('user_validation.Currency name is required'),
            'mollie_currency_rate.required' => trans('user_validation.Currency rate is required'),
        ];
        $this->validate($request, $rules,$customMessages);

        $doctor = Auth::guard('doctor')->user();
        $mollie = DoctorMollie::where('doctor_id', $doctor->id)->first();
        if($mollie){
            $mollie->doctor_id = $doctor->id;
            $mollie->mollie_key = $request->mollie_key;
            $mollie->currency_rate = $request->mollie_currency_rate;
            $mollie->currency_code = $request->mollie_currency_name;
            $mollie->country_code = $request->mollie_country_name;
            $mollie->status = $request->status ? 1 : 0;
            $mollie->save();
        }else{
            $mollie = new DoctorMollie();
            $mollie->doctor_id = $doctor->id;
            $mollie->mollie_key = $request->mollie_key;
            $mollie->currency_rate = $request->mollie_currency_rate;
            $mollie->currency_code = $request->mollie_currency_name;
            $mollie->country_code = $request->mollie_country_name;
            $mollie->status = $request->status ? 1 : 0;
            $mollie->save();
        }

        $notification=trans('user_validation.Update Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }

    public function updatePayStack(Request $request){
        $rules = [
            'paystack_public_key' => 'required',
            'paystack_secret_key' => 'required',
            'paystack_currency_rate' => 'required',
            'paystack_currency_name' => 'required',
            'paystack_country_name' => 'required'
        ];

        $customMessages = [
            'paystack_public_key.required' => trans('user_validation.Paystack public key is required'),
            'paystack_secret_key.required' => trans('user_validation.Paystack secret key is required'),
            'paystack_currency_rate.required' => trans('user_validation.Currency rate is required'),
            'paystack_currency_name.required' => trans('user_validation.Currency name is required'),
            'paystack_country_name.required' => trans('user_validation.Country rate is required'),
        ];
        $this->validate($request, $rules,$customMessages);

        $doctor = Auth::guard('doctor')->user();
        $paystack = DoctorPaystack::where('doctor_id', $doctor->id)->first();
        if($paystack){
            $paystack->doctor_id = $doctor->id;
            $paystack->public_key = $request->paystack_public_key;
            $paystack->secret_key = $request->paystack_secret_key;
            $paystack->currency_code = $request->paystack_currency_name;
            $paystack->country_code = $request->paystack_country_name;
            $paystack->currency_rate = $request->paystack_currency_rate;
            $paystack->status = $request->status ? 1 : 0;
            $paystack->save();
        }else{
            $paystack = new DoctorPaystack();
            $paystack->doctor_id = $doctor->id;
            $paystack->public_key = $request->paystack_public_key;
            $paystack->secret_key = $request->paystack_secret_key;
            $paystack->currency_code = $request->paystack_currency_name;
            $paystack->country_code = $request->paystack_country_name;
            $paystack->currency_rate = $request->paystack_currency_rate;
            $paystack->status = $request->status ? 1 : 0;
            $paystack->save();
        }

        $notification=trans('user_validation.Update Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }

    public function updateflutterwave(Request $request){
        $rules = [
            'public_key' => 'required',
            'secret_key' => 'required',
            'currency_rate' => 'required',
            'currency_name' => 'required',
            'country_name' => 'required',
        ];
        $customMessages = [
            'public_key.required' => trans('user_validation.Public key is required'),
            'secret_key.required' => trans('user_validation.Secret key is required'),
            'currency_rate.required' => trans('user_validation.Currency rate is required'),
            'currency_name.required' => trans('user_validation.Currency name is required'),
            'country_name.required' => trans('user_validation.Country name is required'),
        ];
        $this->validate($request, $rules,$customMessages);

        $flutterwave = DoctorFlutterwave::first();
        $doctor = Auth::guard('doctor')->user();
        if($flutterwave){
            $flutterwave->doctor_id = $doctor->id;
            $flutterwave->public_key = $request->public_key;
            $flutterwave->secret_key = $request->secret_key;
            $flutterwave->currency_rate = $request->currency_rate;
            $flutterwave->country_code = $request->country_name;
            $flutterwave->currency_code = $request->currency_name;
            $flutterwave->status = $request->status ? 1 : 0;
            $flutterwave->save();
        }else{
            $flutterwave = new DoctorFlutterwave();
            $flutterwave->doctor_id = $doctor->id;
            $flutterwave->public_key = $request->public_key;
            $flutterwave->secret_key = $request->secret_key;
            $flutterwave->currency_rate = $request->currency_rate;
            $flutterwave->country_code = $request->country_name;
            $flutterwave->currency_code = $request->currency_name;
            $flutterwave->status = $request->status ? 1 : 0;
            $flutterwave->save();
        }

        $notification=trans('user_validation.Update Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }


    public function updateInstamojo(Request $request){
        $rules = [
            'account_mode' => 'required',
            'api_key' => 'required',
            'auth_token' => 'required',
            'currency_rate' => 'required',
        ];
        $customMessages = [
            'account_mode.required' => trans('user_validation.Account mode is required'),
            'api_key.required' => trans('user_validation.Api key is required'),
            'currency_rate.required' => trans('user_validation.Currency rate is required'),
            'auth_token.required' => trans('user_validation.Auth token is required'),
        ];
        $this->validate($request, $rules,$customMessages);

        $doctor = Auth::guard('doctor')->user();
        $instamojo = DoctorInstamojo::where('doctor_id', $doctor->id)->first();

        if($instamojo){
            $instamojo->doctor_id = $doctor->id;
            $instamojo->account_mode = $request->account_mode;
            $instamojo->api_key = $request->api_key;
            $instamojo->auth_token = $request->auth_token;
            $instamojo->currency_rate = $request->currency_rate;
            $instamojo->status = $request->status ? 1 : 0;
            $instamojo->save();
        }else{
            $instamojo = new DoctorInstamojo();
            $instamojo->doctor_id = $doctor->id;
            $instamojo->account_mode = $request->account_mode;
            $instamojo->api_key = $request->api_key;
            $instamojo->auth_token = $request->auth_token;
            $instamojo->currency_rate = $request->currency_rate;
            $instamojo->status = $request->status ? 1 : 0;
            $instamojo->save();
        }

        $notification=trans('user_validation.Update Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }

    public function updateCashOnDelivery(Request $request){
        $doctor = Auth::guard('doctor')->user();
        $bank = DoctorBankPayment::where('doctor_id', $doctor->id)->first();

        if($bank->hand_cash_status==1){
            $bank->hand_cash_status=0;
            $bank->save();
            $message= trans('user_validation.Inactive Successfully');
        }else{
            $bank->hand_cash_status=1;
            $bank->save();
            $message= trans('user_validation.Active Successfully');
        }
        return response()->json($message);
    }

}
