<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\User;

class AccountConfirmation
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
        if(Auth::check()){
            if(Auth::user()->accountConfirmation !=0){                
                return $next($request);
            }else{
                return redirect('email/not-verified');
            }
        }else{
            return redirect('login');
        }
        
    }
}
