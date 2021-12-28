<?php

namespace App\Http\Controllers;

use App\Category;
use App\Events\MarketplaceTextOrderEvent;
use App\Sell;
use App\Setting;
use App\Transaction;
use App\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Validator;

class MarketController extends BaseController
{
    public function __construct()
    {
        $this->middleware(['auth', 'active']);
    }

    public function index()
    {
        $menu = 'marketplace';
        $submenu = '';
        $role = Auth::user()->role();
        $userId = Auth::user()->id;
        $categories = Category::all();
        $setting = Setting::first();

        $activeSells = Sell::where('user_id', $userId)->where('status', 'open')
                           ->orderBy('updated_at', 'desc')->get();
        $historySells = Sell::where('user_id', $userId)->whereIn('status', ['finish', 'cancel', 'pending'])
                            ->orderBy('updated_at', 'desc')->get();
        if ($role === 'client') {
            $activeSells = Sell::where('status', 'open')->orderBy('updated_at', 'desc')->get();

            return view('markets.client.market', compact('menu', 'submenu', 'categories',
                'setting', 'activeSells'));
        } else {
            return view('markets.copywriter.market', compact('menu', 'submenu', 'categories',
                'setting', 'activeSells', 'historySells'));
        }
    }

    public function boughtText()
    {
        $menu = '';
        $submenu = '';

        $userId = Auth::user()->id;
        $categories = Category::all();

        $historySells = Sell::where('user_id', $userId)->whereIn('status', ['finish', 'cancel', 'pending'])
                            ->orderBy('updated_at', 'desc')->get();

        return view('markets.client.market_buyed', compact('menu', 'submenu', 'categories', 'historySells'));
    }

    /**
     * Create new sell or update sell by its id
     *
     * @param Request $request
     *
     * @return array
     */
    public function create_sell(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|min:10|max:255',
            'text' => 'required|string|min:2500',
        ]);
        if ($validator->fails()) {
            return ['errors' => $validator->errors()];
        }
        $text = $request->text;
        $title = $request->title;
        $price = $request->price;
        $rate = $request->rate;
        $categoryId = $request->categoryId;
        $nChar = $request->nChar;
        $keyword = $request->keyword;
        $id = $request->id;

        $sell = new Sell;
        if ($id > 0) {
            $sell = Sell::find($id);
        }
        $sell->text = $text;
        $sell->title = $title;
        $sell->budget = $price;
        $sell->category_id = $categoryId;
        $sell->user_id = Auth::user()->id;
        $sell->status = Sell::STATUS_OPEN;
        $sell->rate = $rate;
        $sell->nChars = $nChar;
        $sell->keyword = $keyword;
        $sell->save();

        return ['status' => true];
    }

    /**
     * @param $id
     */
    public function buySell(Sell $sell)
    {
        $wallet = auth()->user()->wallet;
        if ( ! $wallet || $wallet->total_balance < $sell->budget) {
            return redirect()->back()
                             ->withErrors(["status" => "You dont have money, pay directly from PayU or top up wallet"]);
        } else {
            // reduce wallet from buyer (user), and increase of seller (copywriter)
            if ( ! $wallet) {
                $wallet = new Wallet;
            }
            $wallet->total_balance -= $sell->budget;
            $wallet->save();

            $sellerWaller = $sell->seller->wallet ?? null;

            if ( ! $sellerWaller) {
                $sellerWaller = new Wallet;
                $sellerWaller->user_id = $sell->user_id;
            }
            $sellerWaller->total_balance += $sell->budget;
            $sellerWaller->save();

            // update transaction
            $buyerTran = new Transaction;
            $buyerTran->user_id = auth()->id();
            $buyerTran->qty = $sell->budget;
            $buyerTran->source = $sell->id;
            $buyerTran->type = "buy";
            $buyerTran->save();

            $sellerTran = new Transaction;
            $sellerTran->user_id = $sell->user_id;
            $sellerTran->qty = $sell->budget;
            $sellerTran->source = $sell->id;
            $sellerTran->type = 'sell';
            $sellerTran->save();

            // update sell
            $sell->status = Sell::STATUS_FINISH;
            $sell->buyer_id = auth()->id();
            $sell->save();
            
            event(new MarketplaceTextOrderEvent($sell));

            return redirect()->back()->with(['status' => 'Successfully']);
        }
    }

    /**
     * @param $id
     */
    public function view_sell($id)
    {
        $sell = Sell::find($id);
//        $categories = Category::all();
//        return view('markets.components.market_view_modalbody', compact('sell', 'categories'));
        return compact('sell');
    }

    public function search_sell(Request $request)
    {
        Log::info(var_export($request->all(), true));
        $categoryId = $request->category_id;
        $rate = $request->rate;
        $min_chars = $request->min_chars;
        $max_chars = $request->max_chars;

        $q = Sell::where('rate', '<=', $rate)
                 ->where(function ($q) use ($min_chars, $max_chars) {
                     if (isset($min_chars)) {
                         $q->where('nChars', '>', $min_chars);
                     }
                     if (isset($max_chars)) {
                         $q->where('nChars', '<=', $max_chars);
                     }
                 });
        if ($categoryId != 0) {
            $q = $q->where('category_id', $categoryId);
        }

        $activeSells = $q->get();

        return view('markets.components.table', compact('activeSells'));
    }


}
