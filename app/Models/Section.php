<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'content',
        'icon',
        'image',
        'link',
        'link_text',
        'background_color',
        'text_color',
        'order',
        'is_active',
        'type',
        'settings'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'settings' => 'json'
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }
}
