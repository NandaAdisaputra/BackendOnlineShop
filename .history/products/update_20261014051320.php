<?php
require_once '../config.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method !== 'PUT' && $method !== 'PATCH' && $method !== 'POST') {
    sendResponse(false, 405, "Method tidak diizinkan", null);
}

// Validasi Token Akses
validateToken($pdo);

$id = '';
$nama_product = '';
$harga = '';
$deskripsi = '';
$fileGambar = null;

// Tangani jika request menggunakan PUT atau PATCH dengan form-data
if ($method === 'PUT' || $method === 'PATCH') {
    $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
    
    if (strpos($contentType, 'multipart/form-data') !== false) {
        // Parsing manual multipart/form-data untuk PUT/PATCH di PHP Native
        $raw_data = file_get_contents('php://input');
        $boundary = substr($raw_data, 0, strpos($raw_data, "\r\n"));
        
        if (!empty($boundary)) {
            $parts = array_slice(explode($boundary, $raw_data), 1);
            foreach ($parts as $part) {
                if ($part === "--\r\n" || $part === "--" || empty($part)) continue;
                
                $part = ltrim($part, "\r\n");
                $sections = explode("\r\n\r\n", $part, 2);
                if (count($sections) < 2) continue;
                
                list($raw_headers, $body) = $sections;
                $body = substr($body, 0, strlen($body) - 2); // Hapus \r\n di akhir
                
                $headers = [];
                foreach (explode("\r\n", $raw_headers) as $header_line) {
                    if (strpos($header_line, ': ') !== false) {
                        list($k, $v) = explode(': ', $header_line, 2);
                        $headers[strtolower($k)] = $v;
                    }
                }
                
                if (isset($headers['content-disposition'])) {
                    preg_match('/^(.+); *name="([^"]+)"(; *filename="([^"]+)")?/', $headers['content-disposition'], $matches);
                    $name = $matches[2] ?? '';
                    $filename = $matches[4] ?? null;
                    
                    if ($name === 'gambar' && $filename) {
                        // Simpan file ke temp directory untuk diproses
                        $tmpName = tempnam(sys_get_temp_dir(), 'php_put_');
                        file_put_contents($tmpName, $body);
                        $fileGambar = [
                            'name' => $filename,
                            'tmp_name' => $tmpName,
                            'error' => UPLOAD_ERR_OK,
                            'is_parsed_put' => true
                        ];
                    } else {
                        if ($name === 'id') $id = trim($body);
                        if ($name === 'nama_product') $nama_product = trim($body);
                        if ($name === 'harga') $harga = trim($body);
                        if ($name === 'deskripsi') $deskripsi = trim($body);
                    }
                }
            }
        }
    } else {
        // Untuk x-www-form-urlencoded atau JSON
        parse_str(file_get_contents('php://input'), $input);
        $id = $input['id'] ?? '';
        $nama_product = $input['nama_product'] ?? '';
        $harga = $input['harga'] ?? '';
        $deskripsi = $input['deskripsi'] ?? '';
    }
} else {
    // Jika menggunakan POST standar
    $id = $_POST['id'] ?? '';
    $nama_product = $_POST['nama_product'] ?? '';
    $harga = $_POST['harga'] ?? '';
    $deskripsi = $_POST['deskripsi'] ?? '';
    $fileGambar = $_FILES['gambar'] ?? null;
}

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
        $fileExtension = strtolower(pathinfo($fileGambar['name'], PATHINFO_EXTENSION));
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];

        if (!in_array($fileExtension, $allowedExtensions)) {
            sendResponse(false, 400, "Format gambar tidak valid! Gunakan JPG, JPEG, PNG, atau WEBP.", null);
        }

        $targetDir = __DIR__ . '/../uploads/';
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $newFileName = uniqid('prod_') . '.' . $fileExtension;
        $targetFilePath = $targetDir . $newFileName;

        $saved = false;
        if (isset($fileGambar['is_parsed_put']) && $fileGambar['is_parsed_put']) {
            if (rename($fileGambar['tmp_name'], $targetFilePath) || copy($fileGambar['tmp_name'], $targetFilePath)) {
                $saved = true;
                @unlink($fileGambar['tmp_name']);
            }
        } else {
            if (move_uploaded_file($fileGambar['tmp_name'], $targetFilePath)) {
                $saved = true;
            }
        }

        if ($saved) {
            // Hapus file gambar lama jika ada
            if (!empty($product['gambar'])) {
                $oldFilePath = __DIR__ . '/../uploads/' . $product['gambar'];
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }
            $namaFileGambar = $newFileName;
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