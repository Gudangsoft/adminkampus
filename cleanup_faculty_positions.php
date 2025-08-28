<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== CLEANING FACULTY-RELATED POSITIONS ===\n\n";

// Check for faculty-related positions
$facultyPositions = \App\Models\StructuralPosition::where(function($query) {
    $query->where('name', 'like', '%fakultas%')
          ->orWhere('name', 'like', '%dekan%')
          ->orWhere('name', 'like', '%direktur%')
          ->orWhere('category', 'Direktur');
})->get();

echo "Faculty-related positions found: " . $facultyPositions->count() . "\n\n";

foreach ($facultyPositions as $position) {
    echo "- {$position->name} ({$position->category})\n";
    
    // Check if any lecturers are assigned to this position
    $assignedLecturers = \App\Models\Lecturer::where('structural_position_id', $position->id)->get();
    
    if ($assignedLecturers->count() > 0) {
        echo "  Assigned lecturers: " . $assignedLecturers->count() . "\n";
        foreach ($assignedLecturers as $lecturer) {
            echo "    - {$lecturer->name}\n";
            
            // Remove structural position from lecturer
            $lecturer->update([
                'structural_position_id' => null,
                'structural_description' => null,
                'structural_start_date' => null,
                'structural_end_date' => null
            ]);
            echo "    ✓ Removed structural position from {$lecturer->name}\n";
        }
    } else {
        echo "  No assigned lecturers\n";
    }
    
    // Deactivate or delete the position
    $position->update(['is_active' => false]);
    echo "  ✓ Deactivated position: {$position->name}\n\n";
}

// Also check HomeController for any hardcoded faculty references
echo "=== CHECKING HOMECONTROLLER FOR FACULTY REFERENCES ===\n\n";

$homeControllerContent = file_get_contents('app/Http/Controllers/HomeController.php');

$facultyReferences = [
    'Dekan Fakultas',
    'Wakil Dekan',
    'fakultas',
    'Direktur', // This might be used in some institutions as faculty dean
];

$foundReferences = [];
foreach ($facultyReferences as $ref) {
    if (stripos($homeControllerContent, $ref) !== false) {
        $foundReferences[] = $ref;
    }
}

if (!empty($foundReferences)) {
    echo "Faculty references found in HomeController:\n";
    foreach ($foundReferences as $ref) {
        echo "- {$ref}\n";
    }
} else {
    echo "✓ No faculty references found in HomeController\n";
}

echo "\n=== FINAL STATUS ===\n\n";

// Show remaining active positions
$activePositions = \App\Models\StructuralPosition::where('is_active', true)->get();
echo "Remaining active structural positions: " . $activePositions->count() . "\n\n";

foreach ($activePositions as $position) {
    $lecturerCount = \App\Models\Lecturer::where('structural_position_id', $position->id)
        ->where('is_active', true)
        ->count();
    echo "- {$position->name} ({$position->category}): {$lecturerCount} lecturer(s)\n";
}

echo "\n=== CLEANUP COMPLETED ===\n";
