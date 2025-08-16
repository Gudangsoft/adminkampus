<?php

// Test toggle status via curl
$pageId = 1; // Beranda page ID
$url = "http://127.0.0.1:8000/admin/pages/{$pageId}/toggle-status";

// First, get CSRF token from the main admin page
$adminPageContent = file_get_contents("http://127.0.0.1:8000/admin/pages");
preg_match('/<meta name="csrf-token" content="([^"]+)"/', $adminPageContent, $matches);
$csrfToken = $matches[1] ?? '';

if (empty($csrfToken)) {
    echo "❌ Could not get CSRF token\n";
    exit(1);
}

echo "🔑 CSRF Token: {$csrfToken}\n";

// Prepare PATCH request
$postData = [];
$headers = [
    'X-CSRF-TOKEN: ' . $csrfToken,
    'Content-Type: application/json',
    'X-Requested-With: XMLHttpRequest'
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "📊 HTTP Status: {$httpCode}\n";
echo "📄 Response: {$response}\n";

if ($httpCode === 200) {
    $jsonResponse = json_decode($response, true);
    if ($jsonResponse && isset($jsonResponse['success']) && $jsonResponse['success']) {
        echo "✅ Toggle status successful!\n";
        echo "📝 New status: {$jsonResponse['status']}\n";
        echo "💬 Message: {$jsonResponse['message']}\n";
    } else {
        echo "❌ Toggle failed: " . ($jsonResponse['message'] ?? 'Unknown error') . "\n";
    }
} else {
    echo "❌ HTTP Error: {$httpCode}\n";
}
