<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'gallery',
        'category_id',
        'user_id',
        'status',
        'is_featured',
        'views',
        'published_at',
        'meta_data'
    ];

    protected $casts = [
        'gallery' => 'array',
        'is_featured' => 'boolean',
        'published_at' => 'datetime',
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

    public function category()
    {
        return $this->belongsTo(NewsCategory::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                    ->where('published_at', '<=', now());
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function incrementViews()
    {
        $this->increment('views');
    }

    public function getFeaturedImageUrlAttribute()
    {
        if ($this->featured_image) {
            // First try Storage::url() for proper Laravel behavior
            $storageUrl = Storage::url($this->featured_image);
            
            // If storage disk is not working, fallback to asset()
            if (!file_exists(public_path('storage/' . $this->featured_image))) {
                // Copy file if it doesn't exist in public storage
                $sourcePath = storage_path('app/public/' . $this->featured_image);
                $destPath = public_path('storage/' . $this->featured_image);
                
                if (file_exists($sourcePath)) {
                    // Ensure directory exists
                    $destDir = dirname($destPath);
                    if (!is_dir($destDir)) {
                        mkdir($destDir, 0755, true);
                    }
                    copy($sourcePath, $destPath);
                }
            }
            
            return asset('storage/' . $this->featured_image);
        }
        return asset('images/default-news.jpg');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
