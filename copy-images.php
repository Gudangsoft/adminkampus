<?php
$sourceDir = 'd:\PROJECT-KAMPUS\storage\app\public\news';
$destDir = 'd:\PROJECT-KAMPUS\public\storage\news';

// Ensure destination directory exists
if (!is_dir($destDir)) {
    mkdir($destDir, 0755, true);
}

$files = glob($sourceDir . '/*');
foreach ($files as $file) {
    if (is_file($file)) {
        $filename = basename($file);
        $destFile = $destDir . '\\' . $filename;
        if (copy($file, $destFile)) {
            echo "Copied: $filename\n";
        } else {
            echo "Failed to copy: $filename\n";
        }
    }
}

echo "Copy completed!\n";
?>
