<?php

require_once 'vendor/autoload.php';

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::create('/pejabat-struktural', 'GET')
);

echo "=== FINAL CAMPUS OFFICIALS PAGE TEST ===\n\n";

// Check response status
echo "1. Response Status: " . $response->getStatusCode() . "\n";

if ($response->getStatusCode() === 200) {
    echo "✓ Page loads successfully\n\n";
    
    $content = $response->getContent();
    
    // Check for key elements
    echo "2. Checking Page Content:\n";
    
    if (strpos($content, 'KESOSI') !== false) {
        echo "✓ Website name (KESOSI) found\n";
    } else {
        echo "✗ Website name not found\n";
    }
    
    if (strpos($content, 'site_logo') !== false || strpos($content, 'default-logo') !== false) {
        echo "✓ Logo element found\n";
    } else {
        echo "✗ Logo element not found\n";
    }
    
    if (strpos($content, 'Pejabat Struktural') !== false) {
        echo "✓ Page title found\n";
    } else {
        echo "✗ Page title not found\n";
    }
    
    if (strpos($content, 'position_name') !== false || strpos($content, 'Rektor') !== false) {
        echo "✓ Official positions found\n";
    } else {
        echo "✗ Official positions not found\n";
    }
    
    // Count officials in content
    $officialsCount = substr_count($content, 'card border-0 shadow-sm');
    echo "✓ Found $officialsCount official cards\n";
    
    echo "\n3. Logo Integration:\n";
    if (strpos($content, 'storage/images/logos/') !== false) {
        echo "✓ Logo path correctly set\n";
    } elseif (strpos($content, 'default-logo') !== false) {
        echo "✓ Fallback logo ready\n";
    } else {
        echo "? Logo handling unclear\n";
    }
    
} else {
    echo "✗ Page failed to load (Status: " . $response->getStatusCode() . ")\n";
    echo "Error: " . $response->getContent() . "\n";
}

echo "\n=== TEST COMPLETED ===\n";
echo "📋 Final verification of campus officials page with logo and branding.\n";

$kernel->terminate($request, $response);
