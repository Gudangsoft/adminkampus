<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Gallery;
use App\Models\GalleryCategory;
use App\Models\User;
use Illuminate\Support\Str;

class GallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = GalleryCategory::all();
        $users = User::all();
        
        if ($categories->isEmpty() || $users->isEmpty()) {
            $this->command->warn('Please run GalleryCategorySeeder and ensure users exist first.');
            return;
        }

        $sampleGalleries = [
            // Videos (YouTube)
            [
                'title' => 'Profil Universitas G0-CAMPUS',
                'description' => 'Video profil lengkap tentang Universitas G0-CAMPUS, fasilitas, dan prestasi yang telah diraih.',
                'type' => 'video',
                'file_path' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', // Sample YouTube URL
                'is_featured' => true,
                'photographer' => 'Tim Multimedia',
                'category_name' => 'Video Profil'
            ],
            [
                'title' => 'Wisuda Semester Genap 2024',
                'description' => 'Upacara wisuda mahasiswa semester genap tahun akademik 2024.',
                'type' => 'video',
                'file_path' => 'https://www.youtube.com/watch?v=ScMzIvxBSi4', // Sample YouTube URL
                'is_featured' => true,
                'photographer' => 'Humas Kampus',
                'category_name' => 'Wisuda'
            ],
            [
                'title' => 'Seminar Teknologi AI dan Machine Learning',
                'description' => 'Seminar nasional tentang perkembangan teknologi AI dan penerapannya di industri.',
                'type' => 'video',
                'file_path' => 'https://www.youtube.com/watch?v=9bZkp7q19f0', // Sample YouTube URL
                'is_featured' => false,
                'photographer' => 'Fakultas Teknik',
                'category_name' => 'Seminar dan Workshop'
            ],
            [
                'title' => 'Festival Budaya Nusantara 2024',
                'description' => 'Festival budaya tahunan yang menampilkan keberagaman budaya Indonesia.',
                'type' => 'video',
                'file_path' => 'https://www.youtube.com/watch?v=kJQP7kiw5Fk', // Sample YouTube URL
                'is_featured' => false,
                'photographer' => 'UKM Seni Budaya',
                'category_name' => 'Kebudayaan'
            ],
            [
                'title' => 'Kompetisi Olahraga Antar Fakultas',
                'description' => 'Kompetisi olahraga tahunan antar fakultas mencakup berbagai cabang olahraga.',
                'type' => 'video',
                'file_path' => 'https://www.youtube.com/watch?v=djV11Xbc914', // Sample YouTube URL
                'is_featured' => false,
                'photographer' => 'UKM Olahraga',
                'category_name' => 'Olahraga'
            ],

            // Images dengan URL eksternal yang dapat diakses
            [
                'title' => 'Gedung Rektorat G0-CAMPUS',
                'description' => 'Foto gedung rektorat yang menjadi landmark utama kampus dengan arsitektur modern.',
                'type' => 'image',
                'file_path' => 'https://images.unsplash.com/photo-1562774053-701939374585?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'is_featured' => true,
                'photographer' => 'Tim Fotografer',
                'category_name' => 'Fasilitas'
            ],
            [
                'title' => 'Laboratorium Komputer Modern',
                'description' => 'Laboratorium komputer dengan peralatan canggih untuk mendukung pembelajaran teknologi informasi.',
                'type' => 'image',
                'file_path' => 'https://images.unsplash.com/photo-1517077304055-6e89abbf09b0?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'is_featured' => false,
                'photographer' => 'Tim Fotografer',
                'category_name' => 'Fasilitas'
            ],
            [
                'title' => 'Perpustakaan Pusat',
                'description' => 'Perpustakaan pusat dengan koleksi buku dan jurnal yang lengkap serta ruang baca yang nyaman.',
                'type' => 'image',
                'file_path' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'is_featured' => false,
                'photographer' => 'Tim Fotografer',
                'category_name' => 'Fasilitas'
            ],
            [
                'title' => 'Kegiatan Orientasi Mahasiswa Baru',
                'description' => 'Kegiatan orientasi dan pengenalan kampus untuk mahasiswa baru yang penuh semangat.',
                'type' => 'image',
                'file_path' => 'https://images.unsplash.com/photo-1523050854058-8df90110c9d1?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'is_featured' => true,
                'photographer' => 'Panitia Orientasi',
                'category_name' => 'Kegiatan Kampus'
            ],
            [
                'title' => 'Penelitian di Laboratorium Kimia',
                'description' => 'Mahasiswa dan dosen melakukan penelitian di laboratorium kimia dengan peralatan canggih.',
                'type' => 'image',
                'file_path' => 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'is_featured' => false,
                'photographer' => 'Fakultas MIPA',
                'category_name' => 'Penelitian'
            ],
            [
                'title' => 'Aula Serbaguna Kampus',
                'description' => 'Aula serbaguna berkapasitas besar untuk berbagai acara akademik dan kemahasiswaan.',
                'type' => 'image',
                'file_path' => 'https://images.unsplash.com/photo-1475721027785-f74eccf877e2?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'is_featured' => false,
                'photographer' => 'Tim Fotografer',
                'category_name' => 'Fasilitas'
            ]
        ];

        foreach ($sampleGalleries as $galleryData) {
            $category = $categories->where('name', $galleryData['category_name'])->first();
            
            if (!$category) {
                continue;
            }

            $slug = Str::slug($galleryData['title']);
            $counter = 1;
            $originalSlug = $slug;
            while (Gallery::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }

            $metadata = null;
            $thumbnail = null;

            if ($galleryData['type'] === 'video') {
                $videoId = $this->extractYouTubeId($galleryData['file_path']);
                if ($videoId) {
                    $metadata = [
                        'video_id' => $videoId,
                        'url' => $galleryData['file_path'],
                        'platform' => 'youtube',
                        'embed_url' => "https://www.youtube.com/embed/{$videoId}"
                    ];
                    $thumbnail = "https://img.youtube.com/vi/{$videoId}/maxresdefault.jpg";
                }
            }

            Gallery::create([
                'title' => $galleryData['title'],
                'slug' => $slug,
                'description' => $galleryData['description'],
                'category_id' => $category->id,
                'type' => $galleryData['type'],
                'file_path' => $galleryData['file_path'],
                'thumbnail' => $thumbnail,
                'alt_text' => $galleryData['title'],
                'metadata' => $metadata,
                'user_id' => $users->random()->id,
                'is_featured' => $galleryData['is_featured'],
                'views' => rand(10, 500),
                'photographer' => $galleryData['photographer'],
                'taken_at' => fake()->dateTimeBetween('-2 years', 'now')
            ]);
        }

        $this->command->info('Created ' . count($sampleGalleries) . ' gallery items successfully.');
    }

    private function extractYouTubeId($url)
    {
        $pattern = '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/';
        preg_match($pattern, $url, $matches);
        return isset($matches[1]) ? $matches[1] : null;
    }
}
