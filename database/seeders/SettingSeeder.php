<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run()
    {
        $settings = [
            // General Settings
            [
                'key' => 'site_name',
                'value' => 'G0-CAMPUS',
                'type' => 'text',
                'group' => 'general',
                'label' => 'Nama Website',
                'description' => 'Nama utama website kampus'
            ],
            [
                'key' => 'site_description',
                'value' => 'Website Resmi Universitas G0-CAMPUS - Kampus Modern untuk Masa Depan Cemerlang',
                'type' => 'textarea',
                'group' => 'general',
                'label' => 'Deskripsi Website',
                'description' => 'Deskripsi singkat tentang kampus'
            ],
            [
                'key' => 'site_keywords',
                'value' => 'universitas, kampus, pendidikan, mahasiswa, program studi',
                'type' => 'text',
                'group' => 'general',
                'label' => 'Keywords SEO',
                'description' => 'Keywords untuk SEO'
            ],
            
            // Contact Settings
            [
                'key' => 'contact_address',
                'value' => 'Jl. Pendidikan No. 123, Kota Pendidikan, Provinsi Edukasi 12345',
                'type' => 'textarea',
                'group' => 'contact',
                'label' => 'Alamat Kampus',
                'description' => 'Alamat lengkap kampus'
            ],
            [
                'key' => 'contact_phone',
                'value' => '+62 21 1234 5678',
                'type' => 'text',
                'group' => 'contact',
                'label' => 'Nomor Telepon',
                'description' => 'Nomor telepon utama'
            ],
            [
                'key' => 'contact_email',
                'value' => 'info@g0-campus.ac.id',
                'type' => 'email',
                'group' => 'contact',
                'label' => 'Email',
                'description' => 'Email resmi kampus'
            ],
            [
                'key' => 'contact_fax',
                'value' => '+62 21 1234 5679',
                'type' => 'text',
                'group' => 'contact',
                'label' => 'Fax',
                'description' => 'Nomor fax'
            ],
            [
                'key' => 'contact_website',
                'value' => 'https://g0-campus.ac.id',
                'type' => 'url',
                'group' => 'contact',
                'label' => 'Website',
                'description' => 'URL website resmi'
            ],
            
            // Social Media
            [
                'key' => 'social_facebook',
                'value' => 'https://facebook.com/g0campus',
                'type' => 'url',
                'group' => 'social',
                'label' => 'Facebook',
                'description' => 'URL Facebook Page'
            ],
            [
                'key' => 'social_instagram',
                'value' => 'https://instagram.com/g0campus',
                'type' => 'url',
                'group' => 'social',
                'label' => 'Instagram',
                'description' => 'URL Instagram'
            ],
            [
                'key' => 'social_youtube',
                'value' => 'https://youtube.com/@g0campus',
                'type' => 'url',
                'group' => 'social',
                'label' => 'YouTube',
                'description' => 'URL YouTube Channel'
            ],
            [
                'key' => 'social_twitter',
                'value' => 'https://twitter.com/g0campus',
                'type' => 'url',
                'group' => 'social',
                'label' => 'Twitter',
                'description' => 'URL Twitter'
            ],
            
            // About Settings
            [
                'key' => 'about_history',
                'value' => 'G0-CAMPUS didirikan pada tahun 2024 dengan visi menjadi universitas terdepan dalam bidang teknologi dan inovasi. Kampus modern ini dilengkapi dengan fasilitas terbaik untuk mendukung proses pembelajaran yang berkualitas.',
                'type' => 'textarea',
                'group' => 'about',
                'label' => 'Sejarah Kampus',
                'description' => 'Sejarah singkat kampus'
            ],
            [
                'key' => 'about_vision',
                'value' => 'Menjadi universitas terdepan yang menghasilkan lulusan berkualitas, inovatif, dan berkarakter untuk kemajuan bangsa.',
                'type' => 'textarea',
                'group' => 'about',
                'label' => 'Visi',
                'description' => 'Visi kampus'
            ],
            [
                'key' => 'about_mission',
                'value' => '1. Menyelenggarakan pendidikan tinggi berkualitas\n2. Mengembangkan penelitian dan pengabdian masyarakat\n3. Menciptakan inovasi untuk kemajuan teknologi\n4. Membangun karakter mahasiswa yang berintegritas',
                'type' => 'textarea',
                'group' => 'about',
                'label' => 'Misi',
                'description' => 'Misi kampus'
            ],
            [
                'key' => 'about_rector_name',
                'value' => 'Prof. Dr. Ahmad Sutrisno, M.Sc.',
                'type' => 'text',
                'group' => 'about',
                'label' => 'Nama Rektor',
                'description' => 'Nama lengkap rektor'
            ],
            [
                'key' => 'about_established_year',
                'value' => '2024',
                'type' => 'text',
                'group' => 'about',
                'label' => 'Tahun Berdiri',
                'description' => 'Tahun pendirian kampus'
            ]
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
