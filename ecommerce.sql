-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 03, 2025 at 05:17 AM
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
-- Database: `ecommerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT 1,
  `selected_options` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customizable_options`
--

CREATE TABLE `customizable_options` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `option_name` varchar(255) DEFAULT NULL,
  `option_value` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customizable_options`
--

INSERT INTO `customizable_options` (`id`, `product_id`, `option_name`, `option_value`, `price`) VALUES
(5, 11, 'Size', 'Medium', 0.00),
(6, 11, 'Size', 'Large', 20.00),
(7, 11, 'Size', 'Overload', 45.00),
(8, 11, 'Flavor', 'Classic', 0.00),
(9, 11, 'Add-on', 'Marshmallow', 15.00),
(10, 11, 'Add-on', 'Sprinkles', 15.00),
(11, 11, 'Add-on', 'Crushed Oreo', 15.00),
(12, 11, 'Add-on', 'Syrup', 15.00),
(13, 11, 'Add-on', 'Milk Powder ', 15.00),
(14, 11, 'Add-on', 'Chocolate Chips', 15.00),
(15, 11, 'Add-on', 'Rice Crispies', 15.00),
(16, 11, 'Add-on', 'Mini Nips', 15.00),
(32, 19, 'Size', 'Small', 0.00),
(33, 19, 'Size', 'Medium', 20.00),
(34, 19, 'Size', 'Large', 35.00),
(35, 19, 'Flavor', 'Vanilla', 0.00),
(36, 19, 'Add-on', 'N/A', 0.00),
(37, 20, 'Size', 'Small', 0.00),
(38, 20, 'Size', 'Medium', 10.00),
(39, 20, 'Size', 'Large', 20.00),
(40, 20, 'Flavor', 'Chocolate', 10.00),
(41, 20, 'Flavor', 'Vanilla', 20.00),
(42, 20, 'Add-on', 'Nata', 15.00),
(43, 20, 'Add-on', 'Syrup', 15.00);

-- --------------------------------------------------------

--
-- Table structure for table `ingredients`
--

CREATE TABLE `ingredients` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `stock` decimal(10,2) NOT NULL,
  `unit` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ingredients`
--

INSERT INTO `ingredients` (`id`, `name`, `stock`, `unit`) VALUES
(1, 'Cup', 5.00, 'cups'),
(2, 'Frozen Corn Dog', 0.00, 'pcs'),
(3, 'Noodles', 10.00, 'pcs'),
(4, 'Sauce', 10.00, 'pcs');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `status` enum('pending','approved','preparing','out_for_delivery','delivered','rejected','canceled') NOT NULL DEFAULT 'pending',
  `payment_method` enum('gcash','cod') DEFAULT NULL,
  `receipt_image` varchar(255) DEFAULT NULL,
  `transaction_id` varchar(100) DEFAULT NULL,
  `area` varchar(100) DEFAULT NULL,
  `landmark` text DEFAULT NULL,
  `delivery_fee` decimal(10,2) DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `total_amount` decimal(10,2) NOT NULL,
  `mode_of_payment` varchar(50) NOT NULL,
  `place` varchar(255) NOT NULL,
  `receipt` varchar(255) DEFAULT NULL,
  `customizations` text DEFAULT NULL,
  `cancel_reason` text DEFAULT NULL,
  `status_updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `delivered_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total`, `status`, `payment_method`, `receipt_image`, `transaction_id`, `area`, `landmark`, `delivery_fee`, `created_at`, `total_amount`, `mode_of_payment`, `place`, `receipt`, `customizations`, `cancel_reason`, `status_updated_at`, `delivered_at`) VALUES
(46, 1, NULL, 'delivered', 'gcash', '../uploads/receipts/1745821123_Corndog.jpg', '12312312312314', 'Encanto', 'purok 4', 40.00, '2025-04-28 06:18:43', 255.00, '', '', NULL, NULL, NULL, '2025-05-03 00:00:59', '2025-05-03 00:00:59'),
(47, 1, NULL, '', 'cod', NULL, '', 'Sta. Lucia', 'purok 4', 50.00, '2025-04-28 06:24:30', 335.00, '', '', NULL, NULL, NULL, '2025-05-02 23:54:28', NULL),
(48, 1, NULL, '', 'gcash', '../uploads/receipts/1745924592_Brown Sugar.png', '1231231254523', 'Encanto Dulo', 'asdfasd', 50.00, '2025-04-29 11:03:12', 165.00, '', '', NULL, NULL, NULL, '2025-05-02 23:46:40', NULL),
(49, 1, NULL, '', 'cod', NULL, '', 'San Roque', 'Basketball court', 30.00, '2025-05-02 23:43:54', 150.00, '', '', NULL, NULL, NULL, '2025-05-02 23:51:18', NULL),
(50, 1, NULL, 'delivered', 'cod', NULL, '', 'San Roque', 'Basketball court', 30.00, '2025-05-03 00:01:21', 150.00, '', '', NULL, NULL, NULL, '2025-05-03 00:01:51', '2025-05-03 00:01:51'),
(51, 1, NULL, 'delivered', 'cod', NULL, '', 'San Roque', 'f', 30.00, '2025-05-03 00:12:01', 340.00, '', '', NULL, NULL, NULL, '2025-05-03 00:21:50', '2025-05-03 00:21:50'),
(52, 1, NULL, 'delivered', 'cod', NULL, '', 'Sto Cristo', 'near brgy hall', 30.00, '2025-05-03 00:20:51', 150.00, '', '', NULL, NULL, NULL, '2025-05-03 00:22:00', '2025-05-03 00:22:00'),
(53, 1, NULL, 'delivered', 'cod', NULL, '', 'Encanto', 'asdfasdf', 40.00, '2025-05-03 00:22:46', 160.00, '', '', NULL, NULL, NULL, '2025-05-03 00:23:11', '2025-05-03 00:23:11'),
(54, 1, NULL, 'delivered', 'cod', NULL, '', 'San Roque', 'near brgy hall', 30.00, '2025-05-03 00:34:38', 150.00, '', '', NULL, NULL, NULL, '2025-05-03 00:46:51', '2025-05-03 00:46:51'),
(55, 1, NULL, 'canceled', 'cod', NULL, '', 'Sto Cristo', 'purok 4', 30.00, '2025-05-03 00:47:11', 150.00, '', '', NULL, NULL, NULL, '2025-05-03 00:53:26', NULL),
(56, 1, NULL, 'delivered', 'cod', NULL, '', 'San Roque', 'Basketball court', 30.00, '2025-05-03 01:09:02', 150.00, '', '', NULL, NULL, NULL, '2025-05-03 02:54:59', '2025-05-03 02:54:59'),
(57, 1, NULL, 'delivered', 'cod', NULL, '', 'San Roque', 'asdfasd', 0.00, '2025-05-03 02:49:39', 50.00, '', '', NULL, NULL, NULL, '2025-05-03 02:59:02', '2025-05-03 02:59:02'),
(58, 1, NULL, 'delivered', 'cod', NULL, '', 'San Roque', 'Basketball court', 0.00, '2025-05-03 02:56:15', 120.00, '', '', NULL, NULL, NULL, '2025-05-03 02:59:28', '2025-05-03 02:59:28'),
(59, 1, NULL, 'delivered', 'cod', NULL, '', 'Binagbag', 'Basketball court', 0.00, '2025-05-03 02:57:02', 420.00, '', '', NULL, NULL, NULL, '2025-05-03 02:59:12', '2025-05-03 02:59:12'),
(60, 1, NULL, 'pending', 'cod', NULL, '', 'Encanto', 'Basketball court', 0.00, '2025-05-03 03:00:26', 120.00, '', '', NULL, NULL, NULL, '2025-05-03 03:00:26', NULL),
(61, 1, NULL, 'pending', 'cod', NULL, '', 'San Roque', 'Basketball court', 0.00, '2025-05-03 03:01:10', 120.00, '', '', NULL, NULL, NULL, '2025-05-03 03:01:10', NULL),
(62, 1, NULL, 'delivered', 'cod', NULL, '', 'Encanto', 'near brgy hall', 0.00, '2025-05-03 03:01:40', 120.00, '', '', NULL, NULL, NULL, '2025-05-03 03:06:02', '2025-05-03 03:06:02');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `size` varchar(50) DEFAULT NULL,
  `flavor` varchar(50) DEFAULT NULL,
  `addons` text DEFAULT NULL,
  `customizations` text DEFAULT NULL,
  `cancel_reason` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`, `size`, `flavor`, `addons`, `customizations`, `cancel_reason`) VALUES
(1, 46, 11, 1, 215.00, NULL, NULL, NULL, '{\"Size\":\"Overload\",\"Flavor\":\"Classic\",\"Add-ons\":[\"Chocolate Chips\",\"Crushed Oreo\",\"Marshmallow\",\"Milk Powder \",\"Mini Nips\",\"Rice Crispies\",\"Sprinkles\",\"Syrup\"]}', NULL),
(2, 47, 11, 1, 115.00, NULL, NULL, NULL, '{\"Size\":\"Large\",\"Flavor\":\"Classic\",\"Add-ons\":[\"Chocolate Chips\",\"Crushed Oreo\",\"Marshmallow\"]}', NULL),
(3, 47, 15, 1, 100.00, NULL, NULL, NULL, NULL, NULL),
(4, 47, 17, 1, 70.00, NULL, NULL, NULL, NULL, NULL),
(5, 48, 11, 1, 115.00, NULL, NULL, NULL, '{\"Size\":\"Large\",\"Flavor\":\"Classic\",\"Add-ons\":[\"Chocolate Chips\",\"Crushed Oreo\",\"Marshmallow\"]}', NULL),
(6, 49, 18, 1, 120.00, NULL, NULL, NULL, NULL, NULL),
(7, 50, 18, 1, 120.00, NULL, NULL, NULL, NULL, NULL),
(8, 51, 18, 2, 120.00, NULL, NULL, NULL, NULL, NULL),
(9, 51, 17, 1, 70.00, NULL, NULL, NULL, NULL, NULL),
(10, 52, 18, 1, 120.00, NULL, NULL, NULL, NULL, NULL),
(11, 53, 18, 1, 120.00, NULL, NULL, NULL, NULL, NULL),
(12, 54, 18, 1, 120.00, NULL, NULL, NULL, NULL, NULL),
(13, 55, 18, 1, 120.00, NULL, NULL, NULL, NULL, NULL),
(14, 56, 18, 1, 120.00, NULL, NULL, NULL, NULL, NULL),
(15, 57, 16, 1, 50.00, NULL, NULL, NULL, '[]', NULL),
(16, 58, 18, 1, 120.00, NULL, NULL, NULL, '[]', NULL),
(17, 59, 17, 6, 70.00, NULL, NULL, NULL, '[]', NULL),
(18, 60, 18, 1, 120.00, NULL, NULL, NULL, '[]', NULL),
(19, 61, 18, 1, 120.00, NULL, NULL, NULL, '[]', NULL),
(20, 62, 18, 1, 120.00, NULL, NULL, NULL, '[]', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) DEFAULT 0,
  `is_customizable` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `description` text DEFAULT NULL,
  `customizable_options` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `image`, `price`, `stock`, `is_customizable`, `created_at`, `description`, `customizable_options`) VALUES
(11, 'Ice Scramble', '../uploads/1745795555_Ice Scramble.jpg', 50.00, 6, 1, '2025-04-27 23:12:35', 'Ice Scramble', NULL),
(15, 'Mini Donuts', '../uploads/1745798412_Mini Donuts.jpg', 100.00, 2, 0, '2025-04-28 00:00:12', 'Mini Donuts', NULL),
(16, 'Corndog', '../uploads/1745800417_Corndog.jpg', 50.00, 6, 0, '2025-04-28 00:33:37', 'Corndog', NULL),
(17, 'Fried Noodles', '../uploads/1745800461_Fried Noodles.jpg', 70.00, 32, 0, '2025-04-28 00:34:21', 'Fried Noodles', NULL),
(18, 'Graham Ice Cream', '../uploads/1745800516_Picture5.jpg', 120.00, 41, 0, '2025-04-28 00:35:16', 'Graham Ice Cream', NULL),
(19, 'Milky Drinks', '../uploads/1745800577_Picture6.jpg', 40.00, 55, 1, '2025-04-28 00:36:17', 'Milky Drinks', NULL),
(20, 'Milky Drinkzzz', '../uploads/1745821302_pic 2.jpg', 40.00, 55, 1, '2025-04-28 06:21:42', 'Milk Drinkz', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_addons`
--

CREATE TABLE `product_addons` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `addon_name` varchar(50) NOT NULL,
  `price_adjustment` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_flavors`
--

CREATE TABLE `product_flavors` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `flavor_name` varchar(50) NOT NULL,
  `price_adjustment` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_ingredients`
--

CREATE TABLE `product_ingredients` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `ingredient_id` int(11) NOT NULL,
  `quantity` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_ingredients`
--

INSERT INTO `product_ingredients` (`id`, `product_id`, `ingredient_id`, `quantity`) VALUES
(1, 16, 2, 10.00);

-- --------------------------------------------------------

--
-- Table structure for table `product_sizes`
--

CREATE TABLE `product_sizes` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `size_name` varchar(50) NOT NULL,
  `price_adjustment` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `name` varchar(50) NOT NULL,
  `value` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`name`, `value`) VALUES
('shutdown', '0');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_admin` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `contact`, `password`, `created_at`, `is_admin`) VALUES
(1, 'Customer1', 'customer@gmail.com', '09649856416', '$2y$10$FVUR6I9N8MVqjsiBcd6CK.oK5C4lJzW5dQzV0t.YG7t11U1dQ4Acq', '2025-04-20 04:45:43', 0),
(2, 'admin', 'admin@gmail.com', '094694654263', '$2y$10$yhrwmkQZEq2Fch5gcOR4lOTI0z/HInKJFvR.RZnLwy0L6YivmuFjW', '2025-04-20 05:06:16', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `customizable_options`
--
ALTER TABLE `customizable_options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customizable_options_ibfk_1` (`product_id`);

--
-- Indexes for table `ingredients`
--
ALTER TABLE `ingredients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `order_items_ibfk_2` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_addons`
--
ALTER TABLE `product_addons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `product_flavors`
--
ALTER TABLE `product_flavors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `product_ingredients`
--
ALTER TABLE `product_ingredients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `ingredient_id` (`ingredient_id`);

--
-- Indexes for table `product_sizes`
--
ALTER TABLE `product_sizes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customizable_options`
--
ALTER TABLE `customizable_options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `ingredients`
--
ALTER TABLE `ingredients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `product_addons`
--
ALTER TABLE `product_addons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_flavors`
--
ALTER TABLE `product_flavors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_ingredients`
--
ALTER TABLE `product_ingredients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product_sizes`
--
ALTER TABLE `product_sizes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `customizable_options`
--
ALTER TABLE `customizable_options`
  ADD CONSTRAINT `customizable_options_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_addons`
--
ALTER TABLE `product_addons`
  ADD CONSTRAINT `product_addons_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `product_flavors`
--
ALTER TABLE `product_flavors`
  ADD CONSTRAINT `product_flavors_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `product_ingredients`
--
ALTER TABLE `product_ingredients`
  ADD CONSTRAINT `product_ingredients_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `product_ingredients_ibfk_2` FOREIGN KEY (`ingredient_id`) REFERENCES `ingredients` (`id`);

--
-- Constraints for table `product_sizes`
--
ALTER TABLE `product_sizes`
  ADD CONSTRAINT `product_sizes_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
