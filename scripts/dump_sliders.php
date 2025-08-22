<?php
require __DIR__ . '/../vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Slider;

$sliders = Slider::all();
foreach ($sliders as $s) {
    echo $s->id . " => " . $s->image . PHP_EOL;
}
