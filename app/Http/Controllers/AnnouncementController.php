<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class AnnouncementController extends Controller
{
    public function index(Request $request)
    {
        $query = Announcement::published()->with('user');
        
        // Filter by priority
        if ($request->has('priority') && $request->priority) {
            $query->where('priority', $request->priority);
        }
        
        // Search
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('excerpt', 'like', '%' . $request->search . '%')
                  ->orWhere('content', 'like', '%' . $request->search . '%');
            });
        }
        
        $announcements = $query->orderBy('is_pinned', 'desc')
                               ->orderBy('priority', 'desc')
                               ->latest('published_at')
                               ->paginate(10);
        
        $pinnedAnnouncements = Announcement::published()->pinned()->latest('published_at')->take(3)->get();
        
        return view('frontend.announcements.index', compact('announcements', 'pinnedAnnouncements'));
    }
    
    public function show($slug)
    {
        $announcement = Announcement::where('slug', $slug)->published()->with('user')->firstOrFail();
        
        // Increment views (only if column exists)
        if (Schema::hasColumn('announcements', 'views')) {
            $announcement->increment('views');
        }
        
        // Get previous and next announcements
        $previousAnnouncement = Announcement::published()
            ->where('published_at', '<', $announcement->published_at)
            ->orderBy('published_at', 'desc')
            ->first(['slug', 'title']);
            
        $nextAnnouncement = Announcement::published()
            ->where('published_at', '>', $announcement->published_at)
            ->orderBy('published_at', 'asc')
            ->first(['slug', 'title']);
        
        // Get recent announcements for sidebar
        $recentAnnouncements = Announcement::published()
            ->where('id', '!=', $announcement->id)
            ->latest('published_at')
            ->take(5)
            ->get(['slug', 'title', 'published_at', 'priority']);
        
        return view('frontend.announcements.show', compact(
            'announcement', 
            'previousAnnouncement', 
            'nextAnnouncement', 
            'recentAnnouncements'
        ));
    }
}
