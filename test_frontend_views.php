<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Testing Frontend Views ===\n\n";

try {
    // Test if globalSettings is available
    $globalSettings = [];
    
    // Check if Setting model exists and has data
    if (class_exists('App\Models\Setting')) {
        $settings = App\Models\Setting::all();
        if ($settings->count() > 0) {
            $globalSettings = $settings->pluck('value', 'key')->toArray();
            echo "✅ Found " . $settings->count() . " settings in database\n";
        } else {
            echo "⚠️ No settings found in database\n";
            // Create some basic settings
            App\Models\Setting::create(['key' => 'site_name', 'value' => 'G0-CAMPUS']);
            App\Models\Setting::create(['key' => 'site_description', 'value' => 'Kampus modern untuk masa depan cemerlang']);
            App\Models\Setting::create(['key' => 'site_keywords', 'value' => 'kampus, universitas, pendidikan, akademik']);
            echo "✅ Created basic settings\n";
            $globalSettings = App\Models\Setting::all()->pluck('value', 'key')->toArray();
        }
    } else {
        echo "❌ Setting model not found\n";
    }
    
    // Test rendering announcement view
    $announcement = App\Models\Announcement::where('slug', 'aa')->published()->first();
    if ($announcement) {
        echo "\n📢 Testing Announcement View:\n";
        try {
            $view = view('frontend.announcements.show', compact('announcement', 'globalSettings'));
            $html = $view->render();
            echo "✅ Announcement view rendered successfully (" . strlen($html) . " chars)\n";
            
            if (strpos($html, $announcement->title) !== false) {
                echo "✅ Contains announcement title\n";
            } else {
                echo "❌ Missing announcement title\n";
            }
        } catch (Exception $e) {
            echo "❌ Announcement view error: " . $e->getMessage() . "\n";
            echo "   File: " . $e->getFile() . ":" . $e->getLine() . "\n";
        }
    }
    
    // Test rendering study program view
    $studyProgram = App\Models\StudyProgram::where('slug', 'maju')->active()->first();
    if ($studyProgram) {
        echo "\n🎓 Testing Study Program View:\n";
        try {
            $lecturers = collect([]);
            $relatedPrograms = collect([]);
            $view = view('frontend.study-programs.show', compact('studyProgram', 'lecturers', 'relatedPrograms', 'globalSettings'));
            $html = $view->render();
            echo "✅ Study program view rendered successfully (" . strlen($html) . " chars)\n";
            
            if (strpos($html, $studyProgram->name) !== false) {
                echo "✅ Contains study program name\n";
            } else {
                echo "❌ Missing study program name\n";
            }
        } catch (Exception $e) {
            echo "❌ Study program view error: " . $e->getMessage() . "\n";
            echo "   File: " . $e->getFile() . ":" . $e->getLine() . "\n";
        }
    }
    
} catch (Exception $e) {
    echo "❌ General error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}

echo "\n=== Test Complete ===\n";
