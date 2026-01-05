<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rpp extends Model
{
    use HasFactory;

    protected $table = 'rpp';

    protected $fillable = [
        'guru_id',
        'judul',
        'mata_pelajaran',
        'kelas',
        'semester',
        'pertemuan_ke',
        'alokasi_waktu',
        'sekolah',
        'mata_pelajaran_detail',
        'kelas_detail',
        'semester_detail',
        'tahun_pelajaran',
        'ki_1',
        'ki_2',
        'ki_3',
        'ki_4',
        'kd_pengetahuan',
        'kd_keterampilan',
        'indikator_pencapaian_kompetensi',
        'tujuan_pembelajaran',
        'materi_pembelajaran',
        'materi_pembelajaran_reguler',
        'materi_pembelajaran_pengayaan',
        'materi_pembelajaran_remedial',
        'metode_pembelajaran',
        'kegiatan_pendahuluan',
        'kegiatan_inti',
        'kegiatan_penutup',
        'media_pembelajaran',
        'sumber_belajar',
        'teknik_penilaian',
        'bentuk_instrumen',
        'rubrik_penilaian',
        'kriteria_ketuntasan',
        'nama_kepala_sekolah',
        'nip_kepala_sekolah',
        'ttd_kepala_sekolah',
    ];

    /**
     * Relasi ke model Guru
     */
    public function guru()
    {
        return $this->belongsTo(Guru::class, 'guru_id');
    }
}
