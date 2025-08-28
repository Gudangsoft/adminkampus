<?php

require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Lecturer;

// Test creating a lecturer with NIDN
echo "Testing Lecturer NIDN functionality...\n\n";

// Check if we can fetch lecturers
$lecturers = Lecturer::limit(3)->get();
echo "Found " . $lecturers->count() . " lecturers:\n";
foreach($lecturers as $lecturer) {
    echo "- Name: {$lecturer->name}\n";
    echo "  NIDN: " . ($lecturer->nidn ?: 'NULL') . "\n";
    echo "  Email: " . ($lecturer->email ?: 'NULL') . "\n\n";
}

// Test creating new lecturer
try {
    $testData = [
        'nidn' => '0123456789',
        'name' => 'Test Lecturer',
        'slug' => 'test-lecturer',
        'email' => 'test@example.com',
        'gender' => 'male',
        'position' => 'Asisten Ahli',
        'is_active' => true
    ];
    
    echo "Testing lecturer creation with data:\n";
    print_r($testData);
    
    $lecturer = Lecturer::create($testData);
    echo "✅ Lecturer created successfully with ID: {$lecturer->id}\n";
    echo "✅ NIDN saved: {$lecturer->nidn}\n";
    
    // Clean up
    $lecturer->delete();
    echo "✅ Test lecturer deleted\n";
    
} catch(Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
