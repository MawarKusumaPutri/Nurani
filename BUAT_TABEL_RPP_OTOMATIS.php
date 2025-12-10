<?php
/**
 * Script untuk membuat tabel RPP secara otomatis
 * Jalankan file ini di browser: http://localhost/nurani/public/BUAT_TABEL_RPP_OTOMATIS.php
 * ATAU double-click file ini jika PHP sudah terkonfigurasi
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
    
    echo "<!DOCTYPE html>
<html lang='id'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Buat Tabel RPP - Otomatis</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #2E7D32;
            margin-bottom: 20px;
        }
        .success {
            background: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            border-left: 4px solid #28a745;
        }
        .error {
            background: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            border-left: 4px solid #dc3545;
        }
        .info {
            background: #d1ecf1;
            color: #0c5460;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            border-left: 4px solid #17a2b8;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
        .btn:hover {
            background: #218838;
        }
        code {
            background: #f4f4f4;
            padding: 2px 6px;
            border-radius: 3px;
            font-family: 'Courier New', monospace;
        }
    </style>
</head>
<body>
    <div class='container'>
        <h1>🔧 Buat Tabel RPP - Otomatis</h1>";
    
    // Cek apakah tabel sudah ada
    $checkTable = $pdo->query("SHOW TABLES LIKE 'rpp'");
    $tableExists = $checkTable->rowCount() > 0;
    
    if ($tableExists) {
        echo "<div class='info'>
            <strong>ℹ️ Info:</strong> Tabel <code>rpp</code> sudah ada di database.
        </div>";
        
        // Tampilkan struktur tabel
        $columns = $pdo->query("DESCRIBE rpp")->fetchAll(PDO::FETCH_ASSOC);
        echo "<h3>Struktur Tabel RPP:</h3>";
        echo "<table border='1' cellpadding='10' style='border-collapse: collapse; width: 100%;'>";
        echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th></tr>";
        foreach ($columns as $column) {
            echo "<tr>";
            echo "<td><strong>{$column['Field']}</strong></td>";
            echo "<td>{$column['Type']}</td>";
            echo "<td>{$column['Null']}</td>";
            echo "<td>{$column['Key']}</td>";
            echo "</tr>";
        }
        echo "</table>";
        
        echo "<div class='success'>
            <strong>✅ Tabel RPP sudah tersedia!</strong><br>
            Anda bisa langsung menggunakan fitur RPP di aplikasi.
        </div>";
    } else {
        // Buat tabel RPP
        $sql = "CREATE TABLE IF NOT EXISTS `rpp` (
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
            
            echo "<div class='success'>
                <strong>✅ BERHASIL!</strong><br>
                Tabel <code>rpp</code> berhasil dibuat di database <code>nurani</code>.
            </div>";
            
            // Tampilkan struktur tabel yang baru dibuat
            $columns = $pdo->query("DESCRIBE rpp")->fetchAll(PDO::FETCH_ASSOC);
            echo "<h3>Struktur Tabel RPP:</h3>";
            echo "<table border='1' cellpadding='10' style='border-collapse: collapse; width: 100%;'>";
            echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th></tr>";
            foreach ($columns as $column) {
                echo "<tr>";
                echo "<td><strong>{$column['Field']}</strong></td>";
                echo "<td>{$column['Type']}</td>";
                echo "<td>{$column['Null']}</td>";
                echo "<td>{$column['Key']}</td>";
                echo "</tr>";
            }
            echo "</table>";
            
        } catch (PDOException $e) {
            echo "<div class='error'>
                <strong>❌ ERROR!</strong><br>
                Gagal membuat tabel: " . htmlspecialchars($e->getMessage()) . "
            </div>";
            
            // Coba buat tanpa foreign key constraint
            echo "<div class='info'>
                <strong>🔄 Mencoba metode alternatif...</strong>
            </div>";
            
            try {
                // Hapus tabel jika ada
                $pdo->exec("DROP TABLE IF EXISTS `rpp`");
                
                // Buat ulang tanpa foreign key constraint
                $sqlSimple = "CREATE TABLE `rpp` (
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
                
                $pdo->exec($sqlSimple);
                
                echo "<div class='success'>
                    <strong>✅ BERHASIL dengan metode alternatif!</strong><br>
                    Tabel <code>rpp</code> berhasil dibuat di database <code>nurani</code>.
                </div>";
                
            } catch (PDOException $e2) {
                echo "<div class='error'>
                    <strong>❌ ERROR!</strong><br>
                    Gagal membuat tabel dengan metode alternatif: " . htmlspecialchars($e2->getMessage()) . "<br><br>
                    <strong>Solusi Manual:</strong><br>
                    1. Buka phpMyAdmin: <a href='http://localhost/phpmyadmin' target='_blank'>http://localhost/phpmyadmin</a><br>
                    2. Pilih database <code>nurani</code><br>
                    3. Klik tab <strong>SQL</strong><br>
                    4. Buka file <code>SQL_RPP_LANGSUNG.txt</code> dari folder proyek<br>
                    5. Copy semua isinya dan paste ke textarea SQL<br>
                    6. Klik tombol <strong>Go</strong>
                </div>";
            }
        }
    }
    
    echo "<div class='info'>
        <strong>📝 Langkah Selanjutnya:</strong><br>
        1. Klik tombol di bawah untuk kembali ke halaman RPP<br>
        2. Atau refresh halaman RPP di browser (Ctrl+F5)<br>
        3. Fitur RPP sekarang sudah bisa digunakan!
    </div>";
    
    echo "<a href='" . (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/guru/rpp') . "' class='btn'>Kembali ke Halaman RPP</a>";
    echo "<a href='http://localhost/nurani/public/guru/rpp' class='btn' style='margin-left: 10px;'>Buka Halaman RPP</a>";
    
    echo "</div></body></html>";
    
} catch (PDOException $e) {
    echo "<!DOCTYPE html>
<html lang='id'>
<head>
    <meta charset='UTF-8'>
    <title>Error - Buat Tabel RPP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .error {
            background: #f8d7da;
            color: #721c24;
            padding: 20px;
            border-radius: 5px;
            border-left: 4px solid #dc3545;
        }
    </style>
</head>
<body>
    <div class='error'>
        <h2>❌ Error Koneksi Database</h2>
        <p><strong>Pesan Error:</strong> " . htmlspecialchars($e->getMessage()) . "</p>
        <p><strong>Solusi:</strong></p>
        <ol>
            <li>Pastikan XAMPP MySQL sudah running (status hijau)</li>
            <li>Pastikan database <code>nurani</code> sudah ada</li>
            <li>Jika database belum ada, buat dulu di phpMyAdmin</li>
            <li>Atau gunakan metode manual dengan file <code>SQL_RPP_LANGSUNG.txt</code></li>
        </ol>
    </div>
</body>
</html>";
}
?>
