<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== ADDING SAMPLE LECTURERS TO STRUCTURAL POSITIONS ===\n\n";

// Get all available lecturers
$availableLecturers = \App\Models\Lecturer::where('is_active', 1)
    ->whereNull('structural_position_id')
    ->get();

if ($availableLecturers->count() == 0) {
    echo "❌ No available lecturers without structural positions found.\n";
    echo "Creating some sample lecturers first...\n\n";
    
    // Create sample lecturers
    $sampleLecturers = [
        [
            'nidn' => '0001010101',
            'name' => 'Prof. Dr. Ahmad Sutrisno, M.T.',
            'email' => 'wakil.rektor2@kampus.ac.id',
            'position' => 'Guru Besar',
            'is_active' => 1
        ],
        [
            'nidn' => '0002020202',
            'name' => 'Dr. Siti Rahayu, M.Kom',
            'email' => 'wakil.rektor3@kampus.ac.id',
            'position' => 'Lektor Kepala',
            'is_active' => 1
        ],
        [
            'nidn' => '0003030303',
            'name' => 'Drs. Budi Santoso, M.M.',
            'email' => 'direktur@kampus.ac.id',
            'position' => 'Lektor',
            'is_active' => 1
        ],
        [
            'nidn' => '0004040404',
            'name' => 'Dr. Rina Wati, M.Pd.',
            'email' => 'kaprodi.ti@kampus.ac.id',
            'position' => 'Lektor Kepala',
            'is_active' => 1
        ],
        [
            'nidn' => '0005050505',
            'name' => 'Ir. Agus Setiawan, M.T.',
            'email' => 'kaprodi.sipil@kampus.ac.id',
            'position' => 'Lektor',
            'is_active' => 1
        ]
    ];
    
    foreach ($sampleLecturers as $lecturerData) {
        try {
            \App\Models\Lecturer::create($lecturerData);
            echo "✓ Created lecturer: {$lecturerData['name']}\n";
        } catch (Exception $e) {
            echo "❌ Failed to create lecturer {$lecturerData['name']}: " . $e->getMessage() . "\n";
        }
    }
    
    // Refresh available lecturers
    $availableLecturers = \App\Models\Lecturer::where('is_active', 1)
        ->whereNull('structural_position_id')
        ->get();
}

echo "\nAvailable lecturers: " . $availableLecturers->count() . "\n\n";

// Get structural positions that need lecturers
$emptyPositions = \App\Models\StructuralPosition::where('is_active', 1)
    ->whereDoesntHave('lecturers', function($query) {
        $query->where('is_active', 1);
    })
    ->orderBy('sort_order')
    ->get();

echo "Empty structural positions: " . $emptyPositions->count() . "\n\n";

// Assign lecturers to structural positions
$assignments = [
    'Wakil Rektor II' => 'Prof. Dr. Ahmad Sutrisno, M.T.',
    'Wakil Rektor III' => 'Dr. Siti Rahayu, M.Kom',
    'Direktur' => 'Drs. Budi Santoso, M.M.',
    'Kepala Program Studi' => 'Dr. Rina Wati, M.Pd.',
    'Kepala Lembaga' => 'Ir. Agus Setiawan, M.T.'
];

foreach ($assignments as $positionName => $lecturerName) {
    $position = \App\Models\StructuralPosition::where('name', $positionName)->first();
    $lecturer = \App\Models\Lecturer::where('name', 'like', '%' . explode(',', $lecturerName)[0] . '%')->first();
    
    if ($position && $lecturer && !$lecturer->structural_position_id) {
        try {
            $lecturer->update([
                'structural_position_id' => $position->id,
                'structural_start_date' => now(),
                'structural_description' => 'Jabatan struktural ' . $position->name
            ]);
            echo "✓ Assigned {$lecturer->name} to {$position->name}\n";
        } catch (Exception $e) {
            echo "❌ Failed to assign {$lecturer->name} to {$position->name}: " . $e->getMessage() . "\n";
        }
    } else {
        if (!$position) echo "❌ Position '{$positionName}' not found\n";
        if (!$lecturer) echo "❌ Lecturer '{$lecturerName}' not found\n";
        if ($lecturer && $lecturer->structural_position_id) echo "⚠️  Lecturer '{$lecturerName}' already has a structural position\n";
    }
}

echo "\n=== FINAL CHECK ===\n\n";

// Check all structural positions now
$allPositions = \App\Models\StructuralPosition::with('lecturers')->where('is_active', 1)->get();

foreach ($allPositions as $position) {
    $activeLecturers = $position->lecturers()->where('is_active', 1)->count();
    echo "- {$position->name}: {$activeLecturers} lecturer(s)\n";
}

echo "\n=== COMPLETED ===\n";
