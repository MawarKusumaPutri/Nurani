<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PresensiSiswa extends Model
{
    use HasFactory;

    protected $table = 'presensi_siswa';
    
    protected $fillable = [
        'siswa_id',
        'guru_id',
        'tanggal',
        'status',
        'keterangan'
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    /**
     * Get the siswa that owns the presensi.
     */
    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class);
    }

    /**
     * Get the guru that created the presensi.
     */
    public function guru(): BelongsTo
    {
        return $this->belongsTo(Guru::class);
    }

    /**
     * Get status label in Indonesian
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'hadir' => 'Hadir',
            'sakit' => 'Sakit',
            'izin' => 'Izin',
            'alfa' => 'Alfa',
            default => ucfirst($this->status)
        };
    }

    /**
     * Get status badge color
     */
    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'hadir' => 'success',
            'sakit' => 'warning',
            'izin' => 'info',
            'alfa' => 'danger',
            default => 'secondary'
        };
    }
}
