<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create admin user
        User::updateOrCreate(
            ['email' => 'admin@g0campus.ac.id'],
            [
                'name' => 'Administrator',
                'email' => 'admin@g0campus.ac.id',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        // Create additional admin users
        User::updateOrCreate(
            ['email' => 'editor@g0campus.ac.id'],
            [
                'name' => 'Content Editor',
                'email' => 'editor@g0campus.ac.id',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
    }
}
