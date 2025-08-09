<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Announcement;
use App\Models\User;

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

// Create sample announcements
$announcements = [
    [
        'title' => 'Pengumuman Penting: Ujian Tengah Semester',
        'slug' => 'pengumuman-penting-ujian-tengah-semester',
        'excerpt' => 'Jadwal dan ketentuan pelaksanaan Ujian Tengah Semester Ganjil 2024/2025',
        'content' => '<p>Kepada seluruh mahasiswa, dengan ini disampaikan jadwal pelaksanaan Ujian Tengah Semester (UTS) Ganjil 2024/2025:</p><h3>Jadwal Pelaksanaan</h3><ul><li>Tanggal: 15-20 Oktober 2024</li><li>Waktu: 08.00 - 10.00 WIB</li><li>Tempat: Sesuai jadwal yang telah ditentukan</li></ul><p>Harap mempersiapkan diri dengan baik.</p>',
        'user_id' => $user->id,
        'status' => 'published',
        'priority' => 'high',
        'is_pinned' => true,
        'published_at' => now(),
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'title' => 'Pembukaan Pendaftaran Mahasiswa Baru 2025',
        'slug' => 'pembukaan-pendaftaran-mahasiswa-baru-2025',
        'excerpt' => 'G0-CAMPUS membuka pendaftaran untuk calon mahasiswa baru periode 2025/2026',
        'content' => '<h3>Pendaftaran Mahasiswa Baru 2025/2026</h3><p>G0-CAMPUS dengan bangga mengumumkan pembukaan pendaftaran mahasiswa baru untuk tahun akademik 2025/2026.</p><h4>Jadwal:</h4><ul><li>Pendaftaran: 1 Januari - 30 April 2025</li><li>Ujian Masuk: 15-20 Mei 2025</li><li>Pengumuman: 1 Juni 2025</li></ul>',
        'user_id' => $user->id,
        'status' => 'published',
        'priority' => 'high',
        'is_pinned' => false,
        'published_at' => now()->subDays(1),
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'title' => 'Libur Nasional Hari Kemerdekaan',
        'slug' => 'libur-nasional-hari-kemerdekaan',
        'excerpt' => 'Pemberitahuan libur nasional dalam rangka memperingati Hari Kemerdekaan RI',
        'content' => '<p>Dalam rangka memperingati Hari Kemerdekaan Republik Indonesia ke-79, maka kegiatan perkuliahan diliburkan pada:</p><ul><li>Tanggal: 17 Agustus 2024</li><li>Kegiatan akan dilanjutkan kembali pada 18 Agustus 2024</li></ul><p>Selamat Hari Kemerdekaan RI!</p>',
        'user_id' => $user->id,
        'status' => 'published',
        'priority' => 'medium',
        'is_pinned' => false,
        'published_at' => now()->subDays(2),
        'created_at' => now(),
        'updated_at' => now(),
    ]
];

try {
    foreach ($announcements as $announcementData) {
        $announcement = Announcement::create($announcementData);
        echo "Created announcement: " . $announcement->title . "\n";
    }
    
    echo "\n=== Summary ===\n";
    echo "Total announcements: " . Announcement::count() . "\n";
    echo "Published announcements: " . Announcement::where('status', 'published')->count() . "\n";
    echo "Pinned announcements: " . Announcement::where('is_pinned', true)->count() . "\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

?>
