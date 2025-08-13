<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ThemeSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

class ThemeController extends Controller
{
    protected $themeSettings = [
        'primary_color' => '#667eea',
        'secondary_color' => '#764ba2', 
        'success_color' => '#1cc88a',
        'info_color' => '#36b9cc',
        'warning_color' => '#f6c23e',
        'danger_color' => '#e74a3b',
        'light_color' => '#f8f9fa',
        'dark_color' => '#5a5c69',
        'sidebar_bg' => 'gradient',
        'sidebar_variant' => 'dark',
        'topbar_variant' => 'light',
        'font_family' => 'Segoe UI',
        'font_size' => '14px',
        'border_radius' => '10px',
        'box_shadow' => 'default',
        'animation_speed' => '0.3s'
    ];

    protected $availableThemes = [
        'default' => [
            'name' => 'Default Theme',
            'description' => 'Modern gradient theme with blue-purple colors',
            'preview' => '/images/themes/default.png',
            'colors' => [
                'primary' => '#667eea',
                'secondary' => '#764ba2'
            ]
        ],
        'corporate' => [
            'name' => 'Corporate Blue',
            'description' => 'Professional blue theme for corporate environments',
            'preview' => '/images/themes/corporate.png',
            'colors' => [
                'primary' => '#0d47a1',
                'secondary' => '#1976d2'
            ]
        ],
        'nature' => [
            'name' => 'Nature Green',
            'description' => 'Fresh green theme inspired by nature',
            'preview' => '/images/themes/nature.png',
            'colors' => [
                'primary' => '#2e7d32',
                'secondary' => '#4caf50'
            ]
        ],
        'sunset' => [
            'name' => 'Sunset Orange',
            'description' => 'Warm orange theme with sunset colors',
            'preview' => '/images/themes/sunset.png',
            'colors' => [
                'primary' => '#f57c00',
                'secondary' => '#ff9800'
            ]
        ],
        'dark' => [
            'name' => 'Dark Mode',
            'description' => 'Elegant dark theme for night work',
            'preview' => '/images/themes/dark.png',
            'colors' => [
                'primary' => '#bb86fc',
                'secondary' => '#3700b3'
            ]
        ]
    ];

    public function index()
    {
        $currentTheme = ThemeSetting::get('current_theme', 'default');
        $themeSettings = ThemeSetting::getAllGrouped();
        $availableThemes = $this->availableThemes;
        
        return view('admin.theme.index', compact('currentTheme', 'themeSettings', 'availableThemes'));
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'primary_color' => 'required|string|regex:/^#[a-fA-F0-9]{6}$/',
            'secondary_color' => 'required|string|regex:/^#[a-fA-F0-9]{6}$/',
            'success_color' => 'required|string|regex:/^#[a-fA-F0-9]{6}$/',
            'info_color' => 'required|string|regex:/^#[a-fA-F0-9]{6}$/',
            'warning_color' => 'required|string|regex:/^#[a-fA-F0-9]{6}$/',
            'danger_color' => 'required|string|regex:/^#[a-fA-F0-9]{6}$/',
            'sidebar_bg' => 'required|in:solid,gradient,image',
            'sidebar_variant' => 'required|in:light,dark',
            'topbar_variant' => 'required|in:light,dark',
            'font_family' => 'required|string',
            'font_size' => 'required|string',
            'border_radius' => 'required|string',
            'box_shadow' => 'required|in:none,small,default,large',
            'animation_speed' => 'required|string'
        ]);

        try {
            $settings = $request->only([
                'primary_color', 'secondary_color', 'success_color', 'info_color',
                'warning_color', 'danger_color', 'light_color', 'dark_color',
                'sidebar_bg', 'sidebar_variant', 'topbar_variant', 'font_family',
                'font_size', 'border_radius', 'box_shadow', 'animation_speed'
            ]);

            // Save each setting to database
            foreach ($settings as $key => $value) {
                $group = 'general';
                if (in_array($key, ['primary_color', 'secondary_color', 'success_color', 'info_color', 'warning_color', 'danger_color', 'light_color', 'dark_color'])) {
                    $group = 'colors';
                } elseif (in_array($key, ['sidebar_bg', 'sidebar_variant', 'topbar_variant', 'border_radius', 'box_shadow'])) {
                    $group = 'layout';
                } elseif (in_array($key, ['font_family', 'font_size'])) {
                    $group = 'typography';
                }
                
                ThemeSetting::set($key, $value, 'string', $group);
            }

            // Check for dark mode toggle
            if ($request->has('dark_mode')) {
                ThemeSetting::set('dark_mode', $request->dark_mode ? 'true' : 'false', 'boolean', 'general');
            }

            // Clear cache
            ThemeSetting::clearCache();

            return response()->json([
                'success' => true,
                'message' => 'Theme settings updated successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update theme settings: ' . $e->getMessage()
            ], 500);
        }
    }

    public function applyTheme(Request $request)
    {
        $request->validate([
            'theme' => 'required|string'
        ]);

        $themeName = $request->theme;

        if (!array_key_exists($themeName, $this->availableThemes)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid theme selected'
            ], 400);
        }

        try {
            $theme = $this->availableThemes[$themeName];
            
            // Update theme settings in database
            ThemeSetting::set('current_theme', $themeName, 'string', 'general');
            ThemeSetting::set('primary_color', $theme['colors']['primary'], 'string', 'colors');
            ThemeSetting::set('secondary_color', $theme['colors']['secondary'], 'string', 'colors');
            
            // Apply theme-specific settings
            if ($themeName === 'dark') {
                ThemeSetting::set('dark_mode', 'true', 'boolean', 'general');
                ThemeSetting::set('sidebar_variant', 'dark', 'string', 'layout');
                ThemeSetting::set('topbar_variant', 'dark', 'string', 'layout');
                ThemeSetting::set('light_color', '#1e1e1e', 'string', 'colors');
                ThemeSetting::set('dark_color', '#ffffff', 'string', 'colors');
            } else {
                ThemeSetting::set('dark_mode', 'false', 'boolean', 'general');
                ThemeSetting::set('sidebar_variant', 'dark', 'string', 'layout');
                ThemeSetting::set('topbar_variant', 'light', 'string', 'layout');
                ThemeSetting::set('light_color', '#f8f9fa', 'string', 'colors');
                ThemeSetting::set('dark_color', '#5a5c69', 'string', 'colors');
            }

            // Clear cache to force reload
            ThemeSetting::clearCache();

            return response()->json([
                'success' => true,
                'message' => "Theme '{$theme['name']}' applied successfully"
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to apply theme: ' . $e->getMessage()
            ], 500);
        }
    }

    public function resetTheme()
    {
        try {
            // Reset to default theme settings
            ThemeSetting::set('current_theme', 'default', 'string', 'general');
            ThemeSetting::set('primary_color', '#667eea', 'string', 'colors');
            ThemeSetting::set('secondary_color', '#764ba2', 'string', 'colors');
            ThemeSetting::set('success_color', '#1cc88a', 'string', 'colors');
            ThemeSetting::set('info_color', '#36b9cc', 'string', 'colors');
            ThemeSetting::set('warning_color', '#f6c23e', 'string', 'colors');
            ThemeSetting::set('danger_color', '#e74a3b', 'string', 'colors');
            ThemeSetting::set('light_color', '#f8f9fa', 'string', 'colors');
            ThemeSetting::set('dark_color', '#5a5c69', 'string', 'colors');
            ThemeSetting::set('sidebar_bg', 'gradient', 'string', 'layout');
            ThemeSetting::set('sidebar_variant', 'dark', 'string', 'layout');
            ThemeSetting::set('topbar_variant', 'light', 'string', 'layout');
            ThemeSetting::set('border_radius', '10px', 'string', 'layout');
            ThemeSetting::set('box_shadow', 'default', 'string', 'layout');
            ThemeSetting::set('font_family', 'Segoe UI', 'string', 'typography');
            ThemeSetting::set('font_size', '14px', 'string', 'typography');
            ThemeSetting::set('animation_speed', '0.3s', 'string', 'general');
            ThemeSetting::set('dark_mode', 'false', 'boolean', 'general');
            
            // Clear cache
            ThemeSetting::clearCache();
            
            Cache::forget('current_theme');

            return response()->json([
                'success' => true,
                'message' => 'Theme reset to default successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to reset theme: ' . $e->getMessage()
            ], 500);
        }
    }

    public function exportTheme()
    {
        $settings = $this->getThemeSettings();
        $currentTheme = $this->getCurrentTheme();
        
        $exportData = [
            'theme_name' => $currentTheme,
            'settings' => $settings,
            'exported_at' => now()->toISOString(),
            'exported_by' => auth()->user()->name
        ];

        $filename = 'theme_' . $currentTheme . '_' . date('Y-m-d_H-i-s') . '.json';
        
        $headers = [
            'Content-Type' => 'application/json',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        return response()->json($exportData, 200, $headers);
    }

    public function importTheme(Request $request)
    {
        $request->validate([
            'theme_file' => 'required|file|mimes:json'
        ]);

        try {
            $file = $request->file('theme_file');
            $content = file_get_contents($file->getPathname());
            $themeData = json_decode($content, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid theme file format'
                ], 400);
            }

            if (!isset($themeData['settings'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Theme file is missing settings data'
                ], 400);
            }

            $settings = $themeData['settings'];
            
            // Validate imported settings
            foreach ($this->themeSettings as $key => $defaultValue) {
                if (!isset($settings[$key])) {
                    $settings[$key] = $defaultValue;
                }
            }

            $this->saveThemeSettings($settings);
            $this->generateCustomCSS($settings);
            
            if (isset($themeData['theme_name'])) {
                Cache::put('current_theme', $themeData['theme_name'], now()->addMonths(12));
            }

            return response()->json([
                'success' => true,
                'message' => 'Theme imported successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to import theme: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getPreview(Request $request)
    {
        $settings = $request->only([
            'primary_color', 'secondary_color', 'success_color', 'info_color',
            'warning_color', 'danger_color', 'light_color', 'dark_color',
            'sidebar_bg', 'sidebar_variant', 'topbar_variant', 'font_family',
            'font_size', 'border_radius', 'box_shadow', 'animation_speed'
        ]);

        $css = $this->generateCustomCSS($settings, false);

        return response()->json([
            'success' => true,
            'css' => $css
        ]);
    }

    protected function getCurrentTheme()
    {
        return Cache::get('current_theme', 'default');
    }

    protected function getThemeSettings()
    {
        return Cache::remember('theme_settings', 3600, function() {
            $settingsFile = storage_path('app/theme/settings.json');
            
            if (File::exists($settingsFile)) {
                $content = File::get($settingsFile);
                $settings = json_decode($content, true);
                
                if ($settings) {
                    return array_merge($this->themeSettings, $settings);
                }
            }
            
            return $this->themeSettings;
        });
    }

    protected function saveThemeSettings($settings)
    {
        $settingsDir = storage_path('app/theme');
        if (!File::exists($settingsDir)) {
            File::makeDirectory($settingsDir, 0755, true);
        }
        
        $settingsFile = $settingsDir . '/settings.json';
        File::put($settingsFile, json_encode($settings, JSON_PRETTY_PRINT));
        
        Cache::forget('theme_settings');
    }

    protected function generateCustomCSS($settings, $save = true)
    {
        $css = ":root {\n";
        $css .= "    --primary-color: {$settings['primary_color']};\n";
        $css .= "    --secondary-color: {$settings['secondary_color']};\n";
        $css .= "    --success-color: {$settings['success_color']};\n";
        $css .= "    --info-color: {$settings['info_color']};\n";
        $css .= "    --warning-color: {$settings['warning_color']};\n";
        $css .= "    --danger-color: {$settings['danger_color']};\n";
        $css .= "    --light-color: {$settings['light_color']};\n";
        $css .= "    --dark-color: {$settings['dark_color']};\n";
        $css .= "    --font-family: '{$settings['font_family']}', sans-serif;\n";
        $css .= "    --font-size: {$settings['font_size']};\n";
        $css .= "    --border-radius: {$settings['border_radius']};\n";
        $css .= "    --animation-speed: {$settings['animation_speed']};\n";
        $css .= "}\n\n";

        // Sidebar background
        if ($settings['sidebar_bg'] === 'gradient') {
            $css .= ".sidebar {\n";
            $css .= "    background: linear-gradient(135deg, {$settings['primary_color']} 0%, {$settings['secondary_color']} 100%);\n";
            $css .= "}\n\n";
        } elseif ($settings['sidebar_bg'] === 'solid') {
            $css .= ".sidebar {\n";
            $css .= "    background: {$settings['primary_color']};\n";
            $css .= "}\n\n";
        }

        // Box shadow
        $shadowValues = [
            'none' => 'none',
            'small' => '0 2px 4px rgba(0,0,0,0.1)',
            'default' => '0 4px 6px rgba(0,0,0,0.1)',
            'large' => '0 8px 25px rgba(0,0,0,0.15)'
        ];
        
        $css .= ".card, .modal-content {\n";
        $css .= "    box-shadow: {$shadowValues[$settings['box_shadow']]};\n";
        $css .= "    border-radius: var(--border-radius);\n";
        $css .= "}\n\n";

        // Button styles
        $css .= ".btn-primary {\n";
        $css .= "    background: var(--primary-color);\n";
        $css .= "    border-color: var(--primary-color);\n";
        $css .= "}\n\n";

        $css .= ".btn-secondary {\n";
        $css .= "    background: var(--secondary-color);\n";
        $css .= "    border-color: var(--secondary-color);\n";
        $css .= "}\n\n";

        // Animation
        $css .= "* {\n";
        $css .= "    transition: all var(--animation-speed) ease;\n";
        $css .= "}\n\n";

        // Font
        $css .= "body {\n";
        $css .= "    font-family: var(--font-family);\n";
        $css .= "    font-size: var(--font-size);\n";
        $css .= "}\n\n";

        if ($save) {
            $cssDir = public_path('css/admin');
            if (!File::exists($cssDir)) {
                File::makeDirectory($cssDir, 0755, true);
            }
            
            File::put($cssDir . '/custom-theme.css', $css);
        }

        return $css;
    }
}
