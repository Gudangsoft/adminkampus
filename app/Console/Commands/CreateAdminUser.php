<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create {email=admin@admin.com} {password=admin123}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create admin user for testing';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $password = $this->argument('password');

        // Check if user already exists
        $existingUser = User::where('email', $email)->first();
        if ($existingUser) {
            $this->info("User with email {$email} already exists!");
            $this->info("Email: {$existingUser->email}");
            $this->info("Name: {$existingUser->name}");
            return;
        }

        // Create new user
        $user = User::create([
            'name' => 'Admin User',
            'email' => $email,
            'password' => Hash::make($password),
            'email_verified_at' => now(),
        ]);

        $this->info("Admin user created successfully!");
        $this->info("Email: {$user->email}");
        $this->info("Password: {$password}");
        $this->info("You can now login at: http://127.0.0.1:8000/login");
    }
}
