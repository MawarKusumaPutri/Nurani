<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== CEK STRUKTUR TABEL RPP ===\n\n";

$columns = DB::select("SHOW COLUMNS FROM rpp");

echo "Kolom yang ada di tabel rpp:\n";
foreach ($columns as $column) {
    echo "  - {$column->Field} ({$column->Type})\n";
}

echo "\n=== CEK KOLOM YANG DIBUTUHKAN ===\n\n";

$requiredColumns = [
    'nama_kepala_sekolah',
    'nip_kepala_sekolah',
    'nama_kantor',
    'kota_kabupaten',
    'alamat_lengkap',
];

$existingColumns = array_map(fn($col) => $col->Field, $columns);

$missingColumns = [];
foreach ($requiredColumns as $col) {
    if (!in_array($col, $existingColumns)) {
        echo "❌ Kolom '$col' TIDAK ADA (perlu ditambahkan)\n";
        $missingColumns[] = $col;
    } else {
        echo "✅ Kolom '$col' sudah ada\n";
    }
}

if (count($missingColumns) > 0) {
    echo "\n=== SQL UNTUK MENAMBAHKAN KOLOM ===\n\n";
    foreach ($missingColumns as $col) {
        echo "ALTER TABLE rpp ADD COLUMN $col VARCHAR(255) NULL;\n";
    }
}
