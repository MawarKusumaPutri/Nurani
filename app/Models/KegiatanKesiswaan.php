<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KegiatanKesiswaan extends Model
{
    protected $table = 'kegiatan_kesiswaan';
    
    protected $fillable = [
        'judul_kegiatan',
        'deskripsi',
        'tanggal_mulai',
        'tanggal_selesai',
        'waktu_mulai',
        'waktu_selesai',
        'lokasi',
        'penanggung_jawab',
        'status',
        'anggaran',
        'peserta',
        'catatan',
        'hasil_kegiatan',
        'evaluasi',
        'dokumen_lampiran',
        'created_by',
    ];
    
    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'anggaran' => 'decimal:2',
    ];
    
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'rencana' => 'Rencana',
            'sedang_berlangsung' => 'Sedang Berlangsung',
            'selesai' => 'Selesai',
            'dibatalkan' => 'Dibatalkan',
            default => $this->status
        };
    }
    
    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'rencana' => 'bg-info',
            'sedang_berlangsung' => 'bg-warning',
            'selesai' => 'bg-success',
            'dibatalkan' => 'bg-danger',
            default => 'bg-secondary'
        };
    }
}
