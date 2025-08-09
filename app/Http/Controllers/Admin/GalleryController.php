<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\GalleryCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $query = Gallery::with(['category', 'user']);
        
        // Search
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%')
                  ->orWhere('photographer', 'like', '%' . $request->search . '%');
            });
        }
        
        // Category filter
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }
        
        // Type filter
        if ($request->has('type') && $request->type) {
            $query->where('type', $request->type);
        }
        
        // Featured filter
        if ($request->has('featured') && $request->featured !== '') {
            $query->where('is_featured', $request->featured);
        }
        
        $galleries = $query->orderBy('created_at', 'desc')->paginate(15);
        
        // Get filter data
        $categories = GalleryCategory::active()->orderBy('name')->get();
        
        // Statistics
        $totalGalleries = Gallery::count();
        $totalImages = Gallery::where('type', 'image')->count();
        $totalVideos = Gallery::where('type', 'video')->count();
        $featuredCount = Gallery::where('is_featured', true)->count();
        
        return view('admin.galleries.index', compact(
            'galleries', 
            'categories',
            'totalGalleries',
            'totalImages',
            'totalVideos',
            'featuredCount'
        ));
    }

    public function create()
    {
        $categories = GalleryCategory::active()->orderBy('name')->get();
        return view('admin.galleries.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:gallery_categories,id',
            'type' => 'required|in:image,video',
            'file_path' => 'nullable|string', // For YouTube URL
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240', // 10MB for images
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'alt_text' => 'nullable|string|max:255',
            'photographer' => 'nullable|string|max:255',
            'taken_at' => 'nullable|date',
            'is_featured' => 'boolean'
        ]);

        // Generate slug
        $validated['slug'] = Str::slug($validated['title']);
        $counter = 1;
        $originalSlug = $validated['slug'];
        while (Gallery::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $originalSlug . '-' . $counter;
            $counter++;
        }

        // Handle file upload for images
        if ($request->type === 'image' && $request->hasFile('image_file')) {
            $validated['file_path'] = $request->file('image_file')->store('galleries/images', 'public');
        }

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('galleries/thumbnails', 'public');
        } elseif ($request->type === 'video' && $request->file_path) {
            // Extract YouTube thumbnail
            $validated['thumbnail'] = $this->getYouTubeThumbnail($request->file_path);
        }

        // Set user
        $validated['user_id'] = auth()->id();
        $validated['is_featured'] = $request->has('is_featured');

        // Extract metadata
        if ($request->type === 'video' && $request->file_path) {
            $validated['metadata'] = $this->extractYouTubeMetadata($request->file_path);
        }

        Gallery::create($validated);

        return redirect()->route('admin.galleries.index')->with('success', 'Gallery item created successfully.');
    }

    public function show(Gallery $gallery)
    {
        $gallery->load(['category', 'user']);
        $gallery->incrementViews();
        
        return view('admin.galleries.show', compact('gallery'));
    }

    public function edit(Gallery $gallery)
    {
        $categories = GalleryCategory::active()->orderBy('name')->get();
        return view('admin.galleries.edit', compact('gallery', 'categories'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:gallery_categories,id',
            'type' => 'required|in:image,video',
            'file_path' => 'nullable|string',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'alt_text' => 'nullable|string|max:255',
            'photographer' => 'nullable|string|max:255',
            'taken_at' => 'nullable|date',
            'is_featured' => 'boolean'
        ]);

        // Update slug if title changed
        if ($validated['title'] !== $gallery->title) {
            $validated['slug'] = Str::slug($validated['title']);
            $counter = 1;
            $originalSlug = $validated['slug'];
            while (Gallery::where('slug', $validated['slug'])->where('id', '!=', $gallery->id)->exists()) {
                $validated['slug'] = $originalSlug . '-' . $counter;
                $counter++;
            }
        }

        // Handle file upload for images
        if ($request->type === 'image' && $request->hasFile('image_file')) {
            // Delete old file
            if ($gallery->file_path && Storage::disk('public')->exists($gallery->file_path)) {
                Storage::disk('public')->delete($gallery->file_path);
            }
            $validated['file_path'] = $request->file('image_file')->store('galleries/images', 'public');
        }

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail
            if ($gallery->thumbnail && Storage::disk('public')->exists($gallery->thumbnail)) {
                Storage::disk('public')->delete($gallery->thumbnail);
            }
            $validated['thumbnail'] = $request->file('thumbnail')->store('galleries/thumbnails', 'public');
        } elseif ($request->type === 'video' && $request->file_path && $request->file_path !== $gallery->file_path) {
            // Update YouTube thumbnail if URL changed
            $validated['thumbnail'] = $this->getYouTubeThumbnail($request->file_path);
        }

        $validated['is_featured'] = $request->has('is_featured');

        // Update metadata for videos
        if ($request->type === 'video' && $request->file_path && $request->file_path !== $gallery->file_path) {
            $validated['metadata'] = $this->extractYouTubeMetadata($request->file_path);
        }

        $gallery->update($validated);

        return redirect()->route('admin.galleries.show', $gallery)->with('success', 'Gallery item updated successfully.');
    }

    public function destroy(Gallery $gallery)
    {
        // Delete files
        if ($gallery->file_path && $gallery->type === 'image' && Storage::disk('public')->exists($gallery->file_path)) {
            Storage::disk('public')->delete($gallery->file_path);
        }
        if ($gallery->thumbnail && Storage::disk('public')->exists($gallery->thumbnail)) {
            Storage::disk('public')->delete($gallery->thumbnail);
        }

        $gallery->delete();

        return redirect()->route('admin.galleries.index')->with('success', 'Gallery item deleted successfully.');
    }

    public function toggleFeatured(Gallery $gallery)
    {
        $gallery->update(['is_featured' => !$gallery->is_featured]);
        
        return back()->with('success', 'Featured status updated successfully.');
    }

    private function getYouTubeThumbnail($url)
    {
        $videoId = $this->extractYouTubeVideoId($url);
        if ($videoId) {
            return "https://img.youtube.com/vi/{$videoId}/maxresdefault.jpg";
        }
        return null;
    }

    private function extractYouTubeVideoId($url)
    {
        $pattern = '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/';
        preg_match($pattern, $url, $matches);
        return isset($matches[1]) ? $matches[1] : null;
    }

    private function extractYouTubeMetadata($url)
    {
        $videoId = $this->extractYouTubeVideoId($url);
        return [
            'video_id' => $videoId,
            'url' => $url,
            'platform' => 'youtube',
            'embed_url' => $videoId ? "https://www.youtube.com/embed/{$videoId}" : null
        ];
    }
}
