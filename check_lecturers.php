<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Check all lecturers with structural positions
try {
    $allLecturers = \App\Models\Lecturer::active()
        ->whereNotNull('structural_position')
        ->get(['name', 'structural_position', 'structural_start_date', 'structural_end_date']);

    echo "All lecturers with structural positions (" . $allLecturers->count() . "):\n\n";
    
    foreach ($allLecturers as $lecturer) {
        echo "- {$lecturer->name}\n";
        echo "  Position: {$lecturer->structural_position}\n";
        echo "  Start: " . ($lecturer->structural_start_date ? $lecturer->structural_start_date->format('Y-m-d') : 'Not set') . "\n";
        echo "  End: " . ($lecturer->structural_end_date ? $lecturer->structural_end_date->format('Y-m-d') : 'Not set') . "\n\n";
    }

    // Show available structural positions
    $positions = \App\Models\Lecturer::whereNotNull('structural_position')->pluck('structural_position')->unique();
    echo "\nAvailable structural positions:\n";
    foreach ($positions as $position) {
        echo "- $position\n";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
