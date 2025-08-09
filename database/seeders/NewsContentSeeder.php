<?php

namespace Database\Seeders;

use Illuminate\            [
                'title' => 'Festival Sains dan Teknologi 2025: Pameran Inovasi Mahasiswa',
                'slug' => 'festival-sains-teknologi-2025-pameran-inovasi-mahasiswa',
                'excerpt' => 'Event tahunan yang menampilkan karya inovasi mahasiswa dari berbagai fakultas, mulai dari robotika hingga aplikasi mobile.',
                'content' => '<p>Festival Sains dan Teknologi 2025 akan segera digelar dengan menampilkan berbagai inovasi dan karya kreatif mahasiswa dari seluruh fakultas.</p><p>Event yang berlangsung selama 3 hari ini akan menampilkan lebih dari 100 karya inovasi dalam bidang teknologi, sains, dan seni.</p>',
                'featured_image' => 'news/science-tech-festival.jpg',
                'is_featured' => true,
                'views' => 543
            ],
            [
                'title' => 'Workshop Digital Marketing untuk UMKM Bersama Mahasiswa',
                'slug' => 'workshop-digital-marketing-umkm-bersama-mahasiswa',
                'excerpt' => 'Program pengabdian masyarakat berupa workshop pemasaran digital gratis untuk pelaku UMKM di sekitar kampus.',
                'content' => '<p>Dalam rangka pengabdian kepada masyarakat, mahasiswa Fakultas Ekonomi dan Bisnis mengadakan workshop digital marketing gratis untuk para pelaku UMKM.</p><p>Workshop ini bertujuan membantu UMKM lokal meningkatkan penjualan melalui platform digital dan media sosial.</p>',
                'featured_image' => 'news/digital-marketing-workshop.jpg',
                'is_featured' => true,
                'views' => 425
            }Seeder;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\User;
use Carbon\Carbon;

class NewsContentSeeder extends Seeder
{
    public function run()
    {
        // Ensure we have a news category
        $category = NewsCategory::firstOrCreate([
            'name' => 'Berita Kampus',
            'slug' => 'berita-kampus'
        ], [
            'description' => 'Berita terkini seputar kehidupan kampus',
            'is_active' => true
        ]);

        // Get admin user
        $admin = User::first();

        // Create featured news with diverse content
        $newsData = [
            [
                'title' => 'Prestasi Gemilang Mahasiswa dalam Kompetisi Nasional Teknologi 2025',
                'slug' => 'prestasi-gemilang-mahasiswa-kompetisi-nasional-teknologi-2025',
                'excerpt' => 'Tim mahasiswa Fakultas Teknik berhasil meraih juara pertama dalam kompetisi inovasi teknologi tingkat nasional dengan menciptakan solusi IoT untuk smart city.',
                'content' => '<p>Tim mahasiswa dari Fakultas Teknik Informatika berhasil menorehkan prestasi membanggakan dengan meraih juara pertama dalam Kompetisi Inovasi Teknologi Nasional 2025 yang diselenggarakan di Jakarta.</p><p>Dengan mengusung tema "Smart City Solutions", tim yang terdiri dari 5 mahasiswa semester 6 ini berhasil mengembangkan sistem monitoring lingkungan berbasis IoT yang dapat memantau kualitas udara, tingkat kebisingan, dan kondisi lalu lintas secara real-time.</p><p>Inovasi ini dinilai sangat relevan dengan kebutuhan kota-kota besar di Indonesia yang sedang mengembangkan konsep smart city. Solusi yang dikembangkan tidak hanya canggih secara teknologi, tetapi juga cost-effective dan mudah diimplementasikan.</p>',
                'featured_image' => 'news/tech-competition-2025.jpg',
                'is_featured' => true,
                'views' => 1250
            ],
            [
                'title' => 'Peluncuran Program Beasiswa Unggulan untuk Mahasiswa Berprestasi',
                'slug' => 'peluncuran-program-beasiswa-unggulan-mahasiswa-berprestasi',
                'excerpt' => 'Universitas meluncurkan program beasiswa unggulan senilai 500 juta rupiah untuk mendukung mahasiswa berprestasi melanjutkan pendidikan ke jenjang yang lebih tinggi.',
                'content' => '<p>Dalam rangka meningkatkan kualitas pendidikan dan memberikan kesempatan yang lebih luas bagi mahasiswa berprestasi, universitas telah meluncurkan Program Beasiswa Unggulan 2025.</p><p>Program ini menyediakan dana beasiswa senilai total 500 juta rupiah yang akan dibagikan kepada 50 mahasiswa terpilih dari berbagai fakultas. Beasiswa ini mencakup biaya kuliah, biaya hidup, dan dana penelitian.</p>',
                'featured_image' => 'news/scholarship-program-2025.jpg',
                'is_featured' => true,
                'views' => 890
            ],
            [
                'title' => 'Kerjasama Internasional dengan Universitas Terkemuka di Eropa',
                'slug' => 'kerjasama-internasional-universitas-terkemuka-eropa',
                'excerpt' => 'Penandatanganan MoU dengan 3 universitas top di Eropa membuka peluang pertukaran mahasiswa dan joint research program.',
                'content' => '<p>Universitas semakin memperkuat jejaring internasionalnya melalui penandatanganan Memorandum of Understanding (MoU) dengan tiga universitas terkemuka di Eropa.</p><p>Kerjasama ini meliputi program pertukaran mahasiswa, joint research, dan dual degree program yang akan memberikan pengalaman internasional berkualitas bagi civitas akademika.</p>',
                'featured_image' => 'news/international-cooperation.jpg',
                'is_featured' => true,
                'views' => 756
            ],
            [
                'title' => 'Festival Sains dan Teknologi 2025: Pameran Inovasi Mahasiswa',
                'slug' => 'festival-sains-teknologi-2025-pameran-inovasi-mahasiswa',
                'excerpt' => 'Event tahunan yang menampilkan karya inovasi mahasiswa dari berbagai fakultas, mulai dari robotika hingga aplikasi mobile.',
                'content' => '<p>Festival Sains dan Teknologi 2025 akan segera digelar dengan menampilkan berbagai inovasi dan karya kreatif mahasiswa dari seluruh fakultas.</p><p>Event yang berlangsung selama 3 hari ini akan menampilkan lebih dari 100 karya inovasi dalam bidang teknologi, sains, dan seni.</p>',
                'featured_image' => 'news/science-tech-festival.jpg',
                'is_featured' => false,
                'views' => 543
            ]
        ];

        foreach ($newsData as $index => $data) {
            News::create([
                'title' => $data['title'],
                'slug' => $data['slug'],
                'excerpt' => $data['excerpt'],
                'content' => $data['content'],
                'featured_image' => $data['featured_image'],
                'news_category_id' => $category->id,
                'user_id' => $admin->id,
                'is_published' => true,
                'is_featured' => $data['is_featured'],
                'published_at' => Carbon::now()->subDays($index),
                'views' => $data['views'],
                'created_at' => Carbon::now()->subDays($index),
                'updated_at' => Carbon::now()->subDays($index)
            ]);
        }

        $this->command->info('Sample news content created successfully!');
    }
}
