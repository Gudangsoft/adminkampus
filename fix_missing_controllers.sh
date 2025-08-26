#!/bin/bash

echo "=== FIXING MISSING CONTROLLERS ==="

# Stop on any error
set -e

# 1. Pull latest changes (including SitemapController fix)
echo "1. Pulling latest fixes from Git..."
git pull origin main

# 2. Clear route cache completely
echo "2. Clearing route cache..."
php artisan route:clear
rm -f bootstrap/cache/routes-v7.php

# 3. Clear other caches
echo "3. Clearing all caches..."
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# 4. Regenerate autoload
echo "4. Regenerating autoload..."
composer dump-autoload --optimize --no-dev

# 5. Test routes without cache
echo "5. Testing routes..."
php artisan route:list | head -10

# 6. Rebuild config cache only
echo "6. Rebuilding config cache..."
php artisan config:cache

echo "=== CONTROLLER FIX COMPLETE ==="
echo "Missing SitemapController has been created."
echo "Routes should now work properly."
