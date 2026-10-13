<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendResponse(false, 405, "Method tidak diizinkan", null);
}

// Ambil Header Authorization (Kompatibel dengan Apache, Nginx, & PHP Built-in Server)
$headers = function_exists('apache_request_headers') ? apache_request_headers() : [];
$authHeader = $headers['Authorization'] ?? $headers['authorization'] ?? $_SERVER['HTTP_AUTHORIZATION'] ?? '';

if (!preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
    sendResponse(false, 401, "Token akses tidak ditemukan atau format salah!", null);
}

$token = $matches[1];

try {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE token = ?");
    $stmt->execute([$token]);
    $user = $stmt->fetch();

    if (!$user) {
        sendResponse(false, 401, "Token tidak valid atau kedaluwarsa, silakan login ulang.", null);
    }

    // Ambil data dari form-data Postman
    $old_password = $_POST['old_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';

    if (empty($old_password) || empty($new_password)) {
        sendResponse(false, 400, "Password lama dan password baru wajib diisi!", null);
    }

    if (!password_verify($old_password, $user['password'])) {
        sendResponse(false, 400, "Password lama yang Anda masukkan salah!", null);
    }

    $hashedNewPassword = password_hash($new_password, PASSWORD_DEFAULT);
    $updateStmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
    $updateStmt->execute([$hashedNewPassword, $user['id']]);

    sendResponse(true, 200, "Password berhasil diubah.", null);

} catch (Exception $e) {
    sendResponse(false, 500, "Terjadi kesalahan server: " . $e->getMessage(), null);
}