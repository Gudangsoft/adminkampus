<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Announcement;

echo "=== Debug Announcements ===\n\n";

echo "Total announcements: " . Announcement::count() . "\n";
echo "Published announcements: " . Announcement::where('status', 'published')->count() . "\n";
echo "Announcements via published() scope: " . Announcement::published()->count() . "\n\n";

echo "All announcements:\n";
$announcements = Announcement::all();
foreach ($announcements as $announcement) {
    echo "ID: {$announcement->id}\n";
    echo "Title: {$announcement->title}\n";
    echo "Status: {$announcement->status}\n";
    echo "Published At: " . ($announcement->published_at ? $announcement->published_at->format('Y-m-d H:i:s') : 'NULL') . "\n";
    echo "Expires At: " . ($announcement->expires_at ? $announcement->expires_at->format('Y-m-d H:i:s') : 'NULL') . "\n";
    echo "Current Time: " . now()->format('Y-m-d H:i:s') . "\n";
    echo "Is Published: " . (Announcement::published()->where('id', $announcement->id)->exists() ? 'YES' : 'NO') . "\n";
    echo "---\n";
}

?>
