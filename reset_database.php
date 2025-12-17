<?php

/**
 * Reset Database dan Migrate
 * Hapus database 'nurani' dan buat ulang, lalu jalankan migrations
 */

try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "========================================\n";
    echo "  RESET DATABASE DAN MIGRATE\n";
    echo "========================================\n\n";
    
    echo "[1/3] Menghapus database 'nurani'...\n";
    $pdo->exec('DROP DATABASE IF EXISTS nurani');
    echo "SUKSES: Database sudah dihapus!\n\n";
    
    echo "[2/3] Membuat database 'nurani' baru...\n";
    $pdo->exec('CREATE DATABASE nurani CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
    echo "SUKSES: Database sudah dibuat!\n\n";
    
    echo "[3/3] Menjalankan migrations...\n";
    echo "Jalankan: php artisan migrate --force\n\n";
    
    echo "========================================\n";
    echo "  DATABASE SUDAH DI-RESET!\n";
    echo "========================================\n";
    
} catch (PDOException $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "\nPastikan MySQL sudah berjalan di XAMPP!\n";
    exit(1);
}

