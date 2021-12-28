<?php

namespace App\Listeners;

use App\Mail\AddFoundsMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendEmailAddFoundsInvoiceListener
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
        Mail::to($event->invoice->user)->send(new AddFoundsMail($event->invoice));
    }
}
