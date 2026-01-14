<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== UPDATE DATA GURU SITI MUNDARI ===\n\n";

// Cek User
$user = App\Models\User::where('email', 'sitimundari54@gmail.com')->first();

if (!$user) {
    echo "❌ User tidak ditemukan!\n";
    exit;
}

echo "✅ User ditemukan (ID: {$user->id})\n\n";

// Cek Guru
$guru = App\Models\Guru::where('user_id', $user->id)->first();

if (!$guru) {
    echo "❌ Data guru tidak ditemukan!\n";
    exit;
}

echo "📝 Data guru saat ini:\n";
echo "   - Mata Pelajaran: {$guru->mata_pelajaran}\n\n";

// Update mata pelajaran
echo "🔄 Mengupdate mata pelajaran...\n";

$guru->update([
    'mata_pelajaran' => 'IPA, Prakarya', // 2 mata pelajaran
]);

echo "\n✅ BERHASIL! Data guru telah diupdate:\n";
echo "   - Guru ID: {$guru->id}\n";
echo "   - Nama: {$user->name}\n";
echo "   - Mata Pelajaran: {$guru->mata_pelajaran}\n";
echo "   - Status: {$guru->status}\n\n";

echo "🎉 Sekarang Siti Mundari mengajar IPA dan Prakarya!\n";
