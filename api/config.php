<?php
// api/config.php
// ---- Edit these values to match your XAMPP MySQL ----
$DB_HOST = '127.0.0.1';
$DB_NAME = 'lab10_webapi';
$DB_USER = 'root';      // XAMPP default
$DB_PASS = '';          // XAMPP default is empty

try {
    $pdo = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8mb4", $DB_USER, $DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['success' => false, 'error' => 'DB connection failed', 'detail' => $e->getMessage()]);
    exit;
}