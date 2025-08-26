<?php

require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

// Mark problematic migrations as completed
$migrations = [
    '2025_08_24_163640_add_missing_lecturer_fields',
    '2025_08_24_164119_add_lecturer_fields_properly',
    '2025_08_25_013214_add_role_to_users_table'
];

foreach($migrations as $migration) {
    $exists = DB::table('migrations')->where('migration', $migration)->exists();
    if (!$exists) {
        DB::table('migrations')->insert([
            'migration' => $migration,
            'batch' => 9
        ]);
        echo "Marked $migration as completed\n";
    } else {
        echo "$migration already exists\n";
    }
}
