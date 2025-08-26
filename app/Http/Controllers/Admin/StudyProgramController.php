<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StudyProgram;
use App\Models\Lecturer;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StudyProgramController extends Controller
{
    public function index(Request $request)
    {
        $query = StudyProgram::withCount(['students']);
        
        // Search
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }
        
        // Degree filter
        if ($request->has('degree') && $request->degree) {
            $query->where('degree', $request->degree);
        }
        
        // Status filter
        if ($request->has('status') && $request->status !== '') {
            $query->where('is_active', $request->status);
        }
        
        $studyPrograms = $query->orderBy('sort_order', 'asc')
                             ->orderBy('name', 'asc')
                             ->paginate(15);
        
        $degrees = StudyProgram::distinct()->pluck('degree')->filter()->sort();
        
        return view('admin.study-programs.index', compact('studyPrograms', 'degrees'));
    }
    
    public function create()
    {
        return view('admin.study-programs.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'degree' => 'required|string|max:50',
            'description' => 'nullable|string',
            'curriculum' => 'nullable|string',
            'accreditation' => 'nullable|string|max:50',
            'accreditation_year' => 'nullable|integer|min:2000|max:' . (date('Y') + 1),
            'head_of_program' => 'nullable|string|max:255',
            'credit_total' => 'nullable|integer|min:0',
            'semester_total' => 'nullable|integer|min:1',
            'career_prospects' => 'nullable|string',
            'facilities' => 'nullable|string',
            'website' => 'nullable|url|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
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
        
        // Convert facilities from textarea string to array
        $facilities = null;
        if ($request->facilities) {
            $facilities = array_filter(
                array_map('trim', explode("\n", $request->facilities)),
                function($value) {
                    return !empty($value);
                }
            );
        }
        
        $studyProgram = StudyProgram::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'degree' => $request->degree,
            'description' => $request->description,
            'curriculum' => $request->curriculum,
            'accreditation' => $request->accreditation,
            'accreditation_year' => $request->accreditation_year,
            'head_of_program' => $request->head_of_program,
            'credit_total' => $request->credit_total,
            'semester_total' => $request->semester_total,
            'career_prospects' => $careerProspects,
            'facilities' => $facilities,
            'website' => $request->website,
            'email' => $request->email,
            'phone' => $request->phone,
            'is_active' => $request->has('is_active'),
            'sort_order' => $request->sort_order ?? 0,
        ]);
        
        return redirect()->route('admin.study-programs.index')
                        ->with('success', 'Program studi berhasil ditambahkan.');
    }
    
    public function show(StudyProgram $studyProgram)
    {
        $studyProgram->load(['students']);
        $students = $studyProgram->students()->latest()->limit(10)->get();
        $lecturers = collect(); // Empty collection for now
        
        return view('admin.study-programs.show', compact('studyProgram', 'students', 'lecturers'));
    }
    
    public function edit(StudyProgram $studyProgram)
    {
        return view('admin.study-programs.edit', compact('studyProgram'));
    }
    
    public function update(Request $request, StudyProgram $studyProgram)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'degree' => 'required|string|max:50',
            'description' => 'nullable|string',
            'curriculum' => 'nullable|string',
            'accreditation' => 'nullable|string|max:50',
            'accreditation_year' => 'nullable|integer|min:2000|max:' . (date('Y') + 1),
            'head_of_program' => 'nullable|string|max:255',
            'credit_total' => 'nullable|integer|min:0',
            'semester_total' => 'nullable|integer|min:1',
            'career_prospects' => 'nullable|string',
            'facilities' => 'nullable|string',
            'website' => 'nullable|url|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
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
        
        // Convert facilities from textarea string to array
        $facilities = null;
        if ($request->facilities) {
            $facilities = array_filter(
                array_map('trim', explode("\n", $request->facilities)),
                function($value) {
                    return !empty($value);
                }
            );
        }
        
        $studyProgram->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'degree' => $request->degree,
            'description' => $request->description,
            'curriculum' => $request->curriculum,
            'accreditation' => $request->accreditation,
            'accreditation_year' => $request->accreditation_year,
            'head_of_program' => $request->head_of_program,
            'credit_total' => $request->credit_total,
            'semester_total' => $request->semester_total,
            'career_prospects' => $careerProspects,
            'facilities' => $facilities,
            'website' => $request->website,
            'email' => $request->email,
            'phone' => $request->phone,
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
