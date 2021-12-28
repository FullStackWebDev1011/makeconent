<?php

namespace App\Console\Commands;

use App\Project;
use Illuminate\Console\Command;

class CheckExpiredProjects extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'projects:expired:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check is Project order expired and if yes mark it as "open" and remove current copywriter';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(Project $project)
    {
        $project->whereIn('status', [Project::STATUS_PENDING, Project::STATUS_AMENDMENT])->whereNotNull('reserved_at')
                ->chunk(100, function ($projects) {
                    foreach ($projects as $project) {
                        if ($project->getDeadLineDate() < now()) {
                            $project->doSellerJumpOut();
                        }
                    }
                });
    }
}
