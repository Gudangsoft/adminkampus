<?php

require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== FIXING SLIDER IMAGE PATHS ===\n";

// Get all sliders with double sliders/ path
$sliders = \App\Models\Slider::where('image', 'LIKE', 'sliders/%')->get();

echo "Found " . $sliders->count() . " sliders with wrong paths\n\n";

foreach ($sliders as $slider) {
    echo "ID: {$slider->id}\n";
    echo "Title: {$slider->title}\n";
    echo "Current image path: {$slider->image}\n";
    
    // Remove the duplicate "sliders/" prefix
    $newImagePath = str_replace('sliders/', '', $slider->image);
    
    echo "New image path: {$newImagePath}\n";
    
    // Check if file exists with new path
    $fullPath = storage_path('app/public/sliders/' . $newImagePath);
    if (file_exists($fullPath)) {
        echo "✓ File exists, updating database...\n";
        
        $slider->image = $newImagePath;
        $slider->save();
        
        echo "✓ Updated successfully!\n";
    } else {
        echo "✗ File not found: " . $fullPath . "\n";
    }
    
    echo "---\n";
}

echo "\n=== FIX COMPLETE ===\n";

// Verify the fix
echo "\n=== VERIFICATION ===\n";
$allSliders = \App\Models\Slider::all();
foreach ($allSliders as $slider) {
    if ($slider->image) {
        $imagePath = storage_path('app/public/sliders/' . $slider->image);
        $publicUrl = asset('storage/sliders/' . $slider->image);
        
        echo "ID {$slider->id}: {$slider->title}\n";
        echo "  Image: {$slider->image}\n";
        echo "  File exists: " . (file_exists($imagePath) ? "✓" : "✗") . "\n";
        echo "  Public URL: {$publicUrl}\n";
        echo "---\n";
    }
}
