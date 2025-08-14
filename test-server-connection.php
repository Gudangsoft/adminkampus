<?php
echo "🌐 SIMPLE SERVER CONNECTION TEST\n";
echo "=" . str_repeat("=", 80) . "\n";

// Test if we can connect to our own server
$url = 'http://127.0.0.1:8001';

echo "\n1️⃣ TESTING CONNECTION TO: {$url}\n";
echo "-" . str_repeat("-", 60) . "\n";

// Method 1: file_get_contents
echo "🔗 Testing with file_get_contents...\n";
$context = stream_context_create([
    'http' => [
        'timeout' => 10,
        'method' => 'GET',
        'header' => "User-Agent: PHP-Test-Script\r\n"
    ]
]);

try {
    $result = @file_get_contents($url, false, $context);
    if ($result !== false) {
        echo "✅ SUCCESS: Server is responding!\n";
        echo "📄 Response length: " . strlen($result) . " bytes\n";
        
        // Check if it looks like HTML
        if (strpos($result, '<html') !== false || strpos($result, '<!DOCTYPE') !== false) {
            echo "✅ Response looks like HTML page\n";
        }
    } else {
        echo "❌ FAILED: Cannot connect to server\n";
    }
} catch (Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
}

// Method 2: cURL (if available)
echo "\n🔗 Testing with cURL...\n";
if (function_exists('curl_init')) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'PHP-cURL-Test');
    
    $result = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);
    
    if ($result !== false && empty($error)) {
        echo "✅ SUCCESS: Server responded with HTTP {$httpCode}\n";
        echo "📄 Response length: " . strlen($result) . " bytes\n";
    } else {
        echo "❌ FAILED: {$error}\n";
        echo "📊 HTTP Code: {$httpCode}\n";
    }
} else {
    echo "⚠️ cURL not available\n";
}

// Test specific Laravel routes
echo "\n2️⃣ TESTING LARAVEL ROUTES:\n";
echo "-" . str_repeat("-", 60) . "\n";

$routes = [
    'Home' => '/',
    'Admin Login' => '/admin/login',
    'Component Login' => '/component/login'
];

foreach ($routes as $name => $path) {
    $testUrl = $url . $path;
    echo "🔗 {$name}: {$testUrl}\n";
    
    $context = stream_context_create([
        'http' => [
            'timeout' => 5,
            'method' => 'GET'
        ]
    ]);
    
    $headers = @get_headers($testUrl, 1, $context);
    if ($headers) {
        $status = $headers[0];
        echo "   📊 Status: {$status}\n";
    } else {
        echo "   ❌ Cannot get headers\n";
    }
}

echo "\n3️⃣ TROUBLESHOOTING SUGGESTIONS:\n";
echo "-" . str_repeat("-", 60) . "\n";
echo "🔧 If you still can't access via browser:\n";
echo "   • Try http://localhost:8001/admin/login instead\n";
echo "   • Clear browser cache and cookies\n";
echo "   • Try incognito/private browsing mode\n";
echo "   • Check Windows Firewall settings\n";
echo "   • Try different browser (Chrome, Firefox, Edge)\n";
echo "   • Disable browser extensions temporarily\n";
echo "   • Check antivirus software blocking connections\n";

echo "\n4️⃣ ALTERNATIVE ACCESS:\n";
echo "-" . str_repeat("-", 60) . "\n";
echo "🌐 Try these URLs:\n";
echo "   • http://localhost:8001/admin/login\n";
echo "   • http://127.0.0.1:8001/admin/login\n";
echo "   • http://0.0.0.0:8001/admin/login\n";

echo "\n✅ SERVER CONNECTION TEST COMPLETED!\n";
