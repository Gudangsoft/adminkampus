<?php

require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$columns = DB::select('DESCRIBE lecturers');

echo "Lecturers table columns:\n";
foreach($columns as $col) {
    echo "- " . $col->Field . " (" . $col->Type . ")\n";
}
