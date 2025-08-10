<?php
// Create proper favicon.ico from existing PNG
function createFaviconIco() {
    $pngFile = 'public/favicon-32x32.png';
    $icoFile = 'public/favicon.ico';
    
    if (!file_exists($pngFile)) {
        echo "PNG file not found: $pngFile\n";
        return false;
    }
    
    // Read PNG file
    $png = imagecreatefrompng($pngFile);
    
    // Create ICO header
    $ico = '';
    $ico .= pack('v', 0);       // Reserved
    $ico .= pack('v', 1);       // Type (1 = ICO)
    $ico .= pack('v', 1);       // Number of images
    
    // Create ICO directory entry
    $ico .= pack('C', 32);      // Width (32px)
    $ico .= pack('C', 32);      // Height (32px)
    $ico .= pack('C', 0);       // Colors (0 = 256+)
    $ico .= pack('C', 0);       // Reserved
    $ico .= pack('v', 1);       // Planes
    $ico .= pack('v', 32);      // Bits per pixel
    
    // Create PNG data for ICO
    ob_start();
    imagepng($png);
    $pngData = ob_get_contents();
    ob_end_clean();
    
    $ico .= pack('V', strlen($pngData)); // Size of image data
    $ico .= pack('V', 22);               // Offset to image data
    
    // Append PNG data
    $ico .= $pngData;
    
    // Write ICO file
    file_put_contents($icoFile, $ico);
    
    imagedestroy($png);
    
    echo "favicon.ico created successfully!\n";
    return true;
}

// Also create a simple text-based favicon
function createSimpleFavicon() {
    $width = 32;
    $height = 32;
    
    $image = imagecreatetruecolor($width, $height);
    
    // Enable alpha blending
    imagealphablending($image, false);
    imagesavealpha($image, true);
    
    // Colors
    $transparent = imagecolorallocatealpha($image, 0, 0, 0, 127);
    $blue = imagecolorallocate($image, 102, 126, 234);
    $purple = imagecolorallocate($image, 118, 75, 162);
    $white = imagecolorallocate($image, 255, 255, 255);
    
    // Fill with transparent background
    imagefill($image, 0, 0, $transparent);
    
    // Create gradient background (simplified)
    for ($y = 0; $y < $height; $y++) {
        $ratio = $y / $height;
        $r = 102 + ($ratio * (118 - 102));
        $g = 126 + ($ratio * (75 - 126));
        $b = 234 + ($ratio * (162 - 234));
        $color = imagecolorallocate($image, $r, $g, $b);
        imageline($image, 0, $y, $width - 1, $y, $color);
    }
    
    // Draw university symbol (simplified graduation cap)
    // Cap base
    imagefilledrectangle($image, 6, 18, 26, 21, $white);
    
    // Cap top (simplified diamond)
    $points = array(
        16, 6,   // top
        22, 12,  // right
        16, 18,  // bottom
        10, 12   // left
    );
    imagefilledpolygon($image, $points, 4, $white);
    
    // Add letter "U" for University
    imagestring($image, 4, 11, 22, 'U', $white);
    
    // Save as PNG
    imagepng($image, 'public/favicon-simple.png');
    
    // Also overwrite the main favicon.ico with a simpler version
    imagepng($image, 'public/favicon.png');
    
    // Copy as ICO (browsers will accept PNG with .ico extension)
    copy('public/favicon.png', 'public/favicon.ico');
    
    imagedestroy($image);
    
    echo "Simple favicon created!\n";
}

// Execute
createSimpleFavicon();
createFaviconIco();

echo "\nFavicon files created:\n";
echo "- favicon.ico (main favicon)\n";
echo "- favicon-32x32.png\n";
echo "- favicon-16x16.png\n";
echo "- apple-touch-icon.png\n";
echo "- favicon.svg (vector version)\n";
?>
