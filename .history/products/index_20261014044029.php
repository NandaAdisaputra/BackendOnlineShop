<?php
require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    sendResponse(false, 405, "Method tidak diizinkan", null);
}

// Validasi akses token
validateToken($pdo);

// Cek apakah user meminta pagination
$usePagination = isset($_GET['page']) || isset($_GET['limit']);

try {
    if ($usePagination) {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
        $offset = ($page - 1) * $limit;

        // Hitung total data produk
        $countStmt = $pdo->query("SELECT COUNT(*) as total FROM products");
        $totalData = $countStmt->fetch()['total'];
        $totalPages = ceil($totalData / $limit);

        // Ambil data dengan pembatasan halaman
        $stmt = $pdo->prepare("SELECT * FROM products ORDER BY id DESC LIMIT ? OFFSET ?");
        $stmt->bindValue(1, $limit, PDO::PARAM_INT);
        $stmt->bindValue(2, $offset, PDO::PARAM_INT);
        $stmt->execute();
        $products = $stmt->fetchAll();

        sendResponse(true, 200, "Berhasil mengambil daftar produk (dengan pagination)", [
            "pagination" => [
                "current_page" => $page,
                "per_page" => $limit,
                "total_data" => (int)$totalData,
                "total_pages" => (int)$totalPages
            ],
            "products" => $products
        ]);
    } else {
        // Tanpa pagination (mengembalikan semua produk untuk RecyclerView)
        $stmt = $pdo->query("SELECT * FROM products ORDER BY id DESC");
        $products = $stmt->fetchAll();

        sendResponse(true, 200, "Berhasil mengambil seluruh daftar produk", [
            "products" => $products
        ]);
    }

} catch (Exception $e) {
    sendResponse(false, 500, "Terjadi kesalahan server: " . $e->getMessage(), null);
}