<?php

/**
 * Fix Tablespace Error dan Migrate Otomatis
 * Script ini akan:
 * 1. Coba DISCARD TABLESPACE untuk tabel migrations
 * 2. Hapus file tablespace secara langsung (jika bisa)
 * 3. Drop database
 * 4. Create database baru
 * 5. Run migrations
 * 6. Run seeder
 */

echo "========================================\n";
echo "  FIX TABLESPACE & MIGRASI OTOMATIS\n";
echo "========================================\n\n";

// Konfigurasi
$dbHost = '127.0.0.1';
$dbPort = '3306';
$dbUser = 'root';
$dbPass = '';
$dbName = 'nurani';
$projectPath = __DIR__;

// Cek path MySQL data directory
$mysqlDataPath = null;
$possiblePaths = [
    'C:\\xampp\\mysql\\data',
    'D:\\xampp\\mysql\\data',
    'C:\\Program Files\\xampp\\mysql\\data',
    'D:\\Program Files\\xampp\\mysql\\data',
];

foreach ($possiblePaths as $path) {
    if (is_dir($path)) {
        $mysqlDataPath = $path;
        break;
    }
}

// Langkah 1: Cek koneksi MySQL
echo "[1/7] Memeriksa koneksi MySQL...\n";
try {
    $pdo = new PDO("mysql:host=$dbHost;port=$dbPort", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "[SUKSES] MySQL sudah berjalan!\n";
} catch (PDOException $e) {
    echo "[ERROR] MySQL belum berjalan!\n";
    exit(1);
}

// Langkah 2: Coba DISCARD TABLESPACE jika database ada
echo "\n[2/7] Mencoba fix tablespace error...\n";
try {
    $stmt = $pdo->query("SHOW DATABASES LIKE '$dbName'");
    if ($stmt->rowCount() > 0) {
        try {
            $pdoDb = new PDO("mysql:host=$dbHost;port=$dbPort;dbname=$dbName", $dbUser, $dbPass);
            $pdoDb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Cek tabel migrations
            $tables = $pdoDb->query("SHOW TABLES LIKE 'migrations'");
            if ($tables->rowCount() > 0) {
                echo "[INFO] Mencoba DISCARD TABLESPACE untuk tabel migrations...\n";
                try {
                    $pdoDb->exec("ALTER TABLE migrations DISCARD TABLESPACE");
                    echo "[SUKSES] DISCARD TABLESPACE berhasil!\n";
                } catch (PDOException $e) {
                    echo "[WARNING] DISCARD TABLESPACE gagal: " . $e->getMessage() . "\n";
                }
                
                // Drop tabel
                try {
                    $pdoDb->exec("DROP TABLE IF EXISTS migrations");
                    echo "[SUKSES] Tabel migrations dihapus!\n";
                } catch (PDOException $e) {
                    echo "[WARNING] Drop tabel gagal: " . $e->getMessage() . "\n";
                }
            }
            
            $pdoDb = null;
        } catch (PDOException $e) {
            echo "[INFO] Tidak bisa koneksi ke database: " . $e->getMessage() . "\n";
        }
    } else {
        echo "[INFO] Database belum ada, lanjut...\n";
    }
} catch (PDOException $e) {
    echo "[INFO] " . $e->getMessage() . "\n";
}

// Langkah 3: Hapus file tablespace secara langsung (jika path diketahui)
echo "\n[3/7] Mencoba hapus file tablespace...\n";
if ($mysqlDataPath && is_dir($mysqlDataPath)) {
    $dbFolder = $mysqlDataPath . '\\' . $dbName;
    $migrationsFrm = $dbFolder . '\\migrations.frm';
    $migrationsIbd = $dbFolder . '\\migrations.ibd';
    
    if (file_exists($migrationsFrm)) {
        echo "[INFO] Menghapus file: migrations.frm\n";
        @unlink($migrationsFrm);
    }
    
    if (file_exists($migrationsIbd)) {
        echo "[INFO] Menghapus file: migrations.ibd\n";
        @unlink($migrationsIbd);
    }
    
    echo "[INFO] File tablespace dicek (jika ada, sudah dihapus)\n";
} else {
    echo "[INFO] Path MySQL data tidak ditemukan, skip hapus file\n";
    echo "[INFO] Path yang dicoba: " . implode(', ', $possiblePaths) . "\n";
}

// Langkah 4: Drop database
echo "\n[4/7] Menghapus database...\n";
try {
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
    $pdo->exec("DROP DATABASE IF EXISTS `$dbName`");
    echo "[SUKSES] Database dihapus!\n";
} catch (PDOException $e) {
    if (strpos($e->getMessage(), "Unknown database") === false) {
        echo "[WARNING] " . $e->getMessage() . "\n";
        echo "[INFO] Database mungkin sudah terhapus atau locked\n";
    } else {
        echo "[INFO] Database belum ada\n";
    }
}

// Tunggu sebentar untuk memastikan file system update
sleep(1);

// Langkah 5: Create database baru
echo "\n[5/7] Membuat database baru...\n";
try {
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "[SUKSES] Database baru dibuat!\n";
} catch (PDOException $e) {
    if (strpos($e->getMessage(), "exists") !== false) {
        // Coba drop dulu
        try {
            $pdo->exec("DROP DATABASE IF EXISTS `$dbName`");
            $pdo->exec("CREATE DATABASE `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            echo "[SUKSES] Database dibuat ulang!\n";
        } catch (PDOException $e2) {
            echo "[ERROR] Gagal membuat database: " . $e2->getMessage() . "\n";
            echo "[SOLUSI] Hapus manual di phpMyAdmin SQL:\n";
            echo "  DROP DATABASE IF EXISTS nurani;\n";
            echo "  CREATE DATABASE nurani CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;\n";
            exit(1);
        }
    } else {
        echo "[ERROR] Gagal membuat database: " . $e->getMessage() . "\n";
        exit(1);
    }
}

// Langkah 6: Run migrations
echo "\n[6/7] Menjalankan migrations...\n";
$migrateCommand = "cd \"$projectPath\" && php artisan migrate --force";
$output = [];
$returnVar = 0;
exec($migrateCommand . ' 2>&1', $output, $returnVar);

if ($returnVar !== 0) {
    // Cek apakah masih error tablespace
    $outputStr = implode("\n", $output);
    if (strpos($outputStr, "Tablespace") !== false) {
        echo "[ERROR] Masih ada error tablespace!\n";
        echo "[SOLUSI] Jalankan SQL berikut di phpMyAdmin:\n";
        echo "  1. Buka http://localhost/phpmyadmin\n";
        echo "  2. Tab SQL - Jalankan:\n";
        echo "     DROP DATABASE IF EXISTS nurani;\n";
        echo "     CREATE DATABASE nurani CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;\n";
        echo "  3. Setelah itu, jalankan script ini lagi\n";
        exit(1);
    }
    
    echo "[ERROR] Migrations gagal!\n";
    foreach ($output as $line) {
        echo "  $line\n";
    }
    exit(1);
}

foreach ($output as $line) {
    if (trim($line) !== '') {
        echo "  $line\n";
    }
}
echo "[SUKSES] Migrations selesai!\n";

// Langkah 7: Run seeder
echo "\n[7/7] Membuat data guru...\n";
$seedCommand = "cd \"$projectPath\" && php artisan db:seed --class=UserSeeder";
$output = [];
$returnVar = 0;
exec($seedCommand . ' 2>&1', $output, $returnVar);

if ($returnVar !== 0) {
    echo "[ERROR] Seeder gagal!\n";
    foreach ($output as $line) {
        echo "  $line\n";
    }
    exit(1);
}

foreach ($output as $line) {
    if (trim($line) !== '') {
        echo "  $line\n";
    }
}
echo "[SUKSES] Data guru dibuat!\n";

// Verifikasi
echo "\n========================================\n";
echo "  VERIFIKASI DATA\n";
echo "========================================\n";
try {
    $pdoDb = new PDO("mysql:host=$dbHost;port=$dbPort;dbname=$dbName", $dbUser, $dbPass);
    $pdoDb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $stmt = $pdoDb->query("SELECT COUNT(*) as count FROM users WHERE role = 'guru'");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $count = $result['count'];
    
    echo "[SUKSES] Jumlah guru: $count\n";
    
    if ($count > 0) {
        echo "\n[INFO] Email guru yang bisa login:\n";
        $stmt = $pdoDb->query("SELECT email, name FROM users WHERE role = 'guru' ORDER BY name LIMIT 5");
        $no = 1;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "  $no. {$row['name']} - {$row['email']}\n";
            $no++;
        }
        if ($count > 5) {
            echo "  ... dan " . ($count - 5) . " guru lainnya\n";
        }
        echo "\n[INFO] Password default: password123\n";
    }
} catch (PDOException $e) {
    echo "[WARNING] Gagal verifikasi: " . $e->getMessage() . "\n";
}

echo "\n========================================\n";
echo "  SELESAI!\n";
echo "========================================\n\n";
echo "[SUKSES] Migrasi otomatis selesai!\n";
echo "[INFO] Test login di: http://localhost/nurani/public/\n";
echo "[INFO] Email: syifarestu81@gmail.com\n";
echo "[INFO] Password: password123\n\n";
