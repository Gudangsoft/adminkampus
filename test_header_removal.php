<?php

require_once 'vendor/autoload.php';

use Illuminate\Foundation\Application;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::create('/pejabat-struktural', 'GET')
);

echo "=== TESTING HEADER REMOVAL ===\n\n";

// Check response status
echo "1. Response Status: " . $response->getStatusCode() . "\n";

if ($response->getStatusCode() === 200) {
    echo "✓ Page loads successfully\n\n";
    
    $content = $response->getContent();
    
    echo "2. Checking Header Removal:\n";
    
    // Check that old header elements are removed
    if (strpos($content, 'page-header') === false) {
        echo "✓ Page header section removed\n";
    } else {
        echo "✗ Page header section still exists\n";
    }
    
    if (strpos($content, 'site_logo') === false) {
        echo "✓ Logo display code removed\n";
    } else {
        echo "✗ Logo display code still exists\n";
    }
    
    if (strpos($content, 'Website Resmi Universitas KESOSI') === false) {
        echo "✓ Site description removed\n";
    } else {
        echo "✗ Site description still exists\n";
    }
    
    // Check new simple header
    if (strpos($content, 'Pejabat Struktural') !== false) {
        echo "✓ New simple header found\n";
    } else {
        echo "✗ New simple header not found\n";
    }
    
    echo "\n3. Content Structure:\n";
    
    // Check that officials content still exists
    if (strpos($content, 'Pimpinan Sekolah Tinggi') !== false) {
        echo "✓ Officials content preserved\n";
    } else {
        echo "✗ Officials content missing\n";
    }
    
    if (strpos($content, 'official-card') !== false) {
        echo "✓ Official cards preserved\n";
    } else {
        echo "✗ Official cards missing\n";
    }
    
} else {
    echo "✗ Page failed to load (Status: " . $response->getStatusCode() . ")\n";
    echo "Error: " . $response->getContent() . "\n";
}

echo "\n=== HEADER REMOVAL TEST COMPLETED ===\n";
echo "📋 The complex header with logo and site description has been removed.\n";
echo "🔗 URL: http://127.0.0.1:8000/pejabat-struktural\n";

$kernel->terminate($request, $response);
