<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $query = News::published()->with(['category', 'user']);
        
        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }
        
        // Search
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('excerpt', 'like', '%' . $request->search . '%')
                  ->orWhere('content', 'like', '%' . $request->search . '%');
            });
        }
        
        $news = $query->latest('published_at')->paginate(12);
        $categories = NewsCategory::active()->orderBy('name')->get();
        $featuredNews = News::published()->featured()->latest('published_at')->take(5)->get();
        
        return view('frontend.news.index', compact('news', 'categories', 'featuredNews'));
    }
    
    public function show($slug)
    {
        $news = News::where('slug', $slug)->published()->with(['category', 'user'])->firstOrFail();
        
        // Increment views
        $news->increment('views');
        
        $relatedNews = News::published()
            ->where('category_id', $news->category_id)
            ->where('id', '!=', $news->id)
            ->latest('published_at')
            ->take(4)
            ->get(['id', 'title', 'slug', 'featured_image', 'published_at', 'category_id']);
            
        $latestNews = News::published()
            ->with('category')
            ->latest('published_at')
            ->take(5)
            ->get(['id', 'title', 'slug', 'featured_image', 'published_at', 'category_id']);
        
        return view('frontend.news.show', compact('news', 'relatedNews', 'latestNews'));
    }
    
    public function category($slug)
    {
        $category = NewsCategory::where('slug', $slug)->active()->firstOrFail();
        $news = News::published()
            ->where('category_id', $category->id)
            ->latest('published_at')
            ->paginate(12);
            
        $featuredNews = News::published()->featured()->latest('published_at')->take(5)->get();
        
        return view('frontend.news.category', compact('category', 'news', 'featuredNews'));
    }
}
