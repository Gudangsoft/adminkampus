<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Debugging Sliders:\n";
echo "==================\n";

$sliders = App\Models\Slider::all();
echo "Total sliders: " . $sliders->count() . "\n\n";

foreach($sliders as $slider) {
    echo "ID: " . $slider->id . "\n";
    echo "Title: " . $slider->title . "\n";
    echo "Active: " . ($slider->is_active ? 'Yes' : 'No') . "\n";
    echo "Image: " . $slider->image . "\n";
    echo "Image URL: " . $slider->image_url . "\n";
    echo "---\n";
}

echo "\nActive sliders only:\n";
$activeSliders = App\Models\Slider::active()->ordered()->get();
echo "Active count: " . $activeSliders->count() . "\n";

foreach($activeSliders as $slider) {
    echo "- " . $slider->title . " (Order: " . $slider->sort_order . ")\n";
}
