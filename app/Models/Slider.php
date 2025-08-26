<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    // Nama tabel (jika tidak mengikuti default plural)
    protected $table = 'sliders';

    // Primary key
    protected $primaryKey = 'id';

    // Field yang boleh diisi (mass assignment)
    protected $fillable = [
        'title',
        'description',
        'image',     // path gambar
        'is_active', // status slider aktif/tidak
    ];

    // Cast agar lebih mudah digunakan
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Scope untuk hanya ambil slider yang aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope untuk order slider berdasarkan created_at
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * Accessor untuk path gambar penuh
     */
    public function getImageUrlAttribute()
    {
        return $this->image 
            ? asset('storage/' . $this->image) 
            : asset('images/default-slider.png');
    }
}
