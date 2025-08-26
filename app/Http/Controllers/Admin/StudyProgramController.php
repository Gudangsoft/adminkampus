<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StudyProgram;
use App\Models\Lecturer;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class StudyProgramController extends Controller
{
    /**
     * Display a listing of the study programs.
     */
    public function index(Request $request): View
    {
        $query = StudyProgram::withCount(['students']);
        
        // Apply search filter
        $this->applySearchFilter($query, $request);
        
        // Apply degree filter
        $this->applyDegreeFilter($query, $request);
        
        // Apply status filter
        $this->applyStatusFilter($query, $request);
        
        $studyPrograms = $query->orderBy('sort_order', 'asc')
                             ->orderBy('name', 'asc')
                             ->paginate(15);
        
        // Add lecturer count for each study program
        $studyPrograms->getCollection()->transform(function ($studyProgram) {
            $studyProgram->lecturers_count = Lecturer::where('study_program_ids', 'LIKE', '%' . $studyProgram->id . '%')
                                                   ->where('is_active', true)
                                                   ->count();
            return $studyProgram;
        });
        
        $degrees = StudyProgram::distinct()
                              ->pluck('degree')
                              ->filter()
                              ->sort()
                              ->values();
        
        return view('admin.study-programs.index', compact('studyPrograms', 'degrees'));
    }

    /**
     * Show the form for creating a new study program.
     */
    public function create(): View
    {
        return view('admin.study-programs.create');
    }

    /**
     * Store a newly created study program in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $this->validateStudyProgramData($request);
        
        $data = $this->prepareStudyProgramData($validatedData);
        $data['slug'] = Str::slug($validatedData['name']);
        
        StudyProgram::create($data);
        
        return redirect()->route('admin.study-programs.index')
                        ->with('success', 'Program studi berhasil ditambahkan.');
    }

    /**
     * Display the specified study program.
     */
    public function show(StudyProgram $studyProgram): View
    {
        $studyProgram->load(['students']);
        
        $students = $studyProgram->students()
                                ->latest()
                                ->limit(10)
                                ->get();
        
        // Get lecturers related to this study program
        $lecturers = Lecturer::whereJsonContains('study_program_ids', $studyProgram->id)
                           ->limit(10)
                           ->get();
        
        return view('admin.study-programs.show', compact('studyProgram', 'students', 'lecturers'));
    }

    /**
     * Show the form for editing the specified study program.
     */
    public function edit(StudyProgram $studyProgram): View
    {
        return view('admin.study-programs.edit', compact('studyProgram'));
    }

    /**
     * Update the specified study program in storage.
     */
    public function update(Request $request, StudyProgram $studyProgram): RedirectResponse
    {
        $validatedData = $this->validateStudyProgramData($request, $studyProgram->id);
        
        $data = $this->prepareStudyProgramData($validatedData);
        $data['slug'] = Str::slug($validatedData['name']);
        
        $studyProgram->update($data);
        
        return redirect()->route('admin.study-programs.index')
                        ->with('success', 'Program studi berhasil diperbarui.');
    }

    /**
     * Remove the specified study program from storage.
     */
    public function destroy(StudyProgram $studyProgram): RedirectResponse
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

    /**
     * Toggle the status of the specified study program.
     */
    public function toggleStatus(StudyProgram $studyProgram): RedirectResponse
    {
        $studyProgram->update([
            'is_active' => !$studyProgram->is_active
        ]);
        
        $status = $studyProgram->is_active ? 'diaktifkan' : 'dinonaktifkan';
        
        return redirect()->back()
                        ->with('success', "Program studi berhasil {$status}.");
    }

    /**
     * Update the sort order of study programs.
     */
    public function updateOrder(Request $request): JsonResponse
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:study_programs,id',
            'items.*.sort_order' => 'required|integer|min:0',
        ]);
        
        foreach ($request->items as $item) {
            StudyProgram::where('id', $item['id'])
                       ->update(['sort_order' => $item['sort_order']]);
        }
        
        return response()->json(['success' => true]);
    }

    /**
     * Apply search filter to the query.
     */
    private function applySearchFilter($query, Request $request): void
    {
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%")
                  ->orWhere('degree', 'like', "%{$searchTerm}%");
            });
        }
    }

    /**
     * Apply degree filter to the query.
     */
    private function applyDegreeFilter($query, Request $request): void
    {
        if ($request->filled('degree')) {
            $query->where('degree', $request->degree);
        }
    }

    /**
     * Apply status filter to the query.
     */
    private function applyStatusFilter($query, Request $request): void
    {
        if ($request->has('status') && $request->status !== '') {
            $query->where('is_active', (bool) $request->status);
        }
    }

    /**
     * Validate study program data.
     */
    private function validateStudyProgramData(Request $request, ?int $studyProgramId = null): array
    {
        $currentYear = date('Y');
        
        return $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('study_programs')->ignore($studyProgramId)
            ],
            'degree' => 'required|string|max:50',
            'description' => 'nullable|string|max:1000',
            'curriculum' => 'nullable|string',
            'accreditation' => 'nullable|string|max:50',
            'accreditation_year' => "nullable|integer|min:2000|max:{$currentYear}",
            'head_of_program' => 'nullable|string|max:255',
            'credit_total' => 'nullable|integer|min:0|max:200',
            'semester_total' => 'nullable|integer|min:1|max:14',
            'career_prospects' => 'nullable|string',
            'facilities' => 'nullable|string',
            'website' => 'nullable|url|max:255',
            'email' => [
                'nullable',
                'email',
                'max:255',
                Rule::unique('study_programs')->ignore($studyProgramId)
            ],
            'phone' => 'nullable|string|max:50',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);
    }

    /**
     * Prepare study program data for storage.
     */
    private function prepareStudyProgramData(array $validatedData): array
    {
        return [
            'name' => $validatedData['name'],
            'degree' => $validatedData['degree'],
            'description' => $validatedData['description'] ?? null,
            'curriculum' => $validatedData['curriculum'] ?? null,
            'accreditation' => $validatedData['accreditation'] ?? null,
            'accreditation_year' => $validatedData['accreditation_year'] ?? null,
            'head_of_program' => $validatedData['head_of_program'] ?? null,
            'credit_total' => $validatedData['credit_total'] ?? null,
            'semester_total' => $validatedData['semester_total'] ?? null,
            'career_prospects' => $this->convertTextareaToArray($validatedData['career_prospects'] ?? null),
            'facilities' => $this->convertTextareaToArray($validatedData['facilities'] ?? null),
            'website' => $validatedData['website'] ?? null,
            'email' => $validatedData['email'] ?? null,
            'phone' => $validatedData['phone'] ?? null,
            'is_active' => $validatedData['is_active'] ?? false,
            'sort_order' => $validatedData['sort_order'] ?? 0,
        ];
    }

    /**
     * Convert textarea string to array.
     */
    private function convertTextareaToArray(?string $text): ?array
    {
        if (empty($text)) {
            return null;
        }

        return array_filter(
            array_map('trim', explode("\n", $text)),
            fn($value) => !empty($value)
        );
    }
}
