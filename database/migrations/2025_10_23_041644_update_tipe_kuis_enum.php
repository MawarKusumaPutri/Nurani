<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update the enum to include 'esai'
        DB::statement("ALTER TABLE kuis MODIFY COLUMN tipe_kuis ENUM('pilihan_ganda', 'video', 'esai') DEFAULT 'pilihan_ganda'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to original enum
        DB::statement("ALTER TABLE kuis MODIFY COLUMN tipe_kuis ENUM('pilihan_ganda', 'video') DEFAULT 'pilihan_ganda'");
    }
};