<?php
/**
 * Script SEDERHANA untuk membuat tabel RPP
 * Tanpa foreign key constraint dulu (untuk menghindari error)
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "========================================\n";
echo "MEMBUAT TABEL RPP - SIMPLE VERSION\n";
echo "========================================\n\n";

// Load Laravel
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    echo "[1] Menghubungkan ke database...\n";
    $pdo = DB::connection()->getPdo();
    echo "✓ Terhubung ke database: " . DB::connection()->getDatabaseName() . "\n\n";
    
    echo "[2] Menghapus tabel 'rpp' jika sudah ada...\n";
    DB::statement('DROP TABLE IF EXISTS `rpp`');
    echo "✓ Tabel lama dihapus (jika ada)\n\n";
    
    echo "[3] Membuat tabel 'rpp'...\n";
    
    // Buat tabel tanpa foreign key constraint dulu
    $sql = "CREATE TABLE `rpp` (
        `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        `guru_id` bigint(20) UNSIGNED NOT NULL,
        `judul` varchar(255) NOT NULL,
        `mata_pelajaran` varchar(255) NOT NULL,
        `kelas` varchar(255) NOT NULL,
        `semester` varchar(255) NOT NULL,
        `pertemuan_ke` int(11) NOT NULL,
        `alokasi_waktu` int(11) NOT NULL,
        `sekolah` varchar(255) DEFAULT NULL,
        `mata_pelajaran_detail` varchar(255) DEFAULT NULL,
        `kelas_detail` varchar(255) DEFAULT NULL,
        `semester_detail` varchar(255) DEFAULT NULL,
        `tahun_pelajaran` varchar(255) DEFAULT NULL,
        `ki_1` text DEFAULT NULL,
        `ki_2` text DEFAULT NULL,
        `ki_3` text DEFAULT NULL,
        `ki_4` text DEFAULT NULL,
        `kd_pengetahuan` text DEFAULT NULL,
        `kd_keterampilan` text DEFAULT NULL,
        `indikator_pencapaian_kompetensi` text DEFAULT NULL,
        `tujuan_pembelajaran` text DEFAULT NULL,
        `materi_pembelajaran` text DEFAULT NULL,
        `materi_pembelajaran_reguler` text DEFAULT NULL,
        `materi_pembelajaran_pengayaan` text DEFAULT NULL,
        `materi_pembelajaran_remedial` text DEFAULT NULL,
        `metode_pembelajaran` text DEFAULT NULL,
        `kegiatan_pendahuluan` text DEFAULT NULL,
        `kegiatan_inti` text DEFAULT NULL,
        `kegiatan_penutup` text DEFAULT NULL,
        `media_pembelajaran` text DEFAULT NULL,
        `sumber_belajar` text DEFAULT NULL,
        `teknik_penilaian` text DEFAULT NULL,
        `bentuk_instrumen` text DEFAULT NULL,
        `rubrik_penilaian` text DEFAULT NULL,
        `kriteria_ketuntasan` text DEFAULT NULL,
        `created_at` timestamp NULL DEFAULT NULL,
        `updated_at` timestamp NULL DEFAULT NULL,
        PRIMARY KEY (`id`),
        KEY `rpp_guru_id_index` (`guru_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    DB::statement($sql);
    echo "✓ Tabel 'rpp' berhasil dibuat!\n\n";
    
    echo "[4] Menambahkan foreign key constraint...\n";
    try {
        // Cek apakah tabel gurus ada
        $gurusExists = DB::select("SHOW TABLES LIKE 'gurus'");
        if (count($gurusExists) > 0) {
            DB::statement("ALTER TABLE `rpp` ADD CONSTRAINT `rpp_guru_id_foreign` FOREIGN KEY (`guru_id`) REFERENCES `gurus` (`id`) ON DELETE CASCADE");
            echo "✓ Foreign key constraint ditambahkan\n\n";
        } else {
            echo "⚠ Tabel 'gurus' tidak ditemukan, skip foreign key\n\n";
        }
    } catch (Exception $e) {
        echo "⚠ Warning: " . $e->getMessage() . "\n";
        echo "  Tabel tetap dibuat, tapi tanpa foreign key constraint\n\n";
    }
    
    echo "[5] Verifikasi...\n";
    $tables = DB::select("SHOW TABLES LIKE 'rpp'");
    if (count($tables) > 0) {
        $count = DB::table('rpp')->count();
        echo "✓ Tabel 'rpp' sudah ada di database\n";
        echo "✓ Jumlah data: $count record\n\n";
        
        echo "========================================\n";
        echo "SUKSES! Tabel RPP sudah siap digunakan.\n";
        echo "========================================\n";
        echo "\nSilakan refresh halaman RPP di browser (Ctrl+F5)\n";
    } else {
        throw new Exception("Tabel 'rpp' tidak ditemukan setelah dibuat!");
    }
    
} catch (PDOException $e) {
    echo "\n✗ DATABASE ERROR: " . $e->getMessage() . "\n";
    echo "\nKode Error: " . $e->getCode() . "\n";
    echo "\nPastikan:\n";
    echo "1. MySQL/MariaDB sudah running\n";
    echo "2. Database 'nurani' sudah ada\n";
    echo "3. Kredensial database di .env sudah benar\n";
    exit(1);
} catch (Exception $e) {
    echo "\n✗ ERROR: " . $e->getMessage() . "\n";
    echo "\nFile: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
    exit(1);
}
