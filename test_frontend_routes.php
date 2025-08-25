<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Testing Frontend Routes ===\n\n";

try {
    // Check announcements
    echo "📢 Checking Announcements:\n";
    $announcementsCount = App\Models\Announcement::count();
    echo "Total announcements: {$announcementsCount}\n";
    
    $publishedCount = App\Models\Announcement::published()->count();
    echo "Published announcements: {$publishedCount}\n";
    
    // Check specific slug
    $announcementAA = App\Models\Announcement::where('slug', 'aa')->first();
    if ($announcementAA) {
        echo "✅ Found announcement with slug 'aa': {$announcementAA->title}\n";
        echo "   Status: " . ($announcementAA->is_published ? 'Published' : 'Draft') . "\n";
    } else {
        echo "❌ No announcement found with slug 'aa'\n";
        
        // Create a test announcement
        $testAnnouncement = App\Models\Announcement::create([
            'title' => 'Test Announcement AA',
            'slug' => 'aa',
            'excerpt' => 'This is a test announcement for testing.',
            'content' => 'This is the full content of the test announcement for testing purposes.',
            'is_published' => true,
            'published_at' => now(),
            'user_id' => 1,
            'priority' => 'normal',
            'is_pinned' => false,
        ]);
        echo "✅ Created test announcement with slug 'aa'\n";
    }
    
    echo "\n🎓 Checking Study Programs:\n";
    $studyProgramsCount = App\Models\StudyProgram::count();
    echo "Total study programs: {$studyProgramsCount}\n";
    
    $activeCount = App\Models\StudyProgram::active()->count();
    echo "Active study programs: {$activeCount}\n";
    
    // Check specific slug
    $studyProgramMaju = App\Models\StudyProgram::where('slug', 'maju')->first();
    if ($studyProgramMaju) {
        echo "✅ Found study program with slug 'maju': {$studyProgramMaju->name}\n";
        echo "   Status: " . ($studyProgramMaju->is_active ? 'Active' : 'Inactive') . "\n";
    } else {
        echo "❌ No study program found with slug 'maju'\n";
        
        // Create a test study program
        $testProgram = App\Models\StudyProgram::create([
            'name' => 'Test Program Maju',
            'slug' => 'maju',
            'code' => 'TPM',
            'degree' => 'S1',
            'description' => 'This is a test study program for testing.',
            'is_active' => true,
            'sort_order' => 99,
        ]);
        echo "✅ Created test study program with slug 'maju'\n";
    }
    
    echo "\n🧪 Testing Controllers:\n";
    
    // Test AnnouncementController
    try {
        $controller = new App\Http\Controllers\AnnouncementController();
        $response = $controller->show('aa');
        echo "✅ AnnouncementController->show('aa') works\n";
    } catch (Exception $e) {
        echo "❌ AnnouncementController error: " . $e->getMessage() . "\n";
    }
    
    // Test StudyProgramController
    try {
        $controller = new App\Http\Controllers\StudyProgramController();
        $response = $controller->show('maju');
        echo "✅ StudyProgramController->show('maju') works\n";
    } catch (Exception $e) {
        echo "❌ StudyProgramController error: " . $e->getMessage() . "\n";
    }
    
} catch (Exception $e) {
    echo "❌ General error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}

echo "\n=== Test Complete ===\n";
