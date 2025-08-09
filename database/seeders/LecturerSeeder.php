<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Lecturer;
use App\Models\Faculty;

class LecturerSeeder extends Seeder
{
    public function run()
    {
        $faculties = Faculty::all();
        
        if ($faculties->isEmpty()) {
            $this->command->info('No faculties found. Please seed faculties first.');
            return;
        }

        $lecturers = [
            [
                'nidn' => '0101010101',
                'name' => 'Dr. Ahmad Wijaya',
                'gender' => 'male',
                'title_prefix' => 'Dr.',
                'title_suffix' => 'M.Kom., Ph.D.',
                'position' => 'Guru Besar',
                'education_background' => 'S3 Teknik Informatika',
                'expertise' => 'Artificial Intelligence, Machine Learning, Data Mining',
                'biography' => 'Dr. Ahmad Wijaya adalah seorang profesor di bidang Teknik Informatika dengan spesialisasi dalam Artificial Intelligence dan Machine Learning. Beliau telah berpengalaman lebih dari 20 tahun dalam dunia akademis dan penelitian.',
                'email' => 'ahmad.wijaya@kampus.ac.id',
                'phone' => '021-12345678',
                'office_room' => 'R301',
                'google_scholar' => 'https://scholar.google.com/citations?user=example1',
                'is_active' => true,
            ],
            [
                'nidn' => '0202020202',
                'name' => 'Dr. Siti Rahayu',
                'gender' => 'female',
                'title_prefix' => 'Dr.',
                'title_suffix' => 'M.Si.',
                'position' => 'Lektor Kepala',
                'education_background' => 'S3 Matematika',
                'expertise' => 'Statistika, Analisis Data, Matematika Terapan',
                'biography' => 'Dr. Siti Rahayu adalah dosen senior di bidang Matematika dengan fokus penelitian pada Statistika dan Analisis Data. Beliau aktif dalam berbagai penelitian dan publikasi internasional.',
                'email' => 'siti.rahayu@kampus.ac.id',
                'phone' => '021-87654321',
                'office_room' => 'R205',
                'is_active' => true,
            ],
            [
                'nidn' => '0303030303',
                'name' => 'Budi Santoso',
                'gender' => 'male',
                'title_suffix' => 'M.T.',
                'position' => 'Lektor',
                'education_background' => 'S2 Teknik Sipil',
                'expertise' => 'Struktur Bangunan, Manajemen Konstruksi',
                'biography' => 'Budi Santoso, M.T. adalah dosen di bidang Teknik Sipil dengan pengalaman praktis di industri konstruksi sebelum bergabung di dunia akademis.',
                'email' => 'budi.santoso@kampus.ac.id',
                'phone' => '021-11223344',
                'office_room' => 'R102',
                'is_active' => true,
            ],
            [
                'nidn' => '0404040404',
                'name' => 'Maya Kusuma',
                'gender' => 'female',
                'title_suffix' => 'M.Pd.',
                'position' => 'Asisten Ahli',
                'education_background' => 'S2 Pendidikan',
                'expertise' => 'Teknologi Pendidikan, E-Learning, Kurikulum',
                'biography' => 'Maya Kusuma, M.Pd. adalah dosen muda yang fokus pada pengembangan teknologi pendidikan dan implementasi e-learning di perguruan tinggi.',
                'email' => 'maya.kusuma@kampus.ac.id',
                'phone' => '021-99887766',
                'office_room' => 'R108',
                'is_active' => true,
            ],
        ];

        foreach ($lecturers as $lecturerData) {
            // Assign random faculty
            $faculty = $faculties->random();
            $lecturerData['faculty_id'] = $faculty->id;
            $lecturerData['slug'] = \Illuminate\Support\Str::slug($lecturerData['name']);
            
            Lecturer::create($lecturerData);
        }

        $this->command->info('Lecturer seeder completed successfully.');
    }
}
