<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== SLIDERS TABLE STRUCTURE ===\n";

try {
    $columns = DB::select('DESCRIBE sliders');
    
    echo "Columns in sliders table:\n";
    foreach($columns as $col) {
        echo "- {$col->Field} ({$col->Type}) - Null: {$col->Null}\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

echo "\n=== SAMPLE SLIDER DATA ===\n";
try {
    $sliders = App\Models\Slider::limit(3)->get();
    foreach($sliders as $slider) {
        echo "ID: {$slider->id}\n";
        echo "Title: {$slider->title}\n";
        echo "Description: {$slider->description}\n";
        echo "Image: {$slider->image}\n";
        echo "Link: " . ($slider->link ?? 'null') . "\n";
        echo "Link Target: " . ($slider->link_target ?? 'null') . "\n";
        echo "Button Text: " . ($slider->button_text ?? 'null') . "\n";
        echo "Sort Order: " . ($slider->sort_order ?? 'null') . "\n";
        echo "Is Active: " . ($slider->is_active ? 'Yes' : 'No') . "\n";
        echo "---\n";
    }
} catch (Exception $e) {
    echo "Error getting slider data: " . $e->getMessage() . "\n";
}
