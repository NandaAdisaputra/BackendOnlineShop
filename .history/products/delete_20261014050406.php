<?php
require_once '../config.php';

// Pastikan method adalah DELETE
if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    sendResponse(false, 405, "Method tidak diizinkan, gunakan DELETE", null);
}

validateToken($pdo);

// Karena method DELETE, data diambil dari php://input (JSON atau x-www-form-urlencoded)
parse_str(file_get_contents("php://input"), $input);
$id = $input['id'] ?? '';

if (empty($id)) {
    sendResponse(false, 400, "ID produk wajib disertakan!", null);
}

try {
    $stmtCheck = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmtCheck->execute([$id]);
    $product = $stmtCheck->fetch();

    if (!$product) {
        sendResponse(false, 404, "Produk tidak ditemukan!", null);
    }

    // Hapus file gambar fisik jika ada
    if (!empty($product['gambar'])) {
        $filePath = __DIR__ . '/../uploads/' . $product['gambar'];
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

    $stmtDelete = $pdo->prepare("DELETE FROM products WHERE id = ?");
    $stmtDelete->execute([$id]);

    sendResponse(true, 200, "Produk berhasil dihapus.", ["id" => (int)$id]);

} catch (Exception $e) {
    sendResponse(false, 500, "Terjadi kesalahan server: " . $e->getMessage(), null);
}