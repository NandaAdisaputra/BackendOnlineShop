<?php
// Header CORS & Respon JSON
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
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

// Fungsi Middleware Validasi Token
function validateToken($pdo) {
    $headers = function_exists('apache_request_headers') ? apache_request_headers() : [];
    $authHeader = $headers['Authorization'] ?? $headers['authorization'] ?? $_SERVER['HTTP_AUTHORIZATION'] ?? '';

    if (!preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
        sendResponse(false, 401, "Token akses tidak ditemukan atau format salah!", null);
    }

    $token = $matches[1];
    $stmt = $pdo->prepare("SELECT * FROM users WHERE token = ?");
    $stmt->execute([$token]);
    $user = $stmt->fetch();

    if (!$user) {
        sendResponse(false, 401, "Token tidak valid atau kedaluwarsa, silakan login ulang.", null);
    }

    return $user;
}
// Fungsi untuk mengubah nama file gambar menjadi URL lengkap
function getImageUrl($filename) {
    if (empty($filename)) {
        return null;
    }
    
    // Deteksi protokol (http / https) dan host secara dinamis
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
    $host = $_SERVER['HTTP_HOST'];
    
    // Sesuaikan '/OnlineShop/uploads/' dengan nama folder proyek Anda di htdocs
    return $protocol . "://" . $host . "/OnlineShop/uploads/" . $filename;
}
// Fungsi untuk handle upload file gambar
function uploadImage($file) {
    if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
        return null;
    }

    $targetDir = __DIR__ . '/../uploads/';
    // Buat folder uploads jika belum ada
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];

    if (!in_array($fileExtension, $allowedExtensions)) {
        return "INVALID_FORMAT";
    }

    // Buat nama file unik agar tidak bentrok
    $fileName = uniqid('prod_') . '.' . $fileExtension;
    $targetFilePath = $targetDir . $fileName;

    if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
        return $fileName;
    }

    return null;
}