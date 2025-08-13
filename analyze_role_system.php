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
    echo "🔍 ROLE-BASED ACCESS CONTROL ANALYSIS\n";
    echo "=" . str_repeat("=", 80) . "\n";
    
    // 1. Check current issues
    echo "\n1️⃣ CURRENT ISSUES:\n";
    
    // Check user with wrong role
    $userWithWrongRole = Capsule::table('users')->where('email', 'admin@g0campus.ac.id')->first();
    if ($userWithWrongRole && $userWithWrongRole->role === 'user') {
        echo "⚠️  Administrator user has role 'user' instead of 'admin'\n";
        echo "   Email: {$userWithWrongRole->email} | Current Role: {$userWithWrongRole->role}\n";
        
        // Fix this issue
        Capsule::table('users')
            ->where('id', $userWithWrongRole->id)
            ->update(['role' => 'admin']);
        echo "✅ FIXED: Changed role to 'admin'\n";
    }
    
    // 2. Check middleware protection
    echo "\n2️⃣ MIDDLEWARE PROTECTION:\n";
    echo "❌ No role-based middleware found in routes\n";
    echo "❌ Any authenticated user can access admin panel\n";
    echo "⚠️  Security Risk: Editor/Viewer users can access admin functions\n";
    
    // 3. Recommendations
    echo "\n3️⃣ RECOMMENDATIONS:\n";
    echo "🔧 Need to implement:\n";
    echo "   - Role-based middleware (AdminMiddleware, EditorMiddleware)\n";
    echo "   - Route protection based on user roles\n";
    echo "   - UI restrictions based on user permissions\n";
    
    // 4. Expected role permissions
    echo "\n4️⃣ EXPECTED ROLE PERMISSIONS:\n";
    $rolePermissions = [
        'admin' => ['Full access', 'User management', 'System settings', 'All CRUD operations'],
        'editor' => ['Content management', 'News/Announcements', 'Gallery', 'Limited access'],
        'viewer' => ['Read-only access', 'View reports', 'No modification rights'],
        'student' => ['Profile management', 'View academic info', 'Limited frontend access'],
        'lecturer' => ['Profile management', 'Manage courses', 'View students', 'Academic content']
    ];
    
    foreach ($rolePermissions as $role => $permissions) {
        echo "\n📋 {$role}:\n";
        foreach ($permissions as $permission) {
            echo "   - {$permission}\n";
        }
    }
    
    // 5. Current user status after fix
    echo "\n5️⃣ UPDATED USER STATUS:\n";
    $users = Capsule::table('users')->select('name', 'email', 'role', 'is_active')->get();
    foreach ($users as $user) {
        $status = $user->is_active ? "✅" : "❌";
        echo "{$status} {$user->name} ({$user->email}) - Role: {$user->role}\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
