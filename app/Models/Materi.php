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
        'jumlah_pertemuan',
        'pertemuan_selesai',
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
        'tanggal_publish' => 'datetime',
        'pertemuan_selesai' => 'array'
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

    /**
     * Get persentase pertemuan yang sudah selesai
     */
    public function getPersentaseSelesaiAttribute()
    {
        if (!$this->jumlah_pertemuan || $this->jumlah_pertemuan == 0) {
            return 0;
        }
        
        $selesai = is_array($this->pertemuan_selesai) ? count($this->pertemuan_selesai) : 0;
        return round(($selesai / $this->jumlah_pertemuan) * 100);
    }

    /**
     * Get jumlah pertemuan yang sudah selesai
     */
    public function getJumlahSelesaiAttribute()
    {
        return is_array($this->pertemuan_selesai) ? count($this->pertemuan_selesai) : 0;
    }

    /**
     * Get jumlah pertemuan yang belum selesai
     */
    public function getJumlahBelumSelesaiAttribute()
    {
        return $this->jumlah_pertemuan - $this->jumlah_selesai;
    }

    /**
     * Check apakah pertemuan tertentu sudah selesai
     */
    public function isPertemuanSelesai($nomorPertemuan)
    {
        if (!is_array($this->pertemuan_selesai)) {
            return false;
        }
        return in_array($nomorPertemuan, $this->pertemuan_selesai);
    }

    /**
     * Toggle status pertemuan
     */
    public function togglePertemuan($nomorPertemuan)
    {
        $selesai = is_array($this->pertemuan_selesai) ? $this->pertemuan_selesai : [];
        
        if (in_array($nomorPertemuan, $selesai)) {
            // Remove dari array
            $selesai = array_values(array_diff($selesai, [$nomorPertemuan]));
        } else {
            // Tambah ke array
            $selesai[] = $nomorPertemuan;
            sort($selesai);
        }
        
        $this->pertemuan_selesai = $selesai;
        $this->save();
        
        return $this;
    }
}
