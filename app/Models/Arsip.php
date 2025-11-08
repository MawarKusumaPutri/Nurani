<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Arsip extends Model
{
    use HasFactory;
    
    protected $table = 'arsips';
    
    protected $fillable = [
        'kategori',
        'judul_dokumen',
        'deskripsi',
        'tanggal_dokumen',
        'pembuat',
        'prioritas',
        'file_dokumen',
        'ukuran_file',
        'tipe_file',
        'is_public',
        'is_important',
        'created_by'
    ];
    
    protected $casts = [
        'tanggal_dokumen' => 'date',
        'is_public' => 'boolean',
        'is_important' => 'boolean',
        'ukuran_file' => 'integer'
    ];
    
    /**
     * Get the user who created the arsip.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
