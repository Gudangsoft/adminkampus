<?php

require __DIR__ . '/vendor/autoload.php';

use Illuminate\Support\Facades\Hash;

// Load Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

// Create admin user
$user = new App\Models\User();
$user->name = 'Admin';
$user->email = 'admin@test.com';
$user->password = Hash::make('admin123');
$user->role = 'admin';
$user->email_verified_at = now();
$user->save();

echo "Admin user created: admin@test.com / admin123\n";
