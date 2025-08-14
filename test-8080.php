<?php
echo "🌐 TESTING PORT 8080\n";
echo "=" . str_repeat("=", 80) . "\n";

$url = 'http://127.0.0.1:8080';

echo "🔗 Testing connection to: {$url}\n";

$context = stream_context_create([
    'http' => [
        'timeout' => 10,
        'method' => 'GET'
    ]
]);

try {
    $result = @file_get_contents($url, false, $context);
    if ($result !== false) {
        echo "✅ SUCCESS: Server on port 8080 is responding!\n";
        echo "📄 Response length: " . strlen($result) . " bytes\n";
        echo "\n🎯 SOLUTION FOUND!\n";
        echo "📱 Access your Laravel app at:\n";
        echo "   • http://127.0.0.1:8080\n";
        echo "   • http://127.0.0.1:8080/admin/login\n";
        echo "   • http://127.0.0.1:8080/component/login\n";
        echo "\n🔧 Port 8001 might be blocked by firewall or antivirus.\n";
        echo "    Port 8080 is working fine!\n";
    } else {
        echo "❌ Still failed on port 8080\n";
    }
} catch (Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
}
