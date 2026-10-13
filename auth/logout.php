<?php
require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendResponse(false, 405, "Method tidak diizinkan, gunakan POST.", null);
}

// 1. Ambil dan validasi Token dari Header Authorization
$headers = apache_request_headers();
$authHeader = $headers['Authorization'] ?? $_SERVER['HTTP_AUTHORIZATION'] ?? '';

if (empty($authHeader) || !preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
    sendResponse(false, 401, "Token akses tidak ditemukan atau format salah!", null);
}
$token = $matches[1];

try {
    // 2. Cari user berdasarkan token yang sedang aktif
    $stmtUser = $pdo->prepare("SELECT * FROM users WHERE token = ?");
    $stmtUser->execute([$token]);
    $user = $stmtUser->fetch();

    if (!$user) {
        sendResponse(false, 401, "Token tidak valid atau sesi telah berakhir!", null);
    }

    // 3. Kosongkan token di database untuk mematikan sesi user tersebut
    $stmtLogout = $pdo->prepare("UPDATE users SET token = NULL WHERE id = ?");
    $stmtLogout->execute([$user['id']]);

    // 4. Kirim respons sukses
    sendResponse(true, 200, "Logout berhasil. Sesi telah diakhiri.", null);

} catch (Exception $e) {
    sendResponse(false, 500, "Terjadi kesalahan server: " . $e->getMessage(), null);
}