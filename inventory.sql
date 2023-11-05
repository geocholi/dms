-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 05, 2023 at 02:35 PM
-- Server version: 8.0.31
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventory`
--

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `description` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `img` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `stock` int NOT NULL,
  `created_by` int NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_users_products` (`created_by`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_name`, `description`, `img`, `stock`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Ultra Cement', 'This is product 1						 				', 'product-1698438240.jpg', 15, 1, '2023-10-27 19:24:00', '2023-10-27 19:24:00'),
(2, 'Portland Cement', 'This is product 2						 				', 'product-1698438291.jpeg', 0, 1, '2023-10-27 19:24:51', '2023-10-27 19:24:51'),
(3, 'Ashaka Cement', 'This is product 3						 				', 'product-1698438337.jpg', 0, 1, '2023-10-27 19:25:37', '2023-10-27 19:25:37'),
(4, 'Dangote Cement', 'This is product 4						 				', 'product-1698438400.jpg', 70, 1, '2023-10-27 19:26:40', '2023-10-27 19:26:40'),
(5, 'Lafarge Cement', 'This is product 5						 				', 'product-1698438450.jpg', 0, 1, '2023-10-27 19:27:30', '2023-10-27 19:27:30'),
(6, 'Elephant Cement', 'This is product 6						 				', 'product-1698438552.jpg', 10, 1, '2023-10-27 19:29:12', '2023-10-27 19:29:12'),
(7, 'Bua Cement', 'This is product 7						 				', 'product-1698447851.jpg', 50, 2, '2023-10-27 22:04:11', '2023-10-27 22:04:11');

-- --------------------------------------------------------

--
-- Table structure for table `productsuppliers`
--

DROP TABLE IF EXISTS `productsuppliers`;
CREATE TABLE IF NOT EXISTS `productsuppliers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `supplier` int NOT NULL,
  `product` int NOT NULL,
  `updated_at` timestamp NOT NULL,
  `created_at` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_products_productsuppliers` (`product`),
  KEY `fk_suppliers_productsuppliers` (`supplier`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `productsuppliers`
--

INSERT INTO `productsuppliers` (`id`, `supplier`, `product`, `updated_at`, `created_at`) VALUES
(1, 1, 1, '2023-10-27 19:24:00', '2023-10-27 19:24:00'),
(2, 2, 2, '2023-10-27 19:24:51', '2023-10-27 19:24:51'),
(3, 3, 3, '2023-10-27 19:25:37', '2023-10-27 19:25:37'),
(4, 6, 4, '2023-10-27 19:26:40', '2023-10-27 19:26:40'),
(5, 4, 4, '2023-10-27 19:26:41', '2023-10-27 19:26:41'),
(6, 3, 4, '2023-10-27 19:26:41', '2023-10-27 19:26:41'),
(7, 2, 4, '2023-10-27 19:26:41', '2023-10-27 19:26:41'),
(8, 1, 4, '2023-10-27 19:26:41', '2023-10-27 19:26:41'),
(9, 5, 5, '2023-10-27 19:27:30', '2023-10-27 19:27:30'),
(10, 6, 6, '2023-10-27 19:29:12', '2023-10-27 19:29:12'),
(11, 7, 7, '2023-10-27 22:04:11', '2023-10-27 22:04:11');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

DROP TABLE IF EXISTS `suppliers`;
CREATE TABLE IF NOT EXISTS `suppliers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `supplier_name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `supplier_location` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_by` int NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_users_suppliers` (`created_by`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `supplier_name`, `supplier_location`, `email`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Ultra', 'Cotonou', 'ultracement@gmail.com', 1, '2023-10-27 19:19:01', '2023-10-27 19:19:01'),
(2, 'Portland', 'Makurdi', 'portlandcement@gmail.com', 1, '2023-10-27 19:19:28', '2023-10-27 19:19:28'),
(3, 'Ashaka', 'Sokoto', 'ashakacement@yahoo.com', 1, '2023-10-27 19:19:44', '2023-10-27 19:19:44'),
(4, 'Dangote', 'Lokoja', 'dangotecement@gmail.com', 1, '2023-10-27 19:20:16', '2023-10-27 19:20:16'),
(5, 'Lafarge', 'Abuja', 'lafargecement@yahoo.com', 1, '2023-10-27 19:20:41', '2023-10-27 19:20:41'),
(6, 'Elephant', 'Aba', 'elephantcement@gmail.com', 1, '2023-10-27 19:21:39', '2023-10-27 19:21:39'),
(7, 'Bua', 'Kaduna', 'buacement@gmail.com', 2, '2023-10-27 22:02:48', '2023-10-27 22:02:48');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `first_name` char(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `last_name` char(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 'John', 'Doe', 'johndoe@dmi.com', 'johndoe', '2023-10-16 07:12:14', '2023-10-24 08:32:31'),
(2, 'Glory', 'Days', 'glorydays@dmi.com', 'glorydays', '2023-10-16 06:14:29', '2023-10-16 06:14:29'),
(5, 'Angel', 'Gabriel', 'angelgabriel@dmi.com', 'angelgabriel', '2023-11-05 11:05:47', '2023-11-05 11:05:47');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_users_products` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `productsuppliers`
--
ALTER TABLE `productsuppliers`
  ADD CONSTRAINT `fk_products_productsuppliers` FOREIGN KEY (`product`) REFERENCES `products` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_suppliers_productsuppliers` FOREIGN KEY (`supplier`) REFERENCES `suppliers` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD CONSTRAINT `fk_users_supplier` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
