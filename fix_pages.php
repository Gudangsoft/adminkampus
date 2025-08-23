<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Page;
use Illuminate\Support\Facades\DB;

// First, let's see what pages exist
echo "Current pages:\n";
$pages = Page::all(['id', 'title', 'status', 'show_in_menu']);
foreach ($pages as $page) {
    echo "ID: {$page->id}, Title: {$page->title}, Status: {$page->status}, Show in Menu: " . ($page->show_in_menu ? 'Yes' : 'No') . "\n";
}

// If no pages exist, create some sample pages
if ($pages->count() === 0) {
    echo "\nNo pages found. Creating sample pages...\n";
    
    Page::create([
        'title' => 'Beranda',
        'slug' => 'beranda',
        'content' => '<h1>Selamat Datang di Universitas Go-Campus</h1><p>Universitas terdepan dalam teknologi dan inovasi.</p>',
        'status' => 'published',
        'show_in_menu' => true,
        'menu_order' => 1,
        'user_id' => 1
    ]);
    
    Page::create([
        'title' => 'Tentang Kami',
        'slug' => 'tentang-kami',
        'content' => '<h2>Tentang Universitas Go-Campus</h2><p>Universitas yang berdedikasi untuk memberikan pendidikan berkualitas.</p>',
        'status' => 'published',
        'show_in_menu' => true,
        'menu_order' => 2,
        'user_id' => 1
    ]);
    
    Page::create([
        'title' => 'Kontak',
        'slug' => 'kontak',
        'content' => '<h2>Hubungi Kami</h2><p>Alamat: Jl. Contoh No. 123, Jakarta</p><p>Telepon: (021) 123-4567</p>',
        'status' => 'published',
        'show_in_menu' => true,
        'menu_order' => 3,
        'user_id' => 1
    ]);
    
    echo "Sample pages created!\n";
} else {
    // Update existing pages to have proper status if they don't
    echo "\nUpdating pages with missing status...\n";
    Page::whereIn('status', ['', null])->update(['status' => 'published']);
    Page::whereNull('show_in_menu')->update(['show_in_menu' => true]);
    echo "Pages updated!\n";
}

echo "\nFinal pages:\n";
$pages = Page::all(['id', 'title', 'status', 'show_in_menu']);
foreach ($pages as $page) {
    echo "ID: {$page->id}, Title: {$page->title}, Status: {$page->status}, Show in Menu: " . ($page->show_in_menu ? 'Yes' : 'No') . "\n";
}
