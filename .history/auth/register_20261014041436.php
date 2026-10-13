<?php
require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendResponse(false, 405, "Method tidak diizinkan", null);
}

// Ambil data dari form-data Postman
$username    = $_POST['username'] ?? '';
$email       = $_POST['email'] ?? '';
$alamat      = $_POST['alamat'] ?? '';
$no_whatsapp = $_POST['no_whatsapp'] ?? '';
$password    = $_POST['password'] ?? '';

// Validasi field kosong
if (empty($username) || empty($email) || empty($alamat) || empty($no_whatsapp) || empty($password)) {
    sendResponse(false, 400, "Semua field wajib diisi!", null);
}

try {
    // Cek apakah username atau email sudah terdaftar
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
    $stmt->execute([$username, $email]);
    if ($stmt->rowCount() > 0) {
        sendResponse(false, 409, "Username atau email sudah digunakan!", null);
    }

    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert user baru dengan role 'user'
    $stmt = $pdo->prepare("INSERT INTO users (username, email, alamat, no_whatsapp, password, role) VALUES (?, ?, ?, ?, ?, 'user')");
    $stmt->execute([$username, $email, $alamat, $no_whatsapp, $hashedPassword]);

    sendResponse(true, 201, "Registrasi berhasil, silakan login.", [
        "username" => $username,
        "email" => $email
    ]);

} catch (Exception $e) {
    sendResponse(false, 500, "Terjadi kesalahan server: " . $e->getMessage(), null);
}