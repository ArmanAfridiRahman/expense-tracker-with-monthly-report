<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PasswordResetMail extends Mailable
{
    use Queueable, SerializesModels;
     public string $resetUrl;

    public function __construct(string $resetUrl)
    {
        $this->resetUrl = $resetUrl;
    }

    /**
     * Summary of envelope
     * @return Envelope
     */
    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Your Password Reset Link');
    }

    /**
     * Summary of content
     * @return Content
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.password-reset-link',
            with: ['url' => $this->resetUrl]
        );
    }

    /**
     * Summary of attachments
     * @return array
     */
    public function attachments(): array
    {
        return [];
    }
}
