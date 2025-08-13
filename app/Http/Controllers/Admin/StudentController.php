<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Faculty;
use App\Models\StudyProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::with(['studyProgram.faculty']);
        
        // Search
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('student_id', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }
        
        // Faculty filter
        if ($request->has('faculty') && $request->faculty) {
            $query->whereHas('studyProgram.faculty', function($q) use ($request) {
                $q->where('id', $request->faculty);
            });
        }
        
        // Study Program filter
        if ($request->has('study_program') && $request->study_program) {
            $query->where('study_program_id', $request->study_program);
        }
        
        // Entry Year filter
        if ($request->has('entry_year') && $request->entry_year) {
            $query->where('entry_year', $request->entry_year);
        }
        
        // Status filter
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }
        
        $students = $query->orderBy('entry_year', 'desc')
                         ->orderBy('student_id', 'asc')
                         ->paginate(15);
        
        $faculties = Faculty::active()->orderBy('name')->get();
        $studyPrograms = StudyProgram::active()->orderBy('name')->get();
        $entryYears = Student::selectRaw('DISTINCT entry_year')
                           ->orderBy('entry_year', 'desc')
                           ->pluck('entry_year');
        
        return view('admin.students.index', compact('students', 'faculties', 'studyPrograms', 'entryYears'));
    }
    
    public function create()
    {
        $faculties = Faculty::active()->orderBy('name')->get();
        $studyPrograms = StudyProgram::active()->orderBy('name')->get();
        $currentYear = date('Y');
        $entryYears = range($currentYear - 10, $currentYear + 1);
        
        return view('admin.students.create', compact('faculties', 'studyPrograms', 'entryYears'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|string|unique:students,student_id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'gender' => 'required|in:male,female',
            'birth_date' => 'required|date',
            'birth_place' => 'required|string|max:255',
            'faculty_id' => 'required|exists:faculties,id',
            'study_program_id' => 'required|exists:study_programs,id',
            'class' => 'nullable|string|max:255',
            'entry_year' => 'required|integer|min:2000|max:' . (date('Y') + 1),
            'status' => 'required|in:active,inactive,graduated,dropped',
            'gpa' => 'nullable|numeric|min:0|max:4',
            'semester' => 'required|integer|min:1|max:20',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        
        $data = $request->except(['photo']);
        
        // Handle photo upload
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('students', 'public');
        }
        
        Student::create($data);
        
        return redirect()->route('admin.students.index')
                        ->with('success', 'Data mahasiswa berhasil ditambahkan.');
    }
    
    public function show(Student $student)
    {
        $student->load(['studyProgram.faculty']);
        
        return view('admin.students.show', compact('student'));
    }
    
    public function edit(Student $student)
    {
        $faculties = Faculty::active()->orderBy('name')->get();
        $studyPrograms = StudyProgram::active()->orderBy('name')->get();
        $currentYear = date('Y');
        $entryYears = range($currentYear - 10, $currentYear + 1);
        
        return view('admin.students.edit', compact('student', 'faculties', 'studyPrograms', 'entryYears'));
    }
    
    public function update(Request $request, Student $student)
    {
        $request->validate([
            'student_id' => 'required|string|unique:students,student_id,' . $student->id,
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email,' . $student->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'gender' => 'required|in:male,female',
            'birth_date' => 'required|date',
            'birth_place' => 'required|string|max:255',
            'faculty_id' => 'required|exists:faculties,id',
            'study_program_id' => 'required|exists:study_programs,id',
            'class' => 'nullable|string|max:255',
            'entry_year' => 'required|integer|min:2000|max:' . (date('Y') + 1),
            'status' => 'required|in:active,inactive,graduated,dropped',
            'gpa' => 'nullable|numeric|min:0|max:4',
            'semester' => 'required|integer|min:1|max:20',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        
        $data = $request->except(['photo']);
        
        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($student->photo) {
                Storage::disk('public')->delete($student->photo);
            }
            $data['photo'] = $request->file('photo')->store('students', 'public');
        }
        
        $student->update($data);
        
        return redirect()->route('admin.students.index')
                        ->with('success', 'Data mahasiswa berhasil diperbarui.');
    }
    
    public function destroy(Student $student)
    {
        // Delete photo if exists
        if ($student->photo) {
            Storage::disk('public')->delete($student->photo);
        }
        
        $student->delete();
        
        return redirect()->route('admin.students.index')
                        ->with('success', 'Data mahasiswa berhasil dihapus.');
    }
    
    public function toggleStatus(Student $student)
    {
        $newStatus = ($student->status === 'active') ? 'inactive' : 'active';
        
        $student->update([
            'status' => $newStatus
        ]);
        
        $statusText = ($newStatus === 'active') ? 'diaktifkan' : 'dinonaktifkan';
        
        return redirect()->back()
                        ->with('success', "Status mahasiswa berhasil {$statusText}.");
    }
    
    public function getStudyPrograms(Request $request)
    {
        $facultyId = $request->faculty_id;
        $studyPrograms = StudyProgram::where('faculty_id', $facultyId)
                                   ->where('is_active', true)
                                   ->orderBy('name')
                                   ->get(['id', 'name']);
        
        return response()->json($studyPrograms);
    }
}
