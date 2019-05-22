<?php

namespace App\Http\Controllers;

use App\User;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;

use App\FileUpload;


class UserController extends Controller
{
    use FileUpload;
    /*
    |--------------------------------------------------------------------------
    | UserController
    |--------------------------------------------------------------------------
    |
    | This controller handles the manipualtion of user
    |
    */

    /**
     * Shows profile of logged in user
     *
     * @return \Illuminate\Http\Response
     */
    public function getProfile()
    {
        $user_id = request()->session()->get('user.id');
        $user = User::where('id', $user_id)->first();

        $config_languages = config('constants.langs');
        $languages = [];
        foreach ($config_languages as $key => $value) {
            $languages[$key] = $value['full_name'];
        }

        return view('user.profile', compact('user', 'languages'));
    }

    /**
     * updates user profile
     *
     * @return \Illuminate\Http\Response
     */
    public function updateProfile(Request $request)
    {
        //Redirect back if demo application
        if (config('app.env') == 'demo') {
            $output = ['success' => 0,
                            'msg' => 'This feature is disabled in demo'
                        ];
            return redirect('user/profile')->with('status', $output);
        }

        try {
            $user_id = $request->session()->get('user.id');
            $input = $request->only(['surname', 'first_name', 'last_name', 'email', 'language']);
            $user = User::where('id', $user_id)->update($input);
            
            $data = User::find($user_id);
            $business = Business::where('id',$data->business_id)->first();
            $dir ="uploads/business/". str_replace(' ','_',$business->name).'/profilePicture/'; 
            $this->CheckDir($dir);
            $data->profilePic = $this->UploadImage($request,'profilePic',$dir,'200','200',$data->profilePic);                 
            $data->save();

            //update session
            $input['id'] = $user_id;
            $business_id = request()->session()->get('user.business_id');
            $input['business_id'] = $business_id;
            session()->put('user', $input);

            $output = ['success' => 1,
                                'msg' => 'Profile updated successfully'
                            ];
        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            
            $output = ['success' => 0,
                            'msg' => 'Something went wrong, please try again'
                        ];
        }
        return redirect('user/profile')->with('status', $output);
    }
    
    /**
     * updates user password
     *
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(Request $request)
    {
        //Redirect back if demo application
        if (config('app.env') == 'demo') {
            $output = ['success' => 0,
                            'msg' => 'This feature is disabled in demo'
                        ];
            return redirect('user/profile')->with('status', $output);
        }

        try {
            $user_id = $request->session()->get('user.id');
            $user = User::where('id', $user_id)->first();
            
            if (Hash::check($request->input('current_password'), $user->password)) {
                $user->password = bcrypt($request->input('new_password'));
                $user->save();
                $output = ['success' => 1,
                                'msg' => 'Password updated successfully'
                            ];
            } else {
                $output = ['success' => 0,
                                'msg' => 'You have entered wrong password'
                            ];
            }
        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            
            $output = ['success' => 0,
                            'msg' => 'Something went wrong, please try again'
                        ];
        }
        return redirect('user/profile')->with('status', $output);
    }
}
