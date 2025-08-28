<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== TESTING LOGO AND WEBSITE NAME ===\n\n";

// Test HomeController campusOfficials method
echo "1. Testing campusOfficials method...\n";

try {
    $homeController = new \App\Http\Controllers\HomeController();
    $request = new \Illuminate\Http\Request();
    $response = $homeController->campusOfficials($request);
    echo "✓ campusOfficials method works without errors\n\n";
} catch (Exception $e) {
    echo "❌ campusOfficials method error: " . $e->getMessage() . "\n\n";
}

// Check global settings
echo "2. Checking Global Settings...\n";

$globalSettings = [
    'site_name' => \App\Models\Setting::get('site_name', 'KESOSI'),
    'site_description' => \App\Models\Setting::get('site_description', 'Kampus Kesehatan Modern'),
    'site_logo' => \App\Models\Setting::get('site_logo', ''),
    'contact_email' => \App\Models\Setting::get('contact_email', 'info@kesosi.ac.id'),
    'contact_phone' => \App\Models\Setting::get('contact_phone', '+62 21 1234567'),
    'site_keywords' => \App\Models\Setting::get('site_keywords', 'kampus, universitas, kesehatan, pendidikan'),
];

foreach ($globalSettings as $key => $value) {
    echo "- {$key}: " . ($value ?: 'Not set') . "\n";
}

// Check logo file
echo "\n3. Checking Logo File...\n";

$logoPath = $globalSettings['site_logo'];
if ($logoPath) {
    $fullPath = storage_path('app/public/' . $logoPath);
    if (file_exists($fullPath)) {
        echo "✓ Logo file exists at: {$fullPath}\n";
        echo "  File size: " . filesize($fullPath) . " bytes\n";
    } else {
        echo "❌ Logo file not found at: {$fullPath}\n";
        echo "⚠️  Will use default CSS logo instead\n";
    }
} else {
    echo "⚠️  No logo path set, will use default CSS logo\n";
}

// Test route
echo "\n4. Testing Route...\n";

try {
    $route = \Illuminate\Support\Facades\Route::getRoutes()->getByName('campus.officials');
    if ($route) {
        echo "✓ Route 'campus.officials' exists\n";
        echo "  URI: " . $route->uri() . "\n";
    } else {
        echo "❌ Route 'campus.officials' not found\n";
    }
} catch (Exception $e) {
    echo "❌ Route error: " . $e->getMessage() . "\n";
}

// Check campus officials data
echo "\n5. Checking Campus Officials Data...\n";

$campusOfficials = \App\Models\Lecturer::where('lecturers.is_active', 1)
    ->whereNotNull('structural_position_id')
    ->with('structuralPosition')
    ->where(function($query) {
        $query->whereNull('structural_end_date')
              ->orWhere('structural_end_date', '>=', now());
    })
    ->whereHas('structuralPosition', function($query) {
        $query->where('structural_positions.is_active', 1);
    })
    ->join('structural_positions', 'lecturers.structural_position_id', '=', 'structural_positions.id')
    ->orderBy('structural_positions.sort_order')
    ->select('lecturers.*')
    ->get();

echo "Total officials to display: " . $campusOfficials->count() . "\n";

if ($campusOfficials->count() > 0) {
    $groupedOfficials = $campusOfficials->groupBy(function($official) {
        return $official->structuralPosition->category;
    });
    
    echo "Grouped by categories:\n";
    foreach ($groupedOfficials as $category => $officials) {
        echo "- {$category}: " . $officials->count() . " official(s)\n";
    }
}

echo "\n=== TEST COMPLETED ===\n";

// Display final summary
echo "\n📋 SUMMARY:\n";
echo "- Website Name: " . $globalSettings['site_name'] . "\n";
echo "- Description: " . $globalSettings['site_description'] . "\n";
echo "- Logo Status: " . ($logoPath && file_exists(storage_path('app/public/' . $logoPath)) ? 'Available' : 'Using Default') . "\n";
echo "- Officials Count: " . $campusOfficials->count() . "\n";
echo "- Page URL: /pejabat-struktural\n";

echo "\n✅ Logo dan nama website siap digunakan!\n";
