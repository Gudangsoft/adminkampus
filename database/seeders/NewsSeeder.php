<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\NewsCategory;
use App\Models\News;

class NewsSeeder extends Seeder
{
    public function run()
    {
        // Create News Categories
        $akademik = NewsCategory::create([
            'name' => 'Akademik',
            'slug' => 'akademik',
            'description' => 'Berita seputar kegiatan akademik kampus',
            'is_active' => true
        ]);

        $kemahasiswaan = NewsCategory::create([
            'name' => 'Kemahasiswaan',
            'slug' => 'kemahasiswaan',
            'description' => 'Berita kegiatan mahasiswa dan organisasi kampus',
            'is_active' => true
        ]);

        $penelitian = NewsCategory::create([
            'name' => 'Penelitian',
            'slug' => 'penelitian',
            'description' => 'Berita penelitian dan inovasi kampus',
            'is_active' => true
        ]);

        $umum = NewsCategory::create([
            'name' => 'Umum',
            'slug' => 'umum',
            'description' => 'Berita umum kampus',
            'is_active' => true
        ]);

        // Create Sample News
        News::create([
            'title' => 'Pembukaan Penerimaan Mahasiswa Baru 2024/2025',
            'slug' => 'pembukaan-penerimaan-mahasiswa-baru-2024-2025',
            'excerpt' => 'G0-CAMPUS membuka pendaftaran mahasiswa baru untuk tahun akademik 2024/2025 dengan berbagai program studi unggulan.',
            'content' => '<p>Universitas G0-CAMPUS dengan bangga mengumumkan pembukaan pendaftaran mahasiswa baru untuk tahun akademik 2024/2025. Kami menawarkan berbagai program studi unggulan yang telah terakreditasi dengan fasilitas modern dan tenaga pengajar berpengalaman.</p><p>Program studi yang tersedia meliputi Teknik Informatika, Teknik Elektro, Manajemen, Akuntansi, dan Ilmu Komunikasi. Setiap program studi dirancang untuk mempersiapkan mahasiswa menghadapi tantangan dunia kerja modern.</p><p>Pendaftaran dibuka mulai tanggal 1 Februari hingga 30 April 2024. Calon mahasiswa dapat mendaftar secara online melalui website resmi kami.</p>',
            'category_id' => $akademik->id,
            'user_id' => 1,
            'status' => 'published',
            'is_featured' => true,
            'published_at' => now(),
            'meta_data' => [
                'meta_title' => 'Pembukaan PMB 2024/2025 - G0-CAMPUS',
                'meta_description' => 'Daftar sekarang! G0-CAMPUS membuka pendaftaran mahasiswa baru 2024/2025 dengan berbagai program studi unggulan dan fasilitas modern.'
            ]
        ]);

        News::create([
            'title' => 'Mahasiswa G0-CAMPUS Raih Juara 1 Kompetisi Teknologi Nasional',
            'slug' => 'mahasiswa-g0-campus-raih-juara-1-kompetisi-teknologi-nasional',
            'excerpt' => 'Tim mahasiswa dari Program Studi Teknik Informatika berhasil meraih juara 1 dalam kompetisi teknologi tingkat nasional.',
            'content' => '<p>Prestasi membanggakan kembali diraih oleh mahasiswa G0-CAMPUS. Tim yang terdiri dari 3 mahasiswa Program Studi Teknik Informatika berhasil meraih juara 1 dalam kompetisi teknologi tingkat nasional yang diselenggarakan di Jakarta.</p><p>Kompetisi yang diikuti oleh lebih dari 100 tim dari seluruh Indonesia ini menguji kemampuan mahasiswa dalam mengembangkan solusi teknologi untuk permasalahan nyata di masyarakat.</p><p>Tim G0-CAMPUS berhasil mengembangkan aplikasi mobile untuk membantu petani dalam monitoring tanaman menggunakan teknologi IoT dan Machine Learning.</p>',
            'category_id' => $kemahasiswaan->id,
            'user_id' => 1,
            'status' => 'published',
            'is_featured' => true,
            'published_at' => now()->subDays(2),
            'views' => 150
        ]);

        News::create([
            'title' => 'Penelitian Dosen G0-CAMPUS Dipublikasikan di Jurnal Internasional',
            'slug' => 'penelitian-dosen-g0-campus-dipublikasikan-di-jurnal-internasional',
            'excerpt' => 'Penelitian tentang artificial intelligence untuk smart city berhasil dipublikasikan di jurnal internasional bereputasi.',
            'content' => '<p>Dr. Eng. Sari Wijayanti, dosen Program Studi Teknik Informatika, berhasil mempublikasikan penelitiannya tentang implementasi artificial intelligence untuk smart city di jurnal internasional bereputasi.</p><p>Penelitian yang dilakukan selama 2 tahun ini mengembangkan sistem cerdas untuk manajemen traffic light yang dapat mengurangi kemacetan hingga 30%.</p><p>Publikasi ini menunjukkan komitmen G0-CAMPUS dalam menghasilkan penelitian berkualitas tinggi yang berdampak pada masyarakat.</p>',
            'category_id' => $penelitian->id,
            'user_id' => 1,
            'status' => 'published',
            'is_featured' => false,
            'published_at' => now()->subDays(5),
            'views' => 89
        ]);

        News::create([
            'title' => 'Kerjasama G0-CAMPUS dengan Industri untuk Program Magang',
            'slug' => 'kerjasama-g0-campus-dengan-industri-untuk-program-magang',
            'excerpt' => 'G0-CAMPUS menjalin kerjasama dengan berbagai perusahaan teknologi terkemuka untuk program magang mahasiswa.',
            'content' => '<p>Dalam upaya meningkatkan kualitas lulusan, G0-CAMPUS menjalin kerjasama strategis dengan berbagai perusahaan teknologi terkemuka untuk program magang mahasiswa.</p><p>Program magang ini akan memberikan kesempatan kepada mahasiswa untuk mendapatkan pengalaman kerja nyata di industri sebelum lulus.</p><p>Beberapa perusahaan yang telah menjalin kerjasama antara lain startup teknologi, perusahaan konsultan IT, dan bank digital terkemuka.</p>',
            'category_id' => $akademik->id,
            'user_id' => 1,
            'status' => 'published',
            'is_featured' => false,
            'published_at' => now()->subDays(7),
            'views' => 67
        ]);

        News::create([
            'title' => 'Workshop Digital Marketing untuk UMKM',
            'slug' => 'workshop-digital-marketing-untuk-umkm',
            'excerpt' => 'Fakultas Ekonomi dan Bisnis mengadakan workshop digital marketing gratis untuk para pelaku UMKM di sekitar kampus.',
            'content' => '<p>Sebagai bentuk pengabdian kepada masyarakat, Fakultas Ekonomi dan Bisnis G0-CAMPUS mengadakan workshop digital marketing gratis untuk para pelaku UMKM di sekitar kampus.</p><p>Workshop yang diikuti oleh 50 peserta ini membahas strategi pemasaran digital yang efektif, penggunaan media sosial untuk bisnis, dan cara meningkatkan penjualan online.</p><p>Kegiatan ini mendapat sambutan positif dari para peserta yang merasa terbantu dalam mengembangkan usaha mereka di era digital.</p>',
            'category_id' => $umum->id,
            'user_id' => 1,
            'status' => 'published',
            'is_featured' => false,
            'published_at' => now()->subDays(10),
            'views' => 43
        ]);
    }
}
