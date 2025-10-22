<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Guru;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Guru Users with individual emails
        $guruData = [
            [
                'email' => 'guru@mtssnuraiman.sch.id',
                'name' => 'Guru MTs Nurul Aiman',
                'password' => Hash::make('Guru123!'),
                'role' => 'guru',
                'nip' => 'GRU001',
                'phone' => '081234567890',
                'address' => 'Jl. Simpang-Parakanmuncang Km 1.2, Cikondang, Gunungmanik, Kec. Tanjungsari Kabupaten Sumedang, Jawa Barat 45363'
            ],
            [
                'email' => 'nurhadi@mtssnuraiman.sch.id',
                'name' => 'Nurhadi, S.Pd',
                'password' => Hash::make('Nurhadi2024!'),
                'role' => 'guru',
                'nip' => 'GRU002',
                'phone' => '081234567891',
                'address' => 'Jl. Simpang-Parakanmuncang Km 1.2, Cikondang, Gunungmanik, Kec. Tanjungsari Kabupaten Sumedang, Jawa Barat 45363'
            ],
            [
                'email' => 'keysha@mtssnuraiman.sch.id',
                'name' => 'Keysha',
                'password' => Hash::make('Keysha2024!'),
                'role' => 'guru',
                'nip' => 'GRU003',
                'phone' => '081234567892',
                'address' => 'Jl. Simpang-Parakanmuncang Km 1.2, Cikondang, Gunungmanik, Kec. Tanjungsari Kabupaten Sumedang, Jawa Barat 45363'
            ],
            [
                'email' => 'fadli@mtssnuraiman.sch.id',
                'name' => 'Fadli',
                'password' => Hash::make('Fadli2024!'),
                'role' => 'guru',
                'nip' => 'GRU004',
                'phone' => '081234567893',
                'address' => 'Jl. Simpang-Parakanmuncang Km 1.2, Cikondang, Gunungmanik, Kec. Tanjungsari Kabupaten Sumedang, Jawa Barat 45363'
            ],
            [
                'email' => 'siti.mundari@mtssnuraiman.sch.id',
                'name' => 'Siti Mundari, S.Ag',
                'password' => Hash::make('SitiMundari2024!'),
                'role' => 'guru',
                'nip' => 'GRU005',
                'phone' => '081234567894',
                'address' => 'Jl. Simpang-Parakanmuncang Km 1.2, Cikondang, Gunungmanik, Kec. Tanjungsari Kabupaten Sumedang, Jawa Barat 45363'
            ],
            [
                'email' => 'lola.nurlaela@mtssnuraiman.sch.id',
                'name' => 'Lola Nurlaela, S.Pd.I.',
                'password' => Hash::make('LolaNurlaela2024!'),
                'role' => 'guru',
                'nip' => 'GRU006',
                'phone' => '081234567895',
                'address' => 'Jl. Simpang-Parakanmuncang Km 1.2, Cikondang, Gunungmanik, Kec. Tanjungsari Kabupaten Sumedang, Jawa Barat 45363'
            ],
            [
                'email' => 'desy.nurfalah@mtssnuraiman.sch.id',
                'name' => 'Desy Nurfalah',
                'password' => Hash::make('DesyNurfalah2024!'),
                'role' => 'guru',
                'nip' => 'GRU007',
                'phone' => '081234567896',
                'address' => 'Jl. Simpang-Parakanmuncang Km 1.2, Cikondang, Gunungmanik, Kec. Tanjungsari Kabupaten Sumedang, Jawa Barat 45363'
            ],
            [
                'email' => 'm.rizmal.maulana@mtssnuraiman.sch.id',
                'name' => 'M. Rizmal Maulana',
                'password' => Hash::make('RizmalMaulana2024!'),
                'role' => 'guru',
                'nip' => 'GRU008',
                'phone' => '081234567897',
                'address' => 'Jl. Simpang-Parakanmuncang Km 1.2, Cikondang, Gunungmanik, Kec. Tanjungsari Kabupaten Sumedang, Jawa Barat 45363'
            ],
            [
                'email' => 'hamzah.nazmudin@mtssnuraiman.sch.id',
                'name' => 'Hamzah Nazmudin',
                'password' => Hash::make('HamzahNazmudin2024!'),
                'role' => 'guru',
                'nip' => 'GRU009',
                'phone' => '081234567898',
                'address' => 'Jl. Simpang-Parakanmuncang Km 1.2, Cikondang, Gunungmanik, Kec. Tanjungsari Kabupaten Sumedang, Jawa Barat 45363'
            ],
            [
                'email' => 'sopyan@mtssnuraiman.sch.id',
                'name' => 'Sopyan',
                'password' => Hash::make('Sopyan2024!'),
                'role' => 'guru',
                'nip' => 'GRU010',
                'phone' => '081234567899',
                'address' => 'Jl. Simpang-Parakanmuncang Km 1.2, Cikondang, Gunungmanik, Kec. Tanjungsari Kabupaten Sumedang, Jawa Barat 45363'
            ],
            [
                'email' => 'syifa.restu.rahayu@mtssnuraiman.sch.id',
                'name' => 'Syifa Restu Rahayu',
                'password' => Hash::make('SyifaRestu2024!'),
                'role' => 'guru',
                'nip' => 'GRU011',
                'phone' => '081234567900',
                'address' => 'Jl. Simpang-Parakanmuncang Km 1.2, Cikondang, Gunungmanik, Kec. Tanjungsari Kabupaten Sumedang, Jawa Barat 45363'
            ],
            [
                'email' => 'weny@mtssnuraiman.sch.id',
                'name' => 'Weny',
                'password' => Hash::make('Weny2024!'),
                'role' => 'guru',
                'nip' => 'GRU012',
                'phone' => '081234567901',
                'address' => 'Jl. Simpang-Parakanmuncang Km 1.2, Cikondang, Gunungmanik, Kec. Tanjungsari Kabupaten Sumedang, Jawa Barat 45363'
            ],
            [
                'email' => 'tintin.martini@mtssnuraiman.sch.id',
                'name' => 'Tintin Martini',
                'password' => Hash::make('TintinMartini2024!'),
                'role' => 'guru',
                'nip' => 'GRU013',
                'phone' => '081234567902',
                'address' => 'Jl. Simpang-Parakanmuncang Km 1.2, Cikondang, Gunungmanik, Kec. Tanjungsari Kabupaten Sumedang, Jawa Barat 45363'
            ]
        ];

        // Create all guru users
        foreach ($guruData as $guru) {
            $user = User::updateOrCreate(
                ['email' => $guru['email']],
                $guru
            );
            
            // Create guru record for each user
            if ($user->role === 'guru') {
                $mataPelajaran = 'Belum ditentukan';
                
                // Set mata pelajaran berdasarkan email guru
                switch ($guru['email']) {
                    case 'nurhadi@mtssnuraiman.sch.id':
                        $mataPelajaran = 'Matematika';
                        break;
                    case 'keysha@mtssnuraiman.sch.id':
                        $mataPelajaran = 'Bahasa Inggris';
                        break;
                    case 'fadli@mtssnuraiman.sch.id':
                        $mataPelajaran = 'Bahasa Arab';
                        break;
                    case 'siti.mundari@mtssnuraiman.sch.id':
                        $mataPelajaran = 'IPA, Prakarya, Basa Sunda';
                        break;
                    case 'lola.nurlaela@mtssnuraiman.sch.id':
                        $mataPelajaran = 'SKI, Akidah Akhlak';
                        break;
                    case 'desy.nurfalah@mtssnuraiman.sch.id':
                        $mataPelajaran = 'Bahasa Indonesia';
                        break;
                    case 'm.rizmal.maulana@mtssnuraiman.sch.id':
                        $mataPelajaran = 'Fiqih, Al-Qur\'an Hadist';
                        break;
                    case 'hamzah.nazmudin@mtssnuraiman.sch.id':
                        $mataPelajaran = 'Penjaskes, IPS';
                        break;
                    case 'sopyan@mtssnuraiman.sch.id':
                        $mataPelajaran = 'PKN';
                        break;
                    case 'syifa.restu.rahayu@mtssnuraiman.sch.id':
                        $mataPelajaran = 'Seni Budaya';
                        break;
                    case 'weny@mtssnuraiman.sch.id':
                        $mataPelajaran = 'Tahsin';
                        break;
                    case 'tintin.martini@mtssnuraiman.sch.id':
                        $mataPelajaran = 'BTQ, Tahsin';
                        break;
                    default:
                        $mataPelajaran = 'Belum ditentukan';
                        break;
                }
                
                Guru::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'nip' => $guru['nip'],
                        'mata_pelajaran' => $mataPelajaran,
                        'status' => 'aktif'
                    ]
                );
            }
        }

        // Create Kepala Sekolah User
        User::updateOrCreate(
            ['email' => 'kepala.sekolah@mtssnuraiman.sch.id'],
            [
                'name' => 'Kepala Sekolah MTs Nurul Aiman',
                'password' => Hash::make('AdminKS@2024'),
                'role' => 'kepala_sekolah',
                'nip' => 'KS001',
                'phone' => '081234567891',
                'address' => 'Jl. Simpang-Parakanmuncang Km 1.2, Cikondang, Gunungmanik, Kec. Tanjungsari Kabupaten Sumedang, Jawa Barat 45363'
            ]
        );

        // Create Tenaga Usaha User
        User::updateOrCreate(
            ['email' => 'tu@mtssnuraiman.sch.id'],
            [
                'name' => 'Tenaga Usaha MTs Nurul Aiman',
                'password' => Hash::make('AdminTU@2024'),
                'role' => 'tu',
                'nip' => 'TU001',
                'phone' => '081234567892',
                'address' => 'Jl. Simpang-Parakanmuncang Km 1.2, Cikondang, Gunungmanik, Kec. Tanjungsari Kabupaten Sumedang, Jawa Barat 45363'
            ]
        );
    }
}