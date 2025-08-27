<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lecturer;
use App\Models\StudyProgram;
use App\Models\StructuralPosition;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class LecturerController extends Controller
{
    public function index(Request $request)
    {
        $query = Lecturer::with('structuralPosition');
        
        // Search
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('nidn', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }
        
        // Position filter
        if ($request->has('position') && $request->position) {
            $query->where('position', $request->position);
        }
        
        // Structural position filter
        if ($request->has('structural_position') && $request->structural_position) {
            $query->where('structural_position_id', $request->structural_position);
        }
        
        // Status filter
        if ($request->has('status') && $request->status !== '') {
            $query->where('is_active', $request->status);
        }
        
        $lecturers = $query->orderBy('position', 'asc')
                          ->orderBy('name', 'asc')
                          ->paginate(15);
        
        $positions = ['Asisten Ahli', 'Lektor', 'Lektor Kepala', 'Guru Besar'];
        $structuralPositions = Lecturer::getStructuralPositions();
        
        return view('admin.lecturers.index', compact('lecturers', 'positions', 'structuralPositions'));
    }

    public function structural(Request $request)
    {
        $query = Lecturer::with(['structuralPosition', 'studyPrograms'])
            ->whereNotNull('structural_position_id')
            ->where('is_active', true);
        
        // Search
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('nidn', 'like', '%' . $request->search . '%')
                  ->orWhereHas('structuralPosition', function($sq) use ($request) {
                      $sq->where('name', 'like', '%' . $request->search . '%');
                  });
            });
        }
        
        // Structural position filter
        if ($request->has('structural_position') && $request->structural_position) {
            $query->where('structural_position_id', $request->structural_position);
        }
        
        // Category filter
        if ($request->has('category') && $request->category) {
            $query->whereHas('structuralPosition', function($q) use ($request) {
                $q->where('category', $request->category);
            });
        }
        
        // Status filter (active, upcoming, expired)
        if ($request->has('status') && $request->status) {
            $now = now();
            switch ($request->status) {
                case 'active':
                    $query->where(function($q) use ($now) {
                        $q->where(function($sq) use ($now) {
                            $sq->whereNull('structural_start_date')
                               ->orWhere('structural_start_date', '<=', $now);
                        })->where(function($sq) use ($now) {
                            $sq->whereNull('structural_end_date')
                               ->orWhere('structural_end_date', '>=', $now);
                        });
                    });
                    break;
                case 'upcoming':
                    $query->where('structural_start_date', '>', $now);
                    break;
                case 'expired':
                    $query->where('structural_end_date', '<', $now);
                    break;
            }
        }
        
        $lecturers = $query->orderBy('structural_position_id')
                          ->orderBy('name')
                          ->paginate(15);
        
        $structuralPositions = StructuralPosition::active()->orderBy('sort_order')->pluck('name', 'id');
        $categories = StructuralPosition::getCategories();
        
        // Statistics
        $stats = [
            'total' => Lecturer::whereNotNull('structural_position_id')->where('is_active', true)->count(),
            'active' => Lecturer::whereNotNull('structural_position_id')
                ->where('is_active', true)
                ->where(function($q) {
                    $now = now();
                    $q->where(function($sq) use ($now) {
                        $sq->whereNull('structural_start_date')
                           ->orWhere('structural_start_date', '<=', $now);
                    })->where(function($sq) use ($now) {
                        $sq->whereNull('structural_end_date')
                           ->orWhere('structural_end_date', '>=', $now);
                    });
                })->count(),
            'upcoming' => Lecturer::whereNotNull('structural_position_id')
                ->where('is_active', true)
                ->where('structural_start_date', '>', now())->count(),
            'expired' => Lecturer::whereNotNull('structural_position_id')
                ->where('is_active', true)
                ->where('structural_end_date', '<', now())->count(),
        ];
        
        return view('admin.lecturers.structural', compact('lecturers', 'structuralPositions', 'categories', 'stats'));
    }

    public function create()
    {
        $studyPrograms = StudyProgram::active()->orderBy('name')->get();
        $positions = ['Asisten Ahli', 'Lektor', 'Lektor Kepala', 'Guru Besar'];
        $structuralPositions = Lecturer::getStructuralPositions();
        
        return view('admin.lecturers.create', compact('studyPrograms', 'positions', 'structuralPositions'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'nidn' => 'required|string|unique:lecturers,nidn',
            'name' => 'required|string|max:255',
            'study_program_ids' => 'nullable|array',
            'study_program_ids.*' => 'exists:study_programs,id',
            'gender' => 'required|in:male,female',
            'position' => 'required|in:Asisten Ahli,Lektor,Lektor Kepala,Guru Besar',
            'structural_position_id' => 'nullable|exists:structural_positions,id',
            'structural_description' => 'nullable|string',
            'structural_start_date' => 'nullable|date',
            'structural_end_date' => 'nullable|date|after_or_equal:structural_start_date',
            'title_prefix' => 'nullable|string|max:50',
            'title_suffix' => 'nullable|string|max:50',
            'education_background' => 'nullable|string|max:255',
            'expertise' => 'nullable|string',
            'biography' => 'nullable|string',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'office_location' => 'nullable|string|max:50',
            'google_scholar' => 'nullable|url',
            'scopus_id' => 'nullable|string|max:50',
            'orcid' => 'nullable|string|max:50',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'is_active' => 'boolean',
        ]);
        
        $data = $request->except(['photo']);
        $data['slug'] = Str::slug($request->name);
        $data['is_active'] = $request->has('is_active');
        $data['study_program_ids'] = $request->study_program_ids ? json_encode($request->study_program_ids) : null;
        
        // Handle photo upload
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('lecturers', 'public');
        }
        
        Lecturer::create($data);
        
        return redirect()->route('admin.lecturers.index')
                        ->with('success', 'Dosen berhasil ditambahkan.');
    }
    
    public function show(Lecturer $lecturer)
    {
        $lecturer->load('structuralPosition');
        $studyPrograms = StudyProgram::whereIn('id', json_decode($lecturer->study_program_ids ?? '[]'))->get();
        
        return view('admin.lecturers.show', compact('lecturer', 'studyPrograms'));
    }
    
    public function edit(Lecturer $lecturer)
    {
        $studyPrograms = StudyProgram::active()->orderBy('name')->get();
        $positions = ['Asisten Ahli', 'Lektor', 'Lektor Kepala', 'Guru Besar'];
        $structuralPositions = Lecturer::getStructuralPositions();
        $lecturerStudyPrograms = json_decode($lecturer->study_program_ids ?? '[]');
        
        return view('admin.lecturers.edit', compact('lecturer', 'studyPrograms', 'positions', 'structuralPositions', 'lecturerStudyPrograms'));
    }
    
    public function update(Request $request, Lecturer $lecturer)
    {
        $request->validate([
            'nidn' => 'required|string|unique:lecturers,nidn,' . $lecturer->id,
            'name' => 'required|string|max:255',
            'study_program_ids' => 'nullable|array',
            'study_program_ids.*' => 'exists:study_programs,id',
            'gender' => 'required|in:male,female',
            'position' => 'required|in:Asisten Ahli,Lektor,Lektor Kepala,Guru Besar',
            'structural_position_id' => 'nullable|exists:structural_positions,id',
            'structural_description' => 'nullable|string',
            'structural_start_date' => 'nullable|date',
            'structural_end_date' => 'nullable|date|after_or_equal:structural_start_date',
            'title_prefix' => 'nullable|string|max:50',
            'title_suffix' => 'nullable|string|max:50',
            'education_background' => 'nullable|string|max:255',
            'expertise' => 'nullable|string',
            'biography' => 'nullable|string',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'office_location' => 'nullable|string|max:50',
            'google_scholar' => 'nullable|url',
            'scopus_id' => 'nullable|string|max:50',
            'orcid' => 'nullable|string|max:50',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'is_active' => 'boolean',
        ]);
        
        $data = $request->except(['photo']);
        $data['slug'] = Str::slug($request->name);
        $data['is_active'] = $request->has('is_active');
        $data['study_program_ids'] = $request->study_program_ids ? json_encode($request->study_program_ids) : null;
        
        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($lecturer->photo) {
                Storage::disk('public')->delete($lecturer->photo);
            }
            $data['photo'] = $request->file('photo')->store('lecturers', 'public');
        }
        
        $lecturer->update($data);
        
        return redirect()->route('admin.lecturers.index')
                        ->with('success', 'Dosen berhasil diperbarui.');
    }
    
    public function destroy(Lecturer $lecturer)
    {
        // Delete photo if exists
        if ($lecturer->photo) {
            Storage::disk('public')->delete($lecturer->photo);
        }
        
        $lecturer->delete();
        
        return redirect()->route('admin.lecturers.index')
                        ->with('success', 'Dosen berhasil dihapus.');
    }
    
    public function toggleStatus(Lecturer $lecturer)
    {
        $lecturer->update([
            'is_active' => !$lecturer->is_active
        ]);
        
        $status = $lecturer->is_active ? 'diaktifkan' : 'dinonaktifkan';
        
        return redirect()->back()
                        ->with('success', "Dosen berhasil {$status}.");
    }
    
    public function updateStructural(Request $request, Lecturer $lecturer)
    {
        $validatedData = $request->validate([
            'structural_position_id' => 'nullable|exists:structural_positions,id',
            'structural_description' => 'nullable|string',
            'structural_start_date' => 'nullable|date',
            'structural_end_date' => 'nullable|date|after_or_equal:structural_start_date',
        ]);
        
        $lecturer->update($validatedData);
        
        $message = $validatedData['structural_position_id'] 
            ? 'Jabatan struktural berhasil diperbarui.' 
            : 'Jabatan struktural berhasil dihapus.';
        
        return redirect()->back()
                        ->with('success', $message);
    }
}
