<?php
require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    sendResponse(false, 405, "Method tidak diizinkan", null);
}

validateToken($pdo);
$keyword = $_GET['q'] ?? '';

if (empty($keyword)) {
    sendResponse(false, 400, "Parameter pencarian 'q' wajib diisi!", null);
}

try {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE nama_product LIKE ? OR deskripsi LIKE ? ORDER BY id DESC");
    $searchKeyword = "%" . $keyword . "%";
    $stmt->execute([$searchKeyword, $searchKeyword]);
    $products = $stmt->fetchAll();

    // Ubah gambar menjadi URL lengkap
    foreach ($products as &$product) {
        $product['gambar'] = getImageUrl($product['gambar']);
    }
    unset($product);

    sendResponse(true, 200, "Pencarian produk berhasil", [
        "keyword" => $keyword,
        "total_found" => count($products),
        "products" => $products
    ]);

} catch (Exception $e) {
    sendResponse(false, 500, "Terjadi kesalahan server: " . $e->getMessage(), null);
}