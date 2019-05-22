<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\SessionLock;

class SessionLockMiddleware
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
            $lock = SessionLock::where('userId','=',Auth::user()->id)->first();
            if(isset($lock->userId) && $lock->userId > 0){  
                return redirect('user/inactive');                
            }else{
                return $next($request);
                
            }
            exit();
        }else{
            return redirect('login');
        }
    }
}
