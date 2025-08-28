<?php

require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Lecturer;

echo "Testing office_location fix...\n\n";

// Test creating lecturer with office_location
try {
    $testData = [
        'nidn' => '0123456789',
        'name' => 'Test Office Location',
        'slug' => 'test-office-location',
        'email' => 'testoffice@example.com',
        'gender' => 'male',
        'position' => 'Asisten Ahli',
        'office_location' => 'Ruang 101, Gedung A',
        'is_active' => true
    ];
    
    echo "Creating lecturer with office_location:\n";
    print_r($testData);
    
    $lecturer = Lecturer::create($testData);
    echo "✅ Lecturer created successfully with ID: {$lecturer->id}\n";
    echo "✅ Office location saved: " . ($lecturer->office_location ?: 'NULL') . "\n";
    
    // Test update
    $lecturer->update([
        'office_location' => 'Ruang 202, Gedung B'
    ]);
    
    $updatedLecturer = Lecturer::find($lecturer->id);
    echo "✅ Office location updated: {$updatedLecturer->office_location}\n";
    
    // Clean up
    $lecturer->delete();
    echo "✅ Test lecturer deleted\n";
    
} catch(Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
