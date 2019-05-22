<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\SessionLock;
use App\User;
use Auth;
use DB;


class SessionLockController extends Controller
{
    
    //Show Lock page 
    public function OpenLockPage() {
        return view('others.sessionLockPage');
    }
    
    // Session Lock Info Add and Lock The session    
    public function LockSession() {
        $lock = SessionLock::where('userId','=',Auth::user()->id)->first();
        if(empty($lock->id)){
            $data = new SessionLock();
            $data->userId = Auth::user()->id;
            $data->status = 1;
            $data->save();
        }        
        return view('others.sessionLockPage');
    }
    
    //Unlock Session Here
    public function UnlockSession(Request $request) {
        if($this->CheckUserData($request)){
            DB::table('session_locks')
                ->where('userId','=',Auth::user()->id)
                ->delete();        
            return redirect('/home');
        }else{
            return back()->with('error','Your password is incorrect.');
        }
    }
    
    protected function CheckUserData($request) {
        $user = User::find(Auth::user()->id);
        if(Hash::check($request->password,$user->password)){
            return true;
        }else{
            return false;
        }
    }
    
}
