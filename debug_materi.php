<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Guru;
use App\Models\Materi;
use Illuminate\Support\Facades\DB;

echo "=== DEBUG MATERI ===\n\n";

// Cek semua guru
echo "1. DAFTAR GURU:\n";
$gurus = Guru::with('user')->get();
foreach ($gurus as $guru) {
    echo "   - ID: {$guru->id}, Nama: {$guru->user->name}, Email: {$guru->user->email}\n";
}

echo "\n2. DAFTAR MATERI:\n";
$materis = Materi::with('guru.user')->get();
if ($materis->count() == 0) {
    echo "   TIDAK ADA MATERI DI DATABASE!\n";
} else {
    foreach ($materis as $materi) {
        echo "   - ID: {$materi->id}\n";
        echo "     Judul: {$materi->judul}\n";
        echo "     Mata Pelajaran: {$materi->mata_pelajaran}\n";
        echo "     Kelas: {$materi->kelas}\n";
        echo "     Guru ID: {$materi->guru_id}\n";
        echo "     Guru Nama: {$materi->guru->user->name}\n";
        echo "     Created: {$materi->created_at}\n";
        echo "\n";
    }
}

// Cek materi per guru
echo "\n3. MATERI PER GURU:\n";
foreach ($gurus as $guru) {
    $materiCount = $guru->materi()->count();
    echo "   - {$guru->user->name}: {$materiCount} materi\n";
    
    if ($materiCount > 0) {
        $materiList = $guru->materi()->get();
        foreach ($materiList as $m) {
            echo "     * {$m->judul} ({$m->mata_pelajaran})\n";
        }
    }
}

// Cek mata pelajaran aktif
echo "\n4. MATA PELAJARAN AKTIF:\n";
foreach ($gurus as $guru) {
    $mataPelajaranAktif = $guru->mataPelajaranAktif;
    echo "   - {$guru->user->name}: {$mataPelajaranAktif->count()} mata pelajaran\n";
    
    if ($mataPelajaranAktif->count() > 0) {
        foreach ($mataPelajaranAktif as $mp) {
            echo "     * {$mp->mata_pelajaran}\n";
        }
    } else {
        echo "     TIDAK ADA MATA PELAJARAN AKTIF!\n";
    }
}

echo "\n=== SELESAI ===\n";
