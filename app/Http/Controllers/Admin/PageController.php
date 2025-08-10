<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pages = Page::with('user')
            ->latest()
            ->paginate(15);

        return view('admin.pages.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'status' => 'required|in:draft,published',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'template' => 'nullable|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
        ]);

        $data = $request->only([
            'title', 'content', 'status', 'template', 'show_in_menu', 'menu_order'
        ]);

        // Generate slug
        $data['slug'] = $request->slug ?: Str::slug($request->title);
        
        // Make sure slug is unique
        $originalSlug = $data['slug'];
        $counter = 1;
        while (Page::where('slug', $data['slug'])->exists()) {
            $data['slug'] = $originalSlug . '-' . $counter;
            $counter++;
        }

        $data['user_id'] = Auth::id();
        $data['show_in_menu'] = $request->has('show_in_menu');

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('pages', 'public');
        }

        // Handle meta data
        $data['meta_data'] = [
            'title' => $request->meta_title,
            'description' => $request->meta_description,
            'keywords' => $request->meta_keywords,
        ];

        Page::create($data);

        return redirect()->route('admin.pages.index')->with('success', 'Halaman berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Page $page)
    {
        return view('admin.pages.show', compact('page'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Page $page)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'status' => 'required|in:draft,published',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'template' => 'nullable|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
        ]);

        $data = $request->only([
            'title', 'content', 'status', 'template', 'show_in_menu', 'menu_order'
        ]);

        // Generate slug if title changed
        if ($request->title !== $page->title) {
            $data['slug'] = $request->slug ?: Str::slug($request->title);
            
            // Make sure slug is unique
            $originalSlug = $data['slug'];
            $counter = 1;
            while (Page::where('slug', $data['slug'])->where('id', '!=', $page->id)->exists()) {
                $data['slug'] = $originalSlug . '-' . $counter;
                $counter++;
            }
        }

        $data['show_in_menu'] = $request->has('show_in_menu');

        // Handle featured image upload and removal
        if ($request->has('remove_image') && $page->featured_image) {
            // Remove existing image
            Storage::disk('public')->delete($page->featured_image);
            $data['featured_image'] = null;
        } elseif ($request->hasFile('featured_image')) {
            // Delete old image if uploading new one
            if ($page->featured_image) {
                Storage::disk('public')->delete($page->featured_image);
            }
            $data['featured_image'] = $request->file('featured_image')->store('pages', 'public');
        }

        // Handle meta data
        $data['meta_data'] = [
            'title' => $request->meta_title,
            'description' => $request->meta_description,
            'keywords' => $request->meta_keywords,
        ];

        $page->update($data);

        return redirect()->route('admin.pages.index')->with('success', 'Halaman berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Page $page)
    {
        // Delete featured image
        if ($page->featured_image) {
            Storage::disk('public')->delete($page->featured_image);
        }

        $page->delete();

        return redirect()->route('admin.pages.index')->with('success', 'Halaman berhasil dihapus.');
    }

    /**
     * Toggle page status
     */
    public function toggleStatus(Page $page)
    {
        $page->update([
            'status' => $page->status === 'published' ? 'draft' : 'published'
        ]);

        return response()->json([
            'success' => true,
            'status' => $page->status,
            'message' => 'Status halaman berhasil diubah.'
        ]);
    }
}
