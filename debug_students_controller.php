<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$request = Illuminate\Http\Request::capture();
$kernel->handle($request);

try {
    echo "=== Testing Student Controller Index Method ===\n\n";
    
    // Login as admin
    $user = App\Models\User::where('email', 'admin@g0campus.ac.id')->first();
    Auth::login($user);
    echo "✅ Logged in as: " . $user->email . " (Role: " . $user->role . ")\n\n";
    
    // Test data availability
    $studentsCount = App\Models\Student::count();
    $studyProgramsCount = App\Models\StudyProgram::count();
    
    echo "📊 Data Check:\n";
    echo "- Students: {$studentsCount}\n";
    echo "- Study Programs: {$studyProgramsCount}\n\n";
    
    // Test controller manually
    $controller = new App\Http\Controllers\Admin\StudentController();
    $request = new Illuminate\Http\Request();
    
    echo "🎯 Calling controller->index()...\n";
    $response = $controller->index($request);
    
    echo "✅ Controller executed successfully\n";
    echo "📄 Response type: " . get_class($response) . "\n";
    
    if ($response instanceof Illuminate\View\View) {
        echo "🎨 View name: " . $response->getName() . "\n";
        
        $data = $response->getData();
        echo "📦 View data keys: " . implode(', ', array_keys($data)) . "\n\n";
        
        // Check each data
        foreach ($data as $key => $value) {
            if ($key === 'students') {
                echo "👥 Students data: " . get_class($value) . " with " . $value->count() . " items\n";
            } elseif ($key === 'studyPrograms') {
                echo "🎓 Study Programs: " . get_class($value) . " with " . $value->count() . " items\n";
            } elseif ($key === 'entryYears') {
                echo "📅 Entry Years: " . gettype($value) . " with " . count($value) . " items\n";
            }
        }
        
        echo "\n🖥️ Attempting to render view...\n";
        try {
            $html = $response->render();
            echo "✅ View rendered successfully\n";
            echo "📏 HTML length: " . strlen($html) . " characters\n";
            
            // Check for specific content
            if (strpos($html, 'Kelola Mahasiswa') !== false) {
                echo "✅ Contains title\n";
            } else {
                echo "❌ Missing title\n";
            }
            
            if (strpos($html, 'Total Mahasiswa') !== false) {
                echo "✅ Contains statistics\n";
            } else {
                echo "❌ Missing statistics\n";
            }
            
            if (strpos($html, 'table') !== false) {
                echo "✅ Contains table\n";
            } else {
                echo "❌ Missing table\n";
            }
            
            // Save rendered HTML to file for inspection
            file_put_contents('debug_students_page.html', $html);
            echo "💾 HTML saved to debug_students_page.html\n";
            
        } catch (Exception $e) {
            echo "❌ Error rendering view: " . $e->getMessage() . "\n";
            echo "📁 File: " . $e->getFile() . ":" . $e->getLine() . "\n";
            echo "🔍 Trace:\n" . $e->getTraceAsString() . "\n";
        }
    }
    
} catch (Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
    echo "📁 File: " . $e->getFile() . ":" . $e->getLine() . "\n";
    echo "🔍 Trace:\n" . $e->getTraceAsString() . "\n";
}
