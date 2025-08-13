<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Gallery;
use App\Models\Page;
use App\Models\Announcement;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');
        $type = $request->input('type', 'all');
        
        if (empty($query)) {
            return view('frontend.search', [
                'query' => $query,
                'results' => collect(),
                'total' => 0
            ]);
        }
        
        $results = collect();
        
        if ($type === 'all' || $type === 'news') {
            $news = News::published()
                ->where(function($q) use ($query) {
                    $q->where('title', 'LIKE', "%{$query}%")
                      ->orWhere('content', 'LIKE', "%{$query}%")
                      ->orWhere('excerpt', 'LIKE', "%{$query}%");
                })
                ->with(['category', 'user'])
                ->take(10)
                ->get()
                ->map(function($item) {
                    $item->type = 'news';
                    $item->url = route('news.show', $item->slug);
                    return $item;
                });
            
            $results = $results->merge($news);
        }
        
        if ($type === 'all' || $type === 'gallery') {
            $galleries = Gallery::where(function($q) use ($query) {
                    $q->where('title', 'LIKE', "%{$query}%")
                      ->orWhere('description', 'LIKE', "%{$query}%");
                })
                ->with(['category'])
                ->take(10)
                ->get()
                ->map(function($item) {
                    $item->type = 'gallery';
                    $item->url = route('gallery.show', $item->slug);
                    return $item;
                });
            
            $results = $results->merge($galleries);
        }
        
        if ($type === 'all' || $type === 'pages') {
            $pages = Page::active()
                ->where(function($q) use ($query) {
                    $q->where('title', 'LIKE', "%{$query}%")
                      ->orWhere('content', 'LIKE', "%{$query}%");
                })
                ->take(10)
                ->get()
                ->map(function($item) {
                    $item->type = 'page';
                    $item->url = route('page.show', $item->slug);
                    return $item;
                });
            
            $results = $results->merge($pages);
        }
        
        if ($type === 'all' || $type === 'announcements') {
            $announcements = Announcement::where(function($q) use ($query) {
                    $q->where('title', 'LIKE', "%{$query}%")
                      ->orWhere('content', 'LIKE', "%{$query}%");
                })
                ->take(10)
                ->get()
                ->map(function($item) {
                    $item->type = 'announcement';
                    $item->url = route('announcements.show', $item->slug);
                    return $item;
                });
            
            $results = $results->merge($announcements);
        }
        
        // Sort by relevance (title matches first)
        $results = $results->sortByDesc(function($item) use ($query) {
            return stripos($item->title, $query) !== false ? 1 : 0;
        });
        
        return view('frontend.search', [
            'query' => $query,
            'type' => $type,
            'results' => $results,
            'total' => $results->count()
        ]);
    }
}
