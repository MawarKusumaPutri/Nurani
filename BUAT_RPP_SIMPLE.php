<?php
// Script sederhana untuk membuat tabel RPP
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = 'localhost';
$dbname = 'nurani';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "========================================\n";
    echo "MEMBUAT TABEL RPP\n";
    echo "========================================\n\n";
    
    // Cek apakah tabel sudah ada
    $checkTable = $pdo->query("SHOW TABLES LIKE 'rpp'");
    if ($checkTable->rowCount() > 0) {
        echo "✓ Tabel 'rpp' sudah ada.\n";
        echo "Menghapus tabel lama...\n";
        $pdo->exec("DROP TABLE IF EXISTS `rpp`");
        echo "✓ Tabel lama dihapus.\n\n";
    }
    
    echo "Membuat tabel 'rpp'...\n";
    
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
    
    $pdo->exec($sql);
    
    echo "✓ Tabel 'rpp' berhasil dibuat!\n\n";
    
    // Verifikasi
    $checkTable = $pdo->query("SHOW TABLES LIKE 'rpp'");
    if ($checkTable->rowCount() > 0) {
        echo "✓ Verifikasi: Tabel 'rpp' sudah ada di database.\n";
        echo "\n========================================\n";
        echo "SUKSES! Tabel RPP sudah siap digunakan.\n";
        echo "========================================\n";
        echo "\nSilakan refresh halaman RPP di browser (Ctrl+F5)\n";
        echo "Atau buka: http://localhost/nurani/public/guru/rpp\n";
    } else {
        echo "✗ ERROR: Tabel 'rpp' tidak ditemukan setelah dibuat!\n";
        exit(1);
    }
    
} catch (PDOException $e) {
    echo "\n✗ ERROR: " . $e->getMessage() . "\n";
    echo "\nFile: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
    exit(1);
}
?>
