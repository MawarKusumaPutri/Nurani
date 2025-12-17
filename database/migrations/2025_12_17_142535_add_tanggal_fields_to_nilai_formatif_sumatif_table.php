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
        Schema::table('nilai_formatif_sumatif', function (Blueprint $table) {
            // Tambahkan field tanggal untuk nilai harian
            $table->date('tanggal_nilai_harian')->nullable()->after('formatif_1');
            $table->date('tanggal_nilai_harian_2')->nullable()->after('formatif_2');
            $table->date('tanggal_nilai_harian_3')->nullable()->after('formatif_3');
            $table->date('tanggal_nilai_harian_4')->nullable()->after('formatif_4');
            
            // Tambahkan field tanggal untuk UTS dan UAS
            $table->date('tanggal_uts')->nullable()->after('sumatif_uts');
            $table->date('tanggal_uas')->nullable()->after('sumatif_uas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nilai_formatif_sumatif', function (Blueprint $table) {
            $table->dropColumn([
                'tanggal_nilai_harian',
                'tanggal_nilai_harian_2',
                'tanggal_nilai_harian_3',
                'tanggal_nilai_harian_4',
                'tanggal_uts',
                'tanggal_uas'
            ]);
        });
    }
};
