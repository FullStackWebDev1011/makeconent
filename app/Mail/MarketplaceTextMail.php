<?php

namespace App\Mail;

use App\Sell;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MarketplaceTextMail extends Mailable
{
    use Queueable, SerializesModels;

    public $sell;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Sell $sell)
    {
        $this->sell = $sell;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.copywriter.new_order', ['user' => $this->sell->buyer])
                    ->subject(__('mails.copywriter_new_order'));
    }
}
