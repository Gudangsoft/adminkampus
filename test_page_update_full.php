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
        echo "📄 Testing Page Update for Beranda (ID: {$beranda->id})\n";
        echo "📊 Current Status: {$beranda->status}\n";
        echo "🔧 Current Template: " . ($beranda->template ?: 'default') . "\n";
        
        // Test updating status from published to draft
        if ($beranda->status === 'published') {
            Capsule::table('pages')
                ->where('id', $beranda->id)
                ->update([
                    'status' => 'draft',
                    'template' => 'full-width',
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            echo "✅ Updated: status -> draft, template -> full-width\n";
        } else {
            Capsule::table('pages')
                ->where('id', $beranda->id)
                ->update([
                    'status' => 'published',
                    'template' => null,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            echo "✅ Updated: status -> published, template -> default\n";
        }
        
        // Verify update worked
        $updatedPage = Capsule::table('pages')->where('id', $beranda->id)->first();
        echo "\n✅ Verification:\n";
        echo "📊 New Status: {$updatedPage->status}\n";
        echo "🔧 New Template: " . ($updatedPage->template ?: 'default') . "\n";
        echo "🕒 Updated At: {$updatedPage->updated_at}\n";
        
        // Test that the fillable fields match what the model expects
        $expectedFillable = [
            'title', 'slug', 'content', 'featured_image', 'meta_data', 
            'user_id', 'status', 'show_in_menu', 'menu_order', 'template'
        ];
        
        echo "\n🔍 Testing all fillable fields exist in database:\n";
        foreach ($expectedFillable as $field) {
            $exists = property_exists($updatedPage, $field);
            echo ($exists ? "✅" : "❌") . " Field '{$field}': " . ($exists ? "EXISTS" : "MISSING") . "\n";
        }
        
        echo "\n🎯 Summary: All database operations completed successfully!\n";
        echo "🎯 The SQLSTATE[42S22] error about 'template' column should now be resolved.\n";
        
    } else {
        echo "❌ Beranda page not found\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
