<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing menus
        Menu::truncate();

        // Main Navigation Menu Items
        $menuItems = [
            [
                'title' => 'Beranda',
                'url' => '/',
                'icon' => 'fas fa-home',
                'is_active' => true,
                'order' => 1,
                'target' => '_self'
            ],
            [
                'title' => 'Tentang',
                'url' => null,
                'icon' => 'fas fa-info-circle',
                'is_active' => true,
                'order' => 2,
                'target' => '_self'
            ],
            [
                'title' => 'Akademik',
                'url' => null,
                'icon' => 'fas fa-graduation-cap',
                'is_active' => true,
                'order' => 3,
                'target' => '_self'
            ],
            [
                'title' => 'Berita',
                'route' => 'news.index',
                'icon' => 'fas fa-newspaper',
                'is_active' => true,
                'order' => 4,
                'target' => '_self'
            ],
            [
                'title' => 'Galeri',
                'route' => 'gallery.index',
                'icon' => 'fas fa-images',
                'is_active' => true,
                'order' => 5,
                'target' => '_self'
            ],
            [
                'title' => 'Kontak',
                'url' => '/kontak',
                'icon' => 'fas fa-phone',
                'is_active' => true,
                'order' => 6,
                'target' => '_self'
            ]
        ];

        foreach ($menuItems as $item) {
            $menu = Menu::create($item);
            
            // Add sub-menus for "Tentang"
            if ($menu->title === 'Tentang') {
                $subMenus = [
                    ['title' => 'Profil Universitas', 'url' => '/tentang/profil', 'order' => 1],
                    ['title' => 'Visi & Misi', 'url' => '/tentang/visi-misi', 'order' => 2],
                    ['title' => 'Sejarah', 'url' => '/tentang/sejarah', 'order' => 3],
                    ['title' => 'Struktur Organisasi', 'url' => '/tentang/struktur', 'order' => 4]
                ];
                
                foreach ($subMenus as $subMenu) {
                    Menu::create(array_merge($subMenu, [
                        'parent_id' => $menu->id,
                        'is_active' => true,
                        'target' => '_self'
                    ]));
                }
            }
            
            // Add sub-menus for "Akademik"
            if ($menu->title === 'Akademik') {
                $subMenus = [
                    ['title' => 'Fakultas', 'route' => 'fakultas.index', 'order' => 1],
                    ['title' => 'Program Studi', 'route' => 'program-studi.index', 'order' => 2],
                    ['title' => 'Dosen', 'url' => '/dosen', 'order' => 3],
                    ['title' => 'Mahasiswa', 'route' => 'mahasiswa.index', 'order' => 4]
                ];
                
                foreach ($subMenus as $subMenu) {
                    Menu::create(array_merge($subMenu, [
                        'parent_id' => $menu->id,
                        'is_active' => true,
                        'target' => '_self'
                    ]));
                }
            }
        }
    }
}
