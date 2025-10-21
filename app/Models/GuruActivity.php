<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GuruActivity extends Model
{
    protected $table = 'guru_activity';
    
    protected $fillable = [
        'guru_id',
        'activity_type',
        'description',
        'metadata',
        'activity_time',
        'ip_address',
        'user_agent'
    ];

    protected $casts = [
        'metadata' => 'array',
        'activity_time' => 'datetime'
    ];

    public function guru(): BelongsTo
    {
        return $this->belongsTo(Guru::class);
    }

    public function getActivityIconAttribute()
    {
        $icons = [
            'login' => 'fas fa-sign-in-alt',
            'logout' => 'fas fa-sign-out-alt',
            'create_materi' => 'fas fa-book',
            'create_kuis' => 'fas fa-question-circle',
            'create_rangkuman' => 'fas fa-clipboard-list',
            'update_profil' => 'fas fa-user-edit',
            'view_dashboard' => 'fas fa-home'
        ];

        return $icons[$this->activity_type] ?? 'fas fa-circle';
    }

    public function getActivityColorAttribute()
    {
        $colors = [
            'login' => 'success',
            'logout' => 'warning',
            'create_materi' => 'primary',
            'create_kuis' => 'info',
            'create_rangkuman' => 'secondary',
            'update_profil' => 'dark',
            'view_dashboard' => 'light'
        ];

        return $colors[$this->activity_type] ?? 'light';
    }
}
