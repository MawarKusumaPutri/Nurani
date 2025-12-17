<?php

/**
 * Script Migrasi Otomatis - Mengurangi Error
 * Script ini akan:
 * 1. Drop database jika ada (dengan error handling)
 * 2. Create database baru
 * 3. Run migrations
 * 4. Run seeder untuk data guru
 * 5. Cek hasil
 */

echo "========================================\n";
echo "  MIGRASI OTOMATIS - MENGURANGI ERROR\n";
echo "========================================\n\n";

// Konfigurasi
$dbHost = '127.0.0.1';
$dbPort = '3306';
$dbUser = 'root';
$dbPass = '';
$dbName = 'nurani';
$projectPath = __DIR__;

// Fungsi untuk menjalankan command
function runCommand($command, $description) {
    echo "[INFO] $description...\n";
    $output = [];
    $returnVar = 0;
    exec($command . ' 2>&1', $output, $returnVar);
    
    if ($returnVar !== 0) {
        echo "[ERROR] Gagal: $description\n";
        foreach ($output as $line) {
            echo "  $line\n";
        }
        return false;
    }
    
    foreach ($output as $line) {
        if (trim($line) !== '') {
            echo "  $line\n";
        }
    }
    return true;
}

// Langkah 1: Cek koneksi MySQL
echo "\n[1/6] Memeriksa koneksi MySQL...\n";
try {
    $pdo = new PDO("mysql:host=$dbHost;port=$dbPort", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "[SUKSES] MySQL sudah berjalan!\n";
} catch (PDOException $e) {
    echo "[ERROR] MySQL belum berjalan atau koneksi gagal!\n";
    echo "[INFO] Pastikan MySQL sudah start di XAMPP Control Panel!\n";
    echo "[ERROR DETAIL] " . $e->getMessage() . "\n";
    exit(1);
}

// Langkah 2: Drop database jika ada (dengan handle tablespace error)
echo "\n[2/6] Menghapus database lama (jika ada)...\n";
try {
    // Cek apakah database ada
    $stmt = $pdo->query("SHOW DATABASES LIKE '$dbName'");
    if ($stmt->rowCount() > 0) {
        // Coba koneksi ke database untuk DISCARD TABLESPACE
        try {
            $pdoDb = new PDO("mysql:host=$dbHost;port=$dbPort;dbname=$dbName", $dbUser, $dbPass);
            $pdoDb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Cek apakah tabel migrations ada dan DISCARD TABLESPACE
            $tables = $pdoDb->query("SHOW TABLES LIKE 'migrations'");
            if ($tables->rowCount() > 0) {
                echo "[INFO] Menghapus tabel migrations yang corrupt...\n";
                try {
                    $pdoDb->exec("DROP TABLE IF EXISTS migrations");
                    echo "[SUKSES] Tabel migrations dihapus!\n";
                } catch (PDOException $e2) {
                    // Jika masih error, coba DISCARD TABLESPACE dulu
                    if (strpos($e2->getMessage(), "Tablespace") !== false) {
                        echo "[INFO] Mencoba DISCARD TABLESPACE...\n";
                        try {
                            $pdoDb->exec("ALTER TABLE migrations DISCARD TABLESPACE");
                            $pdoDb->exec("DROP TABLE IF EXISTS migrations");
                            echo "[SUKSES] Tabel migrations dihapus setelah DISCARD TABLESPACE!\n";
                        } catch (PDOException $e3) {
                            echo "[WARNING] Gagal DISCARD TABLESPACE: " . $e3->getMessage() . "\n";
                        }
                    }
                }
            }
            
            // Tutup semua koneksi
            $pdoDb = null;
        } catch (PDOException $e) {
            // Jika tidak bisa koneksi ke database, lanjut drop database
            echo "[INFO] Tidak bisa koneksi ke database, lanjut drop database...\n";
        }
        
        // Tutup semua koneksi ke database ini dulu
        $pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
        
        // Drop database
        $pdo->exec("DROP DATABASE IF EXISTS `$dbName`");
        echo "[SUKSES] Database lama dihapus!\n";
    } else {
        echo "[INFO] Database belum ada, lanjut ke langkah berikutnya.\n";
    }
} catch (PDOException $e) {
    // Jika error karena database tidak ada, itu OK
    if (strpos($e->getMessage(), "Unknown database") === false) {
        echo "[WARNING] " . $e->getMessage() . "\n";
        echo "[INFO] Mencoba hapus manual via SQL...\n";
        // Coba hapus via SQL langsung
        try {
            $pdo->exec("DROP DATABASE IF EXISTS `$dbName`");
            echo "[SUKSES] Database dihapus via SQL langsung!\n";
        } catch (PDOException $e2) {
            echo "[INFO] Database mungkin sudah terhapus atau locked.\n";
            echo "[INFO] Jika masih error, hapus manual di phpMyAdmin:\n";
            echo "  1. Buka http://localhost/phpmyadmin\n";
            echo "  2. Tab SQL - Jalankan: DROP DATABASE IF EXISTS nurani;\n";
        }
    } else {
        echo "[INFO] Database belum ada, lanjut ke langkah berikutnya.\n";
    }
}

// Langkah 3: Create database baru
echo "\n[3/6] Membuat database baru...\n";
try {
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "[SUKSES] Database baru dibuat!\n";
} catch (PDOException $e) {
    // Jika error karena database sudah ada, coba drop dulu
    if (strpos($e->getMessage(), "exists") !== false) {
        echo "[INFO] Database sudah ada, mencoba hapus dulu...\n";
        try {
            $pdo->exec("DROP DATABASE IF EXISTS `$dbName`");
            $pdo->exec("CREATE DATABASE `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            echo "[SUKSES] Database dibuat ulang!\n";
        } catch (PDOException $e2) {
            echo "[ERROR] Gagal membuat database: " . $e2->getMessage() . "\n";
            echo "[INFO] Coba hapus manual di phpMyAdmin:\n";
            echo "  1. Buka http://localhost/phpmyadmin\n";
            echo "  2. Tab SQL - Jalankan: DROP DATABASE IF EXISTS nurani; CREATE DATABASE nurani...\n";
            exit(1);
        }
    } else {
        echo "[ERROR] Gagal membuat database: " . $e->getMessage() . "\n";
        exit(1);
    }
}

// Langkah 4: Run migrations (dengan retry jika ada tablespace error)
echo "\n[4/6] Menjalankan migrations...\n";
$migrateCommand = "cd \"$projectPath\" && php artisan migrate --force";
$migrateSuccess = runCommand($migrateCommand, "Running migrations");

// Jika gagal karena tablespace error, coba fix dulu
if (!$migrateSuccess) {
    echo "\n[INFO] Migrations gagal, mencoba fix tablespace error...\n";
    try {
        $pdoDb = new PDO("mysql:host=$dbHost;port=$dbPort;dbname=$dbName", $dbUser, $dbPass);
        $pdoDb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Cek apakah tabel migrations ada
        $tables = $pdoDb->query("SHOW TABLES LIKE 'migrations'");
        if ($tables->rowCount() > 0) {
            echo "[INFO] Menghapus tabel migrations yang corrupt...\n";
            try {
                $pdoDb->exec("ALTER TABLE migrations DISCARD TABLESPACE");
            } catch (PDOException $e) {
                // Ignore jika sudah tidak ada
            }
            $pdoDb->exec("DROP TABLE IF EXISTS migrations");
            echo "[SUKSES] Tabel migrations dihapus!\n";
        }
        
        $pdoDb = null;
        
        // Coba migrations lagi
        echo "[INFO] Mencoba migrations lagi...\n";
        $migrateSuccess = runCommand($migrateCommand, "Running migrations (retry)");
    } catch (PDOException $e) {
        echo "[WARNING] Gagal fix tablespace: " . $e->getMessage() . "\n";
    }
}

if (!$migrateSuccess) {
    echo "\n[ERROR] Migrations masih gagal setelah retry!\n";
    echo "[INFO] Cek error di atas untuk detail\n";
    echo "[SOLUSI MANUAL] Hapus database manual di phpMyAdmin:\n";
    echo "  1. Buka http://localhost/phpmyadmin\n";
    echo "  2. Tab SQL - Jalankan: DROP DATABASE IF EXISTS nurani; CREATE DATABASE nurani...\n";
    echo "  3. Jalankan script ini lagi\n";
    exit(1);
}
echo "[SUKSES] Migrations selesai!\n";

// Langkah 5: Run seeder
echo "\n[5/6] Membuat data guru...\n";
$seedCommand = "cd \"$projectPath\" && php artisan db:seed --class=UserSeeder";
if (!runCommand($seedCommand, "Running seeder")) {
    echo "\n[ERROR] Seeder gagal!\n";
    echo "[INFO] Cek error di atas untuk detail\n";
    exit(1);
}
echo "[SUKSES] Data guru dibuat!\n";

// Langkah 6: Verifikasi data
echo "\n[6/6] Memverifikasi data guru...\n";
try {
    $pdo = new PDO("mysql:host=$dbHost;port=$dbPort;dbname=$dbName", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Cek jumlah guru
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM users WHERE role = 'guru'");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $count = $result['count'];
    
    echo "[SUKSES] Jumlah guru di database: $count\n";
    
    if ($count > 0) {
        echo "\n[INFO] Email guru yang bisa login:\n";
        $stmt = $pdo->query("SELECT email, name FROM users WHERE role = 'guru' ORDER BY name");
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
    echo "[INFO] Tapi migrations dan seeder sudah berjalan, cek manual di phpMyAdmin\n";
}

// Selesai
echo "\n========================================\n";
echo "  SELESAI!\n";
echo "========================================\n\n";
echo "[SUKSES] Migrasi otomatis selesai!\n";
echo "[INFO] Test login di: http://localhost/nurani/public/\n";
echo "[INFO] Email guru: syifarestu81@gmail.com\n";
echo "[INFO] Password: password123\n\n";
