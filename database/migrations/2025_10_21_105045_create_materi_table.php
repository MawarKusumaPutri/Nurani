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
        Schema::create('materi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guru_id')->constrained('gurus')->onDelete('cascade');
            $table->string('judul');
            $table->text('deskripsi');
            $table->string('kelas');
            $table->string('topik');
            $table->string('file_path')->nullable();
            $table->string('file_type')->nullable(); // PDF, video, PPT, gambar
            $table->string('file_size')->nullable();
            $table->text('konten')->nullable(); // untuk konten teks
            $table->string('link_video')->nullable(); // untuk video pembelajaran
            $table->boolean('is_published')->default(false);
            $table->timestamp('tanggal_publish')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materi');
    }
};
