<?php

/**
 * Reset Database dan Buat Data Guru
 * Script ini akan:
 * 1. Hapus database 'nurani' jika ada
 * 2. Buat database 'nurani' baru
 * 3. Jalankan migrations
 * 4. Buat data guru
 */

try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "========================================\n";
    echo "  RESET DATABASE DAN BUAT DATA GURU\n";
    echo "========================================\n\n";
    
    echo "[1/4] Menghapus database 'nurani' jika ada...\n";
    $pdo->exec('DROP DATABASE IF EXISTS nurani');
    echo "SUKSES: Database sudah dihapus (jika ada)!\n\n";
    
    echo "[2/4] Membuat database 'nurani' baru...\n";
    $pdo->exec('CREATE DATABASE nurani CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
    echo "SUKSES: Database sudah dibuat!\n\n";
    
    echo "[3/4] Menjalankan migrations...\n";
    echo "Jalankan: php artisan migrate --force\n\n";
    
    echo "[4/4] Membuat data guru...\n";
    echo "Jalankan: php artisan db:seed --class=UserSeeder\n\n";
    
    echo "========================================\n";
    echo "  DATABASE SUDAH DI-RESET!\n";
    echo "========================================\n";
    echo "\nSekarang jalankan:\n";
    echo "1. php artisan migrate --force\n";
    echo "2. php artisan db:seed --class=UserSeeder\n";
    
} catch (PDOException $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "\nPastikan MySQL sudah berjalan di XAMPP!\n";
    exit(1);
}
