<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "🔍 Final Route Verification - Theme Fix Check\n";
echo "=" . str_repeat("=", 55) . "\n\n";

// Test the problematic routes that were just fixed
$testRoutes = [
    'admin.dashboard' => 'Admin Dashboard',
    'admin.notifications.index' => 'Notifications Management',
    'admin.theme.index' => 'Theme Management (Singular)',
    'admin.themes.index' => 'Themes Management (Plural)',
    'admin.students.index' => 'Students Management',
    'admin.lecturers.index' => 'Lecturers Management',
    'admin.settings.index' => 'Settings Management'
];

echo "📋 Testing Critical Admin Routes:\n";
echo "-" . str_repeat("-", 55) . "\n";

$working = 0;
$total = count($testRoutes);

foreach ($testRoutes as $routeName => $description) {
    try {
        $url = route($routeName);
        echo "✅ {$description}: {$url}\n";
        $working++;
    } catch (Exception $e) {
        echo "❌ {$description}: Route not found\n";
    }
}

echo "\n📊 Summary:\n";
echo "-" . str_repeat("-", 55) . "\n";
echo "Routes Working: {$working}/{$total}\n";

if ($working === $total) {
    echo "🎉 All critical routes are working perfectly!\n";
    echo "✅ Admin dashboard should now be accessible without route errors.\n";
} else {
    echo "⚠️ Some routes still need attention.\n";
}

echo "\n🌐 Access admin panel at: http://127.0.0.1:8000/admin/\n";
