<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\NewsCategory;
use App\Models\GalleryCategory;

class CategoryDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create news categories
        NewsCategory::create([
            'name' => 'Berita Umum',
            'slug' => 'berita-umum',
            'description' => 'Berita umum seputar kampus',
            'color' => '#007bff',
            'is_active' => true,
            'sort_order' => 1
        ]);

        NewsCategory::create([
            'name' => 'Akademik',
            'slug' => 'akademik',
            'description' => 'Berita seputar kegiatan akademik',
            'color' => '#28a745',
            'is_active' => true,
            'sort_order' => 2
        ]);

        NewsCategory::create([
            'name' => 'Kemahasiswaan',
            'slug' => 'kemahasiswaan',
            'description' => 'Berita kegiatan kemahasiswaan',
            'color' => '#ffc107',
            'is_active' => true,
            'sort_order' => 3
        ]);

        // Create gallery categories
        GalleryCategory::create([
            'name' => 'Fasilitas',
            'slug' => 'fasilitas',
            'description' => 'Foto-foto fasilitas kampus',
            'color' => '#17a2b8',
            'is_active' => true,
            'sort_order' => 1
        ]);

        GalleryCategory::create([
            'name' => 'Kegiatan',
            'slug' => 'kegiatan',
            'description' => 'Dokumentasi kegiatan kampus',
            'color' => '#dc3545',
            'is_active' => true,
            'sort_order' => 2
        ]);

        GalleryCategory::create([
            'name' => 'Wisuda',
            'slug' => 'wisuda',
            'description' => 'Dokumentasi acara wisuda',
            'color' => '#6f42c1',
            'is_active' => true,
            'sort_order' => 3
        ]);
    }
}
