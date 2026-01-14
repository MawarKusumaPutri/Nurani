<?php
// Update Password untuk Desi Nurfalah
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'nurani';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $email = 'desinurfalah24@gmail.com';
    $newPassword = 'desi123456';
    
    // Hash password dengan bcrypt (Laravel default)
    $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
    
    echo "🔐 UPDATE PASSWORD:\n\n";
    echo "Email: $email\n";
    echo "Password Baru: $newPassword\n";
    echo "Password Hash: $hashedPassword\n\n";
    
    // Update password di database
    $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE email = ?");
    $stmt->execute([$hashedPassword, $email]);
    
    if ($stmt->rowCount() > 0) {
        echo "✅ Password berhasil diupdate!\n\n";
        echo "Sekarang Anda bisa login dengan:\n";
        echo "Email: $email\n";
        echo "Password: $newPassword\n";
    } else {
        echo "❌ Email tidak ditemukan di database!\n";
    }
    
} catch (PDOException $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
