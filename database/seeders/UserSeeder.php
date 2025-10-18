<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Guru User
        User::updateOrCreate(
            ['email' => 'guru@nurani.com'],
            [
                'name' => 'Budi Santoso',
                'password' => Hash::make('guru123'),
                'role' => 'guru',
                'nip' => 'GRU001',
                'phone' => '081234567890',
                'address' => 'Jl. Pendidikan No. 1, Jakarta'
            ]
        );

        // Create another Guru User
        User::updateOrCreate(
            ['email' => 'siti@nurani.com'],
            [
                'name' => 'Siti Aminah',
                'password' => Hash::make('guru123'),
                'role' => 'guru',
                'nip' => 'GRU002',
                'phone' => '081234567891',
                'address' => 'Jl. Guru Sejahtera No. 2, Jakarta'
            ]
        );

        // Create another Guru User
        User::updateOrCreate(
            ['email' => 'ahmad@nurani.com'],
            [
                'name' => 'Ahmad Rizki',
                'password' => Hash::make('guru123'),
                'role' => 'guru',
                'nip' => 'GRU003',
                'phone' => '081234567892',
                'address' => 'Jl. Pendidikan Maju No. 3, Jakarta'
            ]
        );

        // Create Tenaga Usaha User
        User::updateOrCreate(
            ['email' => 'tu@nurani.com'],
            [
                'name' => 'Ahmad Rizki',
                'password' => Hash::make('tu123'),
                'role' => 'tenaga_usaha',
                'nip' => 'TU001',
                'phone' => '081234567893',
                'address' => 'Jl. Pendidikan No. 1, Jakarta'
            ]
        );

        // Create another Tenaga Usaha User
        User::updateOrCreate(
            ['email' => 'sari@nurani.com'],
            [
                'name' => 'Sari Dewi',
                'password' => Hash::make('tu123'),
                'role' => 'tenaga_usaha',
                'nip' => 'TU002',
                'phone' => '081234567894',
                'address' => 'Jl. Pendidikan No. 2, Jakarta'
            ]
        );
    }
}