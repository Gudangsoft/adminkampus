<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Fixing Announcement Issues ===\n\n";

try {
    // Fix announcement to be published
    $announcement = App\Models\Announcement::where('slug', 'aa')->first();
    if ($announcement) {
        $announcement->update([
            'is_published' => true,
            'published_at' => now(),
        ]);
        echo "✅ Updated announcement 'aa' to published status\n";
    }
    
    // Check if views column exists
    $hasViewsColumn = Schema::hasColumn('announcements', 'views');
    echo "Views column exists: " . ($hasViewsColumn ? 'Yes' : 'No') . "\n";
    
    if (!$hasViewsColumn) {
        echo "⚠️ Views column missing - need to add it to database\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

echo "\n=== Fix Complete ===\n";
