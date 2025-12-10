<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rpp', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guru_id')->constrained('gurus')->onDelete('cascade');
            $table->string('judul');
            $table->string('mata_pelajaran');
            $table->string('kelas');
            $table->string('semester');
            $table->integer('pertemuan_ke');
            $table->integer('alokasi_waktu'); // dalam menit
            
            // 1. Identitas Pembelajaran
            $table->string('sekolah')->nullable();
            $table->string('mata_pelajaran_detail')->nullable();
            $table->string('kelas_detail')->nullable();
            $table->string('semester_detail')->nullable();
            $table->string('tahun_pelajaran')->nullable();
            
            // 2. Kompetensi Inti (KI)
            $table->text('ki_1')->nullable(); // Sikap Spiritual
            $table->text('ki_2')->nullable(); // Sikap Sosial
            $table->text('ki_3')->nullable(); // Pengetahuan
            $table->text('ki_4')->nullable(); // Keterampilan
            
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
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rpp');
    }
};
