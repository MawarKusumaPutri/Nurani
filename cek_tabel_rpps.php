<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

echo "=== CEK STRUKTUR TABEL RPPS ===\n\n";

// Get columns
$columns = DB::select("SHOW COLUMNS FROM rpps");

echo "Kolom yang ada di tabel rpps:\n";
foreach ($columns as $column) {
    echo "  - {$column->Field} ({$column->Type})\n";
}

echo "\n=== KOLOM YANG HILANG ===\n\n";

$requiredColumns = [
    'nama_kepala_sekolah',
    'nip_kepala_sekolah',
    'nama_kantor',
    'kota_kabupaten',
    'alamat_lengkap',
];

$existingColumns = array_map(fn($col) => $col->Field, $columns);

foreach ($requiredColumns as $col) {
    if (!in_array($col, $existingColumns)) {
        echo "❌ Kolom '$col' TIDAK ADA\n";
    } else {
        echo "✅ Kolom '$col' sudah ada\n";
    }
}
