<?php

namespace Database\Seeders;

use App\Models\Slider;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Clear existing sliders
        Slider::truncate();

        $sliders = [
            [
                'title' => 'Selamat Datang di Universitas G0-CAMPUS',
                'description' => 'Universitas terkemuka yang menghasilkan lulusan berkualitas dengan fasilitas modern dan tenaga pengajar profesional.',
                'image' => 'https://images.unsplash.com/photo-1562774053-701939374585?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80',
                'link' => '/tentang',
                'link_target' => '_self',
                'button_text' => 'Tentang Kami',
                'is_active' => true,
                'sort_order' => 1
            ],
            [
                'title' => 'Program Studi Unggulan',
                'description' => 'Dapatkan pendidikan terbaik dengan 15+ program studi yang terakreditasi dan siap menghadapi tantangan dunia kerja.',
                'image' => 'https://images.unsplash.com/photo-1523050854058-8df90110c9d1?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80',
                'link' => '/program-studi',
                'link_target' => '_self',
                'button_text' => 'Lihat Program Studi',
                'is_active' => true,
                'sort_order' => 2
            ],
            [
                'title' => 'Fasilitas Modern & Lengkap',
                'description' => 'Nikmati pengalaman belajar dengan fasilitas laboratorium canggih, perpustakaan digital, dan ruang kuliah berteknologi tinggi.',
                'image' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80',
                'link' => '/fasilitas',
                'link_target' => '_self',
                'button_text' => 'Jelajahi Fasilitas',
                'is_active' => true,
                'sort_order' => 3
            ],
            [
                'title' => 'Prestasi Mahasiswa Membanggakan',
                'description' => 'Mahasiswa G0-CAMPUS terus berprestasi di tingkat nasional dan internasional dalam berbagai bidang kompetisi.',
                'image' => 'https://images.unsplash.com/photo-1599008633840-052c7f756385?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80',
                'link' => '/galeri?category=prestasi',
                'link_target' => '_self',
                'button_text' => 'Lihat Prestasi',
                'is_active' => true,
                'sort_order' => 4
            ],
            [
                'title' => 'Pendaftaran Mahasiswa Baru 2025',
                'description' => 'Bergabunglah dengan keluarga besar G0-CAMPUS! Pendaftaran mahasiswa baru telah dibuka untuk tahun akademik 2025/2026.',
                'image' => 'https://images.unsplash.com/photo-1517486808906-6ca8b3f04846?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80',
                'link' => '/pendaftaran',
                'link_target' => '_self',
                'button_text' => 'Daftar Sekarang',
                'is_active' => false, // Inactive by default
                'sort_order' => 5
            ]
        ];

        foreach ($sliders as $sliderData) {
            // For this demo, we'll store the image URL directly
            // In real implementation, you might want to download and store the images locally
            Slider::create($sliderData);
        }

        $this->command->info('Created ' . count($sliders) . ' slider items successfully.');
    }
}
