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
    // Cari user berdasarkan token yang aktif
    $stmtUser = $pdo->prepare("SELECT * FROM users WHERE token = ?");
    $stmtUser->execute([$token]);
    $user = $stmtUser->fetch();

    if (!$user) {
        sendResponse(false, 401, "Token tidak valid atau sesi telah berakhir!", null);
    }

    $user_id = $user['id'];

    // 2. Ambil data dari form-data
    $new_username = $_POST['username'] ?? '';
    $old_password = $_POST['old_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';

    if (empty($new_username)) {
        sendResponse(false, 400, "Username wajib diisi!", null);
    }

    // 3. Cek apakah username baru sudah digunakan oleh user lain di database
    $stmtCheckUsername = $pdo->prepare("SELECT * FROM users WHERE username = ? AND id != ?");
    $stmtCheckUsername->execute([$new_username, $user_id]);
    if ($stmtCheckUsername->fetch()) {
        sendResponse(false, 400, "Username sudah digunakan oleh akun lain!", null);
    }

    // Default gunakan password lama yang sudah di-hash
    $hashedPassword = $user['password'];

    // 4. Jika user ingin mengganti password (old_password & new_password diisi)
    if (!empty($old_password) || !empty($new_password)) {
        if (empty($old_password) || empty($new_password)) {
            sendResponse(false, 400, "Untuk mengubah password, password lama dan password baru wajib diisi!", null);
        }

        // Verifikasi password lama
        if (!password_verify($old_password, $user['password'])) {
            sendResponse(false, 400, "Password lama yang Anda masukkan salah!", null);
        }

        // Validasi panjang password baru minimal 6 karakter
        if (strlen($new_password) < 6) {
            sendResponse(false, 400, "Password baru minimal harus 6 karakter!", null);
        }

        $hashedPassword = password_hash($new_password, PASSWORD_DEFAULT);
    }

    // 5. Update username dan password di database
    $stmtUpdate = $pdo->prepare("UPDATE users SET username = ?, password = ? WHERE id = ?");
    $stmtUpdate->execute([$new_username, $hashedPassword, $user_id]);

    // 6. Ambil data terbaru untuk dikembalikan sebagai respons
    $stmtRefresh = $pdo->prepare("SELECT id, username, email, alamat, no_whatsapp, role FROM users WHERE id = ?");
    $stmtRefresh->execute([$user_id]);
    $updatedUser = $stmtRefresh->fetch();

    sendResponse(true, 200, "Profil (username & password) berhasil diperbarui.", $updatedUser);

} catch (Exception $e) {
    sendResponse(false, 500, "Terjadi kesalahan server: " . $e->getMessage(), null);
}