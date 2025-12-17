<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NilaiFormatifSumatif extends Model
{
    protected $table = 'nilai_formatif_sumatif';
    
    protected $fillable = [
        'guru_id',
        'siswa_id',
        'mata_pelajaran',
        'kelas',
        'semester',
        'tahun_pelajaran',
        'formatif_1',
        'tanggal_nilai_harian',
        'formatif_2',
        'tanggal_nilai_harian_2',
        'formatif_3',
        'tanggal_nilai_harian_3',
        'formatif_4',
        'tanggal_nilai_harian_4',
        'rata_formatif',
        'sumatif_uts',
        'tanggal_uts',
        'sumatif_uas',
        'tanggal_uas',
        'rata_sumatif',
        'nilai_akhir',
        'predikat',
        'keterangan',
    ];

    protected $casts = [
        'formatif_1' => 'decimal:2',
        'formatif_2' => 'decimal:2',
        'formatif_3' => 'decimal:2',
        'formatif_4' => 'decimal:2',
        'rata_formatif' => 'decimal:2',
        'sumatif_uts' => 'decimal:2',
        'sumatif_uas' => 'decimal:2',
        'rata_sumatif' => 'decimal:2',
        'nilai_akhir' => 'decimal:2',
        'tanggal_nilai_harian' => 'date',
        'tanggal_nilai_harian_2' => 'date',
        'tanggal_nilai_harian_3' => 'date',
        'tanggal_nilai_harian_4' => 'date',
        'tanggal_uts' => 'date',
        'tanggal_uas' => 'date',
    ];

    public function guru(): BelongsTo
    {
        return $this->belongsTo(Guru::class);
    }

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class);
    }
}
