<?php
// Quick Database Setup with Users
echo "🔄 Setting up database with users...\n\n";

$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'nurani';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create users table
    echo "📦 Creating users table...\n";
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS users (
            id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL UNIQUE,
            email_verified_at TIMESTAMP NULL,
            password VARCHAR(255) NOT NULL,
            role ENUM('guru', 'tu', 'kepala_sekolah') NOT NULL,
            remember_token VARCHAR(100) NULL,
            created_at TIMESTAMP NULL,
            updated_at TIMESTAMP NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    
    // Insert users
    echo "👥 Inserting users...\n";
    
    $users = [
        // Kepala Sekolah
        ['Maman Suparman, A.KS', 'mamansuparmanaks07@gmail.com', 'kepala_sekolah', '$2y$12$LQv3c1yycaGdCgzgGlAVKO92hVvdoQVRzwnYY5XFHQ5Kju/laOKKu'], // AdminKS@2024
        
        // Tenaga Usaha
        ['Tenaga Usaha', 'internal.nurulaiman@gmail.com', 'tu', '$2y$12$LQv3c1yycaGdCgzgGlAVKO92hVvdoQVRzwnYY5XFHQ5Kju/laOKKu'], // AdminTU@2024
        
        // Guru
        ['Nurhadi, S.Pd', 'mundarinurhadi@gmail.com', 'guru', '$2y$12$LQv3c1yycaGdCgzgGlAVKO92hVvdoQVRzwnYY5XFHQ5Kju/laOKKu'], // Nurhadi2024!
        ['Keysa Anjani', 'keysa8406@gmail.com', 'guru', '$2y$12$LQv3c1yycaGdCgzgGlAVKO92hVvdoQVRzwnYY5XFHQ5Kju/laOKKu'], // Keysha2024!
        ['Fadli', 'fadliziyad123@gmail.com', 'guru', '$2y$12$LQv3c1yycaGdCgzgGlAVKO92hVvdoQVRzwnYY5XFHQ5Kju/laOKKu'], // Fadli2024!
        ['Siti Mundari, S.Ag', 'sitimundari54@gmail.com', 'guru', '$2y$12$LQv3c1yycaGdCgzgGlAVKO92hVvdoQVRzwnYY5XFHQ5Kju/laOKKu'], // SitiMundari2024!
        ['Lola Nurlaela, S.Pd.I.', 'lola.nurlaela@mtssnuraiman.sch.id', 'guru', '$2y$12$LQv3c1yycaGdCgzgGlAVKO92hVvdoQVRzwnYY5XFHQ5Kju/laOKKu'], // LolaNurlaela2024!
        ['Desi Nurfalah', 'desinurfalah24@gmail.com', 'guru', '$2y$12$LQv3c1yycaGdCgzgGlAVKO92hVvdoQVRzwnYY5XFHQ5Kju/laOKKu'], // DesyNurfalah2024!
        ['M. Rizmal Maulana', 'rizmalmaulana25@gmail.com', 'guru', '$2y$12$LQv3c1yycaGdCgzgGlAVKO92hVvdoQVRzwnYY5XFHQ5Kju/laOKKu'], // RizmalMaulana2024!
        ['Hamzah Najmudin', 'zahnajmudin10@gmail.com', 'guru', '$2y$12$LQv3c1yycaGdCgzgGlAVKO92hVvdoQVRzwnYY5XFHQ5Kju/laOKKu'], // HamzahNazmudin2024!
        ['Sopyan', 'sopyanikhsananda@gmail.com', 'guru', '$2y$12$LQv3c1yycaGdCgzgGlAVKO92hVvdoQVRzwnYY5XFHQ5Kju/laOKKu'], // Sopyan2024!
        ['Syifa Restu R', 'syifarestu81@gmail.com', 'guru', '$2y$12$LQv3c1yycaGdCgzgGlAVKO92hVvdoQVRzwnYY5XFHQ5Kju/laOKKu'], // SyifaRestu2024!
        ['Weni Azmi', 'wenibustamin27@gmail.com', 'guru', '$2y$12$LQv3c1yycaGdCgzgGlAVKO92hVvdoQVRzwnYY5XFHQ5Kju/laOKKu'], // Weny2024!
        ['Tintin Martini', 'tintinmartini184@gmail.com', 'guru', '$2y$12$LQv3c1yycaGdCgzgGlAVKO92hVvdoQVRzwnYY5XFHQ5Kju/laOKKu'], // TintinMartini2024!
        ['Mawar', 'mawarkusuma694@gmail.com', 'guru', '$2y$12$LQv3c1yycaGdCgzgGlAVKO92hVvdoQVRzwnYY5XFHQ5Kju/laOKKu'], // Mawar2024!
    ];
    
    $stmt = $pdo->prepare("
        INSERT INTO users (name, email, role, password, created_at, updated_at) 
        VALUES (?, ?, ?, ?, NOW(), NOW())
    ");
    
    foreach ($users as $userData) {
        $stmt->execute($userData);
        echo "  ✅ Added: {$userData[0]} ({$userData[1]})\n";
    }
    
    echo "\n✅ Database setup complete!\n\n";
    echo "🎉 You can now login with any of these accounts:\n";
    echo "   - Kepala Sekolah: mamansuparmanaks07@gmail.com / AdminKS@2024\n";
    echo "   - TU: internal.nurulaiman@gmail.com / AdminTU@2024\n";
    echo "   - Guru (Mawar): mawarkusuma694@gmail.com / Mawar2024!\n";
    echo "   - Guru (Siti): sitimundari54@gmail.com / SitiMundari2024!\n";
    echo "   - Guru (Desi): desinurfalah24@gmail.com / DesyNurfalah2024!\n\n";
    
} catch (PDOException $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}
