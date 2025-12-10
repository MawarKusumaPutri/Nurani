<?php
/**
 * Script untuk membuat tabel RPP secara otomatis - LANGSUNG JALANKAN
 * File ini akan membuat tabel RPP langsung saat diakses
 */

// Koneksi database
$host = 'localhost';
$dbname = 'nurani';
$username = 'root';
$password = ''; // Default XAMPP tidak ada password

try {
    // Buat koneksi PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Cek apakah tabel sudah ada
    $checkTable = $pdo->query("SHOW TABLES LIKE 'rpp'");
    $tableExists = $checkTable->rowCount() > 0;
    
    if ($tableExists) {
        $result = "SUCCESS: Tabel RPP sudah ada di database.";
        $status = "success";
    } else {
        // SQL untuk membuat tabel RPP
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
        
        try {
            $pdo->exec($sql);
            $result = "SUCCESS: Tabel RPP berhasil dibuat di database nurani!";
            $status = "success";
        } catch (PDOException $e) {
            $result = "ERROR: " . $e->getMessage();
            $status = "error";
        }
    }
    
    // Redirect ke halaman RPP setelah 2 detik
    header("Refresh: 2; url=http://localhost/nurani/public/guru/rpp");
    
} catch (PDOException $e) {
    $result = "ERROR KONEKSI: " . $e->getMessage();
    $status = "error";
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Membuat Tabel RPP...</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%);
        }
        .container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.2);
            text-align: center;
            max-width: 600px;
        }
        .success {
            color: #28a745;
            font-size: 48px;
            margin-bottom: 20px;
        }
        .error {
            color: #dc3545;
            font-size: 48px;
            margin-bottom: 20px;
        }
        h1 {
            color: #333;
            margin-bottom: 20px;
        }
        .message {
            font-size: 18px;
            margin: 20px 0;
            padding: 15px;
            border-radius: 5px;
            <?php if($status == 'success'): ?>
            background: #d4edda;
            color: #155724;
            border-left: 4px solid #28a745;
            <?php else: ?>
            background: #f8d7da;
            color: #721c24;
            border-left: 4px solid #dc3545;
            <?php endif; ?>
        }
        .loading {
            margin-top: 20px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if($status == 'success'): ?>
            <div class="success">✅</div>
            <h1>Berhasil!</h1>
        <?php else: ?>
            <div class="error">❌</div>
            <h1>Error</h1>
        <?php endif; ?>
        
        <div class="message">
            <?php echo htmlspecialchars($result); ?>
        </div>
        
        <div class="loading">
            Mengarahkan ke halaman RPP dalam 2 detik...
        </div>
    </div>
</body>
</html>
