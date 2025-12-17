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
        // Ubah enum menjadi string untuk fleksibilitas
        DB::statement("ALTER TABLE presensi_siswa MODIFY COLUMN aktivitas VARCHAR(50) NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Kembalikan ke enum jika diperlukan
        DB::statement("ALTER TABLE presensi_siswa MODIFY COLUMN aktivitas ENUM('aktif', 'tidak aktif') NULL");
    }
};
