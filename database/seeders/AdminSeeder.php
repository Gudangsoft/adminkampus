<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin utama
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@adminkampus.ac.id',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        // Admin backup
        User::create([
            'name' => 'Admin Kampus',
            'email' => 'admin@kampus.ac.id',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        // Editor
        User::create([
            'name' => 'Editor Konten',
            'email' => 'editor@kampus.ac.id',
            'password' => Hash::make('editor123'),
            'role' => 'editor',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        // User biasa untuk testing
        User::create([
            'name' => 'User Test',
            'email' => 'user@kampus.ac.id',
            'password' => Hash::make('user123'),
            'role' => 'user',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        echo "✅ Admin users created successfully!\n";
        echo "📧 Admin: admin@adminkampus.ac.id | Password: admin123\n";
        echo "📧 Admin: admin@kampus.ac.id | Password: password\n";
        echo "📧 Editor: editor@kampus.ac.id | Password: editor123\n";
        echo "📧 User: user@kampus.ac.id | Password: user123\n";
    }
}
