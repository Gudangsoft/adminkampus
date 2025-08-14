<?php

require_once __DIR__ . '/vendor/autoload.php';

// Load Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\FAQ;

echo "🔄 Creating sample FAQ data...\n\n";

// Sample FAQ data
$faqs = [
    // Academic FAQs
    [
        'question' => 'Bagaimana cara mendaftar sebagai mahasiswa baru?',
        'answer' => 'Untuk mendaftar sebagai mahasiswa baru, Anda dapat mengikuti langkah-langkah berikut:<br><br>1. <strong>Akses Portal Pendaftaran:</strong> Kunjungi website resmi kampus dan klik menu "Pendaftaran Online"<br>2. <strong>Buat Akun:</strong> Daftar dengan email aktif dan buat password yang kuat<br>3. <strong>Lengkapi Data:</strong> Isi formulir pendaftaran dengan data diri yang valid<br>4. <strong>Upload Dokumen:</strong> Unggah scan ijazah, transkrip nilai, KTP, dan foto<br>5. <strong>Bayar Biaya Pendaftaran:</strong> Lakukan pembayaran sesuai instruksi<br>6. <strong>Cetak Bukti:</strong> Simpan bukti pendaftaran untuk keperluan administrasi<br><br>📞 <strong>Butuh bantuan?</strong> Hubungi hotline pendaftaran: (021) 123-4567',
        'category' => 'Akademik',
        'keywords' => ['pendaftaran', 'mahasiswa baru', 'daftar kuliah', 'admisi', 'registrasi'],
        'order' => 1,
        'is_active' => true
    ],
    [
        'question' => 'Kapan jadwal pendaftaran mahasiswa baru tahun ini?',
        'answer' => 'Jadwal pendaftaran mahasiswa baru untuk tahun akademik 2024/2025:<br><br><strong>📅 Gelombang 1:</strong><br>• Pendaftaran: 1 Februari - 31 Maret 2024<br>• Tes Masuk: 5-7 April 2024<br>• Pengumuman: 15 April 2024<br><br><strong>📅 Gelombang 2:</strong><br>• Pendaftaran: 1 Mei - 30 Juni 2024<br>• Tes Masuk: 5-7 Juli 2024<br>• Pengumuman: 15 Juli 2024<br><br><strong>📅 Gelombang 3:</strong><br>• Pendaftaran: 1 Agustus - 15 September 2024<br>• Tes Masuk: 20-22 September 2024<br>• Pengumuman: 30 September 2024<br><br>💡 <strong>Tips:</strong> Daftar di gelombang awal untuk mendapat prioritas pilihan program studi favorit!',
        'category' => 'Akademik',
        'keywords' => ['jadwal pendaftaran', 'timeline', 'gelombang', 'tahun akademik'],
        'order' => 2,
        'is_active' => true
    ],
    [
        'question' => 'Bagaimana cara mengecek nilai dan IPK?',
        'answer' => 'Untuk mengecek nilai dan IPK, ikuti panduan berikut:<br><br><strong>🔐 Login Portal Mahasiswa:</strong><br>1. Buka website kampus dan klik "Portal Mahasiswa"<br>2. Masukkan NIM dan password Anda<br>3. Jika lupa password, klik "Reset Password"<br><br><strong>📊 Akses Nilai:</strong><br>1. Setelah login, pilih menu "Akademik"<br>2. Klik "Nilai Semester" untuk melihat nilai per semester<br>3. Klik "Transkrip" untuk melihat keseluruhan nilai dan IPK<br><br><strong>📱 Fitur Tambahan:</strong><br>• Download transkrip dalam format PDF<br>• Lihat grafik perkembangan IPK<br>• Cek status SKS yang sudah diambil<br><br>❗ <strong>Catatan:</strong> Nilai akan tampil setelah dosen menginput dan admin memverifikasi nilai.',
        'category' => 'Akademik',
        'keywords' => ['nilai', 'IPK', 'transkrip', 'portal mahasiswa', 'cek nilai'],
        'order' => 3,
        'is_active' => true
    ],

    // Student Services FAQs
    [
        'question' => 'Bagaimana cara mengajukan beasiswa?',
        'answer' => 'Panduan lengkap pengajuan beasiswa:<br><br><strong>📋 Syarat Umum:</strong><br>• IPK minimal 3.0 (untuk beasiswa prestasi)<br>• Surat keterangan tidak mampu (untuk beasiswa ekonomi)<br>• Aktif dalam kegiatan kemahasiswaan<br>• Tidak sedang menerima beasiswa lain<br><br><strong>📝 Proses Pengajuan:</strong><br>1. <strong>Cek Info Beasiswa:</strong> Monitor pengumuman di website dan portal<br>2. <strong>Siapkan Dokumen:</strong> Transkrip, surat keterangan, proposal (jika diperlukan)<br>3. <strong>Submit Online:</strong> Upload dokumen melalui portal mahasiswa<br>4. <strong>Follow Up:</strong> Pantau status pengajuan secara berkala<br><br><strong>🎯 Jenis Beasiswa:</strong><br>• Beasiswa Prestasi Akademik<br>• Beasiswa Kurang Mampu<br>• Beasiswa Berprestasi<br>• Beasiswa Riset<br><br>📞 <strong>Kontak:</strong> Bagian Kemahasiswaan - (021) 234-5678',
        'category' => 'Layanan Mahasiswa',
        'keywords' => ['beasiswa', 'bantuan keuangan', 'prestasi', 'ekonomi', 'pengajuan'],
        'order' => 4,
        'is_active' => true
    ],
    [
        'question' => 'Bagaimana cara mendaftar asrama kampus?',
        'answer' => 'Informasi lengkap pendaftaran asrama kampus:<br><br><strong>🏠 Fasilitas Asrama:</strong><br>• Kamar ber-AC dengan 2-4 tempat tidur<br>• WiFi gratis 24 jam<br>• Kantin dan area belajar bersama<br>• Security 24 jam<br>• Laundry dan parkir<br><br><strong>📋 Syarat Pendaftaran:</strong><br>• Mahasiswa aktif dengan IPK min. 2.75<br>• Surat keterangan sehat<br>• Surat pernyataan taat peraturan<br>• Tidak pernah melanggar tata tertib kampus<br><br><strong>💰 Biaya per Semester:</strong><br>• Kamar 4 orang: Rp 1.500.000<br>• Kamar 2 orang: Rp 2.200.000<br>• Kamar single: Rp 3.000.000<br><br><strong>📅 Pendaftaran:</strong> Buka setiap awal semester melalui portal mahasiswa<br><br>📱 <strong>Virtual Tour:</strong> Lihat fasilitas asrama di website/virtual-tour',
        'category' => 'Layanan Mahasiswa',
        'keywords' => ['asrama', 'tempat tinggal', 'dormitory', 'fasilitas', 'biaya'],
        'order' => 5,
        'is_active' => true
    ],

    // Administrative FAQs
    [
        'question' => 'Bagaimana cara mengurus surat keterangan mahasiswa aktif?',
        'answer' => 'Panduan mengurus surat keterangan mahasiswa aktif:<br><br><strong>📝 Persyaratan:</strong><br>• Fotocopy KTM yang masih berlaku<br>• Fotocopy KTP<br>• Bukti pembayaran UKT semester berjalan<br>• Pas foto 3x4 terbaru (2 lembar)<br><br><strong>🏢 Prosedur:</strong><br>1. <strong>Datang ke TU Fakultas:</strong> Bawa semua persyaratan<br>2. <strong>Isi Formulir:</strong> Lengkapi formulir permohonan<br>3. <strong>Bayar Biaya Administrasi:</strong> Rp 25.000<br>4. <strong>Tunggu Proses:</strong> 2-3 hari kerja<br>5. <strong>Ambil Surat:</strong> Sesuai jadwal yang diberikan<br><br><strong>⚡ Layanan Express:</strong><br>• Biaya: Rp 50.000<br>• Waktu: 1 hari kerja<br>• Tersedia untuk kebutuhan mendesak<br><br><strong>🕒 Jam Layanan:</strong><br>Senin-Jumat: 08.00-15.00 WIB<br>Istirahat: 12.00-13.00 WIB',
        'category' => 'Administrasi',
        'keywords' => ['surat keterangan', 'mahasiswa aktif', 'administrasi', 'TU', 'dokumen'],
        'order' => 6,
        'is_active' => true
    ],
    [
        'question' => 'Bagaimana cara mengajukan cuti akademik?',
        'answer' => 'Prosedur pengajuan cuti akademik:<br><br><strong>📋 Syarat Pengajuan:</strong><br>• Sudah menempuh minimal 2 semester<br>• IPK minimal 2.00<br>• Tidak sedang dalam masa sanksi akademik<br>• Alasan yang dapat dipertanggungjawabkan<br><br><strong>📄 Dokumen Diperlukan:</strong><br>• Surat permohonan cuti (bermaterai)<br>• Fotocopy transkrip nilai<br>• Surat keterangan alasan cuti (kesehatan/kerja/dll)<br>• Rekomendasi dari dosen wali<br><br><strong>⏱️ Proses Pengajuan:</strong><br>1. <strong>Konsultasi Dosen Wali:</strong> Diskusikan rencana cuti<br>2. <strong>Lengkapi Berkas:</strong> Siapkan semua dokumen<br>3. <strong>Submit ke Fakultas:</strong> Serahkan ke bagian akademik<br>4. <strong>Menunggu Persetujuan:</strong> 5-7 hari kerja<br>5. <strong>Ambil SK Cuti:</strong> Jika disetujui<br><br><strong>⚠️ Penting:</strong><br>• Maksimal cuti: 4 semester<br>• Harus daftar ulang setelah cuti<br>• Tidak dikenakan biaya selama cuti',
        'category' => 'Administrasi',
        'keywords' => ['cuti akademik', 'leave', 'izin tidak kuliah', 'prosedur', 'syarat'],
        'order' => 7,
        'is_active' => true
    ],

    // Technical FAQs
    [
        'question' => 'Lupa password portal mahasiswa, bagaimana reset?',
        'answer' => 'Cara reset password portal mahasiswa:<br><br><strong>🔄 Reset Mandiri:</strong><br>1. <strong>Klik "Lupa Password":</strong> Di halaman login portal<br>2. <strong>Masukkan NIM:</strong> Ketik NIM dengan benar<br>3. <strong>Cek Email:</strong> Buka email yang terdaftar di sistem<br>4. <strong>Klik Link Reset:</strong> Ikuti instruksi di email<br>5. <strong>Buat Password Baru:</strong> Minimal 8 karakter, campuran huruf dan angka<br><br><strong>🆘 Jika Email Tidak Masuk:</strong><br>• Cek folder spam/junk<br>• Pastikan email yang digunakan benar<br>• Tunggu 5-10 menit<br><br><strong>🏢 Reset Manual:</strong><br>Jika cara mandiri tidak berhasil:<br>• Datang ke TU dengan membawa KTM<br>• Isi formulir reset password<br>• Password baru akan dikirim via SMS<br><br><strong>💡 Tips Keamanan:</strong><br>• Ganti password secara berkala<br>• Jangan bagikan password ke orang lain<br>• Logout setelah selesai menggunakan portal',
        'category' => 'Teknis',
        'keywords' => ['lupa password', 'reset password', 'portal mahasiswa', 'login', 'akses'],
        'order' => 8,
        'is_active' => true
    ],
    [
        'question' => 'WiFi kampus lambat atau tidak bisa connect, apa solusinya?',
        'answer' => 'Solusi masalah WiFi kampus:<br><br><strong>🔧 Troubleshooting Dasar:</strong><br>1. <strong>Restart Device:</strong> Matikan dan nyalakan WiFi perangkat<br>2. <strong>Forget & Reconnect:</strong> Hapus jaringan dan connect ulang<br>3. <strong>Clear DNS Cache:</strong> Gunakan DNS 8.8.8.8 atau 1.1.1.1<br>4. <strong>Update Driver:</strong> Pastikan driver WiFi terbaru<br><br><strong>📶 Info Jaringan WiFi:</strong><br>• <strong>KAMPUS-STUDENT:</strong> Untuk mahasiswa (login dengan NIM)<br>• <strong>KAMPUS-GUEST:</strong> Untuk tamu (tanpa password)<br>• <strong>KAMPUS-STAFF:</strong> Untuk dosen dan staff<br><br><strong>⚡ Tips Koneksi Stabil:</strong><br>• Gunakan bandwidth secara bijak<br>• Hindari download besar di jam sibuk<br>• Pilih lokasi dengan sinyal kuat<br>• Logout jika tidak digunakan<br><br><strong>🛠️ Jika Masih Bermasalah:</strong><br>• Lapor ke IT Support: ext. 1234<br>• WhatsApp: +62 812-3456-7890<br>• Email: itsupport@kampus.ac.id<br><br><strong>🕒 Jam Layanan IT:</strong> Senin-Jumat 08.00-17.00 WIB',
        'category' => 'Teknis',
        'keywords' => ['wifi', 'internet', 'koneksi', 'jaringan', 'IT support', 'troubleshooting'],
        'order' => 9,
        'is_active' => true
    ],

    // General Information FAQs
    [
        'question' => 'Dimana lokasi dan bagaimana akses transportasi ke kampus?',
        'answer' => 'Informasi lokasi dan transportasi kampus:<br><br><strong>📍 Alamat Lengkap:</strong><br>Jl. Pendidikan No. 123<br>Kelurahan Cerdas, Kecamatan Pintar<br>Jakarta Selatan 12345<br><br><strong>🚌 Transportasi Umum:</strong><br>• <strong>TransJakarta:</strong> Halte "Kampus Cerdas" (Koridor 6)<br>• <strong>KRL:</strong> Stasiun "Universitas" + ojek online<br>• <strong>Bus Kota:</strong> Trayek P123, AC76<br>• <strong>Angkot:</strong> Rute M45 (dari Terminal Pintar)<br><br><strong>🚗 Kendaraan Pribadi:</strong><br>• Dari Tol Jakarta-Outer: Exit Pintar (5 km)<br>• Dari Sudirman: Melalui Jl. Rasuna Said (15 km)<br>• Parkir tersedia: Motor Rp 3.000, Mobil Rp 5.000<br><br><strong>📱 Navigasi Digital:</strong><br>• Google Maps: "Universitas Cerdas"<br>• Waze: "Kampus UC Jakarta"<br>• Grab/Gojek: "Universitas Cerdas Pintar"<br><br><strong>🕒 Akses Kampus:</strong><br>• Gate 1 (Utama): 24 jam<br>• Gate 2 (Samping): 06.00-22.00<br>• Shuttle bus internal: 07.00-17.00',
        'category' => 'Informasi Umum',
        'keywords' => ['lokasi', 'alamat', 'transportasi', 'akses', 'parkir', 'arah', 'maps'],
        'order' => 10,
        'is_active' => true
    ],
    [
        'question' => 'Apa saja fasilitas yang tersedia di kampus?',
        'answer' => 'Fasilitas lengkap yang tersedia di kampus:<br><br><strong>🏫 Fasilitas Akademik:</strong><br>• 50+ Ruang kuliah ber-AC dengan projector<br>• 15 Laboratorium komputer dan sains<br>• Perpustakaan 4 lantai dengan 100.000+ koleksi<br>• Auditorium kapasitas 500 orang<br>• Studio multimedia dan podcast<br><br><strong>🏃 Fasilitas Olahraga:</strong><br>• Lapangan futsal dan basket<br>• Gym dan fitness center<br>• Kolam renang semi-olympic<br>• Tennis table dan badminton<br>• Track lari 400 meter<br><br><strong>🍽️ Fasilitas Penunjang:</strong><br>• Food court dengan 20+ tenant<br>• Kantin halal dan vegetarian<br>• Mini market dan ATM center<br>• Clinic kesehatan 24 jam<br>• Mushola dan ruang ibadah<br><br><strong>🌐 Teknologi:</strong><br>• WiFi gratis seluruh area<br>• Charging station di setiap gedung<br>• Smart classroom system<br>• E-learning platform<br>• Digital library access<br><br><strong>🚗 Transportasi & Parkir:</strong><br>• Parkir motor (2000+ slot)<br>• Parkir mobil (500+ slot)<br>• Shuttle bus antar gedung<br>• Bike sharing program',
        'category' => 'Informasi Umum',
        'keywords' => ['fasilitas', 'layanan', 'perpustakaan', 'lab', 'olahraga', 'kantin', 'wifi'],
        'order' => 11,
        'is_active' => true
    ],

    // Financial FAQs
    [
        'question' => 'Berapa biaya kuliah dan bagaimana cara pembayarannya?',
        'answer' => 'Informasi biaya kuliah dan sistem pembayaran:<br><br><strong>💰 Biaya Kuliah per Semester:</strong><br><br><strong>Program S1:</strong><br>• Teknik/Kedokteran: Rp 8.500.000<br>• Ekonomi/Hukum: Rp 7.000.000<br>• FISIP/FKIP: Rp 6.500.000<br>• Sastra: Rp 6.000.000<br><br><strong>Program S2:</strong><br>• Magister Teknik: Rp 12.000.000<br>• Magister Ekonomi: Rp 10.000.000<br>• Magister Pendidikan: Rp 9.500.000<br><br><strong>💳 Metode Pembayaran:</strong><br>• Transfer bank (BCA, Mandiri, BNI, BRI)<br>• Virtual account otomatis<br>• Kartu kredit/debit<br>• Mobile banking dan e-wallet<br>• Gerai Indomaret/Alfamart<br><br><strong>📅 Jadwal Pembayaran:</strong><br>• Tenggat: Tanggal 25 setiap bulan<br>• Denda keterlambatan: 2% per bulan<br>• Cicilan 0%: Tersedia 3x pembayaran<br><br><strong>🎁 Program Keringanan:</strong><br>• Beasiswa prestasi: 25-100%<br>• Beasiswa ekonomi: 50-75%<br>• Early bird discount: 5% (bayar sebelum tanggal 10)<br>• Alumni discount: 10% untuk anak alumni',
        'category' => 'Keuangan',
        'keywords' => ['biaya kuliah', 'ukt', 'pembayaran', 'cicilan', 'beasiswa', 'diskon', 'transfer'],
        'order' => 12,
        'is_active' => true
    ]
];

try {
    // Clear existing FAQs
    FAQ::truncate();
    echo "🗑️  Cleared existing FAQ data\n";

    // Insert new FAQs
    foreach ($faqs as $index => $faqData) {
        $faq = FAQ::create($faqData);
        echo "✅ Created FAQ #{$faq->id}: " . substr($faqData['question'], 0, 50) . "...\n";
    }

    echo "\n🎉 Successfully created " . count($faqs) . " FAQ entries!\n";
    echo "\n📊 Summary by category:\n";
    
    $categories = FAQ::selectRaw('category, COUNT(*) as count')
                     ->groupBy('category')
                     ->get();
    
    foreach ($categories as $category) {
        echo "   • {$category->category}: {$category->count} FAQs\n";
    }

    echo "\n💡 You can now test the FAQ system at:\n";
    echo "   🌐 /api/faqs - API endpoint\n";
    echo "   🔍 /api/faqs?search=password - Search example\n";
    echo "   📂 /api/faqs?category=Akademik - Category filter\n";

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}

echo "\n✨ FAQ sample data creation completed!\n";
