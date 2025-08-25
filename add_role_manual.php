<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$request = Illuminate\Http\Request::capture();
$kernel->handle($request);

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

try {
    // Cek apakah kolom role sudah ada
    if (!Schema::hasColumn('users', 'role')) {
        echo "Adding role column to users table...\n";
        DB::statement("ALTER TABLE users ADD COLUMN role ENUM('admin', 'editor', 'user') DEFAULT 'user' AFTER email");
        echo "✅ Role column added successfully\n";
    } else {
        echo "✅ Role column already exists\n";
    }
    
    // Update admin user
    $user = App\Models\User::where('email', 'admin@g0campus.ac.id')->first();
    if ($user) {
        $user->role = 'admin';
        $user->save();
        echo "✅ Admin user role updated: {$user->email} -> admin\n";
    } else {
        echo "❌ Admin user not found\n";
    }
    
    // Update fillable di model User
    echo "✅ Now update User model to include 'role' in fillable array\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
