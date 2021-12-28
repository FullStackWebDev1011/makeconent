<?php

namespace App\Mail;

use App\Document;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use PDF;

class WithdrawMoneyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $document;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Document $document)
    {
        $this->document = $document;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $message = $this->view('mails.copywriter.withdraw_money',
            ['user' => $this->document->user, 'document' => $this->document])
                        ->subject(__('mails.copywriter_withdraw_money', ['document' => $this->document->getNumber()]));

        if ( ! $this->document->user->isCompany) {
            $total_balance = $this->document->qty;
            $tax = $total_balance * 18.699 / 100;
            $info['bruto'] = $total_balance - $tax;
            $info['bruto_tax'] = $info['bruto'] * 0.2;
            $info['bruto_minus_tax'] = $total_balance - $info['bruto_tax'];
            $info['podtava_opodot'] = round($info['bruto']) - round($info['bruto_tax']);
            $info['podatek_dochodowy'] = round($info['podtava_opodot'] * 0.17);
            $info['kwota_do_wyplaty'] = $info['bruto'] - $info['podatek_dochodowy'];

            $pdf = PDF::loadView('pdf.document',
                ['document' => $this->document, 'info' => $info, 'user' => $this->document->user]);

            $message->attachData($pdf->output(),
                'document_'.$this->document->id.'_'.$this->document->created_at->format('Y-m-d_H-i').'.pdf');
        }

        return $message;

    }
}
