<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\StructuralPosition;
use Illuminate\Support\Str;

class StructuralPositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $positions = [
            // Level 1 - Rektor
            [
                'name' => 'Rektor',
                'category' => 'Rektor',
                'level' => 1,
                'sort_order' => 1,
                'description' => 'Pimpinan tertinggi universitas yang bertanggung jawab atas seluruh kegiatan akademik dan non-akademik'
            ],
            
            // Level 2 - Wakil Rektor
            [
                'name' => 'Wakil Rektor I',
                'category' => 'Rektor',
                'level' => 2,
                'sort_order' => 2,
                'description' => 'Wakil Rektor Bidang Akademik dan Kemahasiswaan'
            ],
            [
                'name' => 'Wakil Rektor II',
                'category' => 'Rektor',
                'level' => 2,
                'sort_order' => 3,
                'description' => 'Wakil Rektor Bidang Administrasi Umum dan Keuangan'
            ],
            [
                'name' => 'Wakil Rektor III',
                'category' => 'Rektor',
                'level' => 2,
                'sort_order' => 4,
                'description' => 'Wakil Rektor Bidang Penelitian dan Pengabdian Masyarakat'
            ],
            [
                'name' => 'Wakil Rektor IV',
                'category' => 'Rektor',
                'level' => 2,
                'sort_order' => 5,
                'description' => 'Wakil Rektor Bidang Kerjasama dan Pengembangan'
            ],
            
            // Level 2 - Sekretaris Universitas
            [
                'name' => 'Sekretaris Universitas',
                'category' => 'Rektor',
                'level' => 2,
                'sort_order' => 6,
                'description' => 'Koordinator administrasi dan tata usaha universitas'
            ],
            
            // Level 3 - Direktur/Dekan
            [
                'name' => 'Direktur',
                'category' => 'Direktur',
                'level' => 3,
                'sort_order' => 7,
                'description' => 'Pimpinan fakultas atau sekolah tinggi'
            ],
            [
                'name' => 'Wakil Direktur',
                'category' => 'Direktur',
                'level' => 4,
                'sort_order' => 8,
                'description' => 'Wakil pimpinan fakultas atau sekolah tinggi'
            ],
            
            // Level 5 - Program Studi
            [
                'name' => 'Kepala Program Studi',
                'category' => 'Program Studi',
                'level' => 5,
                'sort_order' => 9,
                'description' => 'Pimpinan program studi yang bertanggung jawab atas pengelolaan akademik program studi'
            ],
            [
                'name' => 'Sekretaris Program Studi',
                'category' => 'Program Studi',
                'level' => 6,
                'sort_order' => 10,
                'description' => 'Koordinator administrasi dan kegiatan program studi'
            ],
            
            // Level 6 - Lembaga
            [
                'name' => 'Kepala Lembaga',
                'category' => 'Lembaga',
                'level' => 6,
                'sort_order' => 11,
                'description' => 'Pimpinan lembaga penelitian, pengabdian, atau unit lainnya'
            ],
            [
                'name' => 'Sekretaris Lembaga',
                'category' => 'Lembaga',
                'level' => 7,
                'sort_order' => 12,
                'description' => 'Koordinator administrasi lembaga'
            ],
            
            // Level 7 - Unit
            [
                'name' => 'Kepala Unit',
                'category' => 'Unit',
                'level' => 7,
                'sort_order' => 13,
                'description' => 'Pimpinan unit kerja atau unit pelaksana teknis'
            ],
            [
                'name' => 'Sekretaris Unit',
                'category' => 'Unit',
                'level' => 8,
                'sort_order' => 14,
                'description' => 'Koordinator administrasi unit kerja'
            ],
            
            // Level 8 - Bagian
            [
                'name' => 'Kepala Bagian',
                'category' => 'Bagian',
                'level' => 8,
                'sort_order' => 15,
                'description' => 'Pimpinan bagian dalam struktur organisasi'
            ],
            [
                'name' => 'Kepala Sub Bagian',
                'category' => 'Bagian',
                'level' => 9,
                'sort_order' => 16,
                'description' => 'Pimpinan sub bagian dalam struktur organisasi'
            ],
        ];

        foreach ($positions as $position) {
            StructuralPosition::create([
                'name' => $position['name'],
                'slug' => Str::slug($position['name']),
                'category' => $position['category'],
                'level' => $position['level'],
                'sort_order' => $position['sort_order'],
                'description' => $position['description'],
                'is_active' => true,
            ]);
        }
    }
}
