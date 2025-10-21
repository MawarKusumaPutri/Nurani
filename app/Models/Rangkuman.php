<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rangkuman extends Model
{
    protected $table = 'rangkuman';
    
    protected $fillable = [
        'guru_id',
        'kelas',
        'mata_pelajaran',
        'tanggal_pertemuan',
        'materi_yang_diajarkan',
        'capaian_pembelajaran',
        'catatan_tambahan',
        'file_lampiran',
        'is_complete',
        'tanggal_selesai'
    ];

    protected $casts = [
        'tanggal_pertemuan' => 'date',
        'file_lampiran' => 'array',
        'is_complete' => 'boolean',
        'tanggal_selesai' => 'datetime'
    ];

    public function guru(): BelongsTo
    {
        return $this->belongsTo(Guru::class);
    }

    public function getBulanAttribute()
    {
        return $this->tanggal_pertemuan->format('F Y');
    }
}
