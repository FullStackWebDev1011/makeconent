<?php

namespace App\Services;

use App\Invoice;
use App\Project;
use App\Transaction;
use App\UserRate;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use ZanySoft\Zip\Zip;

class ProjectService
{
    public function __construct()
    {
    }

    public function reject(Project $project)
    {
        if ( ! in_array($project->status, [Project::STATUS_WRITTEN])) {
            return false;
        }

        $project->update(['status' => Project::STATUS_REJECTED]);

        auth()->user()->transactions()->create([
            'status' => Transaction::STATUS_FINISH,
            'type' => Transaction::TYPE_REFUND,
            'qty' => (float)str_replace(',', '.', $project->budget),
            'source' => $project->id,
        ]);

        auth()->user()->wallet->update([
            'total_balance' => ((float)auth()->user()->wallet->total_balance + (float)str_replace(',', '.',
                    $project->budget)),
        ]);

        $project->seller->userRates()->create([
            'project_id' => $project->id,
            'is_positive' => false,
        ]);

        $project->seller->increment('rate_negative');

        return true;
    }

    public function accept(Project $project)
    {
        $project->seller->userRates()->create([
            'project_id' => $project->id,
            'is_positive' => true,
        ]);

        $project->seller->increment('rate_positive');
    }

    public function reviewAccept(Project $project){
        $project->update(['status' => Project::STATUS_WRITTEN]);
    }
}
