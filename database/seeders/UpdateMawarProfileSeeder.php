<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Guru;
use Illuminate\Support\Facades\DB;

class UpdateMawarProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cari user Mawar
        $user = User::where('email', 'mawarkusuma694@gmail.com')->first();
        
        if ($user) {
            // Update atau create guru record untuk Mawar
            $guru = Guru::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'nip' => 'GRU014',
                    'mata_pelajaran' => 'Basa Sunda',
                    'status' => 'aktif',
                    'kontak' => $user->phone ?? '081234567903', // Gunakan phone dari user atau default
                ]
            );
            
            // Update user phone jika belum ada
            if (!$user->phone) {
                $user->update([
                    'phone' => '081234567903'
                ]);
            }
            
            $this->command->info('Profil Mawar berhasil diperbarui!');
            $this->command->info('Mata Pelajaran: Basa Sunda');
            $this->command->info('Kontak: ' . ($guru->kontak ?? $user->phone ?? '081234567903'));
        } else {
            $this->command->error('User Mawar tidak ditemukan!');
        }
    }
}

