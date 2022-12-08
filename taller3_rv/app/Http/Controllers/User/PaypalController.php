<?php

namespace App\Http\Controllers\User;

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
use App\Mail\AppointmentNotification;
use App\Helpers\MailHelper;
use App\Models\EmailTemplate;
use App\Models\DoctorPaypal;
use App\Models\AppointmentOrder;
use App\Models\Doctor;
use App\Models\Schedule;
use App\Models\Appointment;
use Str;
use Cart;
use Mail;
use Session;
use Auth;
use Carbon\Carbon;
class PaypalController extends Controller
{
    private $apiContext;
    public function __construct()
    {
        $account = DoctorPaypal::first();
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


    public function payWithPaypal(){

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

        $paypalSetting = DoctorPaypal::first();
        $payableAmount = round($total_fee * $paypalSetting->currency_rate,2);

        $name = env('APP_NAME');

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
        $redirectUrls->setReturnUrl(route('paypal-payment-success'))
            ->setCancelUrl(route('paypal-payment-cancled'));

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
            return redirect()->route('our-experts')->with($notification);
        }

        // get paymentlink
        $approvalUrl = $payment->getApprovalLink();

        return redirect($approvalUrl);
    }

    public function paypalPaymentSuccess(Request $request){
        if (empty($request->get('PayerID')) || empty($request->get('token'))) {

            $notification = trans('user_validation.Payment Faild');
            $notification = array('messege'=>$notification,'alert-type'=>'error');
            return redirect()->route('our-experts')->with($notification);

        }

        $payment_id=$request->get('paymentId');
        $payment = Payment::get($payment_id, $this->apiContext);
        $execution = new PaymentExecution();
        $execution->setPayerId($request->get('PayerID'));
        /**Execute the payment **/
        $result = $payment->execute($execution, $this->apiContext);

        if ($result->getState() == 'approved') {
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
            $order->transaction_id = $payment_id;
            $order->payment_method = 'Paypal';
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

    public function paypalPaymentCancled(){
        $notification = trans('user_validation.Payment Faild');
        $notification = array('messege'=>$notification,'alert-type'=>'error');
        return redirect()->route('our-experts')->with($notification);
    }


}
