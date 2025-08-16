<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Announcement;

echo "Testing Announcement Model Fix:\n";
echo "================================\n";

// Test published scope
try {
    $publishedCount = Announcement::published()->count();
    echo "✓ Published scope works: {$publishedCount} announcements\n";
} catch (Exception $e) {
    echo "✗ Published scope error: " . $e->getMessage() . "\n";
}

// Test finding the specific announcement
try {
    $announcement = Announcement::where('slug', 'update-protokol-kesehatan-kampus')->first();
    if ($announcement) {
        echo "✓ Found announcement: " . $announcement->title . "\n";
        echo "  Status: " . $announcement->status . "\n";
        echo "  Start Date: " . $announcement->start_date . "\n";
        echo "  End Date: " . $announcement->end_date . "\n";
    } else {
        echo "✗ Announcement not found\n";
    }
} catch (Exception $e) {
    echo "✗ Error finding announcement: " . $e->getMessage() . "\n";
}

// Test AnnouncementController show method
try {
    $controller = new App\Http\Controllers\AnnouncementController();
    echo "✓ AnnouncementController can be instantiated\n";
} catch (Exception $e) {
    echo "✗ AnnouncementController error: " . $e->getMessage() . "\n";
}

echo "\nTest completed.\n";
