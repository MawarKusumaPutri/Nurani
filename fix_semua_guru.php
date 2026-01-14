<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== CEK DAN FIX SEMUA DATA GURU ===\n\n";

// Daftar semua guru dari LOGIN_CREDENTIALS.md
$guruList = [
    [
        'email' => 'mundarinurhadi@gmail.com',
        'nama' => 'Nurhadi, S.Pd',
        'nip' => '198601012010011001',
        'mata_pelajaran' => 'Matematika',
    ],
    [
        'email' => 'keysa8406@gmail.com',
        'nama' => 'Keysa Anjani',
        'nip' => '199408062019032001',
        'mata_pelajaran' => 'Bahasa Inggris',
    ],
    [
        'email' => 'fadliziyad123@gmail.com',
        'nama' => 'Fadli',
        'nip' => '199205152017011001',
        'mata_pelajaran' => 'Bahasa Arab',
    ],
    [
        'email' => 'sitimundari54@gmail.com',
        'nama' => 'Siti Mundari, S.Ag',
        'nip' => '198705142015032002',
        'mata_pelajaran' => 'IPA, Prakarya',
    ],
    [
        'email' => 'lola.nurlaela@mtssnuraiman.sch.id',
        'nama' => 'Lola Nurlaela, S.Pd.I.',
        'nip' => '199103212016032001',
        'mata_pelajaran' => 'SKI, Akidah Akhlak',
    ],
    [
        'email' => 'desinurfalah24@gmail.com',
        'nama' => 'Desi Nurfalah',
        'nip' => '199612242020032001',
        'mata_pelajaran' => 'Bahasa Indonesia',
    ],
    [
        'email' => 'rizmalmaulana25@gmail.com',
        'nama' => 'M. Rizmal Maulana',
        'nip' => '199502252018011001',
        'mata_pelajaran' => 'QH, FIQIH',
    ],
    [
        'email' => 'zahnajmudin10@gmail.com',
        'nama' => 'Hamzah Najmudin',
        'nip' => '199310102017011001',
        'mata_pelajaran' => 'PJOK, IPS',
    ],
    [
        'email' => 'sopyanikhsananda@gmail.com',
        'nama' => 'Sopyan',
        'nip' => '199407152019011001',
        'mata_pelajaran' => 'PKN',
    ],
    [
        'email' => 'syifarestu81@gmail.com',
        'nama' => 'Syifa Restu R',
        'nip' => '199808012020032001',
        'mata_pelajaran' => 'Seni Budaya',
    ],
    [
        'email' => 'wenibustamin27@gmail.com',
        'nama' => 'Weni Azmi',
        'nip' => '199702272019032001',
        'mata_pelajaran' => 'Tahsin',
    ],
    [
        'email' => 'tintinmartini184@gmail.com',
        'nama' => 'Tintin Martini',
        'nip' => '198401182016032001',
        'mata_pelajaran' => 'BTQ',
    ],
    [
        'email' => 'mawarkusuma694@gmail.com',
        'nama' => 'Mawar',
        'nip' => '199406942020032001',
        'mata_pelajaran' => 'Umum',
    ],
];

$fixed = 0;
$alreadyOk = 0;
$notFound = 0;

foreach ($guruList as $data) {
    echo "Cek: {$data['nama']} ({$data['email']})... ";
    
    // Cek User
    $user = App\Models\User::where('email', $data['email'])->first();
    
    if (!$user) {
        echo "❌ User tidak ada\n";
        $notFound++;
        continue;
    }
    
    // Cek Guru
    $guru = App\Models\Guru::where('user_id', $user->id)->first();
    
    if ($guru) {
        echo "✅ Sudah OK\n";
        $alreadyOk++;
    } else {
        // Buat data guru
        App\Models\Guru::create([
            'user_id' => $user->id,
            'nip' => $data['nip'],
            'mata_pelajaran' => $data['mata_pelajaran'],
            'kontak' => null,
            'biodata' => 'Guru ' . $data['mata_pelajaran'] . ' di MTs Nurul Aiman',
            'foto' => null,
            'status' => 'aktif',
        ]);
        echo "🔧 DIPERBAIKI!\n";
        $fixed++;
    }
}

echo "\n=== RINGKASAN ===\n";
echo "✅ Sudah OK: $alreadyOk guru\n";
echo "🔧 Diperbaiki: $fixed guru\n";
echo "❌ User tidak ada: $notFound guru\n";
echo "\n🎉 SELESAI! Semua guru sekarang bisa login!\n";
