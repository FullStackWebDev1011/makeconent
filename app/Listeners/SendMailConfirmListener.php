<?php

namespace App\Listeners;

use App\Mail\ConfirmEmailMail;
use App\UserLevel;
use Illuminate\Support\Facades\Mail;

class SendMailConfirmListener
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
        $level = UserLevel::find($event->user->level_id);
        if (isset($level)&&$level['levelType'] == UserLevel::TYPE_CLIENT) {
            // Mail::to($event->user)->send(new ConfirmEmailMail($event->user));
        }
    }
}
