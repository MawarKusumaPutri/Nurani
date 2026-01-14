<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== MENAMBAHKAN KOLOM KE TABEL RPP ===\n\n";

$columnsToAdd = [
    'nama_kepala_sekolah' => 'VARCHAR(255) NULL',
    'nip_kepala_sekolah' => 'VARCHAR(255) NULL',
    'nama_kantor' => 'VARCHAR(255) NULL',
    'kota_kabupaten' => 'VARCHAR(255) NULL',
    'alamat_lengkap' => 'TEXT NULL',
];

foreach ($columnsToAdd as $column => $type) {
    try {
        echo "Menambahkan kolom '$column'... ";
        DB::statement("ALTER TABLE rpp ADD COLUMN $column $type");
        echo "✅ Berhasil\n";
    } catch (\Exception $e) {
        if (strpos($e->getMessage(), 'Duplicate column') !== false) {
            echo "⚠️ Sudah ada\n";
        } else {
            echo "❌ Error: " . $e->getMessage() . "\n";
        }
    }
}

echo "\n✅ SELESAI! Kolom telah ditambahkan.\n";
echo "\nSekarang coba simpan RPP lagi!\n";
