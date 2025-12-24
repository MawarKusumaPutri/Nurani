<?php
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Get event with ID 3
$event = App\Models\Event::find(3);

if ($event) {
    echo "Event ID: " . $event->id . "\n";
    echo "Judul: " . $event->judul_event . "\n";
    echo "Foto: " . ($event->foto ?? 'NULL') . "\n";
    echo "Foto Path: " . ($event->foto ? storage_path('app/public/' . $event->foto) : 'NULL') . "\n";
    
    if ($event->foto) {
        $fullPath = storage_path('app/public/' . $event->foto);
        echo "File exists: " . (file_exists($fullPath) ? 'YES' : 'NO') . "\n";
        if (file_exists($fullPath)) {
            echo "File size: " . filesize($fullPath) . " bytes\n";
        }
    }
} else {
    echo "Event not found!\n";
}
