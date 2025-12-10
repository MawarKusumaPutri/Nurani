<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RubrikPenilaian extends Model
{
    protected $table = 'rubrik_penilaian';
    
    protected $fillable = [
        'guru_id',
        'judul',
        'mata_pelajaran',
        'kelas',
        'semester',
        'tahun_pelajaran',
        'deskripsi',
        'kriteria_penilaian',
        'skala_nilai',
        'indikator',
    ];

    protected $casts = [
        'kriteria_penilaian' => 'array',
    ];

    public function guru(): BelongsTo
    {
        return $this->belongsTo(Guru::class);
    }

    public function lembarPenilaian(): HasMany
    {
        return $this->hasMany(LembarPenilaian::class, 'rubrik_penilaian_id');
    }
}
