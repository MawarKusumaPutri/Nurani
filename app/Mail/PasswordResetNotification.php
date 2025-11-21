<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class PasswordResetNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $resetUrl;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, $resetUrl)
    {
        $this->user = $user;
        $this->resetUrl = $resetUrl;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $fromAddress = $this->user->email;
        $fromName = config('mail.from.name', env('MAIL_FROM_NAME', 'MTs Nurul Aiman'));

        return new Envelope(
            from: new \Illuminate\Mail\Mailables\Address($fromAddress, $fromName),
            subject: 'Reset Password - ' . config('app.name'),
            replyTo: [new \Illuminate\Mail\Mailables\Address($fromAddress, $fromName)],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.password-reset',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }

    /**
     * Get the message headers.
     * Menambahkan header untuk memastikan email masuk ke Inbox, bukan Spam
     */
    public function headers(): \Illuminate\Mail\Mailables\Headers
    {
        $fromAddress = $this->user->email;
        
        return new \Illuminate\Mail\Mailables\Headers(
            text: [
                'X-Mailer' => 'TMS NURANI - MTs Nurul Aiman',
                'X-Priority' => '1',
                'X-MSMail-Priority' => 'High',
                'Importance' => 'high',
                'Precedence' => 'bulk',
                'Message-ID' => '<' . time() . '.' . md5($this->user->email . $this->resetUrl) . '@' . parse_url(config('app.url'), PHP_URL_HOST) . '>',
                'Return-Path' => $fromAddress,
            ],
        );
    }
}

