<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Lecturer;

echo "Testing lecturer show page...\n";

try {
    $lecturer = Lecturer::with(['faculty', 'studyPrograms'])->find(6);
    
    if (!$lecturer) {
        echo "Lecturer 6 not found\n";
        exit;
    }
    
    echo "Name: " . $lecturer->name . "\n";
    echo "Full Name: " . $lecturer->full_name . "\n";
    echo "NIDN: " . $lecturer->nidn . "\n";
    echo "Position: " . $lecturer->position . "\n";
    echo "Position Label: " . $lecturer->position_label . "\n";
    echo "Faculty: " . $lecturer->faculty->name . "\n";
    echo "Study Programs: " . $lecturer->studyPrograms->count() . "\n";
    echo "Photo URL: " . substr($lecturer->photo_url, 0, 50) . "...\n";
    echo "Active: " . ($lecturer->is_active ? 'Yes' : 'No') . "\n";
    
    echo "\nAll accessors work fine!\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Line: " . $e->getLine() . "\n";
    echo "File: " . $e->getFile() . "\n";
}

echo "Test completed.\n";
