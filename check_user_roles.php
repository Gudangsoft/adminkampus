<?php

require_once 'vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;

// Database configuration
$capsule = new Capsule;
$capsule->addConnection([
    'driver' => 'mysql',
    'host' => '127.0.0.1',
    'database' => 'g0_campus',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => '',
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();

try {
    // Get all users with their roles
    $users = Capsule::table('users')->select('id', 'name', 'email', 'role', 'is_active', 'created_at')->get();
    
    echo "👥 Current Users in System:\n";
    echo "=" . str_repeat("=", 80) . "\n";
    
    foreach ($users as $user) {
        $status = $user->is_active ? "✅ Active" : "❌ Inactive";
        echo "ID: {$user->id} | {$user->name} | {$user->email}\n";
        echo "Role: {$user->role} | Status: {$status} | Created: {$user->created_at}\n";
        echo "-" . str_repeat("-", 80) . "\n";
    }
    
    // Check role distribution
    $roleStats = Capsule::table('users')
        ->select('role', Capsule::raw('count(*) as count'))
        ->groupBy('role')
        ->get();
    
    echo "\n📊 Role Distribution:\n";
    foreach ($roleStats as $stat) {
        echo "Role '{$stat->role}': {$stat->count} users\n";
    }
    
    // Check if proper admin exists
    $admins = Capsule::table('users')->where('role', 'admin')->where('is_active', 1)->count();
    echo "\n🔐 Active Admins: {$admins}\n";
    
    if ($admins === 0) {
        echo "⚠️  WARNING: No active admin users found!\n";
        echo "💡 You should create an admin user for proper access control.\n";
    } else {
        echo "✅ Admin access is properly configured.\n";
    }
    
    // Check middleware protection
    echo "\n🛡️  Checking current role-based access:\n";
    
    // List expected roles for a campus system
    $expectedRoles = ['admin', 'editor', 'viewer', 'student', 'lecturer'];
    echo "📋 Recommended roles for campus system:\n";
    foreach ($expectedRoles as $role) {
        $count = Capsule::table('users')->where('role', $role)->count();
        echo "- {$role}: {$count} users\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

php artisan route:clear
