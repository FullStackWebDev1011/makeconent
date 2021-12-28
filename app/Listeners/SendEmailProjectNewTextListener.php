<?php

namespace App\Listeners;

use App\Events\ProjectNewTextEvent;
use App\Mail\ProjectNewTextMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendEmailProjectNewTextListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        Mail::to($event->project->user)->send(new ProjectNewTextMail($event->project));
    }
}
