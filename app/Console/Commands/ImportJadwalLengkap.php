<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Jadwal;
use App\Models\Guru;
use Carbon\Carbon;

class ImportJadwalLengkap extends Command
{
    protected $signature = 'jadwal:import-lengkap';
    protected $description = 'Import jadwal lengkap dari CSV';

    public function handle()
    {
        $this->info('=== Import Jadwal Lengkap ===');
        
        $csvFile = base_path('jadwal_lengkap_import.csv');
        
        if (!file_exists($csvFile)) {
            $this->error('File jadwal_lengkap_import.csv tidak ditemukan!');
            return 1;
        }
        
        $handle = fopen($csvFile, 'r');
        $header = fgetcsv($handle); // Skip header
        
        $imported = 0;
        $errors = [];
        $skipped = 0;
        
        // Mapping hari
        $hariMap = [
            'senin' => 'senin',
            'selasa' => 'selasa',
            'rabu' => 'rabu',
            'kamis' => 'kamis',
            'jumat' => 'jumat',
            'sabtu' => 'sabtu',
        ];
        
        // Mapping mata pelajaran
        $mapelMap = [
            'matematika' => 'matematika',
            'bahasa indonesia' => 'bahasa_indonesia',
            'bahasa inggris' => 'bahasa_inggris',
            'ipa' => 'ipa',
            'ilmu pengetahuan alam' => 'ipa',
            'ips' => 'ips',
            'ilmu pengetahuan sosial' => 'ips',
            'pendidikan agama' => 'pendidikan_agama',
            'pkn' => 'pendidikan_kewarganegaraan',
            'pendidikan jasmani' => 'pendidikan_jasmani',
            'seni budaya' => 'seni_budaya',
            'bahasa sunda' => 'lainnya',
            'bahasa arab' => 'lainnya',
            'tahsin' => 'lainnya',
            'prakarya' => 'lainnya',
            'informatika' => 'teknologi_informasi',
            'baca tulis al quran' => 'lainnya',
            'akidah akhlak' => 'lainnya',
        ];
        
        $this->info('Membaca data dari CSV...');
        
        while (($row = fgetcsv($handle)) !== false) {
            if (empty($row[0]) || empty($row[1])) {
                continue;
            }
            
            try {
                $mataPelajaran = trim($row[0]);
                $namaGuru = trim($row[1]);
                $kelas = trim($row[2]);
                $hari = strtolower(trim($row[3]));
                $waktu = trim($row[4]);
                $ruang = trim($row[5]);
                $keterangan = trim($row[6] ?? '');
                
                // Find guru
                $guru = Guru::whereHas('user', function($query) use ($namaGuru) {
                    $query->where('name', 'LIKE', '%' . $namaGuru . '%');
                })->first();
                
                if (!$guru) {
                    $this->warn("Guru tidak ditemukan: $namaGuru");
                    $skipped++;
                    continue;
                }
                
                // Parse hari
                if (!isset($hariMap[$hari])) {
                    $this->warn("Hari tidak valid: $hari");
                    $skipped++;
                    continue;
                }
                $hariDb = $hariMap[$hari];
                
                // Parse waktu
                $waktuParts = explode(' - ', $waktu);
                if (count($waktuParts) !== 2) {
                    $this->warn("Format waktu tidak valid: $waktu");
                    $skipped++;
                    continue;
                }
                
                $jamMulai = trim($waktuParts[0]) . ':00';
                $jamSelesai = trim($waktuParts[1]) . ':00';
                
                // Parse mata pelajaran
                $mataPelajaranLower = strtolower($mataPelajaran);
                $mataPelajaranDb = $mapelMap[$mataPelajaranLower] ?? 'lainnya';
                
                // Detect lab/lapangan
                $isLab = stripos($ruang, 'lab') !== false;
                $isLapangan = stripos($ruang, 'lapangan') !== false;
                
                // Check if exists
                $exists = Jadwal::where('guru_id', $guru->id)
                    ->where('kelas', $kelas)
                    ->where('hari', $hariDb)
                    ->where('jam_mulai', $jamMulai)
                    ->exists();
                
                if ($exists) {
                    $this->line("  Skip: $mataPelajaran - Kelas $kelas - $hari");
                    $skipped++;
                    continue;
                }
                
                // Create jadwal
                Jadwal::create([
                    'mata_pelajaran' => $mataPelajaranDb,
                    'guru_id' => $guru->id,
                    'kelas' => $kelas,
                    'hari' => $hariDb,
                    'jam_mulai' => $jamMulai,
                    'jam_selesai' => $jamSelesai,
                    'semester' => '1',
                    'tahun_ajaran' => '2025/2026',
                    'status' => 'aktif',
                    'keterangan' => $keterangan ?: null,
                    'is_berulang' => true,
                    'is_lab' => $isLab,
                    'is_lapangan' => $isLapangan,
                    'ruang' => $ruang,
                    'created_by' => 1,
                ]);
                
                $this->info("  ✓ $mataPelajaran - Kelas $kelas - $hari $waktu");
                $imported++;
                
            } catch (\Exception $e) {
                $this->error("Error: " . $e->getMessage());
                $skipped++;
            }
        }
        
        fclose($handle);
        
        $this->info("\n=== Hasil Import ===");
        $this->info("Berhasil: $imported jadwal");
        $this->warn("Dilewati: $skipped jadwal");
        
        return 0;
    }
}
