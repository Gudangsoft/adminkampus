<?php

require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== DEBUGGING GALLERY ISSUES ===\n";

// 1. Check database connection
try {
    $galleries = \App\Models\Gallery::all();
    echo "✓ Database connection OK\n";
    echo "✓ Found " . $galleries->count() . " galleries in database\n";
} catch (Exception $e) {
    echo "✗ Database error: " . $e->getMessage() . "\n";
    exit;
}

// 2. Check if we have any gallery data
if ($galleries->count() > 0) {
    echo "\n--- GALLERY DATA ---\n";
    foreach ($galleries as $gallery) {
        echo "ID: {$gallery->id}\n";
        echo "Title: {$gallery->title}\n";
        echo "Type: {$gallery->type}\n";
        echo "File Path: {$gallery->file_path}\n";
        echo "Thumbnail: {$gallery->thumbnail}\n";
        echo "Image URL (accessor): {$gallery->image_url}\n";
        
        // Check if file exists for image type
        if ($gallery->type === 'image' && $gallery->file_path) {
            // Check with current path
            $imagePath1 = storage_path('app/public/' . $gallery->file_path);
            $imagePath2 = storage_path('app/public/galleries/images/' . basename($gallery->file_path));
            
            echo "  Checking path 1: " . $imagePath1 . "\n";
            echo "  File exists 1: " . (file_exists($imagePath1) ? "✓" : "✗") . "\n";
            
            echo "  Checking path 2: " . $imagePath2 . "\n"; 
            echo "  File exists 2: " . (file_exists($imagePath2) ? "✓" : "✗") . "\n";
            
            // Check public URL
            $publicUrl = asset('storage/' . $gallery->file_path);
            echo "  Public URL: " . $publicUrl . "\n";
        }
        
        // Check thumbnail
        if ($gallery->thumbnail) {
            $thumbnailPath = storage_path('app/public/' . $gallery->thumbnail);
            echo "  Thumbnail path: " . $thumbnailPath . "\n";
            echo "  Thumbnail exists: " . (file_exists($thumbnailPath) ? "✓" : "✗") . "\n";
        }
        
        echo "---\n";
    }
} else {
    echo "No galleries found in database\n";
}

// 3. Check storage directories
echo "\n--- STORAGE DIRECTORIES ---\n";
$directories = [
    'storage/app/public/galleries',
    'storage/app/public/galleries/images', 
    'storage/app/public/galleries/thumbnails'
];

foreach ($directories as $dir) {
    $fullPath = base_path($dir);
    if (is_dir($fullPath)) {
        echo "✓ Directory exists: $dir\n";
        $files = scandir($fullPath);
        $fileCount = count($files) - 2; // Remove . and ..
        echo "  Files: $fileCount\n";
        
        if ($fileCount > 0) {
            foreach ($files as $file) {
                if ($file !== '.' && $file !== '..') {
                    echo "    - $file\n";
                }
            }
        }
    } else {
        echo "✗ Directory missing: $dir\n";
    }
}

// 4. Check gallery routes
echo "\n--- CHECKING GALLERY ROUTES ---\n";
try {
    $routes = \Illuminate\Support\Facades\Route::getRoutes();
    $galleryRoutes = [];
    
    foreach ($routes as $route) {
        $uri = $route->uri();
        if (strpos($uri, 'galleri') !== false || strpos($uri, 'gallery') !== false) {
            $galleryRoutes[] = $uri . ' -> ' . $route->getActionName();
        }
    }
    
    if (!empty($galleryRoutes)) {
        echo "✓ Found gallery routes:\n";
        foreach ($galleryRoutes as $route) {
            echo "  " . $route . "\n";
        }
    } else {
        echo "✗ No gallery routes found\n";
    }
} catch (Exception $e) {
    echo "✗ Route check error: " . $e->getMessage() . "\n";
}

echo "\n=== DEBUG COMPLETE ===\n";
