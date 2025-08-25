<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Fake a request for session testing
$request = Illuminate\Http\Request::create('/admin/students');
$app->instance('request', $request);

// Bootstrap the application
$kernel->bootstrap();

// Check if user is authenticated
$user = auth()->user();

echo "Authentication Status:\n";
echo "User authenticated: " . (auth()->check() ? 'YES' : 'NO') . "\n";

if ($user) {
    echo "User ID: " . $user->id . "\n";
    echo "User Email: " . $user->email . "\n";
    echo "User Role: " . ($user->role ?? 'no role') . "\n";
} else {
    echo "No authenticated user\n";
}

// Check session
if (session()->isStarted()) {
    echo "\nSession Status:\n";
    echo "Session ID: " . session()->getId() . "\n";
    echo "Session data: " . json_encode(session()->all()) . "\n";
} else {
    echo "\nSession not started\n";
}

// Test middleware
echo "\nTesting role middleware:\n";
$middleware = new App\Http\Middleware\RoleMiddleware();

try {
    $response = $middleware->handle($request, function($req) {
        return response('OK');
    }, 'admin', 'editor');
    echo "Middleware passed: YES\n";
} catch (Exception $e) {
    echo "Middleware failed: " . $e->getMessage() . "\n";
}
