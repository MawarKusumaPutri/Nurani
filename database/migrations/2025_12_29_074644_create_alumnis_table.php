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
        Schema::create('alumnis', function (Blueprint $table) {
            $table->id();
            $table->string('nis')->unique();
            $table->string('nama');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('kelas_terakhir'); // Kelas 7, 8, atau 9
            $table->year('tahun_lulus');
            $table->text('alamat')->nullable();
            $table->string('no_telepon')->nullable();
            $table->string('email')->nullable();
            $table->string('nama_orang_tua')->nullable();
            $table->string('pekerjaan_orang_tua')->nullable();
            $table->string('no_telepon_orang_tua')->nullable();
            $table->string('sekolah_lanjutan')->nullable(); // SMA/SMK yang dituju
            $table->text('prestasi')->nullable();
            $table->text('catatan')->nullable();
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumnis');
    }
};
