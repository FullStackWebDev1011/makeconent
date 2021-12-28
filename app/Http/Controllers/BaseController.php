<?php

namespace App\Http\Controllers;

use App\PayU;
use App\Setting;
use App\Transaction;
use App\Wallet;
use App\AdminWallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BaseController extends Controller
{
    public function __construct()
    {
        $this->configure_openpayu();
        $this->middleware(['auth', 'active']);
    }

    /**
     * Configure PayU
     */
    //TODO also need to be extracted into service
    private function configure_openpayu(){
        \OpenPayU_Configuration::setEnvironment(config('services.pay_u.mode'));
        \OpenPayU_Configuration::setMerchantPosId(config('services.pay_u.pos_id'));
        \OpenPayU_Configuration::setSignatureKey(config('services.pay_u.signature_key'));
        \OpenPayU_Configuration::setOauthClientId(config('services.pay_u.o_auth_client_id'));
        \OpenPayU_Configuration::setOauthClientSecret(config('services.pay_u.o_auth_client_secret'));
    }

    //TODO have to be extracted to own service, or moved to model Transaction
    //also best practices told us, to inject models into controller constructor
    public function createTransaction($qty, $userId, $status, $currency='USD'){
        $transaction = new Transaction();
        $transaction->qty = $qty;
        $transaction->user_id = $userId;
        $transaction->type = 'deposit';
        $transaction->status = $status;
        $transaction->currency = $currency;
        $transaction->save();
        return $transaction->id;
    }
    //TODO have to be extracted to own service, or moved to model Wallet
    public function updateWallet($qty, $userId){
        $wallet = Wallet::updateOrCreate(
            ['user_id' => $userId]
        );
        $wallet->total_balance = $wallet->total_balance + floatval($qty);
        $wallet->save();
        return $wallet;
    }
    public function updateAdminWallet($qty){
        $adminWallet = AdminWallet::first();
        if (!isset($adminWallet)) $adminWallet = new AdminWallet();
        $adminWallet->total_balance = $adminWallet->total_balance + floatval($qty);
        $adminWallet->save();
    }
}
