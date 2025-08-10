<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Section;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Section::create([
            'title' => 'Selamat Datang di Kampus Kesehatan Terdepan',
            'subtitle' => 'Membentuk Profesional Kesehatan Masa Depan',
            'content' => 'Bergabunglah dengan institusi pendidikan kesehatan terpercaya yang telah menghasilkan ribuan tenaga kesehatan profesional. Dengan fasilitas modern, kurikulum terkini, dan dosen berpengalaman.',
            'icon' => 'fas fa-hospital',
            'background_color' => '#667eea',
            'text_color' => '#ffffff',
            'type' => 'hero',
            'order' => 1,
            'is_active' => true,
            'link' => '/fakultas',
            'link_text' => 'Lihat Program Studi'
        ]);

        Section::create([
            'title' => 'Fasilitas Modern',
            'subtitle' => 'Laboratorium dan Peralatan Terkini',
            'content' => 'Dilengkapi dengan laboratorium berstandar internasional, perpustakaan digital, simulasi klinis, dan fasilitas pendukung pembelajaran yang memadai untuk mengoptimalkan proses belajar mengajar.',
            'icon' => 'fas fa-microscope',
            'type' => 'feature',
            'order' => 2,
            'is_active' => true,
            'link' => '/fasilitas',
            'link_text' => 'Lihat Fasilitas'
        ]);

        Section::create([
            'title' => 'Mengapa Memilih Kami?',
            'subtitle' => 'Keunggulan yang Membedakan',
            'content' => 'Kami memiliki fasilitas laboratorium modern, dosen berpengalaman di bidangnya, kurikulum yang selalu update dengan perkembangan dunia kesehatan, dan jaringan alumni yang kuat di berbagai rumah sakit terkemuka.',
            'icon' => 'fas fa-star',
            'type' => 'content',
            'order' => 3,
            'is_active' => true
        ]);

        Section::create([
            'title' => 'Program Unggulan',
            'subtitle' => 'Beragam Pilihan Program Studi',
            'content' => 'Tersedia berbagai program studi di bidang kesehatan mulai dari Keperawatan, Kebidanan, Farmasi, Gizi, hingga Teknologi Laboratorium Medis. Semua terakreditasi dan diakui secara nasional.',
            'icon' => 'fas fa-graduation-cap',
            'background_color' => '#e3f2fd',
            'type' => 'content',
            'order' => 4,
            'is_active' => true,
            'link' => '/fakultas',
            'link_text' => 'Lihat Program Studi'
        ]);

        Section::create([
            'title' => 'Siap Bergabung?',
            'subtitle' => 'Mulai Perjalanan Karir Kesehatan Anda',
            'content' => 'Daftar sekarang dan wujudkan cita-cita menjadi tenaga kesehatan profesional. Kami siap membantu Anda mencapai impian tersebut dengan pendidikan berkualitas dan bimbingan yang tepat.',
            'icon' => 'fas fa-user-plus',
            'background_color' => '#f8f9fa',
            'type' => 'cta',
            'order' => 5,
            'is_active' => true,
            'link' => '#',
            'link_text' => 'Daftar Sekarang'
        ]);
    }
}
