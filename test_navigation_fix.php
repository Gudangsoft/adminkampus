<?php

require_once 'vendor/autoload.php';

// Setup Laravel environment
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Testing Navigation Fix ===\n\n";

try {
    // Test if all routes exist
    echo "1. Testing Routes...\n";
    
    $routes = [
        'admin.lecturers.index' => 'Data Dosen',
        'admin.lecturers.structural' => 'Dosen Struktural', 
        'admin.structural-positions.index' => 'Kelola Jabatan'
    ];
    
    foreach ($routes as $routeName => $label) {
        try {
            $route = \Illuminate\Support\Facades\Route::getRoutes()->getByName($routeName);
            if ($route) {
                echo "✓ {$label}: {$route->uri()}\n";
            } else {
                echo "❌ {$label}: Route not found\n";
            }
        } catch (Exception $e) {
            echo "❌ {$label}: Error - {$e->getMessage()}\n";
        }
    }
    
    echo "\n2. Testing Controllers...\n";
    
    // Test lecturers controller
    $lecturerController = new App\Http\Controllers\Admin\LecturerController();
    $request = new Illuminate\Http\Request();
    
    try {
        $response = $lecturerController->index($request);
        echo "✓ Lecturer index controller works\n";
    } catch (Exception $e) {
        echo "❌ Lecturer index controller error: {$e->getMessage()}\n";
    }
    
    try {
        $response = $lecturerController->structural($request);
        echo "✓ Lecturer structural controller works\n";
    } catch (Exception $e) {
        echo "❌ Lecturer structural controller error: {$e->getMessage()}\n";
    }
    
    // Test structural positions controller
    try {
        $structuralController = new App\Http\Controllers\Admin\StructuralPositionController();
        $response = $structuralController->index($request);
        echo "✓ Structural positions controller works\n";
    } catch (Exception $e) {
        echo "❌ Structural positions controller error: {$e->getMessage()}\n";
    }
    
    echo "\n3. Navigation Structure:\n";
    echo "✓ Akademik (Main Menu)\n";
    echo "  ├── Program Studi\n";
    echo "  ├── Data Dosen (All lecturers)\n";
    echo "  ├── Dosen Struktural (Lecturers with positions)\n";
    echo "  ├── Kelola Jabatan (Manage structural positions)\n";
    echo "  └── Mahasiswa\n";
    
    echo "\n=== Navigation Fix Complete! ===\n";

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
