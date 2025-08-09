<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Faculty;
use App\Models\StudyProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        // Check if is_active column exists, use appropriate query
        if (Schema::hasColumn('students', 'is_active')) {
            $query = Student::where('is_active', true)->with(['studyProgram.faculty']);
        } else {
            $query = Student::where('status', 'active')->with(['studyProgram.faculty']);
        }
        
        // Filter by faculty
        if ($request->has('faculty') && $request->faculty) {
            $query->whereHas('studyProgram.faculty', function($q) use ($request) {
                $q->where('slug', $request->faculty);
            });
        }
        
        // Filter by study program
        if ($request->has('study_program') && $request->study_program) {
            $query->whereHas('studyProgram', function($q) use ($request) {
                $q->where('slug', $request->study_program);
            });
        }
        
        // Filter by year/angkatan
        if ($request->has('year') && $request->year) {
            $query->where('entry_year', $request->year);
        }
        
        // Search
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('nim', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }
        
        $students = $query->orderBy('name')->paginate(20);
        $faculties = Faculty::active()->orderBy('sort_order')->get();
        $studyPrograms = StudyProgram::active()->orderBy('name')->get();
        $years = Student::select('entry_year')->distinct()->orderBy('entry_year', 'desc')->pluck('entry_year');
        
        return view('frontend.students.index', compact('students', 'faculties', 'studyPrograms', 'years'));
    }
    
    public function show($nim)
    {
        // Check if is_active column exists, use appropriate query
        if (Schema::hasColumn('students', 'is_active')) {
            $student = Student::where('nim', $nim)->where('is_active', true)->with(['studyProgram.faculty'])->firstOrFail();
        } else {
            $student = Student::where('nim', $nim)->where('status', 'active')->with(['studyProgram.faculty'])->firstOrFail();
        }
        
        return view('frontend.students.show', compact('student'));
    }
}
