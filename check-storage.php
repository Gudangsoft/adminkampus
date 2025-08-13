<?php

require 'vendor/autoload.php';

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "🔧 Checking and Fixing Storage Issues...\n\n";

try {
    // Check storage configuration
    echo "📁 Checking Storage Configuration:\n";
    echo "  - Default disk: " . config('filesystems.default') . "\n";
    echo "  - Public disk root: " . config('filesystems.disks.public.root') . "\n";
    echo "  - Public disk URL: " . config('filesystems.disks.public.url') . "\n";
    echo "  - APP_URL: " . config('app.url') . "\n\n";

    // Check if storage link exists
    $publicPath = public_path('storage');
    $storagePath = storage_path('app/public');
    
    echo "🔗 Checking Storage Link:\n";
    echo "  - Public path: $publicPath\n";
    echo "  - Storage path: $storagePath\n";
    echo "  - Link exists: " . (is_link($publicPath) ? "✅ Yes" : "❌ No") . "\n";
    echo "  - Target correct: " . (readlink($publicPath) === $storagePath ? "✅ Yes" : "❌ No") . "\n\n";

    // Check storage directories
    echo "📂 Checking Storage Directories:\n";
    $directories = ['images', 'news', 'galleries', 'sliders', 'sections'];
    
    foreach ($directories as $dir) {
        $dirPath = storage_path("app/public/$dir");
        $exists = is_dir($dirPath);
        echo "  - $dir: " . ($exists ? "✅ Exists" : "❌ Missing") . "\n";
        
        if (!$exists) {
            mkdir($dirPath, 0755, true);
            echo "    → Created directory: $dirPath\n";
        }
    }

    echo "\n🖼️ Checking Gallery Images:\n";
    
    // Get all galleries
    $galleries = DB::table('galleries')->get();
    $issues = [];
    $fixed = 0;
    
    foreach ($galleries as $gallery) {
        echo "  Checking: {$gallery->title}\n";
        
        // Check if it's external URL
        if (filter_var($gallery->file_path, FILTER_VALIDATE_URL)) {
            echo "    ✅ External URL: {$gallery->file_path}\n";
            continue;
        }
        
        // Check if local file exists
        if ($gallery->file_path) {
            $fullPath = storage_path('app/public/' . $gallery->file_path);
            $webPath = Storage::url($gallery->file_path);
            
            echo "    - File path: {$gallery->file_path}\n";
            echo "    - Full path: $fullPath\n";
            echo "    - Web URL: $webPath\n";
            echo "    - File exists: " . (file_exists($fullPath) ? "✅ Yes" : "❌ No") . "\n";
            
            if (!file_exists($fullPath)) {
                $issues[] = [
                    'id' => $gallery->id,
                    'title' => $gallery->title,
                    'file_path' => $gallery->file_path,
                    'issue' => 'File not found'
                ];
            }
        } else {
            echo "    ❌ No file path specified\n";
            $issues[] = [
                'id' => $gallery->id,
                'title' => $gallery->title,
                'file_path' => $gallery->file_path,
                'issue' => 'Empty file path'
            ];
        }
        echo "\n";
    }

    if (!empty($issues)) {
        echo "⚠️  Found " . count($issues) . " issues:\n";
        foreach ($issues as $issue) {
            echo "  - ID: {$issue['id']}, Title: {$issue['title']}, Issue: {$issue['issue']}\n";
        }
        
        echo "\n🔧 Auto-fixing issues by using placeholder images...\n";
        
        // Create placeholder images directory if not exists
        $placeholderDir = storage_path('app/public/placeholders');
        if (!is_dir($placeholderDir)) {
            mkdir($placeholderDir, 0755, true);
        }
        
        // Download placeholder images
        $placeholderUrls = [
            'gallery-placeholder.jpg' => 'https://via.placeholder.com/800x600/e9ecef/6c757d?text=Gallery+Image',
            'video-placeholder.jpg' => 'https://via.placeholder.com/800x450/000000/ffffff?text=Video+Thumbnail'
        ];
        
        foreach ($placeholderUrls as $filename => $url) {
            $placeholderPath = $placeholderDir . '/' . $filename;
            if (!file_exists($placeholderPath)) {
                echo "  Downloading placeholder: $filename\n";
                $content = file_get_contents($url);
                if ($content) {
                    file_put_contents($placeholderPath, $content);
                    echo "    ✅ Downloaded: $placeholderPath\n";
                }
            }
        }
        
        // Update galleries with missing files
        foreach ($issues as $issue) {
            $gallery = DB::table('galleries')->where('id', $issue['id'])->first();
            
            if ($gallery) {
                $placeholderFile = $gallery->type === 'video' 
                    ? 'placeholders/video-placeholder.jpg'
                    : 'placeholders/gallery-placeholder.jpg';
                
                // Only update if file is local (not external URL)
                if (!filter_var($gallery->file_path, FILTER_VALIDATE_URL)) {
                    DB::table('galleries')
                        ->where('id', $issue['id'])
                        ->update([
                            'file_path' => $placeholderFile,
                            'thumbnail' => $placeholderFile,
                            'updated_at' => now()
                        ]);
                    
                    echo "    ✅ Fixed gallery ID {$issue['id']}: Using placeholder image\n";
                    $fixed++;
                }
            }
        }
        
        echo "\n✅ Fixed $fixed gallery images!\n";
    } else {
        echo "✅ No storage issues found!\n";
    }

    echo "\n🧪 Testing Storage URLs:\n";
    
    // Test some sample storage URLs
    $testFiles = [
        'test-image.jpg' => 'placeholders/gallery-placeholder.jpg'
    ];
    
    foreach ($testFiles as $testName => $filePath) {
        $storageUrl = Storage::url($filePath);
        $assetUrl = asset('storage/' . $filePath);
        
        echo "  Test file: $testName\n";
        echo "    Storage::url(): $storageUrl\n";
        echo "    asset('storage/'): $assetUrl\n";
        echo "    File exists: " . (Storage::exists($filePath) ? "✅ Yes" : "❌ No") . "\n\n";
    }

    echo "🎉 Storage check and fix completed!\n\n";
    echo "📋 Summary:\n";
    echo "  - Total galleries checked: " . count($galleries) . "\n";
    echo "  - Issues found: " . count($issues) . "\n";
    echo "  - Issues fixed: $fixed\n";
    echo "  - Storage link: " . (is_link($publicPath) ? "✅ Working" : "❌ Needs attention") . "\n\n";
    
    if (is_link($publicPath)) {
        echo "🌐 You can now test gallery images at: " . config('app.url') . "\n";
    }

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
