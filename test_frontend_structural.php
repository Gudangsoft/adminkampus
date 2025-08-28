<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== TESTING FRONTEND DISPLAY FOR STRUCTURAL POSITIONS ===\n\n";

// Test HomeController
echo "1. Testing HomeController...\n";

try {
    $homeController = new \App\Http\Controllers\HomeController();
    $request = new \Illuminate\Http\Request();
    $response = $homeController->index($request);
    echo "✓ HomeController@index works without errors\n\n";
} catch (Exception $e) {
    echo "❌ HomeController@index error: " . $e->getMessage() . "\n\n";
}

// Check campus officials query directly
echo "2. Testing Campus Officials Query...\n";

$campusOfficials = \App\Models\Lecturer::where('lecturers.is_active', 1)
    ->whereNotNull('structural_position_id')
    ->with('structuralPosition')
    ->where(function($query) {
        $query->whereNull('structural_end_date')
              ->orWhere('structural_end_date', '>=', now()->subYears(1));
    })
    ->whereHas('structuralPosition', function($query) {
        $query->where('structural_positions.is_active', 1)
              ->whereIn('name', [
            'Rektor', 
            'Wakil Rektor I', 
            'Wakil Rektor II', 
            'Wakil Rektor III', 
            'Wakil Rektor IV',
            'Direktur',
            'Wakil Direktur',
            'Sekretaris Universitas',
            'Dekan Fakultas Teknik',
            'Ketua Program Studi Teknik Informatika',
            'Ketua Program Studi Teknik Sipil',
            'Ketua Program Studi Manajemen',
            'Ketua LPPM',
            'Kepala Lembaga',
            'Sekretaris Lembaga'
        ]);
    })
    ->join('structural_positions', 'lecturers.structural_position_id', '=', 'structural_positions.id')
    ->orderBy('structural_positions.sort_order')
    ->select('lecturers.*')
    ->take(6)
    ->get();

echo "Total Campus Officials found: " . $campusOfficials->count() . "\n\n";

if ($campusOfficials->count() > 0) {
    echo "Campus Officials that will be displayed on frontend:\n";
    foreach ($campusOfficials as $official) {
        echo "- {$official->name}\n";
        echo "  Position: " . ($official->structuralPosition ? $official->structuralPosition->name : 'None') . "\n";
        echo "  Category: " . ($official->structuralPosition ? $official->structuralPosition->category : 'None') . "\n";
        echo "  Email: " . ($official->email ?: 'Not set') . "\n\n";
    }
} else {
    echo "❌ No campus officials found for frontend display!\n\n";
}

// Check specifically for LPPM positions
echo "3. Checking LPPM Position Display...\n";

$lppmOfficials = \App\Models\Lecturer::where('lecturers.is_active', 1)
    ->whereNotNull('structural_position_id')
    ->with('structuralPosition')
    ->whereHas('structuralPosition', function($query) {
        $query->where('structural_positions.is_active', 1)
              ->where('name', 'like', '%LPPM%');
    })
    ->get();

if ($lppmOfficials->count() > 0) {
    echo "✓ LPPM officials found:\n";
    foreach ($lppmOfficials as $official) {
        echo "- {$official->name}: {$official->structuralPosition->name}\n";
        
        // Check if this official will appear in frontend
        $inFrontend = $campusOfficials->contains('id', $official->id);
        echo "  Will appear on frontend: " . ($inFrontend ? 'YES' : 'NO') . "\n\n";
    }
} else {
    echo "❌ No LPPM officials found!\n\n";
}

// Test all structural positions available
echo "4. All Available Structural Positions:\n";

$allPositions = \App\Models\StructuralPosition::where('is_active', 1)->get();
echo "Total active structural positions: " . $allPositions->count() . "\n\n";

foreach ($allPositions as $position) {
    $lecturerCount = \App\Models\Lecturer::where('structural_position_id', $position->id)
        ->where('is_active', 1)
        ->count();
    
    echo "- {$position->name} ({$position->category}): {$lecturerCount} lecturer(s)\n";
}

echo "\n=== TEST COMPLETED ===\n";
