<?php
// Create a simple 32x32 favicon
$width = 32;
$height = 32;

// Create image
$image = imagecreate($width, $height);

// Define colors
$bg_start = imagecolorallocate($image, 102, 126, 234); // #667eea
$bg_end = imagecolorallocate($image, 118, 75, 162);    // #764ba2
$white = imagecolorallocate($image, 255, 255, 255);

// Fill background with gradient effect (simplified)
imagefill($image, 0, 0, $bg_start);

// Draw graduation cap
// Cap base (rectangle)
imagefilledrectangle($image, 8, 18, 24, 21, $white);

// Cap top (diamond/square)
$diamond = array(
    16, 8,   // top
    20, 12,  // right
    16, 16,  // bottom  
    12, 12   // left
);
imagefilledpolygon($image, $diamond, 4, $white);

// Tassel
imagefilledrectangle($image, 18, 8, 19, 14, $white);
imagefilledrectangle($image, 17, 7, 20, 8, $white);

// Add "U" letter
imagestring($image, 3, 13, 22, 'U', $white);

// Output as PNG first (ICO is complex format)
header('Content-Type: image/png');
imagepng($image, 'favicon-32x32.png');

// Also create 16x16 version
$small = imagecreatetruecolor(16, 16);
imagecopyresampled($small, $image, 0, 0, 0, 0, 16, 16, 32, 32);
imagepng($small, 'favicon-16x16.png');

// Create apple touch icon (180x180)
$apple = imagecreatetruecolor(180, 180);
imagecopyresampled($apple, $image, 0, 0, 0, 0, 180, 180, 32, 32);
imagepng($apple, 'apple-touch-icon.png');

// Clean up
imagedestroy($image);
imagedestroy($small);
imagedestroy($apple);

echo "Favicon files generated successfully!\n";
echo "- favicon-32x32.png\n";
echo "- favicon-16x16.png\n";
echo "- apple-touch-icon.png\n";
?>
