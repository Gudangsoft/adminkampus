<?php

require __DIR__ . '/vendor/autoload.php';

// Load Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$request = Illuminate\Http\Request::capture();
$kernel->handle($request);

// Update admin password
$user = App\Models\User::where('email', 'admin@g0campus.ac.id')->first();
if ($user) {
    $user->password = bcrypt('admin123');
    $user->save();
    echo "Password updated for admin@g0campus.ac.id -> admin123\n";
} else {
    echo "User not found\n";
}
