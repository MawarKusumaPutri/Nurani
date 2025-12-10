<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MateriPembelajaran extends Model
{
    use HasFactory;

    protected $table = 'materi_pembelajaran';

    protected $fillable = [
        'guru_id',
        'mata_pelajaran',
        'identitas_mata_pelajaran',
        'profil_sejarah',
        'relevansi',
        'identitas_sekolah_program',
        'kompetensi_inti_capaian',
        'unit_pembelajaran',
        'pendekatan_pembelajaran',
        'model_pembelajaran',
        'kegiatan_pembelajaran',
        'penilaian',
        'sarana_prasarana',
    ];

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }
}
