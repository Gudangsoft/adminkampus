<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "🔍 View Verification - User Management Views\n";
echo "=" . str_repeat("=", 55) . "\n\n";

// Check if view files exist
$viewFiles = [
    'admin.system.users.index' => 'resources/views/admin/system/users/index.blade.php',
    'admin.system.users.create' => 'resources/views/admin/system/users/create.blade.php',
    'admin.system.users.edit' => 'resources/views/admin/system/users/edit.blade.php',
    'admin.system.users.show' => 'resources/views/admin/system/users/show.blade.php'
];

echo "📋 Checking View Files:\n";
echo "-" . str_repeat("-", 55) . "\n";

$existing = 0;
$total = count($viewFiles);

foreach ($viewFiles as $viewName => $filePath) {
    if (file_exists($filePath)) {
        echo "✅ {$viewName}: File exists\n";
        $existing++;
    } else {
        echo "❌ {$viewName}: File missing\n";
    }
}

echo "\n📊 Summary:\n";
echo "-" . str_repeat("-", 55) . "\n";
echo "View Files: {$existing}/{$total}\n";

// Test if we can get a user for testing
try {
    $user = \App\Models\User::first();
    if ($user) {
        echo "\n🎯 Test URLs:\n";
        echo "-" . str_repeat("-", 55) . "\n";
        echo "✅ Users Index: " . route('admin.system.users.index') . "\n";
        echo "✅ Create User: " . route('admin.system.users.create') . "\n";
        echo "✅ Edit User: " . route('admin.system.users.edit', $user) . "\n";
        echo "✅ Show User: " . route('admin.system.users.show', $user) . "\n";
    }
} catch (Exception $e) {
    echo "\n⚠️ Could not generate test URLs: " . $e->getMessage() . "\n";
}

if ($existing === $total) {
    echo "\n🎉 All user management views are available!\n";
    echo "✅ The edit page should now be accessible.\n";
} else {
    echo "\n⚠️ Some view files are still missing.\n";
}

echo "\n🌐 Test the edit page at: http://127.0.0.1:8000/admin/system/users/4/edit\n";
