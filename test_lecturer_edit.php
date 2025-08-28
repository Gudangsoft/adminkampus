<?php

require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Lecturer;

echo "Testing Edit Form Data Retrieval...\n\n";

// Create a test lecturer with NIDN
$testData = [
    'nidn' => '0987654321',
    'name' => 'Test Edit Lecturer',
    'slug' => 'test-edit-lecturer',
    'email' => 'testedit@example.com',
    'gender' => 'female',
    'position' => 'Lektor',
    'phone' => '081234567890',
    'education_background' => 'S3 Informatika',
    'is_active' => true
];

echo "Creating test lecturer with data:\n";
print_r($testData);

$lecturer = Lecturer::create($testData);
echo "✅ Test lecturer created with ID: {$lecturer->id}\n\n";

// Retrieve lecturer (simulating edit form)
$retrievedLecturer = Lecturer::find($lecturer->id);
echo "Retrieved lecturer data:\n";
echo "- ID: {$retrievedLecturer->id}\n";
echo "- NIDN: " . ($retrievedLecturer->nidn ?: 'NULL') . "\n";
echo "- Name: {$retrievedLecturer->name}\n";
echo "- Email: {$retrievedLecturer->email}\n";
echo "- Gender: {$retrievedLecturer->gender}\n";
echo "- Position: {$retrievedLecturer->position}\n";
echo "- Phone: " . ($retrievedLecturer->phone ?: 'NULL') . "\n";
echo "- Education: " . ($retrievedLecturer->education_background ?: 'NULL') . "\n";
echo "- Status: " . ($retrievedLecturer->is_active ? 'Active' : 'Inactive') . "\n\n";

// Test update
echo "Testing update...\n";
$retrievedLecturer->update([
    'nidn' => '1111111111',
    'phone' => '087654321098'
]);

$updatedLecturer = Lecturer::find($lecturer->id);
echo "After update:\n";
echo "- NIDN: {$updatedLecturer->nidn}\n";
echo "- Phone: {$updatedLecturer->phone}\n";
echo "✅ Update successful!\n\n";

// Clean up
$lecturer->delete();
echo "✅ Test lecturer deleted\n";
