<?php
echo "🎯 FINAL LIVE CHAT DIAGNOSIS\n";
echo "============================\n\n";

// 1. Configuration Check
echo "1. ✅ KONFIGURASI CHAT:\n";
$config = include 'config/live-chat.php';
echo "   - Status: " . ($config['enabled'] ? '🟢 AKTIF' : '🔴 NONAKTIF') . "\n";
echo "   - Posisi: " . ($config['position'] ?? 'right') . "\n";
echo "   - Judul: " . ($config['button_text'] ?? 'Default') . "\n";
echo "   - Auto Responses: " . count($config['auto_responses'] ?? []) . " items\n\n";

// 2. File Structure Check
echo "2. ✅ STRUKTUR FILE:\n";
$files = [
    'resources/views/components/live-chat.blade.php' => 'Chat Component',
    'config/live-chat.php' => 'Config File',
    'resources/views/layouts/app.blade.php' => 'Main Layout'
];

foreach ($files as $file => $description) {
    if (file_exists($file)) {
        echo "   ✅ $description: Ada\n";
    } else {
        echo "   ❌ $description: Tidak ada\n";
    }
}
echo "\n";

// 3. Layout Integration Check
echo "3. ✅ INTEGRASI LAYOUT:\n";
$layoutContent = file_get_contents('resources/views/layouts/app.blade.php');
if (strpos($layoutContent, '@include(\'components.live-chat\')') !== false) {
    echo "   ✅ Component disertakan di layout\n";
} else {
    echo "   ❌ Component tidak disertakan di layout\n";
}

if (strpos($layoutContent, 'alpinejs') !== false) {
    echo "   ✅ Alpine.js script dimuat\n";
} else {
    echo "   ❌ Alpine.js script tidak dimuat\n";
}
echo "\n";

// 4. Component Content Check
echo "4. ✅ KONTEN COMPONENT:\n";
$componentContent = file_get_contents('resources/views/components/live-chat.blade.php');
$checks = [
    '@if($isEnabled)' => 'Kondisi aktif',
    'x-data=' => 'Alpine.js data',
    'chat-toggle' => 'Toggle button',
    'z-index: 9999' => 'Z-index tinggi',
    'position: fixed' => 'Fixed positioning'
];

foreach ($checks as $search => $description) {
    if (strpos($componentContent, $search) !== false) {
        echo "   ✅ $description: Ada\n";
    } else {
        echo "   ❌ $description: Tidak ada\n";
    }
}
echo "\n";

// 5. Compiled Views Check
echo "5. ✅ COMPILED VIEWS:\n";
$compiledDir = 'storage/framework/views/';
$found = false;
if (is_dir($compiledDir)) {
    $files = glob($compiledDir . '*.php');
    foreach ($files as $file) {
        $content = file_get_contents($file);
        if (strpos($content, 'chat-widget') !== false) {
            echo "   ✅ Compiled view: " . basename($file) . "\n";
            $found = true;
            break;
        }
    }
}
if (!$found) {
    echo "   ⚠️  Compiled view tidak ditemukan\n";
}
echo "\n";

// 6. Test URLs
echo "6. 🌐 TEST URLS:\n";
echo "   📱 Homepage: http://127.0.0.1:8000/\n";
echo "   🔧 Test Page: http://127.0.0.1:8000/chat-test-page\n";
echo "   ⚡ Simple Test: http://127.0.0.1:8000/simple-chat-test.html\n";
echo "   🎛️  Admin Components: http://127.0.0.1:8000/admin/components\n\n";

// 7. Troubleshooting Steps
echo "7. 🔧 LANGKAH TROUBLESHOOTING:\n";
echo "   1. Buka Developer Tools (F12) di browser\n";
echo "   2. Cek tab Console untuk error JavaScript\n";
echo "   3. Cek tab Network untuk failed requests\n";
echo "   4. Cek tab Elements untuk melihat DOM\n";
echo "   5. Search 'chat-widget' di Elements tab\n\n";

// 8. Commands to run
echo "8. 🚀 PERINTAH UNTUK DIJALANKAN:\n";
echo "   php artisan view:clear\n";
echo "   php artisan config:clear\n";
echo "   php artisan route:clear\n";
echo "   php artisan cache:clear\n\n";

// 9. What to look for
echo "9. 👁️  APA YANG HARUS DICARI:\n";
echo "   - Chat button di pojok kanan bawah\n";
echo "   - Warna: Gradient biru-ungu (#667eea to #764ba2)\n";
echo "   - Text: 'Butuh Bantuan?'\n";
echo "   - Icon: Font Awesome comments icon\n";
echo "   - Posisi: Fixed, bottom: 20px, right: 20px\n";
echo "   - Z-index: 9999 (sangat tinggi)\n\n";

echo "🎉 DIAGNOSIS SELESAI!\n";
echo "Jika chat masih tidak muncul, kemungkinan:\n";
echo "1. Konflik CSS dari template lain\n";
echo "2. JavaScript error yang menghalangi Alpine.js\n";
echo "3. Browser cache yang perlu dibersihkan\n";
echo "4. Extension browser yang memblokir\n\n";
echo "💡 Coba buka website di Incognito/Private mode!\n";
?>
