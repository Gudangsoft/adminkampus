<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\StudyProgramController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\PageController;

// Admin Controllers
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\NewsController as AdminNewsController;
use App\Http\Controllers\Admin\NewsCategoryController;
use App\Http\Controllers\Admin\AnnouncementController as AdminAnnouncementController;
use App\Http\Controllers\Admin\FacultyController as AdminFacultyController;
use App\Http\Controllers\Admin\StudyProgramController as AdminStudyProgramController;
use App\Http\Controllers\Admin\LecturerController as AdminLecturerController;
use App\Http\Controllers\Admin\StudentController as AdminStudentController;
use App\Http\Controllers\Admin\GalleryController as AdminGalleryController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SliderController as AdminSliderController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\MenuController as AdminMenuController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\SectionController;

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

// Auto login route untuk testing (hapus di production)
Route::get('/auto-login', function() {
    return view('auto-login');
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
    Route::get('/fakultas/{slug}', [StudyProgramController::class, 'faculty'])->name('faculty');
    Route::get('/{slug}', [StudyProgramController::class, 'show'])->name('show');
});

// Faculty Routes
Route::prefix('fakultas')->name('fakultas.')->group(function () {
    Route::get('/', [FacultyController::class, 'index'])->name('index');
    Route::get('/{slug}', [FacultyController::class, 'show'])->name('show');
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

// Dynamic Pages
Route::get('/halaman/{slug}', [PageController::class, 'show'])->name('page.show');

// Authentication Routes
Auth::routes(['register' => false]); // Disable registration for admin only

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // HAPUS BARIS INI - konflik dengan routes settings di bawah
    // Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    // Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');
    
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // News Management
    Route::resource('news', AdminNewsController::class);
    Route::resource('news-categories', NewsCategoryController::class);
    
    // Announcements Management
    Route::resource('announcements', AdminAnnouncementController::class);
    
    // Academic Management
    Route::resource('faculties', AdminFacultyController::class);
    Route::patch('faculties/{faculty}/toggle-status', [AdminFacultyController::class, 'toggleStatus'])->name('faculties.toggle-status');
    Route::post('faculties/update-order', [AdminFacultyController::class, 'updateOrder'])->name('faculties.update-order');
    
    Route::resource('study-programs', AdminStudyProgramController::class);
    Route::patch('study-programs/{studyProgram}/toggle-status', [AdminStudyProgramController::class, 'toggleStatus'])->name('study-programs.toggle-status');
    Route::post('study-programs/update-order', [AdminStudyProgramController::class, 'updateOrder'])->name('study-programs.update-order');
    
    Route::resource('lecturers', AdminLecturerController::class);
    Route::patch('lecturers/{lecturer}/toggle-status', [AdminLecturerController::class, 'toggleStatus'])->name('lecturers.toggle-status');
    
    Route::resource('students', AdminStudentController::class);
    Route::patch('students/{student}/toggle-status', [AdminStudentController::class, 'toggleStatus'])->name('students.toggle-status');
    
    Route::resource('galleries', AdminGalleryController::class);
    Route::patch('galleries/{gallery}/toggle-featured', [AdminGalleryController::class, 'toggleFeatured'])->name('galleries.toggle-featured');
    
    // Slider Management
    Route::resource('sliders', AdminSliderController::class);
    Route::patch('sliders/{slider}/toggle-active', [AdminSliderController::class, 'toggleActive'])->name('sliders.toggle-active');
    Route::post('sliders/update-order', [AdminSliderController::class, 'updateOrder'])->name('sliders.update-order');
    
    // Sections Management
    Route::resource('sections', SectionController::class);
    Route::post('sections/update-order', [SectionController::class, 'updateOrder'])->name('sections.update-order');
    
    // Pages Management
    Route::resource('pages', AdminPageController::class);
    Route::patch('pages/{page}/toggle-status', [AdminPageController::class, 'toggleStatus'])->name('pages.toggle-status');
    
    // Menu Management
    Route::resource('menus', AdminMenuController::class);
    Route::patch('menus/{menu}/toggle-status', [AdminMenuController::class, 'toggleStatus'])->name('menus.toggle-status');
    Route::post('menus/update-order', [AdminMenuController::class, 'updateOrder'])->name('menus.update-order');
    
    // Settings Management - GUNAKAN YANG INI SAJA
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [SettingController::class, 'index'])->name('index');
        Route::put('/', [SettingController::class, 'update'])->name('update');
        Route::get('/general', [SettingController::class, 'general'])->name('general');
        Route::post('/general', [SettingController::class, 'updateGeneral'])->name('general.update');
        Route::get('/contact', [SettingController::class, 'contact'])->name('contact');
        Route::post('/contact', [SettingController::class, 'updateContact'])->name('contact.update');
        Route::get('/social', [SettingController::class, 'social'])->name('social');
        Route::post('/social', [SettingController::class, 'updateSocial'])->name('social.update');
        Route::get('/about', [SettingController::class, 'about'])->name('about');
        Route::post('/about', [SettingController::class, 'updateAbout'])->name('about.update');
    });
    
    // Profile Management
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [AdminProfileController::class, 'show'])->name('show');
        Route::put('/', [AdminProfileController::class, 'update'])->name('update');
        Route::put('/password', [AdminProfileController::class, 'updatePassword'])->name('password.update');
    });
});

// Frontend Page Routes - These should be at the end to avoid conflicts
Route::get('/{slug}', [PageController::class, 'show'])->name('dynamic.page.show')->where('slug', '[a-zA-Z0-9\-]+');
