<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $token;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $token)
    {
        $this->user = $user;
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $verifyUrl = url(config('app.url').route('password.reset',
                ['token' => $this->token, 'email' => $this->user->getEmailForPasswordReset()], false));

        return $this->view('mails.password_reset',
            ['user' => $this->user, 'token' => $this->token, 'verifyUrl' => $verifyUrl])
                    ->subject(__('mails.password_reset'));
    }
}
