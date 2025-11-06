<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Siswa;

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $siswaData = [
            // Kelas 7
            [
                'nis' => '2024001',
                'nama' => 'Ahmad Fauzi',
                'kelas' => '7',
                'jenis_kelamin' => 'Laki-laki',
                'tanggal_lahir' => '2010-03-15',
                'status' => 'aktif',
            ],
            [
                'nis' => '2024002',
                'nama' => 'Siti Nurhaliza',
                'kelas' => '7',
                'jenis_kelamin' => 'Perempuan',
                'tanggal_lahir' => '2010-07-22',
                'status' => 'aktif',
            ],
            [
                'nis' => '2024004',
                'nama' => 'Rina Wulandari',
                'kelas' => '7',
                'jenis_kelamin' => 'Perempuan',
                'tanggal_lahir' => '2010-05-10',
                'status' => 'aktif',
            ],
            // Kelas 8
            [
                'nis' => '2024003',
                'nama' => 'Budi Santoso',
                'kelas' => '8',
                'jenis_kelamin' => 'Laki-laki',
                'tanggal_lahir' => '2009-12-10',
                'status' => 'tidak_aktif',
            ],
            [
                'nis' => '2024005',
                'nama' => 'Joko Susilo',
                'kelas' => '8',
                'jenis_kelamin' => 'Laki-laki',
                'tanggal_lahir' => '2009-08-20',
                'status' => 'aktif',
            ],
            // Kelas 9
            [
                'nis' => '2024006',
                'nama' => 'Dewi Kartika',
                'kelas' => '9',
                'jenis_kelamin' => 'Perempuan',
                'tanggal_lahir' => '2008-11-25',
                'status' => 'aktif',
            ],
            [
                'nis' => '2024007',
                'nama' => 'Ahmad Fauzi',
                'kelas' => '9',
                'jenis_kelamin' => 'Laki-laki',
                'tanggal_lahir' => '2008-09-15',
                'status' => 'aktif',
            ],
            [
                'nis' => '2024008',
                'nama' => 'Sari Indah',
                'kelas' => '9',
                'jenis_kelamin' => 'Perempuan',
                'tanggal_lahir' => '2008-06-30',
                'status' => 'aktif',
            ],
        ];

        foreach ($siswaData as $data) {
            Siswa::create($data);
        }
    }
}
