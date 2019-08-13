<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        if (\Cookie::get('show_comments') == null) {
            \Cookie::queue('show_comments', "1", 60*24*28);
        }
        
        activity('show')->log('Login');
    }

    public function authenticated($request, $user )
    {
        // First check if there is a user type defined.
        if (auth()->user()->survey_hexad != null && collect(JSON_decode(auth()->user()->survey_hexad))['userType'] != null) {
            
            $userType = collect(JSON_decode(auth()->user()->survey_hexad))['userType'];
            session(['userType' => $userType]);

            // Check if user type is Free Spirit
            if ($userType == "Free_Spirit") {
                if (collect(JSON_decode(auth()->user()->custom))['avatar_path'] != null) {
                    session(['avatar_path' => collect(JSON_decode(auth()->user()->custom))['avatar_path']]);
                } else {
                    session(['avatar_path' => null]);
                }
            }
        }
        
        return redirect()->intended($this->redirectPath());
    }

}
