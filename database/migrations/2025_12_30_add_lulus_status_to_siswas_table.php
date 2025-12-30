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
        // Modify status column to accept 'lulus' value
        DB::statement("ALTER TABLE `siswas` MODIFY COLUMN `status` ENUM('aktif', 'tidak_aktif', 'lulus') NOT NULL DEFAULT 'aktif'");
        
        // Add tahun_lulus column if not exists
        if (!Schema::hasColumn('siswas', 'tahun_lulus')) {
            Schema::table('siswas', function (Blueprint $table) {
                $table->year('tahun_lulus')->nullable()->after('status');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert status column
        DB::statement("ALTER TABLE `siswas` MODIFY COLUMN `status` ENUM('aktif', 'tidak_aktif') NOT NULL DEFAULT 'aktif'");
        
        // Drop tahun_lulus column
        if (Schema::hasColumn('siswas', 'tahun_lulus')) {
            Schema::table('siswas', function (Blueprint $table) {
                $table->dropColumn('tahun_lulus');
            });
        }
    }
};
