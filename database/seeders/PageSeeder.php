<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Page;
use App\Models\User;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::first(); // Ambil user pertama sebagai admin

        $pages = [
            [
                'title' => 'Tentang Kami',
                'slug' => 'tentang-kami',
                'content' => '
                    <h2>Sejarah Universitas</h2>
                    <p>Universitas Go-Campus didirikan pada tahun 1985 dengan visi menjadi universitas terdepan dalam pengembangan ilmu pengetahuan dan teknologi. Sejak awal berdirinya, universitas ini telah berkomitmen untuk memberikan pendidikan berkualitas tinggi dan menghasilkan lulusan yang kompeten di bidangnya.</p>
                    
                    <h3>Visi</h3>
                    <p>Menjadi universitas yang unggul dan terkemuka dalam pengembangan ilmu pengetahuan, teknologi, dan seni yang berlandaskan nilai-nilai kemanusiaan.</p>
                    
                    <h3>Misi</h3>
                    <ul>
                        <li>Menyelenggarakan pendidikan tinggi yang berkualitas dan inovatif</li>
                        <li>Mengembangkan penelitian yang bermanfaat bagi masyarakat</li>
                        <li>Melaksanakan pengabdian kepada masyarakat</li>
                        <li>Membangun kerjasama dengan berbagai pihak</li>
                    </ul>
                ',
                'status' => 'published',
                'show_in_menu' => true,
                'menu_order' => 1,
                'meta_data' => json_encode([
                    'title' => 'Tentang Kami - Go-Campus University',
                    'description' => 'Pelajari sejarah, visi, dan misi Universitas Go-Campus. Universitas terdepan dalam pengembangan ilmu pengetahuan dan teknologi.',
                    'keywords' => 'tentang, sejarah, visi, misi, universitas, go-campus'
                ]),
                'user_id' => $admin->id ?? 1,
            ],
            [
                'title' => 'Fasilitas',
                'slug' => 'fasilitas',
                'content' => '
                    <h2>Fasilitas Kampus</h2>
                    <p>Universitas Go-Campus menyediakan berbagai fasilitas modern untuk mendukung kegiatan belajar mengajar dan penelitian.</p>
                    
                    <h3>Fasilitas Akademik</h3>
                    <ul>
                        <li><strong>Perpustakaan Digital</strong> - Koleksi lebih dari 50.000 buku dan jurnal elektronik</li>
                        <li><strong>Laboratorium Komputer</strong> - 15 lab dengan perangkat terbaru</li>
                        <li><strong>Laboratorium Sains</strong> - Lab kimia, fisika, dan biologi lengkap</li>
                        <li><strong>Studio Desain</strong> - Fasilitas untuk mahasiswa seni dan desain</li>
                    </ul>
                    
                    <h3>Fasilitas Olahraga</h3>
                    <ul>
                        <li>Lapangan basket dan voli</li>
                        <li>Lapangan sepak bola</li>
                        <li>Gedung olahraga indoor</li>
                        <li>Kolam renang</li>
                    </ul>
                    
                    <h3>Fasilitas Penunjang</h3>
                    <ul>
                        <li>Kantin dan food court</li>
                        <li>Klinik kesehatan</li>
                        <li>Asrama mahasiswa</li>
                        <li>Parkir luas</li>
                    </ul>
                ',
                'status' => 'published',
                'show_in_menu' => true,
                'menu_order' => 2,
                'meta_data' => json_encode([
                    'title' => 'Fasilitas Kampus - Go-Campus University',
                    'description' => 'Fasilitas lengkap di Universitas Go-Campus meliputi perpustakaan digital, laboratorium modern, dan fasilitas olahraga.',
                    'keywords' => 'fasilitas, kampus, perpustakaan, laboratorium, olahraga'
                ]),
                'user_id' => $admin->id ?? 1,
            ],
            [
                'title' => 'Kerjasama',
                'slug' => 'kerjasama',
                'content' => '
                    <h2>Kerjasama Universitas</h2>
                    <p>Universitas Go-Campus menjalin kerjasama dengan berbagai institusi dalam dan luar negeri untuk meningkatkan kualitas pendidikan dan penelitian.</p>
                    
                    <h3>Kerjasama Dalam Negeri</h3>
                    <ul>
                        <li>Universitas Indonesia</li>
                        <li>Institut Teknologi Bandung</li>
                        <li>Universitas Gadjah Mada</li>
                        <li>Kementerian Pendidikan dan Kebudayaan</li>
                        <li>Berbagai perusahaan BUMN dan swasta</li>
                    </ul>
                    
                    <h3>Kerjasama Internasional</h3>
                    <ul>
                        <li>University of Melbourne, Australia</li>
                        <li>National University of Singapore</li>
                        <li>Tokyo Institute of Technology, Japan</li>
                        <li>University of California, USA</li>
                        <li>Technical University of Munich, Germany</li>
                    </ul>
                    
                    <h3>Program Kerjasama</h3>
                    <ul>
                        <li>Program pertukaran mahasiswa</li>
                        <li>Joint research program</li>
                        <li>Double degree program</li>
                        <li>Visiting lecturer program</li>
                        <li>Magang industri</li>
                    </ul>
                ',
                'status' => 'published',
                'show_in_menu' => true,
                'menu_order' => 3,
                'meta_data' => json_encode([
                    'title' => 'Kerjasama - Go-Campus University',
                    'description' => 'Kerjasama Universitas Go-Campus dengan institusi dalam dan luar negeri untuk program pertukaran dan penelitian.',
                    'keywords' => 'kerjasama, partnership, internasional, pertukaran, mahasiswa'
                ]),
                'user_id' => $admin->id ?? 1,
            ],
            [
                'title' => 'Kontak',
                'slug' => 'kontak',
                'content' => '
                    <h2>Hubungi Kami</h2>
                    <p>Silakan hubungi kami melalui informasi kontak di bawah ini untuk pertanyaan atau informasi lebih lanjut.</p>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <h3>Alamat</h3>
                            <p>
                                Universitas Go-Campus<br>
                                Jl. Pendidikan No. 123<br>
                                Jakarta Selatan 12345<br>
                                Indonesia
                            </p>
                            
                            <h3>Kontak</h3>
                            <p>
                                <strong>Telepon:</strong> (021) 123-4567<br>
                                <strong>Fax:</strong> (021) 123-4568<br>
                                <strong>Email:</strong> info@gocampus.ac.id<br>
                                <strong>Website:</strong> www.gocampus.ac.id
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h3>Jam Operasional</h3>
                            <p>
                                <strong>Senin - Jumat:</strong> 08:00 - 16:00<br>
                                <strong>Sabtu:</strong> 08:00 - 12:00<br>
                                <strong>Minggu:</strong> Tutup
                            </p>
                            
                            <h3>Media Sosial</h3>
                            <p>
                                Facebook: @gocampusuniversity<br>
                                Instagram: @gocampus_official<br>
                                Twitter: @gocampus<br>
                                LinkedIn: Go-Campus University
                            </p>
                        </div>
                    </div>
                ',
                'status' => 'published',
                'show_in_menu' => true,
                'menu_order' => 4,
                'meta_data' => json_encode([
                    'title' => 'Kontak - Go-Campus University',
                    'description' => 'Hubungi Universitas Go-Campus melalui telepon, email, atau kunjungi langsung kampus kami di Jakarta.',
                    'keywords' => 'kontak, alamat, telepon, email, hubungi'
                ]),
                'user_id' => $admin->id ?? 1,
            ],
            [
                'title' => 'Kebijakan Privasi',
                'slug' => 'kebijakan-privasi',
                'content' => '
                    <h2>Kebijakan Privasi</h2>
                    <p><em>Terakhir diperbarui: ' . date('d F Y') . '</em></p>
                    
                    <h3>Pengumpulan Informasi</h3>
                    <p>Kami mengumpulkan informasi yang Anda berikan secara langsung kepada kami, seperti ketika Anda membuat akun, mengisi formulir, atau menghubungi kami.</p>
                    
                    <h3>Penggunaan Informasi</h3>
                    <p>Informasi yang kami kumpulkan digunakan untuk:</p>
                    <ul>
                        <li>Menyediakan dan memelihara layanan kami</li>
                        <li>Memberikan informasi tentang program dan kegiatan</li>
                        <li>Menanggapi pertanyaan dan memberikan dukungan</li>
                        <li>Mengirimkan komunikasi administratif</li>
                    </ul>
                    
                    <h3>Pembagian Informasi</h3>
                    <p>Kami tidak menjual, memperdagangkan, atau mentransfer informasi pribadi Anda kepada pihak ketiga tanpa persetujuan Anda, kecuali dalam keadaan berikut:</p>
                    <ul>
                        <li>Ketika diperlukan oleh hukum</li>
                        <li>Untuk melindungi hak dan keamanan</li>
                        <li>Dengan penyedia layanan terpercaya</li>
                    </ul>
                    
                    <h3>Keamanan Data</h3>
                    <p>Kami menerapkan berbagai langkah keamanan untuk melindungi informasi pribadi Anda.</p>
                    
                    <h3>Hubungi Kami</h3>
                    <p>Jika Anda memiliki pertanyaan tentang kebijakan privasi ini, silakan hubungi kami di privacy@gocampus.ac.id</p>
                ',
                'status' => 'published',
                'show_in_menu' => false,
                'menu_order' => 0,
                'meta_data' => json_encode([
                    'title' => 'Kebijakan Privasi - Go-Campus University',
                    'description' => 'Kebijakan privasi Universitas Go-Campus mengenai pengumpulan, penggunaan, dan perlindungan data pribadi.',
                    'keywords' => 'privasi, kebijakan, data, keamanan, perlindungan'
                ]),
                'user_id' => $admin->id ?? 1,
            ]
        ];

        foreach ($pages as $page) {
            Page::create($page);
        }
    }
}
