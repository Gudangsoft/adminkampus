# Database Backup & Restore Guide

## 📋 Backup Methods

Tersedia beberapa cara untuk melakukan backup database G0-CAMPUS:

### 1. Laravel Artisan Command (Recommended)

```bash
# Backup biasa
php artisan backup:database

# Backup dengan kompresi (lebih kecil ukuran file)
php artisan backup:database --compress
```

### 2. PowerShell Script

```powershell
# Jalankan script backup
.\scripts\backup-database.ps1
```

### 3. Batch Script (Windows)

```batch
# Jalankan script backup
scripts\backup-database.bat
```

### 4. Manual mysqldump

```bash
# Backup biasa
mysqldump -u root -h 127.0.0.1 --port=3306 --single-transaction --routines --triggers g0_campus > backup.sql

# Backup dengan kompresi
mysqldump -u root -h 127.0.0.1 --port=3306 --single-transaction --routines --triggers g0_campus | gzip > backup.sql.gz
```

## 📁 Lokasi Backup

Semua backup disimpan di: `storage/backups/`

Format nama file:
- `g0_campus_backup_YYYYMMDD_HHMMSS.sql` (uncompressed)
- `g0_campus_backup_YYYYMMDD_HHMMSS.sql.gz` (compressed)

## 🔄 Restore Database

### 1. Restore dari file .sql

```bash
mysql -u root -h 127.0.0.1 --port=3306 g0_campus < storage/backups/g0_campus_backup_20250809_172442.sql
```

### 2. Restore dari file .sql.gz

```bash
# Decompress dan restore
zcat storage/backups/g0_campus_backup_20250809_172442.sql.gz | mysql -u root -h 127.0.0.1 --port=3306 g0_campus

# Atau decompress terlebih dahulu
gunzip storage/backups/g0_campus_backup_20250809_172442.sql.gz
mysql -u root -h 127.0.0.1 --port=3306 g0_campus < storage/backups/g0_campus_backup_20250809_172442.sql
```

### 3. Restore dengan PowerShell

```powershell
# Untuk file .sql
Get-Content "storage\backups\g0_campus_backup_20250809_172442.sql" | mysql -u root -h 127.0.0.1 --port=3306 g0_campus

# Untuk file .sql.gz (perlu extract dulu)
```

## ⚙️ Konfigurasi Database

Pastikan konfigurasi database di `.env` sudah benar:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=g0_campus
DB_USERNAME=root
DB_PASSWORD=
```

## 🗂️ Backup Management

### Auto Cleanup
Script backup otomatis menghapus backup lama dan hanya menyimpan 10 backup terbaru.

### Manual Cleanup
```bash
# Hapus backup yang lebih dari 30 hari
find storage/backups -name "*.sql*" -mtime +30 -delete
```

## 📊 Ukuran Backup

- **Uncompressed**: ~185 KB (full database)
- **Compressed (gzip)**: ~42 KB (kompresi ~77%)

## ⏰ Scheduled Backup

Untuk backup otomatis, tambahkan ke Windows Task Scheduler atau cron job:

### Windows Task Scheduler
1. Buka Task Scheduler
2. Create Basic Task
3. Set trigger (daily/weekly)
4. Action: Start a program
5. Program: `powershell.exe`
6. Arguments: `-File "D:\PROJECT-KAMPUS\scripts\backup-database.ps1"`

### Laravel Scheduler (jika dibutuhkan)
Tambahkan ke `app/Console/Kernel.php`:

```php
protected function schedule(Schedule $schedule)
{
    // Backup harian pada jam 2 pagi
    $schedule->command('backup:database --compress')->dailyAt('02:00');
}
```

## 🚨 Important Notes

1. **Backup Sebelum Update**: Selalu backup sebelum melakukan update database atau aplikasi
2. **Test Restore**: Secara berkala test restore untuk memastikan backup valid
3. **Multiple Locations**: Simpan backup di multiple lokasi untuk keamanan
4. **Permission**: Pastikan MySQL user memiliki permission untuk backup/restore

## 📞 Troubleshooting

### Error: mysqldump command not found
- Install MySQL/MariaDB client
- Tambahkan MySQL bin directory ke PATH

### Error: Access denied
- Periksa username/password database
- Pastikan user memiliki privilege SELECT, LOCK TABLES, SHOW VIEW

### Error: gzip command not found
- Install gzip untuk Windows atau gunakan backup tanpa kompresi
