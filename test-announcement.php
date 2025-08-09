<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Announcement;
use App\Models\User;

// Hapus semua announcements untuk fresh start
Announcement::truncate();

// Get or create user
$user = User::first();
if (!$user) {
    $user = User::create([
        'name' => 'Admin',
        'email' => 'admin@g0campus.com',
        'password' => bcrypt('password'),
        'email_verified_at' => now(),
    ]);
}

// Simple announcement for testing
$announcement = Announcement::create([
    'title' => 'Pengumuman Test - Libur Nasional',
    'slug' => 'pengumuman-test-libur-nasional',
    'excerpt' => 'Ini adalah pengumuman test untuk memastikan frontend berfungsi dengan baik.',
    'content' => '<h3>Pengumuman Test</h3><p>Ini adalah konten pengumuman untuk testing. Jika Anda bisa melihat ini di halaman frontend, berarti sistem sudah berfungsi dengan baik.</p><ul><li>Point 1: Testing</li><li>Point 2: Berhasil</li><li>Point 3: Frontend terupdate</li></ul>',
    'user_id' => $user->id,
    'status' => 'published',
    'priority' => 'high',
    'is_pinned' => true,
    'published_at' => now()->subHour(), // 1 jam yang lalu
    'expires_at' => null,
]);

echo "Created test announcement:\n";
echo "ID: {$announcement->id}\n";
echo "Title: {$announcement->title}\n";
echo "Status: {$announcement->status}\n";
echo "Published At: {$announcement->published_at}\n";
echo "Current Time: " . now() . "\n";

// Test scope
echo "\nTesting scopes:\n";
echo "Total count: " . Announcement::count() . "\n";
echo "Published count: " . Announcement::published()->count() . "\n";

if (Announcement::published()->count() > 0) {
    echo "SUCCESS: Published scope working!\n";
} else {
    echo "ERROR: Published scope not working!\n";
}

?>
