<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Guru;
use Illuminate\Support\Facades\Hash;

class SyncUserEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:sync-emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync user emails from old to new email addresses';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting email synchronization...');

        // Mapping email lama ke email baru berdasarkan nama
        $emailMappings = [
            // Guru
            'nurhadi@mtssnuraiman.sch.id' => 'mundarinurhadi@gmail.com',
            'nurhadi@nurani.com' => 'mundarinurhadi@gmail.com',
            'keysha@mtssnuraiman.sch.id' => 'keysa8406@gmail.com',
            'keysha@nurani.com' => 'keysa8406@gmail.com',
            'fadli@mtssnuraiman.sch.id' => 'fadliziyad123@gmail.com',
            'fadli@nurani.com' => 'fadliziyad123@gmail.com',
            'siti.mundari@mtssnuraiman.sch.id' => 'sitimundari54@gmail.com',
            'siti.mundari@nurani.com' => 'sitimundari54@gmail.com',
            'desy.nurfalah@mtssnuraiman.sch.id' => 'desinurfalah24@gmail.com',
            'desy.nurfalah@nurani.com' => 'desinurfalah24@gmail.com',
            'm.rizmal.maulana@mtssnuraiman.sch.id' => 'rizmalmaulana25@gmail.com',
            'rizmal.maulana@nurani.com' => 'rizmalmaulana25@gmail.com',
            'hamzah.nazmudin@mtssnuraiman.sch.id' => 'zahnajmudin10@gmail.com',
            'hamzah.nazmudin@nurani.com' => 'zahnajmudin10@gmail.com',
            'sopyan@mtssnuraiman.sch.id' => 'sopyanikhsananda@gmail.com',
            'sopyan@nurani.com' => 'sopyanikhsananda@gmail.com',
            'syifa.restu.rahayu@mtssnuraiman.sch.id' => 'syifarestu81@gmail.com',
            'syifa.restu@nurani.com' => 'syifarestu81@gmail.com',
            'weny@mtssnuraiman.sch.id' => 'wenibustamin27@gmail.com',
            'weny@nurani.com' => 'wenibustamin27@gmail.com',
            'tintin.martini@mtssnuraiman.sch.id' => 'tintinmartini184@gmail.com',
            'tintin.martini@nurani.com' => 'tintinmartini184@gmail.com',
            
            // Kepala Sekolah
            'maman.suparman@mtssnuraiman.scl' => 'mamansuparmanaks07@gmail.com',
            
            // Tenaga Usaha
            'tu@mtssnuraiman.sch.id' => 'internal.nurulaiman@gmail.com',
        ];

        $updated = 0;
        $skipped = 0;
        $errors = 0;

        foreach ($emailMappings as $oldEmail => $newEmail) {
            // Cari user dengan email lama
            $user = User::where('email', $oldEmail)->first();
            
            if ($user) {
                // Cek apakah email baru sudah ada
                $existingUser = User::where('email', $newEmail)->first();
                
                if ($existingUser) {
                    $this->warn("Email baru {$newEmail} sudah ada. Melewatkan update untuk {$oldEmail}");
                    $skipped++;
                } else {
                    // Update email
                    $user->email = $newEmail;
                    $user->save();
                    
                    $this->info("✓ Updated: {$oldEmail} → {$newEmail}");
                    $updated++;
                }
            } else {
                // Email lama tidak ditemukan, mungkin sudah diupdate atau belum ada
                $this->line("  Email {$oldEmail} tidak ditemukan di database");
            }
        }

        // Hapus email generic guru jika ada
        $genericGuru = User::where('email', 'guru@mtssnuraiman.sch.id')->where('role', 'guru')->first();
        if ($genericGuru) {
            // Cek apakah ada guru record terkait
            $guru = Guru::where('user_id', $genericGuru->id)->first();
            if ($guru) {
                $guru->delete();
            }
            $genericGuru->delete();
            $this->info("✓ Deleted generic guru account");
            $updated++;
        }

        $this->newLine();
        $this->info("Synchronization completed!");
        $this->info("Updated: {$updated}");
        $this->info("Skipped: {$skipped}");
        $this->info("Errors: {$errors}");

        // Sekarang jalankan seeder untuk memastikan semua data ada
        $this->newLine();
        $this->info('Running UserSeeder to ensure all data is up to date...');
        $this->call('db:seed', ['--class' => 'UserSeeder']);

        return Command::SUCCESS;
    }
}
