<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kuis extends Model
{
    protected $table = 'kuis';
    
    protected $fillable = [
        'guru_id',
        'judul',
        'deskripsi',
        'kelas',
        'mata_pelajaran',
        'soal',
        'durasi_menit',
        'tanggal_mulai',
        'tanggal_selesai',
        'is_active'
    ];

    protected $casts = [
        'soal' => 'array',
        'tanggal_mulai' => 'datetime',
        'tanggal_selesai' => 'datetime',
        'is_active' => 'boolean'
    ];

    public function guru(): BelongsTo
    {
        return $this->belongsTo(Guru::class);
    }

    public function getStatusAttribute()
    {
        $now = now();
        
        if ($now < $this->tanggal_mulai) {
            return 'belum_mulai';
        } elseif ($now > $this->tanggal_selesai) {
            return 'selesai';
        } else {
            return 'berlangsung';
        }
    }
}
