<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'nurani';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "📋 STRUKTUR TABEL GURUS:\n\n";
    $stmt = $pdo->query("DESCRIBE gurus");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "- {$row['Field']} ({$row['Type']})\n";
    }
    
    echo "\n📊 DATA DI TABEL GURUS:\n\n";
    $stmt = $pdo->query("SELECT * FROM gurus LIMIT 5");
    $count = 0;
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $count++;
        echo "Guru #$count:\n";
        foreach ($row as $key => $value) {
            echo "  $key: $value\n";
        }
        echo "\n";
    }
    
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM gurus");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "Total guru: " . $result['total'] . "\n";
    
} catch (PDOException $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
