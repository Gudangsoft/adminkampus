#!/bin/bash

echo "=== FORCE FIX SITEMAP CONTROLLER ==="

# 1. Show current git status
echo "1. Checking git status..."
git status
git log --oneline -3

# 2. Force pull latest changes
echo "2. Force pulling latest changes..."
git fetch origin
git reset --hard origin/main

# 3. Check if SitemapController exists
echo "3. Checking SitemapController file..."
if [ -f "app/Http/Controllers/SitemapController.php" ]; then
    echo "✅ SitemapController.php exists"
    echo "File size: $(wc -c < app/Http/Controllers/SitemapController.php) bytes"
    head -5 app/Http/Controllers/SitemapController.php
else
    echo "❌ SitemapController.php MISSING - Creating it now..."
    mkdir -p app/Http/Controllers
    cat > app/Http/Controllers/SitemapController.php << 'EOF'
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
EOF
    echo "✅ SitemapController.php created manually"
fi

# 4. Clear ALL cached files
echo "4. Clearing all cached files..."
rm -f bootstrap/cache/*.php
rm -rf storage/framework/cache/data/*
rm -rf storage/framework/views/*

# 5. Clear Laravel caches
echo "5. Clearing Laravel caches..."
php artisan cache:clear || echo "Cache clear failed"
php artisan config:clear || echo "Config clear failed"
php artisan route:clear || echo "Route clear failed"
php artisan view:clear || echo "View clear failed"

# 6. Regenerate autoload with verbose output
echo "6. Regenerating autoload..."
composer dump-autoload --optimize --no-dev -v

# 7. Test class loading
echo "7. Testing SitemapController class loading..."
php -r "
try {
    require_once 'vendor/autoload.php';
    if (class_exists('App\Http\Controllers\SitemapController')) {
        echo '✅ SitemapController class can be loaded successfully\n';
    } else {
        echo '❌ SitemapController class NOT found in autoload\n';
    }
} catch (Exception \$e) {
    echo '❌ Error loading class: ' . \$e->getMessage() . '\n';
}
"

# 8. Try route list again
echo "8. Testing route list..."
php artisan route:list | head -5

echo "=== FORCE FIX COMPLETE ==="
