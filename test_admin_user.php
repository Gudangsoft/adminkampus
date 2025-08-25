<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

// Boot the application
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Checking admin user...\n";

// Check if admin user exists
$admin = App\Models\User::where('email', 'admin@g0campus.ac.id')->first();

if ($admin) {
    echo "Admin user found:\n";
    echo "ID: " . $admin->id . "\n";
    echo "Name: " . $admin->name . "\n";
    echo "Email: " . $admin->email . "\n";
    echo "Role: " . $admin->role . "\n";
} else {
    echo "Admin user not found. Creating...\n";
    
    $admin = App\Models\User::create([
        'name' => 'Administrator',
        'email' => 'admin@g0campus.ac.id',
        'email_verified_at' => now(),
        'password' => Hash::make('admin123'),
        'role' => 'admin',
    ]);
    
    echo "Admin user created:\n";
    echo "Email: admin@g0campus.ac.id\n";
    echo "Password: admin123\n";
}

echo "\nTesting students data...\n";

// Check students count
$studentsCount = App\Models\Student::count();
echo "Students count: $studentsCount\n";

if ($studentsCount === 0) {
    echo "No students found. Creating sample data...\n";
    
    // Check if study programs exist
    $studyProgram = App\Models\StudyProgram::first();
    if (!$studyProgram) {
        echo "Creating study program...\n";
        $studyProgram = App\Models\StudyProgram::create([
            'name' => 'Teknik Informatika',
            'slug' => 'teknik-informatika',
            'code' => 'TI',
            'degree' => 'S1',
            'description' => 'Program Studi Teknik Informatika',
            'is_active' => true,
            'order' => 1,
        ]);
    }
    
    // Create sample students
    for ($i = 1; $i <= 5; $i++) {
        App\Models\Student::create([
            'nim' => '2024010' . str_pad($i, 3, '0', STR_PAD_LEFT),
            'name' => 'Student ' . $i,
            'slug' => 'student-' . $i,
            'study_program_id' => $studyProgram->id,
            'entry_year' => 2024,
            'gender' => $i % 2 === 0 ? 'female' : 'male',
            'is_active' => true,
        ]);
    }
    
    echo "Created 5 sample students\n";
}

echo "Setup complete!\n";
