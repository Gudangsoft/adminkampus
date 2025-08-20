<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Menu;
use App\Models\Page;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get pages for linking
        $tentangPage = Page::where('slug', 'tentang-kami')->first();
        $fasilitasPage = Page::where('slug', 'fasilitas')->first();
        $kerjasamaPage = Page::where('slug', 'kerjasama')->first();
        $kontakPage = Page::where('slug', 'kontak')->first();

        // Header Menu Items
        $headerMenus = [
            [
                'name' => 'Beranda',
                'url' => '/',
                'location' => 'header',
                'icon' => 'fas fa-home',
                'is_active' => true,
                'sort_order' => 1,
                'target' => '_self'
            ],
            [
                'name' => 'Berita',
                'url' => '/berita',
                'location' => 'header',
                'icon' => 'fas fa-newspaper',
                'is_active' => true,
                'sort_order' => 2,
                'target' => '_self'
            ],
            [
                'name' => 'Pengumuman',
                'url' => '/pengumuman',
                'location' => 'header',
                'icon' => 'fas fa-bullhorn',
                'is_active' => true,
                'sort_order' => 3,
                'target' => '_self'
            ],
            [
                'name' => 'Tentang',
                'page_id' => $tentangPage?->id,
                'location' => 'header',
                'icon' => 'fas fa-info-circle',
                'is_active' => true,
                'sort_order' => 4,
                'target' => '_self'
            ],
            [
                'name' => 'Fasilitas',
                'page_id' => $fasilitasPage?->id,
                'location' => 'header',
                'icon' => 'fas fa-building',
                'is_active' => true,
                'sort_order' => 5,
                'target' => '_self'
            ],
            [
                'name' => 'Galeri',
                'url' => '/galeri',
                'location' => 'header',
                'icon' => 'fas fa-images',
                'is_active' => true,
                'sort_order' => 6,
                'target' => '_self'
            ]
        ];

        // Create header menus
        foreach ($headerMenus as $menu) {
            Menu::create($menu);
        }

        // Footer Menu Items
        $footerMenus = [
            [
                'name' => 'Tentang Kami',
                'page_id' => $tentangPage?->id,
                'location' => 'footer',
                'icon' => 'fas fa-info-circle',
                'is_active' => true,
                'sort_order' => 1,
                'target' => '_self'
            ],
            [
                'name' => 'Kerjasama',
                'page_id' => $kerjasamaPage?->id,
                'location' => 'footer',
                'icon' => 'fas fa-handshake',
                'is_active' => true,
                'sort_order' => 2,
                'target' => '_self'
            ],
            [
                'name' => 'Kontak',
                'page_id' => $kontakPage?->id,
                'location' => 'footer',
                'icon' => 'fas fa-envelope',
                'is_active' => true,
                'sort_order' => 3,
                'target' => '_self'
            ],
            [
                'name' => 'Kebijakan Privasi',
                'url' => '/kebijakan-privasi',
                'location' => 'footer',
                'icon' => 'fas fa-shield-alt',
                'is_active' => true,
                'sort_order' => 4,
                'target' => '_self'
            ]
        ];

        // Create footer menus
        foreach ($footerMenus as $menu) {
            Menu::create($menu);
        }

        // Create Academic parent menu for header
        $academicParent = Menu::create([
            'name' => 'Akademik',
            'url' => '#',
            'location' => 'header',
            'icon' => 'fas fa-graduation-cap',
            'is_active' => true,
            'sort_order' => 7,
            'target' => '_self'
        ]);

        // Academic submenu items
        $academicSubmenus = [
            [
                'name' => 'Program Studi',
                'url' => '/program-studi',
                'parent_id' => $academicParent->id,
                'location' => 'header',
                'icon' => 'fas fa-book',
                'is_active' => true,
                'sort_order' => 1,
                'target' => '_self'
            ],
            [
                'name' => 'Fakultas',
                'url' => '/fakultas',
                'parent_id' => $academicParent->id,
                'location' => 'header',
                'icon' => 'fas fa-university',
                'is_active' => true,
                'sort_order' => 2,
                'target' => '_self'
            ],
            [
                'name' => 'Mahasiswa',
                'url' => '/mahasiswa',
                'parent_id' => $academicParent->id,
                'location' => 'header',
                'icon' => 'fas fa-users',
                'is_active' => true,
                'sort_order' => 3,
                'target' => '_self'
            ]
        ];

        // Create academic submenus
        foreach ($academicSubmenus as $submenu) {
            Menu::create($submenu);
        }

        // Create Social Media menu for footer
        $socialMedias = [
            [
                'name' => 'Facebook',
                'url' => 'https://facebook.com/gocampus',
                'location' => 'footer',
                'icon' => 'fab fa-facebook',
                'is_active' => true,
                'sort_order' => 10,
                'target' => '_blank'
            ],
            [
                'name' => 'Instagram',
                'url' => 'https://instagram.com/gocampus',
                'location' => 'footer',
                'icon' => 'fab fa-instagram',
                'is_active' => true,
                'sort_order' => 11,
                'target' => '_blank'
            ],
            [
                'name' => 'YouTube',
                'url' => 'https://youtube.com/gocampus',
                'location' => 'footer',
                'icon' => 'fab fa-youtube',
                'is_active' => true,
                'sort_order' => 12,
                'target' => '_blank'
            ]
        ];

        // Create social media menus
        foreach ($socialMedias as $social) {
            Menu::create($social);
        }
    }
}
