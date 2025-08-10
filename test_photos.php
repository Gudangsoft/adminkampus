<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Testing lecturer photos...\n\n";

$lecturers = App\Models\Lecturer::all();
echo "Found " . $lecturers->count() . " lecturers\n\n";

foreach($lecturers as $lecturer) {
    echo "Name: " . $lecturer->name . "\n";
    echo "Photo field: " . ($lecturer->photo ?? 'NULL') . "\n";
    echo "Photo URL: " . $lecturer->photo_url . "\n";
    echo "File exists: " . (($lecturer->photo && Storage::disk('public')->exists($lecturer->photo)) ? 'YES' : 'NO') . "\n";
    echo "---\n";
}
