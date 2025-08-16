<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "🔍 Quick Route Verification - Missing Routes Check\n";
echo "=" . str_repeat("=", 60) . "\n\n";

// Test routes that were recently added
$newRoutes = [
    'admin.notifications.index' => 'Notifications Management',
    'admin.themes.index' => 'Themes Management', 
    'admin.languages.index' => 'Languages Management',
    'admin.analytics.index' => 'Analytics Dashboard',
    'admin.seo.dashboard' => 'SEO Dashboard'
];

echo "📋 Testing Recently Added Routes:\n";
echo "-" . str_repeat("-", 60) . "\n";

foreach ($newRoutes as $routeName => $description) {
    try {
        $url = route($routeName);
        echo "✅ {$description}: {$url}\n";
    } catch (Exception $e) {
        echo "❌ {$description}: Route not found\n";
    }
}

echo "\n🎯 Route Check Complete!\n";
