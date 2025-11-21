<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Mail\LoginNotification;

class TestEmailNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:test {email?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test email notification untuk memastikan SMTP bekerja dengan benar';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🧪 Testing Email Notification...');
        $this->newLine();

        // Cek konfigurasi mail
        $mailer = config('mail.default');
        $this->info("📧 Mail Driver: {$mailer}");

        if ($mailer === 'log') {
            $this->warn('⚠️  WARNING: Mail driver masih menggunakan "log"!');
            $this->warn('   Email tidak akan terkirim, hanya ditulis ke log file.');
            $this->warn('   Update MAIL_MAILER=smtp di file .env');
            $this->newLine();
        }

        // Ambil email dari parameter atau gunakan default
        $email = $this->argument('email') ?? 'mawarkusuma694@gmail.com';
        
        $this->info("📬 Testing email ke: {$email}");
        $this->newLine();

        // Cari user berdasarkan email
        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("❌ User dengan email {$email} tidak ditemukan di database!");
            $this->info('   Pastikan user sudah terdaftar dengan menjalankan: php artisan db:seed --class=UserSeeder');
            return Command::FAILURE;
        }

        $this->info("✅ User ditemukan: {$user->name} ({$user->email})");
        $this->newLine();

        // Test kirim email
        try {
            $this->info('📤 Mengirim email test...');
            
            Mail::to($user->email)->send(new LoginNotification($user, '127.0.0.1', 'Test Browser'));
            
            $this->info('✅ Email berhasil dikirim!');
            $this->newLine();
            $this->info("📬 Cek inbox Gmail: {$email}");
            $this->info('   - Cek folder Inbox');
            $this->info('   - Cek folder Spam/Junk jika tidak ada di Inbox');
            $this->newLine();
            
            if ($mailer === 'log') {
                $this->warn('⚠️  Karena menggunakan driver "log", email hanya ditulis ke:');
                $this->warn('   storage/logs/laravel.log');
            }

            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error('❌ Gagal mengirim email!');
            $this->error('   Error: ' . $e->getMessage());
            $this->newLine();
            $this->info('🔧 Troubleshooting:');
            $this->info('   1. Pastikan SMTP sudah dikonfigurasi di .env');
            $this->info('   2. Pastikan MAIL_MAILER=smtp');
            $this->info('   3. Pastikan MAIL_USERNAME dan MAIL_PASSWORD benar');
            $this->info('   4. Pastikan menggunakan Gmail App Password, bukan password biasa');
            $this->info('   5. Jalankan: php artisan config:clear');
            
            return Command::FAILURE;
        }
    }
}
