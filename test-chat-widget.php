<?php
echo "🔍 Testing Live Chat Widget Configuration\n";
echo "==========================================\n\n";

// Test 1: Check if config file exists
echo "1. Config File Check:\n";
$configPath = 'config/live-chat.php';
if (file_exists($configPath)) {
    echo "   ✅ live-chat.php config exists\n";
    
    // Load config
    $config = include $configPath;
    echo "   📊 Enabled: " . ($config['enabled'] ? 'Yes' : 'No') . "\n";
    echo "   📍 Position: " . ($config['position'] ?? 'right') . "\n";
    echo "   💬 Button Text: " . ($config['button_text'] ?? 'Default') . "\n";
    echo "   📝 Auto Responses: " . count($config['auto_responses'] ?? []) . " items\n";
} else {
    echo "   ❌ live-chat.php config not found\n";
}

echo "\n";

// Test 2: Check if component file exists
echo "2. Component File Check:\n";
$componentPath = 'resources/views/components/live-chat.blade.php';
if (file_exists($componentPath)) {
    echo "   ✅ live-chat.blade.php component exists\n";
    
    // Check file size
    $fileSize = filesize($componentPath);
    echo "   📏 File size: " . number_format($fileSize) . " bytes\n";
    
    // Check if component has proper Alpine.js structure
    $content = file_get_contents($componentPath);
    if (strpos($content, 'x-data') !== false) {
        echo "   ✅ Alpine.js x-data found\n";
    } else {
        echo "   ❌ Alpine.js x-data not found\n";
    }
    
    if (strpos($content, 'chatWidget') !== false) {
        echo "   ✅ chatWidget function found\n";
    } else {
        echo "   ❌ chatWidget function not found\n";
    }
} else {
    echo "   ❌ live-chat.blade.php component not found\n";
}

echo "\n";

// Test 3: Check if layout includes the component
echo "3. Layout Integration Check:\n";
$layoutPath = 'resources/views/layouts/app.blade.php';
if (file_exists($layoutPath)) {
    $layoutContent = file_get_contents($layoutPath);
    
    if (strpos($layoutContent, '@include(\'components.live-chat\')') !== false) {
        echo "   ✅ live-chat component included in app layout\n";
    } else {
        echo "   ❌ live-chat component not included in app layout\n";
    }
    
    if (strpos($layoutContent, 'alpinejs') !== false) {
        echo "   ✅ Alpine.js script found in layout\n";
    } else {
        echo "   ❌ Alpine.js script not found in layout\n";
    }
} else {
    echo "   ❌ app.blade.php layout not found\n";
}

echo "\n";

// Test 4: Check compiled views
echo "4. Compiled Views Check:\n";
$compiledPath = 'storage/framework/views';
if (is_dir($compiledPath)) {
    $files = glob($compiledPath . '/*.php');
    $liveChatCompiled = false;
    
    foreach ($files as $file) {
        $content = file_get_contents($file);
        if (strpos($content, 'chat-widget') !== false) {
            $liveChatCompiled = true;
            echo "   ✅ Compiled live-chat view found: " . basename($file) . "\n";
            break;
        }
    }
    
    if (!$liveChatCompiled) {
        echo "   ⚠️  No compiled live-chat view found - may need view:clear\n";
    }
} else {
    echo "   ❌ Compiled views directory not found\n";
}

echo "\n";

// Test 5: Generate test URL
echo "5. Test Recommendations:\n";
echo "   🌐 Visit: http://127.0.0.1:8000/ to check chat widget\n";
echo "   🔧 Admin Panel: http://127.0.0.1:8000/admin/components\n";
echo "   📱 Look for chat button in bottom-right corner\n";

echo "\n";

// Test 6: Common issues and solutions
echo "6. Common Issues & Solutions:\n";
echo "   💡 If chat not visible:\n";
echo "      - Run: php artisan view:clear\n";
echo "      - Run: php artisan config:clear\n";
echo "      - Check browser console for JS errors\n";
echo "      - Ensure live-chat.enabled = true in config\n";
echo "      - Check if Alpine.js loads properly\n";

echo "\n✨ Test completed!\n";
?>
