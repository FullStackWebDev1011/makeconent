<?php

namespace App\Mail;

use App\Invoice;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use PDF;

class AddFoundsMail extends Mailable
{
    use Queueable, SerializesModels;

    public $invoice;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $pdf = PDF::loadView('pdf.invoice_new', ['invoice' => $this->invoice, 'user' => $this->invoice->user]);

        return $this->view('mails.user.add_founds', ['user' => $this->invoice->user, 'invoice' => $this->invoice])
                    ->subject(__('mails.your_invoice', ['invoice' => $this->invoice->getNumber()]))->attachData($pdf->output(),
                'invoice_'.$this->invoice->id.'_'.$this->invoice->created_at->format('Y-m-d_H-i').'.pdf');
    }
}
