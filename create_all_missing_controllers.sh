#!/bin/bash

echo "=== CREATING ALL MISSING CONTROLLERS ==="

# Create directory structure
mkdir -p app/Http/Controllers/Admin

# List of controllers that might be missing based on routes
controllers=(
    "HomeController"
    "NewsController" 
    "AnnouncementController"
    "StudyProgramController"
    "StudentController"
    "GalleryController"
    "PageController"
    "SearchController"
)

admin_controllers=(
    "DashboardController"
    "NewsController"
    "NewsCategoryController"
    "AnnouncementController"
    "StudyProgramController"
    "LecturerController"
    "StudentController"
    "GalleryController"
    "SettingController"
    "SliderController"
    "PageController"
    "MenuController"
)

echo "1. Checking and creating main controllers..."
for controller in "${controllers[@]}"; do
    file="app/Http/Controllers/${controller}.php"
    if [ ! -f "$file" ] || [ ! -s "$file" ]; then
        echo "Creating $controller..."
        cat > "$file" << EOF
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class $controller extends Controller
{
    public function index()
    {
        // TODO: Implement index method
        return view('frontend.${controller,,}.index');
    }
    
    public function show(\$id)
    {
        // TODO: Implement show method
        return view('frontend.${controller,,}.show', compact('id'));
    }
}
EOF
    else
        echo "✅ $controller already exists"
    fi
done

echo "2. Checking and creating admin controllers..."
for controller in "${admin_controllers[@]}"; do
    file="app/Http/Controllers/Admin/${controller}.php"
    if [ ! -f "$file" ] || [ ! -s "$file" ]; then
        echo "Creating Admin\\$controller..."
        cat > "$file" << EOF
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class $controller extends Controller
{
    public function index()
    {
        // TODO: Implement index method
        return view('admin.${controller,,}.index');
    }
    
    public function create()
    {
        return view('admin.${controller,,}.create');
    }
    
    public function store(Request \$request)
    {
        // TODO: Implement store method
        return redirect()->route('admin.${controller,,}.index');
    }
    
    public function show(\$id)
    {
        // TODO: Implement show method
        return view('admin.${controller,,}.show', compact('id'));
    }
    
    public function edit(\$id)
    {
        // TODO: Implement edit method
        return view('admin.${controller,,}.edit', compact('id'));
    }
    
    public function update(Request \$request, \$id)
    {
        // TODO: Implement update method
        return redirect()->route('admin.${controller,,}.index');
    }
    
    public function destroy(\$id)
    {
        // TODO: Implement destroy method
        return redirect()->route('admin.${controller,,}.index');
    }
}
EOF
    else
        echo "✅ Admin\\$controller already exists"
    fi
done

echo "3. Force clearing all caches..."
rm -rf bootstrap/cache/*
php artisan cache:clear || echo "Cache clear failed"
php artisan config:clear || echo "Config clear failed"
php artisan route:clear || echo "Route clear failed"
php artisan view:clear || echo "View clear failed"

echo "4. Regenerating autoload..."
composer dump-autoload --optimize --no-dev

echo "5. Testing route list..."
php artisan route:list | head -10

echo "=== ALL CONTROLLERS CREATED ==="
