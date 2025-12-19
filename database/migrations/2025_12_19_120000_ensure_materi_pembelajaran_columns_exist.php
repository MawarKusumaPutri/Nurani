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
        // Pastikan tabel sudah ada
        if (!Schema::hasTable('materi_pembelajaran')) {
            return;
        }
        
        Schema::table('materi_pembelajaran', function (Blueprint $table) {
            // A. IDENTITAS SEKOLAH DAN PROGRAM
            if (!Schema::hasColumn('materi_pembelajaran', 'identitas_sekolah_program')) {
                $table->longText('identitas_sekolah_program')->nullable()->after('relevansi');
            }
            
            // B. KOMPETENSI INTI DAN CAPAIAN PEMBELAJARAN
            if (!Schema::hasColumn('materi_pembelajaran', 'kompetensi_inti_capaian')) {
                $table->longText('kompetensi_inti_capaian')->nullable()->after('identitas_sekolah_program');
            }
            
            // C. UNIT-UNIT PEMBELAJARAN
            if (!Schema::hasColumn('materi_pembelajaran', 'unit_pembelajaran')) {
                $table->longText('unit_pembelajaran')->nullable()->after('kompetensi_inti_capaian');
            }
            
            // D. PENDEKATAN PEMBELAJARAN HUMANIS
            if (!Schema::hasColumn('materi_pembelajaran', 'pendekatan_pembelajaran')) {
                $table->longText('pendekatan_pembelajaran')->nullable()->after('unit_pembelajaran');
            }
            
            // E. MODEL-MODEL PEMBELAJARAN YANG DIGUNAKAN
            if (!Schema::hasColumn('materi_pembelajaran', 'model_pembelajaran')) {
                $table->longText('model_pembelajaran')->nullable()->after('pendekatan_pembelajaran');
            }
            
            // F. KEGIATAN PEMBELAJARAN: STRUKTUR UMUM SETIAP PERTEMUAN
            if (!Schema::hasColumn('materi_pembelajaran', 'kegiatan_pembelajaran')) {
                $table->longText('kegiatan_pembelajaran')->nullable()->after('model_pembelajaran');
            }
            
            // G. PENILAIAN (ASSESSMENT)
            if (!Schema::hasColumn('materi_pembelajaran', 'penilaian')) {
                $table->longText('penilaian')->nullable()->after('kegiatan_pembelajaran');
            }
            
            // H. SARANA DAN PRASARANA
            if (!Schema::hasColumn('materi_pembelajaran', 'sarana_prasarana')) {
                $table->longText('sarana_prasarana')->nullable()->after('penilaian');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('materi_pembelajaran', function (Blueprint $table) {
            if (Schema::hasColumn('materi_pembelajaran', 'identitas_sekolah_program')) {
                $table->dropColumn('identitas_sekolah_program');
            }
            if (Schema::hasColumn('materi_pembelajaran', 'kompetensi_inti_capaian')) {
                $table->dropColumn('kompetensi_inti_capaian');
            }
            if (Schema::hasColumn('materi_pembelajaran', 'unit_pembelajaran')) {
                $table->dropColumn('unit_pembelajaran');
            }
            if (Schema::hasColumn('materi_pembelajaran', 'pendekatan_pembelajaran')) {
                $table->dropColumn('pendekatan_pembelajaran');
            }
            if (Schema::hasColumn('materi_pembelajaran', 'model_pembelajaran')) {
                $table->dropColumn('model_pembelajaran');
            }
            if (Schema::hasColumn('materi_pembelajaran', 'kegiatan_pembelajaran')) {
                $table->dropColumn('kegiatan_pembelajaran');
            }
            if (Schema::hasColumn('materi_pembelajaran', 'penilaian')) {
                $table->dropColumn('penilaian');
            }
            if (Schema::hasColumn('materi_pembelajaran', 'sarana_prasarana')) {
                $table->dropColumn('sarana_prasarana');
            }
        });
    }
};

