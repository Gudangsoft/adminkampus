<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'type',
        'status',
        'priority',
        'user_id',
        'start_date',
        'end_date',
        'is_featured',
        'send_notification',
        'target_audience',
        'views',
        'meta_data'
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'send_notification' => 'boolean',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'target_audience' => 'array',
        'meta_data' => 'array'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->title);
            }
        });
        
        static::updating(function ($model) {
            if ($model->isDirty('title') && empty($model->slug)) {
                $model->slug = Str::slug($model->title);
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'active')
                    ->where('start_date', '<=', now())
                    ->where(function($q) {
                        $q->whereNull('end_date')
                          ->orWhere('end_date', '>', now());
                    });
    }

    public function scopePinned($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByPriority($query, $priority = 'high')
    {
        return $query->where('priority', $priority);
    }

    public function incrementViews()
    {
        $this->increment('views');
    }

    public function getFeaturedImageUrlAttribute()
    {
        if ($this->featured_image) {
            return Storage::url($this->featured_image);
        }
        return asset('images/default-announcement.jpg');
    }

    public function getIsExpiredAttribute()
    {
        return $this->end_date && $this->end_date->isPast();
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
