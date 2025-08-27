<?php
require_once 'vendor/autoload.php';

// Test file untuk CRUD Jabatan Struktural
$baseUrl = 'http://127.0.0.1:8000';

echo "=== TEST CRUD JABATAN STRUKTURAL ===\n\n";

// Test 1: Akses halaman index jabatan struktural
echo "1. Testing Index Page:\n";
$indexUrl = $baseUrl . '/admin/structural-positions';
echo "URL: $indexUrl\n";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $indexUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_NOBODY, true);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "HTTP Status: $httpCode\n";
if ($httpCode == 200) {
    echo "✅ Index page accessible\n";
} else {
    echo "❌ Index page not accessible\n";
}

echo "\n";

// Test 2: Cek route create
echo "2. Testing Create Page:\n";
$createUrl = $baseUrl . '/admin/structural-positions/create';
echo "URL: $createUrl\n";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $createUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_NOBODY, true);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "HTTP Status: $httpCode\n";
if ($httpCode == 200) {
    echo "✅ Create page accessible\n";
} else {
    echo "❌ Create page not accessible\n";
}

echo "\n";

// Test 3: Cek data di database
echo "3. Testing Database Data:\n";
$dbConfig = [
    'host' => '127.0.0.1',
    'dbname' => 'adminkampus',
    'username' => 'root',
    'password' => ''
];

try {
    $pdo = new PDO("mysql:host={$dbConfig['host']};dbname={$dbConfig['dbname']}", 
                   $dbConfig['username'], $dbConfig['password']);
    
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM structural_positions");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    echo "Total structural positions in database: " . $result['count'] . "\n";
    
    if ($result['count'] > 0) {
        echo "✅ Database has data\n";
        
        // Ambil beberapa data sample
        $stmt = $pdo->query("SELECT name, category, level FROM structural_positions ORDER BY sort_order LIMIT 5");
        $positions = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo "\nSample positions:\n";
        foreach ($positions as $position) {
            echo "- {$position['name']} (Category: {$position['category']}, Level: {$position['level']})\n";
        }
    } else {
        echo "❌ No data in database\n";
    }
    
} catch (PDOException $e) {
    echo "❌ Database connection failed: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 4: Test routes yang terdaftar
echo "4. Testing Routes:\n";
$routeUrls = [
    'Index' => '/admin/structural-positions',
    'Create' => '/admin/structural-positions/create',
    'Show' => '/admin/structural-positions/1',
    'Edit' => '/admin/structural-positions/1/edit',
];

foreach ($routeUrls as $name => $route) {
    $url = $baseUrl . $route;
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    echo "$name ($route): ";
    if ($httpCode == 200) {
        echo "✅ OK\n";
    } else {
        echo "❌ HTTP $httpCode\n";
    }
}

echo "\n=== TEST COMPLETED ===\n";
