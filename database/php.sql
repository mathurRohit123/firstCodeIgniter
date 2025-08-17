-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 17, 2025 at 04:43 PM
-- Server version: 8.0.39
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `php`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `a_id` int NOT NULL,
  `user_id` int NOT NULL,
  `action_type` varchar(50) NOT NULL,
  `target_table` varchar(50) NOT NULL,
  `target_id` int NOT NULL,
  `description` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`a_id`, `user_id`, `action_type`, `target_table`, `target_id`, `description`, `created_at`) VALUES
(1, 7, 'LOGIN', 'null', 0, 'Admin One with ID 7 logged in', '2025-08-17 08:28:54'),
(2, 7, 'create', 'users, shops', 39, 'Admin created a new shopkeeper record at ID 39', '2025-08-17 08:33:26'),
(3, 7, 'edited a shopkeeper with ID 39', 'users, shops', 39, 'Admin with user_id edited a shopkeeper at target_id', '2025-08-17 08:36:23'),
(4, 7, 'deleted shopkeeper with ID 39', 'users, shops', 39, 'deleted the record from all tables', '2025-08-17 08:36:32'),
(5, 7, 'deleted shopkeeper with ID 39', 'users, shops', 39, 'deleted the record from all tables', '2025-08-17 08:36:53'),
(6, 7, 'deleted shopkeeper with ID 39', 'users, shops', 39, 'deleted the record from all tables', '2025-08-17 08:39:35'),
(7, 35, 'LOGIN', 'null', 0, 'shopkeeper9 with ID 35 logged in', '2025-08-17 09:11:36'),
(11, 35, 'LOGOUT', 'null', 35, 'shopkeeper9 logged out', '2025-08-17 09:18:19'),
(12, 35, 'LOGIN', 'null', 0, 'shopkeeper9 with ID 35 logged in', '2025-08-17 09:20:08'),
(13, 35, 'create', 'users, workers', 42, 'shopkeeper added a new worker at target_id and at 24', '2025-08-17 09:24:24'),
(14, 35, 'delete', 'users, workers', 42, 'shopkeeper with user_id deleted the records of a worker with target_id', '2025-08-17 09:24:31'),
(15, 35, 'update', 'users, workers', 40, 'shopkeeper with user_id updated the worker with target_id', '2025-08-17 09:24:58'),
(16, 35, 'LOGOUT', 'null', 35, 'shopkeeper9 logged out successfully', '2025-08-17 09:25:04'),
(17, 18, 'LOGIN', 'null', 0, 'worker 7 with ID 18 logged in', '2025-08-17 10:27:29'),
(18, 18, 'LOGIN', 'null', 0, 'worker 7 with ID 18 logged in', '2025-08-17 10:28:04'),
(19, 18, 'added product', 'products', 25, 'worker with user_id added a product with target_id', '2025-08-17 10:28:44'),
(20, 18, 'LOGOUT', 'null', 18, 'worker 7 logged out successfully', '2025-08-17 10:28:48');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `c_id` int NOT NULL,
  `shop_id` int NOT NULL,
  `category_name` varchar(100) DEFAULT NULL,
  `added_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`c_id`, `shop_id`, `category_name`, `added_at`, `created_by`) VALUES
(17, 10, 'Fairness Creams', '2025-07-29 06:27:14', 13),
(18, 10, 'Hair Oil', '2025-08-12 05:30:31', 10),
(20, 12, 'Wheat flour', '2025-08-12 05:36:40', 23),
(21, 12, 'Tea', '2025-08-12 05:36:40', 23),
(22, 12, 'biscuit', '2025-08-12 05:36:40', 23),
(23, 13, 'chocolates', '2025-08-12 05:36:40', 27),
(24, 13, 'sweets', '2025-08-12 05:36:40', 27),
(25, 10, 'Perfumes', '2025-08-14 01:40:03', 13),
(26, 15, 'aanar', '2025-08-14 08:16:05', 35),
(27, 15, 'chakri', '2025-08-14 08:16:13', 35),
(28, 15, 'rockets', '2025-08-14 08:16:24', 35),
(29, 15, 'shots', '2025-08-14 08:16:37', 35);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `p_id` int NOT NULL,
  `category_id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int DEFAULT '0',
  `created_by` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`p_id`, `category_id`, `name`, `price`, `quantity`, `created_by`, `created_at`) VALUES
(1, 17, 'Garnier MEN', '80.00', 52, 13, '2025-08-12 06:04:09'),
(2, 17, 'NIVEA MEN', '25.00', 25, 13, '2025-08-12 06:04:09'),
(3, 18, 'Alma Hair Oil', '40.00', 60, 13, '2025-08-12 06:04:09'),
(4, 18, 'Kesh Kanti almond hair oil', '100.00', 25, 13, '2025-08-12 06:04:09'),
(5, 20, 'AAshirvaad aata', '550.00', 50, 23, '2025-08-12 06:04:09'),
(6, 20, 'Patanjali multigrain aata', '1200.00', 15, 23, '2025-08-12 06:04:09'),
(7, 21, 'Tata tea agni', '250.00', 50, 23, '2025-08-12 06:04:09'),
(8, 21, 'Taj', '550.00', 5, 23, '2025-08-12 06:04:09'),
(9, 22, 'Parle G', '80.00', 50, 23, '2025-08-12 06:04:09'),
(10, 22, 'Tiger', '50.00', 50, 23, '2025-08-12 06:04:09'),
(11, 23, 'Dairy Milk Silk', '100.00', 500, 27, '2025-08-12 06:04:09'),
(12, 23, 'Melody', '1.00', 1000, 27, '2025-08-12 06:04:09'),
(13, 24, 'Mootichur ladoo', '360.00', 25, 27, '2025-08-12 06:04:09'),
(14, 24, 'Soan papdi', '200.00', 75, 27, '2025-08-12 06:04:09'),
(17, 26, 'small aanar', '200.00', 20, 35, '2025-08-14 08:18:37'),
(19, 29, '12 shots', '250.00', 10, 35, '2025-08-14 08:19:21'),
(20, 28, 'pocket rockets', '100.00', 12, 35, '2025-08-14 08:19:44'),
(21, 26, 'big aanar', '350.00', 10, 37, '2025-08-14 08:24:15'),
(22, 27, 'large chakri', '250.00', 13, 37, '2025-08-14 08:24:40'),
(23, 28, 'sultan rocket', '280.00', 5, 37, '2025-08-14 08:25:08'),
(24, 29, '20 shots', '500.00', 15, 37, '2025-08-14 08:25:35'),
(25, 25, 'Layer Shot', '250.00', 20, 18, '2025-08-17 10:28:44');

-- --------------------------------------------------------

--
-- Table structure for table `shops`
--

CREATE TABLE `shops` (
  `s_id` int NOT NULL,
  `shopkeeper_id` int NOT NULL,
  `reg_id` varchar(5) NOT NULL,
  `shop_name` varchar(100) NOT NULL,
  `location` varchar(150) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `shops`
--

INSERT INTO `shops` (`s_id`, `shopkeeper_id`, `reg_id`, `shop_name`, `location`, `created_at`, `updated_at`) VALUES
(10, 13, 'GB456', 'Shringar beauty products', 'BHOPAL', '2025-07-28 06:41:06', '2025-08-14 06:21:56'),
(12, 23, 'BLK91', 'Grocery Hub', 'Indore', '2025-08-10 12:40:48', '2025-08-14 06:22:21'),
(13, 27, 'SWT78', 'Sweet Tooth', 'Bhind', '2025-08-10 15:07:22', '2025-08-14 06:23:46'),
(15, 35, 'FRK20', 'Sparkling Fireworks', 'Chennai', '2025-08-14 06:26:24', '2025-08-14 06:28:39');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `u_id` int NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `gender` enum('Male','Female','Others') DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `role` enum('Admin','Shopkeeper','Worker') DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `last_login` datetime DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`u_id`, `name`, `email`, `mobile`, `gender`, `dob`, `role`, `password`, `created_at`, `last_login`, `is_active`, `updated_at`) VALUES
(7, 'Admin One', 'admin@shop.com', '9000000000', 'Male', '1985-01-01', 'Admin', '$2y$10$/5EXDzaeblStpM7.VH06Vu7tu9Cng6JTMZA7ySVXimj6SW0/i0dli', '2025-07-23 06:53:59', NULL, 1, '2025-08-10 09:31:19'),
(10, 'Worker A', 'workera@store.com', '9333333333', 'Male', '2000-02-20', 'Worker', '$2y$10$DDOLRCb43Q8NXPi3emX0reTslOG6gXeZMVVMkZfp9iBNORnl0JXye', '2025-07-23 06:55:33', NULL, 1, '2025-08-10 09:31:19'),
(11, 'Worker B', 'workerb@store.com', '9444444444', 'Female', '2001-07-15', 'Worker', '$2y$10$xi/E2ZETTIFdygOM3E.i0.DGK6NIildUj1cJtx20ELkMxlxOHGJ7m', '2025-07-23 06:55:33', NULL, 1, '2025-08-10 09:31:19'),
(12, 'Worker C', 'workerc@store.com', '9555555555', 'Male', '2002-06-10', 'Worker', '$2y$10$U/KMPE1VNfDl2FCjcpCiEeDJTFqogc6IOZRXAxUBbIt/5myZz0cxO', '2025-07-23 06:55:33', NULL, 1, '2025-08-10 09:31:19'),
(13, 'shopkeeper3', 'shopkeeper3@store.com', '1000560000', 'Female', '1999-06-08', 'Shopkeeper', '$2y$10$.UWtveby8zlCmvwm2l7JVuYNFvcxN9Cv7Xbc/rv3S9hZhaE51A6qu', '2025-07-28 06:41:06', NULL, 1, '2025-08-14 06:21:56'),
(14, 'Worker D', 'workerd@store.com', '7458963201', 'Male', '2006-09-11', 'Worker', '$2y$10$omdWi/C/RQGh4s88jPoTOuwrZUFYMFarGykTD2gPU99sWIkYsy5tW', '2025-07-28 06:48:20', NULL, 1, '2025-08-10 09:31:19'),
(16, 'worker E', 'workere@store.com', '9926845310', 'Male', '2003-11-26', 'Worker', '$2y$10$loSm4.ONxi5GFnAz72ogZ.98YwdFYYR0gXfDQgk/bZ6.yw8/s4eLa', '2025-07-28 07:53:36', NULL, 1, '2025-08-10 09:31:19'),
(17, 'Worker F', 'workerf@store.com', '7896541203', 'Male', '2025-07-04', 'Worker', '$2y$10$/kWC6ncOaBQsZzolircJgOoyYEknVFgkMBUQY/tX5z59/a7/68CpW', '2025-07-29 05:29:50', NULL, 1, '2025-08-10 09:31:19'),
(18, 'worker 7', 'worker7@store.com', '5623985623', 'Female', '1977-06-18', 'Worker', '$2y$10$NM26s6vVWr8JrzPfMIoEruuwtgYS.157GroepkqUnfQwUOg48FttG', '2025-07-29 06:40:01', NULL, 1, '2025-08-10 09:31:19'),
(19, 'Worker 8', 'worker8@store.com', '8529634100', 'Female', '2025-07-02', 'Worker', '$2y$10$X1WGNhOTZbXbpUBbWp5Q4uQX7mwQci//kIXtMceDL3gfdfNMZoOXy', '2025-07-29 07:03:09', NULL, 1, '2025-08-10 09:31:20'),
(22, 'Worker', 'worker@example.com', '2000300056', 'Female', '1959-10-08', 'Worker', '$2y$10$CyvN9xRh7LSPb6WrO2ly4O5O8KiMEI0A5exNjkCSIPx59tWdhnMxi', '2025-08-08 03:23:50', NULL, 1, '2025-08-12 10:43:02'),
(23, 'shopkeeper5', 'shopkeeper5@store.com', '50000900000', 'Male', '1950-06-07', 'Shopkeeper', '$2y$10$8.U52STnhMCmTppPwT9OB.veE1JbEhf1PWPswfb/1WZgCbpbG3NzG', '2025-08-10 12:40:48', NULL, 1, '2025-08-14 06:22:21'),
(27, 'shopkeeper7', 'shopkeeper7@store.com', '8000090000', 'Male', '2003-01-01', 'Shopkeeper', '$2y$10$ktKLtG2qTyixPhcOTRu.JejqeF/w2owXlma45r8T6aYc.NBTCk3Se', '2025-08-10 15:07:22', NULL, 1, '2025-08-14 06:23:46'),
(32, 'newWorker', 'naya6@store.com', '5000600023', 'Male', '2025-08-01', 'Worker', '$2y$10$Qh55baWS.PBUgh33cq3UVO5BBtbgvhL7oEHgJRa1ZZ5Yq7DC8q9oG', '2025-08-13 05:38:59', NULL, 1, '2025-08-13 09:08:59'),
(35, 'shopkeeper9', 'shopkeeper9@store.com', '1239546870', 'Male', '1985-11-30', 'Shopkeeper', '$2y$10$QAA2du6ubj.PTR0tFB0tLeMz7LuckkmhVxR89qrVo8PGMUJydiJgy', '2025-08-14 06:26:24', NULL, 1, '2025-08-14 06:28:39'),
(36, 'worker10', 'worker10@store.com', '8956231046', 'Male', '2000-08-08', 'Worker', '$2y$10$yXxdtoCNHLNQF/tGeWiBXeKvGBvttm/HG/amo2GmNmU/csIinT.PW', '2025-08-14 06:31:08', NULL, 1, '2025-08-14 08:14:24'),
(37, 'worker11', 'worker11@store.com', '1111122222', 'Male', '2005-09-30', 'Worker', '$2y$10$9OoqgXwsA9AaAeg2tOrZ/.pLJZfwuPvkYBHSXoUcLfiG4jOzEw0jS', '2025-08-14 06:33:16', NULL, 1, '2025-08-14 08:23:12'),
(40, 'new worker', 'newworker11@store.com', '7412580963', 'Male', '1999-12-18', 'Worker', '$2y$10$nWptZ36WQYD2lc3QDbeytu6AXnNM8piSOw0jmXR4muIy1FGpqw4XG', '2025-08-17 09:21:30', NULL, 1, '2025-08-17 09:24:58');

-- --------------------------------------------------------

--
-- Table structure for table `workers`
--

CREATE TABLE `workers` (
  `w_id` int NOT NULL,
  `shop_id` int NOT NULL,
  `worker_id` int NOT NULL,
  `role` enum('Helper','SalesMan') DEFAULT NULL,
  `joined_on` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `workers`
--

INSERT INTO `workers` (`w_id`, `shop_id`, `worker_id`, `role`, `joined_on`, `created_at`) VALUES
(4, 10, 14, 'Helper', '2025-07-28', '2025-07-28 06:48:20'),
(5, 10, 16, 'SalesMan', '2025-07-28', '2025-07-28 07:53:36'),
(7, 10, 18, 'Helper', '2025-07-29', '2025-07-29 06:40:01'),
(8, 10, 19, 'SalesMan', '2025-07-29', '2025-07-29 07:03:09'),
(9, 13, 10, 'Helper', '2021-12-12', '2025-08-12 05:08:19'),
(12, 12, 11, 'SalesMan', '2020-08-09', '2025-08-12 05:08:43'),
(15, 12, 12, 'Helper', '2023-07-07', '2025-08-12 05:11:16'),
(16, 13, 17, 'Helper', '2021-07-25', '2025-08-12 05:11:16'),
(17, 12, 22, 'SalesMan', '2023-07-07', '2025-08-12 05:12:24'),
(21, 15, 36, 'Helper', '2025-08-14', '2025-08-14 06:31:08'),
(22, 15, 37, 'SalesMan', '2025-08-08', '2025-08-14 06:33:16'),
(23, 15, 40, 'SalesMan', '2024-01-31', '2025-08-17 09:21:30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`a_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`c_id`),
  ADD KEY `fk_categories_created_by` (`created_by`),
  ADD KEY `fk_categories_shop` (`shop_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`p_id`),
  ADD KEY `idx_category_id` (`category_id`),
  ADD KEY `idx_shop_id` (`created_by`);

--
-- Indexes for table `shops`
--
ALTER TABLE `shops`
  ADD PRIMARY KEY (`s_id`),
  ADD UNIQUE KEY `reg_id` (`reg_id`),
  ADD KEY `fk_shopkeeper` (`shopkeeper_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`u_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `mobile` (`mobile`),
  ADD UNIQUE KEY `unique_email` (`email`);

--
-- Indexes for table `workers`
--
ALTER TABLE `workers`
  ADD PRIMARY KEY (`w_id`),
  ADD UNIQUE KEY `worker_id` (`worker_id`),
  ADD KEY `fk_workers_shop` (`shop_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `a_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `c_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `p_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `shops`
--
ALTER TABLE `shops`
  MODIFY `s_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `u_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `workers`
--
ALTER TABLE `workers`
  MODIFY `w_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`u_id`) ON DELETE CASCADE;

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `users` (`u_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_categories_created_by` FOREIGN KEY (`created_by`) REFERENCES `users` (`u_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_categories_shop` FOREIGN KEY (`shop_id`) REFERENCES `shops` (`s_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_products_created_by` FOREIGN KEY (`created_by`) REFERENCES `users` (`u_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`c_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `users` (`u_id`) ON DELETE SET NULL;

--
-- Constraints for table `shops`
--
ALTER TABLE `shops`
  ADD CONSTRAINT `fk_shopkeeper` FOREIGN KEY (`shopkeeper_id`) REFERENCES `users` (`u_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `shops_ibfk_2` FOREIGN KEY (`shopkeeper_id`) REFERENCES `users` (`u_id`) ON DELETE CASCADE;

--
-- Constraints for table `workers`
--
ALTER TABLE `workers`
  ADD CONSTRAINT `fk_worker_user` FOREIGN KEY (`worker_id`) REFERENCES `users` (`u_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_workers_shop` FOREIGN KEY (`shop_id`) REFERENCES `shops` (`s_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_workers_user` FOREIGN KEY (`worker_id`) REFERENCES `users` (`u_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `workers_ibfk_3` FOREIGN KEY (`shop_id`) REFERENCES `shops` (`s_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
