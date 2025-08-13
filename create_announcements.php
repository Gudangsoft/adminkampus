<?php

require 'vendor/autoload.php';

$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Announcement;
use Carbon\Carbon;

try {
    echo "=== Creating Sample Announcements ===\n";
    
    // Create sample announcements
    $announcements = [
        [
            'title' => 'Penerimaan Mahasiswa Baru Tahun 2025',
            'slug' => 'penerimaan-mahasiswa-baru-2025',
            'content' => '<p>Kami dengan bangga mengumumkan bahwa pendaftaran mahasiswa baru untuk tahun akademik 2025/2026 telah dibuka. Tersedia berbagai program studi unggulan dengan fasilitas modern dan tenaga pengajar berpengalaman.</p><p>Syarat pendaftaran meliputi: ijazah SMA/sederajat, pas foto terbaru, dan dokumen pendukung lainnya. Kuota terbatas untuk setiap program studi.</p>',
            'excerpt' => 'Pendaftaran mahasiswa baru tahun akademik 2025/2026 telah dibuka dengan berbagai program studi unggulan.',
            'type' => 'academic',
            'priority' => 'high',
            'status' => 'active',
            'user_id' => 1,
            'start_date' => Carbon::now(),
            'end_date' => Carbon::now()->addMonths(3),
            'is_featured' => true,
            'send_notification' => true,
            'target_audience' => ['public', 'students', 'parents'],
            'views' => 0,
        ],
        [
            'title' => 'Beasiswa Prestasi Semester Genap 2024',
            'slug' => 'beasiswa-prestasi-semester-genap-2024',
            'content' => '<p>Program beasiswa prestasi semester genap 2024 telah dibuka untuk mahasiswa berprestasi. Beasiswa mencakup biaya kuliah penuh dan tunjangan hidup bulanan.</p><p>Persyaratan: IPK minimal 3.5, aktif dalam kegiatan organisasi, dan melampirkan surat rekomendasi dari dosen pembimbing.</p>',
            'excerpt' => 'Program beasiswa prestasi untuk mahasiswa berprestasi semester genap 2024 dengan benefit biaya kuliah penuh.',
            'type' => 'academic',
            'priority' => 'high',
            'status' => 'active',
            'user_id' => 1,
            'start_date' => Carbon::now()->subDays(5),
            'end_date' => Carbon::now()->addDays(25),
            'is_featured' => true,
            'send_notification' => true,
            'target_audience' => ['students'],
            'views' => 25,
        ],
        [
            'title' => 'Seminar Nasional: Teknologi Digital dalam Pendidikan',
            'slug' => 'seminar-nasional-teknologi-digital-pendidikan',
            'content' => '<p>Seminar nasional bertema "Teknologi Digital dalam Pendidikan: Tantangan dan Peluang di Era 4.0" akan dilaksanakan pada tanggal 25 Agustus 2025.</p><p>Pembicara kunci: Prof. Dr. Digital Expert dan praktisi industri teknologi pendidikan. Gratis untuk mahasiswa dan umum dengan sertifikat.</p>',
            'excerpt' => 'Seminar nasional teknologi digital dalam pendidikan dengan pembicara expert dan sertifikat gratis.',
            'type' => 'event',
            'priority' => 'normal',
            'status' => 'active',
            'user_id' => 1,
            'start_date' => Carbon::now()->subDays(3),
            'end_date' => Carbon::now()->addDays(12),
            'is_featured' => false,
            'send_notification' => true,
            'target_audience' => ['students', 'staff', 'public'],
            'views' => 42,
        ],
        [
            'title' => 'Update Protokol Kesehatan Kampus',
            'slug' => 'update-protokol-kesehatan-kampus',
            'content' => '<p>Mengikuti kebijakan terbaru dari pemerintah, kami mengupdate protokol kesehatan di lingkungan kampus. Semua civitas akademika wajib mematuhi protokol yang berlaku.</p><p>Protokol meliputi: penggunaan masker di ruangan tertutup, menjaga jarak aman, dan mencuci tangan secara berkala.</p>',
            'excerpt' => 'Update protokol kesehatan kampus sesuai kebijakan terbaru pemerintah untuk keamanan bersama.',
            'type' => 'urgent',
            'priority' => 'urgent',
            'status' => 'active',
            'user_id' => 1,
            'start_date' => Carbon::now()->subDays(1),
            'end_date' => Carbon::now()->addMonths(6),
            'is_featured' => true,
            'send_notification' => true,
            'target_audience' => ['students', 'staff', 'visitors'],
            'views' => 78,
        ],
        [
            'title' => 'Workshop Pengembangan Soft Skills Mahasiswa',
            'slug' => 'workshop-pengembangan-soft-skills',
            'content' => '<p>Workshop pengembangan soft skills untuk mahasiswa semester 3-8 akan diadakan setiap Sabtu selama bulan September. Materi meliputi leadership, communication skills, dan time management.</p><p>Pendaftaran dibuka hingga 30 Agustus 2025. Kuota terbatas 50 peserta per sesi.</p>',
            'excerpt' => 'Workshop soft skills bulanan untuk mahasiswa dengan materi leadership dan communication skills.',
            'type' => 'event',
            'priority' => 'normal',
            'status' => 'active',
            'user_id' => 1,
            'start_date' => Carbon::now()->subDays(2),
            'end_date' => Carbon::now()->addDays(18),
            'is_featured' => false,
            'send_notification' => false,
            'target_audience' => ['students'],
            'views' => 15,
        ]
    ];
    
    foreach ($announcements as $data) {
        $existing = Announcement::where('slug', $data['slug'])->first();
        if (!$existing) {
            Announcement::create($data);
            echo "✓ Created: {$data['title']}\n";
        } else {
            echo "- Exists: {$data['title']}\n";
        }
    }
    
    $count = Announcement::count();
    echo "\n🎉 Total announcements in database: {$count}\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
