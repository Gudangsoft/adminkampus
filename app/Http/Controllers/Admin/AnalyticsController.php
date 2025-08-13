<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Announcement;
use App\Models\Gallery;
use App\Models\Faculty;
use App\Models\StudyProgram;
use App\Models\Student;
use App\Models\Lecturer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    /**
     * Display analytics dashboard
     */
    public function index()
    {
        try {
            // Get basic statistics
            $stats = $this->getBasicStats();
            
            // Get content statistics
            $contentStats = $this->getContentStats();
            
            // Get monthly statistics for charts
            $monthlyStats = $this->getMonthlyStats();
            
            // Get recent activities
            $recentActivities = $this->getRecentActivities();
            
            // Get popular content
            $popularContent = $this->getPopularContent();

            return view('admin.analytics.index', compact(
                'stats', 
                'contentStats', 
                'monthlyStats', 
                'recentActivities',
                'popularContent'
            ));
        } catch (\Exception $e) {
            // Log error for debugging
            \Log::error('Analytics error: ' . $e->getMessage());
            
            // Return view with empty data
            return view('admin.analytics.index', [
                'stats' => [],
                'contentStats' => [],
                'monthlyStats' => [],
                'recentActivities' => collect(),
                'popularContent' => []
            ]);
        }
    }

    /**
     * Get basic website statistics
     */
    private function getBasicStats()
    {
        try {
            $stats = [];
            
            // Safe model counts with table existence checks
            $stats['total_news'] = \Schema::hasTable('news') ? News::count() : 0;
            $stats['published_news'] = \Schema::hasTable('news') ? News::where('status', 'published')->count() : 0;
            $stats['total_announcements'] = \Schema::hasTable('announcements') ? Announcement::count() : 0;
            $stats['active_announcements'] = \Schema::hasTable('announcements') ? Announcement::where('status', 'active')->count() : 0;
            $stats['total_galleries'] = \Schema::hasTable('galleries') ? Gallery::count() : 0;
            $stats['featured_galleries'] = \Schema::hasTable('galleries') ? Gallery::where('is_featured', true)->count() : 0;
            $stats['total_faculties'] = \Schema::hasTable('faculties') ? Faculty::count() : 0;
            $stats['active_faculties'] = \Schema::hasTable('faculties') ? Faculty::where('is_active', true)->count() : 0;
            $stats['total_programs'] = \Schema::hasTable('study_programs') ? StudyProgram::count() : 0;
            $stats['active_programs'] = \Schema::hasTable('study_programs') ? StudyProgram::where('is_active', true)->count() : 0;
            $stats['total_students'] = \Schema::hasTable('students') ? Student::count() : 0;
            $stats['active_students'] = \Schema::hasTable('students') ? Student::where('is_active', true)->count() : 0;
            $stats['total_lecturers'] = \Schema::hasTable('lecturers') ? Lecturer::count() : 0;
            $stats['active_lecturers'] = \Schema::hasTable('lecturers') ? Lecturer::where('is_active', true)->count() : 0;
            $stats['total_users'] = \Schema::hasTable('users') ? User::count() : 0;
            
            return $stats;
        } catch (\Exception $e) {
            return [
                'total_news' => 0,
                'published_news' => 0,
                'total_announcements' => 0,
                'active_announcements' => 0,
                'total_galleries' => 0,
                'featured_galleries' => 0,
                'total_faculties' => 0,
                'active_faculties' => 0,
                'total_programs' => 0,
                'active_programs' => 0,
                'total_students' => 0,
                'active_students' => 0,
                'total_lecturers' => 0,
                'active_lecturers' => 0,
                'total_users' => 0,
            ];
        }
    }

    /**
     * Get content statistics by category
     */
    private function getContentStats()
    {
        try {
            $data = [];
            
            // Try to get news by category if tables exist
            if (\Schema::hasTable('news') && \Schema::hasColumn('news', 'category_id')) {
                $data['news_by_category'] = News::select('category_id', DB::raw('count(*) as total'))
                    ->with('category')
                    ->groupBy('category_id')
                    ->get();
            } else {
                $data['news_by_category'] = collect();
            }
            
            // Try to get galleries by category if tables exist
            if (\Schema::hasTable('galleries') && \Schema::hasColumn('galleries', 'category_id')) {
                $data['galleries_by_category'] = Gallery::select('category_id', DB::raw('count(*) as total'))
                    ->with('category')
                    ->groupBy('category_id')
                    ->get();
            } else {
                $data['galleries_by_category'] = collect();
            }
            
            // Try to get students by faculty if tables exist
            if (\Schema::hasTable('students') && \Schema::hasColumn('students', 'faculty_id')) {
                $data['students_by_faculty'] = Student::select('faculty_id', DB::raw('count(*) as total'))
                    ->with('faculty')
                    ->groupBy('faculty_id')
                    ->get();
            } else {
                $data['students_by_faculty'] = collect();
            }
            
            return $data;
        } catch (\Exception $e) {
            return [
                'news_by_category' => collect(),
                'galleries_by_category' => collect(),
                'students_by_faculty' => collect(),
            ];
        }
    }

    /**
     * Get monthly statistics for the last 12 months
     */
    private function getMonthlyStats()
    {
        try {
            $months = collect();
            for ($i = 11; $i >= 0; $i--) {
                $month = Carbon::now()->subMonths($i);
                $monthData = [
                    'month' => $month->format('M Y'),
                    'month_key' => $month->format('Y-m'),
                    'news' => 0,
                    'announcements' => 0,
                    'galleries' => 0,
                    'students' => 0,
                ];
                
                // Safe counting with table checks
                if (Schema::hasTable('news')) {
                    $monthData['news'] = News::whereYear('created_at', $month->year)
                        ->whereMonth('created_at', $month->month)
                        ->count();
                }
                
                if (Schema::hasTable('announcements')) {
                    $monthData['announcements'] = Announcement::whereYear('created_at', $month->year)
                        ->whereMonth('created_at', $month->month)
                        ->count();
                }
                
                if (Schema::hasTable('galleries')) {
                    $monthData['galleries'] = Gallery::whereYear('created_at', $month->year)
                        ->whereMonth('created_at', $month->month)
                        ->count();
                }
                
                if (Schema::hasTable('students')) {
                    $monthData['students'] = Student::whereYear('created_at', $month->year)
                        ->whereMonth('created_at', $month->month)
                        ->count();
                }
                
                $months->push($monthData);
            }
            
            return $months;
        } catch (\Exception $e) {
            return collect();
        }
    }

    /**
     * Get recent activities
     */
    private function getRecentActivities()
    {
        try {
            $activities = collect();
            
            // Recent news (if table exists)
            if (Schema::hasTable('news')) {
                News::latest()->take(5)->get()->each(function ($item) use ($activities) {
                    $activities->push([
                        'type' => 'news',
                        'title' => $item->title,
                        'url' => '#',
                        'created_at' => $item->created_at,
                        'icon' => 'fas fa-newspaper',
                        'color' => 'primary'
                    ]);
                });
            }
            
            // Recent announcements (if table exists)
            if (Schema::hasTable('announcements')) {
                Announcement::latest()->take(5)->get()->each(function ($item) use ($activities) {
                    $activities->push([
                        'type' => 'announcement',
                        'title' => $item->title,
                        'url' => '#',
                        'created_at' => $item->created_at,
                        'icon' => 'fas fa-bullhorn',
                        'color' => 'warning'
                    ]);
                });
            }
            
            // Recent galleries (if table exists)
            if (Schema::hasTable('galleries')) {
                Gallery::latest()->take(5)->get()->each(function ($item) use ($activities) {
                    $activities->push([
                        'type' => 'gallery',
                        'title' => $item->title,
                        'url' => '#',
                        'created_at' => $item->created_at,
                        'icon' => 'fas fa-images',
                        'color' => 'success'
                    ]);
                });
            }
            
            return $activities->sortByDesc('created_at')->take(10);
        } catch (\Exception $e) {
            return collect();
        }
    }

    /**
     * Get popular content based on views/interactions
     */
    private function getPopularContent()
    {
        try {
            $data = [];
            
            if (Schema::hasTable('news')) {
                $data['popular_news'] = News::orderBy('views', 'desc')->take(5)->get();
                $data['recent_news'] = News::where('status', 'published')
                    ->orderBy('created_at', 'desc')
                    ->take(5)
                    ->get();
            } else {
                $data['popular_news'] = collect();
                $data['recent_news'] = collect();
            }
            
            if (Schema::hasTable('galleries')) {
                $data['featured_galleries'] = Gallery::where('is_featured', true)
                    ->orderBy('created_at', 'desc')
                    ->take(5)
                    ->get();
            } else {
                $data['featured_galleries'] = collect();
            }
            
            return $data;
        } catch (\Exception $e) {
            return [
                'popular_news' => collect(),
                'recent_news' => collect(),
                'featured_galleries' => collect(),
            ];
        }
    }

    /**
     * Get detailed analytics for specific content type
     */
    public function getContentAnalytics(Request $request)
    {
        $type = $request->get('type', 'news');
        $period = $request->get('period', '30'); // days
        
        $startDate = Carbon::now()->subDays($period);
        
        switch ($type) {
            case 'news':
                $data = News::where('created_at', '>=', $startDate)
                    ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
                    ->groupBy('date')
                    ->orderBy('date')
                    ->get();
                break;
                
            case 'announcements':
                $data = Announcement::where('created_at', '>=', $startDate)
                    ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
                    ->groupBy('date')
                    ->orderBy('date')
                    ->get();
                break;
                
            case 'galleries':
                $data = Gallery::where('created_at', '>=', $startDate)
                    ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
                    ->groupBy('date')
                    ->orderBy('date')
                    ->get();
                break;
                
            default:
                $data = collect();
        }
        
        return response()->json($data);
    }

    /**
     * Export analytics data
     */
    public function export(Request $request)
    {
        $type = $request->get('type', 'summary');
        
        // This will be implemented with PDF generation later
        return response()->json(['message' => 'Export functionality will be implemented with PDF generator']);
    }
}
