-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 27, 2020 at 03:15 PM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mtzdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `mtz_categories`
--

CREATE TABLE `mtz_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `q1_min` double(8,2) DEFAULT NULL,
  `q1_max` double(8,2) DEFAULT NULL,
  `q2_min` double(8,2) DEFAULT NULL,
  `q2_max` double(8,2) DEFAULT NULL,
  `q3_min` double(8,2) DEFAULT NULL,
  `q3_max` double(8,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mtz_categories`
--

INSERT INTO `mtz_categories` (`id`, `title`, `q1_min`, `q1_max`, `q2_min`, `q2_max`, `q3_min`, `q3_max`, `created_at`, `updated_at`) VALUES
(1, 'Apple Pie', 6.00, 8.00, 9.00, 15.00, 15.00, 25.00, '2020-02-21 06:48:09', '2020-02-21 06:48:12'),
(2, 'Cup Cake', 6.00, 8.00, 10.00, 16.00, 16.00, 30.00, '2020-02-21 06:51:14', '2020-02-21 06:51:17'),
(3, 'Donut', 7.00, 9.00, 12.00, 15.00, 16.00, 25.00, '2020-02-21 06:51:35', '2020-02-21 06:51:37'),
(4, 'Eclair', 8.00, 10.00, 10.00, 16.00, 17.00, 27.00, '2020-02-21 06:52:01', '2020-02-21 06:52:03'),
(5, 'Froyo', 7.00, 9.00, 10.00, 15.00, 16.00, 25.00, '2020-02-21 06:52:24', '2020-02-21 06:52:28'),
(6, 'GingerBread', 6.00, 9.00, 10.00, 15.00, 15.00, 26.00, '2020-02-21 06:52:47', '2020-02-21 06:52:49'),
(7, 'HoneyComb', 7.00, 10.00, 11.00, 16.00, 16.00, 27.00, '2020-02-21 06:53:04', '2020-02-21 06:53:06'),
(8, 'Ice Cream Sandwich', 6.00, 9.00, 10.00, 15.00, 16.00, 30.00, '2020-02-21 06:53:21', '2020-02-21 06:53:24'),
(9, 'Jellybean', 6.00, 10.00, 11.00, 16.00, 16.00, 24.00, '2020-02-21 06:53:39', '2020-02-21 06:53:42'),
(10, 'Kitkat', 7.00, 10.00, 11.00, 17.00, 17.00, 25.00, '2020-02-21 06:53:57', '2020-02-21 06:54:00'),
(11, 'Lollipop', 7.00, 10.00, 10.00, 15.00, 16.00, 24.00, '2020-02-21 06:54:15', '2020-02-21 06:54:18'),
(12, 'Marshmallow', 8.00, 11.00, 12.00, 16.00, 17.00, 25.00, '2020-02-21 06:54:32', '2020-02-21 06:54:37'),
(13, 'Nougat', 6.00, 10.00, 11.00, 14.00, 15.00, 23.00, '2020-02-21 06:54:52', '2020-02-21 06:54:55'),
(14, 'Oreo', 5.00, 8.00, 9.00, 13.00, 14.00, 20.00, '2020-02-21 06:55:10', '2020-02-21 06:55:13');

-- --------------------------------------------------------

--
-- Table structure for table `mtz_failed_jobs`
--

CREATE TABLE `mtz_failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mtz_migrations`
--

CREATE TABLE `mtz_migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mtz_migrations`
--

INSERT INTO `mtz_migrations` (`id`, `migration`, `batch`) VALUES
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2014_10_12_000000_create_users_table', 2),
(5, '2020_02_20_114941_create_projects_table', 3),
(6, '2020_02_21_002609_create_categories_table', 3),
(9, '2020_02_21_002728_create_wallets_table', 4),
(10, '2020_02_21_002751_create_transactions_table', 4),
(12, '2020_02_25_140759_create_settings_table', 5),
(13, '2020_02_24_075517_create_sells_table', 6);

-- --------------------------------------------------------

--
-- Table structure for table `mtz_password_resets`
--

CREATE TABLE `mtz_password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mtz_projects`
--

CREATE TABLE `mtz_projects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `userId` bigint(20) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `min_chars` int(11) NOT NULL,
  `rate` double(8,2) NOT NULL,
  `cp_write_title` tinyint(4) NOT NULL DEFAULT 0,
  `cp_bold_keyword` tinyint(4) NOT NULL DEFAULT 0,
  `payment_method` enum('PayU','wallet') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'PayU',
  `categoryId` int(11) NOT NULL,
  `quality` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'q1_min',
  `status` enum('sketch','open','finish','cancel','pending','accepted') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'open',
  `sellerId` bigint(20) DEFAULT NULL COMMENT 'the id of freelancer who accept the project',
  `budget` double(8,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mtz_projects`
--

INSERT INTO `mtz_projects` (`id`, `userId`, `title`, `description`, `min_chars`, `rate`, `cp_write_title`, `cp_bold_keyword`, `payment_method`, `categoryId`, `quality`, `status`, `sellerId`, `budget`, `created_at`, `updated_at`) VALUES
(1, 2, 'First Order', 'order description', 2000, 10.00, 0, 0, 'wallet', 3, 'q1', 'sketch', NULL, 14.00, '2020-02-21 06:24:40', '2020-02-21 06:24:40'),
(2, 2, 'Second Order', 'Order Descripion', 3000, 15.00, 0, 0, 'PayU', 5, 'q2', 'cancel', NULL, 30.00, '2020-02-21 06:26:06', '2020-02-21 08:39:51'),
(3, 2, 'Third Project', 'Project description', 3000, 6.00, 1, 0, 'wallet', 4, 'q3', 'sketch', NULL, 51.00, '2020-02-21 08:41:30', '2020-02-21 08:41:30'),
(4, 2, 'dsfsdfss', 'sdfsdf', 32342, 10.00, 0, 0, 'wallet', 1, 'q1_min', 'pending', 4, 110706.67, '2020-02-21 12:01:09', '2020-02-24 06:54:31'),
(5, 2, 'order4', 'sdfsdfsdf', 3423423, 5.00, 0, 0, 'PayU', 1, 'q1_min', 'sketch', NULL, 17117.12, '2020-02-21 12:06:34', '2020-02-21 12:06:34'),
(7, 2, 'Writing Article', 'I need great article with more than 500 words.', 3000, 5.00, 0, 0, 'wallet', 1, '', 'sketch', NULL, 15.00, '2020-02-22 06:38:24', '2020-02-22 06:38:24');

-- --------------------------------------------------------

--
-- Table structure for table `mtz_sells`
--

CREATE TABLE `mtz_sells` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `userId` bigint(20) NOT NULL,
  `status` enum('open','finish','cancel','pending') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `rate` double(8,2) NOT NULL COMMENT 'price per 1000 zzs',
  `nChars` bigint(20) DEFAULT 0,
  `budget` double(8,2) NOT NULL DEFAULT 0.00,
  `categoryId` int(10) NOT NULL,
  `buyerId` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mtz_sells`
--

INSERT INTO `mtz_sells` (`id`, `userId`, `status`, `text`, `rate`, `nChars`, `budget`, `categoryId`, `buyerId`, `created_at`, `updated_at`) VALUES
(4, 4, 'open', '<p style=\"margin-top: 0px; margin-bottom: 10px; color: #000000; font-family: \'Open Sans\', sans-serif; font-size: 16px; text-align: justify; background-color: #ffffff;\"><span style=\"font-weight: bold;\">II. SOLUTION</span></p>\n<blockquote style=\"padding: 10px 20px; margin-bottom: 20px; font-size: 17.5px; border-left: 5px solid #eeeeee; color: #000000; font-family: \'Open Sans\', sans-serif; text-align: justify; background-color: #ffffff;\">\n<p style=\"margin-top: 0px; margin-bottom: 10px;\">EPOXYCOAT-AC antirust epoxy primer is applied for active anti-corrosive and anti-rust protection of iron and steel surfaces that are to be coated with EPOXYCOAT or DUROFLOOR epoxy systems.</p>\n<p style=\"margin-top: 0px; margin-bottom: 10px;\">It is extremely hard and resistant to friction. It is particularly resistant to diluted acids, alkalis, petroleum products, to some solvents, water, sea water etc.</p>\n<p style=\"margin-top: 0px; margin-bottom: 0px;\">It can even be used as a coating on its own if its reddish-brown or grey color is satisfactory. Typical examples of use are the protection of silos, steel bridges, iron roofs, pipes, fences etc.</p>\n</blockquote>\n<p style=\"margin-top: 0px; margin-bottom: 10px; color: #000000; font-family: \'Open Sans\', sans-serif; font-size: 16px; text-align: justify; background-color: #ffffff;\">&nbsp;</p>\n<p style=\"margin-top: 0px; margin-bottom: 10px; color: #000000; font-family: \'Open Sans\', sans-serif; font-size: 16px; text-align: justify; background-color: #ffffff;\"><span style=\"font-weight: bold;\">III.&nbsp;APPLICATION</span><br />&nbsp;</p>\n<blockquote style=\"padding: 10px 20px; margin-bottom: 20px; font-size: 17.5px; border-left: 5px solid #eeeeee; color: #000000; font-family: \'Open Sans\', sans-serif; text-align: justify; background-color: #ffffff;\">\n<p style=\"margin-top: 0px; margin-bottom: 10px;\"><span style=\"font-weight: bold;\">&nbsp;Substrate preparation</span></p>\n<ol style=\"margin-bottom: 10px;\">\n<li>\n<p style=\"margin-top: 0px; margin-bottom: 0px;\">The substrate must be dry, stable and free of anything which would hinder bonding, such as dust, loose particles, grease, rust or&nbsp;any kind of corrosion.</p>\n</li>\n<li>\n<p style=\"margin-top: 0px; margin-bottom: 0px;\">Depending on the nature of the substrate, it should be prepaired by brushing, rubbing down, sand blasting, etc. and then thoroughly cleaned from dust.</p>\n</li>\n</ol>\n<p style=\"margin-top: 0px; margin-bottom: 10px;\">&nbsp;</p>\n<p style=\"margin-top: 0px; margin-bottom: 10px;\"><span style=\"font-weight: bold;\">Application of EPOXYCOAT-AC</span></p>\n<ol style=\"margin-bottom: 0px;\">\n<li>\n<p style=\"margin-top: 0px; margin-bottom: 0px;\">Components A (resin) and B (hardener) are packed in two separate containers, having the correct predetermined mixing proportion by weight. The whole quantity of component B is added into component A. Mixing of the 2 components should take place for about 5 minutes, using a low revolution mixer (300 rpm). It is important to stir the mixture thoroughly near the sides and bottom of the container, to achieve uniform dispersion of the hardener.<br />To prime the surface, 2 coats of EPOXYCOAT-AC are applied with brush, roller or spray gun. The second coat is applied once the first one is dry, but within 24 hours.<br />Consumption: 150-200 g/m<span style=\"position: relative; font-size: 13.125px; line-height: 0; vertical-align: baseline; top: -0.5em;\">2</span>&nbsp;per coat.</p>\n</li>\n<li>\n<p style=\"margin-top: 0px; margin-bottom: 0px;\">Subsequently, in the next 24 hours and after the primer is completely dry, application of the chosen EPOXYCOAT or DUROFLOOR system can take place. If alternatively, EPOXYCOAT-AC is to be used as the final finish, 2 more coats of it should be additionally applied. The second coat follows after the first one is completely dry, but within 24 hours.</p>\n</li>\n</ol>\n</blockquote>\n<p style=\"margin-top: 0px; margin-bottom: 10px; color: #000000; font-family: \'Open Sans\', sans-serif; font-size: 16px; text-align: justify; background-color: #ffffff;\">&nbsp;</p>', 26.00, 1947, 50.00, 3, NULL, '2020-02-25 08:32:19', '2020-02-25 08:32:19');

-- --------------------------------------------------------

--
-- Table structure for table `mtz_settings`
--

CREATE TABLE `mtz_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fee` double(8,2) NOT NULL DEFAULT 15.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mtz_settings`
--

INSERT INTO `mtz_settings` (`id`, `fee`, `created_at`, `updated_at`) VALUES
(1, 15.00, '2020-02-25 14:11:03', '2020-02-25 14:11:07');

-- --------------------------------------------------------

--
-- Table structure for table `mtz_transactions`
--

CREATE TABLE `mtz_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `userId` int(11) NOT NULL,
  `qty` double(8,2) NOT NULL,
  `source` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` enum('deposit','withdrawal','order','buy','sell') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mtz_transactions`
--

INSERT INTO `mtz_transactions` (`id`, `userId`, `qty`, `source`, `type`, `created_at`, `updated_at`) VALUES
(1, 2, 1100.00, 'liguo.payu@gmail.com', 'deposit', '2020-02-24 03:42:59', '2020-02-24 03:42:59');

-- --------------------------------------------------------

--
-- Table structure for table `mtz_users`
--

CREATE TABLE `mtz_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fullname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `userType` enum('client','copywriter','freelancer','admin') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'client',
  `isCompany` tinyint(4) NOT NULL DEFAULT 0,
  `companyName` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `NIP` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `other_text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','pending','reject') COLLATE utf8mb4_unicode_ci DEFAULT 'pending',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mtz_users`
--

INSERT INTO `mtz_users` (`id`, `avatar`, `fullname`, `name`, `email`, `email_verified_at`, `password`, `userType`, `isCompany`, `companyName`, `NIP`, `address`, `address_2`, `city`, `zip`, `other_text`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, 'Admin', 'admin@gmail.com', NULL, '$2y$10$1teuPAO/xOv8u3ZBkwAby.MXvM7wlHud0PH9nxH5MxY0hS3tLj66S', 'admin', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', NULL, '2020-02-17 18:59:46', '2020-02-17 18:59:46'),
(2, 'upload\\user-2.jpg', 'Liguo Ma', 'ClientLiguo', 'client.liguo@gmail.com', NULL, '$2y$10$5zUZL/PimgSqj7BQmiXFXuVzQp5FlMcSkenOKvIN4cHTohdOkTSv2', 'client', 0, NULL, NULL, 'China Dandong', 'Donggang Jiaoyubingguan', NULL, NULL, NULL, 'pending', NULL, '2020-02-21 15:36:32', '2020-02-24 10:06:59'),
(4, 'upload\\user-11.jpg', NULL, 'CopywriterUser1', 'copywriter1@gmail.com', NULL, '$2y$10$Y3jZvNSABt1NlyeoGs9RNO/xmfD76kxnM2SOIX8PR8X/tkO6CT9oe', 'copywriter', 0, NULL, NULL, NULL, NULL, NULL, NULL, 'I want to work in this system as a copywriter', 'pending', NULL, '2020-02-21 09:04:23', '2020-02-24 10:59:47');

-- --------------------------------------------------------

--
-- Table structure for table `mtz_wallets`
--

CREATE TABLE `mtz_wallets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `userId` int(11) NOT NULL,
  `source` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_balance` double(8,2) DEFAULT NULL,
  `credit_balance` double(8,2) NOT NULL DEFAULT 0.00,
  `bonus_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bonus` double(8,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mtz_wallets`
--

INSERT INTO `mtz_wallets` (`id`, `userId`, `source`, `total_balance`, `credit_balance`, `bonus_code`, `bonus`, `created_at`, `updated_at`) VALUES
(1, 2, NULL, 1100.00, 0.00, NULL, 0.00, '2020-02-24 03:42:59', '2020-02-24 03:42:59');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mtz_categories`
--
ALTER TABLE `mtz_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mtz_failed_jobs`
--
ALTER TABLE `mtz_failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mtz_migrations`
--
ALTER TABLE `mtz_migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mtz_password_resets`
--
ALTER TABLE `mtz_password_resets`
  ADD KEY `mtz_password_resets_email_index` (`email`);

--
-- Indexes for table `mtz_projects`
--
ALTER TABLE `mtz_projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mtz_sells`
--
ALTER TABLE `mtz_sells`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mtz_settings`
--
ALTER TABLE `mtz_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mtz_transactions`
--
ALTER TABLE `mtz_transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mtz_users`
--
ALTER TABLE `mtz_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mtz_users_email_unique` (`email`);

--
-- Indexes for table `mtz_wallets`
--
ALTER TABLE `mtz_wallets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mtz_wallets_userid_unique` (`userId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mtz_categories`
--
ALTER TABLE `mtz_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `mtz_failed_jobs`
--
ALTER TABLE `mtz_failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mtz_migrations`
--
ALTER TABLE `mtz_migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `mtz_projects`
--
ALTER TABLE `mtz_projects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `mtz_sells`
--
ALTER TABLE `mtz_sells`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `mtz_settings`
--
ALTER TABLE `mtz_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `mtz_transactions`
--
ALTER TABLE `mtz_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `mtz_users`
--
ALTER TABLE `mtz_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `mtz_wallets`
--
ALTER TABLE `mtz_wallets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
