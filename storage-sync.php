<?php

/**
 * Storage Sync Script for Windows Symlink Issues
 * 
 * This script ensures all files in storage/app/public are 
 * available in public/storage for proper image display
 */

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$sourceDir = storage_path('app/public');
$destDir = public_path('storage');

function syncDirectory($source, $dest) {
    // Ensure destination directory exists
    if (!is_dir($dest)) {
        mkdir($dest, 0755, true);
        echo "Created directory: $dest\n";
    }
    
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($source),
        RecursiveIteratorIterator::SELF_FIRST
    );
    
    foreach ($iterator as $item) {
        $sourceItem = $item->getPathname();
        $relativePath = str_replace($source . DIRECTORY_SEPARATOR, '', $sourceItem);
        $destItem = $dest . DIRECTORY_SEPARATOR . $relativePath;
        
        if ($item->isDir()) {
            if (!is_dir($destItem)) {
                mkdir($destItem, 0755, true);
                echo "Created directory: $destItem\n";
            }
        } else {
            if (!file_exists($destItem) || filemtime($sourceItem) > filemtime($destItem)) {
                if (copy($sourceItem, $destItem)) {
                    echo "Synced file: $relativePath\n";
                } else {
                    echo "Failed to sync: $relativePath\n";
                }
            }
        }
    }
}

echo "Starting storage sync...\n";
echo "Source: $sourceDir\n";
echo "Destination: $destDir\n";
echo "----------------------------------------\n";

syncDirectory($sourceDir, $destDir);

echo "----------------------------------------\n";
echo "Storage sync completed!\n";

// Test a specific image
$testImage = 'news/1754717316_seminar-nasional-ai-dan-masa-depan-teknologi.jpeg';
$testPath = public_path('storage/' . $testImage);

if (file_exists($testPath)) {
    echo "✓ Test image is accessible: $testImage\n";
    echo "✓ File size: " . number_format(filesize($testPath)) . " bytes\n";
} else {
    echo "✗ Test image not found: $testPath\n";
}

?>
