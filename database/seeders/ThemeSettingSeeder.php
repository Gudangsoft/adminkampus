<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ThemeSetting;

class ThemeSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'key' => 'site_name',
                'value' => 'Admin Kampus',
                'type' => 'text',
                'description' => 'Nama website/kampus'
            ],
            [
                'key' => 'site_description',
                'value' => 'Sistem Informasi Administrasi Kampus',
                'type' => 'textarea',
                'description' => 'Deskripsi website'
            ],
            [
                'key' => 'site_logo',
                'value' => '/images/logo.png',
                'type' => 'image',
                'description' => 'Logo website'
            ],
            [
                'key' => 'site_favicon',
                'value' => '/favicon.ico',
                'type' => 'image',
                'description' => 'Favicon website'
            ],
            [
                'key' => 'primary_color',
                'value' => '#667eea',
                'type' => 'color',
                'description' => 'Warna primer'
            ],
            [
                'key' => 'secondary_color',
                'value' => '#764ba2',
                'type' => 'color',
                'description' => 'Warna sekunder'
            ],
            [
                'key' => 'footer_text',
                'value' => '© 2025 Admin Kampus. All rights reserved.',
                'type' => 'text',
                'description' => 'Teks footer'
            ],
            [
                'key' => 'contact_email',
                'value' => 'info@kampus.ac.id',
                'type' => 'email',
                'description' => 'Email kontak'
            ],
            [
                'key' => 'contact_phone',
                'value' => '(021) 123-4567',
                'type' => 'text',
                'description' => 'Nomor telepon'
            ],
            [
                'key' => 'whatsapp_number',
                'value' => '6281234567890',
                'type' => 'text',
                'description' => 'Nomor WhatsApp'
            ],
            [
                'key' => 'address',
                'value' => 'Jl. Pendidikan No. 123, Jakarta',
                'type' => 'textarea',
                'description' => 'Alamat kampus'
            ],
            [
                'key' => 'google_analytics',
                'value' => '',
                'type' => 'text',
                'description' => 'Google Analytics ID'
            ]
        ];

        foreach ($settings as $setting) {
            ThemeSetting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }

        echo "✅ Theme settings created successfully!\n";
    }
}
