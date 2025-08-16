<?php

require_once 'vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;

// Database configuration
$capsule = new Capsule;
$capsule->addConnection([
    'driver' => 'mysql',
    'host' => '127.0.0.1',
    'database' => 'g0_campus',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => '',
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();

try {
    // Get beranda page
    $beranda = Capsule::table('pages')->where('slug', 'beranda')->first();
    
    if ($beranda) {
        echo "📄 Current page status: {$beranda->status}\n";
        
        // Toggle status
        $newStatus = $beranda->status === 'published' ? 'draft' : 'published';
        
        Capsule::table('pages')
            ->where('id', $beranda->id)
            ->update(['status' => $newStatus, 'updated_at' => date('Y-m-d H:i:s')]);
        
        echo "✅ Status updated to: {$newStatus}\n";
        
        // Verify update
        $updatedPage = Capsule::table('pages')->where('id', $beranda->id)->first();
        echo "✅ Verified status: {$updatedPage->status}\n";
        
        // Test that all required columns exist
        echo "\n🔍 Checking all columns exist:\n";
        $columns = ['id', 'title', 'slug', 'content', 'meta_title', 'meta_description', 'status', 'show_in_menu', 'menu_order', 'featured_image', 'meta_data', 'user_id', 'template', 'created_at', 'updated_at'];
        
        foreach ($columns as $column) {
            $exists = property_exists($updatedPage, $column);
            echo ($exists ? "✅" : "❌") . " Column '{$column}': " . ($exists ? "EXISTS" : "MISSING") . "\n";
        }
        
    } else {
        echo "❌ Beranda page not found\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
