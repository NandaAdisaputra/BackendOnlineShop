<?php
require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendResponse(false, 405, "Method tidak diizinkan", null);
}

// Validasi Token Akses
validateToken($pdo);

// Ambil data dari form-data Postman
$nama_product = $_POST['nama_product'] ?? '';
$harga        = $_POST['harga'] ?? '';
$deskripsi    = $_POST['deskripsi'] ?? '';
$fileGambar   = $_FILES['gambar'] ?? null;

// Validasi input kosong
if (empty($nama_product) || empty($harga) || empty($deskripsi)) {
    sendResponse(false, 400, "Nama product, harga, dan deskripsi wajib diisi!", null);
}

// Proses Upload Gambar
$namaFileGambar = null;
if ($fileGambar && $fileGambar['error'] === UPLOAD_ERR_OK) {
    $uploadResult = uploadImage($fileGambar);
    if ($uploadResult === "INVALID_FORMAT") {
        sendResponse(false, 400, "Format gambar tidak valid! Gunakan JPG, JPEG, PNG, atau WEBP.", null);
    }
    $namaFileGambar = $uploadResult;
}

try {
    $stmt = $pdo->prepare("INSERT INTO products (nama_product, harga, deskripsi, gambar) VALUES (?, ?, ?, ?)");
    $stmt->execute([$nama_product, $harga, $deskripsi, $namaFileGambar]);

    $productId = $pdo->lastInsertId();

    // Ambil data yang baru dibuat untuk dikembalikan ke response
    $stmtDetail = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmtDetail->execute([$productId]);
    $newProduct = $stmtDetail->fetch();
    $newProduct['gambar'] = getImageUrl($newProduct['gambar']);

    sendResponse(true, 201, "Produk berhasil ditambahkan.", $newProduct);

} catch (Exception $e) {
    sendResponse(false, 500, "Terjadi kesalahan server: " . $e->getMessage(), null);
}