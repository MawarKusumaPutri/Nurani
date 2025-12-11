<?php

/**
 * Safe Migration Runner
 * Menjalankan migrations dengan error handling agar tidak crash jika tabel sudah ada
 */

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

echo "Starting safe migrations...\n";

try {
    // Jalankan migrations dengan output
    Artisan::call('migrate', [
        '--force' => true,
        '--no-interaction' => true,
    ]);
    
    echo Artisan::output();
    echo "Migrations completed successfully!\n";
    exit(0);
    
} catch (\Exception $e) {
    // Jika error karena tabel sudah ada, skip dan lanjutkan
    if (strpos($e->getMessage(), 'already exists') !== false) {
        echo "Warning: " . $e->getMessage() . "\n";
        echo "Skipping and continuing...\n";
        
        // Coba jalankan migrations lagi untuk yang belum jalan
        try {
            Artisan::call('migrate', [
                '--force' => true,
                '--no-interaction' => true,
            ]);
            echo Artisan::output();
            echo "Remaining migrations completed!\n";
            exit(0);
        } catch (\Exception $e2) {
            echo "Error: " . $e2->getMessage() . "\n";
            // Tetap exit 0 agar service tidak crash
            exit(0);
        }
    } else {
        // Error lain, tetap exit 0 agar service tidak crash
        echo "Error: " . $e->getMessage() . "\n";
        echo "Continuing anyway...\n";
        exit(0);
    }
}
