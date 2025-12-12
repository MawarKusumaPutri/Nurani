<?php

/**
 * Safe Migration and Seeder Runner for Railway
 * Menjalankan migrations dan seeder dengan error handling
 */

// Set error handler untuk catch semua error
set_error_handler(function($severity, $message, $file, $line) {
    if (strpos($message, 'already exists') !== false || 
        strpos($message, 'Table') !== false && strpos($message, "doesn't exist") === false) {
        return true; // Suppress error
    }
    return false;
});

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

echo "========================================\n";
echo "  RAILWAY: MIGRATIONS & SEEDER\n";
echo "========================================\n\n";

// Step 1: Run Migrations
echo "[1/2] Running migrations...\n";
try {
    $exitCode = Artisan::call('migrate', [
        '--force' => true,
        '--no-interaction' => true,
    ]);
    
    $output = Artisan::output();
    echo $output;
    
    if (strpos($output, 'DONE') !== false || strpos($output, 'Migrated') !== false) {
        echo "[SUKSES] Migrations selesai!\n\n";
    } else {
        echo "[INFO] Migrations process completed\n\n";
    }
    
} catch (\Exception $e) {
    $errorMsg = $e->getMessage();
    echo "Migration warning: " . $errorMsg . "\n";
    
    if (strpos($errorMsg, 'already exists') !== false || 
        strpos($errorMsg, 'Base table or view already exists') !== false) {
        echo "[INFO] Beberapa tabel sudah ada, lanjut ke seeder...\n\n";
    } else {
        echo "[WARNING] Ada error migration, tapi lanjut ke seeder...\n\n";
    }
}

// Step 2: Run Seeder
echo "[2/2] Running seeder (UserSeeder)...\n";
try {
    $exitCode = Artisan::call('db:seed', [
        '--class' => 'UserSeeder',
        '--force' => true,
        '--no-interaction' => true,
    ]);
    
    $output = Artisan::output();
    echo $output;
    
    if ($exitCode === 0) {
        echo "[SUKSES] Seeder selesai! Data guru sudah dibuat!\n\n";
    } else {
        echo "[INFO] Seeder process completed\n\n";
    }
    
} catch (\Exception $e) {
    $errorMsg = $e->getMessage();
    echo "Seeder warning: " . $errorMsg . "\n";
    
    if (strpos($errorMsg, "doesn't exist") !== false) {
        echo "[WARNING] Tabel belum ada, migrations mungkin belum selesai\n";
    } else {
        echo "[WARNING] Ada error seeder, tapi lanjut start server...\n";
    }
}

// Step 3: Verify
echo "[INFO] Verifikasi data...\n";
try {
    $userCount = DB::table('users')->where('role', 'guru')->count();
    echo "[INFO] Jumlah guru di database: $userCount\n";
    
    if ($userCount > 0) {
        echo "[SUKSES] Data guru sudah ada di Railway!\n";
    } else {
        echo "[WARNING] Belum ada data guru, seeder mungkin belum berjalan\n";
    }
} catch (\Exception $e) {
    echo "[WARNING] Gagal verifikasi: " . $e->getMessage() . "\n";
}

echo "\n========================================\n";
echo "  SELESAI - SERVER AKAN DIMULAI\n";
echo "========================================\n\n";

exit(0);
