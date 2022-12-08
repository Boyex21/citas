<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\MaintainanceText;
use Cache;
class MaintainaceMode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $maintainance = Cache::rememberForever('maintainance', function(){
            return MaintainanceText::first();
        });

        if($maintainance->status == 1){
            return response()->view('maintainace_mode');
        }
        return $next($request);
    }
}
