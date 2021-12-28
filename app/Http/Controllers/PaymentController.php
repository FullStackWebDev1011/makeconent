<?php

namespace App\Http\Controllers;

use App\AdminWallet;
use App\Events\AddFoundsEvent;
use App\Invoice;
use App\Transaction;
use App\User;
use App\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use PDF;

class PaymentController extends Controller
{
    public function __construct()
    {
        \OpenPayU_Configuration::setEnvironment(config('services.pay_u.mode'));
        \OpenPayU_Configuration::setMerchantPosId(config('services.pay_u.pos_id'));
        \OpenPayU_Configuration::setSignatureKey(config('services.pay_u.signature_key'));
        \OpenPayU_Configuration::setOauthClientId(config('services.pay_u.o_auth_client_id'));
        \OpenPayU_Configuration::setOauthClientSecret(config('services.pay_u.o_auth_client_secret'));
    }

    public function testNotification(Request $request)
    {
        if($request->number == 1) {
            return back()->with('payment_success', true);
        }
        if($request->number == 2) {
            return back()->with('payment_pending', true);
        }
        if($request->number == 3) {
            return back()->with('payment_cancel', true);
        }
    }

    /**
     * Deposit Success page
     *
     * @param Request $request
     */
    public function deposit_success(Request $request, $orderId)
    {
        Log::info('deposit_success');
        $transaction = Transaction::where('id', $orderId)->first();

        switch ($transaction->status) {
            case Transaction::STATUS_PENDING:
                return redirect('/payments')->with('payment_pending', true);
                break;
            case Transaction::STATUS_CANCEL:
                return redirect('/payments')->with('payment_cancel', true);
                break;
            case Transaction::STATUS_SUCCESS:
            case Transaction::STATUS_FINISH:
                return redirect('/payments')->with('payment_success', true);
                break;
        }
    }

    /**
     * Deposit notify page
     *
     * @param Request $request
     */
    public function deposit_notify($orderId, Request $request)
    {
        Log::info('deposit_notify');
        $transaction = Transaction::where('id', $orderId)->first();
        if (empty($transaction)) {
            Log::info('deposit_notify not ok'.var_export($request->all(), true));

            return 'not ok';
        }
        $user = $transaction->user;
        $userId = $user->id;

        $invoice = $transaction->invoice;

        $response = \OpenPayU_Order::retrieve($request->all()['order']['orderId']);

        if ($response->getStatus() == 'SUCCESS') {
            $order_status = $response->getResponse()->orders[0]->status;

            if (empty($invoice)) {
                // this part will run only if order created successfully
                $order = $response->getResponse()->orders[0];
                $qty = $order->totalAmount / 100;

                $this->updateWallet($qty, $userId);

                // update admin wallet
                $adminWallet = AdminWallet::first();
                if ( ! $adminWallet) {
                    $adminWallet = new AdminWallet();
                }
                $adminWallet->total_balance += $qty;
                $adminWallet->save();

                $invoice = new Invoice();
                $invoice->invoice_number = $order->orderId;
                $invoice->status = 'finish';
                $invoice->qty = $order->totalAmount / 100;
                $invoice->user_id = $userId;
                $invoice->transaction_id = $transaction->id;
                $invoice->attachment = '';
                $invoice->save();
            }

            if ($order_status === 'COMPLETED') {
                $transaction->update(['status' => Transaction::STATUS_FINISH]);

                event(new AddFoundsEvent($invoice));

                return 'ok';
            }

            if ($order_status === 'PENDING') {
                $transaction->update(['status' => Transaction::STATUS_PENDING]);

                return 'ok';
            }

            if ($order_status === 'CANCELED') {
                $transaction->update(['status' => Transaction::STATUS_CANCEL]);

                return 'ok';
            }
        } else {
            return redirect('/payments')->with(['error' => 'You request has been failed']);
        }
    }

// AAaaaaaaa! Should to copy from BaseController
//TODO have to be extracted to own service, or moved to model Transaction
//also best practices told us, to inject models into controller constructor
    public function createTransaction(
        $qty,
        $userId,
        $status
    ) {
        $transaction = new Transaction();
        $transaction->qty = $qty;
        $transaction->user_id = $userId;
        $transaction->type = 'deposit';
        $transaction->status = $status;
        $transaction->save();

        return $transaction->id;
    }

//TODO have to be extracted to own service, or moved to model Wallet
    public function updateWallet(
        $qty,
        $userId
    ) {
        $wallet = Wallet::updateOrCreate(
            ['user_id' => $userId]
        );
        $wallet->total_balance = $wallet->total_balance + floatval($qty);
        $wallet->save();

        return $wallet;
    }
}
