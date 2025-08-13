<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Faculty;
use App\Models\Lecturer;

echo "Testing lecturer creation...\n";

// Get first faculty
$faculty = Faculty::first();
if (!$faculty) {
    echo "No faculty found. Please create a faculty first.\n";
    exit;
}

echo "Using Faculty: " . $faculty->name . "\n";

// Test data
$data = [
    'lecturer_id' => '1234567890',
    'name' => 'Dr. John Doe',
    'email' => 'john.doe@example.com',
    'phone' => '081234567890',
    'gender' => 'male',
    'birth_date' => '1980-01-01',
    'birth_place' => 'Jakarta',
    'faculty_id' => $faculty->id,
    'position' => 'lektor',
    'employment_status' => 'tetap',
    'join_date' => '2020-01-01',
    'is_active' => true
];

try {
    $lecturer = Lecturer::create($data);
    echo "Lecturer created successfully with ID: " . $lecturer->id . "\n";
    echo "Name: " . $lecturer->name . "\n";
    echo "Position: " . $lecturer->position . "\n";
    
    // Clean up
    $lecturer->delete();
    echo "Test lecturer deleted successfully.\n";
    
} catch (Exception $e) {
    echo "Error creating lecturer: " . $e->getMessage() . "\n";
}

echo "Test completed.\n";
