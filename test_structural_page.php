<?php

require_once 'vendor/autoload.php';

// Setup Laravel environment
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Test Halaman Dosen dengan Jabatan Struktural ===\n\n";

try {
    // Test the controller method
    $controller = new App\Http\Controllers\Admin\LecturerController();
    $request = new Illuminate\Http\Request();
    
    echo "Testing controller structural method...\n";
    $response = $controller->structural($request);
    echo "✓ Controller method works without errors\n\n";
    
    // Test data retrieval
    echo "Testing data retrieval...\n";
    $lecturers = App\Models\Lecturer::with(['structuralPosition', 'studyPrograms'])
        ->whereNotNull('structural_position_id')
        ->where('is_active', true)
        ->get();
    
    echo "✓ Found {$lecturers->count()} lecturers with structural positions\n";
    
    foreach ($lecturers as $lecturer) {
        $positionName = $lecturer->structuralPosition ? $lecturer->structuralPosition->name : 'Unknown';
        echo "  - {$lecturer->full_name}: {$positionName}\n";
        echo "    Status: {$lecturer->structural_status}\n";
    }
    
    // Test relationship
    echo "\nTesting relationships...\n";
    $structuralPositions = App\Models\StructuralPosition::with('lecturers')->get();
    
    foreach ($structuralPositions as $position) {
        $count = $position->lecturers()->where('is_active', true)->count();
        if ($count > 0) {
            echo "✓ {$position->name}: {$count} lecturer(s)\n";
        }
    }
    
    // Test filtering
    echo "\nTesting filtering...\n";
    $activeLecturers = App\Models\Lecturer::whereNotNull('structural_position_id')
        ->where('is_active', true)
        ->where(function($q) {
            $now = now();
            $q->where(function($sq) use ($now) {
                $sq->whereNull('structural_start_date')
                   ->orWhere('structural_start_date', '<=', $now);
            })->where(function($sq) use ($now) {
                $sq->whereNull('structural_end_date')
                   ->orWhere('structural_end_date', '>=', $now);
            });
        })->count();
    
    echo "✓ Active structural positions: {$activeLecturers}\n";
    
    echo "\n=== Test completed successfully! ===\n";

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}
