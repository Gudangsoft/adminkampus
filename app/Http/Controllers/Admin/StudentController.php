<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\StudyProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::with(['studyProgram']);
        
        // Search
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('nim', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
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
            if (Schema::hasColumn('students', 'is_active')) {
                if ($request->status === 'active') {
                    $query->where('is_active', true);
                } else {
                    $query->where('is_active', false);
                }
            } else {
                $query->where('status', $request->status);
            }
        }
        
        $students = $query->orderBy('entry_year', 'desc')
                         ->orderBy('nim', 'asc')
                         ->paginate(15);
        
        $studyPrograms = StudyProgram::active()->orderBy('name')->get();
        $entryYears = Student::selectRaw('DISTINCT entry_year')
                           ->orderBy('entry_year', 'desc')
                           ->pluck('entry_year');
        
        return view('admin.students.index', compact('students', 'studyPrograms', 'entryYears'));
    }
    
    public function create()
    {
        $studyPrograms = StudyProgram::active()->orderBy('name')->get();
        $currentYear = date('Y');
        $entryYears = range($currentYear - 10, $currentYear + 1);
        
        return view('admin.students.create', compact('studyPrograms', 'entryYears'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'nim' => 'required|string|unique:students,nim',
            'name' => 'required|string|max:255',
            'study_program_id' => 'required|exists:study_programs,id',
            'entry_year' => 'required|integer|min:2000|max:' . (date('Y') + 1),
            'gender' => 'required|in:male,female',
            'date_of_birth' => 'nullable|date',
            'place_of_birth' => 'nullable|string|max:100',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'parent_name' => 'nullable|string|max:255',
            'parent_phone' => 'nullable|string|max:20',
            'school_origin' => 'nullable|string|max:255',
            'gpa' => 'nullable|numeric|min:0|max:4',
            'semester' => 'nullable|integer|min:1|max:14',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'is_active' => 'boolean',
        ]);
        
        $data = $request->except(['photo']);
        $data['slug'] = Str::slug($request->nim);
        $data['is_active'] = $request->has('is_active');
        
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
        $student->load(['studyProgram']);
        
        return view('admin.students.show', compact('student'));
    }
    
    public function edit(Student $student)
    {
        $studyPrograms = StudyProgram::active()->orderBy('name')->get();
        $currentYear = date('Y');
        $entryYears = range($currentYear - 10, $currentYear + 1);
        
        return view('admin.students.edit', compact('student', 'studyPrograms', 'entryYears'));
    }
    
    public function update(Request $request, Student $student)
    {
        $request->validate([
            'nim' => 'required|string|unique:students,nim,' . $student->id,
            'name' => 'required|string|max:255',
            'study_program_id' => 'required|exists:study_programs,id',
            'entry_year' => 'required|integer|min:2000|max:' . (date('Y') + 1),
            'gender' => 'required|in:male,female',
            'date_of_birth' => 'nullable|date',
            'place_of_birth' => 'nullable|string|max:100',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'parent_name' => 'nullable|string|max:255',
            'parent_phone' => 'nullable|string|max:20',
            'school_origin' => 'nullable|string|max:255',
            'gpa' => 'nullable|numeric|min:0|max:4',
            'semester' => 'nullable|integer|min:1|max:14',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'is_active' => 'boolean',
        ]);
        
        $data = $request->except(['photo']);
        $data['slug'] = Str::slug($request->nim);
        $data['is_active'] = $request->has('is_active');
        
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
        $student->update([
            'is_active' => !$student->is_active
        ]);
        
        $status = $student->is_active ? 'diaktifkan' : 'dinonaktifkan';
        
        return redirect()->back()
                        ->with('success', "Status mahasiswa berhasil {$status}.");
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
