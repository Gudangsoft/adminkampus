<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'nim',
        'name',
        'slug',
        'study_program_id',
        'gender',
        'date_of_birth',
        'place_of_birth',
        'address',
        'phone',
        'email',
        'parent_name',
        'parent_phone',
        'school_origin',
        'entry_year',
        'semester',
        'gpa',
        'credits_taken',
        'graduation_date',
        'photo',
        'status',
        'is_active'
    ];

    protected $attributes = [
        'is_active' => true,
        'status' => 'active'
    ];

    protected $casts = [
        'gpa' => 'decimal:2',
        'graduation_date' => 'date',
        'date_of_birth' => 'date',
        'is_active' => 'boolean'
    ];

    public function getIsActiveAttribute($value)
    {
        // If is_active column doesn't exist, derive from status
        if (!Schema::hasColumn('students', 'is_active')) {
            return $this->status === 'active';
        }
        return $value;
    }

    public function studyProgram()
    {
        return $this->belongsTo(StudyProgram::class);
    }

    public function getPhotoUrlAttribute()
    {
        if ($this->photo) {
            // Get the base URL
            $baseUrl = url('/storage');
            
            return $baseUrl . '/' . $this->photo;
        }
        
        // Return default avatar SVG if no photo
        $initials = collect(explode(' ', $this->name))
            ->take(2)
            ->map(fn($word) => strtoupper(substr($word, 0, 1)))
            ->join('');
            
        $colors = ['#3B82F6', '#EF4444', '#10B981', '#F59E0B', '#8B5CF6', '#06B6D4', '#F97316'];
        $color = $colors[abs(crc32($this->name)) % count($colors)];
        
        $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="150" height="150" viewBox="0 0 150 150">
            <rect width="150" height="150" fill="' . $color . '"/>
            <text x="75" y="75" font-family="Arial, sans-serif" font-size="48" font-weight="bold" 
                  text-anchor="middle" dy="0.35em" fill="white">' . $initials . '</text>
        </svg>';
        
        return 'data:image/svg+xml;base64,' . base64_encode($svg);
    }

    public function scopeActive($query)
    {
        // Check if is_active column exists, otherwise use status
        if (Schema::hasColumn('students', 'is_active')) {
            return $query->where('is_active', true);
        } else {
            return $query->where('status', 'active');
        }
    }

    public function scopeGraduate($query)
    {
        return $query->where('graduation_date', '!=', null);
    }

    public function scopeByEntryYear($query, $year)
    {
        return $query->where('entry_year', $year);
    }

    public function getCurrentSemesterAttribute()
    {
        $currentYear = now()->year;
        $currentMonth = now()->month;
        
        // Assuming academic year starts in September
        if ($currentMonth >= 9) {
            $academicYear = $currentYear;
        } else {
            $academicYear = $currentYear - 1;
        }
        
        $yearsDiff = $academicYear - $this->entry_year;
        $currentSemester = ($yearsDiff * 2) + 1;
        
        // Adjust for second semester (February-August)
        if ($currentMonth >= 2 && $currentMonth <= 8) {
            $currentSemester++;
        }
        
        return max(1, $currentSemester);
    }
}
