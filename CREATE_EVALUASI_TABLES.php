<?php
// Script untuk membuat tabel Evaluasi - PASTI BERHASIL
$pdo = new PDO('mysql:host=localhost;dbname=nurani', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

echo "Membuat tabel Evaluasi Guru...\n\n";

// 1. Rubrik Penilaian
try {
    $pdo->exec("CREATE TABLE IF NOT EXISTS `rubrik_penilaian` (
      `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
      `guru_id` bigint(20) UNSIGNED NOT NULL,
      `judul` varchar(255) NOT NULL,
      `mata_pelajaran` varchar(255) NOT NULL,
      `kelas` varchar(255) NOT NULL,
      `semester` varchar(255) NOT NULL,
      `tahun_pelajaran` varchar(255) DEFAULT NULL,
      `deskripsi` text DEFAULT NULL,
      `kriteria_penilaian` text NOT NULL,
      `skala_nilai` text DEFAULT NULL,
      `indikator` text DEFAULT NULL,
      `created_at` timestamp NULL DEFAULT NULL,
      `updated_at` timestamp NULL DEFAULT NULL,
      PRIMARY KEY (`id`),
      KEY `rubrik_penilaian_guru_id_index` (`guru_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    echo "✓ rubrik_penilaian\n";
} catch (Exception $e) {
    echo "✗ rubrik_penilaian: " . $e->getMessage() . "\n";
}

// 2. Lembar Penilaian
try {
    $pdo->exec("CREATE TABLE IF NOT EXISTS `lembar_penilaian` (
      `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
      `guru_id` bigint(20) UNSIGNED NOT NULL,
      `siswa_id` bigint(20) UNSIGNED NOT NULL,
      `rubrik_penilaian_id` bigint(20) UNSIGNED DEFAULT NULL,
      `mata_pelajaran` varchar(255) NOT NULL,
      `kelas` varchar(255) NOT NULL,
      `semester` varchar(255) NOT NULL,
      `tahun_pelajaran` varchar(255) DEFAULT NULL,
      `tanggal_penilaian` date NOT NULL,
      `jenis_penilaian` varchar(255) NOT NULL,
      `aspek_penilaian` text DEFAULT NULL,
      `nilai` decimal(5,2) DEFAULT NULL,
      `catatan` text DEFAULT NULL,
      `detail_nilai` text DEFAULT NULL,
      `created_at` timestamp NULL DEFAULT NULL,
      `updated_at` timestamp NULL DEFAULT NULL,
      PRIMARY KEY (`id`),
      KEY `lembar_penilaian_guru_id_index` (`guru_id`),
      KEY `lembar_penilaian_siswa_id_index` (`siswa_id`),
      KEY `lembar_penilaian_rubrik_penilaian_id_index` (`rubrik_penilaian_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    echo "✓ lembar_penilaian\n";
} catch (Exception $e) {
    echo "✗ lembar_penilaian: " . $e->getMessage() . "\n";
}

// 3. Nilai Formatif Sumatif
try {
    $pdo->exec("CREATE TABLE IF NOT EXISTS `nilai_formatif_sumatif` (
      `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
      `guru_id` bigint(20) UNSIGNED NOT NULL,
      `siswa_id` bigint(20) UNSIGNED NOT NULL,
      `mata_pelajaran` varchar(255) NOT NULL,
      `kelas` varchar(255) NOT NULL,
      `semester` varchar(255) NOT NULL,
      `tahun_pelajaran` varchar(255) DEFAULT NULL,
      `formatif_1` decimal(5,2) DEFAULT NULL,
      `formatif_2` decimal(5,2) DEFAULT NULL,
      `formatif_3` decimal(5,2) DEFAULT NULL,
      `formatif_4` decimal(5,2) DEFAULT NULL,
      `rata_formatif` decimal(5,2) DEFAULT NULL,
      `sumatif_uts` decimal(5,2) DEFAULT NULL,
      `sumatif_uas` decimal(5,2) DEFAULT NULL,
      `rata_sumatif` decimal(5,2) DEFAULT NULL,
      `nilai_akhir` decimal(5,2) DEFAULT NULL,
      `predikat` varchar(255) DEFAULT NULL,
      `keterangan` text DEFAULT NULL,
      `created_at` timestamp NULL DEFAULT NULL,
      `updated_at` timestamp NULL DEFAULT NULL,
      PRIMARY KEY (`id`),
      KEY `nilai_formatif_sumatif_guru_id_index` (`guru_id`),
      KEY `nilai_formatif_sumatif_siswa_id_index` (`siswa_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    echo "✓ nilai_formatif_sumatif\n";
} catch (Exception $e) {
    echo "✗ nilai_formatif_sumatif: " . $e->getMessage() . "\n";
}

// 4. Rekap Hasil Belajar
try {
    $pdo->exec("CREATE TABLE IF NOT EXISTS `rekap_hasil_belajar` (
      `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
      `guru_id` bigint(20) UNSIGNED NOT NULL,
      `siswa_id` bigint(20) UNSIGNED NOT NULL,
      `kelas` varchar(255) NOT NULL,
      `semester` varchar(255) NOT NULL,
      `tahun_pelajaran` varchar(255) DEFAULT NULL,
      `mata_pelajaran` varchar(255) NOT NULL,
      `nilai_formatif` decimal(5,2) DEFAULT NULL,
      `nilai_sumatif` decimal(5,2) DEFAULT NULL,
      `nilai_akhir` decimal(5,2) DEFAULT NULL,
      `predikat` varchar(255) DEFAULT NULL,
      `total_mata_pelajaran` int(11) DEFAULT 0,
      `rata_rata_semua_mapel` decimal(5,2) DEFAULT NULL,
      `jumlah_mapel_tuntas` int(11) DEFAULT 0,
      `jumlah_mapel_tidak_tuntas` int(11) DEFAULT 0,
      `catatan` text DEFAULT NULL,
      `created_at` timestamp NULL DEFAULT NULL,
      `updated_at` timestamp NULL DEFAULT NULL,
      PRIMARY KEY (`id`),
      KEY `rekap_hasil_belajar_guru_id_index` (`guru_id`),
      KEY `rekap_hasil_belajar_siswa_id_index` (`siswa_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    echo "✓ rekap_hasil_belajar\n";
} catch (Exception $e) {
    echo "✗ rekap_hasil_belajar: " . $e->getMessage() . "\n";
}

echo "\nSUCCESS: Semua tabel berhasil dibuat!\n";
