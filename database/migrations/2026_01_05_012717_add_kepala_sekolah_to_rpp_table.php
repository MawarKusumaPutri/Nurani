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
            $table->string('nama_kepala_sekolah')->nullable()->after('rubrik_penilaian');
            $table->string('nip_kepala_sekolah')->nullable()->after('nama_kepala_sekolah');
            $table->string('ttd_kepala_sekolah')->nullable()->after('nip_kepala_sekolah');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rpp', function (Blueprint $table) {
            $table->dropColumn(['nama_kepala_sekolah', 'nip_kepala_sekolah', 'ttd_kepala_sekolah']);
        });
    }
};
