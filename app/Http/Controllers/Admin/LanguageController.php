<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;

class LanguageController extends Controller
{
    protected $supportedLanguages = [
        'id' => [
            'name' => 'Bahasa Indonesia',
            'native' => 'Bahasa Indonesia', 
            'flag' => '🇮🇩',
            'rtl' => false
        ],
        'en' => [
            'name' => 'English',
            'native' => 'English',
            'flag' => '🇺🇸', 
            'rtl' => false
        ]
    ];

    public function index()
    {
        $languages = $this->supportedLanguages;
        $currentLanguage = app()->getLocale();
        $translations = $this->getTranslations($currentLanguage);
        
        return view('admin.languages.index', compact('languages', 'currentLanguage', 'translations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'language' => 'required|in:id,en',
            'key' => 'required|string|max:255',
            'value' => 'required|string'
        ]);

        try {
            $language = $request->language;
            $key = $request->key;
            $value = $request->value;

            // Load existing translations
            $translations = $this->getTranslations($language);
            
            // Update translation
            data_set($translations, $key, $value);
            
            // Save translations back to file
            $this->saveTranslations($language, $translations);
            
            // Clear cache
            Cache::forget("translations_{$language}");

            return response()->json([
                'success' => true,
                'message' => 'Translation saved successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to save translation: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $language, $key)
    {
        $request->validate([
            'value' => 'required|string'
        ]);

        if (!array_key_exists($language, $this->supportedLanguages)) {
            return response()->json([
                'success' => false,
                'message' => 'Unsupported language'
            ], 400);
        }

        try {
            // Load existing translations
            $translations = $this->getTranslations($language);
            
            // Update translation
            data_set($translations, $key, $request->value);
            
            // Save translations back to file
            $this->saveTranslations($language, $translations);
            
            // Clear cache
            Cache::forget("translations_{$language}");

            return response()->json([
                'success' => true,
                'message' => 'Translation updated successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update translation: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($language, $key)
    {
        if (!array_key_exists($language, $this->supportedLanguages)) {
            return response()->json([
                'success' => false,
                'message' => 'Unsupported language'
            ], 400);
        }

        try {
            // Load existing translations
            $translations = $this->getTranslations($language);
            
            // Remove translation
            $keys = explode('.', $key);
            $current = &$translations;
            
            for ($i = 0; $i < count($keys) - 1; $i++) {
                if (!isset($current[$keys[$i]])) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Translation key not found'
                    ], 404);
                }
                $current = &$current[$keys[$i]];
            }
            
            unset($current[end($keys)]);
            
            // Save translations back to file
            $this->saveTranslations($language, $translations);
            
            // Clear cache
            Cache::forget("translations_{$language}");

            return response()->json([
                'success' => true,
                'message' => 'Translation deleted successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete translation: ' . $e->getMessage()
            ], 500);
        }
    }

    public function switchLanguage($language)
    {
        if (!array_key_exists($language, $this->supportedLanguages)) {
            return redirect()->back()->with('error', 'Unsupported language');
        }

        session(['locale' => $language]);
        app()->setLocale($language);

        return redirect()->back()->with('success', 'Language switched successfully');
    }

    public function export($language)
    {
        if (!array_key_exists($language, $this->supportedLanguages)) {
            return response()->json([
                'success' => false,
                'message' => 'Unsupported language'
            ], 400);
        }

        $translations = $this->getTranslations($language);
        $filename = "translations_{$language}_" . date('Y-m-d_H-i-s') . '.json';
        
        $headers = [
            'Content-Type' => 'application/json',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        return response()->json($translations, 200, $headers);
    }

    public function import(Request $request)
    {
        $request->validate([
            'language' => 'required|in:id,en',
            'file' => 'required|file|mimes:json'
        ]);

        try {
            $file = $request->file('file');
            $content = file_get_contents($file->getPathname());
            $translations = json_decode($content, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid JSON file'
                ], 400);
            }

            // Save imported translations
            $this->saveTranslations($request->language, $translations);
            
            // Clear cache
            Cache::forget("translations_{$request->language}");

            return response()->json([
                'success' => true,
                'message' => 'Translations imported successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to import translations: ' . $e->getMessage()
            ], 500);
        }
    }

    public function scan()
    {
        try {
            $missingKeys = [];
            $languages = array_keys($this->supportedLanguages);
            
            // Get all translation keys from views and controllers
            $allKeys = $this->scanForTranslationKeys();
            
            foreach ($languages as $language) {
                $translations = $this->getTranslations($language);
                $flatTranslations = $this->flattenArray($translations);
                
                foreach ($allKeys as $key) {
                    if (!isset($flatTranslations[$key])) {
                        $missingKeys[$language][] = $key;
                    }
                }
            }

            return response()->json([
                'success' => true,
                'missing_keys' => $missingKeys
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to scan translations: ' . $e->getMessage()
            ], 500);
        }
    }

    protected function getTranslations($language)
    {
        return Cache::remember("translations_{$language}", 3600, function() use ($language) {
            $filePath = resource_path("lang/{$language}.json");
            
            if (File::exists($filePath)) {
                $content = File::get($filePath);
                return json_decode($content, true) ?? [];
            }
            
            return [];
        });
    }

    protected function saveTranslations($language, $translations)
    {
        $filePath = resource_path("lang/{$language}.json");
        
        // Ensure lang directory exists
        $langDir = resource_path('lang');
        if (!File::exists($langDir)) {
            File::makeDirectory($langDir, 0755, true);
        }
        
        // Save translations
        File::put($filePath, json_encode($translations, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    protected function scanForTranslationKeys()
    {
        $keys = [];
        
        // Scan views directory
        $viewFiles = File::allFiles(resource_path('views'));
        foreach ($viewFiles as $file) {
            if ($file->getExtension() === 'php') {
                $content = File::get($file->getPathname());
                
                // Find translation function calls
                preg_match_all('/__\([\'"]([^\'"]+)[\'"]\)/', $content, $matches);
                foreach ($matches[1] as $key) {
                    $keys[] = $key;
                }
                
                preg_match_all('/@lang\([\'"]([^\'"]+)[\'"]\)/', $content, $matches);
                foreach ($matches[1] as $key) {
                    $keys[] = $key;
                }
            }
        }
        
        // Scan controller files
        $controllerFiles = File::allFiles(app_path('Http/Controllers'));
        foreach ($controllerFiles as $file) {
            $content = File::get($file->getPathname());
            
            preg_match_all('/__\([\'"]([^\'"]+)[\'"]\)/', $content, $matches);
            foreach ($matches[1] as $key) {
                $keys[] = $key;
            }
        }
        
        return array_unique($keys);
    }

    protected function flattenArray($array, $prefix = '')
    {
        $result = [];
        
        foreach ($array as $key => $value) {
            $newKey = $prefix === '' ? $key : $prefix . '.' . $key;
            
            if (is_array($value)) {
                $result = array_merge($result, $this->flattenArray($value, $newKey));
            } else {
                $result[$newKey] = $value;
            }
        }
        
        return $result;
    }

    public function getLanguageData()
    {
        return [
            'current' => app()->getLocale(),
            'supported' => $this->supportedLanguages,
            'translations' => $this->getTranslations(app()->getLocale())
        ];
    }

    public function createMissingTranslations()
    {
        try {
            $allKeys = $this->scanForTranslationKeys();
            $languages = array_keys($this->supportedLanguages);
            $created = 0;
            
            foreach ($languages as $language) {
                $translations = $this->getTranslations($language);
                $flatTranslations = $this->flattenArray($translations);
                $updated = false;
                
                foreach ($allKeys as $key) {
                    if (!isset($flatTranslations[$key])) {
                        // Create placeholder translation
                        data_set($translations, $key, "[{$key}]");
                        $updated = true;
                        $created++;
                    }
                }
                
                if ($updated) {
                    $this->saveTranslations($language, $translations);
                    Cache::forget("translations_{$language}");
                }
            }

            return response()->json([
                'success' => true,
                'message' => "Created {$created} missing translation placeholders"
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create missing translations: ' . $e->getMessage()
            ], 500);
        }
    }
}
