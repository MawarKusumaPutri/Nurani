<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class SetupGmailSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gmail:setup {email} {app_password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup konfigurasi Gmail SMTP untuk sinkronisasi email notifikasi';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $appPassword = $this->argument('app_password');

        $this->info('🔧 Setup Konfigurasi Gmail SMTP...');
        $this->newLine();

        // Validasi email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->error('❌ Email tidak valid!');
            return Command::FAILURE;
        }

        // Validasi app password (harus 16 karakter tanpa spasi)
        $cleanPassword = str_replace(' ', '', $appPassword);
        if (strlen($cleanPassword) !== 16) {
            $this->warn('⚠️  App Password harus 16 karakter!');
            $this->info('   Format: xxxx xxxx xxxx xxxx atau xxxxxxxxxxxxxxxx');
        }

        // Baca file .env
        $envPath = base_path('.env');
        
        if (!File::exists($envPath)) {
            $this->error('❌ File .env tidak ditemukan!');
            return Command::FAILURE;
        }

        $envContent = File::get($envPath);

        // Update konfigurasi mail
        $mailConfig = [
            'MAIL_MAILER' => 'smtp',
            'MAIL_HOST' => 'smtp.gmail.com',
            'MAIL_PORT' => '587',
            'MAIL_USERNAME' => $email,
            'MAIL_PASSWORD' => $appPassword,
            'MAIL_ENCRYPTION' => 'tls',
            'MAIL_FROM_ADDRESS' => $email,
            'MAIL_FROM_NAME' => '"MTs Nurul Aiman"',
        ];

        $this->info('📝 Mengupdate konfigurasi .env...');
        
        foreach ($mailConfig as $key => $value) {
            // Cek apakah sudah ada
            if (preg_match("/^{$key}=.*/m", $envContent)) {
                // Update existing
                $envContent = preg_replace(
                    "/^{$key}=.*/m",
                    "{$key}={$value}",
                    $envContent
                );
                $this->line("   ✅ Updated: {$key}");
            } else {
                // Tambahkan baru
                $envContent .= "\n{$key}={$value}";
                $this->line("   ✅ Added: {$key}");
            }
        }

        // Simpan file .env
        File::put($envPath, $envContent);

        $this->newLine();
        $this->info('✅ Konfigurasi .env berhasil diupdate!');
        $this->newLine();

        // Clear cache
        $this->info('🧹 Clearing cache...');
        $this->call('config:clear');
        $this->call('cache:clear');
        $this->info('✅ Cache cleared!');
        $this->newLine();

        // Tampilkan konfigurasi
        $this->info('📋 Konfigurasi yang sudah diupdate:');
        $this->table(
            ['Setting', 'Value'],
            [
                ['MAIL_MAILER', 'smtp'],
                ['MAIL_HOST', 'smtp.gmail.com'],
                ['MAIL_PORT', '587'],
                ['MAIL_USERNAME', $email],
                ['MAIL_PASSWORD', '**** (tersembunyi)'],
                ['MAIL_ENCRYPTION', 'tls'],
                ['MAIL_FROM_ADDRESS', $email],
                ['MAIL_FROM_NAME', 'MTs Nurul Aiman'],
            ]
        );

        $this->newLine();
        $this->info('🎯 Langkah Selanjutnya:');
        $this->line('   1. Test email dengan: php artisan email:test ' . $email);
        $this->line('   2. Login ke sistem dengan email: ' . $email);
        $this->line('   3. Cek Gmail Inbox (atau Spam jika belum ada)');
        $this->line('   4. Jika masuk Spam, buat filter Gmail (lihat CARA_HINDARI_SPAM.md)');
        $this->newLine();

        return Command::SUCCESS;
    }
}

