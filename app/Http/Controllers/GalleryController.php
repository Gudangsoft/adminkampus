<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\GalleryCategory;
use App\Services\SEOService;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    protected $seoService;

    public function __construct(SEOService $seoService)
    {
        $this->seoService = $seoService;
    }
    public function index(Request $request)
    {
        $query = Gallery::with(['category', 'user']);
        
        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }
        
        // Filter by type
        if ($request->has('type') && $request->type) {
            $query->where('type', $request->type);
        }
        
        // Search
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }
        
        $galleries = $query->latest()->paginate(16);
        $categories = GalleryCategory::active()->orderBy('sort_order')->get();
        
        // Get featured galleries only if no filters applied
        $featuredGalleries = collect();
        if (!$request->hasAny(['category', 'type', 'search'])) {
            $featuredGalleries = Gallery::where('is_featured', true)->latest()->take(8)->get();
        }
        
        // SEO for gallery listing
        $this->seoService->forGallery();
        
        return view('frontend.gallery.index', compact('galleries', 'categories', 'featuredGalleries'));
    }
    
    public function show($slug)
    {
        $gallery = Gallery::where('slug', $slug)->with(['category', 'user'])->firstOrFail();
        $gallery->incrementViews();
        
        $relatedGalleries = Gallery::where('category_id', $gallery->category_id)
            ->where('id', '!=', $gallery->id)
            ->latest()
            ->take(8)
            ->get();
        
        // SEO for specific gallery
        $this->seoService->forGallery($gallery);
        
        return view('frontend.gallery.show', compact('gallery', 'relatedGalleries'));
    }
    
    public function category($slug, Request $request)
    {
        $category = GalleryCategory::where('slug', $slug)->active()->firstOrFail();
        
        $query = Gallery::where('category_id', $category->id);
        
        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        
        // Sort
        switch ($request->get('sort', 'latest')) {
            case 'oldest':
                $query->oldest();
                break;
            case 'title':
                $query->orderBy('title');
                break;
            case 'views':
                $query->orderBy('views', 'desc');
                break;
            default:
                $query->latest();
        }
        
        $galleries = $query->paginate(16);
        
        return view('frontend.gallery.category', compact('category', 'galleries'));
    }
}
