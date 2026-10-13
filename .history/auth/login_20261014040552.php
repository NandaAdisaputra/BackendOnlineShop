<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendResponse(false, 405, "Method tidak diizinkan", null);
}

$input = json_decode(file_get_contents('php://input'), true);
$username = $input['username'] ?? '';
$password = $input['password'] ?? '';

if (empty($username) || empty($password)) {
    sendResponse(false, 400, "Username dan password wajib diisi!", null);
}

try {
    // Cari user berdasarkan username
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if (!$user || !password_verify($password, $user['password'])) {
        sendResponse(false, 401, "Username atau password salah!", null);
    }

    // Generate token aman menggunakan fungsi native PHP
    $token = bin2hex(random_bytes(32));

    // Simpan token ke database
    $updateStmt = $pdo->prepare("UPDATE users SET token = ? WHERE id = ?");
    $updateStmt->execute([$token, $user['id']]);

    // Berikan respons sukses lengkap dengan rolenya (user / admin)
    sendResponse(true, 200, "Login berhasil.", [
        "id" => $user['id'],
        "username" => $user['username'],
        "email" => $user['email'],
        "alamat" => $user['alamat'],
        "no_whatsapp" => $user['no_whatsapp'],
        "role" => $user['role'],
        "token" => $token
    ]);

} catch (Exception $e) {
    sendResponse(false, 500, "Terjadi kesalahan server: " . $e->getMessage(), null);
}