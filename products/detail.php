<?php
require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    sendResponse(false, 405, "Method tidak diizinkan", null);
}

validateToken($pdo);
$id = $_GET['id'] ?? '';

if (empty($id)) {
    sendResponse(false, 400, "ID produk wajib disertakan!", null);
}

try {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$id]);
    $product = $stmt->fetch();

    if (!$product) {
        sendResponse(false, 404, "Produk tidak ditemukan!", null);
    }

    // Ubah gambar menjadi URL lengkap
    $product['gambar'] = getImageUrl($product['gambar']);

    sendResponse(true, 200, "Detail produk berhasil dimuat", $product);

} catch (Exception $e) {
    sendResponse(false, 500, "Terjadi kesalahan server: " . $e->getMessage(), null);
}