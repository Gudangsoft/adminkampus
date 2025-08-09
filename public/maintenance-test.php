<?php
// Test script untuk maintenance mode
require_once __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Setting;

// Aktifkan maintenance mode
Setting::updateOrCreate(['key' => 'maintenance_mode'], ['value' => '1']);
Setting::updateOrCreate(['key' => 'maintenance_title'], ['value' => 'Website Sedang Maintenance']);
Setting::updateOrCreate(['key' => 'maintenance_message'], ['value' => 'Mohon maaf, website sedang dalam perbaikan sistem. Admin tetap dapat mengakses panel admin.']);

echo "Maintenance mode activated successfully!\n";
echo "Visit: http://127.0.0.1:8000 (akan show maintenance page)\n";
echo "Visit: http://127.0.0.1:8000/admin (admin tetap bisa akses)\n";
?>
