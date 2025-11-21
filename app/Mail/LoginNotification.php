<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class LoginNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $loginTime;
    public $ipAddress;
    public $userAgent;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, $ipAddress = null, $userAgent = null)
    {
        $this->user = $user;
        $this->loginTime = now();
        $this->ipAddress = $ipAddress ?? request()->ip();
        $this->userAgent = $userAgent ?? request()->userAgent();
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $roleText = match($this->user->role) {
            'guru' => 'Guru',
            'kepala_sekolah' => 'Kepala Sekolah',
            'tu' => 'Tenaga Usaha',
            default => 'Pengguna'
        };

        // Gunakan email penerima sebagai From address untuk semua email
        // Ini membuat Gmail melihatnya sebagai email dari diri sendiri (self-send)
        // Lebih kecil kemungkinan masuk ke Spam dan lebih mudah dipahami guru
        $fromAddress = $this->user->email; // Gunakan email penerima sebagai pengirim
        $fromName = config('mail.from.name', env('MAIL_FROM_NAME', 'MTs Nurul Aiman'));

        // Pastikan subject tidak terlalu panjang dan jelas
        $subject = 'Notifikasi Login - ' . $roleText . ' ' . config('app.name');
        
        return new Envelope(
            from: new \Illuminate\Mail\Mailables\Address($fromAddress, $fromName),
            subject: $subject,
            replyTo: [new \Illuminate\Mail\Mailables\Address($fromAddress, $fromName)],
            tags: ['login-notification', 'tms-nurani'],
            metadata: [
                'user_id' => (string) $this->user->id,
                'user_email' => $this->user->email,
                'login_time' => $this->loginTime->toIso8601String(),
            ],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.login-notification',
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
        $fromAddress = config('mail.from.address', env('MAIL_FROM_ADDRESS', 'noreply@example.com'));
        
        return new \Illuminate\Mail\Mailables\Headers(
            text: [
                'X-Mailer' => 'TMS NURANI - MTs Nurul Aiman',
                'X-Priority' => '1',
                'X-MSMail-Priority' => 'High',
                'Importance' => 'high',
                'Precedence' => 'bulk',
                'List-Unsubscribe' => '<' . route('welcome') . '>',
                'Message-ID' => '<' . time() . '.' . md5($this->user->email . $this->loginTime) . '@' . parse_url(config('app.url'), PHP_URL_HOST) . '>',
                'Return-Path' => $fromAddress,
            ],
        );
    }
}
