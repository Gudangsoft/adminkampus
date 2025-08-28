<?php

require_once 'vendor/autoload.php';

// Initialize Laravel application
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\StudyProgram;
use Illuminate\Support\Str;

echo "=== Testing Study Program Edit Functionality ===\n\n";

// Get the first study program
$studyProgram = StudyProgram::first();

if (!$studyProgram) {
    echo "No study programs found in database.\n";
    exit;
}

echo "Original Study Program:\n";
echo "Name: {$studyProgram->name}\n";
echo "Degree: {$studyProgram->degree}\n";
echo "Description: {$studyProgram->description}\n";
echo "Career Prospects: " . (is_array($studyProgram->career_prospects) ? implode(', ', $studyProgram->career_prospects) : $studyProgram->career_prospects) . "\n";
echo "Facilities: " . (is_array($studyProgram->facilities) ? implode(', ', $studyProgram->facilities) : $studyProgram->facilities) . "\n";
echo "Email: {$studyProgram->email}\n";
echo "Website: {$studyProgram->website}\n";
echo "Phone: {$studyProgram->phone}\n\n";

// Test data to update
$testData = [
    'name' => 'Teknik Informatika (Updated)',
    'degree' => 'S1',
    'description' => 'Program studi yang fokus pada pengembangan software, sistem informasi, dan teknologi komputer terkini.',
    'curriculum' => 'Kurikulum berbasis industri dengan pendekatan praktis dan teoritis yang seimbang.',
    'accreditation' => 'A',
    'accreditation_year' => 2024,
    'head_of_program' => 'Dr. Eng. Sari Wijayanti, M.Kom.',
    'credit_total' => 144,
    'semester_total' => 8,
    'career_prospects' => [
        'Software Engineer',
        'System Analyst',
        'Database Administrator',
        'Web Developer',
        'Mobile App Developer',
        'Data Scientist',
        'AI Engineer'
    ],
    'facilities' => [
        'Laboratorium Komputer',
        'Laboratorium Jaringan',
        'Laboratorium Mobile Programming',
        'Studio Multimedia',
        'Lab IoT'
    ],
    'website' => 'https://informatika.stikeskesosi.ac.id',
    'email' => 'informatika@stikeskesosi.ac.id',
    'phone' => '021-12345678',
    'is_active' => true,
    'sort_order' => 1,
];

echo "Updating study program with test data...\n";

try {
    $studyProgram->update($testData);
    
    echo "✅ Update successful!\n\n";
    
    // Refresh the model to get updated data
    $studyProgram->refresh();
    
    echo "Updated Study Program:\n";
    echo "Name: {$studyProgram->name}\n";
    echo "Degree: {$studyProgram->degree}\n";
    echo "Description: {$studyProgram->description}\n";
    echo "Curriculum: {$studyProgram->curriculum}\n";
    echo "Career Prospects: " . (is_array($studyProgram->career_prospects) ? implode(', ', $studyProgram->career_prospects) : $studyProgram->career_prospects) . "\n";
    echo "Facilities: " . (is_array($studyProgram->facilities) ? implode(', ', $studyProgram->facilities) : $studyProgram->facilities) . "\n";
    echo "Website: {$studyProgram->website}\n";
    echo "Email: {$studyProgram->email}\n";
    echo "Phone: {$studyProgram->phone}\n";
    echo "Accreditation: {$studyProgram->accreditation} ({$studyProgram->accreditation_year})\n";
    echo "Head of Program: {$studyProgram->head_of_program}\n";
    echo "Credits: {$studyProgram->credit_total} SKS, {$studyProgram->semester_total} semesters\n";
    echo "Status: " . ($studyProgram->is_active ? 'Active' : 'Inactive') . "\n";
    echo "Sort Order: {$studyProgram->sort_order}\n\n";
    
    echo "✅ All fields updated successfully!\n";
    
} catch (Exception $e) {
    echo "❌ Error updating study program: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}

echo "\n=== Test Complete ===\n";
