-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 02, 2025 at 11:33 AM
-- Server version: 11.8.3-MariaDB-log
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u661010849_amazon`
--

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `condition` enum('new','used in good condition','damaged product','damaged bag','without bag','replaced') NOT NULL,
  `inventory_actions` enum('add to inventory','ship to amazon') NOT NULL,
  `notes` varchar(400) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `product_id`, `quantity`, `condition`, `inventory_actions`, `notes`, `created_at`, `updated_at`) VALUES
(57, 17, 22, 'new', 'add to inventory', NULL, '2024-07-26 20:44:20', '2024-07-26 20:44:20'),
(58, 14, 9, 'new', 'add to inventory', NULL, '2024-07-26 20:44:32', '2024-07-26 20:44:32'),
(59, 13, 7, 'new', 'add to inventory', NULL, '2024-07-26 20:44:48', '2024-07-26 20:44:48'),
(60, 12, 6, 'new', 'add to inventory', NULL, '2024-07-26 20:45:00', '2024-07-26 20:45:00'),
(61, 11, 4, 'new', 'add to inventory', NULL, '2024-07-26 20:45:19', '2024-07-26 20:45:19'),
(62, 16, 4, 'new', 'add to inventory', NULL, '2024-07-26 20:45:35', '2024-07-26 20:48:27'),
(63, 20, 1, 'without bag', 'add to inventory', NULL, '2024-07-26 20:46:21', '2024-07-26 20:46:21'),
(64, 20, 1, 'new', 'add to inventory', NULL, '2024-07-26 20:46:29', '2024-07-26 20:46:29'),
(65, 15, 1, 'new', 'add to inventory', NULL, '2024-07-26 20:47:14', '2024-07-26 20:47:14'),
(66, 21, 1, 'new', 'add to inventory', NULL, '2024-07-26 20:47:33', '2024-07-26 20:47:33'),
(67, 20, 60, 'new', 'add to inventory', NULL, '2024-07-26 20:49:27', '2024-07-26 20:49:27'),
(68, 15, 30, 'new', 'add to inventory', NULL, '2024-07-26 20:49:44', '2024-07-26 20:49:44'),
(69, 14, 10, 'new', 'add to inventory', NULL, '2024-07-26 20:49:56', '2024-07-26 20:49:56'),
(70, 12, 6, 'new', 'add to inventory', NULL, '2024-07-26 20:50:15', '2024-07-26 20:50:15'),
(72, 11, -4, 'new', 'ship to amazon', NULL, '2024-07-26 20:55:00', '2024-07-26 20:55:00'),
(73, 20, -8, 'new', 'ship to amazon', NULL, '2024-07-26 20:55:09', '2024-07-26 20:55:09'),
(74, 13, -4, 'new', 'ship to amazon', NULL, '2024-07-26 20:55:22', '2024-07-26 20:55:22'),
(75, 17, -8, 'new', 'ship to amazon', NULL, '2024-07-26 20:55:35', '2024-07-26 20:55:35'),
(76, 16, -4, 'new', 'ship to amazon', NULL, '2024-07-26 20:55:48', '2024-07-26 20:56:03'),
(77, 19, 60, 'new', 'add to inventory', NULL, '2024-07-26 20:57:30', '2024-07-26 20:57:30'),
(78, 16, 30, 'new', 'add to inventory', NULL, '2024-07-26 20:57:41', '2024-07-26 20:57:41'),
(79, 17, -8, 'new', 'ship to amazon', NULL, '2024-07-26 20:58:15', '2024-07-26 20:58:15'),
(80, 16, -20, 'new', 'ship to amazon', NULL, '2024-07-26 20:58:28', '2024-07-26 20:58:28'),
(81, 19, -40, 'new', 'ship to amazon', NULL, '2024-07-26 20:58:44', '2024-07-26 20:58:44'),
(82, 19, 25, 'new', 'add to inventory', NULL, '2024-07-31 01:02:12', '2024-07-31 01:02:12'),
(83, 16, 14, 'new', 'add to inventory', NULL, '2024-07-31 01:02:34', '2024-07-31 01:02:34'),
(84, 13, 10, 'new', 'add to inventory', NULL, '2024-07-31 01:02:46', '2024-07-31 01:02:46'),
(85, 19, 1, 'damaged bag', 'add to inventory', NULL, '2024-07-31 01:05:13', '2024-07-31 01:05:13'),
(87, 20, -4, 'new', 'ship to amazon', NULL, '2024-09-05 02:30:46', '2024-09-05 02:30:46'),
(88, 12, -4, 'new', 'ship to amazon', NULL, '2024-09-05 02:31:02', '2024-09-05 02:31:02'),
(89, 13, -4, 'new', 'ship to amazon', NULL, '2024-09-05 02:31:24', '2024-09-05 02:31:24'),
(90, 14, -6, 'new', 'ship to amazon', NULL, '2024-09-05 02:31:44', '2024-09-05 02:31:44'),
(91, 16, -12, 'new', 'ship to amazon', NULL, '2024-09-05 02:32:04', '2024-09-05 02:32:04'),
(92, 19, -16, 'new', 'ship to amazon', NULL, '2024-09-05 02:32:17', '2024-09-05 02:32:17'),
(93, 12, 11, 'new', 'add to inventory', NULL, '2024-09-09 09:56:56', '2024-09-09 09:56:56'),
(94, 12, 1, 'damaged bag', 'add to inventory', NULL, '2024-09-09 09:57:10', '2024-09-09 09:57:10'),
(95, 11, 4, 'new', 'add to inventory', NULL, '2024-09-09 09:57:18', '2024-09-09 09:57:18'),
(96, 16, 1, 'new', 'add to inventory', NULL, '2024-09-09 09:57:28', '2024-09-09 09:57:28'),
(97, 19, 1, 'damaged bag', 'add to inventory', NULL, '2024-09-09 09:57:37', '2024-09-09 09:58:31'),
(98, 13, 3, 'new', 'add to inventory', NULL, '2024-09-09 09:57:53', '2024-09-09 09:57:53'),
(99, 14, 3, 'new', 'add to inventory', NULL, '2024-09-09 09:58:05', '2024-09-09 09:58:05'),
(100, 14, 2, 'new', 'add to inventory', NULL, '2024-09-28 02:15:05', '2024-09-28 02:15:05'),
(101, 13, 1, 'new', 'add to inventory', NULL, '2024-09-28 02:15:19', '2024-09-28 02:15:19'),
(102, 11, -4, 'new', 'ship to amazon', NULL, '2024-10-02 10:34:03', '2024-10-02 10:34:03'),
(103, 12, -10, 'new', 'ship to amazon', NULL, '2024-10-02 10:34:44', '2024-10-02 10:34:44'),
(104, 13, -5, 'new', 'ship to amazon', NULL, '2024-10-02 10:35:05', '2024-10-02 10:35:05'),
(105, 14, -8, 'new', 'ship to amazon', NULL, '2024-10-02 10:35:29', '2024-10-02 10:35:29'),
(106, 15, -10, 'new', 'ship to amazon', NULL, '2024-10-02 10:35:40', '2024-10-02 10:35:40'),
(107, 16, -10, 'new', 'ship to amazon', NULL, '2024-10-02 10:36:38', '2024-10-02 10:36:38'),
(108, 17, -6, 'new', 'ship to amazon', NULL, '2024-10-02 10:36:47', '2024-10-02 10:36:47'),
(109, 19, -10, 'new', 'ship to amazon', NULL, '2024-10-02 10:37:08', '2024-10-02 10:37:08'),
(110, 20, -10, 'new', 'ship to amazon', NULL, '2024-10-02 10:37:18', '2024-10-25 06:17:38'),
(112, 21, -1, 'new', 'ship to amazon', 'we have sold it to emirates person outside amazon', '2024-10-25 06:19:10', '2024-10-25 06:19:10'),
(113, 20, 8, 'new', 'add to inventory', 'returns from amazon (removal orders) (cause of no sales for last 90 days or for long term issue)\r\nit has new condition but has some tape on them', '2024-10-31 08:07:48', '2024-10-31 08:27:20'),
(114, 12, 2, 'new', 'add to inventory', 'returns from amazon removal orders (aslo tape on it\'s bag)', '2024-10-31 08:26:53', '2024-10-31 08:26:53'),
(115, 11, 2, 'new', 'add to inventory', 'removal orders', '2024-10-31 08:28:09', '2024-10-31 08:28:09'),
(116, 11, -2, 'new', 'ship to amazon', NULL, '2024-11-02 09:30:08', '2024-11-02 09:30:08'),
(117, 12, -8, 'new', 'ship to amazon', NULL, '2024-11-02 09:30:34', '2024-11-02 09:30:34'),
(118, 13, -8, 'new', 'ship to amazon', NULL, '2024-11-02 09:30:45', '2024-11-02 09:30:45'),
(119, 14, -8, 'new', 'ship to amazon', NULL, '2024-11-02 09:30:59', '2024-11-02 09:30:59'),
(120, 15, -8, 'new', 'ship to amazon', NULL, '2024-11-02 09:31:06', '2024-11-02 09:31:06'),
(121, 19, -16, 'new', 'ship to amazon', NULL, '2024-11-02 09:31:24', '2024-11-02 09:31:24'),
(122, 20, -20, 'new', 'ship to amazon', NULL, '2024-11-02 09:31:34', '2024-11-02 09:31:34'),
(123, 22, 10, 'new', 'add to inventory', 'returns from amazon', '2024-11-02 15:16:26', '2024-11-02 15:16:26'),
(124, 23, 2, 'new', 'add to inventory', 'returns from amazon', '2024-11-02 15:20:43', '2024-11-02 16:08:01'),
(125, 11, 1, 'new', 'add to inventory', 'we have buy it from noon to rate it', '2024-11-02 15:22:54', '2024-11-02 15:45:12'),
(126, 24, 1, 'damaged product', 'add to inventory', 'returns in bad conditions', '2024-11-02 15:44:40', '2024-11-02 15:44:40'),
(127, 25, 28, 'new', 'add to inventory', 'we bought 3 items from compitive sellers to see it also (after omar do (jared) for goods in house .. I have to add 25 items to make it equal with the online inventory)', '2024-11-02 15:48:11', '2024-11-02 15:48:11'),
(128, 26, 67, 'new', 'add to inventory', 'returns from amazon', '2024-11-02 16:00:30', '2024-11-02 16:00:30'),
(129, 14, -1, 'new', 'ship to amazon', 'this item has been sent to customer as a replacement', '2024-11-14 05:51:51', '2024-11-14 05:51:51'),
(130, 15, -1, 'new', 'ship to amazon', 'this item has been sent to customer as a replacement', '2024-11-14 05:52:06', '2024-11-14 05:52:06'),
(131, 13, 1, 'without bag', 'add to inventory', NULL, '2024-11-14 06:14:30', '2024-11-14 06:14:30'),
(132, 16, 1, 'new', 'add to inventory', 'returns', '2024-11-20 07:04:29', '2024-11-20 07:04:29'),
(133, 24, 1, 'new', 'add to inventory', 'medium size', '2024-11-20 11:28:41', '2024-11-20 11:28:41'),
(134, 30, 5, 'new', 'add to inventory', 'These items was hidden between products and Omar discovered it today', '2024-12-05 18:12:24', '2024-12-05 18:12:24'),
(135, 29, 38, 'new', 'add to inventory', 'These items was hidden between products and Omar discovered it today', '2024-12-05 18:13:18', '2024-12-05 18:13:18'),
(136, 28, 31, 'new', 'add to inventory', 'These items was hidden between products and Omar discovered it today', '2024-12-05 18:13:39', '2024-12-05 18:13:39'),
(137, 19, 30, 'new', 'add to inventory', 'Today we bought it from roadpower', '2024-12-05 18:15:38', '2024-12-05 18:15:38'),
(138, 16, 15, 'new', 'add to inventory', 'We bought it today from roadpower', '2024-12-05 18:16:33', '2024-12-05 18:16:33'),
(139, 15, 10, 'new', 'add to inventory', 'We bought it today from roadpower', '2024-12-05 18:17:12', '2024-12-05 18:17:12'),
(140, 14, 15, 'new', 'add to inventory', 'We bought it today from roadpower', '2024-12-05 18:17:30', '2024-12-05 18:17:30'),
(141, 13, 15, 'new', 'add to inventory', 'We bought it today from roadpower', '2024-12-05 18:17:46', '2024-12-05 18:17:46'),
(142, 12, 15, 'new', 'add to inventory', 'We bought it today from roadpower', '2024-12-05 18:18:14', '2024-12-05 18:18:14'),
(143, 11, -1, 'new', 'ship to amazon', 'Ship to Amazon', '2024-12-13 21:05:44', '2024-12-13 21:05:44'),
(144, 12, -8, 'new', 'ship to amazon', 'Ship to Amazon', '2024-12-13 21:06:27', '2024-12-13 21:06:27'),
(145, 13, -8, 'new', 'ship to amazon', 'Ship to Amazon', '2024-12-13 21:06:54', '2024-12-13 21:06:54'),
(146, 14, -8, 'new', 'ship to amazon', 'Ship to Amazon', '2024-12-13 21:07:22', '2024-12-13 21:07:22'),
(147, 15, -8, 'new', 'ship to amazon', 'Ship to Amazon', '2024-12-13 21:08:01', '2024-12-13 21:08:01'),
(148, 19, -12, 'new', 'ship to amazon', 'Ship to Amazon', '2024-12-13 21:09:02', '2024-12-13 21:09:02'),
(149, 16, -12, 'new', 'ship to amazon', 'Ship to Amazon', '2024-12-13 21:09:39', '2024-12-13 21:09:39'),
(150, 20, -12, 'new', 'ship to amazon', 'Ship to Amazon', '2024-12-13 21:10:23', '2024-12-13 21:10:23'),
(151, 22, -10, 'new', 'ship to amazon', 'Ship to Amazon', '2024-12-13 21:12:11', '2024-12-13 21:12:11'),
(152, 13, -5, 'new', 'ship to amazon', 'Ship to NOON', '2024-12-13 21:13:34', '2024-12-13 21:13:34'),
(153, 14, -5, 'new', 'ship to amazon', 'Ship to NOON', '2024-12-13 21:14:22', '2024-12-13 21:14:22'),
(154, 15, -10, 'new', 'ship to amazon', 'Ship to NOON', '2024-12-13 21:14:50', '2024-12-13 21:14:50'),
(155, 16, -5, 'new', 'ship to amazon', 'Ship to NOON', '2024-12-13 22:22:30', '2024-12-13 22:22:30'),
(156, 19, -5, 'new', 'ship to amazon', 'Ship to NOON', '2024-12-13 22:23:36', '2024-12-13 22:23:36'),
(157, 19, -5, 'new', 'ship to amazon', 'Ship to NOON', '2024-12-13 22:24:01', '2024-12-13 22:24:01'),
(158, 20, -5, 'new', 'ship to amazon', 'Ship to NOON', '2024-12-13 22:24:19', '2024-12-13 22:24:19'),
(159, 24, 1, 'used in good condition', 'add to inventory', 'Get XL sunshade size .... In good condition from Amazon removal', '2024-12-18 12:47:53', '2024-12-18 12:47:53'),
(161, 15, 3, 'new', 'add to inventory', 'Removal order', '2024-12-25 13:29:52', '2024-12-25 13:29:52'),
(162, 24, 2, 'damaged product', 'add to inventory', 'Removal order (1 with condition and the thermostat there is not folded well)', '2025-01-07 15:12:30', '2025-01-07 15:12:30'),
(163, 11, 5, 'new', 'add to inventory', 'Get it from dubai', '2025-01-16 05:40:24', '2025-01-16 05:40:24'),
(164, 13, 10, 'new', 'add to inventory', 'Get it from dubai', '2025-01-16 05:40:59', '2025-01-16 05:40:59'),
(165, 15, 15, 'new', 'add to inventory', 'Get it from dubai', '2025-01-16 05:41:21', '2025-01-16 05:41:21'),
(166, 16, 20, 'new', 'add to inventory', 'Get it from dubai', '2025-01-16 05:41:47', '2025-01-16 05:41:47'),
(167, 20, 15, 'new', 'add to inventory', 'Get it from dubai', '2025-01-16 05:42:21', '2025-01-16 05:42:21'),
(168, 19, 15, 'new', 'add to inventory', 'Get it from dubai', '2025-01-16 05:42:47', '2025-01-16 05:42:47'),
(169, 12, -4, 'new', 'ship to amazon', 'Ship to Amazon', '2025-01-16 05:46:06', '2025-01-16 05:46:06'),
(170, 13, -12, 'new', 'ship to amazon', 'Ship to Amazon', '2025-01-16 05:46:29', '2025-01-16 05:46:29'),
(171, 15, -16, 'new', 'ship to amazon', 'Ship to Amazon', '2025-01-16 05:46:55', '2025-01-16 05:46:55'),
(172, 16, -20, 'new', 'ship to amazon', 'Ship to Amazon', '2025-01-16 05:47:15', '2025-01-16 05:47:15'),
(173, 19, -16, 'new', 'ship to amazon', 'Ship to Amazon', '2025-01-16 05:47:35', '2025-01-16 05:47:35'),
(174, 20, -16, 'new', 'ship to amazon', 'Ship to Amazon', '2025-01-16 05:48:05', '2025-01-16 05:48:05'),
(175, 19, 1, 'new', 'add to inventory', 'Get it from Amazon as a removals... But the bag is a little dirty cause of tape', '2025-01-18 12:11:52', '2025-01-18 12:11:52'),
(176, 14, 1, 'new', 'add to inventory', 'Removal order', '2025-01-30 12:24:32', '2025-01-30 12:24:32'),
(177, 20, 1, 'new', 'add to inventory', 'Removal order', '2025-01-30 12:25:19', '2025-01-30 12:25:19'),
(178, 13, 3, 'new', 'add to inventory', 'Removal order', '2025-01-30 12:25:57', '2025-01-30 12:25:57'),
(179, 15, 1, 'new', 'add to inventory', 'Removal order', '2025-01-30 12:26:27', '2025-01-30 12:26:27'),
(180, 17, 11, 'new', 'add to inventory', 'Removal order', '2025-02-11 17:57:33', '2025-02-11 17:57:33'),
(181, 13, 2, 'new', 'add to inventory', 'Removal order', '2025-02-11 17:57:52', '2025-02-11 17:57:52'),
(182, 16, 6, 'new', 'add to inventory', 'Removal order', '2025-02-11 17:58:08', '2025-02-11 17:58:08'),
(183, 24, 2, 'new', 'add to inventory', 'Removal order XL sunshade', '2025-02-11 17:58:57', '2025-02-11 17:58:57'),
(184, 16, 3, 'new', 'add to inventory', 'Removal order', '2025-02-11 17:59:34', '2025-02-11 17:59:34'),
(185, 24, 17, 'new', 'add to inventory', 'Removal order large sunshades', '2025-02-14 10:36:28', '2025-02-14 10:36:28'),
(186, 16, 3, 'new', 'add to inventory', 'Removal order', '2025-02-14 10:37:03', '2025-02-14 10:37:03'),
(187, 15, 14, 'new', 'add to inventory', 'Removal order', '2025-02-17 05:27:34', '2025-02-17 05:27:34'),
(188, 14, 3, 'new', 'add to inventory', 'Removal order', '2025-02-17 05:28:01', '2025-02-17 05:28:01'),
(189, 13, 3, 'new', 'add to inventory', 'Removal order', '2025-02-17 05:28:29', '2025-02-17 05:28:29'),
(190, 20, 8, 'new', 'add to inventory', 'Removal order', '2025-02-17 05:28:53', '2025-02-17 05:28:53'),
(191, 19, 1, 'new', 'add to inventory', 'Removal order', '2025-02-17 05:29:18', '2025-02-17 05:29:18'),
(192, 17, 1, 'new', 'add to inventory', 'Removal order', '2025-02-17 05:29:38', '2025-02-17 05:29:38'),
(193, 16, 15, 'new', 'add to inventory', 'Removal order', '2025-02-17 05:30:54', '2025-02-17 05:30:54'),
(194, 24, 13, 'new', 'add to inventory', 'XL sunshades removal order', '2025-02-17 05:32:15', '2025-02-17 05:32:15'),
(195, 12, 4, 'new', 'add to inventory', 'Medium sunshades Removal order', '2025-02-17 05:33:00', '2025-02-17 05:33:00'),
(196, 20, 5, 'new', 'add to inventory', 'Removal order', '2025-02-18 12:03:53', '2025-02-18 12:03:53'),
(197, 14, 6, 'new', 'add to inventory', 'Removal order', '2025-02-18 12:04:11', '2025-02-18 12:04:11'),
(198, 13, 2, 'new', 'add to inventory', 'Removal order', '2025-02-18 12:04:25', '2025-02-18 12:05:16'),
(199, 16, 1, 'new', 'add to inventory', 'Removal order', '2025-02-18 12:04:40', '2025-02-18 12:04:40'),
(200, 24, 4, 'new', 'add to inventory', 'Large sunshades removal order', '2025-02-18 12:05:42', '2025-02-18 12:05:42'),
(201, 13, 4, 'new', 'add to inventory', 'Removal order', '2025-02-19 12:44:24', '2025-02-19 12:44:24'),
(202, 20, 3, 'new', 'add to inventory', 'Removal order', '2025-02-19 12:45:05', '2025-02-19 12:45:05'),
(203, 24, 3, 'new', 'add to inventory', '3 large sunshades removal order', '2025-02-19 12:45:47', '2025-02-19 12:45:47'),
(204, 20, 7, 'new', 'add to inventory', 'Removal order', '2025-02-21 11:17:40', '2025-02-21 11:17:40'),
(205, 14, 4, 'new', 'add to inventory', 'Removal order', '2025-02-21 11:18:00', '2025-02-21 11:18:00'),
(206, 21, 100, 'new', 'add to inventory', 'Get from china', '2025-02-24 22:19:39', '2025-02-24 22:19:39'),
(207, 31, 100, 'new', 'add to inventory', 'Get from china', '2025-02-24 22:20:12', '2025-02-24 22:20:12'),
(208, 32, 200, 'new', 'add to inventory', 'Get from china', '2025-02-24 22:24:00', '2025-03-05 17:06:15'),
(209, 33, 100, 'new', 'add to inventory', 'Get from china', '2025-02-24 22:24:30', '2025-03-05 17:06:35'),
(210, 31, -50, 'new', 'ship to amazon', NULL, '2025-03-01 21:36:20', '2025-03-01 21:36:20'),
(211, 21, -50, 'new', 'ship to amazon', NULL, '2025-03-01 21:36:38', '2025-03-01 21:36:38'),
(212, 32, -50, 'new', 'ship to amazon', NULL, '2025-03-01 21:37:09', '2025-03-01 21:37:09'),
(213, 33, -25, 'new', 'ship to amazon', NULL, '2025-03-01 21:37:30', '2025-03-01 21:37:30'),
(214, 14, -8, 'new', 'ship to amazon', NULL, '2025-03-01 21:38:39', '2025-03-01 21:38:39'),
(215, 17, -8, 'new', 'ship to amazon', NULL, '2025-03-01 21:39:00', '2025-03-01 21:39:00'),
(216, 24, -37, 'new', 'ship to amazon', 'Ship to Amazon 22 large sunshades and 15 XL sunshades', '2025-03-01 21:43:31', '2025-03-01 21:43:31'),
(217, 20, 4, 'damaged bag', 'add to inventory', 'Removal order with bad bag conditions', '2025-03-01 21:45:00', '2025-03-01 21:45:00'),
(218, 35, 1, 'damaged product', 'add to inventory', 'Removal order', '2025-03-01 21:50:16', '2025-03-01 21:50:16'),
(219, 12, 1, 'new', 'add to inventory', 'Removal order', '2025-03-05 17:03:48', '2025-03-05 17:03:48'),
(220, 34, 30, 'new', 'add to inventory', 'Removal orders', '2025-03-06 19:55:22', '2025-03-06 19:55:46'),
(221, 15, 1, 'new', 'add to inventory', 'Removal order', '2025-03-11 13:33:50', '2025-03-11 13:33:50'),
(222, 13, 2, 'new', 'add to inventory', 'Removal order', '2025-03-11 13:34:14', '2025-03-11 13:34:14'),
(223, 35, 41, 'new', 'add to inventory', 'Removal order', '2025-03-11 13:34:50', '2025-03-11 13:34:50'),
(224, 30, 10, 'new', 'add to inventory', 'Removal order', '2025-03-11 13:35:28', '2025-03-11 13:35:28'),
(225, 20, 1, 'new', 'add to inventory', 'Removal order', '2025-03-18 18:47:03', '2025-03-18 18:47:03'),
(226, 20, 2, 'new', 'add to inventory', 'Removals', '2025-03-23 10:48:33', '2025-03-23 10:48:33'),
(227, 34, 3, 'new', 'add to inventory', 'Removals', '2025-03-23 10:49:01', '2025-03-23 10:49:01'),
(228, 11, 1, 'without bag', 'add to inventory', 'Removals from noon', '2025-03-23 10:49:34', '2025-03-23 10:49:34'),
(229, 19, 1, 'damaged bag', 'add to inventory', 'Removals from noon', '2025-03-23 10:50:25', '2025-03-23 10:50:25'),
(230, 20, 1, 'damaged bag', 'add to inventory', 'Removals from noon', '2025-03-23 10:50:57', '2025-03-23 10:50:57'),
(231, 12, 7, 'new', 'add to inventory', 'Removal order', '2025-04-09 12:39:22', '2025-04-09 12:39:22'),
(232, 34, 3, 'new', 'add to inventory', 'Removal order', '2025-04-09 12:39:45', '2025-04-09 12:39:45'),
(233, 14, 3, 'new', 'add to inventory', 'Removal order', '2025-04-09 12:40:06', '2025-04-09 12:40:06'),
(234, 13, 1, 'new', 'add to inventory', 'Removal order', '2025-04-09 12:40:24', '2025-04-09 12:40:24'),
(235, 20, 1, 'new', 'add to inventory', 'Removal order', '2025-04-09 12:40:47', '2025-04-09 12:40:47'),
(236, 30, 10, 'new', 'add to inventory', 'Removal order', '2025-04-14 17:50:57', '2025-04-14 17:50:57'),
(237, 11, -5, 'new', 'ship to amazon', 'Ship to noon', '2025-04-14 19:11:57', '2025-04-14 19:11:57'),
(238, 13, -5, 'new', 'ship to amazon', 'Ship to noon', '2025-04-14 19:12:15', '2025-04-14 19:12:15'),
(239, 15, -5, 'new', 'ship to amazon', 'Ship to noon', '2025-04-14 19:12:38', '2025-04-14 19:13:09'),
(240, 19, -5, 'new', 'ship to amazon', 'Ship to noon', '2025-04-14 19:12:57', '2025-04-14 19:12:57'),
(241, 20, -5, 'new', 'ship to amazon', 'Ship to noon', '2025-04-14 19:13:28', '2025-04-14 19:13:28'),
(242, 21, -10, 'new', 'ship to amazon', 'Ship too noon', '2025-04-14 19:13:56', '2025-04-14 19:13:56'),
(243, 31, -10, 'new', 'ship to amazon', 'Ship to noon', '2025-04-14 19:14:20', '2025-04-14 19:14:20'),
(244, 32, -50, 'new', 'ship to amazon', 'Ship to noon', '2025-04-14 19:14:54', '2025-04-14 19:14:54'),
(245, 33, -35, 'new', 'ship to amazon', 'Ship to noon', '2025-04-14 19:15:26', '2025-04-14 19:15:26'),
(246, 31, -20, 'new', 'ship to amazon', NULL, '2025-04-14 19:18:56', '2025-04-14 19:18:56'),
(247, 21, -20, 'new', 'ship to amazon', NULL, '2025-04-14 19:19:11', '2025-04-14 19:19:11'),
(248, 20, -20, 'new', 'ship to amazon', NULL, '2025-04-14 19:19:41', '2025-04-14 19:19:41'),
(249, 16, -20, 'new', 'ship to amazon', NULL, '2025-04-14 19:20:01', '2025-04-14 19:20:01'),
(250, 17, -4, 'new', 'ship to amazon', NULL, '2025-04-14 19:20:26', '2025-04-14 19:20:26'),
(251, 15, -10, 'new', 'ship to amazon', NULL, '2025-04-14 19:20:54', '2025-04-14 19:20:54'),
(252, 14, -10, 'new', 'ship to amazon', NULL, '2025-04-14 19:21:13', '2025-04-14 19:21:13'),
(253, 13, -10, 'new', 'ship to amazon', NULL, '2025-04-14 19:21:34', '2025-04-14 19:21:34'),
(254, 12, -10, 'new', 'ship to amazon', NULL, '2025-04-14 19:21:56', '2025-04-14 19:21:56'),
(255, 32, -100, 'new', 'ship to amazon', NULL, '2025-04-14 19:22:21', '2025-04-14 19:22:21'),
(256, 33, -40, 'new', 'ship to amazon', NULL, '2025-04-14 19:22:46', '2025-04-14 19:22:46'),
(257, 35, -41, 'new', 'ship to amazon', NULL, '2025-04-14 19:24:03', '2025-04-14 19:24:03'),
(258, 34, -36, 'new', 'ship to amazon', NULL, '2025-04-14 19:24:18', '2025-04-14 19:24:18'),
(259, 12, 1, 'new', 'add to inventory', 'Removal order', '2025-04-17 13:52:51', '2025-04-17 13:52:51'),
(260, 30, 1, 'damaged bag', 'add to inventory', 'Removal order', '2025-04-30 13:39:40', '2025-04-30 13:39:40'),
(261, 20, 1, 'damaged bag', 'add to inventory', 'Removal order', '2025-05-04 14:13:22', '2025-05-04 14:13:22'),
(262, 13, -2, 'new', 'ship to amazon', NULL, '2025-06-04 12:25:51', '2025-06-04 12:25:51'),
(263, 15, -7, 'new', 'ship to amazon', NULL, '2025-06-04 12:26:07', '2025-06-04 12:26:07'),
(264, 16, -10, 'new', 'ship to amazon', NULL, '2025-06-04 12:26:21', '2025-06-04 12:26:21'),
(265, 20, -12, 'new', 'ship to amazon', NULL, '2025-06-04 12:26:48', '2025-06-04 12:26:48'),
(266, 19, -7, 'new', 'ship to amazon', 'only we find 5 items in omar house but i put 7 item to make stock 0', '2025-06-04 12:27:11', '2025-06-04 12:28:33'),
(267, 19, -3, 'damaged bag', 'ship to amazon', 'actually I don\'t ship these 3 items .. but i found that is there is no stock in omar\'s house so i have to reset stock to make it 0', '2025-06-04 12:29:07', '2025-06-04 12:30:46'),
(268, 13, 2, 'new', 'add to inventory', 'Removals', '2025-06-18 14:54:44', '2025-06-18 14:54:44'),
(269, 15, 1, 'new', 'add to inventory', 'Removals', '2025-06-18 14:55:02', '2025-06-18 14:55:02'),
(270, 30, 7, 'new', 'add to inventory', 'removals', '2025-06-22 18:18:44', '2025-06-22 18:18:44'),
(271, 19, 1, 'new', 'add to inventory', 'removal and not used from user but(it has glued peper on it\'s bag)', '2025-06-23 14:51:00', '2025-06-23 14:51:00'),
(272, 14, 1, 'new', 'add to inventory', 'Removals', '2025-07-01 23:48:38', '2025-07-01 23:48:38'),
(273, 16, 1, 'new', 'add to inventory', 'Removals', '2025-07-01 23:49:04', '2025-07-01 23:49:04'),
(274, 17, 1, 'new', 'add to inventory', 'Removals', '2025-07-01 23:49:37', '2025-07-01 23:49:37'),
(275, 32, 1, 'new', 'add to inventory', 'Removals', '2025-07-01 23:52:34', '2025-07-01 23:52:34'),
(276, 13, 30, 'new', 'add to inventory', NULL, '2025-07-05 08:37:33', '2025-07-05 08:37:33'),
(277, 14, 15, 'new', 'add to inventory', NULL, '2025-07-05 08:37:52', '2025-07-05 08:37:52'),
(278, 15, 30, 'new', 'add to inventory', NULL, '2025-07-05 08:38:10', '2025-07-05 08:38:10'),
(279, 19, 100, 'new', 'add to inventory', NULL, '2025-07-05 08:38:47', '2025-07-05 08:38:47'),
(280, 16, 60, 'new', 'add to inventory', NULL, '2025-07-05 08:39:08', '2025-07-05 08:39:08'),
(281, 20, 40, 'new', 'add to inventory', NULL, '2025-07-05 08:39:32', '2025-07-05 08:39:32'),
(282, 13, -24, 'new', 'ship to amazon', NULL, '2025-07-05 08:40:23', '2025-07-05 08:40:23'),
(283, 14, -12, 'new', 'ship to amazon', NULL, '2025-07-05 08:40:45', '2025-07-05 08:40:45'),
(284, 15, -24, 'new', 'ship to amazon', NULL, '2025-07-05 08:41:05', '2025-07-05 08:41:05'),
(285, 19, -28, 'new', 'ship to amazon', 'this is not new np >>> it is 4x4 size >>>> cuase it too close to each other I will pack new np in 4x4 bag', '2025-07-05 08:43:21', '2025-07-05 08:44:04'),
(286, 16, -56, 'new', 'ship to amazon', NULL, '2025-07-05 08:43:43', '2025-07-05 08:43:43'),
(287, 19, -64, 'new', 'ship to amazon', NULL, '2025-07-05 08:44:43', '2025-07-05 08:44:43'),
(288, 20, -32, 'new', 'ship to amazon', NULL, '2025-07-05 08:45:08', '2025-07-05 08:45:08'),
(289, 30, 10, 'new', 'add to inventory', 'Removal order', '2025-07-27 06:44:48', '2025-07-27 06:44:48'),
(290, 12, 1, 'damaged bag', 'add to inventory', 'Removal', '2025-08-11 18:55:47', '2025-08-11 18:55:47'),
(291, 19, -4, 'new', 'ship to amazon', 'we have sold these 4 items as 4x4 covers to local user in (14-Aug-2025)', '2025-09-05 19:17:34', '2025-09-05 19:17:34'),
(292, 20, 1, 'damaged bag', 'add to inventory', 'after omar do (jared) for goods in house .. I have to add 1 item to make it equal with the online inventory', '2025-09-05 19:42:26', '2025-09-05 19:42:26'),
(293, 16, 3, 'new', 'add to inventory', 'after omar do (jared) for goods in house .. I have to add 3 items to make it equal with the online inventory', '2025-09-05 19:43:32', '2025-09-05 19:45:26'),
(294, 15, 8, 'new', 'add to inventory', 'after omar do (jared) for goods in house .. I have to add 8 items to make it equal with the online inventory', '2025-09-05 19:44:50', '2025-09-05 19:44:50'),
(295, 14, 1, 'new', 'add to inventory', 'after omar do (jared) for goods in house .. I have to add 1 item to make it equal with the online inventory', '2025-09-05 19:46:35', '2025-09-05 19:46:35'),
(296, 13, -1, 'new', 'ship to amazon', 'after omar do (jared) for goods in house .. I have to remove 1 item to make it equal with the online inventory', '2025-09-05 19:48:09', '2025-09-05 19:48:09'),
(297, 12, -4, 'new', 'ship to amazon', 'after omar do (jared) for goods in house .. I have to remove 4 items to make it equal with the online inventory', '2025-09-05 19:50:47', '2025-09-05 19:50:47'),
(298, 12, -2, 'damaged bag', 'ship to amazon', 'after omar do (jared) for goods in house .. I have to remove 2 items to make it equal with the online inventory', '2025-09-05 19:51:45', '2025-09-05 19:51:45'),
(299, 11, 2, 'new', 'add to inventory', 'after omar do (jared) for goods in house .. I have to add 2 items to make it equal with the online inventory', '2025-09-05 19:52:51', '2025-09-05 19:52:51'),
(300, 19, 2, 'without bag', 'add to inventory', 'after omar do (jared) for goods in house .. I have to add 2 items to make it equal with the online inventory', '2025-09-05 20:02:17', '2025-09-05 20:02:17'),
(301, 16, 1, 'without bag', 'add to inventory', 'after omar do (jared) for goods in house .. I have to add 1 item to make it equal with the online inventory', '2025-09-05 20:02:54', '2025-09-05 20:02:54'),
(302, 15, 1, 'without bag', 'add to inventory', 'the china sample cover(after omar do (jared) for goods in house .. I have to add 1 item to make it equal with the online inventory)', '2025-09-05 20:05:01', '2025-09-05 20:05:01'),
(303, 37, 2, 'new', 'add to inventory', 'after omar do (jared) for goods in house .. I have to add 2 items to make it equal with the online inventory', '2025-09-05 20:13:44', '2025-09-05 20:13:44'),
(304, 30, -12, 'new', 'ship to amazon', 'after omar do (jared) for goods in house .. I have to add 12 items to make it equal with the online inventory', '2025-09-05 20:22:14', '2025-09-05 20:22:14'),
(305, 27, 20, 'new', 'add to inventory', 'after omar do (jared) for goods in house .. I have to add 20 items to make it equal with the online inventory', '2025-09-05 20:25:17', '2025-09-05 20:25:17'),
(306, 34, 10, 'new', 'add to inventory', 'after omar do (jared) for goods in house .. I have to add 10 items to make it equal with the online inventory', '2025-09-05 20:29:28', '2025-09-05 20:29:28'),
(307, 35, 2, 'new', 'add to inventory', 'after omar do (jared) for goods in house .. I have to add 2 items to make it equal with the online inventory', '2025-09-05 20:30:08', '2025-09-05 20:30:08'),
(308, 30, 43, 'new', 'add to inventory', 'removal order', '2025-09-05 20:32:55', '2025-09-05 20:32:55'),
(309, 22, 17, 'new', 'add to inventory', 'after omar do (jared) for goods in house .. I have to add 37 pair (17 of 4 pcs bag) to make it equal with the online inventory', '2025-09-05 20:38:18', '2025-09-05 20:42:39'),
(310, 38, 25, 'new', 'add to inventory', 'after omar do (jared) for goods in house .. I have to add 50 items (which is 25 items of bag has 4 pcs) to make it equal with the online inventory', '2025-09-05 20:42:26', '2025-09-05 20:42:26'),
(311, 19, 80, 'new', 'add to inventory', NULL, '2025-09-09 16:41:07', '2025-09-09 16:41:07'),
(312, 12, 4, 'new', 'add to inventory', NULL, '2025-09-09 16:41:17', '2025-09-09 16:41:17'),
(313, 20, 8, 'new', 'add to inventory', NULL, '2025-09-09 16:41:38', '2025-09-09 16:41:38'),
(314, 16, 12, 'new', 'add to inventory', NULL, '2025-09-09 16:41:48', '2025-09-09 16:41:48'),
(315, 13, 8, 'new', 'add to inventory', NULL, '2025-09-09 16:42:07', '2025-09-09 16:42:07'),
(316, 14, 8, 'new', 'add to inventory', NULL, '2025-09-09 16:42:33', '2025-09-09 16:42:33'),
(317, 20, -15, 'new', 'ship to amazon', 'We ship all items to Amazon except 1 it remains in Omar\'s house (check shipping group for more info)', '2025-09-23 10:39:49', '2025-09-23 10:41:20'),
(318, 20, -7, 'damaged bag', 'ship to amazon', 'We ship it to Amazon after Omar fix them', '2025-09-23 10:42:18', '2025-09-23 10:45:10'),
(319, 11, -2, 'new', 'ship to amazon', 'Ship to noon', '2025-09-23 11:16:29', '2025-09-23 11:16:29'),
(320, 12, -9, 'new', 'ship to amazon', NULL, '2025-09-23 11:19:32', '2025-09-23 11:19:32'),
(321, 13, -15, 'new', 'ship to amazon', NULL, '2025-09-23 11:20:42', '2025-09-23 11:20:42'),
(322, 14, -14, 'new', 'ship to amazon', 'We shipped all items except 1 cover still in Omar house', '2025-09-23 11:21:31', '2025-09-23 11:21:31'),
(323, 15, -15, 'new', 'ship to amazon', NULL, '2025-09-23 11:22:38', '2025-09-23 11:22:38'),
(324, 16, -20, 'new', 'ship to amazon', NULL, '2025-09-23 11:23:08', '2025-09-23 11:23:08'),
(325, 17, -1, 'new', 'ship to amazon', NULL, '2025-09-23 11:23:45', '2025-09-23 11:23:45'),
(326, 19, -85, 'new', 'ship to amazon', NULL, '2025-09-23 11:24:55', '2025-09-23 11:24:55'),
(327, 21, -20, 'new', 'ship to amazon', NULL, '2025-09-23 11:26:11', '2025-09-23 11:26:11'),
(328, 31, -20, 'new', 'ship to amazon', NULL, '2025-09-23 11:27:07', '2025-09-23 11:27:07');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_06_22_232336_create_products_table', 1),
(6, '2024_06_22_232530_create_inventory_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('fenex.shop@gmail.com', '$2y$12$vH0TQgxxc4xXtqC.dGL6r.Gy6qs13LIX0lBwt28brnSlzjRuncBKa', '2024-11-21 08:59:32');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `cost_of_goods` decimal(8,2) NOT NULL,
  `weight` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `photo`, `cost_of_goods`, `weight`, `created_at`, `updated_at`) VALUES
(11, 'Small : 160 x 65 x 47', 'products/tPreRaxKRiQ5Ccgi0yGyTTPXUwFuF4ezMxX39Ttq.jpg', 55.00, 3.70, '2024-06-26 20:51:25', '2024-06-26 22:48:46'),
(12, 'Medium : 170 x 65 x 47', 'products/ivERJsARGagZ3rndkxx2sneWnTKCsOoGxRR5g5f5.jpg', 55.00, 4.10, '2024-06-26 20:51:54', '2024-06-26 22:48:35'),
(13, 'Large : 190 x 70 x 47', 'products/W1KeMNwzaUwtyU8A8ApPhUdFBOPogxC4vHXXZQxT.jpg', 55.00, 4.30, '2024-06-26 20:52:29', '2024-06-26 22:48:26'),
(14, 'XL : 210 x 70 x 47', 'products/pvCZireRnp1E83xIbQ94EoU4ulLsAHwJG6eQJIVE.jpg', 60.00, 4.70, '2024-06-26 20:53:01', '2024-06-26 22:48:15'),
(15, 'XXL : 225 x 80 x 47', 'products/RkLCaCboCu69eouFB9mG0L9QeJZcOvCJAuCxI1lR.jpg', 65.00, 5.60, '2024-06-26 20:53:59', '2024-06-26 22:48:02'),
(16, 'SUV : 195 x 75 x 70', 'products/bKZ9dstGoA0q72WjYREh9AyzSikVTfPWRhYBYvTG.jpg', 70.00, 5.70, '2024-06-26 20:54:56', '2024-06-26 22:47:39'),
(17, '4x4 : 204 x 80 x 60', 'products/FgnlvjGKFesCNbu8L1GbBxR1NSXsfrfRwC3u1FK4.jpg', 90.00, 7.30, '2024-06-26 20:55:41', '2025-07-02 00:29:57'),
(19, 'New N/P : 212 x 78 x 70', 'products/syW05rn8vXQaVXmxiB4jjURpUwy7cCvi2LWdzAoo.jpg', 85.00, 0.00, '2024-06-26 20:57:59', '2024-06-26 21:29:38'),
(20, 'New LC : 232 x 80 x 63', 'products/OBL4VlmlOhiczMJTt7K6nHv7SMAImdfaV7VVnIBw.jpg', 75.00, 6.85, '2024-06-26 20:58:50', '2024-06-26 22:43:47'),
(21, 'Pickup XL : 240 x 87 x 75', 'products/1BzM4i0kyo0BOZAbqhHDL9n3hZIXEr5yghHabMlH.jpg', 143.00, 5.00, '2024-06-26 21:38:31', '2025-07-01 23:54:29'),
(22, 'Carbon Seatbelt (4 pcs in bag)', 'products/lCb7txYLTcXclvjQlbVpDL3JasVlxibRsZfRE5fA.jpg', 10.00, 100.00, '2024-11-02 15:15:38', '2024-11-02 16:10:09'),
(23, 'Car Roof Star Light Project, Jestar Auto Projector Lights USB Flexible Ceiling', 'products/xiDfRyFcshVFWMdSHe7dtvL13XuUgwnNrPrPDrbV.jpg', 4.00, 100.00, '2024-11-02 15:20:15', '2024-11-02 15:20:15'),
(24, 'sunshade (foldable)', 'products/ZxVSqpfCdUSv2sNDeTIFXhOtNy3q9SGaKNi9DSSb.jpg', 6.00, 200.00, '2024-11-02 15:44:02', '2024-11-02 15:44:02'),
(25, 'sunshade (umrella)', 'products/friB6ENbCcwO57ne0owohIWeDK2YIaBnpIMsG7TE.jpg', 14.00, 350.00, '2024-11-02 15:47:30', '2024-11-02 15:47:30'),
(26, 'seatbelt stop alarm(pairs) (Black)', 'products/KUQbWrFdX6cfi63xpjpT41SczPvptqMLmgPuL6Al.jpg', 4.00, 100.00, '2024-11-02 15:53:28', '2024-11-02 16:13:29'),
(27, 'seatbelt stop alarm(pairs) (Grey)', 'products/hefzSK5d5cRaFRpcwDzmhKb93GRKAxc9OezfLabX.jpg', 4.00, 100.00, '2024-11-02 16:13:08', '2024-11-02 16:13:08'),
(28, 'Seats belt pairs (beigh)', 'products/NtgqAEBZ2ZoKQP1CMLL6Mz1oRgWLzrGjd7SOo7C4.jpg', 3.00, 100.00, '2024-12-05 18:07:37', '2024-12-05 18:09:32'),
(29, 'Seats belt pairs (grey)', 'products/OvtPUkao9sTjdsS9nzZOm0SAbsU474lqo5FHBG1e.jpg', 3.00, 100.00, '2024-12-05 18:10:13', '2024-12-05 18:10:13'),
(30, 'Seats belt pairs (black&red)', 'products/wAY4MvahxPbP3sQVZJvbkAX1P0zxfKS8n8adCdIi.jpg', 3.00, 100.00, '2024-12-05 18:11:13', '2024-12-05 18:11:13'),
(31, 'Pickup Large : 220 × 82 × 70', 'products/ir36nmKvisiSJZtJ15HURW4TT2T94e0Lg79Sm7JD.jpg', 128.00, 4.00, '2024-06-26 21:37:31', '2025-07-01 23:54:08'),
(32, 'Long Seatbelt extender pad (Black)', 'products/rt35ye9c3Kdces0Oi6vkalMdQF66CmewcqFZVVtV.jpg', 5.00, 100.00, '2025-02-24 22:17:28', '2025-07-01 23:53:38'),
(33, 'Long Seatbelt extender pad (Beige)', 'products/tE2frs3zWnTK6UgOi2csVvo0Nw5bbE3KOngEI3AI.jpg', 5.00, 108.00, '2025-02-24 22:18:22', '2025-07-01 23:53:49'),
(34, 'Medium sunshade (foldable)', NULL, 6.00, 200.00, '2025-03-01 21:46:15', '2025-03-01 21:46:15'),
(35, 'Large sunshade (foldable)', NULL, 6.50, 200.00, '2025-03-01 21:48:46', '2025-03-01 21:48:46'),
(36, 'XL sunshade (foldable)', NULL, 7.00, 200.00, '2025-03-01 21:49:11', '2025-03-01 21:49:11'),
(37, 'Smartkit cover', 'products/crj8FmJjDQPkvFtzvoaFrwiVBISky92lfT8i27W2.jpg', 50.00, 2.00, '2025-09-05 20:12:08', '2025-09-05 20:13:05'),
(38, 'Carbon Seatbelt dark colour (4 pcs in bag)', 'products/9odyjdWWtxVVy3bwGHt2wM0t8TFBaQVz7ve3sBt4.jpg', 10.00, 100.00, '2025-09-05 20:40:37', '2025-09-05 20:40:51');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Ali', 'ali.jom3h@gmail.com', NULL, '$2y$12$DhYEKSU5p0kSze/DascbjuywM59y5JgVKzADXTrE4ZSzFnXZHnQqm', NULL, '2024-11-20 17:59:50', '2024-11-21 12:40:12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inventory_product_id_foreign` (`product_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

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
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=329;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `inventory_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
