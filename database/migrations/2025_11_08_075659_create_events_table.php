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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('judul_event');
            $table->string('kategori_event');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai')->nullable();
            $table->time('waktu_mulai')->nullable();
            $table->time('waktu_selesai')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('lokasi')->nullable();
            $table->string('penanggung_jawab');
            $table->string('warna')->default('#6c757d');
            $table->boolean('is_all_day')->default(false);
            $table->boolean('is_public')->default(true);
            $table->boolean('is_important')->default(false);
            $table->boolean('is_recurring')->default(false);
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            
            // Index untuk query cepat
            $table->index('tanggal_mulai');
            $table->index('kategori_event');
            $table->index('is_public');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
