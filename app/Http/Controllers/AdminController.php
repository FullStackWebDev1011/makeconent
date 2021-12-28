<?php

namespace App\Http\Controllers;

use App\BonusCode;
use App\Category;
use App\Countries;
use App\Document;
use App\Events\CopywriterAcceptEvent;
use App\Invoice;
use App\Logs;
use App\Message;
use App\PayU;
use App\Project;
use App\Sell;
use App\Services\InvoiceService;
use App\Setting;
use App\Taxoffice;
use App\Transaction;
use App\User;
use App\UserLevel;
use App\Wallet;
use App\Withdraw;
use Carbon\Carbon;
use Hamcrest\Core\Set;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;

class AdminController extends BaseController
{
    public $invoiceService;

    public function __construct(InvoiceService $invoiceService)
    {
        $this->invoiceService = $invoiceService;

        $this->middleware(['auth', 'admin', 'active']);
    }

    /**
     * Show all users (clients)
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function users_all()
    {
        $menu = 'members';
        $submenu = 'users';
        $users = User::UserLevel()->where('levelType', 'client')->get();

        return view('admin.users', compact('menu', 'submenu', 'users'));
    }

    /**
     * Show all markets
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function markets_all()
    {
        $menu = 'markets';
        $submenu = '';
        $markets = Sell::orderBy('created_at', 'desc')->get();

        return view('admin.markets', compact('menu', 'submenu', 'markets'));
    }

    /**
     * Show all copywriters
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function copywriters_all()
    {
        $menu = 'members';
        $submenu = 'copywriters';
        $users = User::UserLevel()->where('levelType', 'copywriter')->where('users.status', 'active')->get();

        return view('admin.copywriters', compact('menu', 'submenu', 'users'));
    }

    public function copywriters_waiter()
    {
        $menu = 'members';
        $submenu = 'waiter';
        $users = User::UserLevel()->where('levelType', 'copywriter')->where('users.status', 'pending')->get();

        return view('admin.copywriters_waiter', compact('menu', 'submenu', 'users'));
    }

    public function member_waiter()
    {
        $menu = 'members';
        $submenu = 'waiter';
        $users = User::UserLevel()->where('users.status', 'pending')->get();

        return view('admin.member_waiter', compact('menu', 'submenu', 'users'));
    }

    /**
     * Approve member
     *
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function member_approve($id)
    {
        $user = User::find($id);
        $user->status = 'active';
        $user->save();

        // event(new CopywriterAcceptEvent($user));

        return redirect()->back()->with(['success' => $user->name.' is approved']);
    }

    /**
     * Block member
     *
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function member_block($id)
    {
        $user = User::find($id);
        $user->status = 'reject';
        $user->save();

        return redirect()->back()->with(['success' => $user->name.' is blocked']);
    }

    /**
     * Show member
     *
     * @param $id
     */
    public function member_view($id)
    {
        $menu = 'members';
        $submenu = '';
        $member = User::UserLevel()->find($id);
        if ($member['levelType'] === 'client') {
            $open_projects = Project::where('status', 'open')->count();
            $history_projects = Project::whereIn('status', ['finish', 'accepted', 'cancel'])->count();
            $spend_total = 0;
            $transactions = Transaction::where('user_id', $id)
                                       ->whereIn('type', ['order', 'buy', 'refund'])->orderBy('created_at', 'desc')
                                       ->get();
            foreach ($transactions as $transaction) {
                if ($transaction->type === 'refund') {
                    $spend_total -= $transaction->qty;
                } else {
                    $spend_total += $transaction->qty;
                }
            }
            $total_balance = $member->wallet->total_balance ?? 0;

            $orders = Project::whereIn('status', ['pending', 'accepted', 'cancel'])->where('user_id', $member->id)
                             ->orderBy('created_at', 'desc')->get();
            $rechargeTransactions = Transaction::whereIn('type', ['deposit', 'withdrawal'])
                                               ->where('user_id', $id)
                                               ->orderBy('created_at', 'desc')
                                               ->get();
            $useFundsTransactions = Transaction::whereIn('type', ['order', 'buy', 'sell','refund','bonus'])
                                               ->where('user_id', $id)
                                               ->orderBy('created_at', 'desc')
                                               ->get();

            $logs = Logs::where('user_id', $id)->orderBy('created_at', 'desc')->get();
            $messages =
                Message::where('sender_id', $id)->orWhere('receiver_id', $id)->orderBy('created_at', 'desc')->get();

            $invoices = Invoice::where('user_id', $id)->orderBy('created_at', 'desc')->get();

            return view('admin.manage_user', compact('menu', 'submenu', 'open_projects',
                'history_projects', 'spend_total', 'total_balance', 'member', 'orders',
                'rechargeTransactions', 'useFundsTransactions', 'invoices', 'logs', 'messages'));
        }
        if ($member['levelType'] === 'copywriter') {
            $orders = Project::where('seller_id', $id)->orderBy('created_at', 'desc')->get();
            $waiting_withdrawals = Transaction::where('type', 'withdrawal')->where('user_id', $id)
                                              ->where('status', 'pending')->orderBy('created_at', 'desc')->get();
            $history_withdrawals = Transaction::where('type', 'withdrawal')->where('user_id', $id)
                                              ->whereIn('status', ['finish', 'cancel'])->orderBy('created_at', 'desc')
                                              ->get();
            $history_funds = Transaction::where('user_id', $id)->whereIn('type', ['sell', 'order'])
                                        ->where('status', 'finish')->orderBy('created_at', 'desc')->get();
            $messages =
                Message::where('sender_id', $id)->orWhere('receiver_id', $id)->orderBy('created_at', 'desc')->get();
            $documents = Document::where('user_id', $id)->orderBy('created_at', 'desc')->get();
            $logs = Logs::where('user_id', $id)->orderBy('created_at', 'desc')->get();

            $earn_total = 0;
            $transactions = Transaction::whereIn('type', ['sell', 'order'])->where('user_id', $id)
                                       ->orderBy('created_at', 'desc')->get();
            foreach ($transactions as $transaction) {
                $earn_total += $transaction->qty;
            }

            $active_orders = Project::where('status', 'pending')->count();
            $complete_orders = Project::where('status', 'accepted')->count();

            return view('admin.manage_copywriter',
                compact('menu', 'submenu', 'member', 'orders', 'messages', 'documents', 'logs',
                    'waiting_withdrawals', 'history_withdrawals', 'history_funds', 'active_orders', 'complete_orders',
                    'earn_total'));
        }
    }

    /**
     * Show all projects
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function projects_all()
    {
        $menu = 'projects';
        $submenu = '';
        $projects = Project::orderBy('created_at', 'desc')->get();

        return view('admin.projects', compact('menu', 'submenu', 'projects'));
    }

    /**
     * Show admin setting page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function admin_settings()
    {
        $menu = 'settings';
        $submenu = '';
        $setting = Setting::first();

        return view('admin.settings', compact('menu', 'submenu', 'setting'));
    }

    /**
     * @method POST
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function admin_settings_save(Request $request)
    {
        $fee = $request->fee;
        $ratelimit = $request->ratelimit;
        $setting = Setting::first();
        if ( ! $setting) {
            $setting = new Setting;
        }
        $setting->fee = $fee;
        $setting->ratelimit = $ratelimit;
        $setting->order_deadline_hours = $request->order_deadline_hours;
        $setting->environment = $request->environment;
        $setting->email_verification = $request->email_verification;
        $setting->save();

        return redirect()->back()->withInput();
    }

    /**
     * @param $id : marketplace's id
     */
    public function market_approve($id)
    {
        $sell = Sell::find($id);
        $sell->status = 'open';
        $sell->save();

        return redirect()->back();
    }

    public function markets_active()
    {
        $menu = 'markets';
        $submenu = 'active';
        $markets = Sell::where('status', 'open')->orderBy('created_at', 'desc')->get();

        return view('admin.markets.active', compact('menu', 'submenu', 'markets'));
    }

    public function markets_pending()
    {
        $menu = 'markets';
        $submenu = 'pending';
        $markets = Sell::where('status', 'pending')->orderBy('created_at', 'desc')->get();

        return view('admin.markets.active', compact('menu', 'submenu', 'markets'));
    }

    public function markets_history()
    {
        $menu = 'markets';
        $submenu = 'history';
        $markets = Sell::whereIn('status', ['finish'])->orderBy('created_at', 'desc')->get();

        return view('admin.markets.active', compact('menu', 'submenu', 'markets'));
    }

    public function market_view(Request $request)
    {
        $id = $request->get('id');
        $market = Sell::find($id);
        $market->categorytitle = $market->category->title;

        return $market;
    }

    /**
     * @param $id : copywriter's id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function copywriter_approve($id)
    {
        return redirect()->back();
    }

    /**
     * @param $id
     */
    public function approve_sell($id)
    {
        $sell = Sell::find($id);
        $sell->status = 'open';
        $sell->save();

        return redirect()->back();
    }

    public function category_edit()
    {
        $categories = Category::all();
        $menu = 'category';
        $submenu = '';

        return view('admin.category', compact('categories', 'menu', 'submenu'));
    }

    public function category_save(Request $request)
    {
        $data = $request->all();
        Log::info(var_export($data, true));
        if ( ! isset($data['id'])) {
            // save
            $category = new Category;
        } else {
            $category = Category::find($data['id']);
        }
        $category->title = $data['title'];
        $category->currency = $data['currency'];
        $category->q1_min = $data['q1_min'];
        $category->q1_max = $data['q1_max'];
        $category->q2_min = $data['q2_min'];
        $category->q2_max = $data['q2_max'];
        $category->q3_min = $data['q3_min'];
        $category->q3_max = $data['q3_max'];
        $category->save();

        return redirect()->back();
    }

    public function category_get(Request $request)
    {
        $id = $request->get('id');
        $category = Category::find($id);

        return view('modals.admin_category_modal', compact('category'));
    }

    public function category_delete(Request $request)
    {
        $id = $request->get('id');
        $category = Category::find($id);
        $category->delete();

        return ['status' => true];
    }

    /**
     * Show PayU setting page
     *
     * @method: get
     */
    public function admin_payu_edit()
    {
        $menu = 'payments';
        $submenu = 'payu-settings';
        $payu_secure = PayU::where('environment', 'secure')->first();
        $payu_sandbox = PayU::where('environment', 'sandbox')->first();

        return view('admin.payments.payu_setting', compact('menu',
            'submenu', 'payu_secure', 'payu_sandbox'));
    }

    /**
     * Save PayU setting
     * @method: post
     *
     * @param Redirect $redirect
     */
    public function admin_payu_save(Request $request)
    {
        $environment = $request->environment;
        $payu = PayU::where('environment', $environment)->first();
        if ( ! $payu) {
            $payu = new PayU;
            $payu->environment = $environment;
        }
        $payu->merchantPosId = $request->merchantPosId;
        $payu->signatureKey = $request->signatureKey;
        $payu->oAuthClientId = $request->oAuthClientId;
        $payu->oAuthClientSecret = $request->oAuthClientSecret;
        $payu->oAuthGrantType = $request->oAuthGrantType;
        $payu->oAuthEmail = $request->oAuthEmail;
        $payu->oAuthExtCustomerID = $request->oAuthExtCustomerID;
        $payu->save();

        return redirect()->back()->withInput();
    }

    /**
     *  Show pending withdrawal requests of copywriters
     * @method Get
     */
    public function admin_withdrawal_pending()
    {
        $menu = 'payments';
        $submenu = 'pending';
        $transactions = Withdraw::where('status', 'pending')->with(['user'])->orderBy('created_at', 'desc')->get();

        return view('admin.payments.payment_pending', compact('menu', 'submenu', 'transactions'));
    }

    /**
     *  Show pending withdrawal requests of copywriters
     * @method Get
     */
    public function admin_withdrawal_history()
    {
        $menu = 'payments';
        $submenu = 'withdraw-history';
        $transactions = Withdraw::whereIn('status', ['cancel', 'finish'])->orderBy('created_at', 'desc')->get();

        return view('admin.payments.payment_history', compact('menu', 'submenu', 'transactions'));
    }

    /**
     *  Show pending withdrawal requests of copywriters
     * @method Get
     */
    public function admin_transaction_history()
    {
        $menu = 'payments';
        $submenu = 'transaction-history';
        $transactions = Transaction::with(['user'=>function($q){
            $q->leftjoin('user_level', function($join) {
                $join->on('users.level_id', '=',  'user_level.id');
            })->select('users.id','users.first_name','users.email','user_level.levelType');
        }])->orderBy('created_at', 'desc')->get();

        return view('admin.payments.transaction_history', compact('menu', 'submenu', 'transactions'));
    }

    /**
     * Approve pending withdrawal request
     * @method: get
     *
     * @param $id
     */
    public function admin_withdrawal_approve($id)
    {

        return redirect()->back();
    }

    /**
     * @param Request $request
     */
    public function admin_project_history(Request $request)
    {
        $menu = 'projects';
        $submenu = 'history';
        $projects = Project::whereIn('status', ['cancel', 'accepted', 'finish'])->orderBy('created_at', 'desc')->get();

        return view('admin.projects', compact('projects', 'menu', 'submenu'));
    }

    public function admin_project_active(Request $request)
    {
        $menu = 'projects';
        $submenu = 'active';
        $projects = Project::whereIn('status', ['pending', 'open','amendment','checking_plagiarism','accepted','written'])->orderBy('created_at', 'desc')->get();

        return view('admin.projects', compact('projects', 'menu', 'submenu'));
    }

    public function admin_project_sketch(Request $request)
    {
        $menu = 'projects';
        $submenu = 'sketch';
        $projects = Project::where('status', 'sketch')->orderBy('created_at', 'desc')->get();

        return view('admin.projects', compact('projects', 'menu', 'submenu'));
    }

    public function admin_messages()
    {
        $menu = 'messages';
        $submenu = '';
        $messages = Message::orderBy('created_at', 'desc')->get();

        return view('admin.messages', compact('menu', 'submenu', 'messages'));
    }

    // ====================== User Level ===========================
    public function level()
    {
        $menu = 'user level';
        $submenu = '';
        $levels = UserLevel::all();

        return view('admin.user.level', compact('menu', 'submenu', 'levels'));
    }

    public function level_save(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'levelType'=>'required',
            'menu_role'=>'required',
            'status'=>'required',
        ]);
        $id = $request->id;
        $level = new UserLevel();
        if (isset($id)) $level = UserLevel::find($id);
        $level->levelType = $request->levelType;
        $level->name = $request->name;
        $level->description = $request->description;
        $level->menu_role = $request->menu_role;
        $level->status = $request->status;
        $level->save();
        return redirect(route('admin.level'));
    }

    /**
     * @method GET, ajax
     * @param $id
     *
     * @return mixed
     */
    public function level_get(Request $request)
    {
        $menu = 'user level';
        $submenu = '';
        $id = $request->get('id');
        $level = UserLevel::find($id);
        $mrMenuRole = UserLevel::$mrMenuRole;
        // $clientMenuRole = UserLevel::$clientMenuRole;
        // $copywriterMenuRole = UserLevel::$copywriterMenuRole;
        // $adminMenuRole = UserLevel::$adminMenuRole;
        if($id==='add') return view('admin.user.level_add', compact('menu', 'submenu','mrMenuRole'));
        else if(!isset($level)) return redirect('/admin/level')->withErrors(['error'=>'Level is not found'])->withInput();

        return view('admin.user.level_view', compact('menu', 'submenu','level','mrMenuRole'));
    }

    public function level_delete(Request $request)
    {
        $id = $request->get('id');
        $level = UserLevel::find($id);

        $user = User::where('level_id',$id)->first();
        if(isset($user)) return ['status' => false, 'message' => 'This level already have user'];

        $level->delete();
        return ['status'=>true,'message' => 'Level had been deleted'];

    }
    // ====================== Root Management ===========================
    public function root()
    {
        $menu = 'root management';
        $submenu = '';
        $users = User::all();

        return view('admin.user.root', compact('menu', 'submenu', 'users'));
    }

    public function root_save(Request $request)
    {
        $request->validate([
            'first_name'=>'required',
            'last_name'=>'required',
            'email'=>'required|email',
            'status'=>'required',
            'level_id'=>'required',
        ]);
        $id = $request->id;
        $user = new User();
        if (isset($id)) {
            $user = User::find($id);
            if(User::where('email',$request->email)->where('id','!=',$id)->first()){
                return redirect()->back()->withErrors(['error'=>'Email already exist'])->withInput();
            }
        }else{
            if(User::where('email',$request->email)->first()){
                return redirect()->back()->withErrors(['error'=>'Email already exist'])->withInput();
            }
        }
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        if(isset($request->password)) $user->password = Hash::make($request->password);
        $user->status = $request->status;
        $user->level_id = $request->level_id;
        $user->save();
        return redirect(route('admin.root'));
    }

    /**
     * @method GET, ajax
     * @param $id
     *
     * @return mixed
     */
    public function root_get(Request $request)
    {
        $menu = 'root management';
        $submenu = '';
        $id = $request->get('id');
        $user = User::find($id);
        if(!isset($user)) return redirect('/admin/root')->withErrors(['error'=>'User is not found'])->withInput();
        $mrLevel = UserLevel::where('status','active')->get();

        return view('admin.user.root_view', compact('menu', 'submenu','user','mrLevel'));
    }

    public function root_delete(Request $request)
    {
        $id = $request->get('id');
        $user = User::find($id);

        $trx = Project::where(function($q) use($user){
            return $q->where('user_id',$user->id)->orWhere('seller_id',$user->id);
        })->first();
        if(isset($trx)) return ['status' => false, 'message' => 'This user already have project'];

        $user->delete();
        return ['status'=>true,'message' => 'User had been deleted'];

    }
    // ====================== Countries ===========================
    public function countries()
    {
        $menu = 'countries';
        $submenu = '';
        $countries = Countries::get();

        return view('admin.countries', compact('menu', 'submenu', 'countries'));
    }

    public function countries_save(Request $request)
    {
        $name = $request->get('name');
        $currency = $request->get('currency');
        $id = $request->get('id');
        $country = new Countries();
        if (isset($id)) {
            $country = Countries::find($id);
        }
        $country->name = $name;
        $country->currency = $currency;
        $country->save();

        return redirect()->back();
    }

    /**
     * @method GET, ajax
     * @param $id
     *
     * @return mixed
     */
    public function countries_get(Request $request)
    {
        $id = $request->get('id');
        $country = Countries::find($id);

        return view('modals.admin_countries_modal', compact('country'));
    }

    public function countries_delete(Request $request)
    {
        $id = $request->get('id');
        $country = Countries::find($id);
        $country->delete();

        return ['success' => true];
    }

    // ====================== Tax Office ===========================
    public function tax_office()
    {
        $menu = 'tax';
        $submenu = '';
        $tax_offices = Taxoffice::all();

        return view('admin.tax_office', compact('menu', 'submenu', 'tax_offices'));
    }

    public function tax_office_save(Request $request)
    {
        $name = $request->get('name');
        $id = $request->get('id');
        $tax = new Taxoffice();
        if (isset($id)) {
            $tax = Taxoffice::find($id);
        }
        $tax->name = $name;
        $tax->save();

        return redirect()->back();
    }

    /**
     * @method GET, ajax
     * @param $id
     *
     * @return mixed
     */
    public function tax_office_get(Request $request)
    {
        $id = $request->get('id');
        $tax = Taxoffice::find($id);

        return view('modals.admin_tax_modal', compact('tax'));
    }

    public function tax_office_delete(Request $request)
    {
        $id = $request->get('id');
        $tax = Taxoffice::find($id);
        $tax->delete();

        return ['success' => true];
    }

    // ====================== Bonus code part ===========================

    /**
     * Bonus code page
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */

    public function bonus_code()
    {
        $menu = 'bonus_code';
        $submenu = '';
        $bonus_codes = BonusCode::all();

        return view('admin.bonus_code', compact('menu', 'submenu', 'bonus_codes'));
    }

    /**
     * Bonus code save
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function bonus_code_save(Request $request)
    {
        $this->validate($request, [
            'code' => 'required|string|min:20|unique:bonus_codes',
        ]);
        $code = $request->get('code');
        $type = $request->get('type');
        $bonus = new BonusCode();
        $bonus->code = $code;
        if($type) $bonus->type = $type;
        $bonus->save();

        return redirect()->back()->with(['success' => true]);
    }

    public function bonus_code_delete(Request $request)
    {
        $id = $request->get('id');
        $bonus = BonusCode::find($id);
        $bonus->delete();

        return ['success' => true];
    }

    public function admin_invoices(Request $request)
    {
        $menu = 'documents';
        $submenu = 'invoice';
        $invoices = Invoice::orderBy('created_at', 'desc')->get();

        return view('admin.document.invoice', compact('menu', 'submenu', 'invoices'));
    }

    public function admin_bills(Request $request)
    {
        $menu = 'documents';
        $submenu = 'bill';
        $documents = Document::orderBy('created_at', 'desc')->get();

        return view('admin.document.bill', compact('menu', 'submenu', 'documents'));
    }

    // User Management
    public function block_user(Request $request)
    {
        $id = $request->get('id');
        $user = User::find($id);
        $user->status = 'block';
        $user->save();

        return redirect()->back()->with(['success' => true]);
    }

    public function update_user_balance(Request $request)
    {
        $request->validate([
            'balance' => 'required|numeric|min:0',
        ]);
        $id = $request->id;
        $balance = $request->balance;
        $wallet = Wallet::where('user_id', $id)->first();
        if ( ! $wallet) {
            $wallet = new Wallet;
            $wallet->user_id = $id;
        }
        $wallet->total_balance = $balance;
        $wallet->save();

        return redirect()->back()->with(['success' => true]);
    }

    public function admin_message_send(Request $request)
    {
        $id = $request->get('id');
        $message = $request->get('message');
        $msg = new Message();
        $msg->sender = Auth::user()->id;
        $msg->sender = Auth::user()->id;
        $msg->receiver = $id;
        $msg->text = $message;
        $msg->state = 'unread';
        $msg->save();

        return redirect()->back()->with(['success' => true]);
    }

    public function downloadBulkInvoices(Request $request)
    {
        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);

        $headers = [
            'Content-type:application/pdf',
        ];

        $info = $this->invoiceService->generateBulkZip($startDate, $endDate);

        $zipName =
            'invoices_'.now()->format('Y-m-d_h-m-i').'__'.$startDate->format('Y-m-d').'_'.$endDate->format('Y-m-d')
            .'.zip';

        return response()->download($info['path'], $zipName, $headers)->deleteFileAfterSend();
    }

    public function addTransaction(Request $request){
        $request->validate([
            'type' => 'required',
            'currency' => 'required|string|max:4',
            'qty' => 'required|numeric|min:0',
        ]);
        $id = $request->id;
        $trx = new Transaction();
        $trx->user_id = $id;
        $trx->type = $request->type;
        $trx->currency = $request->currency;
        $trx->qty = (float) $request->qty;
        $trx->status = 'success';

        $wallet = Wallet::where('user_id', $id)->first();
        if ( ! $wallet) {
            $wallet = new Wallet;
            $wallet->user_id = $id;
        }
        if($request->position=='income')  $wallet->total_balance += (float) $request->qty;
        else if($request->position=='expenses')  $wallet->total_balance -= (float) $request->qty;
        $wallet->save();

        $trx->save();
        return redirect()->back()->with(['success' => true]);
    }
}
