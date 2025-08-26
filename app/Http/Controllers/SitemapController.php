<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index()
    {
        $sitemap = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        
        // Home page
        $sitemap .= '  <url>' . "\n";
        $sitemap .= '    <loc>' . url('/') . '</loc>' . "\n";
        $sitemap .= '    <lastmod>' . date('Y-m-d') . '</lastmod>' . "\n";
        $sitemap .= '    <changefreq>daily</changefreq>' . "\n";
        $sitemap .= '    <priority>1.0</priority>' . "\n";
        $sitemap .= '  </url>' . "\n";
        
        // About page
        $sitemap .= '  <url>' . "\n";
        $sitemap .= '    <loc>' . url('/about') . '</loc>' . "\n";
        $sitemap .= '    <lastmod>' . date('Y-m-d') . '</lastmod>' . "\n";
        $sitemap .= '    <changefreq>monthly</changefreq>' . "\n";
        $sitemap .= '    <priority>0.8</priority>' . "\n";
        $sitemap .= '  </url>' . "\n";
        
        // Contact page
        $sitemap .= '  <url>' . "\n";
        $sitemap .= '    <loc>' . url('/contact') . '</loc>' . "\n";
        $sitemap .= '    <lastmod>' . date('Y-m-d') . '</lastmod>' . "\n";
        $sitemap .= '    <changefreq>monthly</changefreq>' . "\n";
        $sitemap .= '    <priority>0.7</priority>' . "\n";
        $sitemap .= '  </url>' . "\n";
        
        $sitemap .= '</urlset>';
        
        return response($sitemap, 200)
            ->header('Content-Type', 'application/xml');
    }
    
    public function robots()
    {
        $robots = "User-agent: *\n";
        $robots .= "Allow: /\n";
        $robots .= "Sitemap: " . url('/sitemap.xml') . "\n";
        
        return response($robots, 200)
            ->header('Content-Type', 'text/plain');
    }
}
