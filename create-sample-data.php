<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Faculty;
use App\Models\StudyProgram;
use App\Models\Student;
use App\Models\Lecturer;
use App\Models\User;

echo "=== Creating Sample Data ===\n\n";

// Get or create user
$user = User::first();
if (!$user) {
    $user = User::create([
        'name' => 'Admin',
        'email' => 'admin@g0campus.com',
        'password' => bcrypt('password'),
        'email_verified_at' => now(),
    ]);
}

// Create Faculties
$faculties = [
    [
        'name' => 'Fakultas Teknik dan Informatika',
        'slug' => 'fakultas-teknik-dan-informatika',
        'description' => 'Fakultas yang menyelenggarakan program studi di bidang teknik dan informatika dengan standar internasional.',
        'is_active' => true,
        'sort_order' => 1,
    ],
    [
        'name' => 'Fakultas Ekonomi dan Bisnis',
        'slug' => 'fakultas-ekonomi-dan-bisnis',
        'description' => 'Fakultas yang mengkhususkan diri pada pengembangan ilmu ekonomi dan bisnis modern.',
        'is_active' => true,
        'sort_order' => 2,
    ],
    [
        'name' => 'Fakultas Psikologi',
        'slug' => 'fakultas-psikologi',
        'description' => 'Fakultas yang fokus pada pengembangan ilmu psikologi dan kesehatan mental.',
        'is_active' => true,
        'sort_order' => 3,
    ]
];

foreach ($faculties as $facultyData) {
    $faculty = Faculty::updateOrCreate(
        ['slug' => $facultyData['slug']], 
        $facultyData
    );
    echo "Created/Updated faculty: " . $faculty->name . "\n";
}

// Create Study Programs
$studyPrograms = [
    [
        'name' => 'Teknik Informatika',
        'slug' => 'teknik-informatika',
        'description' => 'Program studi yang mempelajari teknologi informasi dan komputer.',
        'degree' => 'S1',
        'accreditation' => 'A',
        'faculty_id' => Faculty::where('slug', 'fakultas-teknik-dan-informatika')->first()->id,
        'is_active' => true,
        'sort_order' => 1,
    ],
    [
        'name' => 'Sistem Informasi',
        'slug' => 'sistem-informasi',
        'description' => 'Program studi yang fokus pada analisis dan pengembangan sistem informasi.',
        'degree' => 'S1',
        'accreditation' => 'A',
        'faculty_id' => Faculty::where('slug', 'fakultas-teknik-dan-informatika')->first()->id,
        'is_active' => true,
        'sort_order' => 2,
    ],
    [
        'name' => 'Manajemen',
        'slug' => 'manajemen',
        'description' => 'Program studi manajemen dengan fokus pada bisnis modern.',
        'degree' => 'S1',
        'accreditation' => 'A',
        'faculty_id' => Faculty::where('slug', 'fakultas-ekonomi-dan-bisnis')->first()->id,
        'is_active' => true,
        'sort_order' => 1,
    ],
    [
        'name' => 'Akuntansi',
        'slug' => 'akuntansi',
        'description' => 'Program studi akuntansi dengan standar internasional.',
        'degree' => 'S1',
        'accreditation' => 'B',
        'faculty_id' => Faculty::where('slug', 'fakultas-ekonomi-dan-bisnis')->first()->id,
        'is_active' => true,
        'sort_order' => 2,
    ],
    [
        'name' => 'Psikologi',
        'slug' => 'psikologi',
        'description' => 'Program studi psikologi klinis dan industri.',
        'degree' => 'S1',
        'accreditation' => 'A',
        'faculty_id' => Faculty::where('slug', 'fakultas-psikologi')->first()->id,
        'is_active' => true,
        'sort_order' => 1,
    ]
];

foreach ($studyPrograms as $programData) {
    $program = StudyProgram::updateOrCreate(
        ['slug' => $programData['slug']], 
        $programData
    );
    echo "Created/Updated study program: " . $program->name . "\n";
}

// Create Students
$students = [
    [
        'name' => 'Budi Santoso',
        'nim' => '20210001',
        'email' => 'budi.santoso@student.g0campus.com',
        'study_program_id' => StudyProgram::where('slug', 'teknik-informatika')->first()->id,
        'entry_year' => 2021,
        'status' => 'active',
        'gender' => 'male',
        'place_of_birth' => 'Jakarta',
        'date_of_birth' => '2003-05-15',
        'phone' => '081234567890',
        'address' => 'Jl. Sudirman No. 123, Jakarta',
    ],
    [
        'name' => 'Sari Dewi',
        'nim' => '20210002',
        'email' => 'sari.dewi@student.g0campus.com',
        'study_program_id' => StudyProgram::where('slug', 'sistem-informasi')->first()->id,
        'entry_year' => 2021,
        'status' => 'active',
        'gender' => 'female',
        'place_of_birth' => 'Bandung',
        'date_of_birth' => '2003-08-20',
        'phone' => '081234567891',
        'address' => 'Jl. Asia Afrika No. 456, Bandung',
    ],
    [
        'name' => 'Ahmad Rahman',
        'nim' => '20200001',
        'email' => 'ahmad.rahman@student.g0campus.com',
        'study_program_id' => StudyProgram::where('slug', 'manajemen')->first()->id,
        'entry_year' => 2020,
        'status' => 'active',
        'gender' => 'male',
        'place_of_birth' => 'Surabaya',
        'date_of_birth' => '2002-03-10',
        'phone' => '081234567892',
        'address' => 'Jl. Pemuda No. 789, Surabaya',
    ]
];

foreach ($students as $studentData) {
    $student = Student::updateOrCreate(
        ['nim' => $studentData['nim']], 
        $studentData
    );
    echo "Created/Updated student: " . $student->name . "\n";
}

echo "\n=== Summary ===\n";
echo "Total faculties: " . Faculty::count() . "\n";
echo "Total study programs: " . StudyProgram::count() . "\n";
echo "Total students: " . Student::count() . "\n";

?>
