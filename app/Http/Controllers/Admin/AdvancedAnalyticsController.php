<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Gallery;
use App\Models\Announcement;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdvancedAnalyticsController extends Controller
{
    public function dashboard()
    {
        // Content Statistics
        $contentStats = [
            'news' => [
                'total' => News::count(),
                'published' => News::where('status', 'published')->count(),
                'draft' => News::where('status', 'draft')->count(),
                'this_month' => News::whereMonth('created_at', now()->month)->count()
            ],
            'announcements' => [
                'total' => Announcement::count(),
                'active' => Announcement::where('is_active', true)->count(),
                'featured' => Announcement::where('is_featured', true)->count(),
                'expired' => Announcement::where('end_date', '<', now())->count()
            ],
            'galleries' => [
                'total' => Gallery::count(),
                'with_photos' => Gallery::has('photos')->count(),
                'recent' => Gallery::whereDate('created_at', '>=', now()->subDays(7))->count()
            ]
        ];

        // User Activity
        $userActivity = [
            'total_users' => User::count(),
            'active_users' => User::where('is_active', true)->count(),
            'admin_users' => User::where('role', 'admin')->count(),
            'recent_logins' => User::whereDate('updated_at', '>=', now()->subDays(7))->count()
        ];

        // Content Performance (last 30 days)
        $contentPerformance = $this->getContentPerformance();
        
        // Popular Content
        $popularContent = $this->getPopularContent();

        return view('admin.analytics.advanced-dashboard', compact(
            'contentStats',
            'userActivity', 
            'contentPerformance',
            'popularContent'
        ));
    }

    private function getContentPerformance()
    {
        return [
            'daily_news' => News::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as count')
            )
            ->whereDate('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get(),
            
            'daily_announcements' => Announcement::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as count')
            )
            ->whereDate('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
        ];
    }

    private function getPopularContent()
    {
        return [
            'top_news' => News::select('title', 'slug', 'views', 'created_at')
                ->orderBy('views', 'desc')
                ->limit(10)
                ->get(),
                
            'recent_galleries' => Gallery::select('title', 'slug', 'created_at')
                ->with('photos:id,gallery_id')
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get()
        ];
    }

    public function exportReport(Request $request)
    {
        $type = $request->get('type', 'summary');
        $format = $request->get('format', 'pdf');
        
        // Generate report data
        $reportData = $this->generateReportData($type);
        
        if ($format === 'excel') {
            return $this->exportToExcel($reportData, $type);
        }
        
        return $this->exportToPdf($reportData, $type);
    }

    private function generateReportData($type)
    {
        switch ($type) {
            case 'content':
                return [
                    'news' => News::with('category')->get(),
                    'announcements' => Announcement::get(),
                    'galleries' => Gallery::with('photos')->get()
                ];
                
            case 'users':
                return [
                    'users' => User::get(),
                    'activity' => User::whereDate('updated_at', '>=', now()->subDays(30))->get()
                ];
                
            default:
                return [
                    'summary' => [
                        'news_count' => News::count(),
                        'announcement_count' => Announcement::count(),
                        'gallery_count' => Gallery::count(),
                        'user_count' => User::count()
                    ]
                ];
        }
    }

    private function exportToPdf($data, $type)
    {
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('admin.reports.pdf.' . $type, compact('data'));
        
        return $pdf->download($type . '_report_' . now()->format('Y-m-d') . '.pdf');
    }

    private function exportToExcel($data, $type)
    {
        // Implementation for Excel export
        // You can use Laravel Excel package here
        return response()->json(['message' => 'Excel export feature coming soon']);
    }
}
