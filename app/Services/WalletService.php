<?php

namespace App\Services;

use App\Project;
use App\Transaction;
use App\Wallet;

class WalletService
{
    public $wallet;
    public $transaction;

    public function __construct(Wallet $wallet, Transaction $transaction)
    {
        $this->wallet = $wallet;
        $this->transaction = $transaction;
    }

    public function updateProjectPrice(Project $project, $newBudget)
    {
        if ($newBudget <= $project->budget) {
            return false;
        }

        $extraCost = $newBudget - $project->budget;

        if (auth()->user()->wallet->total_balance >= $extraCost) {
            auth()->user()->wallet->update(['total_balance' => (auth()->user()->wallet->total_balance - $extraCost)]);
            $project->update(['budget' => $newBudget]);
            auth()->user()->transactions()->create([
                'status' => Transaction::STATUS_FINISH,
                'type' => Transaction::TYPE_ORDER,
                'qty' => $extraCost,
                'source' => $project->id,
            ]);

            return true;
        } else {
            return false;
        }

    }
}
