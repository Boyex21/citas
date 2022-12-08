<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;
class CheckUserProfile
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
        $authUser = Auth::guard('web')->user();
        if($authUser->fillup != 1){
            $notification = trans('user_validation.Please fillup your profile information');
            $notification=array('messege'=>$notification,'alert-type'=>'error');
            return redirect()->route('user.my-profile')->with($notification);
        }
        return $next($request);
    }
}
