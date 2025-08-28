<?php

require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Schema;

try {
    $columns = Schema::getColumnListing('lecturers');
    echo "Columns in lecturers table:\n";
    foreach($columns as $column) {
        echo "- $column\n";
    }
    echo "\nHas scopus_id: " . (in_array('scopus_id', $columns) ? 'YES' : 'NO') . "\n";
} catch(Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
