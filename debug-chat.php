<?php
echo "🔍 Debugging Live Chat Widget Issue\n";
echo "=====================================\n\n";

// Check if we can access the homepage
echo "1. Testing Homepage Access:\n";
$url = 'http://127.0.0.1:8000/';
$headers = @get_headers($url);
if ($headers && strpos($headers[0], '200') !== false) {
    echo "   ✅ Homepage accessible\n";
} else {
    echo "   ❌ Homepage not accessible\n";
}

echo "\n";

// Check compiled view content
echo "2. Checking Compiled Live Chat View:\n";
$compiledPath = 'storage/framework/views';
$chatFound = false;

if (is_dir($compiledPath)) {
    $files = glob($compiledPath . '/*.php');
    
    foreach ($files as $file) {
        $content = file_get_contents($file);
        if (strpos($content, 'chat-widget') !== false) {
            echo "   ✅ Found compiled chat view: " . basename($file) . "\n";
            
            // Check specific elements
            if (strpos($content, 'x-data') !== false) {
                echo "      ✅ Alpine.js x-data found\n";
            } else {
                echo "      ❌ Alpine.js x-data missing\n";
            }
            
            if (strpos($content, 'chatWidget') !== false) {
                echo "      ✅ chatWidget function found\n";
            } else {
                echo "      ❌ chatWidget function missing\n";
            }
            
            if (strpos($content, 'chat-toggle') !== false) {
                echo "      ✅ chat-toggle element found\n";
            } else {
                echo "      ❌ chat-toggle element missing\n";
            }
            
            $chatFound = true;
            break;
        }
    }
    
    if (!$chatFound) {
        echo "   ❌ No compiled chat view found\n";
    }
} else {
    echo "   ❌ Compiled views directory not found\n";
}

echo "\n";

// Check if config is properly loaded
echo "3. Testing Config Loading:\n";
try {
    $configPath = __DIR__ . '/config/live-chat.php';
    if (file_exists($configPath)) {
        $config = include $configPath;
        echo "   ✅ Config loaded successfully\n";
        echo "      - Enabled: " . ($config['enabled'] ? 'true' : 'false') . "\n";
        echo "      - Position: " . ($config['position'] ?? 'not set') . "\n";
        echo "      - Title: " . ($config['title'] ?? 'not set') . "\n";
    } else {
        echo "   ❌ Config file not found\n";
    }
} catch (Exception $e) {
    echo "   ❌ Error loading config: " . $e->getMessage() . "\n";
}

echo "\n";

// Check component file syntax
echo "4. Checking Component File Syntax:\n";
$componentPath = 'resources/views/components/live-chat.blade.php';
if (file_exists($componentPath)) {
    $content = file_get_contents($componentPath);
    
    // Check for common syntax issues
    $issues = [];
    
    if (strpos($content, '@if($isEnabled)') === false && strpos($content, '@if(') === false) {
        $issues[] = "Missing @if directive";
    }
    
    if (strpos($content, 'x-data=') === false) {
        $issues[] = "Missing Alpine.js x-data";
    }
    
    if (strpos($content, 'function chatWidget') === false) {
        $issues[] = "Missing chatWidget function";
    }
    
    if (empty($issues)) {
        echo "   ✅ Component syntax looks good\n";
    } else {
        echo "   ❌ Found syntax issues:\n";
        foreach ($issues as $issue) {
            echo "      - $issue\n";
        }
    }
} else {
    echo "   ❌ Component file not found\n";
}

echo "\n";

// Suggest solutions
echo "5. Potential Solutions:\n";
echo "   💡 Try these fixes:\n";
echo "      1. Run: php artisan view:clear\n";
echo "      2. Run: php artisan config:clear\n";
echo "      3. Check browser Developer Tools for JS errors\n";
echo "      4. Verify Alpine.js loads before chat component\n";
echo "      5. Check if CSS z-index conflicts exist\n";
echo "      6. Test in incognito/private browser mode\n";

echo "\n";

// Create a simple test
echo "6. Creating Simple Test File:\n";
$testContent = '<!DOCTYPE html>
<html>
<head>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <h1>Simple Chat Test</h1>
    
    <div x-data="{ open: false }" style="position: fixed; bottom: 20px; right: 20px; z-index: 1000;">
        <button @click="open = !open" 
                style="background: #667eea; color: white; border: none; padding: 15px; border-radius: 50px; cursor: pointer;">
            <i class="fas fa-comments"></i> Chat Test
        </button>
        
        <div x-show="open" 
             style="position: absolute; bottom: 60px; right: 0; width: 300px; height: 400px; background: white; border: 1px solid #ddd; border-radius: 10px; box-shadow: 0 4px 20px rgba(0,0,0,0.1);">
            <div style="background: #667eea; color: white; padding: 10px; border-radius: 10px 10px 0 0;">
                Simple Chat Widget
                <button @click="open = false" style="float: right; background: none; border: none; color: white;">×</button>
            </div>
            <div style="padding: 20px;">
                <p>If you can see this, Alpine.js is working!</p>
            </div>
        </div>
    </div>
</body>
</html>';

file_put_contents('public/simple-chat-test.html', $testContent);
echo "   ✅ Created simple test file: public/simple-chat-test.html\n";
echo "   🌐 Access it at: http://127.0.0.1:8000/simple-chat-test.html\n";

echo "\n✨ Debugging completed!\n";
?>
