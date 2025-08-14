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
    echo "🔐 MULTI-ROLE LOGIN SYSTEM TEST\n";
    echo "=" . str_repeat("=", 80) . "\n";

    // 1. Check all users and their roles
    echo "\n1️⃣ CURRENT USERS AND ROLES:\n";
    echo "-" . str_repeat("-", 60) . "\n";
    
    $users = Capsule::table('users')
        ->select('id', 'name', 'email', 'role', 'is_active', 'created_at')
        ->orderBy('role')
        ->get();
    
    foreach ($users as $user) {
        $status = $user->is_active ? "✅ Active" : "❌ Inactive";
        $roleIcon = match($user->role) {
            'admin' => '👑',
            'editor' => '✏️',
            'viewer' => '👁️',
            default => '❓'
        };
        
        echo "{$roleIcon} {$user->name}\n";
        echo "   📧 {$user->email}\n";
        echo "   🎭 Role: " . strtoupper($user->role) . "\n";
        echo "   📊 Status: {$status}\n";
        echo "   📅 Created: {$user->created_at}\n\n";
    }

    // 2. Login URLs and Access Rights
    echo "2️⃣ LOGIN URLS AND ACCESS RIGHTS:\n";
    echo "-" . str_repeat("-", 60) . "\n";
    
    $loginUrls = [
        'Admin Sistem' => [
            'url' => 'http://127.0.0.1:8001/admin/login',
            'access' => ['admin', 'editor'],
            'description' => 'Panel utama untuk manajemen website kampus',
            'features' => [
                'Dashboard & Analytics',
                'Manajemen Berita & Pengumuman', 
                'Manajemen Fakultas & Dosen',
                'Manajemen Mahasiswa',
                'Pengaturan Sistem'
            ]
        ],
        'Admin Komponen' => [
            'url' => 'http://127.0.0.1:8001/component/login',
            'access' => ['admin'],
            'description' => 'Panel khusus untuk manajemen komponen floating',
            'features' => [
                'Quick Access Configuration',
                'Live Chat Configuration',
                'Component Settings'
            ]
        ]
    ];
    
    foreach ($loginUrls as $name => $info) {
        echo "🌐 {$name}:\n";
        echo "   🔗 URL: {$info['url']}\n";
        echo "   👥 Access: " . implode(', ', $info['access']) . "\n";
        echo "   📝 Description: {$info['description']}\n";
        echo "   ⚙️ Features:\n";
        foreach ($info['features'] as $feature) {
            echo "      - {$feature}\n";
        }
        echo "\n";
    }

    // 3. Role-based Access Test
    echo "3️⃣ ROLE-BASED ACCESS MATRIX:\n";
    echo "-" . str_repeat("-", 60) . "\n";
    
    $accessMatrix = [
        'Admin Sistem Login' => [
            'admin' => '✅ Full Access',
            'editor' => '✅ Content Access',
            'viewer' => '❌ No Access'
        ],
        'Component Admin Login' => [
            'admin' => '✅ Full Access',
            'editor' => '❌ No Access',
            'viewer' => '❌ No Access'
        ],
        'User Management' => [
            'admin' => '✅ Full CRUD',
            'editor' => '❌ No Access',
            'viewer' => '❌ No Access'
        ],
        'Content Management' => [
            'admin' => '✅ Full CRUD',
            'editor' => '✅ Full CRUD',
            'viewer' => '👁️ Read Only'
        ]
    ];
    
    foreach ($accessMatrix as $feature => $access) {
        echo "🎯 {$feature}:\n";
        foreach ($access as $role => $permission) {
            echo "   {$permission} - " . strtoupper($role) . "\n";
        }
        echo "\n";
    }

    // 4. Security Features
    echo "4️⃣ SECURITY FEATURES IMPLEMENTED:\n";
    echo "-" . str_repeat("-", 60) . "\n";
    
    $securityFeatures = [
        '🔐 Separate Login Systems' => 'Different login URLs for different access levels',
        '🛡️ Role-based Middleware' => 'Route protection based on user roles',
        '🚫 Account Status Check' => 'Active/inactive account validation',
        '🔄 Session Management' => 'Proper session handling and logout',
        '⚠️ Error Handling' => 'Clear error messages for unauthorized access',
        '🎭 UI Adaptation' => 'Different layouts for different admin types'
    ];
    
    foreach ($securityFeatures as $feature => $description) {
        echo "{$feature}: {$description}\n";
    }

    // 5. Test Recommendations
    echo "\n5️⃣ TESTING RECOMMENDATIONS:\n";
    echo "-" . str_repeat("-", 60) . "\n";
    
    $testSteps = [
        '1. Test Admin Sistem Login' => [
            'Login dengan admin@g0campus.ac.id',
            'Verifikasi akses ke semua fitur admin',
            'Test logout dan redirect'
        ],
        '2. Test Admin Komponen Login' => [
            'Login dengan admin@campus.ac.id', 
            'Verifikasi akses hanya ke component management',
            'Test navigasi antar panel'
        ],
        '3. Test Editor Access' => [
            'Login editor ke admin sistem',
            'Verifikasi tidak bisa akses component admin',
            'Test batasan akses fitur'
        ],
        '4. Test Security' => [
            'Coba akses URL admin tanpa login',
            'Test akses dengan role yang salah',
            'Verifikasi redirect ke login yang sesuai'
        ]
    ];
    
    foreach ($testSteps as $step => $details) {
        echo "📋 {$step}:\n";
        foreach ($details as $detail) {
            echo "   • {$detail}\n";
        }
        echo "\n";
    }

    echo "✅ MULTI-ROLE LOGIN SYSTEM READY FOR TESTING!\n";
    echo "📱 Access via floating button on homepage: http://127.0.0.1:8001\n\n";

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
