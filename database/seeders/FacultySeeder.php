<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Faculty;
use App\Models\StudyProgram;

class FacultySeeder extends Seeder
{
    public function run()
    {
        // Fakultas Teknik
        $teknik = Faculty::create([
            'name' => 'Fakultas Teknik',
            'slug' => 'fakultas-teknik',
            'description' => 'Fakultas Teknik yang menghasilkan sarjana teknik berkualitas dengan keahlian di bidang teknologi terkini.',
            'dean_name' => 'Prof. Dr. Ir. Budi Santoso, M.T.',
            'phone' => '+62 21 1234 5001',
            'email' => 'teknik@g0-campus.ac.id',
            'is_active' => true,
            'sort_order' => 1
        ]);

        // Program Studi Fakultas Teknik
        StudyProgram::create([
            'name' => 'Teknik Informatika',
            'slug' => 'teknik-informatika',
            'faculty_id' => $teknik->id,
            'degree' => 'S1',
            'description' => 'Program studi yang fokus pada pengembangan software, sistem informasi, dan teknologi komputer.',
            'accreditation' => 'A',
            'accreditation_year' => 2023,
            'head_of_program' => 'Dr. Eng. Sari Wijayanti, M.Kom.',
            'credit_total' => 144,
            'semester_total' => 8,
            'career_prospects' => [
                'Software Engineer',
                'System Analyst',
                'Database Administrator',
                'Web Developer',
                'Mobile App Developer',
                'Data Scientist'
            ],
            'facilities' => [
                'Laboratorium Komputer',
                'Laboratorium Jaringan',
                'Laboratorium Mobile Programming',
                'Studio Multimedia'
            ],
            'email' => 'informatika@g0-campus.ac.id',
            'is_active' => true,
            'sort_order' => 1
        ]);

        StudyProgram::create([
            'name' => 'Teknik Elektro',
            'slug' => 'teknik-elektro',
            'faculty_id' => $teknik->id,
            'degree' => 'S1',
            'description' => 'Program studi yang mempelajari sistem kelistrikan, elektronika, dan telekomunikasi.',
            'accreditation' => 'B',
            'accreditation_year' => 2022,
            'head_of_program' => 'Dr. Ahmad Fauzi, M.T.',
            'credit_total' => 144,
            'semester_total' => 8,
            'career_prospects' => [
                'Electrical Engineer',
                'Control System Engineer',
                'Telecommunications Engineer',
                'Power System Engineer'
            ],
            'facilities' => [
                'Laboratorium Elektronika',
                'Laboratorium Telekomunikasi',
                'Laboratorium Sistem Tenaga'
            ],
            'email' => 'elektro@g0-campus.ac.id',
            'is_active' => true,
            'sort_order' => 2
        ]);

        // Fakultas Ekonomi dan Bisnis
        $ekonomi = Faculty::create([
            'name' => 'Fakultas Ekonomi dan Bisnis',
            'slug' => 'fakultas-ekonomi-dan-bisnis',
            'description' => 'Fakultas yang menghasilkan lulusan dengan kompetensi tinggi di bidang ekonomi dan bisnis.',
            'dean_name' => 'Prof. Dr. Eko Prasetyo, M.M.',
            'phone' => '+62 21 1234 5002',
            'email' => 'ekonomi@g0-campus.ac.id',
            'is_active' => true,
            'sort_order' => 2
        ]);

        StudyProgram::create([
            'name' => 'Manajemen',
            'slug' => 'manajemen',
            'faculty_id' => $ekonomi->id,
            'degree' => 'S1',
            'description' => 'Program studi yang mempelajari ilmu manajemen organisasi, keuangan, dan strategi bisnis.',
            'accreditation' => 'A',
            'accreditation_year' => 2023,
            'head_of_program' => 'Dr. Rina Susanti, M.M.',
            'credit_total' => 144,
            'semester_total' => 8,
            'career_prospects' => [
                'Manager',
                'Business Analyst',
                'Marketing Manager',
                'HR Manager',
                'Financial Manager',
                'Entrepreneur'
            ],
            'facilities' => [
                'Laboratorium Komputer Bisnis',
                'Trading Floor Simulation',
                'Business Incubator'
            ],
            'email' => 'manajemen@g0-campus.ac.id',
            'is_active' => true,
            'sort_order' => 1
        ]);

        StudyProgram::create([
            'name' => 'Akuntansi',
            'slug' => 'akuntansi',
            'faculty_id' => $ekonomi->id,
            'degree' => 'S1',
            'description' => 'Program studi yang fokus pada ilmu akuntansi, audit, dan sistem informasi akuntansi.',
            'accreditation' => 'A',
            'accreditation_year' => 2022,
            'head_of_program' => 'Dr. Bambang Sutrisno, M.Ak.',
            'credit_total' => 144,
            'semester_total' => 8,
            'career_prospects' => [
                'Akuntan',
                'Auditor',
                'Tax Consultant',
                'Financial Analyst',
                'Budget Analyst'
            ],
            'facilities' => [
                'Laboratorium Akuntansi',
                'Software Akuntansi',
                'Perpustakaan Khusus'
            ],
            'email' => 'akuntansi@g0-campus.ac.id',
            'is_active' => true,
            'sort_order' => 2
        ]);

        // Fakultas Ilmu Sosial dan Politik
        $fisip = Faculty::create([
            'name' => 'Fakultas Ilmu Sosial dan Politik',
            'slug' => 'fakultas-ilmu-sosial-dan-politik',
            'description' => 'Fakultas yang mengembangkan ilmu sosial dan politik untuk kemajuan masyarakat.',
            'dean_name' => 'Prof. Dr. Siti Nurhaliza, M.A.',
            'phone' => '+62 21 1234 5003',
            'email' => 'fisip@g0-campus.ac.id',
            'is_active' => true,
            'sort_order' => 3
        ]);

        StudyProgram::create([
            'name' => 'Ilmu Komunikasi',
            'slug' => 'ilmu-komunikasi',
            'faculty_id' => $fisip->id,
            'degree' => 'S1',
            'description' => 'Program studi yang mempelajari teori dan praktik komunikasi di berbagai media.',
            'accreditation' => 'B',
            'accreditation_year' => 2023,
            'head_of_program' => 'Dr. Maya Kusuma, M.I.Kom.',
            'credit_total' => 144,
            'semester_total' => 8,
            'career_prospects' => [
                'Jurnalis',
                'Public Relations',
                'Content Creator',
                'Media Planner',
                'Broadcasting'
            ],
            'facilities' => [
                'Studio Radio',
                'Studio TV',
                'Laboratorium Multimedia',
                'News Room'
            ],
            'email' => 'komunikasi@g0-campus.ac.id',
            'is_active' => true,
            'sort_order' => 1
        ]);
    }
}
