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
        Schema::table('kuis', function (Blueprint $table) {
            $table->date('tanggal_dibuat')->nullable()->after('tanggal_selesai');
            $table->string('hari_dibuat', 20)->nullable()->after('tanggal_dibuat');
            $table->time('waktu_dibuat')->nullable()->after('hari_dibuat');
            $table->string('zona_waktu', 10)->nullable()->after('waktu_dibuat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kuis', function (Blueprint $table) {
            $table->dropColumn(['tanggal_dibuat', 'hari_dibuat', 'waktu_dibuat', 'zona_waktu']);
        });
    }
};
