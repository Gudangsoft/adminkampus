<?php

require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\DB;

// Setup Laravel environment
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Dosen dengan Jabatan Struktural ===\n\n";

try {
    // Method 1: Using Eloquent relationships
    echo "Method 1: Using Eloquent relationships\n";
    echo "=====================================\n";
    
    $lecturers = App\Models\Lecturer::with('structuralPosition')
        ->whereNotNull('structural_position_id')
        ->where('is_active', true)
        ->get();
    
    if ($lecturers->count() > 0) {
        foreach ($lecturers as $lecturer) {
            $position = $lecturer->structuralPosition ? $lecturer->structuralPosition->name : 'Tidak Ditemukan';
            echo "- {$lecturer->full_name} ({$lecturer->nidn})\n";
            echo "  Jabatan: {$position}\n";
            if ($lecturer->structural_description) {
                echo "  Deskripsi: {$lecturer->structural_description}\n";
            }
            if ($lecturer->structural_start_date) {
                echo "  Mulai: {$lecturer->structural_start_date->format('d/m/Y')}\n";
            }
            if ($lecturer->structural_end_date) {
                echo "  Selesai: {$lecturer->structural_end_date->format('d/m/Y')}\n";
            }
            echo "  Status: {$lecturer->structural_status}\n\n";
        }
    } else {
        echo "Tidak ada dosen dengan jabatan struktural ditemukan.\n\n";
    }
    
    // Method 2: Direct database query
    echo "Method 2: Direct database query\n";
    echo "===============================\n";
    
    $results = DB::table('lecturers as l')
        ->leftJoin('structural_positions as sp', 'l.structural_position_id', '=', 'sp.id')
        ->select(
            'l.name',
            'l.nidn',
            'l.title_prefix',
            'l.title_suffix',
            'sp.name as position_name',
            'l.structural_description',
            'l.structural_start_date',
            'l.structural_end_date',
            'l.is_active'
        )
        ->whereNotNull('l.structural_position_id')
        ->where('l.is_active', true)
        ->orderBy('sp.name')
        ->get();
    
    if ($results->count() > 0) {
        foreach ($results as $lecturer) {
            $fullName = '';
            if ($lecturer->title_prefix) {
                $fullName .= $lecturer->title_prefix . ' ';
            }
            $fullName .= $lecturer->name;
            if ($lecturer->title_suffix) {
                $fullName .= ', ' . $lecturer->title_suffix;
            }
            
            echo "- {$fullName} ({$lecturer->nidn})\n";
            echo "  Jabatan: {$lecturer->position_name}\n";
            if ($lecturer->structural_description) {
                echo "  Deskripsi: {$lecturer->structural_description}\n";
            }
            if ($lecturer->structural_start_date) {
                echo "  Mulai: " . date('d/m/Y', strtotime($lecturer->structural_start_date)) . "\n";
            }
            if ($lecturer->structural_end_date) {
                echo "  Selesai: " . date('d/m/Y', strtotime($lecturer->structural_end_date)) . "\n";
            }
            echo "\n";
        }
    } else {
        echo "Tidak ada dosen dengan jabatan struktural ditemukan.\n\n";
    }
    
    // Method 3: Show summary statistics
    echo "Method 3: Summary Statistics\n";
    echo "============================\n";
    
    $totalLecturers = App\Models\Lecturer::where('is_active', true)->count();
    $structuralLecturers = App\Models\Lecturer::whereNotNull('structural_position_id')
        ->where('is_active', true)
        ->count();
    
    echo "Total Dosen Aktif: {$totalLecturers}\n";
    echo "Dosen dengan Jabatan Struktural: {$structuralLecturers}\n";
    echo "Persentase: " . round(($structuralLecturers / $totalLecturers) * 100, 2) . "%\n\n";
    
    // Method 4: Group by structural position
    echo "Method 4: Grouped by Position\n";
    echo "=============================\n";
    
    $groupedResults = DB::table('lecturers as l')
        ->leftJoin('structural_positions as sp', 'l.structural_position_id', '=', 'sp.id')
        ->select(
            'sp.name as position_name',
            'sp.category',
            DB::raw('COUNT(l.id) as lecturer_count'),
            DB::raw('GROUP_CONCAT(CONCAT(COALESCE(l.title_prefix, ""), " ", l.name, COALESCE(CONCAT(", ", l.title_suffix), "")) SEPARATOR "; ") as lecturer_names')
        )
        ->whereNotNull('l.structural_position_id')
        ->where('l.is_active', true)
        ->groupBy('sp.id', 'sp.name', 'sp.category')
        ->orderBy('sp.category')
        ->orderBy('sp.name')
        ->get();
    
    if ($groupedResults->count() > 0) {
        $currentCategory = '';
        foreach ($groupedResults as $group) {
            if ($currentCategory !== $group->category) {
                $currentCategory = $group->category;
                echo "\n--- {$currentCategory} ---\n";
            }
            
            echo "{$group->position_name} ({$group->lecturer_count} orang)\n";
            if ($group->lecturer_names) {
                $names = explode('; ', $group->lecturer_names);
                foreach ($names as $name) {
                    echo "  • {$name}\n";
                }
            }
            echo "\n";
        }
    } else {
        echo "Tidak ada data untuk ditampilkan.\n";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}

echo "\n=== Selesai ===\n";
