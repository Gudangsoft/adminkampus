<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StructuralPosition;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StructuralPositionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = StructuralPosition::query();

        // Search filter
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%')
                  ->orWhere('category', 'like', '%' . $request->search . '%');
            });
        }

        // Category filter
        if ($request->has('category') && $request->category) {
            $query->where('category', $request->category);
        }

        // Status filter
        if ($request->has('status') && $request->status !== '') {
            $query->where('is_active', $request->status);
        }

        $structuralPositions = $query->orderBy('level', 'asc')
                                   ->orderBy('sort_order', 'asc')
                                   ->orderBy('name', 'asc')
                                   ->paginate(15);

        $categories = StructuralPosition::getCategories();

        return view('admin.structural-positions.index', compact('structuralPositions', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = StructuralPosition::getCategories();
        return view('admin.structural-positions.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:structural_positions,name',
            'description' => 'nullable|string',
            'category' => 'required|string|max:255',
            'level' => 'required|integer|min:1|max:10',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean'
        ]);

        $validatedData['slug'] = Str::slug($validatedData['name']);
        $validatedData['sort_order'] = $validatedData['sort_order'] ?? 0;
        $validatedData['is_active'] = $request->has('is_active');

        StructuralPosition::create($validatedData);

        return redirect()->route('admin.structural-positions.index')
                        ->with('success', 'Jabatan struktural berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(StructuralPosition $structuralPosition)
    {
        $structuralPosition->loadCount('lecturers');
        $lecturers = $structuralPosition->lecturers()->limit(10)->get();
        
        return view('admin.structural-positions.show', compact('structuralPosition', 'lecturers'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StructuralPosition $structuralPosition)
    {
        $categories = StructuralPosition::getCategories();
        return view('admin.structural-positions.edit', compact('structuralPosition', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StructuralPosition $structuralPosition)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('structural_positions', 'name')->ignore($structuralPosition->id)],
            'description' => 'nullable|string',
            'category' => 'required|string|max:255',
            'level' => 'required|integer|min:1|max:10',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean'
        ]);

        $validatedData['slug'] = Str::slug($validatedData['name']);
        $validatedData['sort_order'] = $validatedData['sort_order'] ?? 0;
        $validatedData['is_active'] = $request->has('is_active');

        $structuralPosition->update($validatedData);

        return redirect()->route('admin.structural-positions.index')
                        ->with('success', 'Jabatan struktural berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StructuralPosition $structuralPosition)
    {
        // Check if position is being used by any lecturer
        if ($structuralPosition->lecturers()->count() > 0) {
            return redirect()->back()
                           ->with('error', 'Tidak dapat menghapus jabatan yang sedang digunakan oleh dosen.');
        }

        $structuralPosition->delete();

        return redirect()->route('admin.structural-positions.index')
                        ->with('success', 'Jabatan struktural berhasil dihapus.');
    }

    /**
     * Toggle the status of the specified resource.
     */
    public function toggleStatus(StructuralPosition $structuralPosition)
    {
        $structuralPosition->update([
            'is_active' => !$structuralPosition->is_active
        ]);

        $status = $structuralPosition->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->back()
                        ->with('success', "Jabatan struktural berhasil {$status}.");
    }
}
