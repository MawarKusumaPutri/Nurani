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
        Schema::create('nilai_formatif_sumatif', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guru_id')->constrained('gurus')->onDelete('cascade');
            $table->foreignId('siswa_id')->constrained('siswas')->onDelete('cascade');
            $table->string('mata_pelajaran');
            $table->string('kelas');
            $table->string('semester');
            $table->string('tahun_pelajaran')->nullable();
            
            // Nilai Formatif
            $table->decimal('formatif_1', 5, 2)->nullable();
            $table->decimal('formatif_2', 5, 2)->nullable();
            $table->decimal('formatif_3', 5, 2)->nullable();
            $table->decimal('formatif_4', 5, 2)->nullable();
            $table->decimal('rata_formatif', 5, 2)->nullable();
            
            // Nilai Sumatif
            $table->decimal('sumatif_uts', 5, 2)->nullable(); // UTS
            $table->decimal('sumatif_uas', 5, 2)->nullable(); // UAS
            $table->decimal('rata_sumatif', 5, 2)->nullable();
            
            // Nilai Akhir
            $table->decimal('nilai_akhir', 5, 2)->nullable();
            $table->string('predikat')->nullable(); // A, B, C, D
            $table->text('keterangan')->nullable();
            
            $table->timestamps();
            
            // Index untuk pencarian cepat
            $table->index(['guru_id', 'mata_pelajaran', 'kelas', 'semester']);
            $table->index(['siswa_id', 'mata_pelajaran']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai_formatif_sumatif');
    }
};
