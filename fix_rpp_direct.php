<?php
/**
 * Script langsung untuk membuat tabel RPP
 * Jalankan: php fix_rpp_direct.php
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "========================================\n";
echo "MEMBUAT TABEL RPP - DIRECT METHOD\n";
echo "========================================\n\n";

// Load Laravel
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

try {
    echo "[1] Menghubungkan ke database...\n";
    DB::connection()->getPdo();
    echo "✓ Terhubung ke database\n\n";
    
    echo "[2] Mengecek apakah tabel 'rpp' sudah ada...\n";
    $tableExists = Schema::hasTable('rpp');
    
    if ($tableExists) {
        echo "⚠ Tabel 'rpp' sudah ada. Menghapus...\n";
        DB::statement('DROP TABLE IF EXISTS `rpp`');
        echo "✓ Tabel lama dihapus\n\n";
    } else {
        echo "✓ Tabel 'rpp' belum ada, akan dibuat\n\n";
    }
    
    echo "[3] Membuat tabel 'rpp'...\n";
    
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
        KEY `rpp_guru_id_foreign` (`guru_id`),
        CONSTRAINT `rpp_guru_id_foreign` FOREIGN KEY (`guru_id`) REFERENCES `gurus` (`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    DB::statement($sql);
    echo "✓ Tabel 'rpp' berhasil dibuat!\n\n";
    
    echo "[4] Verifikasi...\n";
    if (Schema::hasTable('rpp')) {
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
    
} catch (Exception $e) {
    echo "\n✗ ERROR: " . $e->getMessage() . "\n";
    echo "\nDetail Error:\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
    if ($e->getPrevious()) {
        echo "Previous: " . $e->getPrevious()->getMessage() . "\n";
    }
    exit(1);
} catch (PDOException $e) {
    echo "\n✗ DATABASE ERROR: " . $e->getMessage() . "\n";
    echo "\nPastikan:\n";
    echo "1. MySQL/MariaDB sudah running\n";
    echo "2. Database 'nurani' sudah ada\n";
    echo "3. Tabel 'gurus' sudah ada (untuk foreign key)\n";
    echo "4. Kredensial database di .env sudah benar\n";
    exit(1);
}
