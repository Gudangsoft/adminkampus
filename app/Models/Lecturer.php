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
        'lecturer_id',
        'name',
        'email',
        'phone',
        'address',
        'gender',
        'birth_date',
        'birth_place',
        'faculty_id',
        'position',
        'employment_status',
        'education_level',
        'specialization',
        'join_date',
        'photo',
        'biography',
        'research_interests',
        'publications',
        'google_scholar',
        'orcid',
        'is_active'
    ];

    protected $casts = [
        'research_interests' => 'array',
        'publications' => 'array',
        'is_active' => 'boolean',
        'birth_date' => 'date',
        'join_date' => 'date'
    ];

    protected static function boot()
    {
        parent::boot();
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }

    public function studyPrograms()
    {
        return $this->belongsToMany(StudyProgram::class, 'lecturer_study_programs');
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

    public function getNidnAttribute()
    {
        return $this->lecturer_id;
    }

    public function getPositionLabelAttribute()
    {
        $positionMap = [
            'asisten_ahli' => 'Asisten Ahli',
            'lektor' => 'Lektor',
            'lektor_kepala' => 'Lektor Kepala',
            'guru_besar' => 'Guru Besar'
        ];
        
        return $positionMap[$this->position] ?? $this->position;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByPosition($query, $position)
    {
        return $query->where('position', $position);
    }
}
