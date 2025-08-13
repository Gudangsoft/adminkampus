<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Gallery;
use App\Models\Page;
use App\Models\Announcement;
use App\Services\SEOService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class SEOController extends Controller
{
    protected $seoService;

    public function __construct(SEOService $seoService)
    {
        $this->seoService = $seoService;
    }

    public function dashboard()
    {
        // SEO Overview Stats
        $stats = [
            'total_content' => News::count() + Gallery::count() + Page::count() + Announcement::count(),
            'news_count' => News::count(),
            'gallery_count' => Gallery::count(),
            'pages_count' => Page::count(),
            'announcements_count' => Announcement::count(),
        ];

        // Recent SEO Activities
        $recentNews = News::latest()->take(5)->get(['id', 'title', 'slug', 'created_at']);
        $recentGalleries = Gallery::latest()->take(5)->get(['id', 'title', 'slug', 'created_at']);

        // SEO Health Check
        $seoIssues = $this->getSEOIssues();

        return view('admin.seo.dashboard', compact('stats', 'recentNews', 'recentGalleries', 'seoIssues'));
    }

    public function audit(Request $request)
    {
        $auditResults = [];
        
        if ($request->has('run_audit')) {
            // Run SEO audit
            $auditResults = $this->runSEOAudit();
        }

        return view('admin.seo.audit', compact('auditResults'));
    }

    public function runAuditCommand(Request $request)
    {
        $fix = $request->has('fix');
        
        if ($fix) {
            Artisan::call('seo:audit', ['--fix' => true]);
        } else {
            Artisan::call('seo:audit');
        }

        $output = Artisan::output();
        
        return response()->json([
            'success' => true,
            'output' => $output,
            'message' => $fix ? 'SEO audit completed with auto-fix' : 'SEO audit completed'
        ]);
    }

    public function metaTags()
    {
        // Get content with SEO issues
        $newsWithIssues = News::whereRaw('CHAR_LENGTH(title) < 30 OR CHAR_LENGTH(title) > 60')->get();
        $galleryWithIssues = Gallery::whereRaw('CHAR_LENGTH(title) < 30 OR CHAR_LENGTH(title) > 60')->get();
        $pagesWithIssues = Page::whereRaw('CHAR_LENGTH(title) < 30 OR CHAR_LENGTH(title) > 60')->get();

        return view('admin.seo.meta-tags', compact('newsWithIssues', 'galleryWithIssues', 'pagesWithIssues'));
    }

    public function sitemap()
    {
        // Get sitemap info
        $urls = [];
        
        // Homepage
        $urls[] = ['url' => url('/'), 'type' => 'Homepage', 'priority' => '1.0'];
        
        // News
        $news = News::published()->get(['slug', 'updated_at']);
        foreach ($news as $item) {
            $urls[] = [
                'url' => route('news.show', $item->slug),
                'type' => 'News',
                'last_modified' => $item->updated_at,
                'priority' => '0.8'
            ];
        }
        
        // Gallery
        $galleries = Gallery::get(['slug', 'updated_at']);
        foreach ($galleries as $item) {
            $urls[] = [
                'url' => route('gallery.show', $item->slug),
                'type' => 'Gallery',
                'last_modified' => $item->updated_at,
                'priority' => '0.7'
            ];
        }
        
        // Pages
        $pages = Page::published()->get(['slug', 'updated_at']);
        foreach ($pages as $item) {
            $urls[] = [
                'url' => route('page.show', $item->slug),
                'type' => 'Page',
                'last_modified' => $item->updated_at,
                'priority' => '0.6'
            ];
        }

        return view('admin.seo.sitemap', compact('urls'));
    }

    public function refreshSitemap()
    {
        // Clear route cache to refresh sitemap
        Artisan::call('route:clear');
        
        return response()->json([
            'success' => true,
            'message' => 'Sitemap refreshed successfully',
            'sitemap_url' => url('/sitemap.xml')
        ]);
    }

    private function getSEOIssues()
    {
        $issues = [];

        // Check title lengths
        $shortTitles = News::whereRaw('CHAR_LENGTH(title) < 30')->count();
        $longTitles = News::whereRaw('CHAR_LENGTH(title) > 60')->count();
        
        if ($shortTitles > 0) {
            $issues[] = [
                'type' => 'warning',
                'message' => "{$shortTitles} konten memiliki judul terlalu pendek (< 30 karakter)"
            ];
        }
        
        if ($longTitles > 0) {
            $issues[] = [
                'type' => 'warning', 
                'message' => "{$longTitles} konten memiliki judul terlalu panjang (> 60 karakter)"
            ];
        }

        // Check missing images
        $missingImages = News::whereNull('featured_image')->count();
        if ($missingImages > 0) {
            $issues[] = [
                'type' => 'error',
                'message' => "{$missingImages} berita tidak memiliki gambar unggulan"
            ];
        }

        // Check meta descriptions
        $missingMeta = News::whereNull('excerpt')->orWhere('excerpt', '')->count();
        if ($missingMeta > 0) {
            $issues[] = [
                'type' => 'warning',
                'message' => "{$missingMeta} berita tidak memiliki meta description (excerpt)"
            ];
        }

        return $issues;
    }

    private function runSEOAudit()
    {
        $results = [
            'title_issues' => [],
            'meta_issues' => [],
            'image_issues' => [],
            'total_issues' => 0
        ];

        // Check News
        $news = News::all();
        foreach ($news as $item) {
            if (strlen($item->title) < 30 || strlen($item->title) > 60) {
                $results['title_issues'][] = [
                    'type' => 'News',
                    'id' => $item->id,
                    'title' => $item->title,
                    'length' => strlen($item->title),
                    'url' => route('admin.news.edit', $item->id)
                ];
            }
            
            if (!$item->excerpt || strlen($item->excerpt) < 120 || strlen($item->excerpt) > 160) {
                $results['meta_issues'][] = [
                    'type' => 'News',
                    'id' => $item->id,
                    'title' => $item->title,
                    'meta_length' => strlen($item->excerpt ?? ''),
                    'url' => route('admin.news.edit', $item->id)
                ];
            }
            
            if (!$item->featured_image) {
                $results['image_issues'][] = [
                    'type' => 'News',
                    'id' => $item->id,
                    'title' => $item->title,
                    'url' => route('admin.news.edit', $item->id)
                ];
            }
        }

        $results['total_issues'] = count($results['title_issues']) + 
                                   count($results['meta_issues']) + 
                                   count($results['image_issues']);

        return $results;
    }
}
