<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SectionController extends Controller
{
    public function index()
    {
        $sections = Section::ordered()->get();
        return view('admin.sections.index', compact('sections'));
    }

    public function create()
    {
        return view('admin.sections.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'link' => 'nullable|url',
            'link_text' => 'nullable|string|max:255',
            'background_color' => 'nullable|string|max:7',
            'text_color' => 'nullable|string|max:7',
            'order' => 'required|integer|min:0',
            'is_active' => 'boolean',
            'type' => 'required|in:hero,content,feature,cta,gallery'
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('sections', 'public');
        }

        Section::create($data);

        return redirect()->route('admin.sections.index')->with('success', 'Section berhasil ditambahkan!');
    }

    public function show(Section $section)
    {
        return view('admin.sections.show', compact('section'));
    }

    public function edit(Section $section)
    {
        return view('admin.sections.edit', compact('section'));
    }

    public function update(Request $request, Section $section)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'link' => 'nullable|url',
            'link_text' => 'nullable|string|max:255',
            'background_color' => 'nullable|string|max:7',
            'text_color' => 'nullable|string|max:7',
            'order' => 'required|integer|min:0',
            'is_active' => 'boolean',
            'type' => 'required|in:hero,content,feature,cta,gallery'
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($section->image) {
                Storage::disk('public')->delete($section->image);
            }
            $data['image'] = $request->file('image')->store('sections', 'public');
        }

        $section->update($data);

        return redirect()->route('admin.sections.index')->with('success', 'Section berhasil diperbarui!');
    }

    public function destroy(Section $section)
    {
        // Hapus gambar jika ada
        if ($section->image) {
            Storage::disk('public')->delete($section->image);
        }

        $section->delete();

        return redirect()->route('admin.sections.index')->with('success', 'Section berhasil dihapus!');
    }

    public function updateOrder(Request $request)
    {
        $sections = $request->input('sections');
        
        foreach ($sections as $index => $id) {
            Section::where('id', $id)->update(['order' => $index + 1]);
        }

        return response()->json(['success' => true]);
    }

    public function toggleStatus(Section $section)
    {
        $section->update(['is_active' => !$section->is_active]);
        
        return response()->json([
            'success' => true,
            'status' => $section->is_active,
            'message' => 'Status section berhasil diubah!'
        ]);
    }
}
