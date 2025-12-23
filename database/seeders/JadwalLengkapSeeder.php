<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jadwal;
use App\Models\Guru;
use Illuminate\Support\Facades\DB;

class JadwalLengkapSeeder extends Seeder
{
    public function run()
    {
        echo "=== Import Jadwal Lengkap ===\n\n";
        
        // Data jadwal lengkap
        $jadwalData = [
            // Senin - Kelas 7
            ['IPA', 'Nurhadi', '7', 'senin', '07:00:00', '08:20:00', 'Ruang 7'],
            ['IPS', 'Nurhadi', '7', 'senin', '08:20:00', '09:00:00', 'Ruang 7'],
            ['Bahasa Sunda', 'Lola Nurlaelis', '7', 'senin', '09:00:00', '09:40:00', 'Ruang 7'],
            ['Bahasa Sunda', 'Nurhadi', '7', 'senin', '09:40:00', '10:00:00', 'Ruang 7'],
            ['Matematika', 'Nurhadi', '7', 'senin', '10:00:00', '10:40:00', 'Ruang 7'],
            ['Seni Budaya', 'Nurhadi', '7', 'senin', '10:40:00', '11:20:00', 'Ruang 7'],
            ['Matematika', 'Nurhadi', '7', 'senin', '11:20:00', '12:00:00', 'Ruang 7'],
            
            // Senin - Kelas 8
            ['Bahasa Indonesia', 'Maman Suparman', '8', 'senin', '07:00:00', '07:40:00', 'Ruang 8'],
            ['IPA', 'Nurhadi', '8', 'senin', '07:40:00', '08:20:00', 'Ruang 8'],
            ['IPA', 'Nurhadi', '8', 'senin', '08:20:00', '09:00:00', 'Ruang 8'],
            ['Bahasa Sunda', 'Lola Nurlaelis', '8', 'senin', '09:00:00', '09:40:00', 'Ruang 8'],
            ['Matematika', 'Nurhadi', '8', 'senin', '10:00:00', '10:40:00', 'Ruang 8'],
            ['Matematika', 'Nurhadi', '8', 'senin', '10:40:00', '11:20:00', 'Ruang 8'],
            ['Matematika', 'Nurhadi', '8', 'senin', '11:20:00', '12:00:00', 'Ruang 8'],
            
            // Senin - Kelas 9
            ['Bahasa Indonesia', 'Maman Suparman', '9', 'senin', '07:00:00', '07:40:00', 'Ruang 9'],
            ['Matematika', 'Nurhadi', '9', 'senin', '07:40:00', '08:20:00', 'Ruang 9'],
            ['Matematika', 'Nurhadi', '9', 'senin', '08:20:00', '09:00:00', 'Ruang 9'],
            ['Matematika', 'Nurhadi', '9', 'senin', '09:00:00', '09:40:00', 'Ruang 9'],
            ['Matematika', 'Nurhadi', '9', 'senin', '10:00:00', '10:40:00', 'Ruang 9'],
            ['Seni Budaya', 'Nurhadi', '9', 'senin', '10:40:00', '11:20:00', 'Ruang 9'],
            ['Bahasa Arab', 'Nurhadi', '9', 'senin', '11:20:00', '12:00:00', 'Ruang 9'],
            
            // Kamis - Kelas 7 (Penjaskes)
            ['Pendidikan Agama', 'Siti Mundari', '7', 'kamis', '07:00:00', '07:40:00', 'Ruang 7'],
            ['Pendidikan Agama', 'Siti Mundari', '7', 'kamis', '07:40:00', '08:20:00', 'Ruang 7'],
            ['Matematika', 'Nurhadi', '7', 'kamis', '08:20:00', '09:00:00', 'Ruang 7'],
            ['Matematika', 'Nurhadi', '7', 'kamis', '09:00:00', '09:40:00', 'Ruang 7'],
            ['Pendidikan Jasmani', 'Fadli', '7', 'kamis', '10:00:00', '10:40:00', 'Lapangan'],
            ['Pendidikan Jasmani', 'Fadli', '7', 'kamis', '10:40:00', '11:20:00', 'Lapangan'],
            ['Pendidikan Jasmani', 'Fadli', '7', 'kamis', '11:20:00', '12:00:00', 'Lapangan'],
        ];
        
        $imported = 0;
        $skipped = 0;
        
        // Mapping mata pelajaran
        $mapelMap = [
            'matematika' => 'matematika',
            'bahasa indonesia' => 'bahasa_indonesia',
            'bahasa inggris' => 'bahasa_inggris',
            'ipa' => 'ipa',
            'ips' => 'ips',
            'pendidikan agama' => 'pendidikan_agama',
            'pkn' => 'pendidikan_kewarganegaraan',
            'pendidikan jasmani' => 'pendidikan_jasmani',
            'seni budaya' => 'seni_budaya',
            'bahasa sunda' => 'lainnya',
            'bahasa arab' => 'lainnya',
            'tahsin' => 'lainnya',
            'prakarya' => 'lainnya',
            'informatika' => 'teknologi_informasi',
        ];
        
        foreach ($jadwalData as $data) {
            list($mataPelajaran, $namaGuru, $kelas, $hari, $jamMulai, $jamSelesai, $ruang) = $data;
            
            // Find guru
            $guru = Guru::whereHas('user', function($query) use ($namaGuru) {
                $query->where('name', 'LIKE', '%' . $namaGuru . '%');
            })->first();
            
            if (!$guru) {
                echo "  ⚠ Guru tidak ditemukan: $namaGuru\n";
                $skipped++;
                continue;
            }
            
            // Parse mata pelajaran
            $mataPelajaranLower = strtolower($mataPelajaran);
            $mataPelajaranDb = $mapelMap[$mataPelajaranLower] ?? 'lainnya';
            
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
                echo "  - Skip: $mataPelajaran - Kelas $kelas - $hari\n";
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
            
            echo "  ✓ $mataPelajaran - Kelas $kelas - $hari $jamMulai-$jamSelesai\n";
            $imported++;
        }
        
        echo "\n=== Hasil Import ===\n";
        echo "Berhasil: $imported jadwal\n";
        echo "Dilewati: $skipped jadwal\n";
    }
}
