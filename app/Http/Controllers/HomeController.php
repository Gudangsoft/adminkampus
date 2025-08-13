<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\Slider;
use App\Models\News;
use App\Models\Faculty;
use App\Models\Gallery;
use App\Models\Announcement;
use App\Services\SEOService;
use Illuminate\Support\Facades\Schema;

class HomeController extends Controller
{
    protected $seoService;

    public function __construct(SEOService $seoService)
    {
        $this->seoService = $seoService;
    }
    public function index()
    {
        try {
            // Get active sections dari database
            $sections = \Schema::hasTable('sections') ? Section::where('is_active', true)->orderBy('order')->get() : collect();
            
            // Get active sliders dari database  
            $sliders = \Schema::hasTable('sliders') ? Slider::active()->ordered()->get() : collect();
            
            // Get latest published news (max 6 for grid display)
            $latestNews = \Schema::hasTable('news') ? News::published()
                ->orderBy('published_at', 'desc')
                ->take(6)
                ->get() : collect();
            
            // Get latest active announcements (max 5 for sidebar/info box)
            $latestAnnouncements = \Schema::hasTable('announcements') ? Announcement::where('status', 'active')
                ->where('start_date', '<=', now())
                ->where('end_date', '>=', now())
                ->orderBy('start_date', 'desc')
                ->take(5)
                ->get() : collect();
            
            // Get active faculties (max 6 for display)
            $faculties = \Schema::hasTable('faculties') ? Faculty::active()
                ->orderBy('name')
                ->take(6)
                ->get() : collect();
            
            // Get featured galleries (max 8 for grid display)
            $featuredGalleries = \Schema::hasTable('galleries') ? Gallery::where('is_featured', true)
                ->orderBy('created_at', 'desc')
                ->take(8)
                ->get() : collect();
            
            // Get latest galleries (max 12 for display)
            $latestGalleries = \Schema::hasTable('galleries') ? Gallery::orderBy('created_at', 'desc')
                ->take(12)
                ->get() : collect();
            
            // Global settings
            $globalSettings = [
                'site_name' => 'KESOSI',
                'site_description' => 'Kampus Kesehatan Modern',
            ];
            
            // SEO for homepage
            $this->seoService->forPage();
            
            return view('frontend.home', compact('sections', 'sliders', 'latestNews', 'latestAnnouncements', 'faculties', 'featuredGalleries', 'latestGalleries', 'globalSettings'));
            
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
