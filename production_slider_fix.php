<?php

/**
 * PRODUCTION SLIDER DATABASE FIX SCRIPT
 * 
 * This script fixes the slider database paths that have duplication
 * Run this after deployment to production server
 */

require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "========================================\n";
echo "PRODUCTION SLIDER DATABASE FIX SCRIPT\n";
echo "========================================\n";
echo "Date: " . date('Y-m-d H:i:s') . "\n";
echo "Environment: " . app()->environment() . "\n";
echo "========================================\n\n";

try {
    // Check database connection
    \Illuminate\Support\Facades\DB::connection()->getPdo();
    echo "✓ Database connection: OK\n\n";
} catch (Exception $e) {
    echo "✗ Database connection failed: " . $e->getMessage() . "\n";
    exit(1);
}

// Get all sliders
$sliders = \App\Models\Slider::all();
echo "Found " . $sliders->count() . " sliders in database\n\n";

if ($sliders->count() === 0) {
    echo "No sliders found. Nothing to fix.\n";
    exit(0);
}

$fixed = 0;
$skipped = 0;
$errors = 0;

foreach ($sliders as $slider) {
    echo "Processing Slider ID: {$slider->id}\n";
    echo "  Title: {$slider->title}\n";
    echo "  Current image path: {$slider->image}\n";
    
    // Skip if image is empty or is URL
    if (empty($slider->image)) {
        echo "  → Skipped: No image path\n\n";
        $skipped++;
        continue;
    }
    
    if (filter_var($slider->image, FILTER_VALIDATE_URL)) {
        echo "  → Skipped: External URL\n\n";
        $skipped++;
        continue;
    }
    
    // Check if path has duplication (contains 'sliders/')
    if (strpos($slider->image, 'sliders/') === 0) {
        $newImagePath = str_replace('sliders/', '', $slider->image);
        echo "  → Fixing path: {$slider->image} → {$newImagePath}\n";
        
        // Check if file exists with new path
        $fullPath = storage_path('app/public/sliders/' . $newImagePath);
        if (file_exists($fullPath)) {
            echo "  → File exists: ✓\n";
            
            try {
                $slider->image = $newImagePath;
                $slider->save();
                echo "  → Database updated: ✓\n";
                $fixed++;
            } catch (Exception $e) {
                echo "  → Database update failed: " . $e->getMessage() . "\n";
                $errors++;
            }
        } else {
            echo "  → File not found: {$fullPath}\n";
            echo "  → Skipped: File missing\n";
            $skipped++;
        }
    } else {
        echo "  → Path already correct\n";
        $skipped++;
    }
    
    echo "\n";
}

echo "========================================\n";
echo "FIX SUMMARY:\n";
echo "========================================\n";
echo "Total sliders: " . $sliders->count() . "\n";
echo "Fixed: {$fixed}\n";
echo "Skipped: {$skipped}\n";
echo "Errors: {$errors}\n";
echo "========================================\n\n";

if ($fixed > 0) {
    echo "✓ {$fixed} slider(s) have been fixed!\n";
    echo "✓ Slider images should now display correctly\n\n";
}

if ($errors > 0) {
    echo "⚠ {$errors} error(s) occurred during fixing\n";
    echo "⚠ Please check the output above for details\n\n";
}

// Verification
echo "VERIFICATION:\n";
echo "========================================\n";
$allSliders = \App\Models\Slider::all();
foreach ($allSliders as $slider) {
    if ($slider->image) {
        $imagePath = storage_path('app/public/sliders/' . $slider->image);
        $publicUrl = asset('storage/sliders/' . $slider->image);
        
        echo "Slider #{$slider->id}: {$slider->title}\n";
        echo "  Path: {$slider->image}\n";
        echo "  File exists: " . (file_exists($imagePath) ? "✓" : "✗") . "\n";
        echo "  Public URL: {$publicUrl}\n";
        echo "\n";
    }
}

echo "========================================\n";
echo "NEXT STEPS:\n";
echo "========================================\n";
echo "1. Test slider admin: https://stikeskesosi.ac.id/admin/sliders\n";
echo "2. Check frontend slider display\n";
echo "3. Upload new slider to test functionality\n";
echo "4. Monitor Laravel logs for any errors\n";
echo "========================================\n";

echo "Script completed at: " . date('Y-m-d H:i:s') . "\n";
