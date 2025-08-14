<?php

/*
|--------------------------------------------------------------------------  
| Create Test Data for Global Search
|--------------------------------------------------------------------------
| Script untuk membuat sample data untuk testing search functionality
| Jalankan: php create-search-test-data.php
*/

require_once 'vendor/autoload.php';

// Load Laravel environment
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "🔧 Creating test data for Global Search...\n";

try {
    // Get first user for foreign key
    $firstUser = App\Models\User::first();
    if (!$firstUser) {
        echo "❌ No users found. Please create a user first.\n";
        return;
    }
    
    echo "👤 Using user: {$firstUser->name} (ID: {$firstUser->id})\n";

    // Create sample news if none exist
    $newsCount = App\Models\News::count();
    if ($newsCount < 5) {
        echo "📰 Creating sample news...\n";
        
        for ($i = 1; $i <= 5; $i++) {
            App\Models\News::create([
                'title' => "Berita Kampus Terbaru $i",
                'slug' => "berita-kampus-terbaru-$i",
                'content' => "Ini adalah konten berita kampus yang berisi informasi penting tentang kegiatan akademik dan kemahasiswaan di kampus kita.",
                'excerpt' => "Excerpt untuk berita kampus terbaru nomor $i",
                'status' => 'published',
                'published_at' => now()->subDays($i),
                'user_id' => $firstUser->id,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        echo "✅ Created 5 sample news\n";
    } else {
        echo "✅ News data already exists ($newsCount records)\n";
    }

    // Create sample announcements if none exist
    $announcementCount = App\Models\Announcement::count();
    if ($announcementCount < 3) {
        echo "📢 Creating sample announcements...\n";
        
        for ($i = 1; $i <= 3; $i++) {
            App\Models\Announcement::create([
                'title' => "Pengumuman Penting $i",
                'slug' => "pengumuman-penting-$i",
                'content' => "Ini adalah pengumuman penting untuk seluruh civitas akademika mengenai kegiatan kampus dan prosedur administrasi.",
                'start_date' => now()->subDays($i),
                'end_date' => now()->addDays(30),
                'is_active' => true,
                'is_featured' => $i === 1,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        echo "✅ Created 3 sample announcements\n";
    } else {
        echo "✅ Announcement data already exists ($announcementCount records)\n";
    }

    // Create sample pages if none exist
    $pageCount = App\Models\Page::count();
    if ($pageCount < 3) {
        echo "📄 Creating sample pages...\n";
        
        $pages = [
            [
                'title' => 'Tentang Kampus',
                'slug' => 'tentang-kampus',
                'content' => 'Halaman yang berisi informasi lengkap tentang sejarah, visi misi, dan profil kampus kami.'
            ],
            [
                'title' => 'Fasilitas Kampus',
                'slug' => 'fasilitas-kampus', 
                'content' => 'Informasi lengkap mengenai fasilitas yang tersedia di kampus untuk mendukung kegiatan belajar mengajar.'
            ],
            [
                'title' => 'Kontak',
                'slug' => 'kontak',
                'content' => 'Halaman kontak untuk menghubungi pihak kampus, alamat, nomor telepon, dan email resmi.'
            ]
        ];
        
        foreach ($pages as $page) {
            App\Models\Page::create([
                'title' => $page['title'],
                'slug' => $page['slug'],
                'content' => $page['content'],
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        echo "✅ Created 3 sample pages\n";
    } else {
        echo "✅ Page data already exists ($pageCount records)\n";
    }

    echo "\n🎉 Test data creation completed!\n";
    echo "📊 Current data count:\n";
    echo "   - News: " . App\Models\News::count() . "\n";
    echo "   - Announcements: " . App\Models\Announcement::count() . "\n";
    echo "   - Pages: " . App\Models\Page::count() . "\n";
    echo "\n🔗 Test the search at: " . url('/test-search') . "\n";

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}
