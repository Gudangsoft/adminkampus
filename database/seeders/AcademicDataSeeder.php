<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Faculty;
use App\Models\StudyProgram;
use App\Models\Student;
use App\Models\User;

class AcademicDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create or get admin user
        $user = User::firstOrCreate([
            'email' => 'admin@g0campus.com'
        ], [
            'name' => 'Admin',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);

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
            Faculty::updateOrCreate(
                ['slug' => $facultyData['slug']], 
                $facultyData
            );
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
            StudyProgram::updateOrCreate(
                ['slug' => $programData['slug']], 
                $programData
            );
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
                'phone' => '081234567890',
                'address' => 'Jl. Sudirman No. 123, Jakarta',
                'semester' => 6,
                'gpa' => 3.75,
                'credits_taken' => 120,
            ],
            [
                'name' => 'Sari Dewi',
                'nim' => '20210002',
                'email' => 'sari.dewi@student.g0campus.com',
                'study_program_id' => StudyProgram::where('slug', 'sistem-informasi')->first()->id,
                'entry_year' => 2021,
                'status' => 'active',
                'gender' => 'female',
                'phone' => '081234567891',
                'address' => 'Jl. Asia Afrika No. 456, Bandung',
                'semester' => 6,
                'gpa' => 3.85,
                'credits_taken' => 118,
            ],
            [
                'name' => 'Ahmad Rahman',
                'nim' => '20200001',
                'email' => 'ahmad.rahman@student.g0campus.com',
                'study_program_id' => StudyProgram::where('slug', 'manajemen')->first()->id,
                'entry_year' => 2020,
                'status' => 'active',
                'gender' => 'male',
                'phone' => '081234567892',
                'address' => 'Jl. Pemuda No. 789, Surabaya',
                'semester' => 8,
                'gpa' => 3.60,
                'credits_taken' => 140,
            ],
            [
                'name' => 'Putri Indah',
                'nim' => '20220001',
                'email' => 'putri.indah@student.g0campus.com',
                'study_program_id' => StudyProgram::where('slug', 'akuntansi')->first()->id,
                'entry_year' => 2022,
                'status' => 'active',
                'gender' => 'female',
                'phone' => '081234567893',
                'address' => 'Jl. Malioboro No. 321, Yogyakarta',
                'semester' => 4,
                'gpa' => 3.90,
                'credits_taken' => 80,
            ],
            [
                'name' => 'Andi Pratama',
                'nim' => '20210003',
                'email' => 'andi.pratama@student.g0campus.com',
                'study_program_id' => StudyProgram::where('slug', 'psikologi')->first()->id,
                'entry_year' => 2021,
                'status' => 'active',
                'gender' => 'male',
                'phone' => '081234567894',
                'address' => 'Jl. Veteran No. 654, Makassar',
                'semester' => 6,
                'gpa' => 3.70,
                'credits_taken' => 115,
            ]
        ];

        foreach ($students as $studentData) {
            Student::updateOrCreate(
                ['nim' => $studentData['nim']], 
                $studentData
            );
        }

        $this->command->info('Academic data seeded successfully!');
        $this->command->info('Total faculties: ' . Faculty::count());
        $this->command->info('Total study programs: ' . StudyProgram::count());
        $this->command->info('Total students: ' . Student::count());
    }
}
