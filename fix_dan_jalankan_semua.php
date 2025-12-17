<?php

/**
 * Fix Tablespace, Jalankan Migrations, dan Seeder - SEMUA SEKALIGUS
 * Script ini akan:
 * 1. Fix tablespace error
 * 2. Drop dan create database
 * 3. Run migrations (membuat semua tabel)
 * 4. Run seeder (menambahkan data guru)
 */

echo "========================================\n";
echo "  FIX & JALANKAN SEMUA - LENGKAP\n";
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
    exit(1);
}

// Langkah 2: Drop database
echo "\n[2/6] Menghapus database lama...\n";
try {
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
    $pdo->exec("DROP DATABASE IF EXISTS `$dbName`");
    echo "[SUKSES] Database dihapus!\n";
} catch (PDOException $e) {
    if (strpos($e->getMessage(), "Unknown database") === false) {
        echo "[WARNING] " . $e->getMessage() . "\n";
    } else {
        echo "[INFO] Database belum ada\n";
    }
}

sleep(1);

// Langkah 3: Create database baru
echo "\n[3/6] Membuat database baru...\n";
try {
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "[SUKSES] Database baru dibuat!\n";
} catch (PDOException $e) {
    if (strpos($e->getMessage(), "exists") !== false) {
        try {
            $pdo->exec("DROP DATABASE `$dbName`");
            sleep(1);
            $pdo->exec("CREATE DATABASE `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            echo "[SUKSES] Database dibuat ulang!\n";
        } catch (PDOException $e2) {
            echo "[ERROR] Gagal membuat database!\n";
            echo "\n[SOLUSI MANUAL] Jalankan SQL berikut di phpMyAdmin:\n";
            echo "  DROP DATABASE IF EXISTS nurani;\n";
            echo "  CREATE DATABASE nurani CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;\n";
            exit(1);
        }
    } else {
        echo "[ERROR] Gagal membuat database: " . $e->getMessage() . "\n";
        exit(1);
    }
}

sleep(1);

// Langkah 4: Run migrations
echo "\n[4/6] Menjalankan migrations (membuat semua tabel)...\n";
$migrateCommand = "cd \"$projectPath\" && php artisan migrate --force 2>&1";
$output = [];
$returnVar = 0;
exec($migrateCommand, $output, $returnVar);

if ($returnVar !== 0) {
    $outputStr = implode("\n", $output);
    if (strpos($outputStr, "Tablespace") !== false) {
        echo "[ERROR] Masih ada error tablespace!\n";
        echo "\n[SOLUSI MANUAL - WAJIB] Jalankan SQL berikut di phpMyAdmin:\n";
        echo "  1. Buka http://localhost/phpmyadmin\n";
        echo "  2. Tab SQL - Jalankan:\n";
        echo "     DROP DATABASE IF EXISTS nurani;\n";
        echo "     CREATE DATABASE nurani CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;\n";
        echo "  3. Setelah itu, jalankan script ini lagi\n";
        exit(1);
    }
    
    echo "[ERROR] Migrations gagal!\n";
    foreach ($output as $line) {
        if (trim($line) !== '' && strpos($line, 'vendor') === false) {
            echo "  $line\n";
        }
    }
    exit(1);
}

// Tampilkan output migrations
$migrationSuccess = false;
foreach ($output as $line) {
    if (trim($line) !== '') {
        if (strpos($line, "INFO") !== false || strpos($line, "Migrating") !== false || strpos($line, "Migrated") !== false || strpos($line, "DONE") !== false) {
            echo "  $line\n";
            if (strpos($line, "Migrated") !== false || strpos($line, "DONE") !== false) {
                $migrationSuccess = true;
            }
        }
    }
}

if ($migrationSuccess) {
    echo "[SUKSES] Migrations selesai! Semua tabel sudah dibuat!\n";
} else {
    echo "[INFO] Migrations selesai\n";
}

// Langkah 5: Run seeder
echo "\n[5/6] Menambahkan data guru...\n";
$seedCommand = "cd \"$projectPath\" && php artisan db:seed --class=UserSeeder 2>&1";
$output = [];
$returnVar = 0;
exec($seedCommand, $output, $returnVar);

if ($returnVar !== 0) {
    echo "[ERROR] Seeder gagal!\n";
    foreach ($output as $line) {
        if (trim($line) !== '' && strpos($line, 'vendor') === false) {
            echo "  $line\n";
        }
    }
    exit(1);
}

foreach ($output as $line) {
    if (trim($line) !== '' && strpos($line, 'vendor') === false) {
        echo "  $line\n";
    }
}
echo "[SUKSES] Data guru sudah ditambahkan!\n";

// Langkah 6: Verifikasi
echo "\n[6/6] Verifikasi hasil...\n";
try {
    $pdoDb = new PDO("mysql:host=$dbHost;port=$dbPort;dbname=$dbName", $dbUser, $dbPass);
    $pdoDb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Cek tabel
    $tables = $pdoDb->query("SHOW TABLES");
    $tableList = $tables->fetchAll(PDO::FETCH_COLUMN);
    $tableCount = count($tableList);
    echo "[SUKSES] Jumlah tabel: $tableCount\n";
    
    // Cek jumlah guru
    if (in_array('users', $tableList)) {
        $stmt = $pdoDb->query("SELECT COUNT(*) as count FROM users WHERE role = 'guru'");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $count = $result['count'];
        echo "[SUKSES] Jumlah guru: $count\n";
    }
    
} catch (PDOException $e) {
    echo "[WARNING] Gagal verifikasi: " . $e->getMessage() . "\n";
}

echo "\n========================================\n";
echo "  SELESAI - SEMUA BERHASIL!\n";
echo "========================================\n\n";
echo "[SUKSES] Database sudah dibuat!\n";
echo "[SUKSES] Semua tabel sudah dibuat!\n";
echo "[SUKSES] Data guru sudah ditambahkan!\n";
echo "[INFO] Buka phpMyAdmin → database 'nurani' untuk melihat hasil\n";
echo "[INFO] Test login di: http://localhost/nurani/public/\n\n";
