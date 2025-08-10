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
            
            // Get active faculties (max 6 for display)
            $faculties = Faculty::active()
                ->withCount(['studyPrograms', 'lecturers'])
                ->orderBy('sort_order')
                ->orderBy('name')
                ->take(6)
                ->get();
            
            // Global settings
            $globalSettings = [
                'site_name' => 'KESOSI',
                'site_description' => 'Kampus Kesehatan Modern',
            ];
            
            return view('frontend.home', compact('sections', 'sliders', 'latestNews', 'faculties', 'globalSettings'));
            
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
