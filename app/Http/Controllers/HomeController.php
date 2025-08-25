<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\Slider;
use App\Models\News;

class HomeController extends Controller
{
    public function index()
    {
        try {
            // Get active sections dari database
            $sections = Section::where('is_active', true)->orderBy('order')->get();

            // Get active sliders dari database  
            $sliders = Slider::active()->ordered()->get();

            // Get latest published news (max 6 for grid display)
            $latestNews = News::published()
                ->with(['category', 'user'])
                ->orderBy('published_at', 'desc')
                ->take(6)
                ->get();

            // Get latest published announcements (max 5)
            $latestAnnouncements = \App\Models\Announcement::published()
                ->orderBy('start_date', 'desc')
                ->take(5)
                ->get();


            // Get all active study programs
            $studyPrograms = \App\Models\StudyProgram::query()
                ->withCount(['students'])
                ->where('is_active', true)
                ->orderBy('sort_order', 'asc')
                ->orderBy('name', 'asc')
                ->get();


            // Get featured galleries (max 9)
            $featuredGalleries = \App\Models\Gallery::with(['category'])
                ->where('is_active', true)
                ->featured()
                ->orderByDesc('id')
                ->take(9)
                ->get();

            // Get campus officials/leaders (pejabat kampus)
            $campusOfficials = \App\Models\Lecturer::active()
                ->whereNotNull('structural_position')
                ->where(function($query) {
                    $query->whereNull('structural_end_date')
                          ->orWhere('structural_end_date', '>=', now()->subYears(1)); // Include recent officials
                })
                ->whereIn('structural_position', [
                    'Rektor', 
                    'Wakil Rektor I', 
                    'Wakil Rektor II', 
                    'Wakil Rektor III', 
                    'Wakil Rektor IV',
                    'Direktur',
                    'Wakil Direktur',
                    'Sekretaris Universitas',
                    'Dekan Fakultas Teknik',
                    'Ketua Program Studi Teknik Informatika',
                    'Ketua Program Studi Teknik Sipil',
                    'Ketua Program Studi Manajemen'
                ])
                ->orderByRaw("
                    CASE structural_position 
                        WHEN 'Rektor' THEN 1
                        WHEN 'Wakil Rektor I' THEN 2  
                        WHEN 'Wakil Rektor II' THEN 3
                        WHEN 'Wakil Rektor III' THEN 4
                        WHEN 'Wakil Rektor IV' THEN 5
                        WHEN 'Direktur' THEN 6
                        WHEN 'Wakil Direktur' THEN 7
                        WHEN 'Sekretaris Universitas' THEN 8
                        WHEN 'Dekan Fakultas Teknik' THEN 9
                        ELSE 10
                    END
                ")
                ->take(6)
                ->get();

            // Global settings
            $globalSettings = [
                'site_name' => 'KESOSI',
                'site_description' => 'Kampus Kesehatan Modern',
            ];

            return view('frontend.home', compact('sections', 'sliders', 'latestNews', 'studyPrograms', 'globalSettings', 'latestAnnouncements', 'featuredGalleries', 'campusOfficials'));

        } catch (\Exception $e) {
            // Fallback jika ada error
            \Log::error('HomeController error: ' . $e->getMessage());
            return response('<h1>Homepage Works!</h1><p>Loading sections...</p><p>Error: ' . $e->getMessage() . '</p>');
        }
    }

    public function about()
    {
        $settings = \App\Models\Setting::getGroup('about');
        return view('frontend.about', compact('settings'));
    }

    public function contact()
    {
        $settings = \App\Models\Setting::getGroup('contact');
        return view('frontend.contact', compact('settings'));
    }
}
