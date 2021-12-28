<?php

namespace App\Http\Controllers;

use App\Countries;
use App\Invoice;
use App\Project;
use App\StripeLogs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use PDF;

class StripeController extends BaseController
{

	protected $dev_publishable_key = "pk_test_51IhvShAl7ip8OlX9rI72TKxalx7CYxos2FFAhQDVWxBuXMycFGP2rJwoJA2oFgb31LsaMOjVw3Gw96chRo0akfWo005gPDlg2e";
	protected $prod_publishable_key = "";

	protected $dev_secret_key = "sk_test_51IhvShAl7ip8OlX9PVZke4Rg7kbLcSXwvZrcCPAbgbcfoETLRqSJbZr12hAFJKQX9hwiE40xkbeBOhnSQDV2twFc00nOsibsKH";
	protected $prod_secret_key = "";

	function __construct(){
		// define credential
		if(env('APP_ENV')=='prod' || env('APP_ENV')=='production'){
			/* rdl */
			$this->publishable_key = $this->prod_publishable_key;
			$this->secret_key = $this->prod_secret_key;
		}else{
			/* rdl */
			$this->publishable_key = $this->dev_publishable_key;
			$this->secret_key = $this->dev_secret_key;
		}
    }
    
    public function checkout(Request $request) {
		$data = $request->all();
		Log::info($data);Log::info(session()->all());
		$project = Project::find($request->id);		
		if(!$project) return redirect()->back()->withErrors(['error' => 'Project Not Found']);
		if($project->status != 'sketch') return redirect()->back()->withErrors(['error' => 'This project already paid']);
		$user = Auth::user();
		$country = Countries::find($user['country_id']);

		try {
			$stripe = new \Stripe\StripeClient($this->dev_secret_key);
			$payment_intent = $stripe->paymentIntents->create([
				'amount' => (float)$project->budget,
				'currency' => strtolower($country['currency']),
				'payment_method_types' => ['card'],
				'description' => 'Payment From '.$user->getFullName(),
			]);
			StripeLogs::create("checkout",array_merge($data,['projectid'=>$project->id]),$payment_intent);
			
			$stripe_intent = $payment_intent->client_secret;
			$publishable_key = $this->publishable_key;
			
			$menu = 'Stripe';
			$submenu = 'payments';
			return view('stripe.checkout', compact('menu','submenu','project','publishable_key', 'stripe_intent'));
		} catch (\Exception $e) {
			//here you decide, how application had to resolve this
			Log::info('something wrong with your request '.$e->getMessage());
			StripeLogs::create("deposit",$e->getMessage());

			return redirect()->back()->withErrors(['error' => $e->getMessage()]);
		}
	}

		public function charges($qty,$source,$desc){
			$stripe = new \Stripe\StripeClient($this->secret_key);
			$resp = $stripe->charges->create([
				'amount' => $qty,
				'currency' => strtolower('PLN'),
				'source' => $source,
				'description' => $desc,
			]);
			return $resp;
		}

		public function retrieve($id){
			$stripe = new \Stripe\StripeClient( $this->secret_key );
			return $stripe->charges->retrieve( $id, [] );
		}

		public function retrievePayment($id){
			$stripe = new \Stripe\StripeClient( $this->secret_key );
			return $stripe->paymentMethods->retrieve( $id, [] );
		}

		public function retrieveTrx($id){
			$stripe = new \Stripe\StripeClient( $this->secret_key );
			return $stripe->balanceTransactions->retrieve($id);
		}

		public function deposit(Request $request){
			$data = $request->all();
			Log::info($data);Log::info(session()->all());
			if(!isset($data['name'])) return redirect()->back()->withErrors(['error' => 'The name field is required']);
			if(!isset($data['amount'])) return redirect()->back()->withErrors(['error' => 'The amount field is required']);
			if(!isset($data['stripeToken'])) return redirect()->back()->withErrors(['error' => 'Something wrong please try again']);

			$country = Countries::find(Auth::user()->country_id);
			try {
				$stripe = new \Stripe\StripeClient($this->secret_key);
				$resp = $stripe->charges->create([
					'amount' => isx($data['amount'],0),
					'currency' => strtolower($country['currency']),
					'source' => isx($data['stripeToken'],''),
					'description' => "Deposit from ".isx($data['name'],''),
					'receipt_email' => Auth::user()->email,
				]);
				StripeLogs::create("deposit",$data,$resp);

				$trx = $this->retrieveTrx($resp['balance_transaction']);
				$qty = (float) $trx->net/100;

				$userId = Auth::user()->id;
				$transaction_id = $this->createTransaction($qty, $userId, 'finish', $country['currency']);
				$this->updateWallet($qty, $userId);
				// update admin wallet
				$this->updateAdminWallet($qty);
				
				// make invoice pdf
				$invoice = new Invoice();
				$invoice->invoice_number = $resp->id;
				$invoice->status = 'finish';
				$invoice->qty = $qty;
				$invoice->user_id = $userId;
				$invoice->transaction_id = $transaction_id;
				$invoice->save();

				$pdf = PDF::loadView('pdf.stripe_invoice', ['trx'=>$trx,'order' => $resp, 'invoice' => $invoice, 'user' => Auth::user()]);
				$filename = 'invoice_'.date('Y-m-d').Auth::user()->name.$resp->id.'.pdf';
				if (!file_exists(storage_path('pdf'))) mkdir(storage_path('pdf'), 0777, true);
				$pdf->save(storage_path('pdf'.DIRECTORY_SEPARATOR.$filename));

				$invoice->attachment = 'pdf'.DIRECTORY_SEPARATOR.$filename;
				$invoice->save();
				
				return redirect('/payments')->with('payment_success', true);
			} catch (\Exception $e) {
				//here you decide, how application had to resolve this
				Log::info('something wrong with your request '.$e->getMessage());
				StripeLogs::create("deposit",$e->getMessage());

				return redirect()->back()->withErrors(['error' => $e->getMessage()]);
			}
		}

		public function notification(Request $request){
			// $payload = @file_get_contents('php://input');
			$payload = $request->all();
			$event = null;

			try {
				$event = \Stripe\Event::constructFrom(
					json_decode($payload, true)
				);
			} catch(\UnexpectedValueException $e) {
				// Invalid payload
				http_response_code(400);
				exit();
			}

			// Handle the event
			switch ($event->type) {
				case 'payment_intent.succeeded':
					$paymentIntent = $event->data->object; // contains a \Stripe\PaymentIntent
					// Then define and call a method to handle the successful payment intent.
					// handlePaymentIntentSucceeded($paymentIntent);
					break;
				case 'payment_method.attached':
					$paymentMethod = $event->data->object; // contains a \Stripe\PaymentMethod
					// Then define and call a method to handle the successful attachment of a PaymentMethod.
					// handlePaymentMethodAttached($paymentMethod);
					break;
				// ... handle other event types
				default:
					echo 'Received unknown event type ' . $event->type;
			}

			http_response_code(200);
		}
}
