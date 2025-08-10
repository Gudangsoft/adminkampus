# Dokumentasi Fitur Sections

## Overview
Fitur Sections memungkinkan Anda membuat dan mengelola konten homepage secara dinamis melalui halaman admin. Anda dapat membuat berbagai jenis section dengan styling dan konten yang dapat dikustomisasi.

## Jenis Section

### 1. Hero Section
- **Digunakan untuk**: Header utama di homepage
- **Layout**: Dua kolom dengan teks di kiri dan icon/gambar di kanan
- **Styling**: Background berwarna dengan teks putih (default)
- **Field yang tersedia**: Title, Subtitle, Content, Icon/Image, Link

### 2. Content Section
- **Digunakan untuk**: Konten informasi umum
- **Layout**: Fleksibel dengan atau tanpa gambar
- **Styling**: Background putih atau custom
- **Field yang tersedia**: Title, Subtitle, Content, Icon/Image, Link

### 3. Feature Section
- **Digunakan untuk**: Menampilkan fitur/keunggulan dalam card
- **Layout**: Card dengan gambar/icon dan teks
- **Styling**: Card dengan shadow
- **Field yang tersedia**: Title, Subtitle, Content, Icon/Image, Link

### 4. Call to Action (CTA)
- **Digunakan untuk**: Mengajak pengunjung melakukan aksi
- **Layout**: Terpusat dengan button prominent
- **Styling**: Background abu-abu muda (default)
- **Field yang tersedia**: Title, Subtitle, Content, Link dengan tombol besar

### 5. Gallery Section
- **Digunakan untuk**: Menampilkan gambar atau galeri
- **Layout**: Gambar terpusat dengan deskripsi
- **Styling**: Minimalis dengan fokus pada gambar
- **Field yang tersedia**: Title, Subtitle, Content, Image, Link

## Cara Menggunakan

### 1. Akses Menu Sections
- Login ke admin panel
- Klik menu "Media" → "Sections"

### 2. Membuat Section Baru
- Klik tombol "Tambah Section"
- Pilih Type section sesuai kebutuhan
- Isi form:
  - **Title**: Judul utama section (wajib)
  - **Subtitle**: Subjudul atau tagline
  - **Content**: Konten teks utama
  - **Type**: Jenis section (wajib)
  - **Order**: Urutan tampil di homepage (wajib)
  - **Icon**: Font Awesome class (contoh: fas fa-heart)
  - **Image**: Upload gambar
  - **Link URL**: Link tujuan
  - **Link Text**: Teks tombol/link
  - **Background Color**: Warna background section
  - **Text Color**: Warna teks
  - **Status**: Aktif/Nonaktif

### 3. Mengurutkan Sections
- Drag & drop pada halaman index sections
- Atau edit field "Order" pada form edit

### 4. Edit/Hapus Section
- Gunakan tombol edit (ikon pensil) untuk mengubah
- Gunakan tombol hapus (ikon sampah) untuk menghapus

## Tips Penggunaan

### 1. Perencanaan Layout
- Gunakan **Hero Section** sebagai pembuka (order 1)
- Gunakan **Content Section** untuk informasi detail
- Gunakan **Feature Section** untuk keunggulan/fasilitas
- Gunakan **CTA Section** di akhir untuk ajakan bertindak

### 2. Styling
- **Background Color**: Gunakan warna yang kontras
- **Text Color**: Pastikan mudah dibaca
- **Icon**: Gunakan Font Awesome icons (contoh: fas fa-graduation-cap)

### 3. Content
- **Title**: Singkat dan menarik (max 60 karakter)
- **Subtitle**: Pelengkap title yang informatif
- **Content**: Deskripsi detail, gunakan enter untuk paragraph baru
- **Link**: Gunakan URL lengkap atau relative path

### 4. Order Management
- Mulai dari 1 untuk section pertama
- Gunakan kelipatan 10 (10, 20, 30) untuk memudahkan penyisipan

## Integrasi dengan Homepage

### Fallback Content
Jika tidak ada section yang aktif, homepage akan menampilkan konten default (layout lama).

### Custom Styling
Setiap section dapat memiliki:
- Background color custom
- Text color custom
- Icon Font Awesome
- Image upload

### Responsive Design
Semua section otomatis responsive dan menggunakan Bootstrap 5 grid system.

## Contoh Penggunaan

```
Section 1 (Order: 1, Type: Hero)
- Title: "Selamat Datang di Kampus Kesehatan Terdepan"
- Subtitle: "Membentuk Profesional Kesehatan Masa Depan"
- Type: hero
- Background: #667eea
- Text Color: #ffffff

Section 2 (Order: 2, Type: Content)
- Title: "Mengapa Memilih Kami?"
- Subtitle: "Keunggulan yang Membedakan"
- Type: content

Section 3 (Order: 3, Type: CTA)
- Title: "Siap Bergabung?"
- Type: cta
- Link: "/daftar"
- Link Text: "Daftar Sekarang"
```

## Troubleshooting

### Section tidak muncul
- Pastikan status "Aktif" sudah dicentang
- Periksa field Order sudah diisi
- Clear cache browser

### Styling tidak sesuai
- Periksa Background Color dan Text Color
- Pastikan kontras warna cukup
- Test di berbagai ukuran layar

### Error saat upload gambar
- Pastikan file format: JPG, PNG, GIF
- Ukuran maksimal: 2MB
- Periksa permission folder storage
