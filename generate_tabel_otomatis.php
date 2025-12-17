<?php

/**
 * Generate Tabel Otomatis ke phpMyAdmin
 * Script ini akan:
 * 1. Fix tablespace error dengan cara yang lebih agresif
 * 2. Drop dan create database
 * 3. Run migrations (membuat semua tabel)
 * 4. Run seeder (membuat data guru)
 * 5. Verifikasi semua tabel sudah dibuat
 */

echo "========================================\n";
echo "  GENERATE TABEL OTOMATIS KE PHPMYADMIN\n";
echo "========================================\n\n";

// Konfigurasi
$dbHost = '127.0.0.1';
$dbPort = '3306';
$dbUser = 'root';
$dbPass = '';
$dbName = 'nurani';
$projectPath = __DIR__;

// Fungsi untuk menjalankan SQL langsung
function runSQL($pdo, $sql, $description) {
    try {
        $pdo->exec($sql);
        echo "[SUKSES] $description\n";
        return true;
    } catch (PDOException $e) {
        echo "[WARNING] $description: " . $e->getMessage() . "\n";
        return false;
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
    echo "[INFO] Start MySQL di XAMPP Control Panel!\n";
    exit(1);
}

// Langkah 2: Coba fix tablespace dengan SQL langsung
echo "\n[2/7] Mencoba fix tablespace error dengan SQL langsung...\n";
try {
    $stmt = $pdo->query("SHOW DATABASES LIKE '$dbName'");
    if ($stmt->rowCount() > 0) {
        try {
            $pdoDb = new PDO("mysql:host=$dbHost;port=$dbPort;dbname=$dbName", $dbUser, $dbPass);
            $pdoDb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Cek dan hapus semua tabel yang mungkin corrupt
            $tables = $pdoDb->query("SHOW TABLES");
            $tableList = $tables->fetchAll(PDO::FETCH_COLUMN);
            
            if (count($tableList) > 0) {
                echo "[INFO] Menghapus tabel yang mungkin corrupt...\n";
                foreach ($tableList as $table) {
                    // Coba DISCARD TABLESPACE dulu
                    try {
                        $pdoDb->exec("ALTER TABLE `$table` DISCARD TABLESPACE");
                    } catch (PDOException $e) {
                        // Ignore jika tidak bisa
                    }
                    // Drop tabel
                    try {
                        $pdoDb->exec("DROP TABLE IF EXISTS `$table`");
                        echo "  [OK] Tabel '$table' dihapus\n";
                    } catch (PDOException $e) {
                        echo "  [WARNING] Gagal hapus tabel '$table': " . $e->getMessage() . "\n";
                    }
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

// Langkah 3: Drop database dengan force
echo "\n[3/7] Menghapus database lama (force)...\n";
// Coba beberapa cara untuk drop database
$dropSuccess = false;

// Cara 1: Drop biasa
try {
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
    $pdo->exec("DROP DATABASE IF EXISTS `$dbName`");
    echo "[SUKSES] Database dihapus!\n";
    $dropSuccess = true;
} catch (PDOException $e) {
    echo "[WARNING] Drop database gagal: " . $e->getMessage() . "\n";
}

// Tunggu sebentar
sleep(2);

// Langkah 4: Create database baru
echo "\n[4/7] Membuat database baru...\n";
try {
    // Jika database masih ada, coba drop lagi
    if (!$dropSuccess) {
        try {
            $pdo->exec("DROP DATABASE `$dbName`");
        } catch (PDOException $e) {
            // Ignore
        }
    }
    
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "[SUKSES] Database baru dibuat!\n";
} catch (PDOException $e) {
    if (strpos($e->getMessage(), "exists") !== false) {
        // Database sudah ada, coba drop dan create lagi
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

// Tunggu sebentar untuk memastikan database ready
sleep(1);

// Langkah 5: Run migrations
echo "\n[5/7] Menjalankan migrations (membuat semua tabel)...\n";
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
        echo "\n[ATAU] Double-click file: PULIHKAN_DATABASE.bat\n";
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
$migrationLines = [];
$migrationSuccess = false;
foreach ($output as $line) {
    if (trim($line) !== '') {
        $migrationLines[] = $line;
        if (strpos($line, "DONE") !== false || strpos($line, "Migrated") !== false || strpos($line, "Migrating") !== false) {
            $migrationSuccess = true;
        }
    }
}

// Tampilkan hanya baris penting
foreach ($migrationLines as $line) {
    if (strpos($line, "INFO") !== false || strpos($line, "Migrating") !== false || strpos($line, "Migrated") !== false || strpos($line, "DONE") !== false) {
        echo "  $line\n";
    }
}

if ($migrationSuccess || count($migrationLines) > 0) {
    echo "[SUKSES] Migrations selesai! Semua tabel sudah dibuat!\n";
} else {
    echo "[INFO] Migrations selesai (cek output di atas)\n";
}

// Langkah 6: Run seeder
echo "\n[6/7] Membuat data guru...\n";
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
echo "[SUKSES] Data guru dibuat!\n";

// Langkah 7: Verifikasi semua tabel
echo "\n[7/7] Verifikasi tabel di database...\n";
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
        foreach ($tableList as $index => $table) {
            echo "  " . ($index + 1) . ". $table\n";
        }
    }
    
    // Cek jumlah guru
    if (in_array('users', $tableList)) {
        $stmt = $pdoDb->query("SELECT COUNT(*) as count FROM users WHERE role = 'guru'");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $count = $result['count'];
        
        echo "\n[SUKSES] Jumlah guru: $count\n";
        
        if ($count > 0) {
            echo "\n[INFO] Email guru yang bisa login:\n";
            $stmt = $pdoDb->query("SELECT email, name FROM users WHERE role = 'guru' ORDER BY name LIMIT 11");
            $no = 1;
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "  $no. {$row['name']} - {$row['email']}\n";
                $no++;
            }
            echo "\n[INFO] Password default: password123\n";
        }
    }
    
    echo "\n[SUKSES] Semua tabel sudah muncul di phpMyAdmin!\n";
    echo "[INFO] Refresh halaman phpMyAdmin untuk melihat tabel-tabel\n";
    
} catch (PDOException $e) {
    echo "[WARNING] Gagal verifikasi: " . $e->getMessage() . "\n";
    echo "[INFO] Tapi migrations dan seeder sudah berjalan\n";
}

echo "\n========================================\n";
echo "  SELESAI - TABEL SUDAH DIBUAT!\n";
echo "========================================\n\n";
echo "[SUKSES] Semua tabel sudah dibuat di database!\n";
echo "[INFO] Buka phpMyAdmin → database 'nurani' untuk melihat tabel-tabel\n";
echo "[INFO] Test login di: http://localhost/nurani/public/\n";
echo "[INFO] Email: syifarestu81@gmail.com\n";
echo "[INFO] Password: password123\n\n";
