<?php
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Page;

echo "Testing Page data:\n";
$page = Page::first();
echo "First page title: " . $page->title . "\n";
echo "Status: '" . $page->status . "'\n";
echo "Show in menu: " . ($page->show_in_menu ? 'true' : 'false') . "\n";
echo "Show in menu type: " . gettype($page->show_in_menu) . "\n";
echo "Status comparison (published): " . ($page->status === 'published' ? 'true' : 'false') . "\n";
