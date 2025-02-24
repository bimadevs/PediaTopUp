-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 21, 2025 at 07:24 PM
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
-- Database: `db_pediatopup`
--

-- --------------------------------------------------------

--
-- Table structure for table `bank`
--

CREATE TABLE `bank` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `number` varchar(20) NOT NULL,
  `behalf` varchar(100) NOT NULL,
  `icon` varchar(100) NOT NULL,
  `minimum` double NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bank`
--

INSERT INTO `bank` (`id`, `name`, `number`, `behalf`, `icon`, `minimum`, `status`, `created_at`, `updated_at`) VALUES
(1, 'BCA', '7612562342', 'Rehandra Fomin', '1739983940_94390da1beecbdac2c17.svg', 15000, '1', '2025-01-22 04:43:05', '2025-01-22 04:43:05'),
(2, 'BNI', '7712672342', 'Rian Pangabean', '1740033544_6225d8fdfaec626959b5.png', 15000, '1', '2025-02-20 06:39:04', '2025-02-20 06:39:04');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `icon` varchar(100) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `slug`, `icon`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Apple Pay', 'applepay', 'applepay.png', 1, '2025-02-15 19:56:43', '2025-02-15 19:56:22'),
(2, 'Sakuku', 'sakuku', 'sakuku.png', 1, '2025-02-15 19:56:45', '2025-02-15 19:56:22'),
(3, 'i.saku', 'isaku', 'isaku.png', 1, '2025-02-15 19:56:46', '2025-02-15 19:56:22'),
(4, 'PayPal', 'paypal', 'paypal.png', 1, '2025-02-15 19:56:47', '2025-02-15 19:56:22'),
(5, 'LinkAja', 'linkaja', 'linkaja.png', 1, '2025-02-15 19:56:48', '2025-02-15 19:56:22'),
(6, 'ShopeePay', 'shopeepay', 'spay.png', 1, '2025-02-15 19:56:50', '2025-02-15 19:56:22'),
(7, 'Gopay', 'gopay', 'gopay.png', 1, '2025-02-15 19:56:51', '2025-02-15 19:56:22'),
(8, 'DANA', 'dana', 'dana.png', 1, '2025-02-15 19:56:53', '2025-02-15 19:56:22'),
(9, 'OVO', 'ovo', 'ovo.png', 1, '2025-02-15 19:49:52', '2025-02-15 19:49:52');

-- --------------------------------------------------------

--
-- Table structure for table `deposit`
--

CREATE TABLE `deposit` (
  `id` varchar(10) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_bank` int(11) NOT NULL,
  `total` double NOT NULL,
  `uniq` int(3) NOT NULL,
  `bukti_pembayaran` text DEFAULT NULL,
  `note` text DEFAULT NULL,
  `status` enum('pending','approved','declined') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `deposit`
--

INSERT INTO `deposit` (`id`, `id_user`, `id_bank`, `total`, `uniq`, `bukti_pembayaran`, `note`, `status`, `created_at`, `updated_at`) VALUES
('D4767751', 2, 2, 50000, 136, NULL, '', 'approved', '2025-02-20 09:37:12', '2025-02-21 09:37:12');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `id_category` int(11) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` double NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 100,
  `status` int(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `id_category`, `slug`, `name`, `price`, `stock`, `status`, `created_at`, `updated_at`) VALUES
(1, 9, 'ovo', 'OVO 50.000', 50000, 100, 1, '2025-02-15 20:04:00', '2025-02-15 20:04:00'),
(2, 9, 'ovo', 'OVO 100.000', 100000, 100, 1, '2025-02-15 20:04:00', '2025-02-15 20:04:00'),
(3, 9, 'ovo', 'OVO 500.000', 500000, 100, 1, '2025-02-15 20:04:00', '2025-02-15 20:04:00'),
(4, 9, 'ovo', 'OVO 1.000.000', 1000000, 100, 1, '2025-02-15 20:04:00', '2025-02-15 20:04:00'),
(5, 9, 'ovo', 'OVO 5.000.000', 5000000, 100, 1, '2025-02-15 20:04:00', '2025-02-15 20:04:00'),
(6, 8, 'dana', 'DANA 50.000', 50000, 100, 1, '2025-02-16 10:29:02', '2025-02-16 10:29:02'),
(7, 8, 'dana', 'DANA 100.000', 100000, 100, 1, '2025-02-16 10:29:17', '2025-02-16 10:29:17'),
(8, 8, 'dana', 'DANA 500.000', 500000, 100, 1, '2025-02-16 10:31:41', '2025-02-16 10:31:41'),
(9, 8, 'dana', 'DANA 1.000.000', 1000000, 100, 1, '2025-02-16 10:32:25', '2025-02-16 10:32:25'),
(10, 8, 'dana', 'DANA 2.000.000', 2000000, 100, 1, '2025-02-16 10:34:35', '2025-02-16 10:34:35'),
(12, 7, 'gopay', 'GoPay 50.000', 50000, 100, 1, '2025-02-17 03:52:04', '2025-02-17 03:52:04'),
(13, 7, 'gopay', 'GoPay 100.000', 100000, 100, 1, '2025-02-21 18:05:56', '2025-02-21 18:05:56'),
(14, 7, 'gopay', 'GoPay 500.000', 500000, 100, 1, '2025-02-21 18:06:12', '2025-02-21 18:06:12'),
(15, 7, 'gopay', 'GoPay 1.000.000', 1000000, 100, 1, '2025-02-21 18:06:24', '2025-02-21 18:06:24'),
(16, 7, 'gopay', 'GoPay 5.000.000', 5000000, 100, 1, '2025-02-21 18:07:07', '2025-02-21 18:07:07'),
(17, 6, 'shopeepay', 'ShopeePay 50.000', 50000, 100, 1, '2025-02-21 18:07:52', '2025-02-21 18:07:52'),
(18, 6, 'shopeepay', 'ShopeePay 100.000', 100000, 100, 1, '2025-02-21 18:09:04', '2025-02-21 18:09:04'),
(19, 6, 'shopeepay', 'ShopeePay 500.000', 500000, 100, 1, '2025-02-21 18:09:24', '2025-02-21 18:09:24'),
(20, 6, 'shopeepay', 'ShopeePay 1.000.000', 1000000, 100, 1, '2025-02-21 18:09:33', '2025-02-21 18:09:33'),
(21, 6, 'shopeepay', 'ShopeePay 5.000.000', 5000000, 100, 1, '2025-02-21 18:09:45', '2025-02-21 18:09:45'),
(22, 5, 'linkaja', 'LinkAja 50.000', 50000, 100, 1, '2025-02-21 18:10:22', '2025-02-21 18:10:22'),
(23, 5, 'linkaja', 'LinkAja 100.000', 100000, 100, 1, '2025-02-21 18:10:34', '2025-02-21 18:10:34'),
(24, 5, 'linkaja', 'LinkAja 500.000', 500000, 100, 1, '2025-02-21 18:10:47', '2025-02-21 18:10:47'),
(25, 5, 'linkaja', 'LinkAja 1.000.000', 1000000, 100, 1, '2025-02-21 18:11:01', '2025-02-21 18:11:01'),
(26, 5, 'linkaja', 'LinkAja 5.000.000', 5000000, 100, 1, '2025-02-21 18:11:19', '2025-02-21 18:11:19'),
(27, 4, 'paypal', 'PayPal 50.000', 50000, 100, 1, '2025-02-21 18:11:58', '2025-02-21 18:11:58'),
(28, 4, 'paypal', 'PayPal 100.000', 100000, 100, 1, '2025-02-21 18:12:10', '2025-02-21 18:12:10'),
(29, 4, 'paypal', 'PayPal 500.000', 500000, 100, 1, '2025-02-21 18:12:23', '2025-02-21 18:12:23'),
(30, 4, 'paypal', 'PayPal 1.000.000', 1000000, 100, 1, '2025-02-21 18:12:34', '2025-02-21 18:12:34'),
(31, 4, 'paypal', 'PayPal 5.000.000', 5000000, 100, 1, '2025-02-21 18:12:44', '2025-02-21 18:12:44'),
(32, 3, 'isaku', 'i.saku 50.000', 50000, 100, 1, '2025-02-21 18:13:11', '2025-02-21 18:13:11'),
(33, 3, 'isaku', 'i.saku 100.000', 100000, 100, 1, '2025-02-21 18:13:25', '2025-02-21 18:13:25'),
(34, 3, 'isaku', 'i.saku 500.000', 500000, 100, 1, '2025-02-21 18:13:35', '2025-02-21 18:13:35'),
(35, 3, 'isaku', 'i.saku 1.000.000', 1000000, 100, 1, '2025-02-21 18:13:44', '2025-02-21 18:13:44'),
(36, 3, 'isaku', 'i.saku 5.000.000', 5000000, 100, 1, '2025-02-21 18:13:56', '2025-02-21 18:13:56'),
(37, 2, 'sakuku', 'Sakuku 50.000', 50000, 99, 1, '2025-02-21 18:14:26', '2025-02-21 18:14:26'),
(38, 2, 'sakuku', 'Sakuku 100.000', 100000, 100, 1, '2025-02-21 18:14:37', '2025-02-21 18:14:37'),
(39, 2, 'sakuku', 'Sakuku 500.000', 500000, 100, 1, '2025-02-21 18:14:46', '2025-02-21 18:14:46'),
(40, 2, 'sakuku', 'Sakuku 1.000.000', 1000000, 100, 1, '2025-02-21 18:14:58', '2025-02-21 18:14:58'),
(41, 2, 'sakuku', 'Sakuku 5.000.000', 5000000, 100, 1, '2025-02-21 18:15:10', '2025-02-21 18:15:10'),
(42, 1, 'applepay', 'Apple Pay 50.000', 50000, 100, 1, '2025-02-21 18:16:04', '2025-02-21 18:16:04'),
(43, 1, 'applepay', 'Apple Pay 100.000', 100000, 100, 1, '2025-02-21 18:16:13', '2025-02-21 18:16:13'),
(44, 1, 'applepay', 'Apple Pay 500.000', 500000, 100, 1, '2025-02-21 18:16:24', '2025-02-21 18:16:24'),
(45, 1, 'applepay', 'Apple Pay 1.000.000', 1000000, 100, 1, '2025-02-21 18:16:33', '2025-02-21 18:16:33'),
(46, 1, 'applepay', 'Apple Pay 5.000.000', 5000000, 100, 1, '2025-02-21 18:16:43', '2025-02-21 18:16:43');

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `id` varchar(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `phone` varchar(17) DEFAULT NULL,
  `product` varchar(250) NOT NULL,
  `price` bigint(20) NOT NULL,
  `fee` double NOT NULL,
  `total` double NOT NULL,
  `metode` varchar(20) NOT NULL,
  `status` enum('Pending','Processing','Completed','Canceled') NOT NULL,
  `ip` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`id`, `user_id`, `product_id`, `name`, `phone`, `product`, `price`, `fee`, `total`, `metode`, `status`, `ip`, `created_at`, `updated_at`) VALUES
('P2269153', 2, 7, 'Rehandra Fomin', '081807955899', 'OVO 50.000', 50000, 1000, 51000, 'Saldo', 'Completed', '::1', '2025-02-19 03:56:22', '2025-02-19 03:56:22'),
('P8015427', 2, 12, 'Rehandra Fomin', '085156043170', 'Gopay 50.000', 50000, 0, 50000, 'Saldo', 'Completed', '::1', '2025-02-19 03:47:14', '2025-02-19 03:47:18'),
('P9906258', 2, 37, 'Rehandra Fomin', '081058018525', 'Sakuku 50.000', 50000, 0, 50000, 'Saldo', 'Completed', '::1', '2025-02-22 01:15:31', '2025-02-22 01:15:31');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(55) DEFAULT NULL,
  `phone` varchar(17) NOT NULL,
  `password` varchar(250) NOT NULL,
  `balance` double NOT NULL DEFAULT 0,
  `level` enum('Member','Admin') NOT NULL DEFAULT 'Member',
  `status` enum('On','Off') NOT NULL DEFAULT 'On',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_ip` varchar(100) NOT NULL,
  `last_login` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `password`, `balance`, `level`, `status`, `created_at`, `last_ip`, `last_login`) VALUES
(1, 'PediaTopup', 'pediatopup@gmail.com', '0', '$2y$10$tO2gY47517EULVQDqn4rJ.B7xmmrS1aZmbGo/.QTNQQqrR6iQ.MPK', 0, 'Admin', 'On', '2025-01-21 08:13:51', '::1', '2025-01-22 11:30:11'),
(2, 'Rehandra Fomin', 'barakobama22@gmail.com', '081807955233', '$2y$10$tO2gY47517EULVQDqn4rJ.B7xmmrS1aZmbGo/.QTNQQqrR6iQ.MPK', 2238000, 'Member', 'On', '2025-02-16 05:48:13', '', '2025-02-16 06:47:59');

-- --------------------------------------------------------

--
-- Table structure for table `utility`
--

CREATE TABLE `utility` (
  `id` int(11) NOT NULL,
  `u_key` varchar(250) NOT NULL,
  `u_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `utility`
--

INSERT INTO `utility` (`id`, `u_key`, `u_value`) VALUES
(1, 'web-title', 'PediaTopup'),
(2, 'web-icon', '1739896624_115f0aedfa7ad9b39ddc.png'),
(3, 'web-logo', '1739896624_f5bd12efe26098fa5bc4.png'),
(4, 'web-author', 'https://pediatopup.com'),
(5, 'web-keywords', 'top up game, topup murah, top up terpercaya, top up free fire, top up free fire termurah, top up mobile legends, top up ml, top up pubg'),
(6, 'web-description', 'PediaTopup melayani berbagai macam'),
(10, 'slide', '1739905818_16aaa7ba6fabde1befbd.jpg,1739905818_ce87416c37002e7a5651.jpg'),
(17, 'email', 'bakrierayanza@gmail.com'),
(18, 'phone', '081807955899'),
(21, 'pay-saldo', 'On'),
(22, 'fee', '0'),
(23, 'currency', 'Rp'),
(24, 'bonus-deposit', '15%');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bank`
--
ALTER TABLE `bank`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deposit`
--
ALTER TABLE `deposit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `utility`
--
ALTER TABLE `utility`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bank`
--
ALTER TABLE `bank`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `utility`
--
ALTER TABLE `utility`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
