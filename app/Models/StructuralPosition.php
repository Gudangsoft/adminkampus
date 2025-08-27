<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class StructuralPosition extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'category',
        'level',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->name);
            }
        });
        
        static::updating(function ($model) {
            if ($model->isDirty('name') && empty($model->slug)) {
                $model->slug = Str::slug($model->name);
            }
        });
    }

    public function lecturers()
    {
        return $this->hasMany(Lecturer::class, 'structural_position', 'name');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public static function getCategories()
    {
        return [
            'Rektor' => 'Rektor & Wakil Rektor',
            'Direktur' => 'Direktur & Wakil Direktur', 
            'Dekan' => 'Dekan & Wakil Dekan',
            'Program Studi' => 'Program Studi',
            'Lembaga' => 'Lembaga',
            'Unit' => 'Unit',
            'Bagian' => 'Bagian',
            'Lainnya' => 'Lainnya'
        ];
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
