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
                'email' => 'mundarinurhadi@gmail.com',
                'name' => 'Nurhadi, S.Pd',
                'password' => Hash::make('Nurhadi2024!'),
                'role' => 'guru',
                'nip' => 'GRU002',
                'phone' => '081234567891',
                'address' => 'Jl. Simpang-Parakanmuncang Km 1.2, Cikondang, Gunungmanik, Kec. Tanjungsari Kabupaten Sumedang, Jawa Barat 45363'
            ],
            [
                'email' => 'keysa8406@gmail.com',
                'name' => 'Keysa Anjani',
                'password' => Hash::make('Keysha2024!'),
                'role' => 'guru',
                'nip' => 'GRU003',
                'phone' => '081234567892',
                'address' => 'Jl. Simpang-Parakanmuncang Km 1.2, Cikondang, Gunungmanik, Kec. Tanjungsari Kabupaten Sumedang, Jawa Barat 45363'
            ],
            [
                'email' => 'fadliziyad123@gmail.com',
                'name' => 'Fadli',
                'password' => Hash::make('Fadli2024!'),
                'role' => 'guru',
                'nip' => 'GRU004',
                'phone' => '081234567893',
                'address' => 'Jl. Simpang-Parakanmuncang Km 1.2, Cikondang, Gunungmanik, Kec. Tanjungsari Kabupaten Sumedang, Jawa Barat 45363'
            ],
            [
                'email' => 'sitimundari54@gmail.com',
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
                'email' => 'desinurfalah24@gmail.com',
                'name' => 'Desi Nurfalah',
                'password' => Hash::make('DesyNurfalah2024!'),
                'role' => 'guru',
                'nip' => 'GRU007',
                'phone' => '081234567896',
                'address' => 'Jl. Simpang-Parakanmuncang Km 1.2, Cikondang, Gunungmanik, Kec. Tanjungsari Kabupaten Sumedang, Jawa Barat 45363'
            ],
            [
                'email' => 'rizmalmaulana25@gmail.com',
                'name' => 'M. Rizmal Maulana',
                'password' => Hash::make('RizmalMaulana2024!'),
                'role' => 'guru',
                'nip' => 'GRU008',
                'phone' => '081234567897',
                'address' => 'Jl. Simpang-Parakanmuncang Km 1.2, Cikondang, Gunungmanik, Kec. Tanjungsari Kabupaten Sumedang, Jawa Barat 45363'
            ],
            [
                'email' => 'zahnajmudin10@gmail.com',
                'name' => 'Hamzah Najmudin',
                'password' => Hash::make('HamzahNazmudin2024!'),
                'role' => 'guru',
                'nip' => 'GRU009',
                'phone' => '081234567898',
                'address' => 'Jl. Simpang-Parakanmuncang Km 1.2, Cikondang, Gunungmanik, Kec. Tanjungsari Kabupaten Sumedang, Jawa Barat 45363'
            ],
            [
                'email' => 'sopyanikhsananda@gmail.com',
                'name' => 'Sopyan',
                'password' => Hash::make('Sopyan2024!'),
                'role' => 'guru',
                'nip' => 'GRU010',
                'phone' => '081234567899',
                'address' => 'Jl. Simpang-Parakanmuncang Km 1.2, Cikondang, Gunungmanik, Kec. Tanjungsari Kabupaten Sumedang, Jawa Barat 45363'
            ],
            [
                'email' => 'syifarestu81@gmail.com',
                'name' => 'Syifa Restu R',
                'password' => Hash::make('SyifaRestu2024!'),
                'role' => 'guru',
                'nip' => 'GRU011',
                'phone' => '081234567900',
                'address' => 'Jl. Simpang-Parakanmuncang Km 1.2, Cikondang, Gunungmanik, Kec. Tanjungsari Kabupaten Sumedang, Jawa Barat 45363'
            ],
            [
                'email' => 'wenibustamin27@gmail.com',
                'name' => 'Weni Azmi',
                'password' => Hash::make('Weny2024!'),
                'role' => 'guru',
                'nip' => 'GRU012',
                'phone' => '081234567901',
                'address' => 'Jl. Simpang-Parakanmuncang Km 1.2, Cikondang, Gunungmanik, Kec. Tanjungsari Kabupaten Sumedang, Jawa Barat 45363'
            ],
            [
                'email' => 'tintinmartini184@gmail.com',
                'name' => 'Tintin Martini',
                'password' => Hash::make('TintinMartini2024!'),
                'role' => 'guru',
                'nip' => 'GRU013',
                'phone' => '081234567902',
                'address' => 'Jl. Simpang-Parakanmuncang Km 1.2, Cikondang, Gunungmanik, Kec. Tanjungsari Kabupaten Sumedang, Jawa Barat 45363'
            ],
            [
                'email' => 'mawarkusuma694@gmail.com',
                'name' => 'Mawar',
                'password' => Hash::make('Mawar2024!'),
                'role' => 'guru',
                'nip' => 'GRU014',
                'phone' => '081234567903',
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
                    case 'mundarinurhadi@gmail.com':
                        $mataPelajaran = 'Matematika';
                        break;
                    case 'keysa8406@gmail.com':
                        $mataPelajaran = 'Bahasa Inggris';
                        break;
                    case 'fadliziyad123@gmail.com':
                        $mataPelajaran = 'Bahasa Arab';
                        break;
                    case 'sitimundari54@gmail.com':
                        $mataPelajaran = 'IPA, Prakarya';
                        break;
                    case 'lola.nurlaela@mtssnuraiman.sch.id':
                        $mataPelajaran = 'SKI, Akidah Akhlak';
                        break;
                    case 'desinurfalah24@gmail.com':
                        $mataPelajaran = 'Bahasa Indonesia';
                        break;
                    case 'rizmalmaulana25@gmail.com':
                        $mataPelajaran = 'QH, FIQIH';
                        break;
                    case 'zahnajmudin10@gmail.com':
                        $mataPelajaran = 'PJOK, IPS';
                        break;
                    case 'sopyanikhsananda@gmail.com':
                        $mataPelajaran = 'PKN';
                        break;
                    case 'syifarestu81@gmail.com':
                        $mataPelajaran = 'Seni Budaya';
                        break;
                    case 'wenibustamin27@gmail.com':
                        $mataPelajaran = 'Tahsin';
                        break;
                    case 'tintinmartini184@gmail.com':
                        $mataPelajaran = 'BTQ';
                        break;
                    case 'mawarkusuma694@gmail.com':
                        $mataPelajaran = 'Belum ditentukan';
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
            ['email' => 'mamansuparmanaks07@gmail.com'],
            [
                'name' => 'Maman Suparman, A.KS - Kepala Madrasah',
                'password' => Hash::make('AdminKS@2024'),
                'role' => 'kepala_sekolah',
                'nip' => '9661750652200022',
                'phone' => '081234567891',
                'address' => 'Jl. Simpang-Parakanmuncang Km 1.2, Cikondang, Gunungmanik, Kec. Tanjungsari Kabupaten Sumedang, Jawa Barat 45363'
            ]
        );

        // Create Tenaga Usaha User
        User::updateOrCreate(
            ['email' => 'internal.nurulaiman@gmail.com'],
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