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
        Schema::table('rpps', function (Blueprint $table) {
            $table->string('kepala_sekolah_nama')->nullable()->after('kriteria_ketuntasan');
            $table->string('kepala_sekolah_nip')->nullable()->after('kepala_sekolah_nama');
            $table->string('ttd_kepala_sekolah')->nullable()->after('kepala_sekolah_nip');
            $table->string('ttd_guru')->nullable()->after('ttd_kepala_sekolah');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rpps', function (Blueprint $table) {
            $table->dropColumn(['kepala_sekolah_nama', 'kepala_sekolah_nip', 'ttd_kepala_sekolah', 'ttd_guru']);
        });
    }
};
