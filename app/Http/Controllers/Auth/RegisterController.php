<?php

namespace App\Http\Controllers\Auth;

use App\Countries;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Setting;
use App\User;
use App\UserLevel;
use App\UserRenewals;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers {
        register as parentRegister;
    }

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'fname' => ['required', 'string', 'max:255'],
            'lname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            // 'request_string' => $data['userType'] === 'copywriter' ? ['required', 'string', 'min:700'] : [],
            'country' => ['required'],
        ]);
    }

    public function showRegistrationForm(Request $request)
    {
        $code = '';
        if(isset($request->code)) $code = $request->code; 
        $countries = Countries::where('status','active')->select()->get();
        return view('auth.register.client',['countries'=>$countries,'code'=>$code]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     *
     * @return \App\User
     */
    protected function create(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        if ($data['userType'] === 'client') {
            $data['status'] = 'active';
        }else if ($data['userType'] === 'copywriter') {
            $data['status'] = 'pending';
        }

        $settings = Setting::first();
        if(isset($settings)&&$settings['email_verification']=='active') $data['status'] = 'pending';

        $level = UserLevel::where('levelType',$data['userType'])->orderBy('id','desc')->first();
        
        $data['fullname'] = $data['fname'].' '.$data['lname'];
        $data['first_name'] = $data['fname'];
        $data['last_name'] = $data['lname'];
        $data['country_id'] = $data['country'];
        $data['level_id'] = $level['id'];
        $data['affiliated'] = $data['reff']?'active':'inactive';

        $user = User::create($data);
        $user->generateCode();
        return $user;
    }

    public function register(Request $request)
    {
        if(isset($request['code'])&&$request['code']){
            $user_affiliated = User::where('affiliate_code',$request['code'])->first();
            if(!isset($user_affiliated))  return redirect()->back()->withErrors(['account'=>'Your link of affiliate is not found'])->withInput();

            $renewals = new UserRenewals();
            $renewals->code = $request['code'];
            $renewals->email = $request['email'];
            $renewals->amount = 7;
            $renewals->save();
            $request->request->add(['reff' => 1]);
        }else{
            $request->request->add(['reff' => 0]);
        }
        return $this->parentRegister($request);
    }
}
