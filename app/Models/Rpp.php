<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rpp extends Model
{
    protected $table = 'rpp';
    
    protected $fillable = [
        'guru_id',
        'judul',
        'mata_pelajaran',
        'kelas',
        'semester',
        'pertemuan_ke',
        'alokasi_waktu',
        // Identitas Pembelajaran
        'sekolah',
        'mata_pelajaran_detail',
        'kelas_detail',
        'semester_detail',
        'tahun_pelajaran',
        // Kompetensi Inti
        'ki_1',
        'ki_2',
        'ki_3',
        'ki_4',
        // KD & Indikator
        'kd_pengetahuan',
        'kd_keterampilan',
        'indikator_pencapaian_kompetensi',
        // Tujuan Pembelajaran
        'tujuan_pembelajaran',
        // Materi Pembelajaran
        'materi_pembelajaran',
        'materi_pembelajaran_reguler',
        'materi_pembelajaran_pengayaan',
        'materi_pembelajaran_remedial',
        // Metode Pembelajaran
        'metode_pembelajaran',
        // Skenario Pembelajaran
        'kegiatan_pendahuluan',
        'kegiatan_inti',
        'kegiatan_penutup',
        // Media & Sumber Ajar
        'media_pembelajaran',
        'sumber_belajar',
        // Instrumen Penilaian
        'teknik_penilaian',
        'bentuk_instrumen',
        'rubrik_penilaian',
        'kriteria_ketuntasan',
    ];

    public function guru(): BelongsTo
    {
        return $this->belongsTo(Guru::class);
    }
}
