<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index(Request $request)
    {
        $query = Announcement::where('status', 'active')
                             ->where('start_date', '<=', now())
                             ->where('end_date', '>=', now())
                             ->with('user');
        
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
        
        $announcements = $query->orderBy('is_featured', 'desc')
                               ->orderBy('priority', 'desc')
                               ->latest('start_date')
                               ->paginate(10);
        
        $pinnedAnnouncements = Announcement::where('status', 'active')
                                          ->where('start_date', '<=', now())
                                          ->where('end_date', '>=', now())
                                          ->where('is_featured', true)
                                          ->latest('start_date')
                                          ->take(3)
                                          ->get();
        
        return view('frontend.announcements.index', compact('announcements', 'pinnedAnnouncements'));
    }
    
    public function show($slug)
    {
        $announcement = Announcement::where('slug', $slug)
                                   ->where('status', 'active')
                                   ->where('start_date', '<=', now())
                                   ->where('end_date', '>=', now())
                                   ->with('user')
                                   ->firstOrFail();
        
        // Increment views
        $announcement->increment('views');
        
        // Get previous and next announcements
        $previousAnnouncement = Announcement::where('status', 'active')
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->where('start_date', '<', $announcement->start_date)
            ->orderBy('start_date', 'desc')
            ->first(['slug', 'title']);
            
        $nextAnnouncement = Announcement::where('status', 'active')
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->where('start_date', '>', $announcement->start_date)
            ->orderBy('start_date', 'asc')
            ->first(['slug', 'title']);
        
        // Get recent announcements for sidebar
        $recentAnnouncements = Announcement::where('status', 'active')
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->where('id', '!=', $announcement->id)
            ->latest('start_date')
            ->take(5)
            ->get(['slug', 'title', 'start_date', 'priority']);
        
        return view('frontend.announcements.show', compact(
            'announcement', 
            'previousAnnouncement', 
            'nextAnnouncement', 
            'recentAnnouncements'
        ));
    }
}
