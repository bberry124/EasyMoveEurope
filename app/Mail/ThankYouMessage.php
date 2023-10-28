<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ThankYouMessage extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $name;
    private $to_addr;
    public $email, $subject, $message_given;

    public function __construct($name, $to, $contents = [])
    {
        $this->name = $name;
        $this->to_addr = $to;
        if (!empty($contents)) {
            $this->email = $contents['email'];
            $this->subject = $contents['subject'];
            $this->message_given = $contents['message'];
        }
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        if ($this->to_addr != 'info@easymoveeurope.com') {
            return new Envelope(
                subject: __('Thank you for contacting us'),

            );
        } else {
            return new Envelope(
                subject: __('Someone Tried To Contact You'),

            );

        }
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {

        if ($this->to_addr != config('mail.mailers.smtp.username')) {
            return new Content(
                view: 'emails.thankyou',
            );
        } else {
            return new Content(
                view: 'emails.admin_contacted',
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
