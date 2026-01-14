<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== TAMBAH DATA GURU SITI MUNDARI ===\n\n";

// Cek User
$user = App\Models\User::where('email', 'sitimundari54@gmail.com')->first();

if (!$user) {
    echo "❌ User tidak ditemukan!\n";
    exit;
}

echo "✅ User ditemukan (ID: {$user->id})\n\n";

// Cek apakah guru sudah ada
$guruExist = App\Models\Guru::where('user_id', $user->id)->first();

if ($guruExist) {
    echo "⚠️ Data guru sudah ada!\n";
    echo "   - ID: {$guruExist->id}\n";
    echo "   - NIP: {$guruExist->nip}\n";
    exit;
}

// Insert data guru
echo "📝 Membuat data guru...\n";

$guru = App\Models\Guru::create([
    'user_id' => $user->id,
    'nip' => '198705142015032002', // NIP Siti Mundari
    'mata_pelajaran' => 'Bahasa Arab', // Sesuaikan dengan mata pelajaran
    'kontak' => '081234567891',
    'biodata' => 'Guru Bahasa Arab di MTs Nurul Aiman',
    'foto' => null,
    'status' => 'aktif',
]);

echo "\n✅ BERHASIL! Data guru telah ditambahkan:\n";
echo "   - Guru ID: {$guru->id}\n";
echo "   - User ID: {$guru->user_id}\n";
echo "   - NIP: {$guru->nip}\n";
echo "   - Mata Pelajaran: {$guru->mata_pelajaran}\n";
echo "   - Status: {$guru->status}\n\n";

echo "🎉 Sekarang Siti Mundari bisa login!\n";
echo "   Email: sitimundari54@gmail.com\n";
echo "   Password: (password yang sudah dibuat)\n";
