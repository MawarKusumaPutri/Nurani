<?php

// Debug script untuk cek event foto
require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Event;

echo "=== DEBUG: Checking Event Foto ===\n\n";

// Cek event ID 4 (reunian)
$eventId = 4;
$event = Event::find($eventId);

if (!$event) {
    echo "❌ Event ID {$eventId} tidak ditemukan!\n";
    exit;
}

echo "Event ID: {$event->id}\n";
echo "Judul: {$event->judul_event}\n";
echo "Kategori: {$event->kategori_event}\n";
echo "\n--- FOTO INFO ---\n";
echo "Foto field value: " . ($event->foto ?? 'NULL') . "\n";
echo "Foto is empty: " . (empty($event->foto) ? 'YES' : 'NO') . "\n";
echo "Foto is null: " . (is_null($event->foto) ? 'YES' : 'NO') . "\n";

if ($event->foto) {
    $fullPath = storage_path('app/public/' . $event->foto);
    echo "\nFull path: {$fullPath}\n";
    echo "File exists: " . (file_exists($fullPath) ? '✅ YES' : '❌ NO') . "\n";
    
    if (file_exists($fullPath)) {
        echo "File size: " . filesize($fullPath) . " bytes\n";
        echo "File readable: " . (is_readable($fullPath) ? 'YES' : 'NO') . "\n";
    }
} else {
    echo "\n❌ Event tidak memiliki foto di database!\n";
    echo "\nSolusi:\n";
    echo "1. Upload foto melalui tombol 'Upload Foto' di halaman detail event\n";
    echo "2. Atau edit event dan upload foto melalui form edit\n";
}

echo "\n=== Checking Storage Directory ===\n";
$storageDir = storage_path('app/public/events');
echo "Events directory: {$storageDir}\n";
echo "Directory exists: " . (is_dir($storageDir) ? 'YES' : 'NO') . "\n";

if (is_dir($storageDir)) {
    $files = scandir($storageDir);
    $imageFiles = array_filter($files, function($file) {
        return !in_array($file, ['.', '..']);
    });
    
    echo "Files in directory: " . count($imageFiles) . "\n";
    
    if (count($imageFiles) > 0) {
        echo "\nFiles:\n";
        foreach ($imageFiles as $file) {
            $filePath = $storageDir . '/' . $file;
            echo "  - {$file} (" . filesize($filePath) . " bytes)\n";
        }
    }
} else {
    echo "❌ Directory tidak ada! Buat directory dengan:\n";
    echo "   mkdir -p " . $storageDir . "\n";
}

echo "\n=== Checking All Events with Foto ===\n";
$eventsWithFoto = Event::whereNotNull('foto')->where('foto', '!=', '')->get();
echo "Total events dengan foto: " . $eventsWithFoto->count() . "\n\n";

foreach ($eventsWithFoto as $evt) {
    echo "ID: {$evt->id} | Judul: {$evt->judul_event}\n";
    echo "  Foto: {$evt->foto}\n";
    $path = storage_path('app/public/' . $evt->foto);
    echo "  Exists: " . (file_exists($path) ? '✅' : '❌') . "\n\n";
}
