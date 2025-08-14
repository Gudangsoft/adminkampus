<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use App\Models\StudyProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FacultyController extends Controller
{
    public function index(Request $request)
    {
        $query = Faculty::withCount(['studyPrograms', 'students']);
        
        // Search
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }
        
        // Status filter
        if ($request->has('status') && $request->status !== '') {
            $query->where('is_active', $request->status);
        }
        
        $faculties = $query->orderBy('sort_order', 'asc')
                          ->orderBy('name', 'asc')
                          ->paginate(10);
        
        return view('admin.faculties.index', compact('faculties'));
    }
    
    public function create()
    {
        return view('admin.faculties.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:10|unique:faculties,code',
            'description' => 'nullable|string',
            'dean_name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'website' => 'nullable|url|max:255',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);
        
        $faculty = Faculty::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'code' => $request->code, // Let model auto-generate if empty
            'description' => $request->description,
            'dean_name' => $request->dean_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'website' => $request->website,
            'is_active' => $request->has('is_active'),
            'sort_order' => $request->sort_order ?? 0,
        ]);
        
        return redirect()->route('admin.faculties.index')
                        ->with('success', 'Fakultas berhasil ditambahkan.');
    }
    
    public function show(Faculty $faculty)
    {
        $faculty->load(['studyPrograms', 'lecturers', 'students']);
        $studyPrograms = $faculty->studyPrograms()->withCount(['students', 'lecturers'])->get();
        
        return view('admin.faculties.show', compact('faculty', 'studyPrograms'));
    }
    
    public function edit(Faculty $faculty)
    {
        return view('admin.faculties.edit', compact('faculty'));
    }
    
    public function update(Request $request, Faculty $faculty)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:10|unique:faculties,code,' . $faculty->id,
            'description' => 'nullable|string',
            'dean_name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'website' => 'nullable|url|max:255',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);
        
        $faculty->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'code' => $request->code ?: $faculty->code, // Keep existing if empty
            'description' => $request->description,
            'dean_name' => $request->dean_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'website' => $request->website,
            'is_active' => $request->has('is_active'),
            'sort_order' => $request->sort_order ?? 0,
        ]);
        
        return redirect()->route('admin.faculties.index')
                        ->with('success', 'Fakultas berhasil diperbarui.');
    }
    
    public function destroy(Faculty $faculty)
    {
        // Check if faculty has study programs
        if ($faculty->studyPrograms()->count() > 0) {
            return redirect()->back()
                           ->with('error', 'Tidak dapat menghapus fakultas yang masih memiliki program studi.');
        }
        
        $faculty->delete();
        
        return redirect()->route('admin.faculties.index')
                        ->with('success', 'Fakultas berhasil dihapus.');
    }
    
    public function toggleStatus(Faculty $faculty)
    {
        $faculty->update([
            'is_active' => !$faculty->is_active
        ]);
        
        $status = $faculty->is_active ? 'diaktifkan' : 'dinonaktifkan';
        
        return redirect()->back()
                        ->with('success', "Fakultas berhasil {$status}.");
    }
    
    public function updateOrder(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:faculties,id',
            'items.*.sort_order' => 'required|integer|min:0',
        ]);
        
        foreach ($request->items as $item) {
            Faculty::where('id', $item['id'])->update(['sort_order' => $item['sort_order']]);
        }
        
        return response()->json(['success' => true]);
    }
}
