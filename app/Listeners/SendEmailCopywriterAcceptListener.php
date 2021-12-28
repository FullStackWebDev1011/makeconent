<?php

namespace App\Listeners;

use App\Mail\CopywriterAcceptMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendEmailCopywriterAcceptListener
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
        Mail::to($event->user)->send(new CopywriterAcceptMail($event->user));
    }
}
