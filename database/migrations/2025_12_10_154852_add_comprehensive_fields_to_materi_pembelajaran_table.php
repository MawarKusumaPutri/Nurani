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
        // Pastikan tabel sudah ada sebelum menambahkan kolom
        if (!Schema::hasTable('materi_pembelajaran')) {
            return;
        }
        
        Schema::table('materi_pembelajaran', function (Blueprint $table) {
            // A. IDENTITAS SEKOLAH DAN PROGRAM
            $table->longText('identitas_sekolah_program')->nullable()->after('relevansi');
            
            // B. KOMPETENSI INTI DAN CAPAIAN PEMBELAJARAN
            $table->longText('kompetensi_inti_capaian')->nullable()->after('identitas_sekolah_program');
            
            // C. UNIT-UNIT PEMBELAJARAN
            $table->longText('unit_pembelajaran')->nullable()->after('kompetensi_inti_capaian');
            
            // D. PENDEKATAN PEMBELAJARAN HUMANIS
            $table->longText('pendekatan_pembelajaran')->nullable()->after('unit_pembelajaran');
            
            // E. MODEL-MODEL PEMBELAJARAN YANG DIGUNAKAN
            $table->longText('model_pembelajaran')->nullable()->after('pendekatan_pembelajaran');
            
            // F. KEGIATAN PEMBELAJARAN: STRUKTUR UMUM SETIAP PERTEMUAN
            $table->longText('kegiatan_pembelajaran')->nullable()->after('model_pembelajaran');
            
            // G. PENILAIAN (ASSESSMENT)
            $table->longText('penilaian')->nullable()->after('kegiatan_pembelajaran');
            
            // H. SARANA DAN PRASARANA
            $table->longText('sarana_prasarana')->nullable()->after('penilaian');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('materi_pembelajaran', function (Blueprint $table) {
            $table->dropColumn([
                'identitas_sekolah_program',
                'kompetensi_inti_capaian',
                'unit_pembelajaran',
                'pendekatan_pembelajaran',
                'model_pembelajaran',
                'kegiatan_pembelajaran',
                'penilaian',
                'sarana_prasarana',
            ]);
        });
    }
};
