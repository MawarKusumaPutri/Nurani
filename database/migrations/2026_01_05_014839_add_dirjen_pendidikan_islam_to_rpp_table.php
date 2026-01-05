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
        Schema::table('rpp', function (Blueprint $table) {
            $table->string('nama_kantor')->nullable()->after('ttd_kepala_sekolah');
            $table->string('kota_kabupaten')->nullable()->after('nama_kantor');
            $table->text('alamat_lengkap')->nullable()->after('kota_kabupaten');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rpp', function (Blueprint $table) {
            $table->dropColumn(['nama_kantor', 'kota_kabupaten', 'alamat_lengkap']);
        });
    }
};
