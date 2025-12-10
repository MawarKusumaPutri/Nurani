<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RekapHasilBelajar extends Model
{
    protected $table = 'rekap_hasil_belajar';
    
    protected $fillable = [
        'guru_id',
        'siswa_id',
        'kelas',
        'semester',
        'tahun_pelajaran',
        'mata_pelajaran',
        'nilai_formatif',
        'nilai_sumatif',
        'nilai_akhir',
        'predikat',
        'total_mata_pelajaran',
        'rata_rata_semua_mapel',
        'jumlah_mapel_tuntas',
        'jumlah_mapel_tidak_tuntas',
        'catatan',
    ];

    protected $casts = [
        'nilai_formatif' => 'decimal:2',
        'nilai_sumatif' => 'decimal:2',
        'nilai_akhir' => 'decimal:2',
        'rata_rata_semua_mapel' => 'decimal:2',
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
