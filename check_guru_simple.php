<?php
// Simple check for gurus table
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'nurani';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "📋 CEK DATA GURU:\n\n";
    
    // Cek tabel gurus
    echo "=== TABEL GURUS ===\n";
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM gurus");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "Total guru di tabel gurus: " . $result['total'] . "\n\n";
    
    if ($result['total'] > 0) {
        echo "Daftar guru:\n";
        $stmt = $pdo->query("SELECT nama, email FROM gurus ORDER BY nama");
        $no = 1;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "$no. {$row['nama']} - {$row['email']}\n";
            $no++;
        }
    }
    
    echo "\n=== TABEL USERS (ROLE GURU) ===\n";
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM users WHERE role = 'guru'");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "Total user guru: " . $result['total'] . "\n\n";
    
    if ($result['total'] > 0) {
        echo "Daftar user guru:\n";
        $stmt = $pdo->query("SELECT name, email FROM users WHERE role = 'guru' ORDER BY name");
        $no = 1;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "$no. {$row['name']} - {$row['email']}\n";
            $no++;
        }
    }
    
} catch (PDOException $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
