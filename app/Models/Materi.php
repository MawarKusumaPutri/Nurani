<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Materi extends Model
{
    protected $table = 'materi';
    
    protected $fillable = [
        'guru_id',
        'judul',
        'deskripsi',
        'kelas',
        'mata_pelajaran',
        'topik',
        'file_path',
        'file_type',
        'file_size',
        'konten',
        'link_video',
        'is_published',
        'tanggal_publish'
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'tanggal_publish' => 'datetime'
    ];

    public function guru(): BelongsTo
    {
        return $this->belongsTo(Guru::class);
    }

    public function getFileSizeFormattedAttribute()
    {
        if (!$this->file_size) return null;
        
        $bytes = (int) $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }
}
