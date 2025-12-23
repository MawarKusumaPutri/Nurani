<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jadwal;
use App\Models\Guru;
use Illuminate\Support\Facades\DB;

class JadwalLengkapSeeder extends Seeder
{
    /**
     * Seed jadwal lengkap berdasarkan gambar jadwal
     * Setiap guru akan punya jadwal sesuai mata pelajaran yang mereka ajar
     */
    public function run()
    {
        echo "=== Import Jadwal Lengkap untuk Semua Guru ===\n\n";
        
        // Mapping nama guru dari gambar ke database
        $guruMapping = [
            'Maman Suparman' => 'Maman Suparman, A.K.S',
            'Nurhadi' => 'Nurhadi, S.Pd',
            'Lola Nurlaelis' => 'Lola Nurlaelis, S.Pd.I',
            'Siti Mundari' => 'Siti Mundari, S.Ag',
            'Fadli' => 'Fadli',
            'Tintin Martini' => 'Tintin Martini',
        ];
        
        // Mapping mata pelajaran
        $mapelMap = [
            'Matematika' => 'matematika',
            'Bahasa Indonesia' => 'bahasa_indonesia',
            'Bahasa Inggris' => 'bahasa_inggris',
            'IPA' => 'ipa',
            'IPS' => 'ips',
            'Pendidikan Agama' => 'pendidikan_agama',
            'PKN' => 'pendidikan_kewarganegaraan',
            'Pendidikan Jasmani' => 'pendidikan_jasmani',
            'PJOK' => 'pendidikan_jasmani',
            'Seni Budaya' => 'seni_budaya',
            'Bahasa Sunda' => 'lainnya',
            'Bahasa Arab' => 'lainnya',
            'Tahsin' => 'lainnya',
            'Prakarya' => 'lainnya',
            'Informatika' => 'teknologi_informasi',
            'Baca Tulis Al Quran' => 'lainnya',
            'BTQ' => 'lainnya',
            'Akidah Akhlak' => 'lainnya',
            'Ilmu Pengetahuan Alam' => 'ipa',
            'Ilmu Pengetahuan Sosial' => 'ips',
        ];
        
        // Data jadwal lengkap dari gambar
        // Format: [Mata Pelajaran, Nama Guru, Kelas, Hari, Jam Mulai, Jam Selesai, Ruang]
        $jadwalData = [
            // SENIN - Kelas 7
            ['IPA', 'Nurhadi', '7', 'senin', '07:00:00', '07:40:00', 'Ruang 7'],
            ['IPS', 'Nurhadi', '7', 'senin', '07:40:00', '08:20:00', 'Ruang 7'],
            ['Bahasa Sunda', 'Lola Nurlaelis', '7', 'senin', '08:20:00', '09:00:00', 'Ruang 7'],
            ['Bahasa Sunda', 'Nurhadi', '7', 'senin', '09:00:00', '09:40:00', 'Ruang 7'],
            ['Matematika', 'Nurhadi', '7', 'senin', '10:00:00', '10:40:00', 'Ruang 7'],
            ['Seni Budaya', 'Nurhadi', '7', 'senin', '10:40:00', '11:20:00', 'Ruang 7'],
            ['Matematika', 'Nurhadi', '7', 'senin', '11:20:00', '12:00:00', 'Ruang 7'],
            ['Bahasa Sunda', 'Lola Nurlaelis', '7', 'senin', '14:00:00', '14:40:00', 'Ruang 7'],
            
            // SENIN - Kelas 8
            ['Bahasa Indonesia', 'Maman Suparman', '8', 'senin', '07:00:00', '07:40:00', 'Ruang 8'],
            ['IPA', 'Nurhadi', '8', 'senin', '07:40:00', '08:20:00', 'Ruang 8'],
            ['IPA', 'Nurhadi', '8', 'senin', '08:20:00', '09:00:00', 'Ruang 8'],
            ['Bahasa Sunda', 'Lola Nurlaelis', '8', 'senin', '09:00:00', '09:40:00', 'Ruang 8'],
            ['Matematika', 'Nurhadi', '8', 'senin', '10:00:00', '10:40:00', 'Ruang 8'],
            ['Matematika', 'Nurhadi', '8', 'senin', '10:40:00', '11:20:00', 'Ruang 8'],
            ['Matematika', 'Nurhadi', '8', 'senin', '11:20:00', '12:00:00', 'Ruang 8'],
            ['Bahasa Indonesia', 'Maman Suparman', '8', 'senin', '14:00:00', '14:40:00', 'Ruang 8'],
            
            // SENIN - Kelas 9
            ['Bahasa Indonesia', 'Maman Suparman', '9', 'senin', '07:00:00', '07:40:00', 'Ruang 9'],
            ['Matematika', 'Nurhadi', '9', 'senin', '07:40:00', '08:20:00', 'Ruang 9'],
            ['Matematika', 'Nurhadi', '9', 'senin', '08:20:00', '09:00:00', 'Ruang 9'],
            ['Matematika', 'Nurhadi', '9', 'senin', '09:00:00', '09:40:00', 'Ruang 9'],
            ['Matematika', 'Nurhadi', '9', 'senin', '10:00:00', '10:40:00', 'Ruang 9'],
            ['Seni Budaya', 'Nurhadi', '9', 'senin', '10:40:00', '11:20:00', 'Ruang 9'],
            ['Bahasa Arab', 'Nurhadi', '9', 'senin', '11:20:00', '12:00:00', 'Ruang 9'],
            ['Bahasa Sunda', 'Lola Nurlaelis', '9', 'senin', '14:00:00', '14:40:00', 'Ruang 9'],
            
            // SELASA - Kelas 7
            ['Bahasa Indonesia', 'Maman Suparman', '7', 'selasa', '07:00:00', '07:40:00', 'Ruang 7'],
            ['Bahasa Inggris', 'Nurhadi', '7', 'selasa', '07:40:00', '08:20:00', 'Ruang 7'],
            ['Bahasa Inggris', 'Nurhadi', '7', 'selasa', '08:20:00', '09:00:00', 'Ruang 7'],
            ['IPA', 'Nurhadi', '7', 'selasa', '09:00:00', '09:40:00', 'Ruang 7'],
            ['IPA', 'Nurhadi', '7', 'selasa', '10:00:00', '10:40:00', 'Ruang 7'],
            ['IPS', 'Nurhadi', '7', 'selasa', '10:40:00', '11:20:00', 'Ruang 7'],
            ['IPS', 'Nurhadi', '7', 'selasa', '11:20:00', '12:00:00', 'Ruang 7'],
            ['Bahasa Inggris', 'Nurhadi', '7', 'selasa', '14:00:00', '14:40:00', 'Ruang 7'],
            
            // SELASA - Kelas 8
            ['Bahasa Inggris', 'Nurhadi', '8', 'selasa', '07:00:00', '07:40:00', 'Ruang 8'],
            ['IPA', 'Nurhadi', '8', 'selasa', '07:40:00', '08:20:00', 'Ruang 8'],
            ['IPA', 'Nurhadi', '8', 'selasa', '08:20:00', '09:00:00', 'Ruang 8'],
            ['IPS', 'Nurhadi', '8', 'selasa', '09:00:00', '09:40:00', 'Ruang 8'],
            ['Matematika', 'Nurhadi', '8', 'selasa', '10:00:00', '10:40:00', 'Ruang 8'],
            ['Bahasa Inggris', 'Nurhadi', '8', 'selasa', '10:40:00', '11:20:00', 'Ruang 8'],
            ['Bahasa Inggris', 'Nurhadi', '8', 'selasa', '11:20:00', '12:00:00', 'Ruang 8'],
            ['Tahsin', 'Siti Mundari', '8', 'selasa', '14:00:00', '14:40:00', 'Ruang 8'],
            
            // SELASA - Kelas 9
            ['Bahasa Inggris', 'Nurhadi', '9', 'selasa', '07:00:00', '07:40:00', 'Ruang 9'],
            ['Pendidikan Agama', 'Siti Mundari', '9', 'selasa', '07:40:00', '08:20:00', 'Ruang 9'],
            ['Pendidikan Agama', 'Siti Mundari', '9', 'selasa', '08:20:00', '09:00:00', 'Ruang 9'],
            ['Bahasa Inggris', 'Nurhadi', '9', 'selasa', '09:00:00', '09:40:00', 'Ruang 9'],
            ['Bahasa Inggris', 'Nurhadi', '9', 'selasa', '10:00:00', '10:40:00', 'Ruang 9'],
            ['Bahasa Arab', 'Nurhadi', '9', 'selasa', '10:40:00', '11:20:00', 'Ruang 9'],
            ['Bahasa Arab', 'Nurhadi', '9', 'selasa', '11:20:00', '12:00:00', 'Ruang 9'],
            ['Bahasa Arab', 'Nurhadi', '9', 'selasa', '14:00:00', '14:40:00', 'Ruang 9'],
            
            // RABU - Kelas 7
            ['Bahasa Indonesia', 'Maman Suparman', '7', 'rabu', '07:00:00', '07:40:00', 'Ruang 7'],
            ['Bahasa Indonesia', 'Maman Suparman', '7', 'rabu', '07:40:00', '08:20:00', 'Ruang 7'],
            ['Bahasa Indonesia', 'Maman Suparman', '7', 'rabu', '08:20:00', '09:00:00', 'Ruang 7'],
            ['Bahasa Arab', 'Nurhadi', '7', 'rabu', '09:00:00', '09:40:00', 'Ruang 7'],
            ['Bahasa Arab', 'Nurhadi', '7', 'rabu', '10:00:00', '10:40:00', 'Ruang 7'],
            ['Matematika', 'Nurhadi', '7', 'rabu', '10:40:00', '11:20:00', 'Ruang 7'],
            ['Matematika', 'Nurhadi', '7', 'rabu', '11:20:00', '12:00:00', 'Ruang 7'],
            ['Matematika', 'Nurhadi', '7', 'rabu', '14:00:00', '14:40:00', 'Ruang 7'],
            
            // RABU - Kelas 8
            ['Bahasa Indonesia', 'Maman Suparman', '8', 'rabu', '07:00:00', '07:40:00', 'Ruang 8'],
            ['Bahasa Indonesia', 'Maman Suparman', '8', 'rabu', '07:40:00', '08:20:00', 'Ruang 8'],
            ['Bahasa Indonesia', 'Maman Suparman', '8', 'rabu', '08:20:00', '09:00:00', 'Ruang 8'],
            ['Matematika', 'Nurhadi', '8', 'rabu', '09:00:00', '09:40:00', 'Ruang 8'],
            ['IPA', 'Nurhadi', '8', 'rabu', '10:00:00', '10:40:00', 'Ruang 8'],
            ['IPA', 'Nurhadi', '8', 'rabu', '10:40:00', '11:20:00', 'Ruang 8'],
            ['IPA', 'Nurhadi', '8', 'rabu', '11:20:00', '12:00:00', 'Ruang 8'],
            ['Pendidikan Agama', 'Siti Mundari', '8', 'rabu', '14:00:00', '14:40:00', 'Ruang 8'],
            
            // RABU - Kelas 9
            ['Bahasa Indonesia', 'Maman Suparman', '9', 'rabu', '07:00:00', '07:40:00', 'Ruang 9'],
            ['PKN', 'Nurhadi', '9', 'rabu', '07:40:00', '08:20:00', 'Ruang 9'],
            ['PKN', 'Nurhadi', '9', 'rabu', '08:20:00', '09:00:00', 'Ruang 9'],
            ['Matematika', 'Nurhadi', '9', 'rabu', '09:00:00', '09:40:00', 'Ruang 9'],
            ['Matematika', 'Nurhadi', '9', 'rabu', '10:00:00', '10:40:00', 'Ruang 9'],
            ['Bahasa Sunda', 'Lola Nurlaelis', '9', 'rabu', '10:40:00', '11:20:00', 'Ruang 9'],
            ['PKN', 'Nurhadi', '9', 'rabu', '11:20:00', '12:00:00', 'Ruang 9'],
            ['Matematika', 'Nurhadi', '9', 'rabu', '14:00:00', '14:40:00', 'Ruang 9'],
            
            // KAMIS - Kelas 7
            ['Pendidikan Agama', 'Siti Mundari', '7', 'kamis', '07:00:00', '07:40:00', 'Ruang 7'],
            ['Pendidikan Agama', 'Siti Mundari', '7', 'kamis', '07:40:00', '08:20:00', 'Ruang 7'],
            ['Matematika', 'Nurhadi', '7', 'kamis', '08:20:00', '09:00:00', 'Ruang 7'],
            ['Matematika', 'Nurhadi', '7', 'kamis', '09:00:00', '09:40:00', 'Ruang 7'],
            ['Pendidikan Jasmani', 'Fadli', '7', 'kamis', '10:00:00', '10:40:00', 'Lapangan'],
            ['Pendidikan Jasmani', 'Fadli', '7', 'kamis', '10:40:00', '11:20:00', 'Lapangan'],
            ['Pendidikan Jasmani', 'Fadli', '7', 'kamis', '11:20:00', '12:00:00', 'Lapangan'],
            ['Pendidikan Agama', 'Siti Mundari', '7', 'kamis', '14:00:00', '14:40:00', 'Ruang 7'],
            
            // KAMIS - Kelas 8
            ['Pendidikan Agama', 'Siti Mundari', '8', 'kamis', '07:00:00', '07:40:00', 'Ruang 8'],
            ['Bahasa Indonesia', 'Maman Suparman', '8', 'kamis', '07:40:00', '08:20:00', 'Ruang 8'],
            ['Pendidikan Agama', 'Siti Mundari', '8', 'kamis', '08:20:00', '09:00:00', 'Ruang 8'],
            ['Matematika', 'Nurhadi', '8', 'kamis', '09:00:00', '09:40:00', 'Ruang 8'],
            ['Pendidikan Jasmani', 'Fadli', '8', 'kamis', '10:00:00', '10:40:00', 'Lapangan'],
            ['Pendidikan Jasmani', 'Fadli', '8', 'kamis', '10:40:00', '11:20:00', 'Lapangan'],
            ['Pendidikan Jasmani', 'Fadli', '8', 'kamis', '11:20:00', '12:00:00', 'Lapangan'],
            ['Tahsin', 'Siti Mundari', '8', 'kamis', '14:00:00', '14:40:00', 'Ruang 8'],
            
            // KAMIS - Kelas 9
            ['Bahasa Indonesia', 'Maman Suparman', '9', 'kamis', '07:00:00', '07:40:00', 'Ruang 9'],
            ['Bahasa Indonesia', 'Maman Suparman', '9', 'kamis', '07:40:00', '08:20:00', 'Ruang 9'],
            ['Bahasa Indonesia', 'Maman Suparman', '9', 'kamis', '08:20:00', '09:00:00', 'Ruang 9'],
            ['Bahasa Indonesia', 'Maman Suparman', '9', 'kamis', '09:00:00', '09:40:00', 'Ruang 9'],
            ['Pendidikan Jasmani', 'Fadli', '9', 'kamis', '10:00:00', '10:40:00', 'Lapangan'],
            ['IPS', 'Nurhadi', '9', 'kamis', '10:40:00', '11:20:00', 'Ruang 9'],
            ['IPS', 'Nurhadi', '9', 'kamis', '11:20:00', '12:00:00', 'Ruang 9'],
            ['BTQ', 'Siti Mundari', '9', 'kamis', '14:00:00', '14:40:00', 'Ruang 9'],
            
            // JUMAT - Kelas 7
            ['PKN', 'Nurhadi', '7', 'jumat', '07:00:00', '07:40:00', 'Ruang 7'],
            ['Pendidikan Agama', 'Siti Mundari', '7', 'jumat', '07:40:00', '08:20:00', 'Ruang 7'],
            ['Bahasa Sunda', 'Lola Nurlaelis', '7', 'jumat', '08:20:00', '09:00:00', 'Ruang 7'],
            ['PKN', 'Nurhadi', '7', 'jumat', '09:00:00', '09:40:00', 'Ruang 7'],
            ['Bahasa Sunda', 'Lola Nurlaelis', '7', 'jumat', '10:00:00', '10:40:00', 'Ruang 7'],
            ['Bahasa Sunda', 'Lola Nurlaelis', '7', 'jumat', '10:40:00', '11:20:00', 'Ruang 7'],
            ['PKN', 'Nurhadi', '7', 'jumat', '11:20:00', '12:00:00', 'Ruang 7'],
            
            // JUMAT - Kelas 8
            ['PKN', 'Nurhadi', '8', 'jumat', '07:00:00', '07:40:00', 'Ruang 8'],
            ['Pendidikan Agama', 'Siti Mundari', '8', 'jumat', '07:40:00', '08:20:00', 'Ruang 8'],
            ['Pendidikan Agama', 'Siti Mundari', '8', 'jumat', '08:20:00', '09:00:00', 'Ruang 8'],
            ['Bahasa Sunda', 'Lola Nurlaelis', '8', 'jumat', '09:00:00', '09:40:00', 'Ruang 8'],
            ['Bahasa Sunda', 'Lola Nurlaelis', '8', 'jumat', '10:00:00', '10:40:00', 'Ruang 8'],
            ['Bahasa Sunda', 'Lola Nurlaelis', '8', 'jumat', '10:40:00', '11:20:00', 'Ruang 8'],
            ['Bahasa Sunda', 'Lola Nurlaelis', '8', 'jumat', '11:20:00', '12:00:00', 'Ruang 8'],
            
            // JUMAT - Kelas 9
            ['PKN', 'Nurhadi', '9', 'jumat', '07:00:00', '07:40:00', 'Ruang 9'],
            ['Pendidikan Agama', 'Siti Mundari', '9', 'jumat', '07:40:00', '08:20:00', 'Ruang 9'],
            ['Pendidikan Agama', 'Siti Mundari', '9', 'jumat', '08:20:00', '09:00:00', 'Ruang 9'],
            ['IPA', 'Nurhadi', '9', 'jumat', '09:00:00', '09:40:00', 'Ruang 9'],
            ['IPA', 'Nurhadi', '9', 'jumat', '10:00:00', '10:40:00', 'Ruang 9'],
            ['Matematika', 'Nurhadi', '9', 'jumat', '10:40:00', '11:20:00', 'Ruang 9'],
            ['Matematika', 'Nurhadi', '9', 'jumat', '11:20:00', '12:00:00', 'Ruang 9'],
            
            // SABTU - Kelas 7
            ['Akidah Akhlak', 'Siti Mundari', '7', 'sabtu', '07:00:00', '07:40:00', 'Ruang 7'],
            ['Ilmu Pengetahuan Alam', 'Nurhadi', '7', 'sabtu', '10:00:00', '10:40:00', 'Ruang 7'],
            ['Ilmu Pengetahuan Sosial', 'Nurhadi', '7', 'sabtu', '10:40:00', '11:20:00', 'Ruang 7'],
            ['Matematika', 'Nurhadi', '7', 'sabtu', '11:20:00', '12:00:00', 'Ruang 7'],
            ['Seni Budaya', 'Nurhadi', '7', 'sabtu', '14:00:00', '14:40:00', 'Ruang 7'],
            ['Bahasa Arab', 'Nurhadi', '7', 'sabtu', '14:40:00', '15:20:00', 'Ruang 7'],
            
            // SABTU - Kelas 8
            ['Bahasa Inggris', 'Nurhadi', '8', 'sabtu', '12:00:00', '12:40:00', 'Ruang 8'],
            ['Bahasa Indonesia', 'Maman Suparman', '8', 'sabtu', '14:00:00', '14:40:00', 'Ruang 8'],
            ['Prakarya', 'Nurhadi', '8', 'sabtu', '14:40:00', '15:20:00', 'Ruang 8'],
            
            // SABTU - Kelas 9
            ['Bahasa Sunda', 'Lola Nurlaelis', '9', 'sabtu', '14:00:00', '14:40:00', 'Ruang 9'],
            ['Informatika', 'Tintin Martini', '9', 'sabtu', '14:40:00', '15:20:00', 'Ruang 9'],
        ];
        
        $imported = 0;
        $skipped = 0;
        $errors = [];
        
        foreach ($jadwalData as $data) {
            list($mataPelajaran, $namaGuruShort, $kelas, $hari, $jamMulai, $jamSelesai, $ruang) = $data;
            
            try {
                // Find guru dengan mapping nama
                $namaGuruFull = $guruMapping[$namaGuruShort] ?? $namaGuruShort;
                
                $guru = Guru::whereHas('user', function($query) use ($namaGuruFull, $namaGuruShort) {
                    $query->where('name', 'LIKE', '%' . $namaGuruFull . '%')
                          ->orWhere('name', 'LIKE', '%' . $namaGuruShort . '%');
                })->first();
                
                if (!$guru) {
                    $errors[] = "Guru tidak ditemukan: $namaGuruShort";
                    $skipped++;
                    echo "  ⚠ Guru tidak ditemukan: $namaGuruShort\n";
                    continue;
                }
                
                // Parse mata pelajaran
                $mataPelajaranDb = $mapelMap[$mataPelajaran] ?? 'lainnya';
                
                // Detect lab/lapangan
                $isLab = stripos($ruang, 'lab') !== false;
                $isLapangan = stripos($ruang, 'lapangan') !== false;
                
                // Check if exists
                $exists = Jadwal::where('guru_id', $guru->id)
                    ->where('kelas', $kelas)
                    ->where('hari', $hari)
                    ->where('jam_mulai', $jamMulai)
                    ->exists();
                
                if ($exists) {
                    $skipped++;
                    continue;
                }
                
                // Create jadwal
                Jadwal::create([
                    'mata_pelajaran' => $mataPelajaranDb,
                    'guru_id' => $guru->id,
                    'kelas' => $kelas,
                    'hari' => $hari,
                    'jam_mulai' => $jamMulai,
                    'jam_selesai' => $jamSelesai,
                    'semester' => '1',
                    'tahun_ajaran' => '2025/2026',
                    'status' => 'aktif',
                    'is_berulang' => true,
                    'is_lab' => $isLab,
                    'is_lapangan' => $isLapangan,
                    'ruang' => $ruang,
                    'created_by' => 1,
                ]);
                
                echo "  ✓ $mataPelajaran - $namaGuruShort - Kelas $kelas - $hari $jamMulai\n";
                $imported++;
                
            } catch (\Exception $e) {
                $errors[] = "Error: " . $e->getMessage();
                $skipped++;
                echo "  ✗ Error: {$e->getMessage()}\n";
            }
        }
        
        echo "\n=== Hasil Import ===\n";
        echo "Berhasil: $imported jadwal\n";
        echo "Dilewati: $skipped jadwal\n";
        
        if (count($errors) > 0) {
            echo "\nError (10 pertama):\n";
            foreach (array_slice($errors, 0, 10) as $error) {
                echo "  - $error\n";
            }
        }
        
        echo "\n=== Jadwal per Guru ===\n";
        $gurus = Guru::with('user')->get();
        foreach ($gurus as $guru) {
            $count = Jadwal::where('guru_id', $guru->id)->count();
            if ($count > 0) {
                echo "  {$guru->user->name}: $count jadwal\n";
            }
        }
    }
}
