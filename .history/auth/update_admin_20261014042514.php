<?php
require_once '../config.php'; // Sesuaikan path config jika berada di folder yang sama, gunakan 'config.php'

// Buat hash password yang dijamin valid oleh PHP
$passwordBaru = 'admin123';
$hashedPassword = password_hash($passwordBaru, PASSWORD_DEFAULT);

try {
    // Update password untuk user admin
    $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE username = 'admin'");
    $stmt->execute([$hashedPassword]);

    echo "<h3>Sukses! Password admin berhasil diperbarui.</h3>";
    echo "<p>Silakan hapus file <b>update_admin.php</b> ini demi keamanan, lalu coba login kembali di Postman.</p>";
} catch (Exception $e) {
    echo "Gagal: " . $e->getMessage();
}