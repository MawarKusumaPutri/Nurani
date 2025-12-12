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
        // Create Guru Users dengan email, password, dan mata pelajaran yang benar dari LOGIN_CREDENTIALS.md
        $guruData = [
            [
                'email' => 'mundarinurhadi@gmail.com',
                'name' => 'Nurhadi, S.Pd',
                'password' => Hash::make('Nurhadi2024!'),
                'role' => 'guru',
                'nip' => 'GRU001',
                'phone' => '081234567001',
                'address' => 'Jl. Simpang-Parakanmuncang Km 1.2, Cikondang, Gunungmanik, Kec. Tanjungsari Kabupaten Sumedang, Jawa Barat 45363',
                'mata_pelajaran' => 'Matematika'
            ],
            [
                'email' => 'keysa8406@gmail.com',
                'name' => 'Keysa Anjani',
                'password' => Hash::make('Keysha2024!'),
                'role' => 'guru',
                'nip' => 'GRU002',
                'phone' => '081234567002',
                'address' => 'Jl. Simpang-Parakanmuncang Km 1.2, Cikondang, Gunungmanik, Kec. Tanjungsari Kabupaten Sumedang, Jawa Barat 45363',
                'mata_pelajaran' => 'Bahasa Inggris'
            ],
            [
                'email' => 'fadliziyad123@gmail.com',
                'name' => 'Fadli',
                'password' => Hash::make('Fadli2024!'),
                'role' => 'guru',
                'nip' => 'GRU003',
                'phone' => '081234567003',
                'address' => 'Jl. Simpang-Parakanmuncang Km 1.2, Cikondang, Gunungmanik, Kec. Tanjungsari Kabupaten Sumedang, Jawa Barat 45363',
                'mata_pelajaran' => 'Bahasa Arab'
            ],
            [
                'email' => 'sitimundari54@gmail.com',
                'name' => 'Siti Mundari, S.Ag',
                'password' => Hash::make('SitiMundari2024!'),
                'role' => 'guru',
                'nip' => 'GRU004',
                'phone' => '081234567004',
                'address' => 'Jl. Simpang-Parakanmuncang Km 1.2, Cikondang, Gunungmanik, Kec. Tanjungsari Kabupaten Sumedang, Jawa Barat 45363',
                'mata_pelajaran' => 'IPA, Prakarya'
            ],
            [
                'email' => 'lola.nurlaela@mtssnuraiman.sch.id',
                'name' => 'Lola Nurlaela, S.Pd.I.',
                'password' => Hash::make('LolaNurlaela2024!'),
                'role' => 'guru',
                'nip' => 'GRU005',
                'phone' => '081234567005',
                'address' => 'Jl. Simpang-Parakanmuncang Km 1.2, Cikondang, Gunungmanik, Kec. Tanjungsari Kabupaten Sumedang, Jawa Barat 45363',
                'mata_pelajaran' => 'SKI, Akidah Akhlak'
            ],
            [
                'email' => 'desinurfalah24@gmail.com',
                'name' => 'Desi Nurfalah',
                'password' => Hash::make('DesyNurfalah2024!'),
                'role' => 'guru',
                'nip' => 'GRU006',
                'phone' => '081234567006',
                'address' => 'Jl. Simpang-Parakanmuncang Km 1.2, Cikondang, Gunungmanik, Kec. Tanjungsari Kabupaten Sumedang, Jawa Barat 45363',
                'mata_pelajaran' => 'Bahasa Indonesia'
            ],
            [
                'email' => 'rizmalmaulana25@gmail.com',
                'name' => 'M. Rizmal Maulana',
                'password' => Hash::make('RizmalMaulana2024!'),
                'role' => 'guru',
                'nip' => 'GRU007',
                'phone' => '081234567007',
                'address' => 'Jl. Simpang-Parakanmuncang Km 1.2, Cikondang, Gunungmanik, Kec. Tanjungsari Kabupaten Sumedang, Jawa Barat 45363',
                'mata_pelajaran' => 'QH, FIQIH'
            ],
            [
                'email' => 'zahnajmudin10@gmail.com',
                'name' => 'Hamzah Najmudin',
                'password' => Hash::make('HamzahNazmudin2024!'),
                'role' => 'guru',
                'nip' => 'GRU008',
                'phone' => '081234567008',
                'address' => 'Jl. Simpang-Parakanmuncang Km 1.2, Cikondang, Gunungmanik, Kec. Tanjungsari Kabupaten Sumedang, Jawa Barat 45363',
                'mata_pelajaran' => 'PJOK, IPS'
            ],
            [
                'email' => 'sopyanikhsananda@gmail.com',
                'name' => 'Sopyan',
                'password' => Hash::make('Sopyan2024!'),
                'role' => 'guru',
                'nip' => 'GRU009',
                'phone' => '081234567009',
                'address' => 'Jl. Simpang-Parakanmuncang Km 1.2, Cikondang, Gunungmanik, Kec. Tanjungsari Kabupaten Sumedang, Jawa Barat 45363',
                'mata_pelajaran' => 'PKN'
            ],
            [
                'email' => 'syifarestu81@gmail.com',
                'name' => 'Syifa Restu R',
                'password' => Hash::make('SyifaRestu2024!'),
                'role' => 'guru',
                'nip' => 'GRU010',
                'phone' => '081234567010',
                'address' => 'Jl. Simpang-Parakanmuncang Km 1.2, Cikondang, Gunungmanik, Kec. Tanjungsari Kabupaten Sumedang, Jawa Barat 45363',
                'mata_pelajaran' => 'Seni Budaya'
            ],
            [
                'email' => 'wenibustamin27@gmail.com',
                'name' => 'Weni Azmi',
                'password' => Hash::make('Weny2024!'),
                'role' => 'guru',
                'nip' => 'GRU011',
                'phone' => '081234567011',
                'address' => 'Jl. Simpang-Parakanmuncang Km 1.2, Cikondang, Gunungmanik, Kec. Tanjungsari Kabupaten Sumedang, Jawa Barat 45363',
                'mata_pelajaran' => 'Tahsin'
            ],
            [
                'email' => 'tintinmartini184@gmail.com',
                'name' => 'Tintin Martini',
                'password' => Hash::make('TintinMartini2024!'),
                'role' => 'guru',
                'nip' => 'GRU012',
                'phone' => '081234567012',
                'address' => 'Jl. Simpang-Parakanmuncang Km 1.2, Cikondang, Gunungmanik, Kec. Tanjungsari Kabupaten Sumedang, Jawa Barat 45363',
                'mata_pelajaran' => 'BTQ'
            ],
            [
                'email' => 'mawarkusuma694@gmail.com',
                'name' => 'Mawar',
                'password' => Hash::make('Mawar2024!'),
                'role' => 'guru',
                'nip' => 'GRU013',
                'phone' => '081234567013',
                'address' => 'Jl. Simpang-Parakanmuncang Km 1.2, Cikondang, Gunungmanik, Kec. Tanjungsari Kabupaten Sumedang, Jawa Barat 45363',
                'mata_pelajaran' => 'Belum ditentukan'
            ]
        ];

        // Create all guru users
        foreach ($guruData as $guru) {
            $mataPelajaran = $guru['mata_pelajaran'] ?? 'Belum ditentukan';
            
            $user = User::updateOrCreate(
                ['email' => $guru['email']],
                collect($guru)->except('mata_pelajaran')->toArray()
            );
            
            // Create guru record for each user
            if ($user->role === 'guru') {
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