<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== SLIDER DATA CHECK ===\n";

// Check slider count
$sliderCount = App\Models\Slider::count();
echo "Total sliders: $sliderCount\n\n";

// Check each slider
$sliders = App\Models\Slider::all();
foreach ($sliders as $slider) {
    echo "ID: {$slider->id}\n";
    echo "Title: {$slider->title}\n";
    echo "Image: {$slider->image}\n";
    echo "Active: " . ($slider->is_active ? 'Yes' : 'No') . "\n";
    echo "Image URL: {$slider->image_url}\n";
    
    // Check if image file exists
    if ($slider->image) {
        $fullPath = public_path('storage/' . $slider->image);
        echo "Full path: $fullPath\n";
        echo "File exists: " . (file_exists($fullPath) ? 'Yes' : 'No') . "\n";
    }
    echo "---\n";
}

// Check storage link
echo "\nStorage link check:\n";
echo "Storage path exists: " . (file_exists(public_path('storage')) ? 'Yes' : 'No') . "\n";
echo "Sliders folder exists: " . (file_exists(public_path('storage/sliders')) ? 'Yes' : 'No') . "\n";
