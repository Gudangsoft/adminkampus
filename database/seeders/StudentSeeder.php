<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\StudyProgram;
use Illuminate\Support\Str;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $studyPrograms = StudyProgram::all();
        
        if ($studyPrograms->isEmpty()) {
            $this->command->warn('No study programs found. Please run StudyProgramSeeder first.');
            return;
        }

        $studentNames = [
            // Male names
            ['name' => 'Ahmad Rizki Pratama', 'gender' => 'L'],
            ['name' => 'Budi Santoso', 'gender' => 'L'],
            ['name' => 'Dicky Firmansyah', 'gender' => 'L'],
            ['name' => 'Eko Prasetyo', 'gender' => 'L'],
            ['name' => 'Fajar Nugroho', 'gender' => 'L'],
            ['name' => 'Galih Setiawan', 'gender' => 'L'],
            ['name' => 'Hadi Wijaya', 'gender' => 'L'],
            ['name' => 'Indra Kurniawan', 'gender' => 'L'],
            ['name' => 'Joko Susilo', 'gender' => 'L'],
            ['name' => 'Krisna Pradana', 'gender' => 'L'],
            
            // Female names
            ['name' => 'Aisyah Putri Maharani', 'gender' => 'P'],
            ['name' => 'Bella Sari Dewi', 'gender' => 'P'],
            ['name' => 'Citra Anggraini', 'gender' => 'P'],
            ['name' => 'Dewi Sartika', 'gender' => 'P'],
            ['name' => 'Erlina Handayani', 'gender' => 'P'],
            ['name' => 'Fitri Ramadhani', 'gender' => 'P'],
            ['name' => 'Gita Permata Sari', 'gender' => 'P'],
            ['name' => 'Hesti Wulandari', 'gender' => 'P'],
            ['name' => 'Indah Lestari', 'gender' => 'P'],
            ['name' => 'Julia Kartika', 'gender' => 'P'],
        ];

        $cities = [
            'Jakarta', 'Bandung', 'Surabaya', 'Medan', 'Semarang', 
            'Makassar', 'Palembang', 'Tangerang', 'Bekasi', 'Bogor',
            'Depok', 'Yogyakarta', 'Solo', 'Malang', 'Balikpapan'
        ];

        $schools = [
            'SMA Negeri 1 Jakarta', 'SMA Negeri 3 Bandung', 'SMA Negeri 5 Surabaya',
            'SMA Negeri 2 Medan', 'SMA Negeri 1 Semarang', 'SMA Negeri 4 Yogyakarta',
            'SMA Negeri 3 Solo', 'SMA Negeri 2 Malang', 'SMA Negeri 1 Makassar',
            'SMA Negeri 5 Palembang', 'SMA Negeri 3 Tangerang', 'SMA Negeri 2 Bekasi'
        ];

        foreach ($studentNames as $index => $studentData) {
            $entryYear = rand(2020, 2024);
            $currentYear = date('Y');
            $yearsDiff = $currentYear - $entryYear;
            $semester = min(($yearsDiff * 2) + 1, 8);
            
            // Generate NIM: Format -> YYYYPPPP000X (Year + Program + Sequential + Check)
            $studyProgram = $studyPrograms->random();
            $sequential = str_pad($index + 1, 3, '0', STR_PAD_LEFT);
            $programCode = str_pad($studyProgram->id, 2, '0', STR_PAD_LEFT);
            $nim = $entryYear . $programCode . $sequential . rand(1, 9);
            
            $name = $studentData['name'];
            $slug = Str::slug($name);
            
            // Make slug unique
            $counter = 1;
            $originalSlug = $slug;
            while (Student::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }

            Student::create([
                'nim' => $nim,
                'name' => $name,
                'slug' => $slug,
                'study_program_id' => $studyProgram->id,
                'gender' => $studentData['gender'],
                'date_of_birth' => fake()->dateTimeBetween('1998-01-01', '2005-12-31'),
                'place_of_birth' => fake()->randomElement($cities),
                'address' => fake()->address(),
                'phone' => '08' . fake()->numerify('##########'),
                'email' => strtolower(str_replace(' ', '.', $name)) . '@student.kampus.ac.id',
                'parent_name' => ($studentData['gender'] == 'L' ? 'Bapak ' : 'Ibu ') . fake()->name(),
                'parent_phone' => '08' . fake()->numerify('##########'),
                'school_origin' => fake()->randomElement($schools),
                'entry_year' => $entryYear,
                'semester' => $semester,
                'gpa' => fake()->randomFloat(2, 2.5, 4.0),
                'credits_taken' => $semester * rand(18, 24),
                'graduation_date' => $semester >= 8 && rand(0, 1) ? fake()->dateTimeBetween($entryYear + 4 . '-01-01', 'now') : null,
                'status' => $semester >= 8 && rand(0, 1) ? 'graduate' : 'active',
                'is_active' => rand(0, 10) > 1, // 90% active students
            ]);
        }

        $this->command->info('Created ' . count($studentNames) . ' students successfully.');
    }
}
