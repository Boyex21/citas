<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Order;
use Auth;
class CheckPricingPlan
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $doctor = Auth::guard('doctor')->user();
        $existOrder = Order::orderBy('id','desc')->where('doctor_id', $doctor->id)->where('payment_status', 1)->first();

        if(!$existOrder){
            $notification = trans('user_validation.To get our software advantage, you need to buy a subscription plan');
            $notification = array('messege'=>$notification,'alert-type'=>'error');
            return redirect()->route('doctor.pricing-plan')->with($notification);
        }

        return $next($request);
    }
}
