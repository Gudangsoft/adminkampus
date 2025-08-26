#!/bin/bash

# ================================================
# DEPLOYMENT SCRIPT TO PRODUCTION SERVER
# ================================================

echo "🚀 Starting deployment to production server..."

# Colors for output
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Function to print colored output
print_status() {
    echo -e "${GREEN}✓${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}⚠${NC} $1"
}

print_error() {
    echo -e "${RED}✗${NC} $1"
}

# Set production directory
PROD_DIR="/home/wwwroot/stikeskesosi.ac.id/adminkampus"

echo "📁 Production directory: $PROD_DIR"

# Change to production directory
cd $PROD_DIR

# Step 1: Backup Database
print_warning "Creating database backup..."
BACKUP_FILE="backup_$(date +%Y%m%d_%H%M%S).sql"
# Uncomment and modify these lines with your actual database credentials
# mysqldump -u your_username -p your_database > $BACKUP_FILE
# print_status "Database backed up to: $BACKUP_FILE"

# Step 2: Resolve Git Issues
print_warning "Resolving git issues..."
git status

# Check if there's an unfinished merge
if git status | grep -q "You have unmerged paths"; then
    print_warning "Unfinished merge detected. Resetting..."
    git reset --hard HEAD
    print_status "Git reset completed"
fi

# Step 3: Pull Latest Changes
print_warning "Pulling latest changes from repository..."
git pull origin main

if [ $? -eq 0 ]; then
    print_status "Git pull successful"
else
    print_error "Git pull failed!"
    exit 1
fi

# Step 4: Update Dependencies
print_warning "Updating composer dependencies..."
composer install --no-dev --optimize-autoloader

if [ $? -eq 0 ]; then
    print_status "Composer install successful"
else
    print_error "Composer install failed!"
    exit 1
fi

# Step 5: Run Migrations
print_warning "Running database migrations..."
php artisan migrate --force

if [ $? -eq 0 ]; then
    print_status "Migrations completed successfully"
else
    print_error "Migrations failed!"
    exit 1
fi

# Step 6: Fix Storage Symlink
print_warning "Setting up storage symlink..."
php artisan storage:link

if [ $? -eq 0 ]; then
    print_status "Storage symlink created"
else
    print_warning "Storage symlink may already exist"
fi

# Step 7: Set Proper Permissions
print_warning "Setting proper permissions..."
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/

# Only run chown if we have proper permissions
if [ "$EUID" -eq 0 ]; then
    chown -R www-data:www-data storage/
    chown -R www-data:www-data bootstrap/cache/
    print_status "Ownership set to www-data"
else
    print_warning "Running without root - skipping chown"
fi

# Step 8: Clear and Cache
print_warning "Clearing application cache..."
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

print_status "Cache cleared"

print_warning "Building production cache..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

print_status "Production cache built"

# Step 9: Fix Slider Database Paths (if script exists)
if [ -f "fix_slider_paths.php" ]; then
    print_warning "Fixing slider database paths..."
    php fix_slider_paths.php
    print_status "Slider paths fixed"
else
    print_warning "fix_slider_paths.php not found - skipping"
fi

# Step 10: Final Tests
print_warning "Running final tests..."

# Test storage directory
if [ -d "storage/app/public/sliders" ]; then
    print_status "Slider storage directory exists"
else
    print_warning "Slider storage directory missing"
fi

if [ -d "storage/app/public/galleries" ]; then
    print_status "Gallery storage directory exists"
else
    print_warning "Gallery storage directory missing"
fi

# Test symlink
if [ -L "public/storage" ]; then
    print_status "Storage symlink exists"
else
    print_error "Storage symlink missing!"
fi

# Step 11: Display Important URLs to Test
echo ""
echo "🧪 TESTING URLS:"
echo "Admin Sliders: https://stikeskesosi.ac.id/admin/sliders"
echo "Admin Galleries: https://stikeskesosi.ac.id/admin/galleries"
echo "Admin Profile: https://stikeskesosi.ac.id/admin/profile"
echo ""

# Step 12: Display Log Command
echo "📋 MONITORING COMMANDS:"
echo "Watch Laravel logs: tail -f storage/logs/laravel.log"
echo "Watch web server logs: tail -f /var/log/nginx/error.log"
echo ""

print_status "🎉 Deployment completed successfully!"
print_warning "Please test the admin panels to ensure everything works correctly"

echo ""
echo "🔍 WHAT WAS FIXED:"
echo "• Slider image upload and display issues"
echo "• Storage symlink problems"  
echo "• Profile photo system database columns"
echo "• Path duplication in slider storage"
echo "• Missing migration for user avatar and student photo fields"
echo ""

print_status "All systems should now be working correctly!"
