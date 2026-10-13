<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendResponse(false, 405, "Method tidak diizinkan", null);
}

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($username) || empty($password)) {
    sendResponse(false, 400, "Username dan password wajib diisi!", null);
}

try {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if (!$user || !password_verify($password, $user['password'])) {
        sendResponse(false, 401, "Username atau password salah!", null);
    }

    $token = bin2hex(random_bytes(32));

    $updateStmt = $pdo->prepare("UPDATE users SET token = ? WHERE id = ?");
    $updateStmt->execute([$token, $user['id']]);

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