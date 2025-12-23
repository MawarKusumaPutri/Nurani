<?php

/**
 * Script untuk import jadwal lengkap ke database
 * Jalankan dengan: php import_jadwal_lengkap.php
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Jadwal;
use App\Models\Guru;
use Carbon\Carbon;

echo "=== Import Jadwal Lengkap ===\n\n";

// Baca file CSV
$csvFile = __DIR__ . '/jadwal_lengkap_import.csv';

if (!file_exists($csvFile)) {
    echo "Error: File jadwal_lengkap_import.csv tidak ditemukan!\n";
    exit(1);
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
    'minggu' => 'minggu',
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
    'pjok' => 'pendidikan_jasmani',
    'seni budaya' => 'seni_budaya',
    'bahasa sunda' => 'lainnya',
    'bahasa arab' => 'lainnya',
    'tahsin' => 'lainnya',
    'prakarya' => 'lainnya',
    'informatika' => 'teknologi_informasi',
    'baca tulis al quran' => 'lainnya',
    'akidah akhlak' => 'lainnya',
];

echo "Membaca data dari CSV...\n";

while (($row = fgetcsv($handle)) !== false) {
    // Skip empty rows
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
            $errors[] = "Guru tidak ditemukan: $namaGuru (Mapel: $mataPelajaran, Kelas: $kelas, Hari: $hari)";
            $skipped++;
            continue;
        }
        
        // Parse hari
        if (!isset($hariMap[$hari])) {
            $errors[] = "Hari tidak valid: $hari";
            $skipped++;
            continue;
        }
        $hariDb = $hariMap[$hari];
        
        // Parse waktu (format: HH:MM - HH:MM)
        $waktuParts = explode(' - ', $waktu);
        if (count($waktuParts) !== 2) {
            $errors[] = "Format waktu tidak valid: $waktu";
            $skipped++;
            continue;
        }
        
        $jamMulai = trim($waktuParts[0]) . ':00';
        $jamSelesai = trim($waktuParts[1]) . ':00';
        
        // Parse mata pelajaran
        $mataPelajaranLower = strtolower($mataPelajaran);
        $mataPelajaranDb = $mapelMap[$mataPelajaranLower] ?? 'lainnya';
        
        // Detect lab/lapangan
        $isLab = false;
        $isLapangan = false;
        $ruangLower = strtolower($ruang);
        
        if (strpos($ruangLower, 'lab') !== false) {
            $isLab = true;
        } elseif (strpos($ruangLower, 'lapangan') !== false) {
            $isLapangan = true;
        }
        
        // Check if jadwal already exists
        $exists = Jadwal::where('guru_id', $guru->id)
            ->where('kelas', $kelas)
            ->where('hari', $hariDb)
            ->where('jam_mulai', $jamMulai)
            ->where('jam_selesai', $jamSelesai)
            ->exists();
        
        if ($exists) {
            echo "  - Skip (sudah ada): $mataPelajaran - $namaGuru - Kelas $kelas - $hari $waktu\n";
            $skipped++;
            continue;
        }
        
        // Create jadwal
        Jadwal::create([
            'mata_pelajaran' => $mataPelajaranDb,
            'guru_id' => $guru->id,
            'kelas' => $kelas,
            'hari' => $hariDb,
            'tanggal' => null,
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
            'created_by' => 1, // Admin/TU user ID
        ]);
        
        echo "  ✓ Import: $mataPelajaran - $namaGuru - Kelas $kelas - $hari $waktu\n";
        $imported++;
        
    } catch (\Exception $e) {
        $errors[] = "Error: " . $e->getMessage() . " (Row: " . implode(', ', $row) . ")";
        $skipped++;
    }
}

fclose($handle);

echo "\n=== Hasil Import ===\n";
echo "Berhasil diimport: $imported jadwal\n";
echo "Dilewati/Error: $skipped jadwal\n";

if (count($errors) > 0) {
    echo "\n=== Error Log ===\n";
    foreach (array_slice($errors, 0, 10) as $error) {
        echo "  - $error\n";
    }
    if (count($errors) > 10) {
        echo "  ... dan " . (count($errors) - 10) . " error lainnya\n";
    }
}

echo "\nSelesai!\n";
