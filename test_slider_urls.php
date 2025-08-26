<?php

echo "=== TESTING SLIDER IMAGE URLs ===\n";

// URL server Laravel
$baseUrl = 'http://127.0.0.1:8000';

// Test URLs untuk gambar slider
$imageUrls = [
    '/storage/sliders/fKVEzAJLy9zVzUG6jNgPIRyway1gdjZm9kP6fTDu.jpg',
    '/storage/sliders/yWfmDvrLNLzP9nBgEJQmPliJEBpWA3Qbpwkov0ls.png',
    '/storage/sliders/YuL9g1FMPo1tjWUXAxKUsRQNrsmGSkw4pbhsRpEU.png'
];

foreach ($imageUrls as $imageUrl) {
    $fullUrl = $baseUrl . $imageUrl;
    echo "\nTesting: " . $fullUrl . "\n";
    
    // Test dengan cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $fullUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_NOBODY, true); // Hanya HEAD request
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
    curl_close($ch);
    
    if ($httpCode === 200) {
        echo "✓ Accessible (HTTP $httpCode)\n";
        echo "  Content-Type: $contentType\n";
    } else {
        echo "✗ Not accessible (HTTP $httpCode)\n";
    }
}

echo "\n=== TEST ADMIN SLIDER PAGE ===\n";
$adminSliderUrl = $baseUrl . '/admin/sliders';
echo "Testing admin page: " . $adminSliderUrl . "\n";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $adminSliderUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_NOBODY, true);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode === 200) {
    echo "✓ Admin slider page accessible (HTTP $httpCode)\n";
} elseif ($httpCode === 302) {
    echo "→ Redirected (HTTP $httpCode) - probably needs login\n";
} else {
    echo "✗ Admin page error (HTTP $httpCode)\n";
}

echo "\nTest completed. Check browser at: $baseUrl/admin/sliders\n";
