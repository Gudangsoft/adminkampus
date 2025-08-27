<?php

require_once 'vendor/autoload.php';

// Bootstrap aplikasi Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\StructuralPosition;

echo "=== STRUCTURAL POSITIONS DATA ===\n\n";

try {
    $count = StructuralPosition::count();
    echo "Total Structural Positions: $count\n\n";
    
    if ($count > 0) {
        echo "List of Structural Positions:\n";
        echo str_repeat("-", 80) . "\n";
        printf("%-5s %-30s %-15s %-10s %s\n", "ID", "Name", "Category", "Level", "Status");
        echo str_repeat("-", 80) . "\n";
        
        StructuralPosition::orderBy('sort_order')->get()->each(function($position) {
            $status = $position->is_active ? '✅ Active' : '❌ Inactive';
            printf("%-5s %-30s %-15s %-10s %s\n", 
                $position->id, 
                $position->name, 
                $position->category, 
                $position->level, 
                $status
            );
        });
        
        echo str_repeat("-", 80) . "\n";
        
        // Tampilkan per kategori
        echo "\nGrouped by Category:\n";
        $categories = StructuralPosition::orderBy('sort_order')->get()->groupBy('category');
        
        foreach ($categories as $category => $positions) {
            echo "\n📁 $category:\n";
            foreach ($positions as $position) {
                echo "   - {$position->name} (Level {$position->level})\n";
            }
        }
        
    } else {
        echo "❌ No structural positions found in database!\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

echo "\n=== END ===\n";
