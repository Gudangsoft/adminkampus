<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Page;
use App\Models\Section;

class BasicDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create basic pages
        Page::create([
            'title' => 'Beranda',
            'slug' => 'beranda',
            'content' => '<h1>Selamat Datang di Website Kampus</h1><p>Ini adalah halaman beranda.</p>',
            'status' => 'published',
            'show_in_menu' => true,
            'menu_order' => 1
        ]);

        Page::create([
            'title' => 'Tentang Kami',
            'slug' => 'tentang-kami',
            'content' => '<h1>Tentang Kami</h1><p>Informasi tentang kampus kami.</p>',
            'status' => 'published',
            'show_in_menu' => true,
            'menu_order' => 2
        ]);

        // Create basic sections
        Section::create([
            'type' => 'hero',
            'title' => 'Hero Section',
            'content' => 'Selamat datang di kampus kami',
            'data' => json_encode([
                'subtitle' => 'Universitas Terbaik',
                'button_text' => 'Pelajari Lebih Lanjut',
                'button_url' => '#'
            ]),
            'is_active' => true,
            'order' => 1
        ]);

        Section::create([
            'type' => 'about',
            'title' => 'Tentang Kami',
            'content' => 'Kami adalah universitas yang berkomitmen untuk memberikan pendidikan terbaik.',
            'is_active' => true,
            'order' => 2
        ]);
    }
}
