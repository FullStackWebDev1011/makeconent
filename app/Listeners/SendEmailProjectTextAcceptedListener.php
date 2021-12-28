<?php

namespace App\Listeners;

use App\Mail\ProjectTextAcceptedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendEmailProjectTextAcceptedListener
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
     * @param  object $event
     *
     * @return void
     */
    public function handle($event)
    {
        Mail::to($event->project->seller)->send(new ProjectTextAcceptedMail($event->project));
    }
}
