<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Event extends Model
{
    protected $table = 'events';
    
    protected $fillable = [
        'judul_event',
        'kategori_event',
        'tanggal_mulai',
        'tanggal_selesai',
        'waktu_mulai',
        'waktu_selesai',
        'deskripsi',
        'lokasi',
        'penanggung_jawab',
        'warna',
        'is_all_day',
        'is_public',
        'is_important',
        'is_recurring',
        'created_by'
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'is_all_day' => 'boolean',
        'is_public' => 'boolean',
        'is_important' => 'boolean',
        'is_recurring' => 'boolean'
    ];

    /**
     * Get the user who created the event.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
