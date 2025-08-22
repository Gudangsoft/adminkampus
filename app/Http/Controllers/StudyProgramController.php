<?php

namespace App\Http\Controllers;

use App\Models\StudyProgram;
use App\Models\Faculty;
use App\Models\Lecturer;
use Illuminate\Http\Request;

class StudyProgramController extends Controller
{
    public function index(Request $request)
    {
        $query = StudyProgram::active()->with('faculty')->withCount(['students']);
        
        // Filter by faculty
        if ($request->has('faculty') && $request->faculty) {
            $query->whereHas('faculty', function($q) use ($request) {
                $q->where('slug', $request->faculty);
            });
        }
        
        // Filter by degree
        if ($request->has('degree') && $request->degree) {
            $query->where('degree', $request->degree);
        }
        
        // Search
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }
        
        $studyPrograms = $query->orderBy('sort_order')->orderBy('name')->paginate(12);
        $faculties = Faculty::active()->orderBy('sort_order')->get();
        $degrees = StudyProgram::select('degree')->distinct()->pluck('degree');
        
        return view('frontend.study-programs.index', compact('studyPrograms', 'faculties', 'degrees'));
    }
    
    public function show($slug)
    {
        // Load the study program; faculty is optional so don't require whereHas
        $studyProgram = StudyProgram::where('slug', $slug)
            ->active()
            ->with('faculty')
            ->firstOrFail();
        
        // Get lecturers for this study program
        // If study program has a faculty, prefer lecturers from that faculty and linked to program.
        // If no faculty, fetch lecturers linked to the program regardless of faculty.
        $lecturerQuery = Lecturer::active()
            ->whereJsonContains('study_program_ids', $studyProgram->id);

        if ($studyProgram->faculty_id) {
            $lecturerQuery->where('faculty_id', $studyProgram->faculty_id);
        }

        $lecturers = $lecturerQuery->orderBy('position')
            ->take(8)
            ->get();
        
        // Get other programs in the same faculty if faculty exists, otherwise get other active programs
        $relatedQuery = StudyProgram::active()->where('id', '!=', $studyProgram->id)->orderBy('sort_order');
        if ($studyProgram->faculty_id) {
            $relatedQuery->where('faculty_id', $studyProgram->faculty_id);
        }
        $relatedPrograms = $relatedQuery->take(4)->get();
        
        return view('frontend.study-programs.show', compact('studyProgram', 'lecturers', 'relatedPrograms'));
    }
    
    public function faculty($slug)
    {
        $faculty = Faculty::where('slug', $slug)->active()->firstOrFail();
        $studyPrograms = StudyProgram::active()
            ->where('faculty_id', $faculty->id)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(12);
            
        $lecturers = Lecturer::active()
            ->where('faculty_id', $faculty->id)
            ->orderBy('position')
            ->take(12)
            ->get();
        
        return view('frontend.study-programs.faculty', compact('faculty', 'studyPrograms', 'lecturers'));
    }
}
