#!/bin/bash

echo "=== EMERGENCY DEPLOYMENT FIX ==="
echo "Fixing PSR-4 autoloading and cache issues..."

# 1. Pull latest changes
echo "1. Pulling latest changes from Git..."
git pull origin main

# 2. Clear all Laravel caches
echo "2. Clearing all Laravel caches..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# 3. Regenerate composer autoload with optimization
echo "3. Regenerating composer autoload..."
composer dump-autoload --optimize --no-dev

# 4. Rebuild caches
echo "4. Rebuilding optimized caches..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 5. Run migrations (if needed)
echo "5. Running any pending migrations..."
php artisan migrate --force

# 6. Set proper storage permissions
echo "6. Setting storage permissions..."
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# 7. Create storage symlink if needed
echo "7. Creating storage symlink..."
php artisan storage:link

echo "=== DEPLOYMENT FIX COMPLETE ==="
echo "The PSR-4 autoloading issue should now be resolved."
echo "Test the application: https://stikeskesosi.ac.id"
