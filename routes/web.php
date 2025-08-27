<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\StudyProgramController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SitemapController;

// Admin Controllers
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\NewsController as AdminNewsController;
use App\Http\Controllers\Admin\NewsCategoryController;
use App\Http\Controllers\Admin\AnnouncementController as AdminAnnouncementController;
use App\Http\Controllers\Admin\StudyProgramController as AdminStudyProgramController;
use App\Http\Controllers\Admin\LecturerController as AdminLecturerController;
use App\Http\Controllers\Admin\StudentController as AdminStudentController;
use App\Http\Controllers\Admin\StructuralPositionController as AdminStructuralPositionController;
use App\Http\Controllers\Admin\GalleryController as AdminGalleryController;
use App\Http\Controllers\Admin\SettingController as AdminSettingsController;
use App\Http\Controllers\Admin\SliderController as AdminSliderController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\MenuController as AdminMenuController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\SEOController as AdminSEOController;
use App\Http\Controllers\Admin\AnalyticsController as AdminAnalyticsController;
use App\Http\Controllers\Admin\NotificationController as AdminNotificationController;
use App\Http\Controllers\Admin\BackupController as AdminBackupController;
use App\Http\Controllers\Admin\LanguageController as AdminLanguageController;
use App\Http\Controllers\Admin\ThemeController as AdminThemeController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\PDFController as AdminPDFController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AdvancedSearchController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Frontend Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/tentang', function() { return view('frontend.about'); })->name('about');
Route::get('/kontak', [ContactController::class, 'index'])->name('contact');

// Auto login route untuk testing (hapus di production)
Route::get('/auto-login', function() {
    return view('auto-login');
});

// Auto login admin route untuk testing
Route::get('/auto-login-admin', function() {
    $user = App\Models\User::where('email', 'admin@g0campus.ac.id')->where('role', 'admin')->first();
    if ($user) {
        Auth::login($user);
        session()->regenerate();
        return redirect('/admin/students')->with('success', 'Auto login berhasil!');
    }
    return redirect('/admin-login.html')->with('error', 'Admin user tidak ditemukan');
});

// Route untuk handle login form
Route::post('/admin-login', function(Illuminate\Http\Request $request) {
    $credentials = $request->only('email', 'password');
    
    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->route('admin.students.index');
    }
    
    return back()->withErrors(['email' => 'Kredensial tidak valid']);
});

// Test route untuk view students tanpa middleware
Route::get('/test-students-view', function() {
    $students = App\Models\Student::with(['studyProgram'])->paginate(15);
    $studyPrograms = App\Models\StudyProgram::active()->orderBy('name')->get();
    $entryYears = App\Models\Student::selectRaw('DISTINCT entry_year')
                       ->orderBy('entry_year', 'desc')
                       ->pluck('entry_year');
    
    return view('admin.students.index', compact('students', 'studyPrograms', 'entryYears'));
});

// Test route untuk view simple
Route::get('/test-students-simple', function() {
    $students = App\Models\Student::with(['studyProgram'])->paginate(15);
    $studyPrograms = App\Models\StudyProgram::active()->orderBy('name')->get();
    $entryYears = App\Models\Student::selectRaw('DISTINCT entry_year')
                       ->orderBy('entry_year', 'desc')
                       ->pluck('entry_year');
    
    return view('admin.students.index_simple', compact('students', 'studyPrograms', 'entryYears'));
});

// Test route untuk debugging
Route::get('/simple-test', function() {
    return '<h1>Simple Test Works!</h1><p>Server is running fine</p>';
});

// Test admin route tanpa middleware
Route::get('/test-admin-create', function() {
    return view('admin.pages.create_simple');
});

// Test admin route dengan controller
Route::get('/test-admin-controller', function() {
    $controller = new \App\Http\Controllers\Admin\PageController();
    return $controller->create();
});

Route::get('/test', function() {
    $sections = \App\Models\Section::active()->ordered()->get();
    return view('frontend.test', compact('sections'));
});

// Test analytics response
Route::get('/test-analytics-response', function() {
    try {
        echo "<h1>Analytics Response Debug</h1>";
        
        // Simulate authenticated request
        $user = \App\Models\User::first();
        if ($user) {
            auth()->login($user);
            echo "<p>✅ User authenticated: {$user->email}</p>";
        } else {
            echo "<p>❌ No user found</p>";
            return;
        }
        
        // Create controller instance and call index
        $controller = new App\Http\Controllers\Admin\AnalyticsController();
        
        echo "<h2>Calling Analytics Controller...</h2>";
        
        $response = $controller->index();
        
        echo "<h3>Response Type: " . get_class($response) . "</h3>";
        
        if ($response instanceof \Illuminate\View\View) {
            echo "<p>✅ View response received</p>";
            echo "<p>View name: " . $response->getName() . "</p>";
            
            $data = $response->getData();
            echo "<h3>View Data:</h3>";
            echo "<pre>";
            foreach ($data as $key => $value) {
                echo $key . " => ";
                if (is_array($value)) {
                    echo "Array with " . count($value) . " items\n";
                } elseif (is_object($value)) {
                    echo get_class($value) . "\n";
                } else {
                    echo $value . "\n";
                }
            }
            echo "</pre>";
            
            // Try to render the view
            echo "<h3>Attempting to render view...</h3>";
            try {
                $html = $response->render();
                echo "<p>✅ View rendered successfully</p>";
                echo "<p>HTML length: " . strlen($html) . " characters</p>";
                
                // Check if it contains expected content
                if (strpos($html, 'Analytics Dashboard') !== false) {
                    echo "<p>✅ Contains title</p>";
                } else {
                    echo "<p>❌ Missing title</p>";
                }
                
                if (strpos($html, 'Total Berita') !== false) {
                    echo "<p>✅ Contains stats cards</p>";
                } else {
                    echo "<p>❌ Missing stats cards</p>";
                }
                
                // Show first 500 characters
                echo "<h4>First 500 characters of rendered HTML:</h4>";
                echo "<textarea style='width:100%;height:200px;'>" . htmlspecialchars(substr($html, 0, 500)) . "</textarea>";
                
            } catch (Exception $e) {
                echo "<p style='color:red'>❌ Error rendering view: " . $e->getMessage() . "</p>";
                echo "<p>File: " . $e->getFile() . ":" . $e->getLine() . "</p>";
            }
        } else {
            echo "<p>❌ Unexpected response type</p>";
        }
        
    } catch (Exception $e) {
        echo "<p style='color:red'>Error: " . $e->getMessage() . "</p>";
        echo "<p>File: " . $e->getFile() . ":" . $e->getLine() . "</p>";
        echo "<pre>" . $e->getTraceAsString() . "</pre>";
    }
});

// Debug route untuk analytics
Route::get('/debug-analytics', function() {
    try {
        // Test basic Laravel functionality
        echo "<h1>Debug Analytics</h1>";
        
        // Test controller exists
        if (class_exists('App\Http\Controllers\Admin\AnalyticsController')) {
            echo "<p>✅ AnalyticsController exists</p>";
        } else {
            echo "<p>❌ AnalyticsController missing</p>";
        }
        
        // Test models exist
        $models = [
            'App\Models\News',
            'App\Models\Announcement', 
            'App\Models\Gallery',
            'App\Models\StudyProgram',
            'App\Models\Student',
            'App\Models\Lecturer',
            'App\Models\User'
        ];
        
        foreach ($models as $model) {
            if (class_exists($model)) {
                try {
                    $count = $model::count();
                    echo "<p>✅ {$model}: {$count} records</p>";
                } catch (Exception $e) {
                    echo "<p>⚠️ {$model}: Error - {$e->getMessage()}</p>";
                }
            } else {
                echo "<p>❌ {$model}: Missing</p>";
            }
        }
        
        // Test analytics controller directly
        echo "<h2>Testing Analytics Controller</h2>";
        $controller = new App\Http\Controllers\Admin\AnalyticsController();
        
        // Call private method through reflection
        $reflection = new ReflectionClass($controller);
        $method = $reflection->getMethod('getBasicStats');
        $method->setAccessible(true);
        
        $stats = $method->invoke($controller);
        echo "<pre>" . print_r($stats, true) . "</pre>";
        
        // Test view exists
        if (view()->exists('admin.analytics.index')) {
            echo "<p>✅ Analytics view exists</p>";
        } else {
            echo "<p>❌ Analytics view missing</p>";
        }
        
    } catch (Exception $e) {
        echo "<p style='color:red'>Error: " . $e->getMessage() . "</p>";
        echo "<p>File: " . $e->getFile() . ":" . $e->getLine() . "</p>";
        echo "<pre>" . $e->getTraceAsString() . "</pre>";
    }
});

// Debug route untuk test settings
Route::get('/debug-settings', function() {
    try {
        $settings = \App\Models\Setting::all()->pluck('value', 'key');
        $globalSettings = \App\Models\Setting::all()->pluck('value', 'key');
        return response()->json([
            'helper_exists' => function_exists('setting'),
            'settings_count' => $settings->count(),
            'all_settings' => $settings->toArray(),
            'logo_setting' => $settings->get('site_logo'),
            'favicon_setting' => $settings->get('site_favicon'),
            'globalSettings_logo' => $globalSettings->get('site_logo'),
            'storage_url_test' => \Storage::url('test/path.jpg'),
            'site_name' => function_exists('setting') ? setting('site_name', 'DEFAULT') : 'Helper tidak ada'
        ]);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()]);
    }
});

// News Routes
Route::prefix('berita')->name('news.')->group(function () {
    Route::get('/', [NewsController::class, 'index'])->name('index');
    Route::get('/kategori/{slug}', [NewsController::class, 'category'])->name('category');
    Route::get('/{slug}', [NewsController::class, 'show'])->name('show');
});

// Announcement Routes
Route::prefix('pengumuman')->name('announcements.')->group(function () {
    Route::get('/', [AnnouncementController::class, 'index'])->name('index');
    Route::get('/{slug}', [AnnouncementController::class, 'show'])->name('show');
});

// Study Program Routes
Route::prefix('program-studi')->name('program-studi.')->group(function () {
    Route::get('/', [StudyProgramController::class, 'index'])->name('index');
    Route::get('/{slug}', [StudyProgramController::class, 'show'])->name('show');
});

// Student Routes
Route::prefix('mahasiswa')->name('mahasiswa.')->group(function () {
    Route::get('/', [StudentController::class, 'index'])->name('index');
    Route::get('/{nim}', [StudentController::class, 'show'])->name('show');
});

// Gallery Routes
Route::prefix('galeri')->name('gallery.')->group(function () {
    Route::get('/', [GalleryController::class, 'index'])->name('index');
    Route::get('/kategori/{slug}', [GalleryController::class, 'category'])->name('category');
    Route::get('/{slug}', [GalleryController::class, 'show'])->name('show');
});

// Search Routes
Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/advanced-search', [AdvancedSearchController::class, 'index'])->name('search.advanced');
Route::get('/search-suggestions', [AdvancedSearchController::class, 'suggestions'])->name('search.suggestions');

// Contact Routes
Route::post('/kontak', [ContactController::class, 'store'])->name('contact.store');

// Email Test Route (development only)
Route::get('/test-email', [ContactController::class, 'testEmail'])->name('contact.test');

// SEO Routes
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
Route::get('/robots.txt', [SitemapController::class, 'robots'])->name('robots');
Route::get('/seo-test', function() {
    return view('seo-test');
})->name('seo.test');

// Dynamic Pages
Route::get('/halaman/{slug}', [PageController::class, 'show'])->name('pages.show');

// Authentication Routes
Auth::routes(['register' => false]); // Disable registration for admin only

// Admin Routes - Role-based access control
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin,editor'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Content Management (Admin + Editor)
    Route::middleware('role:admin,editor')->group(function () {
        // News Management
        Route::resource('news', AdminNewsController::class);
        Route::patch('news/{news}/toggle-status', [AdminNewsController::class, 'toggleStatus'])->name('news.toggle-status');
        
        // News Categories  
        Route::resource('news-categories', NewsCategoryController::class);
        
        // Announcements Management
        Route::resource('announcements', AdminAnnouncementController::class);
        Route::patch('announcements/{announcement}/toggle-status', [AdminAnnouncementController::class, 'toggleStatus'])->name('announcements.toggle-status');
        
        // Gallery Management
    Route::resource('galleries', AdminGalleryController::class);
    Route::patch('galleries/{gallery}/toggle-featured', [AdminGalleryController::class, 'toggleFeatured'])->name('galleries.toggle-featured');
    Route::delete('galleries/{gallery}/photo/{photo}', [AdminGalleryController::class, 'deletePhoto'])->name('galleries.delete-photo');
        
        // Slider Management
    Route::resource('sliders', AdminSliderController::class);
    Route::patch('sliders/{slider}/toggle-status', [AdminSliderController::class, 'toggleStatus'])->name('sliders.toggle-status');
    Route::patch('sliders/{slider}/toggle-active', [AdminSliderController::class, 'toggleActive'])->name('sliders.toggle-active');
    Route::post('sliders/update-order', [AdminSliderController::class, 'updateOrder'])->name('sliders.update-order');
        
        // Section Management
    Route::resource('sections', SectionController::class);
    Route::patch('sections/{section}/toggle-status', [SectionController::class, 'toggleStatus'])->name('sections.toggle-status');
        
        // Pages Management
        Route::resource('pages', AdminPageController::class);
        Route::patch('pages/{page}/toggle-status', [AdminPageController::class, 'toggleStatus'])->name('pages.toggle-status');
    });
    
    // Academic Management (Admin + Editor)
    Route::middleware('role:admin,editor')->group(function () {
    // Study Program Management
    Route::resource('study-programs', AdminStudyProgramController::class);
    Route::patch('study-programs/{study_program}/toggle-status', [AdminStudyProgramController::class, 'toggleStatus'])->name('study-programs.toggle-status');
    Route::post('study-programs/update-order', [AdminStudyProgramController::class, 'updateOrder'])->name('study-programs.update-order');

    // Lecturer Management  
    Route::resource('lecturers', AdminLecturerController::class);
    Route::get('lecturers-structural', [AdminLecturerController::class, 'structural'])->name('lecturers.structural');
    Route::patch('lecturers/{lecturer}/toggle-status', [AdminLecturerController::class, 'toggleStatus'])->name('lecturers.toggle-status');
    Route::patch('lecturers/{lecturer}/update-structural', [AdminLecturerController::class, 'updateStructural'])->name('lecturers.update-structural');

    // Student Management
    Route::resource('students', AdminStudentController::class);
    Route::patch('students/{student}/toggle-status', [AdminStudentController::class, 'toggleStatus'])->name('students.toggle-status');
    
    // Structural Position Management
    Route::resource('structural-positions', AdminStructuralPositionController::class);
    Route::patch('structural-positions/{structuralPosition}/toggle-status', [AdminStructuralPositionController::class, 'toggleStatus'])->name('structural-positions.toggle-status');
    
    }); // End of role:admin,editor group
    
    // System Management (Admin Only)
    Route::middleware('admin')->group(function () {
        // User Management
        Route::prefix('system')->name('system.')->group(function () {
            Route::resource('users', AdminUserController::class);
            Route::patch('users/{user}/toggle-status', [AdminUserController::class, 'toggleStatus'])->name('users.toggle-status');
            
            // PDF Generator
            Route::prefix('pdf')->name('pdf.')->group(function () {
                Route::get('/', [AdminPDFController::class, 'index'])->name('index');
                Route::post('/news', [AdminPDFController::class, 'generateNewsReport'])->name('news');
                Route::post('/lecturers', [AdminPDFController::class, 'generateLecturersReport'])->name('lecturers');
                Route::post('/gallery', [AdminPDFController::class, 'generateGalleryReport'])->name('gallery');
                Route::post('/users', [AdminPDFController::class, 'generateUsersReport'])->name('users');
                Route::post('/custom', [AdminPDFController::class, 'generateCustomReport'])->name('custom');
            });
        });
        
        // Settings Management
        Route::prefix('settings')->name('settings.')->group(function () {
            Route::get('/', [AdminSettingsController::class, 'index'])->name('index');
            Route::get('/general', [AdminSettingsController::class, 'general'])->name('general');
            Route::get('/contact', [AdminSettingsController::class, 'contact'])->name('contact');
            Route::get('/social', [AdminSettingsController::class, 'social'])->name('social');
            Route::get('/about', [AdminSettingsController::class, 'about'])->name('about');
            Route::put('/', [AdminSettingsController::class, 'update'])->name('update');
        });
        
        // Database Backup
        Route::prefix('backups')->name('backups.')->group(function () {
            Route::get('/', [AdminBackupController::class, 'index'])->name('index');
            Route::post('/create', [AdminBackupController::class, 'create'])->name('create');
            Route::get('/download/{filename}', [AdminBackupController::class, 'download'])->name('download');
            Route::delete('/delete/{filename}', [AdminBackupController::class, 'delete'])->name('delete');
        });
        
        // Menu Management
        Route::resource('menus', AdminMenuController::class);
        Route::patch('menus/{menu}/toggle-status', [AdminMenuController::class, 'toggleStatus'])->name('menus.toggle-status');
    });
    
    // Profile & Language (All authenticated users)
    Route::get('/profile', [AdminProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [AdminProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/avatar', [AdminProfileController::class, 'updateAvatar'])->name('profile.avatar');
    Route::delete('/profile/avatar', [AdminProfileController::class, 'removeAvatar'])->name('profile.remove-avatar');
    
    // Languages Management (Admin + Editor)
    Route::middleware('role:admin,editor')->group(function () {
        Route::resource('languages', AdminLanguageController::class);
    });
    
    // Read-only routes for viewers
    Route::middleware('role:admin,editor,viewer')->group(function () {
        // Analytics (view only for viewers)
        Route::get('/analytics', [AdminAnalyticsController::class, 'index'])->name('analytics.index');
        
        // SEO Management (view only for viewers)
        Route::prefix('seo')->name('seo.')->group(function () {
            Route::get('/dashboard', [AdminSEOController::class, 'dashboard'])->name('dashboard');
            Route::get('/audit', [AdminSEOController::class, 'audit'])->name('audit');
            Route::get('/meta-tags', [AdminSEOController::class, 'metaTags'])->name('meta-tags');
            Route::get('/sitemap', [AdminSEOController::class, 'sitemap'])->name('sitemap');
        });
        
        // PDF Export - Admin Only
        Route::prefix('pdf')->name('pdf.')->group(function () {
            Route::get('/', [AdminPDFController::class, 'index'])->name('index');
            Route::post('/news', [AdminPDFController::class, 'generateNews'])->name('news');
            Route::post('/lecturers', [AdminPDFController::class, 'generateLecturers'])->name('lecturers');
            Route::post('/gallery', [AdminPDFController::class, 'generateGallery'])->name('gallery');
            Route::post('/users', [AdminPDFController::class, 'generateUsers'])->name('users');
            Route::post('/custom', [AdminPDFController::class, 'generateCustom'])->name('custom');
        });
        
        // Settings Management
        Route::prefix('settings')->name('settings.')->group(function () {
            Route::get('/', [AdminSettingsController::class, 'index'])->name('index');
            Route::put('/', [AdminSettingsController::class, 'update'])->name('update');
            Route::get('/general', [AdminSettingsController::class, 'general'])->name('general');
            Route::post('/general', [AdminSettingsController::class, 'updateGeneral'])->name('general.update');
            Route::get('/contact', [AdminSettingsController::class, 'contact'])->name('contact');
            Route::post('/contact', [AdminSettingsController::class, 'updateContact'])->name('contact.update');
            Route::get('/social', [AdminSettingsController::class, 'social'])->name('social');
            Route::post('/social', [AdminSettingsController::class, 'updateSocial'])->name('social.update');
            Route::get('/about', [AdminSettingsController::class, 'about'])->name('about');
            Route::post('/about', [AdminSettingsController::class, 'updateAbout'])->name('about.update');
        });
        
        // Profile Management
        Route::prefix('profile')->name('profile.')->group(function () {
            Route::get('/', [AdminProfileController::class, 'show'])->name('show');
            Route::put('/', [AdminProfileController::class, 'update'])->name('update');
            Route::put('/password', [AdminProfileController::class, 'updatePassword'])->name('password.update');
        });
    });
});

// Frontend Page Routes - These should be at the end to avoid conflicts
Route::get('/{slug}', [PageController::class, 'show'])->name('dynamic.page.show')->where('slug', '[a-zA-Z0-9\-]+');
