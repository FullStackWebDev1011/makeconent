<?php

namespace App\Http\Controllers;

use App\Category;
use App\Countries;
use App\Document;
use App\Events\AddFoundsEvent;
use App\Events\CopywriterAcceptEvent;
use App\Events\MarketplaceTextOrderEvent;
use App\Events\ProjectNewTextEvent;
use App\Events\ProjectNotReservedEvent;
use App\Events\ProjectTextAcceptedEvent;
use App\Events\WithdrawMoneyEvent;
use App\Invoice;
use App\Logs;
use App\Mail\ConfirmEmailMail;
use App\Project;
use App\Sell;
use App\Setting;
use App\Taxoffice;
use App\Transaction;
use App\User;
use App\UserRenewals;
use App\Wallet;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Languages;

class HomeController extends BaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'active']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $menu = 'dashboard';
        $submenu = '';
        $role = Auth::user()->role();
        $userId = Auth::user()->id;
        if ($role === 'client') {
            $spend_this_month = 0;
            $spend_total = 0;

            // calculate spend_money type: order, buy and refund;
            $transactions = Transaction::where('user_id', $userId)
                                       ->whereIn('type', ['order', 'buy', 'refund'])->orderBy('created_at', 'desc')
                                       ->get();

            $open_projects = Project::where('status', 'open')->where('user_id', $userId)->count();
            $sketch_projects = Project::where('status', 'sketch')->where('user_id', $userId)->count();
            $waiting_projects = Project::where('status', 'pending')->where('user_id', $userId)->count();

            $total_projects = $open_projects + $sketch_projects + $waiting_projects;

            foreach ($transactions as $transaction) {
                if ($transaction->type === 'refund') {
                    if ($this->checkThisMonth($transaction->created_at)) {
                        $spend_this_month -= $transaction->qty;
                    }
                    $spend_total -= $transaction->qty;
                } else {
                    if ($this->checkThisMonth($transaction->created_at)) {
                        $spend_this_month += $transaction->qty;
                    }
                    $spend_total += $transaction->qty;
                }
            }
            $latest_orders = Project::whereIn('status', ['open', 'sketch'])->where('user_id', $userId)
                                    ->orderBy('created_at', 'desc')->take(5)->get();

            return view('home', compact('menu', 'submenu',
                'spend_this_month', 'spend_total', 'open_projects', 'sketch_projects',
                'waiting_projects', 'latest_orders', 'total_projects'));
        }
        if ($role === 'copywriter') {
            $earn_today = 0;
            $earn_thismonth = 0;
            $earn_total = 0;

            $waiting_complete =
                Project::whereNotNull('text')->where('seller_id', $userId)->where('status', 'pending')->count();
            $accepted_complete = Project::where('status', 'pending')->where('seller_id', $userId)->count();
            $total_projects = Project::where('seller_id', $userId)->count();

            $transactions = Transaction::whereIn('type', ['sell', 'order'])->where('user_id', $userId)
                                       ->orderBy('created_at', 'desc')->get();
            foreach ($transactions as $transaction) {
                $earn_total += $transaction->qty;
                if ($this->checkToday($transaction->created_at)) {
                    $earn_today += $transaction->qty;
                }
                if ($this->checkThisMonth($transaction->created_at)) {
                    $earn_thismonth += $transaction->qty;
                }
            }

            $pending_projects = Project::where('status', 'pending')->where('seller_id', $userId)->take(5)->get();

            return view('freelancerHome', compact('menu', 'submenu', 'earn_today', 'earn_thismonth',
                'waiting_complete', 'accepted_complete', 'pending_projects', 'earn_total', 'total_projects'));
        }
        if (in_array($role,['admin','support'])) {
            $menu = "dashboard";
            $submenu = "";
            $orders_today = Project:: where('status', 'open')->where('created_at', 'like', date('Y-m-d').'%')->count();
            $earns = Transaction::where('type', 'fee')->orderBy('created_at', 'desc')->get();
            $earns_today = 0;
            $earns_total = 0;
            foreach ($earns as $earn) {
                $earns_total += $earn->qty;
                if ($this->checkToday($earn->created_at)) {
                    $earns_today += $earn->qty;
                }
            }
            $sales = [];
            foreach(range(1,12) as $month){
                $sales['thisMonth'][] = Transaction::whereIn('type',['sell','order'])->where(['status'=>'finish'])->whereRaw('year(created_at) = ? and month(created_at) = ?',[date('Y'),$month])->sum('qty');
                $sales['lastMonth'][] = Transaction::whereIn('type',['sell','order'])->where(['status'=>'finish'])->whereRaw('year(created_at) = ? and month(created_at) = ?',[date('Y',strtotime('- 1 year')),$month])->sum('qty');
            }

            $users = User::UserLevel()->where('levelType', 'client')->count();
            $copywriters = User::UserLevel()->where('levelType', 'copywriter')->count();

            return view('admin.index',
                compact('menu', 'submenu', 'orders_today', 'earns_today', 'earns_total','sales','users', 'copywriters'));
        }
    }

    private function getHMfromTimeDiff($deadline_hours, $dd)
    {
        $timediff = strtotime($dd) - strtotime('-'.$deadline_hours.' hours');
        $hours = floor($timediff / 3600);
        $mins = floor(($timediff - $hours * 3600) / 60);
        $res = '';
        if ($hours !== 0) {
            $res = $hours.' h ';
        }
        if ($mins !== 0) {
            $res .= ($mins.' m');
        }

        return $res;
    }

    private function checkThisMonth($date)
    {
        $thisyear = date('Y');
        $thismonth = date('m');
        $today = date('d');

        $timestamp = strtotime($date);
        $dy = date('Y', $timestamp);
        $dm = date('m', $timestamp);
        $dd = date('d', $timestamp);
        if ($thisyear === $dy && $thismonth === $dm) {
            return true;
        }

        return false;
    }

    private function checkToday($date)
    {
        $thisyear = date('Y');
        $thismonth = date('m');
        $today = date('d');

        $timestamp = strtotime($date);
        $dy = date('Y', $timestamp);
        $dm = date('m', $timestamp);
        $dd = date('d', $timestamp);
        if ($thisyear === $dy && $thismonth === $dm && $today === $dd) {
            return true;
        }

        return false;
    }

    /**
     * Show the copywriter list page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function copylist()
    {
        $menu = 'copywriter';
        $submenu = '';
        $copywriters = User::UserLevel()->where('levelType', 'copywriter')->orderBy('users.created_at', 'desc')->get();

        return view('copywriter.list', compact('menu', 'submenu', 'copywriters'));
    }


    /**
     * Show Affilate list page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function affilate()
    {
        $menu = 'affilate';
        $submenu = 'affilate';
        $data = UserRenewals::where('code',Auth::user()->affiliate_code)->with(['user'=>function($q){
            $q->leftjoin('user_level', function($join) {
                $join->on('users.level_id', '=',  'user_level.id');
            })->select('users.first_name','users.email','user_level.levelType');
        }]);
        $dataUnpaid = (clone $data)->where('status','unpaid');
        $renewals = (clone $data)->limit(4)->get();

        $total = (clone $dataUnpaid)->sum('amount');
        $monthly = (clone $dataUnpaid)->whereRaw('year(created_at) = ? and month(created_at) = ?',[date('Y'),date('m')])->sum('amount');
        $daily = (clone $dataUnpaid)->whereRaw('date(created_at) = ? ',[date('Y-m-d')])->sum('amount');

        $chart_total = [];
        $chart_monthly = [];
        $chart_daily = [];
        foreach (range(6,0) as $value) {
            $chart_total[] = (clone $dataUnpaid)->whereRaw('year(created_at) = ? and month(created_at) = ?',[date('Y'),date('m',strtotime("- $value months"))])->sum('amount');
            $chart_monthly[] = (clone $dataUnpaid)->whereRaw('year(created_at) = ? and month(created_at) = ? and day(created_at) = ?',[date('Y'),date('m'),date('d',strtotime("- $value days"))])->sum('amount');
            $chart_daily[] = (clone $dataUnpaid)->whereRaw('year(created_at) = ? and month(created_at) = ? and day(created_at) = ? and hour(created_at) = ?',[date('Y'),date('m'),date('d'),date('H',strtotime("- $value hours"))])->sum('amount');
        }
        // return dd($x);

        return view('affilate.index', compact('menu', 'submenu', 'renewals', 'total', 'monthly','daily','chart_total','chart_monthly','chart_daily'));
    }

    public function affilate_all(){
        $menu = 'affilate';
        $submenu = 'affilate-all';
        $data = UserRenewals::where('code',Auth::user()->affiliate_code)->with(['user'=>function($q){
            $q->leftjoin('user_level', function($join) {
                $join->on('users.level_id', '=',  'user_level.id');
            })->select('users.first_name','users.email','user_level.levelType');
        }]);
        $total = (clone $data)->sum('amount');
        $renewals = (clone $data)->get();
        return view('affilate.all', compact('menu', 'submenu', 'renewals', 'total'));
    }

    /**
     * Show the Settings page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function settings()
    {
        $menu = 'settings';
        $submenu = '';
        $user = Auth::user();
        if(isset($user['phone'])&&isset($user['phone_prefix'])){
            $user['phone'] = $user['phone_prefix'].$user['phone'];
        }
        $role = $user->role();
        $tax_offices = Taxoffice::all();
        $countries = Countries::where('status','active')->select()->get();;
        $logs = Logs::where('user_id', $user->id)->orderBy('created_at', 'desc')->take(5)->get();
        if ($role === 'client') {
            return view('settings', compact('menu', 'submenu', 'user', 'tax_offices','countries', 'logs'));
        } else {
            $categories = Category::all();
            $languages = Languages::lookup();

            return view('freelancer_settings', compact('menu', 'submenu',
                'user', 'tax_offices','countries', 'logs', 'categories', 'languages'));
        }
    }

    public function profile(User $user = null)
    {
        $menu = 'profile';
        $submenu = '';

        if ($user === null) {
            $user = auth()->user();

            if (auth()->user()->role() !== User::TYPE_FREELANCER) {
                return redirect(route('settings'));
            }
        }

        return view('copywriter_profile', [
            'menu' => $menu,
            'submenu' => $submenu,
            'user' => $user->load(['reviews', 'reviews.owner']),
        ]);
    }

    public function saveAbout(Request $request)
    {
        auth()->user()->update(['about' => $request->about]);

        return response()->json(['status' => 'ok']);
    }

    public function saveCategories(Request $request)
    {
        auth()->user()->categories()->sync($request->categories);

        return response()->json(['status' => 'ok']);
    }

    public function saveLanguages(Request $request)
    {
        auth()->user()->update(['languages' => $request->languages]);

        return response()->json(['status' => 'ok']);
    }

    public function settings_client_save(Request $request)
    {
        $validate = [
            'lname' => 'required|string|max:191',
            'fname' => 'required|string|max:191',
            // 'email' => 'required|string|email|max:191',
            'phone' => 'required|string|max:18',
        ];
        if($request->isCompany) $validate = array_merge($validate,[
            'comp_street' => ['required', 'string', 'max:255'],
            'comp_apartment_number' => ['required', 'string', 'max:255'],
            'comp_city' => ['required', 'string', 'max:255'],
            'comp_post_code' => ['required', 'string', 'max:255'],
        ]);
        else $validate = array_merge($validate,[
            'street' => ['required', 'string', 'max:255'],
            'apartment_number' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'post_code' => ['required', 'string', 'max:255'],
        ]);
        $this->validate($request, $validate);

        $file = $request->file('avatar');
        $phonePrefix = $request->phone_prefix?$request->phone_prefix:'+1';
        $user = auth()->user();
        if (isset($file)) {
//        $file->storeAs('public', 'user'.$userId.'.'.$file->getClientOriginalExtension());
            move_uploaded_file($_FILES['avatar']['tmp_name'],
                public_path('upload'.DIRECTORY_SEPARATOR.$file->getClientOriginalName()));
//
            $user->avatar = 'upload'.DIRECTORY_SEPARATOR.$file->getClientOriginalName();
        }
        $user->fullname = $request->fname.' '.$request->lname;
        $user->first_name = $request->fname;
        $user->last_name = $request->lname;
        // $user->email = $request->email;
        $user->phone_prefix = '+'.preg_replace("/[^0-9]/", "", $phonePrefix);
        $user->phone = mobileNumber($request->phone,$phonePrefix);
        $user->userType = 'client';

        if ($request->isCompany) {
            $user->isCompany = true;
            $user->companyName = $request->companyName;
            $user->comp_apartment_number = $request->comp_apartment_number;
            $user->comp_street = $request->comp_street;
            $user->comp_city = $request->comp_city;
            $user->comp_post_code = $request->comp_post_code;
            $user->vat_number = $request->vat_number;
        } else {
            $user->isCompany = false;
            $user->apartment_number = $request->apartment_number;
            $user->street = $request->street;
            $user->city = $request->city;
            $user->post_code = $request->post_code;
        }

        $user->save();

        return redirect()->back()->with(['success' => true]);
    }


    public function settings_copywriter_save(Request $request)
    {
        $this->validate($request, [
            'lname' => 'required|string|max:191',
            'fname' => 'required|string|max:191',
            // 'email' => 'required|string|email|max:191',
            'phone' => 'required|string|max:18',
            // personal
            'street' => ['required', 'string', 'max:191'],
            'apartment_number' => ['required', 'string', 'max:191'],
            'city' => ['required', 'string', 'max:191'],
            'post_code' => ['required', 'string', 'max:191'],
            'bank_account' => ['required', 'string', 'max:191'],
            'tax_office_id' => $request->isCompany ? [] : ['required'],
            // company
            'companyName' => $request->isCompany ? ['string', 'max:191'] : [],
            'vat_number' => $request->isCompany ? ['string', 'max:191'] : [],
        ]);

        if(isset($request->languages)){
            if(count($request->languages)>3){
                return redirect()->back()->withErrors(['account'=>'Your languages is more then 3']);
            }
        }

        $file = $request->file('avatar');
        $userId = Auth::user()->id;
        $user = User::find($userId);
        $phonePrefix = $request->phone_prefix?$request->phone_prefix:'+1';
        if (isset($file)) {
        // $file->storeAs('public', 'user'.$userId.'.'.$file->getClientOriginalExtension());
            move_uploaded_file($_FILES['avatar']['tmp_name'],
                public_path('upload'.DIRECTORY_SEPARATOR.$file->getClientOriginalName()));

            $user->avatar = 'upload'.DIRECTORY_SEPARATOR.$file->getClientOriginalName();
        }
        $user->fullname = $request->fname.' '.$request->lname;
        $user->first_name = $request->fname;
        $user->last_name = $request->lname;
        // $user->email = $request->email;
        $user->street = $request->street;
        $user->apartment_number = $request->apartment_number;
        $user->city = $request->city;
        $user->post_code = $request->post_code;

        $user->phone_prefix = '+'.preg_replace("/[^0-9]/", "", $phonePrefix);
        $user->phone = mobileNumber($request->phone,$phonePrefix);
        $user->companyName = $request->companyName;
        $user->bank_account = $request->bank_account;
        $user->vat_number = $request->vat_number;
        $user->tax_office_id = $request->tax_office_id;
        $user->userType = 'copywriter';
        $user->isCompany = $request->isCompany;
        $user->save();

        return redirect()->back()->with(['success' => true]);
    }

    /**
     * Show the support page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function support()
    {
        $menu = 'support';
        $submenu = '';

        return view('support', compact('menu', 'submenu'));
    }

    public function about_us()
    {
        return view('homepage.about_us');
    }

    public function question()
    {
        return view('homepage.questions');
    }

    public function for_agency()
    {
        return view('homepage.for-agency');
    }

    public function for_copywriter()
    {
        return view('homepage.for-copywriters');
    }

    public function help_center()
    {
        return view('homepage.help_center');
    }

    public function knowledgebase()
    {
        return view('homepage.knowledgebase');
    }

    public function agreement()
    {
        return view('homepage.agreement');
    }

    public function contact()
    {
        return view('homepage.contact');
    }

    /**
     * Save password
     *
     * @param Request $request
     */
    public function password_save(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);
        $id = Auth::user()->id;
        $password = $request->get('password');
        $user = User::find($id);
        $user->password = Hash::make($password);
        $user->save();

        return redirect()->back()->with(['success' => true, 'message' => 'Password has been updated successfully']);
    }

    public function switchLang($locale){
        Session::put('applocale', $locale);
        return Redirect::back();
    }

}
