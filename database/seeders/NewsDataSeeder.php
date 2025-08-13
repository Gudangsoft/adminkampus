<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\User;

class NewsDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();
        $academicCategory = NewsCategory::where('slug', 'akademik')->first();
        $generalCategory = NewsCategory::where('slug', 'berita-umum')->first();
        $studentCategory = NewsCategory::where('slug', 'kemahasiswaan')->first();

        // Create sample news
        News::create([
            'title' => 'Penerimaan Mahasiswa Baru Tahun 2025',
            'slug' => 'penerimaan-mahasiswa-baru-tahun-2025',
            'excerpt' => 'Universitas membuka pendaftaran mahasiswa baru untuk tahun akademik 2025/2026',
            'content' => '<p>Universitas dengan bangga mengumumkan pembukaan pendaftaran mahasiswa baru untuk tahun akademik 2025/2026. Pendaftaran dibuka untuk berbagai program studi unggulan.</p>',
            'category_id' => $academicCategory->id,
            'user_id' => $user->id,
            'status' => 'published',
            'is_featured' => true,
            'views' => 150,
            'published_at' => now()->subDays(5)
        ]);

        News::create([
            'title' => 'Seminar Nasional Teknologi dan Inovasi',
            'slug' => 'seminar-nasional-teknologi-dan-inovasi',
            'excerpt' => 'Event tahunan yang menghadirkan para ahli teknologi terkemuka',
            'content' => '<p>Seminar nasional teknologi dan inovasi akan diadakan pada tanggal 25 Agustus 2025. Event ini menghadirkan pembicara dari berbagai universitas dan industri teknologi.</p>',
            'category_id' => $generalCategory->id,
            'user_id' => $user->id,
            'status' => 'published',
            'is_featured' => true,
            'views' => 89,
            'published_at' => now()->subDays(3)
        ]);

        News::create([
            'title' => 'Prestasi Mahasiswa dalam Olimpiade Sains',
            'slug' => 'prestasi-mahasiswa-dalam-olimpiade-sains',
            'excerpt' => 'Tim mahasiswa meraih juara pertama dalam kompetisi sains tingkat nasional',
            'content' => '<p>Tim mahasiswa dari Fakultas Teknik berhasil meraih juara pertama dalam Olimpiade Sains Nasional. Prestasi ini membanggakan dan menunjukkan kualitas pendidikan di universitas.</p>',
            'category_id' => $studentCategory->id,
            'user_id' => $user->id,
            'status' => 'published',
            'is_featured' => false,
            'views' => 67,
            'published_at' => now()->subDays(1)
        ]);

        News::create([
            'title' => 'Workshop Digital Marketing untuk Mahasiswa',
            'slug' => 'workshop-digital-marketing-untuk-mahasiswa',
            'excerpt' => 'Pelatihan gratis digital marketing khusus untuk mahasiswa',
            'content' => '<p>Universitas mengadakan workshop digital marketing gratis untuk semua mahasiswa. Workshop ini bertujuan meningkatkan skill digital mahasiswa dalam era teknologi.</p>',
            'category_id' => $studentCategory->id,
            'user_id' => $user->id,
            'status' => 'published',
            'is_featured' => false,
            'views' => 45,
            'published_at' => now()
        ]);
    }
}
