<?php

/*
|--------------------------------------------------------------------------
| Admin System Health Check
|--------------------------------------------------------------------------
| Script untuk mengecek kesehatan sistem admin kampus
| Jalankan: php admin-health-check.php
*/

require_once 'vendor/autoload.php';

// Load Laravel environment
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "🏥 ADMIN SYSTEM HEALTH CHECK\n";
echo "============================\n\n";

// Check database connection
echo "📡 Database Connection: ";
try {
    DB::connection()->getPdo();
    echo "✅ OK\n";
} catch (Exception $e) {
    echo "❌ FAILED: " . $e->getMessage() . "\n";
}

// Check storage permissions
echo "📁 Storage Permissions: ";
if (is_writable('storage/app') && is_writable('storage/logs')) {
    echo "✅ OK\n";
} else {
    echo "❌ FAILED: Storage not writable\n";
}

// Check admin controllers
echo "🎮 Admin Controllers: ";
$controllers = glob('app/Http/Controllers/Admin/*.php');
echo "✅ " . count($controllers) . " controllers found\n";

// Check admin views
echo "👁️ Admin Views: ";
$views = glob('resources/views/admin/**/*.blade.php');
echo "✅ " . count($views) . " view files found\n";

// Check routes
echo "🛣️ Admin Routes: ";
$output = shell_exec('php artisan route:list --name=admin | wc -l');
echo "✅ " . trim($output) . " routes registered\n";

// Check migrations
echo "🗃️ Migrations: ";
$output = shell_exec('php artisan migrate:status | grep "Ran" | wc -l');
echo "✅ " . trim($output) . " migrations completed\n";

// Check cache status
echo "⚡ Cache Status: ";
if (file_exists('bootstrap/cache/config.php')) {
    echo "✅ Cached\n";
} else {
    echo "⚠️ Not cached (run php artisan config:cache)\n";
}

echo "\n🎉 Health check completed!\n";
echo "💡 Untuk optimasi, jalankan: scripts/optimize-admin.ps1\n";
