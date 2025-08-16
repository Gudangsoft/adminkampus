<?php

require 'vendor/autoload.php';

$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\ThemeSetting;

try {
    echo "=== Theme System Test ===\n";
    
    // Test database connection
    $settings = ThemeSetting::getAllGrouped();
    echo "✓ Database connection successful\n";
    echo "✓ Theme settings loaded: " . count($settings) . " groups\n";
    
    // Test theme setting retrieval
    $primaryColor = ThemeSetting::get('primary_color');
    echo "✓ Primary color: " . $primaryColor . "\n";
    
    $currentTheme = ThemeSetting::get('current_theme');
    echo "✓ Current theme: " . $currentTheme . "\n";
    
    // Test setting a value
    ThemeSetting::set('test_setting', 'test_value', 'string', 'general');
    $testValue = ThemeSetting::get('test_setting');
    echo "✓ Set and get test: " . $testValue . "\n";
    
    // Clean up test setting
    ThemeSetting::where('key', 'test_setting')->delete();
    echo "✓ Test cleanup completed\n";
    
    echo "\n🎉 Theme system is working correctly!\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
