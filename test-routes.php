<?php
require_once 'vendor/autoload.php';

echo "🌐 LARAVEL ROUTE TESTING\n";
echo "=" . str_repeat("=", 80) . "\n";

try {
    // Check if we can load Laravel
    $app = require_once 'bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

    echo "\n1️⃣ LARAVEL APPLICATION STATUS:\n";
    echo "-" . str_repeat("-", 60) . "\n";
    echo "✅ Laravel application loaded successfully\n";
    echo "✅ Kernel initialized\n";

    echo "\n2️⃣ ROUTE TESTING:\n";
    echo "-" . str_repeat("-", 60) . "\n";

    // Test routes
    $routes = [
        'Home' => '/',
        'Admin Login' => '/admin/login',
        'Component Login' => '/component/login',
        'Admin Dashboard' => '/admin',
        'Component Management' => '/admin/components'
    ];

    foreach ($routes as $name => $path) {
        echo "🔗 {$name}: http://127.0.0.1:8001{$path}\n";
    }

    echo "\n3️⃣ CONTROLLER FILES CHECK:\n";
    echo "-" . str_repeat("-", 60) . "\n";

    $controllers = [
        'Admin\\AuthController' => 'app/Http/Controllers/Admin/AuthController.php',
        'Component\\AuthController' => 'app/Http/Controllers/Component/AuthController.php', 
        'ComponentController' => 'app/Http/Controllers/ComponentController.php',
        'GlobalAuthController' => 'app/Http/Controllers/GlobalAuthController.php'
    ];

    foreach ($controllers as $name => $path) {
        if (file_exists($path)) {
            echo "✅ {$name}: {$path}\n";
        } else {
            echo "❌ {$name}: {$path} (MISSING)\n";
        }
    }

    echo "\n4️⃣ VIEW FILES CHECK:\n";
    echo "-" . str_repeat("-", 60) . "\n";

    $views = [
        'Admin Login' => 'resources/views/admin/auth/login.blade.php',
        'Component Login' => 'resources/views/component/auth/login.blade.php',
        'Admin Layout' => 'resources/views/layouts/admin.blade.php',
        'Component Layout' => 'resources/views/admin/layouts/app.blade.php'
    ];

    foreach ($views as $name => $path) {
        if (file_exists($path)) {
            echo "✅ {$name}: {$path}\n";
        } else {
            echo "❌ {$name}: {$path} (MISSING)\n";
        }
    }

    echo "\n5️⃣ CONFIGURATION CHECK:\n";
    echo "-" . str_repeat("-", 60) . "\n";

    // Check important config files
    $configs = [
        'auth' => 'config/auth.php',
        'database' => 'config/database.php',
        'app' => 'config/app.php'
    ];

    foreach ($configs as $name => $path) {
        if (file_exists($path)) {
            echo "✅ {$name}: {$path}\n";
        } else {
            echo "❌ {$name}: {$path} (MISSING)\n";
        }
    }

    echo "\n6️⃣ SERVER STATUS:\n";
    echo "-" . str_repeat("-", 60) . "\n";
    echo "🔥 Laravel Development Server: http://127.0.0.1:8001\n";
    echo "📝 Test URLs:\n";
    echo "   • Homepage: http://127.0.0.1:8001\n";
    echo "   • Admin Login: http://127.0.0.1:8001/admin/login\n";
    echo "   • Component Login: http://127.0.0.1:8001/component/login\n";

    echo "\n7️⃣ TROUBLESHOOTING:\n";
    echo "-" . str_repeat("-", 60) . "\n";
    echo "🔧 If still can't access:\n";
    echo "   • Clear browser cache\n";
    echo "   • Try different browser\n";
    echo "   • Check Windows Firewall\n";
    echo "   • Try http://localhost:8001/admin/login\n";
    echo "   • Check if server is running: php artisan serve --port=8001\n";

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "🔧 Try running: php artisan serve --host=127.0.0.1 --port=8001\n";
}
