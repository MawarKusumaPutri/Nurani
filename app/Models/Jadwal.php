<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Jadwal extends Model
{
    protected $table = 'jadwal';
    
    protected $fillable = [
        'mata_pelajaran',
        'guru_id',
        'kelas',
        'hari',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'semester',
        'tahun_ajaran',
        'status',
        'keterangan',
        'is_berulang',
        'is_lab',
        'is_lapangan',
        'ruang',
        'created_by'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'is_berulang' => 'boolean',
        'is_lab' => 'boolean',
        'is_lapangan' => 'boolean'
    ];

    /**
     * Get the guru that owns the jadwal.
     */
    public function guru(): BelongsTo
    {
        return $this->belongsTo(Guru::class);
    }

    /**
     * Get the user who created the jadwal.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get formatted hari name
     */
    public function getHariNamaAttribute(): string
    {
        $hariMap = [
            'minggu' => 'Minggu',
            'senin' => 'Senin',
            'selasa' => 'Selasa',
            'rabu' => 'Rabu',
            'kamis' => 'Kamis',
            'jumat' => 'Jumat',
            'sabtu' => 'Sabtu'
        ];
        
        return $hariMap[strtolower($this->hari)] ?? ucfirst($this->hari);
    }

    /**
     * Get formatted mata pelajaran name
     */
    public function getMataPelajaranNamaAttribute(): string
    {
        $map = [
            'matematika' => 'Matematika',
            'bahasa_indonesia' => 'Bahasa Indonesia',
            'bahasa_inggris' => 'Bahasa Inggris',
            'ipa' => 'IPA',
            'ips' => 'IPS',
            'pendidikan_agama' => 'Pendidikan Agama',
            'pendidikan_kewarganegaraan' => 'Pendidikan Kewarganegaraan',
            'pendidikan_jasmani' => 'Pendidikan Jasmani',
            'seni_budaya' => 'Seni Budaya',
            'teknologi_informasi' => 'Teknologi Informasi',
            'lainnya' => 'Lainnya'
        ];
        
        return $map[$this->mata_pelajaran] ?? ucfirst(str_replace('_', ' ', $this->mata_pelajaran));
    }
}
