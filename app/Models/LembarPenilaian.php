<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LembarPenilaian extends Model
{
    protected $table = 'lembar_penilaian';
    
    protected $fillable = [
        'guru_id',
        'siswa_id',
        'rubrik_penilaian_id',
        'mata_pelajaran',
        'kelas',
        'semester',
        'tahun_pelajaran',
        'tanggal_penilaian',
        'jenis_penilaian',
        'aspek_penilaian',
        'nilai',
        'catatan',
        'detail_nilai',
    ];

    protected $casts = [
        'tanggal_penilaian' => 'date',
        'nilai' => 'decimal:2',
        'detail_nilai' => 'array',
    ];

    public function guru(): BelongsTo
    {
        return $this->belongsTo(Guru::class);
    }

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class);
    }

    public function rubrikPenilaian(): BelongsTo
    {
        return $this->belongsTo(RubrikPenilaian::class, 'rubrik_penilaian_id');
    }
}
