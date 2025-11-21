<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class TestPasswordReset extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'password:test {role?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test password reset untuk semua role (guru, tu, kepala_sekolah)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔑 Testing Password Reset untuk Semua Role...');
        $this->newLine();

        $role = $this->argument('role');

        if ($role) {
            // Test untuk role tertentu
            $this->testRole($role);
        } else {
            // Test untuk semua role
            $this->info('📋 Testing untuk semua role:');
            $this->newLine();

            // Test Guru
            $this->testRole('guru');
            $this->newLine();

            // Test TU
            $this->testRole('tu');
            $this->newLine();

            // Test Kepala Sekolah
            $this->testRole('kepala_sekolah');
        }

        $this->newLine();
        $this->info('✅ Test selesai!');
        $this->info('📖 Lihat PANDUAN_RESET_PASSWORD_SEMUA_ROLE.md untuk panduan lengkap.');

        return Command::SUCCESS;
    }

    private function testRole($role)
    {
        $roleText = match($role) {
            'guru' => 'Guru',
            'tu' => 'Tenaga Usaha',
            'kepala_sekolah' => 'Kepala Sekolah',
            default => 'Pengguna'
        };

        $this->info("👤 Testing untuk Role: {$roleText}");
        $this->line("   Role code: {$role}");

        $users = User::where('role', $role)->get();

        if ($users->isEmpty()) {
            $this->warn("   ⚠️  Tidak ada user dengan role {$roleText}");
            return;
        }

        $this->info("   ✅ Ditemukan {$users->count()} user:");
        $this->newLine();

        $this->table(
            ['No', 'Nama', 'Email', 'Status'],
            $users->map(function ($user, $index) {
                return [
                    $index + 1,
                    $user->name,
                    $user->email,
                    '✅ Aktif'
                ];
            })->toArray()
        );

        $this->newLine();
        $this->info("   📝 Cara test reset password untuk {$roleText}:");
        $this->line("   1. Buka: http://127.0.0.1:8000/forgot-password");
        $this->line("   2. Pilih Role: {$roleText}");
        $this->line("   3. Masukkan email dari daftar di atas");
        $this->line("   4. Klik 'Kirim Link Reset Password'");
        $this->line("   5. Langsung akan diarahkan ke halaman reset password");
        $this->line("   6. Masukkan password baru");
        $this->line("   7. Login dengan password baru");
    }
}

