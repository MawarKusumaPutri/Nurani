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

// Step 2.5: Verify and fix foto column in events table
echo "\n[2.5/3] Verifikasi kolom foto di tabel events...\n";
try {
    // Check if events table exists
    if (Schema::hasTable('events')) {
        // Check if foto column exists
        if (!Schema::hasColumn('events', 'foto')) {
            echo "[INFO] Kolom 'foto' belum ada, menambahkan kolom...\n";
            
            Schema::table('events', function ($table) {
                $table->string('foto')->nullable()->after('warna');
            });
            
            echo "[SUKSES] Kolom 'foto' berhasil ditambahkan!\n";
        } else {
            echo "[INFO] Kolom 'foto' sudah ada di tabel events\n";
        }
    } else {
        echo "[WARNING] Tabel 'events' belum ada\n";
    }
} catch (\Exception $e) {
    echo "[WARNING] Gagal verifikasi kolom foto: " . $e->getMessage() . "\n";
}

// Step 2.6: Verify and fix signature columns in rpps table
echo "\n[2.6/3] Verifikasi kolom tanda tangan di tabel rpps...\n";
try {
    // Check if rpps table exists
    if (Schema::hasTable('rpps')) {
        $columnsToAdd = [];
        
        // Check each signature column
        if (!Schema::hasColumn('rpps', 'kepala_sekolah_nama')) {
            $columnsToAdd[] = 'kepala_sekolah_nama';
        }
        if (!Schema::hasColumn('rpps', 'kepala_sekolah_nip')) {
            $columnsToAdd[] = 'kepala_sekolah_nip';
        }
        if (!Schema::hasColumn('rpps', 'ttd_kepala_sekolah')) {
            $columnsToAdd[] = 'ttd_kepala_sekolah';
        }
        if (!Schema::hasColumn('rpps', 'ttd_guru')) {
            $columnsToAdd[] = 'ttd_guru';
        }
        
        if (count($columnsToAdd) > 0) {
            echo "[INFO] Menambahkan kolom: " . implode(', ', $columnsToAdd) . "...\n";
            
            Schema::table('rpps', function ($table) use ($columnsToAdd) {
                if (in_array('kepala_sekolah_nama', $columnsToAdd)) {
                    $table->string('kepala_sekolah_nama')->nullable();
                }
                if (in_array('kepala_sekolah_nip', $columnsToAdd)) {
                    $table->string('kepala_sekolah_nip')->nullable();
                }
                if (in_array('ttd_kepala_sekolah', $columnsToAdd)) {
                    $table->string('ttd_kepala_sekolah')->nullable();
                }
                if (in_array('ttd_guru', $columnsToAdd)) {
                    $table->string('ttd_guru')->nullable();
                }
            });
            
            echo "[SUKSES] Kolom tanda tangan berhasil ditambahkan!\n";
        } else {
            echo "[INFO] Semua kolom tanda tangan sudah ada di tabel rpps\n";
        }
    } else {
        echo "[WARNING] Tabel 'rpps' belum ada\n";
    }
} catch (\Exception $e) {
    echo "[WARNING] Gagal verifikasi kolom tanda tangan: " . $e->getMessage() . "\n";
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
