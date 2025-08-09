<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Test Storage::url()
$imagePath = 'news/1754717316_seminar-nasional-ai-dan-masa-depan-teknologi.jpeg';
$imageUrl = \Illuminate\Support\Facades\Storage::url($imagePath);

echo "Image Path: " . $imagePath . "\n";
echo "Generated URL: " . $imageUrl . "\n";
echo "APP_URL: " . config('app.url') . "\n";

// Test News model
$news = \App\Models\News::whereNotNull('featured_image')->first();
if ($news) {
    echo "News ID: " . $news->id . "\n";
    echo "Featured Image: " . $news->featured_image . "\n";
    echo "Featured Image URL: " . $news->featured_image_url . "\n";
}
