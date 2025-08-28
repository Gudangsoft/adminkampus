<?php

require_once 'vendor/autoload.php';

use Illuminate\Foundation\Application;
use App\Models\StructuralPosition;
use App\Models\Lecturer;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

echo "=== CHECKING EXISTING STRUCTURAL POSITIONS ===\n\n";

try {
    $positions = StructuralPosition::where('is_active', true)->get(['id', 'position_name', 'category']);
    
    echo "Available Structural Positions:\n";
    foreach($positions as $p) {
        echo "ID: {$p->id} | Position: {$p->position_name} | Category: {$p->category}\n";
    }
    
    echo "\n=== DOSEN YANG AKAN DITAMBAHKAN ===\n";
    
    $newLecturers = [
        [
            'name' => 'Rina Setyawati, S.Si., M.Pd',
            'position' => 'Ketua Program Studi D3 TLM',
            'category' => 'Program Studi'
        ],
        [
            'name' => 'Yuri Pradika, S.Si., M.Sc',
            'position' => 'Ketua Program Studi D4 TLM',
            'category' => 'Program Studi'
        ],
        [
            'name' => 'Ns. Asrifah Suardi, S.Kep., M.M',
            'position' => 'Wakil Ketua Bagian Akademik',
            'category' => 'Bagian'
        ],
        [
            'name' => 'Aulia Mutiara Hikmah, S.Si., M.Si',
            'position' => 'Ketua LPPM',
            'category' => 'Lembaga'
        ],
        [
            'name' => 'Rina Setyawati, S.Si., M.Pd',
            'position' => 'Ketua LPM',
            'category' => 'Lembaga'
        ],
        [
            'name' => 'Ns. Zalihin, S.Kep',
            'position' => 'Bagian Kemahasiswaan',
            'category' => 'Bagian'
        ],
        [
            'name' => 'Ns. Mubassir, S.Kep',
            'position' => 'Bagian Keuangan',
            'category' => 'Bagian'
        ]
    ];
    
    foreach($newLecturers as $index => $lecturer) {
        echo ($index + 1) . ". {$lecturer['name']} - {$lecturer['position']} ({$lecturer['category']})\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}
