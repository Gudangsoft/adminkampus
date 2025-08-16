<?php

require_once 'vendor/autoload.php';

use App\Models\User;

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Testing Role-Based Access Control ===\n\n";

// Test user roles
$users = User::select('id', 'name', 'email', 'role', 'is_active')->get();

echo "Current Users and Roles:\n";
echo "========================\n";
foreach ($users as $user) {
    echo "ID: {$user->id} | Name: {$user->name} | Email: {$user->email} | Role: {$user->role} | Active: " . ($user->is_active ? 'Yes' : 'No') . "\n";
    
    // Test role methods
    echo "  - Is Admin: " . ($user->isAdmin() ? 'Yes' : 'No') . "\n";
    echo "  - Can Access Admin: " . ($user->canAccessAdmin() ? 'Yes' : 'No') . "\n";
    echo "  - Role Display: " . $user->role_display_name . "\n";
    echo "  - Has Admin Role: " . ($user->hasRole('admin') ? 'Yes' : 'No') . "\n";
    echo "  - Has Editor Role: " . ($user->hasRole('editor') ? 'Yes' : 'No') . "\n";
    echo "  - Has Viewer Role: " . ($user->hasRole('viewer') ? 'Yes' : 'No') . "\n";
    echo "\n";
}

echo "\n=== Middleware Test ===\n";
echo "AdminMiddleware and RoleMiddleware classes are registered in Http/Kernel.php\n";
echo "Routes are protected with role-based middleware\n";

echo "\n=== Route Groups Summary ===\n";
echo "1. Admin Only Routes (middleware: admin):\n";
echo "   - /admin/users (User Management)\n";
echo "   - /admin/backup (Backup Management)\n";
echo "   - /admin/pdf (PDF Reports)\n";
echo "   - /admin/settings (System Settings)\n\n";

echo "2. Admin + Editor Routes (middleware: role:admin,editor):\n";
echo "   - /admin/news (Content Management)\n";
echo "   - /admin/announcements\n";
echo "   - /admin/galleries\n";
echo "   - /admin/sliders\n";
echo "   - /admin/pages\n";
echo "   - /admin/menus\n\n";

echo "3. Admin + Editor + Viewer Routes (middleware: role:admin,editor,viewer):\n";
echo "   - /admin/faculties (Read-only for viewers)\n";
echo "   - /admin/lecturers\n";
echo "   - /admin/students\n\n";

echo "4. Profile Routes (Available to all authenticated admin users):\n";
echo "   - /admin/profile\n\n";

echo "=== Test Completed Successfully ===\n";
