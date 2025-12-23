<?php
/**
 * AUTO MIGRATION SCRIPT
 * Jalankan file ini SEKALI via browser untuk menambahkan kolom foto
 * URL: https://web-production-50f9.up.railway.app/migrate-foto.php
 * 
 * HAPUS FILE INI setelah migration berhasil!
 */

// Load Laravel environment
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Get database connection
$pdo = DB::connection()->getPdo();

try {
    // Check if column already exists
    $stmt = $pdo->query("SHOW COLUMNS FROM events LIKE 'foto'");
    $columnExists = $stmt->rowCount() > 0;
    
    if ($columnExists) {
        echo "<h1 style='color: green;'>✅ SUCCESS</h1>";
        echo "<p>Kolom 'foto' sudah ada di tabel 'events'!</p>";
        echo "<p><strong>Migration sudah selesai.</strong></p>";
        echo "<hr>";
        echo "<p><strong>PENTING:</strong> Hapus file ini sekarang untuk keamanan!</p>";
        echo "<p>Lokasi file: <code>public/migrate-foto.php</code></p>";
    } else {
        // Run migration
        $sql = "ALTER TABLE events ADD COLUMN foto VARCHAR(255) NULL AFTER warna";
        $pdo->exec($sql);
        
        echo "<h1 style='color: green;'>✅ MIGRATION BERHASIL!</h1>";
        echo "<p>Kolom 'foto' berhasil ditambahkan ke tabel 'events'!</p>";
        echo "<hr>";
        echo "<h2>Langkah Selanjutnya:</h2>";
        echo "<ol>";
        echo "<li>✅ Migration selesai</li>";
        echo "<li>📤 Upload foto via <a href='/tu/kalender/3/edit'>Edit Event</a></li>";
        echo "<li>👁️ Lihat foto via <a href='/tu/kalender/3'>Detail Event</a></li>";
        echo "<li>🗑️ <strong>HAPUS file ini</strong> (migrate-foto.php) untuk keamanan!</li>";
        echo "</ol>";
        echo "<hr>";
        echo "<p><strong>PENTING:</strong> Hapus file ini sekarang!</p>";
        echo "<p>Lokasi file: <code>public/migrate-foto.php</code></p>";
    }
    
} catch (Exception $e) {
    echo "<h1 style='color: red;'>❌ ERROR</h1>";
    echo "<p>Gagal menjalankan migration:</p>";
    echo "<pre>" . htmlspecialchars($e->getMessage()) . "</pre>";
    echo "<hr>";
    echo "<h2>Solusi Alternatif:</h2>";
    echo "<p>Jalankan SQL ini manual di Railway MySQL:</p>";
    echo "<pre>ALTER TABLE events ADD COLUMN foto VARCHAR(255) NULL AFTER warna;</pre>";
}
?>
