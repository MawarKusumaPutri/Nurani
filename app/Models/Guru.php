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
        'status'
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
}