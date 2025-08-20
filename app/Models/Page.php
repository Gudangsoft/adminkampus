<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'featured_image',
        'meta_data',
        'user_id',
        'status',
        'show_in_menu',
        'menu_order',
        'template'
    ];

    protected $casts = [
        'meta_data' => 'array',
        'show_in_menu' => 'boolean'
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

    public function menus()
    {
        return $this->hasMany(Menu::class);
    }

    public function getFeaturedImageUrlAttribute()
    {
        if ($this->featured_image) {
            return Storage::url($this->featured_image);
        }
        return null;
    }

    public function getMetaTitleAttribute()
    {
        return $this->meta_data['title'] ?? null;
    }

    public function getMetaDescriptionAttribute()
    {
        return $this->meta_data['description'] ?? null;
    }

    public function getMetaKeywordsAttribute()
    {
        return $this->meta_data['keywords'] ?? null;
    }

    public function setMetaTitleAttribute($value)
    {
        $meta = $this->meta_data ?? [];
        $meta['title'] = $value;
        $this->meta_data = $meta;
    }

    public function setMetaDescriptionAttribute($value)
    {
        $meta = $this->meta_data ?? [];
        $meta['description'] = $value;
        $this->meta_data = $meta;
    }

    public function setMetaKeywordsAttribute($value)
    {
        $meta = $this->meta_data ?? [];
        $meta['keywords'] = $value;
        $this->meta_data = $meta;
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeInMenu($query)
    {
        return $query->where('show_in_menu', true);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
