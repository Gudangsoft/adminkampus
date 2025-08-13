<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'url',
        'route',
        'icon',
        'parent_id',
        'order',
        'is_active',
        'target',
        'description',
        'permissions'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'permissions' => 'array'
    ];

    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id')->orderBy('order');
    }

    public function getFullUrlAttribute()
    {
        if ($this->url && (str_starts_with($this->url, 'http') || str_starts_with($this->url, '/'))) {
            return $this->url;
        }
        
        if ($this->route) {
            try {
                return route($this->route);
            } catch (\Exception $e) {
                return '#';
            }
        }
        
        if ($this->url) {
            return url($this->url);
        }
        
        return '#';
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeParent($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
    
    public function hasPermission($user = null)
    {
        if (!$this->permissions || empty($this->permissions)) {
            return true; // Jika tidak ada permission yang ditentukan, semua bisa akses
        }
        
        if (!$user) {
            $user = auth()->user();
        }
        
        if (!$user) {
            return false;
        }
        
        return in_array($user->role, $this->permissions);
    }
}
