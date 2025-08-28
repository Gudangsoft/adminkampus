<?php

require_once 'vendor/autoload.php';

use Illuminate\Foundation\Application;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::create('/pejabat-struktural', 'GET')
);

echo "=== TESTING HIERARCHICAL ORDER OF STRUCTURAL OFFICIALS ===\n\n";

// Check response status
echo "1. Response Status: " . $response->getStatusCode() . "\n";

if ($response->getStatusCode() === 200) {
    echo "✓ Page loads successfully\n\n";
    
    // Check hierarchy order in content
    $content = $response->getContent();
    
    echo "2. Checking Hierarchical Display Order:\n";
    
    // Define expected hierarchy order
    $hierarchyLabels = [
        'Pimpinan Sekolah Tinggi' => 1,
        'Pimpinan Lembaga' => 2,  
        'Pimpinan Program Studi' => 3,
        'Pimpinan Unit' => 4,
        'Pimpinan Bagian' => 5
    ];
    
    $foundPositions = [];
    
    foreach($hierarchyLabels as $label => $expectedOrder) {
        $position = strpos($content, $label);
        if ($position !== false) {
            $foundPositions[$label] = $position;
            echo "✓ Found: $label (position: $position)\n";
        } else {
            echo "✗ Not found: $label\n";
        }
    }
    
    echo "\n3. Verifying Order Sequence:\n";
    
    if (count($foundPositions) >= 2) {
        $sortedPositions = asort($foundPositions);
        $actualOrder = array_keys($foundPositions);
        
        echo "Actual display order:\n";
        foreach($actualOrder as $index => $label) {
            echo ($index + 1) . ". $label\n";
        }
        
        // Check if order matches hierarchy
        $expectedLabels = array_keys($hierarchyLabels);
        $correctOrder = true;
        
        for($i = 0; $i < count($actualOrder) - 1; $i++) {
            $current = $actualOrder[$i];
            $next = $actualOrder[$i + 1];
            
            if ($hierarchyLabels[$current] > $hierarchyLabels[$next]) {
                $correctOrder = false;
                echo "✗ Wrong order: $current should come before $next\n";
            }
        }
        
        if ($correctOrder) {
            echo "✓ Hierarchy order is correct!\n";
        }
    } else {
        echo "! Not enough categories to verify order\n";
    }
    
    echo "\n4. Additional Checks:\n";
    
    // Check for category icons
    if (strpos($content, 'fas fa-crown') !== false) {
        echo "✓ Crown icon for highest leadership found\n";
    }
    
    if (strpos($content, 'fas fa-building') !== false) {
        echo "✓ Building icon for institutions found\n";
    }
    
    if (strpos($content, 'fas fa-graduation-cap') !== false) {
        echo "✓ Graduation cap icon for study programs found\n";
    }
    
} else {
    echo "✗ Page failed to load (Status: " . $response->getStatusCode() . ")\n";
}

echo "\n=== HIERARCHY TEST COMPLETED ===\n";
echo "📋 URL: http://127.0.0.1:8000/pejabat-struktural\n";
echo "🏛️ Order: Pimpinan Sekolah Tinggi → Pimpinan Lembaga → Pimpinan Program Studi → dll\n";

$kernel->terminate($request, $response);
