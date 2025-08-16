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
    // Check if beranda page exists
    $beranda = Capsule::table('pages')->where('slug', 'beranda')->first();
    
    if (!$beranda) {
        // Create beranda page
        Capsule::table('pages')->insert([
            'title' => 'Beranda',
            'slug' => 'beranda',
            'content' => '<h1>Selamat Datang di Website Kampus</h1><p>Ini adalah halaman beranda website kampus.</p>',
            'meta_title' => 'Beranda - Website Kampus',
            'meta_description' => 'Halaman beranda website kampus',
            'status' => 'published',
            'show_in_menu' => true,
            'menu_order' => 1,
            'template' => null,
            'featured_image' => null,
            'meta_data' => json_encode([
                'title' => 'Beranda - Website Kampus',
                'description' => 'Halaman beranda website kampus',
                'keywords' => 'beranda, kampus, website'
            ]),
            'user_id' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        echo "✅ Page 'Beranda' created successfully\n";
    } else {
        echo "ℹ️  Page 'Beranda' already exists\n";
    }
    
    // Check if tentang page exists
    $tentang = Capsule::table('pages')->where('slug', 'tentang')->first();
    
    if (!$tentang) {
        // Create tentang page
        Capsule::table('pages')->insert([
            'title' => 'Tentang Kami',
            'slug' => 'tentang',
            'content' => '<h1>Tentang Kampus Kami</h1><p>Informasi lengkap mengenai kampus kami.</p>',
            'meta_title' => 'Tentang Kami - Website Kampus',
            'meta_description' => 'Informasi tentang kampus kami',
            'status' => 'published',
            'show_in_menu' => true,
            'menu_order' => 2,
            'template' => 'full-width',
            'featured_image' => null,
            'meta_data' => json_encode([
                'title' => 'Tentang Kami - Website Kampus',
                'description' => 'Informasi tentang kampus kami',
                'keywords' => 'tentang, kampus, informasi'
            ]),
            'user_id' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        echo "✅ Page 'Tentang Kami' created successfully\n";
    } else {
        echo "ℹ️  Page 'Tentang Kami' already exists\n";
    }
    
    // Show current pages
    $pages = Capsule::table('pages')->select('id', 'title', 'slug', 'status', 'template')->get();
    echo "\n📋 Current pages in database:\n";
    foreach ($pages as $page) {
        echo "ID: {$page->id} | Title: {$page->title} | Slug: {$page->slug} | Status: {$page->status} | Template: " . ($page->template ?: 'default') . "\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
