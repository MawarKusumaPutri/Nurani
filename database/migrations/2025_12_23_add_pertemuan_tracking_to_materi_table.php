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
        Schema::table('materi', function (Blueprint $table) {
            $table->integer('jumlah_pertemuan')->default(1)->after('topik');
            $table->json('pertemuan_selesai')->nullable()->after('jumlah_pertemuan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('materi', function (Blueprint $table) {
            $table->dropColumn(['jumlah_pertemuan', 'pertemuan_selesai']);
        });
    }
};
