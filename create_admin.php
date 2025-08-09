<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

// Create admin user
User::updateOrCreate(
    ['email' => 'admin@g0campus.ac.id'],
    [
        'name' => 'Administrator',
        'email' => 'admin@g0campus.ac.id',
        'password' => Hash::make('password'),
        'email_verified_at' => now(),
    ]
);

echo "Admin user created successfully!\n";
echo "Email: admin@g0campus.ac.id\n";
echo "Password: password\n";
