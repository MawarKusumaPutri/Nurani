<?php
// Reset Database Script
echo "🔄 Resetting database...\n\n";

// Database connection
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'nurani';

try {
    // Connect without database
    $pdo = new PDO("mysql:host=$host", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Drop and create database
    echo "📦 Dropping old database...\n";
    $pdo->exec("DROP DATABASE IF EXISTS `$db`");
    
    echo "📦 Creating new database...\n";
    $pdo->exec("CREATE DATABASE `$db` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    
    echo "✅ Database reset successfully!\n\n";
    echo "🚀 Next steps:\n";
    echo "   1. Run: php artisan migrate --force\n";
    echo "   2. Run: php artisan db:seed --class=UserSeeder --force\n";
    
} catch (PDOException $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}
