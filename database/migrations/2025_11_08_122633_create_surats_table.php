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
        Schema::create('surats', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_surat');
            $table->string('nomor_surat');
            $table->date('tanggal_surat');
            $table->string('perihal');
            $table->string('penerima');
            $table->string('penerima_lainnya')->nullable();
            $table->text('isi_surat');
            $table->string('pembuat_surat');
            $table->string('jabatan_pembuat')->nullable();
            $table->string('prioritas')->default('biasa');
            $table->string('lampiran')->nullable();
            $table->boolean('cc_email')->default(false);
            $table->boolean('arsipkan')->default(true);
            $table->string('status')->default('draft'); // draft, terkirim, diterima
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            
            // Index untuk query cepat
            $table->index('jenis_surat');
            $table->index('status');
            $table->index('tanggal_surat');
            $table->index('created_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surats');
    }
};
