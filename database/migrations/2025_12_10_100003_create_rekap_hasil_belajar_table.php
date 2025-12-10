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
        Schema::create('rekap_hasil_belajar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guru_id')->constrained('gurus')->onDelete('cascade');
            $table->foreignId('siswa_id')->constrained('siswas')->onDelete('cascade');
            $table->string('kelas');
            $table->string('semester');
            $table->string('tahun_pelajaran')->nullable();
            
            // Rekap per Mata Pelajaran
            $table->string('mata_pelajaran');
            $table->decimal('nilai_formatif', 5, 2)->nullable();
            $table->decimal('nilai_sumatif', 5, 2)->nullable();
            $table->decimal('nilai_akhir', 5, 2)->nullable();
            $table->string('predikat')->nullable();
            
            // Rekap Keseluruhan
            $table->integer('total_mata_pelajaran')->default(0);
            $table->decimal('rata_rata_semua_mapel', 5, 2)->nullable();
            $table->integer('jumlah_mapel_tuntas')->default(0);
            $table->integer('jumlah_mapel_tidak_tuntas')->default(0);
            
            $table->text('catatan')->nullable();
            $table->timestamps();
            
            // Index
            $table->index(['guru_id', 'kelas', 'semester']);
            $table->index(['siswa_id', 'semester']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekap_hasil_belajar');
    }
};
