<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    private $invoice_id, $which_view;
    public function __construct($id, $which_view='bank')
    {
        $this->invoice_id = $id;
        $this->which_view  = $which_view;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: __("Easy Move Europe Invoice"),
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        if($this->which_view == 'defferd')
        {
            return new Content(
                markdown: 'deferred_payment_mail',
                with: ['invoice_id' => $this->invoice_id]
            );
        }
        else
        {
            return new Content(
                markdown: $this->which_view == 'bank' ? 'invoice_bank_payment_mail' : 'invoice_payment_mail',
                with: ['invoice_id' => $this->invoice_id]
            );
        }
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }


}
