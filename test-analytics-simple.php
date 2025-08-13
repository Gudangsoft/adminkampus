<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

try {
    echo "=== Analytics Debug Test ===\n";
    
    // Test 1: Controller exists
    echo "1. Testing controller exists...\n";
    if (class_exists('App\Http\Controllers\Admin\AnalyticsController')) {
        echo "   ✅ AnalyticsController exists\n";
    } else {
        echo "   ❌ AnalyticsController missing\n";
    }
    
    // Test 2: Models exist
    echo "2. Testing models...\n";
    $models = [
        'App\Models\News',
        'App\Models\User'
    ];
    
    foreach ($models as $model) {
        if (class_exists($model)) {
            echo "   ✅ {$model} exists\n";
        } else {
            echo "   ❌ {$model} missing\n";
        }
    }
    
    // Test 3: View exists
    echo "3. Testing view...\n";
    $viewPath = 'resources/views/admin/analytics/index.blade.php';
    if (file_exists($viewPath)) {
        echo "   ✅ Analytics view exists\n";
        
        // Check file size
        $size = filesize($viewPath);
        echo "   📄 View file size: {$size} bytes\n";
        
        // Check if it contains key content
        $content = file_get_contents($viewPath);
        if (strpos($content, 'Analytics Dashboard') !== false) {
            echo "   ✅ View contains title\n";
        } else {
            echo "   ⚠️ View missing title\n";
        }
        
        if (strpos($content, '$stats') !== false) {
            echo "   ✅ View uses stats variable\n";
        } else {
            echo "   ⚠️ View missing stats variable\n";
        }
        
    } else {
        echo "   ❌ Analytics view missing\n";
    }
    
    // Test 4: Check layout
    echo "4. Testing layout...\n";
    $layoutPath = 'resources/views/admin/layouts/app.blade.php';
    if (file_exists($layoutPath)) {
        echo "   ✅ Admin layout exists\n";
    } else {
        echo "   ❌ Admin layout missing\n";
    }
    
    echo "\n=== Test Complete ===\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}
