<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswas';

    protected $fillable = [
        'nis',
        'nama',
        'kelas',
        'jenis_kelamin',
        'tanggal_lahir',
        'status',
        'tahun_lulus',
        'alamat',
        'no_telp',
        'email',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    /**
     * Get the presensi records for the siswa.
     */
    public function presensi()
    {
        return $this->hasMany(PresensiSiswa::class);
    }
}
