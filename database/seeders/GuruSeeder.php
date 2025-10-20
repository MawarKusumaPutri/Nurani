<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Guru;
use Illuminate\Support\Facades\Hash;

class GuruSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data guru berdasarkan tabel di gambar
        $guruData = [
            [
                'name' => 'Nurhadi, S.Pd',
                'email' => 'nurhadi@nurani.com',
                'password' => Hash::make('password123'),
                'role' => 'guru',
                'nip' => 'G001',
                'phone' => '081234567001',
                'address' => 'Sumedang, Jawa Barat',
                'mata_pelajaran' => 'Matematika'
            ],
            [
                'name' => 'Keysha',
                'email' => 'keysha@nurani.com',
                'password' => Hash::make('password123'),
                'role' => 'guru',
                'nip' => 'G002',
                'phone' => '081234567002',
                'address' => 'Sumedang, Jawa Barat',
                'mata_pelajaran' => 'Bahasa Inggris'
            ],
            [
                'name' => 'Fadli',
                'email' => 'fadli@nurani.com',
                'password' => Hash::make('password123'),
                'role' => 'guru',
                'nip' => 'G003',
                'phone' => '081234567003',
                'address' => 'Sumedang, Jawa Barat',
                'mata_pelajaran' => 'Bahasa Arab'
            ],
            [
                'name' => 'Siti Mundari, S.Ag',
                'email' => 'siti.mundari@nurani.com',
                'password' => Hash::make('password123'),
                'role' => 'guru',
                'nip' => 'G004',
                'phone' => '081234567004',
                'address' => 'Sumedang, Jawa Barat',
                'mata_pelajaran' => 'IPA, Prakarya, Basa Sunda'
            ],
            [
                'name' => 'Lola Nurlaela, S.Pd.I.',
                'email' => 'lola.nurlaela@nurani.com',
                'password' => Hash::make('password123'),
                'role' => 'guru',
                'nip' => 'G005',
                'phone' => '081234567005',
                'address' => 'Sumedang, Jawa Barat',
                'mata_pelajaran' => 'SKI, Akidah Akhlak'
            ],
            [
                'name' => 'Desy Nurfalah',
                'email' => 'desy.nurfalah@nurani.com',
                'password' => Hash::make('password123'),
                'role' => 'guru',
                'nip' => 'G006',
                'phone' => '081234567006',
                'address' => 'Sumedang, Jawa Barat',
                'mata_pelajaran' => 'Bahasa Indonesia'
            ],
            [
                'name' => 'M. Rizmal Maulana',
                'email' => 'rizmal.maulana@nurani.com',
                'password' => Hash::make('password123'),
                'role' => 'guru',
                'nip' => 'G007',
                'phone' => '081234567007',
                'address' => 'Sumedang, Jawa Barat',
                'mata_pelajaran' => 'Fiqih, Al-Qur\'an Hadist'
            ],
            [
                'name' => 'Hamzah Nazmudin',
                'email' => 'hamzah.nazmudin@nurani.com',
                'password' => Hash::make('password123'),
                'role' => 'guru',
                'nip' => 'G008',
                'phone' => '081234567008',
                'address' => 'Sumedang, Jawa Barat',
                'mata_pelajaran' => 'Penjaskes, IPS'
            ],
            [
                'name' => 'Sopyan',
                'email' => 'sopyan@nurani.com',
                'password' => Hash::make('password123'),
                'role' => 'guru',
                'nip' => 'G009',
                'phone' => '081234567009',
                'address' => 'Sumedang, Jawa Barat',
                'mata_pelajaran' => 'PKN'
            ],
            [
                'name' => 'Syifa Restu Rahayu',
                'email' => 'syifa.restu@nurani.com',
                'password' => Hash::make('password123'),
                'role' => 'guru',
                'nip' => 'G010',
                'phone' => '081234567010',
                'address' => 'Sumedang, Jawa Barat',
                'mata_pelajaran' => 'Seni Budaya'
            ],
            [
                'name' => 'Weny',
                'email' => 'weny@nurani.com',
                'password' => Hash::make('password123'),
                'role' => 'guru',
                'nip' => 'G011',
                'phone' => '081234567011',
                'address' => 'Sumedang, Jawa Barat',
                'mata_pelajaran' => 'Tahsin'
            ],
            [
                'name' => 'Tintin Martini',
                'email' => 'tintin.martini@nurani.com',
                'password' => Hash::make('password123'),
                'role' => 'guru',
                'nip' => 'G012',
                'phone' => '081234567012',
                'address' => 'Sumedang, Jawa Barat',
                'mata_pelajaran' => 'Belum ditentukan'
            ]
        ];

        // Data TU (Tenaga Usaha)
        $tuData = [
            [
                'name' => 'Siti Nurhaliza',
                'email' => 'siti.tu@nurani.com',
                'password' => Hash::make('password123'),
                'role' => 'tu',
                'nip' => 'TU001',
                'phone' => '081234567100',
                'address' => 'Sumedang, Jawa Barat'
            ],
            [
                'name' => 'Ahmad Fauzi',
                'email' => 'ahmad.tu@nurani.com',
                'password' => Hash::make('password123'),
                'role' => 'tu',
                'nip' => 'TU002',
                'phone' => '081234567101',
                'address' => 'Sumedang, Jawa Barat'
            ]
        ];

        // Data Kepala Sekolah
        $kepalaSekolahData = [
            [
                'name' => 'Dr. H. Abdul Rahman, M.Pd',
                'email' => 'kepala.sekolah@nurani.com',
                'password' => Hash::make('password123'),
                'role' => 'kepala_sekolah',
                'nip' => 'KS001',
                'phone' => '081234567200',
                'address' => 'Sumedang, Jawa Barat'
            ]
        ];

        // Insert data guru
        foreach ($guruData as $guru) {
            $user = User::updateOrCreate(
                ['email' => $guru['email']],
                collect($guru)->except('mata_pelajaran')->toArray()
            );
            
            // Insert data ke tabel gurus
            Guru::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'nip' => $guru['nip'],
                    'mata_pelajaran' => $guru['mata_pelajaran'],
                    'status' => 'aktif'
                ]
            );
        }

        // Insert data TU
        foreach ($tuData as $tu) {
            User::updateOrCreate(
                ['email' => $tu['email']],
                $tu
            );
        }

        // Insert data Kepala Sekolah
        foreach ($kepalaSekolahData as $ks) {
            User::updateOrCreate(
                ['email' => $ks['email']],
                $ks
            );
        }

        $this->command->info('Data guru, TU, dan Kepala Sekolah berhasil dibuat!');
    }
}
