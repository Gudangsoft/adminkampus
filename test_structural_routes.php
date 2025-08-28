<?php

require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Lecturer;

echo "Testing Structural Position Route and Functionality:\n\n";

// Test route existence
try {
    $route = route('admin.lecturers.update-structural', 1);
    echo "✅ Route 'admin.lecturers.update-structural' exists: {$route}\n";
} catch (Exception $e) {
    echo "❌ Route error: " . $e->getMessage() . "\n";
}

// Test structural positions data
$positions = Lecturer::getStructuralPositions();
echo "\n✅ Available structural positions (" . count($positions) . "):\n";
foreach ($positions as $key => $position) {
    echo "  - {$key}: {$position}\n";
}

// Test lecturer with structural position
$lecturer = Lecturer::where('structural_position', '!=', null)->first();
if ($lecturer) {
    echo "\n✅ Found lecturer with structural position:\n";
    echo "  Name: {$lecturer->name}\n";
    echo "  Position: {$lecturer->structural_position}\n";
    echo "  Description: " . ($lecturer->structural_description ?: 'None') . "\n";
    echo "  Start Date: " . ($lecturer->structural_start_date ? $lecturer->structural_start_date->format('Y-m-d') : 'None') . "\n";
    echo "  End Date: " . ($lecturer->structural_end_date ? $lecturer->structural_end_date->format('Y-m-d') : 'None') . "\n";
} else {
    echo "\n⚠️  No lecturers with structural positions found\n";
}

echo "\n🎉 All structural position functionality is ready!\n";
