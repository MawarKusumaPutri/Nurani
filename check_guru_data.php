<?php
// Cek Data Guru di Database
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "📋 DAFTAR GURU DI DATABASE:\n\n";
echo str_repeat("=", 80) . "\n";
printf("%-5s %-30s %-40s\n", "No", "Nama", "Email");
echo str_repeat("=", 80) . "\n";

$gurus = DB::table('gurus')
    ->select('nama', 'email')
    ->orderBy('nama')
    ->get();

$no = 1;
foreach ($gurus as $guru) {
    printf("%-5d %-30s %-40s\n", $no++, $guru->nama, $guru->email);
}

echo str_repeat("=", 80) . "\n";
echo "Total: " . $gurus->count() . " guru\n\n";

// Cek juga di tabel users
echo "📋 DAFTAR USER GURU DI DATABASE:\n\n";
echo str_repeat("=", 80) . "\n";
printf("%-5s %-30s %-40s\n", "No", "Nama", "Email");
echo str_repeat("=", 80) . "\n";

$users = DB::table('users')
    ->where('role', 'guru')
    ->select('name', 'email')
    ->orderBy('name')
    ->get();

$no = 1;
foreach ($users as $user) {
    printf("%-5d %-30s %-40s\n", $no++, $user->name, $user->email);
}

echo str_repeat("=", 80) . "\n";
echo "Total: " . $users->count() . " user guru\n";
