<?php
// Cek relasi antara users dan gurus untuk Desi
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'nurani';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $email = 'desinurfalah24@gmail.com';
    
    echo "🔍 CEK DATA UNTUK: $email\n\n";
    
    // Cek di tabel users
    echo "=== TABEL USERS ===\n";
    $stmt = $pdo->prepare("SELECT id, name, email, role FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user) {
        echo "✅ User ditemukan:\n";
        echo "  ID: {$user['id']}\n";
        echo "  Name: {$user['name']}\n";
        echo "  Email: {$user['email']}\n";
        echo "  Role: {$user['role']}\n\n";
        
        $userId = $user['id'];
        
        // Cek di tabel gurus
        echo "=== TABEL GURUS ===\n";
        $stmt = $pdo->prepare("SELECT * FROM gurus WHERE user_id = ?");
        $stmt->execute([$userId]);
        $guru = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($guru) {
            echo "✅ Data guru ditemukan:\n";
            echo "  ID: {$guru['id']}\n";
            echo "  User ID: {$guru['user_id']}\n";
            echo "  NIP: {$guru['nip']}\n";
            echo "  Mata Pelajaran: {$guru['mata_pelajaran']}\n\n";
            echo "✅ RELASI OK! Seharusnya bisa login.\n";
        } else {
            echo "❌ Data guru TIDAK ditemukan!\n";
            echo "   User ID $userId tidak ada di tabel gurus.\n\n";
            echo "🔧 SOLUSI: Tambahkan data guru untuk user ini.\n";
        }
    } else {
        echo "❌ User tidak ditemukan di tabel users!\n";
    }
    
} catch (PDOException $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
