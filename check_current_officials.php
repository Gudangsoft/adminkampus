<?php

require_once 'vendor/autoload.php';

use Illuminate\Foundation\Application;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

echo "=== CHECKING CURRENT STRUCTURAL OFFICIALS ===\n\n";

try {
    $activeLecturers = \App\Models\Lecturer::with('structuralPosition')
        ->whereNotNull('structural_position_id')
        ->where('is_active', true)
        ->get();
        
    echo "Total pejabat struktural aktif: " . $activeLecturers->count() . "\n\n";
    
    foreach($activeLecturers as $lecturer) {
        echo "- {$lecturer->name} ({$lecturer->structuralPosition->name})\n";
    }
    
    echo "\n=== CHECKING GROUPED BY CATEGORY ===\n\n";
    $grouped = $activeLecturers->groupBy('structuralPosition.category');
    
    foreach($grouped as $category => $officials) {
        echo "{$category}: {$officials->count()} pejabat\n";
        foreach($officials as $official) {
            echo "  - {$official->name}\n";
        }
        echo "\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
