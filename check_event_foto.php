<?php

// Check event foto
require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Event;

echo "=== Checking Event ID 4 ===\n\n";

$event = Event::find(4);

if (!$event) {
    echo "❌ Event ID 4 tidak ditemukan!\n";
    exit;
}

echo "✅ Event ditemukan:\n";
echo "ID: " . $event->id . "\n";
echo "Judul: " . $event->judul_event . "\n";
echo "Kategori: " . $event->kategori_event . "\n";
echo "Foto: " . ($event->foto ?? 'NULL/KOSONG') . "\n\n";

if ($event->foto) {
    $filePath = storage_path('app/public/' . $event->foto);
    echo "Path foto: " . $filePath . "\n";
    
    if (file_exists($filePath)) {
        echo "✅ File foto ADA di storage\n";
        echo "Ukuran: " . filesize($filePath) . " bytes\n";
    } else {
        echo "❌ File foto TIDAK ADA di storage\n";
        echo "Event memiliki field foto di database, tapi file fisiknya tidak ada!\n";
    }
} else {
    echo "❌ Event tidak memiliki foto (field foto kosong/null)\n";
}

echo "\n=== Checking All Events with Foto ===\n\n";

$eventsWithFoto = Event::whereNotNull('foto')->where('foto', '!=', '')->get();

echo "Total events dengan foto: " . $eventsWithFoto->count() . "\n\n";

foreach ($eventsWithFoto as $evt) {
    echo "ID: {$evt->id} | Judul: {$evt->judul_event} | Foto: {$evt->foto}\n";
    $path = storage_path('app/public/' . $evt->foto);
    echo "  File exists: " . (file_exists($path) ? '✅ YES' : '❌ NO') . "\n\n";
}
