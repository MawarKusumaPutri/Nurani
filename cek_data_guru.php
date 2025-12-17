<?php

/**
 * Cek Data Guru di Database
 */

try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=nurani', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "========================================\n";
    echo "  CEK DATA GURU DI DATABASE\n";
    echo "========================================\n\n";
    
    // Cek apakah tabel users ada
    $tables = $pdo->query("SHOW TABLES LIKE 'users'");
    if ($tables->rowCount() == 0) {
        echo "[INFO] Tabel 'users' belum ada!\n";
        echo "[INFO] Jalankan migrations dulu: php artisan migrate --force\n";
        exit(0);
    }
    
    // Cek jumlah guru
    $result = $pdo->query("SELECT COUNT(*) as count FROM users WHERE role = 'guru'");
    $row = $result->fetch(PDO::FETCH_ASSOC);
    $count = $row['count'];
    
    echo "Jumlah guru di database: $count\n\n";
    
    if ($count > 0) {
        echo "Data guru yang ada:\n";
        echo "----------------------------------------\n";
        $gurus = $pdo->query("SELECT email, name, role FROM users WHERE role = 'guru' ORDER BY name");
        $no = 1;
        foreach ($gurus as $guru) {
            echo "$no. {$guru['name']} - {$guru['email']}\n";
            $no++;
        }
        echo "\n[SUKSES] Data guru sudah ada!\n";
        echo "[INFO] Password default: password123\n";
    } else {
        echo "[INFO] Belum ada data guru!\n";
        echo "[INFO] Jalankan seeder: php artisan db:seed --class=UserSeeder\n";
    }
    
} catch (PDOException $e) {
    if (strpos($e->getMessage(), "Unknown database") !== false) {
        echo "[INFO] Database 'nurani' belum ada!\n";
        echo "[INFO] Buat database dulu di phpMyAdmin atau jalankan migrations\n";
    } else {
        echo "ERROR: " . $e->getMessage() . "\n";
    }
    exit(1);
}
