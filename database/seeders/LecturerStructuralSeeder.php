<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Lecturer;
use App\Models\StudyProgram;
use Illuminate\Support\Str;

class LecturerStructuralSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get some study programs
        $studyPrograms = StudyProgram::take(3)->pluck('id')->toArray();
        $studyProgramIds = json_encode($studyPrograms);

        $lecturers = [
            [
                'name' => 'Prof. Dr. Ahmad Sutrisno, M.Kom',
                'email' => 'rektor@kampus.ac.id',
                'nip' => '198501012008011001',
                'position' => 'Guru Besar',
                'structural_position' => 'Rektor',
                'structural_description' => 'Memimpin dan mengelola seluruh aktivitas universitas, mengembangkan visi misi universitas, dan membangun kerjasama strategis.',
                'structural_start_date' => '2020-01-01',
                'structural_end_date' => '2024-12-31',
                'bio' => 'Rektor dengan pengalaman lebih dari 20 tahun dalam bidang teknologi informasi dan pendidikan tinggi.',
                'study_program_ids' => $studyProgramIds,
                'is_active' => true,
            ],
            [
                'name' => 'Dr. Siti Nurhaliza, M.T',
                'email' => 'wakilrektor1@kampus.ac.id',
                'nip' => '198702152009122002',
                'position' => 'Lektor Kepala',
                'structural_position' => 'Wakil Rektor I',
                'structural_description' => 'Mengawasi bidang akademik, kurikulum, dan pengembangan program studi.',
                'structural_start_date' => '2021-01-01',
                'structural_end_date' => '2024-12-31',
                'bio' => 'Wakil Rektor I dengan spesialisasi dalam pengembangan kurikulum dan manajemen akademik.',
                'study_program_ids' => $studyProgramIds,
                'is_active' => true,
            ],
            [
                'name' => 'Prof. Dr. Budi Santoso, M.Sc',
                'email' => 'wakilrektor2@kampus.ac.id',
                'nip' => '198603102010011003',
                'position' => 'Guru Besar',
                'structural_position' => 'Wakil Rektor II',
                'structural_description' => 'Mengelola administrasi umum, keuangan, dan sumber daya manusia.',
                'structural_start_date' => '2021-01-01',
                'structural_end_date' => '2024-12-31',
                'bio' => 'Wakil Rektor II dengan keahlian dalam manajemen keuangan dan administrasi perguruan tinggi.',
                'study_program_ids' => $studyProgramIds,
                'is_active' => true,
            ],
            [
                'name' => 'Dr. Eng. Andi Wijaya, M.T',
                'email' => 'wakilrektor3@kampus.ac.id',
                'nip' => '198804202011011004',
                'position' => 'Lektor Kepala',
                'structural_position' => 'Wakil Rektor III',
                'structural_description' => 'Mengembangkan kemahasiswaan, alumni, dan kerjasama eksternal.',
                'structural_start_date' => '2021-01-01',
                'structural_end_date' => '2024-12-31',
                'bio' => 'Wakil Rektor III dengan fokus pada pengembangan soft skills mahasiswa dan networking alumni.',
                'study_program_ids' => $studyProgramIds,
                'is_active' => true,
            ],
            [
                'name' => 'Dr. Maya Sari, M.Kom',
                'email' => 'dekan.teknik@kampus.ac.id',
                'nip' => '198505152012012005',
                'position' => 'Lektor Kepala',
                'structural_position' => 'Dekan Fakultas Teknik',
                'structural_description' => 'Memimpin dan mengelola Fakultas Teknik, mengembangkan program studi teknik.',
                'structural_start_date' => '2022-01-01',
                'structural_end_date' => '2025-12-31',
                'bio' => 'Dekan Fakultas Teknik dengan penelitian utama di bidang rekayasa perangkat lunak.',
                'study_program_ids' => json_encode([1, 2]),
                'is_active' => true,
            ],
            [
                'name' => 'Prof. Dr. Ir. Hendra Gunawan, M.T',
                'email' => 'kaprodi.informatika@kampus.ac.id',
                'nip' => '198506302013011006',
                'position' => 'Guru Besar',
                'structural_position' => 'Ketua Program Studi Teknik Informatika',
                'structural_description' => 'Mengelola program studi Teknik Informatika, mengembangkan kurikulum dan penelitian.',
                'structural_start_date' => '2023-01-01',
                'structural_end_date' => '2025-12-31',
                'bio' => 'Ketua Program Studi dengan spesialisasi Artificial Intelligence dan Computer Vision.',
                'study_program_ids' => json_encode([1]),
                'is_active' => true,
            ],
            [
                'name' => 'Dr. Rina Kusumawati, M.T',
                'email' => 'kaprodi.sipil@kampus.ac.id',
                'nip' => '198707102014012007',
                'position' => 'Lektor Kepala',
                'structural_position' => 'Ketua Program Studi Teknik Sipil',
                'structural_description' => 'Mengelola program studi Teknik Sipil, mengembangkan laboratorium dan praktikum.',
                'structural_start_date' => '2023-01-01',
                'structural_end_date' => '2025-12-31',
                'bio' => 'Ketua Program Studi dengan keahlian dalam konstruksi bangunan dan manajemen proyek.',
                'study_program_ids' => json_encode([2]),
                'is_active' => true,
            ],
            [
                'name' => 'Dr. Fajar Nugroho, M.M',
                'email' => 'kaprodi.manajemen@kampus.ac.id',
                'nip' => '198808152015011008',
                'position' => 'Lektor',
                'structural_position' => 'Ketua Program Studi Manajemen',
                'structural_description' => 'Mengelola program studi Manajemen, mengembangkan kerjasama dengan industri.',
                'structural_start_date' => '2023-01-01',
                'structural_end_date' => '2025-12-31',
                'bio' => 'Ketua Program Studi dengan fokus pada manajemen strategis dan kewirausahaan.',
                'study_program_ids' => json_encode([3]),
                'is_active' => true,
            ],
        ];

        foreach ($lecturers as $lecturer) {
            Lecturer::create($lecturer);
        }
    }
}
