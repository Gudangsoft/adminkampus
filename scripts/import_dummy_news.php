<?php
// File: scripts/import_dummy_news.php

use Illuminate\Support\Str;
use Illuminate\Database\Capsule\Manager as DB;

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

$newsFile = __DIR__ . '/dummy_news.json';
if (!file_exists($newsFile)) {
    exit("File dummy_news.json tidak ditemukan!\n");
}
$newsList = json_decode(file_get_contents($newsFile), true);

foreach ($newsList as $news) {
    DB::table('news')->updateOrInsert(
        ['slug' => $news['slug']],
        $news
    );
}
echo "Import dummy_news.json ke tabel news selesai!\n";
