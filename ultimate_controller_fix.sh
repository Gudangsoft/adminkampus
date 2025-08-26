#!/bin/bash

echo "=== ULTIMATE FIX FOR ALL MISSING CONTROLLERS ==="

# 1. Force pull latest changes
echo "1. Force pulling latest changes..."
git fetch origin
git reset --hard origin/main

# 2. Create UserController manually if missing
echo "2. Ensuring UserController exists..."
if [ ! -f "app/Http/Controllers/Admin/UserController.php" ] || [ ! -s "app/Http/Controllers/Admin/UserController.php" ]; then
    mkdir -p app/Http/Controllers/Admin
    cat > app/Http/Controllers/Admin/UserController.php << 'EOF'
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully!');
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ];

        if ($request->filled('password')) {
            $rules['password'] = 'required|string|min:8|confirmed';
        }

        $request->validate($rules);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully!');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully!');
    }
}
EOF
    echo "✅ UserController created"
else
    echo "✅ UserController already exists"
fi

# 3. Create SitemapController manually if missing
echo "3. Ensuring SitemapController exists..."
if [ ! -f "app/Http/Controllers/SitemapController.php" ] || [ ! -s "app/Http/Controllers/SitemapController.php" ]; then
    cat > app/Http/Controllers/SitemapController.php << 'EOF'
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SitemapController extends Controller
{
    public function index()
    {
        $sitemap = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"></urlset>';
        
        return response($sitemap, 200)->header('Content-Type', 'application/xml');
    }
    
    public function robots()
    {
        $robots = "User-agent: *\nAllow: /\n";
        return response($robots, 200)->header('Content-Type', 'text/plain');
    }
}
EOF
    echo "✅ SitemapController created"
else
    echo "✅ SitemapController already exists"
fi

# 4. Nuclear cache clear
echo "4. Nuclear cache clearing..."
rm -rf bootstrap/cache/*
rm -rf storage/framework/cache/data/*
rm -rf storage/framework/sessions/*
rm -rf storage/framework/views/*

# 5. Clear Laravel caches
echo "5. Clearing Laravel caches..."
php artisan cache:clear || echo "Cache clear failed, continuing..."
php artisan config:clear || echo "Config clear failed, continuing..."
php artisan route:clear || echo "Route clear failed, continuing..."
php artisan view:clear || echo "View clear failed, continuing..."

# 6. Regenerate autoload
echo "6. Regenerating autoload..."
composer dump-autoload --optimize --no-dev

# 7. Test individual classes
echo "7. Testing controller classes..."
php -r "
require_once 'vendor/autoload.php';
\$controllers = [
    'App\Http\Controllers\SitemapController',
    'App\Http\Controllers\Admin\UserController'
];
foreach (\$controllers as \$class) {
    if (class_exists(\$class)) {
        echo '✅ ' . \$class . ' loaded successfully' . PHP_EOL;
    } else {
        echo '❌ ' . \$class . ' NOT FOUND' . PHP_EOL;
    }
}
"

# 8. Final test
echo "8. Final route list test..."
php artisan route:list | head -5

echo "=== ULTIMATE FIX COMPLETE ==="
echo "All missing controllers should now be available!"
