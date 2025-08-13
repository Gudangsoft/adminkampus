<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SEOMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        
        // Add security headers
        $response->headers->set('X-Frame-Options', 'DENY');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        
        // Add performance headers
        $response->headers->set('Cache-Control', 'public, max-age=3600');
        $response->headers->set('Vary', 'Accept-Encoding');
        
        // Add SEO headers
        if ($response->headers->get('Content-Type') === 'text/html; charset=UTF-8' || 
            str_contains($response->headers->get('Content-Type', ''), 'text/html')) {
            
            $content = $response->getContent();
            
            // Add canonical URL if not present
            if (!str_contains($content, '<link rel="canonical"')) {
                $canonicalUrl = $request->url();
                $content = str_replace(
                    '</head>',
                    '    <link rel="canonical" href="' . $canonicalUrl . '">' . "\n</head>",
                    $content
                );
            }
            
            // Add Open Graph and Twitter Card meta tags if not present
            if (!str_contains($content, 'property="og:')) {
                $ogTags = $this->generateOpenGraphTags($request);
                $content = str_replace(
                    '</head>',
                    $ogTags . "\n</head>",
                    $content
                );
            }
            
            // Add structured data
            if (!str_contains($content, '"@type": "WebSite"')) {
                $structuredData = $this->generateStructuredData($request);
                $content = str_replace(
                    '</head>',
                    $structuredData . "\n</head>",
                    $content
                );
            }
            
            $response->setContent($content);
        }
        
        return $response;
    }
    
    private function generateOpenGraphTags(Request $request): string
    {
        $siteName = config('app.name', 'G0-CAMPUS');
        $currentUrl = $request->url();
        $title = $this->extractTitle($request) ?? $siteName;
        $description = $this->extractDescription($request) ?? 'Sistem Informasi Kampus Terdepan';
        $image = asset('images/og-image.jpg'); // Default OG image
        
        return "    <!-- Open Graph Meta Tags -->
    <meta property=\"og:type\" content=\"website\">
    <meta property=\"og:site_name\" content=\"{$siteName}\">
    <meta property=\"og:title\" content=\"{$title}\">
    <meta property=\"og:description\" content=\"{$description}\">
    <meta property=\"og:url\" content=\"{$currentUrl}\">
    <meta property=\"og:image\" content=\"{$image}\">
    <meta property=\"og:image:alt\" content=\"{$title}\">
    
    <!-- Twitter Card Meta Tags -->
    <meta name=\"twitter:card\" content=\"summary_large_image\">
    <meta name=\"twitter:title\" content=\"{$title}\">
    <meta name=\"twitter:description\" content=\"{$description}\">
    <meta name=\"twitter:image\" content=\"{$image}\">";
    }
    
    private function generateStructuredData(Request $request): string
    {
        $siteName = config('app.name', 'G0-CAMPUS');
        $siteUrl = config('app.url', $request->getSchemeAndHttpHost());
        
        $structuredData = [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => $siteName,
            'url' => $siteUrl,
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => [
                    '@type' => 'EntryPoint',
                    'urlTemplate' => $siteUrl . '/search?q={search_term_string}'
                ],
                'query-input' => 'required name=search_term_string'
            ]
        ];
        
        return "    <!-- Structured Data -->
    <script type=\"application/ld+json\">" . json_encode($structuredData, JSON_UNESCAPED_SLASHES) . "</script>";
    }
    
    private function extractTitle(Request $request): ?string
    {
        // Try to extract from route parameters or page data
        $routeName = $request->route()?->getName();
        
        return match($routeName) {
            'home' => config('app.name', 'G0-CAMPUS') . ' - Beranda',
            'search' => 'Pencarian - ' . config('app.name', 'G0-CAMPUS'),
            'news.index' => 'Berita - ' . config('app.name', 'G0-CAMPUS'),
            'gallery.index' => 'Galeri - ' . config('app.name', 'G0-CAMPUS'),
            'announcements.index' => 'Pengumuman - ' . config('app.name', 'G0-CAMPUS'),
            default => null
        };
    }
    
    private function extractDescription(Request $request): ?string
    {
        $routeName = $request->route()?->getName();
        
        return match($routeName) {
            'home' => 'Portal informasi resmi kampus dengan berita terbaru, galeri kegiatan, dan pengumuman penting',
            'search' => 'Cari berita, galeri, pengumuman, dan informasi lainnya di ' . config('app.name', 'G0-CAMPUS'),
            'news.index' => 'Berita terbaru dan informasi kampus ' . config('app.name', 'G0-CAMPUS'),
            'gallery.index' => 'Galeri foto dan video kegiatan kampus ' . config('app.name', 'G0-CAMPUS'),
            'announcements.index' => 'Pengumuman resmi dan informasi penting kampus ' . config('app.name', 'G0-CAMPUS'),
            default => null
        };
    }
}
