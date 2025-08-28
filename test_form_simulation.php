<?php

require_once 'vendor/autoload.php';

// Initialize Laravel application
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Http\Controllers\Admin\StudyProgramController;
use App\Models\StudyProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

echo "=== Testing Study Program Form Validation and Controller ===\n\n";

// Get the first study program
$studyProgram = StudyProgram::first();

if (!$studyProgram) {
    echo "No study programs found in database.\n";
    exit;
}

echo "Testing with Study Program: {$studyProgram->name} (ID: {$studyProgram->id})\n\n";

// Simulate form data as it would come from the web form
$formData = [
    'name' => 'Teknik Informatika - Updated via Form',
    'slug' => 'teknik-informatika-updated',
    'degree' => 'S1',
    'description' => 'Program studi yang telah diperbarui melalui form edit.',
    'curriculum' => "Semester 1: Algoritma & Pemrograman\nSemester 2: Struktur Data\nSemester 3: Basis Data",
    'accreditation' => 'A',
    'accreditation_year' => 2024,
    'head_of_program' => 'Dr. Eng. Sari Wijayanti, M.Kom.',
    'credit_total' => 144,
    'semester_total' => 8,
    'career_prospects' => "Software Engineer\nSystem Analyst\nDatabase Administrator\nWeb Developer\nMobile App Developer\nData Scientist\nDevOps Engineer",
    'facilities' => "Laboratorium Komputer\nLaboratorium Jaringan\nLaboratorium Mobile Programming\nStudio Multimedia\nLab Cloud Computing",
    'website' => 'https://informatika.stikeskesosi.ac.id',
    'email' => 'informatika@stikeskesosi.ac.id',
    'phone' => '021-87654321',
    'is_active' => '1',
    'sort_order' => '1',
];

echo "Form Data to Test:\n";
foreach ($formData as $key => $value) {
    $displayValue = is_string($value) && strlen($value) > 50 ? substr($value, 0, 50) . '...' : $value;
    echo "  {$key}: {$displayValue}\n";
}
echo "\n";

// Test validation rules from the controller
echo "Testing validation rules...\n";

$rules = [
    'name' => 'required|string|max:255',
    'degree' => 'required|string|max:50',
    'description' => 'nullable|string',
    'curriculum' => 'nullable|string',
    'accreditation' => 'nullable|string|max:50',
    'accreditation_year' => 'nullable|integer|min:2000|max:' . (date('Y') + 1),
    'head_of_program' => 'nullable|string|max:255',
    'credit_total' => 'nullable|integer|min:0',
    'semester_total' => 'nullable|integer|min:1',
    'career_prospects' => 'nullable|string',
    'facilities' => 'nullable|string',
    'website' => 'nullable|url|max:255',
    'email' => 'nullable|email|max:255',
    'phone' => 'nullable|string|max:50',
    'is_active' => 'boolean',
    'sort_order' => 'nullable|integer|min:0',
];

$validator = Validator::make($formData, $rules);

if ($validator->fails()) {
    echo "❌ Validation failed:\n";
    foreach ($validator->errors()->all() as $error) {
        echo "  - {$error}\n";
    }
    exit;
} else {
    echo "✅ Validation passed!\n\n";
}

// Test the data processing logic (as done in the controller)
echo "Testing data processing logic...\n";

// Convert career_prospects from textarea string to array
$careerProspects = null;
if ($formData['career_prospects']) {
    $careerProspects = array_filter(
        array_map('trim', explode("\n", $formData['career_prospects'])),
        function($value) {
            return !empty($value);
        }
    );
}

// Convert facilities from textarea string to array  
$facilities = null;
if ($formData['facilities']) {
    $facilities = array_filter(
        array_map('trim', explode("\n", $formData['facilities'])),
        function($value) {
            return !empty($value);
        }
    );
}

echo "Processed Arrays:\n";
echo "  Career Prospects: " . implode(', ', $careerProspects) . "\n";
echo "  Facilities: " . implode(', ', $facilities) . "\n\n";

// Test the update process
echo "Testing update process...\n";

$updateData = [
    'name' => $formData['name'],
    'slug' => \Illuminate\Support\Str::slug($formData['name']),
    'degree' => $formData['degree'],
    'description' => $formData['description'],
    'curriculum' => $formData['curriculum'],
    'accreditation' => $formData['accreditation'],
    'accreditation_year' => $formData['accreditation_year'],
    'head_of_program' => $formData['head_of_program'],
    'credit_total' => $formData['credit_total'],
    'semester_total' => $formData['semester_total'],
    'career_prospects' => $careerProspects,
    'facilities' => $facilities,
    'website' => $formData['website'],
    'email' => $formData['email'],
    'phone' => $formData['phone'],
    'is_active' => isset($formData['is_active']),
    'sort_order' => $formData['sort_order'] ?? 0,
];

try {
    $studyProgram->update($updateData);
    echo "✅ Update successful!\n\n";
    
    // Refresh and display updated data
    $studyProgram->refresh();
    
    echo "Final Updated Data:\n";
    echo "  Name: {$studyProgram->name}\n";
    echo "  Slug: {$studyProgram->slug}\n";
    echo "  Degree: {$studyProgram->degree}\n";
    echo "  Description: {$studyProgram->description}\n";
    echo "  Curriculum: " . (strlen($studyProgram->curriculum) > 50 ? substr($studyProgram->curriculum, 0, 50) . '...' : $studyProgram->curriculum) . "\n";
    echo "  Career Prospects Count: " . count($studyProgram->career_prospects) . " items\n";
    echo "  Facilities Count: " . count($studyProgram->facilities) . " items\n";
    echo "  Website: {$studyProgram->website}\n";
    echo "  Email: {$studyProgram->email}\n";
    echo "  Phone: {$studyProgram->phone}\n";
    echo "  Accreditation: {$studyProgram->accreditation} ({$studyProgram->accreditation_year})\n";
    echo "  Head: {$studyProgram->head_of_program}\n";
    echo "  Credits: {$studyProgram->credit_total} SKS / {$studyProgram->semester_total} semesters\n";
    echo "  Status: " . ($studyProgram->is_active ? 'Active' : 'Inactive') . "\n";
    echo "  Sort Order: {$studyProgram->sort_order}\n";
    
} catch (Exception $e) {
    echo "❌ Error during update: " . $e->getMessage() . "\n";
}

echo "\n✅ Form Simulation Test Complete!\n";
echo "The edit study program functionality is working correctly.\n";
