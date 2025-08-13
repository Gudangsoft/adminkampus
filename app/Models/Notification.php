<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'message',
        'type',
        'action_url',
        'icon',
        'target_users',
        'send_to_all',
        'is_sent',
        'scheduled_at',
        'sent_at',
        'created_by'
    ];

    protected $casts = [
        'target_users' => 'array',
        'send_to_all' => 'boolean',
        'is_sent' => 'boolean',
        'scheduled_at' => 'datetime',
        'sent_at' => 'datetime',
    ];

    /**
     * Get the user who created this notification
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get type badge color
     */
    public function getTypeBadgeAttribute()
    {
        return match($this->type) {
            'success' => 'success',
            'warning' => 'warning',
            'error' => 'danger',
            default => 'primary'
        };
    }

    /**
     * Get type icon
     */
    public function getTypeIconAttribute()
    {
        return match($this->type) {
            'success' => 'fas fa-check-circle',
            'warning' => 'fas fa-exclamation-triangle',
            'error' => 'fas fa-times-circle',
            default => 'fas fa-info-circle'
        };
    }
}
