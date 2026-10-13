<?php
require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    sendResponse(false, 405, "Method tidak diizinkan, gunakan GET.", null);
}

// 1. Ambil dan validasi Token dari Header Authorization
$headers = apache_request_headers();
$authHeader = $headers['Authorization'] ?? $_SERVER['HTTP_AUTHORIZATION'] ?? '';

if (empty($authHeader) || !preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
    sendResponse(false, 401, "Token akses tidak ditemukan atau format salah!", null);
}
$token = $matches[1];

try {
    // Cari user berdasarkan token yang aktif untuk mendapatkan user_id
    $stmtUser = $pdo->prepare("SELECT * FROM users WHERE token = ?");
    $stmtUser->execute([$token]);
    $user = $stmtUser->fetch();

    if (!$user) {
        sendResponse(false, 401, "Token tidak valid atau sesi telah berakhir!", null);
    }

    $user_id = $user['id'];

    // 2. Ambil daftar produk di keranjang milik user tersebut dengan melakukan JOIN ke tabel products
    $stmtCart = $pdo->prepare("
        SELECT 
            cart.id AS cart_id, 
            cart.quantity, 
            cart.created_at,
            products.id AS product_id, 
            products.nama_product, 
            products.harga, 
            products.deskripsi, 
            products.gambar 
        FROM cart 
        JOIN products ON cart.product_id = products.id 
        WHERE cart.user_id = ? 
        ORDER BY cart.id DESC
    ");
    $stmtCart->execute([$user_id]);
    $cartItems = $stmtCart->fetchAll();

    $grandTotal = 0;
    $formattedItems = [];

    foreach ($cartItems as $item) {
        $subtotal = (float)$item['harga'] * (int)$item['quantity'];
        $grandTotal += $subtotal;

        $formattedItems[] = [
            "cart_id" => (int)$item['cart_id'],
            "product_id" => (int)$item['product_id'],
            "nama_product" => $item['nama_product'],
            "harga" => (float)$item['harga'],
            "deskripsi" => $item['deskripsi'],
            "gambar" => getImageUrl($item['gambar']), // URL absolut gambar
            "quantity" => (int)$item['quantity'],
            "subtotal" => $subtotal,
            "created_at" => $item['created_at']
        ];
    }

    // 3. Kirim respons JSON standar industri
    sendResponse(true, 200, "Berhasil memuat daftar keranjang belanja.", [
        "user_id" => (int)$user_id,
        "total_items" => count($formattedItems),
        "grand_total" => $grandTotal,
        "items" => $formattedItems // Array utama ini yang nanti di-looping ke RecyclerViewAdapter
    ]);

} catch (Exception $e) {
    sendResponse(false, 500, "Terjadi kesalahan server: " . $e->getMessage(), null);
}