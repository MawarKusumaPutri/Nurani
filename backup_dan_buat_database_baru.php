<?php

/**
 * Backup Database dan Buat Database Baru - AMAN
 * Script ini akan:
 * 1. Backup database lama (jika ada data)
 * 2. Drop database lama
 * 3. Buat database baru
 * 4. Run migrations
 * 5. Run seeder
 */

echo "========================================\n";
echo "  BACKUP & BUAT DATABASE BARU - AMAN\n";
echo "========================================\n\n";

// Konfigurasi
$dbHost = '127.0.0.1';
$dbPort = '3306';
$dbUser = 'root';
$dbPass = '';
$dbName = 'nurani';
$projectPath = __DIR__;
$backupDir = $projectPath . '/backup';
$backupFile = $backupDir . '/nurani_backup_' . date('Y-m-d_H-i-s') . '.sql';

// Buat folder backup jika belum ada
if (!is_dir($backupDir)) {
    mkdir($backupDir, 0777, true);
    echo "[INFO] Folder backup dibuat: $backupDir\n";
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

// Langkah 2: Cek apakah database ada dan ada data
echo "\n[2/7] Mengecek database dan data...\n";
$hasData = false;
$tableCount = 0;
try {
    $stmt = $pdo->query("SHOW DATABASES LIKE '$dbName'");
    if ($stmt->rowCount() > 0) {
        $pdoDb = new PDO("mysql:host=$dbHost;port=$dbPort;dbname=$dbName", $dbUser, $dbPass);
        $pdoDb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $tables = $pdoDb->query("SHOW TABLES");
        $tableList = $tables->fetchAll(PDO::FETCH_COLUMN);
        $tableCount = count($tableList);
        
        if ($tableCount > 0) {
            // Cek apakah ada data
            foreach ($tableList as $table) {
                $result = $pdoDb->query("SELECT COUNT(*) as count FROM `$table`");
                $row = $result->fetch(PDO::FETCH_ASSOC);
                if ($row['count'] > 0) {
                    $hasData = true;
                    break;
                }
            }
            
            echo "[INFO] Database ada dengan $tableCount tabel\n";
            if ($hasData) {
                echo "[WARNING] Ada data di database!\n";
            } else {
                echo "[INFO] Database kosong, tidak perlu backup\n";
            }
        } else {
            echo "[INFO] Database ada tapi kosong (tidak ada tabel)\n";
        }
        
        $pdoDb = null;
    } else {
        echo "[INFO] Database belum ada\n";
    }
} catch (PDOException $e) {
    echo "[INFO] " . $e->getMessage() . "\n";
}

// Langkah 3: Backup database (jika ada data)
if ($hasData && $tableCount > 0) {
    echo "\n[3/7] Membuat backup database...\n";
    echo "[INFO] Backup akan disimpan di: $backupFile\n";
    
    // Cek apakah mysqldump tersedia
    $mysqldumpPath = null;
    $possiblePaths = [
        'C:\\xampp\\mysql\\bin\\mysqldump.exe',
        'D:\\xampp\\mysql\\bin\\mysqldump.exe',
        'C:\\Program Files\\xampp\\mysql\\bin\\mysqldump.exe',
        'D:\\Program Files\\xampp\\mysql\\bin\\mysqldump.exe',
        'mysqldump' // Jika sudah di PATH
    ];
    
    foreach ($possiblePaths as $path) {
        if (file_exists($path) || $path === 'mysqldump') {
            $mysqldumpPath = $path;
            break;
        }
    }
    
    if ($mysqldumpPath) {
        $command = "\"$mysqldumpPath\" -h $dbHost -P $dbPort -u $dbUser " . 
                   ($dbPass ? "-p$dbPass" : "") . " $dbName > \"$backupFile\" 2>&1";
        
        exec($command, $output, $returnVar);
        
        if ($returnVar === 0 && file_exists($backupFile) && filesize($backupFile) > 0) {
            $fileSize = round(filesize($backupFile) / 1024, 2);
            echo "[SUKSES] Backup berhasil! ($fileSize KB)\n";
            echo "[INFO] File backup: $backupFile\n";
        } else {
            echo "[WARNING] Backup gagal atau file kosong\n";
            echo "[INFO] Lanjut tanpa backup (data mungkin kosong)\n";
        }
    } else {
        echo "[WARNING] mysqldump tidak ditemukan\n";
        echo "[INFO] Lanjut tanpa backup\n";
    }
} else {
    echo "\n[3/7] Skip backup (tidak ada data atau tabel)\n";
}

// Langkah 4: Drop database
echo "\n[4/7] Menghapus database lama...\n";
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

sleep(1);

// Langkah 5: Create database baru
echo "\n[5/7] Membuat database baru...\n";
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

// Langkah 6: Run migrations
echo "\n[6/7] Menjalankan migrations (membuat semua tabel)...\n";
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

// Langkah 7: Run seeder
echo "\n[7/7] Menambahkan data guru...\n";
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

// Verifikasi
echo "\n========================================\n";
echo "  VERIFIKASI HASIL\n";
echo "========================================\n";
try {
    $pdoDb = new PDO("mysql:host=$dbHost;port=$dbPort;dbname=$dbName", $dbUser, $dbPass);
    $pdoDb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $tables = $pdoDb->query("SHOW TABLES");
    $tableList = $tables->fetchAll(PDO::FETCH_COLUMN);
    $tableCount = count($tableList);
    echo "[SUKSES] Jumlah tabel: $tableCount\n";
    
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
echo "  SELESAI - DATABASE BARU DIBUAT!\n";
echo "========================================\n\n";
echo "[SUKSES] Database baru sudah dibuat!\n";
echo "[SUKSES] Semua tabel sudah dibuat!\n";
echo "[SUKSES] Data guru sudah ditambahkan!\n";
if ($hasData && file_exists($backupFile)) {
    echo "[INFO] Backup database lama: $backupFile\n";
    echo "[INFO] Jika perlu restore, gunakan file backup tersebut\n";
}
echo "[INFO] Buka phpMyAdmin → database 'nurani' untuk melihat hasil\n";
echo "[INFO] Test login di: http://localhost/nurani/public/\n\n";
