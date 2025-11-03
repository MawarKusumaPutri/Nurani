<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Guru extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nip',
        'mata_pelajaran',
        'status',
        'foto'
    ];

    /**
     * Get the user that owns the guru.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the materi for the guru.
     */
    public function materi(): HasMany
    {
        return $this->hasMany(Materi::class);
    }

    /**
     * Get the kuis for the guru.
     */
    public function kuis(): HasMany
    {
        return $this->hasMany(Kuis::class);
    }

    /**
     * Get the rangkuman for the guru.
     */
    public function rangkuman(): HasMany
    {
        return $this->hasMany(Rangkuman::class);
    }

    /**
     * Get the mata pelajaran for the guru.
     */
    public function mataPelajaran(): HasMany
    {
        return $this->hasMany(GuruMataPelajaran::class);
    }

    /**
     * Get active mata pelajaran for the guru.
     */
    public function getMataPelajaranAktifAttribute()
    {
        if (!$this->mata_pelajaran || $this->mata_pelajaran === 'Belum ditentukan') {
            return collect();
        }
        
        $subjects = explode(', ', $this->mata_pelajaran);
        return collect($subjects)->map(function ($subject) {
            return (object)['mata_pelajaran' => trim($subject)];
        });
    }

    /**
     * Get the activities for the guru.
     */
    public function activities(): HasMany
    {
        return $this->hasMany(GuruActivity::class);
    }

    /**
     * Get recent activities for the guru.
     */
    public function recentActivities(): HasMany
    {
        return $this->hasMany(GuruActivity::class)->orderBy('activity_time', 'desc');
    }

    /**
     * Get the presensi for the guru.
     */
    public function presensi(): HasMany
    {
        return $this->hasMany(Presensi::class);
    }
}