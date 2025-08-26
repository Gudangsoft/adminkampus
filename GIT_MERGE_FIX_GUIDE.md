# GIT MERGE CONFLICT RESOLUTION - SERVER ONLINE

## 🚨 MASALAH YANG TERJADI:
```
error: You have not concluded your merge (MERGE_HEAD exists).
hint: Please, commit your changes before merging.
fatal: Exiting because of unfinished merge.
```

## ✅ SOLUSI LANGKAH DEMI LANGKAH:

### Langkah 1: Masuk ke Server
```bash
ssh username@your-server.com
cd /home/wwwroot/stikeskesosi.ac.id/adminkampus
```

### Langkah 2: Cek Status Git
```bash
git status
```

### Langkah 3: Lihat File yang Konflik (jika ada)
```bash
git diff --name-only --diff-filter=U
```

### Langkah 4: SOLUSI A - Selesaikan Merge (Jika Ingin Lanjutkan Merge)
```bash
# Jika tidak ada konflik, commit merge
git add .
git commit -m "Resolve merge conflicts and complete merge"

# Atau jika ada konflik, edit file manual lalu:
git add .
git commit -m "Resolve merge conflicts"
```

### Langkah 5: SOLUSI B - Batalkan Merge (Recommended)
```bash
# Batalkan merge yang belum selesai
git merge --abort

# Reset ke kondisi clean
git reset --hard HEAD

# Pull ulang dengan strategy
git pull origin main --strategy=recursive -X ours
```

### Langkah 6: Verifikasi Hasil
```bash
git status
git log --oneline -5
```

### Langkah 7: Update Dependencies (Jika Diperlukan)
```bash
composer install --no-dev --optimize-autoloader
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 🔧 ALTERNATIF SOLUSI CEPAT:

### Reset Hard ke Remote
```bash
git fetch origin
git reset --hard origin/main
git clean -fd
```

### Force Pull
```bash
git fetch --all
git reset --hard origin/main
```

## ⚠️ CATATAN PENTING:
- Backup file penting sebelum reset hard
- Pastikan tidak ada perubahan local yang belum di-commit
- Setelah selesai, test website untuk memastikan berfungsi normal

## 🚀 QUICK COMMAND SEQUENCE:
```bash
cd /home/wwwroot/stikeskesosi.ac.id/adminkampus
git merge --abort
git reset --hard HEAD
git pull origin main
php artisan config:cache
php artisan view:cache
```
