# G0-CAMPUS - Website Kampus Modern

Website kampus modern yang dibangun dengan Laravel 10 dan MySQL, dilengkapi dengan sistem CMS untuk manajemen konten yang lengkap.

## 🚀 Fitur Utama

### Frontend (Website Publik)
- **Halaman Beranda** - Banner slider, info kampus, berita terkini, testimoni alumni
- **Tentang Kampus** - Sejarah, visi & misi, struktur organisasi, akreditasi
- **Program Studi** - Daftar jurusan, kurikulum, dosen pengampu
- **Berita & Pengumuman** - Sistem berita dengan kategori dan pencarian
- **Galeri** - Foto dan video kegiatan kampus dengan kategori
- **Kontak** - Informasi kontak, alamat, peta lokasi

### Backend (Dashboard Admin)
- **Dashboard** - Statistik dan overview sistem
- **Manajemen Konten**
  - CRUD Berita dan kategori berita
  - CRUD Pengumuman dengan prioritas
  - CRUD Galeri dengan kategori
- **Manajemen Akademik**
  - CRUD Program Studi
  - CRUD Dosen dengan profile lengkap
  - CRUD Mahasiswa (data display)
- **Manajemen Website**
  - Pengaturan umum (logo, favicon, nama website)
  - Manajemen slider homepage
  - Manajemen menu navigasi
  - Pengaturan kontak dan media sosial
  - Kustomisasi warna tema

## 🛠️ Teknologi yang Digunakan

- **Backend**: Laravel 10 (PHP 8.1+)
- **Database**: MySQL 8.0+
- **Frontend**: Bootstrap 5, JavaScript
- **Image Processing**: Intervention Image
- **Authentication**: Laravel UI
- **Permissions**: Spatie Laravel Permission

## 📋 Persyaratan Sistem

- PHP >= 8.1
- Composer
- MySQL >= 8.0
- Node.js & NPM (untuk asset compilation)
- Apache/Nginx

## 🚀 Instalasi

### 1. Install Dependencies
```bash
composer install
```

### 2. Environment Setup
File .env sudah dikonfigurasi dengan:
```env
APP_NAME="G0-CAMPUS"
DB_DATABASE=g0_campus
```

### 3. Buat Database
```sql
CREATE DATABASE g0_campus;
```

### 4. Generate Key
```bash
php artisan key:generate
```

### 5. Migrasi dan Seeder
```bash
php artisan migrate
php artisan db:seed
```

### 6. Storage Link
```bash
php artisan storage:link
```

### 7. Jalankan Server
```bash
php artisan serve
```

Website akan dapat diakses di `http://localhost:8000`

## 🔐 Akun Default

**Administrator:**
- Email: `admin@g0-campus.ac.id`
- Password: `admin123`

**Content Editor:**
- Email: `editor@g0-campus.ac.id`
- Password: `editor123`

## 📁 Struktur yang Sudah Dibuat

✅ **Database Migrations:**
- news_categories, news, announcements
- faculties, study_programs, lecturers, students  
- gallery_categories, galleries, sliders
- pages, menus, settings

✅ **Models dengan Relationships:**
- News, NewsCategory, Announcement
- Faculty, StudyProgram, Lecturer, Student
- Gallery, GalleryCategory, Slider
- Page, Menu, Setting

✅ **Controllers:**
- Frontend: Home, News, Announcement, StudyProgram, Gallery, Page
- Admin: Dashboard, News, NewsCategory, Setting

✅ **Routes:**
- Frontend routes untuk semua halaman publik
- Admin routes dengan middleware auth

✅ **Seeders:**
- UserSeeder (admin accounts)
- SettingSeeder (website settings)
- FacultySeeder (sample faculties & study programs)
- NewsSeeder (sample news & categories)

✅ **Views:**
- Layout utama dengan Bootstrap 5
- Homepage dengan sections lengkap
- Helper functions untuk settings

## 🎯 Langkah Selanjutnya

Untuk melengkapi website, yang perlu ditambahkan:

1. **Admin Views** - Form CRUD untuk semua modules
2. **Frontend Views** - Halaman detail news, announcements, dll
3. **Image Uploads** - Implementasi upload gambar
4. **Authentication Views** - Login/logout forms
5. **Sample Images** - Default images untuk testing

## 🔧 Maintenance

### Clear Cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

---

**G0-CAMPUS** - *Website Kampus Modern dengan Laravel & MySQL* 🎓
