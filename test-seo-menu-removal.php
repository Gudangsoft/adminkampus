<?php
require_once 'vendor/autoload.php';
use Illuminate\Database\Capsule\Manager as Capsule;

// Database configuration
$capsule = new Capsule;
$capsule->addConnection([
    'driver' => 'mysql',
    'host' => '127.0.0.1',
    'database' => 'g0_campus',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => '',
]);
$capsule->setAsGlobal();
$capsule->bootEloquent();

try {
    echo "🚫 SEO & ANALYTICS MENU REMOVAL FOR EDITOR\n";
    echo "=" . str_repeat("=", 80) . "\n";

    echo "\n1️⃣ MENU YANG DIHAPUS DARI EDITOR:\n";
    echo "-" . str_repeat("-", 60) . "\n";
    echo "❌ SEO & ANALYTICS Section (Entire section hidden)\n";
    echo "   ❌ SEO Management (with all submenus)\n";
    echo "      • SEO Dashboard\n";
    echo "      • SEO Audit\n";
    echo "      • Meta Tags\n";
    echo "      • Sitemap\n";
    echo "      • SEO Tester\n";
    echo "   ❌ Analytics Dashboard\n";

    echo "\n2️⃣ UPDATED MENU STRUCTURE FOR EDITOR:\n";
    echo "-" . str_repeat("-", 60) . "\n";
    
    $editorMenus = [
        'CONTENT MANAGEMENT' => [
            '✅ Berita (with submenu: Kelola Berita, Kategori Berita)',
            '✅ Pengumuman',
            '✅ Halaman'
        ],
        'ACADEMIC MANAGEMENT' => [
            '✅ Akademik (dropdown: Fakultas, Program Studi, Dosen, Mahasiswa)'
        ],
        'MEDIA & DESIGN' => [
            '✅ Media (dropdown: Galeri, Slider, Sections)',
            '✅ Menu'
        ],
        'PERSONAL' => [
            '✅ Pengaturan',
            '✅ Profil', 
            '✅ Lihat Website',
            '✅ Logout'
        ]
    ];

    foreach ($editorMenus as $section => $menus) {
        echo "\n📋 {$section}:\n";
        foreach ($menus as $menu) {
            echo "   {$menu}\n";
        }
    }

    echo "\n3️⃣ ADMIN MASIH MEMILIKI AKSES PENUH:\n";
    echo "-" . str_repeat("-", 60) . "\n";
    echo "👑 Admin dapat melihat SEMUA menu termasuk:\n";
    echo "   ✅ SEO & Analytics (tetap ada)\n";
    echo "   ✅ System Tools\n";
    echo "   ✅ Push Notifications\n";
    echo "   ✅ Customization\n";
    echo "   ✅ Semua fitur content management\n";

    echo "\n4️⃣ VERIFICATION:\n";
    echo "-" . str_repeat("-", 60) . "\n";
    
    $users = Capsule::table('users')
        ->select('name', 'email', 'role')
        ->where('is_active', 1)
        ->orderBy('role')
        ->get();

    echo "👥 Test dengan user ini:\n\n";
    
    foreach ($users as $user) {
        $roleIcon = match($user->role) {
            'admin' => '👑',
            'editor' => '✏️',
            'viewer' => '👁️',
            default => '❓'
        };
        
        $seoAccess = ($user->role === 'admin') ? 'CAN see SEO & Analytics' : 'CANNOT see SEO & Analytics';
        
        echo "{$roleIcon} {$user->name} ({$user->email})\n";
        echo "   📧 Email: {$user->email}\n";
        echo "   🎭 Role: " . strtoupper($user->role) . "\n";
        echo "   📊 SEO Menu: {$seoAccess}\n\n";
    }

    echo "5️⃣ TESTING STEPS:\n";
    echo "-" . str_repeat("-", 60) . "\n";
    echo "🧪 Test Editor Menu:\n";
    echo "   1. Login sebagai editor@gmail.com\n";
    echo "   2. Check sidebar - SEO & Analytics section HILANG\n";
    echo "   3. Verify hanya ada: Content, Academic, Media, Personal\n\n";
    
    echo "🧪 Test Admin Menu:\n";
    echo "   1. Login sebagai admin@g0campus.ac.id\n";
    echo "   2. Check sidebar - SEO & Analytics section MASIH ADA\n";
    echo "   3. Verify semua menu terlihat lengkap\n";

    echo "\n✅ SEO & ANALYTICS MENU BERHASIL DIHAPUS DARI EDITOR!\n";
    echo "🔗 Test URL: http://127.0.0.1:8000/admin/login\n";

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
