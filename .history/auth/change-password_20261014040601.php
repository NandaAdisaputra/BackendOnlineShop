<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendResponse(false, 405, "Method tidak diizinkan", null);
}

// Ambil Header Authorization
$headers = apache_request_headers();
$authHeader = $headers['Authorization'] ?? $headers['authorization'] ?? '';

if (!preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
    sendResponse(false, 401, "Token akses tidak ditemukan atau format salah!", null);
}

$token = $matches[1];

try {
    // Validasi token di database
    $stmt = $pdo->prepare("SELECT * FROM users WHERE token = ?");
    $stmt->execute([$token]);
    $user = $stmt->fetch();

    if (!$user) {
        sendResponse(false, 401, "Token tidak valid atau kedaluwarsa, silakan login ulang.", null);
    }

    $input = json_decode(file_get_contents('php://input'), true);
    $old_password = $input['old_password'] ?? '';
    $new_password = $input['new_password'] ?? '';

    if (empty($old_password) || empty($new_password)) {
        sendResponse(false, 400, "Password lama dan password baru wajib diisi!", null);
    }

    // Verifikasi password lama
    if (!password_verify($old_password, $user['password'])) {
        sendResponse(false, 400, "Password lama yang Anda masukkan salah!", null);
    }

    // Hash password baru dan simpan
    $hashedNewPassword = password_hash($new_password, PASSWORD_DEFAULT);
    $updateStmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
    $updateStmt->execute([$hashedNewPassword, $user['id']]);

    sendResponse(true, 200, "Password berhasil diubah.", null);

} catch (Exception $e) {
    sendResponse(false, 500, "Terjadi kesalahan server: " . $e->getMessage(), null);
}