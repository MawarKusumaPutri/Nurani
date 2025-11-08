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
        Schema::create('jadwal', function (Blueprint $table) {
            $table->id();
            $table->string('mata_pelajaran');
            $table->foreignId('guru_id')->constrained('gurus')->onDelete('cascade');
            $table->string('kelas');
            $table->string('hari'); // senin, selasa, rabu, kamis, jumat, sabtu
            $table->date('tanggal')->nullable(); // tanggal spesifik jika ada
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->string('semester'); // 1 atau 2
            $table->string('tahun_ajaran');
            $table->enum('status', ['aktif', 'nonaktif', 'sementara'])->default('aktif');
            $table->text('keterangan')->nullable();
            $table->boolean('is_berulang')->default(false);
            $table->boolean('is_lab')->default(false);
            $table->string('ruang')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            
            // Index untuk query cepat
            $table->index(['kelas', 'hari']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal');
    }
};
