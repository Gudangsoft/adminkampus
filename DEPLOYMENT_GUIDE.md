# PANDUAN UPLOAD PRODUCTION YANG AMAN

## 1. PERSIAPAN DI DEVELOPMENT

### A. Pastikan Semua Fix Sudah Commit Local
```bash
# Di D:\LARAVEL\adminkampus
git status
git add .
git commit -m "Fix: Slider image upload and profile photo system ready"
```

### B. Push ke Repository
```bash
git push origin main
```

## 2. DEPLOYMENT KE PRODUCTION SERVER

### A. Login ke Server Production
```bash
ssh ubuntu@vm1226710.contaboserver.net
cd /home/wwwroot/stikeskesosi.ac.id/adminkampus
```

### B. Backup Database (PENTING!)
```bash
# Backup database sebelum update
mysqldump -u username -p database_name > backup_$(date +%Y%m%d_%H%M%S).sql
```

### C. Selesaikan Git Issues
```bash
# Cek status git
git status

# Jika ada unfinished merge
git reset --hard HEAD

# Pull changes terbaru
git pull origin main
```

### D. Update Dependencies
```bash
# Update composer
composer install --no-dev --optimize-autoloader

# Update npm jika ada perubahan
npm install --production
npm run production
```

### E. Run Migrations
```bash
# Run migrations untuk photo columns yang baru ditambahkan
php artisan migrate --force

# Jika ada error, cek migration status
php artisan migrate:status
```

### F. Fix Storage Issues
```bash
# Pastikan storage symlink
php artisan storage:link

# Set permissions yang benar
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
chown -R www-data:www-data storage/
chown -R www-data:www-data bootstrap/cache/
```

### G. Clear Cache
```bash
# Clear semua cache
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# Optimize for production
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 3. FILES YANG HARUS DI-UPLOAD

### Files yang Berubah (Slider Fix):
- `app/Http/Controllers/Admin/SliderController.php`
- `app/Models/Slider.php`
- `database/migrations/2025_08_26_000001_add_missing_photo_fields.php`

### Script Fix Database:
- `fix_slider_paths.php` (untuk fix path database)

## 4. TESTING DI PRODUCTION

### A. Test Storage Access
```bash
# Test URL gambar
curl -I https://stikeskesosi.ac.id/storage/sliders/filename.jpg
curl -I https://stikeskesosi.ac.id/storage/galleries/images/filename.jpg
```

### B. Test Admin Panels
- https://stikeskesosi.ac.id/admin/sliders
- https://stikeskesosi.ac.id/admin/galleries
- https://stikeskesosi.ac.id/admin/profile

## 5. JIKA ADA MASALAH

### Rollback Plan:
```bash
# Restore database backup
mysql -u username -p database_name < backup_YYYYMMDD_HHMMSS.sql

# Reset git ke commit sebelumnya
git reset --hard HEAD~1
```

### Debug Issues:
```bash
# Cek log Laravel
tail -f storage/logs/laravel.log

# Cek web server logs
tail -f /var/log/nginx/error.log
# atau
tail -f /var/log/apache2/error.log
```

## 6. COMMAND SEQUENCE LENGKAP

```bash
# STEP 1: Development
cd D:\LARAVEL\adminkampus
git add .
git commit -m "Slider and profile photo fixes"
git push origin main

# STEP 2: Production Server  
ssh ubuntu@vm1226710.contaboserver.net
cd /home/wwwroot/stikeskesosi.ac.id/adminkampus

# Backup first
mysqldump -u username -p database_name > backup_$(date +%Y%m%d_%H%M%S).sql

# Reset git issues
git reset --hard HEAD
git pull origin main

# Update system
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan storage:link

# Set permissions
chmod -R 755 storage/ bootstrap/cache/
chown -R www-data:www-data storage/ bootstrap/cache/

# Clear cache
php artisan config:clear && php artisan route:clear && php artisan view:clear && php artisan cache:clear
php artisan config:cache && php artisan route:cache && php artisan view:cache

# STEP 3: Fix slider database (if needed)
php fix_slider_paths.php
```

## 7. VERIFIKASI SUKSES

✅ Admin slider dapat upload gambar
✅ Gambar slider tampil di frontend  
✅ Admin gallery berfungsi normal
✅ Profile photo upload ready
✅ Tidak ada error di log

## PERINGATAN ⚠️

1. **SELALU BACKUP DATABASE** sebelum deployment
2. **TEST DI STAGING** jika ada environment staging
3. **DEPLOY SAAT TRAFFIC RENDAH** (malam/dini hari)
4. **MONITOR LOG** setelah deployment
5. **SIAPKAN ROLLBACK PLAN** jika ada masalah
