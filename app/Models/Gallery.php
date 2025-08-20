<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'category_id',
        'type',
        'file_path',
        'thumbnail',
        'alt_text',
        'metadata',
        'user_id',
        'is_featured',
        'views',
        'taken_at',
        'photographer'
    ];

    protected $casts = [
        'metadata' => 'array',
        'is_featured' => 'boolean',
        'taken_at' => 'datetime'
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
        return $this->belongsTo(GalleryCategory::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFileUrlAttribute()
    {
        if ($this->type === 'video' && $this->metadata) {
            $metadata = is_string($this->metadata) ? json_decode($this->metadata, true) : $this->metadata;
            if (isset($metadata['url'])) {
                return $metadata['url'];
            }
        }
        
        if ($this->file_path && filter_var($this->file_path, FILTER_VALIDATE_URL)) {
            return $this->file_path;
        }
        
        return Storage::url($this->file_path);
    }

    public function getImageUrlAttribute()
    {
        if ($this->type === 'image') {
            // Jika file_path adalah URL lengkap, gunakan langsung
            if ($this->file_path && filter_var($this->file_path, FILTER_VALIDATE_URL)) {
                return $this->file_path;
            }
            
            // Jika file lokal, gunakan storage URL
            if ($this->file_path) {
                return asset('storage/' . $this->file_path);
            }
        }
        
        // Default placeholder image menggunakan URL eksternal
        return 'https://via.placeholder.com/800x600/e9ecef/6c757d?text=Gallery+Image';
    }

    public function getEmbedUrlAttribute()
    {
        if ($this->type === 'video' && $this->metadata) {
            $metadata = is_string($this->metadata) ? json_decode($this->metadata, true) : $this->metadata;
            if (isset($metadata['embed_url'])) {
                return $metadata['embed_url'];
            }
        }
        return null;
    }

    public function getYoutubeIdAttribute()
    {
        if ($this->type === 'video' && $this->metadata) {
            $metadata = is_string($this->metadata) ? json_decode($this->metadata, true) : $this->metadata;
            if (isset($metadata['video_id'])) {
                return $metadata['video_id'];
            }
        }
        return null;
    }

    public function getYoutubeThumbnailAttribute()
    {
        if ($this->type === 'video' && $this->youtube_id) {
            return "https://img.youtube.com/vi/{$this->youtube_id}/maxresdefault.jpg";
        }
        
        // Fallback untuk video non-YouTube
        return 'https://via.placeholder.com/800x450/000000/ffffff?text=Video+Thumbnail';
    }

    public function getYoutubeUrlAttribute()
    {
        if ($this->type === 'video' && $this->file_path) {
            return $this->file_path;
        }
        return null;
    }

    public function getThumbnailUrlAttribute()
    {
        if ($this->thumbnail) {
            // If it's a URL (YouTube thumbnail), return as is
            if (filter_var($this->thumbnail, FILTER_VALIDATE_URL)) {
                return $this->thumbnail;
            }
            // If it's a local file, use storage URL
            return Storage::url($this->thumbnail);
        }
        
        if ($this->type === 'image') {
            return $this->file_url;
        }
        
        // For videos, try to get YouTube thumbnail
        if ($this->type === 'video') {
            return $this->youtube_thumbnail;
        }
        
        // Default thumbnail
        return 'https://via.placeholder.com/800x600/e9ecef/6c757d?text=Thumbnail';
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeImages($query)
    {
        return $query->where('type', 'image');
    }

    public function scopeVideos($query)
    {
        return $query->where('type', 'video');
    }

    public function incrementViews()
    {
        $this->increment('views');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
