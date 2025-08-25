<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Test campus officials data
try {
    $officials = \App\Models\Lecturer::active()
        ->whereNotNull('structural_position')
        ->where(function($query) {
            $query->whereNull('structural_end_date')
                  ->orWhere('structural_end_date', '>=', now()->subYears(1)); // Include recent officials
        })
        ->whereIn('structural_position', [
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
        ])
        ->orderByRaw("
            CASE structural_position 
                WHEN 'Rektor' THEN 1
                WHEN 'Wakil Rektor I' THEN 2  
                WHEN 'Wakil Rektor II' THEN 3
                WHEN 'Wakil Rektor III' THEN 4
                WHEN 'Wakil Rektor IV' THEN 5
                WHEN 'Direktur' THEN 6
                WHEN 'Wakil Direktur' THEN 7
                WHEN 'Sekretaris Universitas' THEN 8
                WHEN 'Dekan Fakultas Teknik' THEN 9
                ELSE 10
            END
        ")
        ->take(8)
        ->get();

    echo "Found " . $officials->count() . " campus officials:\n\n";
    
    foreach ($officials as $official) {
        echo "- {$official->name} ({$official->structural_position})\n";
        echo "  Email: " . ($official->email ?: 'Not set') . "\n";
        echo "  Photo: " . ($official->photo ? 'Available' : 'Not available') . "\n";
        echo "  Start Date: " . ($official->structural_start_date ? $official->structural_start_date->format('Y-m-d') : 'Not set') . "\n\n";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
