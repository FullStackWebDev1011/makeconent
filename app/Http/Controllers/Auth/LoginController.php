<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Logs;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

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

    use AuthenticatesUsers {
        login as parentLogin;
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request) {
        $request->validate([
            'email'=>'required|email|exists:users',
            'password'=>'required'
        ]);
        $email = $request['email'];
        $user = User::where('email',$email)->first();
        if(!isset($user)) {
            return redirect()->back()->withErrors(['account'=>'Your account is not found'])->withInput();
        }else if(!Hash::check($request['password'], $user['password'])) {
            return redirect()->back()->withErrors(['account'=>'Your password is wrong'])->withInput();
        }else if($user['status'] == 'pending') {
            return redirect()->back()->withErrors(['account'=>'Your account not yet active - contact support to get more information'])->withInput();
        }else if($user['status'] == 'reject') {
            return redirect()->back()->withErrors(['account'=>'Your account is rejected - contact support to get more information'])->withInput();
        }else if($user['status'] == 'banned') {
            return redirect()->back()->withErrors(['account'=>'Your account is banned - contact support to get more information'])->withInput();
        }else if($user['status'] !== 'active') {
            return redirect()->back()->withErrors(['account'=>'Please contact support to get more information'])->withInput();
        }
        $ip = $request->ip();
        $agent = $request->userAgent();
        $log = new Logs();
        $log->user_id = $user['id'];
        $log->ip = $ip;
        $log->agent = $agent;
        $log->save();
        return $this->parentLogin($request);
    }
}
