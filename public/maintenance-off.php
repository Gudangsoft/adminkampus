<?php
// Test script untuk mematikan maintenance mode
require_once __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Setting;

// Matikan maintenance mode
Setting::updateOrCreate(['key' => 'maintenance_mode'], ['value' => '0']);

echo "Maintenance mode deactivated successfully!\n";
echo "Website sekarang dapat diakses normal.\n";
?>
