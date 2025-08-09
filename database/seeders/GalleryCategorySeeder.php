<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\GalleryCategory;
use Illuminate\Support\Str;

class GalleryCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Kegiatan Kampus',
                'description' => 'Dokumentasi berbagai kegiatan dan acara di kampus',
                'is_active' => true,
                'sort_order' => 1
            ],
            [
                'name' => 'Fasilitas',
                'description' => 'Foto-foto fasilitas dan infrastruktur kampus',
                'is_active' => true,
                'sort_order' => 2
            ],
            [
                'name' => 'Wisuda',
                'description' => 'Dokumentasi upacara wisuda dan kelulusan',
                'is_active' => true,
                'sort_order' => 3
            ],
            [
                'name' => 'Seminar dan Workshop',
                'description' => 'Dokumentasi seminar, workshop, dan pelatihan',
                'is_active' => true,
                'sort_order' => 4
            ],
            [
                'name' => 'Olahraga',
                'description' => 'Kegiatan olahraga dan kompetisi mahasiswa',
                'is_active' => true,
                'sort_order' => 5
            ],
            [
                'name' => 'Kebudayaan',
                'description' => 'Acara budaya, seni, dan festival kampus',
                'is_active' => true,
                'sort_order' => 6
            ],
            [
                'name' => 'Penelitian',
                'description' => 'Dokumentasi kegiatan penelitian dan laboratorium',
                'is_active' => true,
                'sort_order' => 7
            ],
            [
                'name' => 'Video Profil',
                'description' => 'Video profil kampus, fakultas, dan program studi',
                'is_active' => true,
                'sort_order' => 8
            ]
        ];

        foreach ($categories as $categoryData) {
            $categoryData['slug'] = Str::slug($categoryData['name']);
            
            GalleryCategory::create($categoryData);
        }

        $this->command->info('Created ' . count($categories) . ' gallery categories successfully.');
    }
}
