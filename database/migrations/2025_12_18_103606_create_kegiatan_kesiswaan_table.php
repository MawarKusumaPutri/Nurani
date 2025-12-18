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
        Schema::create('kegiatan_kesiswaan', function (Blueprint $table) {
            $table->id();
            $table->string('judul_kegiatan');
            $table->text('deskripsi')->nullable();
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai')->nullable();
            $table->string('waktu_mulai')->nullable();
            $table->string('waktu_selesai')->nullable();
            $table->string('lokasi')->nullable();
            $table->string('penanggung_jawab');
            $table->enum('status', ['rencana', 'sedang_berlangsung', 'selesai', 'dibatalkan'])->default('rencana');
            $table->decimal('anggaran', 15, 2)->nullable();
            $table->text('peserta')->nullable(); // JSON atau text untuk menyimpan daftar peserta
            $table->text('catatan')->nullable();
            $table->text('hasil_kegiatan')->nullable(); // Untuk laporan
            $table->text('evaluasi')->nullable(); // Untuk laporan
            $table->string('dokumen_lampiran')->nullable(); // Path file lampiran
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kegiatan_kesiswaan');
    }
};
