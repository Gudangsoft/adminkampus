<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$galleries = App\Models\Gallery::all();

echo "Available Galleries:\n";
foreach ($galleries as $gallery) {
    echo $gallery->id . ': ' . $gallery->title . ' (' . $gallery->type . ')' . "\n";
    if ($gallery->image_path) {
        echo "   Image: " . $gallery->image_path . "\n";
    }
    echo "   Description: " . substr($gallery->description, 0, 50) . "...\n\n";
}
