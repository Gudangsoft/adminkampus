<?php

namespace App\Http\Controllers;

use App\Models\Section;

class HomeController extends Controller
{
    public function index()
    {
        try {
            // Get active sections dari database
            $sections = Section::where('is_active', true)->orderBy('order')->get();
            
            // Global settings
            $globalSettings = [
                'site_name' => 'KESOSI',
                'site_description' => 'Kampus Kesehatan Modern',
            ];
            
            return view('frontend.home', compact('sections', 'globalSettings'));
            
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
