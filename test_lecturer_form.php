<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Faculty;
use App\Models\Lecturer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

echo "Testing lecturer form validation...\n";

// Get first faculty
$faculty = Faculty::first();
if (!$faculty) {
    echo "No faculty found. Please create a faculty first.\n";
    exit;
}

echo "Using Faculty: " . $faculty->name . "\n";

// Simulate form data
$formData = [
    'nidn' => '1234567890',
    'name' => 'Dr. Jane Smith',
    'title_prefix' => 'Dr.',
    'title_suffix' => 'M.Kom.',
    'gender' => 'female',
    'email' => 'jane.smith@example.com',
    'phone' => '081234567890',
    'faculty_id' => $faculty->id,
    'position' => 'Lektor Kepala',
    'education_background' => 'S3 Teknik Informatika',
    'office_room' => 'R101',
    'google_scholar' => 'https://scholar.google.com/citations?user=abc123',
    'scopus_id' => '123456789',
    'expertise' => 'Machine Learning, AI',
    'biography' => 'Expert in AI and ML',
    'is_active' => '1'
];

// Test validation rules from controller
$rules = [
    'nidn' => 'required|string|unique:lecturers,lecturer_id',
    'name' => 'required|string|max:255',
    'title_prefix' => 'nullable|string|max:50',
    'title_suffix' => 'nullable|string|max:100',
    'gender' => 'required|in:male,female',
    'email' => 'nullable|email|unique:lecturers,email',
    'phone' => 'nullable|string|max:20',
    'faculty_id' => 'required|exists:faculties,id',
    'position' => 'required|in:Asisten Ahli,Lektor,Lektor Kepala,Guru Besar',
    'education_background' => 'nullable|string|max:255',
    'office_room' => 'nullable|string|max:100',
    'google_scholar' => 'nullable|url',
    'scopus_id' => 'nullable|string|max:100',
    'expertise' => 'nullable|string',
    'biography' => 'nullable|string',
    'is_active' => 'boolean',
];

$validator = Validator::make($formData, $rules);

if ($validator->fails()) {
    echo "Validation failed:\n";
    foreach ($validator->errors()->all() as $error) {
        echo "- $error\n";
    }
} else {
    echo "Validation passed!\n";
    
    // Test data transformation
    $data = collect($formData)->except(['nidn'])->toArray();
    
    // Map nidn to lecturer_id
    $data['lecturer_id'] = $formData['nidn'];
    
    // Map position from form format to database format
    $positionMap = [
        'Asisten Ahli' => 'asisten_ahli',
        'Lektor' => 'lektor',
        'Lektor Kepala' => 'lektor_kepala',
        'Guru Besar' => 'guru_besar'
    ];
    $data['position'] = $positionMap[$formData['position']] ?? null;
    
    // Set default values for required fields
    $data['birth_date'] = now()->subYears(30)->format('Y-m-d');
    $data['birth_place'] = 'Jakarta';
    $data['join_date'] = now()->format('Y-m-d');
    $data['employment_status'] = 'tetap';
    $data['is_active'] = isset($formData['is_active']) && $formData['is_active'];
    
    echo "Transformed data:\n";
    print_r($data);
    
    try {
        $lecturer = Lecturer::create($data);
        echo "Lecturer created successfully with ID: " . $lecturer->id . "\n";
        
        // Clean up
        $lecturer->delete();
        echo "Test lecturer deleted successfully.\n";
        
    } catch (Exception $e) {
        echo "Error creating lecturer: " . $e->getMessage() . "\n";
    }
}

echo "Test completed.\n";
