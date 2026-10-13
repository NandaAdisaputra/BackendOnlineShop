<?php
require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendResponse(false, 405, "Method tidak diizinkan", null);
}

// Validasi Token Akses
validateToken($pdo);

$id           = $_POST['id'] ?? '';
$nama_product = $_POST['nama_product'] ?? '';
$harga        = $_POST['harga'] ?? '';
$deskripsi    = $_POST['deskripsi'] ?? '';
$fileGambar   = $_FILES['gambar'] ?? null;

if (empty($id) || empty($nama_product) || empty($harga) || empty($deskripsi)) {
    sendResponse(false, 400, "ID, nama product, harga, dan deskripsi wajib diisi!", null);
}

try {
    // Cek apakah produk ada di database
    $stmtCheck = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmtCheck->execute([$id]);
    $product = $stmtCheck->fetch();

    if (!$product) {
        sendResponse(false, 404, "Produk tidak ditemukan!", null);
    }

    $namaFileGambar = $product['gambar']; // Default pakai gambar lama

    // Jika ada file gambar baru yang di-upload
    if ($fileGambar && $fileGambar['error'] === UPLOAD_ERR_OK) {
        $uploadResult = uploadImage($fileGambar);
        if ($uploadResult === "INVALID_FORMAT") {
            sendResponse(false, 400, "Format gambar tidak valid! Gunakan JPG, JPEG, PNG, atau WEBP.", null);
        }

        if ($uploadResult) {
            // Hapus file gambar lama jika ada
            if (!empty($product['gambar'])) {
                $oldFilePath = __DIR__ . '/../uploads/' . $product['gambar'];
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }
            $namaFileGambar = $uploadResult;
        }
    }

    // Update data di database
    $stmtUpdate = $pdo->prepare("UPDATE products SET nama_product = ?, harga = ?, deskripsi = ?, gambar = ? WHERE id = ?");
    $stmtUpdate->execute([$nama_product, $harga, $deskripsi, $namaFileGambar, $id]);

    // Ambil data terbaru
    $stmtCheck->execute([$id]);
    $updatedProduct = $stmtCheck->fetch();
    $updatedProduct['gambar'] = getImageUrl($updatedProduct['gambar']);

    sendResponse(true, 200, "Produk berhasil diperbarui.", $updatedProduct);

} catch (Exception $e) {
    sendResponse(false, 500, "Terjadi kesalahan server: " . $e->getMessage(), null);
}