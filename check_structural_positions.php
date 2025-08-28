<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== CHECKING STRUCTURAL POSITIONS ===\n\n";

// Check all structural positions
$positions = \App\Models\StructuralPosition::all();
echo "Total Structural Positions: " . $positions->count() . "\n\n";

foreach ($positions as $position) {
    echo "- {$position->name}\n";
    echo "  Category: {$position->category}\n";
    echo "  Level: {$position->level}\n";
    echo "  Description: " . ($position->description ?: 'None') . "\n";
    echo "  Active: " . ($position->is_active ? 'Yes' : 'No') . "\n\n";
}

// Check lecturers with structural positions
echo "\n=== LECTURERS WITH STRUCTURAL POSITIONS ===\n\n";

$lecturers = \App\Models\Lecturer::with('structuralPosition')
    ->whereNotNull('structural_position_id')
    ->where('is_active', true)
    ->get();

echo "Total Lecturers with Structural Positions: " . $lecturers->count() . "\n\n";

foreach ($lecturers as $lecturer) {
    echo "- {$lecturer->name}\n";
    echo "  Position: " . ($lecturer->structuralPosition ? $lecturer->structuralPosition->name : 'None') . "\n";
    echo "  Category: " . ($lecturer->structuralPosition ? $lecturer->structuralPosition->category : 'None') . "\n\n";
}

// Check if LPPM exists
echo "\n=== LPPM POSITIONS ===\n\n";

$lppmPositions = \App\Models\StructuralPosition::where('name', 'like', '%LPPM%')
    ->orWhere('name', 'like', '%Penelitian%')
    ->orWhere('name', 'like', '%Pengabdian%')
    ->get();

if ($lppmPositions->count() > 0) {
    echo "LPPM Related Positions Found:\n";
    foreach ($lppmPositions as $position) {
        echo "- {$position->name} ({$position->category})\n";
    }
} else {
    echo "❌ No LPPM related positions found!\n";
}

echo "\n=== CHECKING FRONTEND DISPLAY ===\n\n";

// Check if structural positions are displayed on frontend
$frontendLecturers = \App\Models\Lecturer::with('structuralPosition')
    ->whereNotNull('structural_position_id')
    ->where('is_active', true)
    ->get();

echo "Lecturers that should appear on frontend: " . $frontendLecturers->count() . "\n\n";

foreach ($frontendLecturers as $lecturer) {
    echo "- {$lecturer->name}: {$lecturer->structuralPosition->name}\n";
}
