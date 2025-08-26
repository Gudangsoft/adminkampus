#!/bin/bash

echo "=== CLEARING CORRUPTED CACHE FILES ==="

# Stop here if any command fails
set -e

# 1. Force remove all cached files
echo "1. Removing corrupted cache files..."
rm -f bootstrap/cache/routes-v7.php
rm -f bootstrap/cache/config.php
rm -f bootstrap/cache/services.php
rm -f bootstrap/cache/packages.php

# 2. Clear storage cache
echo "2. Clearing storage cache..."
rm -rf storage/framework/cache/data/*
rm -rf storage/framework/sessions/*
rm -rf storage/framework/views/*

# 3. Clear Laravel application cache
echo "3. Clearing Laravel caches..."
php artisan cache:clear || echo "Cache clear failed, continuing..."
php artisan config:clear || echo "Config clear failed, continuing..."
php artisan route:clear || echo "Route clear failed, continuing..."
php artisan view:clear || echo "View clear failed, continuing..."

# 4. Regenerate composer autoload
echo "4. Regenerating autoload files..."
composer dump-autoload --optimize --no-dev

# 5. Rebuild only essential caches (avoid route:cache if it causes issues)
echo "5. Rebuilding safe caches..."
php artisan config:cache

# 6. Test if routes work without caching first
echo "6. Testing application without route cache..."
php artisan route:list | head -5

echo "=== CACHE CLEANUP COMPLETE ==="
echo "Try accessing the site now. If it works, you can optionally run 'php artisan route:cache' later."
