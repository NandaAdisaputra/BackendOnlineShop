<?php
require_once '../config.php';

// Gunakan POST agar form-data langsung terbaca otomatis oleh PHP di $_POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendResponse(false, 405, "Method tidak diizinkan, gunakan POST untuk form-data.", null);
}

// 1. Ambil dan validasi Token dari Header Authorization
$headers = apache_request_headers();
$authHeader = $headers['Authorization'] ?? $_SERVER['HTTP_AUTHORIZATION'] ?? '';

if (empty($authHeader) || !preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
    sendResponse(false, 401, "Token akses tidak ditemukan atau format salah!", null);
}
$token = $matches[1];

try {
    // Cari user berdasarkan token yang aktif
    $stmtUser = $pdo->prepare("SELECT * FROM users WHERE token = ?");
    $stmtUser->execute([$token]);
    $user = $stmtUser->fetch();

    if (!$user) {
        sendResponse(false, 401, "Token tidak valid atau sesi telah berakhir!", null);
    }

    // 2. Ambil data langsung dari form-data ($_POST)
    $old_password = $_POST['old_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';

    // Validasi input kosong
    if (empty($old_password) || empty($new_password)) {
        sendResponse(false, 400, "Password lama dan password baru wajib diisi!", null);
    }

    // 3. Verifikasi apakah password lama sudah benar
    if (!password_verify($old_password, $user['password'])) {
        sendResponse(false, 400, "Password lama yang Anda masukkan salah!", null);
    }

    // Validasi panjang password baru (minimal 6 karakter)
    if (strlen($new_password) < 6) {
        sendResponse(false, 400, "Password baru minimal harus 6 karakter!", null);
    }

    // 4. Hash password baru menggunakan BCRYPT
    $hashedNewPassword = password_hash($new_password, PASSWORD_DEFAULT);

    // 5. Simpan perubahan ke database
    $stmtUpdate = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
    $stmtUpdate->execute([$hashedNewPassword, $user['id']]);

    sendResponse(true, 200, "Password berhasil diperbarui.", [
        "id" => (int)$user['id'],
        "username" => $user['username'],
        "email" => $user['email']
    ]);

} catch (Exception $e) {
    sendResponse(false, 500, "Terjadi kesalahan server: " . $e->getMessage(), null);
}