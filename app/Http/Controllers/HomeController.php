<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Slider;
use App\Models\Announcement;
use App\Models\Gallery;
use App\Models\StudyProgram;
use App\Models\Faculty;

class HomeController extends Controller
{
    public function index()
    {
        $sliders = Slider::active()->ordered()->get();
        $featuredNews = News::published()->featured()->latest('published_at')->take(3)->get();
        $latestNews = News::published()->latest('published_at')->take(6)->get();
        $urgentAnnouncements = Announcement::published()->byPriority('urgent')->latest('published_at')->take(3)->get();
        $featuredGallery = Gallery::featured()->latest()->take(8)->get();
        $faculties = Faculty::active()->orderBy('sort_order')->get();
        
        // Statistics
        $stats = [
            'total_students' => \App\Models\Student::active()->count(),
            'total_lecturers' => \App\Models\Lecturer::active()->count(),
            'total_study_programs' => StudyProgram::active()->count(),
            'total_faculties' => Faculty::active()->count(),
        ];

        return view('frontend.home', compact(
            'sliders',
            'featuredNews',
            'latestNews',
            'urgentAnnouncements',
            'featuredGallery',
            'faculties',
            'stats'
        ));
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
