<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== CEK DATA GURU SITI MUNDARI ===\n\n";

// Cek User
$user = App\Models\User::where('email', 'sitimundari54@gmail.com')->first();

if ($user) {
    echo "✅ User ditemukan:\n";
    echo "   - ID: {$user->id}\n";
    echo "   - Nama: {$user->name}\n";
    echo "   - Email: {$user->email}\n";
    echo "   - Role: {$user->role}\n\n";
    
    // Cek Guru
    $guru = App\Models\Guru::where('user_id', $user->id)->first();
    
    if ($guru) {
        echo "✅ Data Guru ditemukan:\n";
        echo "   - ID: {$guru->id}\n";
        echo "   - NIP: {$guru->nip}\n";
        echo "   - Mata Pelajaran: {$guru->mata_pelajaran}\n";
        echo "   - Status: {$guru->status}\n\n";
        echo "STATUS: LENGKAP ✅\n";
    } else {
        echo "❌ MASALAH: User ada tapi data Guru TIDAK ADA!\n\n";
        echo "SOLUSI: Perlu insert data ke tabel gurus\n";
    }
} else {
    echo "❌ User TIDAK ditemukan di database\n\n";
    echo "SOLUSI: Perlu insert data user dan guru\n";
}

// Cek juga Desi untuk perbandingan
echo "\n=== PERBANDINGAN: CEK DATA GURU DESI ===\n\n";
$userDesi = App\Models\User::where('email', 'desinurfalah24@gmail.com')->first();

if ($userDesi) {
    echo "✅ User Desi ditemukan (ID: {$userDesi->id})\n";
    $guruDesi = App\Models\Guru::where('user_id', $userDesi->id)->first();
    if ($guruDesi) {
        echo "✅ Data Guru Desi ditemukan (ID: {$guruDesi->id})\n";
    } else {
        echo "❌ Data Guru Desi TIDAK ADA\n";
    }
}
