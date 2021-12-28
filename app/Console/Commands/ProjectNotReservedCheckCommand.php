<?php

namespace App\Console\Commands;

use App\Events\ProjectNotReservedEvent;
use App\Project;
use Illuminate\Console\Command;

class ProjectNotReservedCheckCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'projects:not_reserved:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify user if project not reserved after X hours';

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
        $notReservedLimitTime = now()->subMinutes(config('settings.project_not_reserved'));

        $project->whereIn('status', [Project::STATUS_OPEN])
                ->whereNull('reserved_at')
                ->where('notified_not_reserved', false)
                ->where('created_at', '<', $notReservedLimitTime)
                ->chunk(10, function ($projects) {
                    foreach ($projects as $project) {
                        $project->update(['notified_not_reserved' => true]);
                        print_r($project->id);
                        print_r("\n");
                        event(new ProjectNotReservedEvent($project));
                    }
                });

//        config('settings.project_not_reserved');
//
//        print_r(now()->subMinutes(config('settings.project_not_reserved')));
    }
}
