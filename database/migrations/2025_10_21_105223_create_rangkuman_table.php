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
        Schema::create('rangkuman', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guru_id')->constrained('gurus')->onDelete('cascade');
            $table->string('kelas');
            $table->string('mata_pelajaran');
            $table->date('tanggal_pertemuan');
            $table->text('materi_yang_diajarkan');
            $table->text('capaian_pembelajaran');
            $table->text('catatan_tambahan')->nullable();
            $table->json('file_lampiran')->nullable(); // array file yang dilampirkan
            $table->boolean('is_complete')->default(false);
            $table->timestamp('tanggal_selesai')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rangkuman');
    }
};
