-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 19, 2020 at 12:36 PM
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
-- Database: `cwco55_bcit`
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
  `image` varchar(50) DEFAULT NULL,
  `status` enum('on','off') DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `sort` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_about`
--

INSERT INTO `tb_about` (`id`, `detail`, `image`, `status`, `created`, `updated`, `sort`) VALUES
(1, '<p class=\"pb-0\">BCIT : Provide = Costdown (VE)</p>\r\n<p>BCIT คือตัวแทนเพื่อการจัดหาชิ้นส่วน วัตถุดิบ ด้วยทีมงานที่ประสบการณ์ที่มากกว่า 30 ปี สามารถให้คำปรึกษาหัวข้อหรือการปรับปรุง สำหรับการลดต้นทุนของชิ้นส่วนวัตถุดิบ ซึ่งยังคงคุณภาพ และการจัดส่งตามที่ลูกค้ากำหนด เสนอราคาที่ถูก เพื่อตอบสนองเป้าหมายผลกำไรของธุรกิจ ของคุณ</p>\r\n<p class=\"pb-0\">BCIT : ผู้รับซื้อที่ให้ราคาสูงสุด</p>\r\n<p>BCIT เป็นกลุ่มที่มีผู้รับซื้อเศษเหล็กทุกประเภทให้ราคาสูง เราเป็นผู้จัดส่งโดยตรงถึงโรงหลอม มีเอกสารครบตามกฎหมายกำหนด สามารถเสนอราคาที่สูง และสามารถกำหนดราคาซื้อ โดยใช้สูตรที่อ้างอิงจากจากต้นน้ำ(LME Billet) ได้อีกด้วย</p>\r\n<p class=\"pb-0\">BCIT : มีความชำนาญการแปลภาษาญี่ปุ่น-ไทย,ไทย-ญี่ปุ่น</p>\r\n<p>BCIT มีผู้แปลภาษาที่มีประสบการณ์กับกลุ่มอุตสาหรรมโดยตรง กว่า 25ปีที่คลุกคลีกับการแปลผลิตภัณฑ์เครื่องใช้ไฟฟ้า และเครืองจักรหลายประเภท สามารถรับแปลจากเอกสาร และรับแปลโดยตรงที่บริษัทคุณ</p>\r\n<p class=\"mb-5\">BCIT : รับจัดหาสินค้าจากจีน หลากหลายสินค้าที่ปัจจุบันเที่จัดหาให้แล้วหลายๆ บริษัทในกลุ่มบริษัทเครื่องใช้ไฟฟ้า เรามีโกดังเพื่อรองรับจัดเก็บสินค้าที่มีการสั่งซื้ออย่างต่อเนื่อง ไว้ใจเราในการดูแล ให้กับบริษัทของคุณทั้งคุณภาพสินค้า และราคาที่ถูก</p>', NULL, 'on', '2020-05-19 09:06:45', '2020-05-19 17:01:30', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_category`
--

CREATE TABLE `tb_category` (
  `id` int(11) NOT NULL,
  `_id` int(11) DEFAULT NULL,
  `position` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name_th` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `name_en` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `caption_th` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `caption_en` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `detail_th` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `detail_en` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `status` enum('on','off') COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `updated` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_contact`
--

CREATE TABLE `tb_contact` (
  `id` int(11) NOT NULL,
  `address` text DEFAULT NULL,
  `hotline` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `line_id` varchar(50) DEFAULT NULL,
  `image` varchar(50) DEFAULT NULL,
  `map` text DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `sort` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_contact`
--

INSERT INTO `tb_contact` (`id`, `address`, `hotline`, `email`, `line_id`, `image`, `map`, `created`, `updated`, `sort`) VALUES
(1, 'บริษัท เบสท์เซอเคิล อินเตอร์เทรด จำกัด 1606 ซอยสุขุมวิท 101/1 บางจาก กรุงเทพมหานคร5', '081-702-6796 , 092-2725480', 'bcit2011@gmail.com', '@bcit', 'upload/contact/19052020-165054-.png', 'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d124036.25464258561!2d100.43049305879457!3d13.71039614420906!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x5480f75fcf67cfdb!2sGoogle+Thailand!5e0!3m2!1sth!2sth!4v1550117760252', '2020-05-19 12:01:49', '2020-05-19 17:18:40', 1);

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
(323, 6, 'about', 'upload/about/gallery/gallery-18052020-161917-0-md.jpeg', NULL, NULL, '2020-05-18 16:19:17', NULL),
(324, 7, 'about', 'upload/about/gallery/gallery-18052020-161947-0-md.jpeg', NULL, NULL, '2020-05-18 16:19:47', NULL),
(325, 8, 'about', 'upload/about/gallery/gallery-19052020-090645-0-md.jpeg', NULL, NULL, '2020-05-19 09:06:46', NULL),
(326, 1, 'information', 'upload/information/gallery/gallery-19052020-094710-0.jpeg', NULL, NULL, '2020-05-19 09:47:11', NULL),
(327, 1, 'portfolio', 'upload/portfolio/gallery/gallery-19052020-132147-0-md.jpeg', NULL, NULL, '2020-05-19 13:21:47', NULL),
(328, 1, 'portfolio', 'upload/portfolio/gallery/gallery-19052020-132147-1-md.jpeg', NULL, NULL, '2020-05-19 13:21:47', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_information`
--

CREATE TABLE `tb_information` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `image` varchar(50) DEFAULT NULL,
  `short_detail` varchar(50) DEFAULT NULL,
  `detail` text DEFAULT NULL,
  `status` enum('on','off') DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `sort` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_information`
--

INSERT INTO `tb_information` (`id`, `name`, `image`, `short_detail`, `detail`, `status`, `created`, `updated`, `sort`) VALUES
(1, 'sdf7777', 'upload/information/19052020-094710-.png', 'sdflsgkdf;gl', 'sdfasaasdfaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 'on', '2020-05-19 09:47:10', '2020-05-19 09:47:44', 1);

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
(27, NULL, 'บริการ / Service', '/service', 'fa fa-list', NULL, 'on', 'main', '2020-05-18 13:57:22', '2020-05-18 13:57:22', NULL),
(28, NULL, 'ผลงาน / Portfolio', '/portfolio', 'fa fa-file', NULL, 'on', 'main', '2020-05-18 14:16:44', '2020-05-18 14:16:44', NULL),
(29, NULL, 'เกี่ยวกับบริษัท / About', '/about/1', 'fa fa-building', NULL, 'on', 'main', '2020-05-18 15:27:40', '2020-05-19 13:05:50', NULL),
(30, NULL, 'ติดต่อเรา / Contact', '/contact/1', 'fa fa-phone-volume', NULL, 'on', 'main', '2020-05-18 16:31:04', '2020-05-19 13:02:37', NULL),
(31, NULL, 'ข้อมูลอื่นๆ / Information', '/information', 'fa fa-folder-open', NULL, 'on', 'main', '2020-05-18 17:19:31', '2020-05-18 17:19:31', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_portfolio`
--

CREATE TABLE `tb_portfolio` (
  `id` int(11) NOT NULL,
  `image` varchar(50) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `detail` text DEFAULT NULL,
  `status` enum('on','off') DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `sort` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_portfolio`
--

INSERT INTO `tb_portfolio` (`id`, `image`, `name`, `detail`, `status`, `created`, `updated`, `sort`) VALUES
(1, 'upload/portfolio/19052020-144803-.jpeg', 'dsaddfds', 'eeekdsssssssssssssssss', 'on', '2020-05-18 15:14:19', '2020-05-19 14:48:38', 2),
(2, 'upload/portfolio/19052020-144838-.jpeg', 'sssssssssssss', 'sssssssssss', 'on', '2020-05-19 14:48:38', '2020-05-19 14:48:38', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_service`
--

CREATE TABLE `tb_service` (
  `id` int(11) NOT NULL,
  `image` varchar(50) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `short_detail` varchar(50) DEFAULT NULL,
  `detail` text DEFAULT NULL,
  `status` enum('on','off') DEFAULT NULL,
  `sort` int(5) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_service`
--

INSERT INTO `tb_service` (`id`, `image`, `name`, `short_detail`, `detail`, `status`, `sort`, `created`, `updated`) VALUES
(1, 'upload/service/19052020-103456-.jpeg', 'dfg', 'dfgdfg', 'dsfdsf', 'on', 2, '2020-05-18 14:09:48', '2020-05-19 15:20:06'),
(2, 'upload/service/19052020-152006-.jpeg', 'ik', 'ioi', 'oio', 'on', 1, '2020-05-19 15:20:06', '2020-05-19 15:20:06');

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
-- Indexes for table `tb_category`
--
ALTER TABLE `tb_category`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `tb_contact`
--
ALTER TABLE `tb_contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_gallery`
--
ALTER TABLE `tb_gallery`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `tb_information`
--
ALTER TABLE `tb_information`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_menu`
--
ALTER TABLE `tb_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_portfolio`
--
ALTER TABLE `tb_portfolio`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_service`
--
ALTER TABLE `tb_service`
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
-- AUTO_INCREMENT for table `tb_category`
--
ALTER TABLE `tb_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_contact`
--
ALTER TABLE `tb_contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tb_gallery`
--
ALTER TABLE `tb_gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=329;

--
-- AUTO_INCREMENT for table `tb_information`
--
ALTER TABLE `tb_information`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_menu`
--
ALTER TABLE `tb_menu`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `tb_portfolio`
--
ALTER TABLE `tb_portfolio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_service`
--
ALTER TABLE `tb_service`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
