<?php
// Tambahkan data guru untuk Desi Nurfalah
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'nurani';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "🔧 MENAMBAHKAN DATA GURU UNTUK DESI NURFALAH...\n\n";
    
    // Data untuk Desi Nurfalah
    $userId = 8; // ID dari tabel users
    $nip = 'G013'; // NIP guru (unique)
    $mataPelajaran = 'Bahasa Indonesia';
    
    // Cek apakah sudah ada
    $stmt = $pdo->prepare("SELECT id FROM gurus WHERE user_id = ?");
    $stmt->execute([$userId]);
    
    if ($stmt->fetch()) {
        echo "ℹ️ Data guru sudah ada untuk user_id $userId\n";
    } else {
        // Insert data guru
        $stmt = $pdo->prepare("
            INSERT INTO gurus (user_id, nip, mata_pelajaran, status, created_at, updated_at) 
            VALUES (?, ?, ?, 'aktif', NOW(), NOW())
        ");
        $stmt->execute([$userId, $nip, $mataPelajaran]);
        
        echo "✅ Data guru berhasil ditambahkan!\n\n";
        echo "Detail:\n";
        echo "  User ID: $userId\n";
        echo "  NIP: $nip\n";
        echo "  Mata Pelajaran: $mataPelajaran\n";
        echo "  Status: aktif\n\n";
        echo "🎉 Sekarang Desi Nurfalah bisa login!\n";
    }
    
} catch (PDOException $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
