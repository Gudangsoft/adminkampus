<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ComponentController extends Controller
{
    /**
     * Display component management index
     */
    public function index()
    {
        $quickAccessConfig = $this->getQuickAccessConfig();
        $liveChatConfig = $this->getLiveChatConfig();
        
        return view('admin.components.index', compact('quickAccessConfig', 'liveChatConfig'));
    }

    /**
     * Show Quick Access configuration
     */
    public function quickAccess()
    {
        $config = $this->getQuickAccessConfig();
        return view('admin.components.quick-access', compact('config'));
    }

    /**
     * Update Quick Access configuration
     */
    public function updateQuickAccess(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'enabled' => 'nullable|in:on,1,true',
            'position' => 'required|in:left,right',
            'button_text' => 'required|string|max:50',
            'academic_services' => 'nullable|array',
            'student_services' => 'nullable|array',
            'information_services' => 'nullable|array',
            'contact_services' => 'nullable|array'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $config = [
                'enabled' => $request->has('enabled') && in_array($request->input('enabled'), ['on', '1', 'true', 1, true]),
                'position' => $request->input('position', 'right'),
                'button_text' => $request->input('button_text', 'Layanan Cepat'),
                'academic_services' => $request->input('academic_services', []),
                'student_services' => $request->input('student_services', []),
                'information_services' => $request->input('information_services', []),
                'contact_services' => $request->input('contact_services', [])
            ];

            $this->saveQuickAccessConfig($config);

            return back()->with('success', 'Konfigurasi Quick Access berhasil diperbarui!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui konfigurasi: ' . $e->getMessage());
        }
    }

    /**
     * Show Live Chat configuration
     */
    public function liveChat()
    {
        $config = $this->getLiveChatConfig();
        return view('admin.components.live-chat', compact('config'));
    }

    /**
     * Update Live Chat configuration
     */
    public function updateLiveChat(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'enabled' => 'nullable|in:on,1,true',
            'position' => 'required|in:left,right',
            'button_text' => 'required|string|max:50',
            'welcome_message' => 'required|string|max:500',
            'auto_responses' => 'nullable|array'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $config = [
                'enabled' => $request->has('enabled') && in_array($request->input('enabled'), ['on', '1', 'true', 1, true]),
                'position' => $request->input('position', 'right'),
                'button_text' => $request->input('button_text', 'Butuh Bantuan?'),
                'welcome_message' => $request->input('welcome_message', 'Halo! Ada yang bisa saya bantu?'),
                'auto_responses' => $request->input('auto_responses', [])
            ];

            $this->saveLiveChatConfig($config);

            return back()->with('success', 'Konfigurasi Live Chat berhasil diperbarui!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui konfigurasi: ' . $e->getMessage());
        }
    }

    /**
     * Get Quick Access configuration
     */
    private function getQuickAccessConfig()
    {
        $configPath = config_path('quick-access.php');
        
        if (File::exists($configPath)) {
            return include $configPath;
        }

        // Default configuration
        return [
            'enabled' => true,
            'position' => 'right',
            'button_text' => 'Layanan Cepat',
            'academic_services' => [
                [
                    'id' => 'enrollment',
                    'title' => 'Pendaftaran Online',
                    'description' => 'Daftar kuliah secara online',
                    'icon' => 'fas fa-user-plus',
                    'color' => 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
                    'url' => '/pendaftaran',
                    'enabled' => true
                ],
                [
                    'id' => 'schedule',
                    'title' => 'Jadwal Kuliah',
                    'description' => 'Lihat jadwal kuliah terkini',
                    'icon' => 'fas fa-calendar-alt',
                    'color' => 'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)',
                    'url' => '/jadwal',
                    'enabled' => true
                ]
            ],
            'student_services' => [
                [
                    'id' => 'library',
                    'title' => 'Perpustakaan Digital',
                    'description' => 'Akses e-book dan jurnal online',
                    'icon' => 'fas fa-book-open',
                    'color' => 'linear-gradient(135deg, #fa709a 0%, #fee140 100%)',
                    'url' => '/perpustakaan',
                    'enabled' => true
                ]
            ],
            'information_services' => [
                [
                    'id' => 'news',
                    'title' => 'Berita Kampus',
                    'description' => 'Berita dan pengumuman terbaru',
                    'icon' => 'fas fa-newspaper',
                    'color' => 'linear-gradient(135deg, #a8edea 0%, #fed6e3 100%)',
                    'url' => '/berita',
                    'enabled' => true
                ]
            ],
            'contact_services' => [
                [
                    'id' => 'contact',
                    'title' => 'Kontak Kami',
                    'description' => 'Hubungi tim support',
                    'icon' => 'fas fa-phone',
                    'color' => 'linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%)',
                    'url' => '/kontak',
                    'enabled' => true
                ]
            ]
        ];
    }

    /**
     * Get Live Chat configuration
     */
    private function getLiveChatConfig()
    {
        $configPath = config_path('live-chat.php');
        
        if (File::exists($configPath)) {
            return include $configPath;
        }

        // Default configuration
        return [
            'enabled' => true,
            'position' => 'right',
            'button_text' => 'Butuh Bantuan?',
            'welcome_message' => 'Halo! 👋 Saya adalah asisten virtual kampus. Ada yang bisa saya bantu?',
            'auto_responses' => [
                [
                    'keyword' => 'pendaftaran',
                    'response' => 'Untuk informasi pendaftaran, silakan kunjungi halaman pendaftaran kami atau hubungi bagian admisi di nomor (021) 123-4567.'
                ],
                [
                    'keyword' => 'biaya',
                    'response' => 'Informasi lengkap tentang biaya kuliah dapat Anda lihat di brosur atau hubungi bagian keuangan untuk konsultasi lebih detail.'
                ],
                [
                    'keyword' => 'fasilitas',
                    'response' => 'Kampus kami dilengkapi dengan perpustakaan modern, laboratorium lengkap, dan fasilitas olahraga. Anda bisa mengunjungi galeri untuk melihat foto-foto fasilitas.'
                ]
            ]
        ];
    }

    /**
     * Save Quick Access configuration
     */
    private function saveQuickAccessConfig($config)
    {
        $configPath = config_path('quick-access.php');
        $content = "<?php\n\nreturn " . var_export($config, true) . ";\n";
        
        File::put($configPath, $content);
    }

    /**
     * Save Live Chat configuration
     */
    private function saveLiveChatConfig($config)
    {
        $configPath = config_path('live-chat.php');
        $content = "<?php\n\nreturn " . var_export($config, true) . ";\n";
        
        File::put($configPath, $content);
    }

    /**
     * Test Quick Access service
     */
    public function testQuickAccess(Request $request)
    {
        $serviceId = $request->input('service_id');
        
        // Simulate testing the service
        $config = $this->getQuickAccessConfig();
        $allServices = array_merge(
            $config['academic_services'] ?? [],
            $config['student_services'] ?? [],
            $config['information_services'] ?? [],
            $config['contact_services'] ?? []
        );
        
        $service = collect($allServices)->firstWhere('id', $serviceId);
        
        if (!$service) {
            return response()->json(['success' => false, 'message' => 'Service tidak ditemukan']);
        }
        
        return response()->json([
            'success' => true,
            'message' => "Test berhasil untuk service: {$service['title']}",
            'service' => $service
        ]);
    }

    /**
     * Test Live Chat response
     */
    public function testLiveChat(Request $request)
    {
        $message = $request->input('message');
        $config = $this->getLiveChatConfig();
        
        // Find matching auto response
        $response = null;
        foreach ($config['auto_responses'] as $autoResponse) {
            if (stripos($message, $autoResponse['keyword']) !== false) {
                $response = $autoResponse['response'];
                break;
            }
        }
        
        if (!$response) {
            $response = 'Maaf, saya belum bisa memahami pertanyaan Anda. Silakan hubungi admin untuk bantuan lebih lanjut.';
        }
        
        return response()->json([
            'success' => true,
            'response' => $response,
            'matched_keyword' => $response !== null ? true : false
        ]);
    }
}
