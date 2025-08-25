<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

try {
    echo "=== Testing View After Cleanup ===\n\n";
    
    // Login as admin
    $user = App\Models\User::where('email', 'admin@g0campus.ac.id')->first();
    Auth::login($user);
    
    // Get data like the controller does
    $students = App\Models\Student::with(['studyProgram'])->paginate(15);
    $studyPrograms = App\Models\StudyProgram::active()->orderBy('name')->get();
    $entryYears = App\Models\Student::selectRaw('DISTINCT entry_year')
                                   ->orderBy('entry_year', 'desc')
                                   ->pluck('entry_year');
    
    echo "Data prepared:\n";
    echo "- Students: " . $students->count() . " items\n";
    echo "- Study Programs: " . $studyPrograms->count() . " items\n";
    echo "- Entry Years: " . $entryYears->count() . " items\n\n";
    
    // Test view rendering
    try {
        $view = view('admin.students.index', compact('students', 'studyPrograms', 'entryYears'));
        echo "✅ View created successfully\n";
        
        $html = $view->render();
        echo "✅ View rendered: " . strlen($html) . " characters\n";
        
        if (strlen($html) > 0) {
            // Check for key content
            if (strpos($html, 'Kelola Mahasiswa') !== false) {
                echo "✅ Contains main title\n";
            } else {
                echo "❌ Missing main title\n";
            }
            
            if (strpos($html, 'Total Mahasiswa') !== false) {
                echo "✅ Contains statistics\n";
            } else {
                echo "❌ Missing statistics\n";
            }
            
            if (strpos($html, 'btn-group') !== false) {
                echo "✅ Contains action buttons\n";
            } else {
                echo "❌ Missing action buttons\n";
            }
            
            // Check for duplications
            $totalMatches = substr_count($html, 'Total Mahasiswa');
            echo "📊 'Total Mahasiswa' appears: {$totalMatches} times\n";
            
            $programMatches = substr_count($html, 'Program Studi');
            echo "📊 'Program Studi' appears: {$programMatches} times\n";
            
        } else {
            echo "❌ Empty HTML output\n";
        }
        
    } catch (Exception $e) {
        echo "❌ View render error: " . $e->getMessage() . "\n";
        echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
    }
    
} catch (Exception $e) {
    echo "❌ General error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}

echo "\n=== Test Complete ===\n";
