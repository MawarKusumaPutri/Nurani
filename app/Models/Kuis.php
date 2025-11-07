<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kuis extends Model
{
    protected $table = 'kuis';
    
    protected $fillable = [
        'guru_id',
        'judul',
        'deskripsi',
        'kelas',
        'mata_pelajaran',
        'tipe_kuis',
        'video_url',
        'video_title',
        'video_thumbnail',
        'video_soal',
        'soal',
        'esai_soal',
        'esai_petunjuk',
        'durasi_menit',
        'tanggal_mulai',
        'tanggal_selesai',
        'tanggal_dibuat',
        'hari_dibuat',
        'waktu_dibuat',
        'zona_waktu',
        'is_active'
    ];

    protected $casts = [
        'soal' => 'array',
        'tanggal_mulai' => 'datetime',
        'tanggal_selesai' => 'datetime',
        'is_active' => 'boolean'
    ];

    public function guru(): BelongsTo
    {
        return $this->belongsTo(Guru::class);
    }

    public function getStatusAttribute()
    {
        $now = now();
        
        if ($now < $this->tanggal_mulai) {
            return 'belum_mulai';
        } elseif ($now > $this->tanggal_selesai) {
            return 'selesai';
        } else {
            return 'berlangsung';
        }
    }

    public function getEmbedUrl()
    {
        if (!$this->video_url) {
            return null;
        }

        // Extract video ID from YouTube URL
        $videoId = $this->extractVideoId($this->video_url);
        
        if (!$videoId) {
            // Log for debugging
            \Log::error('Failed to extract video ID from URL: ' . $this->video_url);
            return null;
        }

        $embedUrl = "https://www.youtube.com/embed/{$videoId}";
        
        // Log for debugging
        \Log::info('Generated embed URL: ' . $embedUrl);
        
        return $embedUrl;
    }

    private function extractVideoId($url)
    {
        // Handle different YouTube URL formats
        $patterns = [
            '/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]+)/',
            '/youtube\.com\/embed\/([a-zA-Z0-9_-]+)/',
            '/youtube\.com\/v\/([a-zA-Z0-9_-]+)/',
            '/youtube\.com\/watch\?.*v=([a-zA-Z0-9_-]+)/',
            '/youtu\.be\/([a-zA-Z0-9_-]+)/'
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $url, $matches)) {
                \Log::info('Extracted video ID: ' . $matches[1] . ' from URL: ' . $url);
                return $matches[1];
            }
        }

        \Log::error('No video ID found in URL: ' . $url);
        return null;
    }
}
