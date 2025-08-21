
<?php
// File: scripts/dummy_news.php

function now() {
    return date('Y-m-d H:i:s');
}

function slugify($text) {
    $text = strtolower($text);
    $text = preg_replace('/[^a-z0-9]+/', '-', $text);
    $text = trim($text, '-');
    return $text;
}

$news = [];
for ($i = 1; $i <= 10; $i++) {
    $title = "Berita Dummy ke-$i";
    $slug = slugify($title) . '-' . $i;
    $content = "<p>Ini adalah konten berita dummy ke-$i. Berisi informasi lengkap dan gambar.</p>\n<img src=\"https://picsum.photos/seed/news$i/800/400\" alt=\"Gambar Berita $i\">";
    $excerpt = "Ringkasan berita dummy ke-$i.";
    $image = "https://picsum.photos/seed/news$i/800/400";
    $news[] = [
        'title' => $title,
        'slug' => $slug,
        'excerpt' => $excerpt,
        'content' => $content,
        'image' => $image,
        'status' => 'published',
        'published_at' => now(),
        'user_id' => 1,
        'category_id' => 1,
        'is_featured' => false,
        'views' => rand(10, 100),
        'meta_data' => null,
        'created_at' => now(),
        'updated_at' => now(),
    ];
}

file_put_contents(__DIR__ . '/dummy_news.json', json_encode($news, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
echo "File dummy_news.json berhasil dibuat!\n";
