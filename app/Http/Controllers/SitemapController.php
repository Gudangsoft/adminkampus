<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Gallery;
use App\Models\Page;
use App\Models\Announcement;
use Illuminate\Http\Response;
use Carbon\Carbon;

class SitemapController extends Controller
{
    public function index()
    {
        $sitemap = '<?xml version="1.0" encoding="UTF-8"?>';
        $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        
        // Homepage
        $sitemap .= $this->addUrl(route('home'), Carbon::now(), 'daily', 1.0);
        
        // Static pages
        $sitemap .= $this->addUrl(route('news.index'), Carbon::now(), 'daily', 0.9);
        $sitemap .= $this->addUrl(route('gallery.index'), Carbon::now(), 'weekly', 0.8);
        $sitemap .= $this->addUrl(route('announcements.index'), Carbon::now(), 'daily', 0.8);
        $sitemap .= $this->addUrl(route('search'), Carbon::now(), 'monthly', 0.5);
        
        // News articles
        $news = News::published()
            ->orderBy('published_at', 'desc')
            ->limit(1000)
            ->get();
            
        foreach ($news as $article) {
            $sitemap .= $this->addUrl(
                route('news.show', $article->slug),
                $article->updated_at,
                'weekly',
                0.8
            );
        }
        
        // Gallery items
        $galleries = Gallery::orderBy('created_at', 'desc')
            ->limit(500)
            ->get();
            
        foreach ($galleries as $gallery) {
            $sitemap .= $this->addUrl(
                route('gallery.show', $gallery->slug),
                $gallery->updated_at,
                'monthly',
                0.6
            );
        }
        
        // Announcements
        $announcements = Announcement::orderBy('created_at', 'desc')
            ->limit(500)
            ->get();
            
        foreach ($announcements as $announcement) {
            $sitemap .= $this->addUrl(
                route('announcements.show', $announcement->slug),
                $announcement->updated_at,
                'weekly',
                0.7
            );
        }
        
        // Pages
        $pages = Page::active()
            ->orderBy('updated_at', 'desc')
            ->get();
            
        foreach ($pages as $page) {
            $sitemap .= $this->addUrl(
                route('page.show', $page->slug),
                $page->updated_at,
                'monthly',
                0.6
            );
        }
        
        $sitemap .= '</urlset>';
        
        return response($sitemap, 200, [
            'Content-Type' => 'application/xml',
            'Cache-Control' => 'public, max-age=3600'
        ]);
    }
    
    private function addUrl($url, $lastmod, $changefreq, $priority)
    {
        return '<url>' .
               '<loc>' . htmlspecialchars($url) . '</loc>' .
               '<lastmod>' . $lastmod->toW3cString() . '</lastmod>' .
               '<changefreq>' . $changefreq . '</changefreq>' .
               '<priority>' . $priority . '</priority>' .
               '</url>';
    }
    
    public function robots()
    {
        $robots = "User-agent: *\n";
        $robots .= "Allow: /\n";
        $robots .= "Disallow: /admin/\n";
        $robots .= "Disallow: /login\n";
        $robots .= "Disallow: /register\n";
        $robots .= "Disallow: /password/\n";
        $robots .= "\n";
        $robots .= "Sitemap: " . route('sitemap') . "\n";
        
        return response($robots, 200, [
            'Content-Type' => 'text/plain',
            'Cache-Control' => 'public, max-age=86400'
        ]);
    }
}
