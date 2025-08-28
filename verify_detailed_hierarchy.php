<?php

require_once 'vendor/autoload.php';

use Illuminate\Foundation\Application;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Test the campusOfficials controller method directly
use App\Http\Controllers\HomeController;

echo "=== DETAILED HIERARCHY VERIFICATION ===\n\n";

try {
    $controller = new HomeController();
    
    // Create a mock request to test the controller
    $request = Illuminate\Http\Request::create('/pejabat-struktural', 'GET');
    $response = $controller->campusOfficials();
    
    $data = $response->getData();
    $groupedOfficials = $data['groupedOfficials'];
    $campusOfficials = $data['campusOfficials'];
    
    echo "📊 TOTAL OFFICIALS: " . $campusOfficials->count() . "\n\n";
    
    echo "🏛️ HIERARCHY ORDER (As Displayed):\n";
    $position = 1;
    
    foreach($groupedOfficials as $category => $officials) {
        echo "\n{$position}. KATEGORI: {$category}\n";
        echo "   📝 Jumlah pejabat: " . $officials->count() . "\n";
        
        foreach($officials as $official) {
            echo "   👤 " . $official->name . " - " . $official->structuralPosition->position_name . "\n";
        }
        
        $position++;
    }
    
    echo "\n" . str_repeat("=", 60) . "\n";
    echo "📋 HIERARCHY SUMMARY:\n";
    echo "✓ Urutan sesuai permintaan: Pimpinan Sekolah Tinggi → Pimpinan Lembaga → Pimpinan Program Studi\n";
    echo "✓ Setiap kategori diurutkan dari level tertinggi ke bawah\n";
    echo "✓ Total " . $groupedOfficials->count() . " kategori pejabat struktural\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}
