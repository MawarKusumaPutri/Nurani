<?php

/**
 * Script Pulihkan Database - Lengkap
 * Script ini akan:
 * 1. Fix tablespace error
 * 2. Drop dan create database
 * 3. Run migrations (membuat tabel)
 * 4. Run seeder (membuat data guru)
 * 5. Verifikasi hasil
 */

echo "========================================\n";
echo "  PULIHKAN DATABASE - LENGKAP\n";
echo "========================================\n\n";

// Konfigurasi
$dbHost = '127.0.0.1';
$dbPort = '3306';
$dbUser = 'root';
$dbPass = '';
$dbName = 'nurani';
$projectPath = __DIR__;

// Langkah 1: Cek koneksi MySQL
echo "[1/6] Memeriksa koneksi MySQL...\n";
try {
    $pdo = new PDO("mysql:host=$dbHost;port=$dbPort", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "[SUKSES] MySQL sudah berjalan!\n";
} catch (PDOException $e) {
    echo "[ERROR] MySQL belum berjalan!\n";
    echo "[INFO] Start MySQL di XAMPP Control Panel!\n";
    exit(1);
}

// Langkah 2: Coba DISCARD TABLESPACE jika database ada
echo "\n[2/6] Mencoba fix tablespace error...\n";
try {
    $stmt = $pdo->query("SHOW DATABASES LIKE '$dbName'");
    if ($stmt->rowCount() > 0) {
        try {
            $pdoDb = new PDO("mysql:host=$dbHost;port=$dbPort;dbname=$dbName", $dbUser, $dbPass);
            $pdoDb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Cek tabel migrations
            $tables = $pdoDb->query("SHOW TABLES LIKE 'migrations'");
            if ($tables->rowCount() > 0) {
                echo "[INFO] Mencoba DISCARD TABLESPACE...\n";
                try {
                    $pdoDb->exec("ALTER TABLE migrations DISCARD TABLESPACE");
                    echo "[SUKSES] DISCARD TABLESPACE berhasil!\n";
                } catch (PDOException $e) {
                    echo "[INFO] DISCARD TABLESPACE: " . $e->getMessage() . "\n";
                }
                
                // Drop tabel
                try {
                    $pdoDb->exec("DROP TABLE IF EXISTS migrations");
                    echo "[SUKSES] Tabel migrations dihapus!\n";
                } catch (PDOException $e) {
                    echo "[INFO] Drop tabel: " . $e->getMessage() . "\n";
                }
            }
            
            $pdoDb = null;
        } catch (PDOException $e) {
            echo "[INFO] Tidak bisa koneksi ke database: " . $e->getMessage() . "\n";
        }
    }
} catch (PDOException $e) {
    echo "[INFO] " . $e->getMessage() . "\n";
}

// Langkah 3: Drop database
echo "\n[3/6] Menghapus database lama...\n";
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

// Tunggu sebentar
sleep(1);

// Langkah 4: Create database baru
echo "\n[4/6] Membuat database baru...\n";
try {
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "[SUKSES] Database baru dibuat!\n";
} catch (PDOException $e) {
    if (strpos($e->getMessage(), "exists") !== false) {
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

// Langkah 5: Run migrations
echo "\n[5/6] Menjalankan migrations (membuat tabel)...\n";
$migrateCommand = "cd \"$projectPath\" && php artisan migrate --force";
$output = [];
$returnVar = 0;
exec($migrateCommand . ' 2>&1', $output, $returnVar);

if ($returnVar !== 0) {
    $outputStr = implode("\n", $output);
    if (strpos($outputStr, "Tablespace") !== false) {
        echo "[ERROR] Masih ada error tablespace!\n";
        echo "\n[SOLUSI MANUAL] Jalankan SQL berikut di phpMyAdmin:\n";
        echo "  1. Buka http://localhost/phpmyadmin\n";
        echo "  2. Tab SQL - Jalankan:\n";
        echo "     DROP DATABASE IF EXISTS nurani;\n";
        echo "     CREATE DATABASE nurani CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;\n";
        echo "  3. Setelah itu, jalankan script ini lagi\n";
        exit(1);
    }
    
    echo "[ERROR] Migrations gagal!\n";
    foreach ($output as $line) {
        if (trim($line) !== '') {
            echo "  $line\n";
        }
    }
    exit(1);
}

// Tampilkan output migrations
$migrationSuccess = false;
foreach ($output as $line) {
    if (trim($line) !== '') {
        echo "  $line\n";
        if (strpos($line, "DONE") !== false || strpos($line, "Migrated") !== false) {
            $migrationSuccess = true;
        }
    }
}

if ($migrationSuccess || strpos(implode("\n", $output), "Migrating") !== false) {
    echo "[SUKSES] Migrations selesai! Tabel sudah dibuat!\n";
} else {
    echo "[INFO] Migrations selesai (cek output di atas)\n";
}

// Langkah 6: Run seeder
echo "\n[6/6] Membuat data guru...\n";
$seedCommand = "cd \"$projectPath\" && php artisan db:seed --class=UserSeeder";
$output = [];
$returnVar = 0;
exec($seedCommand . ' 2>&1', $output, $returnVar);

if ($returnVar !== 0) {
    echo "[ERROR] Seeder gagal!\n";
    foreach ($output as $line) {
        if (trim($line) !== '') {
            echo "  $line\n";
        }
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
    
    // Cek tabel
    $tables = $pdoDb->query("SHOW TABLES");
    $tableCount = $tables->rowCount();
    echo "[SUKSES] Jumlah tabel: $tableCount\n";
    
    // Cek jumlah guru
    $stmt = $pdoDb->query("SELECT COUNT(*) as count FROM users WHERE role = 'guru'");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $count = $result['count'];
    
    echo "[SUKSES] Jumlah guru: $count\n";
    
    if ($count > 0) {
        echo "\n[INFO] Email guru yang bisa login:\n";
        $stmt = $pdoDb->query("SELECT email, name FROM users WHERE role = 'guru' ORDER BY name LIMIT 11");
        $no = 1;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "  $no. {$row['name']} - {$row['email']}\n";
            $no++;
        }
        echo "\n[INFO] Password default: password123\n";
    } else {
        echo "[WARNING] Belum ada data guru!\n";
    }
} catch (PDOException $e) {
    echo "[WARNING] Gagal verifikasi: " . $e->getMessage() . "\n";
    echo "[INFO] Tapi migrations dan seeder sudah berjalan\n";
}

echo "\n========================================\n";
echo "  SELESAI - DATABASE DIPULIHKAN!\n";
echo "========================================\n\n";
echo "[SUKSES] Database sudah dipulihkan!\n";
echo "[INFO] Tabel sudah dibuat\n";
echo "[INFO] Data guru sudah dibuat\n";
echo "[INFO] Test login di: http://localhost/nurani/public/\n";
echo "[INFO] Email: syifarestu81@gmail.com\n";
echo "[INFO] Password: password123\n\n";
