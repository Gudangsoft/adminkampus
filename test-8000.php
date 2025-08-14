<?php
echo "🌐 TESTING DEFAULT PORT 8000\n";
echo "=" . str_repeat("=", 80) . "\n";

$url = 'http://127.0.0.1:8000';

echo "🔗 Testing connection to: {$url}\n";

try {
    $result = @file_get_contents($url);
    if ($result !== false) {
        echo "✅ SUCCESS! Laravel server is working on port 8000!\n";
        echo "📄 Response length: " . strlen($result) . " bytes\n";
        echo "\n🎯 YOUR LARAVEL APP IS ACCESSIBLE AT:\n";
        echo "=" . str_repeat("=", 60) . "\n";
        echo "🏠 Homepage: http://127.0.0.1:8000\n";
        echo "👑 Admin Login: http://127.0.0.1:8000/admin/login\n";
        echo "⚙️ Component Login: http://127.0.0.1:8000/component/login\n";
        echo "\n🔧 Update your bookmark to:\n";
        echo "   http://127.0.0.1:8000/admin/login (NOT 8001)\n";
    } else {
        echo "❌ Still failed\n";
    }
} catch (Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
}
