<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Testing Students Page Buttons ===\n\n";

try {
    // Login as admin
    $user = App\Models\User::where('email', 'admin@g0campus.ac.id')->first();
    Auth::login($user);
    echo "✅ Logged in as: " . $user->email . "\n\n";
    
    // Test data availability
    $studentsCount = App\Models\Student::count();
    echo "📊 Students count: {$studentsCount}\n";
    
    if ($studentsCount > 0) {
        $student = App\Models\Student::first();
        echo "📋 Testing with student: {$student->name} (ID: {$student->id})\n\n";
        
        // Test controller actions
        $controller = new App\Http\Controllers\Admin\StudentController();
        
        // Test show action
        try {
            $response = $controller->show($student);
            echo "✅ Show action works - Response type: " . get_class($response) . "\n";
        } catch (Exception $e) {
            echo "❌ Show action failed: " . $e->getMessage() . "\n";
        }
        
        // Test edit action
        try {
            $response = $controller->edit($student);
            echo "✅ Edit action works - Response type: " . get_class($response) . "\n";
        } catch (Exception $e) {
            echo "❌ Edit action failed: " . $e->getMessage() . "\n";
        }
        
        // Test toggle status action
        try {
            $originalStatus = $student->is_active;
            $response = $controller->toggleStatus($student);
            $student->refresh();
            
            if ($student->is_active !== $originalStatus) {
                echo "✅ Toggle status works - Status changed from " . 
                     ($originalStatus ? 'active' : 'inactive') . " to " . 
                     ($student->is_active ? 'active' : 'inactive') . "\n";
                
                // Revert back
                $controller->toggleStatus($student);
                $student->refresh();
            } else {
                echo "❌ Toggle status failed - Status didn't change\n";
            }
        } catch (Exception $e) {
            echo "❌ Toggle status failed: " . $e->getMessage() . "\n";
        }
        
        echo "\n🎯 Routes check:\n";
        $routes = [
            'admin.students.index' => 'Index page',
            'admin.students.show' => 'Show page',
            'admin.students.edit' => 'Edit page',
            'admin.students.create' => 'Create page',
            'admin.students.toggle-status' => 'Toggle status'
        ];
        
        foreach ($routes as $route => $description) {
            try {
                if ($route === 'admin.students.toggle-status') {
                    $url = route($route, $student);
                } elseif (in_array($route, ['admin.students.show', 'admin.students.edit'])) {
                    $url = route($route, $student);
                } else {
                    $url = route($route);
                }
                echo "✅ {$description}: {$url}\n";
            } catch (Exception $e) {
                echo "❌ {$description}: Route not found\n";
            }
        }
        
    } else {
        echo "❌ No students found for testing\n";
    }
    
} catch (Exception $e) {
    echo "❌ General error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}

echo "\n=== Test Complete ===\n";
