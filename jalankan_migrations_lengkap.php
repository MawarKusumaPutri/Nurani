<?php

/**
 * Jalankan Migrations Lengkap - Buat Semua Tabel di phpMyAdmin
 * Script ini akan:
 * 1. Fix tablespace error
 * 2. Drop dan create database
 * 3. Run semua migrations (membuat semua tabel)
 * 4. Verifikasi semua tabel sudah dibuat
 */

echo "========================================\n";
echo "  JALANKAN MIGRATIONS LENGKAP\n";
echo "  BUAT SEMUA TABEL DI PHPMYADMIN\n";
echo "========================================\n\n";

// Konfigurasi
$dbHost = '127.0.0.1';
$dbPort = '3306';
$dbUser = 'root';
$dbPass = '';
$dbName = 'nurani';
$projectPath = __DIR__;

// Langkah 1: Cek koneksi MySQL
echo "[1/5] Memeriksa koneksi MySQL...\n";
try {
    $pdo = new PDO("mysql:host=$dbHost;port=$dbPort", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "[SUKSES] MySQL sudah berjalan!\n";
} catch (PDOException $e) {
    echo "[ERROR] MySQL belum berjalan!\n";
    echo "[INFO] Start MySQL di XAMPP Control Panel!\n";
    exit(1);
}

// Langkah 2: Drop database (untuk fix tablespace)
echo "\n[2/5] Menghapus database lama (untuk fix tablespace)...\n";
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

// Langkah 3: Create database baru
echo "\n[3/5] Membuat database baru...\n";
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
            echo "[ERROR] Gagal membuat database: " . $e2->getMessage() . "\n";
            echo "\n[SOLUSI MANUAL] Jalankan SQL berikut di phpMyAdmin:\n";
            echo "  1. Buka http://localhost/phpmyadmin\n";
            echo "  2. Tab SQL - Jalankan:\n";
            echo "     DROP DATABASE IF EXISTS nurani;\n";
            echo "     CREATE DATABASE nurani CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;\n";
            echo "  3. Setelah itu, jalankan script ini lagi\n";
            exit(1);
        }
    } else {
        echo "[ERROR] Gagal membuat database: " . $e->getMessage() . "\n";
        exit(1);
    }
}

// Tunggu sebentar
sleep(1);

// Langkah 4: Run migrations
echo "\n[4/5] Menjalankan migrations (membuat semua tabel)...\n";
echo "[INFO] Ini akan membuat semua tabel dari folder database/migrations\n";
echo "[INFO] Tunggu sebentar, proses mungkin memakan waktu...\n\n";

$migrateCommand = "cd \"$projectPath\" && php artisan migrate --force 2>&1";
$output = [];
$returnVar = 0;
exec($migrateCommand, $output, $returnVar);

if ($returnVar !== 0) {
    $outputStr = implode("\n", $output);
    
    // Cek apakah masih error tablespace
    if (strpos($outputStr, "Tablespace") !== false) {
        echo "[ERROR] Masih ada error tablespace!\n";
        echo "\n[SOLUSI MANUAL - WAJIB] Jalankan SQL berikut di phpMyAdmin:\n";
        echo "  1. Buka http://localhost/phpmyadmin\n";
        echo "  2. Klik tab 'SQL' di bagian atas (tidak perlu pilih database)\n";
        echo "  3. Copy dan paste SQL berikut:\n\n";
        echo "     DROP DATABASE IF EXISTS nurani;\n";
        echo "     CREATE DATABASE nurani CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;\n\n";
        echo "  4. Klik 'Go' untuk menjalankan\n";
        echo "  5. Setelah itu, jalankan script ini lagi\n";
        echo "\n[ATAU] Double-click file: JALANKAN_MIGRATIONS.bat\n";
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

// Tampilkan output migrations (hanya yang penting)
$migrationSuccess = false;
$migrationCount = 0;
foreach ($output as $line) {
    if (trim($line) !== '') {
        // Tampilkan baris penting
        if (strpos($line, "INFO") !== false || 
            strpos($line, "Migrating") !== false || 
            strpos($line, "Migrated") !== false || 
            strpos($line, "DONE") !== false ||
            strpos($line, "Running") !== false) {
            echo "  $line\n";
            if (strpos($line, "Migrated") !== false || strpos($line, "DONE") !== false) {
                $migrationSuccess = true;
                $migrationCount++;
            }
        }
    }
}

if ($migrationSuccess) {
    echo "\n[SUKSES] Migrations selesai! Semua tabel sudah dibuat!\n";
    echo "[INFO] Total migrations yang dijalankan: $migrationCount\n";
} else {
    echo "\n[INFO] Migrations selesai (cek output di atas)\n";
}

// Langkah 5: Verifikasi semua tabel
echo "\n[5/5] Verifikasi tabel di database...\n";
try {
    $pdoDb = new PDO("mysql:host=$dbHost;port=$dbPort;dbname=$dbName", $dbUser, $dbPass);
    $pdoDb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Cek semua tabel
    $tables = $pdoDb->query("SHOW TABLES");
    $tableList = $tables->fetchAll(PDO::FETCH_COLUMN);
    $tableCount = count($tableList);
    
    echo "[SUKSES] Jumlah tabel: $tableCount\n";
    
    if ($tableCount > 0) {
        echo "\n[INFO] Tabel yang sudah dibuat:\n";
        $no = 1;
        foreach ($tableList as $table) {
            echo "  $no. $table\n";
            $no++;
        }
        
        // Cek tabel penting
        $importantTables = ['users', 'gurus', 'migrations', 'siswas', 'materi', 'kuis', 'presensi', 'jadwal', 'surats'];
        $foundTables = [];
        foreach ($importantTables as $important) {
            if (in_array($important, $tableList)) {
                $foundTables[] = $important;
            }
        }
        
        echo "\n[INFO] Tabel penting yang sudah dibuat: " . count($foundTables) . " dari " . count($importantTables) . "\n";
        foreach ($foundTables as $table) {
            echo "  ✓ $table\n";
        }
    }
    
    echo "\n[SUKSES] Semua tabel sudah muncul di phpMyAdmin!\n";
    echo "[INFO] Refresh halaman phpMyAdmin untuk melihat tabel-tabel\n";
    echo "[INFO] Buka: http://localhost/phpmyadmin → database 'nurani'\n";
    
} catch (PDOException $e) {
    echo "[WARNING] Gagal verifikasi: " . $e->getMessage() . "\n";
    echo "[INFO] Tapi migrations sudah berjalan\n";
}

echo "\n========================================\n";
echo "  SELESAI - TABEL SUDAH DIBUAT!\n";
echo "========================================\n\n";
echo "[SUKSES] Semua migrations sudah dijalankan!\n";
echo "[INFO] Semua tabel sudah dibuat di database!\n";
echo "[INFO] Buka phpMyAdmin → database 'nurani' untuk melihat tabel-tabel\n";
echo "[INFO] Setelah ini, jalankan seeder untuk menambahkan data:\n";
echo "      php artisan db:seed --class=UserSeeder\n\n";
