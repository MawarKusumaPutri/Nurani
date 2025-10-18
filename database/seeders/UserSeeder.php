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
        // Create Guru Users
        User::updateOrCreate(
            ['email' => 'guru1@nurani.com'],
            [
                'name' => 'Budi Santoso',
                'password' => Hash::make('guru123'),
                'role' => 'guru',
                'nip' => 'GRU001',
                'phone' => '081234567890',
                'address' => 'Jl. Simpang-Parakanmuncang Km 1.2, Cikondang, Gunungmanik, Kec. Tanjungsari Kabupaten Sumedang, Jawa Barat 45363'
            ]
        );

        User::updateOrCreate(
            ['email' => 'guru2@nurani.com'],
            [
                'name' => 'Siti Aminah',
                'password' => Hash::make('guru123'),
                'role' => 'guru',
                'nip' => 'GRU002',
                'phone' => '081234567891',
                'address' => 'Jl. Simpang-Parakanmuncang Km 1.2, Cikondang, Gunungmanik, Kec. Tanjungsari Kabupaten Sumedang, Jawa Barat 45363'
            ]
        );

        User::updateOrCreate(
            ['email' => 'guru3@nurani.com'],
            [
                'name' => 'Ahmad Rizki',
                'password' => Hash::make('guru123'),
                'role' => 'guru',
                'nip' => 'GRU003',
                'phone' => '081234567892',
                'address' => 'Jl. Simpang-Parakanmuncang Km 1.2, Cikondang, Gunungmanik, Kec. Tanjungsari Kabupaten Sumedang, Jawa Barat 45363'
            ]
        );

        User::updateOrCreate(
            ['email' => 'guru4@nurani.com'],
            [
                'name' => 'Dewi Kartika',
                'password' => Hash::make('guru123'),
                'role' => 'guru',
                'nip' => 'GRU004',
                'phone' => '081234567893',
                'address' => 'Jl. Simpang-Parakanmuncang Km 1.2, Cikondang, Gunungmanik, Kec. Tanjungsari Kabupaten Sumedang, Jawa Barat 45363'
            ]
        );

        User::updateOrCreate(
            ['email' => 'guru5@nurani.com'],
            [
                'name' => 'Rizki Pratama',
                'password' => Hash::make('guru123'),
                'role' => 'guru',
                'nip' => 'GRU005',
                'phone' => '081234567894',
                'address' => 'Jl. Simpang-Parakanmuncang Km 1.2, Cikondang, Gunungmanik, Kec. Tanjungsari Kabupaten Sumedang, Jawa Barat 45363'
            ]
        );

        // Create Tenaga Usaha Users
        User::updateOrCreate(
            ['email' => 'tu1@nurani.com'],
            [
                'name' => 'Sari Dewi',
                'password' => Hash::make('tu123'),
                'role' => 'tenaga_usaha',
                'nip' => 'TU001',
                'phone' => '081234567895',
                'address' => 'Jl. Simpang-Parakanmuncang Km 1.2, Cikondang, Gunungmanik, Kec. Tanjungsari Kabupaten Sumedang, Jawa Barat 45363'
            ]
        );

        User::updateOrCreate(
            ['email' => 'tu2@nurani.com'],
            [
                'name' => 'Muhammad Yusuf',
                'password' => Hash::make('tu123'),
                'role' => 'tenaga_usaha',
                'nip' => 'TU002',
                'phone' => '081234567896',
                'address' => 'Jl. Simpang-Parakanmuncang Km 1.2, Cikondang, Gunungmanik, Kec. Tanjungsari Kabupaten Sumedang, Jawa Barat 45363'
            ]
        );

        User::updateOrCreate(
            ['email' => 'tu3@nurani.com'],
            [
                'name' => 'Fatimah Zahra',
                'password' => Hash::make('tu123'),
                'role' => 'tenaga_usaha',
                'nip' => 'TU003',
                'phone' => '081234567897',
                'address' => 'Jl. Simpang-Parakanmuncang Km 1.2, Cikondang, Gunungmanik, Kec. Tanjungsari Kabupaten Sumedang, Jawa Barat 45363'
            ]
        );
    }
}