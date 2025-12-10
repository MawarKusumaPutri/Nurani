<?php
/**
 * Script untuk membuat tabel RPP secara langsung
 * Jalankan: php create_rpp_table.php
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

try {
    echo "========================================\n";
    echo "MEMBUAT TABEL RPP\n";
    echo "========================================\n\n";
    
    // Cek apakah tabel sudah ada
    if (Schema::hasTable('rpp')) {
        echo "⚠ Tabel 'rpp' sudah ada!\n";
        echo "Menghapus tabel lama...\n";
        Schema::dropIfExists('rpp');
        echo "✓ Tabel lama dihapus.\n\n";
    }
    
    echo "Membuat tabel 'rpp'...\n";
    
    Schema::create('rpp', function ($table) {
        $table->id();
        $table->foreignId('guru_id')->constrained('gurus')->onDelete('cascade');
        $table->string('judul');
        $table->string('mata_pelajaran');
        $table->string('kelas');
        $table->string('semester');
        $table->integer('pertemuan_ke');
        $table->integer('alokasi_waktu');
        
        // 1. Identitas Pembelajaran
        $table->string('sekolah')->nullable();
        $table->string('mata_pelajaran_detail')->nullable();
        $table->string('kelas_detail')->nullable();
        $table->string('semester_detail')->nullable();
        $table->string('tahun_pelajaran')->nullable();
        
        // 2. Kompetensi Inti (KI)
        $table->text('ki_1')->nullable();
        $table->text('ki_2')->nullable();
        $table->text('ki_3')->nullable();
        $table->text('ki_4')->nullable();
        
        // 3. KD & Indikator
        $table->text('kd_pengetahuan')->nullable();
        $table->text('kd_keterampilan')->nullable();
        $table->text('indikator_pencapaian_kompetensi')->nullable();
        
        // 4. Tujuan Pembelajaran
        $table->text('tujuan_pembelajaran')->nullable();
        
        // 5. Materi Pembelajaran
        $table->text('materi_pembelajaran')->nullable();
        $table->text('materi_pembelajaran_reguler')->nullable();
        $table->text('materi_pembelajaran_pengayaan')->nullable();
        $table->text('materi_pembelajaran_remedial')->nullable();
        
        // 6. Metode Pembelajaran
        $table->text('metode_pembelajaran')->nullable();
        
        // 7. Skenario Pembelajaran
        $table->text('kegiatan_pendahuluan')->nullable();
        $table->text('kegiatan_inti')->nullable();
        $table->text('kegiatan_penutup')->nullable();
        
        // 8. Media & Sumber Ajar
        $table->text('media_pembelajaran')->nullable();
        $table->text('sumber_belajar')->nullable();
        
        // 9. Instrumen Penilaian
        $table->text('teknik_penilaian')->nullable();
        $table->text('bentuk_instrumen')->nullable();
        $table->text('rubrik_penilaian')->nullable();
        $table->text('kriteria_ketuntasan')->nullable();
        
        $table->timestamps();
    });
    
    echo "✓ Tabel 'rpp' berhasil dibuat!\n\n";
    
    // Verifikasi
    if (Schema::hasTable('rpp')) {
        echo "✓ Verifikasi: Tabel 'rpp' sudah ada di database.\n";
        echo "\n========================================\n";
        echo "SUKSES! Tabel RPP sudah siap digunakan.\n";
        echo "========================================\n";
    } else {
        echo "✗ ERROR: Tabel 'rpp' tidak ditemukan setelah dibuat!\n";
        exit(1);
    }
    
} catch (Exception $e) {
    echo "\n✗ ERROR: " . $e->getMessage() . "\n";
    echo "\nFile: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
    exit(1);
}
