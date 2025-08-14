<?php

require_once __DIR__ . '/vendor/autoload.php';

// Load Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "🧪 Testing Search API directly...\n\n";

try {
    // Create request
    $request = new \Illuminate\Http\Request();
    $request->merge(['q' => 'pendaftaran']);
    
    // Create controller and test
    $controller = new \App\Http\Controllers\GlobalSearchController();
    $response = $controller->search($request);
    
    echo "✅ Search API Response:\n";
    echo $response->getContent() . "\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}
