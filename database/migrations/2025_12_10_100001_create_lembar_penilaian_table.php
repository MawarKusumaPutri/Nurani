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
        Schema::create('lembar_penilaian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guru_id')->constrained('gurus')->onDelete('cascade');
            $table->foreignId('siswa_id')->constrained('siswas')->onDelete('cascade');
            $table->foreignId('rubrik_penilaian_id')->nullable()->constrained('rubrik_penilaian')->onDelete('set null');
            $table->string('mata_pelajaran');
            $table->string('kelas');
            $table->string('semester');
            $table->string('tahun_pelajaran')->nullable();
            $table->date('tanggal_penilaian');
            $table->string('jenis_penilaian'); // Formatif, Sumatif, Harian, dll
            $table->text('aspek_penilaian')->nullable(); // Aspek yang dinilai
            $table->decimal('nilai', 5, 2)->nullable(); // Nilai akhir
            $table->text('catatan')->nullable();
            $table->text('detail_nilai')->nullable(); // JSON untuk detail nilai per aspek
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lembar_penilaian');
    }
};
