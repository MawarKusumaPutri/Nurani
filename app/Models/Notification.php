<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'title',
        'message',
        'data',
        'is_read',
        'read_at'
    ];

    protected $casts = [
        'data' => 'array',
        'is_read' => 'boolean',
        'read_at' => 'datetime'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getIconAttribute()
    {
        $icons = [
            'guru_login' => 'fas fa-sign-in-alt',
            'guru_logout' => 'fas fa-sign-out-alt',
            'guru_activity' => 'fas fa-bell',
            'guru_create_materi' => 'fas fa-book',
            'guru_create_kuis' => 'fas fa-question-circle',
            'guru_create_rangkuman' => 'fas fa-clipboard-list'
        ];

        return $icons[$this->type] ?? 'fas fa-bell';
    }

    public function getColorAttribute()
    {
        $colors = [
            'guru_login' => 'success',
            'guru_logout' => 'warning',
            'guru_activity' => 'info',
            'guru_create_materi' => 'primary',
            'guru_create_kuis' => 'info',
            'guru_create_rangkuman' => 'secondary'
        ];

        return $colors[$this->type] ?? 'info';
    }

    public function markAsRead()
    {
        $this->update([
            'is_read' => true,
            'read_at' => now()
        ]);
    }
}
