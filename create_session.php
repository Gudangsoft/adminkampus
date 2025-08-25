<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$request = Illuminate\Http\Request::capture();
$kernel->handle($request);

// Login as admin
$user = App\Models\User::where('email', 'admin@g0campus.ac.id')->first();
if ($user) {
    Auth::login($user);
    echo "✅ Logged in as: " . $user->email . " (Role: " . $user->role . ")\n";
    
    // Start session
    session()->start();
    session()->put('auth.password_confirmed_at', time());
    session()->save();
    
    echo "✅ Session ID: " . session()->getId() . "\n";
    echo "✅ Auth check: " . (Auth::check() ? 'YES' : 'NO') . "\n";
    
    // Get session cookie
    $sessionName = config('session.cookie');
    $sessionValue = session()->getId();
    
    echo "✅ Session cookie: {$sessionName}={$sessionValue}\n";
    echo "\n🌐 Now access: http://127.0.0.1:8000/admin/students\n";
    echo "📋 Set cookie: {$sessionName}={$sessionValue}\n";
    
} else {
    echo "❌ User not found\n";
}
