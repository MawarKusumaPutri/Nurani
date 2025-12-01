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
        Schema::table('presensi', function (Blueprint $table) {
            $table->text('tugas_kelas7')->nullable()->after('keterangan');
            $table->text('tugas_kelas8')->nullable()->after('tugas_kelas7');
            $table->text('tugas_kelas9')->nullable()->after('tugas_kelas8');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('presensi', function (Blueprint $table) {
            $table->dropColumn(['tugas_kelas7', 'tugas_kelas8', 'tugas_kelas9']);
        });
    }
};

