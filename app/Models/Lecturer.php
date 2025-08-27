<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Lecturer extends Model
{
    use HasFactory;

    protected $fillable = [
        'nidn',
        'name',
        'slug',
        'email',
        'gender',
        'title_prefix',
        'title_suffix',
        'position',
        'education_background',
        'expertise',
        'biography',
        'phone',
        'office_location',
        'office_hours',
        'google_scholar',
        'scopus_id',
        'orcid',
        'photo',
        'study_program_ids',
        'is_active',
        'structural_position_id',
        'structural_description',
        'structural_start_date',
        'structural_end_date',
    ];

    protected $casts = [
        'study_program_ids' => 'array',
        'research_interests' => 'array',
        'publications' => 'array',
        'awards' => 'array',
        'certifications' => 'array',
        'structural_start_date' => 'date',
        'structural_end_date' => 'date',
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

    public function studyPrograms()
    {
        return $this->belongsToMany(StudyProgram::class, 'lecturer_study_programs');
    }

    public function structuralPosition()
    {
        return $this->belongsTo(StructuralPosition::class);
    }

    public function getPhotoUrlAttribute()
    {
        if ($this->photo && Storage::disk('public')->exists($this->photo)) {
            // Use current domain and port for storage URL
            $baseUrl = request() ? request()->getSchemeAndHttpHost() : config('app.url');
            return $baseUrl . '/storage/' . $this->photo;
        }
        
        // Create a simple data URL for default avatar
        $initials = $this->getInitials();
        $colors = ['6f42c1', '007bff', '28a745', 'dc3545', 'fd7e14', '20c997', 'ffc107', 'e83e8c'];
        $colorIndex = crc32($this->name) % count($colors);
        $backgroundColor = $colors[$colorIndex];
        
        // Generate SVG avatar
        $svg = '<svg width="200" height="200" xmlns="http://www.w3.org/2000/svg">
            <rect width="200" height="200" fill="#' . $backgroundColor . '"/>
            <text x="100" y="120" font-family="Arial, sans-serif" font-size="60" font-weight="bold" fill="white" text-anchor="middle">' . $initials . '</text>
        </svg>';
        
        return 'data:image/svg+xml;base64,' . base64_encode($svg);
    }
    
    private function getInitials()
    {
        $words = explode(' ', $this->name);
        $initials = '';
        foreach ($words as $word) {
            if (strlen($word) > 0) {
                $initials .= strtoupper($word[0]);
            }
            if (strlen($initials) >= 2) break;
        }
        return substr($initials, 0, 2);
    }

    public function getFullNameAttribute()
    {
        $name = '';
        if ($this->title_prefix) {
            $name .= $this->title_prefix . ' ';
        }
        $name .= $this->name;
        if ($this->title_suffix) {
            $name .= ', ' . $this->title_suffix;
        }
        return $name;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByPosition($query, $position)
    {
        return $query->where('position', $position);
    }

    public function scopeByStructuralPosition($query, $position)
    {
        return $query->where('structural_position_id', $position);
    }

    public function getStructuralStatusAttribute()
    {
        if (!$this->structural_position_id) {
            return null;
        }

        $now = now();
        if ($this->structural_start_date && $now < $this->structural_start_date) {
            return 'upcoming';
        }
        if ($this->structural_end_date && $now > $this->structural_end_date) {
            return 'expired';
        }
        return 'active';
    }

    public function getIsStructuralActiveAttribute()
    {
        return $this->structural_status === 'active';
    }

    public static function getStructuralPositions()
    {
        return StructuralPosition::active()->orderBy('sort_order')->pluck('name', 'id')->toArray();
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
