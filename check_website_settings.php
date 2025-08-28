<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== WEBSITE SETTINGS ===\n\n";

// Check current settings
$siteName = \App\Models\Setting::get('site_name', 'Default Site');
$siteLogo = \App\Models\Setting::get('site_logo', '');
$siteDescription = \App\Models\Setting::get('site_description', '');
$favicon = \App\Models\Setting::get('favicon', '');

echo "Current Website Settings:\n";
echo "- Site Name: {$siteName}\n";
echo "- Site Logo: " . ($siteLogo ?: 'Not set') . "\n";
echo "- Site Description: " . ($siteDescription ?: 'Not set') . "\n";
echo "- Favicon: " . ($favicon ?: 'Not set') . "\n\n";

// Check if logo file exists
if ($siteLogo) {
    $logoPath = public_path($siteLogo);
    if (file_exists($logoPath)) {
        echo "✓ Logo file exists at: {$logoPath}\n";
    } else {
        echo "❌ Logo file not found at: {$logoPath}\n";
    }
}

// Check common logo locations
echo "\nChecking common logo locations:\n";
$commonPaths = [
    'images/logo.png',
    'images/logo.jpg',
    'images/logo.svg',
    'assets/images/logo.png',
    'uploads/logo.png',
    'storage/app/public/logo.png'
];

foreach ($commonPaths as $path) {
    $fullPath = public_path($path);
    if (file_exists($fullPath)) {
        echo "✓ Found logo at: {$path}\n";
    }
}

// Check storage folder for uploaded logos
$storagePath = storage_path('app/public');
if (is_dir($storagePath)) {
    $files = scandir($storagePath);
    $logoFiles = array_filter($files, function($file) {
        return preg_match('/logo\.(png|jpg|jpeg|svg|gif)$/i', $file);
    });
    
    if (!empty($logoFiles)) {
        echo "\nLogos found in storage:\n";
        foreach ($logoFiles as $file) {
            echo "- storage/app/public/{$file}\n";
        }
    }
}

echo "\n=== CHECKING LAYOUT ===\n\n";

// Check main layout file
$layoutPath = resource_path('views/layouts/app.blade.php');
if (file_exists($layoutPath)) {
    echo "✓ Main layout exists: {$layoutPath}\n";
    
    $layoutContent = file_get_contents($layoutPath);
    if (strpos($layoutContent, 'site_logo') !== false || strpos($layoutContent, 'logo') !== false) {
        echo "✓ Layout contains logo references\n";
    } else {
        echo "⚠️  Layout may not contain logo references\n";
    }
} else {
    echo "❌ Main layout not found\n";
}

echo "\n=== COMPLETED ===\n";
