<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class StudyProgram extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'degree',
        'description',
        'curriculum',
        'accreditation',
        'accreditation_year',
        'head_of_program',
        'credit_total',
        'semester_total',
        'career_prospects',
        'facilities',
        'website',
        'email',
        'phone',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'career_prospects' => 'array',
        'facilities' => 'array',
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

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function lecturers()
    {
        return $this->belongsToMany(Lecturer::class, 'lecturer_study_programs');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByDegree($query, $degree)
    {
        return $query->where('degree', $degree);
    }

    public function getFullNameAttribute()
    {
        return $this->degree . ' ' . $this->name;
    }

    public function getLecturersCountAttribute()
    {
        return Lecturer::where('study_program_ids', 'LIKE', '%' . $this->id . '%')
                      ->where('is_active', true)
                      ->count();
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
