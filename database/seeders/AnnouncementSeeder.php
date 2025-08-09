<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Announcement;
use App\Models\User;
use Carbon\Carbon;

class AnnouncementSeeder extends Seeder
{
    public function run()
    {
        $user = User::first();
        
        if (!$user) {
            $user = User::create([
                'name' => 'Admin',
                'email' => 'admin@g0campus.com',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]);
        }

        $announcements = [
            [
                'title' => 'Pembukaan Pendaftaran Mahasiswa Baru Semester Ganjil 2025/2026',
                'slug' => 'pembukaan-pendaftaran-mahasiswa-baru-semester-ganjil-2025-2026',
                'excerpt' => 'G0-CAMPUS membuka pendaftaran untuk calon mahasiswa baru periode semester ganjil 2025/2026. Tersedia berbagai program studi unggulan dengan fasilitas modern.',
                'content' => '<h3>Pendaftaran Mahasiswa Baru Semester Ganjil 2025/2026</h3>
                
                <p>Dengan bangga, <strong>G0-CAMPUS</strong> mengumumkan pembukaan pendaftaran untuk calon mahasiswa baru periode <strong>Semester Ganjil 2025/2026</strong>.</p>
                
                <h4>📅 Jadwal Penting:</h4>
                <ul>
                    <li><strong>Pendaftaran Online:</strong> 1 Januari - 30 April 2025</li>
                    <li><strong>Ujian Masuk:</strong> 15-20 Mei 2025</li>
                    <li><strong>Pengumuman Hasil:</strong> 1 Juni 2025</li>
                    <li><strong>Daftar Ulang:</strong> 5-15 Juni 2025</li>
                    <li><strong>Orientasi Mahasiswa:</strong> 20-25 Agustus 2025</li>
                </ul>
                
                <h4>🎓 Program Studi yang Tersedia:</h4>
                <ul>
                    <li>Teknik Informatika (S1)</li>
                    <li>Sistem Informasi (S1)</li>
                    <li>Manajemen (S1)</li>
                    <li>Akuntansi (S1)</li>
                    <li>Psikologi (S1)</li>
                    <li>Desain Komunikasi Visual (S1)</li>
                </ul>
                
                <h4>💰 Biaya Pendaftaran:</h4>
                <p>Rp 300.000,- (Tiga Ratus Ribu Rupiah)</p>
                
                <h4>📋 Persyaratan:</h4>
                <ul>
                    <li>Lulusan SMA/SMK/MA sederajat</li>
                    <li>Ijazah dan transkrip nilai</li>
                    <li>Surat keterangan sehat</li>
                    <li>Pas foto terbaru 4x6 (3 lembar)</li>
                    <li>Fotokopi KTP dan KK</li>
                </ul>
                
                <p><strong>Info lebih lanjut:</strong><br>
                📞 Tel: (021) 123-4567<br>
                📱 WA: 0812-3456-7890<br>
                📧 Email: pmb@g0campus.ac.id</p>',
                'priority' => 'high',
                'is_pinned' => true,
                'status' => 'published',
                'published_at' => Carbon::now()->subDays(2),
                'expires_at' => Carbon::create(2025, 4, 30, 23, 59, 59),
                'user_id' => $user->id,
                'views' => rand(150, 300)
            ],
            [
                'title' => 'Libur Semester Ganjil 2024/2025',
                'slug' => 'libur-semester-ganjil-2024-2025',
                'excerpt' => 'Pengumuman jadwal libur semester ganjil 2024/2025 untuk seluruh civitas akademika G0-CAMPUS.',
                'content' => '<h3>Libur Semester Ganjil 2024/2025</h3>
                
                <p>Kepada seluruh <strong>Civitas Akademika G0-CAMPUS</strong>,</p>
                
                <p>Dengan hormat, kami sampaikan bahwa <strong>Semester Ganjil 2024/2025</strong> akan berakhir dan memasuki masa libur dengan jadwal sebagai berikut:</p>
                
                <h4>📅 Jadwal Libur:</h4>
                <ul>
                    <li><strong>Ujian Akhir Semester:</strong> 15-30 Januari 2025</li>
                    <li><strong>Libur Semester:</strong> 1 Februari - 28 Februari 2025</li>
                    <li><strong>Masuk Semester Genap:</strong> 3 Maret 2025</li>
                </ul>
                
                <h4>📝 Catatan Penting:</h4>
                <ul>
                    <li>Selama masa libur, kampus tetap buka untuk pelayanan administrasi (08.00-15.00 WIB)</li>
                    <li>Perpustakaan tutup tanggal 15-20 Februari 2025</li>
                    <li>Bagi mahasiswa yang mengambil remedial, silakan hubungi fakultas masing-masing</li>
                </ul>
                
                <p>Selamat berlibur dan sampai jumpa di semester genap!</p>
                
                <p><strong>Salam Akademika,</strong><br>
                Wakil Rektor Bidang Akademik</p>',
                'priority' => 'medium',
                'is_pinned' => false,
                'status' => 'published',
                'published_at' => Carbon::now()->subDays(5),
                'expires_at' => Carbon::create(2025, 3, 3, 23, 59, 59),
                'user_id' => $user->id,
                'views' => rand(200, 400)
            ],
            [
                'title' => 'PENTING: Pemadaman Listrik Kampus',
                'slug' => 'penting-pemadaman-listrik-kampus',
                'excerpt' => 'Pemberitahuan pemadaman listrik terjadwal di seluruh area kampus untuk maintenance sistem kelistrikan.',
                'content' => '<div class="alert alert-danger">
                    <h4><i class="fas fa-exclamation-triangle"></i> PENGUMUMAN PENTING</h4>
                </div>
                
                <h3>Pemadaman Listrik Terjadwal</h3>
                
                <p>Kepada seluruh civitas akademika,</p>
                
                <p>Sehubungan dengan <strong>maintenance sistem kelistrikan kampus</strong>, akan dilakukan pemadaman listrik terjadwal dengan detail sebagai berikut:</p>
                
                <h4>⚡ Detail Pemadaman:</h4>
                <ul>
                    <li><strong>Tanggal:</strong> Minggu, 15 Agustus 2025</li>
                    <li><strong>Waktu:</strong> 08.00 - 17.00 WIB</li>
                    <li><strong>Area:</strong> Seluruh gedung kampus</li>
                    <li><strong>Dampak:</strong> Listrik, AC, WiFi, dan lift tidak beroperasi</li>
                </ul>
                
                <h4>📋 Yang Perlu Diperhatikan:</h4>
                <ul>
                    <li>Semua kegiatan perkuliahan DITIADAKAN</li>
                    <li>Perpustakaan dan laboratorium TUTUP</li>
                    <li>Kantin kampus tetap buka dengan menu terbatas</li>
                    <li>Parkir kendaraan tetap tersedia</li>
                    <li>Security tetap berjaga 24 jam</li>
                </ul>
                
                <h4>💡 Saran untuk Mahasiswa:</h4>
                <ul>
                    <li>Manfaatkan waktu untuk istirahat atau kegiatan di luar kampus</li>
                    <li>Charge perangkat elektronik sebelum hari H</li>
                    <li>Simpan data penting sebelumnya</li>
                </ul>
                
                <p>Mohon maaf atas ketidaknyamanan yang ditimbulkan. Pemadaman ini dilakukan untuk meningkatkan kualitas sistem kelistrikan kampus.</p>
                
                <p><strong>Terima kasih atas pengertiannya.</strong></p>
                
                <p><strong>Tim Maintenance Kampus</strong><br>
                G0-CAMPUS</p>',
                'priority' => 'urgent',
                'is_pinned' => true,
                'status' => 'published',
                'published_at' => Carbon::now()->subDays(1),
                'expires_at' => Carbon::create(2025, 8, 16, 23, 59, 59),
                'user_id' => $user->id,
                'views' => rand(500, 800)
            ],
            [
                'title' => 'Workshop "Digital Marketing untuk Mahasiswa"',
                'slug' => 'workshop-digital-marketing-untuk-mahasiswa',
                'excerpt' => 'Ikuti workshop digital marketing gratis untuk mahasiswa. Dapatkan sertifikat dan networking dengan praktisi industri.',
                'content' => '<h3>Workshop "Digital Marketing untuk Mahasiswa"</h3>
                
                <p>Halo Mahasiswa G0-CAMPUS! 👋</p>
                
                <p>Siap untuk upgrade skill digital marketing? <strong>Unit Kemahasiswaan G0-CAMPUS</strong> dengan bangga mempersembahkan workshop <strong>"Digital Marketing untuk Mahasiswa"</strong>!</p>
                
                <h4>📅 Detail Acara:</h4>
                <ul>
                    <li><strong>Tanggal:</strong> Sabtu, 20 Agustus 2025</li>
                    <li><strong>Waktu:</strong> 09.00 - 15.00 WIB</li>
                    <li><strong>Tempat:</strong> Auditorium Utama G0-CAMPUS</li>
                    <li><strong>Kapasitas:</strong> 200 peserta</li>
                    <li><strong>Biaya:</strong> GRATIS! 🎉</li>
                </ul>
                
                <h4>🎯 Materi Workshop:</h4>
                <ul>
                    <li>Pengenalan Digital Marketing</li>
                    <li>Social Media Marketing Strategy</li>
                    <li>Content Creation & Copywriting</li>
                    <li>Google Ads & Facebook Ads</li>
                    <li>Email Marketing</li>
                    <li>Analytics & Measurement</li>
                </ul>
                
                <h4>👨‍🏫 Pembicara:</h4>
                <ul>
                    <li><strong>Budi Santoso</strong> - Digital Marketing Manager, Tokopedia</li>
                    <li><strong>Sarah Wijaya</strong> - Social Media Specialist, Gojek</li>
                    <li><strong>Ahmad Rahman</strong> - Content Creator dengan 1M+ followers</li>
                </ul>
                
                <h4>🎁 Benefit:</h4>
                <ul>
                    <li>✅ Sertifikat resmi</li>
                    <li>✅ E-book "Digital Marketing 101"</li>
                    <li>✅ Networking session</li>
                    <li>✅ Doorprize menarik</li>
                    <li>✅ Konsumsi (snack + lunch)</li>
                </ul>
                
                <h4>📝 Cara Daftar:</h4>
                <ol>
                    <li>Kunjungi: bit.ly/WorkshopDM-G0Campus</li>
                    <li>Isi form pendaftaran</li>
                    <li>Upload bukti mahasiswa aktif</li>
                    <li>Tunggu konfirmasi via email</li>
                </ol>
                
                <p><strong>Buruan daftar! Kuota terbatas! 🏃‍♂️💨</strong></p>
                
                <p><strong>Info lebih lanjut:</strong><br>
                📱 WA: 0812-3456-7890<br>
                📧 Email: kemahasiswaan@g0campus.ac.id</p>',
                'priority' => 'high',
                'is_pinned' => false,
                'status' => 'published',
                'published_at' => Carbon::now()->subDays(3),
                'expires_at' => Carbon::create(2025, 8, 19, 23, 59, 59),
                'user_id' => $user->id,
                'views' => rand(300, 500)
            ],
            [
                'title' => 'Beasiswa Prestasi Akademik Semester Genap 2024/2025',
                'slug' => 'beasiswa-prestasi-akademik-semester-genap-2024-2025',
                'excerpt' => 'Pendaftaran beasiswa prestasi akademik untuk mahasiswa berprestasi semester genap 2024/2025. Total dana 500 juta rupiah.',
                'content' => '<h3>Beasiswa Prestasi Akademik Semester Genap 2024/2025</h3>
                
                <p>Kepada mahasiswa berprestasi G0-CAMPUS,</p>
                
                <p>Kami dengan senang hati mengumumkan pembukaan <strong>Program Beasiswa Prestasi Akademik</strong> untuk Semester Genap 2024/2025.</p>
                
                <h4>💰 Total Dana Beasiswa:</h4>
                <p><strong>Rp 500.000.000,-</strong> (Lima Ratus Juta Rupiah)</p>
                
                <h4>🎓 Kategori Beasiswa:</h4>
                <ul>
                    <li><strong>Beasiswa Penuh:</strong> Rp 10.000.000/semester (20 penerima)</li>
                    <li><strong>Beasiswa Parsial:</strong> Rp 5.000.000/semester (50 penerima)</li>
                    <li><strong>Beasiswa Prestasi:</strong> Rp 2.500.000/semester (100 penerima)</li>
                </ul>
                
                <h4>✅ Syarat Umum:</h4>
                <ul>
                    <li>Mahasiswa aktif G0-CAMPUS minimal semester 2</li>
                    <li>IPK minimal 3.50 (skala 4.00)</li>
                    <li>Tidak sedang menerima beasiswa lain</li>
                    <li>Berkelakuan baik (tidak pernah sanksi akademik)</li>
                    <li>Aktif dalam kegiatan kemahasiswaan</li>
                </ul>
                
                <h4>📋 Berkas yang Diperlukan:</h4>
                <ul>
                    <li>Formulir pendaftaran (download di website)</li>
                    <li>Transkrip nilai terbaru</li>
                    <li>Surat keterangan tidak mampu dari RT/RW</li>
                    <li>Slip gaji orang tua/wali</li>
                    <li>Sertifikat prestasi (jika ada)</li>
                    <li>Essay motivasi (max 500 kata)</li>
                    <li>Pas foto 4x6 (2 lembar)</li>
                </ul>
                
                <h4>📅 Timeline:</h4>
                <ul>
                    <li><strong>Pendaftaran:</strong> 10-25 Agustus 2025</li>
                    <li><strong>Seleksi Berkas:</strong> 26-30 Agustus 2025</li>
                    <li><strong>Wawancara:</strong> 1-5 September 2025</li>
                    <li><strong>Pengumuman:</strong> 10 September 2025</li>
                    <li><strong>Pencairan:</strong> 15 September 2025</li>
                </ul>
                
                <h4>📝 Cara Pendaftaran:</h4>
                <ol>
                    <li>Download formulir di website resmi</li>
                    <li>Lengkapi semua berkas</li>
                    <li>Submit ke Bagian Kemahasiswaan</li>
                    <li>Dapatkan tanda terima pendaftaran</li>
                </ol>
                
                <p><strong>Jangan sia-siakan kesempatan emas ini! 🌟</strong></p>
                
                <p><strong>Contact Person:</strong><br>
                Bu Sari (Kemahasiswaan): 0812-1234-5678<br>
                Email: beasiswa@g0campus.ac.id</p>',
                'priority' => 'high',
                'is_pinned' => false,
                'status' => 'published',
                'published_at' => Carbon::now()->subDays(7),
                'expires_at' => Carbon::create(2025, 8, 25, 23, 59, 59),
                'user_id' => $user->id,
                'views' => rand(400, 700)
            ],
            [
                'title' => 'Update Protokol Kesehatan di Kampus',
                'slug' => 'update-protokol-kesehatan-di-kampus',
                'excerpt' => 'Pembaruan protokol kesehatan terbaru yang berlaku di lingkungan kampus G0-CAMPUS untuk menjaga kesehatan bersama.',
                'content' => '<h3>Update Protokol Kesehatan di Kampus</h3>
                
                <p>Kepada seluruh civitas akademika,</p>
                
                <p>Sehubungan dengan perkembangan situasi kesehatan terkini, <strong>G0-CAMPUS</strong> menerapkan protokol kesehatan yang telah diperbarui untuk menjaga kesehatan dan keselamatan bersama.</p>
                
                <h4>😷 Wajib Menggunakan Masker:</h4>
                <ul>
                    <li>Di dalam ruang kelas dan laboratorium</li>
                    <li>Di perpustakaan dan area publik</li>
                    <li>Saat menggunakan transportasi kampus</li>
                    <li>Masker medis atau KN95 direkomendasikan</li>
                </ul>
                
                <h4>🧼 Protokol Kebersihan:</h4>
                <ul>
                    <li>Cuci tangan dengan sabun minimal 20 detik</li>
                    <li>Gunakan hand sanitizer di setiap pintu masuk</li>
                    <li>Hindari menyentuh wajah, mata, hidung, dan mulut</li>
                    <li>Etika batuk dan bersin yang benar</li>
                </ul>
                
                <h4>📏 Physical Distancing:</h4>
                <ul>
                    <li>Jaga jarak minimal 1 meter</li>
                    <li>Kapasitas ruang kelas maksimal 75%</li>
                    <li>Hindari kerumunan di area umum</li>
                    <li>Antrian dengan jarak aman</li>
                </ul>
                
                <h4>🌡️ Screening Kesehatan:</h4>
                <ul>
                    <li>Cek suhu tubuh di pintu masuk</li>
                    <li>Isi form self-assessment harian</li>
                    <li>Laporkan jika ada gejala tidak fit</li>
                    <li>Isolasi mandiri jika merasa tidak sehat</li>
                </ul>
                
                <h4>🍽️ Protokol Kantin:</h4>
                <ul>
                    <li>Kapasitas tempat duduk dibatasi</li>
                    <li>Sistem antrian dengan jarak aman</li>
                    <li>Pembayaran cashless direkomendasikan</li>
                    <li>Bawa tempat makan sendiri jika memungkinkan</li>
                </ul>
                
                <h4>⚠️ Larangan:</h4>
                <ul>
                    <li>Masuk kampus jika merasa tidak sehat</li>
                    <li>Berbagi makanan, minuman, atau alat tulis</li>
                    <li>Mengadakan kerumunan tanpa protokol</li>
                    <li>Membuka masker saat berbicara di area publik</li>
                </ul>
                
                <p><strong>Mari bersama-sama menjaga kesehatan kampus! 💪</strong></p>
                
                <p><strong>Satgas COVID-19 G0-CAMPUS</strong><br>
                Hotline: 0800-1234-COVID (26843)</p>',
                'priority' => 'medium',
                'is_pinned' => false,
                'status' => 'published',
                'published_at' => Carbon::now()->subDays(10),
                'expires_at' => null,
                'user_id' => $user->id,
                'views' => rand(250, 450)
            ]
        ];

        foreach ($announcements as $announcement) {
            Announcement::create($announcement);
        }
    }
}
