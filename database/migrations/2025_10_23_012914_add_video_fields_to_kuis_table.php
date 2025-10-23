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
            $table->enum('tipe_kuis', ['pilihan_ganda', 'video'])->default('pilihan_ganda')->after('mata_pelajaran');
            $table->string('video_url')->nullable()->after('tipe_kuis');
            $table->text('video_soal')->nullable()->after('video_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kuis', function (Blueprint $table) {
            $table->dropColumn(['tipe_kuis', 'video_url', 'video_soal']);
        });
    }
};
