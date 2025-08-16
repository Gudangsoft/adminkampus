<?php

require 'vendor/autoload.php';

$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

try {
    echo "=== User Management Test ===\n";
    
    // Check existing users
    $userCount = User::count();
    echo "✓ Current users in database: " . $userCount . "\n";
    
    if ($userCount === 0) {
        // Create a test admin user
        $user = User::create([
            'name' => 'Admin Test',
            'email' => 'admin@test.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'is_active' => true
        ]);
        echo "✓ Created test admin user: admin@test.com / password123\n";
    } else {
        $users = User::select('name', 'email', 'role')->get();
        echo "✓ Existing users:\n";
        foreach ($users as $user) {
            echo "  - {$user->name} ({$user->email}) - Role: {$user->role}\n";
        }
    }
    
    echo "\n🎉 User system is ready!\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
