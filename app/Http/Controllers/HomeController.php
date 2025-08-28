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
            $campusOfficials = \App\Models\Lecturer::where('lecturers.is_active', 1)
                ->whereNotNull('structural_position_id')
                ->with('structuralPosition')
                ->where(function($query) {
                    $query->whereNull('structural_end_date')
                          ->orWhere('structural_end_date', '>=', now()->subYears(1)); // Include recent officials
                })
                ->whereHas('structuralPosition', function($query) {
                    $query->where('structural_positions.is_active', 1);
                })
                ->join('structural_positions', 'lecturers.structural_position_id', '=', 'structural_positions.id')
                ->orderBy('structural_positions.sort_order')
                ->select('lecturers.*')
                ->take(10) // Increase limit to show more officials
                ->get();

            // Global settings
            $globalSettings = [
                'site_name' => \App\Models\Setting::get('site_name', 'KESOSI'),
                'site_description' => \App\Models\Setting::get('site_description', 'Kampus Kesehatan Modern'),
                'contact_email' => \App\Models\Setting::get('contact_email', 'info@kesosi.ac.id'),
                'contact_phone' => \App\Models\Setting::get('contact_phone', '+62 21 1234567'),
                'site_keywords' => \App\Models\Setting::get('site_keywords', 'kampus, universitas, kesehatan, pendidikan'),
            ];

            return view('frontend.home', compact('sections', 'sliders', 'latestNews', 'studyPrograms', 'globalSettings', 'latestAnnouncements', 'featuredGalleries', 'campusOfficials'));

        } catch (\Exception $e) {
            // Fallback jika ada error
            \Log::error('HomeController error: ' . $e->getMessage());
            return response('<h1>Homepage Works!</h1><p>Loading sections...</p><p>Error: ' . $e->getMessage() . '</p>');
        }
    }

    public function campusOfficials()
    {
        $campusOfficials = \App\Models\Lecturer::where('lecturers.is_active', 1)
            ->whereNotNull('structural_position_id')
            ->with('structuralPosition')
            ->where(function($query) {
                $query->whereNull('structural_end_date')
                      ->orWhere('structural_end_date', '>=', now());
            })
            ->whereHas('structuralPosition', function($query) {
                $query->where('structural_positions.is_active', 1);
            })
            ->join('structural_positions', 'lecturers.structural_position_id', '=', 'structural_positions.id')
            ->orderBy('structural_positions.sort_order')
            ->select('lecturers.*')
            ->get();

        // Define hierarchy order - from highest to lowest level
        $hierarchyOrder = [
            'Rektor' => 1,           // Pimpinan Sekolah Tinggi (Rektor & Wakil Rektor)
            'Direktur' => 2,         // Pimpinan Sekolah Tinggi level Direktur
            'Lembaga' => 3,          // Pimpinan Lembaga (LPPM, dll)
            'Program Studi' => 4,    // Pimpinan Program Studi
            'Dekan' => 5,            // Dekan (jika ada)
            'Unit' => 6,             // Unit kerja
            'Bagian' => 7,           // Bagian
            'Lainnya' => 8           // Level bawah lainnya
        ];

        // Group by category for better organization
        $groupedOfficials = $campusOfficials->groupBy(function($official) {
            return $official->structuralPosition->category;
        });
        
        // Sort groups by hierarchy order
        $groupedOfficials = $groupedOfficials->sortBy(function($officials, $category) use ($hierarchyOrder) {
            return $hierarchyOrder[$category] ?? 999; // Default to last if category not found
        });

        // Global settings
        $globalSettings = [
            'site_name' => \App\Models\Setting::get('site_name', 'KESOSI'),
            'site_description' => \App\Models\Setting::get('site_description', 'Kampus Kesehatan Modern'),
            'site_logo' => \App\Models\Setting::get('site_logo', ''),
            'contact_email' => \App\Models\Setting::get('contact_email', 'info@kesosi.ac.id'),
            'contact_phone' => \App\Models\Setting::get('contact_phone', '+62 21 1234567'),
            'site_keywords' => \App\Models\Setting::get('site_keywords', 'kampus, universitas, kesehatan, pendidikan'),
        ];

        return view('frontend.campus-officials', compact('campusOfficials', 'groupedOfficials', 'globalSettings'));
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
