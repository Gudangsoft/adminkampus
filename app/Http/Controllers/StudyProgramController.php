<?php

namespace App\Http\Controllers;

use App\Models\StudyProgram;
use App\Models\Lecturer;
use Illuminate\Http\Request;

class StudyProgramController extends Controller
{
    public function index(Request $request)
    {
        $query = StudyProgram::active()->withCount(['students']);
        
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
        $degrees = StudyProgram::select('degree')->distinct()->pluck('degree');
        
        return view('frontend.study-programs.index', compact('studyPrograms', 'degrees'));
    }
    
    public function show($slug)
    {
        $studyProgram = StudyProgram::where('slug', $slug)->active()->firstOrFail();
        
        // Get lecturers for this study program  
        $lecturers = Lecturer::active()
            ->whereJsonContains('study_program_ids', $studyProgram->id)
            ->orderBy('position')
            ->take(8)
            ->get();
        
        // Get other programs (all active programs)
        $relatedPrograms = StudyProgram::active()
            ->where('id', '!=', $studyProgram->id)
            ->orderBy('sort_order')
            ->take(4)
            ->get();
        
        return view('frontend.study-programs.show', compact('studyProgram', 'lecturers', 'relatedPrograms'));
    }
}
