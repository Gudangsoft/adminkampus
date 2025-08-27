<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Announcement;
use App\Models\Student;
use App\Models\Lecturer;
use App\Models\StudyProgram;

use App\Models\Gallery;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Statistics for dashboard
        $stats = [
            'total_news' => News::count(),
            'published_news' => News::where('status', 'published')->count(),
            'total_announcements' => Announcement::count(),
            'total_students' => Student::count(),
            'active_students' => Student::where('status', 'active')->count(),
            'total_lecturers' => Lecturer::count(),
            'active_lecturers' => Lecturer::where('is_active', true)->count(),
            'structural_lecturers' => Lecturer::whereNotNull('structural_position_id')
                                            ->where('is_active', true)->count(),
            'active_structural' => Lecturer::whereNotNull('structural_position_id')
                                         ->where('is_active', true)
                                         ->where(function($q) {
                                             $now = now();
                                             $q->where(function($sq) use ($now) {
                                                 $sq->whereNull('structural_start_date')
                                                    ->orWhere('structural_start_date', '<=', $now);
                                             })->where(function($sq) use ($now) {
                                                 $sq->whereNull('structural_end_date')
                                                    ->orWhere('structural_end_date', '>=', $now);
                                             });
                                         })->count(),
            'total_study_programs' => StudyProgram::count(),
            'active_study_programs' => StudyProgram::where('is_active', true)->count(),
           
            'total_galleries' => Gallery::count(),
        ];

        // Recent activities
        $recentNews = News::with('user')->latest()->take(5)->get();
        $recentAnnouncements = Announcement::with('user')->latest()->take(5)->get();
        $recentGalleries = Gallery::with('user')->latest()->take(5)->get();
        $recentStructuralLecturers = Lecturer::with('structuralPosition')
                                           ->whereNotNull('structural_position_id')
                                           ->where('is_active', true)
                                           ->latest('updated_at')
                                           ->take(5)
                                           ->get();

        // Monthly statistics
        $monthlyNews = News::whereMonth('created_at', now()->month)
                          ->whereYear('created_at', now()->year)
                          ->count();
                          
        $monthlyAnnouncements = Announcement::whereMonth('created_at', now()->month)
                                          ->whereYear('created_at', now()->year)
                                          ->count();

        return view('admin.dashboard', compact(
            'stats',
            'recentNews',
            'recentAnnouncements',
            'recentGalleries',
            'recentStructuralLecturers',
            'monthlyNews',
            'monthlyAnnouncements'
        ));
    }
}
