<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\PaymentExecution;
use App\Models\BreadcrumbImage;
use App\Models\Country;
use App\Models\CountryState;
use App\Models\City;
use App\Models\Order;
use App\Models\Setting;
use App\Models\StripePayment;
use App\Mail\OrderSuccessfully;
use App\Helpers\MailHelper;
use App\Models\EmailTemplate;
use App\Models\PaypalPayment;
use App\Models\Package;
use Str;
use Cart;
use Mail;
use Session;
use Auth;
use Carbon\Carbon;
class DoctorPaypalController extends Controller
{
    private $apiContext;
    public function __construct()
    {
        $account = PaypalPayment::first();
        $paypal_conf = \Config::get('paypal');
        $this->apiContext = new ApiContext(new OAuthTokenCredential(
            $account->client_id,
            $account->secret_id,
            )
        );

        $setting=array(
            'mode' => $account->account_mode,
            'http.ConnectionTimeOut' => 30,
            'log.LogEnabled' => true,
            'log.FileName' => storage_path() . '/logs/paypal.log',
            'log.LogLevel' => 'ERROR'
        );
        $this->apiContext->setConfig($setting);
    }


    public function payWithPaypal($slug){
        $package = Package::where(['slug' => $slug, 'status' => 1])->first();
        $setting = Setting::first();
        $total_price = $package->price;
        $paypalSetting = PaypalPayment::first();
        $payableAmount = round($total_price * $paypalSetting->currency_rate,2);

        $name=env('APP_NAME');

        // set payer
        $payer = new Payer();
        $payer->setPaymentMethod("paypal");

        // set amount total
        $amount = new Amount();
        $amount->setCurrency($paypalSetting->currency_code)
            ->setTotal($payableAmount);

        // transaction
        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setDescription(env('APP_NAME'));

        // redirect url
        $redirectUrls = new RedirectUrls();

        $root_url=url('/');
        $redirectUrls->setReturnUrl(route('doctor.paypal-payment-success'))
            ->setCancelUrl(route('doctor.paypal-payment-cancled'));

        // payment
        $payment = new Payment();
        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions(array($transaction));
        try {
            $payment->create($this->apiContext);
        } catch (\PayPal\Exception\PPConnectionException $ex) {

            $notification = trans('user_validation.Payment Faild');
            $notification = array('messege'=>$notification,'alert-type'=>'error');
            return redirect()->route('user.checkout.payment')->with($notification);
        }

        // get paymentlink
        $approvalUrl = $payment->getApprovalLink();
        Session::put('package_slug', $package->slug);

        return redirect($approvalUrl);
    }

    public function paypalPaymentSuccess(Request $request){
        if (empty($request->get('PayerID')) || empty($request->get('token'))) {

            $notification = trans('user_validation.Payment Faild');
            $notification = array('messege'=>$notification,'alert-type'=>'error');
            return redirect()->route('payment')->with($notification);

        }

        $payment_id=$request->get('paymentId');
        $payment = Payment::get($payment_id, $this->apiContext);
        $execution = new PaymentExecution();
        $execution->setPayerId($request->get('PayerID'));
        /**Execute the payment **/
        $result = $payment->execute($execution, $this->apiContext);

        if ($result->getState() == 'approved') {

            $slug = Session::get('package_slug');
            $doctor = Auth::guard('doctor')->user();
            $package = Package::where(['slug' => $slug, 'status' => 1])->first();
            $setting = Setting::first();
            $total_price = $package->price;
            $paypalSetting = PaypalPayment::first();
            $payableAmount = round($total_price * $paypalSetting->currency_rate,2);


            $order = new Order();
            $order->order_id = substr(rand(0,time()),0,10);
            $order->doctor_id =  $doctor->id;
            $order->package_id = $package->id;
            $order->package_name =  $package->name;
            $order->purchase_date =  date('Y-m-d');
            $order->expired_day =  $package->expiration_day;
            $order->expired_date =  $package->expiration_day ==-1 ? null : date('Y-m-d', strtotime($package->expiration_day.' days'));
            $order->payment_method = 'Paypal';
            $order->transaction_id = $payment_id;
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

            Order::where('doctor_id', $doctor->id)->where('id', '!=', $order->id)->update(['status' => 2]);

            MailHelper::setMailConfig();

            $template=EmailTemplate::where('id',6)->first();
            $subject=$template->subject;
            $message=$template->description;
            $message = str_replace('{{user_name}}',$doctor->name,$message);
            $message = str_replace('{{total_amount}}',$setting->currency_icon.$payableAmount,$message);
            $message = str_replace('{{payment_method}}','Paypal',$message);
            $message = str_replace('{{payment_status}}','Success',$message);
            $message = str_replace('{{order_date}}',$order->created_at->format('Y-m-d'),$message);
            $message = str_replace('{{expired_date}}',$order->expired_date ,$message);
            $message = str_replace('{{package_name}}',$order->package_name,$message);

            Mail::to($doctor->email)->send(new OrderSuccessfully($subject,$message));

            $notification = trans('user_validation.Payment Successfully');
            $notification = array('messege'=>$notification,'alert-type'=>'success');
            return redirect()->route('doctor.order')->with($notification);


        }
    }

    public function paypalPaymentCancled(){
        $notification = trans('user_validation.Payment Faild');
        $notification = array('messege'=>$notification,'alert-type'=>'error');
        return redirect()->route('doctor.pricing-plan')->with($notification);
    }


}
