-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 26, 2025 at 09:33 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `MKTime`
--
CREATE DATABASE IF NOT EXISTS `MKTime` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `MKTime`;

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE IF NOT EXISTS `cart` (
  `cart_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(10) UNSIGNED NOT NULL,
  `item_id` int(10) UNSIGNED NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `added_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`cart_id`),
  UNIQUE KEY `unique_cart_item` (`user_id`,`item_id`),
  KEY `fk_cart_item` (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(10) UNSIGNED NOT NULL,
  `total` decimal(8,2) NOT NULL,
  `order_date` datetime NOT NULL,
  PRIMARY KEY (`order_id`),
  KEY `fk_orders_user` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `total`, `order_date`) VALUES
(1, 2, 1125.50, '2025-10-24 16:48:43'),
(2, 2, 179.00, '2025-10-24 16:49:39'),
(3, 2, 279.98, '2025-10-24 16:53:41'),
(4, 2, 149.50, '2025-10-24 16:55:55'),
(5, 2, 598.00, '2025-10-24 16:56:49'),
(6, 2, 847.50, '2025-10-24 17:05:11'),
(7, 2, 751.75, '2025-10-24 17:08:08'),
(8, 2, 229.00, '2025-10-24 17:13:01'),
(9, 5, 880.75, '2025-10-24 17:14:17');

-- --------------------------------------------------------

--
-- Table structure for table `order_contents`
--

CREATE TABLE IF NOT EXISTS `order_contents` (
  `content_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id` int(10) UNSIGNED NOT NULL,
  `item_id` int(10) UNSIGNED NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `price` decimal(8,2) NOT NULL,
  PRIMARY KEY (`content_id`),
  KEY `fk_ordercontents_order` (`order_id`),
  KEY `fk_ordercontents_item` (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_contents`
--

INSERT INTO `order_contents` (`content_id`, `order_id`, `item_id`, `quantity`, `price`) VALUES
(1, 1, 3, 2, 179.00),
(2, 1, 2, 4, 149.50),
(3, 1, 8, 1, 169.50),
(4, 2, 3, 1, 179.00),
(5, 3, 7, 2, 139.99),
(6, 4, 2, 1, 149.50),
(7, 5, 2, 4, 149.50),
(8, 6, 8, 5, 169.50),
(9, 7, 6, 1, 229.00),
(10, 7, 10, 3, 174.25),
(11, 8, 6, 1, 229.00),
(12, 9, 10, 3, 174.25),
(13, 9, 3, 2, 179.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `item_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `item_name` varchar(20) NOT NULL,
  `item_desc` varchar(200) NOT NULL,
  `item_img` varchar(20) NOT NULL,
  `item_price` decimal(6,2) DEFAULT NULL,
  PRIMARY KEY (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`item_id`, `item_name`, `item_desc`, `item_img`, `item_price`) VALUES
(1, 'Classic Timepiece', 'Elegant and timeless design suitable for any occasion.', 'img/men1.jpg', 129.99),
(2, 'Urban Explorer', 'Durable watch built for everyday adventures.', 'img/men2.jpg', 149.50),
(3, 'Silver Horizon', 'Sleek silver finish with a minimalist dial.', 'img/men3.jpg', 179.00),
(4, 'Midnight Tracker', 'Black dial with luminous hands for night visibility.', 'img/men4.jpg', 199.99),
(5, 'Ocean Breeze', 'Water-resistant watch perfect for casual wear.', 'img/men5.jpg', 159.75),
(6, 'Golden Aura', 'Luxury golden finish with subtle detailing.', 'img/men6.jpg', 229.00),
(7, 'City Runner', 'Lightweight design for active lifestyles.', 'img/men7.jpg', 139.99),
(8, 'Vintage Charm', 'Retro-inspired watch with leather strap.', 'img/men8.jpg', 169.50),
(9, 'Stellar Orbit', 'Modern design with stainless steel case.', 'img/w1.jpg', 189.99),
(10, 'Aurora Light', 'Colorful dial inspired by northern lights.', 'img/w2.jpg', 174.25),
(11, 'Titanium Edge', 'Strong and stylish titanium case for daily use.', 'img/w3.jpg', 249.99),
(12, 'Harmony Classic', 'Balanced design combining elegance and functionality.', 'img/w4.jpg', 199.50);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(40) NOT NULL,
  `email` varchar(60) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `reg_date` datetime NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `email`, `pass`, `reg_date`) VALUES
(2, 'Karina', 'Kutuzova', 'ec2321253@edinburghcollege.ac.uk', '$2y$10$eu2g/kZbv/37rKgCYwffn.kmfy0Irsiy45ZpxoYCxEvNyTffR7PDy', '2025-10-22 15:37:31'),
(4, 'Viktor', 'Kutuzova', 'viktor.plotnikov@allpass.ai', '$2y$10$ohAT0Hxcb1HZV/you0W1tewGFz9ZRYslTz1KC/vYqtv.YiNobFkfi', '2025-10-22 17:39:57'),
(5, 'Karina', 'Kutu', 'karina.artist.edi@gmail.com', '$2y$10$8FNxVfy9wuBKjuxKugPqOOPQ1TakGsjw2Z55k/9V3gp8VmagJusc6', '2025-10-24 17:13:51');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `fk_cart_item` FOREIGN KEY (`item_id`) REFERENCES `products` (`item_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_cart_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_orders_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `order_contents`
--
ALTER TABLE `order_contents`
  ADD CONSTRAINT `fk_ordercontents_item` FOREIGN KEY (`item_id`) REFERENCES `products` (`item_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_ordercontents_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
