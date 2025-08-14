<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Faculty extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'code',
        'description',
        'dean_name',
        'logo',
        'phone',
        'email',
        'address',
        'website',
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
            
            if (empty($model->code)) {
                $model->code = $model->generateUniqueCode();
            }
        });
        
        static::updating(function ($model) {
            if ($model->isDirty('name') && empty($model->slug)) {
                $model->slug = Str::slug($model->name);
            }
            
            if ($model->isDirty('name') && empty($model->code)) {
                $model->code = $model->generateUniqueCode();
            }
        });
    }

    public function studyPrograms()
    {
        return $this->hasMany(StudyProgram::class);
    }

    public function lecturers()
    {
        return $this->hasMany(Lecturer::class);
    }

    public function students()
    {
        return $this->hasManyThrough(Student::class, StudyProgram::class);
    }

    public function getLogoUrlAttribute()
    {
        if ($this->logo) {
            return Storage::url($this->logo);
        }
        return asset('images/default-faculty.jpg');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Generate unique faculty code
     */
    public function generateUniqueCode()
    {
        // Generate code from faculty name
        $words = explode(' ', $this->name);
        $code = '';
        
        // Take first letter of each word, max 4 letters
        foreach ($words as $word) {
            if (strlen($code) < 4) {
                $code .= strtoupper(substr($word, 0, 1));
            }
        }
        
        // If code is less than 3 characters, pad with first letters
        if (strlen($code) < 3) {
            $code = strtoupper(substr($this->name, 0, 3));
        }
        
        // Remove non-alphanumeric characters
        $code = preg_replace('/[^A-Z0-9]/', '', $code);
        
        // Ensure code is unique
        $originalCode = $code;
        $counter = 1;
        
        while (Faculty::where('code', $code)->where('id', '!=', $this->id ?? 0)->exists()) {
            $code = $originalCode . $counter;
            $counter++;
        }
        
        return $code;
    }
}
