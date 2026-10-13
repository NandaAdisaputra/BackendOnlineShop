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