<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Surat extends Model
{
    protected $table = 'surats';
    
    protected $fillable = [
        'tipe_surat',
        'jenis_surat',
        'nomor_surat',
        'tanggal_surat',
        'perihal',
        'penerima',
        'penerima_lainnya',
        'pengirim',
        'isi_surat',
        'pembuat_surat',
        'jabatan_pembuat',
        'prioritas',
        'lampiran',
        'cc_email',
        'arsipkan',
        'status',
        'created_by',
    ];
    
    protected $casts = [
        'tanggal_surat' => 'date',
        'cc_email' => 'boolean',
        'arsipkan' => 'boolean',
    ];
    
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
