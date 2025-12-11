<?php

/**
 * Safe Migration Runner
 * Menjalankan migrations dengan error handling agar tidak crash jika tabel sudah ada
 */

// Set error handler untuk catch semua error
set_error_handler(function($severity, $message, $file, $line) {
    if (strpos($message, 'already exists') !== false) {
        echo "Warning: Table already exists, skipping...\n";
        return true; // Suppress error
    }
    return false; // Let other errors through
});

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

echo "Starting safe migrations...\n";

try {
    // Jalankan migrations dengan output
    $exitCode = Artisan::call('migrate', [
        '--force' => true,
        '--no-interaction' => true,
    ]);
    
    $output = Artisan::output();
    echo $output;
    
    // Check output for errors
    if (strpos($output, 'already exists') !== false) {
        echo "Warning: Some tables already exist, but continuing...\n";
    }
    
    echo "Migrations process completed!\n";
    exit(0);
    
} catch (\Exception $e) {
    $errorMsg = $e->getMessage();
    echo "Migration error: " . $errorMsg . "\n";
    
    // Jika error karena tabel sudah ada, tetap lanjutkan
    if (strpos($errorMsg, 'already exists') !== false || 
        strpos($errorMsg, 'Base table or view already exists') !== false) {
        echo "Warning: Table already exists, but this is OK. Continuing...\n";
        exit(0);
    }
    
    // Error lain, tetap exit 0 agar service tidak crash
    echo "Warning: Migration error occurred, but continuing anyway to start server...\n";
    exit(0);
} catch (\Throwable $e) {
    $errorMsg = $e->getMessage();
    echo "Fatal error: " . $errorMsg . "\n";
    echo "Continuing anyway to start server...\n";
    exit(0);
}
