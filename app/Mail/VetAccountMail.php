<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VetAccountMail extends Mailable
{
    use Queueable, SerializesModels;

    public $vet;
    public $tempPassword;

    /**
     * Create a new message instance.
     */
    public function __construct($vet, $tempPassword)
    {
        $this->vet = $vet;
        $this->tempPassword = $tempPassword;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your VetCare Account',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.vet-account',
        );
    }
}
