<?php
/**
 * Script untuk membuat tabel RPP secara otomatis - LANGSUNG JALANKAN
 * Akses: http://localhost/nurani/public/BUAT_TABEL_RPP_OTOMATIS_LANGSUNG.php
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
        $action = "exists";
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
            $action = "created";
        } catch (PDOException $e) {
            $result = "ERROR: " . $e->getMessage();
            $status = "error";
            $action = "error";
        }
    }
    
    // Redirect ke halaman RPP setelah 3 detik jika berhasil
    if ($status == "success") {
        header("Refresh: 3; url=http://localhost/nurani/public/guru/rpp");
    }
    
} catch (PDOException $e) {
    $result = "ERROR KONEKSI: " . $e->getMessage();
    $status = "error";
    $action = "error";
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Membuat Tabel RPP...</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
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
            padding: 50px;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.3);
            text-align: center;
            max-width: 700px;
            width: 100%;
        }
        .icon {
            font-size: 80px;
            margin-bottom: 30px;
            animation: bounce 1s ease-in-out;
        }
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }
        .success .icon {
            color: #28a745;
        }
        .error .icon {
            color: #dc3545;
        }
        h1 {
            color: #333;
            margin-bottom: 20px;
            font-size: 32px;
        }
        .message {
            font-size: 18px;
            margin: 30px 0;
            padding: 20px;
            border-radius: 10px;
            line-height: 1.6;
        }
        .success .message {
            background: #d4edda;
            color: #155724;
            border-left: 5px solid #28a745;
        }
        .error .message {
            background: #f8d7da;
            color: #721c24;
            border-left: 5px solid #dc3545;
        }
        .loading {
            margin-top: 30px;
            color: #666;
            font-size: 16px;
        }
        .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #4CAF50;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 20px auto;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .btn {
            display: inline-block;
            padding: 12px 30px;
            margin-top: 20px;
            background: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background 0.3s;
        }
        .btn:hover {
            background: #45a049;
        }
        .info-box {
            background: #e7f3ff;
            border-left: 5px solid #2196F3;
            padding: 15px;
            margin-top: 20px;
            border-radius: 5px;
            text-align: left;
        }
        .info-box ul {
            margin-left: 20px;
            margin-top: 10px;
        }
        .info-box li {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <div class="container <?php echo $status; ?>">
        <?php if($status == 'success'): ?>
            <div class="icon">✅</div>
            <h1>Berhasil!</h1>
            <div class="message">
                <?php echo htmlspecialchars($result); ?>
            </div>
            <?php if($action == 'created'): ?>
                <div class="info-box">
                    <strong>✓ Tabel RPP sudah dibuat dengan sukses!</strong>
                    <ul>
                        <li>Total kolom: 35 kolom</li>
                        <li>Primary Key: id</li>
                        <li>Index: guru_id</li>
                        <li>Engine: InnoDB</li>
                        <li>Charset: utf8mb4</li>
                    </ul>
                </div>
            <?php endif; ?>
            <div class="loading">
                <div class="spinner"></div>
                Mengarahkan ke halaman RPP dalam 3 detik...
            </div>
            <a href="http://localhost/nurani/public/guru/rpp" class="btn">
                <i class="fas fa-arrow-right"></i> Buka Halaman RPP Sekarang
            </a>
        <?php else: ?>
            <div class="icon">❌</div>
            <h1>Error</h1>
            <div class="message">
                <?php echo htmlspecialchars($result); ?>
            </div>
            <div class="info-box">
                <strong>Solusi:</strong>
                <ul>
                    <li>Pastikan XAMPP MySQL sudah running (status hijau)</li>
                    <li>Pastikan database "nurani" sudah ada</li>
                    <li>Coba buka phpMyAdmin: <a href="http://localhost/phpmyadmin" target="_blank">http://localhost/phpmyadmin</a></li>
                    <li>Atau coba cara manual dengan file SQL_RPP_LANGSUNG.txt</li>
                </ul>
            </div>
            <a href="http://localhost/nurani/public/guru/rpp" class="btn">
                Kembali ke Halaman RPP
            </a>
        <?php endif; ?>
    </div>
</body>
</html>
