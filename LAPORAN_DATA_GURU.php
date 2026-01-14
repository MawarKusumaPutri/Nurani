<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'nurani';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "📋 DAFTAR LENGKAP DATA GURU:\n\n";
    echo str_repeat("=", 100) . "\n";
    printf("%-4s %-25s %-35s %-15s %-20s\n", "No", "Nama", "Email", "NIP", "Mata Pelajaran");
    echo str_repeat("=", 100) . "\n";
    
    $stmt = $pdo->query("
        SELECT 
            u.name, 
            u.email, 
            g.nip, 
            g.mata_pelajaran
        FROM gurus g
        JOIN users u ON g.user_id = u.id
        WHERE u.role = 'guru'
        ORDER BY u.name
    ");
    
    $no = 1;
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $mapel = strlen($row['mata_pelajaran']) > 18 ? substr($row['mata_pelajaran'], 0, 15) . '...' : $row['mata_pelajaran'];
        printf("%-4d %-25s %-35s %-15s %-20s\n", 
            $no++, 
            $row['name'], 
            $row['email'], 
            $row['nip'] ?: '-', 
            $mapel ?: '-'
        );
    }
    
    echo str_repeat("=", 100) . "\n";
    echo "Total: " . ($no - 1) . " guru\n\n";
    
    echo "✅ Semua data guru sudah ada dan bisa digunakan untuk login!\n";
    
} catch (PDOException $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
