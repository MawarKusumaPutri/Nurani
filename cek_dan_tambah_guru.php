<?php

/**
 * Cek Tabel dan Tambah Data Guru
 */

$dbHost = '127.0.0.1';
$dbPort = '3306';
$dbUser = 'root';
$dbPass = '';
$dbName = 'nurani';

try {
    $pdo = new PDO("mysql:host=$dbHost;port=$dbPort;dbname=$dbName", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Cek apakah tabel users ada
    $result = $pdo->query("SHOW TABLES LIKE 'users'");
    if ($result->rowCount() > 0) {
        echo "[INFO] Tabel users sudah ada!\n";
        echo "[INFO] Langsung jalankan seeder untuk update data guru...\n";
        exit(0);
    } else {
        echo "[INFO] Tabel users belum ada!\n";
        echo "[INFO] Perlu jalankan migrations dulu...\n";
        exit(1);
    }
} catch (PDOException $e) {
    if (strpos($e->getMessage(), "Unknown database") !== false) {
        echo "[INFO] Database 'nurani' belum ada!\n";
        echo "[INFO] Perlu buat database dan jalankan migrations...\n";
    } else {
        echo "[ERROR] " . $e->getMessage() . "\n";
    }
    exit(1);
}
