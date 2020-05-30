-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 03, 2020 at 05:45 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `e_commerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `order_queues`
--

CREATE TABLE `order_queues` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double(8,2) NOT NULL,
  `quantity` int(11) DEFAULT 1,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_queues`
--

INSERT INTO `order_queues` (`id`, `name`, `price`, `quantity`, `image`, `user_id`, `product_id`, `created_at`, `updated_at`) VALUES
(1, 'LCD TV 32-inched', 450.99, 1, 'storage/products/BjxZoS-B4Xs.jpg', 1, 1, '2020-03-31 14:56:52', '2020-03-31 14:56:52'),
(2, 'PS4', 120.99, 1, 'storage/products/BjxZoS-B4Xs.jpg', 1, 2, '2020-03-31 14:57:04', '2020-03-31 14:57:04'),
(3, 'Nitendo Gameboy', 40.56, 1, 'storage/products/BjxZoS-B4Xs.jpg', 1, 3, '2020-03-31 20:49:07', '2020-03-31 20:49:07'),
(4, 'PS4', 120.99, 1, 'storage/products/BjxZoS-B4Xs.jpg', 14, 2, '2020-03-31 21:22:15', '2020-03-31 21:22:15'),
(5, 'Nitendo Gameboy', 40.56, 1, 'storage/products/BjxZoS-B4Xs.jpg', 14, 3, '2020-03-31 21:23:03', '2020-03-31 21:23:03'),
(6, 'LCD TV 32-inched', 450.99, 1, 'storage/products/BjxZoS-B4Xs.jpg', 14, 1, '2020-03-31 21:24:16', '2020-03-31 21:24:16');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subcategory` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double(8,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `category`, `subcategory`, `price`, `quantity`, `image`, `created_at`, `updated_at`) VALUES
(1, 'LCD TV 32-inched', 'Electronic', 'television', 450.99, 12, 'storage/products/BjxZoS-B4Xs.jpg', '2020-03-28 06:36:51', '2020-03-28 06:36:51'),
(2, 'PS4', 'Games', 'Play Station', 120.99, 12, 'storage/products/BjxZoS-B4Xs.jpg', '2020-03-28 06:42:11', '2020-03-28 06:42:11'),
(3, 'Nitendo Gameboy', 'Games', 'Nitendo', 40.56, 1, 'storage/products/BjxZoS-B4Xs.jpg', '2020-03-28 14:32:25', '2020-03-28 14:32:25');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `image`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Casandra Chloe', 'CasandraChloe@test.com', NULL, NULL, '$2y$10$M8SPSieCf6WQyDFG8Q/MT.X/qVxxpDa3OgMXtUl7ELbh7C9M.80ui', 'dBwHOH36jbSHqc0ZHVPBevvK1chTMZvGeWtc66Sma3amTPd48RyJE0rT7obY', '2020-03-28 06:11:56', '2020-03-31 19:33:55'),
(14, 'Eze Goodnes', 'EzekGoodness@test.com', NULL, NULL, '$2y$10$CsEHdSVIGix.mdllKR.p4uk/coR3P3NG52w.BVWDTBjs3yEkaXvk2', NULL, '2020-03-29 15:02:10', '2020-03-29 15:02:10'),
(40, 'Chloe Santa', 'okoyep98@gmail.com', NULL, NULL, '$2y$10$OWuDcZ6FLeVLnoX8kf86vu48X8SjuwbPB8vWUdEYT.cKxFGWmmWYi', 'cGMNk9tDIIFlfogLlS5TUn7CYFh5wY4BCmSSnBxAiX3lU1Bq8E35kG1M3biz', '2020-03-30 17:30:56', '2020-03-31 19:11:30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `order_queues`
--
ALTER TABLE `order_queues`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_queues_user_id_foreign` (`user_id`),
  ADD KEY `order_queues_product_id_foreign` (`product_id`);

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
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `order_queues`
--
ALTER TABLE `order_queues`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_queues`
--
ALTER TABLE `order_queues`
  ADD CONSTRAINT `order_queues_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_queues_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
