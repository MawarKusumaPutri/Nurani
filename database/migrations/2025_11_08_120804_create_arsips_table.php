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
        Schema::create('arsips', function (Blueprint $table) {
            $table->id();
            $table->string('kategori');
            $table->string('judul_dokumen');
            $table->text('deskripsi')->nullable();
            $table->date('tanggal_dokumen')->nullable();
            $table->string('pembuat');
            $table->string('prioritas')->default('sedang');
            $table->string('file_dokumen');
            $table->bigInteger('ukuran_file')->nullable();
            $table->string('tipe_file')->nullable();
            $table->boolean('is_public')->default(false);
            $table->boolean('is_important')->default(false);
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            
            // Index untuk query cepat
            $table->index('kategori');
            $table->index('tanggal_dokumen');
            $table->index('is_public');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('arsips');
    }
};
