<?php
// Header CORS & Respon JSON
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$host = 'localhost';
$db   = 'db_online_shop';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    echo json_encode([
        "status" => false,
        "code" => 500,
        "message" => "Koneksi database gagal: " . $e->getMessage(),
        "data" => null
    ]);
    exit();
}

// Fungsi Standar Industri untuk Response API
function sendResponse($status, $code, $message, $data = null) {
    http_response_code($code);
    echo json_encode([
        "status" => $status,
        "code" => $code,
        "message" => $message,
        "data" => $data
    ]);
    exit();
}