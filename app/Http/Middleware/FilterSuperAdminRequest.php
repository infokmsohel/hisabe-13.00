<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class FilterSuperAdminRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(env('ADMINISTRATOR_USERNAMES') == Auth::user()->email || env('ADMINISTRATOR_USERNAMES') == Auth::user()->username){
            return $next($request);
        }else{
            return redirect('/home');
        }
    }
}
