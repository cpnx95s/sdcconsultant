-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 22, 2020 at 12:43 PM
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
-- Database: `cw_sdcconsultant`
--

-- --------------------------------------------------------

--
-- Table structure for table `counter`
--

CREATE TABLE `counter` (
  `DATE` date NOT NULL,
  `IP` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `daily`
--

CREATE TABLE `daily` (
  `DATE` date NOT NULL,
  `NUM` varchar(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tb_about`
--

CREATE TABLE `tb_about` (
  `id` int(11) NOT NULL,
  `detail` text DEFAULT NULL,
  `status` enum('on','off') DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `sort` int(5) DEFAULT NULL,
  `word` varchar(50) NOT NULL,
  `company_name` varchar(50) NOT NULL,
  `image` varchar(50) DEFAULT NULL,
  `short_detail` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_about`
--

INSERT INTO `tb_about` (`id`, `detail`, `status`, `created`, `updated`, `sort`, `word`, `company_name`, `image`, `short_detail`) VALUES
(1, '<p class=\"pb-0\">was founded in April 1989 as a Consultant Company to provide Services in architectural and engineering works, agriculture, aquaculture and agro-industry development. The Company was formed by a group of professional engineers, architects, economists and agriculturists who already had substantial experiences in their fields. The company services range from project identification, feasibility study, planning, design, construction supervision, project management to turn key operation.</p>', 'on', '2020-05-19 09:06:45', '2020-05-21 15:04:24', 1, 'Welcome to', 'S.D.C. Comapany Limited', NULL, 'The main policy of the Company is to fulfill the client\'s needs by providing the right expertise combined with personal service.');

-- --------------------------------------------------------

--
-- Table structure for table `tb_contact`
--

CREATE TABLE `tb_contact` (
  `id` int(11) NOT NULL,
  `address` text DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `line` varchar(50) DEFAULT NULL,
  `image` varchar(50) DEFAULT NULL,
  `map` text DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `sort` int(5) DEFAULT NULL,
  `tel` varchar(200) DEFAULT NULL,
  `fax` varchar(50) DEFAULT NULL,
  `facebook` text DEFAULT NULL,
  `twitter` text DEFAULT NULL,
  `company_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_contact`
--

INSERT INTO `tb_contact` (`id`, `address`, `email`, `line`, `image`, `map`, `created`, `updated`, `sort`, `tel`, `fax`, `facebook`, `twitter`, `company_name`) VALUES
(1, 'Phaholyothin Place Building, 12th Floor, 408/53 Phaholyothin Road, Sam Saen Nai, Phyathai, Bangkok 10400 Thailand', 'sdc.thailand@gmail.com', 'https://line.me/R/ti/p/%40256vmwej', NULL, 'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15499.731100908142!2d100.5463541!3d13.782926!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x2c3d8e00293751db!2sS.D.C.%20Company%20Limited!5e0!3m2!1sth!2sth!4v1584693116749!5m2!1sth!2sth', '2020-05-21 11:27:44', '2020-05-22 11:17:31', 1, '++66 (0) 2278-1896 <br> ++66 (0) 2357-1474 <br> ++66 (0) 2271-3531 <br>', '++66 (0) 2278-4470', 'https://www.facebook.com/ultimatefilmsthailand/', 'https://www.instagram.com/ultimatefilms_official/?hl=th', 'S.D.C. COMPANY LIMITED PROJECT CONSULTANT & MANAGEMENT');

-- --------------------------------------------------------

--
-- Table structure for table `tb_fields_category`
--

CREATE TABLE `tb_fields_category` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `sort` int(5) NOT NULL,
  `status` enum('on','off') NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_fields_category`
--

INSERT INTO `tb_fields_category` (`id`, `name`, `sort`, `status`, `created`, `updated`) VALUES
(1, 'ARCHITECTURAL AND INTERIOR DESIGN', 8, 'on', '2020-05-21 16:25:54', '2020-05-21 16:35:00'),
(2, 'STRUCTURAL AND CIVIL ENGINEERING', 7, 'on', '2020-05-21 16:33:26', '2020-05-21 16:35:00'),
(3, 'MECHANICAL ENGINEERING', 6, 'on', '2020-05-21 16:33:46', '2020-05-21 16:35:00'),
(4, 'ELECTRICAL ENGINEERING', 5, 'on', '2020-05-21 16:34:00', '2020-05-21 16:35:00'),
(5, 'SANITARY AND WATER SUPPLY', 4, 'on', '2020-05-21 16:34:16', '2020-05-21 16:35:00'),
(6, 'AGRICULTURE AND AGRO-INDUSTRY', 3, 'on', '2020-05-21 16:34:28', '2020-05-21 16:35:00'),
(7, 'CONSTRUCTION MANAGEMENT', 2, 'on', '2020-05-21 16:34:41', '2020-05-21 16:35:00'),
(8, 'ENERGY CONSULTING SERVICES', 1, 'on', '2020-05-21 16:35:00', '2020-05-21 16:35:00');

-- --------------------------------------------------------

--
-- Table structure for table `tb_fields_of_specialization`
--

CREATE TABLE `tb_fields_of_specialization` (
  `id` int(11) NOT NULL,
  `_id` int(5) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `list_detail` varchar(50) DEFAULT NULL,
  `status` enum('on','off') DEFAULT NULL,
  `sort` int(5) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_fields_of_specialization`
--

INSERT INTO `tb_fields_of_specialization` (`id`, `_id`, `type`, `name`, `list_detail`, `status`, `sort`, `updated`, `created`) VALUES
(4, 4, NULL, NULL, 'Test', 'on', 8, '2020-05-22 15:19:34', '2020-05-22 14:31:27'),
(5, 6, NULL, NULL, 'ddddddddddก', 'on', 7, '2020-05-22 15:19:34', '2020-05-22 14:34:09'),
(6, 1, NULL, NULL, 'ก', 'on', 6, '2020-05-22 15:19:34', '2020-05-22 14:49:38'),
(7, 2, NULL, NULL, 'ด', 'on', 5, '2020-05-22 15:19:34', '2020-05-22 14:49:46'),
(8, 5, NULL, NULL, 'กกดเ', 'on', 4, '2020-05-22 15:19:34', '2020-05-22 14:50:00'),
(9, 7, NULL, NULL, 'หดหกด', 'on', 3, '2020-05-22 15:19:34', '2020-05-22 14:50:15'),
(10, 8, NULL, NULL, 'หกดหฟก', 'on', 2, '2020-05-22 15:19:34', '2020-05-22 14:50:25'),
(11, 2, NULL, NULL, '6', 'on', 1, '2020-05-22 15:19:34', '2020-05-22 15:19:34');

-- --------------------------------------------------------

--
-- Table structure for table `tb_gallery`
--

CREATE TABLE `tb_gallery` (
  `id` int(11) NOT NULL,
  `_id` int(11) DEFAULT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` smallint(1) DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `updated` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tb_gallery`
--

INSERT INTO `tb_gallery` (`id`, `_id`, `type`, `image`, `status`, `sort`, `created`, `updated`) VALUES
(329, 1, 'about', 'upload/about/gallery/gallery-20052020-164207-0-md.jpeg', NULL, NULL, '2020-05-20 16:42:08', NULL),
(335, 1, 'about', 'upload/about/gallery/gallery-21052020-150424-0-md.jpeg', NULL, NULL, '2020-05-21 15:04:25', NULL),
(336, 2, 'our_experience', 'upload/our_experience/gallery/gallery-22052020-172540-0.jpeg', NULL, NULL, '2020-05-22 17:25:40', NULL),
(337, 2, 'our_experience', 'upload/our_experience/gallery/gallery-22052020-172540-1.jpeg', NULL, NULL, '2020-05-22 17:25:41', NULL),
(338, 2, 'our_experience', 'upload/our_experience/gallery/gallery-22052020-172540-2.jpeg', NULL, NULL, '2020-05-22 17:25:41', NULL),
(339, 1, 'our_experience', 'upload/our_experience/gallery/gallery-22052020-173050-0.jpeg', NULL, NULL, '2020-05-22 17:30:50', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_menu`
--

CREATE TABLE `tb_menu` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_id` bigint(20) DEFAULT NULL,
  `name` char(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `url` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `icon` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `sort` bigint(20) DEFAULT NULL,
  `status` enum('on','off') COLLATE utf8_unicode_ci DEFAULT NULL,
  `position` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tb_menu`
--

INSERT INTO `tb_menu` (`id`, `_id`, `name`, `url`, `icon`, `sort`, `status`, `position`, `created`, `updated`, `deleted`) VALUES
(5, 4, 'ประเภทสินค้าเช่า / Category Rental', '/categoryrental', NULL, NULL, 'on', 'secondary', '2020-04-23 02:56:34', '2020-04-23 02:56:34', NULL),
(14, 13, 'งานติดตั้งกระจกอลูมิเนียม', '/service01', NULL, NULL, 'on', 'secondary', '2020-05-11 10:28:30', '2020-05-11 10:28:30', NULL),
(15, 13, 'งานก่อสร้างครบวงจร', '/service02', NULL, NULL, 'on', 'secondary', '2020-05-11 10:29:12', '2020-05-11 10:29:12', NULL),
(20, 19, 'บริษัท / Company', '/about/1', NULL, NULL, 'on', 'secondary', '2020-05-12 19:44:08', '2020-05-12 19:44:08', NULL),
(21, 19, 'วิสัยทัศน์ / Vision', '/about/2', NULL, NULL, 'on', 'secondary', '2020-05-12 19:44:39', '2020-05-12 19:44:39', NULL),
(22, 19, 'นโยบาย / Policy', '/about/3', NULL, NULL, 'on', 'secondary', '2020-05-12 19:45:07', '2020-05-12 19:45:07', NULL),
(24, 23, 'ตั้งค่า / Option', '/ourcustomer_option/4', NULL, NULL, 'on', 'secondary', '2020-05-14 17:01:34', '2020-05-14 17:04:59', NULL),
(25, 23, 'ลูกค้า / Customer', '/ourcustomer', NULL, NULL, 'on', 'secondary', '2020-05-14 17:02:07', '2020-05-14 17:02:07', NULL),
(32, NULL, 'About Us', '/about/1', 'fa fa-building', NULL, 'on', 'main', '2020-05-20 15:41:25', '2020-05-21 13:02:59', NULL),
(33, NULL, 'Fields of Specialization', '/fields_of_specialization', 'fa fa-toolbox', NULL, 'on', 'main', '2020-05-20 15:42:29', '2020-05-20 15:42:29', NULL),
(34, NULL, 'Services', '/services', 'fa fa-hard-hat', NULL, 'on', 'main', '2020-05-20 15:43:54', '2020-05-20 15:43:54', NULL),
(35, NULL, 'Our experience', '/our_experience', 'fa fa-brain', NULL, 'on', 'main', '2020-05-20 15:44:54', '2020-05-20 15:44:54', NULL),
(36, NULL, 'Contact Us', '/contact/1', 'fa fa-map-marked-alt', NULL, 'on', 'main', '2020-05-20 15:47:22', '2020-05-21 11:51:18', NULL),
(37, NULL, 'Silde', '/slide', 'fa fa-images', NULL, 'on', 'main', '2020-05-21 13:58:11', '2020-05-21 13:58:11', NULL),
(38, 33, 'Category', '/fields_category', NULL, NULL, 'on', 'secondary', '2020-05-21 15:27:25', '2020-05-21 15:27:25', NULL),
(39, 33, 'List item', '/fields_of_specialization', NULL, NULL, 'on', 'secondary', '2020-05-21 15:28:34', '2020-05-21 15:28:34', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_our_experience`
--

CREATE TABLE `tb_our_experience` (
  `id` int(11) NOT NULL,
  `image` varchar(50) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `short_detail` varchar(50) DEFAULT NULL,
  `detail` text DEFAULT NULL,
  `location` varchar(50) DEFAULT NULL,
  `project_owner` varchar(50) DEFAULT NULL,
  `duration_s` date DEFAULT NULL,
  `duration_f` date NOT NULL,
  `status` enum('on','off') DEFAULT NULL,
  `sort` int(5) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_our_experience`
--

INSERT INTO `tb_our_experience` (`id`, `image`, `name`, `short_detail`, `detail`, `location`, `project_owner`, `duration_s`, `duration_f`, `status`, `sort`, `created`, `updated`) VALUES
(1, 'upload/our_experience/22052020-105833-.jpeg', 'หกดเเเเเเเ', 'ดกเเเเเเเเเเเเ', 'ดฟดฟดฟดฟดฟดฟดฟดฟดฟดฟดฟดฟดฟดฟ', 'กหดเดเดเดเดเดเดเดเ', 'กดเดเดเดเดเดเดเดเดเ', '2020-05-06', '2020-05-27', 'on', 2, '2020-05-22 10:37:09', '2020-05-22 17:30:50'),
(2, 'upload/our_experience/22052020-105822-.jpeg', 'sdfdf', 'sdfs', 'sfdfdsfdfdfffffffffffd', 'dsfd', 'fsdfds', '2020-05-25', '2020-05-24', 'on', 1, '2020-05-22 10:51:11', '2020-05-22 17:30:35');

-- --------------------------------------------------------

--
-- Table structure for table `tb_services`
--

CREATE TABLE `tb_services` (
  `id` int(11) NOT NULL,
  `list_detail` text DEFAULT NULL,
  `image` varchar(50) DEFAULT NULL,
  `status` enum('on','off') DEFAULT NULL,
  `sort` int(5) NOT NULL,
  `updated` datetime NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_services`
--

INSERT INTO `tb_services` (`id`, `list_detail`, `image`, `status`, `sort`, `updated`, `created`) VALUES
(1, 'sdfsdfgdfgsdfgdfgdsfg', 'upload/services/21052020-133700-.jpeg', 'on', 1, '2020-05-22 15:42:49', '2020-05-21 10:09:57');

-- --------------------------------------------------------

--
-- Table structure for table `tb_slide`
--

CREATE TABLE `tb_slide` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `image` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sort` bigint(20) DEFAULT NULL,
  `status` enum('on','off') COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tb_slide`
--

INSERT INTO `tb_slide` (`id`, `image`, `name`, `sort`, `status`, `created`, `updated`, `deleted`) VALUES
(7, 'upload/slide/slide_12052020-160751.jpeg', 'Test', 1, 'on', '0020-05-12 16:07:52', '2020-05-12 16:08:30', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role` char(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `status`, `last_login`, `created_at`, `updated_at`) VALUES
(3, 'admin', 'คุณไมค์', 'pipat.pimnont@gmail.com', NULL, '$2y$12$33MMPDhHphL4L9Q9gXoMPuTHVdQ5YV/CS3pADcvuHyEM7exUG5ZjW', NULL, 'active', NULL, '2020-02-04 01:04:15', '2020-02-04 01:04:15'),
(4, 'admin', 'Administrator', 'Administrator', NULL, '$2y$12$CudP2XCRo9mfnLD0Ur7c.uxFuAh.LBw4bPpW9zwmLLWIt2GaCyETO', NULL, 'active', NULL, '2020-05-13 17:00:00', '2020-05-13 17:00:00'),
(5, 'admin', 'bow', 'titiwan', NULL, '$2y$10$MfG9d2M6PxsNxIUcYteYQOO/5Toxupy.mParSDdaS6qrcnyMPUX3S', NULL, 'active', NULL, '2020-05-18 06:55:32', '2020-05-18 06:55:32');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_about`
--
ALTER TABLE `tb_about`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_contact`
--
ALTER TABLE `tb_contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_fields_category`
--
ALTER TABLE `tb_fields_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_fields_of_specialization`
--
ALTER TABLE `tb_fields_of_specialization`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_gallery`
--
ALTER TABLE `tb_gallery`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `tb_menu`
--
ALTER TABLE `tb_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_our_experience`
--
ALTER TABLE `tb_our_experience`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_services`
--
ALTER TABLE `tb_services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_slide`
--
ALTER TABLE `tb_slide`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_about`
--
ALTER TABLE `tb_about`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tb_contact`
--
ALTER TABLE `tb_contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tb_fields_category`
--
ALTER TABLE `tb_fields_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tb_fields_of_specialization`
--
ALTER TABLE `tb_fields_of_specialization`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tb_gallery`
--
ALTER TABLE `tb_gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=340;

--
-- AUTO_INCREMENT for table `tb_menu`
--
ALTER TABLE `tb_menu`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `tb_our_experience`
--
ALTER TABLE `tb_our_experience`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_services`
--
ALTER TABLE `tb_services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tb_slide`
--
ALTER TABLE `tb_slide`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
