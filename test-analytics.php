<?php

// Test analytics functionality
try {
    require_once __DIR__ . '/vendor/autoload.php';
    
    $app = require_once __DIR__ . '/bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
    
    $request = Illuminate\Http\Request::create('/admin/analytics', 'GET');
    $response = $kernel->handle($request);
    
    echo "Status Code: " . $response->getStatusCode() . "\n";
    
    if ($response->getStatusCode() === 200) {
        echo "Analytics page loaded successfully\n";
        $content = $response->getContent();
        if (strpos($content, 'Analytics Dashboard') !== false) {
            echo "Content contains title\n";
        } else {
            echo "Content missing title\n";
        }
        
        if (strpos($content, '$stats') !== false) {
            echo "Content contains stats variables\n";
        }
        
        // Show first 500 characters
        echo "First 500 chars:\n" . substr($content, 0, 500) . "\n";
    } else {
        echo "Error: " . $response->getContent() . "\n";
    }
    
} catch (Exception $e) {
    echo "Exception: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}
