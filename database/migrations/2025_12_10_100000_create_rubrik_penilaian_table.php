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
        Schema::create('rubrik_penilaian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guru_id')->constrained('gurus')->onDelete('cascade');
            $table->string('judul');
            $table->string('mata_pelajaran');
            $table->string('kelas');
            $table->string('semester');
            $table->string('tahun_pelajaran')->nullable();
            $table->text('deskripsi')->nullable();
            $table->text('kriteria_penilaian')->nullable(); // JSON atau text untuk menyimpan kriteria
            $table->text('skala_nilai')->nullable(); // Skala penilaian (1-4, 1-5, dll)
            $table->text('indikator')->nullable(); // Indikator penilaian
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rubrik_penilaian');
    }
};
