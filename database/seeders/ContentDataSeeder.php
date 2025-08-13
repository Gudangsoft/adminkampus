<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Announcement;
use App\Models\Gallery;
use App\Models\Faculty;
use App\Models\User;

class ContentDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();
        
        // Create sample announcements
        Announcement::create([
            'title' => 'Pengumuman Pendaftaran Mahasiswa Baru',
            'slug' => 'pengumuman-pendaftaran-mahasiswa-baru',
            'content' => 'Pendaftaran mahasiswa baru telah dibuka untuk tahun akademik 2025/2026.',
            'excerpt' => 'Pendaftaran mahasiswa baru dibuka',
            'type' => 'academic',
            'status' => 'active',
            'priority' => 'high',
            'user_id' => $user->id,
            'start_date' => now(),
            'end_date' => now()->addMonths(3),
            'is_featured' => true
        ]);

        Announcement::create([
            'title' => 'Seminar Nasional Teknologi',
            'slug' => 'seminar-nasional-teknologi',
            'content' => 'Akan diadakan seminar nasional teknologi pada tanggal 20 Agustus 2025.',
            'excerpt' => 'Seminar nasional teknologi',
            'type' => 'event',
            'status' => 'active',
            'priority' => 'normal',
            'user_id' => $user->id,
            'start_date' => now(),
            'end_date' => now()->addWeeks(2)
        ]);

        // Create sample faculties
        Faculty::create([
            'name' => 'Fakultas Teknik Informatika',
            'slug' => 'fakultas-teknik-informatika',
            'description' => 'Fakultas yang menghasilkan lulusan berkualitas di bidang teknologi informasi.',
            'code' => 'FTI',
            'dean_name' => 'Prof. Dr. Ahmad Teknik',
            'email' => 'fti@campus.ac.id',
            'phone' => '0271-123456',
            'address' => 'Jl. Kampus No. 1',
            'is_active' => true,
            'sort_order' => 1
        ]);

        Faculty::create([
            'name' => 'Fakultas Ekonomi dan Bisnis',
            'slug' => 'fakultas-ekonomi-dan-bisnis',
            'description' => 'Fakultas yang menghasilkan lulusan di bidang ekonomi dan bisnis.',
            'code' => 'FEB',
            'dean_name' => 'Prof. Dr. Siti Ekonomi',
            'email' => 'feb@campus.ac.id',
            'phone' => '0271-123457',
            'address' => 'Jl. Kampus No. 2',
            'is_active' => true,
            'sort_order' => 2
        ]);

        // Create sample galleries
        Gallery::create([
            'title' => 'Kampus Utama',
            'slug' => 'kampus-utama',
            'description' => 'Foto gedung kampus utama',
            'type' => 'image',
            'file_path' => 'galleries/campus-main.jpg',
            'alt_text' => 'Gedung kampus utama',
            'user_id' => $user->id,
            'is_featured' => true,
            'photographer' => 'Tim Dokumentasi'
        ]);

        Gallery::create([
            'title' => 'Laboratorium Komputer',
            'slug' => 'laboratorium-komputer',
            'description' => 'Fasilitas laboratorium komputer modern',
            'type' => 'image',
            'file_path' => 'galleries/lab-computer.jpg',
            'alt_text' => 'Laboratorium komputer',
            'user_id' => $user->id,
            'is_featured' => true,
            'photographer' => 'Tim Dokumentasi'
        ]);
    }
}
