<?php

require_once __DIR__ . '/vendor/autoload.php';

use Illuminate\Foundation\Application;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Support\Facades\Log;

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== DEBUGGING SLIDER ISSUES ===\n";

// 1. Check database connection
try {
    $sliders = \App\Models\Slider::all();
    echo "✓ Database connection OK\n";
    echo "✓ Found " . $sliders->count() . " sliders in database\n";
} catch (Exception $e) {
    echo "✗ Database error: " . $e->getMessage() . "\n";
    exit;
}

// 2. Check if we have any slider data
if ($sliders->count() > 0) {
    echo "\n--- SLIDER DATA ---\n";
    foreach ($sliders as $slider) {
        echo "ID: {$slider->id}\n";
        echo "Title: {$slider->title}\n";
        echo "Image: {$slider->image}\n";
        echo "Is Active: {$slider->is_active}\n";
        
        // Check if image file exists
        if ($slider->image) {
            $imagePath = storage_path('app/public/sliders/' . $slider->image);
            if (file_exists($imagePath)) {
                echo "✓ Image file exists: " . $imagePath . "\n";
                echo "  File size: " . filesize($imagePath) . " bytes\n";
            } else {
                echo "✗ Image file missing: " . $imagePath . "\n";
            }
            
            // Check public URL
            $publicUrl = asset('storage/sliders/' . $slider->image);
            echo "  Public URL: " . $publicUrl . "\n";
        }
        echo "---\n";
    }
} else {
    echo "No sliders found in database\n";
}

// 3. Check storage symlink
echo "\n--- STORAGE SYMLINK CHECK ---\n";
$publicStoragePath = public_path('storage');
if (is_link($publicStoragePath)) {
    echo "✓ Storage symlink exists\n";
    echo "  Target: " . readlink($publicStoragePath) . "\n";
} else {
    echo "✗ Storage symlink missing\n";
}

// 4. Check slider controller routes
echo "\n--- CHECKING ROUTES ---\n";
try {
    $routes = \Illuminate\Support\Facades\Route::getRoutes();
    $sliderRoutes = [];
    
    foreach ($routes as $route) {
        $uri = $route->uri();
        if (strpos($uri, 'slider') !== false) {
            $sliderRoutes[] = $uri . ' -> ' . $route->getActionName();
        }
    }
    
    if (!empty($sliderRoutes)) {
        echo "✓ Found slider routes:\n";
        foreach ($sliderRoutes as $route) {
            echo "  " . $route . "\n";
        }
    } else {
        echo "✗ No slider routes found\n";
    }
} catch (Exception $e) {
    echo "✗ Route check error: " . $e->getMessage() . "\n";
}

// 5. Check recent logs for slider-related errors
echo "\n--- RECENT ERRORS ---\n";
$logFile = storage_path('logs/laravel.log');
if (file_exists($logFile)) {
    $logContent = file_get_contents($logFile);
    $lines = explode("\n", $logContent);
    $recentLines = array_slice($lines, -50); // Last 50 lines
    
    $sliderErrors = [];
    foreach ($recentLines as $line) {
        if (strpos(strtolower($line), 'slider') !== false || 
            strpos(strtolower($line), 'error') !== false) {
            $sliderErrors[] = $line;
        }
    }
    
    if (!empty($sliderErrors)) {
        echo "Found recent errors:\n";
        foreach ($sliderErrors as $error) {
            echo "  " . $error . "\n";
        }
    } else {
        echo "No recent slider-related errors found\n";
    }
} else {
    echo "Log file not found\n";
}

// 6. Test creating a simple slider entry
echo "\n--- TESTING SLIDER CREATION ---\n";
try {
    $testSlider = new \App\Models\Slider();
    $testSlider->title = 'Test Slider';
    $testSlider->description = 'Debug test';
    $testSlider->is_active = 1;
    $testSlider->sort_order = 999;
    
    // Don't save, just validate
    echo "✓ Slider model can be instantiated\n";
    echo "✓ Fillable fields: " . implode(', ', $testSlider->getFillable()) . "\n";
    
} catch (Exception $e) {
    echo "✗ Slider model error: " . $e->getMessage() . "\n";
}

echo "\n=== DEBUG COMPLETE ===\n";
