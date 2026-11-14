<?php
require_once __DIR__ . '/config.php';

$host = 'localhost';
$dbname = 'saniyas_kitchen';
$username = 'root';
$password = ''; // Default XAMPP MySQL password is usually blank.

try {
    $pdo = new PDO(
        "mysql:host={$host};dbname={$dbname};charset=utf8mb4",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    );
} catch (PDOException $e) {
    http_response_code(500);
    exit('Database connection failed. Check config/database.php and import database/restaurant.sql.');
}
