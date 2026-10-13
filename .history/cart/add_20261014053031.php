<?php
require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendResponse(false, 405, "Method tidak diizinkan, gunakan POST.", null);
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

    // 2. Ambil data dari form-data Postman
    $product_id = $_POST['product_id'] ?? '';
    $quantity   = $_POST['quantity'] ?? 1; // Default kuantiti 1 jika tidak diisi

    if (empty($product_id)) {
        sendResponse(false, 400, "ID produk wajib diisi!", null);
    }

    // 3. Cek apakah produk benar-benar ada di database
    $stmtProd = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmtProd->execute([$product_id]);
    $product = $stmtProd->fetch();

    if (!$product) {
        sendResponse(false, 404, "Produk tidak ditemukan!", null);
    }

    // 4. Cek apakah produk tersebut sudah ada di keranjang user ini sebelumnya
    $stmtCheckCart = $pdo->prepare("SELECT * FROM cart WHERE user_id = ? AND product_id = ?");
    $stmtCheckCart->execute([$user_id, $product_id]);
    $cartItem = $stmtCheckCart->fetch();

    if ($cartItem) {
        // Jika sudah ada, tambahkan quantity-nya
        $newQuantity = $cartItem['quantity'] + (int)$quantity;
        $stmtUpdate = $pdo->prepare("UPDATE cart SET quantity = ? WHERE id = ?");
        $stmtUpdate->execute([$newQuantity, $cartItem['id']]);
        $cartId = $cartItem['id'];
    } else {
        // Jika belum ada, masukkan baris baru ke tabel cart
        $stmtInsert = $pdo->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)");
        $stmtInsert->execute([$user_id, $product_id, $quantity]);
        $cartId = $pdo->lastInsertId();
    }

    // 5. Ambil detail keranjang terbaru beserta informasi produknya untuk dikirim sebagai response
    $stmtDetail = $pdo->prepare("
        SELECT cart.id AS cart_id, cart.quantity, products.id AS product_id, 
               products.nama_product, products.harga, products.gambar 
        FROM cart 
        JOIN products ON cart.product_id = products.id 
        WHERE cart.id = ?
    ");
    $stmtDetail->execute([$cartId]);
    $result = $stmtDetail->fetch();
    
    // Ubah gambar menjadi URL lengkap
    $result['gambar'] = getImageUrl($result['gambar']);
    $result['total_harga'] = (float)$result['harga'] * (int)$result['quantity'];

    sendResponse(true, 201, "Produk berhasil ditambahkan ke keranjang.", $result);

} catch (Exception $e) {
    sendResponse(false, 500, "Terjadi kesalahan server: " . $e->getMessage(), null);
}