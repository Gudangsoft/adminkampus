<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FAQ extends Model
{
    use HasFactory;

    protected $table = 'faqs';
    
    protected $fillable = [
        'question',
        'answer', 
        'category',
        'order',
        'is_active',
        'views',
        'keywords'
    ];

    protected $casts = [
        'keywords' => 'array',
        'is_active' => 'boolean'
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('created_at');
    }

    public function scopePopular($query)
    {
        return $query->orderBy('views', 'desc');
    }

    public function scopeSearch($query, $searchTerm)
    {
        return $query->where(function($q) use ($searchTerm) {
            $q->where('question', 'LIKE', "%{$searchTerm}%")
              ->orWhere('answer', 'LIKE', "%{$searchTerm}%");
        });
    }

    // Methods
    public function incrementViews()
    {
        $this->increment('views');
    }

    public function matchesKeywords($searchTerm)
    {
        if (!$this->keywords) {
            return false;
        }

        $searchTerm = strtolower($searchTerm);
        
        foreach ($this->keywords as $keyword) {
            if (strpos($searchTerm, strtolower($keyword)) !== false) {
                return true;
            }
        }

        return false;
    }

    public static function searchByQuestion($searchTerm)
    {
        return static::active()
            ->where(function($query) use ($searchTerm) {
                $query->where('question', 'LIKE', "%{$searchTerm}%")
                      ->orWhere('answer', 'LIKE', "%{$searchTerm}%");
            })
            ->get()
            ->filter(function($faq) use ($searchTerm) {
                return $faq->matchesKeywords($searchTerm) || 
                       stripos($faq->question, $searchTerm) !== false ||
                       stripos($faq->answer, $searchTerm) !== false;
            });
    }

    public static function getCategories()
    {
        return static::active()
            ->distinct()
            ->pluck('category')
            ->sort()
            ->values();
    }
}
