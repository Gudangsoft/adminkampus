<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

try {
    echo "=== Debug View Rendering ===\n";
    
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
    
    // Test view rendering step by step
    echo "Testing view components...\n";
    
    // 1. Test if layout exists
    if (view()->exists('layouts.admin')) {
        echo "✅ Layout exists: layouts.admin\n";
    } else {
        echo "❌ Layout missing: layouts.admin\n";
    }
    
    // 2. Test if students view exists
    if (view()->exists('admin.students.index')) {
        echo "✅ View exists: admin.students.index\n";
    } else {
        echo "❌ View missing: admin.students.index\n";
    }
    
    // 3. Try to render the view
    try {
        $view = view('admin.students.index', compact('students', 'studyPrograms', 'entryYears'));
        echo "✅ View created successfully\n";
        
        $html = $view->render();
        echo "✅ View rendered: " . strlen($html) . " characters\n";
        
        if (strlen($html) > 0) {
            file_put_contents('test_view_output.html', $html);
            echo "✅ HTML saved to test_view_output.html\n";
            
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
        } else {
            echo "❌ Empty HTML output\n";
        }
        
    } catch (Exception $e) {
        echo "❌ View render error: " . $e->getMessage() . "\n";
        echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
        
        // Try to get more details
        if (strpos($e->getMessage(), 'status') !== false) {
            echo "\n🔍 Checking data structure:\n";
            $firstStudent = $students->first();
            if ($firstStudent) {
                echo "First student attributes: " . implode(', ', array_keys($firstStudent->getAttributes())) . "\n";
            }
        }
    }
    
} catch (Exception $e) {
    echo "❌ General error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}
