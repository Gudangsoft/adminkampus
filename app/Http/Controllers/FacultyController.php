<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use App\Models\StudyProgram;
use App\Models\Lecturer;
use Illuminate\Http\Request;

class FacultyController extends Controller
{
    public function index(Request $request)
    {
        $query = Faculty::active()->withCount(['studyPrograms', 'lecturers']);
        
        // Search
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }
        
        $faculties = $query->orderBy('sort_order')->orderBy('name')->paginate(12);
        
        return view('frontend.faculties.index', compact('faculties'));
    }
    
    public function show($slug)
    {
        $faculty = Faculty::where('slug', $slug)->active()->firstOrFail();
        
        // Get study programs
        $studyPrograms = StudyProgram::active()
            ->where('faculty_id', $faculty->id)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();
        
        // Get lecturers
        $lecturers = Lecturer::active()
            ->where('faculty_id', $faculty->id)
            ->orderBy('name')
            ->paginate(12);
        
        // Get statistics
        $stats = [
            'total_study_programs' => $studyPrograms->count(),
            'total_lecturers' => Lecturer::where('faculty_id', $faculty->id)->count(),
            'total_students' => \App\Models\Student::whereHas('studyProgram', function($q) use ($faculty) {
                $q->where('faculty_id', $faculty->id);
            })->count(),
        ];
        
        return view('frontend.faculties.show', compact('faculty', 'studyPrograms', 'lecturers', 'stats'));
    }
}
