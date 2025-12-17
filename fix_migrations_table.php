<?php

/**
 * Fix Migrations Table
 * Menghapus tabel migrations yang bermasalah termasuk tablespace
 */

try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=nurani', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Memeriksa tabel migrations...\n";
    
    // Cek apakah tabel ada
    $stmt = $pdo->query("SHOW TABLES LIKE 'migrations'");
    $tableExists = $stmt->rowCount() > 0;
    
    if ($tableExists) {
        echo "Tabel migrations ditemukan. Menghapus...\n";
        
        // Coba DISCARD tablespace dulu
        try {
            $pdo->exec('ALTER TABLE migrations DISCARD TABLESPACE');
            echo "Tablespace sudah di-discard.\n";
        } catch (PDOException $e) {
            // Ignore error jika tablespace sudah tidak ada
        }
        
        // Hapus tabel
        $pdo->exec('DROP TABLE IF EXISTS migrations');
        echo "SUKSES: Tabel migrations sudah dihapus!\n";
    } else {
        echo "Tabel migrations tidak ada.\n";
        
        // Tapi coba DISCARD tablespace jika masih ada file
        try {
            $pdo->exec('ALTER TABLE migrations DISCARD TABLESPACE');
            echo "Tablespace sudah di-discard.\n";
        } catch (PDOException $e) {
            // Ignore error
        }
    }
    
    echo "\nSekarang jalankan: php artisan migrate --force\n";
    
} catch (PDOException $e) {
    if (strpos($e->getMessage(), "Unknown database") !== false) {
        echo "INFO: Database 'nurani' belum ada. Akan dibuat saat migrations.\n";
    } else {
        echo "ERROR: " . $e->getMessage() . "\n";
        echo "\nCoba hapus manual di phpMyAdmin:\n";
        echo "1. Buka http://localhost/phpmyadmin\n";
        echo "2. Pilih database 'nurani'\n";
        echo "3. Klik tab 'SQL'\n";
        echo "4. Jalankan: DROP TABLE IF EXISTS migrations;\n";
        echo "5. Lalu jalankan: php artisan migrate --force\n";
    }
}

