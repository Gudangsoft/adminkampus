<?php

require 'vendor/autoload.php';

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "🎨 Creating Sample Gallery Data...\n\n";

try {
    // Ensure gallery categories exist
    echo "📁 Creating Gallery Categories...\n";
    
    $categories = [
        [
            'name' => 'Kegiatan Kampus',
            'slug' => 'kegiatan-kampus',
            'description' => 'Dokumentasi berbagai kegiatan di kampus',
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'name' => 'Fasilitas',
            'slug' => 'fasilitas',
            'description' => 'Foto-foto fasilitas kampus',
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'name' => 'Wisuda',
            'slug' => 'wisuda',
            'description' => 'Momen wisuda mahasiswa',
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'name' => 'Prestasi',
            'slug' => 'prestasi',
            'description' => 'Dokumentasi prestasi mahasiswa dan dosen',
            'created_at' => now(),
            'updated_at' => now()
        ]
    ];

    foreach ($categories as $category) {
        DB::table('gallery_categories')->updateOrInsert(
            ['slug' => $category['slug']],
            $category
        );
        echo "  ✅ {$category['name']}\n";
    }

    // Get category IDs
    $kegiatanId = DB::table('gallery_categories')->where('slug', 'kegiatan-kampus')->value('id');
    $fasilitasId = DB::table('gallery_categories')->where('slug', 'fasilitas')->value('id');
    $wisudaId = DB::table('gallery_categories')->where('slug', 'wisuda')->value('id');
    $prestasiId = DB::table('gallery_categories')->where('slug', 'prestasi')->value('id');

    echo "\n📸 Creating Sample Gallery Items...\n";

    // Sample galleries with external images
    $galleries = [
        // Foto Kegiatan
        [
            'title' => 'Orientasi Mahasiswa Baru 2024',
            'slug' => 'orientasi-mahasiswa-baru-2024',
            'description' => 'Kegiatan orientasi mahasiswa baru tahun akademik 2024/2025 yang meriah dan penuh semangat.',
            'category_id' => $kegiatanId,
            'type' => 'image',
            'file_path' => 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80',
            'thumbnail' => 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80',
            'alt_text' => 'Mahasiswa baru dalam kegiatan orientasi',
            'is_featured' => true,
            'views' => 145,
            'photographer' => 'Tim Dokumentasi KESOSI',
            'taken_at' => Carbon::now()->subDays(10),
            'user_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'title' => 'Seminar Kesehatan Nasional',
            'slug' => 'seminar-kesehatan-nasional',
            'description' => 'Seminar kesehatan nasional dengan pembicara dari berbagai universitas ternama.',
            'category_id' => $kegiatanId,
            'type' => 'image',
            'file_path' => 'https://images.unsplash.com/photo-1515187029135-18ee286d815b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80',
            'thumbnail' => 'https://images.unsplash.com/photo-1515187029135-18ee286d815b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80',
            'alt_text' => 'Peserta seminar kesehatan',
            'is_featured' => true,
            'views' => 89,
            'photographer' => 'Dr. Ahmad Setiawan',
            'taken_at' => Carbon::now()->subDays(5),
            'user_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ],
        
        // Foto Fasilitas
        [
            'title' => 'Laboratorium Komputer Modern',
            'slug' => 'laboratorium-komputer-modern',
            'description' => 'Fasilitas laboratorium komputer dengan perangkat terkini untuk mendukung pembelajaran.',
            'category_id' => $fasilitasId,
            'type' => 'image',
            'file_path' => 'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2022&q=80',
            'thumbnail' => 'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80',
            'alt_text' => 'Ruang laboratorium komputer',
            'is_featured' => true,
            'views' => 201,
            'photographer' => 'Tim Fasilitas',
            'taken_at' => Carbon::now()->subDays(15),
            'user_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'title' => 'Perpustakaan Digital',
            'slug' => 'perpustakaan-digital',
            'description' => 'Perpustakaan modern dengan koleksi digital dan ruang baca yang nyaman.',
            'category_id' => $fasilitasId,
            'type' => 'image',
            'file_path' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80',
            'thumbnail' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80',
            'alt_text' => 'Interior perpustakaan modern',
            'is_featured' => true,
            'views' => 167,
            'photographer' => 'Tim Fasilitas',
            'taken_at' => Carbon::now()->subDays(20),
            'user_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ],
        
        // Foto Wisuda
        [
            'title' => 'Wisuda Periode I 2024',
            'slug' => 'wisuda-periode-i-2024',
            'description' => 'Upacara wisuda periode I tahun 2024 dengan 150 lulusan terbaik.',
            'category_id' => $wisudaId,
            'type' => 'image',
            'file_path' => 'https://images.unsplash.com/photo-1523289333742-be1143f6b766?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80',
            'thumbnail' => 'https://images.unsplash.com/photo-1523289333742-be1143f6b766?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80',
            'alt_text' => 'Upacara wisuda mahasiswa',
            'is_featured' => true,
            'views' => 324,
            'photographer' => 'Tim Dokumentasi',
            'taken_at' => Carbon::now()->subDays(30),
            'user_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ],
        
        // Video YouTube
        [
            'title' => 'Profil Kampus KESOSI 2024',
            'slug' => 'profil-kampus-kesosi-2024',
            'description' => 'Video profil kampus yang menampilkan fasilitas, kegiatan, dan prestasi KESOSI.',
            'category_id' => $kegiatanId,
            'type' => 'video',
            'file_path' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'thumbnail' => 'https://img.youtube.com/vi/dQw4w9WgXcQ/maxresdefault.jpg',
            'alt_text' => 'Video profil kampus',
            'metadata' => json_encode([
                'video_id' => 'dQw4w9WgXcQ',
                'embed_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                'duration' => '3:32'
            ]),
            'is_featured' => true,
            'views' => 456,
            'photographer' => 'Tim Media KESOSI',
            'taken_at' => Carbon::now()->subDays(7),
            'user_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ],
        
        // Foto Prestasi
        [
            'title' => 'Juara Kompetisi Inovasi Teknologi',
            'slug' => 'juara-kompetisi-inovasi-teknologi',
            'description' => 'Tim mahasiswa KESOSI meraih juara 1 kompetisi inovasi teknologi tingkat nasional.',
            'category_id' => $prestasiId,
            'type' => 'image',
            'file_path' => 'https://images.unsplash.com/photo-1552664730-d307ca884978?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80',
            'thumbnail' => 'https://images.unsplash.com/photo-1552664730-d307ca884978?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80',
            'alt_text' => 'Tim pemenang kompetisi',
            'is_featured' => true,
            'views' => 278,
            'photographer' => 'Panitia Kompetisi',
            'taken_at' => Carbon::now()->subDays(12),
            'user_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ],
        
        // Lebih banyak foto untuk grid
        [
            'title' => 'Kelas Praktikum Anatomi',
            'slug' => 'kelas-praktikum-anatomi',
            'description' => 'Mahasiswa sedang mengikuti praktikum anatomi di laboratorium.',
            'category_id' => $kegiatanId,
            'type' => 'image',
            'file_path' => 'https://images.unsplash.com/photo-1559757148-5c350d0d3c56?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2069&q=80',
            'thumbnail' => 'https://images.unsplash.com/photo-1559757148-5c350d0d3c56?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80',
            'alt_text' => 'Praktikum anatomi',
            'is_featured' => false,
            'views' => 89,
            'photographer' => 'Dr. Sarah Medika',
            'taken_at' => Carbon::now()->subDays(8),
            'user_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]
    ];

    foreach ($galleries as $gallery) {
        DB::table('galleries')->updateOrInsert(
            ['slug' => $gallery['slug']],
            $gallery
        );
        echo "  ✅ {$gallery['title']}\n";
    }

    echo "\n🎉 Sample Gallery Data Created Successfully!\n\n";
    echo "📊 Summary:\n";
    echo "  - Categories: " . count($categories) . "\n";
    echo "  - Gallery Items: " . count($galleries) . "\n";
    echo "  - Featured Items: " . count(array_filter($galleries, fn($g) => $g['is_featured'])) . "\n";
    echo "  - Images: " . count(array_filter($galleries, fn($g) => $g['type'] === 'image')) . "\n";
    echo "  - Videos: " . count(array_filter($galleries, fn($g) => $g['type'] === 'video')) . "\n\n";
    
    echo "🌐 Gallery is now ready to be displayed on the homepage!\n";
    echo "Visit: http://localhost:8000 to see the gallery section.\n\n";

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
