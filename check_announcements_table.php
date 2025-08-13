<?php

require_once 'vendor/autoload.php';

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Create database connection
$pdo = new PDO(
    'mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_DATABASE'],
    $_ENV['DB_USERNAME'],
    $_ENV['DB_PASSWORD']
);

echo "=== Announcements Table Structure ===\n";

$result = $pdo->query("DESCRIBE announcements");
$columns = $result->fetchAll(PDO::FETCH_ASSOC);

foreach ($columns as $column) {
    echo $column['Field'] . " (" . $column['Type'] . ") " . ($column['Null'] === 'YES' ? 'NULL' : 'NOT NULL') . "\n";
}

echo "\n=== Total columns: " . count($columns) . " ===\n";
