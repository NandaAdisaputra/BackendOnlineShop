CREATE DATABASE IF NOT EXISTS db_online_shop;
USE db_online_shop;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    alamat TEXT NOT NULL,
    no_whatsapp VARCHAR(20) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user',
    token VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Seed Admin Default (Password asli: admin123)
-- Admin langsung tersedia di database tanpa perlu melalui proses register
INSERT INTO users (username, email, alamat, no_whatsapp, password, role) 
VALUES ('admin', 'admin@app.com', 'Kantor Pusat Admin', '081234567890', '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', 'admin');

CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_product VARCHAR(255) NOT NULL,
    harga DECIMAL(12,2) NOT NULL,
    deskripsi TEXT NOT NULL,
    gambar VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Contoh data produk sesuai desain UI (Cardinal Sneakers)
INSERT INTO products (nama_product, harga, deskripsi, gambar) 
VALUES (
    'Cardinal Sneakers APria M1329T01A', 
    321500.00, 
    'sepatu sneakers kasual berpotongan low-cut dengan material katun / kanvas berkualitas. Sepatu ini dirancang fleksibel untuk aktivitas harian, menawarkan kenyamanan optimal serta tampilan yang minimalis dan stylish.', 
    'sneakers.jpg'
);
CREATE TABLE IF NOT EXISTS cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);