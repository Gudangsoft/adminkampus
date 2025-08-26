#!/bin/bash

# EMERGENCY FIX SCRIPT FOR PRODUCTION ERRORS

echo "🚨 EMERGENCY FIX - Production Errors"
echo "=================================="

# Set production directory
PROD_DIR="/home/wwwroot/stikeskesosi.ac.id/adminkampus"
cd $PROD_DIR

echo "📁 Current directory: $(pwd)"

# Step 1: Clear all cache first
echo "🧹 Clearing all cache..."
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# Step 2: Clear bootstrap cache
echo "🗑️ Clearing bootstrap cache..."
rm -rf bootstrap/cache/routes-v7.php
rm -rf bootstrap/cache/config.php
rm -rf bootstrap/cache/services.php

# Step 3: Regenerate autoload
echo "🔄 Regenerating autoload..."
composer dump-autoload --optimize

# Step 4: Clear vendor cache
echo "🧽 Clearing vendor cache..."
rm -rf vendor/composer/autoload_*.php
composer install --no-dev --optimize-autoloader

# Step 5: Rebuild Laravel cache
echo "🏗️ Rebuilding Laravel cache..."
php artisan config:cache
php artisan route:cache

# Step 6: Check for syntax errors
echo "🔍 Checking for syntax errors..."
php -l app/Http/Controllers/Admin/SettingsController.php

# Step 7: Test basic artisan commands
echo "🧪 Testing artisan commands..."
php artisan --version

echo "✅ Emergency fix completed!"
echo "🔄 Please try accessing the admin panel again"
