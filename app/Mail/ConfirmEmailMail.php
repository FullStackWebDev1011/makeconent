<?php

namespace App\Mail;

use App\User;
use Carbon\Carbon;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class ConfirmEmailMail extends Mailable
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
        $verifyUrl = URL::temporarySignedRoute(
            'verification.verify', Carbon::now()->addMinutes(60),
            ['id' => $this->user->getKey(), 'hash' => sha1($this->user->getEmailForVerification()),]
        );

        return $this->view('mails.confirm', ['user' => $this->user, 'verifyUrl' => $verifyUrl])
                    ->subject(__('mails.verify_email_address'));
    }
}
