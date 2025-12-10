<?php
/**
 * Script untuk membuat tabel Evaluasi Guru secara otomatis
 * Akses: http://localhost/nurani/public/BUAT_TABEL_EVALUASI_OTOMATIS.php
 */

$host = 'localhost';
$dbname = 'nurani';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $tables = [
        'rubrik_penilaian' => "CREATE TABLE IF NOT EXISTS `rubrik_penilaian` (
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
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",
        
        'lembar_penilaian' => "CREATE TABLE IF NOT EXISTS `lembar_penilaian` (
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
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",
        
        'nilai_formatif_sumatif' => "CREATE TABLE IF NOT EXISTS `nilai_formatif_sumatif` (
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
          KEY `nilai_formatif_sumatif_siswa_id_index` (`siswa_id`),
          KEY `nilai_formatif_sumatif_guru_id_mata_pelajaran_kelas_semester_index` (`guru_id`, `mata_pelajaran`, `kelas`, `semester`),
          KEY `nilai_formatif_sumatif_siswa_id_mata_pelajaran_index` (`siswa_id`, `mata_pelajaran`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",
        
        'rekap_hasil_belajar' => "CREATE TABLE IF NOT EXISTS `rekap_hasil_belajar` (
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
          KEY `rekap_hasil_belajar_siswa_id_index` (`siswa_id`),
          KEY `rekap_hasil_belajar_guru_id_kelas_semester_index` (`guru_id`, `kelas`, `semester`),
          KEY `rekap_hasil_belajar_siswa_id_semester_index` (`siswa_id`, `semester`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci"
    ];
    
    $results = [];
    
    foreach ($tables as $tableName => $sql) {
        try {
            // Cek apakah tabel sudah ada
            $checkTable = $pdo->query("SHOW TABLES LIKE '$tableName'");
            if ($checkTable->rowCount() > 0) {
                $results[$tableName] = "SUCCESS: Tabel $tableName sudah ada";
            } else {
                $pdo->exec($sql);
                $results[$tableName] = "SUCCESS: Tabel $tableName berhasil dibuat";
            }
        } catch (PDOException $e) {
            $results[$tableName] = "ERROR: " . $e->getMessage();
        }
    }
    
    header("Refresh: 3; url=http://localhost/nurani/public/guru/evaluasi/rubrik");
    
} catch (PDOException $e) {
    $error = "ERROR KONEKSI: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Membuat Tabel Evaluasi...</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%);
            padding: 20px;
        }
        .container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.2);
            max-width: 800px;
            width: 100%;
        }
        h1 { color: #333; margin-bottom: 20px; }
        .result {
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border-left: 4px solid #28a745;
            background: #d4edda;
        }
        .error {
            border-left-color: #dc3545;
            background: #f8d7da;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Membuat Tabel Evaluasi Guru</h1>
        <?php if(isset($error)): ?>
            <div class="result error"><?php echo htmlspecialchars($error); ?></div>
        <?php else: ?>
            <?php foreach($results as $table => $message): ?>
                <div class="result <?php echo strpos($message, 'ERROR') !== false ? 'error' : ''; ?>">
                    <strong><?php echo $table; ?>:</strong> <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
        <p class="mt-3">Mengarahkan ke halaman Evaluasi dalam 3 detik...</p>
    </div>
</body>
</html>
