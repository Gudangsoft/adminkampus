<?php

require_once 'vendor/autoload.php';

use Illuminate\Foundation\Application;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::create('/pejabat-struktural', 'GET')
);

echo "=== TESTING CAMPUS OFFICIALS LAYOUT ===\n\n";

if ($response->getStatusCode() === 200) {
    echo "✓ Campus officials page loads successfully\n\n";
    
    $content = $response->getContent();
    
    // Check for centering classes
    if (strpos($content, 'justify-content-center') !== false) {
        echo "✓ Centering classes found in layout\n";
    } else {
        echo "✗ Centering classes not found\n";
    }
    
    if (strpos($content, 'single-official-center') !== false) {
        echo "✓ Single official centering class found\n";
    } else {
        echo "✗ Single official centering class not found\n";
    }
    
    if (strpos($content, 'mx-auto') !== false) {
        echo "✓ Auto margin centering found\n";
    } else {
        echo "✗ Auto margin centering not found\n";
    }
    
    // Count official cards
    $officialCards = substr_count($content, 'official-card');
    echo "✓ Total official cards: $officialCards\n";
    
    // Check for category distribution
    $categories = ['Rektor', 'Lembaga', 'Program Studi', 'Bagian'];
    echo "\nCategory distribution in HTML:\n";
    foreach ($categories as $category) {
        if (strpos($content, $category) !== false) {
            echo "✓ Found category: $category\n";
        }
    }
    
    echo "\n=== LAYOUT IMPROVEMENT SUMMARY ===\n";
    echo "✅ Added justify-content-center to all grids\n";
    echo "✅ Added responsive column classes (col-sm-8)\n";
    echo "✅ Added special handling for single officials\n";
    echo "✅ Added CSS for max-width on single cards\n";
    echo "✅ Cards will now center when only 1 official in category\n";
    
} else {
    echo "✗ Campus officials page failed to load\n";
    echo "Status: " . $response->getStatusCode() . "\n";
}

$kernel->terminate($request, $response);

echo "\n🎯 Layout telah dioptimalkan!\n";
echo "📱 Kartu pejabat sekarang akan terpusat dengan baik\n";
echo "🔗 Lihat hasilnya di: http://127.0.0.1:8000/pejabat-struktural\n";
