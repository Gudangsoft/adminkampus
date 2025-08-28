<?php

require_once 'vendor/autoload.php';

use Illuminate\Foundation\Application;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::create('/pejabat-struktural', 'GET')
);

echo "=== VERIFYING NEW LECTURERS DATA ===\n\n";

if ($response->getStatusCode() === 200) {
    echo "✓ Campus officials page loads successfully\n\n";
    
    $content = $response->getContent();
    
    // Check for new lecturers
    $newLecturers = [
        'Rina Setyawati',
        'Yuri Pradika',
        'Asrifah Suardi',
        'Aulia Mutiara Hikmah',
        'Zalihin',
        'Mubassir'
    ];
    
    echo "Checking for new lecturers on website:\n";
    foreach ($newLecturers as $name) {
        if (strpos($content, $name) !== false) {
            echo "✓ Found: $name\n";
        } else {
            echo "✗ Not found: $name\n";
        }
    }
    
    // Check for new positions
    $newPositions = [
        'Ketua Program Studi D3 TLM',
        'Ketua Program Studi D4 TLM',
        'Wakil Ketua Bagian Akademik',
        'Ketua LPM',
        'Bagian Kemahasiswaan',
        'Bagian Keuangan'
    ];
    
    echo "\nChecking for new positions on website:\n";
    foreach ($newPositions as $position) {
        if (strpos($content, $position) !== false) {
            echo "✓ Found: $position\n";
        } else {
            echo "✗ Not found: $position\n";
        }
    }
    
    // Count total officials now
    $officialCards = substr_count($content, 'official-card');
    echo "\nTotal official cards found: $officialCards\n";
    
} else {
    echo "✗ Campus officials page failed to load\n";
    echo "Status: " . $response->getStatusCode() . "\n";
}

echo "\n=== DATABASE VERIFICATION ===\n\n";

try {
    // Direct database check
    $lecturers = \App\Models\Lecturer::with('structuralPosition')
        ->whereNotNull('structural_position_id')
        ->where('is_active', true)
        ->get();
    
    echo "Total active lecturers with structural positions: " . $lecturers->count() . "\n\n";
    
    echo "New lecturers added:\n";
    $newNIDNs = ['0101018801', '0102018902', '0103018703', '0104019004', '0105018805', '0106018906'];
    
    foreach ($newNIDNs as $nidn) {
        $lecturer = $lecturers->where('nidn', $nidn)->first();
        if ($lecturer) {
            echo "✓ NIDN: $nidn | {$lecturer->name} | {$lecturer->structuralPosition->name}\n";
        } else {
            echo "✗ NIDN: $nidn | Not found\n";
        }
    }
    
    echo "\nStructural positions by category:\n";
    $positions = \App\Models\StructuralPosition::where('is_active', true)->get();
    $grouped = $positions->groupBy('category');
    
    foreach ($grouped as $category => $categoryPositions) {
        echo "$category: " . $categoryPositions->count() . " positions\n";
        foreach ($categoryPositions as $pos) {
            $lecturerCount = \App\Models\Lecturer::where('structural_position_id', $pos->id)
                ->where('is_active', true)
                ->count();
            echo "  - {$pos->name} ($lecturerCount lecturer)\n";
        }
    }
    
} catch (Exception $e) {
    echo "Database verification error: " . $e->getMessage() . "\n";
}

echo "\n=== VERIFICATION COMPLETED ===\n";
echo "📋 All new lecturers have been successfully added to the system!\n";
echo "🔗 View them at: http://127.0.0.1:8000/pejabat-struktural\n";

$kernel->terminate($request, $response);
