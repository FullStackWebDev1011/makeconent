<?php

namespace App\Http\Controllers;

use App\AdminWallet;
use App\BonusCode;
use App\BonusCodeUse;
use App\Document;
use App\Events\WithdrawMoneyEvent;
use App\Invoice;
use App\PayU;
use App\Setting;
use App\Transaction;
use App\User;
use App\Wallet;
use App\WalletLock;
use App\Withdraw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use PDF;
use PhpParser\Comment\Doc;

class FinancialController extends BaseController
{
    public function __construct()
    {
        $this->middleware(['auth', 'active']);
        parent::__construct();
    }

    /**
     * Show the payments page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function payments_page()
    {
        $menu = 'financial';
        $submenu = 'payments';
        $stripe_key = controller("StripeController")->publishable_key;
        $role = Auth::user()->role();
        $userId = Auth::user()->id;
        $rechargeTransactions = Transaction::whereIn('type', ['deposit', 'withdrawal'])
                                           ->where('user_id', $userId)
                                           ->orderBy('created_at', 'desc')
                                           ->get();
        $useFundsTransactions = Transaction::whereIn('type', ['order', 'buy', 'sell'])
                                           ->where('user_id', $userId)
                                           ->orderBy('created_at', 'desc')
                                           ->get();
        $wallet = Wallet::where('user_id', $userId)->first();
        $country = isset(auth()->user()->country)?auth()->user()->country->currency:'';
				
        if ($role === 'client') {
            return view('financial.payments',
                compact('menu', 'submenu','stripe_key', 'rechargeTransactions', 'useFundsTransactions', 'wallet','country'));
        } else {
            $totalWithdrawal = 0;
            $withdrawals = Transaction::where('type', 'withdrawal')->where('user_id', $userId)->get();
            foreach ($withdrawals as $withdrawal) {
                $totalWithdrawal += $withdrawal->qty;
            }

            return view('financial.copywriter.payments', compact('menu', 'submenu',
                'rechargeTransactions','stripe_key','useFundsTransactions', 'wallet', 'totalWithdrawal','country'));
        }
    }

    /**
     * Show the invoice page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function invoice_page()
    {
        $menu = 'financial';
        $submenu = 'invoice';
        $userId = Auth::user()->id;
        $trans = Transaction::where('user_id', $userId)->where('type', ['order', 'buy', 'refund'])->get();
        $total_spend = 0;
        foreach ($trans as $tran) {
            if ($tran->type === 'refund') {
                $total_spend -= $tran->qty;
            } else {
                $total_spend += $tran->qty;
            }
        }
        $invoices = Invoice::where('user_id', $userId)->orderBy('created_at', 'desc')->get();

        return view('financial.invoice', compact('menu', 'submenu', 'invoices', 'total_spend'));
    }

    /**
     * @param Request $request
     *
     * @response download pdf
     */
    public function invoiceDownload(Invoice $invoice)
    {
        $pdf = PDF::loadView('pdf.invoice_new', ['invoice' => $invoice, 'user' => auth()->user()]);

        return $pdf->download('invoice.pdf');
    }

    /**
     * Show Document page for copywriter
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function document_page()
    {
        $menu = 'financial';
        $submenu = 'document';
        $me = Auth::user();
        $documents = Document::where('user_id', $me->id)->orderBy('created_at', 'desc')->get();

        return view('financial.copywriter.documents', compact('menu', 'submenu', 'documents'));
    }


    public function documentDownload(Document $document)
    {
        $total_balance = $document->qty;
        $tax = $total_balance * 18.699 / 100;
        $info['bruto'] = $total_balance - $tax;
        $info['bruto_tax'] = $info['bruto'] * 0.2;
        $info['bruto_minus_tax'] = $total_balance - $info['bruto_tax'];
        $info['podtava_opodot'] = round($info['bruto']) - round($info['bruto_tax']);
        $info['podatek_dochodowy'] = round($info['podtava_opodot'] * 0.17);
        $info['kwota_do_wyplaty'] = $info['bruto'] - $info['podatek_dochodowy'];

        $pdf = PDF::loadView('pdf.document', ['document' => $document, 'info' => $info, 'user' => $document->user]);

        return $pdf->download('document_'.$document->created_at->format('Y-m-d_H-i').'.pdf');
    }

    public function deposit(Request $request)
    {
//        $email = $request->get('email');
        //TODO need validate 'qty' param
        $request->validate([
            'qty' => 'required|numeric',
        ]);
        $qty = $request->get('qty');

        //risky operation like api call should be wrap into try catch block
        $orderId = uniqid();
        try {
            $order = $this->orderPrepare($qty, $orderId);
            $response = \OpenPayU_Order::create($order);
            //TODO make table for it. store in session not good idea.
            session()->put('last_order', $response->getResponse()->orderId);
        } catch (\Exception $e) {
            //here you decide, how application had to resolve this
            Log::info('something wrong with order '.$orderId.' '.$e->getMessage());
            dd($e->getMessage());

            return redirect()->back()->with('error', ['your message here']);
        }

        return Redirect::to($response->getResponse()->redirectUri);
    }

    /**
     * Deposit Success page
     *
     * @param Request $request
     */
    public function deposit_success(Request $request, $orderId)
    {
        Log::info(session()->all());
        Log::info($request->all());

        return 'ok';
        $lastOrderExternalId = session()->get('last_order') ?: null;
        Log::info('lastOrderExternalID'.$lastOrderExternalId);
        $userId = Auth::user()->id;
        if ($lastOrderExternalId) {
            session()->forget('last_order');
            $response = \OpenPayU_Order::retrieve($lastOrderExternalId);
            Log::info('order retrieve response '.var_export($response, true));
            $order_status = "";
            if ($response->getStatus() == 'SUCCESS') {
                $order_status = $response->getResponse()->orders[0]->status;
                if ($order_status === 'COMPLETED') {
                    // this part will run only if order created successfully
                    $order = $response->getResponse()->orders[0];
                    $qty = $order->totalAmount / 100;
                    $transaction_id = $this->createTransaction($qty, $userId, $order_status);
                    $this->updateWallet($qty, $userId);

                    // update admin wallet
                    $adminWallet = AdminWallet::first();
                    if ( ! $adminWallet) {
                        $adminWallet = new AdminWallet();
                    }
                    $adminWallet->total_balance += $qty;
                    $adminWallet->save();
                    // make invoice pdf

                    $invoice = new Invoice();
                    $invoice->invoice_number = $order->orderId;
                    $invoice->status = 'finish';
                    $invoice->qty = $order->totalAmount / 100;
                    $invoice->user_id = $userId;
                    $invoice->transaction_id = $transaction_id;
                    $invoice->save();

                    $pdf = PDF::loadView('pdf.invoice',
                        ['order' => $order, 'invoice' => $invoice, 'user' => Auth::user()]);
                    $filename = 'invoice_'.date('Y-m-d').Auth::user()->name.$order->orderId.'.pdf';
                    $pdf->save(storage_path('pdf'.DIRECTORY_SEPARATOR.$filename));

                    $invoice->attachment = 'pdf'.DIRECTORY_SEPARATOR.$filename;
                    $invoice->save();

                    return redirect('/payments')->with('payment_success', true);
                }
                if ($order_status === 'PENDING') {
//                dd('Error: order status is ' . $response->getResponse()->orders[0]->status);
                    $order = $response->getResponse()->orders[0];
                    $qty = $order->totalAmount / 100;
                    $this->createTransaction($qty, $userId, $order_status);
                    Log::info('payment error'.var_export($response, true));
                }
                if ($order_status === 'WAITING_FOR_CONFIRMATION') {
                    Log::info('payment error'.var_export($response, true));
                    $order = $response->getResponse()->orders[0];
                    $qty = $order->totalAmount / 100;
                    $this->createTransaction($qty, $userId, $order_status);
                }

                return redirect('/payments')->with(['error' => 'Your request is pending']);
            } else {
                return redirect('/payments')->with(['error' => 'You request has been failed']);
            }
        } else {
            //or something else related to your app logic
            Log::info('not found stored order');

            return redirect('/payments')->with(['error' => 'No order found']);
        }

    }

    /**
     * Deposit notify page
     *
     * @param Request $request
     */
    public function deposit_notify($orderId, Request $request)
    {
        Log::info(session()->all());
        Log::info($request->all());

        return 'ok';
        Log::info('deposit notify response ==========='.$orderId.'----------'.var_export($request->all(), true));
    }

    //TODO have to be extracted to some service, logic not allowed in controllers.
    public function orderPrepare($qty, $orderId)
    {
        $newTransaction = Transaction::create([
            'user_id' => auth()->user()->id,
            'status' => Transaction::STATUS_PENDING,
            'type' => Transaction::TYPE_DEPOSIT,
            'qty' => $qty,
        ]);

        $order['continueUrl'] =
            url('payments/success/'
                .$newTransaction->id); //customer will be redirected to this page after suсcessful payment
        $order['notifyUrl'] = url('payments/notify/'.$newTransaction->id);
        $order['customerIp'] = $_SERVER['REMOTE_ADDR'];
        $order['merchantPosId'] = \OpenPayU_Configuration::getMerchantPosId();
        $order['description'] = 'Deposit';
        $order['currencyCode'] = 'PLN';
        $order['totalAmount'] = floatval($qty) * 100;
        $order['extOrderId'] = $newTransaction->id; //must be unique!
        $order['products'][0]['name'] = 'Deposit';
        $order['products'][0]['unitPrice'] = floatval($qty) * 100;
        $order['products'][0]['quantity'] = 1;
        $order['buyer']['email'] = Auth::user()->email;
        $order['buyer']['firstName'] = explode(' ', Auth::user()->fullname)[0];
        $order['buyer']['lastName'] = explode(' ', Auth::user()->fullname)[1];

        Log::info($order);

        return $order;
    }

    /**
     * Withdrawal
     *
     * @method: POST
     */
    public function withdrawal(Request $request)
    {
        if ( ! in_array(auth()->user()->role(), [User::TYPE_FREELANCER, User::TYPE_COPYWRITER])) {
            return redirect()->back()->withErrors(['message' => 'You can not withdrawal']);
        }
        $total_balance = auth()->user()->wallet ? auth()->user()->wallet->total_balance : 0;
        $lock_balance = auth()->user()->wallet_lock ? auth()->user()->wallet_lock->lock_amount : 0;
        $available_balance = $total_balance;

        if ($lock_balance > 0) {
            return redirect()->back()
                             ->withErrors(['message' => 'You can not withdraw because your wallet is already locked due to previous withdrawal']);
        }

        if ($available_balance < config('settings.payment.min_withdrawal_balance')) {
            return redirect()->back()->withErrors([
                'message' => 'You can withdrawal more than '
                             .roundPrice(config('settings.payment.min_withdrawal_balance')).' PLN',
            ]);
        }

        if (auth()->user()->isCompany) {
            if ( ! empty(auth()->user()->street) && ! empty(auth()->user()->companyName)
                 && ! empty(auth()->user()->vat_number)
                 && ! empty(auth()->user()->fullname)
                 && ! empty(auth()->user()->phone)
                 && ! empty(auth()->user()->apartment_number)
                 && ! empty(auth()->user()->city)
                 && ! empty(auth()->user()->post_code)
                 && ! empty(auth()->user()->bank_account)) {
                return $this->withdrawal_continue($request);
            } else {
                return redirect()->back()
                                 ->withErrors(['message' => 'First you need to complete the field in setting to make withdrawal']);
            }
        } else {
            if ( ! empty(auth()->user()->street) && ! empty(auth()->user()->tax_office_id)
                 && ! empty(auth()->user()->fullname)
                 && ! empty(auth()->user()->phone)
                 && ! empty(auth()->user()->apartment_number)
                 && ! empty(auth()->user()->city)
                 && ! empty(auth()->user()->post_code)
                 && ! empty(auth()->user()->bank_account)) {
                // redirect to withdrawal/continue
                return $this->withdrawal_continue($request);
            } else {
                return redirect()->back()
                                 ->withErrors(['message' => 'First you need to complete the field in setting to make withdrawal']);
            }
        }
    }

    public function withdrawal_continue(Request $request)
    {
        $me = Auth::user();
        $myWallet = Wallet::where('user_id', $me->id)->first();
        $withdrawal_type = $request->withdrawal_type;

        // add new transaction
        $transaction_amount = $myWallet->total_balance;

        $myWallet->update(['total_balance' => 0]);

        $fee = 0;
        if ($withdrawal_type === 'express') { // Express fee is -15 by default for now
            $fee = 15;
        }
        $newTran = new Transaction;
        $newTran->user_id = $me->id;
        $newTran->qty = $transaction_amount;
        $newTran->type = 'withdrawal';
        $newTran->status = 'pending';
        $newTran->save();

        // Reduce admin wallet
        // TODO: this part should be proceed in admin panel
//        $adminWallet = AdminWallet::first();
//        if($adminWallet) {
//            $adminWallet -> total_balance = $adminWallet -> total_balance - $transaction_amount;
//        }
//        $adminWallet->save();
//
//        $myWallet->total_balance = 0;
//        $myWallet->save();


        // lock wallet
        $walletLock = WalletLock::where('user_id', $me->id)->first();
        if ( ! $walletLock) {
            $walletLock = new WalletLock();
            $walletLock->lock_amount = 0;
        }
        $walletLock->user_id = $me->id;
        $walletLock->lock_amount += $transaction_amount;
        $walletLock->save();

        $filename = '';
//        if ( ! $me->isCompany) {
////         make document pdf and atttached to document
//            $pdf = PDF::loadView('pdf.document');
//            if (is_writable($filename)) {
//                $filename = 'pdf'.DIRECTORY_SEPARATOR.'bill_'.date('Y-m-d').Auth::user()->name.'.pdf';
//                $pdf->save(storage_path($filename));
//            } else {
//                $filename = 'pdf'.DIRECTORY_SEPARATOR.'bill_'.date('Y-m-d').uniqid().Auth::user()->name.'.pdf';
//                $pdf->save(storage_path($filename));
//            }
//        }

        $document = new Document();
        $document->user_id = $me->id;
        $document->status = Document::STATUS_FINISH;
        $document->qty = $transaction_amount;
        $document->bill_number = uniqid();
        $document->attachment = $filename;
        $document->save();

        // update withdraw table
        $withdraw = new Withdraw();
        $withdraw->type = $withdrawal_type;
        $withdraw->status = 'pending';
        $withdraw->qty = $transaction_amount;
        $withdraw->fee = $fee;
        $withdraw->user_id = $me->id;
        $withdraw->bill_id = $document->id;
        $withdraw->save();

        event(new WithdrawMoneyEvent($document));

        return redirect('payments');
    }

    public function bonus_receive(Request $request)
    {
        $request->validate([
            'code' => 'required|string|exists:bonus_codes,code',
        ]);
        $code = $request->get('code');

        $userId = Auth::user()->id;
        $bonusCodeUse = BonusCodeUse::where('code', $code)->where('user_id', $userId)->get();
        if (count($bonusCodeUse) > 0) {
            return redirect()->back()->withErrors(['code' => 'Code is used already']);
        }

        $bonusCode = BonusCode::where('code',$code)->first();
        if (!$bonusCode) {
            return redirect()->back()->withErrors(['code' => 'Code is not found']);
        }
        if($bonusCode['type']=='once'){
            $bonuscodeused = BonusCodeUse::where('code', $code)->get();
            if(count($bonuscodeused)>0) {
                return redirect()->back()->withErrors(['code' => 'Code is used already with another user']);
            }
        }

        $bonusCodeUse = new BonusCodeUse();
        $bonusCodeUse->code = $code;
        $bonusCodeUse->user_id = $userId;
        $bonusCodeUse->save();

        $bonusCode->counting = $bonusCode->counting+1;
        $bonusCode->save();

        $setting = Setting::first();

        // add wallet
        $wallet = Wallet::where('user_id', $userId)->first();
        if(!$wallet) {
            $wallet = new Wallet();
            $wallet->user_id = $userId;
        }
        $wallet->total_balance = $wallet->total_balance + $setting->bonus_fee;
        $wallet->bonus_code = $code;
        $wallet->bonus = $setting->bonus_fee;
        $wallet->save();
        // update transaction
        $trans = new Transaction();
        $trans->qty = $setting->bonus_fee;
        $trans->user_id = $userId;
        $trans->type = 'bonus';
        $trans->status = 'finish';
        $trans->save();

        return redirect()->back()->with(['success' => true]);
    }
}
