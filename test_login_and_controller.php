<?php

// Laravel Bootstrap  
require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$request = Illuminate\Http\Request::capture();
$kernel->handle($request);

use Illuminate\Support\Facades\Auth;
use App\Models\User;

// Find the admin user
$user = User::where('email', 'admin@g0campus.ac.id')->first();

if (!$user) {
    echo "User not found\n";
    exit(1);
}

// Simulate login
Auth::login($user);

// Check if logged in
if (Auth::check()) {
    echo "Login successful: " . Auth::user()->email . "\n";
    echo "User ID: " . Auth::id() . "\n";
    echo "Session ID: " . session()->getId() . "\n";
} else {
    echo "Login failed\n";
}

// Try to access the controller
try {
    $controller = new App\Http\Controllers\Admin\StudentController();
    $request = new Illuminate\Http\Request();
    
    echo "Testing controller...\n";
    $response = $controller->index($request);
    echo "Controller executed successfully\n";
    echo "View: " . $response->getName() . "\n";
    
} catch (Exception $e) {
    echo "Controller error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}
