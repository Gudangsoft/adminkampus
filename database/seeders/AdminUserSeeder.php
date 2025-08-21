<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::updateOrCreate(
            ['email' => 'admin@g0campus.ac.id'],
            [
                'name' => 'Administrator',
                'email' => 'admin@g0campus.ac.id',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        \App\Models\User::updateOrCreate(
            ['email' => 'editor@g0campus.ac.id'],
            [
                'name' => 'Content Editor',
                'email' => 'editor@g0campus.ac.id',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
    }
}
