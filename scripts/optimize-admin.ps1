# Admin System Optimization Script
# Jalankan script ini secara berkala untuk menjaga performa admin

Write-Host "Mengoptimalkan Sistem Admin..." -ForegroundColor Green

# Clear all caches
Write-Host "Membersihkan cache..." -ForegroundColor Yellow
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Rebuild optimized caches
Write-Host "Membangun cache optimal..." -ForegroundColor Yellow
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Optimize autoloader
Write-Host "Mengoptimalkan autoloader..." -ForegroundColor Yellow
composer dump-autoload -o

Write-Host "Optimasi selesai!" -ForegroundColor Green
Write-Host "Admin system ready untuk production" -ForegroundColor Cyan
