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
            $table->text('esai_soal')->nullable()->after('soal');
            $table->text('esai_petunjuk')->nullable()->after('esai_soal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kuis', function (Blueprint $table) {
            $table->dropColumn(['esai_soal', 'esai_petunjuk']);
        });
    }
};