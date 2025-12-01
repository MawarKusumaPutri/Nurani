<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Presensi extends Model
{
    protected $table = 'presensi';
    
    protected $fillable = [
        'guru_id',
        'tanggal',
        'jenis',
        'jam_masuk',
        'jam_keluar',
        'keterangan',
        'surat_sakit',
        'tugas_kelas7',
        'tugas_kelas8',
        'tugas_kelas9',
        'status_verifikasi',
        'verified_by',
        'verified_at',
        'tugas_kelas_7',
        'tugas_kelas_8',
        'tugas_kelas_9',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'verified_at' => 'datetime'
    ];

    /**
     * Get the guru that owns the presensi.
     */
    public function guru(): BelongsTo
    {
        return $this->belongsTo(Guru::class);
    }

    /**
     * Get the user who verified the presensi.
     */
    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    /**
     * Check if presensi is pending verification
     */
    public function isPending(): bool
    {
        return $this->status_verifikasi === 'pending';
    }

    /**
     * Check if presensi is approved
     */
    public function isApproved(): bool
    {
        return $this->status_verifikasi === 'approved';
    }

    /**
     * Check if presensi is rejected
     */
    public function isRejected(): bool
    {
        return $this->status_verifikasi === 'rejected';
    }
}
