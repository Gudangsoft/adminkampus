<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Announcement;
use App\Models\StudyProgram;
use App\Models\Gallery;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->get('q');
        $results = [];
        
        if (!empty($query)) {
            // Search in news
            $news = News::where('title', 'LIKE', "%{$query}%")
                       ->orWhere('content', 'LIKE', "%{$query}%")
                       ->published()
                       ->latest()
                       ->take(5)
                       ->get();
            
            // Search in announcements
            $announcements = Announcement::where('title', 'LIKE', "%{$query}%")
                                       ->orWhere('content', 'LIKE', "%{$query}%")
                                       ->published()
                                       ->latest()
                                       ->take(5)
                                       ->get();
            
            // Search in study programs
            $studyPrograms = StudyProgram::where('name', 'LIKE', "%{$query}%")
                                       ->orWhere('description', 'LIKE', "%{$query}%")
                                       ->active()
                                       ->take(5)
                                       ->get();
            
            $results = [
                'news' => $news,
                'announcements' => $announcements,
                'study_programs' => $studyPrograms,
            ];
        }
        
        return view('frontend.search', compact('query', 'results'));
    }
}