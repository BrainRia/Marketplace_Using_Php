-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 12, 2026 at 01:17 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `swapandsave`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Electronics'),
(2, 'Books'),
(3, 'Furniture'),
(4, 'Transportation'),
(5, 'Accessories');

-- --------------------------------------------------------

--
-- Table structure for table `impact_factors`
--

CREATE TABLE `impact_factors` (
  `category_id` int(11) DEFAULT NULL,
  `co2_per_kg` decimal(6,2) DEFAULT NULL,
  `water_per_kg` decimal(8,2) DEFAULT NULL,
  `waste_per_kg` decimal(6,2) DEFAULT NULL,
  `energy_per_kg` decimal(6,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `impact_factors`
--

INSERT INTO `impact_factors` (`category_id`, `co2_per_kg`, `water_per_kg`, `waste_per_kg`, `energy_per_kg`) VALUES
(1, 20.00, 150.00, 1.20, 8.50),
(2, 2.50, 10.00, 1.00, NULL),
(3, 5.00, 50.00, 1.50, NULL),
(4, 15.00, 80.00, 1.80, NULL),
(5, 3.00, 25.00, 0.80, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `weight_kg` decimal(6,2) NOT NULL,
  `category_id` int(11) NOT NULL,
  `item_condition` varchar(50) NOT NULL,
  `pickup_location` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('available','in_progress','completed') DEFAULT 'available',
  `buyer_id` int(11) DEFAULT NULL,
  `completed_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `user_id`, `title`, `description`, `price`, `weight_kg`, `category_id`, `item_condition`, `pickup_location`, `image`, `created_at`, `status`, `buyer_id`, `completed_at`) VALUES
(1, 1, '11', '1', 1.00, 1.00, 1, 'New', '', NULL, '2026-01-11 22:30:25', 'available', NULL, NULL),
(2, 1, 'Calc', 'good', 10.00, 0.00, 2, 'New', '', 'uploads/1768192315_cover-1024x576.jpg', '2026-01-12 04:31:55', 'available', NULL, NULL),
(3, 1, 'ds', 's', 1.00, 1.00, 1, 'New', 'Limassol', NULL, '2026-01-12 06:52:25', 'available', NULL, NULL),
(4, 1, 'a', 'a1', 1.00, 1.00, 2, 'Like New', 'Limassol', NULL, '2026-01-12 07:51:35', 'available', NULL, NULL),
(5, 1, 'a', 'a', 2.00, 3.00, 2, 'New', 'Limassol', NULL, '2026-01-12 07:54:17', 'in_progress', 6, NULL),
(7, 6, 'book', 'book', 2.00, 2.50, 1, 'Like New', 'home', 'uploads/1768217717_6964dc751cde6.png', '2026-01-12 11:35:17', 'completed', 5, '2026-01-12 13:36:24'),
(8, 6, 'nbo', 'ioid', 2.00, 2.20, 4, 'Like New', 'home', NULL, '2026-01-12 11:53:24', 'completed', 5, '2026-01-12 13:54:00'),
(9, 5, 'bbokw', 'book', 2.50, 2.50, 1, 'New', 'home', NULL, '2026-01-12 11:56:59', 'completed', 6, '2026-01-12 13:57:29');

-- --------------------------------------------------------

--
-- Table structure for table `items_old`
--

CREATE TABLE `items_old` (
  `id` int(11) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `weight_kg` decimal(6,2) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_suspended` tinyint(1) DEFAULT 0,
  `role` enum('user','admin') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password_hash`, `created_at`, `is_suspended`, `role`) VALUES
(1, 'ria', '111@GMAIL.COM', '$2y$10$usBAywjiDxHgrDjSHL7h/uryVhIqXPagRGdssJszJUVe9kHR6sI2W', '2026-01-11 22:05:09', 0, 'user'),
(5, 'katerina', 'katerinadimosthenous3@gmail.com', '$2y$10$y86qI0kD0C2bY.Fh/rmwL.K/WpKmaztTg6.NWnNx28kZM43f6XLHO', '2026-01-12 11:34:31', 0, 'user'),
(6, 'katerina1', 'st025058@stud.frederick.cy', '$2y$10$IV3W4zKRZTG15bidFA1T..hnbVuAKFuPPSvgttF4ZQL4Y0JhOqMuW', '2026-01-12 11:34:45', 0, 'user'),
(7, 'Admin User', 'admin@example.com', '$2y$10$J3V7cHN321hj7a1v942v7.0WAo1OQqkvGWQ.8nwZD3Z4Een61baBO', '2026-01-12 12:07:26', 0, 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `users_old`
--

CREATE TABLE `users_old` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('student','admin') DEFAULT 'student',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `reset_token` varchar(64) DEFAULT NULL,
  `reset_expires` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `impact_factors`
--
ALTER TABLE `impact_factors`
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_items_user` (`user_id`),
  ADD KEY `fk_items_category` (`category_id`),
  ADD KEY `fk_items_buyer` (`buyer_id`);

--
-- Indexes for table `items_old`
--
ALTER TABLE `items_old`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `users_old`
--
ALTER TABLE `users_old`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `items_old`
--
ALTER TABLE `items_old`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users_old`
--
ALTER TABLE `users_old`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `impact_factors`
--
ALTER TABLE `impact_factors`
  ADD CONSTRAINT `impact_factors_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `fk_items_buyer` FOREIGN KEY (`buyer_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_items_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `fk_items_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
