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
        Schema::table('rubrik_penilaian', function (Blueprint $table) {
            $table->text('kriteria_penilaian')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rubrik_penilaian', function (Blueprint $table) {
            $table->text('kriteria_penilaian')->nullable(false)->change();
        });
    }
};

