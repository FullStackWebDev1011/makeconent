<?php

namespace App\Http\Controllers;

use App\AdminWallet;
use App\Category;
use App\CopywriterReview;
use App\Events\ProjectNewTextEvent;
use App\Http\Middleware\Admin;
use App\Http\Requests\ProjectAmendmentsRequest;
use App\Invoice;
use App\Project;
use App\Services\ProjectService;
use App\Services\WalletService;
use App\Setting;
use App\Transaction;
use App\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use PDF;
use Languages;

class ProjectController extends BaseController
{
    public $wallerService;
    public $projectService;

    public function __construct(WalletService $wallerService, ProjectService $projectService)
    {
        $this->wallerService = $wallerService;
        $this->projectService = $projectService;

        $this->middleware(['auth', 'active']);
        parent::__construct();
    }

    /////////////////////////// For Clients //////////////////
    public function create()
    {
        $menu = 'projects';
        $submenu = '';
        $languages = Languages::lookup();
        $categories = Category::all();

        return view('projects.create', compact('menu', 'submenu', 'categories', 'languages'));
    }

    public function view(Request $request, Project $project)
    {
        $menu = 'projects';
        $submenu = '';

        $role = Auth::user()->role();
        $languages = Languages::lookup();

        if ($role === 'client') {
            return view('projects.view', compact('menu', 'submenu', 'project','languages'));
        }
        if ($role === 'copywriter') {
            return view('projects.copywriter.view', compact('menu', 'submenu', 'project','languages'));
        }
    }

    public function preview(Request $request)
    {
        $menu = 'projects';
        $submenu = '';
        $id = $request->get('id');
        $userId = Auth::user()->id;

        $role = Auth::user()->role();

        if ($role === 'client') {
            $project = Project::findOrFail($id);

            return view('projects.preview', compact('menu', 'submenu', 'project'));
        }
        if ($role === 'freelancer') {
            return view('errors.404');
        }
    }

    public function view_all()
    {
        $menu = 'projects';
        $submenu = '';
        $myId = Auth::user()->id;
        $projects = Project::where('user_id', $myId)->orderBy('created_at', 'desc')->get();

        return view('projects.all', compact('menu', 'submenu', 'projects'));
    }

    public function reviewAdd(Project $project, Request $request)
    {
        if ($project->rated) {
            return back();
        }

        $reviewUserTarget = $project->seller_id;

        app(CopywriterReview::class)->create([
            'user_id' => $reviewUserTarget,
            'project_id' => $project->id,
            'from_user_id' => auth()->id(),
            'rate' => $request->rate,
            'comment' => $request->comment,
        ]);

        $project->update(['rated' => true]);

        $result = app(CopywriterReview::class)->select(DB::raw('count(*) as count'), DB::raw('sum(rate) as sum'))
                                              ->where('user_id', $reviewUserTarget)->orderBy('id', 'desc')->limit(100)
                                              ->get();

        $rate = round($result[0]['sum'] / $result[0]['count'] * 100);

        $project->seller->update(['rate' => $rate]);

        return back();
    }

    /**
     * Show the projects open page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function open()
    {
        $menu = 'projects';
        $submenu = 'open';
        $myId = Auth::user()->id;
        $projects = Project::whereIn('projects.status', ['pending', 'open','amendment','checking_plagiarism','written'])->where('user_id', $myId)
                           ->orderBy('created_at', 'desc')->get();

        return view('projects.open', compact('menu', 'submenu', 'projects'));
    }

    /**
     * Show the projects sketch page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function sketch()
    {
        $menu = 'projects';
        $submenu = 'sketch';
        $myId = Auth::user()->id;
        $role = Auth::user()->role();
        if ($role === 'client') {
            $projects = Project::where('projects.status', 'sketch')->where('user_id', $myId)->get();

            return view('projects.sketch', compact('menu', 'submenu', 'projects'));
        } else {
            $projects = Project::where('projects.status', 'sketch')->get();

            return view('projects.copywriter.sketch', compact('menu', 'submenu', 'projects'));
        }
    }

    /**
     * Show the projects history page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function history()
    {
        $menu = 'projects';
        $submenu = 'history';
        $myId = Auth::user()->id;
        $role = Auth::user()->role();
        if ($role === 'client') {
            $projects =
                Project::whereIn('projects.status', ['finish', 'cancel', 'accepted'])->where('user_id', $myId)->get();

            return view('projects.history', compact('menu', 'submenu', 'projects'));
        } else {
            $projects = Project::whereIn('projects.status', ['finish', 'cancel', 'accepted'])->where('seller_id', $myId)->get();

            return view('projects.copywriter.history', compact('menu', 'submenu', 'projects'));
        }
    }

    /**
     * return category by its id
     *
     * @param Request $request
     */
    public function getCategory(Request $request)
    {
        $catId = $request->get('id');

        return Category::find($catId);
    }

    public function save(Request $request)
    {
        $request->validate([
            'budget' => 'required|numeric',
            'title' => 'required|string|max:255',
            'min_chars' => 'required|numeric|min:100',
            'payment_method' => 'required',
        ]);
        $payment_method = $request->payment_method;

        $data = $request->all();
        $data['category_id'] = $request->categoryId;
        unset($data['categoryId']);
        $userId = Auth::user()->id;
        $wallet = new Wallet;
        $wallet->user_id = $userId;
        if ($payment_method === 'wallet') { // reduce user's wallet total_balance
            $wallet = Wallet::where('user_id', $userId)->first();
            if ( ! $wallet || $wallet->total_balance < $data['budget']) {
                return redirect()->back()->withErrors([
                    'status' => false,
                    'msg' => 'You wallet has no enough balance, please deposit first',
                ]);
            }
        }

        $orderId = '';
        $status = $data['status'];
        if (in_array($payment_method,['PayU','Stripe'])) {
            $data['status'] = 'sketch'; // make it's status sketch by default
        }
        $cp_write_title = $request->cp_write_title;
        if ( ! isset($cp_write_title)) {
            $data['cp_write_title'] = 0;
        } else {
            $data['cp_write_title'] = 1;
        }
        $cp_bold_keyword = $request->cp_bold_keyword;
        if ( ! isset($cp_bold_keyword)) {
            $data['cp_bold_keyword'] = 0;
        } else {
            $data['cp_bold_keyword'] = 1;
        }
        $data['user_id'] = $userId;
        $quality = $request->quality;
        if ( ! isset($quality)) {
            $data['quality'] = '';
        }
        $data['order_id'] = $orderId;

        // Affilate
        if(!Project::where(['user_id'=>$userId])->first()&&Auth::user()->affiliated=='active'){
            $affilate = (float)$data['budget']*2/100;
            $data['budget'] -= $affilate;

            $trans = new Transaction;
            $trans->user_id = $userId;
            $trans->qty = $affilate;
            $trans->type = 'bonus';
            $trans->save();
        }

        $project = Project::create($data);

        if ($payment_method === 'PayU' && $status === 'open') {
            // Use $orderId ======== for extOrderId of OpenPayU_create method's parameter
            // TODO : OpenPayU_create_order in case of payu directly
            // in continueUrl pass $project->id and update project's status to 'open',
            // and increase admin's wallet and update transaction
            Log::info($status.'---'.$project->id);
            $orderId = uniqid(); // extOrderId;
            try {
                $order = $this->orderPrepare($data['budget'], $orderId, $project->id);
                $response = \OpenPayU_Order::create($order);
                //TODO make table for it. store in session not good idea.
                session()->put('last_project_order', $response->getResponse()->orderId);
            } catch (\Exception $e) {
                //here you decide, how application had to resolve this
                Log::info('something wrong with order '.$orderId.' '.$e->getMessage());
                dd($e->getMessage());

                return redirect()->back()->with('error', ['your message here']);
            }

            return Redirect::to($response->getResponse()->redirectUri);
        }

        if ($payment_method === 'wallet' && $status === 'open') { // update user's wallet in case of payment_method is wallet
            // transaction update for user
            $trans = new Transaction;
            $trans->user_id = $userId;
            $trans->qty = $data['budget'];
            $trans->type = 'order';
            $trans->save();

            $wallet = Wallet::where('user_id', $userId)->first();
            $wallet->total_balance -= $data['budget'];
            $wallet->save();

            // payment method is wallet --> admin_wallet update
            $admin_wallet = AdminWallet::first();
            if ( ! $admin_wallet) {
                $admin_wallet = new AdminWallet;
                $admin_wallet->total_balance = 0;
            }
            $admin_wallet->total_balance += $data['budget'];
            $admin_wallet->save();
        }

        if ($project->status == Project::STATUS_SKETCH) {
            return redirect(route('projects.view', ['project' => $project]));
        }

        return redirect('/projects/open')->with('payment_success', true);
    }

    private function orderPrepare($qty, $orderId, $projectId)
    {
        $order['continueUrl'] = url('project/payment/success/'.$orderId.'/'
                                    .$projectId); //customer will be redirected to this page after suсcessful payment
        $order['notifyUrl'] = url('project/payment/notify/'.$orderId.'/'.$projectId);
        $order['customerIp'] = $_SERVER['REMOTE_ADDR'];
        $order['merchantPosId'] = \OpenPayU_Configuration::getMerchantPosId();
        $order['description'] = 'Order';
        $order['currencyCode'] = 'PLN';
        $order['totalAmount'] = floatval($qty) * 100;
        $order['extOrderId'] = $orderId; //must be unique!
        $order['products'][0]['name'] = 'Order';
        $order['products'][0]['unitPrice'] = floatval($qty) * 100;
        $order['products'][0]['quantity'] = 1;
        $order['buyer']['email'] = Auth::user()->email;
        $order['buyer']['firstName'] = explode(' ', Auth::user()->fullname)[0];
        $order['buyer']['lastName'] = explode(' ', Auth::user()->fullname)[1];

        return $order;
    }

    public function project_pay_success($orderId, $projectId)
    {
        Log::info($orderId.' - '.$projectId);
        $lastOrderExternalId = session()->get('last_project_order') ?: null;
        Log::info('lastOrderExternalID'.$lastOrderExternalId);
        $userId = Auth::user()->id;
        if ($lastOrderExternalId) {
            session()->forget('last_project_order');
            $response = \OpenPayU_Order::retrieve($lastOrderExternalId);
            Log::info('order retrieve response '.var_export($response, true));
            $order_status = "";
            if ($response->getStatus() == 'SUCCESS') {
                $order_status = $response->getResponse()->orders[0]->status;
                if ($order_status === 'COMPLETED') {
                    // this part will run only if order created successfully
                    $order = $response->getResponse()->orders[0];
                    $qty = $order->totalAmount / 100;
                    $this->createTransaction($qty, $userId, $order_status);

                    $project = Project::find($projectId);
                    $project->status = 'open';
                    $project->save();

                    $adminWallet = AdminWallet::first();
                    if ( ! $adminWallet) {
                        $adminWallet = new AdminWallet();
                        $adminWallet->total_balance = 0;
                    }
                    $adminWallet->total_balance += $qty;
                    $adminWallet->save();

                    $invoice = new Invoice();
                    $invoice->invoice_number = $order->orderId;
                    $invoice->status = 'finish';
                    $invoice->qty = $order->totalAmount / 100;
                    $invoice->user_id = $userId;

                    $invoice->save();

                    $pdf = PDF::loadView('pdf.invoice',
                        ['order' => $order, 'invoice' => $invoice, 'user' => Auth::user()]);
                    $filename = 'invoice_'.date('Y-m-d').Auth::user()->name.$order->orderId.'.pdf';
                    $pdf->save(storage_path('pdf'.DIRECTORY_SEPARATOR.$filename));

                    $invoice->attachment = 'pdf'.DIRECTORY_SEPARATOR.$filename;
                    $invoice->save();

                    return redirect('/projects/open')->with('payment_success', true);
                }
                if ($order_status === 'PENDING') {
//                dd('Error: order status is ' . $response->getResponse()->orders[0]->status);
                    $order = $response->getResponse()->orders[0];
                    $qty = $order->totalAmount / 100;
                    $this->createTransaction($qty, $userId, $order_status);
                    Log::info('payment error'.var_export($response, true));
                }
                if ($order_status === 'WAITING_FOR_CONFIRMATION') {
                    $order = $response->getResponse()->orders[0];
                    $qty = $order->totalAmount / 100;
                    $this->createTransaction($qty, $userId, $order_status);
                }

                return redirect('/projects/open')->with(['error' => 'Your request is pending']);
            } else {
                return redirect('/projects/open')->with(['error' => 'You request has been failed']);
            }
        } else {
            //or something else related to your app logic
            Log::info('not found stored order');

            return redirect('/projects/open')->with(['error' => 'No order found']);
        }
    }

    public function project_pay_notify($orderId, $projectId)
    {
        // TODO: update project's status to open
        Log::info('project pay notify orderId = '.$orderId.'---- projectId = '.$projectId);
    }

    public function cancel(Request $request)
    {
        $id = $request->id;
        $project = Project::find($id);
        $userId = $project->user_id;
        $myId = Auth::user()->id;
        if ($userId !== $myId) {
            $status = false;
            $message = 'This project is not made by you.';

            return compact('status', 'message');
        }
        $project->status = 'cancel';
        $project->save();

        // =============  revoke funds to wallet ================
        // in callback function should update wallet, and transaction
        // ================= update wallet ======================
        $refund_amount = (double) $project->budget;
        if ($project->payment_method === 'PayU') { // OpenPayU cancel order
            $orderId = $project->orderId; // use $openId for OpenPayU's parameter
            $refund_amount = (double) $project->budget; // should be got from OpenPayU :: refund
        }
        else if ($project->payment_method === 'Stripe') { // Stripe cancel order
            $orderId = $project->orderId; // use $openId for Stripe's parameter
            $refund_amount = (double) $project->budget; // should be got from Stripe :: refund
        }
        else if ($project->payment_method === 'wallet') { // reduce admin_wallet's total_balance
            $admin_wallet = AdminWallet::first();
            if ($admin_wallet) {
                $admin_wallet->total_balance -= $refund_amount;
                $admin_wallet->save();
            }
        }
        $wallet = Wallet::where('user_id', $userId)->first();
        if ( ! $wallet || ! $wallet->id) {
            $wallet = new Wallet;
            $wallet->user_id = $userId;
        }
        $wallet->total_balance += $refund_amount;
        $wallet->save();

        // ================= update transaction ================
        $trans = new Transaction;
        $trans->user_id = $userId;
        $trans->qty = $refund_amount;
        $trans->type = 'refund';
        $trans->source = $id; // order's id
        $trans->save();
         
        $status = true;
        $message = 'This project has been canceled.';
        return compact('status', 'message');
    }

    /////////////////// For Copywriter /////////////////////////

    public function browse(Request $request)
    {
        $menu = 'projects';
        $submenu = 'open';
        $me = Auth::user();
        $mylanguages= auth()->user()->languages?:[];
        $projects = Project::whereIn('status', ['open'])->whereIn('language', $mylanguages)->orderBy('created_at', 'desc');
        $categories = Category::all();
        $languages = Languages::lookup($mylanguages);

        $projects = $projects->get(); 
        return view('projects.copywriter.browse',
            compact('menu', 'submenu', 'projects', 'categories', 'languages'));
    }

    public function actual()
    {
        $menu = 'projects';
        $submenu = 'actual';
        $projects =
            Project::whereIn('status', [
                Project::STATUS_PENDING,
                Project::STATUS_AMENDMENT,
                Project::STATUS_WRITTEN,
                Project::STATUS_CHECKING_PLAGIARISM,
            ])->orderBy('created_at', 'desc')->get();

        return view('projects.copywriter.actual', compact('projects', 'menu', 'submenu'));
    }

    /**
     * Get projects data for ajax request
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function browse_ajax(Request $request)
    {
        $rate = $request->get('rate');
        $me = Auth::user();
        $categoryId = $request->get('category_id');
        // $query = Project::whereIn('status', ['open'])->orWhere(function ($query) use ($me) {
        //     $query->where('status', 'pending')->where('seller_id', $me->id);
        // });
        $query = Project::whereIn('status', ['open']);
        
        if($request->rate) $query = $query->where('rate','<=',$request->rate);
        if($request->language) $query = $query->where('language',$request->language);
        if($request->categoryId) $query = $query->where('category_id',$request->categoryId);

        $projects = $query->orderBy('created_at', 'desc')->get();

        return view('projects.components.table', compact('projects'));
    }

    /**
     * @param Request $request
     */
    public function reserve(Request $request)
    {
        $id = $request->get('id');
        $project = Project::find($id);
        $project->status = 'pending';
        $project->seller_id = Auth::user()->id;
        $project->reserved_at = now();
        $project->save();

        return ['status' => 'ok'];
    }

    public function jumpOut(Request $request, Project $project)
    {
        $project->doSellerJumpOut();

        return redirect(route('projects.browse'));
    }

    public function acceptText(Project $project, Request $request)
    {
        $project->update(['status' => Project::STATUS_ACCEPTED]);

        $sellerId = $project->seller_id;

        // transaction update for copywriter
        $setting = Setting::first();
        $fee = 15;
        if ($setting) {
            $fee = $setting->fee;
        }
        $paidMoney = $project->budget;

        $trans = new Transaction;
        $trans->user_id = Auth::user()->id;
        $trans->type = 'order';
        $trans->qty = $paidMoney;
        $trans->save();

        $trans = new Transaction;
        $trans->user_id = $sellerId;
        $trans->type = 'order';
        $trans->qty = $paidMoney;
        $trans->save();

        $feePaid = (float)$project->budget * (float)$fee / 100;

        $affilate = 0;
        if(!Project::whereNotIn('id',[$project->id])->where(['seller_id'=>$sellerId])->first()&&Auth::user()->affiliated=='active'){
            $affilate = $paidMoney*5/100;
            $trans = new Transaction;
            $trans->user_id = $sellerId;
            $trans->type = 'bonus';
            $trans->qty = $affilate;
            $trans->save();
        }

        $trans = new Transaction;
        $trans->user_id = $sellerId;
        $trans->type = 'fee';
        $trans->qty = $feePaid;
        $trans->save();

        // update copywriters's wallet
        $wallet = Wallet::where('user_id', $sellerId)->first();
        if ( ! $wallet) {
            $wallet = new Wallet;
            $wallet->user_id = $sellerId;
            $wallet->total_balance = 0;
        }
        $wallet->total_balance += ((float)$paidMoney - (float)$feePaid)+(float)$affilate;
        $wallet->save();

        // update admin wallet
        $adminWallet = AdminWallet::first();
        if ( ! $adminWallet) {
            $adminWallet = new AdminWallet();
            $adminWallet->total_balance = 0;
        }
        $adminWallet->total_balance -= ((float)$paidMoney - (float)$feePaid)+(float)$affilate;
        $adminWallet->save();

        $this->projectService->accept($project);

        $project->seller->increment('accepted');

        return redirect()->back();
    }

    public function rejectText(Project $project)
    {
        $this->projectService->reject($project);

        $project->seller->increment('declined');

        return redirect()->back();
    }

    public function reviewAccept(Project $project){
        $this->projectService->reviewAccept($project);

        return redirect()->back();
    }

    public function sendAmendments(Project $project, ProjectAmendmentsRequest $request)
    {
        $project->update(['amendment_comment' => $request->text, 'status' => Project::STATUS_AMENDMENT]);

        return redirect()->back();
    }

    /**
     * Pay for sketch project
     *
     * @param Request $request
     */
    public function pay(Request $request)
    {
        $id = $request->get('id');
        $project = Project::find($id);
        if ($project->status !== 'sketch') {
            return ['status' => false, 'message' => 'This project is not sketch'];
        } else {
            $userId = Auth::user()->id;
            $projectUserId = $project->user_id;
            if ($userId !== $projectUserId) {
                return ['status' => false, 'message' => 'This project is not made by you'];
            }

            $payment_method = $project->payment_method;
            if ( ! empty($request->payment_method)) {
                $payment_method = $request->payment_method;
            }

            if ($payment_method=='wallet') {
                $wallet = Wallet::where('user_id', $userId)->first();
                if ( ! $wallet || ! $wallet->id) {
                    $wallet = new Wallet;
                    $wallet->user_id = $userId;
                    $wallet->total_balance = 0;

                }
                if ($wallet->total_balance < $project->budget) {
                    return [
                        'status' => false,
                        'message' => 'You have no enough money in your wallet, please deposit funds from PayU first',
                    ];
                }
                $wallet->total_balance -= (float)$project->budget;
                $wallet->save();
                // update transaction
                $trans = new Transaction;
                $trans->user_id = $userId;
                $trans->qty = $project->budget;
                $trans->type = 'order';
                $trans->source = $id;
                $trans->save();

                // update project
                $project->payment_method = $payment_method;
                $project->status = 'open';
                $project->save();
            }else if ($payment_method === 'Stripe') {
                // update transaction
                $trans = new Transaction;
                $trans->user_id = $userId;
                $trans->qty = $project->budget;
                $trans->type = 'order';
                $trans->source = $id;
                $trans->save();

                // update project
                $project->payment_method = $payment_method;
                $project->status = 'open';
                $project->save();
            }else if ($payment_method === 'PayU') {
                $orderId = uniqid(); // extOrderId;
                try {
                    $order = $this->orderPrepare($project->budget, $orderId, $project->id);
                    $response = \OpenPayU_Order::create($order);
                    //TODO make table for it. store in session not good idea.
                    session()->put('last_project_order', $response->getResponse()->orderId);
                } catch (\Exception $e) {
                    //here you decide, how application had to resolve this
                    Log::info('something wrong with order '.$orderId.' '.$e->getMessage());
                    dd($e->getMessage());

                    return redirect()->back()->with('error', ['your message here']);
                }

                // update project
                $project->payment_method = $payment_method;
                $project->save();
                return Redirect::to($response->getResponse()->redirectUri);
            }

            if ( ! empty($request->redirect)) {
                return redirect($request->redirect)->with('status', ['Done']);
            }

            return redirect(route('projects.view',['project'=>$project]));
        }
    }

    /**
     * Save text
     *
     * @param Request $request
     */
    public function save_text(Request $request)
    {
        $id = $request->get('id');
        $project = Project::find($id);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|min:10|max:255',
            'text' => 'required|string|min:'.$project->min_chars,
        ]);
        if ($validator->fails()) {
            return ['errors' => $validator->errors()];
        }
        $title = $request->get('title');
        $text = $request->get('text');

        $sellerId = $project->seller_id;
        $myId = Auth::user()->id;
        if ($sellerId === $myId
            && ($project->status === Project::STATUS_PENDING
                || $project->status === Project::STATUS_AMENDMENT)) { // reserved project only
            $project->text = $text;
            $project->seller_title = $title;
//            $project->status = Project::STATUS_WRITTEN;
            $project->status = Project::STATUS_CHECKING_PLAGIARISM;
            $project->save();

            event(new ProjectNewTextEvent($project));

            return ['status' => true, 'message' => 'Successfully submitted.'];
        }

        return ['status' => false, 'message' => 'Project is not reserved by you.'];
    }

    public function get_text(Request $request)
    {
        $id = $request->get('id');
        $project = Project::find($id);

        return $project->load(['user', 'seller', 'category']);
    }

    /**
     * Project update price
     *
     * @param Redirect $redirect
     */
    public function priceUpdate(Project $project, Request $request)
    {
        if ($this->wallerService->updateProjectPrice($project, $request->budget)) {
            return redirect()->back()->with(['success' => true]);
        } else {
            return redirect()->back()->with(['success' => false]);
        }
    }
}
