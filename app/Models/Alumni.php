<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alumni extends Model
{
    protected $fillable = [
        'nis',
        'nama',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'kelas_terakhir',
        'tahun_lulus',
        'alamat',
        'no_telepon',
        'email',
        'nama_orang_tua',
        'pekerjaan_orang_tua',
        'no_telepon_orang_tua',
        'sekolah_lanjutan',
        'prestasi',
        'catatan',
        'foto',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tahun_lulus' => 'integer',
    ];
}
