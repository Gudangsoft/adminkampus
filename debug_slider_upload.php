<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== SLIDER UPLOAD DEBUG ===\n";

// Test permissions storage folder
echo "1. Testing storage folder permissions:\n";
$storagePath = storage_path('app/public/sliders');
echo "Storage path: $storagePath\n";
echo "Folder exists: " . (is_dir($storagePath) ? 'Yes' : 'No') . "\n";
echo "Folder writable: " . (is_writable($storagePath) ? 'Yes' : 'No') . "\n";

// Test symlink
echo "\n2. Testing storage symlink:\n";
$publicStoragePath = public_path('storage');
echo "Public storage path: $publicStoragePath\n";
echo "Symlink exists: " . (is_link($publicStoragePath) || is_dir($publicStoragePath) ? 'Yes' : 'No') . "\n";

if (!is_link($publicStoragePath) && !is_dir($publicStoragePath)) {
    echo "WARNING: Storage symlink not found!\n";
    echo "Run: php artisan storage:link\n";
}

// Test model fillable
echo "\n3. Testing Slider model fillable:\n";
$slider = new App\Models\Slider();
echo "Fillable fields: " . implode(', ', $slider->getFillable()) . "\n";

// Check validation in controller
echo "\n4. Check recent slider uploads:\n";
$recentSliders = App\Models\Slider::orderBy('created_at', 'desc')->limit(3)->get();
foreach($recentSliders as $slider) {
    echo "ID: {$slider->id} - Created: {$slider->created_at} - Image: {$slider->image}\n";
    
    // Check if image file actually exists
    if ($slider->image && !filter_var($slider->image, FILTER_VALIDATE_URL)) {
        $fullPath = storage_path('app/public/' . $slider->image);
        echo "  File exists: " . (file_exists($fullPath) ? 'Yes' : 'No') . " - Path: $fullPath\n";
    }
}

echo "\n5. Test file upload size limits:\n";
echo "PHP upload_max_filesize: " . ini_get('upload_max_filesize') . "\n";
echo "PHP post_max_size: " . ini_get('post_max_size') . "\n";
echo "PHP max_file_uploads: " . ini_get('max_file_uploads') . "\n";
echo "PHP max_execution_time: " . ini_get('max_execution_time') . "\n";

echo "\n=== DEBUG COMPLETE ===\n";
