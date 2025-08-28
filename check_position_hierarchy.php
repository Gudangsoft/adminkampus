<?php

require_once 'vendor/autoload.php';

use Illuminate\Foundation\Application;
use App\Models\StructuralPosition;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

echo "=== CURRENT STRUCTURAL POSITIONS ===\n\n";

$positions = StructuralPosition::with('lecturer')->where('is_active', true)->get();

echo "Total active positions: " . $positions->count() . "\n\n";

foreach($positions as $position) {
    echo "Category: " . $position->category . "\n";
    echo "Position: " . $position->position_name . "\n";
    echo "Level: " . ($position->level ?? 'Not set') . "\n";
    echo "Order: " . ($position->order ?? 'Not set') . "\n";
    if($position->lecturer) {
        echo "Lecturer: " . $position->lecturer->name . "\n";
    }
    echo "---\n";
}

echo "\n=== SUGGESTED HIERARCHY ORDER ===\n\n";
echo "1. Pimpinan Sekolah Tinggi (Rektor level)\n";
echo "2. Pimpinan Lembaga (LPPM, dll)\n";
echo "3. Pimpinan Program Studi\n";
echo "4. Level bawah lainnya\n";
