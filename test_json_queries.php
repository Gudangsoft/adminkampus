<?php

require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Lecturer;

echo "Testing direct JSON queries:\n";

// Test for ID 13 (as string)
$result1 = Lecturer::whereJsonContains('study_program_ids', '13')->get();
echo "Query whereJsonContains(study_program_ids, '13'): " . $result1->count() . " results\n";

// Test for ID 13 (as integer)
$result2 = Lecturer::whereJsonContains('study_program_ids', 13)->get();
echo "Query whereJsonContains(study_program_ids, 13): " . $result2->count() . " results\n";

// Test JSON_CONTAINS with raw SQL
$result3 = Lecturer::whereRaw("JSON_CONTAINS(study_program_ids, '\"13\"')")->get();
echo "Query JSON_CONTAINS(study_program_ids, '\"13\"'): " . $result3->count() . " results\n";

// Test JSON_CONTAINS with proper string format
$result5 = Lecturer::whereRaw("JSON_CONTAINS(study_program_ids, '[\"13\"]')")->get();
echo "Query JSON_CONTAINS(study_program_ids, '[\"13\"]'): " . $result5->count() . " results\n";

// Test more LIKE patterns
$result7 = Lecturer::where('study_program_ids', 'LIKE', '%13%')->get();
echo "Query LIKE '%13%': " . $result7->count() . " results\n";

$result8 = Lecturer::where('study_program_ids', 'LIKE', '%\"13\"%')->get();
echo "Query LIKE '%\\\"13\\\"%': " . $result8->count() . " results\n";

// Test direct database query
$results = \DB::select("SELECT * FROM lecturers WHERE study_program_ids LIKE '%13%'");
echo "Raw SQL LIKE '%13%': " . count($results) . " results\n";

// Show actual JSON content
foreach(Lecturer::all() as $lecturer) {
    echo "Lecturer: {$lecturer->name} - Raw JSON: {$lecturer->getRawOriginal('study_program_ids')}\n";
}
