<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CopywriterAcceptMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $message = $this->view('mails.copywriter.account_accepted', ['user' => $this->user])
                        ->subject(__('mails.copywriter_account_accepted'));
        
        if ($this->user->isCompany == false) {
            $message->attach(config('settings.rules_file.path'), ['as' => config('settings.rules_file.email_name')]);
        }

        return $message;
    }
}
