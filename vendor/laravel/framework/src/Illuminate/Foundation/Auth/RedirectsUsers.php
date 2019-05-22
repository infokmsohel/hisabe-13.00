<?php

namespace Illuminate\Foundation\Auth;

use DB;
use Auth;

trait RedirectsUsers
{
    /**
     * Get the post register / login redirect path.
     *
     * @return string
     */
    public function redirectPath($request)
    {
        //Remove User Session Lock Information 
        DB::table('session_locks')->where('userId','=',Auth::user()->id)->delete();
        
        // Redirect subscription page for first time register user
        if($request->rgister_type ==1){
            return '/subscription';
        }
        if (method_exists($this, 'redirectTo')) {
            return $this->redirectTo();
        }
        
        return property_exists($this, 'redirectTo') ? $this->redirectTo : '/home';
    }
}
