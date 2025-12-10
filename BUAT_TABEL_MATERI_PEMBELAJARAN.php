<?php
/**
 * Script untuk membuat tabel Materi Pembelajaran - LANGSUNG JALANKAN
 * Akses: http://localhost/nurani/public/BUAT_TABEL_MATERI_PEMBELAJARAN.php
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
    
    // Cek apakah tabel sudah ada
    $check = $pdo->query("SHOW TABLES LIKE 'materi_pembelajaran'");
    if ($check->rowCount() > 0) {
        $message = 'SUCCESS: Tabel materi_pembelajaran sudah ada';
        $status = 'success';
    } else {
        // Buat tabel
        $sql = "CREATE TABLE `materi_pembelajaran` (
          `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
          `guru_id` bigint(20) UNSIGNED NOT NULL,
          `mata_pelajaran` varchar(255) NOT NULL,
          `identitas_mata_pelajaran` text DEFAULT NULL,
          `profil_sejarah` text DEFAULT NULL,
          `relevansi` text DEFAULT NULL,
          `created_at` timestamp NULL DEFAULT NULL,
          `updated_at` timestamp NULL DEFAULT NULL,
          PRIMARY KEY (`id`),
          UNIQUE KEY `materi_pembelajaran_guru_id_mata_pelajaran_unique` (`guru_id`, `mata_pelajaran`),
          KEY `materi_pembelajaran_guru_id_foreign` (`guru_id`),
          CONSTRAINT `materi_pembelajaran_guru_id_foreign` FOREIGN KEY (`guru_id`) REFERENCES `gurus` (`id`) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        
        $pdo->exec($sql);
        $message = 'SUCCESS: Tabel materi_pembelajaran berhasil dibuat';
        $status = 'success';
    }
    
    // Redirect setelah 2 detik
    header("Refresh: 2; url=http://localhost/nurani/public/guru/dashboard?created=1");
    
} catch (PDOException $e) {
    $message = 'ERROR: ' . $e->getMessage();
    $status = 'error';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Membuat Tabel Materi Pembelajaran...</title>
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
            max-width: 600px;
            width: 100%;
            text-align: center;
        }
        .success-icon { font-size: 60px; margin-bottom: 20px; }
        .result {
            padding: 15px;
            margin: 20px 0;
            border-radius: 8px;
            background: <?php echo $status === 'success' ? '#d4edda' : '#f8d7da'; ?>;
            color: <?php echo $status === 'success' ? '#155724' : '#721c24'; ?>;
            border-left: 5px solid <?php echo $status === 'success' ? '#28a745' : '#dc3545'; ?>;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="success-icon"><?php echo $status === 'success' ? '✅' : '❌'; ?></div>
        <h1>Membuat Tabel Materi Pembelajaran</h1>
        <div class="result">
            <strong><?php echo htmlspecialchars($message); ?></strong>
        </div>
        <p class="text-muted">
            <?php if($status === 'success'): ?>
                Mengarahkan ke Dashboard dalam 2 detik...
            <?php else: ?>
                Silakan periksa error di atas dan coba lagi.
            <?php endif; ?>
        </p>
    </div>
</body>
</html>
