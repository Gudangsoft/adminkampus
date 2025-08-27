<?php

require_once 'vendor/autoload.php';

// Bootstrap aplikasi Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== TESTING HOMEPAGE QUERY ===\n\n";

try {
    // Test query yang sama seperti di HomeController
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
                'Ketua Program Studi Manajemen'
            ]);
        })
        ->join('structural_positions', 'lecturers.structural_position_id', '=', 'structural_positions.id')
        ->orderBy('structural_positions.sort_order')
        ->select('lecturers.*')
        ->take(6)
        ->get();

    echo "✅ Query executed successfully!\n";
    echo "Found " . $campusOfficials->count() . " campus officials.\n\n";
    
    if ($campusOfficials->count() > 0) {
        echo "Campus Officials:\n";
        echo str_repeat("-", 50) . "\n";
        foreach ($campusOfficials as $official) {
            $structuralPosition = $official->structuralPosition ? $official->structuralPosition->name : 'N/A';
            echo "- {$official->name} ({$structuralPosition})\n";
        }
    } else {
        echo "No campus officials found. This is normal if no lecturers have structural positions assigned.\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}

echo "\n=== END TEST ===\n";
