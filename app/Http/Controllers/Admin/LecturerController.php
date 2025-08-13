<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lecturer;
use App\Models\Faculty;
use App\Models\StudyProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class LecturerController extends Controller
{
    public function index(Request $request)
    {
        $query = Lecturer::with(['faculty']);
        
        // Search
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('nidn', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }
        
        // Faculty filter
        if ($request->has('faculty') && $request->faculty) {
            $query->where('faculty_id', $request->faculty);
        }
        
        // Position filter
        if ($request->has('position') && $request->position) {
            $query->where('position', $request->position);
        }
        
        // Status filter
        if ($request->has('status') && $request->status !== '') {
            $query->where('is_active', $request->status);
        }
        
        $lecturers = $query->orderBy('faculty_id', 'asc')
                          ->orderBy('position', 'asc')
                          ->orderBy('name', 'asc')
                          ->paginate(15);
        
        $faculties = Faculty::active()->orderBy('name')->get();
        $positions = ['Asisten Ahli', 'Lektor', 'Lektor Kepala', 'Guru Besar'];
        
        return view('admin.lecturers.index', compact('lecturers', 'faculties', 'positions'));
    }
    
    public function create()
    {
        $faculties = Faculty::active()->orderBy('name')->get();
        $studyPrograms = StudyProgram::active()->orderBy('name')->get();
        $positions = ['Asisten Ahli', 'Lektor', 'Lektor Kepala', 'Guru Besar'];
        
        return view('admin.lecturers.create', compact('faculties', 'studyPrograms', 'positions'));
    }
    
    public function store(Request $request)
    {
        // Debug: Log incoming request data
        \Log::info('Lecturer creation attempt', [
            'request_data' => $request->all(),
            'has_files' => $request->hasFile('photo')
        ]);
        
        $request->validate([
            'nidn' => 'required|string|unique:lecturers,lecturer_id',
            'name' => 'required|string|max:255',
            'title_prefix' => 'nullable|string|max:50',
            'title_suffix' => 'nullable|string|max:100',
            'gender' => 'required|in:male,female',
            'email' => 'nullable|email|unique:lecturers,email',
            'phone' => 'nullable|string|max:20',
            'faculty_id' => 'required|exists:faculties,id',
            'position' => 'required|in:Asisten Ahli,Lektor,Lektor Kepala,Guru Besar',
            'education_background' => 'nullable|string|max:255',
            'office_room' => 'nullable|string|max:100',
            'google_scholar' => 'nullable|url',
            'scopus_id' => 'nullable|string|max:100',
            'expertise' => 'nullable|string',
            'biography' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'study_program_ids' => 'nullable|array',
            'study_program_ids.*' => 'exists:study_programs,id',
            'is_active' => 'boolean',
        ]);
        
        \Log::info('Validation passed');
        
        $data = $request->except(['photo', 'study_program_ids', 'nidn']);
        
        // Map nidn to lecturer_id
        $data['lecturer_id'] = $request->nidn;
        
        // Map position from form format to database format
        $positionMap = [
            'Asisten Ahli' => 'asisten_ahli',
            'Lektor' => 'lektor',
            'Lektor Kepala' => 'lektor_kepala',
            'Guru Besar' => 'guru_besar'
        ];
        $data['position'] = $positionMap[$request->position] ?? null;
        
        // Set default values for required fields that aren't in form
        $data['birth_date'] = now()->subYears(30)->format('Y-m-d'); // Default birth date
        $data['birth_place'] = 'Jakarta'; // Default birth place
        $data['join_date'] = now()->format('Y-m-d'); // Default join date
        $data['employment_status'] = 'tetap'; // Default employment status
        
        $data['is_active'] = $request->has('is_active');
        
        \Log::info('Data prepared for creation', ['data' => $data]);
        
        // Handle photo upload
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('lecturers', 'public');
            \Log::info('Photo uploaded', ['photo_path' => $data['photo']]);
        }
        
        try {
            $lecturer = Lecturer::create($data);
            \Log::info('Lecturer created successfully', ['lecturer_id' => $lecturer->id]);
            
            // Sync study programs
            if ($request->study_program_ids) {
                $lecturer->studyPrograms()->sync($request->study_program_ids);
                \Log::info('Study programs synced', ['study_program_ids' => $request->study_program_ids]);
            }
            
            return redirect()->route('admin.lecturers.index')
                            ->with('success', 'Dosen berhasil ditambahkan.');
        } catch (\Exception $e) {
            \Log::error('Failed to create lecturer', [
                'error' => $e->getMessage(),
                'data' => $data
            ]);
            
            return redirect()->back()
                            ->withInput()
                            ->with('error', 'Gagal menyimpan data dosen: ' . $e->getMessage());
        }
    }
    
    public function show(Lecturer $lecturer)
    {
        $lecturer->load(['faculty', 'studyPrograms']);
        
        return view('admin.lecturers.show', compact('lecturer'));
    }
    
    public function edit(Lecturer $lecturer)
    {
        $faculties = Faculty::active()->orderBy('name')->get();
        $studyPrograms = StudyProgram::active()->orderBy('name')->get();
        $positions = ['Asisten Ahli', 'Lektor', 'Lektor Kepala', 'Guru Besar'];
        $lecturerStudyPrograms = $lecturer->studyPrograms->pluck('id')->toArray();
        
        return view('admin.lecturers.edit', compact('lecturer', 'faculties', 'studyPrograms', 'positions', 'lecturerStudyPrograms'));
    }
    
    public function update(Request $request, Lecturer $lecturer)
    {
        $request->validate([
            'nidn' => 'required|string|unique:lecturers,lecturer_id,' . $lecturer->id,
            'name' => 'required|string|max:255',
            'title_prefix' => 'nullable|string|max:50',
            'title_suffix' => 'nullable|string|max:100',
            'gender' => 'required|in:male,female',
            'email' => 'nullable|email|unique:lecturers,email,' . $lecturer->id,
            'phone' => 'nullable|string|max:20',
            'faculty_id' => 'required|exists:faculties,id',
            'position' => 'required|in:Asisten Ahli,Lektor,Lektor Kepala,Guru Besar',
            'education_background' => 'nullable|string|max:255',
            'office_room' => 'nullable|string|max:100',
            'google_scholar' => 'nullable|url',
            'scopus_id' => 'nullable|string|max:100',
            'expertise' => 'nullable|string',
            'biography' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'study_program_ids' => 'nullable|array',
            'study_program_ids.*' => 'exists:study_programs,id',
            'is_active' => 'boolean',
        ]);
        
        $data = $request->except(['photo', 'study_program_ids', 'nidn']);
        
        // Map nidn to lecturer_id
        $data['lecturer_id'] = $request->nidn;
        
        // Map position from form format to database format
        $positionMap = [
            'Asisten Ahli' => 'asisten_ahli',
            'Lektor' => 'lektor',
            'Lektor Kepala' => 'lektor_kepala',
            'Guru Besar' => 'guru_besar'
        ];
        $data['position'] = $positionMap[$request->position] ?? null;
        
        $data['is_active'] = $request->has('is_active');
        
        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($lecturer->photo) {
                Storage::disk('public')->delete($lecturer->photo);
            }
            $data['photo'] = $request->file('photo')->store('lecturers', 'public');
        }
        
        $lecturer->update($data);
        
        // Sync study programs
        if ($request->study_program_ids) {
            $lecturer->studyPrograms()->sync($request->study_program_ids);
        } else {
            $lecturer->studyPrograms()->detach();
        }
        
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
}
