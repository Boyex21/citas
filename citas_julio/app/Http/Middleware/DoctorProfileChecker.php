<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;
class DoctorProfileChecker
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
        if($doctor->profile_fillup == 0){
            $notification = trans('user_validation.Pleas fillup this form');
            $notification = array('messege'=>$notification,'alert-type'=>'error');
            return redirect()->route('doctor.profile')->with($notification);
        }
        return $next($request);
    }
}
