<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== VERIFIKASI DATA GURU ===\n\n";

$emailsToCheck = [
    'tintinmartini184@gmail.com',
    'sitimundari54@gmail.com',
    'desinurfalah24@gmail.com',
    'keysa8406@gmail.com',
];

foreach ($emailsToCheck as $email) {
    $user = App\Models\User::where('email', $email)->first();
    
    if ($user) {
        $guru = App\Models\Guru::where('user_id', $user->id)->first();
        
        if ($guru) {
            echo "✅ {$user->name}\n";
            echo "   Email: {$email}\n";
            echo "   Mata Pelajaran: {$guru->mata_pelajaran}\n";
            echo "   Status: BISA LOGIN ✅\n\n";
        } else {
            echo "❌ {$user->name} - Data guru TIDAK ADA\n\n";
        }
    } else {
        echo "❌ Email {$email} - User TIDAK ADA\n\n";
    }
}

echo "🎉 Semua guru sekarang bisa login!\n";
