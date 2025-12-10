<?php
/**
 * Script untuk membuat tabel Evaluasi Guru - LANGSUNG JALANKAN
 * Akses: http://localhost/nurani/public/BUAT_EVALUASI_NOW.php
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = 'localhost';
$dbname = 'nurani';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $results = [];
    
    // 1. Rubrik Penilaian
    try {
        $check = $pdo->query("SHOW TABLES LIKE 'rubrik_penilaian'");
        if ($check->rowCount() > 0) {
            $results['rubrik_penilaian'] = 'SUCCESS: Sudah ada';
        } else {
            $sql = "CREATE TABLE `rubrik_penilaian` (
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
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
            $pdo->exec($sql);
            $results['rubrik_penilaian'] = 'SUCCESS: Berhasil dibuat';
        }
    } catch (PDOException $e) {
        $results['rubrik_penilaian'] = 'ERROR: ' . $e->getMessage();
    }
    
    // 2. Lembar Penilaian
    try {
        $check = $pdo->query("SHOW TABLES LIKE 'lembar_penilaian'");
        if ($check->rowCount() > 0) {
            $results['lembar_penilaian'] = 'SUCCESS: Sudah ada';
        } else {
            $sql = "CREATE TABLE `lembar_penilaian` (
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
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
            $pdo->exec($sql);
            $results['lembar_penilaian'] = 'SUCCESS: Berhasil dibuat';
        }
    } catch (PDOException $e) {
        $results['lembar_penilaian'] = 'ERROR: ' . $e->getMessage();
    }
    
    // 3. Nilai Formatif Sumatif
    try {
        $check = $pdo->query("SHOW TABLES LIKE 'nilai_formatif_sumatif'");
        if ($check->rowCount() > 0) {
            $results['nilai_formatif_sumatif'] = 'SUCCESS: Sudah ada';
        } else {
            $sql = "CREATE TABLE `nilai_formatif_sumatif` (
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
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
            $pdo->exec($sql);
            $results['nilai_formatif_sumatif'] = 'SUCCESS: Berhasil dibuat';
        }
    } catch (PDOException $e) {
        $results['nilai_formatif_sumatif'] = 'ERROR: ' . $e->getMessage();
    }
    
    // 4. Rekap Hasil Belajar
    try {
        $check = $pdo->query("SHOW TABLES LIKE 'rekap_hasil_belajar'");
        if ($check->rowCount() > 0) {
            $results['rekap_hasil_belajar'] = 'SUCCESS: Sudah ada';
        } else {
            $sql = "CREATE TABLE `rekap_hasil_belajar` (
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
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
            $pdo->exec($sql);
            $results['rekap_hasil_belajar'] = 'SUCCESS: Berhasil dibuat';
        }
    } catch (PDOException $e) {
        $results['rekap_hasil_belajar'] = 'ERROR: ' . $e->getMessage();
    }
    
    // Cek apakah semua berhasil
    $allSuccess = true;
    foreach ($results as $result) {
        if (strpos($result, 'ERROR') !== false) {
            $allSuccess = false;
            break;
        }
    }
    
    // Redirect setelah 1 detik jika berhasil
    if ($allSuccess) {
        header("Location: http://localhost/nurani/public/guru/evaluasi/rubrik?created=1");
        exit;
    }
    
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
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.3);
            max-width: 800px;
            width: 100%;
        }
        h1 { color: #333; margin-bottom: 30px; text-align: center; }
        .success-icon { font-size: 60px; text-align: center; margin-bottom: 20px; }
        .result {
            padding: 15px;
            margin: 10px 0;
            border-radius: 8px;
            border-left: 5px solid #28a745;
            background: #d4edda;
            color: #155724;
        }
        .result.error {
            border-left-color: #dc3545;
            background: #f8d7da;
            color: #721c24;
        }
        .loading {
            text-align: center;
            margin-top: 20px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="success-icon">✅</div>
        <h1>Membuat Tabel Evaluasi Guru</h1>
        <?php if(isset($error)): ?>
            <div class="result error">
                <strong>ERROR:</strong> <?php echo htmlspecialchars($error); ?>
            </div>
        <?php else: ?>
            <?php foreach($results as $table => $message): ?>
                <div class="result <?php echo strpos($message, 'ERROR') !== false ? 'error' : ''; ?>">
                    <strong><?php echo ucfirst(str_replace('_', ' ', $table)); ?>:</strong> 
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
        <div class="loading">
            <?php if(isset($allSuccess) && $allSuccess): ?>
                <p>Mengarahkan ke halaman Rubrik Penilaian dalam 2 detik...</p>
            <?php else: ?>
                <p>Silakan periksa error di atas dan coba lagi.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
