<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class LogoutNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $logoutTime;
    public $ipAddress;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, $ipAddress = null)
    {
        $this->user = $user;
        $this->logoutTime = now();
        $this->ipAddress = $ipAddress ?? request()->ip();
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '👋 Notifikasi Logout - ' . config('app.name'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.logout-notification',
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
}
