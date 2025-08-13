<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\StudyProgram;
use App\Models\Lecturer;
use App\Models\Student;
use App\Models\Faculty;

class AcademicDataSeeder2 extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fti = Faculty::where('code', 'FTI')->first();
        $feb = Faculty::where('code', 'FEB')->first();

        // Get existing study programs
        $tikProgram = StudyProgram::where('code', 'TIK')->first();
        $siProgram = StudyProgram::where('code', 'SI')->first();
        $manajemenProgram = StudyProgram::where('code', 'MAN')->first();

        // Create lecturers only if they don't exist
        if (!Lecturer::where('lecturer_id', '197801012005011001')->exists()) {
            Lecturer::create([
                'lecturer_id' => '197801012005011001',
                'name' => 'Dr. Ahmad Programmer, M.Kom',
                'email' => 'ahmad.prog@campus.ac.id',
                'phone' => '081234567890',
                'address' => 'Jl. Dosen No. 1',
                'gender' => 'male',
                'birth_date' => '1978-01-01',
                'birth_place' => 'Jakarta',
                'faculty_id' => $fti->id,
                'position' => 'lektor',
                'employment_status' => 'tetap',
                'education_level' => 'S3',
                'specialization' => 'Software Engineering',
                'join_date' => '2005-01-01',
                'is_active' => true
            ]);
        }

        if (!Lecturer::where('lecturer_id', '198205152010012002')->exists()) {
            Lecturer::create([
                'lecturer_id' => '198205152010012002',
                'name' => 'Dr. Siti Developer, M.T',
                'email' => 'siti.dev@campus.ac.id',
                'phone' => '081234567891',
                'address' => 'Jl. Dosen No. 2',
                'gender' => 'female',
                'birth_date' => '1982-05-15',
                'birth_place' => 'Bandung',
                'faculty_id' => $fti->id,
                'position' => 'asisten_ahli',
                'employment_status' => 'tetap',
                'education_level' => 'S2',
                'specialization' => 'Data Science',
                'join_date' => '2010-01-01',
                'is_active' => true
            ]);
        }

        if (!Lecturer::where('lecturer_id', '197512102008011003')->exists()) {
            Lecturer::create([
                'lecturer_id' => '197512102008011003',
                'name' => 'Prof. Dr. Budi Manager, M.M',
                'email' => 'budi.mgr@campus.ac.id',
                'phone' => '081234567892',
                'address' => 'Jl. Dosen No. 3',
                'gender' => 'male',
                'birth_date' => '1975-12-10',
                'birth_place' => 'Surabaya',
                'faculty_id' => $feb->id,
                'position' => 'guru_besar',
                'employment_status' => 'tetap',
                'education_level' => 'S3',
                'specialization' => 'Strategic Management',
                'join_date' => '2008-01-01',
                'is_active' => true
            ]);
        }

        // Create students only if they don't exist
        if (!Student::where('student_id', '210001001')->exists()) {
            Student::create([
                'student_id' => '210001001',
                'name' => 'Muhammad Rizki',
                'email' => 'rizki@student.campus.ac.id',
                'phone' => '081234560001',
                'address' => 'Jl. Mahasiswa No. 1',
                'gender' => 'male',
                'birth_date' => '2002-03-15',
                'birth_place' => 'Solo',
                'faculty_id' => $fti->id,
                'study_program_id' => $tikProgram->id,
                'class' => 'TIK-A',
                'entry_year' => 2021,
                'status' => 'active',
                'gpa' => 3.75,
                'semester' => 7
            ]);
        }

        if (!Student::where('student_id', '210001002')->exists()) {
            Student::create([
                'student_id' => '210001002',
                'name' => 'Sari Indah',
                'email' => 'sari@student.campus.ac.id',
                'phone' => '081234560002',
                'address' => 'Jl. Mahasiswa No. 2',
                'gender' => 'female',
                'birth_date' => '2002-07-20',
                'birth_place' => 'Yogyakarta',
                'faculty_id' => $fti->id,
                'study_program_id' => $siProgram->id,
                'class' => 'SI-A',
                'entry_year' => 2021,
                'status' => 'active',
                'gpa' => 3.82,
                'semester' => 7
            ]);
        }

        if (!Student::where('student_id', '220002001')->exists()) {
            Student::create([
                'student_id' => '220002001',
                'name' => 'Andi Pratama',
                'email' => 'andi@student.campus.ac.id',
                'phone' => '081234560003',
                'address' => 'Jl. Mahasiswa No. 3',
                'gender' => 'male',
                'birth_date' => '2003-11-10',
                'birth_place' => 'Semarang',
                'faculty_id' => $feb->id,
                'study_program_id' => $manajemenProgram->id,
                'class' => 'MAN-A',
                'entry_year' => 2022,
                'status' => 'active',
                'gpa' => 3.65,
                'semester' => 5
            ]);
        }

        if (!Student::where('student_id', '230003001')->exists()) {
            Student::create([
                'student_id' => '230003001',
                'name' => 'Dewi Lestari',
                'email' => 'dewi@student.campus.ac.id',
                'phone' => '081234560004',
                'address' => 'Jl. Mahasiswa No. 4',
                'gender' => 'female',
                'birth_date' => '2004-01-25',
                'birth_place' => 'Malang',
                'faculty_id' => $fti->id,
                'study_program_id' => $tikProgram->id,
                'class' => 'TIK-B',
                'entry_year' => 2023,
                'status' => 'active',
                'gpa' => 3.90,
                'semester' => 3
            ]);
        }

        if (!Student::where('student_id', '230003002')->exists()) {
            Student::create([
                'student_id' => '230003002',
                'name' => 'Fajar Nugroho',
                'email' => 'fajar@student.campus.ac.id',
                'phone' => '081234560005',
                'address' => 'Jl. Mahasiswa No. 5',
                'gender' => 'male',
                'birth_date' => '2004-09-12',
                'birth_place' => 'Surakarta',
                'faculty_id' => $feb->id,
                'study_program_id' => $manajemenProgram->id,
                'class' => 'MAN-B',
                'entry_year' => 2023,
                'status' => 'active',
                'gpa' => 3.55,
                'semester' => 3
            ]);
        }
    }
}
