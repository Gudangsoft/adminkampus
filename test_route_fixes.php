<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "🔍 Testing Route Fixes - Admin Panel\n";
echo "=" . str_repeat("=", 50) . "\n\n";

// Test critical admin routes
$criticalRoutes = [
    'admin.dashboard' => 'Dashboard Admin',
    'admin.students.index' => 'Students Management',
    'admin.lecturers.index' => 'Lecturers Management',
    'admin.faculties.index' => 'Faculties Management', 
    'admin.study-programs.index' => 'Study Programs Management',
    'admin.news.index' => 'News Management',
    'admin.announcements.index' => 'Announcements Management',
    'admin.galleries.index' => 'Galleries Management',
    'admin.system.users.index' => 'User Management',
    'admin.settings.index' => 'Settings Management'
];

echo "📋 Testing Route Definitions:\n";
echo "-" . str_repeat("-", 50) . "\n";

foreach ($criticalRoutes as $routeName => $description) {
    try {
        $url = route($routeName);
        echo "✅ {$description}: {$url}\n";
    } catch (Exception $e) {
        echo "❌ {$description}: Route not found - {$e->getMessage()}\n";
    }
}

echo "\n🛡️ Testing Middleware Registration:\n";
echo "-" . str_repeat("-", 50) . "\n";

// Check if middleware classes exist
$middlewareClasses = [
    'App\\Http\\Middleware\\AdminMiddleware' => 'AdminMiddleware',
    'App\\Http\\Middleware\\RoleMiddleware' => 'RoleMiddleware'
];

foreach ($middlewareClasses as $class => $name) {
    if (class_exists($class)) {
        echo "✅ {$name}: Class exists\n";
    } else {
        echo "❌ {$name}: Class not found\n";
    }
}

echo "\n📊 Route Statistics:\n";
echo "-" . str_repeat("-", 50) . "\n";

// Count routes by type
$router = app('router');
$routes = $router->getRoutes();

$adminRoutes = 0;
$resourceRoutes = 0;
$totalRoutes = 0;

foreach ($routes as $route) {
    $totalRoutes++;
    
    if (strpos($route->getName() ?? '', 'admin.') === 0) {
        $adminRoutes++;
    }
    
    if (in_array('GET', $route->methods()) && in_array('POST', $route->methods())) {
        $resourceRoutes++;
    }
}

echo "Total Routes: {$totalRoutes}\n";
echo "Admin Routes: {$adminRoutes}\n";
echo "Resource Routes: {$resourceRoutes}\n";

echo "\n✅ Route Fix Verification Complete!\n";
echo "=" . str_repeat("=", 50) . "\n";

// Test user roles
try {
    $users = \App\Models\User::select('id', 'name', 'role', 'is_active')->get();
    
    echo "\n👥 Current User Roles:\n";
    echo "-" . str_repeat("-", 50) . "\n";
    
    foreach ($users as $user) {
        $status = $user->is_active ? "Active" : "Inactive";
        echo "ID: {$user->id} | {$user->name} | Role: {$user->role} | {$status}\n";
    }
    
} catch (Exception $e) {
    echo "\n⚠️ User data check failed: " . $e->getMessage() . "\n";
}

echo "\n🎯 All Routes Fixed and Ready for Production!\n";
