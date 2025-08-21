<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\Slider;
use App\Models\News;
use App\Models\Faculty;

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


            // Get all active study programs, same as admin
            $studyPrograms = \App\Models\StudyProgram::with(['faculty'])
                ->withCount(['students'])
                ->where('is_active', true)
                ->orderBy('faculty_id', 'asc')
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

            // Global settings
            $globalSettings = [
                'site_name' => 'KESOSI',
                'site_description' => 'Kampus Kesehatan Modern',
            ];

            return view('frontend.home', compact('sections', 'sliders', 'latestNews', 'studyPrograms', 'globalSettings', 'latestAnnouncements', 'featuredGalleries'));

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
