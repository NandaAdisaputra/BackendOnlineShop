CREATE DATABASE IF NOT EXISTS db_online_shop;
USE db_online_shop;

-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 28, 2026 at 04:41 PM
-- Server version: 10.11.19-MariaDB-cll-lve-log
-- PHP Version: 8.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_online_shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `quantity`, `created_at`) VALUES
(1, 4, 2, 2, '2026-10-13 22:32:44');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `nama_product` varchar(255) NOT NULL,
  `harga` decimal(12,2) NOT NULL,
  `deskripsi` text NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `nama_product`, `harga`, `deskripsi`, `gambar`, `created_at`) VALUES
(1, 'Sepatu Salomon', 250000.00, 'Sepatu outdoor dari Salomon yang dirancang untuk memberikan kenyamanan, daya cengkeram, dan kestabilan saat beraktivitas. Cocok digunakan untuk hiking, trekking, dan menjelajahi berbagai medan.', 'sepatu_salomon.jpg', '2026-10-28 09:11:30'),
(2, 'Sepatu Badminton', 450000.00, 'Sepatu khusus olahraga badminton dengan desain sporty, nyaman digunakan, dan mendukung pergerakan lincah di lapangan. Cocok untuk latihan maupun pertandingan badminton.', 'sepatu_badminton.jpg', '2026-10-13 21:55:15'),
(3, 'Sepatu Sepak Bola', 500000.00, 'Sepatu khusus olahraga sepak bola dengan desain sporty dan nyaman digunakan. Dirancang untuk mendukung pergerakan, menjaga kestabilan, serta membantu meningkatkan kontrol saat menggiring dan menendang bola di lapangan.', 'sepatu_bola.jpg', '2026-10-13 22:08:42'),
(4, 'Sepatu Futsal', 300000.00, 'Sepatu khusus olahraga futsal dengan desain sporty dan nyaman digunakan. Dirancang untuk mendukung pergerakan lincah, menjaga kestabilan, serta meningkatkan kontrol bola saat bermain di lapangan futsal.', 'sepatu_futsal.jpg', '2026-10-28 09:09:43'),
(5, 'Sepatu Safety Krisbow', 350000.00, 'Sepatu keselamatan kerja dari Krisbow yang dirancang untuk melindungi kaki saat bekerja. Cocok digunakan di lingkungan industri, bengkel, proyek konstruksi, dan aktivitas kerja lainnya yang membutuhkan perlindungan kaki.', 'sepatu_krisbow.jpg', '2026-10-28 09:10:37'),
(6, 'Sepatu Voli', 320000.00, 'Sepatu khusus olahraga bola voli dengan desain sporty dan nyaman digunakan. Dirancang untuk mendukung lompatan, pergerakan cepat, serta menjaga kestabilan saat melakukan smash, block, dan bertahan di lapangan.', 'sepatu_voli.jpg', '2026-10-28 09:13:07'),
(7, 'Sepatu Pantofel', 335000.00, 'Sepatu formal dengan desain elegan dan profesional yang cocok digunakan untuk acara resmi, bekerja, sekolah, maupun kegiatan perkantoran. Memberikan tampilan rapi dan menunjang penampilan dalam berbagai kesempatan.', 'sepatu_pantofel.jpg', '2026-10-28 09:14:14'),
(8, 'Sepatu Lari', 280000.00, 'Sepatu olahraga yang dirancang untuk memberikan kenyamanan dan mendukung pergerakan saat berlari. Cocok digunakan untuk jogging, latihan kebugaran, dan aktivitas olahraga sehari-hari.', 'sepatu_lari.jpg', '2026-10-28 09:15:13'),
(9, 'Sepatu Basket', 280000.00, 'Sepatu khusus olahraga bola basket dengan desain sporty dan nyaman digunakan. Dirancang untuk mendukung pergerakan cepat, lompatan, serta menjaga kestabilan kaki saat melakukan dribbling, shooting, dan bertahan di lapangan.', 'sepatu_basket.jpg', '2026-10-28 09:16:29'),
(10, 'Sepatu Boots', 200000.00, 'Sepatu boots dengan desain kokoh dan tahan lama yang memberikan perlindungan serta kenyamanan saat digunakan. Cocok untuk aktivitas outdoor, pekerjaan lapangan, perjalanan, dan kegiatan sehari-hari.', 'sepatu_boots.jpg', '2026-10-28 09:17:27'),
(11, 'Sepatu Kuning', 230000.00, 'Sepatu berwarna kuning dengan desain menarik dan sporty yang cocok digunakan untuk aktivitas sehari-hari maupun olahraga. Memberikan tampilan cerah, modern, dan nyaman untuk berbagai kegiatan.', 'sepatu_kuning.jpg', '2026-10-28 09:18:28');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `no_whatsapp` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  `token` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `alamat`, `no_whatsapp`, `password`, `role`, `token`, `created_at`) VALUES
(2, 'admin', 'admin@app.com', 'Kantor Pusat Admin', '081234567890', '$2y$10$Cl4kNNh37TpRYKIdeI4WueSjwXhc7xvh8HurgbmA2AejJMuVQx.OO', 'admin', NULL, '2026-10-13 21:21:27'),
(3, 'johndoe', 'john@mail.com', 'Jl. Contoh No. 123', '081234567890', '$2y$10$ZwuPrcjWbEASojhdQ3JZxuM/HGroNgf/.YavRfRqIFQI.r2WaCriO', 'user', NULL, '2026-10-13 21:31:07'),
(4, 'nanda', 'nandaadisaputra18@gmail.com', 'Kp.Jempono RT 01 RW 01', '082141730797', '$2y$10$WpIoHiXmlIo6iMbh/.erZeaaM8m1WydpSp3Y/h282G40v9SpsKMI6', 'user', 'f595abb35e4dc8c882e27c15a5b219969efd7bfa4cbd573d420e05e5e74659a0', '2026-10-13 21:33:58'),
(5, 'dhimas', 'dhimas@gmail.com', 'Bangetayu Kulon', '082141730797', '$2y$10$5SS4Jen3wSCIR8cOuv0BSe7FnLMWs85gDWRAuIGP6wAz1ePTZmbOa', 'user', '7e9caa3164761a1c2aa82ca740e22eb170f3e09175df3b87cbf03408df177405', '2026-10-17 11:18:58'),
(6, 'adi', 'adi@gmail.com', 'jempono', '082141730797', '$2y$10$st./4KBIwg6QwoPmZ4J5zOW01KbAGnznSLMEljcj/lHzNVQ3tJQMm', 'user', '0699378980a2039252a6b96fece455eab1c9617aa4fdd1056f699e6091e281f3', '2026-10-17 14:48:01'),
(7, 'dhimasangga', 'dhimasangga@gmail.com', 'Bangetayu Kulon', '082141730797', '$2y$10$lh2LDsGdIByZwh4RmNyy7eZvEfGYbTdiB4BVMcd4zgIEl/meUjn/m', 'user', NULL, '2026-10-21 12:44:06'),
(8, 'yuni', 'yuni@gmail.com', 'semarang', '082141730797', '$2y$10$eqaSeu6mIAJiIkS4BsxyDuPVYolTuHMmDbWE5LcFS9TEQrMYIOr.m', 'user', NULL, '2026-10-21 13:42:17'),
(9, 'Nabil Raditya Nagata', 'nagatar76@gmail.com', 'kalikayen ungaran timur', '089668983054', '$2y$10$lJ2c3Mh/WAYB6Jq4YfRwounFBmnT9ZyBZpwIWDx5NBTeNiUbwfxJ.', 'user', '56e495034f3a2e202e57a8d8d7d49a2f61e8afbe8b6eb52a110325429fedd92a', '2026-10-22 17:09:17'),
(10, 'nayla', 'nayla@gmail.com', 'bangetayu', '08762162992', '$2y$10$p2y2ySMoqh4c2JTtqCoJ0eEnao5yRgH8XPhkLlXhW45LvDB/syzdG', 'user', NULL, '2026-10-24 18:37:53'),
(11, 'Ega', 'egaandra70@gmail.cim', 'Jl.Murti lestari raya no 16', '085293030890', '$2y$10$oESBJKHURRxcF5bNsLbZyeL4zFs6vzbQlFsOQREpoXDdzjSJyCJAK', 'user', '759b566aeced6aedc3d8cd584eb9c7fc6f1ea06926a4aa32ed1a1ef34dcd1516', '2026-10-28 03:24:34');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
