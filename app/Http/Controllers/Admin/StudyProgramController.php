<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StudyProgram;
use App\Models\Faculty;
use App\Models\Lecturer;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StudyProgramController extends Controller
{
    public function index(Request $request)
    {
        $query = StudyProgram::with(['faculty'])
                            ->withCount(['students']);
        
        // Search
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }
        
        // Faculty filter
        if ($request->has('faculty') && $request->faculty) {
            $query->where('faculty_id', $request->faculty);
        }
        
        // Degree filter
        if ($request->has('degree') && $request->degree) {
            $query->where('degree', $request->degree);
        }
        
        // Status filter
        if ($request->has('status') && $request->status !== '') {
            $query->where('is_active', $request->status);
        }
        
        $studyPrograms = $query->orderBy('faculty_id', 'asc')
                             ->orderBy('sort_order', 'asc')
                             ->orderBy('name', 'asc')
                             ->paginate(15);
        
        $faculties = Faculty::active()->orderBy('name')->get();
        $degrees = StudyProgram::distinct()->pluck('degree')->filter()->sort();
        
        return view('admin.study-programs.index', compact('studyPrograms', 'faculties', 'degrees'));
    }
    
    public function create()
    {
        $faculties = Faculty::active()->orderBy('name')->get();
        return view('admin.study-programs.create', compact('faculties'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'faculty_id' => 'nullable|exists:faculties,id',
            'degree' => 'required|string|max:50',
            'description' => 'nullable|string',
            'accreditation' => 'nullable|string|max:10',
            'career_prospects' => 'nullable|string',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);
        
        // Convert career_prospects from textarea string to array
        $careerProspects = null;
        if ($request->career_prospects) {
            $careerProspects = array_filter(
                array_map('trim', explode("\n", $request->career_prospects)),
                function($value) {
                    return !empty($value);
                }
            );
        }
        
        $studyProgram = StudyProgram::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'faculty_id' => $request->faculty_id,
            'degree' => $request->degree,
            'description' => $request->description,
            'accreditation' => $request->accreditation,
            'career_prospects' => $careerProspects,
            'is_active' => $request->has('is_active'),
            'sort_order' => $request->sort_order ?? 0,
        ]);
        
        return redirect()->route('admin.study-programs.index')
                        ->with('success', 'Program studi berhasil ditambahkan.');
    }
    
    public function show(StudyProgram $studyProgram)
    {
        $studyProgram->load(['faculty', 'students']);
        $students = $studyProgram->students()->with('studyProgram.faculty')->latest()->limit(10)->get();
        $lecturers = collect(); // Empty collection for now
        
        return view('admin.study-programs.show', compact('studyProgram', 'students', 'lecturers'));
    }
    
    public function edit(StudyProgram $studyProgram)
    {
        $faculties = Faculty::active()->orderBy('name')->get();
        return view('admin.study-programs.edit', compact('studyProgram', 'faculties'));
    }
    
    public function update(Request $request, StudyProgram $studyProgram)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'faculty_id' => 'required|exists:faculties,id',
            'degree' => 'required|string|max:50',
            'description' => 'nullable|string',
            'accreditation' => 'nullable|string|max:10',
            'career_prospects' => 'nullable|string',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);
        
        // Convert career_prospects from textarea string to array
        $careerProspects = null;
        if ($request->career_prospects) {
            $careerProspects = array_filter(
                array_map('trim', explode("\n", $request->career_prospects)),
                function($value) {
                    return !empty($value);
                }
            );
        }
        
        $studyProgram->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'faculty_id' => $request->faculty_id,
            'degree' => $request->degree,
            'description' => $request->description,
            'accreditation' => $request->accreditation,
            'career_prospects' => $careerProspects,
            'is_active' => $request->has('is_active'),
            'sort_order' => $request->sort_order ?? 0,
        ]);
        
        return redirect()->route('admin.study-programs.index')
                        ->with('success', 'Program studi berhasil diperbarui.');
    }
    
    public function destroy(StudyProgram $studyProgram)
    {
        // Check if study program has students
        if ($studyProgram->students()->count() > 0) {
            return redirect()->back()
                           ->with('error', 'Tidak dapat menghapus program studi yang masih memiliki mahasiswa.');
        }
        
        $studyProgram->delete();
        
        return redirect()->route('admin.study-programs.index')
                        ->with('success', 'Program studi berhasil dihapus.');
    }
    
    public function toggleStatus(StudyProgram $studyProgram)
    {
        $studyProgram->update([
            'is_active' => !$studyProgram->is_active
        ]);
        
        $status = $studyProgram->is_active ? 'diaktifkan' : 'dinonaktifkan';
        
        return redirect()->back()
                        ->with('success', "Program studi berhasil {$status}.");
    }
    
    public function updateOrder(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:study_programs,id',
            'items.*.sort_order' => 'required|integer|min:0',
        ]);
        
        foreach ($request->items as $item) {
            StudyProgram::where('id', $item['id'])->update(['sort_order' => $item['sort_order']]);
        }
        
        return response()->json(['success' => true]);
    }
}
