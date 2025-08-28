<?php

require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$columns = DB::select('DESCRIBE lecturers');

echo "Looking for office-related columns:\n";
foreach($columns as $col) {
    if (strpos($col->Field, 'office') !== false) {
        echo "Found: " . $col->Field . " (" . $col->Type . ")\n";
    }
}

echo "\nAll columns in lecturers table:\n";
foreach($columns as $col) {
    echo "- " . $col->Field . "\n";
}
