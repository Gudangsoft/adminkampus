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
        'name',
        'email',
        'nip',
        'photo',
        'bio',
        'study_program_ids',
        'is_active',
        'position',
        'structural_position',
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
        return $query->where('structural_position', $position);
    }

    public function getStructuralStatusAttribute()
    {
        if (!$this->structural_position) {
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
        return [
            'Rektor' => 'Rektor',
            'Wakil Rektor I' => 'Wakil Rektor I (Bidang Akademik)',
            'Wakil Rektor II' => 'Wakil Rektor II (Bidang Administrasi Umum)',
            'Wakil Rektor III' => 'Wakil Rektor III (Bidang Kemahasiswaan)',
            'Wakil Rektor IV' => 'Wakil Rektor IV (Bidang Kerjasama)',
            'Sekretaris Universitas' => 'Sekretaris Universitas',
            'Direktur' => 'Direktur',
            'Wakil Direktur' => 'Wakil Direktur',
            'Kepala Program Studi' => 'Kepala Program Studi',
            'Sekretaris Program Studi' => 'Sekretaris Program Studi',
            'Kepala Lembaga' => 'Kepala Lembaga',
            'Sekretaris Lembaga' => 'Sekretaris Lembaga',
            'Kepala Unit' => 'Kepala Unit',
            'Sekretaris Unit' => 'Sekretaris Unit',
            'Kepala Bagian' => 'Kepala Bagian',
            'Kepala Sub Bagian' => 'Kepala Sub Bagian',
        ];
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
