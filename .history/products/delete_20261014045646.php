<?php
require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendResponse(false, 405, "Method tidak diizinkan", null);
}

// Validasi Token Akses
validateToken($pdo);

$id = $_POST['id'] ?? '';

if (empty($id)) {
    sendResponse(false, 400, "ID produk wajib disertakan!", null);
}

try {
    // Cek apakah produk ada
    $stmtCheck = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmtCheck->execute([$id]);
    $product = $stmtCheck->fetch();

    if (!$product) {
        sendResponse(false, 404, "Produk tidak ditemukan!", null);
    }

    // Hapus file gambar fisik dari folder uploads jika ada
    if (!empty($product['gambar'])) {
        $filePath = __DIR__ . '/../uploads/' . $product['gambar'];
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

    // Hapus dari database
    $stmtDelete = $pdo->prepare("DELETE FROM products WHERE id = ?");
    $stmtDelete->execute([$id]);

    sendResponse(true, 200, "Produk berhasil dihapus.", [
        "id" => (int)$id
    ]);

} catch (Exception $e) {
    sendResponse(false, 500, "Terjadi kesalahan server: " . $e->getMessage(), null);
}