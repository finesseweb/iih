-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 30, 2023 at 02:03 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.2.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gh_nep_erp`
--

-- --------------------------------------------------------

--
-- Table structure for table `fa_alloted_room`
--

CREATE TABLE `fa_alloted_room` (
  `id` int(11) NOT NULL,
  `stu_id` varchar(11) DEFAULT NULL,
  `bed_id` int(11) DEFAULT NULL,
  `inactive` tinyint(1) NOT NULL DEFAULT 1,
  `from_date` datetime NOT NULL,
  `to_date` datetime NOT NULL,
  `remark` varchar(300) NOT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `fa_allowed_book`
--

CREATE TABLE `fa_allowed_book` (
  `id` int(11) NOT NULL,
  `ref_id` varchar(50) NOT NULL,
  `checkout_policy` varchar(100) NOT NULL,
  `no_book` int(10) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fa_allowed_book`
--

INSERT INTO `fa_allowed_book` (`id`, `ref_id`, `checkout_policy`, `no_book`, `status`) VALUES
(39, 'No-001', 'Staff', 7, 0),
(40, 'No-002', 'Student', 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `fa_areas`
--

CREATE TABLE `fa_areas` (
  `area_code` int(11) NOT NULL,
  `description` varchar(60) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `inactive` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fa_areas`
--

INSERT INTO `fa_areas` (`area_code`, `description`, `inactive`) VALUES
(1, 'Global', 0);

-- --------------------------------------------------------

--
-- Table structure for table `fa_assembled_assets`
--

CREATE TABLE `fa_assembled_assets` (
  `id` int(11) NOT NULL,
  `item_category_id` int(11) NOT NULL,
  `item_sub_category_id` int(11) NOT NULL,
  `stock_id` varchar(20) NOT NULL,
  `asset_id` int(11) NOT NULL,
  `inactive` int(11) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fa_assembled_assets`
--

INSERT INTO `fa_assembled_assets` (`id`, `item_category_id`, `item_sub_category_id`, `stock_id`, `asset_id`, `inactive`, `qty`) VALUES
(12, 1, 1, '0210', 1, 0, 2),
(13, 3, 5, '003', 1, 0, 4),
(16, 3, 5, '003', 2, 0, 4),
(17, 1, 1, '0210', 2, 0, 2);

-- --------------------------------------------------------

--
-- Table structure for table `fa_asset_issue_items`
--

CREATE TABLE `fa_asset_issue_items` (
  `id` int(11) NOT NULL,
  `stock_id` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `issue_id` int(11) DEFAULT NULL,
  `qty_issued` double DEFAULT NULL,
  `unit_cost` double NOT NULL DEFAULT 0,
  `sl_no` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `code` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'NA',
  `room_no` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'NA',
  `department_id` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'NA',
  `seat_no` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'NA',
  `asset_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fa_asset_master`
--

CREATE TABLE `fa_asset_master` (
  `asset_id` int(11) NOT NULL,
  `product_id` int(10) NOT NULL,
  `code` varchar(100) NOT NULL,
  `inactive` tinyint(2) NOT NULL,
  `qty` tinyint(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fa_asset_master`
--

INSERT INTO `fa_asset_master` (`asset_id`, `product_id`, `code`, `inactive`, `qty`) VALUES
(1, 3, 'First Floor', 0, 5);

-- --------------------------------------------------------

--
-- Table structure for table `fa_attachments`
--

CREATE TABLE `fa_attachments` (
  `id` int(11) UNSIGNED NOT NULL,
  `description` varchar(60) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `type_no` int(11) NOT NULL DEFAULT 0,
  `trans_no` int(11) NOT NULL DEFAULT 0,
  `unique_name` varchar(60) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `tran_date` date NOT NULL DEFAULT '0000-00-00',
  `filename` varchar(60) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `filesize` int(11) NOT NULL DEFAULT 0,
  `filetype` varchar(60) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fa_attendance`
--

CREATE TABLE `fa_attendance` (
  `emp_id` int(11) NOT NULL,
  `overtime_id` int(11) NOT NULL,
  `hours_no` float NOT NULL DEFAULT 0,
  `rate` float NOT NULL DEFAULT 1,
  `att_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `fa_audit_trail`
--

CREATE TABLE `fa_audit_trail` (
  `id` int(11) NOT NULL,
  `type` smallint(6) UNSIGNED NOT NULL DEFAULT 0,
  `trans_no` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `user` smallint(6) UNSIGNED NOT NULL DEFAULT 0,
  `stamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `description` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fiscal_year` int(11) NOT NULL DEFAULT 0,
  `gl_date` date NOT NULL DEFAULT '0000-00-00',
  `gl_seq` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fa_audit_trail`
--

INSERT INTO `fa_audit_trail` (`id`, `type`, `trans_no`, `user`, `stamp`, `description`, `fiscal_year`, `gl_date`, `gl_seq`) VALUES
(1, 0, 1, 1, '2022-04-01 05:42:53', '', 4, '2021-01-13', 1),
(2, 25, 0, 1, '2022-08-19 05:37:00', '', 6, '2021-11-19', NULL),
(3, 25, 1, 1, '2023-01-05 10:51:47', '', 6, '2021-11-19', NULL),
(5, 25, 23, 1, '2022-08-19 05:37:00', 'Updated.', 6, '2021-11-22', NULL),
(6, 25, 23, 1, '2022-08-19 05:37:00', 'Updated.', 6, '2021-11-22', NULL),
(7, 16, 1, 1, '2022-01-19 06:12:37', '', 5, '2021-12-29', NULL),
(8, 90, 23, 1, '2021-12-30 06:51:58', '', 5, '2021-12-30', 0),
(9, 90, 24, 1, '2021-12-30 06:55:06', '', 5, '2021-12-30', 0),
(10, 25, 25, 1, '2021-12-30 06:56:08', '', 5, '2021-12-30', 0),
(11, 25, 2, 1, '2023-02-01 11:39:14', '', 6, '2021-12-30', NULL),
(13, 26, 0, 1, '2021-12-30 08:27:13', '', 5, '2021-12-30', NULL),
(14, 26, 0, 1, '2021-12-30 08:27:13', 'Released.', 5, '2021-12-30', 0),
(15, 28, 0, 1, '2021-12-30 08:32:11', '', 5, '2021-12-30', 0),
(16, 90, 26, 1, '2021-12-30 09:47:13', '', 5, '2021-12-30', 0),
(17, 25, 27, 1, '2021-12-30 09:57:07', '', 5, '2021-12-30', 0),
(18, 25, 3, 1, '2023-02-01 11:43:50', '', 6, '2021-12-30', NULL),
(19, 25, 28, 1, '2021-12-30 11:09:47', '', 5, '2021-12-30', 0),
(20, 25, 4, 1, '2023-03-15 14:19:17', '', 6, '2021-12-30', NULL),
(21, 28, 3, 1, '2022-11-10 11:24:39', '', 6, '2021-12-30', NULL),
(22, 29, 0, 1, '2023-02-01 12:04:25', 'Production.', 6, '2021-12-30', NULL),
(23, 28, 5, 1, '2022-08-08 10:59:47', '', 6, '2022-01-04', NULL),
(24, 29, 2, 1, '2022-01-18 05:17:06', 'Production.', 5, '2022-01-04', NULL),
(25, 28, 6, 1, '2022-08-08 12:07:05', '', 6, '2022-01-07', NULL),
(26, 29, 3, 1, '2022-01-19 06:09:18', 'Production.', 5, '2022-01-07', NULL),
(27, 25, 29, 1, '2022-01-17 10:04:12', '', 5, '2022-01-17', 0),
(28, 25, 5, 1, '2022-10-26 07:32:11', '', 6, '2022-01-17', NULL),
(29, 25, 30, 1, '2022-01-17 10:21:32', '', 5, '2022-01-17', 0),
(30, 25, 6, 1, '2022-10-26 07:37:29', '', 6, '2022-01-17', NULL),
(31, 26, 1, 1, '2022-11-01 08:24:04', '', 6, '2022-01-17', NULL),
(32, 26, 1, 1, '2022-11-01 08:24:04', 'Released.', 6, '2022-01-17', NULL),
(33, 29, 1, 1, '2022-01-17 10:21:48', 'Production.', 5, '2022-01-17', 0),
(34, 28, 1, 1, '2023-03-23 09:24:11', '', 6, '2022-01-17', NULL),
(35, 25, 31, 1, '2022-01-18 05:04:36', '', 5, '2022-01-18', 0),
(36, 25, 7, 1, '2022-10-27 07:44:38', '', 6, '2022-01-18', NULL),
(37, 29, 2, 1, '2022-01-18 05:17:06', 'Production.', 5, '2022-01-18', 0),
(38, 100, 32, 1, '2022-01-19 04:54:45', '', 5, '2022-01-19', 0),
(39, 25, 33, 1, '2022-01-19 05:33:20', '', 5, '2022-01-19', 0),
(40, 25, 8, 1, '2022-12-02 05:29:29', '', 6, '2022-01-19', NULL),
(41, 100, 34, 1, '2022-01-19 05:34:58', '', 5, '2022-01-19', 0),
(42, 26, 2, 1, '2022-11-30 06:26:42', '', 6, '2022-01-19', NULL),
(43, 26, 2, 1, '2022-11-30 06:26:42', 'Released.', 6, '2022-01-19', NULL),
(44, 25, 35, 1, '2022-01-19 06:04:13', '', 5, '2022-01-19', 0),
(45, 25, 9, 1, '2023-01-02 09:54:23', '', 6, '2022-01-19', NULL),
(46, 28, 2, 1, '2023-03-21 08:00:26', '', 6, '2022-01-19', NULL),
(47, 29, 3, 1, '2022-01-19 06:09:18', 'Production.', 5, '2022-01-19', 0),
(48, 16, 1, 1, '2022-01-19 06:12:37', '', 5, '2022-01-19', 0),
(49, 25, 36, 1, '2022-01-19 06:16:28', '', 5, '2022-01-19', 0),
(50, 25, 10, 1, '2023-01-05 10:51:47', '', 6, '2022-01-19', NULL),
(51, 26, 3, 1, '2023-02-01 11:41:27', '', 6, '2022-01-19', NULL),
(52, 26, 3, 1, '2023-02-01 11:41:27', 'Released.', 6, '2022-01-19', NULL),
(53, 28, 3, 1, '2022-11-10 11:24:39', '', 6, '2022-01-19', NULL),
(54, 29, 4, 1, '2022-01-19 08:02:21', 'Production.', 5, '2022-01-19', 0),
(55, 26, 4, 1, '2023-03-14 12:07:04', '', 0, '2022-01-19', NULL),
(56, 26, 4, 1, '2023-03-14 12:07:04', 'Released.', 0, '2022-01-19', NULL),
(57, 28, 4, 1, '2022-12-12 07:29:01', '', 6, '2022-01-19', NULL),
(58, 25, 37, 1, '2022-01-19 09:48:42', '', 5, '2022-01-19', 0),
(59, 25, 11, 1, '2023-02-01 11:39:14', '', 6, '2022-01-19', NULL),
(60, 26, 5, 1, '2022-01-19 12:29:41', '', 5, '2022-01-19', NULL),
(61, 26, 5, 1, '2022-01-19 12:29:41', 'Released.', 5, '2022-01-19', 0),
(62, 25, 38, 1, '2022-01-19 12:31:40', '', 5, '2022-01-19', 0),
(63, 25, 12, 1, '2023-02-01 11:43:50', '', 6, '2022-01-19', NULL),
(64, 28, 5, 1, '2022-08-08 10:59:47', '', 6, '2022-01-19', NULL),
(65, 28, 6, 1, '2022-08-08 12:07:05', '', 6, '2022-01-19', NULL),
(66, 29, 5, 1, '2022-01-20 05:31:13', 'Production.', 5, '2022-01-20', 0),
(67, 28, 7, 1, '2022-08-10 07:38:06', '', 6, '2022-01-20', NULL),
(68, 29, 6, 1, '2022-01-20 05:33:26', 'Production.', 5, '2022-01-20', 0),
(69, 25, 39, 1, '2022-01-20 05:34:48', '', 5, '2022-01-20', 0),
(70, 25, 13, 1, '2023-03-15 14:19:18', '', 6, '2022-01-20', NULL),
(71, 29, 7, 1, '2022-01-20 06:48:21', 'Production.', 5, '2022-01-20', 0),
(72, 25, 40, 1, '2022-01-20 08:19:08', '', 5, '2022-01-20', 0),
(73, 25, 14, 1, '2022-01-20 08:19:08', '', 5, '2022-01-20', 0),
(74, 100, 41, 1, '2022-01-20 09:24:26', '', 5, '2022-01-20', 0),
(75, 100, 42, 1, '2022-01-21 07:05:49', '', 5, '2022-01-21', 0),
(76, 100, 43, 1, '2022-01-25 06:35:06', '', 5, '2022-01-25', 0),
(77, 100, 44, 1, '2022-01-25 06:35:58', '', 5, '2022-01-25', 0),
(78, 100, 45, 1, '2022-01-25 06:52:14', '', 5, '2022-01-25', 0),
(79, 25, 46, 1, '2022-01-25 10:12:39', '', 5, '2022-01-25', 0),
(80, 25, 15, 1, '2022-01-25 10:12:39', '', 5, '2022-01-25', 0),
(81, 26, 6, 1, '2022-01-25 10:15:13', '', 5, '2022-01-25', NULL),
(82, 26, 6, 1, '2022-01-25 10:15:13', 'Released.', 5, '2022-01-25', 0),
(83, 28, 8, 1, '2022-08-10 10:23:04', '', 6, '2022-01-25', NULL),
(84, 29, 8, 1, '2022-01-25 10:24:10', 'Production.', 5, '2022-01-25', 0),
(85, 25, 47, 1, '2022-01-25 10:26:28', '', 5, '2022-01-25', 0),
(86, 25, 16, 1, '2022-10-18 08:08:54', '', 6, '2022-01-25', NULL),
(87, 100, 48, 1, '2022-01-25 10:35:04', '', 5, '2022-01-25', 0),
(88, 28, 9, 1, '2022-08-10 10:22:13', '', 6, '2022-01-25', NULL),
(89, 29, 9, 1, '2022-01-25 10:37:46', 'Production.', 5, '2022-01-25', 0),
(90, 25, 49, 1, '2022-01-25 10:39:05', '', 5, '2022-01-25', 0),
(91, 25, 17, 1, '2022-10-18 09:25:29', '', 0, '2022-01-25', NULL),
(92, 25, 50, 1, '2022-02-10 10:54:06', '', 5, '2022-02-10', 0),
(93, 25, 18, 1, '2022-10-18 09:26:23', '', 0, '2022-02-10', NULL),
(94, 25, 51, 1, '2022-04-01 05:49:19', '', 6, '2022-04-01', 0),
(95, 25, 19, 1, '2022-10-18 09:33:53', '', 0, '2022-04-01', NULL),
(96, 28, 11, 1, '2022-04-04 09:06:29', '', 6, '2022-04-04', 0),
(97, 28, 12, 1, '2022-04-04 09:15:18', '', 6, '2022-04-04', 0),
(98, 28, 1, 1, '2023-03-23 09:24:11', '', 6, '2022-04-04', NULL),
(99, 28, 2, 1, '2023-03-21 08:00:26', '', 6, '2022-04-05', NULL),
(100, 28, 2, 1, '2023-03-21 08:00:26', '', 6, '2022-04-05', NULL),
(101, 28, 1, 1, '2023-03-23 09:24:11', '', 6, '2022-04-05', NULL),
(102, 28, 2, 1, '2023-03-21 08:00:26', '', 6, '2022-04-05', NULL),
(103, 28, 3, 1, '2022-11-10 11:24:39', '', 6, '2022-08-04', NULL),
(104, 25, 52, 1, '2022-08-04 09:48:31', '', 6, '2022-08-04', 0),
(105, 25, 20, 1, '2022-08-04 09:48:31', '', 6, '2022-08-04', 0),
(107, 28, 3, 1, '2022-11-10 11:24:39', '', 6, '2022-08-04', NULL),
(108, 28, 2, 1, '2023-03-21 08:00:26', '', 6, '2022-08-08', NULL),
(109, 28, 3, 1, '2022-11-10 11:24:39', '', 6, '2022-08-08', NULL),
(110, 28, 4, 1, '2022-12-12 07:29:01', '', 6, '2022-08-08', NULL),
(111, 28, 5, 1, '2022-08-08 10:59:47', '', 6, '2022-08-08', 0),
(112, 28, 6, 1, '2022-08-08 12:07:05', '', 6, '2022-08-08', 0),
(113, 28, 2, 1, '2023-03-21 08:00:26', '', 6, '2022-08-09', NULL),
(114, 28, 1, 1, '2023-03-23 09:24:11', '', 6, '2022-08-09', NULL),
(115, 28, 1, 1, '2023-03-23 09:24:11', '', 6, '2022-08-09', NULL),
(116, 28, 1, 1, '2023-03-23 09:24:11', '', 6, '2022-08-09', NULL),
(117, 28, 1, 1, '2023-03-23 09:24:11', '', 6, '2022-08-09', NULL),
(118, 28, 2, 1, '2023-03-21 08:00:26', '', 6, '2022-08-09', NULL),
(119, 28, 7, 1, '2022-08-10 07:38:06', '', 6, '2022-08-10', 0),
(120, 28, 8, 1, '2022-08-10 10:23:04', '', 6, '2022-08-10', NULL),
(121, 28, 9, 1, '2022-08-10 10:22:13', '', 6, '2022-08-10', 0),
(122, 28, 8, 1, '2022-08-10 10:23:04', '', 6, '2022-08-10', 0),
(123, 28, 1, 1, '2023-03-23 09:24:11', '', 6, '2022-08-18', NULL),
(124, 28, 1, 1, '2023-03-23 09:24:11', '', 6, '2022-08-18', NULL),
(125, 28, 1, 1, '2023-03-23 09:24:11', '', 6, '2022-08-18', NULL),
(126, 28, 1, 1, '2023-03-23 09:24:11', '', 6, '2022-08-18', NULL),
(127, 28, 1, 1, '2023-03-23 09:24:11', '', 6, '2022-08-18', NULL),
(128, 25, 0, 1, '2022-08-19 05:37:00', '', 6, '2022-08-19', NULL),
(129, 25, 21, 1, '2022-08-19 05:34:11', '', 6, '2022-08-19', 0),
(130, 25, 0, 1, '2022-08-19 05:37:00', '', 6, '2022-08-19', NULL),
(131, 25, 22, 1, '2022-08-19 05:35:38', '', 6, '2022-08-19', 0),
(132, 25, 0, 1, '2022-08-19 05:37:00', '', 6, '2022-08-19', 0),
(133, 25, 23, 1, '2022-08-19 05:37:00', '', 6, '2022-08-19', 0),
(134, 25, 1, 1, '2023-01-05 10:51:47', '', 6, '2022-08-19', NULL),
(135, 25, 1, 1, '2023-01-05 10:51:47', '', 6, '2022-08-19', NULL),
(136, 25, 2, 1, '2023-02-01 11:39:14', '', 6, '2022-08-19', NULL),
(137, 25, 2, 1, '2023-02-01 11:39:14', '', 6, '2022-08-19', NULL),
(138, 28, 1, 1, '2023-03-23 09:24:11', '', 6, '2022-08-19', NULL),
(139, 28, 2, 1, '2023-03-21 08:00:26', '', 6, '2022-08-19', NULL),
(140, 28, 2, 1, '2023-03-21 08:00:26', '', 6, '2022-08-19', NULL),
(141, 28, 2, 1, '2023-03-21 08:00:26', '', 6, '2022-08-19', NULL),
(142, 28, 2, 1, '2023-03-21 08:00:26', '', 6, '2022-08-19', NULL),
(143, 28, 2, 1, '2023-03-21 08:00:26', '', 6, '2022-08-19', NULL),
(144, 28, 2, 1, '2023-03-21 08:00:26', '', 6, '2022-08-19', NULL),
(145, 28, 2, 1, '2023-03-21 08:00:26', '', 6, '2022-08-19', NULL),
(146, 26, 7, 1, '2022-10-14 11:21:49', '', 6, '2022-10-14', NULL),
(147, 26, 7, 1, '2022-10-14 11:21:49', 'Released.', 6, '2022-10-14', NULL),
(148, 26, 7, 1, '2022-10-14 11:21:49', 'Updated.', 6, '2022-10-14', 0),
(149, 29, 0, 1, '2023-02-01 12:04:25', 'Production.', 6, '2022-10-14', NULL),
(150, 25, 3, 1, '2023-02-01 11:43:50', '', 6, '2022-10-17', NULL),
(151, 25, 3, 1, '2023-02-01 11:43:50', '', 6, '2022-10-17', NULL),
(152, 26, 8, 1, '2022-10-17 06:34:14', '', 6, '2022-10-17', NULL),
(153, 26, 8, 1, '2022-10-17 06:34:14', 'Released.', 6, '2022-10-17', 0),
(154, 28, 1, 1, '2023-03-23 09:24:11', '', 6, '2022-10-17', NULL),
(155, 29, 0, 1, '2023-02-01 12:04:25', 'Production.', 6, '2022-10-17', NULL),
(156, 28, 2, 1, '2023-03-21 08:00:26', '', 6, '0000-00-00', NULL),
(157, 28, 3, 1, '2022-11-10 11:24:39', '', 6, '2022-10-17', NULL),
(158, 0, 0, 1, '2022-10-18 07:04:54', '', 0, '0000-00-00', NULL),
(159, 0, 0, 1, '2022-10-18 07:04:54', '', 0, '0000-00-00', NULL),
(160, 0, 0, 1, '2022-10-18 07:04:54', '', 0, '0000-00-00', NULL),
(161, 0, 0, 1, '2022-10-18 07:04:54', '', 0, '0000-00-00', NULL),
(162, 0, 0, 1, '2022-10-18 07:04:54', '', 0, '0000-00-00', NULL),
(163, 0, 0, 1, '2022-10-18 07:04:54', '', 0, '0000-00-00', 0),
(164, 25, 10, 1, '2023-01-05 10:51:47', '', 6, '2022-10-18', NULL),
(165, 25, 4, 1, '2023-03-15 14:19:17', '', 6, '2022-10-18', NULL),
(166, 25, 16, 1, '2022-10-18 08:08:54', '', 6, '2022-10-18', 0),
(167, 25, 5, 1, '2022-10-26 07:32:11', '', 6, '2022-10-18', NULL),
(168, 25, 17, 1, '2022-10-18 09:25:29', '', 0, '0000-00-00', 0),
(169, 25, 18, 1, '2022-10-18 09:26:23', '', 0, '0000-00-00', 0),
(170, 25, 19, 1, '2022-10-18 09:33:53', '', 0, '0000-00-00', 0),
(171, 25, 1, 1, '2023-01-05 10:51:47', '', 6, '2022-10-18', NULL),
(172, 25, 6, 1, '2022-10-26 07:37:29', '', 6, '2022-10-18', NULL),
(173, 25, 2, 1, '2023-02-01 11:39:14', '', 6, '0000-00-00', NULL),
(174, 28, 3, 1, '2022-11-10 11:24:39', '', 6, '2022-10-20', NULL),
(175, 29, 0, 1, '2023-02-01 12:04:25', 'Production.', 6, '2022-10-21', NULL),
(176, 25, 3, 1, '2023-02-01 11:43:50', '', 6, '0000-00-00', NULL),
(177, 25, 4, 1, '2023-03-15 14:19:17', '', 6, '0000-00-00', NULL),
(178, 25, 5, 1, '2022-10-26 07:32:11', '', 6, '2022-10-21', NULL),
(179, 25, 7, 1, '2022-10-27 07:44:38', '', 6, '2022-10-21', NULL),
(180, 25, 6, 1, '2022-10-26 07:37:29', '', 6, '2022-10-21', NULL),
(181, 25, 8, 1, '2022-12-02 05:29:29', '', 6, '2022-10-21', NULL),
(182, 25, 7, 1, '2022-10-27 07:44:38', '', 6, '2022-10-21', NULL),
(183, 25, 9, 1, '2023-01-02 09:54:23', '', 6, '2022-10-21', NULL),
(184, 25, 9, 1, '2023-01-02 09:54:23', '', 6, '0000-00-00', NULL),
(185, 28, 2, 1, '2023-03-21 08:00:26', '', 6, '2022-10-21', NULL),
(186, 28, 2, 1, '2023-03-21 08:00:26', '', 6, '2022-10-21', NULL),
(187, 28, 2, 1, '2023-03-21 08:00:26', '', 6, '2022-10-21', NULL),
(188, 28, 2, 1, '2023-03-21 08:00:26', '', 6, '2022-10-21', NULL),
(189, 28, 2, 1, '2023-03-21 08:00:26', '', 6, '2022-10-21', NULL),
(190, 28, 3, 1, '2022-11-10 11:24:39', '', 6, '2022-10-21', NULL),
(191, 26, 9, 1, '2022-10-21 09:41:22', '', 6, '2022-10-21', NULL),
(192, 26, 9, 1, '2022-10-21 09:41:22', 'Released.', 6, '2022-10-21', 0),
(193, 28, 2, 1, '2023-03-21 08:00:26', '', 6, '2022-10-21', NULL),
(194, 29, 0, 1, '2023-02-01 12:04:25', 'Production.', 6, '2022-10-21', NULL),
(195, 25, 10, 1, '2023-01-05 10:51:47', '', 6, '0000-00-00', NULL),
(196, 28, 2, 1, '2023-03-21 08:00:26', '', 6, '2022-10-21', NULL),
(197, 25, 11, 1, '2023-02-01 11:39:14', '', 6, '2022-10-21', NULL),
(198, 25, 10, 1, '2023-01-05 10:51:47', '', 6, '2022-10-21', NULL),
(199, 25, 12, 1, '2023-02-01 11:43:50', '', 6, '2022-10-21', NULL),
(200, 25, 11, 1, '2023-02-01 11:39:14', '', 6, '2022-10-21', NULL),
(201, 25, 13, 1, '2023-03-15 14:19:18', '', 6, '2022-10-21', NULL),
(202, 25, 12, 1, '2023-02-01 11:43:50', '', 6, '2022-10-21', NULL),
(203, 28, 2, 1, '2023-03-21 08:00:26', '', 6, '2022-10-21', NULL),
(204, 28, 2, 1, '2023-03-21 08:00:26', '', 6, '2022-10-21', NULL),
(206, 25, 1, 1, '2023-01-05 10:51:47', 'Updated.', 6, '2022-10-21', NULL),
(207, 25, 1, 1, '2023-01-05 10:51:47', 'Updated.', 6, '2022-10-21', NULL),
(208, 25, 1, 1, '2023-01-05 10:51:47', 'Updated.', 6, '2022-10-21', NULL),
(209, 25, 1, 1, '2023-01-05 10:51:47', 'Updated.', 6, '2022-10-21', NULL),
(210, 25, 1, 1, '2023-01-05 10:51:47', 'Updated.', 6, '2022-10-21', NULL),
(211, 25, 1, 1, '2023-01-05 10:51:47', 'Updated.', 6, '2022-10-21', NULL),
(212, 25, 1, 1, '2023-01-05 10:51:47', 'Updated.', 6, '2022-10-21', NULL),
(213, 25, 1, 1, '2023-01-05 10:51:47', 'Updated.', 6, '2022-10-21', NULL),
(214, 25, 1, 1, '2023-01-05 10:51:47', 'Updated.', 6, '2022-10-21', NULL),
(217, 25, 4, 1, '2023-03-15 14:19:17', '', 6, '2022-10-21', NULL),
(218, 25, 4, 1, '2023-03-15 14:19:17', '', 6, '2022-10-21', NULL),
(219, 25, 1, 1, '2023-01-05 10:51:47', '', 6, '2022-10-26', NULL),
(220, 25, 5, 1, '2022-10-26 07:32:11', '', 6, '2022-10-26', 0),
(221, 25, 2, 1, '2023-02-01 11:39:14', '', 6, '2022-10-26', NULL),
(222, 25, 6, 1, '2022-10-26 07:37:29', '', 6, '2022-10-26', 0),
(223, 25, 3, 1, '2023-02-01 11:43:50', '', 6, '2022-10-27', NULL),
(224, 25, 7, 1, '2022-10-27 07:44:38', '', 6, '2022-10-27', 0),
(225, 28, 2, 1, '2023-03-21 08:00:26', '', 6, '2022-10-27', NULL),
(226, 26, 1, 1, '2022-11-01 08:24:04', '', 6, '2022-11-01', NULL),
(227, 26, 1, 1, '2022-11-01 08:24:04', 'Released.', 6, '2022-11-01', 0),
(228, 28, 1, 1, '2023-03-23 09:24:11', '', 6, '2022-11-01', NULL),
(229, 29, 0, 1, '2023-02-01 12:04:25', 'Production.', 6, '2022-11-01', NULL),
(230, 25, 4, 1, '2023-03-15 14:19:17', '', 6, '0000-00-00', NULL),
(231, 28, 2, 1, '2023-03-21 08:00:26', '', 6, '2022-11-01', NULL),
(232, 28, 3, 1, '2022-11-10 11:24:39', '', 6, '2022-11-10', NULL),
(233, 28, 3, 1, '2022-11-10 11:24:39', '', 6, '2022-11-10', 0),
(234, 26, 2, 1, '2022-11-30 06:26:42', '', 6, '2022-11-30', NULL),
(235, 26, 2, 1, '2022-11-30 06:26:42', 'Released.', 6, '2022-11-30', 0),
(236, 28, 1, 1, '2023-03-23 09:24:11', '', 6, '2022-12-01', NULL),
(237, 25, 1, 1, '2023-01-05 10:51:47', '', 6, '2022-12-02', NULL),
(238, 25, 8, 1, '2022-12-02 05:29:29', '', 6, '2022-12-02', 0),
(239, 28, 1, 1, '2023-03-23 09:24:11', '', 6, '2022-12-02', NULL),
(240, 28, 2, 1, '2023-03-21 08:00:26', '', 6, '2022-12-02', NULL),
(241, 28, 2, 1, '2023-03-21 08:00:26', '', 6, '2022-12-05', NULL),
(242, 28, 4, 1, '2022-12-12 07:29:01', '', 6, '2022-12-12', 0),
(243, 25, 2, 1, '2023-02-01 11:39:14', '', 6, '2023-01-02', NULL),
(244, 25, 9, 1, '2023-01-02 09:54:23', '', 6, '2023-01-02', 0),
(250, 30, 1, 1, '2023-01-05 11:55:23', '', 6, '2023-01-03', NULL),
(251, 13, 1, 1, '2023-01-05 11:55:23', '', 6, '2023-01-03', NULL),
(252, 10, 1, 1, '2023-01-05 11:55:23', '', 6, '2023-01-03', NULL),
(253, 30, 2, 1, '2023-01-05 12:12:09', '', 6, '2023-01-03', NULL),
(254, 13, 2, 1, '2023-01-05 12:12:09', '', 6, '2023-01-03', NULL),
(255, 10, 2, 1, '2023-01-05 12:12:09', '', 6, '2023-01-03', NULL),
(256, 30, 3, 1, '2023-01-03 12:07:11', '', 6, '2023-01-03', 0),
(257, 13, 3, 1, '2023-01-03 12:07:11', '', 6, '2023-01-03', 0),
(258, 10, 3, 1, '2023-01-03 12:07:11', '', 6, '2023-01-03', 0),
(259, 30, 1, 1, '2023-01-05 11:55:23', '', 6, '2023-01-05', NULL),
(260, 25, 1, 1, '2023-01-05 10:51:47', '', 6, '2023-01-05', 0),
(261, 25, 10, 1, '2023-01-05 10:51:47', '', 6, '2023-01-05', 0),
(264, 10, 1, 1, '2023-01-05 11:55:23', '', 6, '2023-01-05', NULL),
(267, 10, 1, 1, '2023-01-05 11:55:23', '', 6, '2023-01-05', NULL),
(270, 10, 1, 1, '2023-01-05 11:55:23', '', 6, '2023-01-05', NULL),
(274, 30, 1, 1, '2023-01-05 11:55:23', '', 6, '2023-01-05', 0),
(275, 13, 1, 1, '2023-01-05 11:55:23', '', 6, '2023-01-05', 0),
(276, 10, 1, 1, '2023-01-05 11:55:23', '', 6, '2023-01-05', 0),
(277, 30, 2, 1, '2023-01-05 12:12:09', '', 6, '2023-01-05', 0),
(278, 13, 2, 1, '2023-01-05 12:12:09', '', 6, '2023-01-05', 0),
(279, 10, 2, 1, '2023-01-05 12:12:09', '', 6, '2023-01-05', 0),
(280, 25, 2, 1, '2023-02-01 11:39:14', '', 6, '2023-02-01', 0),
(281, 25, 11, 1, '2023-02-01 11:39:14', '', 6, '2023-02-01', 0),
(282, 26, 3, 1, '2023-02-01 11:41:27', '', 6, '2023-02-01', NULL),
(283, 26, 3, 1, '2023-02-01 11:41:27', 'Released.', 6, '2023-02-01', 0),
(284, 25, 3, 1, '2023-02-01 11:43:50', '', 6, '2023-02-01', 0),
(285, 25, 12, 1, '2023-02-01 11:43:50', '', 6, '2023-02-01', 0),
(286, 29, 0, 1, '2023-02-01 12:04:25', 'Production.', 6, '2023-02-01', 0),
(287, 26, 4, 1, '2023-03-14 12:07:04', '', 0, '2023-03-14', NULL),
(288, 26, 4, 1, '2023-03-14 12:07:04', 'Released.', 0, '0000-00-00', 0),
(289, 25, 4, 1, '2023-03-15 14:19:17', '', 6, '2023-03-15', 0),
(290, 25, 13, 1, '2023-03-15 14:19:18', '', 6, '2023-03-15', 0),
(291, 28, 1, 1, '2023-03-23 09:24:11', '', 6, '2023-03-20', NULL),
(292, 28, 1, 1, '2023-03-23 09:24:11', '', 6, '2023-03-20', NULL),
(293, 28, 2, 1, '2023-03-21 08:00:26', '', 6, '2023-03-21', 0),
(294, 28, 1, 1, '2023-03-23 09:24:11', '', 6, '2023-03-22', NULL),
(295, 28, 1, 1, '2023-03-23 09:24:11', '', 6, '2023-03-23', 0);

-- --------------------------------------------------------

--
-- Table structure for table `fa_author_details`
--

CREATE TABLE `fa_author_details` (
  `auth_id` int(11) NOT NULL,
  `auth_name` varchar(100) NOT NULL,
  `auth_code` varchar(50) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fa_author_details`
--

INSERT INTO `fa_author_details` (`auth_id`, `auth_name`, `auth_code`, `status`) VALUES
(1, 'M.K.MISHRA &amp; L.C.SAHA', 'MKL', 1),
(2, 'M K MISHRA', 'MKM', 1),
(3, 'A.K.SINGH', 'AKS', 1),
(4, 'H C VERMA', 'HC1', 1),
(5, 'S.K.JAIN', 'SKJ', 1),
(6, 'R.S.AGRAWAL &amp; VINA AGRAWAL', 'RVA', 1),
(7, 'P.S.VERMA &amp; V.K.AGRAWAL', 'PSV', 1),
(8, 'LAKHMIR SINGH &amp; MANJIT KAUR', 'LSM', 1),
(9, 'H.C.VERMA', 'HCV', 1),
(10, 'ASHA RANI SINGHAL &amp; OTHERS', 'ARS', 1),
(11, 'S.V.SATSANGI &amp; R.K.TYAGI', 'SRK', 1),
(12, 'ABHA MOHAN', 'AM', 1),
(13, 'SUMAN JAIN', 'SJ', 1),
(14, 'MANJUSHA BHARATI', 'MB', 1),
(15, 'BHARAT PANDEY', 'BP', 1),
(16, 'K.N.BHATIA &amp; M.P.TYAGI', 'KNM', 1),
(17, 'S.N.DHAWAN,S.C.KHET.,P.N.KAPIL', 'SCP', 1),
(18, 'K.L.GOMBER &amp; K.L.LOGIA', 'KLG', 1),
(19, 'R D SHARMA', 'RDS', 1),
(20, 'NCERT SCIENCE', 'NSC', 1),
(21, 'DEVI PRASAD CHATPADHYAY', 'DPC', 1),
(22, 'SHIVANI', 'SHI', 1),
(23, 'RAM PRATAP TRIPATHY', 'RPT', 1),
(24, 'DR.SHRI PRASAD', 'DSP', 1),
(25, 'SWETA UPPAL', 'SU', 1),
(26, 'NONE', 'NO', 1),
(27, 'SUDH RAVI', 'SDR', 1),
(28, 'NEETA SHARMA', 'NS', 1),
(29, 'MAMTA JAIN', 'MJ', 1),
(30, 'RENU ANAND & NEENA KAUL', 'RAN', 1),
(31, 'RACHNA JAIN', 'RJ', 1),
(32, 'VINOD KUMAR', 'VK', 1),
(33, 'SUNITA HOODA', 'SH', 1),
(34, 'SANDHYA RASTOGI', 'SRA', 1),
(35, 'BEENA JAIN & ARCHANA VERMA', 'BJA', 1),
(36, 'ARCHITA B.CHARYA & R P', 'ABR', 1),
(37, 'PRADEEP SINGH C K PUNNOOSE', 'PSC', 1),
(38, 'JAGANATH ADHEK&DEEP DIGGA', 'JA1', 1),
(39, 'ANUPAL SAGAR RASMI SAGAR', 'AS8', 1),
(40, 'DEVCHANDRA KR.SINGH', 'DKS', 1),
(41, 'GITA BUDHIRAJA', 'GB', 1),
(42, 'MICHAL NILKANT& PHICIP PANDEY', 'MNP', 1),
(43, 'G.C.AGRWAL', 'GCA', 1),
(44, 'HALLIDAY RESNICK', 'HR', 1),
(45, 'SATISH KUMAR GUPTA &A GUPTA', 'SKA', 1),
(46, 'J.L.FINAR', 'JLF', 1),
(47, 'O P TANDAN A K VIVMAN', 'OPT', 1),
(48, 'PREM DHAWAN & V DHAWAN', 'PVD', 1),
(49, 'S C &S N DHAWAN &P N KAPIL', 'SSP', 1),
(50, 'S P SAUHA', 'SSH', 1),
(51, 'M P TYAGI &J P GOYAL', 'MPJ', 1),
(52, 'S B LALL', 'SBL', 1),
(53, 'B B ARORA &A K SHABHARWAL', 'BAS', 1),
(54, 'V B RASTOGI', 'VBR', 1),
(55, 'RAYAN DHENGRA & D K RAO', 'RDD', 1),
(56, 'S C AGRKAR & OTHERS', 'SCO', 1),
(57, 'S M BHATNAGAR', 'SMB', 1),
(58, 'SATISH PURI', 'SPU', 1),
(59, 'N K MISHRA L C SAHA', 'NKS', 1),
(60, 'K K MOHINDRO', 'KK3', 1),
(61, 'J S CHHIBBER', 'JSC', 1),
(62, 'A K SINGH & N K MISHRA', 'ANM', 1),
(63, 'ARCHANA B B R RANGRAJAN', 'ABB', 1),
(64, 'R K VERSHMEN', 'RKV', 1),
(65, 'P C CHHABRA S V SINGH', 'PCS', 1),
(66, 'YURI OLESHA', 'YO', 1),
(67, 'MR.ATOLA', 'MAT', 1),
(68, 'V L PILLAI', 'VLP', 1),
(69, 'G K ARORA', 'GKA', 1),
(70, 'K.L.WADHWAN', 'KLW', 1),
(71, 'S P JAUHAR', 'SPJ', 1),
(72, 'M K VERMA M VERMA', 'MVM', 1),
(73, 'SANJAY BHATNAGAR', 'SB', 1),
(74, 'M S GANESH', 'MSG', 1),
(75, 'A N MITAL', 'AM1', 1),
(76, 'K K GUPTA', 'KKG', 1),
(77, 'LAKHMIR SINGH', 'LSI', 1),
(78, 'J N JAISWAL', 'JNJ', 1),
(79, 'STALIN MALHOTRA', 'SM', 1),
(80, 'P N KAPIL', 'PNK', 1),
(81, 'P N PILLAI', 'PNP', 1),
(82, 'R L MADAN', 'RLM', 1),
(83, 'K P MANCHANDA', 'KPM', 1),
(84, 'S N JAISWAL & S K S', 'SJS', 1),
(85, 'SATENDAR SINGH', 'SS;', 1),
(86, 'MS.ATULA', 'MSA', 1),
(87, 'S P SAUHA R S', 'SRS', 1),
(88, 'SARITA AGARWAL', 'SAG', 1),
(89, 'A.B.BHATACHARYA', 'AB3', 1),
(90, 'K.K. ANU GOYAL', 'KAG', 1),
(91, 'V.B.A S V GOPAL', 'VBG', 1),
(92, 'R.P.GOEL', 'RPG', 1),
(93, 'R P GOEL', 'RPG', 1),
(94, 'A.M.VAIDYA & OTHES', 'AMO', 1),
(95, 'S K GUPTA & OTHERS', 'SGU', 1),
(96, 'P M ARORA &O ARORA', 'PMA', 1),
(97, 'R S AGGARWAL', 'RSA', 1),
(98, 'R K GOYA', 'RKG', 1),
(99, 'U M SINGH', 'UMS', 1),
(100, 'P.N.ARORA', 'PNA', 1),
(101, 'ISHWAR CHANDRA', 'ICH', 1),
(102, 'MANOJ DUBEY &R S T', 'MDR', 1),
(103, 'ASHA RANI SINGAL', 'ASG', 1),
(104, 'S C ANAND &A K', 'SCA', 1),
(105, 'P.N.ARORA & OTHERS', 'PNO', 1),
(106, 'M.DUBEY', 'MDU', 1),
(107, 'P K GARG', 'PKG', 1),
(108, 'HARI KRISHNA', 'HK', 1),
(109, 'MANJEET SINGH', 'MSI', 1),
(110, 'S S MALHOTRA &S MALHOTRA', 'SMM', 1),
(111, 'A K ROY', 'AKR', 1),
(112, 'J.P.MOHINDRA', 'JPM', 1),
(113, 'S N SHARMA', 'SNS', 1),
(114, 'HARBANSLAL & A K SHARMA', 'HAS', 1),
(115, 'S K BATRA SANJEEV VERMA', 'SBS', 1),
(116, 'S S MALHOTRA S MALHOTRA', 'SSM', 1),
(117, 'H.K.DASS', 'HD', 1),
(118, 'V K TANWER', 'VKT', 1),
(119, 'P K SINGHAL', 'PKS', 1),
(120, 'N K CHAUDHARY', 'NKC', 1),
(121, 'A C SHARMA', 'AC6', 1),
(122, 'PREM CHAND', 'PCH', 1),
(123, 'N K KHER', 'NKK', 1),
(124, 'K L JOSHI', 'KJS', 1),
(125, 'M.K.CHOW', 'MC2', 1),
(126, 'M K CHAUDHARY', 'MKC', 1),
(127, 'N.ANANTA.PADNABHAM', 'NAP', 1),
(128, 'SHAMMEN KISAN', 'SHK', 1),
(129, 'N N KHER', 'NNK', 1),
(130, 'TAPAS MAZOOMDAR', 'TMA', 1),
(131, 'CHANDEN SINGH', 'CSI', 1),
(132, 'O P KHANA', 'OPK', 1),
(133, 'ALKA GAUTAM', 'AG1', 1),
(134, 'D N KUNDRA R M K B S BAWA', 'DRB', 1),
(135, 'RADHA KRISHN SHARMA', 'RSH', 1),
(136, 'TARA CHAND', 'TCH', 1),
(137, 'B B MOHANTY', 'BBM', 1),
(138, 'K P VERMA', 'KPV', 1),
(139, 'BISHWANATH PD SHARMA', 'BPS', 1),
(140, 'JOHN LOCKE', 'JL1', 1),
(141, 'WILLIAM O DOUGLAS', 'WOD', 1),
(142, 'JANARDAN PD SINGH GIGYASU', 'JSG', 1),
(143, 'BRAJ BIHARI PSANDEY', 'BP6', 1),
(144, 'K MARK', 'KMA', 1),
(145, 'BHISMA SAHNI', 'BS0', 1),
(146, 'JANKI BALLAV PATNAYAK', 'JBP', 1),
(147, 'BASHUDEV NARAYAN ALOK', 'BNA', 1),
(148, 'RAMESHWAR PD VISHWABANDHU', 'RPV', 1),
(149, 'MADHURI SEXENA', 'MSE', 1),
(150, 'K L JOSHI', 'KLJ', 1),
(151, 'ISWARE PD GUPTA', 'IPG', 1),
(152, 'J.P.SINGAL & OTHERS', 'JPO', 1),
(153, 'I C DHINGAR', 'ICD', 1),
(154, 'TEJ PRATAP SINGH', 'TPS', 1),
(155, 'J C AGGARWAL', 'JCA', 1),
(156, 'AKHILESWAR KR & OTHERS', 'A&O', 1),
(157, 'HARIOM & OTHERS', 'HOO', 1),
(158, 'ANITA SHARMA', 'ASM', 1),
(159, 'D N KUNDRA', 'DN4', 1),
(160, 'A N RAY', 'ANR', 1),
(161, 'KUNDRA &BAWA', 'KBA', 1),
(162, 'ARJUN DEO', 'AR1', 1),
(163, 'CHAMKAUR SINGH', 'CS3', 1),
(164, 'N N KHER & OTHERS', 'NNO', 1),
(165, 'BHALCHAND SADASHIV BHASKAR', 'BSB', 1),
(166, 'B LGUPTA', 'BLG', 1),
(167, 'SHIVJEE RAI A P SINGH', 'SVS', 1),
(168, 'ASHOK GUJRATI', 'AGT', 1),
(169, 'AJIT GOPAL RAY', 'AGR', 1),
(170, 'H S V', 'HSV', 1),
(171, 'RAM SAGAR RAY RAN PD SINGJ', 'RRS', 1),
(172, 'PARTH SHARTHI GUPTA', 'PSG', 1),
(173, 'DAMODAR SHARMA HARI MAHARSI', 'DHM', 1),
(174, 'MR ILEAN Y SEGAL', 'IYS', 1),
(175, 'T N CHATURVEDI', 'TNC', 1),
(176, 'KRISHNA NAND PANDEY', 'KNP', 1),
(177, 'DURGA DAS BERU', 'DDB', 1),
(178, 'PUKHRAJ JAIN', 'PJ', 1),
(179, 'G.KUBLISKY', 'GK', 1),
(180, 'RESTIK HALLIDAY KRANE', 'RH', 1),
(181, 'S VEENA GOPAL', 'SVG', 1),
(182, 'M P KAUSIK', 'MPK', 1),
(183, 'R P MANCHANDA', 'RPM', 1),
(184, 'I L FINAR', 'ILF', 1),
(185, 'SOLMONS & FRYHLL', 'SF', 1),
(186, 'AJAY KR GUPTA', 'AK1', 1),
(187, 'LALJI PRASAD', 'LJP', 1),
(188, 'B R ANAND', 'BRA', 1),
(189, 'R N KUNDRA V M KUNDRA B S B', 'RKB', 1),
(190, 'S MUKHARJEE & OTHERS', 'SMO', 1),
(191, 'S K RAM &OTHERS', 'SKO', 1),
(192, 'S K KHANDELWAL', 'SKK', 1),
(193, 'R LALITHA &OTHERS', 'RLO', 1),
(194, 'H.L.WASAN & A BHASKAR', 'HLB', 1),
(195, 'KOHLI ASHOK MITRA', 'KAM', 1),
(196, 'RENU NAGA KOR K SHARMA', 'RNS', 1),
(197, 'BIRENDRA SUKLA', 'BS8', 1),
(198, 'SURESH PRASAD', 'SPD', 1),
(199, 'K S RANDHWAN', 'KSR', 1),
(200, 'D M KUNDRA & B S BAWA', 'DMB', 1),
(201, 'JAWAHAR SINGH TOMAR', 'JST', 1),
(202, 'B M PANDEY &J P SINGH', 'BPJ', 1),
(203, 'KRISHN BALAV SINGH', 'KBS', 1),
(204, 'A K CHATARGEE', 'AKC', 1),
(205, 'R CDAHIA', 'RCD', 1),
(206, 'M DUBEY RAJ TOMER', 'MRT', 1),
(207, 'AJIT IQBAL SINGH', 'AIS', 1),
(208, 'H K DAS &RANA VONK', 'HKR', 1),
(209, 'S K BATRA & S VERMA', 'SBV', 1),
(210, 'DELIP KUMAR', 'DKR', 1),
(211, 'D K BHATACHARYA & P P', 'DBP', 1),
(212, 'R K TYAGI S KUMAR', 'RTS', 1),
(213, 'H LAL A KR SHARMA', 'HLS', 1),
(214, 'MEERA VERMA', 'MV', 1),
(215, 'SHAMERKISHAN', 'SKI', 1),
(216, 'A.K.KUMAR', 'A.K', 1),
(217, 'M L T &OTHERS', 'MLO', 1),
(218, 'SANDHYA RANI SAHO', 'SSO', 1),
(219, 'S KHANDELWAL', 'SKH', 1),
(220, 'MEDISAUA MUKHARJEE', 'MEM', 1),
(221, 'ALKA GATUM                   J', 'KJK', 1),
(222, 'S MEHTA A SAH', 'SMS', 1),
(223, 'M BOSE LJ YOGEN VIJAY', 'MBY', 1),
(224, 'SHARMA & SSHARMA', 'S&S', 1),
(225, 'O P ARA V K', 'OVK', 1),
(226, 'DEEPAK GOAL', 'DG', 1),
(227, 'M BOSE', 'MBO', 1),
(228, 'RENU ANAND', 'RAD', 1),
(229, 'RAJENDRA PRASAD', 'RPD', 1),
(230, 'DURGA PRASAD GUPT', 'DPG', 1),
(231, 'RAFI AHMED', 'RAH', 1),
(232, 'JAGDESH PD CHATURVEDI', 'JPC', 1),
(233, 'BIPEN CHANDRA OTHERS', 'BCO', 1),
(234, 'MANMOHAN GUPTA', 'MAD', 1),
(235, 'BRAJ BHUSAN', 'BBH', 1),
(236, 'BACHNAS', 'B', 1),
(237, 'URMELISH', 'URM', 1),
(238, 'AYODHYA SINGH', 'A', 1),
(239, 'DEVI SHANKAR PRABHAKAR', 'DPR', 1),
(240, 'KRISHN GOPAL', 'KGO', 1),
(241, 'S S BHATACHARYA', 'SBH', 1),
(242, 'AJAY SHANKAR PANDEY', 'ASP', 1),
(243, 'BIPEN CHANDRA', 'BCH', 1),
(244, 'A S AYER', 'ASA', 1),
(245, 'PRABHAKAR MACHWE', 'PM', 1),
(246, 'ARUN CHANDRA GUPTA', 'ACG', 1),
(247, 'SHAYAM SUNDER', 'SSU', 1),
(248, 'BINOD MISHRA', 'BMI', 1),
(249, 'SWAMI VIVEKANAND', 'SV1', 1),
(250, 'M M SHARMA', 'MM1', 1),
(251, 'SUNIL BATRA', 'SU6', 1),
(252, 'P N CHOPRA', 'PNC', 1),
(253, 'MANMAN NATH GUPT', 'MNG', 1),
(254, 'LUXMI NARAYAN LAL', 'LNL', 1),
(255, 'SITA RAM SINGH', 'SSI', 1),
(256, 'BIPIN CHANDRA', 'BIC', 1),
(257, 'RAM MANOHAR LOHIYA', 'RML', 1),
(258, 'RAKESH RENU', 'RRE', 1),
(259, 'R K PRABHU &OTHERS', 'RPO', 1),
(260, 'B R AGGARWAL', 'BR4', 1),
(261, 'MOHAN KR SARKAR', 'MKS', 1),
(262, 'TARUN BHAI', 'TBH', 1),
(263, 'INDERA DEVI', 'IND', 1),
(264, 'PRAKASH PANDIT', 'PPN', 1),
(265, 'NIRANKAR DEV', 'NID', 1),
(266, 'RAMPATI SUKLA', 'RSU', 1),
(267, 'SATKAM VIDYALANKAR', 'SVR', 1),
(268, 'RAM BACHAN ANAL', 'RBA', 1),
(269, 'SUKHDEO SINGH SAURABH', 'SSS', 1),
(270, 'RATAN SHANKAR PD', 'RSP', 1),
(271, 'MATHALI SARAN GUPT', 'MGU', 1),
(272, 'MAYARAM PATANG', 'MPT', 1),
(273, 'FIRAK GORAKHPURI', 'FGK', 1),
(274, 'BINAY CHANDRA MUDGAL', 'BCM', 1),
(275, 'NARSIMH SHRIVASTAV', 'NSH', 1),
(276, 'AGYAY', 'AGY', 1),
(277, 'SUKHCHAIN SINGH BHANDARI', 'SSB', 1),
(278, 'ANIL PADHLANKAR &OHETRS', 'APO', 1),
(279, 'R SHARMA', 'RSR', 1),
(280, 'RAJ AGGARWAL SUNITA', 'RAS', 1),
(281, 'SANJEEV KR BANSAL', 'SKB', 1),
(282, 'BACHANDEO KUMAR', 'BDK', 1),
(283, 'KRISHN GOPAL RASTOGI SASHI KR', 'SHA', 1),
(284, 'MERA DEXIT', 'MD2', 1),
(285, 'SURENDRA GAMMER &OTHERS', 'SGO', 1),
(286, 'VENET', 'V', 1),
(287, 'SHAYAM CHANDRA KAPOOR & PURNIM', 'SKP', 1),
(288, 'RAJENDRA B BHATNAGAR', 'RBB', 1),
(289, 'ANAMIKA KAPOOR', 'AKP', 1),
(290, 'KAMAL SATYARTHI', 'KSA', 1),
(291, 'HANUMAN PD SHARMA S P TIWARI', 'HSS', 1),
(292, 'JANARDEN MISHRA', 'JMI', 1),
(293, 'RAMBRICKH BENIPURI', 'RBE', 1),
(294, 'GYANWATI DARBAR', 'GDR', 1),
(295, 'MAMA VORKAR', 'MVR', 1),
(296, 'HARI KRISHN DEVVERE', 'HKD', 1),
(297, 'AMRIT LAL NAGER', 'AL5', 1),
(298, 'BADHURATN', 'BDR', 1),
(299, 'KAILASH NATH BHATNAGAR', 'KNB', 1),
(300, 'GIRDHER LAL B CHARWARTI', 'GLC', 1),
(301, 'J K HARI JEE', 'JKH', 1),
(302, 'LELA AWASTHI', 'LAS', 1),
(303, 'UCHRANGRAM KESHWA RAM OJHA', 'UKO', 1),
(304, 'KAMLESHWAR', 'KMW', 1),
(305, 'LIYO TOLSTOY', 'LT', 1),
(306, 'YASHPAL JAIN', 'YAJ', 1),
(307, 'KHALIL GIBRAN', 'KGI', 1),
(308, 'HERA LAL VERMA', 'HLV', 1),
(309, 'BISHNU BHASKAR', 'BB', 1),
(310, 'BIJYENDRA  RAMESHWAR KHANDELWA', 'BRK', 1),
(311, 'BAKE BEHARI BHATNAGAR', 'BBB', 1),
(312, 'RAM KUMAR VERMA', 'RVR', 1),
(313, 'BISHNU KANT SHASTRI', 'BKS', 1),
(314, 'BAADRI NARAYAN SINHA', 'BN', 1),
(315, 'TRIBHUWAN SINGH', 'TBS', 1),
(316, 'HAJARI PD DEWEDI', 'HP1', 1),
(317, 'RATNAKER PANDEY', 'RPN', 1),
(318, 'VIMAL MEHTA', 'VMH', 1),
(319, 'LALDHER TRIPATHI', 'LDT', 1),
(320, 'LUXMI NARAYAN SHASTRI', 'LNS', 1),
(321, 'JAYNATH NALIN', 'JN', 1),
(322, 'BASHUDEV SINGH', 'BDS', 1),
(323, 'BARJOR SINGH SARAL', 'BSS', 1),
(324, 'SURESHWAR PATHAK VIDYALANKAR', 'SPV', 1),
(325, 'JAY CHANDRA RAM', 'JCR', 1),
(326, 'KANHAYA LAL SARAL', 'KLS', 1),
(327, 'JAY SINGH READY', 'JSR', 1),
(328, 'BHAWER LAL SHARMA', 'BLS', 1),
(329, 'BREMHESHWAR OJHA', 'BSO', 1),
(330, 'BISHNU PRABHAKAR', 'BP4', 1),
(331, 'GIRIDHER PD SHARMA', 'GPS', 1),
(332, 'BHOLA NATH TIWARI', 'BNT', 1),
(333, 'OM PRAKASH SINDAL', 'OP', 1),
(334, 'HARI SHANKAR DUBEY', 'HSD', 1),
(335, 'MOTI LAL ARY', 'MLA', 1),
(336, 'JUGAL KISHOR GUPTA', 'JKG', 1),
(337, 'DHARMPAL SARIN', 'DPS', 1),
(338, 'TILAKRAJ SHARMA', 'TRS', 1),
(339, 'SHIVPUJAN SAHAY', 'SSA', 1),
(340, 'RAMESHWAR LAL KHANDELWAL', 'RLK', 1),
(341, 'UDAY NARAYAN TIWARI', 'UNT', 1),
(342, 'S P KHAN', 'SPK', 1),
(343, 'SHELA BYASH', 'SBY', 1),
(344, 'RAMESH CHAND MISHR', 'RCM', 1),
(345, 'NAGENDRA', 'NAG', 1),
(346, 'ACHARYA RAMCHANDRA SUKLA', 'ASU', 1),
(347, 'RAJ KR SHARMA JANKI PD SHARMA', 'RSJ', 1),
(348, 'LAKHMIR SINGH A KUMAR', 'LSA', 1),
(349, 'J K GUPTA &N OTHERS', 'JGO', 1),
(350, 'R S MITAL & OTHERS', 'RSO', 1),
(351, 'VIKASH AGGARWAL', 'VAW', 1),
(352, 'MAMTA SINGH', 'MSN', 1),
(353, 'B BHUSAN', 'BBU', 1),
(354, 'S C MAHESHWARI', 'SCM', 1),
(355, 'PAOLA COLLO', 'PC', 1),
(356, 'GLEN VECCBIONE', 'GLV', 1),
(357, 'BOB BONNET & DAN KEN', 'BD1', 1),
(358, 'JANE PORTMAN &J RICHARDSAN', 'JPR', 1),
(359, 'D C SHARMA', 'DCS', 1),
(360, 'MANORMA GUPTA', 'MGP', 1),
(361, 'MAMTA AGGARWAL', 'MAW', 1),
(362, 'G L ARORA & R K CHOPRA', 'GKC', 1),
(363, 'NICHOLAS HARDWAD NICOLA BIND', 'NHN', 1),
(364, 'S K RAM PAUL GUNASEKHAR', 'SRG', 1),
(365, 'KRITI LAPUR RAJENDRA DIXIT', 'KLR', 1),
(366, 'M M SHARMA', 'MSH', 1),
(367, 'HARISCHAND', 'HCH', 1),
(368, 'UDAYBHAN CHAND', 'UBC', 1),
(369, 'BIJAY PAL SINGH', 'BSI', 1),
(370, 'SHAYM JEE GOKUL VERMA', 'SGV', 1),
(371, 'PANDIT KAMTA PD GUPTA', 'PKP', 1),
(372, 'BASHUDEV NANDAN PD', 'BNP', 1),
(373, 'VIMAL KUMARI', 'VKU', 1),
(374, 'C H SATYANARAYEN', 'CHS', 1),
(375, 'KEDAR NATH', 'KNA', 1),
(376, 'D B PPATHAK M G BHARGAW', 'DBM', 1),
(377, 'BIRENDRA KR GUPTA', 'BKG', 1),
(378, 'RAVINDRA', 'RA0', 1),
(379, 'KAPIL DEV', 'KDE', 1),
(380, 'B K TIWARI BHATNAGER', 'BTB', 1),
(381, 'FANISHWAR NATH RENU', 'FN1', 1),
(382, 'BACKUNTH NARAYAN', 'BNY', 1),
(383, 'RASUL HAMJTAW', 'RUH', 1),
(384, 'DEVAKAR MANI', 'DNA', 1),
(385, 'PANDIT BHAGIRATH', 'PBH', 1),
(386, 'NARENDRA MOHAN', 'NMO', 1),
(387, 'AMRITA PRETAM', 'APT', 1),
(388, 'MALIK RAJ', 'MRJ', 1),
(389, 'RAMADHAR OJHA TUCKH', 'ROT', 1),
(390, 'RAKCHA SHARMA KAMAL', 'RSK', 1),
(391, 'BALRAJ KOMAL', 'BKO', 1),
(392, 'P C SHARMA', 'PC1', 1),
(393, 'GIRISH CHANDRA JEE', 'GCJ', 1),
(394, 'GAGAN GIL', 'GGL', 1),
(395, 'MAHA DEVI', 'MD', 1),
(396, 'RUPDEWGUN', 'RG', 1),
(397, 'RAM NARESH TRIPATHI', 'RNT', 1),
(398, 'ANJANI KR DUBEY BHAWOK', 'ADB', 1),
(399, 'IQBAL', 'IBL', 1),
(400, 'TRILOCHAN SAHI', 'TS', 1),
(401, 'LILADHAR BIBHOGI', 'LDB', 1),
(402, 'DURGA SHANKAR MISHRA', 'DSM', 1),
(403, 'BRAMHDEV MISHRA', 'BDM', 1),
(404, 'BISHWANATH TRIPATHI', 'BTT', 1),
(405, 'RAKESH SHARMA SHYAM', 'RS2', 1),
(406, 'BISHWANATH MISHRA', 'BNM', 1),
(407, 'NIRMAL VERMA', 'NV', 1),
(408, 'JAGDESH CHANDRA MATHUR', 'JCM', 1),
(409, 'KALIDAS KAPOOR', 'KDK', 1),
(410, 'SETH GOVIND DAS', 'SGD', 1),
(411, 'GOVIND DAS', 'GDS', 1),
(412, 'PRATAP NARAYAN TANDAN', 'PNT', 1),
(413, 'RAJ KUMAR VERMA', 'RK1', 1),
(414, 'HARI KRISH PREMI', 'HKP', 1),
(415, 'S A S RAWAL', 'SSR', 1),
(416, 'JAISHANKAR PRASAD', 'JAI', 1),
(417, 'MUNSI PREM CHAND', 'MPC', 1),
(418, 'KALIDAS', 'KLD', 1),
(419, 'RASIK BIHARI OJHA', 'RBO', 1),
(420, 'CHIRANJEET', 'CRJ', 1),
(421, 'YUGESHWAR', 'YGW', 1),
(422, 'WAYATHET HERDAY', 'WH', 1),
(423, 'LUXMI NARAYAN MISHRA', 'LNM', 1),
(424, 'GIRINDRA NATH SHARMA', 'GNS', 1),
(425, 'PURAN CHAND PANDEY', 'PCP', 1),
(426, 'GYAN SINGH MA', 'GSM', 1),
(427, 'HARIHAR TRIVADI', 'HHT', 1),
(428, 'DEEPAK CHATANYA', 'DCT', 1),
(429, 'BALRAJ PANDIT', 'BLP', 1),
(430, 'CHANDRGUPT BIDYALANKAR', 'CGB', 1),
(431, 'BRAHM MANDAL', 'BMD', 1),
(432, 'P P MANCHANDA H N JHA & OTHER', 'PPM', 1),
(433, 'PANU HALDER', 'PH', 1),
(434, 'GLEN VECCLIONE', 'GVL', 1),
(435, 'ARVIND GUPTA', 'AVG', 1),
(436, 'PREMDAT MISHR MATHIL', 'PM2', 1),
(437, 'AASHIT KR BANDHOPADHYAY', 'AB4', 1),
(438, 'RAJKISHOR', 'RJK', 1),
(439, 'SASHI BHUSAN PANDEY', 'SB6', 1),
(440, 'BHUBNESHWAR NATH MISHR', 'BHN', 1),
(441, 'OM PRAKASH PRASAD', 'OP6', 1),
(442, 'RAJNATH SHARMA', 'RN1', 1),
(443, 'DESH RAJ SINGH BHARTI', 'DSB', 1),
(444, 'RAJ KISHOR SINGH', 'RK2', 1),
(445, 'RAKESH', 'RAK', 1),
(446, 'PREM KANT TANDEN', 'PKT', 1),
(447, 'SAMBHUNATH PANDEY', 'SAM', 1),
(448, 'PARAS DASOL', 'PAD', 1),
(449, 'RAJESHWAR PD CHATURVEDI', 'RP2', 1),
(450, 'MAHENDRA KR S K SHARMA', 'MSS', 1),
(451, 'HARIBANS RAM SHARMA', 'HRS', 1),
(452, 'KALYAN CHAND SRIMAN R K SRIMA', 'KC1', 1),
(453, 'RAMESH CHANDRA MALHOTRA', 'RAM', 1),
(454, 'DEVENDRA KR SHARMA D D', 'DED', 1),
(455, 'ASHOK', 'AS', 1),
(456, 'SAWRENDRA BAAREK', 'SW', 1),
(457, 'AWADHESH MOHAN GUPT', 'AWM', 1),
(458, 'KRISHN VGYE', 'KRI', 1),
(459, 'HARIBANS RAI BACHAN', 'HRB', 1),
(460, 'JASWANT NEGI', 'JAN', 1),
(461, 'MUHAMAD MUFIB', 'MUM', 1),
(462, 'INDERA DEWAN', 'IN1', 1),
(463, 'JIGAR MURADABADI', 'JIM', 1),
(464, 'MANJHI ANANT', 'MA1', 1),
(465, 'KARMVIR ANURAGI', 'KV1', 1),
(466, 'SANGETA NATH', 'SGN', 1),
(467, 'RAMA TIWARI', 'RAT', 1),
(468, 'RAMESH CHANDRA', 'RAC', 1),
(469, 'DEVENDR NATH SHARMA', 'DNS', 1),
(470, 'KARM SINGH', 'KA2', 1),
(471, 'KAYAMUDIN AHAMAD JATASHANKAR', 'KAJ', 1),
(472, 'BHAKT PRAKASH VERMA', 'BPV', 1),
(473, 'RAJKUMAR ATREY', 'RKA', 1),
(474, 'SHIVPRASAD LOHANI', 'SPL', 1),
(475, 'BASU BHATCHARYA', 'B1', 1),
(476, 'GIRISH RASTOGI', 'GRT', 1),
(477, 'NAVENDRA PANULI', 'NNP', 1),
(478, 'SURESH CHANDRA SUKL', 'S C', 1),
(479, 'BADAL SARKAR', 'BAD', 1),
(480, 'SEKSHPEAR   RANGEM RAGHAW', 'SR2', 1),
(481, 'BHAGWATI SARAN MISHRA', 'BSM', 1),
(482, 'MAHIP SINGH', 'MAH', 1),
(483, 'MOHAN RAKESH', 'MOR', 1),
(484, 'PRASHANT', 'PRA', 1),
(485, 'NAMICHAND JAIN', 'NAJ', 1),
(486, 'KANHAIYALAL MANIKLAL MUNSI', 'KM2', 1),
(487, 'SHANKER SESH', 'SHS', 1),
(488, 'WILLEAM SEKSHPEAR', 'WIS', 1),
(489, 'BATOLT BREST', 'BAB', 1),
(490, 'GAJANAN MUKTIBODH', 'GAM', 1),
(491, 'NAND KISHOR NAWAL', 'NKN', 1),
(492, 'PRABHUNATH SINGH', 'PN1', 1),
(493, 'VEER SINGH', 'VER', 1),
(494, 'URMILA MANDHIRTA', 'UR1', 1),
(495, 'ANIL VIDYALANKAR', 'ANV', 1),
(496, 'SNEHLATA PRASAD', 'SNE', 1),
(497, 'KANTA KAMBOJ ROHIT KAMBOJ', 'KKR', 1),
(498, 'GETA BUDHERAJA', 'GBR', 1),
(499, 'SURENDRA PD SEHGAL', 'SP4', 1),
(500, 'PRADEEP SINGH J R', 'PJR', 1),
(501, 'NEENA SINHA R K S R RANGRJAN', 'NSR', 1),
(502, 'SURINDEA SINGH STALIN MAL', 'SS5', 1),
(503, 'BRAHM PRAKASH', 'BHH', 1),
(504, 'S P SAXENA DHEERAJ SAXENA', 'SD6', 1),
(505, 'NAVDEEP SHARMA & OTHERS', 'NSO', 1),
(506, 'MADAN LAL MADHU', 'MLM', 1),
(507, 'ANIRUDH RAM', 'ANI', 1),
(508, 'KRISHN GOPAL RASTOGI', 'KG1', 1),
(509, 'UTPAL MALLIK P K', 'UPK', 1),
(510, 'ANUP SAGAR RASHMI SAGAR', 'AS9', 1),
(511, 'BHAGWATI CHAREN VERMA', 'BCV', 1),
(512, 'RAMDHARI SINGH DINKE', 'RSD', 1),
(513, 'SUNITE NARAYAN', 'SUN', 1),
(514, 'BINOD KHETAN', 'BIK', 1),
(515, 'KAWE ASHOK', 'KA', 1),
(516, 'BIJAY BAHADUR SINGH', 'BBS', 1),
(517, 'PRABHAT BHATNAGER GIGER', 'PBG', 1),
(518, 'MALIK RAM', 'MAR', 1),
(519, 'RAMESH KR SHARMA', 'RK3', 1),
(520, 'DEV RAJ', 'DR', 1),
(521, 'MOHINI RAO', 'MOH', 1),
(522, 'BISHWAMITR UPADHYAY', 'BIU', 1),
(523, 'RAKESH BALA SECSENA', 'RB1', 1),
(524, 'NISHA AGGARWAL', 'NIA', 1),
(525, 'SRI LAL SUKL PREMJAN', 'SRI', 1),
(526, 'NARENDRA SINHA', 'NAS', 1),
(527, 'BIRENDRA MISHRA', 'BIM', 1),
(528, 'BHUBNESHWAR PD TRIBHUWAN', 'BPT', 1),
(529, 'CHEM CHANDR SUMAN', 'CCS', 1),
(530, 'NAGARJUN', 'NA1', 1),
(531, 'R RANGARAJAN', 'RR2', 1),
(532, 'SUDHA RANI', 'SR', 1),
(533, 'BHARAT BHUSAN SAROJ', 'BHB', 1),
(534, 'JAGDESH GUPT', 'JAG', 1),
(535, 'RAM BILAS SHARM', 'RB2', 1),
(536, 'SARWESHWAR DAYAL SHARMA', 'SD1', 1),
(537, 'AMIK BHANU', 'ABH', 1),
(538, 'SURENDRA SHARMA', 'SUS', 1),
(539, 'BISHNU NARAYAN BHARAT KHAND', 'BNB', 1),
(540, 'KANHAYA LAL NANDAN', 'KLN', 1),
(541, 'AMIT KUMAR', 'AMK', 1),
(542, 'SURYA KANT TRIPATHI NIRALA', 'SKT', 1),
(543, 'KAFI AZMI', 'KA4', 1),
(544, 'KEDAR NATH SINGH', 'KNS', 1),
(545, 'SUMITRA NANDAN PANT', 'SN1', 1),
(546, 'BISHNU KHER', 'BIS', 1),
(547, 'KAVI AJBIR', 'KAV', 1),
(548, 'RADHE SHAYAM PRAGALV', 'RS6', 1),
(549, 'JAMNADAS AKHTAR', 'JAA', 1),
(550, 'SHANTI SWARUP', 'SH1', 1),
(551, 'ANAND KOOSANTHAYAN', 'AN1', 1),
(552, 'HANSRAJ RAHBER', 'HAR', 1),
(553, 'ANAND JAIN', 'ANJ', 1),
(554, 'OMPRAKASH PALIWAL', 'OPP', 1),
(555, 'JITENDRA KR MITAL', 'JK1', 1),
(556, 'TRILOK DEEP', 'TRD', 1),
(557, 'BALJET BAGA KULDEP BAGA', 'BBK', 1),
(558, 'KAMLA SANSKRITYAYAN', 'KS1', 1),
(559, 'VIRAJ', 'VIR', 1),
(560, 'HARIDAT SHARMA', 'HA1', 1),
(561, 'M C AGGARWAL', 'MCA', 1),
(562, 'RAJENDRA PAL H C KATYAL', 'RHK', 1),
(563, 'P C WREN', 'PCW', 1),
(564, 'MAHESHWAR ROY', 'MA2', 1),
(565, 'ASHOK GUPTA', 'AS2', 1),
(566, 'R P SINHA', 'RPS', 1),
(567, 'N K AGGARWAL', 'NKA', 1),
(568, 'R N GOEL', 'RNG', 1),
(569, 'B JAMES', 'BJ', 1),
(570, 'RAVI CHOPRA', 'RAV', 1),
(571, 'G FRANKMAN & OTHERS', 'GFO', 1),
(572, 'ASHOK ARORA', 'AS1', 1),
(573, 'H MARTIN', 'HMA', 1),
(574, 'B K KISHOR', 'BKI', 1),
(575, 'A K CHATURVEDI', 'AK2', 1),
(576, 'B N AHUJA', 'BN2', 1),
(577, 'P K KAUL', 'PAK', 1),
(578, 'PRAKASH LAL & OTHERS', 'PLO', 1),
(579, 'BLADEMER DADEYAR', 'BD', 1),
(580, 'SANT KR VERMA', 'SKV', 1),
(581, 'GOREKH NATH CHAUBEY', 'GNC', 1),
(582, 'BHAI DAYAL JAIN', 'BDJ', 1),
(583, 'D R MANKEKAR', 'DR3', 1),
(584, 'JAI PRAKASH NARAYAN', 'JPN', 1),
(585, 'HIMANSU SRIVASTAW', 'HIS', 1),
(586, 'MAHESHWAR CHARY', 'MAC', 1),
(587, 'PUNYDEV NARAYAN SINGH & OTHER', 'PN2', 1),
(588, 'BINOD', 'BIN', 1),
(589, 'RANJAN SURIDEV RAVINDRA RAJHAN', 'RRR', 1),
(590, 'RAJESH SHARMA', 'RA3', 1),
(591, 'B K R B RAO', 'BRB', 1),
(592, 'MAHENDRA KUMAR GUPTA', 'MK1', 1),
(593, 'PRAMOD KR SHARMA', 'PK3', 1),
(594, 'PRABHU NARAYAN BIDYARTHI', 'PNB', 1),
(595, 'HANS KR TIWARI', 'HKT', 1),
(596, 'YOGRAJ WANI', 'YOW', 1),
(597, 'JEEVAN LAL PREM', 'JLP', 1),
(598, 'SUDARSHAN CHOPRA', 'SUC', 1),
(599, 'RAJENDRA AWASTHI', 'RAA', 1),
(600, 'RAMESH BAKSHI', 'RAB', 1),
(601, 'YADWENDU SHARMA', 'YAS', 1),
(602, 'PITAMBER PATEL', 'PIP', 1),
(603, 'BAL SHAUREY READEY', 'BS1', 1),
(604, 'SATYADEV NARAYAN SINHA', 'SN2', 1),
(605, 'VEENA SHRIVASTAW', 'VES', 1),
(606, 'JAYANT WACHASPATI', 'JAW', 1),
(607, 'HARI MOHAN SHARMA YOGRAJ', 'HMS', 1),
(608, 'AAREEG PUDE', 'AAP', 1),
(609, 'BINOD GUPT', 'BIG', 1),
(610, 'ROOPA GOSWAMI', 'ROG', 1),
(611, 'SARIT KR MUKHARJEE', 'SKM', 1),
(612, 'JAYBANS KISHOR BAKBER', 'JB3', 1),
(613, 'LILADHAR SHARMA PARWAT', 'LSP', 1),
(614, 'ACHARYA PARAMHANS PRAMOD', 'APP', 1),
(615, 'RAMCHANDRA PRASAD', 'RCP', 1),
(616, 'DENANATH DUBEY', 'DND', 1),
(617, 'PURUSOTAM NAGEKA OM', 'PSN', 1),
(618, 'RAJENDRA PD SINHA', 'RP7', 1),
(619, 'P C WREN & H MATIN', 'PWH', 1),
(620, 'R K CHOPRA & B B GAKHA', 'RBG', 1),
(621, 'SIDHNATH PRASAD', 'SNP', 1),
(622, 'BHOLA PANDIT', 'BHP', 1),
(623, 'A P PANDEY', 'AP1', 1),
(624, 'M L KHANA D SHARMA', 'MDS', 1),
(625, 'BASUDEO SINGH', 'BD2', 1),
(626, 'E R R MENUN', 'ERR', 1),
(627, 'S SINHA', 'SSN', 1),
(628, 'SAM PHILIPS', 'SAP', 1),
(629, 'ANNE SEATON', 'ANN', 1),
(630, 'JNDISH FOLSM', 'JF', 1),
(631, 'S S BHALES ANAND', 'SS7', 1),
(632, 'P P PANDIT', 'PPP', 1),
(633, 'R K MALHOTRA', 'RKM', 1),
(634, 'M M KULKARNI', 'MMK', 1),
(635, 'R LAKSHMI &R V', 'RLR', 1),
(636, 'MADHU DANTWALA', 'MA3', 1),
(637, 'SURENDRA MOHAN', 'SRM', 1),
(638, 'MAHESHWAR NEOG', 'MA4', 1),
(639, 'F C FREITAS', 'FCF', 1),
(640, 'S S PAGEDI', 'SS8', 1),
(641, 'OSCAR LEUY', 'OSL', 1),
(642, 'RAVINDRA NATH VERMA', 'RNV', 1),
(643, 'S CHATERJEE C CHATERJEE', 'SCC', 1),
(644, 'SUDHER PANT', 'SU4', 1),
(645, 'NAVAJTS', 'NAV', 1),
(646, 'LAEEG FUTEHALLY', 'LAF', 1),
(647, 'PRITAM SINGH', 'PR1', 1),
(648, 'T KITEHCEW', 'TKI', 1),
(649, 'Y D PHANKE', 'YDP', 1),
(650, 'JAYANT PANDYA', 'JAP', 1),
(651, 'G P PRADHAN', 'GPP', 1),
(652, 'LILA MAZUMDAR', 'LIM', 1),
(653, 'A MAHALNOBIS', 'AMA', 1),
(654, 'WAZIR SNGH', 'WAS', 1),
(655, 'V B KARNIK', 'VBK', 1),
(656, 'GOPAL SINGH', 'GOS', 1),
(657, 'LELLA GEORGE', 'LEG', 1),
(658, 'MAHADEO DESAI', 'MDE', 1),
(659, 'K M MUNSI', 'KM1', 1),
(660, 'WINSTEN S CHU', 'WSC', 1),
(661, 'SETU NAND HAVERS', 'SNH', 1),
(662, 'PHYLLIS WRAGGE', 'PW', 1),
(663, 'ASHWINI BHOUDWARI', 'ASB', 1),
(664, 'JAGGIT SINGH', 'JA2', 1),
(665, 'MADAN MOHAN MALVIYA', 'MM', 1),
(666, 'SWAMI TEJASWANEND', 'SWT', 1),
(667, 'CHARLS DICKEN', 'CH3', 1),
(668, 'G F ALEXANDER', 'GFA', 1),
(669, 'LOVIS FISHER', 'LF1', 1),
(670, 'S K BAJAJ & OTHERS', 'S B', 1),
(671, 'MORARJI DESAI', 'MD3', 1),
(672, 'K S PILLAI', 'KSP', 1),
(673, 'AMRIT RAVI', 'AMV', 1),
(674, 'MANOHER BANDHOPADHYAY', 'MAB', 1),
(675, 'DR S PAUL', 'DS1', 1),
(676, 'L S BUXI', 'LSB', 1),
(677, 'MD HASSAN', 'MDH', 1),
(678, 'T S RUKMANI', 'TSR', 1),
(679, 'W N KUWAR', 'WN1', 1),
(680, 'T R DEOGRI KOR', 'TRK', 1),
(681, 'A K MUKHARJEE', 'AK3', 1),
(682, 'C P RAASWAMI AIYAR', 'CPR', 1),
(683, 'N C JOG', 'NCJ', 1),
(684, 'MUSHISUL HASSAN', 'MH1', 1),
(685, 'B N PANDE', 'B N', 1),
(686, 'D R MAHEKAR', 'DR1', 1),
(687, 'A P J ABDUL KALAM', 'AJK', 1),
(688, 'ROMAIN ROLLARD', 'RR4', 1),
(689, 'DILIP M SALVI', 'DM2', 1),
(690, 'K G BALKRISHN PILLAI', 'KGB', 1),
(691, 'JAGDESH CHANDRA JAIN', 'JCJ', 1),
(692, 'PRANNATH SETH', 'PN3', 1),
(693, 'PRABHA CHARNE', 'PRC', 1),
(694, 'RAJENDRA KR RAJEEV', 'RKR', 1),
(695, 'PUSHPENDRA KUMAR', 'PUK', 1),
(696, 'K R SRINIVASAN', 'KR5', 1),
(697, 'KRISHNA DEVA', 'KSD', 1),
(698, 'SUPRIYA GUHA', 'SG6', 1),
(699, 'H M PATEL', 'HMP', 1),
(700, 'KHAWAJA AHMAD ABBAS', 'KA6', 1),
(701, 'INDR RAJ SINGH', 'IR1', 1),
(702, 'SHRAWAN KUMAR GOSAWAMI', 'SK4', 1),
(703, 'MADAN GOPAL', 'MAE', 1),
(704, 'MANU SHARMA', 'MAS', 1),
(705, 'R KUMAR', 'RKU', 1),
(706, 'G P NENE', 'GPN', 1),
(707, 'SITARAM CHATURVEDI', 'SRC', 1),
(708, 'NAMBER SINGH', 'NAM', 1),
(709, 'DR M HAKIM KIDWAI', 'DMH', 1),
(710, 'MADHURI PAL', 'MAP', 1),
(711, 'BALMIKE CHAUDHARY', 'BAC', 1),
(712, 'J T RAMAN', 'JTR', 1),
(713, 'OM PRAKASH SHARMA SHASTRI', 'OPS', 1),
(714, 'KARTAR SINGH DUGGAL', 'KS2', 1),
(715, 'MUKOT KUNHAPA', 'MK', 1),
(716, 'W N KUBBER', 'WNK', 1),
(717, 'DEVI PRASAD', 'DEP', 1),
(718, 'L G JOG', 'LGJ', 1),
(719, 'NIJAMUDEEN AULIYA', 'NIJ', 1),
(720, 'RUP NARAYAN', 'RUN', 1),
(721, 'AJAY KUMAR KOTHARI', 'AKK', 1),
(722, 'BHAGWATI SARAN SINGH', 'BS2', 1),
(723, 'DHANPATI PANDEY', 'DHP', 1),
(724, 'BISWA PRIYA MUKHARJEE', 'BPM', 1),
(725, 'DR BINAY', 'DBI', 1),
(726, 'MAHARSI ADWETANAND', 'MAA', 1),
(727, 'TRAYAMBAK RAGHUNATH DEVGIREKAR', 'TR1', 1),
(728, 'TRIPURARI RAM', 'TRR', 1),
(729, 'MUKUT BIHARI VERMA', 'MBV', 1),
(730, 'JIYAUDEEN ANSARI', 'JIA', 1),
(731, 'SAOMENDRA NATH THAKUR', 'SNT', 1),
(732, 'INDRA SWAPN', 'ISW', 1),
(733, 'SARAL KUMAR CHATERJEE', 'SKC', 1),
(734, 'DR RADHAKRISHNAN', 'DR6', 1),
(735, 'DR MOTILAL BHARDAW', 'MLB', 1),
(736, 'DR DARSHAN SETHI', 'DDS', 1),
(737, 'SAT SONI', 'SAS', 1),
(738, 'BIJAY AGGARWAL', 'BIA', 1),
(739, 'JAFER AHMED NIJAMI', 'JA3', 1),
(740, 'S P PANDIT', 'SPP', 1),
(741, 'SUDHAKAR PANDEY', 'SUD', 1),
(742, 'R PARTHSARTHI', 'RP1', 1),
(743, 'RAVINDRA KALEKAR', 'RNK', 1),
(744, 'FIROJ CHAND', 'FIC', 1),
(745, 'B B KULKARNI', 'BB2', 1),
(746, 'HIRANMAY BANARJEE', 'HMB', 1),
(747, 'LUXMI KANT VERMA', 'LKV', 1),
(748, 'RAJENDRA SINGH WATS', 'RSW', 1),
(749, 'M CHATURVEDI', 'MCV', 1),
(750, 'SWAMI APURWANAND', 'SAN', 1),
(751, 'SATYNARAYAN RAY S K VERMA', 'SSV', 1),
(752, 'PODAR RAMAWATAR ARUN', 'PR7', 1),
(753, 'BISHWAMITRA SHARMA', 'BMS', 1),
(754, 'BIRENDRA KR BHATACHARYA', 'BK2', 1),
(755, 'M C JOG', 'MCJ', 1),
(756, 'RETA BAHUGUNA JOSHI R N TRIPA', 'RBJ', 1),
(757, 'SHIV SAGAR MISHR', 'SM0', 1),
(758, 'B S SAKLATWALA & K KHOSLA', 'BKK', 1),
(759, 'BINAY GHOSH', 'BI1', 1),
(760, 'TARA ALI BEG', 'TA1', 1),
(761, 'KAMLA PRASAD', 'KAP', 1),
(762, 'AJIT KUMAR', 'AJ1', 1),
(763, 'JITENDRA NATH SANYAL', 'JN1', 1),
(764, 'BASANT BOON', 'BA1', 1),
(765, 'SEREE MUKHVE', 'SEM', 1),
(766, 'NARENDRA SHARMA', 'NDS', 1),
(767, 'U R RAO', 'URR', 1),
(768, 'BIYOM HARI', 'BIH', 1),
(769, 'G L CHANDAWKER', 'GL1', 1),
(770, 'SHYAM BIHARI SWARUP', 'SB3', 1),
(771, 'SATISH KUMAR', 'SA2', 1),
(772, 'JAWAHAR LAL NEHRU', 'JLN', 1),
(773, 'DEVENDRA CHANDRA', 'DDC', 1),
(774, 'KRISHN KUMAR', 'KR1', 1),
(775, 'DR BIRENDRA BHATNAGAR', 'BDB', 1),
(776, 'MULK RAJ ANAND', 'MR1', 1),
(777, 'DURGA PRASAD SUKLA', 'DP1', 1),
(778, 'DR NIRMAL JAIN', 'DNJ', 1),
(779, 'SHELA JHUNJHUNWALA', 'SJJ', 1),
(780, 'DEVKINANDAN PRASAD', 'DNP', 1),
(781, 'DR M G MALI', 'MGM', 1),
(782, 'CHITIJ RAM', 'CHR', 1),
(783, 'JANAK DULARI PRASAD', 'JDP', 1),
(784, 'SANJAY GUPTA', 'SA1', 1),
(785, 'M P KAMAL', 'MP', 1),
(786, 'VIVEK MOHAN', 'VIM', 1),
(787, 'ONKAR SARAD', 'ONS', 1),
(788, 'DR RAJESHWAR PD CHATURVEDI', 'RP4', 1),
(789, 'SOBHA KANT', 'SOK', 1),
(790, 'BISHWANATH', 'BWN', 1),
(791, 'CHANDRASEKHER SHASTRI', 'CSS', 1),
(792, 'BIRENDRA SIDHU', 'BI2', 1),
(793, 'RAJ BAHADUR SINGH', 'RB3', 1),
(794, 'S RADHA KRISHNAN', 'SR4', 1),
(795, 'RAJENDRA MOHAN BHATNAGAR', 'RMB', 1),
(796, 'FILIP KEN', 'FK', 1),
(797, 'SHANTIMAY CHATERJEE', 'SMC', 1),
(798, 'BISHWANATH TIWARY', 'BTY', 1),
(799, 'PREMA NAND KUMAR', 'PN4', 1),
(800, 'KAMLA DUT PANDEY', 'KDP', 1),
(801, 'SHAKTI M GUPTA', 'SMG', 1),
(802, 'BHESM SAHNI', 'BHS', 1),
(803, 'AWADHES KR CHATURVEDI', 'AK5', 1),
(804, 'ABID RIJWE', 'ABI', 1),
(805, 'GUNAKAR MULE', 'GUM', 1),
(806, 'R M LALA', 'RL', 1),
(807, 'SUSHIL NAYAR KAMAL MANDEKAR', 'SK6', 1),
(808, 'NIRMAL JAIN', 'NI1', 1),
(809, 'B CHATENYDEO', 'BCD', 1),
(810, 'KIRAN GUPTA', 'KIG', 1),
(811, 'B K CHATURVEDI', 'BKC', 1),
(812, 'ANNURADHA RAY', 'ARR', 1),
(813, 'M SHARMA', 'MS1', 1),
(814, 'ARUN BHA', 'ARB', 1),
(815, 'SHYAM DUA', 'SHD', 1),
(816, 'GANESH PRASAD', 'GAP', 1),
(817, 'V K NARSIMHAM', 'VKN', 1),
(818, 'GAGI CHAKRWARTI', 'GAC', 1),
(819, 'K SWAMINATHEN', 'KSN', 1),
(820, 'A N KOTHARI & OTHERS', 'ANO', 1),
(821, 'MURKOT KANAMA', 'MUK', 1),
(822, 'SOBHIT MAHAJAN', 'SOM', 1),
(823, 'K V GOPAL KRISHNAN', 'KVG', 1),
(824, 'M K GANDHI', 'MKG', 1),
(825, 'K P BHANUMATHY', 'KPB', 1),
(826, 'S A AYER', 'SAA', 1),
(827, 'G M PAWAR', 'GMP', 1),
(828, 'KORNEI CHUKOVSKY', 'KC3', 1),
(829, 'FRANCES RAVIRA', 'FR', 1),
(830, 'MICHAEL ROSEN', 'MIR', 1),
(831, 'MAIKE KARST KAREL', 'MKK', 1),
(832, 'HADJAK GYULNAZAYAN', 'HG', 1),
(833, 'REGINALD BOSANQUEET', 'RB8', 1),
(834, 'ANNA SEWELL', 'AS0', 1),
(835, 'MARY SHELLY', 'MS', 1),
(836, 'JONATHAN SWIFT', 'JOS', 1),
(837, 'LOUISA M ALOTLA', 'LM1', 1),
(838, 'EDGAR ALLAN POE', 'EAP', 1),
(839, 'JULES VEVNE', 'JV1', 1),
(840, 'CHARLES DICKEN', 'CD', 1),
(841, 'MARK TWEIN', 'MA9', 1),
(842, 'ROBERT LOUIS STEVENSON', 'RL4', 1),
(843, 'JULES VESNE', 'JV', 1),
(844, 'A CONEN DOUK', 'ACD', 1),
(845, 'JAYSHREE', 'JAY', 1),
(846, 'LOVELAN KAKACKER', 'LK', 1),
(847, 'SHANTA R RAO', 'SR5', 1),
(848, 'ANITA SARAV', 'AN3', 1),
(849, 'CHERYL RAO', 'CR2', 1),
(850, 'A K SRIVASTAV', 'AK6', 1),
(851, 'RAJIV TIWARI', 'RA6', 1),
(852, 'PRACHI GUPTA', 'PRG', 1),
(853, 'SANDEEP GUPTA', 'SA3', 1),
(854, 'P M JOSHI', 'PMJ', 1),
(855, 'S P K NAGHMA ZAFR', 'SNZ', 1),
(856, 'PRITHVI VISHNU GAYA', 'PVG', 1),
(857, 'ANITA INDER SINGH', 'AI1', 1),
(858, 'MUKUND SWARUP VERMA', 'MSV', 1),
(859, 'SHIV NATH PRASAD', 'SN5', 1),
(860, 'DAMODER SHARMA', 'DAS', 1),
(861, 'SHIVNATH PRASAD', 'SN8', 1),
(862, 'C S GUPTA', 'CSG', 1),
(863, 'L M PARSONS', 'LMP', 1),
(864, 'A H HASMI', 'AHH', 1),
(865, 'B N BHARB', 'BN4', 1),
(866, 'BIDYASAGAR', 'BID', 1),
(867, 'T SHARMA', 'TSH', 1),
(868, 'JOSEOH HEITHER', 'JH1', 1),
(869, 'RAM NIWAS RAM', 'RN4', 1),
(870, 'S RAMAMRUTHAM', 'SRT', 1),
(871, 'GSATIN VES', 'GV', 1),
(872, 'D P SEN GUPTA', 'DGT', 1),
(873, 'SUNIL B ATHWALE', 'SB2', 1),
(874, 'A M P UMER KULTY', 'AUK', 1),
(875, 'LACEG FUTEHALLY', 'LF', 1),
(876, 'HARI PRAKASH GERG', 'HPG', 1),
(877, 'M S GIRI', 'MS2', 1),
(878, 'SUDHANSU KR JAIN', 'SK7', 1),
(879, 'PARUL R SHETH', 'PRS', 1),
(880, 'P J LAVAKARE', 'PJ1', 1),
(881, 'A K MALHOTRA', 'AKM', 1),
(882, 'A K BAKHSI', 'AK7', 1),
(883, 'BHEDRA SEN', 'BS;', 1),
(884, 'MANISH CHANDRA UTAK', 'MCU', 1),
(885, 'U S SRIVASTAV', 'US1', 1),
(886, 'YOGETA PRAB', 'YOP', 1),
(887, 'NILIMA SHRIVASTAV', 'NS2', 1),
(888, 'SURYA P RAO', 'SPR', 1),
(889, 'DEPTI DEOBAGKAR', 'DE1', 1),
(890, 'YATISH AGGARWAL', 'YAA', 1),
(891, 'BIJAY GUPTA', 'BI4', 1),
(892, 'N NANIBHASKARAN', 'NNB', 1),
(893, 'S M NAIR', 'SMN', 1),
(894, 'BIMAN BASU', 'BIB', 1),
(895, 'INDUMATI RAO C N R RAO', 'IRR', 1),
(896, 'INDUMATI RAO', 'IMR', 1),
(897, 'G K BHINDE', 'GKB', 1),
(898, 'ANIL AGGARWAL', 'AAG', 1),
(899, 'MOHAL SUNDESA RANJAN', 'MSR', 1),
(900, 'RAMESH BEDI', 'RSB', 1),
(901, 'CHEIRO', 'CHE', 1),
(902, 'ALAN LIA', 'ALL', 1),
(903, 'I A RICHERDS', 'IAR', 1),
(904, 'H S BEGHALA', 'HSB', 1),
(905, 'DR DHARMPAL CHAUDHARY', 'DC1', 1),
(906, 'RAM BINAYAK SINGH', 'RB5', 1),
(907, 'ANDREUD MOUR', 'AN4', 1),
(908, 'NEEMA KHANNA', 'NE', 1),
(909, 'NIRMALA GUPTA', 'NIG', 1),
(910, 'RABERT G MEMARS', 'RGM', 1),
(911, 'ROMILA THAPER', 'RT1', 1),
(912, 'RICHERD WEBSTER', 'RIW', 1),
(913, 'M A RAO', 'MA5', 1),
(914, 'N DIXET', 'NDI', 1),
(915, 'DILRAJ SINGH', 'DR4', 1),
(916, 'SHYAM CHANDRA KAPOOR', 'SHC', 1),
(917, 'KIRAN VERMA', 'KIV', 1),
(918, 'O P AGGARWAL', 'OP5', 1),
(919, 'SWAMI DAYAL BHARTI', 'SDB', 1),
(920, 'J MOHANTY', 'JMO', 1),
(921, 'DON ASSET', 'DOA', 1),
(922, 'HARGET SINGH GANDHI', 'HSG', 1),
(923, 'S ABID HUSAN', 'SA5', 1),
(924, 'KAKA SAHEB KALKEKAR', 'KS3', 1),
(925, 'DR PHUL GENDA SINGH', 'PGS', 1),
(926, 'RAM CHARAN GUPT', 'RC5', 1),
(927, 'G K ARYA', 'GK3', 1),
(928, 'W A WHILIAN', 'WAW', 1),
(929, 'TEJINDRA', 'TEJ', 1),
(930, 'H C PRADHAN', 'HCP', 1),
(931, 'KIRAN SUD', 'KIS', 1),
(932, 'MEDHA S ROY D K S DATTA', 'MRD', 1),
(933, 'R M BHAKT', 'RM2', 1),
(934, 'JERY DURHIS', 'JED', 1),
(935, 'ANANT RAM NIGAM', 'AR4', 1),
(936, 'BRAD FORD SMITH', 'BFM', 1),
(937, 'KRISHAN CHAND', 'KRC', 1),
(938, 'BIMAL PRASAD', 'BIP', 1),
(939, 'SUBHASH C KASYAP', 'SC3', 1),
(940, 'M K SANTHANAN', 'MK3', 1),
(941, 'SUREKHA PANANDIKAR I S M SINH', 'SPI', 1),
(942, 'K V SINGH', 'KVS', 1),
(943, 'DR GORAKH PRASAD', 'DGP', 1),
(944, 'THAKUR DAS', 'THD', 1),
(945, 'C P SINGH DEO', 'CPD', 1),
(946, 'V R DUTTA', 'VRD', 1),
(947, 'DR HARI BANS TARUN', 'HBT', 1),
(948, 'BAL MUKUND AGGARWWAL', 'BM1', 1),
(949, 'SHANKAR MOHAN MATHUR', 'SM2', 1),
(950, 'ANIL KUMAR', 'AN5', 1),
(951, 'DAVID BALLTHA', 'DA1', 1),
(952, 'S C DUBE', 'SC5', 1),
(953, 'SHELA DHER', 'SH5', 1),
(954, 'SUNIL BALKHER', 'SB4', 1),
(955, 'SURESH MANDHAI', 'SUM', 1),
(956, 'RAMPHEL SINGH', 'RP8', 1),
(957, 'S C JOHARI', 'SCJ', 1),
(958, 'SUBHAS B KASHYAP', 'SBK', 1),
(959, 'H R GHOSAL', 'HRG', 1),
(960, 'UPINDR SINGH', 'UPS', 1),
(961, 'DR PUKHRAJ JAIN', 'DPJ', 1),
(962, 'AMARTY SEN', 'AMS', 1),
(963, 'JASLEN DHANEJA', 'JD', 1),
(964, 'N N OJHA', 'NO1', 1),
(965, 'IRFAN HABIB', 'IRH', 1),
(966, 'RAM SARAN SHARMA', 'RS9', 1),
(967, 'DAMODER KARMANAND  ASWE', 'DKA', 1),
(968, 'SUMIT SARKAR', 'SUK', 1),
(969, 'LEAH LEAVIN', 'LL1', 1),
(970, 'GAUTAM SHARMA', 'GAS', 1),
(971, 'J ABID HASAN', 'JAH', 1),
(972, 'DAVID BETHAM & OTHERS', 'DBO', 1),
(973, 'S M MATHUR', 'SM3', 1),
(974, 'SHAYAM SUNDER SHARMA', 'SS9', 1),
(975, 'G ARORA', 'G', 1),
(976, 'M R SETHI', 'MRS', 1),
(977, 'REINU BHANT', 'REB', 1),
(978, 'SNEHA VIZ', 'SNV', 1),
(979, 'SHASHI JAIN', 'SHJ', 1),
(980, 'MANISHA MIRULAH', 'MA6', 1),
(981, 'T K LAHIRI', 'TKL', 1),
(982, 'REKHA CHANDRA', 'RC2', 1),
(983, 'JENS NELSON', 'JN3', 1),
(984, 'ANAND SAGAR', 'AN6', 1),
(985, 'ARUN ARNAW', 'ARA', 1),
(986, 'B N AHUJA', 'BN1', 1),
(987, 'DAVID PRITEHURD', 'DAP', 1),
(988, 'SUNITA GUPTA', 'SU3', 1),
(989, 'HARISH YADAV', 'HY', 1),
(990, 'O P KHATRI', 'OP7', 1),
(991, 'ANUJ GOSWAMI', 'AG', 1),
(992, 'SALHIN SINGAL', 'SA7', 1),
(993, 'R LAKHMI', 'RLA', 1),
(994, 'GUPTA &VARNIST', 'G&V', 1),
(995, 'RAJENDRA SRIVASTAV', 'RST', 1),
(996, 'VALERIE PIH', 'VAP', 1),
(997, 'B P BHATNAGER', 'BPB', 1),
(998, 'DR BALKRISHN', 'DBK', 1),
(999, 'KEISH LYE', 'KL', 1),
(1000, 'RUSSEL ASH', 'RA8', 1),
(1001, 'RAJEEV PRATAP RURHI', 'RP9', 1),
(1002, 'S K BATRA', 'SK8', 1),
(1003, 'GRALE MARIT', 'GM2', 1),
(1004, 'DAVID MUDGEH', 'DAM', 1),
(1005, 'PHILIP JOHN', 'PHJ', 1),
(1006, 'PANDIT RAMCHANDRA PATHAK', 'PR5', 1),
(1007, 'L K SHARMA', 'LKS', 1),
(1008, 'S K TULI', 'SK9', 1),
(1009, 'MADHU ARORA', 'MA8', 1),
(1010, 'J ANAND', 'JA4', 1),
(1011, 'DHAMU K BHUTANI A C SUKLA', 'DK5', 1),
(1012, 'V P JAGGI', 'VPJ', 1),
(1013, 'KIT PARRY', 'KIP', 1),
(1014, 'JONS NELSEN', 'JON', 1),
(1015, 'SHIRLEY BURRIDGE', 'SHB', 1),
(1016, 'AMY L B J D J S', 'ALJ', 1),
(1017, 'ASHA PURI', 'AP4', 1),
(1018, 'HARDEO BEHARI', 'HA2', 1),
(1019, 'BETTY KIRK PARICK', 'BKP', 1),
(1020, 'T C SINGH', 'TCS', 1),
(1021, 'NESKNT', 'NES', 1),
(1022, 'RUDYYORD KIPLING', 'RUK', 1),
(1023, 'GEORGE ELIOT', 'GE', 1),
(1024, 'MARY MAPES DODGE', 'MM2', 1),
(1025, 'BERNARD SHOW', 'BS4', 1),
(1026, 'VICTOR HOGO', 'VIH', 1),
(1027, 'RUSKIN BOND', 'RB6', 1),
(1028, 'P V NARSEMHA RAO', 'PVN', 1),
(1029, 'R L STINE', 'RLS', 1),
(1030, 'THONAS HERDY', 'THH', 1),
(1031, 'OSCER WILDE', 'OSW', 1),
(1032, 'WALTER SCOTT', 'WA1', 1),
(1033, 'ERNEST HEMIGWAY', 'ERH', 1),
(1034, 'LORD LYTLON', 'LOL', 1),
(1035, 'ANTHENY WOPE', 'ANT', 1),
(1036, 'RICHNAL COMPTON', 'RIC', 1),
(1037, 'P G WODEHOUSE', 'PGW', 1),
(1038, 'ARUN SHOURIE', 'ARU', 1),
(1039, 'DANIAL DEFOE', 'DD', 1),
(1040, 'RUDYARD KIPLING', 'RUD', 1),
(1041, 'J K ROWLING', 'JKR', 1),
(1042, 'JIYAUL HASAN KARUBE', 'JHK', 1),
(1043, 'JAGARNATH SHARMA', 'JA6', 1),
(1044, 'BISHWANATH PRASAD', 'BN7', 1),
(1045, 'MAHADEVI VERMA', 'MDV', 1),
(1046, 'KESHAW PD SINGH', 'KPS', 1),
(1047, 'RAJ KUMAR NIJAT', 'RKN', 1),
(1048, 'RAM BILAS GUPTA', 'RB4', 1),
(1049, 'RAMESHWAR NATH GOUR', 'RN5', 1),
(1050, 'GANPATI CHANDRA GUPTA', 'GCG', 1),
(1051, 'DR USHA VERMA', 'DUV', 1),
(1052, 'R N RAI', 'RN7', 1),
(1053, 'KANWAR DEEPAK', 'KAD', 1),
(1054, 'Y P PURANG', 'YPP', 1),
(1055, 'POOJA BHATIA', 'POB', 1),
(1056, 'SUNITA JAISINGH', 'SJ6', 1),
(1057, 'RENITA ABB', 'REA', 1),
(1058, 'K C TYAGI', 'KCT', 1),
(1059, 'BIHARI SINGH', 'BII', 1),
(1060, 'SUBHRA DAS', 'SHR', 1),
(1061, 'A AGGARWAL', 'AA2', 1),
(1062, 'SUMAN PODDAR', 'SU5', 1),
(1063, 'ANIL MADAN', 'AN7', 1),
(1064, 'V B AGGARWAL', 'VBA', 1),
(1065, 'MUKUL NARSIMHA', 'MUN', 1),
(1066, 'RABERT SHARF', 'RA4', 1),
(1067, 'V K JAIN', 'VKJ', 1),
(1068, 'P B MAHAPATRA', 'PBM', 1),
(1069, 'SUMITA ARORA', 'SU7', 1),
(1070, 'PETER KANT', 'PEK', 1),
(1071, 'BILL KLING', 'BLK', 1),
(1072, 'TOM SHELDIN', 'TOS', 1),
(1073, 'RON S COTTEEFIED', 'RSC', 1),
(1074, 'DANY GOODMAN', 'DAG', 1),
(1075, 'SEAMUS DUNN', 'SED', 1),
(1076, 'ARUN SONI', 'AS6', 1),
(1077, 'SARA MATHEW', 'SMH', 1),
(1078, 'KAMAL SUKL', 'KS', 1),
(1079, 'VASU BHATACHARYA & OTHERS', 'VBO', 1),
(1080, 'SANDEEP CHOPRA', 'SDC', 1),
(1081, 'SHASHANK SAHNI', 'SH7', 1),
(1082, 'N SUBHRANYAM', 'NSM', 1),
(1083, 'C K SETH', 'CKS', 1),
(1084, 'S GREWAL', 'SGW', 1),
(1085, 'SANGETA PANCHAL', 'SGP', 1),
(1086, 'A K SHARMA', 'AK9', 1),
(1087, 'ROBERT LAFERE', 'ROL', 1),
(1088, 'LOUISH UNTER MEYAR', 'LUM', 1),
(1089, 'THOMAS HUTCHINSON', 'TH', 1),
(1090, 'AET BORSD & J FUT', 'ABJ', 1),
(1091, 'N MUKUNDA', 'NMU', 1),
(1092, 'H SHARAT CHANDRA', 'HSA', 1),
(1093, 'S R SETJE', 'SR7', 1),
(1094, 'G SRINEVASAN', 'GSN', 1),
(1095, 'USHA DUTTA', 'USD', 1),
(1096, 'RAJKUMAR GUPT', 'RJH', 1),
(1097, 'PURAN CHAND', 'PUC', 1),
(1098, 'C S MAGARJU', 'CSM', 1),
(1099, 'DEBYANI CHATERJEE', 'DEC', 1),
(1100, 'M CHOKSI', 'MC', 1),
(1101, 'H M HULME', 'HMH', 1),
(1102, 'SHAKESPEARE', 'SH0', 1),
(1103, 'J C DENT', 'JCD', 1),
(1104, 'JOHN MAYDFIULD', 'JOM', 1),
(1105, 'MISSION EZE KIEL', 'MEK', 1),
(1106, 'E V RIOV', 'EVR', 1),
(1107, 'ROBERT LOUIS STENONSEN', 'RL1', 1),
(1108, 'JAMES HILTON', 'JH', 1),
(1109, 'GNID BFYTON', 'GB1', 1),
(1110, 'LORD LYTTON', 'LL', 1),
(1111, 'MARGERY GUEN', 'MG1', 1),
(1112, 'ASHOK KUMR', 'ASK', 1),
(1113, 'JOHANNA SPYSI', 'JS1', 1),
(1114, 'JIM RAZZI', 'JR', 1),
(1115, 'R D BIFIELD', 'RDB', 1),
(1116, 'JOHAN BROODHEAD', 'JB', 1),
(1117, 'NENA VON LEYTEN', 'NVL', 1),
(1118, 'HERMAN MELVIL', 'HM', 1),
(1119, 'JANE AUSTEN', 'JA5', 1),
(1120, 'CHARLOTLE BRONTO', 'CB2', 1),
(1121, 'ALEXANDER DUMAS', 'AD4', 1),
(1122, 'S B PALES', 'SB.', 1),
(1123, 'SHOBHANA MALLIKARJUNAN', 'SML', 1),
(1124, 'STEPHEN GRANE', 'SG4', 1),
(1125, 'WILKIE COLLINS', 'WC', 1),
(1126, 'MAZHASHUL HAQUE', 'MH', 1),
(1127, 'PRIYANKA GULATI', 'PG', 1),
(1128, 'H C KATYAL S L D S K BAJAJ', 'HCK', 1),
(1129, 'LOUSIA M ALCOTT', 'LMA', 1),
(1130, 'KRISHNA SALYANAND', 'KS8', 1),
(1131, 'ARTHUR CONAN DOYLI', 'AC9', 1),
(1132, 'R L S LEVENSON', 'RLE', 1),
(1133, 'EVIEL BHYTON', 'EB', 1),
(1134, 'ST MARTIN PAPER BOOK', 'SMP', 1),
(1135, 'GIN FIRSHAY LUSFORD', 'GFL', 1),
(1136, 'ALBERTO MORAVIA', 'AM3', 1),
(1137, 'CAROLYN KEONE', 'CK', 1),
(1138, 'JONOOTHAN SUIFT', 'JS2', 1),
(1139, 'A BRYYLANTS', 'AB2', 1),
(1140, 'JOAN MALINTESH', 'JM1', 1),
(1141, 'STUART TROTLER', 'ST', 1),
(1142, 'Y P RANADE', 'YPR', 1),
(1143, 'R K JAIN', 'RKJ', 1),
(1144, 'PROF YOGENDRA MISHRA', 'YM', 1),
(1145, 'VANDANA SHARMA', 'VDS', 1),
(1146, 'ALEXANDER S JOP', 'ASJ', 1),
(1147, 'KUNDRA & BANLA', 'K&B', 1),
(1148, 'HARI PRASAD THEPNIYAL', 'HPT', 1),
(1149, 'K S RANDHAVEA S S MINHAS', 'KS4', 1),
(1150, 'XAVIER PINTO & OTHERS', 'XPO', 1),
(1151, 'A S KHURANA', 'AKH', 1),
(1152, 'PUSHPA JAIN', 'PUS', 1),
(1153, 'S.K.SETHI', 'STH', 1),
(1154, 'S.K.SETHI & OTHERS', 'STO', 1),
(1155, 'YASHOBIMLANAND', 'YBN', 1),
(1156, 'MAHENDRA MATTAL', 'MHM', 1),
(1157, 'SRI RAM SHARMA RAM', 'SR.', 1),
(1158, 'MREGESH', 'MRE', 1),
(1159, 'HEMANSHU JOSHI', 'HJ', 1),
(1160, 'PRATAP NARAYAN SHRIVASTAV', 'PN6', 1),
(1161, 'A RAMESH CHAUDHARY', 'ARC', 1),
(1162, 'GOVIND BALABH PANT', 'GBP', 1),
(1163, 'YADEVCHANDRA JAIN', 'YCJ', 1),
(1164, 'VIDYASAGAR VERMA', 'VSV', 1),
(1165, 'HARNAM DAS SAHRAI', 'HDS', 1),
(1166, 'PYARE LAL WEDEL', 'PLW', 1),
(1167, 'BHAGWATE PRASAD BAAJPEY', 'BWP', 1),
(1168, 'DR G N AAWTE', 'DGN', 1),
(1169, 'BIMAL MITR', 'BM', 1),
(1170, 'SANHAYYALAL OJHA', 'SYO', 1),
(1171, 'ROOP CHANDR SETH', 'ROC', 1),
(1172, 'JAGDESH JAGESH', 'JDJ', 1),
(1173, 'GO NE DANDEKAR', 'GO', 1),
(1174, 'HELEN MEKINS', 'HMK', 1),
(1175, 'RAMAN LAL BASANT LAL DESAI', 'RLB', 1),
(1176, 'RADHE SHAYAM PRAGALBH', 'RDE', 1),
(1177, 'BIMAL', 'BI', 1),
(1178, 'DR GAURI SHANKAR RAJHANS', 'DGS', 1),
(1179, 'LUXMI NEWAS BERLA', 'LUX', 1),
(1180, 'STEPHEN JWEG', 'STJ', 1),
(1181, 'HAZARE PD DEWEDE', 'HPZ', 1),
(1182, 'NARENDRA PAL SINGH', 'NPS', 1),
(1183, 'DR BHAGWATE SARAN MISHR', 'DBW', 1),
(1184, 'GADADHER NARAYAN', 'GDD', 1),
(1185, 'SANTOSH SHAILJA', 'SOJ', 1),
(1186, 'PHANESHWAR NATH RENU', 'PWN', 1),
(1187, 'RANGEY RAGHAW', 'RR', 1),
(1188, 'INDR VIDYAWACHESPATI', 'INV', 1),
(1189, 'MANOJ BASU', 'MJB', 1),
(1190, 'SATRUGHAN LAL SHUKL', 'STL', 1),
(1191, 'BHIKHU', 'BHI', 1),
(1192, 'KRISHN PRASAD MISHR', 'KRH', 1),
(1193, 'AACHARYA CHATURSEN', 'AYC', 1),
(1194, 'HELENA HODACHOWA', 'HHC', 1),
(1195, 'KRISHAN CHANDR SHARMA BHEKHU', 'KCB', 1),
(1196, 'MADHU BHADURI', 'MBU', 1),
(1197, 'VIMAL KAR', 'VMK', 1),
(1198, 'B S KHANDEKAR', 'BKD', 1),
(1199, 'SONYA SURBHI', 'SON', 1),
(1200, 'PRAMOD KR AGGARWAL', 'PKA', 1),
(1201, 'MAYANAND MISHR', 'MYN', 1),
(1202, 'SUNIL GANGOPADHYAY', 'SG2', 1),
(1203, 'DR LUXMI NARAYAN', 'LUN', 1),
(1204, 'DEWKE NANDAN KHATRI', 'DWN', 1),
(1205, 'BISHWANATH MUKHARGE', 'BMU', 1),
(1206, 'DR SUMATI CHETRBHADE', 'DSC', 1),
(1207, 'WAIDEHE SINHA', 'WDS', 1),
(1208, 'RADHA KRISHN PRASAD', 'RDK', 1),
(1209, 'KAMAL SHUKL', 'KSU', 1),
(1210, 'RAMDARAS MISHR', 'RDR', 1),
(1211, 'BIJAY PRAKASH BARI', 'BP2', 1),
(1212, 'SARWDEW SINGH', 'SWS', 1),
(1213, 'RAM PRAKASH KAPOOR', 'RPK', 1),
(1214, 'HIMATLAL SANADHYA', 'HIM', 1),
(1215, 'RAM PRASAD MISHR', 'RP0', 1),
(1216, 'GETA CHAUDHARY', 'GCD', 1),
(1217, 'UMESH PD SINGH', 'UP2', 1),
(1218, 'KUDNEKA KAPAREYA', 'KUD', 1),
(1219, 'UMESH KR SINGH', 'UKS', 1),
(1220, 'DR DEVRAJ', 'DDR', 1),
(1221, 'RAJENDRA YADEV', 'RDY', 1),
(1222, 'DHARMBEER BHARTI', 'DBB', 1),
(1223, 'GOVIND SINGH', 'GS', 1),
(1224, 'AMRESH', 'AM2', 1),
(1225, 'SUSHIL KUMAR', 'SK0', 1),
(1226, 'CHANDRABHAN JOUHARI', 'CBJ', 1),
(1227, 'RAMKESHWAR PERDESI', 'RKP', 1),
(1228, 'KANCHAN BAL SABHARWAL', 'KB2', 1),
(1229, 'KRISHN BHAWUK', 'KB', 1),
(1230, 'PRADEEP KR DUBEY', 'PKD', 1),
(1231, 'SARASWATI SARAN KAIF', 'SKF', 1),
(1232, 'KRISHN MANU', 'KM', 1),
(1233, 'ASHWATM', 'AS4', 1),
(1234, 'SRI KRISHAN MAYUS', 'SMY', 1),
(1235, 'NIHAL CHAND VERMA', 'NCV', 1),
(1236, 'OM PRASAD NIRMAL', 'OPN', 1),
(1237, 'LATIF MUKHMDEO', 'LMM', 1),
(1238, 'RAMKRISHAN MISHR', 'RKI', 1),
(1239, 'SURENDRA VERMA', 'SDV', 1),
(1240, 'RAMAKANT', 'RK', 1),
(1241, 'TAHMINA DURRANI', 'TMD', 1),
(1242, 'KIRAN BEDI', 'KB1', 1),
(1243, 'PADMA SACHDEWA', 'PSD', 1),
(1244, 'USHA PRIYABANDA', 'UPB', 1),
(1245, 'HEMANT SHARMA', 'HS', 1),
(1246, 'RAVINDRA THAKUR', 'RT', 1),
(1247, 'URMILA KAUL', 'UK', 1),
(1248, 'RAMA SHANKAR SHRIVASTAW', 'R S', 1),
(1249, 'SHIV PRASAD SINGH', 'SP7', 1),
(1250, 'BRAJ NARAYAN SINGH', 'BN9', 1),
(1251, 'BACHANDEO TRIPATHI', 'BDT', 1),
(1252, 'LUXMI NARAYAN BIRLA', 'LNB', 1),
(1253, 'ASHA PURNA DEVI', 'AP3', 1),
(1254, 'TASLIMA NARSIMH', 'TN', 1),
(1255, 'S K POT KANT', 'SP8', 1),
(1256, 'M S PUTENA', 'MS4', 1),
(1257, 'SATYA PRAKASH MILIND', 'SYP', 1),
(1258, 'GURUDAT', 'GD', 1),
(1259, 'NARENDRA KOHLI', 'NDK', 1),
(1260, 'BAMKIM CHANDRA CHATERJE', 'BCC', 1),
(1261, 'BANKIM CHANDR', 'BCN', 1),
(1262, 'SARAT CHANDRA', 'SC9', 1),
(1263, 'RAVI BHUSAN PRASAD', 'RBP', 1),
(1264, 'KYODOR DOSTOYEBSKO BAURAM 1', 'KDB', 1),
(1265, 'RAHI MASOM RAJA', 'RMR', 1),
(1266, 'ABDUL BISMILLAH', 'AB', 1),
(1267, 'MIRJA RUPWA', 'MR', 1),
(1268, 'SHANTI JOSHI', 'SJ3', 1),
(1269, 'RAM BACHAN VERMA', 'RBV', 1),
(1270, 'KRISHNA SOBETI', 'KS5', 1),
(1271, 'DUDH NATH SINGH', 'DN2', 1),
(1272, 'AMAR KANT', 'AK', 1),
(1273, 'MAHA SWETA DEVI', 'MSD', 1),
(1274, 'SRI LAL SUKLA', 'SL4', 1),
(1275, 'BHAGWATE CHARAN VERMA', 'BWV', 1),
(1276, 'C J SANEPOR WALA', 'CJW', 1),
(1277, 'V K SALLY S K AGGARWAL', 'VSA', 1),
(1278, 'A K GERG & OTHERS', 'AK0', 1),
(1279, 'N KAPOOR RASSIK SAH & G S M R', 'NKR', 1),
(1280, 'M N SIDDIQUI', 'MNS', 1),
(1281, 'A C SEHGAL & MUKUL SAHGAL', 'ACS', 1),
(1282, 'D V CHOPRA ALKA NAGPAL', 'DVC', 1),
(1283, 'S BASU KASTURI', 'SB5', 1),
(1284, 'R K SABARWAL', 'RK9', 1),
(1285, 'K K GUPTA', 'KK4', 1),
(1286, 'R K SHARMA', 'RKS', 1),
(1287, 'A M CHAWLA', 'AMC', 1),
(1288, 'A C SAHGAL', 'AC1', 1),
(1289, 'L K VASHISTHA', 'LK1', 1),
(1290, 'BHUPENDRA SHARMA', 'BS7', 1),
(1291, 'PRADEEP SINGH', 'PS', 1),
(1292, 'SUMAN NATH', 'SN9', 1),
(1293, 'ANTON SIROMANI', 'AS7', 1),
(1294, 'DR S GANGULY', 'DSG', 1),
(1295, 'J P GUPTA', 'JP2', 1),
(1296, 'NIMIMI JAIN', 'NJ', 1),
(1297, 'ALKA NAGPAL', 'ALK', 1),
(1298, 'JUHI AGGARWAL', 'JA', 1),
(1299, 'VIPSHA BHATIA', 'VB', 1),
(1300, 'N K SEHGAL', 'NKW', 1),
(1301, 'D V CHOPRA', 'DV1', 1),
(1302, 'A MISHRA', 'AMI', 1),
(1303, 'SUPRIYA RANJMOHAN', 'SR6', 1),
(1304, 'VAISHALI GUPTA S BAJAJ S D SES', 'VGS', 1),
(1305, 'V K AGGARWAL', 'VKA', 1),
(1306, 'N K SEHGAL V K V S VINAY KR', 'NVK', 1),
(1307, 'KIRAN ASHOK KUMAR', 'KAK', 1),
(1308, 'BANKU BIHARI GANGULI & OTHER', 'BBG', 1),
(1309, 'S GANGULI', 'SGG', 1),
(1310, 'VIVEKKA NAND BANARJEE', 'VNB', 1),
(1311, 'KULDIP RAI', 'KUR', 1),
(1312, 'M R MENDIRATTA A T FLYNN B P', 'MR4', 1),
(1313, 'V AHLUWALIA', 'VAH', 1),
(1314, 'KANCHAN BALA', 'KAN', 1),
(1315, 'M N KHAN A C SHARMA', 'MNA', 1),
(1316, 'SAVITA SINHA', 'S1', 1),
(1317, 'BIRENDRA KR SINGH', 'BK6', 1),
(1318, 'SAGARIKA MUKHARJEE', 'SA8', 1),
(1319, 'B S PASAH', 'BSP', 1),
(1320, 'ANITA DEVRAJ', 'AD2', 1),
(1321, 'J K BHATNAGAR', 'JKB', 1),
(1322, 'V SRIDHARAN', 'VSD', 1),
(1323, 'VIDYA SAGAR GOYAL', 'VSG', 1),
(1324, 'D K NARAYAN', 'DKN', 1),
(1325, 'MAKHYA LAL', 'ML', 1),
(1326, 'I D PANDEY', 'IDP', 1),
(1327, 'DR H K KHAN', 'HKK', 1),
(1328, 'ALKA HAJELA', 'AHA', 1),
(1329, 'R L BHAT & OTHERS', 'RLT', 1),
(1330, 'CHITRA SRINIVAS', 'CSV', 1),
(1331, 'R N RAY', 'RNR', 1),
(1332, 'PRATIMA SAXENA', 'PSX', 1),
(1333, 'RAJNI BHANDARI', 'RBD', 1),
(1334, 'ALKA HAJELA ANSUA BANARJEE', 'AAB', 1),
(1335, 'A K GANDHI', 'AGD', 1),
(1336, 'B S PORAKH', 'BPO', 1),
(1337, 'D C MULA', 'DCM', 1),
(1338, 'SAMPURN JEET', 'SAJ', 1),
(1339, 'S K BHATNAGAR', 'SBT', 1),
(1340, 'CHITRA SRIVASTAV', 'CS', 1),
(1341, 'B S MALHOTRA', 'BS9', 1),
(1342, 'D V CHOPRA ALKA NAGPAL S R', 'DV3', 1),
(1343, 'NEELA SHARMA RAKHI CHAUHAN', 'NRC', 1),
(1344, 'KIRPAL SINGH', 'KRS', 1),
(1345, 'M P MISHRA', 'MP2', 1),
(1346, 'ASHOK GOSAIN ASHISH GOSAIN', 'AGA', 1),
(1347, 'DR RAJENDRA SHARMA', 'DRS', 1),
(1348, 'A K GANDHI C SURESH', 'AC4', 1),
(1349, 'TRIPTI SINGH RAGHUBIR B K T', 'TS4', 1),
(1350, 'NANDITA KRISHNA', 'NK6', 1),
(1351, 'ANNA LURASCHI', 'ANL', 1),
(1352, 'FIONA PATCHETT', 'FIP', 1),
(1353, 'VIVIAN WEBB HEATHER ANERY', 'VWH', 1),
(1354, 'JANE BINGHAM COLIN KING', 'JBC', 1),
(1355, 'FELICITY EVERETT', 'FEE', 1),
(1356, 'CHRISTOPHER RAWSON', 'CR1', 1),
(1357, 'LESLEY SIMS STEPHEN CARTWRIGH', 'LSS', 1),
(1358, 'PUSSELL PANTER MIKE PHILIPS', 'PM1', 1),
(1359, 'ANGELA WILKES PETER DENNIS', 'AWP', 1),
(1360, 'JANE BINGHAM ALAN MARKS', 'JBA', 1),
(1361, 'LESLY SIMS TERI GOWER', 'LST', 1),
(1362, 'HANS CHRISTION LESEY SIMS A M', 'HCL', 1),
(1363, 'SONTHAN SUIFT', 'SOS', 1),
(1364, 'JANE BINGHAM', 'JB1', 1),
(1365, 'JULES VERNE ADAM STOWER', 'JVA', 1),
(1366, 'HARRIET COSTER', 'HC', 1),
(1367, 'CAROT WATSON', 'CW', 1),
(1368, 'KAREN DALBY', 'KD', 1),
(1369, 'EMMA FISCHAL', 'EF', 1),
(1370, 'HANS CHRISTIAN ANDERSON', 'HCA', 1),
(1371, 'THE BROTHERS GRIMM', 'TBG', 1),
(1372, 'KATIE DAYNES PADDY MOUNTER', 'KD1', 1),
(1373, 'SUSANNA DAVIDSON FABIANO FIOR', 'SDF', 1),
(1374, 'BROTHERS GRIMM D GUICCIAREDI', 'BDG', 1),
(1375, 'BROTHERS GRIMM ANNA LURASCHI', 'BGA', 1),
(1376, 'JANE BINGHAM DANIAL POSTGATE', 'JBD', 1),
(1377, 'BROTHERS GRIMM MIKE GORDON', 'BGM', 1),
(1378, 'JANATHEN LOUD', 'JL', 1),
(1379, 'SUSAN PARTICLIFF', 'SP', 1),
(1380, 'JULIA ELLIT', 'JE', 1),
(1381, 'BIJAY CHAUHAN', 'BC', 1),
(1382, 'SURJIT', 'SU8', 1),
(1383, 'HARI KRISHN DEWSARE', 'HK2', 1),
(1384, 'URMI KRISHN', 'UK1', 1),
(1385, 'INDU JAN', 'IJ', 1),
(1386, 'GHANSHAYAM AGGARWAL', 'GSA', 1),
(1387, 'DR SATISH RAJ PUSHKARAN', 'DSR', 1),
(1388, 'RAMSARAN JOSHI', 'RJO', 1),
(1389, 'LUXMI NARAYAN SHASTRI SHAY KPR', 'LSK', 1),
(1390, 'RAMESHWAR SHARMA', 'RWS', 1),
(1391, 'MITHELESHWAR', 'MIT', 1),
(1392, 'SARYU', 'SAR', 1),
(1393, 'GOVIND MITRA', 'GM', 1),
(1394, 'SHIV SHANKAR', 'SH8', 1),
(1395, 'SAPAN KUMAR', 'SPN', 1),
(1396, 'KAMLESHWAR', 'KA1', 1),
(1397, 'DR MAHESHWAR', 'DMS', 1),
(1398, 'DHANANJAY VERMA', 'DV', 1),
(1399, 'KHUSWANT SINGH', 'KHS', 1),
(1400, 'DR MADHU', 'M', 1),
(1401, 'A K RMANUJAM', 'AR7', 1),
(1402, 'SUDHA BALA', 'SB8', 1),
(1403, 'GOPAL CHATURVEDI', 'GC3', 1),
(1404, 'SUSMITA BANDHOPADHYAY', 'SB9', 1),
(1405, 'AMRIT NAGAR', 'AN', 1),
(1406, 'MANJUR AHTESAM', 'MA', 1),
(1407, 'HARI SHANKAR PERSAE', 'HS5', 1),
(1408, 'GYAN CHATURWEDI', 'GC2', 1),
(1409, 'BANCIM CHANDRA CHATOPADHYAY', 'BC2', 1),
(1410, 'RAVINDRA NATH TAGOR', 'RVN', 1),
(1411, 'WILIAM FROKAN', 'WF', 1),
(1412, 'MOHIN RAO', 'MR2', 1),
(1413, 'JAWAHAR SINGH', 'JS', 1),
(1414, 'SURYA BALA', 'SUB', 1),
(1415, 'OM PRAKASH GUPT', 'OPG', 1),
(1416, 'SARTENDU', 'STD', 1),
(1417, 'NAND KR SOMANI', 'NK7', 1),
(1418, 'PANDEY BACHAN SHARMA UGRA', 'PBS', 1),
(1419, 'B R PATAM', 'BRP', 1),
(1420, 'DR SAROJNI PRITAM', 'SP0', 1),
(1421, 'SANKU MAHARAJ', 'SM7', 1),
(1422, 'TEJ NARAYAN LAL', 'TNL', 1),
(1423, 'RAJENDRA MISHR', 'RM7', 1),
(1424, 'CHAUDHARY S N S SANDILYA', 'CS1', 1),
(1425, 'SHIV PRASAD MISHR RUDR', 'SM9', 1),
(1426, 'ABHIMANYU ANANT', 'AA', 1),
(1427, 'SARASWATI RAMNATH', 'SR8', 1),
(1428, 'NADIN GORDMER', 'NG', 1),
(1429, 'MADAN MOHAN RAJENDRA', 'MMR', 1),
(1430, 'RAJ KUMAR ANIL', 'RA9', 1),
(1431, 'YOGESH KUMAR', 'YK', 1),
(1432, 'AJGAR WAJAHAT', 'AW', 1),
(1433, 'CHAKRWARTI RAJ GOPALACHARI', 'CRG', 1),
(1434, 'WACHNES TRIPATHI', 'WT1', 1),
(1435, 'PRADEP KUMAR', 'PK', 1),
(1436, 'RAJENDRA PAL SINGH', 'R P', 1),
(1437, 'DAYA SHANKAR SUBODH', 'DSS', 1),
(1438, 'CHITIJ SHARMA', 'CS2', 1),
(1439, 'KANHAYA LAL GOYAL', 'KL5', 1),
(1440, 'GOPAL AWHEY', 'GA', 1),
(1441, 'USHA CHAUDHARY', 'UC', 1),
(1442, 'SHARAD JOSI', 'SJ5', 1),
(1443, 'MANNU BHANDARI', 'MB3', 1),
(1444, 'SRIRAM SHARMA', 'SR9', 1),
(1445, 'SURESH KR SHARMA', 'S K', 1),
(1446, 'SRI PRASAD', 'SIP', 1),
(1447, 'C S MISHRA', 'CS4', 1),
(1448, 'S C ANAND', 'SC1', 1),
(1449, 'SHASHI MALHOTRA', 'SM8', 1),
(1450, 'SURJA KUMARI', 'SJK', 1),
(1451, 'GAGAN KR SEN', 'GK1', 1),
(1452, 'ASHA RANI SINGAL M K SINGAL', 'AR9', 1),
(1453, 'DR HARBANS LAL', 'HBL', 1),
(1454, 'P C CHHABRA', 'PCC', 1),
(1455, 'P JASEPH B K GUPTA', 'PJG', 1),
(1456, 'V E VARMA', 'VEV', 1),
(1457, 'S C DUSE', 'SC2', 1),
(1458, 'O P MALHOTRA', 'OPM', 1),
(1459, 'JOSE PAUL', 'JP', 1),
(1460, 'SUDHIR AGGARWAL', 'SAW', 1),
(1461, 'P K SHARMA GURVINDRA KAUR', 'PKK', 1),
(1462, 'ASHISH RANJAN MISHRA', 'ARM', 1),
(1463, 'V K GAUR SOMDATTA SINHA', 'VKG', 1),
(1464, 'S P BHATNAGAR', ' SP', 1),
(1465, 'KULDIP RAI A T FLYNN', 'KRA', 1),
(1466, 'N KAPOR G S MADHAV RAO', 'NKG', 1),
(1467, 'B K GOWEL', 'BK1', 1),
(1468, 'S BASU KASURI S BHATTACHARYA', 'SBB', 1),
(1469, 'V K GAUR', 'VK6', 1);
INSERT INTO `fa_author_details` (`auth_id`, `auth_name`, `auth_code`, `status`) VALUES
(1470, 'DR M N SIDDIQI A N SHARMA', 'MN4', 1),
(1471, 'V AHLWALIA & OTHERS', 'VAO', 1),
(1472, 'A T FLYNN', 'ATF', 1),
(1473, 'SNEH VERMA MEELAM AMARS', 'SVM', 1),
(1474, 'V AHLUWALIA G M D L R MOHAN', 'VRM', 1),
(1475, 'K K GUPTA STALIN MALHOTRA', 'KK5', 1),
(1476, 'ANUPAM DIXIT & OTHERS', 'AD1', 1),
(1477, 'ANUPAM DIXIT', 'AD', 1),
(1478, 'SASHI KR SHARMA', 'SKS', 1),
(1479, 'NERANJAN KR SINGH', 'NER', 1),
(1480, 'KHANA & AGGARWAL', 'K&A', 1),
(1481, 'AMIT RANJAN', 'ARJ', 1),
(1482, 'MUKUL PRIYDARSHNI', 'MPD', 1),
(1483, 'GANGA DUT SHARMA', 'GD1', 1),
(1484, 'G D BAKSHI', 'GDB', 1),
(1485, 'RAM GOPAL VERMA', 'RGV', 1),
(1486, 'KUSUM AGGARWAL', 'KAR', 1),
(1487, 'O P MALHOTRA S K GUPTA', 'OP9', 1),
(1488, 'L N RAI', 'LNR', 1),
(1489, 'H S SINHA', 'HSI', 1),
(1490, 'SAROJA SUNDARARAJAN', 'SSJ', 1),
(1491, 'R S LUGANI', 'RSL', 1),
(1492, 'DR P P VERMANI', 'PPV', 1),
(1493, 'R C GUPTA', 'RCG', 1),
(1494, 'R BHATIA RENU BHATIA', 'RBR', 1),
(1495, 'S N CHHIBBER', 'SNC', 1),
(1496, 'SUDHER AGGARWAL MENA AGGARWAL', 'SMA', 1),
(1497, 'HARIOM SHASTRI', 'HOS', 1),
(1498, 'DR INDRBHUSAN MISHR', 'DIM', 1),
(1499, 'DR RAMBILAS GUPTA VEENA GUPTA', 'RVG', 1),
(1500, 'RAJESH YADEV PURNIMA GUPTA', 'RYG', 1),
(1501, 'P PRAKASH', 'PPK', 1),
(1502, 'A K PRIYADARSHI', 'APD', 1),
(1503, 'SNA RIZVI MR.K RIZVI', 'SRZ', 1),
(1504, 'G S SHRIVASTAVA', 'GSS', 1),
(1505, 'FRANSIS M PETER', 'FMP', 1),
(1506, 'K P THAKAR', 'KPT', 1),
(1507, 'DR B R KISHOR', 'DBR', 1),
(1508, 'RAMJANM SHARMA', 'RJS', 1),
(1509, 'S SEN GUPTA', 'SSE', 1),
(1510, 'CECEIL G DOLMAGE', 'CGD', 1),
(1511, 'PRABHA KIRAN JAIN', 'PKJ', 1),
(1512, 'N K VERMA NEERA VERMA', 'NNV', 1),
(1513, 'J N JAISWAL & S K SUNJA', 'JJS', 1),
(1514, 'J.P.SHARMA', 'J.P', 1),
(1515, 'INDIA & CONTENPERY WORLD 1', 'ICW', 1),
(1516, 'DEVENDRANATH KUNDRA VERINDRA K', 'DKV', 1),
(1518, 'K T AEHAYA', 'KTA', 1),
(1519, 'JALIM ALI C F', 'JAC', 1),
(1520, 'LQALPANA SOOD LAL', 'LSL', 1),
(1521, 'DR RADHESHAYAM GAUR', 'DRG', 1),
(1522, 'DR ASHOK BATRA', 'DAB', 1),
(1523, 'DR ASHOK KUMAR UPADHYAY', 'AKU', 1),
(1524, 'BHAGWAN SINGH', 'BWS', 1),
(1525, 'SHIV KUMAR', 'SKU', 1),
(1526, 'ABID SHRUTI', 'ASH', 1),
(1527, 'GEJU BHAI BADHEKA', 'GBB', 1),
(1528, 'SASHI PRABHA DAS', 'SDS', 1),
(1529, 'K P GAGERIYA', 'KPG', 1),
(1530, 'SAMER SINGH', 'SS3', 1),
(1531, 'P K LEAN', 'PKL', 1),
(1532, 'BALMUKUND AGGARWAL', 'BMA', 1),
(1533, 'M.ASLAM', 'M.A', 1),
(1534, 'JEAN BAECHLER', 'JBR', 1),
(1535, 'P.S. RAMA LARISHHAN', 'PSL', 1),
(1536, 'B.P.CHHAPGAR', 'BCG', 1),
(1537, 'CHAMAN LAL', 'CML', 1),
(1538, 'DILIP M JALWI', 'DMJ', 1),
(1539, 'ROEMAIN ROLLAND', 'RRA', 1),
(1540, 'KRISHNA KRIPLANI', 'KSK', 1),
(1541, 'SUDHANSU RANJAN', 'SRJ', 1),
(1542, 'COONOOR KRIPLANI', 'CKL', 1),
(1543, 'A BHASKAR', 'ABK', 1),
(1544, 'S L ARORA', 'SL1', 1),
(1545, 'VERMA & VERMA', 'V&V', 1),
(1546, 'ARBIND GUPTA', 'ABG', 1),
(1547, 'A N KOTHARI', 'ANK', 1),
(1548, 'GITA INGAR', 'GTI', 1),
(1549, 'UMA SHANKAR JOSHI', 'USJ', 1),
(1550, 'DHARMVIR KOHLI', 'DVK', 1),
(1551, 'R S ABOOSNURMARH', 'RS3', 1),
(1552, 'SHANKAR', 'SNK', 1),
(1553, 'ARUN SEDNAL', 'AUS', 1),
(1554, 'AMIT GARG', 'AMG', 1),
(1555, 'RITESH SINGH', 'RSG', 1),
(1556, 'C D TULI P L SONI', 'CTP', 1),
(1557, 'ELIBBORD SAWHNEY', 'EBS', 1),
(1558, 'NORMAN LEWIS', 'NL', 1),
(1559, 'A H BAJKELT', 'AHB', 1),
(1560, 'JOHN DEINILL JOHN O CLARK', 'JJC', 1),
(1561, 'A M GOLDSTEIN', 'AGS', 1),
(1562, 'ROBERT HIRE', 'RBH', 1),
(1563, 'JILL BAUILLEY', 'JBL', 1),
(1564, 'SABARI MAITRA & OTJHERS', 'SBM', 1),
(1565, 'MANJU SINGH J K LELAUSIA', 'MSJ', 1),
(1566, 'POONAM PANDEY R L VIS NIDHI CA', 'PPR', 1),
(1567, 'HARIBACHAN SINGH ARSI', 'HBA', 1),
(1568, 'JANRAL YASHWANT MANDE', 'JYM', 1),
(1569, 'KAMLA CHAMOLAR', 'KCL', 1),
(1570, 'SULEKHA KUMAR', 'SEK', 1),
(1571, 'DEV REV AGGARWAL', 'DRA', 1),
(1572, 'SAHNI & ARSHAD', 'S&A', 1),
(1573, 'BIRENDRA KUMAR', 'BNK', 1),
(1574, 'M.J.ASHOK', 'MJA', 1),
(1575, 'A A VABLANGADI', 'AAV', 1),
(1576, 'SHAILESH SHIRADI', 'SLD', 1),
(1577, 'JAYANT V MARLIKAR & OTHERS', 'JVO', 1),
(1578, 'HARSHVARDEN LEUTHA', 'HVL', 1),
(1579, 'FRANKLIN W DINON', 'FWD', 1),
(1580, 'WILFRED D BEST', 'WDB', 1),
(1581, 'TAPUS GUNA', 'TPG', 1),
(1582, 'MITA BERRY', 'MBR', 1),
(1583, 'S RAGHUNATHM', 'SRN', 1),
(1584, 'DR.M.L.AGARWAL', 'DMA', 1),
(1585, 'DEVIKA RANGCHARI', 'DRC', 1),
(1586, 'M S PATIL', 'MSP', 1),
(1587, 'B SUTHAR', 'BST', 1),
(1588, 'COOLYN KANE', 'CLK', 1),
(1589, 'ANUP KR DATTA', 'AKD', 1),
(1590, 'MILIMA SINHA', 'MLS', 1),
(1591, 'THANGAMAN', 'TGM', 1),
(1592, 'LINDA &  RUGERFLAVELL', 'L&R', 1),
(1593, 'R RANGRAJAN S K GOEL', 'RR1', 1),
(1594, 'PRADEEP SINGH JITENDRA SINGH', 'PJS', 1),
(1595, 'MANJISTH BOSE SUBAND RAGHWRAMA', 'MBS', 1),
(1596, 'HARIOM SHASTRI SUDAN SHAMI', 'HS1', 1),
(1597, 'SUDHA RAVI', 'SUR', 1),
(1598, 'RANJAN KR SINGH', 'RJ1', 1),
(1599, 'UMA RAMEN MINA SEHGAL', 'URS', 1),
(1600, 'SAPNA KHURANA', 'SKN', 1),
(1601, 'ANIMA JAIN', 'AMJ', 1),
(1602, 'B K GOWEL SANGEETA', 'BGS', 1),
(1603, 'R L VIZ', 'RLV', 1),
(1604, 'MEERA AGGARWAL', 'MRA', 1),
(1605, 'V K SALLY', 'VKS', 1),
(1606, 'V K MALHOTRA', 'VKM', 1),
(1607, 'SARITA KUMAR', 'SR1', 1),
(1608, 'VANDANA JOJOO', 'VJJ', 1),
(1609, 'MARY GEORGE', 'MGR', 1),
(1610, 'PRATIMA SANENA', 'PTS', 1),
(1611, 'GEETA OBERAI', 'GOR', 1),
(1612, 'REKHEE CHAUHAN', 'RKE', 1),
(1613, 'JAGDISH RAJ SHARMA', 'JRS', 1),
(1614, 'K V NANDANI REDDY', 'NAD', 1),
(1615, 'TRIPTI SINGHJ', 'TTS', 1),
(1616, 'R K KALRA', 'RKK', 1),
(1617, 'VINOD SHARMA', 'VSH', 1),
(1618, 'GITA DUGGAL', 'GDG', 1),
(1619, 'JOYITA CHAKRABARTI', 'JCB', 1),
(1620, 'SULOCHNA ARJUN', 'SC\\', 1),
(1621, 'ANUP POPPAL 2', 'AP2', 1),
(1622, 'ANUP RAJPUT 2', 'AR2', 1),
(1623, 'O P ARORA', 'OP1', 1),
(1624, 'MAYA SUKUMARAN', 'MSM', 1),
(1625, 'HARBANS LAL ACHUTHAM MADHAV', 'HAM', 1),
(1626, 'ASHISH SINGHAL SAVITA HARSPAL', 'ASS', 1),
(1627, 'K C SINHA', 'KCS', 1),
(1628, 'J P MOHINDER KIRAN GROVER', 'JPG', 1),
(1629, 'K N BHALIA M P TYAGI', 'KMT', 1),
(1630, 'DEVINDER NATH KUNDRA B S BAWA', 'KBB', 1),
(1631, 'C P SHAYAMA SUMAN JAIN', 'CPJ', 1),
(1632, 'JAGDISH RAJ SHARMA JANKI NAT', 'JSJ', 1),
(1633, 'RAKHEE SHOUHAN NEERA SOUHAN', 'RSN', 1),
(1634, 'CHANDANA BANARJEE', 'CDB', 1),
(1635, 'DR RAKHEE CHOUHAN', 'RKH', 1),
(1636, 'SATISH CHANDRA', 'SCD', 1),
(1637, 'B GANGULY & OTHERS', 'B&O', 1),
(1638, 'SANPAT MUKHARJEE', 'SMK', 1),
(1639, 'R K MITTAL A K JAIN', 'RAJ', 1),
(1640, 'R K SINGAL', 'R K', 1),
(1641, 'T R JAIN V K OHRI', 'TVO', 1),
(1642, 'DR S P JOUHAR', 'SP2', 1),
(1643, 'R V VERMA S VERMA', 'RVV', 1),
(1644, 'DWARKA NATH KUNDRA', 'DNK', 1),
(1645, 'ARUN BHASKAR', 'ABS', 1),
(1646, 'DR R K SINGH', 'DRK', 1),
(1647, 'ANITA RAJPUT', 'OML', 1),
(1648, 'OMLATE SINGH', 'OLS', 1),
(1649, 'R G GUPTA', 'RGG', 1),
(1650, 'S C SHARMA', 'SCS', 1),
(1651, 'DR P N SINGH', 'PNS', 1),
(1652, 'S S MALHOTRA', 'SS1', 1),
(1653, 'R K TYAGI', 'RKT', 1),
(1654, 'P JOSEPN', 'PJE', 1),
(1655, 'JOSE POUL', 'JPU', 1),
(1656, 'VINOD TYAGI', 'VTY', 1),
(1657, 'P K SHARMA', 'PSR', 1),
(1658, 'L C SAHA D K SINHA', 'LDS', 1),
(1659, 'V P AGGARWAL S C MAHESHWARI', 'VSM', 1),
(1660, 'LOKVER SINGH', 'LVS', 1),
(1661, 'VEENA SURI', 'VEN', 1),
(1662, 'KUSUMIM WADHWA', 'KWH', 1),
(1663, 'V K BHANDARI', 'VKB', 1),
(1664, 'A P SINGH', 'A.P', 1),
(1665, 'UDAYNATH MISHRA', 'UNM', 1),
(1666, 'R L ARORA', 'RL3', 1),
(1667, 'A L ARORA', 'ALA', 1),
(1668, 'ASHOK SINGH', 'AHK', 1),
(1669, 'C S SHARMA &OTHERS', 'CSO', 1),
(1670, 'DR SANJEEV VERMA', 'DSV', 1),
(1671, 'O P GUPTA', 'OGU', 1),
(1672, 'NISHA GUPTA', 'NGU', 1),
(1673, 'POONAM GANDHI', 'PON', 1),
(1674, 'K L VERMA', 'KLV', 1),
(1675, 'D K GOEL', 'DKG', 1),
(1676, 'PRADEEP SHARMA', 'PRE', 1),
(1677, 'PREM P BHALLA', 'PPB', 1),
(1678, 'JUHI AGGARWAL & OTHERS', 'JAO', 1),
(1679, 'FREDERICK C WOOTAM', 'FCW', 1),
(1680, 'B G VERMA', 'BGV', 1),
(1681, 'K P THAKUR', 'KP1', 1),
(1682, 'PREMCHAND', 'PCD', 1),
(1683, 'AJAY KR. KOTHARI', 'AKT', 1),
(1684, 'PANKAJ KISHOR', 'PKI', 1),
(1685, 'RAJAN DHINGRA', 'RDN', 1),
(1686, 'AMARNATH MISHRA', 'AN8', 1),
(1687, 'VEER BALA RASTOGI', 'VRT', 1);

-- --------------------------------------------------------

--
-- Table structure for table `fa_bank_accounts`
--

CREATE TABLE `fa_bank_accounts` (
  `account_code` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `account_type` smallint(6) NOT NULL DEFAULT 0,
  `bank_account_name` varchar(60) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `bank_account_number` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `bank_name` varchar(60) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `bank_address` tinytext COLLATE utf8_unicode_ci DEFAULT NULL,
  `bank_curr_code` char(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `dflt_curr_act` tinyint(1) NOT NULL DEFAULT 0,
  `id` smallint(6) NOT NULL,
  `bank_charge_act` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `last_reconciled_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ending_reconcile_balance` double NOT NULL DEFAULT 0,
  `inactive` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fa_bank_accounts`
--

INSERT INTO `fa_bank_accounts` (`account_code`, `account_type`, `bank_account_name`, `bank_account_number`, `bank_name`, `bank_address`, `bank_curr_code`, `dflt_curr_act`, `id`, `bank_charge_act`, `last_reconciled_date`, `ending_reconcile_balance`, `inactive`) VALUES
('1060', 0, 'Current account', '9999999999', 'Wachovia Bank', NULL, 'INR', 1, 1, '5690', '0000-00-00 00:00:00', 0, 0),
('1065', 3, 'Petty Cash account', 'N/A', 'N/A', NULL, 'INR', 0, 2, '5690', '0000-00-00 00:00:00', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `fa_bank_trans`
--

CREATE TABLE `fa_bank_trans` (
  `id` int(11) NOT NULL,
  `type` smallint(6) DEFAULT NULL,
  `trans_no` int(11) DEFAULT NULL,
  `bank_act` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `ref` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `trans_date` date NOT NULL DEFAULT '0000-00-00',
  `amount` double DEFAULT NULL,
  `dimension_id` int(11) NOT NULL DEFAULT 0,
  `dimension2_id` int(11) NOT NULL DEFAULT 0,
  `person_type_id` int(11) NOT NULL DEFAULT 0,
  `person_id` tinyblob DEFAULT NULL,
  `reconciled` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fa_bom`
--

CREATE TABLE `fa_bom` (
  `id` int(11) NOT NULL,
  `parent` char(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `component` char(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `workcentre_added` int(11) NOT NULL DEFAULT 0,
  `loc_code` char(5) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `quantity` double NOT NULL DEFAULT 1,
  `serialno` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fa_bom`
--

INSERT INTO `fa_bom` (`id`, `parent`, `component`, `workcentre_added`, `loc_code`, `quantity`, `serialno`) VALUES
(4, '', 'BAT-LAP-N4010', 2, 'PAT', 1, ''),
(1, 'cpu', 'CP110', 2, 'DEF', 1, ''),
(2, 'cpui3', 'HDD-SSD-500GB', 2, 'PAT', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `fa_bom_drawings`
--

CREATE TABLE `fa_bom_drawings` (
  `id` int(11) NOT NULL,
  `description` varchar(60) CHARACTER SET utf8 NOT NULL,
  `type_no` varchar(50) CHARACTER SET utf8 NOT NULL,
  `unique_name` varchar(60) CHARACTER SET utf8 NOT NULL,
  `tran_date` date DEFAULT NULL,
  `filename` varchar(60) CHARACTER SET utf8 NOT NULL,
  `filesize` varchar(60) CHARACTER SET utf8 NOT NULL,
  `filetype` varchar(60) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `fa_books`
--

CREATE TABLE `fa_books` (
  `book_id` int(11) NOT NULL,
  `ISBN` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `category` int(10) NOT NULL,
  `author` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `publisher` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `published_date` date NOT NULL,
  `edition` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `copies_no` int(10) NOT NULL,
  `book_cost` float NOT NULL,
  `copyright_year` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(10) NOT NULL,
  `added_date` datetime NOT NULL DEFAULT current_timestamp(),
  `modified_date` datetime DEFAULT NULL,
  `modified_by` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `IP_address` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `entered_by` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fa_books`
--

INSERT INTO `fa_books` (`book_id`, `ISBN`, `title`, `category`, `author`, `publisher`, `published_date`, `edition`, `copies_no`, `book_cost`, `copyright_year`, `status`, `added_date`, `modified_date`, `modified_by`, `IP_address`, `entered_by`) VALUES
(1, 'ISBN-10', 'Chemistry', 2, '1061', '240', '2020-01-09', 'first', 20, 250, '2003', 1, '2020-01-09 18:33:46', NULL, NULL, '::1', 'Administrator'),
(2, 'ISBN-002', 'MATH', 6, '1401', '96', '2020-12-24', 'IST', 20, 250, '2020', 1, '2020-12-24 03:55:36', NULL, NULL, '157.42.216.254', '');

-- --------------------------------------------------------

--
-- Table structure for table `fa_books_copies`
--

CREATE TABLE `fa_books_copies` (
  `id` int(11) NOT NULL,
  `ISBN` varchar(50) NOT NULL,
  `title` varchar(50) NOT NULL,
  `category` int(10) NOT NULL,
  `copies_no` varchar(100) NOT NULL,
  `status` int(10) NOT NULL DEFAULT 0,
  `hold` int(10) NOT NULL DEFAULT 0,
  `issue` int(10) NOT NULL DEFAULT 0,
  `damage` int(10) NOT NULL DEFAULT 0,
  `req_copy` int(50) NOT NULL DEFAULT 0,
  `map` int(10) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fa_books_copies`
--

INSERT INTO `fa_books_copies` (`id`, `ISBN`, `title`, `category`, `copies_no`, `status`, `hold`, `issue`, `damage`, `req_copy`, `map`) VALUES
(36, 'ISBN-002', 'C', 1, 'COPY001', 0, 0, 1, 0, 1, 0),
(37, 'ISBN-002', 'C', 1, 'COPY002', 0, 0, 1, 0, 0, 0),
(38, 'ISBN-002', 'C', 1, 'COPY003', 0, 0, 0, 0, 0, 0),
(39, 'ISBN-002', 'C', 1, 'COPY004', 0, 0, 0, 0, 1, 0),
(40, 'ISBN-002', 'C', 1, 'COPY005', 0, 0, 0, 0, 0, 0),
(41, 'ISBN-002', 'C', 1, 'COPY006', 0, 0, 0, 0, 0, 0),
(42, 'ISBN-002', 'C', 1, 'COPY007', 0, 0, 0, 0, 0, 0),
(43, 'ISBN-002', 'C', 1, 'COPY008', 0, 0, 0, 0, 0, 0),
(44, 'ISBN-003', 'I C Engine', 2, 'COPY001', 1, 0, 0, 0, 1, 0),
(45, 'ISBN-003', 'I C Engine', 2, 'COPY002', 0, 0, 0, 0, 0, 0),
(46, 'ISBN-003', 'I C Engine', 2, 'COPY003', 0, 0, 0, 0, 1, 0),
(47, 'ISBN-003', 'I C Engine', 2, 'COPY004', 1, 0, 0, 0, 0, 0),
(48, 'ISBN-003', 'I C Engine', 2, 'COPY005', 0, 0, 0, 0, 0, 0),
(49, 'ISBN-003', 'I C Engine', 2, 'COPY006', 0, 0, 0, 0, 0, 0),
(50, 'ISBN-004', 'Machine Design', 2, 'COPY001', 0, 0, 0, 0, 1, 0),
(51, 'ISBN-004', 'Machine Design', 2, 'COPY002', 0, 0, 0, 0, 1, 0),
(52, 'ISBN-004', 'Machine Design', 2, 'COPY003', 0, 0, 0, 0, 1, 0),
(53, 'ISBN-004', 'Machine Design', 2, 'COPY004', 0, 0, 0, 0, 1, 0),
(54, 'ISBN-004', 'Machine Design', 2, 'COPY005', 0, 0, 0, 0, 0, 0),
(55, 'ISBN-004', 'Machine Design', 2, 'COPY006', 0, 0, 0, 0, 0, 0),
(56, 'ISBN-004', 'Machine Design', 2, 'COPY007', 0, 0, 0, 0, 0, 0),
(57, 'ISBN-004', 'Machine Design', 2, 'COPY008', 0, 0, 0, 0, 0, 0),
(58, 'ISBN-005', 'Ac History', 3, 'COPY001', 1, 0, 0, 0, 0, 0),
(59, 'ISBN-005', 'Ac History', 3, 'COPY002', 1, 0, 0, 0, 0, 0),
(60, 'ISBN-005', 'Ac History', 3, 'COPY003', 0, 0, 0, 0, 0, 0),
(61, 'ISBN-005', 'Ac History', 3, 'COPY004', 0, 0, 0, 0, 0, 0),
(62, 'ISBN-005', 'Ac History', 3, 'COPY005', 0, 0, 0, 0, 0, 0),
(83, 'Isbn-0010', 'test', 1, 'COPY001', 1, 0, 0, 0, 0, 0),
(84, 'Isbn-0010', 'test', 1, 'COPY002', 1, 0, 0, 0, 0, 0),
(85, 'Isbn-0010', 'test', 1, 'COPY003', 1, 0, 0, 0, 0, 0),
(86, 'Isbn-0010', 'test', 1, 'COPY004', 0, 0, 1, 0, 0, 0),
(87, 'Isbn-0010', 'test', 1, 'COPY005', 0, 0, 1, 0, 0, 0),
(88, 'Isbn-0010', 'test', 1, 'COPY006', 0, 0, 0, 0, 0, 0),
(89, 'Isbn-0010', 'test', 1, 'COPY007', 0, 0, 0, 0, 0, 0),
(90, 'Isbn-0010', 'test', 1, 'COPY008', 0, 0, 0, 0, 0, 0),
(91, 'Isbn-0010', 'test', 1, 'COPY009', 0, 0, 0, 0, 0, 0),
(92, 'Isbn-0010', 'test', 1, 'COPY0010', 0, 0, 0, 0, 0, 0),
(93, 'Isbn-0010', 'test', 1, 'COPY0011', 0, 0, 0, 0, 0, 0),
(94, 'Isbn-0010', 'test', 1, 'COPY0012', 0, 0, 0, 0, 0, 0),
(95, 'Isbn-0010', 'test', 1, 'COPY0013', 0, 0, 0, 0, 0, 0),
(96, 'Isbn-0010', 'test', 1, 'COPY0014', 0, 0, 0, 0, 0, 0),
(97, 'Isbn-0010', 'test', 1, 'COPY0015', 0, 0, 0, 0, 0, 0),
(98, 'Isbn-0010', 'test', 1, 'COPY0016', 0, 0, 0, 0, 0, 0),
(99, 'Isbn-0010', 'test', 1, 'COPY0017', 0, 0, 0, 0, 0, 0),
(100, 'Isbn-0010', 'test', 1, 'COPY0018', 0, 0, 0, 0, 0, 0),
(101, 'Isbn-0010', 'test', 1, 'COPY0019', 0, 0, 0, 0, 0, 0),
(102, 'Isbn-0010', 'test', 1, 'COPY0020', 0, 0, 0, 0, 0, 0),
(103, 'ISBN-10', 'Chemistry', 2, 'COPY001', 0, 0, 0, 0, 0, 0),
(104, 'ISBN-10', 'Chemistry', 2, 'COPY002', 0, 0, 0, 0, 0, 0),
(105, 'ISBN-10', 'Chemistry', 2, 'COPY003', 0, 0, 0, 0, 0, 0),
(106, 'ISBN-10', 'Chemistry', 2, 'COPY004', 0, 0, 0, 0, 0, 0),
(107, 'ISBN-10', 'Chemistry', 2, 'COPY005', 0, 0, 0, 0, 0, 0),
(108, 'ISBN-10', 'Chemistry', 2, 'COPY006', 0, 0, 0, 0, 0, 0),
(109, 'ISBN-10', 'Chemistry', 2, 'COPY007', 0, 0, 0, 0, 0, 0),
(110, 'ISBN-10', 'Chemistry', 2, 'COPY008', 0, 0, 0, 0, 0, 0),
(111, 'ISBN-10', 'Chemistry', 2, 'COPY009', 0, 0, 0, 0, 0, 0),
(112, 'ISBN-10', 'Chemistry', 2, 'COPY0010', 0, 0, 0, 0, 0, 0),
(113, 'ISBN-10', 'Chemistry', 2, 'COPY0011', 0, 0, 0, 0, 0, 0),
(114, 'ISBN-10', 'Chemistry', 2, 'COPY0012', 0, 0, 0, 0, 0, 0),
(115, 'ISBN-10', 'Chemistry', 2, 'COPY0013', 0, 0, 0, 0, 0, 0),
(116, 'ISBN-10', 'Chemistry', 2, 'COPY0014', 0, 0, 0, 0, 0, 0),
(117, 'ISBN-10', 'Chemistry', 2, 'COPY0015', 0, 0, 0, 0, 0, 0),
(118, 'ISBN-10', 'Chemistry', 2, 'COPY0016', 0, 0, 0, 0, 0, 0),
(119, 'ISBN-10', 'Chemistry', 2, 'COPY0017', 0, 0, 0, 0, 0, 0),
(120, 'ISBN-10', 'Chemistry', 2, 'COPY0018', 0, 0, 0, 0, 0, 0),
(121, 'ISBN-10', 'Chemistry', 2, 'COPY0019', 0, 0, 0, 0, 0, 0),
(122, 'ISBN-10', 'Chemistry', 2, 'COPY0020', 0, 0, 0, 0, 0, 0),
(123, 'ISBN-002', 'MATH', 6, 'COPY001', 0, 0, 0, 0, 0, 0),
(124, 'ISBN-002', 'MATH', 6, 'COPY002', 0, 0, 1, 0, 0, 0),
(125, 'ISBN-002', 'MATH', 6, 'COPY003', 0, 0, 0, 0, 0, 0),
(126, 'ISBN-002', 'MATH', 6, 'COPY004', 0, 0, 0, 0, 0, 0),
(127, 'ISBN-002', 'MATH', 6, 'COPY005', 0, 0, 0, 0, 0, 0),
(128, 'ISBN-002', 'MATH', 6, 'COPY006', 0, 0, 0, 0, 0, 0),
(129, 'ISBN-002', 'MATH', 6, 'COPY007', 0, 0, 0, 0, 0, 0),
(130, 'ISBN-002', 'MATH', 6, 'COPY008', 0, 0, 0, 0, 0, 0),
(131, 'ISBN-002', 'MATH', 6, 'COPY009', 0, 0, 0, 0, 0, 0),
(132, 'ISBN-002', 'MATH', 6, 'COPY0010', 0, 0, 0, 0, 0, 0),
(133, 'ISBN-002', 'MATH', 6, 'COPY0011', 0, 0, 0, 0, 0, 0),
(134, 'ISBN-002', 'MATH', 6, 'COPY0012', 0, 0, 0, 0, 0, 0),
(135, 'ISBN-002', 'MATH', 6, 'COPY0013', 0, 0, 0, 0, 0, 0),
(136, 'ISBN-002', 'MATH', 6, 'COPY0014', 0, 0, 0, 0, 0, 0),
(137, 'ISBN-002', 'MATH', 6, 'COPY0015', 0, 0, 0, 0, 0, 0),
(138, 'ISBN-002', 'MATH', 6, 'COPY0016', 0, 0, 0, 0, 0, 0),
(139, 'ISBN-002', 'MATH', 6, 'COPY0017', 0, 0, 0, 0, 0, 0),
(140, 'ISBN-002', 'MATH', 6, 'COPY0018', 0, 0, 0, 0, 0, 0),
(141, 'ISBN-002', 'MATH', 6, 'COPY0019', 0, 0, 0, 0, 0, 0),
(142, 'ISBN-002', 'MATH', 6, 'COPY0020', 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `fa_book_category`
--

CREATE TABLE `fa_book_category` (
  `id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `cat_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fa_book_category`
--

INSERT INTO `fa_book_category` (`id`, `category_name`, `cat_status`) VALUES
(1, 'Computer', 1),
(2, 'Auto Mobile Engg.', 1),
(3, 'History', 1),
(4, 'Science', 2),
(5, 'English', 1),
(6, 'Math', 1);

-- --------------------------------------------------------

--
-- Table structure for table `fa_book_fine`
--

CREATE TABLE `fa_book_fine` (
  `id` int(11) NOT NULL,
  `based_on` int(10) NOT NULL,
  `amount` float NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fa_book_fine`
--

INSERT INTO `fa_book_fine` (`id`, `based_on`, `amount`, `status`) VALUES
(41, 1, 1, 0),
(42, 2, 5, 0),
(43, 3, 20, 0);

-- --------------------------------------------------------

--
-- Table structure for table `fa_book_location`
--

CREATE TABLE `fa_book_location` (
  `id` int(11) NOT NULL,
  `floor_id` varchar(100) NOT NULL,
  `fl_num` varchar(50) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fa_book_location`
--

INSERT INTO `fa_book_location` (`id`, `floor_id`, `fl_num`, `status`) VALUES
(1, 'No-001', 'GR-A/001', 0),
(2, 'No-002', 'GR-B/001', 0),
(3, 'No-003', 'SD-A001', 0),
(4, 'No-004', 'SD-A002', 0),
(5, 'No-005', 'LGF-01', 0);

-- --------------------------------------------------------

--
-- Table structure for table `fa_book_map`
--

CREATE TABLE `fa_book_map` (
  `id` int(11) NOT NULL,
  `cat_id` int(10) NOT NULL,
  `ISBN` varchar(80) NOT NULL,
  `copies_no` varchar(80) NOT NULL,
  `title` varchar(80) NOT NULL,
  `author` varchar(50) NOT NULL,
  `floor` varchar(50) NOT NULL,
  `aisel` varchar(50) NOT NULL,
  `self` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fa_book_map`
--

INSERT INTO `fa_book_map` (`id`, `cat_id`, `ISBN`, `copies_no`, `title`, `author`, `floor`, `aisel`, `self`) VALUES
(1, 3, 'ISBN-005', 'COPY0010', 'Ac History', 'AC Auth', 'SD-A001', 'SD-A-001', 'Second Arts'),
(2, 3, 'ISBN-005', 'COPY009', 'Ac History', 'AC Auth', 'SD-A001', 'SD-A-001', 'Second Arts'),
(3, 3, 'ISBN-005', 'COPY008', 'Ac History', 'AC Auth', 'SD-A001', 'SD-A-001', 'Second Arts'),
(4, 3, 'ISBN-005', 'COPY007', 'Ac History', 'AC Auth', 'SD-A001', 'SD-A-001', 'Second Arts'),
(5, 3, 'ISBN-005', 'COPY006', 'Ac History', 'AC Auth', 'SD-A001', 'SD-A-001', 'Second Arts'),
(6, 3, 'ISBN-005', 'COPY005', 'Ac History', 'AC Auth', 'SD-A001', 'SD-A-001', 'Second Arts'),
(7, 3, 'ISBN-005', 'COPY004', 'Ac History', 'AC Auth', 'SD-A001', 'SD-A-001', 'Second Arts'),
(8, 3, 'ISBN-005', 'COPY003', 'Ac History', 'AC Auth', 'SD-A001', 'SD-A-001', 'Second Arts'),
(9, 3, 'ISBN-005', 'COPY002', 'Ac History', 'AC Auth', 'SD-A001', 'SD-A-001', 'Second Arts'),
(10, 3, 'ISBN-005', 'COPY001', 'Ac History', 'AC Auth', 'SD-A001', 'SD-A-001', 'Second Arts'),
(11, 1, 'ISBN-001', 'COPY0025', 'C++', 'C Author', 'SD-A002', 'SD-B-002', 'Self Comp. Sc.'),
(12, 1, 'ISBN-001', 'COPY0024', 'C++', 'C Author', 'SD-A002', 'SD-B-002', 'Self Comp. Sc.'),
(13, 1, 'ISBN-001', 'COPY0023', 'C++', 'C Author', 'SD-A002', 'SD-B-002', 'Self Comp. Sc.'),
(14, 1, 'ISBN-001', 'COPY0022', 'C++', 'C Author', 'SD-A002', 'SD-B-002', 'Self Comp. Sc.'),
(15, 1, 'ISBN-001', 'COPY0021', 'C++', 'C Author', 'SD-A002', 'SD-B-002', 'Self Comp. Sc.'),
(16, 1, 'ISBN-001', 'COPY0020', 'C++', 'C Author', 'SD-A002', 'SD-B-002', 'Self Comp. Sc.'),
(17, 1, 'ISBN-001', 'COPY001', 'C++', 'C Author', 'SD-A002', 'SD-B-002', 'Self Comp. Sc.'),
(18, 1, 'ISBN-001', 'COPY002', 'C++', 'C Author', 'SD-A002', 'SD-B-002', 'Self Comp. Sc.'),
(19, 1, 'ISBN-001', 'COPY003', 'C++', 'C Author', 'SD-A002', 'SD-B-002', 'Self Comp. Sc.'),
(20, 1, 'ISBN-001', 'COPY004', 'C++', 'C Author', 'SD-A002', 'SD-B-002', 'Self Comp. Sc.'),
(21, 1, 'ISBN-001', 'COPY005', 'C++', 'C Author', 'SD-A002', 'SD-B-002', 'Self Comp. Sc.'),
(22, 1, 'ISBN-001', 'COPY006', 'C++', 'C Author', 'SD-A002', 'SD-B-002', 'Self Comp. Sc.'),
(23, 1, 'ISBN-001', 'COPY0010', 'C++', 'C Author', 'SD-A002', 'SD-B-002', 'Self Comp. Sc.'),
(24, 1, 'ISBN-001', 'COPY0011', 'C++', 'C Author', 'SD-A002', 'SD-B-002', 'Self Comp. Sc.'),
(25, 1, 'ISBN-001', 'COPY0013', 'C++', 'C Author', 'SD-A002', 'SD-B-002', 'Self Comp. Sc.'),
(26, 1, 'ISBN-001', 'COPY007', 'C++', 'C Author', 'GR-A/001', 'GR-AS-001', 'GR-S001'),
(27, 1, 'ISBN-001', 'COPY008', 'C++', 'C Author', 'GR-A/001', 'GR-AS-001', 'GR-S001'),
(28, 1, 'ISBN-001', 'COPY009', 'C++', 'C Author', 'GR-A/001', 'GR-AS-001', 'GR-S001'),
(29, 1, 'ISBN-001', 'COPY0012', 'C++', 'C Author', 'GR-A/001', 'GR-AS-001', 'GR-S001'),
(30, 1, 'ISBN-001', 'COPY0014', 'C++', 'C Author', 'GR-A/001', 'GR-AS-001', 'GR-S001'),
(31, 1, 'ISBN-001', 'COPY0015', 'C++', 'C Author', 'GR-A/001', 'GR-AS-001', 'GR-S001'),
(32, 1, 'ISBN-001', 'COPY0016', 'C++', 'C Author', 'GR-A/001', 'GR-AS-001', 'GR-S001'),
(36, 1, 'ISBN-001', 'COPY0017', 'C++', 'C Author', 'SD-A001', 'SD-A-001', 'Second Arts'),
(37, 1, 'ISBN-001', 'COPY0018', 'C++', 'C Author', 'SD-A001', 'SD-A-001', 'Second Arts'),
(38, 1, 'ISBN-001', 'COPY0019', 'C++', 'C Author', 'SD-A001', 'SD-A-001', 'Second Arts');

-- --------------------------------------------------------

--
-- Table structure for table `fa_breakdown_maintain_items`
--

CREATE TABLE `fa_breakdown_maintain_items` (
  `items_id` int(11) NOT NULL,
  `break_id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `sub_cat_id` int(11) NOT NULL,
  `item_id` varchar(150) NOT NULL,
  `quantity` float NOT NULL,
  `stock_qty` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fa_breakdown_maintain_items`
--

INSERT INTO `fa_breakdown_maintain_items` (`items_id`, `break_id`, `cat_id`, `sub_cat_id`, `item_id`, `quantity`, `stock_qty`) VALUES
(1, 1, 0, 0, 'Select', 0, 0),
(2, 1, 4, 2, 'Car', 0, 3),
(3, 2, 3, 6, '003', 0, 0),
(4, 3, 1, 3, 'Rotar', 1, 3),
(5, 4, 1, 3, 'Rotar', 1, 2),
(6, 4, 0, 0, 'Select', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `fa_breakdown_maintenance`
--

CREATE TABLE `fa_breakdown_maintenance` (
  `break_id` int(11) NOT NULL,
  `maintain_date` varchar(30) NOT NULL,
  `utility_id` int(11) NOT NULL,
  `contractor_id` int(11) NOT NULL,
  `break_st_time` text NOT NULL,
  `break_end_time` text NOT NULL,
  `ob_reason` text NOT NULL,
  `ob_1` varchar(200) NOT NULL,
  `ob_2` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fa_breakdown_maintenance`
--

INSERT INTO `fa_breakdown_maintenance` (`break_id`, `maintain_date`, `utility_id`, `contractor_id`, `break_st_time`, `break_end_time`, `ob_reason`, `ob_1`, `ob_2`) VALUES
(1, '26-01-2022', 3, 4, '12:48 PM', '12:48 PM', 'Starting problem', 'Battery is not working', 'Need to recharge the Battery'),
(2, '08-02-2022', 5, 3, '03:57 PM', '03:57 PM', 'reason ', 'observation', 'changed'),
(3, '08-02-2022', 4, 0, '06:03 PM', '06:03 PM', 'Winding Burned', 'Winding Burned', 'Replaced'),
(4, '08-02-2022', 4, 2, '06:08 PM', '06:08 PM', 'Brake Not Working', 'Brake padding Faded', 'Replaced Brake Shoe');

-- --------------------------------------------------------

--
-- Table structure for table `fa_breakdown_new_items`
--

CREATE TABLE `fa_breakdown_new_items` (
  `new_items_id` int(11) NOT NULL,
  `break_id` int(11) NOT NULL,
  `n_item` varchar(100) NOT NULL,
  `n_qty` float NOT NULL,
  `n_bill_date` varchar(30) NOT NULL,
  `n_billno` varchar(100) NOT NULL,
  `n_contractor` varchar(120) NOT NULL,
  `n_comments` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `fa_budget_trans`
--

CREATE TABLE `fa_budget_trans` (
  `id` int(11) NOT NULL,
  `tran_date` date NOT NULL DEFAULT '0000-00-00',
  `account` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `amount` double NOT NULL DEFAULT 0,
  `dimension_id` int(11) DEFAULT 0,
  `dimension2_id` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fa_building_issues`
--

CREATE TABLE `fa_building_issues` (
  `issue_no` int(11) NOT NULL,
  `workorder_id` int(11) NOT NULL DEFAULT 0,
  `reference` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `issue_date` date DEFAULT NULL,
  `loc_code` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `workcentre_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fa_carry_forward_leave`
--

CREATE TABLE `fa_carry_forward_leave` (
  `id` bigint(20) NOT NULL,
  `updated_date` date NOT NULL,
  `no_of_cls` float NOT NULL,
  `no_of_el` float NOT NULL,
  `no_of_pls` float NOT NULL,
  `updated_date_ml` date NOT NULL,
  `updated_date_vl` date NOT NULL,
  `updated_date_el` date NOT NULL,
  `no_of_medical_ls` float NOT NULL,
  `updated_date_on` date NOT NULL,
  `empl` int(11) NOT NULL,
  `empl_id` varchar(50) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `fisical_yr` int(11) NOT NULL,
  `cal_year` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `fa_cat_group`
--

CREATE TABLE `fa_cat_group` (
  `id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `subcat_id` int(11) NOT NULL,
  `cat_group` varchar(110) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `fa_chart_class`
--

CREATE TABLE `fa_chart_class` (
  `cid` int(11) NOT NULL,
  `class_name` varchar(60) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `ctype` tinyint(1) NOT NULL DEFAULT 0,
  `inactive` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fa_chart_master`
--

CREATE TABLE `fa_chart_master` (
  `account_code` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `account_code2` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `account_name` varchar(60) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `account_type` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `inactive` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fa_chart_types`
--

CREATE TABLE `fa_chart_types` (
  `id` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(60) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `class_id` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `parent` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '-1',
  `inactive` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fa_comments`
--

CREATE TABLE `fa_comments` (
  `type` int(11) NOT NULL DEFAULT 0,
  `id` int(11) NOT NULL,
  `date_` date DEFAULT '0000-00-00',
  `memo_` tinytext COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fa_contractor`
--

CREATE TABLE `fa_contractor` (
  `supplier_id` int(11) NOT NULL,
  `supp_name` varchar(60) NOT NULL,
  `supp_ref` varchar(30) NOT NULL,
  `address` tinytext NOT NULL,
  `supp_address` tinytext NOT NULL,
  `gst_no` varchar(25) NOT NULL,
  `website` varchar(100) NOT NULL,
  `bank_account` varchar(60) NOT NULL,
  `curr_code` char(3) NOT NULL,
  `payment_terms` int(11) NOT NULL,
  `tax_included` tinyint(4) NOT NULL,
  `tax_group_id` int(11) NOT NULL,
  `purchase_account` varchar(15) NOT NULL,
  `payable_account` varchar(15) NOT NULL,
  `payment_discount_account` varchar(15) NOT NULL,
  `phone` bigint(20) NOT NULL,
  `phone2` bigint(20) NOT NULL,
  `notes` tinytext NOT NULL,
  `contact` varchar(50) NOT NULL,
  `fax` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `inactive` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `fa_cost_centre`
--

CREATE TABLE `fa_cost_centre` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `descript` text NOT NULL,
  `inactive` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `fa_cost_centre_category`
--

CREATE TABLE `fa_cost_centre_category` (
  `id` int(11) NOT NULL,
  `category_name` varchar(30) NOT NULL,
  `description` text NOT NULL,
  `inactive` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `fa_credit_status`
--

CREATE TABLE `fa_credit_status` (
  `id` int(11) NOT NULL,
  `reason_description` char(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `dissallow_invoices` tinyint(1) NOT NULL DEFAULT 0,
  `inactive` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fa_crm_categories`
--

CREATE TABLE `fa_crm_categories` (
  `id` int(11) NOT NULL COMMENT 'pure technical key',
  `type` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `action` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `description` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `system` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'nonzero for core system usage',
  `inactive` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fa_crm_contacts`
--

CREATE TABLE `fa_crm_contacts` (
  `id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL DEFAULT 0 COMMENT 'foreign key to crm_contacts',
  `type` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `action` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `entity_id` varchar(11) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fa_crm_persons`
--

CREATE TABLE `fa_crm_persons` (
  `id` int(11) NOT NULL,
  `ref` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `name2` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` tinytext COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone2` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fax` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lang` char(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `notes` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `inactive` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fa_currencies`
--

CREATE TABLE `fa_currencies` (
  `currency` varchar(60) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `curr_abrev` char(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `curr_symbol` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `country` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `hundreds_name` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `auto_update` tinyint(1) NOT NULL DEFAULT 1,
  `inactive` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fa_cust_allocations`
--

CREATE TABLE `fa_cust_allocations` (
  `id` int(11) NOT NULL,
  `person_id` int(11) DEFAULT NULL,
  `amt` double UNSIGNED DEFAULT NULL,
  `date_alloc` date NOT NULL DEFAULT '0000-00-00',
  `trans_no_from` int(11) DEFAULT NULL,
  `trans_type_from` int(11) DEFAULT NULL,
  `trans_no_to` int(11) DEFAULT NULL,
  `trans_type_to` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fa_cust_branch`
--

CREATE TABLE `fa_cust_branch` (
  `branch_code` int(11) NOT NULL,
  `debtor_no` int(11) NOT NULL DEFAULT 0,
  `br_name` varchar(60) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `branch_ref` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `br_address` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `area` int(11) DEFAULT NULL,
  `salesman` int(11) NOT NULL DEFAULT 0,
  `default_location` varchar(5) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `tax_group_id` int(11) DEFAULT NULL,
  `sales_account` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `sales_discount_account` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `receivables_account` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `payment_discount_account` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `default_ship_via` int(11) NOT NULL DEFAULT 1,
  `br_post_address` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `group_no` int(11) NOT NULL DEFAULT 0,
  `notes` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `bank_account` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `inactive` tinyint(1) NOT NULL DEFAULT 0,
  `country` int(11) NOT NULL,
  `state` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fa_debtors_master`
--

CREATE TABLE `fa_debtors_master` (
  `debtor_no` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `debtor_ref` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `address` tinytext COLLATE utf8_unicode_ci DEFAULT NULL,
  `tax_id` varchar(55) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `curr_code` char(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `sales_type` int(11) NOT NULL DEFAULT 1,
  `dimension_id` int(11) NOT NULL DEFAULT 0,
  `dimension2_id` int(11) NOT NULL DEFAULT 0,
  `credit_status` int(11) NOT NULL DEFAULT 0,
  `payment_terms` int(11) DEFAULT NULL,
  `discount` double NOT NULL DEFAULT 0,
  `pymt_discount` double NOT NULL DEFAULT 0,
  `credit_limit` float NOT NULL DEFAULT 1000,
  `notes` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `inactive` tinyint(1) NOT NULL DEFAULT 0,
  `country` int(11) NOT NULL,
  `state` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fa_debtors_master`
--

INSERT INTO `fa_debtors_master` (`debtor_no`, `name`, `debtor_ref`, `address`, `tax_id`, `curr_code`, `sales_type`, `dimension_id`, `dimension2_id`, `credit_status`, `payment_terms`, `discount`, `pymt_discount`, `credit_limit`, `notes`, `inactive`, `country`, `state`) VALUES
(3, 'Raushan Kumar', 'RK', 'patna', '99', '', 0, 0, 0, 0, 0, 1, 4, 0, '1000', 0, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `fa_debtor_trans`
--

CREATE TABLE `fa_debtor_trans` (
  `trans_no` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `type` smallint(6) UNSIGNED NOT NULL DEFAULT 0,
  `version` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `debtor_no` int(11) UNSIGNED NOT NULL,
  `branch_code` int(11) NOT NULL DEFAULT -1,
  `tran_date` date NOT NULL DEFAULT '0000-00-00',
  `due_date` date NOT NULL DEFAULT '0000-00-00',
  `reference` varchar(60) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `tpe` int(11) NOT NULL DEFAULT 0,
  `order_` int(11) NOT NULL DEFAULT 0,
  `ov_amount` double NOT NULL DEFAULT 0,
  `ov_gst` double NOT NULL DEFAULT 0,
  `ov_freight` double NOT NULL DEFAULT 0,
  `ov_freight_tax` double NOT NULL DEFAULT 0,
  `ov_discount` double NOT NULL DEFAULT 0,
  `alloc` double NOT NULL DEFAULT 0,
  `prep_amount` double NOT NULL DEFAULT 0,
  `rate` double NOT NULL DEFAULT 1,
  `ship_via` int(11) DEFAULT NULL,
  `dimension_id` int(11) NOT NULL DEFAULT 0,
  `dimension2_id` int(11) NOT NULL DEFAULT 0,
  `payment_terms` int(11) DEFAULT NULL,
  `tax_included` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `gst` int(11) NOT NULL,
  `gst_amt` int(11) NOT NULL,
  `cst` int(11) NOT NULL,
  `cst_amt` int(11) NOT NULL,
  `ist` int(11) NOT NULL,
  `ist_amt` int(11) NOT NULL,
  `hsn_no` int(11) NOT NULL,
  `currency` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `f_year` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fa_debtor_trans`
--

INSERT INTO `fa_debtor_trans` (`trans_no`, `type`, `version`, `debtor_no`, `branch_code`, `tran_date`, `due_date`, `reference`, `tpe`, `order_`, `ov_amount`, `ov_gst`, `ov_freight`, `ov_freight_tax`, `ov_discount`, `alloc`, `prep_amount`, `rate`, `ship_via`, `dimension_id`, `dimension2_id`, `payment_terms`, `tax_included`, `gst`, `gst_amt`, `cst`, `cst_amt`, `ist`, `ist_amt`, `hsn_no`, `currency`, `f_year`) VALUES
(1, 10, 0, 3, 3, '2023-01-05', '2023-01-06', '7', 1, 1, 0, 0, 0, 0, 0, 0, 0, 1, 2, 0, 0, 4, 1, 0, 0, 0, 0, 0, 0, 632, '', '6'),
(2, 10, 0, 3, 3, '2023-01-05', '2023-01-06', '8', 1, 2, 0, 0, 0, 0, 0, 0, 0, 1, 2, 0, 0, 4, 1, 0, 0, 0, 0, 0, 0, 632, '', '6'),
(1, 13, 1, 3, 3, '2023-01-05', '2023-01-06', 'auto', 1, 1, 0, 0, 0, 0, 0, 0, 0, 1, 2, 0, 0, 4, 1, 0, 0, 0, 0, 0, 0, 632, '', '6'),
(2, 13, 1, 3, 3, '2023-01-05', '2023-01-06', 'auto', 1, 2, 0, 0, 0, 0, 0, 0, 0, 1, 2, 0, 0, 4, 1, 0, 0, 0, 0, 0, 0, 632, '', '6');

-- --------------------------------------------------------

--
-- Table structure for table `fa_debtor_trans_details`
--

CREATE TABLE `fa_debtor_trans_details` (
  `id` int(11) NOT NULL,
  `debtor_trans_no` int(11) DEFAULT NULL,
  `debtor_trans_type` int(11) DEFAULT NULL,
  `stock_id` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `description` tinytext COLLATE utf8_unicode_ci DEFAULT NULL,
  `unit_price` double NOT NULL DEFAULT 0,
  `unit_tax` double NOT NULL DEFAULT 0,
  `quantity` double NOT NULL DEFAULT 0,
  `discount_percent` double NOT NULL DEFAULT 0,
  `standard_cost` double NOT NULL DEFAULT 0,
  `qty_done` double NOT NULL DEFAULT 0,
  `src_id` int(11) DEFAULT NULL,
  `gst` double NOT NULL,
  `gst_amt` double NOT NULL,
  `cst` double NOT NULL,
  `cst_amt` double NOT NULL,
  `ist` double NOT NULL,
  `ist_amt` double NOT NULL,
  `hsn_no` int(11) NOT NULL,
  `currency` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fa_debtor_trans_details`
--

INSERT INTO `fa_debtor_trans_details` (`id`, `debtor_trans_no`, `debtor_trans_type`, `stock_id`, `description`, `unit_price`, `unit_tax`, `quantity`, `discount_percent`, `standard_cost`, `qty_done`, `src_id`, `gst`, `gst_amt`, `cst`, `cst_amt`, `ist`, `ist_amt`, `hsn_no`, `currency`) VALUES
(1, 1, 13, 'head001', 'head light ', 0, 0, 1, 0, 0, 1, 6, 0, 0, 0, 0, 0, 0, 632, 0),
(2, 1, 10, 'head001', 'head light ', 0, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 632, 0),
(3, 2, 13, 'head001', 'head light ', 0, 0, 1, 0, 0, 1, 7, 0, 0, 0, 0, 0, 0, 632, 0),
(4, 2, 10, 'head001', 'head light ', 0, 0, 1, 0, 0, 0, 3, 0, 0, 0, 0, 0, 0, 632, 0);

-- --------------------------------------------------------

--
-- Table structure for table `fa_department`
--

CREATE TABLE `fa_department` (
  `dept_id` int(11) NOT NULL,
  `dept_name` tinytext NOT NULL,
  `inactive` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fa_department`
--

INSERT INTO `fa_department` (`dept_id`, `dept_name`, `inactive`) VALUES
(1, 'sdsds', 0);

-- --------------------------------------------------------

--
-- Table structure for table `fa_department_allocation`
--

CREATE TABLE `fa_department_allocation` (
  `id` int(11) NOT NULL,
  `master_id` int(11) NOT NULL,
  `department_id` varchar(110) NOT NULL,
  `quantity` int(11) NOT NULL,
  `inactive` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fa_department_allocation`
--

INSERT INTO `fa_department_allocation` (`id`, `master_id`, `department_id`, `quantity`, `inactive`) VALUES
(1, 1, 'Academics', 5, 0),
(2, 2, 'Academics', 5, 0),
(3, 5, 'Academics', 5, 0);

-- --------------------------------------------------------

--
-- Table structure for table `fa_department_master`
--

CREATE TABLE `fa_department_master` (
  `id` int(11) NOT NULL,
  `building` int(11) NOT NULL,
  `floor` int(11) NOT NULL,
  `room` int(11) NOT NULL,
  `inactive` tinyint(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fa_department_master`
--

INSERT INTO `fa_department_master` (`id`, `building`, `floor`, `room`, `inactive`) VALUES
(1, 3, 1, 40, 0),
(2, 3, 1, 41, 0),
(3, 3, 1, 42, 0),
(4, 3, 1, 43, 0),
(5, 3, 1, 44, 0);

-- --------------------------------------------------------

--
-- Table structure for table `fa_dept_issues`
--

CREATE TABLE `fa_dept_issues` (
  `issue_no` int(11) NOT NULL,
  `workorder_id` int(11) NOT NULL DEFAULT 0,
  `reference` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `issue_date` date DEFAULT NULL,
  `loc_code` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `workcentre_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fa_dept_issue_items`
--

CREATE TABLE `fa_dept_issue_items` (
  `id` int(11) NOT NULL,
  `stock_id` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `issue_id` int(11) DEFAULT NULL,
  `qty_issued` double DEFAULT NULL,
  `unit_cost` double NOT NULL DEFAULT 0,
  `sl_no` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `seat_no` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'NA',
  `seat_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fa_designation_master`
--

CREATE TABLE `fa_designation_master` (
  `id` int(11) NOT NULL,
  `desig_group_id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `inactive` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fa_designation_master`
--

INSERT INTO `fa_designation_master` (`id`, `desig_group_id`, `name`, `description`, `inactive`) VALUES
(1, 1, 'PHP Programmer', 'PHP Programmer', 0),
(2, 1, '.NET Programmer', '.NET Programmer', 0),
(3, 2, 'Andriod Developer', 'Andriod Developer', 0),
(4, 2, 'IOS Developer', 'IOS Developer', 0),
(5, 3, 'Project Manager', 'Project Manager', 0),
(6, 4, 'Marketing Intern', 'Marketing Intern', 0),
(7, 4, 'Technical Intern', 'Technical Intern', 0),
(8, 5, 'Junior Designer', 'Junior Designer', 0),
(9, 5, 'Senior Designer', 'Senior Designer', 0),
(10, 1, 'Junior Programmer', 'Junior Programmer', 0),
(11, 1, 'Senior Programmer', 'Senior Programmer', 0),
(12, 1, 'Team Lead', 'Team Lead', 0),
(13, 3, 'Senior Project Manager', 'Senior Project Manager', 0),
(14, 6, 'Office Assistant', 'Office Assistant', 0),
(15, 7, 'Senior', 'Senior', 0),
(16, 8, 'Tester engineer', 'fresher tester', 0);

-- --------------------------------------------------------

--
-- Table structure for table `fa_dimensions`
--

CREATE TABLE `fa_dimensions` (
  `id` int(11) NOT NULL,
  `reference` varchar(60) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `name` varchar(60) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `type_` tinyint(1) NOT NULL DEFAULT 1,
  `closed` tinyint(1) NOT NULL DEFAULT 0,
  `date_` date NOT NULL DEFAULT '0000-00-00',
  `due_date` date NOT NULL DEFAULT '0000-00-00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fa_dispatch_management`
--

CREATE TABLE `fa_dispatch_management` (
  `id` int(11) NOT NULL,
  `ref_id` varchar(255) NOT NULL,
  `issue_no` varchar(255) DEFAULT NULL,
  `subject_title` varchar(255) NOT NULL,
  `dispatch_date` datetime NOT NULL,
  `person_org_name` varchar(255) NOT NULL,
  `designation` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `pin_no` varchar(50) NOT NULL,
  `dispatch_mode` varchar(255) NOT NULL,
  `document_type` varchar(255) NOT NULL,
  `dispatched_reciept_number_if_any` varchar(255) DEFAULT NULL,
  `upload_scanned_copy` varchar(255) NOT NULL,
  `sender_person` varchar(255) NOT NULL,
  `sender_designation` varchar(255) NOT NULL,
  `sender_department` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `unique_name` varchar(255) NOT NULL,
  `email_id` varchar(255) NOT NULL,
  `contact_no` int(10) NOT NULL,
  `remarks` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fa_dispatch_management`
--

INSERT INTO `fa_dispatch_management` (`id`, `ref_id`, `issue_no`, `subject_title`, `dispatch_date`, `person_org_name`, `designation`, `department`, `address`, `city`, `state`, `pin_no`, `dispatch_mode`, `document_type`, `dispatched_reciept_number_if_any`, `upload_scanned_copy`, `sender_person`, `sender_designation`, `sender_department`, `country`, `filename`, `unique_name`, `email_id`, `contact_no`, `remarks`, `status`) VALUES
(1, 'ref-001', '', '', '2020-01-22 00:00:00', '', '', '', ',', '', '1479', '', '', '', '', '', '', '', '', '99', '', '', '', 0, '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `fa_dispatch_mode`
--

CREATE TABLE `fa_dispatch_mode` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `discription` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `fa_document_type`
--

CREATE TABLE `fa_document_type` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `fa_driver_details`
--

CREATE TABLE `fa_driver_details` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `father_name` varchar(100) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `pin_no` int(11) DEFAULT NULL,
  `phone_no` int(11) DEFAULT NULL,
  `emergency_contact` int(11) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `licence_no` varchar(50) DEFAULT NULL,
  `valid_upto` varchar(40) DEFAULT NULL,
  `aadhar_no` varchar(50) DEFAULT NULL,
  `aadhar_copy` varchar(100) NOT NULL,
  `licence_copy` varchar(100) NOT NULL,
  `profile_pic` varchar(100) NOT NULL,
  `status` int(10) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fa_driver_details`
--

INSERT INTO `fa_driver_details` (`id`, `name`, `father_name`, `address`, `city`, `state`, `pin_no`, `phone_no`, `emergency_contact`, `email`, `licence_no`, `valid_upto`, `aadhar_no`, `aadhar_copy`, `licence_copy`, `profile_pic`, `status`) VALUES
(1, 'Ritika kumari pd', 'ravi shankar pd', '2 telegraph colony', 'patna', 'bihar', 800001, 2147483647, 2147483647, 'test@test.com', '231421425235', '2018-09-18', '536436346347', '1195445301811339265dagobert83_female_user_icon.svg.med.png', 'tt.pdf', '1195445301811339265dagobert83_female_user_icon.svg.med.png', 1),
(2, 'Ritika kumari', 'ravi shankar pd', '2 telegraph colony', 'patna', 'bihar', 800001, 2147483647, 2147483647, 'test2@test.com', '1234233ACCV', '2018-09-20', '232323232323', '1195445301811339265dagobert83_female_user_icon.svg.med.png', 'tt.pdf', '1195445301811339265dagobert83_female_user_icon.svg.med.png', 1),
(3, 'Test Account', 'sgtdh', 'dfhdfh', 'fdjfj', 'fgjfgk', 2147483647, 2147483647, 2147483647, 'test12@test.com', '453536346457', '2018-09-11', ' 352363463467', '1195445301811339265dagobert83_female_user_icon.svg.med.png', 'tt.pdf', '1195445301811339265dagobert83_female_user_icon.svg.med.png', 1),
(5, 'Test Driver ', 'Test 123', 'ABC 123 Street', 'test1', 'test2', 12345667, 2147483647, 233423536, 'test@test.voomm', '214124235236jhj', '1986-10-20', '21414235326346', '1195445301811339265dagobert83_female_user_icon.svg.med.png', 'tt.pdf', '1195445301811339265dagobert83_female_user_icon.svg.med.png', 1),
(6, 'Ashu Singh', 'ABC ABC', '123 Colony ', 'Patna', 'Bihar', 800012, 2147483647, 1234567891, 'ashu@test.com', '214124235236', '2019-05-15', '21414235326346', 'dummy-image.jpg', 'achievement-agreement-arms-1068523.jpg', 'alesia-kazantceva-283288-unsplash.jpg', 1),
(7, 'test user', 'testy', 'patna', 'patna', 'bihar', 800001, 2147483647, 2147483647, 'tetsy@gmil.com', '236532', '2030-12-20', '332632565632', 'download.jpg', 'download.jpg', 'download.jpg', 1),
(8, 'test user', 'testy', 'patna', 'patna', 'bihar', 800001, 2147483647, 2147483647, 'tetsy@gmil.com', '236532', '2030-12-20', '332632565632', 'download.jpg', 'download.jpg', 'download.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `fa_employee`
--

CREATE TABLE `fa_employee` (
  `emp_id` int(11) NOT NULL,
  `emp_first_name` varchar(100) DEFAULT NULL,
  `emp_last_name` varchar(100) DEFAULT NULL,
  `gender` tinyint(1) NOT NULL DEFAULT 0,
  `emp_address` tinytext DEFAULT NULL,
  `emp_mobile` varchar(30) DEFAULT NULL,
  `emp_email` varchar(100) DEFAULT NULL,
  `emp_birthdate` date NOT NULL,
  `emp_notes` tinytext NOT NULL,
  `emp_hiredate` date DEFAULT NULL,
  `department_id` int(11) NOT NULL,
  `salary_scale_id` int(11) NOT NULL DEFAULT 0,
  `emp_releasedate` date DEFAULT NULL,
  `inactive` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `fa_employee_trans`
--

CREATE TABLE `fa_employee_trans` (
  `id` int(11) NOT NULL,
  `trans_no` int(11) NOT NULL DEFAULT 0,
  `payslip_no` int(11) NOT NULL,
  `pay_date` date NOT NULL,
  `to_the_order_of` varchar(255) NOT NULL,
  `pay_amount` double NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `fa_enq_drawings`
--

CREATE TABLE `fa_enq_drawings` (
  `id` int(11) NOT NULL,
  `description` varchar(60) CHARACTER SET utf8 NOT NULL,
  `type_no` varchar(50) CHARACTER SET utf8 NOT NULL,
  `unique_name` varchar(60) CHARACTER SET utf8 NOT NULL,
  `tran_date` date DEFAULT NULL,
  `filename` varchar(60) CHARACTER SET utf8 NOT NULL,
  `filesize` varchar(60) CHARACTER SET utf8 NOT NULL,
  `filetype` varchar(60) CHARACTER SET utf8 NOT NULL,
  `trans_type` varchar(10) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `fa_exchange_rates`
--

CREATE TABLE `fa_exchange_rates` (
  `id` int(11) NOT NULL,
  `curr_code` char(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `rate_buy` double NOT NULL DEFAULT 0,
  `rate_sell` double NOT NULL DEFAULT 0,
  `date_` date NOT NULL DEFAULT '0000-00-00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fa_exchange_rates`
--

INSERT INTO `fa_exchange_rates` (`id`, `curr_code`, `rate_buy`, `rate_sell`, `date_`) VALUES
(1, 'USD', 46.3052, 46.3052, '2010-02-20');

-- --------------------------------------------------------

--
-- Table structure for table `fa_ext_policy`
--

CREATE TABLE `fa_ext_policy` (
  `id` int(11) NOT NULL,
  `ref_id` varchar(50) NOT NULL,
  `ext_policy` varchar(100) NOT NULL,
  `no_day` int(10) NOT NULL,
  `no_time` int(10) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fa_ext_policy`
--

INSERT INTO `fa_ext_policy` (`id`, `ref_id`, `ext_policy`, `no_day`, `no_time`, `status`) VALUES
(39, 'No-001', 'Staff', 10, 5, 0),
(40, 'No-002', 'Student', 7, 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `fa_fiscal_year`
--

CREATE TABLE `fa_fiscal_year` (
  `id` int(11) NOT NULL,
  `begin` date DEFAULT '0000-00-00',
  `end` date DEFAULT '0000-00-00',
  `closed` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fa_fiscal_year`
--

INSERT INTO `fa_fiscal_year` (`id`, `begin`, `end`, `closed`) VALUES
(3, '2019-04-01', '2020-03-31', 0),
(4, '2020-04-01', '2021-03-31', 0),
(5, '2021-04-01', '2022-03-31', 0),
(6, '2022-04-01', '2023-03-31', 0),
(7, '2023-04-01', '2024-03-31', 0);

-- --------------------------------------------------------

--
-- Table structure for table `fa_floor_aisle`
--

CREATE TABLE `fa_floor_aisle` (
  `id` int(11) NOT NULL,
  `floor_id` varchar(100) NOT NULL,
  `floor_aisle` varchar(50) NOT NULL,
  `aisle_desc` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `fa_floor_issues`
--

CREATE TABLE `fa_floor_issues` (
  `issue_no` int(11) NOT NULL,
  `workorder_id` int(11) NOT NULL DEFAULT 0,
  `reference` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `issue_date` date DEFAULT NULL,
  `loc_code` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `workcentre_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fa_floor_issue_items`
--

CREATE TABLE `fa_floor_issue_items` (
  `id` int(11) NOT NULL,
  `stock_id` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `issue_id` int(11) DEFAULT NULL,
  `qty_issued` double DEFAULT NULL,
  `unit_cost` double NOT NULL DEFAULT 0,
  `sl_no` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `room_no` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'NA',
  `department_id` varchar(10) COLLATE utf8_unicode_ci DEFAULT 'NA',
  `seat_no` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'NA',
  `room_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fa_frequency_master`
--

CREATE TABLE `fa_frequency_master` (
  `freq_id` int(11) NOT NULL,
  `frequency_name` varchar(150) NOT NULL,
  `frequency_desc` varchar(150) NOT NULL,
  `inactive` int(11) NOT NULL,
  `frequency_des` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fa_frequency_master`
--

INSERT INTO `fa_frequency_master` (`freq_id`, `frequency_name`, `frequency_desc`, `inactive`, `frequency_des`) VALUES
(1, 'Monthly', 'Monthly', 0, '1 months'),
(2, 'Half-Yearly', 'Half-Yearly', 0, '6 months'),
(3, 'Daily', 'day to day work daily routine', 0, '1 days'),
(4, 'Every 2 Hrs', 'Every 2Hours Routine check', 0, ''),
(5, 'Quarterly', 'Quaterly', 0, '4 months'),
(6, 'Annual', 'Annual', 0, '1 year');

-- --------------------------------------------------------

--
-- Table structure for table `fa_gl_trans`
--

CREATE TABLE `fa_gl_trans` (
  `counter` int(11) NOT NULL,
  `type` smallint(6) NOT NULL DEFAULT 0,
  `type_no` int(11) NOT NULL DEFAULT 0,
  `tran_date` date NOT NULL DEFAULT '0000-00-00',
  `account` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `memo_` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `amount` double NOT NULL DEFAULT 0,
  `dimension_id` int(11) NOT NULL DEFAULT 0,
  `dimension2_id` int(11) NOT NULL DEFAULT 0,
  `person_type_id` int(11) DEFAULT NULL,
  `person_id` tinyblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fa_grn_batch`
--

CREATE TABLE `fa_grn_batch` (
  `id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL DEFAULT 0,
  `purch_order_no` int(11) DEFAULT NULL,
  `reference` varchar(60) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `delivery_date` date NOT NULL DEFAULT '0000-00-00',
  `loc_code` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `rate` double DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fa_grn_batch`
--

INSERT INTO `fa_grn_batch` (`id`, `supplier_id`, `purch_order_no`, `reference`, `delivery_date`, `loc_code`, `rate`) VALUES
(1, 20, 10, '3', '2022-12-16', 'PAT', 1),
(2, 20, 11, '4', '2022-12-16', 'PAT', 1),
(3, 5, 12, '5', '2022-12-16', 'HYD', 1),
(4, 14, 13, '6', '2022-12-16', 'PAT', 1),
(5, 14, 14, '7', '2022-12-16', 'PAT', 1),
(6, 18, 15, '8', '2022-12-16', 'PAT', 1),
(7, 19, 16, '9', '2022-12-16', 'PAT', 1),
(8, 21, 17, '10', '2022-12-16', 'PAT', 1),
(9, 14, 18, '11', '2022-12-16', 'PAT', 1),
(10, 5, 19, '12', '2022-12-16', 'PAT', 1),
(11, 26, 20, '13', '2022-12-16', 'PAT', 1),
(12, 26, 21, '14', '2022-12-16', 'PAT', 1),
(13, 5, 22, '15', '2022-12-16', 'PAT', 1),
(14, 13, 23, '16', '2022-12-16', 'PAT', 1),
(15, 13, 24, '17', '2022-12-16', 'PAT', 1),
(16, 13, 25, '18', '2022-12-16', 'PAT', 1),
(17, 25, 26, '19', '2022-12-16', 'PAT', 1),
(18, 25, 27, '20', '2022-12-16', 'PAT', 1),
(19, 27, 28, '21', '2022-12-16', 'PAT', 1),
(20, 5, 29, '22', '2022-12-16', 'PAT', 1),
(21, 5, 30, '23', '2022-12-16', 'PAT', 1),
(22, 11, 31, '24', '2022-12-16', 'PAT', 1),
(23, 11, 32, '25', '2022-12-16', 'PAT', 1),
(24, 11, 33, '26', '2022-12-16', 'PAT', 1),
(25, 11, 34, '27', '2022-12-16', 'PAT', 1),
(26, 11, 35, '28', '2022-12-16', 'PAT', 1),
(27, 11, 36, '29', '2022-12-16', 'PAT', 1),
(28, 11, 37, '30', '2022-12-16', 'PAT', 1),
(29, 13, 38, '31', '2022-12-16', 'PAT', 1),
(30, 11, 39, '32', '2022-12-16', 'PAT', 1),
(31, 11, 40, '33', '2022-12-16', 'PAT', 1),
(32, 14, 41, '34', '2022-12-16', 'PAT', 1),
(33, 14, 42, '35', '2022-12-16', 'PAT', 1),
(34, 19, 43, '36', '2022-12-16', 'PAT', 1),
(35, 12, 44, '37', '2022-12-16', 'PAT', 1),
(36, 12, 45, '38', '2022-12-16', 'PAT', 1),
(37, 12, 46, '39', '2022-12-16', 'PAT', 1),
(38, 12, 47, '40', '2022-12-16', 'PAT', 1),
(39, 12, 48, '41', '2022-12-16', 'PAT', 1),
(40, 12, 49, '42', '2022-12-16', 'PAT', 1),
(41, 12, 50, '43', '2022-12-16', 'PAT', 1),
(42, 12, 51, '44', '2022-12-16', 'PAT', 1),
(43, 12, 52, '45', '2022-12-16', 'PAT', 1),
(44, 24, 53, '46', '2022-12-16', 'PAT', 1),
(45, 24, 54, '47', '2022-12-16', 'PAT', 1),
(46, 12, 55, '48', '2022-12-16', 'HYD', 1),
(47, 12, 56, '49', '2022-12-16', 'PAT', 1),
(48, 12, 57, '50', '2022-12-16', 'PAT', 1),
(49, 12, 58, '51', '2022-12-16', 'PAT', 1),
(50, 12, 59, '52', '2022-12-16', 'PAT', 1),
(51, 5, 60, '53', '2022-12-16', 'PAT', 1),
(52, 5, 61, '54', '2022-12-16', 'PAT', 1),
(53, 5, 62, '55', '2022-12-16', 'PAT', 1),
(54, 5, 63, '56', '2022-12-16', 'PAT', 1),
(55, 5, 64, '57', '2022-12-16', 'PAT', 1),
(56, 5, 65, '58', '2022-12-16', 'PAT', 1),
(57, 5, 66, '59', '2022-12-16', 'PAT', 1),
(58, 5, 67, '60', '2022-12-16', 'PAT', 1),
(59, 5, 68, '61', '2022-12-16', 'PAT', 1),
(60, 5, 69, '62', '2022-12-16', 'PAT', 1),
(61, 5, 70, '63', '2022-12-16', 'HYD', 1),
(62, 5, 71, '64', '2022-12-16', 'PAT', 1),
(63, 5, 72, '65', '2022-12-16', 'PAT', 1),
(64, 5, 73, '66', '2022-12-16', 'PAT', 1),
(65, 5, 74, '67', '2022-12-16', 'PAT', 1),
(66, 5, 75, '68', '2022-12-16', 'PAT', 1),
(67, 5, 76, '69', '2022-12-16', 'PAT', 1),
(68, 5, 77, '70', '2022-12-16', 'PAT', 1),
(69, 5, 78, '71', '2022-12-16', 'PAT', 1),
(70, 5, 79, '72', '2022-12-16', 'PAT', 1),
(71, 5, 80, '73', '2022-12-16', 'PAT', 1),
(72, 5, 81, '74', '2022-12-16', 'PAT', 1),
(73, 5, 82, '75', '2022-12-16', 'PAT', 1),
(74, 5, 83, '76', '2022-12-16', 'PAT', 1),
(75, 5, 84, '77', '2022-12-16', 'PAT', 1),
(76, 5, 85, '78', '2022-12-16', 'PAT', 1),
(77, 5, 86, '79', '2022-12-16', 'PAT', 1),
(78, 5, 87, '80', '2022-12-16', 'PAT', 1),
(79, 5, 88, '81', '2022-12-16', 'PAT', 1),
(80, 5, 89, '82', '2022-12-16', 'PAT', 1),
(81, 12, 90, '83', '2022-12-16', 'PAT', 1),
(82, 12, 91, '84', '2022-12-16', 'PAT', 1),
(83, 12, 92, '85', '2022-12-16', 'PAT', 1),
(84, 12, 93, '86', '2022-12-16', 'PAT', 1),
(85, 11, 94, '87', '2022-12-16', 'PAT', 1),
(86, 11, 95, '88', '2022-12-16', 'PAT', 1),
(87, 11, 96, '89', '2022-12-16', 'PAT', 1),
(88, 12, 97, '90', '2022-12-16', 'PAT', 1),
(89, 11, 98, '91', '2022-12-16', 'PAT', 1),
(90, 11, 99, '92', '2022-12-16', 'PAT', 1),
(91, 11, 100, '93', '2022-12-16', 'PAT', 1),
(92, 11, 101, '94', '2022-12-16', 'PAT', 1),
(93, 11, 102, '95', '2022-12-16', 'PAT', 1),
(94, 11, 103, '96', '2022-12-16', 'PAT', 1),
(95, 11, 104, '97', '2022-12-16', 'PAT', 1),
(96, 11, 105, '98', '2022-12-16', 'PAT', 1),
(97, 11, 106, '99', '2022-12-16', 'PAT', 1),
(98, 11, 107, '100', '2022-12-16', 'PAT', 1),
(99, 11, 108, '101', '2022-12-16', 'PAT', 1),
(100, 11, 109, '102', '2022-12-16', 'PAT', 1),
(101, 11, 110, '103', '2022-12-16', 'PAT', 1),
(102, 11, 111, '104', '2022-12-16', 'PAT', 1),
(103, 11, 112, '105', '2022-12-16', 'PAT', 1),
(104, 11, 113, '106', '2022-12-16', 'PAT', 1),
(105, 11, 114, '107', '2022-12-16', 'PAT', 1),
(106, 11, 115, '108', '2022-12-19', 'PAT', 1),
(107, 11, 116, '109', '2022-12-19', 'PAT', 1),
(108, 11, 117, '110', '2022-12-19', 'PAT', 1),
(109, 11, 118, '111', '2022-12-19', 'PAT', 1),
(110, 11, 119, '112', '2022-12-19', 'PAT', 1),
(111, 11, 120, '113', '2022-12-19', 'PAT', 1),
(112, 11, 121, '114', '2022-12-19', 'PAT', 1),
(113, 11, 122, '115', '2022-12-19', 'PAT', 1),
(114, 11, 123, '116', '2022-12-19', 'PAT', 1),
(115, 11, 124, '117', '2022-12-19', 'PAT', 1),
(116, 11, 125, '118', '2022-12-19', 'PAT', 1),
(117, 11, 126, '119', '2022-12-19', 'PAT', 1),
(118, 11, 127, '120', '2022-12-19', 'PAT', 1),
(119, 11, 128, '121', '2022-12-19', 'PAT', 1),
(120, 12, 129, '122', '2022-12-19', 'PAT', 1),
(121, 12, 130, '123', '2022-12-19', 'PAT', 1),
(122, 12, 131, '124', '2022-12-19', 'PAT', 1),
(123, 12, 132, '125', '2022-12-19', 'PAT', 1),
(124, 12, 133, '126', '2022-12-19', 'PAT', 1),
(125, 12, 134, '127', '2022-12-19', 'PAT', 1),
(126, 12, 135, '128', '2022-12-19', 'PAT', 1),
(127, 12, 136, '129', '2022-12-19', 'PAT', 1),
(128, 12, 137, '130', '2022-12-19', 'PAT', 1),
(129, 12, 138, '131', '2022-12-19', 'PAT', 1),
(130, 12, 139, '132', '2022-12-19', 'PAT', 1),
(131, 12, 140, '133', '2022-12-19', 'PAT', 1),
(132, 5, 141, '134', '2022-12-19', 'PAT', 1),
(133, 12, 142, '135', '2022-12-19', 'PAT', 1),
(134, 8, 143, '136', '2022-12-19', 'PAT', 1),
(135, 5, 144, '137', '2022-12-19', 'PAT', 1),
(136, 5, 145, '138', '2022-12-19', 'PAT', 1),
(137, 5, 146, '139', '2022-12-19', 'PAT', 1),
(138, 11, 147, '140', '2022-12-19', 'PAT', 1),
(139, 11, 148, '141', '2022-12-19', 'PAT', 1),
(140, 11, 149, '142', '2022-12-19', 'PAT', 1),
(141, 2, 150, '143', '2022-12-19', 'PAT', 1),
(142, 15, 151, '144', '2022-12-19', 'PAT', 1),
(143, 14, 152, '145', '2022-12-19', 'PAT', 1),
(144, 12, 153, '146', '2022-12-19', 'PAT', 1),
(145, 16, 154, '147', '2022-12-19', 'PAT', 1),
(146, 16, 155, '148', '2022-12-19', 'PAT', 1),
(147, 19, 156, '149', '2022-12-19', 'PAT', 1),
(148, 12, 157, '150', '2022-12-19', 'PAT', 1),
(149, 11, 158, '151', '2022-12-19', 'PAT', 1),
(150, 11, 159, '152', '2022-12-19', 'PAT', 1),
(151, 5, 160, '153', '2022-12-19', 'PAT', 1),
(152, 11, 161, '154', '2022-12-19', 'PAT', 1),
(153, 5, 162, '155', '2022-12-19', 'PAT', 1),
(154, 5, 163, '156', '2022-12-19', 'PAT', 1),
(155, 5, 164, '157', '2022-12-19', 'PAT', 1),
(156, 13, 165, '158', '2022-12-19', 'PAT', 1),
(157, 22, 166, '159', '2022-12-19', 'PAT', 1),
(158, 12, 167, '160', '2022-12-19', 'PAT', 1),
(159, 23, 168, '161', '2022-12-19', 'PAT', 1),
(160, 12, 169, '162', '2022-12-19', 'PAT', 1),
(161, 12, 170, '163', '2022-12-19', 'PAT', 1),
(162, 24, 171, '164', '2022-12-19', 'PAT', 1),
(163, 12, 172, '165', '2022-12-19', 'PAT', 1),
(164, 12, 173, '166', '2022-12-19', 'PAT', 1),
(165, 12, 174, '167', '2022-12-19', 'PAT', 1),
(166, 12, 175, '168', '2022-12-19', 'PAT', 1),
(167, 5, 176, '169', '2022-12-19', 'PAT', 1),
(168, 5, 177, '170', '2022-12-19', 'PAT', 1),
(169, 5, 178, '171', '2022-12-19', 'PAT', 1),
(170, 11, 179, '172', '2022-12-19', 'PAT', 1),
(171, 11, 180, '173', '2022-12-19', 'PAT', 1),
(172, 17, 181, '174', '2022-12-19', 'PAT', 1),
(173, 11, 182, '175', '2022-12-19', 'PAT', 1),
(174, 11, 183, '176', '2022-12-19', 'PAT', 1),
(175, 11, 184, '177', '2023-01-30', 'PAT', 1),
(176, 9, 185, '178', '2023-01-31', 'PAT', 1),
(177, 9, 186, '179', '2023-02-01', 'PAT', 1),
(178, 9, 187, '180', '2023-02-01', 'PAT', 1),
(179, 9, 189, '182', '2023-02-01', 'HYD', 1),
(180, 9, 190, '183', '2023-02-02', 'PAT', 1),
(181, 5, 191, '184', '2023-02-02', 'PAT', 1),
(182, 9, 193, '186', '2023-02-03', 'PAT', 1),
(183, 9, 194, '187', '2023-02-03', 'PAT', 1),
(184, 9, 195, '188', '2023-02-03', 'PAT', 1),
(185, 9, 196, '189', '2023-02-03', 'PAT', 1),
(186, 9, 197, '190', '2023-02-03', 'HYD', 1),
(187, 9, 198, '191', '2023-02-03', 'PAT', 1),
(188, 9, 199, '192', '2023-02-03', 'PAT', 1),
(189, 9, 200, '193', '2023-02-03', 'PAT', 1),
(190, 9, 201, '194', '2023-02-03', 'HYD', 1),
(191, 9, 202, '195', '2023-02-06', 'PAT', 1),
(192, 9, 203, '196', '2023-02-06', 'PAT', 1),
(193, 9, 204, '197', '2023-02-06', 'PAT', 1),
(194, 9, 205, '198', '2023-02-06', 'PAT', 1),
(195, 9, 206, '199', '2023-02-06', 'PAT', 1),
(196, 9, 207, '200', '2023-02-06', 'PAT', 1),
(197, 9, 208, '201', '2023-02-06', 'PAT', 1),
(198, 9, 209, '202', '2023-02-06', 'PAT', 1),
(199, 9, 210, '203', '2023-02-06', 'PAT', 1),
(200, 9, 211, '204', '2023-02-06', 'PAT', 1),
(201, 9, 212, '205', '2023-02-06', 'PAT', 1),
(202, 9, 213, '206', '2023-02-06', 'HYD', 1),
(203, 9, 214, '207', '2023-02-06', 'PAT', 1),
(204, 9, 215, '208', '2023-02-06', 'PAT', 1),
(205, 9, 216, '209', '2023-02-06', 'PAT', 1),
(206, 9, 217, '210', '2023-02-06', 'PAT', 1),
(207, 9, 218, '211', '2023-02-06', 'PAT', 1),
(208, 9, 219, '212', '2023-02-06', 'PAT', 1),
(209, 9, 220, '213', '2023-02-06', 'PAT', 1),
(210, 9, 221, '214', '2023-02-06', 'PAT', 1),
(211, 9, 222, '215', '2023-02-06', 'PAT', 1),
(212, 9, 223, '216', '2023-02-06', 'PAT', 1),
(213, 9, 224, '217', '2023-02-07', 'PAT', 1),
(214, 9, 225, '218', '2023-02-07', 'PAT', 1),
(215, 9, 226, '219', '2023-02-07', 'PAT', 1),
(216, 9, 227, '220', '2023-02-07', 'PAT', 1),
(217, 9, 228, '221', '2023-02-07', 'PAT', 1),
(218, 5, 229, '222', '2023-02-07', 'PAT', 1),
(219, 9, 230, '223', '2023-02-07', 'PAT', 1),
(220, 9, 231, '224', '2023-02-07', 'PAT', 1),
(221, 9, 232, '225', '2023-02-07', 'PAT', 1),
(222, 9, 233, '226', '2023-02-07', 'PAT', 1),
(223, 9, 234, '227', '2023-02-07', 'PAT', 1),
(224, 9, 235, '228', '2023-02-07', 'PAT', 1),
(225, 9, 236, '229', '2023-02-07', 'PAT', 1),
(226, 9, 237, '230', '2023-02-07', 'HYD', 1),
(227, 9, 238, '231', '2023-02-07', 'PAT', 1),
(228, 9, 239, '232', '2023-02-07', 'PAT', 1),
(229, 9, 240, '233', '2023-02-07', 'PAT', 1),
(230, 9, 241, '234', '2023-02-07', 'PAT', 1),
(231, 9, 242, '235', '2023-02-07', 'PAT', 1),
(232, 9, 243, '236', '2023-02-07', 'PAT', 1),
(233, 9, 244, '237', '2023-02-07', 'PAT', 1),
(234, 9, 245, '238', '2023-02-07', 'PAT', 1),
(235, 9, 246, '239', '2023-02-07', 'PAT', 1),
(236, 9, 247, '240', '2023-02-07', 'PAT', 1),
(237, 9, 248, '241', '2023-02-07', 'PAT', 1),
(238, 9, 249, '242', '2023-02-07', 'PAT', 1),
(239, 9, 250, '243', '2023-02-07', 'PAT', 1),
(240, 9, 251, '244', '2023-02-07', 'PAT', 1),
(241, 9, 252, '245', '2023-02-07', 'PAT', 1),
(242, 9, 253, '246', '2023-02-07', 'PAT', 1),
(243, 9, 254, '247', '2023-02-07', 'PAT', 1),
(244, 5, 304, '297', '2023-02-08', 'PAT', 1),
(245, 5, 305, '298', '2023-02-08', 'PAT', 1),
(246, 9, 306, '299', '2023-02-08', 'PAT', 1),
(247, 9, 307, '300', '2023-02-08', 'PAT', 1),
(248, 5, 308, '301', '2023-02-09', 'PAT', 1);

-- --------------------------------------------------------

--
-- Table structure for table `fa_grn_items`
--

CREATE TABLE `fa_grn_items` (
  `id` int(11) NOT NULL,
  `grn_batch_id` int(11) DEFAULT NULL,
  `po_detail_item` int(11) NOT NULL DEFAULT 0,
  `item_code` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `description` tinytext COLLATE utf8_unicode_ci DEFAULT NULL,
  `qty_recd` double NOT NULL DEFAULT 0,
  `quantity_inv` double NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fa_grn_items`
--

INSERT INTO `fa_grn_items` (`id`, `grn_batch_id`, `po_detail_item`, `item_code`, `description`, `qty_recd`, `quantity_inv`) VALUES
(1, 1, 32, 'L-BAG-LP-BLUE', 'Bag (HS.CANVOBNP L P 01 Blue)', 1, 0),
(2, 2, 33, 'L-BAG-LP-GRAY', 'Bag (HS.CANVOBNP L P 01 Gray)', 1, 0),
(3, 3, 34, 'L-BAG-HP', 'Laptop Bag for Hp Pavillion ', 2, 0),
(4, 4, 35, 'BAT-42AH-E', 'Exide 24 Nos Battery ( 42 AH )', 26, 0),
(5, 5, 36, 'BAT-EP65-12-E', 'EXIDE EP 65-12 BATTERY', 16, 0),
(6, 6, 37, 'BAT-LAP-HPOA04', 'Lap care battery (HPOA04)', 1, 0),
(7, 7, 38, 'BAT-LAP-INEX', 'Dell inspiron laptop battery (Lapkit inex)', 1, 0),
(8, 8, 39, 'BAT-150AH-T-E', 'Exide inva tall tublar battery  150 AH , 12 V (FEMO-IMTT1500)', 2, 0),
(9, 9, 40, 'BAT-65AH-E', 'Development Floor Ups 16 Battery (Exide 65 Ah Powersafe Plus) 2 Year Warranty ', 16, 0),
(10, 10, 41, 'BAT-LAP-OA04', 'Lapcare Compatible battery ( OA04)', 1, 0),
(11, 11, 42, 'BAT-UPS-HB1875', 'MICROTEK SINE WAVE INVERTER UPS HB1875', 1, 0),
(12, 12, 43, 'BAT-150AH-T-E', 'Exide inva tall tublar battery  150 AH , 12 V (FEMO-IMTT1500)', 4, 0),
(13, 13, 44, 'BAT-LAP-LAOBT6C2196', 'Laptop Battery for Acer Laptop (LAOBT6C2196)', 1, 0),
(14, 14, 45, 'ESSL-AM-X990', 'Attandance Machine Essl  (Model no :-  X990 + ID)', 2, 0),
(15, 15, 46, 'ESSL-FR1200 ', 'Fingure Reaer Essl ( Modal no :- FR1200 , RS 485 )', 2, 0),
(16, 16, 47, 'BIOCARD', 'Biometric Card Access ', 6, 0),
(17, 17, 48, 'ESSL-AM-X990', 'Attandance Machine Essl  (Model no :-  X990 + ID)', 1, 0),
(18, 18, 49, 'ESSL-FR1200 ', 'Fingure Reaer Essl ( Modal no :- FR1200 , RS 485 )', 1, 0),
(19, 19, 50, 'CAB-POWER', 'Laptop power cable ( Dell )', 1, 0),
(20, 20, 51, 'CAB-HDMI', 'MERCURY HDMI CABLE 20 MTR', 1, 0),
(21, 21, 52, 'CAB-POWER', 'Laptop power cable ( Dell )', 5, 0),
(22, 22, 53, 'L-BAG-LENOVO', 'Lenovo Bagpack ', 1, 0),
(23, 23, 54, 'L-BAG-HP', 'Laptop Bag for Hp Pavillion ', 2, 0),
(24, 24, 55, 'BAT-LAP-B', 'Laptop Battery For Bimlesh ', 1, 0),
(25, 25, 56, 'BAT-LAP-N4010', 'Dell laptop Battery(DELL Inspiron 14R(N4010) 6 Cell Laptop Battery)', 1, 0),
(26, 26, 57, 'BAT-MICRO-L', 'Micro Lithium ion Battery  ', 10, 0),
(27, 27, 58, 'BAT-LAP-TC-3817U', 'Laptop Battery for standby laptop Thoshiba ( Modal no :- TC-3817U', 1, 0),
(28, 28, 59, 'CAB-HDMI', 'MERCURY HDMI CABLE 20 MTR', 1, 0),
(29, 29, 60, 'DS-2CE1AC0T-IRPF', 'Hikvision Bullet camera ( Modal no :- DS-2CE1AC0T-IRPF = 1 Mp ) ', 1, 0),
(30, 30, 61, 'DS-2CD1323G0E-I ', 'Hikvision Dome Camera Moadl no :- ( DS-2CD1323G0E-I )', 24, 0),
(31, 31, 62, 'DS-2CD2023G2-IU', 'Hikvision Bullet Camea:- Modal no :- ( DS-2CD2023G2-IU )', 3, 0),
(32, 32, 63, 'UPS-10-KVA', 'ON LINE UPS ( I -Max 10 KVA/192 V )', 1, 0),
(33, 33, 64, 'UPS-10-KVA', 'ON LINE UPS ( I -Max 10 KVA/192 V )', 1, 0),
(34, 34, 65, 'KEYBOARD', 'Dell vostro 2520 Keyboard (Newtrix)', 1, 0),
(35, 35, 66, 'HDMI-CONVERTER', 'Display port to Feamle HDMI converter ', 1, 0),
(36, 36, 67, 'USB-PENDRIVE-64GB', 'SanDisk Ultra 64 GB USB Pen Drives (SDDDC2-064G-I35, Black, Silver) | B01EZ0X3L8 ', 1, 0),
(37, 36, 68, 'HDD-SATA-2TB', 'Samsung 870 EVO  - 2TB SATA SSD (MZ-77E2T0)', 1, 0),
(38, 37, 69, 'ADAP-WIRELESS-T2U', 'Tp-Link Nano usb wireless adaptor (archer t2u nano us ver 1.0)', 2, 0),
(39, 38, 70, 'ADAP-CONVERTER-TC', 'Type C to USB Converter Adaptor ', 1, 0),
(40, 39, 71, 'ADAP-NT-UE300C-TC', 'Type C to RJ45 Gigabit Network Adapter (Model :- UE300C(UN)', 2, 0),
(41, 39, 72, 'ADAP-NT-UE300C-USB3', 'USB 3.0 to Gigabyte Etherney Adapter (Model :- UE300C(UN)', 2, 0),
(42, 39, 73, 'USB-PORT-HUB4', 'USB 3.1 Gen:1    4 Port Hub (  QZ-HB03)', 1, 0),
(43, 39, 74, 'ADAP-USB-T3-QZ-AD11', 'USB 3.1 Type C to Type a Converter (QZ AD11)', 2, 0),
(44, 40, 75, 'MON-GW2480-T-24', 'BenQ GW2480 24-inch', 1, 0),
(45, 41, 76, 'MON-24MK600M-24', 'Lg 24MK600M 24&quot;', 1, 0),
(46, 42, 77, 'MON-GW2480-T-24', 'Benq Monitor 24&quot; (GW2480-B)', 2, 0),
(47, 43, 78, 'PRECISION-110', 'Screwdriver 110 in 1 set Precision ', 1, 0),
(48, 44, 79, 'CAB-FING-SMPS', 'Fingures Cabinet with SMPS ', 1, 0),
(49, 44, 80, 'CPU-I5-10400', 'CPU i5 2.9 Ghz ( 10400)', 1, 0),
(50, 44, 81, 'MTB-B460M-DS3H-AC', 'Gigabyte MBD ( B460M DS3H AC )', 1, 0),
(51, 44, 82, 'RAM-DDR4-16GB', '16 GB 3000 Mhz DDR4 CORSIAR VEN RAM', 1, 0),
(52, 44, 83, 'HDD-SSD-500GB', 'SSD  SAMSUNG 98O EVO NVME 5OOGB ( MZ-V8V500BW )', 1, 0),
(53, 44, 84, 'HDD-HDD-1TB', 'HDD Segate 1 TB Barracudda ', 1, 0),
(54, 44, 85, 'MON-E2421HN-24', 'MONITOR DELL 24 Modal No :- (E2421HN) WITH VGA+HDMI', 1, 0),
(55, 45, 86, 'HDD-SSD-500GB', 'SSD  SAMSUNG 98O EVO NVME 5OOGB ( MZ-V8V500BW )', 6, 0),
(56, 46, 87, 'HEADPHONE-G231', 'Logitech gaming headphone G231 prodigy ', 2, 0),
(57, 47, 88, 'USB-SOUND', 'Usb sound card ', 1, 0),
(58, 48, 89, 'MON-GW2480-T-24', 'BenQ GW2480 24-inch', 2, 0),
(59, 49, 90, 'MON-GW2480-T-24', 'BenQ GW2480 24-inch', 1, 0),
(60, 50, 91, 'M-PHONE-BY-M1', 'Boya ( BY-M1) Microphone ', 1, 0),
(61, 51, 92, 'RAM-DDR4-16GB', '16 GB 3000 Mhz DDR4 CORSIAR VEN RAM', 1, 0),
(62, 52, 93, 'HDD-SSD-500GB', 'SSD  SAMSUNG 98O EVO NVME 5OOGB ( MZ-V8V500BW )', 2, 0),
(63, 53, 94, 'CPU-I5-10400', 'CPU i5 2.9 Ghz ( 10400)', 1, 0),
(64, 54, 95, 'MTB-H470M-DS3H', 'Gigabyte Motherboard Modal No :- (H470M DS3H)', 1, 0),
(65, 54, 96, 'RAM-DDR4-16GB', '16 GB 3000 Mhz DDR4 CORSIAR VEN RAM', 1, 0),
(66, 54, 97, 'HDD-SSD-500GB', 'SSD  SAMSUNG 98O EVO NVME 5OOGB ( MZ-V8V500BW )', 1, 0),
(67, 54, 98, 'HDD-HDD-1TB', 'HDD Segate 1 TB Barracudda ', 1, 0),
(68, 54, 99, 'CAB-FING-SMPS', 'Fingures Cabinet with SMPS ', 1, 0),
(69, 54, 100, 'HDD-SSD-480GB', 'WD Green 480 GB SSD ', 5, 0),
(70, 55, 101, 'MOUSE-WIRELESS', 'Logitech MK275 Wireless Keyboard &amp; Mouse ', 1, 0),
(71, 55, 102, 'HEADPHONE-G340', 'Ligitech H340 usb headphone ', 1, 0),
(72, 56, 103, 'CAB-CORSIAR', 'Corsiar Cabinet', 2, 0),
(73, 56, 104, 'RAM-DDR4-16GB', '16 GB 3000 Mhz DDR4 CORSIAR VEN RAM', 2, 0),
(74, 56, 105, 'CPU-I5-10400', 'CPU i5 2.9 Ghz ( 10400)', 2, 0),
(75, 56, 106, 'HDD-500GB', 'NVME Kingston 500 GB ', 2, 0),
(76, 56, 107, 'HDD-HDD-1TB', 'HDD Segate 1 TB Barracudda ', 2, 0),
(77, 56, 108, 'MTB-Z490', 'Gigabyte Z490 Mtb', 2, 0),
(78, 56, 109, 'HDD-SSD-480GB', 'WD Green 480 GB SSD ', 2, 0),
(79, 56, 110, 'SMPS-CORSIAR-450', 'Corsiar 450 Watt smps ', 2, 0),
(80, 57, 111, 'SMPS-F-P-400', 'Finger&#039;s Polonium-400', 1, 0),
(81, 57, 112, 'SMPS-F-G-12-407', 'SMPS Fingers gama-12-407', 1, 0),
(82, 57, 113, 'MON-FRONTECH', 'Frontech', 1, 0),
(83, 58, 114, 'HDD-SSD-500GB', 'SSD  SAMSUNG 98O EVO NVME 5OOGB ( MZ-V8V500BW )', 5, 0),
(84, 59, 115, 'SMPS-F-G-401', 'SMPS Finger&#039;s Gamma-401 ', 5, 0),
(85, 60, 116, 'CPU-I3-10105', 'Cpu core i3-10105 3.7 GHZ 6 MB Cache ', 1, 0),
(86, 60, 117, 'MTB-B460M-DS3H-V2', 'Gigabyte B460M DS3H V2', 1, 0),
(87, 60, 118, 'RAM-DDR4-8GB', 'Corsiar DDR 4 RAM 8 GB 3000 Mhz', 1, 0),
(88, 60, 119, 'HDD-500GB', 'NVME Kingston 500 GB ', 1, 0),
(89, 61, 120, 'CPU-I3-10105', 'Cpu core i3-10105 3.7 GHZ 6 MB Cache ', 1, 0),
(90, 61, 121, 'MTB-B460M-DS3H-V2', 'Gigabyte B460M DS3H V2', 1, 0),
(91, 61, 122, 'RAM-DDR4-8GB', 'Corsiar DDR 4 RAM 8 GB 3000 Mhz', 1, 0),
(92, 61, 123, 'HDD-500GB', 'NVME Kingston 500 GB ', 1, 0),
(93, 61, 124, 'MON-22MP68VQ-22', 'Lg 22&quot; ips monitor modal no :- 22MP68VQ', 1, 0),
(94, 61, 125, 'CAB-FING-SMPS', 'Fingures Cabinet with SMPS ', 1, 0),
(95, 62, 126, 'CPU-I3-10105', 'Cpu core i3-10105 3.7 GHZ 6 MB Cache ', 1, 0),
(96, 62, 127, 'RAM-DDR4-8GB', 'Corsiar DDR 4 RAM 8 GB 3000 Mhz', 1, 0),
(97, 62, 128, 'HDD-500GB', 'NVME Kingston 500 GB ', 1, 0),
(98, 62, 129, 'MTB-B460M-DS3H-V2', 'Gigabyte B460M DS3H V2', 1, 0),
(99, 62, 130, 'MON-22MP68VQ-22', 'Lg 22&quot; ips monitor modal no :- 22MP68VQ', 1, 0),
(100, 62, 131, 'CAB-FING-SMPS', 'Fingures Cabinet with SMPS ', 1, 0),
(101, 63, 132, 'CPU-I3-10105', 'Cpu core i3-10105 3.7 GHZ 6 MB Cache ', 2, 0),
(102, 63, 133, 'MTB-H470M-DS3H', 'Gigabyte Motherboard Modal No :- (H470M DS3H)', 2, 0),
(103, 63, 134, 'RAM-DDR4-8GB', 'Corsiar DDR 4 RAM 8 GB 3000 Mhz', 2, 0),
(104, 63, 135, 'HDD-500GB', 'NVME Kingston 500 GB ', 2, 0),
(105, 63, 136, 'CAB-FING-SMPS', 'Fingures Cabinet with SMPS ', 2, 0),
(106, 64, 137, 'MOUSE-PAD', 'Mouse pad', 1, 0),
(107, 64, 138, 'HEADPHONE-F5', 'Finger&#039;s F5 Single jack headphone (Showstopper)', 2, 0),
(108, 65, 139, 'SMPS-FA-C3', 'Cabinet Finger&#039;s Ascend c3 with SMPS ', 1, 0),
(109, 65, 140, 'CPU-I5-10400', 'CPU i5 2.9 Ghz ( 10400)', 1, 0),
(110, 65, 141, 'MTB-B56OM-DS3H-AC', 'Motherboard Gigabyte  Modal No :-(B56OM-DS3H:AC) ', 1, 0),
(111, 65, 142, 'RAM-DDR4-16GB', '16 GB 3000 Mhz DDR4 CORSIAR VEN RAM', 1, 0),
(112, 65, 143, 'HDD-SSD-500GB', 'SSD  SAMSUNG 98O EVO NVME 5OOGB ( MZ-V8V500BW )', 1, 0),
(113, 65, 144, 'HDD-HDD-1TB', 'HDD Segate 1 TB Barracudda ', 1, 0),
(114, 65, 145, 'MON-S2421HN-24', 'Monitor dell 24&quot; Modal No: ( S2421HN )', 1, 0),
(115, 66, 146, 'RAM-DDR4-16GB', '16 GB 3000 Mhz DDR4 CORSIAR VEN RAM', 1, 0),
(116, 66, 147, 'HDD-SSD-500GB', 'SSD  SAMSUNG 98O EVO NVME 5OOGB ( MZ-V8V500BW )', 5, 0),
(117, 67, 148, 'HDD-SSD-500GB', 'SSD  SAMSUNG 98O EVO NVME 5OOGB ( MZ-V8V500BW )', 1, 0),
(118, 68, 149, 'MON-22MP68VQ-22', 'Lg 22&quot; ips monitor modal no :- 22MP68VQ', 1, 0),
(119, 69, 150, 'MTB-H110', 'Gigabyte H110 M/b', 1, 0),
(120, 69, 151, 'MON-22MP68VQ-22', 'Lg 22&quot; ips monitor modal no :- 22MP68VQ', 1, 0),
(121, 70, 152, 'HEADPHONE-H5', 'Finger&#039;s show stoper H5', 2, 0),
(122, 71, 153, 'CAB-FING-SMPS', 'Fingures Cabinet with SMPS ', 1, 0),
(123, 71, 154, 'MTB- B560M-AE', ' Motherboard (Gigabyte B560M Aorus Elite) ', 1, 0),
(124, 71, 155, 'RAM-DDR4-16GB', '16 GB 3000 Mhz DDR4 CORSIAR VEN RAM', 1, 0),
(125, 71, 156, 'HDD-SSD-500GB', 'SSD  SAMSUNG 98O EVO NVME 5OOGB ( MZ-V8V500BW )', 1, 0),
(126, 71, 157, 'MON-22MP68VQ-22', 'Lg 22&quot; ips monitor modal no :- 22MP68VQ', 1, 0),
(127, 72, 158, 'HDD-SSD-480GB', 'WD Green 480 GB SSD ', 5, 0),
(128, 73, 159, 'HEADPHONE-H-340', 'Ligitech H340 usb headphone ', 1, 0),
(129, 73, 160, 'HEADPHONE-H9', 'Finger&#039;s Usb-Tonic H9 Hedaphone', 1, 0),
(130, 74, 161, 'MTB-B460M-DS3H-V2', 'Gigabyte B460M DS3H V2', 2, 0),
(131, 74, 162, 'CPU-I5-10400', 'CPU i5 2.9 Ghz ( 10400)', 2, 0),
(132, 74, 163, 'RAM-DDR4-16GB', '16 GB 3000 Mhz DDR4 CORSIAR VEN RAM', 2, 0),
(133, 74, 164, 'HDD-SSD-500GB', 'SSD  SAMSUNG 98O EVO NVME 5OOGB ( MZ-V8V500BW )', 2, 0),
(134, 74, 165, 'HDD-HDD-1TB', 'HDD Segate 1 TB Barracudda ', 2, 0),
(135, 74, 166, 'CAB-FING-SMPS', 'Fingures Cabinet with SMPS ', 2, 0),
(137, 75, 168, 'MTB-B460M-DS3H-V2', 'Gigabyte B460M DS3H V2', 1, 0),
(138, 75, 169, 'CPU-I5-10400', 'CPU i5 2.9 Ghz ( 10400)', 1, 0),
(139, 75, 170, 'RAM-DDR4-8GB', 'Corsiar DDR 4 RAM 8 GB 3000 Mhz', 2, 0),
(140, 75, 171, 'HDD-SSD-500GB', 'SSD  SAMSUNG 98O EVO NVME 5OOGB ( MZ-V8V500BW )', 1, 0),
(141, 75, 172, 'HDD-HDD-1TB', 'HDD Segate 1 TB Barracudda ', 1, 0),
(142, 75, 173, 'CAB-FING-SMPS', 'Fingures Cabinet with SMPS ', 1, 0),
(143, 75, 174, 'MON-22MP68VQ-22', 'Lg 22&quot; ips monitor modal no :- 22MP68VQ', 1, 0),
(144, 76, 175, 'MTB- B560M-AE', ' Motherboard (Gigabyte B560M Aorus Elite) ', 1, 0),
(145, 76, 176, 'HDD-500GB', 'NVME Kingston 500 GB ', 1, 0),
(146, 76, 177, 'HDD-HDD-2TB', 'Segate 2 TB HDD ', 1, 0),
(147, 77, 178, 'SMPS-S-H5', 'Finger&#039;s show stoper H5', 1, 0),
(148, 77, 179, 'HEADPHONE-G340', 'Ligitech H340 usb headphone ', 1, 0),
(149, 78, 180, 'HEADPHONE-H-111', 'Logitech H111 Singal jack Headphone ', 2, 0),
(150, 79, 181, 'HDD-SSD-500GB', 'SSD  SAMSUNG 98O EVO NVME 5OOGB ( MZ-V8V500BW )', 1, 0),
(151, 80, 182, 'CPU-I5-10400', 'CPU i5 2.9 Ghz ( 10400)', 2, 0),
(152, 80, 183, 'CAB-FING-SMPS', 'Fingures Cabinet with SMPS ', 1, 0),
(153, 80, 184, 'MTB-B460M-DS3H-V2', 'Gigabyte B460M DS3H V2', 2, 0),
(154, 80, 185, 'HDD-SSD-500GB', 'SSD  SAMSUNG 98O EVO NVME 5OOGB ( MZ-V8V500BW )', 1, 0),
(155, 80, 186, 'RAM-DDR4-16GB', '16 GB 3000 Mhz DDR4 CORSIAR VEN RAM', 1, 0),
(156, 80, 187, 'HDD-HDD-1TB', 'HDD Segate 1 TB Barracudda ', 2, 0),
(157, 81, 188, 'FOOTPEDAL-ODIN', 'Odin FootPedal ', 1, 0),
(158, 82, 189, 'ZEB-CRYSTAL-WEBCAM ', 'Zebronics Web Camera ( Modal No :- ZEB-CRYSTAL CLEAR )', 1, 0),
(159, 83, 190, 'HEADPHONE-F-10', 'Finger&#039;s F10 Headphone ', 5, 0),
(160, 84, 191, 'MON-22MP68VQ-22', 'Lg 22&quot; ips monitor modal no :- 22MP68VQ', 2, 0),
(161, 85, 192, 'HEADPHONE-H-340', 'Ligitech H340 usb headphone ', 1, 0),
(162, 86, 193, 'HDD-SSD-1TB', 'USB SSD :- 1 TB Samsung Protable SSD T5 ( Modal No :- MU-PA1T0B )', 1, 0),
(163, 86, 194, 'ADAP-USB-T3-VIBOTON', 'M2 Casing Type C to usb 3.0 (VIBOTON)', 1, 0),
(164, 86, 195, 'ADAP-USB-SATA', 'Xcess Sata Usb casing', 1, 0),
(165, 87, 196, 'HEADPHONE-D3', 'Usb Headphone i ball upbeat d3 with mic ', 1, 0),
(166, 88, 197, 'HEADPHONE-F10', 'Finger&#039;s F10 Headphone ', 5, 0),
(167, 89, 198, 'HDD-HDD-1TB', 'HDD Segate 1 TB Barracudda ', 2, 0),
(168, 90, 199, 'MTB-B365M D3H', 'MBD :- Gigabyte ( B365M D3H )', 1, 0),
(169, 90, 200, 'CPU-I3-8100', 'CPUi3-8100   8th Gen  ', 1, 0),
(170, 90, 201, 'RAM-DDR4-8GB', 'Corsiar DDR 4 RAM 8 GB 3000 Mhz', 1, 0),
(171, 90, 202, 'CAB-IBALL', 'I ball cabinet', 1, 0),
(172, 90, 203, 'HDD-SSD-250GB', 'SSD Segate Barracuda 250 GB ', 1, 0),
(173, 90, 204, 'MON-GW2480-T-24', 'BenQ GW2480 24-inch', 2, 0),
(174, 90, 205, 'RAM-DDR3-8GB', 'RAM DDR-3    8 GB Kingston 1333 Mhz', 2, 0),
(175, 91, 206, 'MTB-B365M D3H', 'MBD :- Gigabyte ( B365M D3H )', 1, 0),
(176, 91, 207, 'CPU-I5-8400', 'I5-8400 Cpu', 1, 0),
(177, 91, 208, 'RAM-DDR4-16GB', '16 GB 3000 Mhz DDR4 CORSIAR VEN RAM', 1, 0),
(178, 91, 209, 'CAB-IBALL', 'I ball cabinet', 1, 0),
(179, 91, 210, 'MON-GW2480-T-24', 'BenQ GW2480 24-inch', 1, 0),
(180, 91, 211, 'HDD-SSD-500GB', 'SSD  SAMSUNG 98O EVO NVME 5OOGB ( MZ-V8V500BW )', 1, 0),
(181, 92, 212, 'HDD-SSD-500GB', 'SSD  SAMSUNG 98O EVO NVME 5OOGB ( MZ-V8V500BW )', 1, 0),
(182, 93, 213, 'MTB-B360M-D3H', 'Gigabyte B360M-D3H Motherboard', 1, 0),
(183, 93, 214, 'CPU-I5-8400', 'I5-8400 Cpu', 1, 0),
(184, 93, 215, 'RAM-DDR4-16GB', '16 GB 3000 Mhz DDR4 CORSIAR VEN RAM', 1, 0),
(185, 93, 216, 'HDD-1TB', 'Segate 1 TB Barracaudda Hdd', 1, 0),
(186, 93, 217, 'CAB-IBALL', 'I ball cabinet', 1, 0),
(187, 93, 218, 'RAM-DDR3-16GB', 'Corsiar value set DDR3 1600 RAM', 1, 0),
(188, 94, 219, 'LOGI-WEBCAM-C270', 'Logitech Web Cam ( C270 )', 3, 0),
(189, 95, 220, 'MTB-B460M-DS3H-AC', 'Gigabyte B360M-D3H Motherboard', 2, 0),
(190, 95, 221, 'RAM-DDR4-8GB', 'Corsiar DDR 4 RAM 8 GB 3000 Mhz', 2, 0),
(191, 95, 222, 'HDD-500GB', 'NVME Kingston 500 GB ', 2, 0),
(192, 95, 223, 'CPU-I3-BX8070110100', 'i3 10th Gen 3.2Ghz (BX8070110100 )', 2, 0),
(193, 95, 224, 'CAB-FING-SMPS', 'Fingures Cabinet with SMPS ', 2, 0),
(194, 95, 225, 'SMPS-F-GAMA-401', 'Fingures SMPS (GAMA-401)', 4, 0),
(195, 96, 226, 'HDD-SSD-500GB', 'SSD  SAMSUNG 98O EVO NVME 5OOGB ( MZ-V8V500BW )', 1, 0),
(196, 97, 227, 'HDD-HDD-1TB', 'HDD Segate 1 TB Barracudda ', 2, 0),
(197, 97, 228, 'SMPS-I-ZPS-281', 'SMPS  I Ball :- ZPS-281 ', 2, 0),
(198, 98, 229, 'MTB-B460M-DS3H-AC', 'Gigabyte MBD ( B460M DS3H AC )', 1, 0),
(199, 98, 230, 'HDD-HDD-1TB', 'HDD Segate 1 TB Barracudda ', 1, 0),
(200, 98, 231, 'RAM-DDR4-16GB', '16 GB 3000 Mhz DDR4 CORSIAR VEN RAM', 1, 0),
(201, 98, 232, 'CPU-I5-10400', 'CPU i5 2.9 Ghz ( 10400)', 1, 0),
(202, 98, 233, 'HDD-HDD-1TB', 'HDD Segate 1 TB Barracudda ', 1, 0),
(203, 98, 234, 'CAB-FING-SMPS', 'Fingures Cabinet with SMPS ', 1, 0),
(204, 98, 235, 'MON-GW2480-T-24', 'BenQ GW2480 24-inch', 1, 0),
(205, 99, 236, 'MTB- B560M-AE', ' Motherboard (Gigabyte B560M Aorus Elite) ', 1, 0),
(206, 99, 237, 'MTB-B560M-DS3H-AC', 'Motherboard (Gigabyte B560M DS3H AC) ', 1, 0),
(207, 99, 238, 'RAM-DDR4-16GB', '16 GB 3000 Mhz DDR4 CORSIAR VEN RAM', 3, 0),
(208, 99, 239, 'HDD-SSD-500GB', 'SSD  SAMSUNG 98O EVO NVME 5OOGB ( MZ-V8V500BW )', 1, 0),
(209, 99, 240, 'MON-S2421H-24', 'Dell 24&quot; Ips Monitor Modal No :- S2421H ', 1, 0),
(210, 99, 241, 'CAB-FING-SMPS', 'Fingures Cabinet with SMPS ', 1, 0),
(211, 100, 242, 'CAB-FING-SMPS', 'Fingures Cabinet with SMPS ', 1, 0),
(212, 100, 243, 'MTB- B560M-AE', ' Motherboard (Gigabyte B560M Aorus Elite) ', 1, 0),
(213, 100, 244, 'RAM-DDR4-16GB', '16 GB 3000 Mhz DDR4 CORSIAR VEN RAM', 1, 0),
(214, 100, 245, 'HDD-SSD-500GB', 'SSD  SAMSUNG 98O EVO NVME 5OOGB ( MZ-V8V500BW )', 1, 0),
(215, 100, 246, 'MON-S2421H-24', 'Dell 24&quot; Ips Monitor Modal No :- S2421H ', 1, 0),
(216, 101, 247, 'MTB-B360M-D3H', 'Gigabyte B360M-D3H Motherboard', 2, 0),
(217, 101, 248, 'CPU-I5-8400', 'I5-8400 Cpu', 1, 0),
(218, 101, 249, 'CPU-I3-8100', 'CPUi3-8100   8th Gen  ', 1, 0),
(219, 101, 250, 'RAM-DDR4-16GB', '16 GB 3000 Mhz DDR4 CORSIAR VEN RAM', 1, 0),
(220, 101, 251, 'RAM-DDR4-8GB', 'Corsiar DDR 4 RAM 8 GB 3000 Mhz', 1, 0),
(221, 101, 252, 'HDD-1TB', 'Segate 1 TB Barracaudda Hdd', 4, 0),
(222, 101, 253, 'CAB-IBALL', 'I ball cabinet', 2, 0),
(223, 101, 254, 'ADAP-LAPCARE', 'Laptop Adapter Lap care', 1, 0),
(224, 102, 255, 'MOUSE-USB-M90', 'Logitech Usb Mouse (M90)', 5, 0),
(225, 103, 256, 'CAB-FINGERS', 'Fingers cabinet ', 2, 0),
(226, 103, 257, 'CPU-I5-10400', 'CPU i5 2.9 Ghz ( 10400)', 3, 0),
(227, 103, 258, 'MTB-B460M-DS3H-V2', 'Gigabyte B460M DS3H V2', 3, 0),
(228, 103, 259, 'RAM-DDR4-16GB', '16 GB 3000 Mhz DDR4 CORSIAR VEN RAM', 3, 0),
(229, 103, 260, 'HDD-SSD-500GB', 'SSD  SAMSUNG 98O EVO NVME 5OOGB ( MZ-V8V500BW )', 2, 0),
(230, 103, 261, 'HDD-HDD-1TB', 'HDD Segate 1 TB Barracudda ', 2, 0),
(231, 103, 262, 'MON-GW2480-B-24', 'Benq Monitor 24&quot; (GW2480-B)', 1, 0),
(232, 104, 263, 'RAM-DDR4-16GB', '16 GB 3000 Mhz DDR4 CORSIAR VEN RAM', 1, 0),
(233, 104, 264, 'HDD-SSD-500GB', 'SSD  SAMSUNG 98O EVO NVME 5OOGB ( MZ-V8V500BW )', 1, 0),
(234, 104, 265, 'HDD-HDD-1TB', 'HDD Segate 1 TB Barracudda ', 2, 0),
(235, 104, 266, 'SMPS-I-ZPS-281', 'SMPS  I Ball :- ZPS-281 ', 2, 0),
(236, 105, 267, 'CAB-CORSIAR', 'Corsiar Cabinet', 1, 0),
(237, 105, 268, 'SMPS-ANTEC-VP-450', 'ANTEC VP 450 SMPS (VP450P PLUS IN V3000A200H-18) 450 Watt ', 1, 0),
(238, 105, 269, 'CPU-I5-10400', 'CPU i5 2.9 Ghz ( 10400)', 1, 0),
(239, 105, 270, 'MTB-B460M-DS3H-AC', 'Gigabyte MBD ( B460M DS3H AC )', 1, 0),
(240, 105, 271, 'GR-CARD-Z-GTX-1050', 'Graphics Card 4 GB ,128 BIT ,GDDR5  Zotac Modal No :- (Zotac Geforce GTX 1050 Ti oc)', 1, 0),
(241, 105, 272, 'RAM-DDR4-16GB', '16 GB 3000 Mhz DDR4 CORSIAR VEN RAM', 1, 0),
(242, 105, 273, 'HDD-500GB', 'NVME Kingston 500 GB ', 1, 0),
(243, 105, 274, 'HDD-HDD-1TB', 'HDD Segate 1 TB Barracudda ', 1, 0),
(244, 105, 275, 'MOUSE-USB', 'Logitech Combo Mk-120 Keyboard &amp; Mouse ', 1, 0),
(245, 105, 276, 'MON-GW2480-B-24', 'Benq Monitor 24&quot; (GW2480-B)', 1, 0),
(246, 106, 277, 'HDD-SATA-8TB', 'HDD 8TB SATA SEGATE SURVILLANCE', 1, 0),
(247, 107, 278, 'CPU-I5-10400', 'CPU i5 2.9 Ghz ( 10400)', 1, 0),
(248, 107, 279, 'CAB-FING-SMPS', 'Fingures Cabinet with SMPS ', 1, 0),
(249, 107, 280, 'MTB-B460M-DS3H-AC', 'Gigabyte MBD ( B460M DS3H AC )', 1, 0),
(250, 107, 281, 'HDD-500GB', 'NVME Kingston 500 GB ', 1, 0),
(251, 107, 282, 'HDD-HDD-1TB', 'HDD Segate 1 TB Barracudda ', 1, 0),
(252, 107, 283, 'MOUSE-USB', 'Logitech Combo Mk-120 Keyboard &amp; Mouse ', 1, 0),
(253, 107, 284, 'MON-GW2480-B-24', 'Benq Monitor 24&quot; (GW2480-B)', 1, 0),
(254, 107, 285, 'RAM-DDR4-16GB', '16 GB 3000 Mhz DDR4 CORSIAR VEN RAM', 1, 0),
(255, 108, 286, 'MON-GW2480-T-24', 'BenQ GW2480 24-inch', 1, 0),
(256, 108, 287, 'CPU-I5-9400', 'Core I5 9400F 2.9 Ghz', 2, 0),
(257, 108, 288, 'RAM-DDR4-16GB', '16 GB 3000 Mhz DDR4 CORSIAR VEN RAM', 2, 0),
(258, 108, 289, 'MTB-B360M-D3H', 'Gigabyte B360M-D3H Motherboard', 2, 0),
(259, 108, 290, 'CAB-IBALL', 'I ball cabinet', 2, 0),
(260, 108, 291, 'GR-CARD-N-GT-70', 'Nvidia Geforce GT 70 Graphics card ', 2, 0),
(261, 109, 292, 'HDD-1TB', 'Segate 1 TB Barracaudda Hdd', 1, 0),
(262, 110, 293, 'HDD-HDD-1TB', 'HDD Segate 1 TB Barracudda ', 5, 0),
(263, 111, 294, 'HDD-SSD-500GB', 'SSD  SAMSUNG 98O EVO NVME 5OOGB ( MZ-V8V500BW )', 3, 0),
(264, 112, 295, 'MTB-B360M-D3H', 'Gigabyte B360M-D3H Motherboard', 2, 0),
(265, 112, 296, 'RAM-DDR4-16GB', '16 GB 3000 Mhz DDR4 CORSIAR VEN RAM', 1, 0),
(266, 112, 297, 'HDD-SSD-240GB', 'Wd green M2 ssd 240 GB ( M.2 2280  WDC WDS240G2GOB )', 2, 0),
(267, 112, 298, 'CAB-IBALL', 'I ball cabinet', 2, 0),
(268, 112, 299, 'MON-GW2480-T-24', 'BenQ GW2480 24-inch', 2, 0),
(269, 112, 300, 'RAM-DDR4-8GB', 'Corsiar DDR 4 RAM 8 GB 3000 Mhz', 1, 0),
(270, 113, 301, 'HDD-1TB', 'HDD Segate 1 TB Barracudda ', 2, 0),
(271, 113, 302, 'RAM-DDR4-8GB', 'Corsiar DDR 4 RAM 8 GB 3000 Mhz', 1, 0),
(272, 113, 303, 'RAM-DDR4-16GB', '16 GB 3000 Mhz DDR4 CORSIAR VEN RAM', 1, 0),
(273, 114, 304, 'MTB-B360M-D3H', 'MBD :- Gigabyte ( B365M D3H )', 2, 0),
(274, 114, 305, 'CPU-I5-8400', 'I5-8400 Cpu', 1, 0),
(275, 114, 306, 'RAM-DDR4-16GB', '16 GB 3000 Mhz DDR4 CORSIAR VEN RAM', 2, 0),
(276, 114, 307, 'CAB-IBALL', 'I ball cabinet', 2, 0),
(277, 114, 308, 'MON-GW2480-T-24', 'BenQ GW2480 24-inch', 3, 0),
(278, 114, 309, 'CPU-I3-8100', 'CPUi3-8100   8th Gen  ', 1, 0),
(279, 114, 310, 'HDD-SSD-500GB', 'SSD  SAMSUNG 98O EVO NVME 5OOGB ( MZ-V8V500BW )', 1, 0),
(280, 115, 311, 'RAM-DDR4-16GB', '16 GB 3000 Mhz DDR4 CORSIAR VEN RAM', 1, 0),
(281, 115, 312, 'MOUSE-USB', 'Logitech Combo Mk-120 Keyboard &amp; Mouse ', 5, 0),
(282, 116, 313, 'MTB-B460M-DS3H-V2', 'Gigabyte B460M DS3H V2', 2, 0),
(283, 116, 314, 'CPU-I5-10400', 'CPU i5 2.9 Ghz ( 10400)', 2, 0),
(284, 116, 315, 'RAM-DDR4-16GB', '16 GB 3000 Mhz DDR4 CORSIAR VEN RAM', 2, 0),
(285, 116, 316, 'CAB-FING-SMPS', 'Fingures Cabinet with SMPS ', 2, 0),
(286, 116, 317, 'HDD-SSD-500GB', 'SSD  SAMSUNG 98O EVO NVME 5OOGB ( MZ-V8V500BW )', 2, 0),
(287, 116, 318, 'HDD-HDD-1TB', 'HDD Segate 1 TB Barracudda ', 2, 0),
(288, 116, 319, 'MON-LED-LF24T352FHWXXL-24', 'SAMSUNG 24&quot; LED MONITOR (Modal No :- LF24T352FHWXXL)', 2, 0),
(289, 117, 320, 'HDD-HDD-1TB', 'HDD Segate 1 TB Barracudda ', 5, 0),
(290, 118, 321, 'UPS-600-VA', 'UPS LUMINIOUS 600VA', 1, 0),
(291, 119, 322, 'HDD-HDD-1TB', 'HDD Segate 1 TB Barracudda ', 2, 0),
(292, 119, 323, 'SMPS-I-ZPS-281', 'SMPS  I Ball :- ZPS-281 ', 2, 0),
(293, 119, 324, 'MON-GW2480-T-24', 'BenQ GW2480 24-inch', 1, 0),
(294, 119, 325, 'HDD-SSD-500GB', 'SSD  SAMSUNG 98O EVO NVME 5OOGB ( MZ-V8V500BW )', 1, 0),
(295, 120, 326, 'RAM-DDR3-8GB', 'RAM DDR-3    8 GB Kingston 1333 Mhz', 1, 0),
(296, 121, 327, 'MON-GW2280-B-22', 'Benq GW2280-B 22&quot; ', 1, 0),
(297, 122, 328, 'MON-GW2480-T-24', 'BenQ GW2480 24-inch', 1, 0),
(298, 123, 329, 'HDD-SSD-500GB', 'SSD  SAMSUNG 98O EVO NVME 5OOGB ( MZ-V8V500BW )', 2, 0),
(299, 124, 330, 'USB-LINK-HUB', 'Usb ( 1 Gbps Lan + 3.1 Usb ) Tp link Hub', 1, 0),
(300, 125, 331, 'MON-GW2480-T-24', 'BenQ GW2480 24-inch', 1, 0),
(301, 126, 332, 'HDD-SSD-1TB', 'USB SSD :- 1 TB Samsung Protable SSD T5 ( Modal No :- MU-PA1T0B )', 1, 0),
(302, 127, 333, 'MON-GW2480-T-24', 'BenQ GW2480 24-inch', 1, 0),
(303, 128, 334, 'MON-22MP68VQ-22', 'Lg 22&quot; ips monitor modal no :- 22MP68VQ', 1, 0),
(304, 129, 335, 'HDD-SSD-500GB', 'SSD  SAMSUNG 98O EVO NVME 5OOGB ( MZ-V8V500BW )', 1, 0),
(305, 130, 336, 'HDD-SSD-500GB', 'SSD  SAMSUNG 98O EVO NVME 5OOGB ( MZ-V8V500BW )', 1, 0),
(306, 131, 337, 'MON-GW2480-T-24', 'BenQ GW2480 24-inch', 1, 0),
(307, 132, 338, 'HDD-HDD-1TB', 'HDD Segate 1 TB Barracudda ', 4, 0),
(308, 133, 339, 'MUSIC-WOOFER', 'Zook Woofer + Wireless Mic (ZB-Rocker Thunder XL)', 1, 0),
(309, 134, 340, 'FIREWALL-FGT-80F', 'Fortinet 80F Firewall with 3 Years fotigaurd suscribition  ', 1, 0),
(310, 135, 341, 'PRO-I5-11GEN', 'Processor i5 11th gen 2.6 GHZ LGA 1200 ( i5-11400 BX8070811400) ', 2, 0),
(311, 136, 342, 'PRO-I5-11GEN', 'Processor i5 11th gen 2.6 GHZ LGA 1200 ( i5-11400 BX8070811400) ', 1, 0),
(312, 137, 343, 'PRO-I5-11GEN', 'Processor i5 11th gen 2.6 GHZ LGA 1200 ( i5-11400 BX8070811400) ', 1, 0),
(313, 138, 344, 'PRO-I5-11GEN', 'Processor i5 11th gen 2.6 GHZ LGA 1200 ( i5-11400 BX8070811400) ', 2, 0),
(314, 139, 345, 'PRO-I5-11GEN', 'Processor i5 11th gen 2.6 GHZ LGA 1200 ( i5-11400 BX8070811400) ', 1, 0),
(315, 140, 346, 'PRO-I3-8GEN', 'I3 8th gen processor', 2, 0),
(316, 141, 347, 'FIREWALL-FGT-60F', 'Fortigate 60 F Model :- ( FG-60F)', 1, 0),
(317, 142, 348, 'GEN-JSPF-35X-3PH', '35 KVA Jakson Cummions Gen-set  3 Phase ( JSPF-35X (3PH)', 1, 0),
(318, 143, 349, 'GEN-SNMP-MCY-EN', 'SNMP CARD ( SNMP web pro   Modal no :- SNMP-MCY-EN )', 1, 0),
(319, 144, 350, 'LAP-IPAD-A1893', 'Apple i pad  (Modal no :-A1893)', 1, 0),
(320, 145, 351, 'LAP-HP-15Q', 'Laptop HP 15Q core i5 8th gen 8 GB ', 1, 0),
(321, 146, 352, 'LAP-ASUS-X509J', 'Asus Laptop vivo book ( X509J )', 1, 0),
(322, 147, 353, 'LAP-DELL-14', 'Dell inspiron laptop ( 14&quot; paper 40 pin )', 1, 0),
(323, 148, 354, 'LAP-DELL-IP-3511', 'Dell New 2022 Inspiron 3511 (Modal No:- Inspiron 3511, i3 11th gen, 8GB DDR4,256 GB Nvme,1TB HDD)', 1, 0),
(324, 149, 355, 'LAP-IPAD-L14ITL6 ', 'Lenovo IdeaPad 5 Pro 14ITL6 ( i7-1165G7 2.80Ghz , 16 GB RAM ,500GB NVME)', 1, 0),
(325, 150, 356, 'LAP-HP-15-EG2039TU', 'Hp Pavillion Laptop :- 15-EG2039TU ( i7-1260P . 16 GB RAM , 1 TB NVME 15.6&quot; Display )', 1, 0),
(326, 151, 357, 'LAP-HP-EG2039TU', 'Hp Pavillion Laptop :- 15-EG2039TU ( i7-1260P . 16 GB RAM , 1 TB NVME 15.6&quot; Display )', 2, 0),
(327, 152, 358, 'LAP-HP-EG2039TU', 'Hp Pavillion Laptop :- 15-EG2039TU ( i7-1260P . 16 GB RAM , 1 TB NVME 15.6&quot; Display )', 1, 0),
(328, 153, 359, 'LAPCARE-LCP-111', 'Laptop Cooling Pad (Lapcare :- LCP-111)', 1, 0),
(329, 154, 360, 'LAPCARE-LCP-111', 'Laptop Cooling Pad (Lapcare :- LCP-111)', 3, 0),
(330, 155, 361, 'LAPCARE-LCP-111', 'Laptop Cooling Pad (Lapcare :- LCP-111)', 2, 0),
(331, 156, 362, 'DL-ESSL-EML600-2', 'Door Lock Essl Em ( Modal No :- EML600-2 )', 2, 0),
(332, 157, 363, 'M-CHARGE-MI', 'Mi Sonic Charger 2.0 Modal No :- MDY-11-EL ', 1, 0),
(333, 158, 364, 'M-REDMI-9', 'Redmi 9 Power Modal No :- M2010J19SI (Electric Green, 4GB RAM, 64GB Storage) - 6000mAh Battery B089MS8HPF                         ( REDMI9PWGREEN-4+64GB )', 1, 0),
(334, 159, 365, 'M-MICROMAX-412', 'Micromax x412 Mobile Phone with Adaptor ( ACC05C14)', 1, 0),
(335, 160, 366, 'ROUT-WIFI-A-RT-AX55', 'Wi-Fi Router With Mac binding feature Asus Modal No :- ( RT-AX55)', 1, 0),
(336, 161, 367, 'ROUT-D--DGS-1210-28', 'D-Link Systems 28-Port Gigabit Web Smart (DGS-1210-28)', 1, 0),
(337, 162, 368, 'ROUT-D-DGS-1210-52', 'D LINK 48PORT SWITCH (DGS-1210-52)', 1, 0),
(338, 162, 369, 'RACK-2U', 'D.LINK 2U RACK', 1, 0),
(339, 163, 370, 'ROUT-D-WIFI-001-DIR-', 'D-Link DIR-825 AC 1200 Wi-Fi Dual-Band Gigabit (LAN/WAN) Router | B098DTPWSM ( IT-ROUTER-001-DIR-825 )', 1, 0),
(340, 164, 371, 'ROUT-TP-UE300', 'TP-Link UE300 USB 3.0 to RJ45 Gigabit Ethernet (UE300)', 2, 0),
(341, 165, 372, 'ROUT-TP-UE300', 'TP-Link UE300 USB 3.0 to RJ45 Gigabit Ethernet (UE300)', 1, 0),
(342, 166, 373, 'ROUT-TP-AC600', 'TP-Link AC600 (Modal No :- Archer T2U Plus ver 1.0)', 1, 0),
(343, 167, 374, 'ROUT-WIFI-A-RT-AX55', 'Wi-Fi Router With Mac binding feature Asus Modal No :- ( RT-AX55)', 2, 0),
(344, 168, 375, 'RACK-D-2U', 'D-Link 2U Rack ', 1, 0),
(345, 169, 376, 'ROUT-D-DGS-1210-52', 'D LINK 48PORT SWITCH (DGS-1210-52)', 1, 0),
(346, 170, 377, 'ROUT-H-DS-7632NI-K2', 'Hikvision Embeded NVR Modal No :- ( DS-7632NI-K2)', 1, 0),
(347, 170, 378, 'ROUT-H-DS-3E0510P-E/', 'Hikvision 8 Port Gigabit Poe Unmangged switch :-Modal No :- DS-3E0510P-E/M ', 6, 0),
(348, 170, 379, 'RACK-2U', 'D.LINK 2U RACK', 1, 0),
(349, 171, 380, 'ROUT-D-DGS-1210-5', 'Dlink 52 Port switch( 52-Port Gigabit Smart Managed Switch DGS-1210-5)', 1, 0),
(350, 172, 381, 'ROUT-D-DGS-1210-52', 'D LINK 48PORT SWITCH (DGS-1210-52)', 1, 0),
(351, 173, 382, 'ROUT-TP-WN823N', 'Tp-Link 300 Mbps (TP-WN823N)', 1, 0),
(352, 174, 383, 'REALME-TV-32', 'REALME 32&quot; INCH ANDROID TV', 1, 0),
(353, 175, 384, 'LOGITECH-KEYB', 'logitech keyboard', 100, 0),
(354, 175, 385, 'LOGITECH-MOUSE', 'logitech mouse', 100, 0),
(355, 176, 386, 'CPUMI3', 'i3 cpu manufacture ', 4, 0),
(356, 177, 387, 'CPUI3-3210', 'CPU- i3-3210-3.20GHz', 4, 0),
(357, 178, 388, 'RAM-DDR4-12GB', 'Ram 12 gb', 10, 0),
(358, 179, 390, 'CPUI3-3210-16GB', 'cpu i3 3210 16 gb', 2, 0),
(359, 180, 391, 'CPUI3-3210-8GB', 'cpu i3 3210 8gb', 12, 0),
(360, 181, 392, 'RAM-DDR4-8GB', 'Corsiar DDR 4 RAM 8 GB 3000 Mhz', 20, 0),
(361, 182, 394, 'CPUi3-6098P-3.60GH', 'CPUi3-6098P-3.60GHz', 12, 0),
(362, 183, 395, 'CPU-I3-6098P-8GB', 'CPU- i3-6098P-3.60GHz, RAM-8GB', 11, 0),
(363, 184, 396, 'CPUI36098P', 'CPUI3-240GB', 1, 0),
(364, 185, 397, 'HDD-SSD-240GBM', 'HDD-SSD-240GBM', 1, 0),
(365, 186, 398, 'RAM-DDR4-8GB', 'Corsiar DDR 4 RAM 8 GB 3000 Mhz', 20, 0),
(366, 187, 399, 'HDD-SSD-500GB', 'SSD  SAMSUNG 98O EVO NVME 5OOGB ( MZ-V8V500BW )', 50, 0),
(367, 188, 400, 'RAM-DDR4-8GB', 'Corsiar DDR 4 RAM 8 GB 3000 Mhz', 10, 0),
(368, 189, 401, 'CPU-i5-10400-2.90GH', 'CPU-i5-10400-2.90GHz', 10, 0),
(369, 190, 402, 'CPUI52310-2.90', 'CPUI5-2310-2.90 8GB', 1, 0),
(370, 191, 403, 'CPUI5-11400-2.60GH', 'CPU-i5-11400-2.60GHz, RAM-16GB', 1, 0),
(371, 192, 404, 'CPUI5-9400F-2.90GH', 'CPU-I5-9400F-2.90GHz 16GB Ram', 1, 0),
(372, 193, 405, 'CPUI3-3210-3.20GH-12', 'CPU-i3-3210-3.20GHz, RAM-12GB,', 1, 0),
(373, 193, 406, 'LAP-HP-I5', 'LAP-HP-I5-8GB', 1, 0),
(374, 194, 407, 'CPUI5-3210-2.20GHz', 'CPU- i5-3210-2.20GHz, RAM-8GB', 1, 0),
(375, 195, 408, 'CPUI5-8400-2.80-16GB', 'CPU- i5-8400-2.80GHz, RAM-16GB,', 1, 0),
(376, 196, 409, 'CPUI5-10400-2.90-16G', 'CPU- i5-10400-2.90GHz, RAM-16GB,', 2, 0),
(377, 197, 410, 'CPUI3-10400-3.20-16G', 'CPUI3-10400-3.20GHz,RAM-16GB', 1, 0),
(378, 198, 411, 'CPUI3-6098P-3.60-16G', 'CPU- i3-6098P-3.60GHz, RAM-16GB, SSD-250 GB,HDD-1TB', 1, 0),
(379, 199, 412, 'HDD-SSD-250GB', 'SSD Segate Barracuda 250 GB ', 10, 0),
(380, 200, 413, 'CPUI5-10400-2.9-16GB', 'CPUI5-10400-2.90-16GB-500GB-1TB', 2, 0),
(381, 201, 414, 'CPU-I7-7700k-4.20GH', 'CPU-I7-7700K-4.20GHz, RAM-32GB,', 1, 0),
(382, 202, 415, 'RAM-32GB', 'RAM-32GB', 5, 0),
(383, 203, 416, 'RAM-32GB', 'RAM-32GB', 2, 0),
(384, 204, 417, 'CPU-I5-10400-2.9G16G', 'CPU- i5-10400-2.90GHz, RAM-16GB', 6, 0),
(385, 205, 418, 'CPU-I7-8700K-3.70GH', 'CPU-I7-8700K-3.70GHz', 1, 0),
(386, 206, 419, 'CPU-I5-8400-2.80GHz', 'CPU- i5-8400-2.80GHz,RAM-16GB,SSD250', 1, 0),
(387, 207, 420, 'CPUI5-11400-2.6GH16G', 'CPU- i5-11400-2.60GHz, RAM-16GB, SSD-500 GB', 2, 0),
(388, 208, 421, 'CPU-I3-3210-3.2GH16', 'CPU- i3-3210-3.20GHz, Ram 16GB', 1, 0),
(389, 209, 422, 'HDD-4TB', 'HDD-4TB', 5, 0),
(390, 210, 423, 'RAM-DDR4-16GB', '16 GB 3000 Mhz DDR4 CORSIAR VEN RAM', 10, 0),
(391, 211, 424, 'CPU-I3-8100-3.6GH-16', 'CPU- i3-8100-3.60GHz, RAM-16GB', 1, 0),
(392, 212, 425, 'CPUI3-2120-3.2G-12GB', 'CPU- i3-2120-3.20GHz, RAM-12GB,', 1, 0),
(393, 213, 426, 'CPU-I3-3210-3.2-1TB', 'CPU- i3-3210-3.20GHz 1TB', 1, 0),
(394, 214, 427, 'CPU-I5-8400-2.8G32GB', 'CPU- i5-8400-2.80GHz,RAM-32GB 2TB', 1, 0),
(395, 215, 428, 'RAM-32GB', 'RAM-32GB', 5, 0),
(396, 216, 429, 'CPU-I3-2120-3.3G-16G', 'CPU- i3-2120-3.30GHz,RAM-16GB SSD-500GB', 1, 0),
(397, 217, 430, 'CPUI7-1260P-RAM-16G', 'CPU- i7-1260P, RAM-16GB, SSD- 1TB', 4, 0),
(398, 218, 431, 'HDD-SSD-1TB', 'USB SSD :- 1 TB Samsung Protable SSD T5 ( Modal No :- MU-PA1T0B )', 5, 0),
(399, 219, 432, 'CPUI7-1165G7-RAM-16G', 'CPU- i7-1165G7,RAM-16GB, SSD-500GB', 1, 0),
(400, 220, 433, 'CPUI5-9400F-2.9G-16G', 'CPU- i5-9400F-2.90GHz, RAM-16GB, SSD-500 GB,HDD-1TB', 1, 0),
(401, 221, 434, 'CPUI3-8100-3.6G-16GB', 'CPU- i3-8100-3.60GHz, RAM-16GB, SSD-250 GB,HDD- 1TB', 1, 0),
(402, 222, 435, 'CPUI3-3210-3.2G-16GB', 'CPU- i3-3210-3.20GHz, RAM-16GB, SSD-500 GB', 1, 0),
(403, 223, 436, 'CPUI5-10400-2.9G-16G', 'CPU- i5-10400-2.90GHz, RAM-16GB, SSD-500 GB,HDD- 1TB', 1, 0),
(404, 224, 437, 'CPUI3-6098P-3.60-16G', 'CPU- i3-6098P-3.60GHz, RAM-16GB, SSD-250 GB,HDD-1TB', 1, 0),
(405, 225, 438, 'RAM-DDR4-16GB', '16 GB 3000 Mhz DDR4 CORSIAR VEN RAM', 1, 0),
(406, 226, 439, 'CPUI5-8400-2.80GHz', 'CPU- i5-8400-2.80GHz, RAM-16GB, SSD-500 GB,HDD- 1TB', 1, 0),
(407, 227, 440, 'CPU-I5-11400-2.6-16G', 'CPU- i5-11400-2.60GHz, RAM-16GB, SSD-250 GB, ', 1, 0),
(408, 228, 441, 'CPU-I5-2400-3.1G-16G', 'CPU- i5-2400-3.10GHz, RAM-16GB, SSD-500 GB,HDD- 1TB, ', 1, 0),
(409, 229, 442, 'CPU-I5-10400-2.90-16', 'CPU- i5-10400-2.90GHz, RAM-16GB, SSD-500 GB', 2, 0),
(410, 230, 443, 'CPU-I3-8100-3.6-16Gb', 'CPU- i3-8100-3.60GHz, RAM-16GB, SSD-500GB,HDD-1TB,', 1, 0),
(411, 231, 444, 'CPU-I5-11400-2.6-16', 'CPU- i5-11400-2.60GHz, RAM-16GB, SSD-500 GB', 1, 0),
(412, 232, 445, 'CPU-I5-10400-2.90-16', 'CPU- i5-10400-2.90GHz, RAM-16GB, SSD-500 GB', 1, 0),
(413, 233, 446, 'CPU-I5-10400-2.9-16', 'CPU- i5-10400-2.90GHz, RAM-16GB, SSD-500 GB,HDD-1TB,', 1, 0),
(414, 234, 447, 'CPUI5-11400-2.6-16G', 'CPU- i5-11400-2.60GHz, RAM-16GB, SSD-250 GB, HDD-1TB,', 2, 0),
(415, 235, 448, 'CPUI3-6098P-3.6-16', 'CPU- i3-6098P-3.60GHz, RAM-16GB, SSD-500GB,HDD-1TB', 1, 0),
(416, 236, 449, 'CPU-I3-4005U-1.70GH', 'CPU- i3-4005U-1.70GHz, RAM-12GB, SSD-500 GB (HP 15 Notebook Laptop),', 1, 0),
(417, 237, 450, 'CPU-I3-10100-3.6-8GB', 'CPU- i3-10100-3.60GHz, RAM-8GB, SSD-240 GB, HDD-1TB, ', 1, 0),
(418, 238, 451, 'CPU-I3-2330M-2.20-L', 'CPU- i3-2330M-2.20GHz, RAM-8GB, SSD-500 GB (Acer Laptop)', 1, 0),
(419, 239, 452, 'CPU-I3-6100U-2.30-L', 'CPU- i3-6100U-2.30GHz, RAM-8GB, SSD-500 GB (Lenevo Laptop)', 1, 0),
(420, 240, 453, 'CPU-I5-1035G1-1.0-L', 'CPU- i5-1035G1-1.00GHz, RAM-8GB, SSD-500 GB ', 1, 0),
(421, 241, 454, 'Cpu-i3-2.4G-4gb-LAP', 'Cpu-i3 2.4 Ghz, RAM-4GB,SSD-240 GB ( Stand by Laptop )', 1, 0),
(422, 242, 455, 'CPU-I3-3210-3.20G-16', 'CPU- i3-3210-3.20GHz, RAM-16GB, SSD-250 GB,MBD-Gigabyte.', 1, 0),
(423, 243, 456, 'CPU-I5-10400-2.9-16G', 'CPU- i5-10400-2.90GHz, RAM-16GB, SSD-500 GB', 1, 0),
(424, 244, 506, 'LAP-HP-I5-2.2-8GB', 'CPU- i5-5200U-2.20GHz, RAM-8GB, SSD-500 GB', 1, 0),
(425, 245, 507, 'LAP-DELL-I3-8GB-1TB', 'CPU- i3-1115G4-3.00GHz, RAM-8GB, SSD-1TB,', 1, 0),
(426, 246, 508, 'LAP-I7-16GB-500GB', 'CPU-I7-1165G7,RAM-16GB, SSD-500GB ', 1, 0),
(427, 247, 509, 'LAP-I5-16GB-SSD-500G', 'CPU- i5-10400-2.90GHz, RAM-16GB, ', 1, 0),
(428, 248, 510, 'delll-lap', 'dell inspiration', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `fa_grn_serial_no`
--

CREATE TABLE `fa_grn_serial_no` (
  `id` int(11) NOT NULL,
  `grn_batch_id` int(11) NOT NULL,
  `sl_no` varchar(50) DEFAULT NULL,
  `osl_no` varchar(100) NOT NULL,
  `warranty` int(11) DEFAULT NULL,
  `from_date` date DEFAULT NULL,
  `to_date` date DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `stock_id` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fa_grn_serial_no`
--

INSERT INTO `fa_grn_serial_no` (`id`, `grn_batch_id`, `sl_no`, `osl_no`, `warranty`, `from_date`, `to_date`, `status`, `stock_id`) VALUES
(3, 11, '', 'FB-LAP-BAG-002', 1, '2022-12-16', '2023-12-16', 0, 'L-BAG-LP-GRAY'),
(4, 12, '', 'FB-LAP-BAG-003', 1, '2022-12-16', '2023-12-16', 0, 'L-BAG-HP'),
(5, 12, '', 'FB-LAP-BAG-004', 1, '2022-12-16', '2023-12-16', 0, 'L-BAG-HP'),
(6, 13, '', 'FB-BAT42AH-001', 1, '2022-12-16', '2023-12-16', 0, 'BAT-42AH-E'),
(7, 13, '', 'FB-BAT42AH-002', 1, '2022-12-16', '2023-12-16', 0, 'BAT-42AH-E'),
(8, 13, '', 'FB-BAT42AH-003', 1, '2022-12-16', '2023-12-16', 0, 'BAT-42AH-E'),
(9, 13, '', 'FB-BAT42AH-004', 1, '2022-12-16', '2023-12-16', 0, 'BAT-42AH-E'),
(10, 13, '', 'FB-BAT42AH-005', 1, '2022-12-16', '2023-12-16', 0, 'BAT-42AH-E'),
(11, 13, '', 'FB-BAT42AH-006', 1, '2022-12-16', '2023-12-16', 0, 'BAT-42AH-E'),
(12, 13, '', 'FB-BAT42AH-007', 1, '2022-12-16', '2023-12-16', 0, 'BAT-42AH-E'),
(13, 13, '', 'FB-BAT42AH-008', 1, '2022-12-16', '2023-12-16', 0, 'BAT-42AH-E'),
(14, 13, '', 'FB-BAT42AH-009', 1, '2022-12-16', '2023-12-16', 0, 'BAT-42AH-E'),
(15, 13, '', 'FB-BAT42AH-010', 1, '2022-12-16', '2023-12-16', 0, 'BAT-42AH-E'),
(16, 13, '', 'FB-BAT42AH-011', 1, '2022-12-16', '2023-12-16', 0, 'BAT-42AH-E'),
(17, 13, '', 'FB-BAT42AH-012', 1, '2022-12-16', '2023-12-16', 0, 'BAT-42AH-E'),
(18, 13, '', 'FB-BAT42AH-013', 1, '2022-12-16', '2023-12-16', 0, 'BAT-42AH-E'),
(19, 13, '', 'FB-BAT42AH-014', 1, '2022-12-16', '2023-12-16', 0, 'BAT-42AH-E'),
(20, 13, '', 'FB-BAT42AH-015', 1, '2022-12-16', '2023-12-16', 0, 'BAT-42AH-E'),
(21, 13, '', 'FB-BAT42AH-016', 1, '2022-12-16', '2023-12-16', 0, 'BAT-42AH-E'),
(22, 13, '', 'FB-BAT42AH-017', 1, '2022-12-16', '2023-12-16', 0, 'BAT-42AH-E'),
(23, 13, '', 'FB-BAT42AH-018', 1, '2022-12-16', '2023-12-16', 0, 'BAT-42AH-E'),
(24, 13, '', 'FB-BAT42AH-019', 1, '2022-12-16', '2023-12-16', 0, 'BAT-42AH-E'),
(25, 13, '', 'FB-BAT42AH-020', 1, '2022-12-16', '2023-12-16', 0, 'BAT-42AH-E'),
(26, 13, '', 'FB-BAT42AH-021', 1, '2022-12-16', '2023-12-16', 0, 'BAT-42AH-E'),
(27, 13, '', 'FB-BAT42AH-022', 1, '2022-12-16', '2023-12-16', 0, 'BAT-42AH-E'),
(28, 13, '', 'FB-BAT42AH-023', 1, '2022-12-16', '2023-12-16', 0, 'BAT-42AH-E'),
(29, 13, '', 'FB-BAT42AH-024', 1, '2022-12-16', '2023-12-16', 0, 'BAT-42AH-E'),
(30, 13, '', 'FB-BAT42AH-025', 1, '2022-12-16', '2023-12-16', 0, 'BAT-42AH-E'),
(31, 13, '', 'FB-BAT42AH-026', 1, '2022-12-16', '2023-12-16', 0, 'BAT-42AH-E'),
(32, 14, '', 'FB-BATEP65-001', 1, '2022-12-16', '2023-12-16', 0, 'BAT-EP65-12-E'),
(33, 14, '', 'FB-BATEP65-002', 1, '2022-12-16', '2023-12-16', 0, 'BAT-EP65-12-E'),
(34, 14, '', 'FB-BATEP65-003', 1, '2022-12-16', '2023-12-16', 0, 'BAT-EP65-12-E'),
(35, 14, '', 'FB-BATEP65-004', 1, '2022-12-16', '2023-12-16', 0, 'BAT-EP65-12-E'),
(36, 14, '', 'FB-BATEP65-005', 1, '2022-12-16', '2023-12-16', 0, 'BAT-EP65-12-E'),
(37, 14, '', 'FB-BATEP65-006', 1, '2022-12-16', '2023-12-16', 0, 'BAT-EP65-12-E'),
(38, 14, '', 'FB-BATEP65-007', 1, '2022-12-16', '2023-12-16', 0, 'BAT-EP65-12-E'),
(39, 14, '', 'FB-BATEP65-008', 1, '2022-12-16', '2023-12-16', 0, 'BAT-EP65-12-E'),
(40, 14, '', 'FB-BATEP65-009', 1, '2022-12-16', '2023-12-16', 0, 'BAT-EP65-12-E'),
(41, 14, '', 'FB-BATEP65-010', 1, '2022-12-16', '2023-12-16', 0, 'BAT-EP65-12-E'),
(42, 14, '', 'FB-BATEP65-011', 1, '2022-12-16', '2023-12-16', 0, 'BAT-EP65-12-E'),
(43, 14, '', 'FB-BATEP65-012', 1, '2022-12-16', '2023-12-16', 0, 'BAT-EP65-12-E'),
(44, 14, '', 'FB-BATEP65-013', 1, '2022-12-16', '2023-12-16', 0, 'BAT-EP65-12-E'),
(45, 14, '', 'FB-BATEP65-014', 1, '2022-12-16', '2023-12-16', 0, 'BAT-EP65-12-E'),
(46, 14, '', 'FB-BATEP65-015', 1, '2022-12-16', '2023-12-16', 0, 'BAT-EP65-12-E'),
(47, 14, '', 'FB-BATEP65-016', 1, '2022-12-16', '2023-12-16', 0, 'BAT-EP65-12-E'),
(48, 15, '', 'FB-BAT-LAP-001', 1, '2022-12-16', '2023-12-16', 0, 'BAT-LAP-HPOA04'),
(49, 16, '', 'FB-BAT-LAP-002', 1, '2022-12-16', '2023-12-16', 0, 'BAT-LAP-INEX'),
(50, 17, '', 'FB-BAT-INV-001', 1, '2022-12-16', '2023-12-16', 0, 'BAT-150AH-T-E'),
(51, 17, '', 'FB-BAT-INV-002', 1, '2022-12-16', '2023-12-16', 0, 'BAT-150AH-T-E'),
(52, 18, '', 'FB-BAT-INV-003', 1, '2022-12-16', '2023-12-16', 0, 'BAT-65AH-E'),
(53, 18, '', 'FB-BAT-INV-004', 1, '2022-12-16', '2023-12-16', 0, 'BAT-65AH-E'),
(54, 18, '', 'FB-BAT-INV-005', 1, '2022-12-16', '2023-12-16', 0, 'BAT-65AH-E'),
(55, 18, '', 'FB-BAT-INV-006', 1, '2022-12-16', '2023-12-16', 0, 'BAT-65AH-E'),
(56, 18, '', 'FB-BAT-INV-007', 1, '2022-12-16', '2023-12-16', 0, 'BAT-65AH-E'),
(57, 18, '', 'FB-BAT-INV-008', 1, '2022-12-16', '2023-12-16', 0, 'BAT-65AH-E'),
(58, 18, '', 'FB-BAT-INV-009', 1, '2022-12-16', '2023-12-16', 0, 'BAT-65AH-E'),
(59, 18, '', 'FB-BAT-INV-010', 1, '2022-12-16', '2023-12-16', 0, 'BAT-65AH-E'),
(60, 18, '', 'FB-BAT-INV-011', 1, '2022-12-16', '2023-12-16', 0, 'BAT-65AH-E'),
(61, 18, '', 'FB-BAT-INV-012', 1, '2022-12-16', '2023-12-16', 0, 'BAT-65AH-E'),
(62, 18, '', 'FB-BAT-INV-013', 1, '2022-12-16', '2023-12-16', 0, 'BAT-65AH-E'),
(63, 18, '', 'FB-BAT-INV-014', 1, '2022-12-16', '2023-12-16', 0, 'BAT-65AH-E'),
(64, 18, '', 'FB-BAT-INV-015', 1, '2022-12-16', '2023-12-16', 0, 'BAT-65AH-E'),
(65, 18, '', 'FB-BAT-INV-016', 1, '2022-12-16', '2023-12-16', 0, 'BAT-65AH-E'),
(66, 18, '', 'FB-BAT-INV-017', 1, '2022-12-16', '2023-12-16', 0, 'BAT-65AH-E'),
(67, 18, '', 'FB-BAT-INV-018', 1, '2022-12-16', '2023-12-16', 0, 'BAT-65AH-E'),
(68, 19, '', 'FB-BAT-LAP-003', 1, '2022-12-16', '2023-12-16', 0, 'BAT-LAP-OA04'),
(69, 20, '', 'FB-INV-UPS-001', 1, '2022-12-16', '2023-12-16', 0, 'BAT-UPS-HB1875'),
(70, 21, '', 'FB-BAT-INV-019', 1, '2022-12-16', '2023-12-16', 0, 'BAT-150AH-T-E'),
(71, 21, '', 'FB-BAT-INV-020', 1, '2022-12-16', '2023-12-16', 0, 'BAT-150AH-T-E'),
(72, 21, '', 'FB-BAT-INV-021', 1, '2022-12-16', '2023-12-16', 0, 'BAT-150AH-T-E'),
(73, 21, '', 'FB-BAT-INV-022', 1, '2022-12-16', '2023-12-16', 0, 'BAT-150AH-T-E'),
(74, 22, '', 'FB-BAT-LAP-004', 1, '2022-12-16', '2023-12-16', 0, 'BAT-LAP-LAOBT6C2196'),
(75, 23, '', 'FB-ESSL-PUNCH-001', 1, '2022-12-16', '2023-12-16', 0, 'ESSL-AM-X990'),
(76, 23, '', 'FB-ESSL-PUNCH-002', 1, '2022-12-16', '2023-12-16', 0, 'ESSL-AM-X990'),
(77, 24, '', 'FB-ESSL-FR-001', 1, '2022-12-16', '2023-12-16', 0, 'ESSL-FR1200 '),
(78, 24, '', 'FB-ESSL-FR-002', 1, '2022-12-16', '2023-12-16', 0, 'ESSL-FR1200 '),
(79, 25, '', 'FB-BIOCARD-006', 1, '2022-12-16', '2023-12-16', 0, 'BIOCARD'),
(80, 25, '', 'FB-BIOCARD-005', 1, '2022-12-16', '2023-12-16', 0, 'BIOCARD'),
(81, 25, '', 'FB-BIOCARD-004', 1, '2022-12-16', '2023-12-16', 0, 'BIOCARD'),
(82, 25, '', 'FB-BIOCARD-003', 1, '2022-12-16', '2023-12-16', 0, 'BIOCARD'),
(83, 25, '', 'FB-BIOCARD-002', 1, '2022-12-16', '2023-12-16', 0, 'BIOCARD'),
(84, 25, '', 'FB-BIOCARD-001', 1, '2022-12-16', '2023-12-16', 0, 'BIOCARD'),
(85, 26, '', 'FB-ESSL-PUNCH-003', 1, '2022-12-16', '2023-12-16', 0, 'ESSL-AM-X990'),
(86, 27, '', 'FB-ESSL-FR-003', 1, '2022-12-16', '2023-12-16', 0, 'ESSL-FR1200 '),
(87, 28, '', 'FB-CAB-POWER-001', 1, '2022-12-16', '2023-12-16', 0, 'CAB-POWER'),
(88, 28, '', 'FB-CAB-POWER-002', 1, '2022-12-16', '2023-12-16', 0, 'CAB-POWER'),
(89, 29, '', 'FB-HDMI-CAB-001', 1, '2022-12-16', '2023-12-16', 0, 'CAB-HDMI'),
(90, 30, '', 'FB-CAB-POWER-002', 1, '2022-12-16', '2023-12-16', 0, 'CAB-POWER'),
(91, 30, '', 'FB-CAB-POWER-003', 1, '2022-12-16', '2023-12-16', 0, 'CAB-POWER'),
(92, 30, '', 'FB-CAB-POWER-004', 1, '2022-12-16', '2023-12-16', 0, 'CAB-POWER'),
(93, 30, '', 'FB-CAB-POWER-005', 1, '2022-12-16', '2023-12-16', 0, 'CAB-POWER'),
(94, 30, '', 'FB-CAB-POWER-006', 1, '2022-12-16', '2023-12-16', 0, 'CAB-POWER'),
(95, 31, '', 'FB-LAP-BAG-005\r\n', 1, '2022-12-16', '2023-12-16', 0, 'L-BAG-LENOVO'),
(96, 32, '', 'FB-LAP-BAG-006\r\n', 1, '2022-12-16', '2023-12-16', 0, 'L-BAG-HP'),
(97, 32, '', 'FB-LAP-BAG-007', 1, '2022-12-16', '2023-12-16', 0, 'L-BAG-HP'),
(98, 33, '', 'FB-LAP-BAG-008', 1, '2022-12-16', '2023-12-16', 0, 'BAT-LAP-B'),
(99, 34, '', 'FB-BAT-LAP-005', 1, '2022-12-16', '2023-12-16', 0, 'BAT-LAP-N4010'),
(100, 35, '', 'FB-BAT-MICRO-001', 1, '2022-12-16', '2023-12-16', 0, 'BAT-MICRO-L'),
(101, 35, '', 'FB-BAT-MICRO-002', 1, '2022-12-16', '2023-12-16', 0, 'BAT-MICRO-L'),
(102, 35, '', 'FB-BAT-MICRO-003', 1, '2022-12-16', '2023-12-16', 0, 'BAT-MICRO-L'),
(103, 35, '', 'FB-BAT-MICRO-004', 1, '2022-12-16', '2023-12-16', 0, 'BAT-MICRO-L'),
(104, 35, '', 'FB-BAT-MICRO-005', 1, '2022-12-16', '2023-12-16', 0, 'BAT-MICRO-L'),
(105, 35, '', 'FB-BAT-MICRO-006', 1, '2022-12-16', '2023-12-16', 0, 'BAT-MICRO-L'),
(106, 35, '', 'FB-BAT-MICRO-007', 1, '2022-12-16', '2023-12-16', 0, 'BAT-MICRO-L'),
(107, 35, '', 'FB-BAT-MICRO-008', 1, '2022-12-16', '2023-12-16', 0, 'BAT-MICRO-L'),
(108, 35, '', 'FB-BAT-MICRO-009', 1, '2022-12-16', '2023-12-16', 0, 'BAT-MICRO-L'),
(109, 35, '', 'FB-BAT-MICRO-010', 1, '2022-12-16', '2023-12-16', 0, 'BAT-MICRO-L'),
(110, 36, '', 'FB-BAT-LAP-006', 1, '2022-12-16', '2023-12-16', 0, 'BAT-LAP-TC-3817U'),
(111, 37, '', 'FB-HDMI-CAB-002', 1, '2022-12-16', '2023-12-16', 0, 'CAB-HDMI'),
(112, 38, '', 'FB-CCTV-DS-001', 1, '2022-12-16', '2023-12-16', 0, 'DS-2CE1AC0T-IRPF'),
(113, 39, '', 'FB-CCTV-DS-002', 1, '2022-12-16', '2023-12-16', 0, 'DS-2CD1323G0E-I '),
(114, 39, '', 'FB-CCTV-DS-025', 1, '2022-12-16', '2023-12-16', 0, 'DS-2CD1323G0E-I '),
(115, 39, '', 'FB-CCTV-DS-024', 1, '2022-12-16', '2023-12-16', 0, 'DS-2CD1323G0E-I '),
(116, 39, '', 'FB-CCTV-DS-023', 1, '2022-12-16', '2023-12-16', 0, 'DS-2CD1323G0E-I '),
(117, 39, '', 'FB-CCTV-DS-022', 1, '2022-12-16', '2023-12-16', 0, 'DS-2CD1323G0E-I '),
(118, 39, '', 'FB-CCTV-DS-021', 1, '2022-12-16', '2023-12-16', 0, 'DS-2CD1323G0E-I '),
(119, 39, '', 'FB-CCTV-DS-020', 1, '2022-12-16', '2023-12-16', 0, 'DS-2CD1323G0E-I '),
(120, 39, '', 'FB-CCTV-DS-019', 1, '2022-12-16', '2023-12-16', 0, 'DS-2CD1323G0E-I '),
(121, 39, '', 'FB-CCTV-DS-018', 1, '2022-12-16', '2023-12-16', 0, 'DS-2CD1323G0E-I '),
(122, 39, '', 'FB-CCTV-DS-017', 1, '2022-12-16', '2023-12-16', 0, 'DS-2CD1323G0E-I '),
(123, 39, '', 'FB-CCTV-DS-016', 1, '2022-12-16', '2023-12-16', 0, 'DS-2CD1323G0E-I '),
(124, 39, '', 'FB-CCTV-DS-015', 1, '2022-12-16', '2023-12-16', 0, 'DS-2CD1323G0E-I '),
(125, 39, '', 'FB-CCTV-DS-014', 1, '2022-12-16', '2023-12-16', 0, 'DS-2CD1323G0E-I '),
(126, 39, '', 'FB-CCTV-DS-013', 1, '2022-12-16', '2023-12-16', 0, 'DS-2CD1323G0E-I '),
(127, 39, '', 'FB-CCTV-DS-012', 1, '2022-12-16', '2023-12-16', 0, 'DS-2CD1323G0E-I '),
(128, 39, '', 'FB-CCTV-DS-011', 1, '2022-12-16', '2023-12-16', 0, 'DS-2CD1323G0E-I '),
(129, 39, '', 'FB-CCTV-DS-010', 1, '2022-12-16', '2023-12-16', 0, 'DS-2CD1323G0E-I '),
(130, 39, '', 'FB-CCTV-DS-009', 1, '2022-12-16', '2023-12-16', 0, 'DS-2CD1323G0E-I '),
(131, 39, '', 'FB-CCTV-DS-008', 1, '2022-12-16', '2023-12-16', 0, 'DS-2CD1323G0E-I '),
(132, 39, '', 'FB-CCTV-DS-007', 1, '2022-12-16', '2023-12-16', 0, 'DS-2CD1323G0E-I '),
(133, 39, '', 'FB-CCTV-DS-006', 1, '2022-12-16', '2023-12-16', 0, 'DS-2CD1323G0E-I '),
(134, 39, '', 'FB-CCTV-DS-005', 1, '2022-12-16', '2023-12-16', 0, 'DS-2CD1323G0E-I '),
(135, 39, '', 'FB-CCTV-DS-004', 1, '2022-12-16', '2023-12-16', 0, 'DS-2CD1323G0E-I '),
(136, 39, '', 'FB-CCTV-DS-003', 1, '2022-12-16', '2023-12-16', 0, 'DS-2CD1323G0E-I '),
(137, 40, '', 'FB-CCTV-DS-026', 1, '2022-12-16', '2023-12-16', 0, 'DS-2CD2023G2-IU'),
(138, 40, '', 'FB-CCTV-DS-027', 1, '2022-12-16', '2023-12-16', 0, 'DS-2CD2023G2-IU'),
(139, 40, '', 'FB-CCTV-DS-028', 1, '2022-12-16', '2023-12-16', 0, 'DS-2CD2023G2-IU'),
(140, 41, '', 'FB-INV-UPS-002', 1, '2022-12-16', '2023-12-16', 0, 'UPS-10-KVA'),
(141, 42, '', 'FB-INV-UPS-003', 1, '2022-12-16', '2023-12-16', 0, 'UPS-10-KVA'),
(142, 43, '', 'FB-KEYBOARD-001', 1, '2022-12-16', '2023-12-16', 0, 'KEYBOARD'),
(143, 44, '', 'FB-HDMI-CON-001', 1, '2022-12-16', '2023-12-16', 0, 'HDMI-CONVERTER'),
(144, 45, '', 'FB-PENDRIVE-001', 1, '2022-12-16', '2023-12-16', 0, 'USB-PENDRIVE-64GB'),
(145, 45, '', 'FB-HDD-SATA-001', 1, '2022-12-16', '2023-12-16', 0, 'HDD-SATA-2TB'),
(146, 46, '', 'FB-ADAP-WL-001', 1, '2022-12-16', '2023-12-16', 0, 'ADAP-WIRELESS-T2U'),
(147, 46, '', 'FB-ADAP-WL-002', 1, '2022-12-16', '2023-12-16', 0, 'ADAP-WIRELESS-T2U'),
(148, 47, '', 'FB-ADAP-CON-001', 1, '2022-12-16', '2023-12-16', 0, 'ADAP-CONVERTER-TC'),
(149, 48, '', 'FB-ADAP-NT-001', 1, '2022-12-16', '2023-12-16', 0, 'ADAP-NT-UE300C-TC'),
(150, 48, '', 'FB-ADAP-NT-002', 1, '2022-12-16', '2023-12-16', 0, 'ADAP-NT-UE300C-TC'),
(151, 48, '', 'FB-ADAP-NT-003', 1, '2022-12-16', '2023-12-16', 0, 'ADAP-NT-UE300C-USB3'),
(152, 48, '', 'FB-ADAP-NT-004', 1, '2022-12-16', '2023-12-16', 0, 'ADAP-NT-UE300C-USB3'),
(153, 48, '', 'FB-USB-PORT-001', 1, '2022-12-16', '2023-12-16', 0, 'USB-PORT-HUB4'),
(154, 48, '', 'FB-ADAP-USB-001', 1, '2022-12-16', '2023-12-16', 0, 'ADAP-USB-T3-QZ-AD11'),
(155, 48, '', 'FB-ADAP-USB-002', 1, '2022-12-16', '2023-12-16', 0, 'ADAP-USB-T3-QZ-AD11'),
(156, 49, '', 'FB-MON-BENQ-001', 1, '2022-12-16', '2023-12-16', 0, 'MON-GW2480-T-24'),
(157, 50, '', 'FB-MON-MK-002', 1, '2022-12-16', '2023-12-16', 0, 'MON-24MK600M-24'),
(158, 51, '', 'FB-MON-BENQ-003', 1, '2022-12-16', '2023-12-16', 0, 'MON-GW2480-T-24'),
(159, 51, '', 'FB-MON-BENQ-004', 1, '2022-12-16', '2023-12-16', 0, 'MON-GW2480-T-24'),
(160, 52, '', 'FB-PRECISION-001', 1, '2022-12-16', '2023-12-16', 0, 'PRECISION-110'),
(161, 53, '', 'FB-RAM-DDR4-001', 1, '2022-12-16', '2023-12-16', 0, 'RAM-DDR4-16GB'),
(162, 53, '', 'FB-CPU-I5-001', 1, '2022-12-16', '2023-12-16', 0, 'CPU-I5-10400'),
(163, 53, '', 'FB-CABINET-001', 1, '2022-12-16', '2023-12-16', 0, 'CAB-FING-SMPS'),
(164, 53, '', 'FB-MTB-001', 1, '2022-12-16', '2023-12-16', 0, 'MTB-B460M-DS3H-AC'),
(166, 53, '', 'FB-HDD-002', 1, '2022-12-16', '2023-12-16', 0, 'HDD-HDD-1TB'),
(167, 53, '', 'FB-MON-E-005', 1, '2022-12-16', '2023-12-16', 0, 'MON-E2421HN-24'),
(168, 53, '', 'FB-HDD-SSD-003', 1, '2022-12-16', '2023-12-16', 0, 'HDD-SSD-500GB'),
(169, 54, '', 'FB-HDD-SSD-004', 1, '2022-12-16', '2023-12-16', 0, 'HDD-SSD-500GB'),
(170, 54, '', 'FB-HDD-SSD-005', 1, '2022-12-16', '2023-12-16', 0, 'HDD-SSD-500GB'),
(171, 54, '', 'FB-HDD-SSD-006', 1, '2022-12-16', '2023-12-16', 0, 'HDD-SSD-500GB'),
(172, 54, '', 'FB-HDD-SSD-007', 1, '2022-12-16', '2023-12-16', 0, 'HDD-SSD-500GB'),
(173, 54, '', 'FB-HDD-SSD-008', 1, '2022-12-16', '2023-12-16', 0, 'HDD-SSD-500GB'),
(174, 54, '', 'FB-HDD-SSD-009', 1, '2022-12-16', '2023-12-16', 0, 'HDD-SSD-500GB'),
(175, 55, '', 'FB-HEADPHONE-001', 1, '2022-12-16', '2023-12-16', 0, 'HEADPHONE-G231'),
(176, 55, '', 'FB-HEADPHONE-002', 1, '2022-12-16', '2023-12-16', 0, 'HEADPHONE-G231'),
(177, 56, '', 'FB-SOUND-C-001', 1, '2022-12-16', '2023-12-16', 0, 'USB-SOUND'),
(178, 57, '', 'FB-MON-BENQ-007', 1, '2022-12-16', '2023-12-16', 0, 'MON-GW2480-T-24'),
(179, 57, '', 'FB-MON-BENQ-006', 1, '2022-12-16', '2023-12-16', 0, 'MON-GW2480-T-24'),
(181, 58, '', 'FB-MON-BENQ-008', 1, '2022-12-16', '2023-12-16', 0, 'MON-GW2480-T-24'),
(182, 59, '', 'FB-MICROPHOE-001', 1, '2022-12-16', '2023-12-16', 0, 'M-PHONE-BY-M1'),
(183, 60, '', 'FB-RAM-DDR4-002', 1, '2022-12-16', '2023-12-16', 0, 'RAM-DDR4-16GB'),
(184, 61, '', 'FB-HDD-SSD-010', 1, '2022-12-16', '2023-12-16', 0, 'HDD-SSD-500GB'),
(185, 61, '', 'FB-HDD-SSD-011', 1, '2022-12-16', '2023-12-16', 0, 'HDD-SSD-500GB'),
(186, 62, '', 'FB-CPU-I5-002', 1, '2022-12-16', '2023-12-16', 0, 'CPU-I5-10400'),
(187, 63, '', 'FB-RAM-DDR4-003', 1, '2022-12-16', '2023-12-16', 0, 'RAM-DDR4-16GB'),
(188, 63, '', 'FB-CABINET-002', 1, '2022-12-16', '2023-12-16', 0, 'CAB-FING-SMPS'),
(189, 63, '', 'FB-MTB-002', 1, '2022-12-16', '2023-12-16', 0, 'MTB-H470M-DS3H'),
(190, 63, '', 'FB-HDD-012', 1, '2022-12-16', '2023-12-16', 0, 'HDD-HDD-1TB'),
(191, 63, '', 'FB-HDD-SSD-013', 1, '2022-12-16', '2023-12-16', 0, 'HDD-SSD-500GB'),
(192, 63, '', 'FB-HDD-SSD-014', 1, '2022-12-16', '2023-12-16', 0, 'HDD-SSD-480GB'),
(193, 63, '', 'FB-HDD-SSD-015', 1, '2022-12-16', '2023-12-16', 0, 'HDD-SSD-480GB'),
(194, 63, '', 'FB-HDD-SSD-016', 1, '2022-12-16', '2023-12-16', 0, 'HDD-SSD-480GB'),
(195, 63, '', 'FB-HDD-SSD-017', 1, '2022-12-16', '2023-12-16', 0, 'HDD-SSD-480GB'),
(196, 63, '', 'FB-HDD-SSD-018', 1, '2022-12-16', '2023-12-16', 0, 'HDD-SSD-480GB'),
(197, 64, '', 'FB-HEADPHONE-003', 1, '2022-12-16', '2023-12-16', 0, 'HEADPHONE-G340'),
(198, 64, '', 'FB-MOUSE-WL-001', 1, '2022-12-16', '2023-12-16', 0, 'MOUSE-WIRELESS'),
(199, 65, '', 'FB-RAM-DDR4-004', 1, '2022-12-16', '2023-12-16', 0, 'RAM-DDR4-16GB'),
(200, 65, '', 'FB-RAM-DDR4-005', 1, '2022-12-16', '2023-12-16', 0, 'RAM-DDR4-16GB'),
(201, 65, '', 'FB-SMPS-COR-001', 1, '2022-12-16', '2023-12-16', 0, 'SMPS-CORSIAR-450'),
(202, 65, '', 'FB-SMPS-COR-002', 1, '2022-12-16', '2023-12-16', 0, 'SMPS-CORSIAR-450'),
(203, 65, '', 'FB-CABINET-003', 1, '2022-12-16', '2023-12-16', 0, 'CAB-CORSIAR'),
(204, 65, '', 'FB-CABINET-004', 1, '2022-12-16', '2023-12-16', 0, 'CAB-CORSIAR'),
(205, 65, '', 'FB-CPU-I5-003', 1, '2022-12-16', '2023-12-16', 0, 'CPU-I5-10400'),
(206, 65, '', 'FB-CPU-I5-004', 1, '2022-12-16', '2023-12-16', 0, 'CPU-I5-10400'),
(207, 65, '', 'FB-MTB-003', 1, '2022-12-16', '2023-12-16', 0, 'MTB-Z490'),
(208, 65, '', 'FB-MTB-004', 1, '2022-12-16', '2023-12-16', 0, 'MTB-Z490'),
(209, 65, '', 'FB-HDD-SSD-020', 1, '2022-12-16', '2023-12-16', 0, 'HDD-HDD-1TB'),
(210, 65, '', 'FB-HDD-SSD-021', 1, '2022-12-16', '2023-12-16', 0, 'HDD-HDD-1TB'),
(211, 65, '', 'FB-HDD-SSD-022', 1, '2022-12-16', '2023-12-16', 0, 'HDD-500GB'),
(212, 65, '', 'FB-HDD-SSD-023', 1, '2022-12-16', '2023-12-16', 0, 'HDD-500GB'),
(213, 65, '', 'FB-HDD-SSD-024', 1, '2022-12-16', '2023-12-16', 0, 'HDD-SSD-480GB'),
(214, 65, '', 'FB-HDD-SSD-025', 1, '2022-12-16', '2023-12-16', 0, 'HDD-SSD-480GB'),
(215, 66, '', 'FB-SMPS-003', 1, '2022-12-16', '2023-12-16', 0, 'SMPS-F-P-400'),
(216, 66, '', 'FB-MON-FRON-009', 1, '2022-12-16', '2023-12-16', 0, 'MON-FRONTECH'),
(217, 66, '', 'FB-SMPS-004', 1, '2022-12-16', '2023-12-16', 0, 'SMPS-F-G-12-407'),
(218, 67, '', 'FB-HDD-SSD-026', 1, '2022-12-16', '2023-12-16', 0, 'HDD-SSD-500GB'),
(219, 67, '', 'FB-HDD-SSD-027', 1, '2022-12-16', '2023-12-16', 0, 'HDD-SSD-500GB'),
(220, 67, '', 'FB-HDD-SSD-028', 1, '2022-12-16', '2023-12-16', 0, 'HDD-SSD-500GB'),
(221, 67, '', 'FB-HDD-SSD-029', 1, '2022-12-16', '2023-12-16', 0, 'HDD-SSD-500GB'),
(222, 67, '', 'FB-HDD-SSD-030', 1, '2022-12-16', '2023-12-16', 0, 'HDD-SSD-500GB'),
(223, 68, '', 'FB-SMPS-005', 1, '2022-12-16', '2023-12-16', 0, 'SMPS-F-G-401'),
(224, 68, '', 'FB-SMPS-006', 1, '2022-12-16', '2023-12-16', 0, 'SMPS-F-G-401'),
(225, 68, '', 'FB-SMPS-007', 1, '2022-12-16', '2023-12-16', 0, 'SMPS-F-G-401'),
(226, 68, '', 'FB-SMPS-008', 1, '2022-12-16', '2023-12-16', 0, 'SMPS-F-G-401'),
(227, 68, '', 'FB-SMPS-009', 1, '2022-12-16', '2023-12-16', 0, 'SMPS-F-G-401'),
(228, 69, '', 'FB-RAM-DDR4-006', 1, '2022-12-16', '2023-12-16', 1, 'RAM-DDR4-8GB'),
(229, 69, '', 'FB-CPU-I3-001', 1, '2022-12-16', '2023-12-16', 0, 'CPU-I3-10105'),
(230, 69, '', 'FB-MTB-012', 1, '2022-12-16', '2023-12-16', 0, 'MTB-B460M-DS3H-V2'),
(231, 69, '', 'FB-HDD-031', 1, '2022-12-16', '2023-12-16', 1, 'HDD-500GB'),
(232, 70, '', 'FB-RAM-DDR4-007', 1, '2022-12-16', '2023-12-16', 1, 'RAM-DDR4-8GB'),
(233, 70, '', 'FB-CPU-I3-002', 1, '2022-12-16', '2023-12-16', 0, 'CPU-I3-10105'),
(234, 70, '', 'FB-CABINET-005', 1, '2022-12-16', '2023-12-16', 0, 'CAB-FING-SMPS'),
(235, 70, '', 'FB-MTB-005', 1, '2022-12-16', '2023-12-16', 0, 'MTB-B460M-DS3H-V2'),
(236, 70, '', 'FB-MON-LG-010', 1, '2022-12-16', '2023-12-16', 1, 'MON-22MP68VQ-22'),
(237, 70, '', 'FB-HDD-032', 1, '2022-12-16', '2023-12-16', 0, 'HDD-500GB'),
(238, 71, '', 'FB-RAM-DDR4-008', 1, '2022-12-16', '2023-12-16', 1, 'RAM-DDR4-8GB'),
(239, 71, '', 'FB-CPU-I3-003', 1, '2022-12-16', '2023-12-16', 0, 'CPU-I3-10105'),
(240, 71, '', 'FB-CABINET-006', 1, '2022-12-16', '2023-12-16', 0, 'CAB-FING-SMPS'),
(241, 71, '', 'FB-MTB-006', 1, '2022-12-16', '2023-12-16', 0, 'MTB-B460M-DS3H-V2'),
(242, 71, '', 'FB-MTB-007', 1, '2022-12-16', '2023-12-16', 0, 'MON-22MP68VQ-22'),
(243, 71, '', 'FB-HDD-033', 1, '2022-12-16', '2023-12-16', 0, 'HDD-500GB'),
(244, 72, '', 'FB-RAM-DDR4-010', 1, '2022-12-16', '2023-12-16', 0, 'RAM-DDR4-8GB'),
(245, 72, '', 'FB-RAM-DDR4-009', 1, '2022-12-16', '2023-12-16', 1, 'RAM-DDR4-8GB'),
(246, 72, '', 'FB-CPU-I3-005', 1, '2022-12-16', '2023-12-16', 0, 'CPU-I3-10105'),
(247, 72, '', 'FB-CPU-I3-004', 1, '2022-12-16', '2023-12-16', 0, 'CPU-I3-10105'),
(248, 72, '', 'FB-CABINET-008', 1, '2022-12-16', '2023-12-16', 0, 'CAB-FING-SMPS'),
(249, 72, '', 'FB-CABINET-007', 1, '2022-12-16', '2023-12-16', 0, 'CAB-FING-SMPS'),
(250, 72, '', 'FB-MTB-009', 1, '2022-12-16', '2023-12-16', 0, 'MTB-H470M-DS3H'),
(251, 72, '', 'FB-MTB-008', 1, '2022-12-16', '2023-12-16', 0, 'MTB-H470M-DS3H'),
(252, 72, '', 'FB-HDD-034', 1, '2022-12-16', '2023-12-16', 0, 'HDD-500GB'),
(253, 72, '', 'FB-HDD-035', 1, '2022-12-16', '2023-12-16', 0, 'HDD-500GB'),
(254, 73, '', 'FB-HEADPHONE-004', 1, '2022-12-16', '2023-12-16', 0, 'HEADPHONE-F5'),
(255, 73, '', 'FB-HEADPHONE-005', 1, '2022-12-16', '2023-12-16', 0, 'HEADPHONE-F5'),
(256, 73, '', 'FB-MOUSE-PAD-001', 1, '2022-12-16', '2023-12-16', 0, 'MOUSE-PAD'),
(257, 100, '', 'FB-RAM-DDR4-011', 1, '2022-12-16', '2023-12-16', 0, 'RAM-DDR4-16GB'),
(258, 100, '', 'FB-MON-BENQ-011', 1, '2022-12-16', '2023-12-16', 0, 'MON-GW2480-T-24'),
(259, 100, '', 'FB-CABINET-009', 1, '2022-12-16', '2023-12-16', 0, 'CAB-IBALL'),
(260, 100, '', 'FB-CPU-I5-005', 1, '2022-12-16', '2023-12-16', 0, 'CPU-I5-8400'),
(261, 100, '', 'FB-MTB-010', 1, '2022-12-16', '2023-12-16', 0, 'MTB-B365M D3H'),
(262, 100, '', 'FB-HDD-SDD-036', 1, '2022-12-16', '2023-12-16', 0, 'HDD-SSD-500GB'),
(263, 101, '', 'FB-HDD-SDD-037', 1, '2022-12-16', '2023-12-16', 0, 'HDD-SSD-500GB'),
(264, 102, '', 'FB-RAM-DDR4-012', 1, '2022-12-16', '2023-12-16', 0, 'RAM-DDR4-16GB'),
(265, 102, '', 'FB-RAM-DDR3-001', 1, '2022-12-16', '2023-12-16', 0, 'RAM-DDR3-16GB'),
(266, 102, '', 'FB-MTB-011', 1, '2022-12-16', '2023-12-16', 0, 'MTB-B360M-D3H'),
(267, 102, '', 'FB-CABINET-010', 1, '2022-12-16', '2023-12-16', 0, 'CAB-IBALL'),
(268, 102, '', 'FB-CPU-I5-007', 1, '2022-12-16', '2023-12-16', 0, 'CPU-I5-8400'),
(269, 102, '', 'FB-HDD-1TB-038', 1, '2022-12-16', '2023-12-16', 0, 'HDD-1TB'),
(270, 103, '', 'FB-WEBCAM-001', 1, '2022-12-16', '2023-12-16', 0, 'LOGI-WEBCAM-C270'),
(271, 103, '', 'FB-WEBCAM-002', 1, '2022-12-16', '2023-12-16', 0, 'LOGI-WEBCAM-C270'),
(272, 103, '', 'FB-WEBCAM-003', 1, '2022-12-16', '2023-12-16', 0, 'LOGI-WEBCAM-C270'),
(273, 104, '', 'FB-RAM-DDR4-013', 1, '2022-12-16', '2023-12-16', 0, 'RAM-DDR4-8GB'),
(274, 104, '', 'FB-RAM-DDR4-014', 1, '2022-12-16', '2023-12-16', 0, 'RAM-DDR4-8GB'),
(275, 104, '', 'FB-CABINET-011', 1, '2022-12-16', '2023-12-16', 0, 'CAB-FING-SMPS'),
(276, 104, '', 'FB-CABINET-012', 1, '2022-12-16', '2023-12-16', 0, 'CAB-FING-SMPS'),
(277, 104, '', 'FB-SMPS-010', 1, '2022-12-16', '2023-12-16', 0, 'SMPS-F-GAMA-401'),
(278, 104, '', 'FB-SMPS-011', 1, '2022-12-16', '2023-12-16', 0, 'SMPS-F-GAMA-401'),
(279, 104, '', 'FB-SMPS-012', 1, '2022-12-16', '2023-12-16', 0, 'SMPS-F-GAMA-401'),
(280, 104, '', 'FB-SMPS-013', 1, '2022-12-16', '2023-12-16', 0, 'SMPS-F-GAMA-401'),
(281, 104, '', 'FB-MTB-041', 1, '2022-12-16', '2023-12-16', 0, 'MTB-B360M-D3H'),
(282, 104, '', 'FB-MTB-013', 1, '2022-12-16', '2023-12-16', 0, 'MTB-B360M-D3H'),
(283, 104, '', 'FB-CPU-I3-008', 1, '2022-12-16', '2023-12-16', 0, 'CPU-I3-BX8070110100'),
(284, 104, '', 'FB-CPU-I3-007', 1, '2022-12-16', '2023-12-16', 0, 'CPU-I3-BX8070110100'),
(285, 104, '', 'FB-HDD-039', 1, '2022-12-16', '2023-12-16', 0, 'HDD-500GB'),
(286, 104, '', 'FB-HDD-040', 1, '2022-12-16', '2023-12-16', 0, 'HDD-500GB'),
(289, 105, '', 'FB-HDD-041', 1, '2022-12-16', '2023-12-16', 0, 'HDD-HDD-1TB'),
(290, 105, '', 'FB-HDD-042', 1, '2022-12-16', '2023-12-16', 1, 'HDD-SSD-500GB'),
(291, 106, '', 'FB-HDD-043', 1, '2022-12-16', '2023-12-16', 0, 'HDD-HDD-1TB'),
(292, 106, '', 'FB-HDD-044', 1, '2022-12-16', '2023-12-16', 0, 'HDD-HDD-1TB'),
(293, 106, '', 'FB-SMPS-015', 1, '2022-12-16', '2023-12-16', 0, 'SMPS-I-ZPS-281'),
(294, 106, '', 'FB-SMPS-014', 1, '2022-12-16', '2023-12-16', 0, 'SMPS-I-ZPS-281'),
(295, 107, '', 'FB-RAM-DDR4-015', 1, '2022-12-16', '2023-12-16', 0, 'RAM-DDR4-16GB'),
(296, 107, '', 'FB-MON-BENQ-012', 1, '2022-12-16', '2023-12-16', 0, 'MON-GW2480-T-24'),
(299, 107, '', 'FB-CPU-I5-006', 1, '2022-12-16', '2023-12-16', 0, 'CPU-I5-10400'),
(300, 107, '', 'FB-CABINET-013', 1, '2022-12-16', '2023-12-16', 0, 'CAB-FING-SMPS'),
(301, 107, '', 'FB-MTB-014', 1, '2022-12-16', '2023-12-16', 0, 'MTB-B460M-DS3H-AC'),
(302, 107, '', 'FB-HDD-045', 1, '2022-12-16', '2023-12-16', 0, 'HDD-HDD-1TB'),
(303, 107, '', 'FB-HDD-046', 1, '2022-12-16', '2023-12-16', 0, 'HDD-HDD-1TB'),
(304, 107, '', 'FB-HDD-047', 1, '2022-12-16', '2023-12-16', 0, 'HDD-HDD-1TB'),
(305, 107, '', 'FB-HDD-048', 1, '2022-12-16', '2023-12-16', 0, 'HDD-HDD-1TB'),
(308, 108, '', 'FB-MTB-015', 1, '2022-12-16', '2023-12-16', 0, 'MTB- B560M-AE'),
(309, 108, '', 'FB-RAM-DDR4-016', 1, '2022-12-16', '2023-12-16', 0, 'RAM-DDR4-16GB'),
(310, 108, '', 'FB-RAM-DDR4-017', 1, '2022-12-16', '2023-12-16', 0, 'RAM-DDR4-16GB'),
(311, 108, '', 'FB-RAM-DDR4-018', 1, '2022-12-16', '2023-12-16', 0, 'RAM-DDR4-16GB'),
(312, 108, '', 'FB-MTB-016', 1, '2022-12-16', '2023-12-16', 0, 'MON-S2421H-24'),
(313, 108, '', 'FB-CABINET-014', 1, '2022-12-16', '2023-12-16', 0, 'CAB-FING-SMPS'),
(314, 108, '', 'FB-MTB-017', 1, '2022-12-16', '2023-12-16', 0, 'MTB-B560M-DS3H-AC'),
(315, 108, '', 'FB-HDD-049', 1, '2022-12-16', '2023-12-16', 1, 'HDD-SSD-500GB'),
(316, 109, '', 'FB-HDD-050', 1, '2022-12-16', '2023-12-16', 1, 'HDD-SSD-500GB'),
(317, 109, '', 'FB-CABINET-015', 1, '2022-12-16', '2023-12-16', 0, 'CAB-FING-SMPS'),
(318, 109, '', 'FB-MON-DELL-013', 1, '2022-12-16', '2023-12-16', 0, 'MON-S2421H-24'),
(319, 109, '', 'FB-RAM-DDR4-019', 1, '2022-12-16', '2023-12-16', 0, 'RAM-DDR4-16GB'),
(320, 109, '', 'FB-MTB-018', 1, '2022-12-16', '2023-12-16', 0, 'MTB- B560M-AE'),
(321, 110, '', 'FB-RAM-DDR4-020', 1, '2022-12-16', '2023-12-16', 0, 'RAM-DDR4-16GB'),
(322, 110, '', 'FB-RAM-DDR4-021', 1, '2022-12-16', '2023-12-16', 0, 'RAM-DDR4-8GB'),
(323, 110, '', 'FB-CPU-I3-009', 1, '2022-12-16', '2023-12-16', 0, 'CPU-I3-8100'),
(324, 110, '', 'FB-MTB-019', 1, '2022-12-16', '2023-12-16', 0, 'MTB-B360M-D3H'),
(325, 110, '', 'FB-MTB-020', 1, '2022-12-16', '2023-12-16', 0, 'MTB-B360M-D3H'),
(326, 110, '', 'FB-CABINET-016', 1, '2022-12-16', '2023-12-16', 0, 'CAB-IBALL'),
(327, 110, '', 'FB-CABINET-033', 1, '2022-12-16', '2023-12-16', 0, 'CAB-IBALL'),
(328, 110, '', 'FB-CPU-I5-008', 1, '2022-12-16', '2023-12-16', 0, 'CPU-I5-8400'),
(329, 110, '', 'FB-ADAP-LAP-001', 1, '2022-12-16', '2023-12-16', 0, 'ADAP-LAPCARE'),
(330, 110, '', 'FB-HDD-051', 1, '2022-12-16', '2023-12-16', 0, 'HDD-1TB'),
(331, 110, '', 'FB-HDD-052', 1, '2022-12-16', '2023-12-16', 0, 'HDD-1TB'),
(332, 110, '', 'FB-HDD-053', 1, '2022-12-16', '2023-12-16', 0, 'HDD-1TB'),
(333, 110, '', 'FB-HDD-054', 1, '2022-12-16', '2023-12-16', 0, 'HDD-1TB'),
(334, 111, '', 'MOUSE-USB-002', 1, '2022-12-16', '2023-12-16', 0, 'MOUSE-USB-M90'),
(335, 111, '', 'MOUSE-USB-001', 1, '2022-12-16', '2023-12-16', 0, 'MOUSE-USB-M90'),
(336, 111, '', 'MOUSE-USB-003', 1, '2022-12-16', '2023-12-16', 0, 'MOUSE-USB-M90'),
(337, 111, '', 'MOUSE-USB-004', 1, '2022-12-16', '2023-12-16', 0, 'MOUSE-USB-M90'),
(338, 111, '', 'MOUSE-USB-005', 1, '2022-12-16', '2023-12-16', 0, 'MOUSE-USB-M90'),
(339, 112, '', 'FB-RAM-DDR4-022', 1, '2022-12-16', '2023-12-16', 0, 'RAM-DDR4-16GB'),
(340, 112, '', 'FB-RAM-DDR4-023', 1, '2022-12-16', '2023-12-16', 0, 'RAM-DDR4-16GB'),
(341, 112, '', 'FB-RAM-DDR4-024', 1, '2022-12-16', '2023-12-16', 0, 'RAM-DDR4-16GB'),
(342, 112, '', 'FB-MTB-021', 1, '2022-12-16', '2023-12-16', 0, 'MON-GW2480-B-24'),
(343, 112, '', 'FB-CPU-I5-009', 1, '2022-12-16', '2023-12-16', 0, 'CPU-I5-10400'),
(344, 112, '', 'FB-CPU-I5-010', 1, '2022-12-16', '2023-12-16', 0, 'CPU-I5-10400'),
(345, 112, '', 'FB-CPU-I5-011', 1, '2022-12-16', '2023-12-16', 0, 'CPU-I5-10400'),
(346, 112, '', 'FB-CABINET-017', 1, '2022-12-16', '2023-12-16', 0, 'CAB-FINGERS'),
(347, 112, '', 'FB-CABINET-018', 1, '2022-12-16', '2023-12-16', 0, 'CAB-FINGERS'),
(348, 112, '', 'FB-MTB-042', 1, '2022-12-16', '2023-12-16', 0, 'MTB-B460M-DS3H-V2'),
(349, 112, '', 'FB-MTB-023', 1, '2022-12-16', '2023-12-16', 0, 'MTB-B460M-DS3H-V2'),
(350, 112, '', 'FB-MTB-044', 1, '2022-12-16', '2023-12-16', 0, 'MTB-B460M-DS3H-V2'),
(351, 112, '', 'FB-MTB-022', 1, '2022-12-16', '2023-12-16', 0, 'HDD-HDD-1TB'),
(352, 112, '', 'FB-MTB-043', 1, '2022-12-16', '2023-12-16', 0, 'HDD-HDD-1TB'),
(353, 112, '', 'FB-HDD-055', 1, '2022-12-16', '2023-12-16', 0, 'HDD-SSD-500GB'),
(354, 112, '', 'FB-HDD-056', 1, '2022-12-16', '2023-12-16', 0, 'HDD-SSD-500GB'),
(355, 113, '', 'FB-HDD-057', 1, '2022-12-16', '2023-12-16', 0, 'HDD-SSD-500GB'),
(356, 113, '', 'FB-HDD-058', 1, '2022-12-16', '2023-12-16', 0, 'HDD-HDD-1TB'),
(357, 113, '', 'FB-HDD-059', 1, '2022-12-16', '2023-12-16', 0, 'HDD-HDD-1TB'),
(358, 113, '', 'FB-SMPS-016', 1, '2022-12-16', '2023-12-16', 0, 'SMPS-I-ZPS-281'),
(359, 113, '', 'FB-SMPS-017', 1, '2022-12-16', '2023-12-16', 0, 'SMPS-I-ZPS-281'),
(360, 113, '', 'FB-RAM-DDR4-025', 1, '2022-12-16', '2023-12-16', 0, 'RAM-DDR4-16GB'),
(361, 114, '', 'FB-RAM-DDR4-026', 1, '2022-12-16', '2023-12-16', 0, 'RAM-DDR4-16GB'),
(362, 114, '', 'FB-SMPS-018', 1, '2022-12-16', '2023-12-16', 0, 'SMPS-ANTEC-VP-450'),
(363, 114, '', 'FB-MON-BENQ-014', 1, '2022-12-16', '2023-12-16', 0, 'MON-GW2480-B-24'),
(364, 114, '', 'FB-CABINET-019', 1, '2022-12-16', '2023-12-16', 0, 'CAB-CORSIAR'),
(366, 114, '', 'FB-CPU-I5-012', 1, '2022-12-16', '2023-12-16', 0, 'CPU-I5-10400'),
(367, 114, '', 'FB-MTB-024', 1, '2022-12-16', '2023-12-16', 0, 'MTB-B460M-DS3H-AC'),
(368, 114, '', 'FB-GRAPHIC-001', 1, '2022-12-16', '2023-12-16', 0, 'GR-CARD-Z-GTX-1050'),
(369, 114, '', 'FB-HDD-060', 1, '2022-12-16', '2023-12-16', 0, 'HDD-HDD-1TB'),
(370, 114, '', 'MOUSE-USB-006', 1, '2022-12-16', '2023-12-16', 1, 'MOUSE-USB'),
(371, 114, '', 'FB-HDD-061', 1, '2022-12-16', '2023-12-16', 0, 'HDD-500GB'),
(372, 115, '', 'FB-HDD-SATA-062', 1, '2022-12-19', '2023-12-19', 0, 'HDD-SATA-8TB'),
(373, 116, '', 'FB-RAM-DDR4-027', 1, '2022-12-19', '2023-12-19', 0, 'RAM-DDR4-16GB'),
(374, 116, '', 'FB-MON-BENQ-015', 1, '2022-12-19', '2023-12-19', 0, 'MON-GW2480-B-24'),
(375, 116, '', 'FB-CPU-I5-013', 1, '2022-12-19', '2023-12-19', 0, 'CPU-I5-10400'),
(376, 116, '', 'FB-CABINET-020', 1, '2022-12-19', '2023-12-19', 0, 'CAB-FING-SMPS'),
(377, 116, '', 'FB-MTB-025', 1, '2022-12-19', '2023-12-19', 0, 'MTB-B460M-DS3H-AC'),
(378, 116, '', 'FB-HDD-063', 1, '2022-12-19', '2023-12-19', 0, 'HDD-HDD-1TB'),
(379, 116, '', 'MOUSE-USB-007', 1, '2022-12-19', '2023-12-19', 0, 'MOUSE-USB'),
(380, 116, '', 'FB-HDD-064', 1, '2022-12-19', '2023-12-19', 0, 'HDD-500GB'),
(381, 117, '', 'FB-RAM-DDR4-028', 1, '2022-12-19', '2023-12-19', 0, 'RAM-DDR4-16GB'),
(382, 117, '', 'FB-RAM-DDR4-029', 1, '2022-12-19', '2023-12-19', 0, 'RAM-DDR4-16GB'),
(383, 117, '', 'FB-MON-BENQ-016', 1, '2022-12-19', '2023-12-19', 0, 'MON-GW2480-T-24'),
(384, 117, '', 'FB-CPU-I5-014', 1, '2022-12-19', '2023-12-19', 0, 'CPU-I5-9400'),
(385, 117, '', 'FB-CPU-I5-015', 1, '2022-12-19', '2023-12-19', 0, 'CPU-I5-9400'),
(386, 117, '', 'FB-MTB-026', 1, '2022-12-19', '2023-12-19', 0, 'MTB-B360M-D3H'),
(387, 117, '', 'FB-MTB-027', 1, '2022-12-19', '2023-12-19', 0, 'MTB-B360M-D3H'),
(388, 117, '', 'FB-CABINET-021', 1, '2022-12-19', '2023-12-19', 0, 'CAB-IBALL'),
(389, 117, '', 'FB-CABINET-022', 1, '2022-12-19', '2023-12-19', 0, 'CAB-IBALL'),
(390, 117, '', 'FB-GRAPHIC-002', 1, '2022-12-19', '2023-12-19', 0, 'GR-CARD-N-GT-70'),
(391, 117, '', 'FB-GRAPHIC-003', 1, '2022-12-19', '2023-12-19', 0, 'GR-CARD-N-GT-70'),
(392, 118, '', 'FB-HDD-065', 1, '2022-12-19', '2023-12-19', 0, 'HDD-1TB'),
(393, 119, '', 'FB-HDD-066', 1, '2022-12-19', '2023-12-19', 0, 'HDD-HDD-1TB'),
(394, 119, '', 'FB-HDD-067', 1, '2022-12-19', '2023-12-19', 0, 'HDD-HDD-1TB'),
(395, 119, '', 'FB-HDD-068', 1, '2022-12-19', '2023-12-19', 0, 'HDD-HDD-1TB'),
(396, 119, '', 'FB-HDD-069', 1, '2022-12-19', '2023-12-19', 0, 'HDD-HDD-1TB'),
(397, 119, '', 'FB-HDD-070', 1, '2022-12-19', '2023-12-19', 0, 'HDD-HDD-1TB'),
(398, 120, '', 'FB-HDD-071', 1, '2022-12-19', '2023-12-19', 0, 'HDD-SSD-500GB'),
(399, 120, '', 'FB-HDD-072', 1, '2022-12-19', '2023-12-19', 0, 'HDD-SSD-500GB'),
(400, 120, '', 'FB-HDD-073', 1, '2022-12-19', '2023-12-19', 0, 'HDD-SSD-500GB'),
(401, 121, '', 'FB-RAM-DDR4-030', 1, '2022-12-19', '2023-12-19', 0, 'RAM-DDR4-16GB'),
(402, 121, '', 'FB-MON-BENQ-017', 1, '2022-12-19', '2023-12-19', 0, 'MON-GW2480-T-24'),
(403, 121, '', 'FB-MON-BENQ-018', 1, '2022-12-19', '2023-12-19', 0, 'MON-GW2480-T-24'),
(404, 121, '', 'FB-RAM-DDR4-031', 1, '2022-12-19', '2023-12-19', 0, 'RAM-DDR4-8GB'),
(405, 121, '', 'FB-MTB-029', 1, '2022-12-19', '2023-12-19', 0, 'MTB-B360M-D3H'),
(406, 121, '', 'FB-MTB-028', 1, '2022-12-19', '2023-12-19', 0, 'MTB-B360M-D3H'),
(407, 121, '', 'FB-CABINET-024', 1, '2022-12-19', '2023-12-19', 0, 'CAB-IBALL'),
(408, 121, '', 'FB-CABINET-023', 1, '2022-12-19', '2023-12-19', 0, 'CAB-IBALL'),
(409, 121, '', 'FB-HDD-074', 1, '2022-12-19', '2023-12-19', 0, 'HDD-SSD-240GB'),
(410, 121, '', 'FB-HDD-075', 1, '2022-12-19', '2023-12-19', 0, 'HDD-SSD-240GB'),
(411, 122, '', 'FB-RAM-DDR4-032', 1, '2022-12-19', '2023-12-19', 0, 'RAM-DDR4-16GB'),
(412, 122, '', 'FB-RAM-DDR4-033', 1, '2022-12-19', '2023-12-19', 0, 'RAM-DDR4-8GB'),
(413, 122, '', 'FB-HDD-076', 1, '2022-12-19', '2023-12-19', 0, 'HDD-1TB'),
(414, 122, '', 'FB-HDD-077', 1, '2022-12-19', '2023-12-19', 0, 'HDD-1TB'),
(415, 123, '', 'FB-RAM-DDR4-034', 1, '2022-12-19', '2023-12-19', 0, 'RAM-DDR4-16GB'),
(416, 123, '', 'FB-RAM-DDR4-035', 1, '2022-12-19', '2023-12-19', 0, 'RAM-DDR4-16GB'),
(417, 123, '', 'FB-MON-BENQ-019', 1, '2022-12-19', '2023-12-19', 0, 'MON-GW2480-T-24'),
(418, 123, '', 'FB-MON-BENQ-020', 1, '2022-12-19', '2023-12-19', 0, 'MON-GW2480-T-24'),
(419, 123, '', 'FB-MON-BENQ-021', 1, '2022-12-19', '2023-12-19', 0, 'MON-GW2480-T-24'),
(420, 123, '', 'FB-CPU-I3-010', 1, '2022-12-19', '2023-12-19', 0, 'CPU-I3-8100'),
(421, 123, '', 'FB-MTB-030', 1, '2022-12-19', '2023-12-19', 0, 'MTB-B360M-D3H'),
(422, 123, '', 'FB-MTB-031', 1, '2022-12-19', '2023-12-19', 0, 'MTB-B360M-D3H'),
(423, 123, '', 'FB-CABINET-024', 1, '2022-12-19', '2023-12-19', 0, 'CAB-IBALL'),
(424, 123, '', 'FB-CABINET-025', 1, '2022-12-19', '2023-12-19', 0, 'CAB-IBALL'),
(425, 123, '', 'FB-CPU-I5-024', 1, '2022-12-19', '2023-12-19', 0, 'CPU-I5-8400'),
(426, 123, '', 'FB-HDD-078', 1, '2022-12-19', '2023-12-19', 0, 'HDD-SSD-500GB'),
(427, 124, '', 'FB-RAM-DDR4-036', 1, '2022-12-19', '2023-12-19', 0, 'RAM-DDR4-16GB'),
(428, 124, '', 'MOUSE-USB-008', 1, '2022-12-19', '2023-12-19', 0, 'MOUSE-USB'),
(429, 124, '', 'MOUSE-USB-009', 1, '2022-12-19', '2023-12-19', 0, 'MOUSE-USB'),
(430, 124, '', 'MOUSE-USB-010', 1, '2022-12-19', '2023-12-19', 0, 'MOUSE-USB'),
(431, 124, '', 'MOUSE-USB-011', 1, '2022-12-19', '2023-12-19', 0, 'MOUSE-USB'),
(432, 124, '', 'MOUSE-USB-012', 1, '2022-12-19', '2023-12-19', 0, 'MOUSE-USB'),
(433, 125, '', 'FB-RAM-DDR4-037', 1, '2022-12-19', '2023-12-19', 0, 'RAM-DDR4-16GB'),
(434, 125, '', 'FB-RAM-DDR4-038', 1, '2022-12-19', '2023-12-19', 0, 'RAM-DDR4-16GB'),
(435, 125, '', 'FB-CPU-I5-016', 1, '2022-12-19', '2023-12-19', 0, 'CPU-I5-10400'),
(436, 125, '', 'FB-CPU-I5-017', 1, '2022-12-19', '2023-12-19', 0, 'CPU-I5-10400'),
(437, 125, '', 'FB-CABINET-026', 1, '2022-12-19', '2023-12-19', 0, 'CAB-FING-SMPS'),
(438, 125, '', 'FB-CABINET-027', 1, '2022-12-19', '2023-12-19', 0, 'CAB-FING-SMPS'),
(439, 125, '', 'FB-MTB-032', 1, '2022-12-19', '2023-12-19', 0, 'MTB-B460M-DS3H-V2'),
(440, 125, '', 'FB-MTB-033', 1, '2022-12-19', '2023-12-19', 0, 'MTB-B460M-DS3H-V2'),
(441, 125, '', 'FB-HDD-079', 1, '2022-12-19', '2023-12-19', 0, 'HDD-HDD-1TB'),
(442, 125, '', 'FB-HDD-080', 1, '2022-12-19', '2023-12-19', 0, 'HDD-HDD-1TB'),
(443, 125, '', 'FB-MON-BENQ-022', 1, '2022-12-19', '2023-12-19', 0, 'MON-LED-LF24T352FHWXXL-24'),
(444, 125, '', 'FB-MON-BENQ-023', 1, '2022-12-19', '2023-12-19', 0, 'MON-LED-LF24T352FHWXXL-24'),
(445, 125, '', 'FB-HDD-081', 1, '2022-12-19', '2023-12-19', 0, 'HDD-SSD-500GB'),
(446, 125, '', 'FB-HDD-082', 1, '2022-12-19', '2023-12-19', 0, 'HDD-SSD-500GB'),
(447, 126, '', 'FB-HDD-083', 1, '2022-12-19', '2023-12-19', 0, 'HDD-HDD-1TB'),
(448, 126, '', 'FB-HDD-084', 1, '2022-12-19', '2023-12-19', 0, 'HDD-HDD-1TB'),
(449, 126, '', 'FB-HDD-085', 1, '2022-12-19', '2023-12-19', 0, 'HDD-HDD-1TB'),
(450, 126, '', 'FB-HDD-086', 1, '2022-12-19', '2023-12-19', 0, 'HDD-HDD-1TB'),
(451, 126, '', 'FB-HDD-087', 1, '2022-12-19', '2023-12-19', 0, 'HDD-HDD-1TB'),
(452, 127, '', 'FB-UPS-001', 1, '2022-12-19', '2023-12-19', 0, 'UPS-600-VA'),
(453, 128, '', 'FB-MON-BENQ-024', 1, '2022-12-19', '2023-12-19', 0, 'MON-GW2480-T-24'),
(454, 128, '', 'FB-HDD-088', 1, '2022-12-19', '2023-12-19', 0, 'HDD-HDD-1TB'),
(455, 128, '', 'FB-HDD-089', 1, '2022-12-19', '2023-12-19', 0, 'HDD-HDD-1TB'),
(456, 128, '', 'FB-SMPS-019', 1, '2022-12-19', '2023-12-19', 0, 'SMPS-I-ZPS-281'),
(457, 128, '', 'FB-SMPS-020', 1, '2022-12-19', '2023-12-19', 0, 'SMPS-I-ZPS-281'),
(458, 128, '', 'FB-HDD-090', 1, '2022-12-19', '2023-12-19', 0, 'HDD-SSD-500GB'),
(459, 129, '', 'FB-RAM-DDR3-002', 1, '2022-12-19', '2023-12-19', 0, 'RAM-DDR3-8GB'),
(460, 130, '', 'FB-MON-BENQ-025', 1, '2022-12-19', '2023-12-19', 0, 'MON-GW2280-B-22'),
(461, 131, '', 'FB-MON-BENQ-026', 1, '2022-12-19', '2023-12-19', 0, 'MON-GW2480-T-24'),
(462, 132, '', 'FB-HDD-091', 1, '2022-12-19', '2023-12-19', 0, 'HDD-SSD-500GB'),
(463, 132, '', 'FB-HDD-092', 1, '2022-12-19', '2023-12-19', 0, 'HDD-SSD-500GB'),
(464, 133, '', 'FB-ADAP-USB-003', 1, '2022-12-19', '2023-12-19', 0, 'USB-LINK-HUB'),
(465, 134, '', 'FB-MON-BENQ-027', 1, '2022-12-19', '2023-12-19', 0, 'MON-GW2480-T-24'),
(466, 135, '', 'FB-HDD-093', 1, '2022-12-19', '2023-12-19', 0, 'HDD-SSD-1TB'),
(467, 136, '', 'FB-MON-BENQ-028', 1, '2022-12-19', '2023-12-19', 0, 'MON-GW2480-T-24'),
(468, 137, '', 'FB-MON-LG-029', 1, '2022-12-19', '2023-12-19', 1, 'MON-22MP68VQ-22'),
(469, 138, '', 'FB-HDD-094', 1, '2022-12-19', '2023-12-19', 0, 'HDD-SSD-500GB'),
(470, 139, '', 'FB-HDD-095', 1, '2022-12-19', '2023-12-19', 0, 'HDD-SSD-500GB'),
(471, 140, '', 'FB-MON-BENQ-030', 1, '2022-12-19', '2023-12-19', 0, 'MON-GW2480-T-24'),
(472, 141, '', 'FB-HDD-096', 1, '2022-12-19', '2023-12-19', 0, 'HDD-HDD-1TB'),
(473, 141, '', 'FB-HDD-097', 1, '2022-12-19', '2023-12-19', 0, 'HDD-HDD-1TB'),
(474, 141, '', 'FB-HDD-098', 1, '2022-12-19', '2023-12-19', 0, 'HDD-HDD-1TB'),
(475, 141, '', 'FB-HDD-099', 1, '2022-12-19', '2023-12-19', 0, 'HDD-HDD-1TB'),
(476, 142, '', 'FB-MUSIC-WO-001', 1, '2022-12-19', '2023-12-19', 0, 'MUSIC-WOOFER'),
(477, 143, '', 'FB-FIREWALL-001', 1, '2022-12-19', '2023-12-19', 0, 'FIREWALL-FGT-80F'),
(478, 144, '', 'FB-PRO-001', 1, '2022-12-19', '2023-12-19', 0, 'PRO-I5-11GEN'),
(479, 144, '', 'FB-PRO-002', 1, '2022-12-19', '2023-12-19', 0, 'PRO-I5-11GEN'),
(480, 145, '', 'FB-PRO-003', 1, '2022-12-19', '2023-12-19', 0, 'PRO-I5-11GEN'),
(481, 146, '', 'FB-PRO-004', 1, '2022-12-19', '2023-12-19', 0, 'PRO-I5-11GEN'),
(482, 147, '', 'FB-PRO-005', 1, '2022-12-19', '2023-12-19', 0, 'PRO-I5-11GEN'),
(483, 147, '', 'FB-PRO-006', 1, '2022-12-19', '2023-12-19', 0, 'PRO-I5-11GEN'),
(484, 148, '', 'FB-PRO-007', 1, '2022-12-19', '2023-12-19', 0, 'PRO-I5-11GEN'),
(485, 149, '', 'FB-PRO-008', 1, '2022-12-19', '2023-12-19', 0, 'PRO-I3-8GEN'),
(486, 149, '', 'FB-PRO-009', 1, '2022-12-19', '2023-12-19', 0, 'PRO-I3-8GEN'),
(487, 150, '', 'FB-FIREWALL-002', 1, '2022-12-19', '2023-12-19', 0, 'FIREWALL-FGT-60F'),
(488, 151, '', 'FB-GENERATER-001', 1, '2022-12-19', '2023-12-19', 0, 'GEN-JSPF-35X-3PH'),
(489, 152, '', 'FB-GENERATER-002', 1, '2022-12-19', '2023-12-19', 0, 'GEN-SNMP-MCY-EN'),
(490, 153, '', 'FB-IPAD-001', 1, '2022-12-19', '2023-12-19', 0, 'LAP-IPAD-A1893'),
(491, 154, '', 'FB-LAPTOP-HP-001', 1, '2022-12-19', '2023-12-19', 0, 'LAP-HP-15Q'),
(492, 155, '', 'FB-LAPTOP-ASUS-002', 1, '2022-12-19', '2023-12-19', 0, 'LAP-ASUS-X509J'),
(493, 156, '', 'FB-LAPTOP-DELL-003', 1, '2022-12-19', '2023-12-19', 1, 'LAP-DELL-14'),
(494, 157, '', 'FB-LAPTOP-DELL-004', 1, '2022-12-19', '2023-12-19', 0, 'LAP-DELL-IP-3511'),
(495, 158, '', 'FB-LAPTOP-L-005', 1, '2022-12-19', '2023-12-19', 0, 'LAP-IPAD-L14ITL6 '),
(496, 159, '', 'FB-LAPTOP-HP-006', 1, '2022-12-19', '2023-12-19', 0, 'LAP-HP-15-EG2039TU'),
(497, 160, '', 'FB-LAPTOP-HP-008', 1, '2022-12-19', '2023-12-19', 0, 'LAP-HP-EG2039TU'),
(498, 160, '', 'FB-LAPTOP-HP-007', 1, '2022-12-19', '2023-12-19', 0, 'LAP-HP-EG2039TU'),
(499, 161, '', 'FB-LAPTOP-HP-009', 1, '2022-12-19', '2023-12-19', 0, 'LAP-HP-EG2039TU'),
(500, 162, '', 'FB-COOLING-PAD-001', 1, '2022-12-19', '2023-12-19', 0, 'LAPCARE-LCP-111'),
(501, 163, '', 'FB-COOLING-PAD-002', 1, '2022-12-19', '2023-12-19', 0, 'LAPCARE-LCP-111'),
(502, 163, '', 'FB-COOLING-PAD-003', 1, '2022-12-19', '2023-12-19', 0, 'LAPCARE-LCP-111'),
(503, 163, '', 'FB-COOLING-PAD-004', 1, '2022-12-19', '2023-12-19', 0, 'LAPCARE-LCP-111'),
(504, 164, '', 'FB-COOLING-PAD-005', 1, '2022-12-19', '2023-12-19', 0, 'LAPCARE-LCP-111'),
(505, 164, '', 'FB-COOLING-PAD-006', 1, '2022-12-19', '2023-12-19', 0, 'LAPCARE-LCP-111'),
(506, 165, '', 'FB-DOOR-L-001', 1, '2022-12-19', '2023-12-19', 1, 'DL-ESSL-EML600-2'),
(507, 165, '', 'FB-DOOR-L-002', 1, '2022-12-19', '2023-12-19', 0, 'DL-ESSL-EML600-2'),
(508, 166, '', 'FB-MOBILE-CH-001', 1, '2022-12-19', '2023-12-19', 0, 'M-CHARGE-MI'),
(509, 167, '', 'FB-MOBILE-MI-001', 1, '2022-12-19', '2023-12-19', 0, 'M-REDMI-9'),
(510, 168, '', 'FB-MOBILE-MAX-002', 1, '2022-12-19', '2023-12-19', 0, 'M-MICROMAX-412'),
(511, 169, '', 'FB-ROUTER-WIFI-001', 1, '2022-12-19', '2023-12-19', 0, 'ROUT-WIFI-A-RT-AX55'),
(512, 170, '', 'FB-ROUTER-WIFI-002', 1, '2022-12-19', '2023-12-19', 0, 'ROUT-D--DGS-1210-28'),
(513, 171, '', 'FB-ROUTER-WIFI-003', 1, '2022-12-19', '2023-12-19', 0, 'ROUT-D-DGS-1210-52'),
(514, 171, '', 'FB-RACK-2U-001', 1, '2022-12-19', '2023-12-19', 0, 'RACK-2U'),
(515, 173, '', 'FB-ROUTER-WIFI-005', 1, '2022-12-19', '2023-12-19', 0, 'ROUT-TP-UE300'),
(516, 173, '', 'FB-ROUTER-WIFI-004', 1, '2022-12-19', '2023-12-19', 0, 'ROUT-TP-UE300'),
(517, 174, '', 'FB-ROUTER-WIFI-006', 1, '2022-12-19', '2023-12-19', 0, 'ROUT-TP-UE300'),
(518, 175, '', 'FB-ROUTER-WIFI-007', 1, '2022-12-19', '2023-12-19', 0, 'ROUT-TP-AC600'),
(519, 176, '', 'FB-ROUTER-WIFI-008', 1, '2022-12-19', '2023-12-19', 0, 'ROUT-WIFI-A-RT-AX55'),
(520, 176, '', 'FB-ROUTER-WIFI-009', 1, '2022-12-19', '2023-12-19', 0, 'ROUT-WIFI-A-RT-AX55'),
(521, 177, '', 'FB-RACK-2U-002', 1, '2022-12-19', '2023-12-19', 0, 'RACK-D-2U'),
(522, 178, '', 'FB-ROUTER-WIFI-010', 1, '2022-12-19', '2023-12-19', 0, 'ROUT-D-DGS-1210-52'),
(523, 179, '', 'FB-RACK-2U-003', 1, '2022-12-19', '2023-12-19', 0, 'RACK-2U'),
(524, 179, '', 'FB-ROUTER-WIFI-011', 1, '2022-12-19', '2023-12-19', 0, 'ROUT-H-DS-7632NI-K2'),
(525, 180, '', 'FB-ROUTER-WIFI-012', 1, '2022-12-19', '2023-12-19', 0, 'ROUT-D-DGS-1210-5'),
(526, 181, '', 'FB-ROUTER-WIFI-013', 1, '2022-12-19', '2023-12-19', 0, 'ROUT-D-DGS-1210-52'),
(527, 182, '', 'FB-ROUTER-WIFI-014', 1, '2022-12-19', '2023-12-19', 0, 'ROUT-TP-WN823N'),
(528, 183, '', 'FB-SMART-TV-001', 1, '2022-12-19', '2023-12-19', 0, 'REALME-TV-32'),
(529, 74, '', 'FB-RAM-DDR4-039', 1, '2022-12-16', '2023-12-16', 0, 'RAM-DDR4-16GB'),
(530, 74, '', 'FB-SMPS-021', 1, '2022-12-16', '2023-12-16', 0, 'SMPS-FA-C3'),
(531, 74, '', 'FB-CPU-I5-018', 1, '2022-12-16', '2023-12-16', 0, 'CPU-I5-10400'),
(532, 74, '', 'FB-HDD-100', 1, '2022-12-16', '2023-12-16', 0, 'HDD-HDD-1TB'),
(533, 74, '', 'FB-MON-DELL-031', 1, '2022-12-16', '2023-12-16', 0, 'MON-S2421HN-24'),
(534, 74, '', 'FB-MTB-034', 1, '2022-12-16', '2023-12-16', 0, 'MTB-B56OM-DS3H-AC'),
(535, 74, '', 'FB-HDD-101', 1, '2022-12-16', '2023-12-16', 0, 'HDD-SSD-500GB'),
(536, 75, '', 'FB-RAM-DDR4-040', 1, '2022-12-16', '2023-12-16', 0, 'RAM-DDR4-16GB'),
(537, 75, '', 'FB-HDD-102', 1, '2022-12-16', '2023-12-16', 0, 'HDD-SSD-500GB'),
(538, 75, '', 'FB-HDD-103', 1, '2022-12-16', '2023-12-16', 0, 'HDD-SSD-500GB'),
(539, 75, '', 'FB-HDD-104', 1, '2022-12-16', '2023-12-16', 0, 'HDD-SSD-500GB'),
(540, 75, '', 'FB-HDD-105', 1, '2022-12-16', '2023-12-16', 0, 'HDD-SSD-500GB'),
(541, 75, '', 'FB-HDD-106', 1, '2022-12-16', '2023-12-16', 0, 'HDD-SSD-500GB'),
(542, 76, '', 'FB-HDD-107', 1, '2022-12-16', '2023-12-16', 0, 'HDD-SSD-500GB'),
(543, 77, '', 'FB-MON-LG-035', 1, '2022-12-16', '2023-12-16', 0, 'MON-22MP68VQ-22'),
(544, 78, '', 'FB-MON-LG-036', 1, '2022-12-16', '2023-12-16', 0, 'MON-22MP68VQ-22'),
(545, 78, '', 'FB-MTB-035', 1, '2022-12-16', '2023-12-16', 0, 'MTB-H110'),
(546, 79, '', 'FB-HEADPHONE-006', 1, '2022-12-16', '2023-12-16', 0, 'HEADPHONE-H5'),
(547, 79, '', 'FB-HEADPHONE-007', 1, '2022-12-16', '2023-12-16', 0, 'HEADPHONE-H5'),
(549, 80, '', 'FB-MTB-037', 1, '2022-12-16', '2023-12-16', 0, 'MON-22MP68VQ-22'),
(550, 80, '', 'FB-MTB-036', 1, '2022-12-16', '2023-12-16', 0, 'MTB- B560M-AE'),
(551, 80, '', 'FB-RAM-DDR4-041', 1, '2022-12-16', '2023-12-16', 0, 'RAM-DDR4-16GB'),
(552, 80, '', 'FB-CABINET-028', 1, '2022-12-16', '2023-12-16', 0, 'CAB-FING-SMPS'),
(553, 80, '', 'FB-HDD-108', 1, '2022-12-16', '2023-12-16', 0, 'HDD-SSD-500GB'),
(554, 81, '', 'FB-HDD-109', 1, '2022-12-16', '2023-12-16', 0, 'HDD-SSD-480GB'),
(555, 81, '', 'FB-HDD-110', 1, '2022-12-16', '2023-12-16', 0, 'HDD-SSD-480GB'),
(556, 81, '', 'FB-HDD-111', 1, '2022-12-16', '2023-12-16', 0, 'HDD-SSD-480GB'),
(557, 81, '', 'FB-HDD-112', 1, '2022-12-16', '2023-12-16', 0, 'HDD-SSD-480GB'),
(558, 81, '', 'FB-HDD-113', 1, '2022-12-16', '2023-12-16', 0, 'HDD-SSD-480GB'),
(559, 82, '', 'FB-HEADPHONE-009', 1, '2022-12-16', '2023-12-16', 0, 'HEADPHONE-H9'),
(560, 82, '', 'FB-HEADPHONE-010', 1, '2022-12-16', '2023-12-16', 0, 'HEADPHONE-H-340'),
(561, 83, '', 'FB-RAM-DDR4-042', 1, '2022-12-16', '2023-12-16', 0, 'RAM-DDR4-16GB'),
(562, 83, '', 'FB-RAM-DDR4-043', 1, '2022-12-16', '2023-12-16', 0, 'RAM-DDR4-16GB'),
(563, 83, '', 'FB-CPU-I5-019', 1, '2022-12-16', '2023-12-16', 0, 'CPU-I5-10400'),
(564, 83, '', 'FB-CPU-I5-020', 1, '2022-12-16', '2023-12-16', 0, 'CPU-I5-10400'),
(565, 83, '', 'FB-CABINET-029', 1, '2022-12-16', '2023-12-16', 0, 'CAB-FING-SMPS'),
(566, 83, '', 'FB-CABINET-030', 1, '2022-12-16', '2023-12-16', 0, 'CAB-FING-SMPS'),
(567, 83, '', 'FB-MTB-038', 1, '2022-12-16', '2023-12-16', 0, 'MTB-B460M-DS3H-V2'),
(568, 83, '', 'FB-MTB-039', 1, '2022-12-16', '2023-12-16', 0, 'MTB-B460M-DS3H-V2'),
(569, 83, '', 'FB-HDD-114', 1, '2022-12-16', '2023-12-16', 0, 'HDD-HDD-1TB'),
(570, 83, '', 'FB-HDD-115', 1, '2022-12-16', '2023-12-16', 0, 'HDD-HDD-1TB'),
(571, 83, '', 'FB-HDD-116', 1, '2022-12-16', '2023-12-16', 0, 'HDD-SSD-500GB'),
(572, 83, '', 'FB-HDD-117', 1, '2022-12-16', '2023-12-16', 0, 'HDD-SSD-500GB'),
(573, 84, '', 'FB-HDD-118', 1, '2022-12-16', '2023-12-16', 0, 'HDD-SSD-500GB'),
(574, 84, '', 'FB-RAM-DDR4-044', 1, '2022-12-16', '2023-12-16', 0, 'RAM-DDR4-8GB'),
(575, 84, '', 'FB-RAM-DDR4-045', 1, '2022-12-16', '2023-12-16', 0, 'RAM-DDR4-8GB'),
(576, 84, '', 'FB-CPU-I5-021', 1, '2022-12-16', '2023-12-16', 0, 'CPU-I5-10400'),
(577, 84, '', 'FB-CABINET-031', 1, '2022-12-16', '2023-12-16', 0, 'CAB-FING-SMPS'),
(578, 84, '', 'FB-MTB-040', 1, '2022-12-16', '2023-12-16', 0, 'MTB-B460M-DS3H-V2'),
(579, 84, '', 'FB-HDD-119', 1, '2022-12-16', '2023-12-16', 0, 'HDD-HDD-1TB'),
(580, 84, '', 'FB-MON-LG-034', 1, '2022-12-16', '2023-12-16', 0, 'MON-22MP68VQ-22'),
(581, 85, '', 'FB-MTB-045', 1, '2022-04-07', '2023-04-07', 0, 'MTB- B560M-AE'),
(583, 85, '', 'FB-HDD-120', 1, '2022-12-16', '2023-12-16', 0, 'HDD-500GB'),
(584, 85, '', 'FB-HDD-121', 1, '2022-12-16', '2023-12-16', 0, 'HDD-HDD-2TB'),
(585, 86, '', 'FB-SMPS-022', 1, '2022-12-16', '2023-12-16', 0, 'SMPS-S-H5'),
(586, 86, '', 'FB-HEADPHONE-011', 1, '2022-12-16', '2023-12-16', 0, 'HEADPHONE-G340'),
(587, 87, '', 'FB-HEADPHONE-012', 1, '2022-12-16', '2023-12-16', 0, 'HEADPHONE-H-111'),
(588, 87, '', 'FB-HEADPHONE-013', 1, '2022-12-16', '2023-12-16', 0, 'HEADPHONE-H-111'),
(589, 88, '', 'FB-HDD-122', 1, '2022-12-16', '2023-12-16', 0, 'HDD-SSD-500GB'),
(590, 89, '', 'FB-HDD-123', 1, '2022-12-16', '2023-12-16', 0, 'HDD-SSD-500GB'),
(591, 89, '', 'FB-RAM-DDR4-046', 1, '2022-12-16', '2023-12-16', 0, 'RAM-DDR4-16GB'),
(592, 89, '', 'FB-CPU-I5-022', 1, '2022-12-16', '2023-12-16', 0, 'CPU-I5-10400'),
(593, 89, '', 'FB-CPU-I5-023', 1, '2022-12-16', '2023-12-16', 0, 'CPU-I5-10400'),
(594, 89, '', 'FB-CABINET-032', 1, '2022-12-16', '2023-12-16', 0, 'CAB-FING-SMPS'),
(595, 89, '', 'FB-MTB-046', 1, '2022-12-16', '2023-12-16', 0, 'MTB-B460M-DS3H-V2'),
(596, 89, '', 'FB-MTB-047', 1, '2022-12-16', '2023-12-16', 0, 'MTB-B460M-DS3H-V2'),
(597, 89, '', 'FB-HDD-124', 1, '2022-12-16', '2023-12-16', 0, 'HDD-HDD-1TB'),
(598, 89, '', 'FB-HDD-125', 1, '2022-12-16', '2023-12-16', 0, 'HDD-HDD-1TB'),
(599, 90, '', 'FB-FOOTPEDAL-001', 1, '2022-12-16', '2023-12-16', 0, 'FOOTPEDAL-ODIN'),
(600, 91, '', 'FB-WEBCAM-004', 1, '2022-12-16', '2023-12-16', 0, 'ZEB-CRYSTAL-WEBCAM '),
(601, 92, '', 'FB-HEADPHONE-014', 1, '2022-12-16', '2023-12-16', 1, 'HEADPHONE-F-10'),
(602, 92, '', 'FB-HEADPHONE-015', 1, '2022-12-16', '2023-12-16', 0, 'HEADPHONE-F-10'),
(603, 92, '', 'FB-HEADPHONE-016', 1, '2022-12-16', '2023-12-16', 0, 'HEADPHONE-F-10'),
(604, 92, '', 'FB-HEADPHONE-017', 1, '2022-12-16', '2023-12-16', 0, 'HEADPHONE-F-10'),
(605, 92, '', 'FB-HEADPHONE-018', 1, '2022-12-16', '2023-12-16', 0, 'HEADPHONE-F-10'),
(606, 93, '', 'FB-MON-LG-032', 1, '2022-12-16', '2023-12-16', 0, 'MON-22MP68VQ-22'),
(607, 93, '', 'FB-MON-LG-033', 1, '2022-12-16', '2023-12-16', 0, 'MON-22MP68VQ-22'),
(608, 94, '', 'FB-HEADPHONE-019', 1, '2022-12-16', '2023-12-16', 0, 'HEADPHONE-H-340'),
(609, 95, '', 'FB-ADAP-USB-004', 1, '2022-12-16', '2023-12-16', 0, 'ADAP-USB-T3-VIBOTON'),
(610, 95, '', 'FB-HDD-126', 1, '2022-12-16', '2023-12-16', 0, 'HDD-SSD-1TB'),
(611, 95, '', 'FB-ADAP-USB-005', 1, '2022-12-16', '2023-12-16', 0, 'ADAP-USB-SATA'),
(612, 96, '', 'FB-HEADPHONE-020', 1, '2022-12-16', '2023-12-16', 0, 'HEADPHONE-D3'),
(613, 97, '', 'FB-HEADPHONE-021', 1, '2022-12-16', '2023-12-16', 1, 'HEADPHONE-F10'),
(614, 97, '', 'FB-HEADPHONE-022', 1, '2022-12-16', '2023-12-16', 0, 'HEADPHONE-F10'),
(615, 97, '', 'FB-HEADPHONE-023', 1, '2022-12-16', '2023-12-16', 0, 'HEADPHONE-F10'),
(616, 97, '', 'FB-HEADPHONE-024', 1, '2022-12-16', '2023-12-16', 0, 'HEADPHONE-F10'),
(617, 97, '', 'FB-HEADPHONE-025', 1, '2022-12-16', '2023-12-16', 0, 'HEADPHONE-F10'),
(618, 98, '', 'FB-HDD-127', 1, '2022-12-16', '2023-12-16', 0, 'HDD-HDD-1TB'),
(619, 98, '', 'FB-HDD-128', 1, '2022-12-16', '2023-12-16', 0, 'HDD-HDD-1TB'),
(620, 99, '', 'FB-MON-BENQ-037', 1, '2022-12-16', '2023-12-16', 0, 'MON-GW2480-T-24'),
(621, 99, '', 'FB-MON-BENQ-038', 1, '2022-12-16', '2023-12-16', 0, 'MON-GW2480-T-24'),
(622, 99, '', 'FB-RAM-DDR4-047', 1, '2022-12-16', '2023-12-16', 0, 'RAM-DDR4-8GB'),
(623, 99, '', 'FB-CPU-I3-011', 1, '2022-12-16', '2023-12-16', 0, 'CPU-I3-8100'),
(624, 99, '', 'FB-CABINET-034', 1, '2022-12-16', '2023-12-16', 0, 'CAB-IBALL'),
(625, 99, '', 'FB-MTB-048', 1, '2022-12-16', '2023-12-16', 0, 'MTB-B365M D3H'),
(626, 99, '', 'FB-RAM-DDR3-003', 1, '2022-12-16', '2023-12-16', 0, 'RAM-DDR3-8GB');
INSERT INTO `fa_grn_serial_no` (`id`, `grn_batch_id`, `sl_no`, `osl_no`, `warranty`, `from_date`, `to_date`, `status`, `stock_id`) VALUES
(627, 99, '', 'FB-RAM-DDR3-004', 1, '2022-12-16', '2023-12-16', 0, 'RAM-DDR3-8GB'),
(628, 99, '', 'FB-HDD-129', 1, '2022-12-16', '2023-12-16', 0, 'HDD-SSD-250GB'),
(629, 184, '', 'LOGITECH-KEYB-001', 1, '2023-01-30', '2024-01-30', 1, 'LOGITECH-KEYB'),
(630, 184, '', 'LOGITECH-KEYB-002', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(631, 184, '', 'LOGITECH-KEYB-003', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(632, 184, '', 'LOGITECH-KEYB-004', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(633, 184, '', 'LOGITECH-KEYB-005', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(634, 184, '', 'LOGITECH-KEYB-006', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(635, 184, '', 'LOGITECH-KEYB-007', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(636, 184, '', 'LOGITECH-KEYB-008', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(637, 184, '', 'LOGITECH-KEYB-009', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(638, 184, '', 'LOGITECH-KEYB-010', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(639, 184, '', 'LOGITECH-KEYB-011', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(640, 184, '', 'LOGITECH-KEYB-012', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(641, 184, '', 'LOGITECH-KEYB-013', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(642, 184, '', 'LOGITECH-KEYB-014', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(643, 184, '', 'LOGITECH-KEYB-015', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(644, 184, '', 'LOGITECH-KEYB-016', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(645, 184, '', 'LOGITECH-KEYB-017', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(646, 184, '', 'LOGITECH-KEYB-018', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(647, 184, '', 'LOGITECH-KEYB-019', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(648, 184, '', 'LOGITECH-KEYB-020', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(649, 184, '', 'LOGITECH-KEYB-021', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(650, 184, '', 'LOGITECH-KEYB-022', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(651, 184, '', 'LOGITECH-KEYB-023', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(652, 184, '', 'LOGITECH-KEYB-024', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(653, 184, '', 'LOGITECH-KEYB-025', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(654, 184, '', 'LOGITECH-KEYB-026', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(655, 184, '', 'LOGITECH-KEYB-027', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(656, 184, '', 'LOGITECH-KEYB-028', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(657, 184, '', 'LOGITECH-KEYB-029', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(658, 184, '', 'LOGITECH-KEYB-030', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(659, 184, '', 'LOGITECH-KEYB-031', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(660, 184, '', 'LOGITECH-KEYB-032', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(661, 184, '', 'LOGITECH-KEYB-033', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(662, 184, '', 'LOGITECH-KEYB-034', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(663, 184, '', 'LOGITECH-KEYB-035', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(664, 184, '', 'LOGITECH-KEYB-037', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(665, 184, '', 'LOGITECH-KEYB-038', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(666, 184, '', 'LOGITECH-KEYB-039', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(667, 184, '', 'LOGITECH-KEYB-040', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(668, 184, '', 'LOGITECH-KEYB-041', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(669, 184, '', 'LOGITECH-KEYB-042', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(670, 184, '', 'LOGITECH-KEYB-043', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(671, 184, '', 'LOGITECH-KEYB-044', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(672, 184, '', 'LOGITECH-KEYB-045', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(673, 184, '', 'LOGITECH-KEYB-046', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(674, 184, '', 'LOGITECH-KEYB-047', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(675, 184, '', 'LOGITECH-KEYB-048', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(676, 184, '', 'LOGITECH-KEYB-049', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(677, 184, '', 'LOGITECH-KEYB-050', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(678, 184, '', 'LOGITECH-KEYB-051', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(679, 184, '', 'LOGITECH-KEYB-052', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(680, 184, '', 'LOGITECH-KEYB-053', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(681, 184, '', 'LOGITECH-KEYB-054', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(682, 184, '', 'LOGITECH-KEYB-055', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(683, 184, '', 'LOGITECH-KEYB-056', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(684, 184, '', 'LOGITECH-KEYB-057', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(685, 184, '', 'LOGITECH-KEYB-058', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(686, 184, '', 'LOGITECH-KEYB-059', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(687, 184, '', 'LOGITECH-KEYB-060', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(688, 184, '', 'LOGITECH-KEYB-061', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(689, 184, '', 'LOGITECH-KEYB-062', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(690, 184, '', 'LOGITECH-KEYB-063', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(691, 184, '', 'LOGITECH-KEYB-064', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(692, 184, '', 'LOGITECH-KEYB-065', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(693, 184, '', 'LOGITECH-KEYB-066', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(694, 184, '', 'LOGITECH-KEYB-067', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(695, 184, '', 'LOGITECH-KEYB-068', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(696, 184, '', 'LOGITECH-KEYB-069', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(697, 184, '', 'LOGITECH-KEYB-070', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(698, 184, '', 'LOGITECH-KEYB-071', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(699, 184, '', 'LOGITECH-KEYB-072', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(700, 184, '', 'LOGITECH-KEYB-073', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(701, 184, '', 'LOGITECH-KEYB-074', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(702, 184, '', 'LOGITECH-KEYB-075', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(703, 184, '', 'LOGITECH-KEYB-076', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(704, 184, '', 'LOGITECH-KEYB-077', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(705, 184, '', 'LOGITECH-KEYB-078', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(706, 184, '', 'LOGITECH-KEYB-079', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(707, 184, '', 'LOGITECH-KEYB-080', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(708, 184, '', 'LOGITECH-KEYB-081', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(709, 184, '', 'LOGITECH-KEYB-082', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(710, 184, '', 'LOGITECH-KEYB-083', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(711, 184, '', 'LOGITECH-KEYB-084', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(712, 184, '', 'LOGITECH-KEYB-085', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(713, 184, '', 'LOGITECH-KEYB-086', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(714, 184, '', 'LOGITECH-KEYB-087', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(715, 184, '', 'LOGITECH-KEYB-088', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(716, 184, '', 'LOGITECH-KEYB-089', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(717, 184, '', 'LOGITECH-KEYB-090', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(718, 184, '', 'LOGITECH-KEYB-091', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(719, 184, '', 'LOGITECH-KEYB-092', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(720, 184, '', 'LOGITECH-KEYB-093', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(721, 184, '', 'LOGITECH-KEYB-036', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(722, 184, '', 'LOGITECH-KEYB-094', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(723, 184, '', 'LOGITECH-KEYB-095', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(724, 184, '', 'LOGITECH-KEYB-096', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(725, 184, '', 'LOGITECH-KEYB-097', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(726, 184, '', 'LOGITECH-KEYB-098', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(727, 184, '', 'LOGITECH-KEYB-099', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(728, 184, '', 'LOGITECH-KEYB-100', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-KEYB'),
(729, 184, '', 'LOGITECH-MOU-001', 1, '2023-01-30', '2024-01-30', 1, 'LOGITECH-MOUSE'),
(730, 184, '', 'LOGITECH-MOU-095', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(731, 184, '', 'LOGITECH-MOU-100', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(732, 184, '', 'LOGITECH-MOU-099', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(733, 184, '', 'LOGITECH-MOU-098', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(734, 184, '', 'LOGITECH-MOU-097', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(735, 184, '', 'LOGITECH-MOU-096', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(736, 184, '', 'LOGITECH-MOU-094', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(737, 184, '', 'LOGITECH-MOU-093', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(738, 184, '', 'LOGITECH-MOU-092', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(739, 184, '', 'LOGITECH-MOU-091', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(740, 184, '', 'LOGITECH-MOU-090', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(741, 184, '', 'LOGITECH-MOU-089', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(742, 184, '', 'LOGITECH-MOU-088', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(743, 184, '', 'LOGITECH-MOU-087', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(744, 184, '', 'LOGITECH-MOU-086', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(745, 184, '', 'LOGITECH-MOU-085', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(746, 184, '', 'LOGITECH-MOU-084', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(747, 184, '', 'LOGITECH-MOU-083', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(748, 184, '', 'LOGITECH-MOU-082', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(749, 184, '', 'LOGITECH-MOU-081', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(750, 184, '', 'LOGITECH-MOU-080', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(751, 184, '', 'LOGITECH-MOU-079', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(752, 184, '', 'LOGITECH-MOU-078', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(753, 184, '', 'LOGITECH-MOU-077', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(754, 184, '', 'LOGITECH-MOU-076', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(755, 184, '', 'LOGITECH-MOU-075', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(756, 184, '', 'LOGITECH-MOU-074', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(757, 184, '', 'LOGITECH-MOU-073', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(758, 184, '', 'LOGITECH-MOU-072', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(759, 184, '', 'LOGITECH-MOU-071', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(760, 184, '', 'LOGITECH-MOU-070', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(761, 184, '', 'LOGITECH-MOU-069', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(762, 184, '', 'LOGITECH-MOU-068', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(763, 184, '', 'LOGITECH-MOU-067', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(764, 184, '', 'LOGITECH-MOU-066', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(765, 184, '', 'LOGITECH-MOU-065', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(766, 184, '', 'LOGITECH-MOU-064', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(767, 184, '', 'LOGITECH-MOU-063', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(768, 184, '', 'LOGITECH-MOU-062', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(769, 184, '', 'LOGITECH-MOU-061', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(770, 184, '', 'LOGITECH-MOU-060', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(771, 184, '', 'LOGITECH-MOU-059', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(772, 184, '', 'LOGITECH-MOU-058', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(773, 184, '', 'LOGITECH-MOU-057', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(774, 184, '', 'LOGITECH-MOU-056', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(775, 184, '', 'LOGITECH-MOU-055', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(776, 184, '', 'LOGITECH-MOU-054', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(777, 184, '', 'LOGITECH-MOU-053', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(778, 184, '', 'LOGITECH-MOU-052', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(779, 184, '', 'LOGITECH-MOU-051', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(780, 184, '', 'LOGITECH-MOU-050', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(781, 184, '', 'LOGITECH-MOU-049', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(782, 184, '', 'LOGITECH-MOU-048', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(783, 184, '', 'LOGITECH-MOU-047', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(784, 184, '', 'LOGITECH-MOU-046', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(785, 184, '', 'LOGITECH-MOU-045', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(786, 184, '', 'LOGITECH-MOU-044', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(787, 184, '', 'LOGITECH-MOU-043', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(788, 184, '', 'LOGITECH-MOU-042', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(789, 184, '', 'LOGITECH-MOU-041', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(790, 184, '', 'LOGITECH-MOU-040', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(791, 184, '', 'LOGITECH-MOU-039', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(792, 184, '', 'LOGITECH-MOU-038', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(793, 184, '', 'LOGITECH-MOU-037', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(794, 184, '', 'LOGITECH-MOU-036', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(795, 184, '', 'LOGITECH-MOU-035', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(796, 184, '', 'LOGITECH-MOU-034', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(797, 184, '', 'LOGITECH-MOU-033', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(798, 184, '', 'LOGITECH-MOU-032', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(799, 184, '', 'LOGITECH-MOU-031', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(800, 184, '', 'LOGITECH-MOU-030', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(801, 184, '', 'LOGITECH-MOU-029', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(802, 184, '', 'LOGITECH-MOU-028', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(803, 184, '', 'LOGITECH-MOU-027', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(804, 184, '', 'LOGITECH-MOU-026', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(805, 184, '', 'LOGITECH-MOU-025', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(806, 184, '', 'LOGITECH-MOU-024', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(807, 184, '', 'LOGITECH-MOU-023', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(808, 184, '', 'LOGITECH-MOU-022', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(809, 184, '', 'LOGITECH-MOU-021', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(810, 184, '', 'LOGITECH-MOU-020', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(811, 184, '', 'LOGITECH-MOU-019', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(812, 184, '', 'LOGITECH-MOU-018', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(813, 184, '', 'LOGITECH-MOU-017', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(814, 184, '', 'LOGITECH-MOU-016', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(815, 184, '', 'LOGITECH-MOU-015', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(816, 184, '', 'LOGITECH-MOU-014', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(817, 184, '', 'LOGITECH-MOU-013', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(818, 184, '', 'LOGITECH-MOU-012', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(819, 184, '', 'LOGITECH-MOU-011', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(820, 184, '', 'LOGITECH-MOU-010', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(821, 184, '', 'LOGITECH-MOU-009', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(822, 184, '', 'LOGITECH-MOU-008', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(823, 184, '', 'LOGITECH-MOU-007', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(824, 184, '', 'LOGITECH-MOU-006', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(825, 184, '', 'LOGITECH-MOU-005', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(826, 184, '', 'LOGITECH-MOU-004', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(827, 184, '', 'LOGITECH-MOU-003', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(828, 184, '', 'LOGITECH-MOU-002', 1, '2023-01-30', '2024-01-30', 0, 'LOGITECH-MOUSE'),
(829, 185, '', 'FB-CPUM-005', 1, '2023-01-31', '2024-01-31', 0, 'CPUMI3'),
(830, 185, '', 'FB-CPUM-006', 1, '2023-01-31', '2024-01-31', 0, 'CPUMI3'),
(831, 185, '', 'FB-CPUM-007', 1, '2023-01-31', '2024-01-31', 0, 'CPUMI3'),
(832, 185, '', 'FB-CPUM-008', 1, '2023-01-31', '2024-01-31', 0, 'CPUMI3'),
(833, 186, '', 'FB-CPUM-001', 1, '2023-02-01', '2024-02-01', 0, 'CPUI3-3210'),
(834, 186, '', 'FB-CPUM-002', 1, '2023-02-01', '2024-02-01', 0, 'CPUI3-3210'),
(835, 186, '', 'FB-CPUM-003', 1, '2023-02-01', '2024-02-01', 0, 'CPUI3-3210'),
(836, 186, '', 'FB-CPUM-004', 1, '2023-02-01', '2024-02-01', 0, 'CPUI3-3210'),
(837, 187, '', 'FB-RAM-DDR4-12-001', 1, '2023-02-01', '2024-02-01', 0, 'RAM-DDR4-12GB'),
(838, 187, '', 'FB-RAM-DDR4-12-002', 1, '2023-02-01', '2024-02-01', 0, 'RAM-DDR4-12GB'),
(839, 187, '', 'FB-RAM-DDR4-12-003', 1, '2023-02-01', '2024-02-01', 0, 'RAM-DDR4-12GB'),
(840, 187, '', 'FB-RAM-DDR4-12-004', 1, '2023-02-01', '2024-02-01', 0, 'RAM-DDR4-12GB'),
(841, 187, '', 'FB-RAM-DDR4-12-005', 1, '2023-02-01', '2024-02-01', 0, 'RAM-DDR4-12GB'),
(842, 187, '', 'FB-RAM-DDR4-12-006', 1, '2023-02-01', '2024-02-01', 0, 'RAM-DDR4-12GB'),
(843, 187, '', 'FB-RAM-DDR4-12-007', 1, '2023-02-01', '2024-02-01', 0, 'RAM-DDR4-12GB'),
(844, 187, '', 'FB-RAM-DDR4-12-008', 1, '2023-02-01', '2024-02-01', 0, 'RAM-DDR4-12GB'),
(845, 187, '', 'FB-RAM-DDR4-12-009', 1, '2023-02-01', '2024-02-01', 0, 'RAM-DDR4-12GB'),
(846, 187, '', 'FB-RAM-DDR4-12-010', 1, '2023-02-01', '2024-02-01', 0, 'RAM-DDR4-12GB'),
(847, 188, '', 'FB-CPU-010', 1, '2023-02-01', '2023-02-01', 0, 'FB-CPUMI3'),
(848, 188, '', 'FB-CPU-017', 1, '2023-02-01', '2023-02-01', 1, 'FB-CPUMI3'),
(849, 188, '', 'FB-CPU-019', 1, '2023-02-01', '2023-02-01', 0, 'FB-CPUMI3'),
(850, 188, '', 'FB-CPU-025', 1, '2023-02-01', '2023-02-01', 0, 'FB-CPUMI3'),
(851, 190, '', 'FB-CPUI3-3210-8GB-11', 1, '2023-02-02', '2024-02-02', 0, 'CPUI3-3210-8GB'),
(852, 190, '', 'FB-CPUI3-3210-8GB-12', 1, '2023-02-02', '2024-02-02', 0, 'CPUI3-3210-8GB'),
(853, 190, '', 'FB-CPUI3-3210-8GB-10', 1, '2023-02-02', '2024-02-02', 0, 'CPUI3-3210-8GB'),
(854, 190, '', 'FB-CPUI3-3210-8GB-09', 1, '2023-02-02', '2024-02-02', 0, 'CPUI3-3210-8GB'),
(855, 190, '', 'FB-CPUI3-3210-8GB-08', 1, '2023-02-02', '2024-02-02', 0, 'CPUI3-3210-8GB'),
(856, 190, '', 'FB-CPUI3-3210-8GB-07', 1, '2023-02-02', '2024-02-02', 0, 'CPUI3-3210-8GB'),
(857, 190, '', 'FB-CPUI3-3210-8GB-06', 1, '2023-02-02', '2024-02-02', 0, 'CPUI3-3210-8GB'),
(858, 190, '', 'FB-CPUI3-3210-8GB-05', 1, '2023-02-02', '2024-02-02', 0, 'CPUI3-3210-8GB'),
(859, 190, '', 'FB-CPUI3-3210-8GB-04', 1, '2023-02-02', '2024-02-02', 0, 'CPUI3-3210-8GB'),
(860, 190, '', 'FB-CPUI3-3210-8GB-03', 1, '2023-02-02', '2024-02-02', 0, 'CPUI3-3210-8GB'),
(861, 190, '', 'FB-CPUI3-3210-8GB-02', 1, '2023-02-02', '2024-02-02', 0, 'CPUI3-3210-8GB'),
(862, 190, '', 'FB-CPUI3-3210-8GB-01', 1, '2023-02-02', '2024-02-02', 0, 'CPUI3-3210-8GB'),
(863, 191, '', 'FB-RAM-DDR4-048', 1, '2023-02-02', '2024-02-02', 0, 'RAM-DDR4-8GB'),
(864, 191, '', 'FB-RAM-DDR4-049', 1, '2023-02-02', '2024-02-02', 0, 'RAM-DDR4-8GB'),
(865, 191, '', 'FB-RAM-DDR4-050', 1, '2023-02-02', '2024-02-02', 0, 'RAM-DDR4-8GB'),
(866, 191, '', 'FB-RAM-DDR4-051', 1, '2023-02-02', '2024-02-02', 0, 'RAM-DDR4-8GB'),
(867, 191, '', 'FB-RAM-DDR4-052', 1, '2023-02-02', '2024-02-02', 0, 'RAM-DDR4-8GB'),
(868, 191, '', 'FB-RAM-DDR4-053', 1, '2023-02-02', '2024-02-02', 0, 'RAM-DDR4-8GB'),
(869, 191, '', 'FB-RAM-DDR4-054', 1, '2023-02-02', '2024-02-02', 0, 'RAM-DDR4-8GB'),
(870, 191, '', 'FB-RAM-DDR4-055', 1, '2023-02-02', '2024-02-02', 0, 'RAM-DDR4-8GB'),
(871, 191, '', 'FB-RAM-DDR4-056', 1, '2023-02-02', '2024-02-02', 0, 'RAM-DDR4-8GB'),
(872, 191, '', 'FB-RAM-DDR4-057', 1, '2023-02-02', '2024-02-02', 0, 'RAM-DDR4-8GB'),
(873, 191, '', 'FB-RAM-DDR4-058', 1, '2023-02-02', '2024-02-02', 0, 'RAM-DDR4-8GB'),
(874, 191, '', 'FB-RAM-DDR4-059', 1, '2023-02-02', '2024-02-02', 0, 'RAM-DDR4-8GB'),
(875, 191, '', 'FB-RAM-DDR4-060', 1, '2023-02-02', '2024-02-02', 0, 'RAM-DDR4-8GB'),
(876, 191, '', 'FB-RAM-DDR4-061', 1, '2023-02-02', '2024-02-02', 0, 'RAM-DDR4-8GB'),
(877, 191, '', 'FB-RAM-DDR4-062', 1, '2023-02-02', '2024-02-02', 0, 'RAM-DDR4-8GB'),
(878, 191, '', 'FB-RAM-DDR4-063', 1, '2023-02-02', '2024-02-02', 0, 'RAM-DDR4-8GB'),
(879, 191, '', 'FB-RAM-DDR4-064', 1, '2023-02-02', '2024-02-02', 0, 'RAM-DDR4-8GB'),
(880, 191, '', 'FB-RAM-DDR4-065', 1, '2023-02-02', '2024-02-02', 0, 'RAM-DDR4-8GB'),
(881, 191, '', 'FB-RAM-DDR4-066', 1, '2023-02-02', '2024-02-02', 0, 'RAM-DDR4-8GB'),
(882, 191, '', 'FB-RAM-DDR4-067', 1, '2023-02-02', '2024-02-02', 0, 'RAM-DDR4-8GB'),
(883, 189, '', 'CPUI3-3210-16GB-001', 1, '2023-02-01', '2024-02-01', 0, 'CPUI3-3210-16GB'),
(884, 189, '', 'CPUI3-3210-16GB-002', 1, '2023-02-01', '2024-02-01', 0, 'CPUI3-3210-16GB'),
(885, 193, '', 'CPUi3-6098P-3.60GH-01', 1, '2023-02-03', '2024-02-03', 0, 'CPUi3-6098P-3.60GH'),
(886, 193, '', 'CPUi3-6098P-3.60GH-02', 1, '2023-02-03', '2024-02-03', 0, 'CPUi3-6098P-3.60GH'),
(887, 193, '', 'CPUi3-6098P-3.60GH-03', 1, '2023-02-03', '2024-02-03', 0, 'CPUi3-6098P-3.60GH'),
(888, 193, '', '	CPUi3-6098P-3.60GH-04', 1, '2023-02-03', '2024-02-03', 0, 'CPUi3-6098P-3.60GH'),
(889, 193, '', 'CPUi3-6098P-3.60GH-05', 1, '2023-02-03', '2024-02-03', 0, 'CPUi3-6098P-3.60GH'),
(890, 193, '', 'CPUi3-6098P-3.60GH-06', 1, '2023-02-03', '2024-02-03', 0, 'CPUi3-6098P-3.60GH'),
(891, 193, '', 'CPUi3-6098P-3.60GH-07', 1, '2023-02-03', '2024-02-03', 0, 'CPUi3-6098P-3.60GH'),
(892, 193, '', 'CPUi3-6098P-3.60GH-08', 1, '2023-02-03', '2024-02-03', 0, 'CPUi3-6098P-3.60GH'),
(893, 193, '', 'CPUi3-6098P-3.60GH-09', 1, '2023-02-03', '2024-02-03', 0, 'CPUi3-6098P-3.60GH'),
(894, 193, '', 'CPUi3-6098P-3.60GH-10', 1, '2023-02-03', '2024-02-03', 0, 'CPUi3-6098P-3.60GH'),
(895, 193, '', 'CPUi3-6098P-3.60GH-11', 1, '2023-02-03', '2024-02-03', 0, 'CPUi3-6098P-3.60GH'),
(896, 193, '', 'CPUi3-6098P-3.60GH-12', 1, '2023-02-03', '2024-02-03', 0, 'CPUi3-6098P-3.60GH'),
(897, 194, '', 'CPU-I3-6098P-8GB-01', 1, '2023-02-03', '2024-02-03', 0, 'CPU-I3-6098P-8GB'),
(898, 194, '', 'CPU-I3-6098P-8GB-02', 1, '2023-02-03', '2024-02-03', 0, 'CPU-I3-6098P-8GB'),
(899, 194, '', 'CPU-I3-6098P-8GB-03', 1, '2023-02-03', '2024-02-03', 0, 'CPU-I3-6098P-8GB'),
(900, 194, '', 'CPU-I3-6098P-8GB-04', 1, '2023-02-03', '2024-02-03', 0, 'CPU-I3-6098P-8GB'),
(901, 194, '', 'CPU-I3-6098P-8GB-05', 1, '2023-02-03', '2024-02-03', 0, 'CPU-I3-6098P-8GB'),
(902, 194, '', 'CPU-I3-6098P-8GB-06', 1, '2023-02-03', '2024-02-03', 0, 'CPU-I3-6098P-8GB'),
(903, 194, '', 'CPU-I3-6098P-8GB-07', 1, '2023-02-03', '2024-02-03', 0, 'CPU-I3-6098P-8GB'),
(904, 194, '', 'CPU-I3-6098P-8GB-08', 1, '2023-02-03', '2024-02-03', 0, 'CPU-I3-6098P-8GB'),
(905, 194, '', 'CPU-I3-6098P-8GB-09', 1, '2023-02-03', '2024-02-03', 0, 'CPU-I3-6098P-8GB'),
(906, 194, '', 'CPU-I3-6098P-8GB-10', 1, '2023-02-03', '2024-02-03', 0, 'CPU-I3-6098P-8GB'),
(907, 194, '', 'CPU-I3-6098P-8GB-11', 1, '2023-02-03', '2024-02-03', 0, 'CPU-I3-6098P-8GB'),
(908, 195, '', 'CPUI36098P-001', 1, '2023-02-03', '2024-02-03', 0, 'CPUI36098P'),
(909, 196, '', 'HDD-SSD-240GBM-01', 1, '2023-02-03', '2024-02-03', 0, 'HDD-SSD-240GBM'),
(910, 210, '', 'HDD-SSD-250GB-001', 1, '2023-02-06', '2024-02-06', 0, 'HDD-SSD-250GB'),
(911, 210, '', 'HDD-SSD-250GB-002', 1, '2023-02-06', '2024-02-06', 0, 'HDD-SSD-250GB'),
(912, 210, '', 'HDD-SSD-250GB-003', 1, '2023-02-06', '2024-02-06', 0, 'HDD-SSD-250GB'),
(913, 210, '', 'HDD-SSD-250GB-005', 1, '2023-02-06', '2024-02-06', 0, 'HDD-SSD-250GB'),
(914, 210, '', 'HDD-SSD-250GB-006', 1, '2023-02-06', '2024-02-06', 0, 'HDD-SSD-250GB'),
(915, 210, '', 'HDD-SSD-250GB-007', 1, '2023-02-06', '2024-02-06', 0, 'HDD-SSD-250GB'),
(916, 210, '', 'HDD-SSD-250GB-008', 1, '2023-02-06', '2024-02-06', 0, 'HDD-SSD-250GB'),
(917, 210, '', 'HDD-SSD-250GB-009', 1, '2023-02-06', '2024-02-06', 0, 'HDD-SSD-250GB'),
(918, 210, '', 'HDD-SSD-250GB-004', 1, '2023-02-06', '2024-02-06', 0, 'HDD-SSD-250GB'),
(919, 210, '', 'HDD-SSD-250GB-010', 1, '2023-02-06', '2024-02-06', 0, 'HDD-SSD-250GB'),
(920, 214, '', 'RAM-32GB-002', 1, '2023-02-06', '2024-02-06', 0, 'RAM-32GB'),
(921, 214, '', 'RAM-32GB-001', 1, '2023-02-06', '2024-02-06', 0, 'RAM-32GB'),
(922, 220, '', 'HDD-4TB-001', 1, '2023-02-06', '2024-02-06', 0, 'HDD-4TB'),
(923, 220, '', 'HDD-4TB-002', 1, '2023-02-06', '2024-02-06', 0, 'HDD-4TB'),
(924, 220, '', 'HDD-4TB-003', 1, '2023-02-06', '2024-02-06', 0, 'HDD-4TB'),
(925, 220, '', 'HDD-4TB-004', 1, '2023-02-06', '2024-02-06', 0, 'HDD-4TB'),
(926, 220, '', 'HDD-4TB-005', 1, '2023-02-06', '2024-02-06', 0, 'HDD-4TB'),
(927, 221, '', 'FB-RAM-DDR4-068', 1, '2023-02-06', '2024-02-06', 0, 'RAM-DDR4-16GB'),
(928, 221, '', 'FB-RAM-DDR4-069', 1, '2023-02-06', '2024-02-06', 0, 'RAM-DDR4-16GB'),
(929, 221, '', 'FB-RAM-DDR4-070', 1, '2023-02-06', '2024-02-06', 0, 'RAM-DDR4-16GB'),
(930, 221, '', 'FB-RAM-DDR4-071', 1, '2023-02-06', '2024-02-06', 0, 'RAM-DDR4-16GB'),
(931, 221, '', 'FB-RAM-DDR4-072', 1, '2023-02-06', '2024-02-06', 0, 'RAM-DDR4-16GB'),
(932, 221, '', 'FB-RAM-DDR4-073', 1, '2023-02-06', '2024-02-06', 0, 'RAM-DDR4-16GB'),
(933, 221, '', 'FB-RAM-DDR4-074', 1, '2023-02-06', '2024-02-06', 0, 'RAM-DDR4-16GB'),
(934, 221, '', 'FB-RAM-DDR4-075', 1, '2023-02-06', '2024-02-06', 0, 'RAM-DDR4-16GB'),
(935, 221, '', 'FB-RAM-DDR4-076', 1, '2023-02-06', '2024-02-06', 0, 'RAM-DDR4-16GB'),
(936, 221, '', 'FB-RAM-DDR4-077', 1, '2023-02-06', '2024-02-06', 0, 'RAM-DDR4-16GB'),
(937, 226, '', 'RAM-32GB-003', 1, '2023-02-07', '2024-02-07', 0, 'RAM-32GB'),
(938, 226, '', 'RAM-32GB-004', 1, '2023-02-07', '2024-02-07', 0, 'RAM-32GB'),
(939, 226, '', 'RAM-32GB-005', 1, '2023-02-07', '2024-02-07', 0, 'RAM-32GB'),
(940, 226, '', 'RAM-32GB-006', 1, '2023-02-07', '2024-02-07', 0, 'RAM-32GB'),
(941, 226, '', 'RAM-32GB-007', 1, '2023-02-07', '2024-02-07', 0, 'RAM-32GB'),
(942, 229, '', 'FB-HDD-SSD-1TB-001', 1, '2023-02-07', '2024-02-07', 0, 'HDD-SSD-1TB'),
(943, 229, '', 'FB-HDD-SSD-1TB-003', 1, '2023-02-07', '2024-02-07', 0, 'HDD-SSD-1TB'),
(944, 229, '', 'FB-HDD-SSD-1TB-002', 1, '2023-02-07', '2024-02-07', 0, 'HDD-SSD-1TB'),
(945, 229, '', 'FB-HDD-SSD-1TB-004', 1, '2023-02-07', '2024-02-07', 0, 'HDD-SSD-1TB'),
(946, 229, '', 'FB-HDD-SSD-1TB-005', 1, '2023-02-07', '2024-02-07', 0, 'HDD-SSD-1TB'),
(947, 192, '', 'FB-CPU-036', 0, '2023-02-02', '2023-02-02', 0, 'M-CPUI3-3210-8GB'),
(948, 192, '', 'FB-CPU-002', 0, '2023-02-02', '2023-02-02', 0, 'M-CPUI3-3210-8GB'),
(949, 192, '', 'FB-CPU-003', 0, '2023-02-02', '2023-02-02', 0, 'M-CPUI3-3210-8GB'),
(950, 192, '', 'FB-CPU-013', 0, '2023-02-02', '2023-02-02', 0, 'M-CPUI3-3210-8GB'),
(951, 192, '', 'FB-CPU-015', 0, '2023-02-02', '2023-02-02', 0, 'M-CPUI3-3210-8GB'),
(952, 192, '', 'FB-CPU-020', 0, '2023-02-02', '2023-02-02', 0, 'M-CPUI3-3210-8GB'),
(953, 192, '', 'FB-CPU-031', 0, '2023-02-02', '2023-02-02', 0, 'M-CPUI3-3210-8GB'),
(954, 192, '', 'FB-CPU-034', 0, '2023-02-02', '2023-02-02', 0, 'M-CPUI3-3210-8GB'),
(955, 192, '', 'FB-CPU-039', 0, '2023-02-02', '2023-02-02', 0, 'M-CPUI3-3210-8GB'),
(956, 192, '', 'FB-CPU-008', 0, '2023-02-02', '2023-02-02', 0, 'M-CPUI3-3210-8GB'),
(957, 192, '', 'FB-CPU-009', 0, '2023-02-02', '2023-02-02', 0, 'M-CPUI3-3210-8GB'),
(958, 192, '', 'FB-CPU-021', 0, '2023-02-02', '2023-02-02', 0, 'M-CPUI3-3210-8GB'),
(959, 255, '', 'FB-CPU-016', 0, '2023-02-07', '2023-02-07', 0, 'M-CPUI5-10400-8Gb'),
(960, 256, '', 'FB-CPU-001', 0, '2023-02-07', '2023-02-07', 0, 'M-CPUI52310-2.90'),
(961, 257, '', 'FB-CPU-040', 0, '2023-02-07', '2023-02-07', 0, 'CPUI5-11400-2.60-16GB'),
(962, 259, '', 'FB-CPU-044', 0, '2023-02-07', '2023-02-07', 0, 'M-CPUI3-3210-3.2-12'),
(963, 260, '', 'FB-CPU-045', 0, '2023-02-07', '2023-02-07', 0, 'M-CPUI5-3210-2.20-8GB'),
(964, 261, '', 'FB-CPU-046', 0, '2023-02-07', '2023-02-07', 0, 'M-CPUI5-8400-2.8-16GB'),
(965, 262, '', 'FB-CPU-048', 0, '2023-02-07', '2023-02-07', 0, 'M-CPUI510400-2.90GHz'),
(966, 262, '', 'FB-CPU-049', 0, '2023-02-07', '2023-02-07', 0, 'M-CPUI510400-2.90GHz'),
(967, 263, '', 'FB-CPU-050', 0, '2023-02-07', '2023-02-07', 0, 'M-CPUI3-10400-16G'),
(968, 264, '', 'FB-CPU-051', 0, '2023-02-07', '2023-02-07', 0, 'M-CPUI3-6098P-3.60-16G'),
(969, 265, '', 'FB-CPU-030', 0, '2023-02-07', '2023-02-07', 0, 'M-CPUI3-3210'),
(970, 265, '', 'FB-CPU-029', 0, '2023-02-07', '2023-02-07', 0, 'M-CPUI3-3210'),
(971, 265, '', 'FB-CPU-027', 0, '2023-02-07', '2023-02-07', 0, 'M-CPUI3-3210'),
(972, 265, '', 'FB-CPU-018', 0, '2023-02-07', '2023-02-07', 0, 'M-CPUI3-3210'),
(973, 266, '', 'FB-CPU-053', 0, '2023-02-07', '2023-02-07', 0, 'M-CPUI5-10400-500GB-16GB'),
(974, 266, '', 'FB-CPU-052', 0, '2023-02-07', '2023-02-07', 0, 'M-CPUI5-10400-500GB-16GB'),
(975, 267, '', 'FB-CPU-054', 0, '2023-02-07', '2023-02-07', 0, 'M-CPU-I7-32GB'),
(976, 268, '', 'FB-CPU-055', 0, '2023-02-07', '2023-02-07', 0, 'M-CPU-I5-10100-16gb'),
(977, 268, '', 'FB-CPU-057', 0, '2023-02-07', '2023-02-07', 0, 'M-CPU-I5-10100-16gb'),
(978, 268, '', 'FB-CPU-058', 0, '2023-02-07', '2023-02-07', 0, 'M-CPU-I5-10100-16gb'),
(979, 268, '', 'FB-CPU-061', 0, '2023-02-07', '2023-02-07', 0, 'M-CPU-I5-10100-16gb'),
(980, 268, '', 'FB-CPU-062', 0, '2023-02-07', '2023-02-07', 0, 'M-CPU-I5-10100-16gb'),
(981, 268, '', 'FB-CPU-067', 0, '2023-02-07', '2023-02-07', 0, 'M-CPU-I5-10100-16gb'),
(982, 269, '', 'FB-CPU-056', 0, '2023-02-07', '2023-02-07', 0, 'M-CPUI7-8700K-32GB'),
(983, 270, '', 'FB-CPU-059', 0, '2023-02-07', '2023-02-07', 0, 'CPUI5-8400-2.8GH-16GB'),
(984, 272, '', 'FB-CPU-063', 1, '2023-02-07', '2024-02-07', 0, 'M-CPUI3-3210-16GB-SSD500GB'),
(985, 274, '', 'FB-CPU-065', 1, '2023-02-07', '2024-02-07', 0, 'M-CPUI3-3.2-2120-12GB'),
(986, 275, '', 'FB-CPU-066', 1, '2023-02-07', '2024-02-07', 0, 'M-CPUI3-3210-1TBHDD'),
(987, 277, '', 'FB-CPU-070', 1, '2023-02-07', '2024-02-07', 0, 'M-CPUI3-2120-16GB-500GB'),
(988, 278, '', 'FB-LAP-073', 1, '2023-02-07', '2024-02-07', 0, 'M-CPUI7-1165G7-16GB-500GB'),
(989, 279, '', 'FB-LAP-072', 1, '2023-02-07', '2024-02-07', 0, 'M-CPUI7-1260P-16GB-1TB'),
(990, 279, '', 'FB-LAP-074', 1, '2023-02-07', '2024-02-07', 0, 'M-CPUI7-1260P-16GB-1TB'),
(991, 279, '', 'FB-LAP-075', 1, '2023-02-07', '2024-02-07', 0, 'M-CPUI7-1260P-16GB-1TB'),
(992, 279, '', 'FB-LAP-079', 1, '2023-02-07', '2024-02-07', 0, 'M-CPUI7-1260P-16GB-1TB'),
(993, 280, '', 'FB-CPU-076', 1, '2023-02-07', '2024-02-07', 0, 'M-CPUI5-9400F-16GB-500GB-1TB'),
(994, 281, '', 'FB-CPU-077', 1, '2023-02-07', '2024-02-07', 0, 'M-CPUI3-8100-3.6G-16GB-250GB'),
(995, 282, '', 'FB-CPU-078', 1, '2023-02-07', '2024-02-07', 0, 'M-CPI3-3210-16GB-500GB '),
(996, 283, '', 'FB-CPU-080', 1, '2023-02-07', '2024-02-07', 0, 'M-CPUI510400-2.9G-16G-500GB-1TB'),
(997, 284, '', 'FB-CPU-081', 1, '2023-02-07', '2024-02-07', 0, 'M-CPUI3-6089-3.6-16G-250GB-1TB'),
(998, 285, '', 'FB-CPU-082', 1, '2023-02-07', '2024-02-07', 0, 'M-CPUI5-8400-2.8G-12GB-500GB-1TB'),
(999, 285, '', 'FB-CPU-083', 1, '2023-02-07', '2024-02-07', 0, 'M-CPUI5-8400-2.8G-12GB-500GB-1TB'),
(1000, 287, '', 'FB-CPU-084\r\n', 1, '2023-02-07', '2024-02-07', 0, 'M-CPUI3-10105-3.7G-16GB-500GB-1tb'),
(1001, 288, '', 'FB-CPU-085', 1, '2023-02-07', '2024-02-07', 0, 'M-CPUI5-11400-2.6-16GB-250GB'),
(1002, 289, '', 'FB-CPU-087\r\n', 1, '2023-02-07', '2024-02-07', 0, 'M-CPUI5-2400-3.1G-16G-500GB-SSD-1TB-HDD'),
(1003, 290, '', 'FB-CPU-088', 0, '2023-02-07', '2023-02-07', 0, 'M-CPUI5-10400-2.9-16GB-SSD-500GB'),
(1004, 290, '', 'FB-CPU-089', 0, '2023-02-07', '2023-02-07', 0, 'M-CPUI5-10400-2.9-16GB-SSD-500GB'),
(1005, 291, '', 'FB-CPU-090', 0, '2023-02-07', '2023-02-07', 0, 'M-CPUI3-8100-3.6-16GB-500-SSD'),
(1006, 292, '', 'FB-CPU-091', 0, '2023-02-07', '2023-02-07', 0, 'M-CPUI5-11400-2.6-16Gb-SSD-500GB'),
(1007, 293, '', 'FB-CPU-092', 0, '2023-02-07', '2023-02-07', 0, 'M-CPUI5-10400-2.9-16GB-SSD500Gb-'),
(1008, 294, '', 'FB-CPU-093', 0, '2023-02-07', '2023-02-07', 0, 'M-CPUI5-11400-2.6-16GB-SSD-250GB-1TB'),
(1009, 294, '', 'FB-CPU-094', 0, '2023-02-07', '2023-02-07', 0, 'M-CPUI5-11400-2.6-16GB-SSD-250GB-1TB'),
(1010, 295, '', 'FB-CPU-097', 0, '2023-02-07', '2023-02-07', 0, 'M-CPUI3-6098P-3.6-16GB-500GB'),
(1011, 296, '', 'FB-CPU-101', 0, '2023-02-07', '2023-02-07', 0, 'M-CPUI3-10100-3.6-8GB-SSD-240GB'),
(1012, 297, '', 'FB-CPU-038', 0, '2023-02-07', '2023-02-07', 0, 'CPUI3-6098P'),
(1013, 298, '', 'FB-CPU-105', 0, '2023-02-07', '2023-02-07', 0, 'M-CPUI3-3210-3.2G-16GB-SSD-250GB'),
(1014, 299, '', 'FB-CPU-005', 0, '2023-02-07', '2023-02-07', 0, 'M-CPUI5-10400-2.9-16GB-500GB-SSD'),
(1015, 300, '', 'FB-CPU-012', 0, '2023-02-07', '2023-02-07', 0, 'CPUI3-6098P8GB'),
(1016, 300, '', 'FB-CPU-014', 0, '2023-02-07', '2023-02-07', 0, 'CPUI3-6098P8GB'),
(1017, 300, '', 'FB-CPU-022', 0, '2023-02-07', '2023-02-07', 0, 'CPUI3-6098P8GB'),
(1018, 300, '', 'FB-CPU-028', 0, '2023-02-07', '2023-02-07', 0, 'CPUI3-6098P8GB'),
(1019, 300, '', 'FB-CPU-033', 0, '2023-02-07', '2023-02-07', 0, 'CPUI3-6098P8GB'),
(1020, 300, '', 'FB-CPU-037', 0, '2023-02-07', '2023-02-07', 0, 'CPUI3-6098P8GB'),
(1021, 300, '', 'FB-CPU-004', 0, '2023-02-07', '2023-02-07', 0, 'CPUI3-6098P8GB'),
(1022, 300, '', 'FB-CPU-023', 0, '2023-02-07', '2023-02-07', 0, 'CPUI3-6098P8GB'),
(1023, 300, '', 'FB-CPU-026', 0, '2023-02-07', '2023-02-07', 0, 'CPUI3-6098P8GB'),
(1024, 300, '', 'FB-CPU-035', 0, '2023-02-07', '2023-02-07', 0, 'CPUI3-6098P8GB'),
(1025, 301, '', 'FB-CPU-006', 0, '2023-02-07', '2023-02-07', 0, 'CPUI3-6098P-240GB'),
(1026, 302, '', 'FB-CPU-024', 0, '2023-02-07', '2023-02-07', 0, 'M-CPU-I3-8100'),
(1027, 303, '', 'FB-CPU-041', 0, '2023-02-07', '2023-02-07', 1, 'M-CPUI5-10400'),
(1028, 258, '', 'FB-CPU-042\r\n', 1, '2022-04-07', '2023-04-07', 0, 'CPUI5-9400F 2.9 GH 16 GB'),
(1029, 271, '', 'FB-CPU-060\r\n', 1, '2022-12-16', '2023-12-16', 0, 'M-CPU- i5-11400-2.60GH 16GB '),
(1030, 271, '', 'FB-CPU-068\r\n', 1, '2022-12-16', '2023-12-16', 0, 'M-CPU- i5-11400-2.60GH 16GB '),
(1031, 273, '', 'FB-CPU-064\r\n', 1, '2022-12-16', '2023-12-16', 0, 'M-CPUI3-8100-3.6 16GB'),
(1032, 276, '', 'FB-CPU-069', 1, '2022-12-16', '2023-12-16', 0, 'M-CPUI5-8400-2.8GH 32GB 2TB'),
(1033, 286, '', 'FB-CPU-032', 0, '2023-02-07', '2023-02-07', 0, 'M-CPUI3-16GB'),
(1034, 286, '', 'FB-CPU-007', 0, '2023-02-07', '2023-02-07', 0, 'M-CPUI3-16GB'),
(1037, 1, '', 'AC-STAR-EMP-SPLIT-01', 1, '2022-04-07', '2023-04-07', 0, 'AC-STAR-EMP-SPLIT'),
(1038, 252, '', 'FB-LAP-104', 1, '2023-02-07', '2024-02-07', 0, 'Cpu-i3-2.4G-4gb-LAP'),
(1039, 251, '', 'FB-LAP-103', 1, '2023-02-07', '2024-02-07', 0, 'CPU-I5-1035G1-1.0-L'),
(1040, 250, '', 'FB-LAP-102', 1, '2023-02-07', '2024-02-07', 0, 'CPU-I3-6100U-2.30-L'),
(1041, 249, '', 'FB-LAP-100', 1, '2023-02-07', '2024-02-07', 0, 'CPU-I3-2330M-2.20-L'),
(1042, 247, '', 'FB-LAP-099', 1, '2023-02-07', '2024-02-07', 0, 'CPU-I3-4005U-1.70GH'),
(1043, 228, '', 'FB-LAP-079', 1, '2023-02-07', '2024-02-07', 0, 'CPUI7-1260P-RAM-16G'),
(1044, 228, '', 'FB-LAP-075', 1, '2023-02-07', '2024-02-07', 0, 'CPUI7-1260P-RAM-16G'),
(1045, 228, '', 'FB-LAP-074', 1, '2023-02-07', '2024-02-07', 0, 'CPUI7-1260P-RAM-16G'),
(1046, 228, '', 'FB-LAP-072', 1, '2023-02-07', '2024-02-07', 0, 'CPUI7-1260P-RAM-16G'),
(1047, 304, '', 'FB-LAP-043', 1, '2023-02-08', '2024-02-08', 0, 'LAP-HP-I5-2.2-8GB'),
(1048, 305, '', 'FB-LAP-011', 1, '2023-02-08', '2024-02-08', 0, 'LAP-DELL-I3-8GB-1TB'),
(1049, 306, '', 'FB-LAP-073', 1, '2023-02-08', '2024-02-08', 0, 'LAP-I7-16GB-500GB'),
(1050, 307, '', 'FB-LAP-106', 1, '2023-02-08', '2024-02-08', 0, 'LAP-I5-16GB-SSD-500G');

-- --------------------------------------------------------

--
-- Table structure for table `fa_group`
--

CREATE TABLE `fa_group` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `assinged` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fa_group`
--

INSERT INTO `fa_group` (`id`, `name`, `description`, `assinged`) VALUES
(1, 'CPU-I3-8GB-500GBb', 'cpu i3 8gb ram 500gb hdd', 0),
(2, 'CPU-I3-8GB-500GB-1', 'CPU-I3-8GB-500GB DEVELOPMENT', 1),
(3, 'CPU-I5-8GB-1TB', 'CPU-I5-8GB-1TB', 0);

-- --------------------------------------------------------

--
-- Table structure for table `fa_groups`
--

CREATE TABLE `fa_groups` (
  `id` smallint(6) UNSIGNED NOT NULL,
  `description` varchar(60) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `inactive` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fa_groups`
--

INSERT INTO `fa_groups` (`id`, `description`, `inactive`) VALUES
(1, 'Small', 0),
(2, 'Medium', 0),
(3, 'Large', 0);

-- --------------------------------------------------------

--
-- Table structure for table `fa_guest_registration`
--

CREATE TABLE `fa_guest_registration` (
  `guest_id` int(11) NOT NULL,
  `guest_name` varchar(300) DEFAULT NULL,
  `fathers_name` varchar(300) DEFAULT NULL,
  `gender` int(11) DEFAULT NULL,
  `marital_status` int(11) DEFAULT NULL,
  `id_proof` varchar(300) DEFAULT NULL,
  `porpose` varchar(300) DEFAULT NULL,
  `line1` varchar(300) DEFAULT NULL,
  `line2` varchar(300) DEFAULT NULL,
  `city` varchar(300) DEFAULT NULL,
  `country` int(11) DEFAULT NULL,
  `state` int(11) DEFAULT NULL,
  `pin_code` int(11) DEFAULT NULL,
  `email_id` varchar(300) DEFAULT NULL,
  `contact_number` int(11) NOT NULL,
  `registraion_date` datetime NOT NULL,
  `filename` varchar(255) NOT NULL,
  `unique_name` varchar(11) NOT NULL,
  `inactive` tinyint(11) NOT NULL DEFAULT 0,
  `deleted` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `fa_help_desk_category`
--

CREATE TABLE `fa_help_desk_category` (
  `desk_cat_id` int(11) NOT NULL,
  `category_name` varchar(80) NOT NULL,
  `inactive` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fa_help_desk_category`
--

INSERT INTO `fa_help_desk_category` (`desk_cat_id`, `category_name`, `inactive`) VALUES
(1, 'Employee', 0),
(2, 'Student', 0);

-- --------------------------------------------------------

--
-- Table structure for table `fa_hold_book`
--

CREATE TABLE `fa_hold_book` (
  `id` int(11) NOT NULL,
  `ref_id` varchar(50) NOT NULL,
  `hold_book` varchar(100) NOT NULL,
  `no_book` int(10) NOT NULL,
  `no_day` int(10) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fa_hold_book`
--

INSERT INTO `fa_hold_book` (`id`, `ref_id`, `hold_book`, `no_book`, `no_day`, `status`) VALUES
(39, 'No-001', 'Staff', 5, 7, 0),
(40, 'No-002', 'Student', 2, 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `fa_item_codes`
--

CREATE TABLE `fa_item_codes` (
  `id` int(11) UNSIGNED NOT NULL,
  `item_code` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `stock_id` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `category_id` smallint(6) UNSIGNED NOT NULL,
  `quantity` double NOT NULL DEFAULT 1,
  `is_foreign` tinyint(1) NOT NULL DEFAULT 0,
  `inactive` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fa_item_codes`
--

INSERT INTO `fa_item_codes` (`id`, `item_code`, `stock_id`, `description`, `category_id`, `quantity`, `is_foreign`, `inactive`) VALUES
(1, 'ITc00', 'ITc00', 'computers', 3, 1, 0, 0),
(2, 'cpu', 'cpu', 'central processing unit', 1, 1, 0, 0),
(4, 'cpu250rI3/1', 'cpu250rI3/1', 'cpu250rI3', 1, 1, 0, 0),
(5, 'cpu250rI3/2', 'cpu250rI3/2', 'cpu250rI3', 1, 1, 0, 0),
(6, 'HDD250', 'HDD250', 'Hard Disk 250', 1, 1, 0, 0),
(7, 'RAM8GB', 'RAM8GB', 'RAM 8 GB ', 1, 1, 0, 0),
(8, 'IntelProcessor', 'IntelProcessor', 'Intel Processor 5Gz', 1, 1, 0, 0),
(9, 'MotherBoard', 'MotherBoard', 'Mother Board', 1, 1, 0, 0),
(10, 'LAPTOPFINE', 'LAPTOPFINE', 'LAPTOP Finesse', 3, 1, 0, 0),
(11, 'TableFan', 'TableFan', 'Table Fan', 4, 1, 0, 0),
(12, 'Blade', 'Blade', 'Fan Blade', 1, 1, 0, 0),
(13, 'Rotar', 'Rotar', 'Fan Rotar', 1, 1, 0, 0),
(14, 'Car', 'Car', 'MARTCAR', 4, 1, 0, 0),
(15, 'DISENGINE', 'DISENGINE', 'Diesel Engine', 1, 1, 0, 0),
(16, 'VEHBATTERY', 'VEHBATTERY', 'Vehicle Battery', 1, 1, 0, 0),
(17, 'VEHCHASSIS', 'VEHCHASSIS', 'Vehicle Chassis', 1, 1, 0, 0),
(18, 'WTANK', 'WTANK', 'Water Tank', 1, 1, 0, 0),
(19, 'WFILTER', 'WFILTER', 'Water Filter', 1, 1, 0, 0),
(20, 'MChair', 'MChair', 'Moving Chair', 1, 1, 0, 0),
(21, 'testr', 'testr', 'raushan', 4, 1, 0, 0),
(22, 'CP110', 'CP110', 'Computer Cpu', 3, 1, 0, 0),
(0, 'head001', 'head001', 'head light ', 16, 1, 0, 0),
(0, 'cpui3', 'cpui3', 'cpu i3', 7, 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `fa_item_tax_types`
--

CREATE TABLE `fa_item_tax_types` (
  `id` int(11) NOT NULL,
  `name` varchar(60) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `exempt` tinyint(1) NOT NULL DEFAULT 0,
  `inactive` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fa_item_tax_types`
--

INSERT INTO `fa_item_tax_types` (`id`, `name`, `exempt`, `inactive`) VALUES
(1, 'Regular', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `fa_item_tax_type_exemptions`
--

CREATE TABLE `fa_item_tax_type_exemptions` (
  `item_tax_type_id` int(11) NOT NULL DEFAULT 0,
  `tax_type_id` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fa_item_units`
--

CREATE TABLE `fa_item_units` (
  `abbr` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `decimals` tinyint(2) NOT NULL,
  `inactive` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fa_item_units`
--

INSERT INTO `fa_item_units` (`abbr`, `name`, `decimals`, `inactive`) VALUES
('box', 'Box', 0, 0),
('ctn', 'Carton', 0, 0),
('hrs', 'Hours', 1, 0),
('kg.', 'Kilogram', 0, 0),
('ltr', 'Litre', 0, 0),
('pc.', 'Piece', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `fa_journal`
--

CREATE TABLE `fa_journal` (
  `type` smallint(6) NOT NULL DEFAULT 0,
  `trans_no` int(11) NOT NULL DEFAULT 0,
  `tran_date` date DEFAULT '0000-00-00',
  `reference` varchar(60) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `source_ref` varchar(60) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `event_date` date DEFAULT '0000-00-00',
  `doc_date` date NOT NULL DEFAULT '0000-00-00',
  `currency` char(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `amount` double NOT NULL DEFAULT 0,
  `rate` double NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fa_kv_allocation_request`
--

CREATE TABLE `fa_kv_allocation_request` (
  `allocate_id` int(11) NOT NULL,
  `dept_id` int(11) NOT NULL,
  `desig_group_id` int(11) NOT NULL,
  `desig_id` int(11) NOT NULL,
  `employees_id` varchar(50) NOT NULL,
  `request_date` date NOT NULL,
  `type_leave` int(11) NOT NULL,
  `reason` text NOT NULL,
  `today_date` varchar(20) NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `no_of_days` float NOT NULL,
  `upload_file` text NOT NULL,
  `filesize` varchar(60) NOT NULL,
  `filetype` varchar(60) NOT NULL,
  `unique_name` varchar(60) NOT NULL,
  `no_of_days_approved` int(11) NOT NULL,
  `approved_from_date` date NOT NULL,
  `approved_to_date` date NOT NULL,
  `comments` text NOT NULL,
  `status` varchar(100) NOT NULL DEFAULT '1',
  `updated_date` date NOT NULL,
  `inactive` int(11) NOT NULL,
  `cancel_status` tinyint(4) NOT NULL,
  `cal_year` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fa_kv_allocation_request`
--

INSERT INTO `fa_kv_allocation_request` (`allocate_id`, `dept_id`, `desig_group_id`, `desig_id`, `employees_id`, `request_date`, `type_leave`, `reason`, `today_date`, `from_date`, `to_date`, `no_of_days`, `upload_file`, `filesize`, `filetype`, `unique_name`, `no_of_days_approved`, `approved_from_date`, `approved_to_date`, `comments`, `status`, `updated_date`, `inactive`, `cancel_status`, `cal_year`) VALUES
(3, 1, 1, 11, 'EMP-F-005', '2019-04-11', 1, '', '11-04-2019', '2019-04-11', '2019-04-11', 1, '', '0', '', '', 1, '2019-04-11', '2019-04-11', '', '5', '0000-00-00', 0, 1, 2019),
(4, 1, 1, 1, 'EMP-S-002', '2019-04-11', 1, '', '11-04-2019', '2019-04-12', '2019-04-12', 1, '', '0', '', '', 1, '2019-04-12', '2019-04-12', '', '2', '0000-00-00', 0, 1, 2019),
(6, 1, 3, 5, 'EMP-F-001', '2019-07-23', 11, '', '23-07-2019', '2019-01-14', '2019-01-14', 1, '', '0', '', '', 1, '2019-01-14', '2019-01-14', '', '2', '0000-00-00', 0, 0, 2019),
(7, 1, 3, 5, 'EMP-F-001', '2019-07-23', 11, 'personal work', '23-07-2019', '2019-03-04', '2019-03-04', 1, '', '0', '', '', 1, '2019-03-04', '2019-03-04', '', '2', '0000-00-00', 0, 0, 2019),
(8, 1, 3, 5, 'EMP-F-001', '2019-07-23', 11, '', '23-07-2019', '2019-04-19', '2019-04-19', 1, '', '0', '', '', 1, '2019-04-19', '2019-04-19', '', '2', '0000-00-00', 0, 0, 2019),
(9, 1, 3, 5, 'EMP-F-001', '2019-07-23', 11, '', '23-07-2019', '2019-06-04', '2019-06-04', 1, '', '0', '', '', 1, '2019-06-04', '2019-06-04', '', '2', '0000-00-00', 0, 0, 2019),
(10, 1, 2, 3, 'EMP-F-004', '2021-04-05', 1, '', '05-04-2021', '2021-04-05', '2021-04-05', 1, '', '', '', '', 1, '2021-04-05', '2021-04-05', '', '2', '0000-00-00', 0, 0, 2021);

-- --------------------------------------------------------

--
-- Table structure for table `fa_kv_allowances`
--

CREATE TABLE `fa_kv_allowances` (
  `id` int(10) NOT NULL,
  `description` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `percentage` float NOT NULL,
  `basic` int(11) NOT NULL DEFAULT 0,
  `Tax` int(2) NOT NULL DEFAULT 0,
  `inactive` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fa_kv_allowances`
--

INSERT INTO `fa_kv_allowances` (`id`, `description`, `type`, `value`, `percentage`, `basic`, `Tax`, `inactive`) VALUES
(0, 'testing data', 'Earnings', 'Amount', 0, 0, 0, 1),
(1, 'Basic Pay', 'Earnings', 'Percentage', 40, 1, 0, 0),
(2, 'Academic Grade Pay/Grade Pay', 'Earnings', 'Amount', 0, 0, 0, 1),
(3, 'DA', 'Earnings', 'Percentage', 40, 0, 0, 1),
(4, 'HRA', 'Earnings', 'Percentage', 40, 0, 0, 0),
(5, 'test', 'Earnings', 'Amount', 0, 0, 0, 1),
(6, 'SAS', 'Deductions', 'Percentage', 8.33, 0, 0, 1),
(8, 'Conveyance ', 'Earnings', 'Amount', 0, 0, 0, 1),
(10, 'Prof. TAX', 'Deductions', 'Amount', 0, 0, 0, 0),
(12, 'PF', 'Deductions', 'Percentage', 12, 0, 0, 0),
(13, 'Leave encashment', 'Tax-E', 'Amount', 0, 0, 1, 0),
(14, 'Perks - Free House', 'Tax-E', 'Amount', 0, 0, 1, 0),
(15, 'Other Perks', 'Tax-E', 'Amount', 0, 0, 1, 0),
(16, 'Tax on Employment u/s 16', 'Tax-E', 'Amount', 0, 0, 1, 0),
(17, 'Entertainment allowance u/s 16', 'Tax-E', 'Amount', 0, 0, 1, 0),
(18, 'Interest on NSC', 'Tax-E', 'Amount', 0, 0, 1, 0),
(19, 'Interest on Housing Loan (Negative)', 'Tax-E', 'Amount', 0, 0, 1, 0),
(20, 'Interest on Deposit (Bank/PO)', 'Tax-E', 'Amount', 0, 0, 1, 0),
(21, 'Income from House Property', 'Tax-E', 'Amount', 0, 0, 1, 0),
(22, 'Statutory Provident Fund', 'Tax-E', 'Amount', 0, 0, 1, 0),
(23, 'Public PF', 'Tax-E', 'Amount', 0, 0, 1, 0),
(24, 'LIC Direct', 'Tax-E', 'Amount', 0, 0, 1, 0),
(25, 'NSC', 'Tax-E', 'Amount', 0, 0, 1, 0),
(26, 'Int. on NSC', 'Tax-E', 'Amount', 0, 0, 1, 0),
(27, 'Infrastructure Bonds', 'Tax-E', 'Amount', 0, 0, 1, 0),
(28, 'Children\'s Education', 'Tax-E', 'Amount', 0, 0, 1, 0),
(29, 'Pension U/S 80 CCC (Jeevan Suraksha)', 'Tax-E', 'Amount', 0, 0, 1, 0),
(30, 'Ded. U/S 80 D (Medi-Claim)', 'Tax-E', 'Amount', 0, 0, 1, 0),
(31, 'Ded. U/S 80 DD (Handicapped-Dependant)', 'Tax-E', 'Amount', 0, 0, 1, 0),
(32, 'Ded. U/S 80DD B (Expenses on medical treatment on certain deseases for self or dependent)', 'Tax-E', 'Amount', 0, 0, 1, 0),
(33, 'Ded. U/S 80 G (Charitable contribution)', 'Tax-E', 'Amount', 0, 0, 1, 0),
(34, 'Ded. U/S 80 E  (Payment of intrest towards loan taken for higher studies for individual, spouce, children)', 'Tax-E', 'Amount', 0, 0, 1, 0),
(35, 'Rent Paid', 'Tax-E', 'Amount', 0, 0, 1, 0),
(36, 'ULIP/ LIC Dhanraksha/ LIC Home/ Mutual Fund/UTI/CTD/NSS', 'Tax-E', 'Amount', 0, 0, 1, 0),
(37, 'Equity Linked Savings/Other Insurance/RD/FD', 'Tax-E', 'Amount', 0, 0, 1, 0),
(38, 'Repayment of housing Loan', 'Tax-E', 'Amount', 0, 0, 1, 0),
(39, 'CTC', 'Earnings', 'Amount', 0, 0, 0, 0),
(40, 'Food Coupon', 'Earnings', 'Amount', 0, 0, 0, 0),
(41, 'Employer&#039;s ESI', 'Earnings', 'Amount', 0, 0, 0, 0),
(43, 'Employer&#039;s ESI', 'Deductions', 'Amount', 0, 0, 0, 0),
(44, 'Salary Advance', 'Earnings', 'Amount', 0, 0, 0, 0),
(45, 'Medical', 'Earnings', 'Amount', 0, 0, 0, 1),
(46, 'Incentive', 'Earnings', 'Amount', 0, 0, 0, 0),
(47, 'Special Allowance', 'Earnings', 'Amount', 0, 0, 0, 0),
(48, 'ESI(Employee Cont.)', 'Deductions', 'Amount', 0, 0, 0, 1),
(49, 'Employee ESI', 'Deductions', 'Amount', 0, 0, 0, 0),
(50, 'Medical', 'Deductions', 'Amount', 0, 0, 0, 1),
(51, 'Food Coupon', 'Deductions', 'Amount', 0, 0, 0, 0),
(52, 'Employer&#039;s PF ', 'Earnings', 'Percentage', 12, 0, 0, 0),
(53, 'test', 'Earnings', 'Amount', 0, 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `fa_kv_comp_request`
--

CREATE TABLE `fa_kv_comp_request` (
  `allocate_id` int(11) NOT NULL,
  `dept_id` int(11) NOT NULL,
  `desig_group_id` int(11) NOT NULL,
  `desig_id` int(11) NOT NULL,
  `employees_id` varchar(50) NOT NULL,
  `request_date` date NOT NULL,
  `type_leave` int(11) NOT NULL,
  `reason` text NOT NULL,
  `today_date` varchar(20) NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `no_of_days` float NOT NULL,
  `upload_file` text NOT NULL,
  `filesize` varchar(60) NOT NULL,
  `filetype` varchar(60) NOT NULL,
  `unique_name` varchar(60) NOT NULL,
  `no_of_days_approved` int(11) NOT NULL,
  `approved_from_date` date NOT NULL,
  `approved_to_date` date NOT NULL,
  `comments` text NOT NULL,
  `status` varchar(100) NOT NULL DEFAULT '1',
  `updated_date` date NOT NULL,
  `inactive` int(11) NOT NULL,
  `cancel_status` tinyint(4) NOT NULL,
  `cal_year` int(11) NOT NULL,
  `working_hours` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `fa_kv_countries`
--

CREATE TABLE `fa_kv_countries` (
  `id` int(11) NOT NULL,
  `countries_name` varchar(128) COLLATE utf8_bin NOT NULL,
  `countries_iso_code_2` varchar(2) COLLATE utf8_bin NOT NULL,
  `countries_iso_code_3` varchar(3) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `fa_kv_countries`
--

INSERT INTO `fa_kv_countries` (`id`, `countries_name`, `countries_iso_code_2`, `countries_iso_code_3`) VALUES
(1, 'Afghanistan', 'AF', 'AFG'),
(2, 'Albania', 'AL', 'ALB'),
(3, 'Algeria', 'DZ', 'DZA'),
(4, 'American Samoa', 'AS', 'ASM'),
(5, 'Andorra', 'AD', 'AND'),
(6, 'Angola', 'AO', 'AGO'),
(7, 'Anguilla', 'AI', 'AIA'),
(8, 'Antarctica', 'AQ', 'ATA'),
(9, 'Antigua and Barbuda', 'AG', 'ATG'),
(10, 'Argentina', 'AR', 'ARG'),
(11, 'Armenia', 'AM', 'ARM'),
(12, 'Aruba', 'AW', 'ABW'),
(13, 'Australia', 'AU', 'AUS'),
(14, 'Austria', 'AT', 'AUT'),
(15, 'Azerbaijan', 'AZ', 'AZE'),
(16, 'Bahamas', 'BS', 'BHS'),
(17, 'Bahrain', 'BH', 'BHR'),
(18, 'Bangladesh', 'BD', 'BGD'),
(19, 'Barbados', 'BB', 'BRB'),
(20, 'Belarus', 'BY', 'BLR'),
(21, 'Belgium', 'BE', 'BEL'),
(22, 'Belize', 'BZ', 'BLZ'),
(23, 'Benin', 'BJ', 'BEN'),
(24, 'Bermuda', 'BM', 'BMU'),
(25, 'Bhutan', 'BT', 'BTN'),
(26, 'Bolivia', 'BO', 'BOL'),
(27, 'Bosnia and Herzegowina', 'BA', 'BIH'),
(28, 'Botswana', 'BW', 'BWA'),
(29, 'Bouvet Island', 'BV', 'BVT'),
(30, 'Brazil', 'BR', 'BRA'),
(31, 'British Indian Ocean Territory', 'IO', 'IOT'),
(32, 'Brunei Darussalam', 'BN', 'BRN'),
(33, 'Bulgaria', 'BG', 'BGR'),
(34, 'Burkina Faso', 'BF', 'BFA'),
(35, 'Burundi', 'BI', 'BDI'),
(36, 'Cambodia', 'KH', 'KHM'),
(37, 'Cameroon', 'CM', 'CMR'),
(38, 'Canada', 'CA', 'CAN'),
(39, 'Cape Verde', 'CV', 'CPV'),
(40, 'Cayman Islands', 'KY', 'CYM'),
(41, 'Central African Republic', 'CF', 'CAF'),
(42, 'Chad', 'TD', 'TCD'),
(43, 'Chile', 'CL', 'CHL'),
(44, 'China', 'CN', 'CHN'),
(45, 'Christmas Island', 'CX', 'CXR'),
(46, 'Cocos (Keeling) Islands', 'CC', 'CCK'),
(47, 'Colombia', 'CO', 'COL'),
(48, 'Comoros', 'KM', 'COM'),
(49, 'Congo', 'CG', 'COG'),
(50, 'Cook Islands', 'CK', 'COK'),
(51, 'Costa Rica', 'CR', 'CRI'),
(52, 'Cote D\'Ivoire', 'CI', 'CIV'),
(53, 'Croatia', 'HR', 'HRV'),
(54, 'Cuba', 'CU', 'CUB'),
(55, 'Cyprus', 'CY', 'CYP'),
(56, 'Czech Republic', 'CZ', 'CZE'),
(57, 'Denmark', 'DK', 'DNK'),
(58, 'Djibouti', 'DJ', 'DJI'),
(59, 'Dominica', 'DM', 'DMA'),
(60, 'Dominican Republic', 'DO', 'DOM'),
(61, 'East Timor', 'TP', 'TMP'),
(62, 'Ecuador', 'EC', 'ECU'),
(63, 'Egypt', 'EG', 'EGY'),
(64, 'El Salvador', 'SV', 'SLV'),
(65, 'Equatorial Guinea', 'GQ', 'GNQ'),
(66, 'Eritrea', 'ER', 'ERI'),
(67, 'Estonia', 'EE', 'EST'),
(68, 'Ethiopia', 'ET', 'ETH'),
(69, 'Falkland Islands (Malvinas)', 'FK', 'FLK'),
(70, 'Faroe Islands', 'FO', 'FRO'),
(71, 'Fiji', 'FJ', 'FJI'),
(72, 'Finland', 'FI', 'FIN'),
(73, 'France', 'FR', 'FRA'),
(74, 'France, Metropolitan', 'FX', 'FXX'),
(75, 'French Guiana', 'GF', 'GUF'),
(76, 'French Polynesia', 'PF', 'PYF'),
(77, 'French Southern Territories', 'TF', 'ATF'),
(78, 'Gabon', 'GA', 'GAB'),
(79, 'Gambia', 'GM', 'GMB'),
(80, 'Georgia', 'GE', 'GEO'),
(81, 'Germany', 'DE', 'DEU'),
(82, 'Ghana', 'GH', 'GHA'),
(83, 'Gibraltar', 'GI', 'GIB'),
(84, 'Greece', 'GR', 'GRC'),
(85, 'Greenland', 'GL', 'GRL'),
(86, 'Grenada', 'GD', 'GRD'),
(87, 'Guadeloupe', 'GP', 'GLP'),
(88, 'Guam', 'GU', 'GUM'),
(89, 'Guatemala', 'GT', 'GTM'),
(90, 'Guinea', 'GN', 'GIN'),
(91, 'Guinea-bissau', 'GW', 'GNB'),
(92, 'Guyana', 'GY', 'GUY'),
(93, 'Haiti', 'HT', 'HTI'),
(94, 'Heard and Mc Donald Islands', 'HM', 'HMD'),
(95, 'Honduras', 'HN', 'HND'),
(96, 'Hong Kong', 'HK', 'HKG'),
(97, 'Hungary', 'HU', 'HUN'),
(98, 'Iceland', 'IS', 'ISL'),
(99, 'India', 'IN', 'IND'),
(100, 'Indonesia', 'ID', 'IDN'),
(101, 'Iran (Islamic Republic of)', 'IR', 'IRN'),
(102, 'Iraq', 'IQ', 'IRQ'),
(103, 'Ireland', 'IE', 'IRL'),
(104, 'Israel', 'IL', 'ISR'),
(105, 'Italy', 'IT', 'ITA'),
(106, 'Jamaica', 'JM', 'JAM'),
(107, 'Japan', 'JP', 'JPN'),
(108, 'Jordan', 'JO', 'JOR'),
(109, 'Kazakhstan', 'KZ', 'KAZ'),
(110, 'Kenya', 'KE', 'KEN'),
(111, 'Kiribati', 'KI', 'KIR'),
(112, 'North Korea', 'KP', 'PRK'),
(113, 'Korea, Republic of', 'KR', 'KOR'),
(114, 'Kuwait', 'KW', 'KWT'),
(115, 'Kyrgyzstan', 'KG', 'KGZ'),
(116, 'Lao People\'s Democratic Republic', 'LA', 'LAO'),
(117, 'Latvia', 'LV', 'LVA'),
(118, 'Lebanon', 'LB', 'LBN'),
(119, 'Lesotho', 'LS', 'LSO'),
(120, 'Liberia', 'LR', 'LBR'),
(121, 'Libyan Arab Jamahiriya', 'LY', 'LBY'),
(122, 'Liechtenstein', 'LI', 'LIE'),
(123, 'Lithuania', 'LT', 'LTU'),
(124, 'Luxembourg', 'LU', 'LUX'),
(125, 'Macau', 'MO', 'MAC'),
(126, 'Macedonia', 'MK', 'MKD'),
(127, 'Madagascar', 'MG', 'MDG'),
(128, 'Malawi', 'MW', 'MWI'),
(129, 'Malaysia', 'MY', 'MYS'),
(130, 'Maldives', 'MV', 'MDV'),
(131, 'Mali', 'ML', 'MLI'),
(132, 'Malta', 'MT', 'MLT'),
(133, 'Marshall Islands', 'MH', 'MHL'),
(134, 'Martinique', 'MQ', 'MTQ'),
(135, 'Mauritania', 'MR', 'MRT'),
(136, 'Mauritius', 'MU', 'MUS'),
(137, 'Mayotte', 'YT', 'MYT'),
(138, 'Mexico', 'MX', 'MEX'),
(139, 'Micronesia, Federated States of', 'FM', 'FSM'),
(140, 'Moldova, Republic of', 'MD', 'MDA'),
(141, 'Monaco', 'MC', 'MCO'),
(142, 'Mongolia', 'MN', 'MNG'),
(143, 'Montserrat', 'MS', 'MSR'),
(144, 'Morocco', 'MA', 'MAR'),
(145, 'Mozambique', 'MZ', 'MOZ'),
(146, 'Myanmar', 'MM', 'MMR'),
(147, 'Namibia', 'NA', 'NAM'),
(148, 'Nauru', 'NR', 'NRU'),
(149, 'Nepal', 'NP', 'NPL'),
(150, 'Netherlands', 'NL', 'NLD'),
(151, 'Netherlands Antilles', 'AN', 'ANT'),
(152, 'New Caledonia', 'NC', 'NCL'),
(153, 'New Zealand', 'NZ', 'NZL'),
(154, 'Nicaragua', 'NI', 'NIC'),
(155, 'Niger', 'NE', 'NER'),
(156, 'Nigeria', 'NG', 'NGA'),
(157, 'Niue', 'NU', 'NIU'),
(158, 'Norfolk Island', 'NF', 'NFK'),
(159, 'Northern Mariana Islands', 'MP', 'MNP'),
(160, 'Norway', 'NO', 'NOR'),
(161, 'Oman', 'OM', 'OMN'),
(162, 'Pakistan', 'PK', 'PAK'),
(163, 'Palau', 'PW', 'PLW'),
(164, 'Panama', 'PA', 'PAN'),
(165, 'Papua New Guinea', 'PG', 'PNG'),
(166, 'Paraguay', 'PY', 'PRY'),
(167, 'Peru', 'PE', 'PER'),
(168, 'Philippines', 'PH', 'PHL'),
(169, 'Pitcairn', 'PN', 'PCN'),
(170, 'Poland', 'PL', 'POL'),
(171, 'Portugal', 'PT', 'PRT'),
(172, 'Puerto Rico', 'PR', 'PRI'),
(173, 'Qatar', 'QA', 'QAT'),
(174, 'Reunion', 'RE', 'REU'),
(175, 'Romania', 'RO', 'ROM'),
(176, 'Russian Federation', 'RU', 'RUS'),
(177, 'Rwanda', 'RW', 'RWA'),
(178, 'Saint Kitts and Nevis', 'KN', 'KNA'),
(179, 'Saint Lucia', 'LC', 'LCA'),
(180, 'Saint Vincent and the Grenadines', 'VC', 'VCT'),
(181, 'Samoa', 'WS', 'WSM'),
(182, 'San Marino', 'SM', 'SMR'),
(183, 'Sao Tome and Principe', 'ST', 'STP'),
(184, 'Saudi Arabia', 'SA', 'SAU'),
(185, 'Senegal', 'SN', 'SEN'),
(186, 'Seychelles', 'SC', 'SYC'),
(187, 'Sierra Leone', 'SL', 'SLE'),
(188, 'Singapore', 'SG', 'SGP'),
(189, 'Slovak Republic', 'SK', 'SVK'),
(190, 'Slovenia', 'SI', 'SVN'),
(191, 'Solomon Islands', 'SB', 'SLB'),
(192, 'Somalia', 'SO', 'SOM'),
(193, 'South Africa', 'ZA', 'ZAF'),
(194, 'South Georgia &amp; South Sandwich Islands', 'GS', 'SGS'),
(195, 'Spain', 'ES', 'ESP'),
(196, 'Sri Lanka', 'LK', 'LKA'),
(197, 'St. Helena', 'SH', 'SHN'),
(198, 'St. Pierre and Miquelon', 'PM', 'SPM'),
(199, 'Sudan', 'SD', 'SDN'),
(200, 'Suriname', 'SR', 'SUR'),
(201, 'Svalbard and Jan Mayen Islands', 'SJ', 'SJM'),
(202, 'Swaziland', 'SZ', 'SWZ'),
(203, 'Sweden', 'SE', 'SWE'),
(204, 'Switzerland', 'CH', 'CHE'),
(205, 'Syrian Arab Republic', 'SY', 'SYR'),
(206, 'Taiwan', 'TW', 'TWN'),
(207, 'Tajikistan', 'TJ', 'TJK'),
(208, 'Tanzania, United Republic of', 'TZ', 'TZA'),
(209, 'Thailand', 'TH', 'THA'),
(210, 'Togo', 'TG', 'TGO'),
(211, 'Tokelau', 'TK', 'TKL'),
(212, 'Tonga', 'TO', 'TON'),
(213, 'Trinidad and Tobago', 'TT', 'TTO'),
(214, 'Tunisia', 'TN', 'TUN'),
(215, 'Turkey', 'TR', 'TUR'),
(216, 'Turkmenistan', 'TM', 'TKM'),
(217, 'Turks and Caicos Islands', 'TC', 'TCA'),
(218, 'Tuvalu', 'TV', 'TUV'),
(219, 'Uganda', 'UG', 'UGA'),
(220, 'Ukraine', 'UA', 'UKR'),
(221, 'United Arab Emirates', 'AE', 'ARE'),
(222, 'United Kingdom', 'GB', 'GBR'),
(223, 'United States', 'US', 'USA'),
(224, 'United States Minor Outlying Islands', 'UM', 'UMI'),
(225, 'Uruguay', 'UY', 'URY'),
(226, 'Uzbekistan', 'UZ', 'UZB'),
(227, 'Vanuatu', 'VU', 'VUT'),
(228, 'Vatican City State (Holy See)', 'VA', 'VAT'),
(229, 'Venezuela', 'VE', 'VEN'),
(230, 'Viet Nam', 'VN', 'VNM'),
(231, 'Virgin Islands (British)', 'VG', 'VGB'),
(232, 'Virgin Islands (U.S.)', 'VI', 'VIR'),
(233, 'Wallis and Futuna Islands', 'WF', 'WLF'),
(234, 'Western Sahara', 'EH', 'ESH'),
(235, 'Yemen', 'YE', 'YEM'),
(236, 'Yugoslavia', 'YU', 'YUG'),
(237, 'Democratic Republic of Congo', 'CD', 'COD'),
(238, 'Zambia', 'ZM', 'ZMB'),
(239, 'Zimbabwe', 'ZW', 'ZWE');

-- --------------------------------------------------------

--
-- Table structure for table `fa_kv_country`
--

CREATE TABLE `fa_kv_country` (
  `id` int(11) UNSIGNED NOT NULL,
  `iso` varchar(50) DEFAULT NULL,
  `local_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fa_kv_country`
--

INSERT INTO `fa_kv_country` (`id`, `iso`, `local_name`) VALUES
(1, 'AD', 'Andorra'),
(2, 'AE', 'United Arab Emirates'),
(3, 'AF', 'Afghanistan'),
(4, 'AG', 'Antigua and Barbuda'),
(5, 'AI', 'Anguilla'),
(6, 'AL', 'Albania'),
(7, 'AM', 'Armenia\r\n'),
(8, 'AN', 'Netherlands Antilles\r\n'),
(9, 'AO', 'Angola\r\n'),
(10, 'AQ', 'Antarctica\r\n'),
(11, 'AR', 'Argentina\r\n'),
(12, 'AS', 'American Samoa\r\n'),
(13, 'AT', 'Austria\r\n'),
(14, 'AU', 'Australia\r\n'),
(15, 'AW', 'Aruba\r\n'),
(16, 'AX', 'Aland Islands'),
(17, 'AZ', 'Azerbaijan\r\n'),
(18, 'BA', 'Bosnia and Herzegovina\r\n'),
(19, 'BB', 'Barbados\r\n'),
(20, 'BD', 'Bangladesh\r\n'),
(21, 'BE', 'Belgium\r\n'),
(22, 'BF', 'Burkina Faso\r\n'),
(23, 'BG', 'Bulgaria\r\n'),
(24, 'BH', 'Bahrain\r\n'),
(25, 'BI', 'Burundi\r\n'),
(26, 'BJ', 'Benin\r\n'),
(27, 'BL', 'Saint Barthlemy'),
(28, 'BM', 'Bermuda\r\n'),
(29, 'BN', 'Brunei Darussalam\r\n'),
(30, 'BO', 'Bolivia\r\nBolivia, Plurinational state of'),
(31, 'BR', 'Brazil\r\n'),
(32, 'BS', 'Bahamas\r\n'),
(33, 'BT', 'Bhutan\r\n'),
(34, 'BV', 'Bouvet Island\r\n'),
(35, 'BW', 'Botswana\r\n'),
(36, 'BY', 'Belarus\r\n'),
(37, 'BZ', 'Belize\r\n'),
(38, 'CA', 'Canada\r\n'),
(39, 'CC', 'Cocos (Keeling) Islands\r\n'),
(40, 'CD', 'Congo, The Democratic Republic of the\r\n'),
(41, 'CF', 'Central African Republic\r\n'),
(42, 'CG', 'Congo\r\n'),
(43, 'CH', 'Switzerland\r\n'),
(45, 'CK', 'Cook Islands\r\n'),
(46, 'CL', 'Chile'),
(47, 'CM', 'Cameroon\r\n'),
(48, 'CN', 'China\r\n'),
(49, 'CO', 'Colombia\r\n'),
(50, 'CR', 'Costa Rica\r\n'),
(51, 'CU', 'Cuba\r\n'),
(52, 'CV', 'Cape Verde\r\n'),
(53, 'CX', 'Christmas Island\r\n'),
(54, 'CY', 'Cyprus\r\n'),
(55, 'CZ', 'Czech Republic\r\n'),
(56, 'DE', 'Germany\r\n'),
(57, 'DJ', 'Djibouti\r\n'),
(58, 'DK', 'Denmark\r\n'),
(59, 'DM', 'Dominica\r\n'),
(60, 'DO', 'Dominican Republic\r\n'),
(61, 'DZ', 'Algeria\r\n'),
(62, 'EC', 'Ecuador\r\n'),
(63, 'EE', 'Estonia\r\n'),
(64, 'EG', 'Egypt\r\n'),
(65, 'EH', 'Western Sahara\r\n'),
(66, 'ER', 'Eritrea\r\n'),
(67, 'ES', 'Spain\r\n'),
(68, 'ET', 'Ethiopia\r\n'),
(69, 'FI', 'Finland\r\n'),
(70, 'FJ', 'Fiji\r\n'),
(71, 'FK', 'Falkland Islands (Malvinas)\r\n'),
(72, 'FM', 'Micronesia, Federated States of\r\n'),
(73, 'FO', 'Faroe Islands\r\n'),
(74, 'FR', 'France\r\n'),
(75, 'GA', 'Gabon'),
(76, 'GB', 'United Kingdom'),
(77, 'GD', 'Grenada'),
(78, 'GE', 'Georgia'),
(79, 'GF', 'French Guiana'),
(80, 'GG', 'Guernsey'),
(81, 'GH', 'Ghana\r\n'),
(82, 'GI', 'Gibraltar\r\n'),
(83, 'GL', 'Greenland\r\n'),
(84, 'GM', 'Gambia\r\n'),
(85, 'GN', 'Guinea\r\n'),
(86, 'GP', 'Guadeloupe\r\n'),
(87, 'GQ', 'Equatorial Guinea\r\n'),
(88, 'GR', 'Greece\r\n'),
(89, 'GS', 'South Georgia and the South Sandwich Islands\r\n'),
(90, 'GT', 'Guatemala\r\n'),
(91, 'GU', 'Guam\r\n'),
(92, 'GW', 'Guinea-Bissau\r\n'),
(93, 'GY', 'Guyana\r\n'),
(94, 'HK', 'Hong Kong\r\n'),
(95, 'HM', 'Heard Island and McDonald Islands\r\n'),
(96, 'HN', 'Honduras\r\n'),
(97, 'HR', 'Croatia\r\n'),
(98, 'HT', 'Haiti\r\n'),
(99, 'HU', 'Hungary\r\n'),
(100, 'ID', 'Indonesia\r\n'),
(101, 'IE', 'Ireland\r\n'),
(102, 'IL', 'Israel\r\n'),
(103, 'IM', 'Isle of Man\r\n'),
(104, 'IN', 'India\r\n'),
(105, 'IO', 'British Indian Ocean Territory\r\n'),
(106, 'IQ', 'Iraq\r\n'),
(107, 'IR', 'Iran, Islamic Republic of\r\n'),
(108, 'IS', 'Iceland\r\n'),
(109, 'IT', 'Italy'),
(110, 'JE', 'Jersey\r\n'),
(111, 'JM', 'Jamaica\r\n'),
(112, 'JO', 'Jordan\r\n'),
(113, 'JP', 'Japan\r\n'),
(114, 'KE', 'Kenya\r\n'),
(115, 'KG', 'Kyrgyzstan\r\n'),
(116, 'KH', 'Cambodia\r\n'),
(117, 'KI', 'Kiribati\r\n'),
(118, 'KM', 'Comoros\r\n'),
(119, 'KN', 'Saint Kitts and Nevis\r\n'),
(120, 'KP', 'Korea, Democratic People&#39;s Republic of\r\n'),
(121, 'KR', 'Korea, Republic of\r\n'),
(122, 'KW', 'Kuwait\r\n'),
(123, 'KY', 'Cayman Islands\r\n'),
(124, 'KZ', 'Kazakhstan\r\n'),
(125, 'LA', 'Lao People&#39;s Democratic Republic\r\n'),
(126, 'LB', 'Lebanon\r\n'),
(127, 'LC', 'Saint Lucia\r\n'),
(128, 'LI', 'Liechtenstein\r\n'),
(129, 'LK', 'Sri Lanka\r\n'),
(130, 'LR', 'Liberia\r\n'),
(131, 'LS', 'Lesotho\r\n'),
(132, 'LT', 'Lithuania\r\n'),
(133, 'LU', 'Luxembourg\r\n'),
(134, 'LV', 'Latvia\r\n'),
(135, 'LY', 'Libyan Arab Jamahiriya\r\n'),
(136, 'MA', 'Morocco\r\n'),
(137, 'MC', 'Monaco\r\n'),
(138, 'MD', 'Moldova, Republic of\r\n'),
(139, 'ME', 'Montenegro\r\n'),
(140, 'MF', 'Saint Martin'),
(141, 'MG', 'Madagascar\r\n'),
(142, 'MH', 'Marshall Islands\r\n'),
(143, 'MK', 'Macedonia\r\n'),
(144, 'ML', 'Mali\r\n'),
(145, 'MM', 'Myanmar\r\n'),
(146, 'MN', 'Mongolia\r\n'),
(147, 'MO', 'Macao\r\n'),
(148, 'MP', 'Northern Mariana Islands\r\n'),
(149, 'MQ', 'Martinique\r\n'),
(150, 'MR', 'Mauritania\r\n'),
(151, 'MS', 'Montserrat\r\n'),
(152, 'MT', 'Malta\r\n'),
(153, 'MU', 'Mauritius\r\n'),
(154, 'MV', 'Maldives\r\n'),
(155, 'MW', 'Malawi\r\n'),
(156, 'MX', 'Mexico\r\n'),
(157, 'MY', 'Malaysia\r\n'),
(158, 'MZ', 'Mozambique\r\n'),
(159, 'NA', 'Namibia\r\n'),
(160, 'NC', 'New Caledonia\r\n'),
(161, 'NE', 'Niger\r\n'),
(162, 'NF', 'Norfolk Island\r\n'),
(163, 'NG', 'Nigeria\r\n'),
(164, 'NI', 'Nicaragua\r\n'),
(165, 'NL', 'Netherlands\r\n'),
(166, 'NO', 'Norway'),
(167, 'NP', 'Nepal\r\n'),
(168, 'NR', 'Nauru\r\n'),
(169, 'NU', 'Niue\r\n'),
(170, 'NZ', 'New Zealand\r\n'),
(171, 'OM', 'Oman\r\n'),
(172, 'PA', 'Panama\r\n'),
(173, 'PE', 'Peru\r\n'),
(174, 'PF', 'French Polynesia\r\n'),
(175, 'PG', 'Papua New Guinea\r\n'),
(176, 'PH', 'Philippines\r\n'),
(177, 'PK', 'Pakistan\r\n'),
(178, 'PL', 'Poland\r\n'),
(179, 'PM', 'Saint Pierre and Miquelon\r\n'),
(180, 'PN', 'Pitcairn\r\n'),
(181, 'PR', 'Puerto Rico\r\n'),
(182, 'PS', 'Palestinian Territory, Occupied'),
(183, 'PT', 'Portugal\r\n'),
(184, 'PW', 'Palau\r\n'),
(185, 'PY', 'Paraguay\r\n'),
(186, 'QA', 'Qatar\r\n'),
(188, 'RO', 'Romania\r\n'),
(189, 'RS', 'Serbia\r\n'),
(190, 'RU', 'Russian Federation\r\n'),
(191, 'RW', 'Rwanda\r\n'),
(192, 'SA', 'Saudi Arabia\r\n'),
(193, 'SB', 'Solomon Islands\r\n'),
(194, 'SC', 'Seychelles\r\n'),
(195, 'SD', 'Sudan\r\n'),
(196, 'SE', 'Sweden\r\n'),
(197, 'SG', 'Singapore\r\n'),
(198, 'SH', 'Saint Helena\r\n'),
(199, 'SI', 'Slovenia\r\n'),
(200, 'SJ', 'Svalbard and Jan Mayen\r\n'),
(201, 'SK', 'Slovakia\r\n'),
(202, 'SL', 'Sierra Leone\r\n'),
(203, 'SM', 'San Marino\r\n'),
(204, 'SN', 'Senegal\r\n'),
(205, 'SO', 'Somalia\r\n'),
(206, 'SR', 'Suriname\r\n'),
(207, 'ST', 'Sao Tome and Principe\r\n'),
(208, 'SV', 'El Salvador\r\n'),
(209, 'SY', 'Syrian Arab Republic\r\n'),
(210, 'SZ', 'Swaziland\r\n'),
(211, 'TC', 'Turks and Caicos Islands\r\n'),
(212, 'TD', 'Chad'),
(213, 'TF', 'French Southern Territories'),
(214, 'TG', 'Togo'),
(215, 'TH', 'Thailand'),
(216, 'TJ', 'Tajikistan'),
(217, 'TK', 'Tokelau'),
(218, 'TL', 'Timor-Leste'),
(219, 'TM', 'Turkmenistan\r\n'),
(220, 'TN', 'Tunisia\r\n'),
(221, 'TO', 'Tonga\r\n'),
(222, 'TR', 'Turkey'),
(223, 'TT', 'Trinidad and Tobago\r\n'),
(224, 'TV', 'Tuvalu\r\n'),
(225, 'TW', 'Taiwan\r\n'),
(226, 'TZ', 'Tanzania, United Republic of\r\n'),
(227, 'UA', 'Ukraine\r\n'),
(228, 'UG', 'Uganda\r\n'),
(229, 'UM', 'United States Minor Outlying Islands\r\n'),
(230, 'US', 'United States\r\n'),
(231, 'UY', 'Uruguay\r\n'),
(232, 'UZ', 'Uzbekistan\r\n'),
(233, 'VA', 'Holy See (Vatican City State)\r\n'),
(234, 'VC', 'Saint Vincent and the Grenadines\r\n'),
(235, 'VE', 'Venezuela, Bolivarian Republic of'),
(236, 'VG', 'Virgin Islands, British\r\n'),
(237, 'VI', 'Virgin Islands, U.S.\r\n'),
(238, 'VN', 'Viet Nam'),
(239, 'VU', 'Vanuatu\r\n'),
(240, 'WF', 'Wallis and Futuna\r\n'),
(241, 'WS', 'Samoa\r\n'),
(242, 'YE', 'Yemen\r\n'),
(243, 'YT', 'Mayotte\r\n'),
(244, 'ZA', 'South Africa\r\n'),
(245, 'ZM', 'Zambia\r\n'),
(246, 'ZW', 'Zimbabwe');

-- --------------------------------------------------------

--
-- Table structure for table `fa_kv_departments`
--

CREATE TABLE `fa_kv_departments` (
  `id` smallint(6) UNSIGNED NOT NULL,
  `description` varchar(60) NOT NULL DEFAULT '',
  `inactive` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fa_kv_departments`
--

INSERT INTO `fa_kv_departments` (`id`, `description`, `inactive`) VALUES
(1, 'Academics', 0),
(2, 'Exam', 0);

-- --------------------------------------------------------

--
-- Table structure for table `fa_kv_desig_group`
--

CREATE TABLE `fa_kv_desig_group` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  `inactive` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fa_kv_desig_group`
--

INSERT INTO `fa_kv_desig_group` (`id`, `name`, `description`, `inactive`) VALUES
(1, 'Programmer', 'Programmer', 0),
(2, 'App Developer', 'Mobile App Development', 0),
(3, 'Manager', 'Project Manager', 0),
(4, 'Intern', 'Intern', 0),
(5, 'Designer', 'Designer', 0),
(6, 'Exam Coordinator', 'Exam Coordinator', 0),
(7, 'Web Developer', 'Senior Developer', 0),
(8, 'QA', 'Testing ', 0);

-- --------------------------------------------------------

--
-- Table structure for table `fa_kv_empl_attendancee`
--

CREATE TABLE `fa_kv_empl_attendancee` (
  `id` int(11) UNSIGNED NOT NULL,
  `month` int(2) DEFAULT NULL,
  `year` int(2) DEFAULT NULL,
  `dept_id` int(10) NOT NULL,
  `empl_id` varchar(30) DEFAULT NULL,
  `1` varchar(5) NOT NULL,
  `2` varchar(5) NOT NULL,
  `3` varchar(5) NOT NULL,
  `4` varchar(5) NOT NULL,
  `5` varchar(5) NOT NULL,
  `6` varchar(5) NOT NULL,
  `7` varchar(5) NOT NULL,
  `8` varchar(5) NOT NULL,
  `9` varchar(5) NOT NULL,
  `10` varchar(5) NOT NULL,
  `11` varchar(5) NOT NULL,
  `12` varchar(5) NOT NULL,
  `13` varchar(5) NOT NULL,
  `14` varchar(5) NOT NULL,
  `15` varchar(5) NOT NULL,
  `16` varchar(5) NOT NULL,
  `17` varchar(5) NOT NULL,
  `18` varchar(5) NOT NULL,
  `19` varchar(5) NOT NULL,
  `20` varchar(5) NOT NULL,
  `21` varchar(5) NOT NULL,
  `22` varchar(5) NOT NULL,
  `23` varchar(5) NOT NULL,
  `24` varchar(5) NOT NULL,
  `25` varchar(5) NOT NULL,
  `26` varchar(5) NOT NULL,
  `27` varchar(5) NOT NULL,
  `28` varchar(5) NOT NULL,
  `29` varchar(5) NOT NULL,
  `30` varchar(5) NOT NULL,
  `31` varchar(5) NOT NULL,
  `cal_year` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fa_kv_empl_attendancee`
--

INSERT INTO `fa_kv_empl_attendancee` (`id`, `month`, `year`, `dept_id`, `empl_id`, `1`, `2`, `3`, `4`, `5`, `6`, `7`, `8`, `9`, `10`, `11`, `12`, `13`, `14`, `15`, `16`, `17`, `18`, `19`, `20`, `21`, `22`, `23`, `24`, `25`, `26`, `27`, `28`, `29`, `30`, `31`, `cal_year`) VALUES
(1, 1, 1, 1, 'EMP-F-011', 'A', 'A', 'A', 'A', '', '', 'A', 'A', 'A', 'A', 'A', '', '', 'A', 'A', 'A', 'A', 'A', '', '', 'A', 'A', 'A', 'A', 'A', '', '', 'A', 'A', 'A', 'A', 2019),
(2, 1, 1, 1, 'EMP-F-008', 'A', 'A', 'A', 'A', '', '', 'A', 'A', 'A', 'A', 'A', '', '', 'A', 'A', 'A', 'A', 'A', '', '', 'A', 'A', 'A', 'A', 'A', '', '', 'A', 'A', 'A', 'A', 2019),
(3, 1, 1, 1, 'EMP-F-007', 'A', 'A', 'A', 'A', '', '', 'A', 'A', 'A', 'A', 'A', '', '', 'A', 'A', 'A', 'A', 'A', '', '', 'A', 'A', 'A', 'A', 'A', '', '', 'A', 'A', 'A', 'A', 2019),
(4, 1, 1, 1, 'EMP-F-006', 'A', 'A', 'A', 'A', '', '', 'A', 'A', 'A', 'A', 'A', '', '', 'A', 'A', 'A', 'A', 'A', '', '', 'A', 'A', 'A', 'A', 'A', '', '', 'A', 'A', 'A', 'A', 2019),
(5, 1, 1, 1, 'EMP-F-005', 'A', 'A', 'A', 'A', '', '', 'A', 'A', 'A', 'A', 'A', '', '', 'A', 'A', 'A', 'A', 'A', '', '', 'A', 'A', 'A', 'A', 'A', '', '', 'A', 'A', 'A', 'A', 2019),
(6, 1, 1, 1, 'EMP-F-001', 'P', 'P', 'P', 'P', '', '', 'P', 'P', 'P', 'P', 'P', '', '', 'EL', 'P', 'P', 'P', 'P', '', '', 'P', 'P', 'P', 'P', 'P', '', '', 'P', 'P', 'P', 'P', 2019),
(7, 1, 1, 1, 'EMP-S-003', 'A', 'A', 'A', 'A', '', '', 'A', 'A', 'A', 'A', 'A', '', '', 'A', 'A', 'A', 'A', 'A', '', '', 'A', 'A', 'A', 'A', 'A', '', '', 'A', 'A', 'A', 'A', 2019),
(8, 1, 1, 1, 'EMP-S-002', 'A', 'A', 'A', 'A', '', '', 'A', 'A', 'A', 'A', 'A', '', '', 'A', 'A', 'A', 'A', 'A', '', '', 'A', 'A', 'A', 'A', 'A', '', '', 'A', 'A', 'A', 'A', 2019),
(9, 1, 1, 1, 'EMP-S-001', 'A', 'A', 'A', 'A', '', '', 'A', 'A', 'A', 'A', 'A', '', '', 'A', 'A', 'A', 'A', 'A', '', '', 'A', 'A', 'A', 'A', 'A', '', '', 'A', 'A', 'A', 'A', 2019),
(10, 2, 1, 1, 'EMP-F-011', 'A', '', '', 'A', 'A', 'A', 'A', 'A', '', '', 'A', 'A', 'A', 'A', 'A', '', '', 'A', 'A', 'A', 'A', 'A', '', '', 'A', 'A', 'A', 'A', '', '', '', 2019),
(11, 2, 1, 1, 'EMP-F-008', 'A', '', '', 'A', 'A', 'A', 'A', 'A', '', '', 'A', 'A', 'A', 'A', 'A', '', '', 'A', 'A', 'A', 'A', 'A', '', '', 'A', 'A', 'A', 'A', '', '', '', 2019),
(12, 2, 1, 1, 'EMP-F-007', 'A', '', '', 'A', 'A', 'A', 'A', 'A', '', '', 'A', 'A', 'A', 'A', 'A', '', '', 'A', 'A', 'A', 'A', 'A', '', '', 'A', 'A', 'A', 'A', '', '', '', 2019),
(13, 2, 1, 1, 'EMP-F-006', 'A', '', '', 'A', 'A', 'A', 'A', 'A', '', '', 'A', 'A', 'A', 'A', 'A', '', '', 'A', 'A', 'A', 'A', 'A', '', '', 'A', 'A', 'A', 'A', '', '', '', 2019),
(14, 2, 1, 1, 'EMP-F-005', 'A', '', '', 'A', 'A', 'A', 'A', 'A', '', '', 'A', 'A', 'A', 'A', 'A', '', '', 'A', 'A', 'A', 'A', 'A', '', '', 'A', 'A', 'A', 'A', '', '', '', 2019),
(15, 2, 1, 1, 'EMP-F-001', 'P', '', '', 'P', 'P', 'P', 'P', 'P', '', '', 'P', 'P', 'P', 'P', 'P', '', '', 'P', 'P', 'P', 'P', 'P', '', '', 'P', 'P', 'P', 'P', '', '', '', 2019),
(16, 2, 1, 1, 'EMP-S-003', 'A', '', '', 'A', 'A', 'A', 'A', 'A', '', '', 'A', 'A', 'A', 'A', 'A', '', '', 'A', 'A', 'A', 'A', 'A', '', '', 'A', 'A', 'A', 'A', '', '', '', 2019),
(17, 2, 1, 1, 'EMP-S-002', 'A', '', '', 'A', 'A', 'A', 'A', 'A', '', '', 'A', 'A', 'A', 'A', 'A', '', '', 'A', 'A', 'A', 'A', 'A', '', '', 'A', 'A', 'A', 'A', '', '', '', 2019),
(18, 2, 1, 1, 'EMP-S-001', 'A', '', '', 'A', 'A', 'A', 'A', 'A', '', '', 'A', 'A', 'A', 'A', 'A', '', '', 'A', 'A', 'A', 'A', 'A', '', '', 'A', 'A', 'A', 'A', '', '', '', 2019),
(19, 3, 1, 1, 'EMP-F-011', 'A', '', '', 'A', 'A', 'A', 'A', 'A', '', '', 'A', 'A', 'A', 'A', 'A', '', '', 'A', 'A', 'A', 'A', 'A', '', '', 'A', 'A', 'A', 'A', 'A', '', '', 2019),
(20, 3, 1, 1, 'EMP-F-008', 'A', '', '', 'A', 'A', 'A', 'A', 'A', '', '', 'A', 'A', 'A', 'A', 'A', '', '', 'A', 'A', 'A', 'A', 'A', '', '', 'A', 'A', 'A', 'A', 'A', '', '', 2019),
(21, 3, 1, 1, 'EMP-F-007', 'A', '', '', 'A', 'A', 'A', 'A', 'A', '', '', 'A', 'A', 'A', 'A', 'A', '', '', 'A', 'A', 'A', 'A', 'A', '', '', 'A', 'A', 'A', 'A', 'A', '', '', 2019),
(22, 3, 1, 1, 'EMP-F-006', 'A', '', '', 'A', 'A', 'A', 'A', 'A', '', '', 'A', 'A', 'A', 'A', 'A', '', '', 'A', 'A', 'A', 'A', 'A', '', '', 'A', 'A', 'A', 'A', 'A', '', '', 2019),
(23, 3, 1, 1, 'EMP-F-005', 'A', '', '', 'A', 'A', 'A', 'A', 'A', '', '', 'A', 'A', 'A', 'A', 'A', '', '', 'A', 'A', 'A', 'A', 'A', '', '', 'A', 'A', 'A', 'A', 'A', '', '', 2019),
(24, 3, 1, 1, 'EMP-F-001', 'P', '', '', 'EL', 'P', 'P', 'P', 'P', '', '', 'P', 'P', 'P', 'P', 'P', '', '', 'P', 'P', 'P', 'P', 'P', '', '', 'P', 'P', 'P', 'P', 'P', '', '', 2019),
(25, 3, 1, 1, 'EMP-S-003', 'A', '', '', 'A', 'A', 'A', 'A', 'A', '', '', 'A', 'A', 'A', 'A', 'A', '', '', 'A', 'A', 'A', 'A', 'A', '', '', 'A', 'A', 'A', 'A', 'A', '', '', 2019),
(26, 3, 1, 1, 'EMP-S-002', 'A', '', '', 'A', 'A', 'A', 'A', 'A', '', '', 'A', 'A', 'A', 'A', 'A', '', '', 'A', 'A', 'A', 'A', 'A', '', '', 'A', 'A', 'A', 'A', 'A', '', '', 2019),
(27, 3, 1, 1, 'EMP-S-001', 'A', '', '', 'A', 'A', 'A', 'A', 'A', '', '', 'A', 'A', 'A', 'A', 'P', '', '', 'P', 'A', 'A', 'A', 'A', '', '', 'A', 'A', 'P', 'A', 'A', '', '', 2019),
(28, 1, 3, 1, 'EMP-F-013', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', 2020),
(29, 1, 3, 1, 'EMP-F-011', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', 2020),
(30, 1, 3, 1, 'EMP-F-008', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', 2020),
(31, 1, 3, 1, 'EMP-F-007', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', 2020),
(32, 1, 3, 1, 'EMP-F-006', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', 2020),
(33, 1, 3, 1, 'EMP-F-005', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', 2020),
(34, 1, 3, 1, 'EMP-F-001', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'A', '', '', 'HD', 'HD', 'A', '', '', '', '', 2020),
(35, 1, 3, 1, 'EMP-S-003', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', 2020),
(36, 1, 3, 1, 'EMP-S-002', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', 2020),
(37, 1, 3, 1, 'EMP-S-001', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', 2020),
(38, 12, 2, 6, 'EMP-F-001', 'P', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2020),
(39, 4, 5, 1, 'EMP-f-171', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(40, 4, 5, 1, 'EMP-f-170', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(41, 4, 5, 1, 'EMP-F-169', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(42, 4, 5, 1, 'EMP-F-168', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(43, 4, 5, 1, 'EMP-F-167', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(44, 4, 5, 1, 'EMP-f-166', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(45, 4, 5, 1, 'EMP-f-165', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(46, 4, 5, 1, 'EMP-f-164', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(47, 4, 5, 1, 'EMP-f-163', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(48, 4, 5, 1, 'EMP-f-162', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(49, 4, 5, 1, 'EMP-f-161', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(50, 4, 5, 1, 'EMP-f-160', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(51, 4, 5, 1, 'EMP-f-159', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(52, 4, 5, 1, 'EMP-f-158', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(53, 4, 5, 1, 'EMP-f-157', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(54, 4, 5, 1, 'EMP-f-156', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(55, 4, 5, 1, 'EMP-f-155', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(56, 4, 5, 1, 'EMP-f-154', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(57, 4, 5, 1, 'EMP-f-153', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(58, 4, 5, 1, 'EMP-f-152', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(59, 4, 5, 1, 'EMP-f-151', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(60, 4, 5, 1, 'EMP-f-150', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(61, 4, 5, 1, 'EMP-f-149', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(62, 4, 5, 1, 'EMP-f-148', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(63, 4, 5, 1, 'EMP-f-147', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(64, 4, 5, 1, 'EMP-f-146', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(65, 4, 5, 1, 'EMP-f-145', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(66, 4, 5, 1, 'EMP-f-144', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(67, 4, 5, 1, 'EMP-f-143', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(68, 4, 5, 1, 'EMP-f-142', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(69, 4, 5, 1, 'EMP-f-141', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(70, 4, 5, 1, 'EMP-f-140', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(71, 4, 5, 1, 'EMP-f-139', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(72, 4, 5, 1, 'EMP-f-138', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(73, 4, 5, 1, 'EMP-f-137', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(74, 4, 5, 1, 'EMP-f-136', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(75, 4, 5, 1, 'EMP-f-135', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(76, 4, 5, 1, 'EMP-f-134', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(77, 4, 5, 1, 'EMP-f-133', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(78, 4, 5, 1, 'EMP-f-132', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(79, 4, 5, 1, 'EMP-f-131', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(80, 4, 5, 1, 'EMP-f-130', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(81, 4, 5, 1, 'EMP-f-129', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(82, 4, 5, 1, 'EMP-f-128', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(83, 4, 5, 1, 'EMP-f-127', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(84, 4, 5, 1, 'EMP-f-126', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(85, 4, 5, 1, 'EMP-f-125', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(86, 4, 5, 1, 'EMP-f-124', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(87, 4, 5, 1, 'EMP-f-123', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(88, 4, 5, 1, 'EMP-f-122', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(89, 4, 5, 1, 'EMP-f-121', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(90, 4, 5, 1, 'EMP-f-120', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(91, 4, 5, 1, 'EMP-f-119', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(92, 4, 5, 1, 'EMP-f-118', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(93, 4, 5, 1, 'EMP-f-117', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(94, 4, 5, 1, 'EMP-f-116', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(95, 4, 5, 1, 'EMP-f-115', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(96, 4, 5, 1, 'EMP-f-114', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(97, 4, 5, 1, 'EMP-f-113', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(98, 4, 5, 1, 'EMP-f-112', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(99, 4, 5, 1, 'EMP-f-111', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(100, 4, 5, 1, 'EMP-f-110', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(101, 4, 5, 1, 'EMP-f-109', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(102, 4, 5, 1, 'EMP-f-108', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(103, 4, 5, 1, 'EMP-f-107', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(104, 4, 5, 1, 'EMP-f-106', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(105, 4, 5, 1, 'EMP-f-105', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(106, 4, 5, 1, 'EMP-f-104', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(107, 4, 5, 1, 'EMP-f-103', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(108, 4, 5, 1, 'EMP-f-102', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(109, 4, 5, 1, 'EMP-f-101', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(110, 4, 5, 1, 'EMP-f-100', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(111, 4, 5, 1, 'EMP-F-099', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(112, 4, 5, 1, 'EMP-F-098', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(113, 4, 5, 1, 'EMP-F-097', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(114, 4, 5, 1, 'EMP-F-096', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(115, 4, 5, 1, 'EMP-F-095', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(116, 4, 5, 1, 'EMP-F-094', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(117, 4, 5, 1, 'EMP-F-093', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(118, 4, 5, 1, 'EMP-F-092', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(119, 4, 5, 1, 'EMP-F-091', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(120, 4, 5, 1, 'EMP-F-090', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(121, 4, 5, 1, 'EMP-F-089', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(122, 4, 5, 1, 'EMP-F-088', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(123, 4, 5, 1, 'EMP-F-087', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(124, 4, 5, 1, 'EMP-F-086', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(125, 4, 5, 1, 'EMP-F-085', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(126, 4, 5, 1, 'EMP-F-084', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(127, 4, 5, 1, 'EMP-F-083', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(128, 4, 5, 1, 'EMP-F-082', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(129, 4, 5, 1, 'EMP-F-081', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(130, 4, 5, 1, 'EMP-F-080', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(131, 4, 5, 1, 'EMP-F-079', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(132, 4, 5, 1, 'EMP-F-078', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(133, 4, 5, 1, 'EMP-F-077', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(134, 4, 5, 1, 'EMP-F-076', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(135, 4, 5, 1, 'EMP-F-075', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(136, 4, 5, 1, 'EMP-F-074', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(137, 4, 5, 1, 'EMP-F-073', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(138, 4, 5, 1, 'EMP-F-072', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(139, 4, 5, 1, 'EMP-F-071', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(140, 4, 5, 1, 'EMP-F-070', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(141, 4, 5, 1, 'EMP-F-069', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(142, 4, 5, 1, 'EMP-F-068', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(143, 4, 5, 1, 'EMP-F-067', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(144, 4, 5, 1, 'EMP-F-066', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(145, 4, 5, 1, 'EMP-F-065', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(146, 4, 5, 1, 'EMP-F-064', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(147, 4, 5, 1, 'EMP-F-063', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(148, 4, 5, 1, 'EMP-F-062', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(149, 4, 5, 1, 'EMP-F-061', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(150, 4, 5, 1, 'EMP-F-060', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(151, 4, 5, 1, 'EMP-F-059', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(152, 4, 5, 1, 'EMP-F-058', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(153, 4, 5, 1, 'EMP-F-057', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(154, 4, 5, 1, 'EMP-F-056', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(155, 4, 5, 1, 'EMP-F-055', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(156, 4, 5, 1, 'EMP-F-054', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(157, 4, 5, 1, 'EMP-F-053', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(158, 4, 5, 1, 'EMP-F-052', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(159, 4, 5, 1, 'EMP-F-051', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(160, 4, 5, 1, 'EMP-F-050', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(161, 4, 5, 1, 'EMP-F-049', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(162, 4, 5, 1, 'EMP-F-048', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(163, 4, 5, 1, 'EMP-F-047', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(164, 4, 5, 1, 'EMP-F-046', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(165, 4, 5, 1, 'EMP-F-045', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(166, 4, 5, 1, 'EMP-F-044', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(167, 4, 5, 1, 'EMP-F-043', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(168, 4, 5, 1, 'EMP-F-042', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(169, 4, 5, 1, 'EMP-F-041', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(170, 4, 5, 1, 'EMP-F-040', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(171, 4, 5, 1, 'EMP-F-039', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(172, 4, 5, 1, 'EMP-F-038', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(173, 4, 5, 1, 'EMP-F-037', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(174, 4, 5, 1, 'EMP-F-036', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(175, 4, 5, 1, 'EMP-F-035', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(176, 4, 5, 1, 'EMP-F-034', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(177, 4, 5, 1, 'EMP-F-033', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(178, 4, 5, 1, 'EMP-F-032', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(179, 4, 5, 1, 'EMP-F-031', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(180, 4, 5, 1, 'EMP-F-030', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(181, 4, 5, 1, 'EMP-F-029', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(182, 4, 5, 1, 'EMP-F-028', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(183, 4, 5, 1, 'EMP-F-027', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(184, 4, 5, 1, 'EMP-F-026', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(185, 4, 5, 1, 'EMP-F-025', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(186, 4, 5, 1, 'EMP-F-024', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(187, 4, 5, 1, 'EMP-F-023', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(188, 4, 5, 1, 'EMP-F-022', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(189, 4, 5, 1, 'EMP-F-021', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(190, 4, 5, 1, 'EMP-F-020', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(191, 4, 5, 1, 'EMP-F-019', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(192, 4, 5, 1, 'EMP-F-018', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(193, 4, 5, 1, 'EMP-F-017', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(194, 4, 5, 1, 'EMP-F-016', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(195, 4, 5, 1, 'EMP-F-015', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(196, 4, 5, 1, 'EMP-F-014', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(197, 4, 5, 1, 'EMP-F-013', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(198, 4, 5, 1, 'EMP-F-012', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(199, 4, 5, 1, 'EMP-F-011', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(200, 4, 5, 1, 'EMP-F-010', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(201, 4, 5, 1, 'EMP-F-009', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(202, 4, 5, 1, 'EMP-F-008', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(203, 4, 5, 1, 'EMP-F-007', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(204, 4, 5, 1, 'EMP-F-006', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(205, 4, 5, 1, 'EMP-F-005', '', '', '', '', 'A', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021),
(206, 4, 5, 1, 'EMP-F-004', '', '', '', '', 'HCL', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2021);

-- --------------------------------------------------------

--
-- Table structure for table `fa_kv_empl_cv`
--

CREATE TABLE `fa_kv_empl_cv` (
  `id` int(10) NOT NULL,
  `empl_id` varchar(10) NOT NULL,
  `empl_firstname` varchar(60) NOT NULL,
  `cv_title` varchar(60) NOT NULL,
  `filename` varchar(60) NOT NULL,
  `unique_name` varchar(60) NOT NULL,
  `uploaded_date` datetime DEFAULT NULL,
  `last_updated` datetime DEFAULT NULL,
  `f_year` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fa_kv_empl_cv`
--

INSERT INTO `fa_kv_empl_cv` (`id`, `empl_id`, `empl_firstname`, `cv_title`, `filename`, `unique_name`, `uploaded_date`, `last_updated`, `f_year`) VALUES
(1, 'EMP-F-001', 'Raushan', 'test', 'download.jpg', '5e2ea3322688c', '2020-01-27 09:45:38', NULL, 1),
(2, 'EMP-F-001', 'Raushan', 'test', 'download.jpg', '5e2eb7522e639', '2020-01-27 11:11:30', NULL, 3),
(3, 'EMP-F-004', 'Om', 'tesst', 'pfi.png', '5ffd76c5a4b2d', '2021-01-12 10:15:33', NULL, 3);

-- --------------------------------------------------------

--
-- Table structure for table `fa_kv_empl_degree`
--

CREATE TABLE `fa_kv_empl_degree` (
  `id` int(10) NOT NULL,
  `empl_id` varchar(10) NOT NULL,
  `degree` varchar(20) NOT NULL,
  `major` varchar(20) NOT NULL,
  `university` varchar(80) NOT NULL,
  `grade` varchar(20) NOT NULL,
  `year` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fa_kv_empl_degree`
--

INSERT INTO `fa_kv_empl_degree` (`id`, `empl_id`, `degree`, `major`, `university`, `grade`, `year`) VALUES
(1, 'EMP-F-001', 'Btech', 'computer', 'ptu', '65', '2014-06-01');

-- --------------------------------------------------------

--
-- Table structure for table `fa_kv_empl_experience`
--

CREATE TABLE `fa_kv_empl_experience` (
  `id` int(10) NOT NULL,
  `empl_id` varchar(10) NOT NULL,
  `organization` varchar(60) NOT NULL,
  `job_role` varchar(60) NOT NULL,
  `job_position` varchar(120) NOT NULL,
  `nature_of_work` varchar(120) NOT NULL,
  `type_employment` varchar(120) NOT NULL,
  `monthly_sal` varchar(100) NOT NULL,
  `s_date` date NOT NULL,
  `e_date` date NOT NULL,
  `experience` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fa_kv_empl_experience`
--

INSERT INTO `fa_kv_empl_experience` (`id`, `empl_id`, `organization`, `job_role`, `job_position`, `nature_of_work`, `type_employment`, `monthly_sal`, `s_date`, `e_date`, `experience`) VALUES
(1, 'EMP-F-001', 'realestate', 'developer', 'senior', 'development', 'regular', '30000', '2017-07-02', '2017-11-10', '36');

-- --------------------------------------------------------

--
-- Table structure for table `fa_kv_empl_info`
--

CREATE TABLE `fa_kv_empl_info` (
  `id` int(5) NOT NULL,
  `empl_id` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `empl_salutation` varchar(9) COLLATE utf8_unicode_ci NOT NULL,
  `salutation_text` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `empl_firstname` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `empl_middlename` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `empl_lastname` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `addr_line1` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `addr_line2` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `correspondence_address` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `permanent_address` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `same_as_correspond_address` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `empl_city` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `empl_state` int(11) NOT NULL,
  `pincode` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `country` int(5) NOT NULL,
  `gender` int(2) NOT NULL,
  `date_of_birth` date NOT NULL,
  `age` int(3) NOT NULL,
  `marital_status` int(2) NOT NULL,
  `office_phone` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `home_phone` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `mobile_phone` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(2) NOT NULL,
  `empl_pic` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '...',
  `pf_number` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `pan_no` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `aadhaar_no` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `esi_no` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `pran_no` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `per_addr_line1` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `per_addr_line2` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `empl_per_city` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `per_country` int(11) NOT NULL,
  `empl_per_state` int(11) NOT NULL,
  `per_pincode` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `no_of_children` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `eligible_hra` varchar(11) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fa_kv_empl_info`
--

INSERT INTO `fa_kv_empl_info` (`id`, `empl_id`, `empl_salutation`, `salutation_text`, `empl_firstname`, `empl_middlename`, `empl_lastname`, `addr_line1`, `addr_line2`, `correspondence_address`, `permanent_address`, `same_as_correspond_address`, `empl_city`, `empl_state`, `pincode`, `country`, `gender`, `date_of_birth`, `age`, `marital_status`, `office_phone`, `home_phone`, `mobile_phone`, `email`, `status`, `empl_pic`, `pf_number`, `pan_no`, `aadhaar_no`, `esi_no`, `pran_no`, `per_addr_line1`, `per_addr_line2`, `empl_per_city`, `per_country`, `empl_per_state`, `per_pincode`, `no_of_children`, `eligible_hra`) VALUES
(1, 'EMP-F-004', '1', '', 'Om', 'Prakash', '', 'Qno.40, Tilatand Colony', '', '', '', '1', 'ttt', 1479, '800011', 99, 1, '2000-07-16', 19, 1, NULL, '6325778569', '1457889635', 'om@gmail.com', 1, '...', '', '', '', '', '', 'Qno.40, Tilatand Colony', '', 'ttt', 99, 1479, '800011', '', ''),
(33, 'EMP-F-001', '1', '', 'Bhupendara', '', '', 'patna', 'patna', '', '', '1', 'patna', 1479, '80001', 99, 1, '1989-12-08', 30, 1, NULL, '7982489235', '8287806737', '', 1, '...', '', '', '', '', '', 'patna', 'patna', 'patna', 99, 1479, '80001', '', ''),
(34, 'EMP-F-002', '1', '', 'Harilal', '', '', 'patna', 'patna', '', '', '1', 'patna', 1479, '80001', 99, 1, '1989-12-08', 30, 1, NULL, '7982489235', '8287806737', '', 1, '...', '', '', '', '', '', 'patna', 'patna', 'patna', 99, 1479, '80001', '', ''),
(35, 'EMP-F-003', '1', '', 'Nasim', '', '', 'patna', 'patna', '', '', '1', 'patna', 1479, '80001', 99, 1, '1989-12-08', 30, 1, NULL, '7982489235', '8287806737', '', 1, '...', '', '', '', '', '', 'patna', 'patna', 'patna', 99, 1479, '80001', '', ''),
(36, 'EMP-F-005', '3', '', 'Nusrath', 'Sohail', '', 'PWC', '', '', '', '1', '', 1479, '800001', 99, 1, '2000-07-17', 19, 1, NULL, '852336578', '5478996325', 'nusrath.amm@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '800001', '', ''),
(37, 'EMP-F-006', '4', '', 'Shazia', 'Rahman', '', 'PWC', '', '', '', '1', 'PWC', 1479, '800001', 99, 1, '2000-07-17', 19, 1, NULL, '3658997451', '1458778523', 'shazia.amm@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', 'PWC', 99, 1479, '800001', '', ''),
(38, 'EMP-F-007', '3', '', 'Somuya', 'Shukla', '', 'PWC', '', '', '', '1', '', 1479, '800001', 99, 1, '2000-07-17', 19, 1, NULL, '3698552147', '2578996324', 'smshukla53@gmail.com', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '800001', '', ''),
(39, 'EMP-F-008', '1', '', 'Dharmendra', 'Kumar', 'Singh', 'PWC', '', '', '', '1', 'Patna', 1479, '800001', 99, 1, '2000-07-17', 19, 1, NULL, '1478559683', '2578996325', 'drdksingh@gmail.com', 1, '...', '', '', '', '', '', 'PWC', '', 'Patna', 99, 1479, '800001', '', ''),
(40, 'EMP-F-009', '1', '', 'Yosha', 'Singh', '', 'PWC', '', '', '', '1', 'Patna', 1479, '800001', 99, 1, '2000-07-17', 19, 1, NULL, '5689332147', '9632558741', 'yoshasingh21@gmail.com', 1, '...', '', '', '', '', '', 'PWC', '', 'Patna', 99, 1479, '800001', '', ''),
(41, 'EMP-F-010', '1', '', 'Alok', 'John', '', 'PWC', '', '', '', '1', 'Patna', 1479, '800001', 99, 1, '2000-07-17', 19, 1, NULL, '258933658995', '2547889632', 'alok.amm@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', 'Patna', 99, 1479, '80001', '', ''),
(42, 'EMP-F-011', '3', '', 'Pallawi', '', '', 'PWC', '', '', '', '1', 'Patna', 1479, '800001', 99, 1, '2000-07-17', 19, 1, NULL, '', '2548663259', 'pallawi.bba@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', 'Patna', 99, 1479, '800001', '', ''),
(43, 'EMP-F-012', '1', '', 'Satnam', 'Kaur', '', 'PWC', '', '', '', '1', '', 1479, '800001', 99, 1, '2000-07-17', 19, 1, NULL, '', '1245778963', 'satnam.bba@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '800001', '', ''),
(44, 'EMP-F-013', '1', '', 'Norin', 'Raj', 'Lakra', 'PWC', '', '', '', '1', 'Patna', 1479, '800001', 99, 1, '2000-07-17', 19, 1, NULL, '', '2548336579', 'norinraj.bba@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', 'Patna', 99, 1479, '800001', '', ''),
(45, 'EMP-F-014', '1', '', 'Avinash', 'Vishal', '', 'PWC', '', '', '', '1', '', 1479, '800001', 99, 1, '2000-07-17', 19, 1, NULL, '', '5879632589', 'avinash_vishal9@yahoo.co.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '800001', '', ''),
(46, 'EMP-F-015', '3', '', 'Pinky', 'Prasad', '', 'PWC', '', '', '', '1', '', 1479, '800001', 99, 1, '2000-07-17', 19, 1, NULL, '', '523669878', 'pinky.bot@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '800001', '', ''),
(47, 'EMP-F-016', '3', '', 'Isha', 'Gaurav', '', 'PWC', '', '', '', '1', '', 1479, '800001', 99, 1, '2000-07-17', 19, 1, NULL, '', '56234587', 'ishagaurav86@gmail.com', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '800001', '', ''),
(48, 'EMP-F-017', '1', '', 'Hena', 'Naz', '', 'PWC', '', '', '', '1', '', 1479, '800001', 99, 1, '2000-07-17', 19, 1, NULL, '', '256899632', 'hena.bot@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '800001', '', ''),
(49, 'EMP-F-018', '1', '', 'Piyush', 'Kumar', 'Rai', 'PWC', '', '', '', '1', '', 1479, '800001', 99, 1, '2000-07-17', 19, 1, NULL, '', '85214458', 'raipiyush518@gmail.com', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '800001', '', ''),
(50, 'EMP-F-019', '1', '', 'Urvashi', 'Sinha', '', 'PWC', '', '', '', '1', '', 1479, '800001', 99, 1, '2000-07-17', 19, 1, NULL, '', '5632447895', 'urvashi.bot@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '800001', '', ''),
(51, 'EMP-F-020', '1', '', 'Anjana', 'Verma', '', 'PWC', '', '', '', '1', 'Patna', 1479, '800001', 99, 1, '2000-07-17', 19, 1, NULL, '', '4123669852', 'anjana.nath.verma@gmail.com', 1, '...', '', '', '', '', '', 'PWC', '', 'Patna', 99, 1479, '800001', '', ''),
(52, 'EMP-F-021', '1', '', 'Tauseef', 'Hassan', '', 'PWC', '', '', '', '1', '', 1479, '800001', 99, 1, '2000-07-17', 19, 1, NULL, '', '752366985', 'tauseef.cems@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '800001', '', ''),
(53, 'EMP-F-022', '1', '', 'Ashrita', 'Kandulna', '', 'PWC', '', '', '', '1', '', 1479, '800001', 99, 1, '2000-07-17', 19, 1, NULL, '', '5214556328', 'ashrita.cems@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '800001', '', ''),
(54, 'EMP-F-023', '1', '', 'Frank', 'Krishner', '', 'PWC', '', '', '', '1', 'Patna', 1479, '800001', 99, 1, '2000-07-17', 19, 1, NULL, '', '5231669875', 'act.patna@gmail.com', 1, '...', '', '', '', '', '', 'PWC', '', 'Patna', 99, 1479, '800001', '', ''),
(55, 'EMP-F-024', '1', '', 'Amitabh', 'Ranjan', '', 'PWC', '', '', '', '1', '', 1479, '800001', 99, 1, '2000-07-17', 19, 1, NULL, '', '584556327', 'amitabh.cems@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '800001', '', ''),
(56, 'EMP-F-025', '1', '', 'Runa', '', '', 'PWC', '', '', '', '1', '', 1479, '800001', 99, 1, '2000-07-17', 19, 1, NULL, '', '9823665478', 'runa.cems@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '800001', '', ''),
(57, 'EMP-F-026', '1', '', 'Madhu', 'Rani', 'Sinha', 'PWC', '', '', '', '1', '', 1479, '800001', 99, 1, '2000-07-17', 19, 1, NULL, '', '2545889632', 'madhu.che@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '800001', '', ''),
(58, 'EMP-F-027', '1', '', 'Ashish', 'Kumar', '', 'PWC', '', '', '', '1', 'Patna', 1479, '800001', 99, 1, '2000-07-17', 19, 1, NULL, '', '2654772365', 'ashish.che@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', 'Patna', 99, 1479, '800001', '', ''),
(59, 'EMP-F-028', '1', '', 'Jyoti', 'Chandra', '', 'PWC', '', '', '', '1', '', 1479, '800001', 99, 1, '2000-07-17', 19, 1, NULL, '', '584122369', 'jyoti.che@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '800001', '', ''),
(60, 'EMP-F-029', '1', '', 'Kumari', 'Jyotsna', '', 'PWC', '', '', '', '1', 'Patna', 1479, '800001', 99, 1, '2000-07-17', 19, 1, NULL, '', '23654789', 'jyotsna.che@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', 'Patna', 99, 1479, '800001', '', ''),
(61, 'EMP-F-030', '1', '', 'Nandini', 'Nandini', '', 'PWC', '', '', '', '1', '', 1479, '800001', 99, 1, '2000-07-17', 19, 1, NULL, '', '22333', 'nandini.che@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '800001', '', ''),
(62, 'EMP-F-031', '1', '', 'Amita', 'Prasad', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-17', 19, 1, NULL, '', '111', 'amita.che@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(63, 'EMP-F-032', '3', '', 'Soofia', 'Fatima', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-17', 19, 1, NULL, '', '111', 'soofia.bcom@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(64, 'EMP-F-033', '1', '', 'Puja', 'Kumari', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-17', 19, 1, NULL, '', '111', 'puja.com@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(65, 'EMP-F-034', '1', '', 'Pallavi', '', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-17', 19, 1, NULL, '', '111', 'pallavi.bcom@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(66, 'EMP-F-035', '1', '', 'Kirti', 'Kamal', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-17', 19, 1, NULL, '', '111', 'kirti.bcom@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(67, 'EMP-F-036', '1', '', 'Rena', 'Kumari', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-17', 19, 1, NULL, '', '111', 'reena.com@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(68, 'EMP-F-037', '1', '', 'Sagarika', 'Sagarika', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-17', 19, 1, NULL, '', '451', 'sagarika.com@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(69, 'EMP-F-038', '1', '', 'Shweta', 'Shah', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-17', 19, 1, NULL, '', '111', 'shweta.bcom@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(70, 'EMP-F-039', '1', '', 'Manisha', 'Prasad', '', 'PWC', '', '', '', '1', 'Patna', 1479, '', 99, 1, '2000-07-21', 19, 1, NULL, '', '111', 'manisha.bca@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', 'Patna', 99, 1479, '', '', ''),
(71, 'EMP-F-040', '1', '', 'Nimisha', 'Manan', '', 'PWC', '', '', '', '1', 'Patna', 1479, '', 99, 1, '2000-07-21', 19, 1, NULL, '', '12321', 'nimisha.bca@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', 'Patna', 99, 1479, '', '', ''),
(72, 'EMP-F-041', '1', '', 'Anshu', '', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-21', 19, 1, NULL, '', '231', 'anshu.bca@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(73, 'EMP-F-042', '1', '', 'Amrita', 'Prakash', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-21', 19, 1, NULL, '', '213', 'amrita.bca@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(74, 'EMP-F-043', '1', '', 'Deepa', 'Sonal', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-21', 19, 1, NULL, '', '2144', 'deepa.bca@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(75, 'EMP-F-044', '1', '', 'Renu', 'Kumari', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-21', 19, 1, NULL, '', '111', 'renu.bca@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(76, 'EMP-F-045', '1', '', 'Ajit', 'Singh', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-21', 19, 1, NULL, '', '231', 'ajit_singh24@yahoo.com', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(77, 'EMP-F-046', '1', '', 'Sudhir', 'Sinha', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-21', 19, 1, NULL, '', '1123', 'sudhirji.sinha67@gmail.com', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(78, 'EMP-F-047', '1', '', ' Shemushi', 'Ityalam', 'Madhu', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-21', 19, 1, NULL, '', '113', 'shemushiityalam.pgdfd@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(79, 'EMP-F-048', '1', '', 'Geetanjali', 'Chaudhary', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-21', 19, 1, NULL, '', '225', 'geetanjalikr2013@gmail.com', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(80, 'EMP-F-049', '1', '', 'Asha', 'Pandey', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-21', 19, 1, NULL, '', '1212', 'ashapandeydesigns@gmail.com', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(81, 'EMP-F-050', '1', '', 'Purnima', 'Roy', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-21', 19, 1, NULL, '', '11', 'purnima.pgdfd@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(82, 'EMP-F-051', '1', '', 'Priyanka', 'Singh', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-21', 19, 1, NULL, '', '1231', 'deepti.priyanka25@gmail.com', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(83, 'EMP-F-052', '1', '', 'Vandana', 'Sinha', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-21', 19, 1, NULL, '', '1231', 'vandani09@gmail.com', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(84, 'EMP-F-053', '1', '', 'Sister M', 'Dipasha A.C.', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-21', 19, 1, NULL, '', '231', 'dipasha.eco@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(85, 'EMP-F-054', '1', '', 'Priti', 'Kumari', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-21', 19, 1, NULL, '', '241', 'priti.eco@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(86, 'EMP-F-055', '1', '', 'Monica', '', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-21', 19, 1, NULL, '', '244', 'monicadeepak26@gmail.com', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(87, 'EMP-F-056', '1', '', 'Zareen', 'Fatima', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-21', 19, 1, NULL, '', '124', 'zareen.eco@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(88, 'EMP-F-057', '1', '', 'Veena', 'Kumari', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-21', 19, 1, NULL, '', '2432', 'veena.eco@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(89, 'EMP-F-058', '1', '', 'Sanjay', 'Srivastava', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-21', 19, 1, NULL, '', '2321', 'sanjay.eco@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(90, 'EMP-F-059', '1', '', 'Upasana', 'Singh', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-21', 19, 1, NULL, '', '123', 'upasana.edu@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(91, 'EMP-F-060', '1', '', 'Babli', 'Roy', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-21', 19, 1, NULL, '', '2312', 'babli.edu@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(92, 'EMP-F-061', '4', '', 'Madhumita', '', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-21', 19, 1, NULL, '', '122', 'madhumita.edu@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(93, 'EMP-F-062', '1', '', 'Sister', 'Saroj', 'A,C', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-21', 19, 1, NULL, '', '212', 'saroj.edu@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(94, 'EMP-F-063', '4', '', 'Anju', 'Gandhi', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-21', 19, 1, NULL, '', '123', 'anju.edu@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(95, 'EMP-F-064', '1', '', 'Prabhas', 'Ranjan', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-21', 19, 1, NULL, '', '123', 'prabhas.edu@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(96, 'EMP-F-065', '1', '', 'MadhuSmita', 'Singh', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-21', 19, 1, NULL, '', '1321', 'madhu.edu@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(97, 'EMP-F-066', '1', '', 'Rashmi', 'Sinha', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-21', 19, 1, NULL, '', '234', 'rashmi.edu@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(98, 'EMP-F-067', '1', '', 'Yamini', 'Yamini', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-21', 19, 1, NULL, '', '2134', 'yamini.edu@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(99, 'EMP-F-068', '1', '', 'Sister', 'Sylvie', 'A.C', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-21', 19, 1, NULL, '', '868', 'sylviecarmel@gmail.com', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(100, 'EMP-F-069', '1', '', 'Shahla', 'Rehana', '', 'PWC', '', '', '', '', '', 1475, '', 99, 1, '2000-07-21', 19, 1, NULL, '', '24', 'shahla.eng@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(101, 'EMP-F-070', '1', '', 'Sister', 'Nelsa A.C.', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-21', 19, 1, NULL, '', '123', 'nelsa.eng@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(102, 'EMP-F-071', '1', '', 'Sahar', 'Rehman', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-21', 19, 1, NULL, '', '121', 'sahar.eng@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(103, 'EMP-F-072', '4', '', 'Muniba', 'Sami', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-21', 19, 1, NULL, '', '1321', 'dr.munibasami@gmail.com', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(104, 'EMP-F-073', '1', '', 'Devina', 'Krishna', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-21', 19, 1, NULL, '', '121', 'devina.eng@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(105, 'EMP-F-074', '1', '', 'Nikhila', 'Narayanan', '', 'PWC', '', '', '', '1', '', 1475, '', 99, 1, '2000-07-21', 19, 1, NULL, '', '212', 'nikhila.eng@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1475, '', '', ''),
(106, 'EMP-F-075', '1', '', 'Apurba', 'Paul', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-21', 19, 1, NULL, '', '21', 'apurba.eng@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(107, 'EMP-F-076', '1', '', 'Richa', '', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-21', 19, 1, NULL, '', '213', 'richa.eng@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(108, 'EMP-F-077', '1', '', 'Deepika', 'Tiwari', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-21', 19, 1, NULL, '', '23', 'deepika.eng@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(109, 'EMP-F-078', '1', '', 'Papita', 'Dey', 'Biswas', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-21', 19, 1, NULL, '', '23', 'Enakshi.art@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(110, 'EMP-F-079', '1', '', 'Debjani', 'Sarkar', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-21', 19, 1, NULL, '', '2321', 'debjani.geog@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(111, 'EMP-F-080', '1', '', 'Neha', 'Singh', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-21', 19, 1, NULL, '', '231', 'neha.geog@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(112, 'EMP-F-081', '1', '', 'Sister', 'Anna A.C.', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-21', 19, 1, NULL, '', '123', 'anna.geog@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(113, 'EMP-F-082', '1', '', 'Amrita', 'Chowdhury', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-21', 19, 1, NULL, '', '234', 'amrita.geog@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(114, 'EMP-F-083', '1', '', 'Meenakshi', 'Mishra', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-21', 19, 1, NULL, '', '87', 'meenakshi.geog@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(115, 'EMP-F-084', '1', '', 'Aishwarya', 'Raj', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-21', 19, 1, NULL, '', '2131', 'aishwarya.geog@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(116, 'EMP-F-085', '1', '', 'Manjula', 'Sushila', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-21', 19, 1, NULL, '', '212', 'manjula.hindi@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(117, 'EMP-F-086', '1', '', 'Neha', 'Sinha', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-21', 19, 1, NULL, '', '886', 'nehanishisinha@gmail.com', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(118, 'EMP-F-087', '1', '', 'Sushma', 'Choubey', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-21', 19, 1, NULL, '', '355', 'Sushma.hindi@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(119, 'EMP-F-088', '1', '', 'Kumar', 'Dhananjay', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-21', 19, 1, NULL, '', '213', 'Dhananjay.hindi@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(120, 'EMP-F-089', '1', '', 'Deepa', 'Srivastava', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-21', 19, 1, NULL, '', '234', 'deepa.hindi@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(121, 'EMP-F-090', '1', '', 'Sister Celine', 'Crasta A.C', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-21', 19, 1, NULL, '', '24', 'celine.hist@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(122, 'EMP-F-091', '4', '', 'Priyanka', 'R', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-22', 19, 1, NULL, '', '1321', 'priyanka.hist@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(123, 'EMP-F-092', '4', '', 'Sangeeta', 'Saxena', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-22', 19, 1, NULL, '', '2342', 'sangeetakhlesh@gmail.com', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(124, 'EMP-F-093', '2', '', 'Shreya', 'Singh', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-22', 19, 1, NULL, '', '1321', 'shreyajaisingh311@gmail.com', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(125, 'EMP-F-094', '1', '', 'Prathibha', 'Singh', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-22', 19, 1, NULL, '', '123', 'pratibhasinghvarsha@gmail.com', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(126, 'EMP-F-095', '1', '', 'Sister M', 'Tanisha A.C.', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-22', 19, 1, NULL, '', '1213', 'tanisha.hsc@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(127, 'EMP-F-096', '1', '', 'Suniti', 'Bhagat', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-22', 19, 1, NULL, '', '123', 'suniti.hsc@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(128, 'EMP-F-097', '1', '', 'Shazia', 'Husain', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-22', 19, 1, NULL, '', '133', 'shazia.hsc@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(129, 'EMP-F-098', '1', '', 'Nisha', 'Kumari', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-22', 19, 1, NULL, '', '213', 'nisharoshan4195@gmail.com', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(130, 'EMP-F-099', '1', '', 'Rosy', 'Kumari', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-22', 19, 1, NULL, '', '133', 'rosy.hsc@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(131, 'EMP-f-100', '1', '', 'Sunita', 'Kumari', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-22', 19, 1, NULL, '', '132', 'sunita.hsc@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(132, 'EMP-f-101', '1', '', 'Priyanka', 'Shankar', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-22', 19, 1, NULL, '', '123', 'priyanka.hsc@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(133, 'EMP-f-102', '1', '', 'Minati', 'Chaklanavis', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-22', 19, 1, NULL, '', '213', 'minati.bmc@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(134, 'EMP-f-103', '1', '', 'Ajay', 'Kumar', 'Jha', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-22', 19, 1, NULL, '', '133333', 'ajaykumarjha24@gmail.com', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(135, 'EMP-f-104', '1', '', 'Vikash', 'Kumar', 'Mishra', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-22', 19, 1, NULL, '', '123', 'vikashkr.mishra28@gmail.com', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(136, 'EMP-f-105', '1', '', 'Roma', '', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-22', 19, 1, NULL, '', '123', 'roma.bmc@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(137, 'EMP-f-106', '1', '', 'Prashant', 'Ravi', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-22', 19, 1, NULL, '', '123', 'prashantravi27@gmail.com', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(138, 'EMP-f-107', '4', '', 'Alka', 'Kumari', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-22', 19, 1, NULL, '', '123', 'alka.math@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(139, 'EMP-f-108', '4', '', 'Chhaya', 'Gangwal', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-22', 19, 1, NULL, '', '14', 'chhayapunia@gmail.com', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(140, 'EMP-f-109', '1', '', 'Ravi', 'Kumar', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-22', 19, 1, NULL, '', '123', 'kumar.ravi.iitg@gmail.com', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(141, 'EMP-f-110', '4', '', 'Abhay', 'Kumar', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-22', 19, 1, NULL, '', '123', 'abhaykr378@gmail.com', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(142, 'EMP-f-111', '4', '', 'Seema', 'Mishra', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-22', 19, 1, NULL, '', '123', 'seema.math@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(143, 'EMP-f-112', '4', '', 'Bhawna', 'Sinha', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-22', 19, 1, NULL, '', '123', 'bhawna.mca@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(144, 'EMP-F-113', '1', '', 'Poonam', 'Abraham', 'Lakra', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-22', 19, 1, NULL, '', '123', 'poonam.mca@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(145, 'EMP-f-114', '1', '', 'Braj Kishore', 'Prasad', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-22', 19, 1, NULL, '', '123', 'brajkishore.mca@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(146, 'EMP-F-115', '1', '', 'Sushmita', 'Chakraborty', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-22', 19, 1, NULL, '', '123', 'sushmita.mca@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(147, 'EMP-f-116', '4', '', 'Tapan', 'Kant', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-22', 19, 1, NULL, '', '123', 'tapan.mca@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(148, 'EMP-f-117', '1', '', 'Hera', 'Shaheen', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-22', 19, 1, NULL, '', '123', 'hera.mca@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(149, 'EMP-f-118', '1', '', 'Praveen', 'Kumar', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-22', 19, 1, NULL, '', '123', 'praveen.mca@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(150, 'EMP-f-119', '1', '', 'Jaya', 'Philip', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-22', 19, 1, NULL, '', '123', 'jaya.mbio@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(151, 'EMP-f-120', '4', '', 'Shilpi', 'Kiran', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-22', 19, 1, NULL, '', '1243', 'shilpi.mbio@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(152, 'EMP-f-121', '1', '', 'Arti', 'Kumari', 'Microbiology', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-22', 19, 1, NULL, '', '123', 'arti.mbio@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(153, 'EMP-f-122', '1', '', 'Preeti', 'Swarupa', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-22', 19, 1, NULL, '', '13', 'preeti.mbio@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(154, 'EMP-f-123', '1', '', 'Satyamvada', 'Swayamprabha', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-22', 19, 1, NULL, '', '123', 'satyamvada.mbio@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(155, 'EMP-f-124', '4', '', 'Niti', 'Yashvardhini', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-22', 19, 1, NULL, '', '1213', 'niti.mbio@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(156, 'EMP-f-125', '1', '', 'Ameeta', 'Jaiswal', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-22', 19, 1, NULL, '', '123', 'ameeta.phi@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(157, 'EMP-f-126', '2', '', 'Shyam', 'Priya', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-22', 19, 1, NULL, '', '123', 'shyaampriya@gmail.com', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(158, 'EMP-f-127', '4', '', 'Kumkum', 'Rani', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-22', 19, 1, NULL, '', '123', 'kumkum.phi@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(159, 'EMP-f-128', '4', '', 'Aprajita', 'Krishna', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-22', 19, 1, NULL, '', '123', 'aprajita.phy@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(160, 'EMP-f-129', '4', '', 'Rohit', 'Singh', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-22', 19, 1, NULL, '', '124', 'rohit.phy@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(161, 'EMP-f-130', '1', '', 'Riekshika', 'Sanwari', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-22', 19, 1, NULL, '', '123', 'riekshikasanwari@gmail.com', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(162, 'EMP-f-131', '1', '', 'Amrita', 'Singh', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-22', 19, 1, NULL, '', '123', 'amrita.phy@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(163, 'EMP-f-132', '4', '', 'Kavita', 'Verma', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-22', 19, 1, NULL, '', '13', 'kavita.phy@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(164, 'EMP-f-133', '1', '', 'Vinita', 'Priyedarshi', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-22', 19, 1, NULL, '', '123', 'vinita.pol@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(165, 'EMP-f-134', '1', '', 'Fiza', 'Darakshan', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-22', 19, 1, NULL, '', '133', 'fabfiza@gmail.com', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(166, 'EMP-f-135', '1', '', 'Garima', 'Das', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-22', 19, 1, NULL, '', '123', 'garima.ds@gmail.com', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(167, 'EMP-f-136', '1', '', 'Bhanu', 'Pratap', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-22', 19, 1, NULL, '', '123', 'bhanu92in@gmail.com', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(168, 'EMP-f-137', '1', '', 'Sister M', 'Reema A.C.', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-22', 19, 1, NULL, '', '123', 'reema.psy@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(169, 'EMP-f-138', '1', '', 'Vinita', 'Kochgaway', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-22', 19, 1, NULL, '', '1223', 'vinita.psy@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(170, 'EMP-F-139', '1', '', 'Mukta', 'Mrinalini', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-22', 19, 1, NULL, '', '13', 'mukta.psy@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(171, 'EMP-F-140', '1', '', 'Nupur', 'Sinha', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-22', 19, 1, NULL, '', '123', 'nupur.psy@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(172, 'EMP-F-141', '1', '', 'Shruti', 'Narain', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-22', 19, 1, NULL, '', '123', 'shruti.psy@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(173, 'EMP-F-142', '4', '', 'Neena', 'Verma', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-22', 19, 1, NULL, '', '123', 'neenaverma55@gmail.com', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(174, 'EMP-F-143', '4', '', 'Tapashi', 'Bhattacharjee', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-22', 19, 1, NULL, '', '124', 'tapashibhattacharjee63@gmail.com', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(175, 'EMP-F-144', '1', '', 'Chandini', 'Sinha', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-22', 19, 1, NULL, '', '123', 'chandini.soc@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(176, 'EMP-F-145', '1', '', 'Tahera', 'Khatoon', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-22', 19, 1, NULL, '', '1432', 'taherarahmani@gmail.com', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(177, 'EMP-F-146', '1', '', 'Sister', 'M.Jincy A.C.', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-22', 19, 1, NULL, '', '123', 'jincy.soc@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(178, 'EMP-F-147', '1', '', 'Ragini', 'Ranjan', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-22', 19, 1, NULL, '', '13', 'ragini.soc@patnawomenscollege.com', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(179, 'EMP-F-148', '1', '', 'Samiksha', 'Sinha', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-22', 19, 1, NULL, '', '123', 'samiksha.sinha.007@gmail.com', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(180, 'EMP-F-149', '1', '', 'Chandni', 'Sinha', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-22', 19, 1, NULL, '', '123', 'chandnisinha2011@gmail.com', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(181, 'EMP-F-150', '1', '', 'Moon', '', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-22', 19, 1, NULL, '', '133', 'moon.stat@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(182, 'EMP-F-151', '1', '', 'Nishtha', 'Bhardwaj', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-22', 19, 1, NULL, '', '123', 'nishthabhardwaj2050@gmail.com', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(183, 'EMP-F-152', '1', '', 'Vijay', 'Kumar', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-22', 19, 1, NULL, '', '133', 'vijay.stat@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(184, 'EMP-F-153', '1', '', 'Bhavna', 'Kumari', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-22', 19, 1, NULL, '', '123', 'bhavna.kumari43@gmail.com', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(185, 'EMP-F-154', '4', '', 'Saurabh', '', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-22', 19, 1, NULL, '', '123', 'saurabh.stat@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(186, 'EMP-F-155', '1', '', 'Shahla', 'Yasmin', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-22', 19, 1, NULL, '', '123', 'shahla.zoo@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(187, 'EMP-F-156', '1', '', 'Anupma', 'Kumari', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-22', 19, 1, NULL, '', '123', 'anupma.zoo@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(188, 'EMP-F-157', '1', '', 'Sister M', 'Stuti A.C', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-22', 19, 1, NULL, '', '1233', 'stuti.zoo@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(189, 'EMP-F-158', '1', '', 'Amresh', 'Kumar', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-22', 19, 1, NULL, '', '123', 'amresh27@gmail.com', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(190, 'EMP-F-159', '1', '', 'Sapna', 'Kumari', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-22', 19, 1, NULL, '', '113', 'me.sap11@gmail.com', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(191, 'EMP-F-160', '1', '', 'Anupma', 'Kumari', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-22', 19, 1, NULL, '', '12', 'anupmakumari11@gmail.com', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(192, 'EMP-F-161', '1', '', 'Sumeet', 'Ranjan', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-22', 19, 1, NULL, '', '12', 'sumeet.crl@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(193, 'EMP-F-162', '1', '', 'Rajeev', 'Ranjan', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-22', 19, 1, NULL, '', '123', 'rajeevr17890@gmail.com', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(194, 'EMP-F-163', '1', '', 'Shobha', 'Shrivastava', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-07-22', 19, 1, NULL, '', '12', 'shrivastava.shobha07@gmail.com', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(195, 'EMP-F-164', '2', '', 'Smita', 'Kumari', '', 'PWC', '', '', '', '1', '', 1479, '800001', 99, 1, '2000-07-17', 19, 1, NULL, '852336578', '5478996324', 'smita.san@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '800001', '', ''),
(196, 'EMP-F-165', '1', '', 'Manu', 'Priya', '', 'PWC', '', '', '', '1', 'Patna', 1479, '800001', 99, 1, '2000-07-17', 19, 1, NULL, '', '2548663259', 'manupriya8055@gmail.com', 1, '...', '', '', '', '', '', 'PWC', '', 'Patna', 99, 1479, '800001', '', ''),
(197, 'EMP-F-166', '1', '', 'Mridul', 'Mishra', '', 'PWC', '', '', '', '1', 'Patna', 1479, '800001', 99, 1, '2000-07-17', 19, 1, NULL, '', '2548336579', 'mmridul661@gmail.com', 1, '...', '', '', '', '', '', 'PWC', '', 'Patna', 99, 1479, '800001', '', ''),
(198, 'EMP-F-167', '1', '', 'IM', 'Das', '', 'PWC', '', '', '', '1', '', 1479, '800001', 99, 1, '2000-07-17', 19, 1, NULL, '', '5214556328', 'i.m.das@outlook.com', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '800001', '', ''),
(199, 'EMP-F-168', '1', '', 'Deep', 'Shikha', '', 'PWC', '', '', '', '1', '', 1479, '800001', 99, 1, '2000-07-17', 19, 1, NULL, '', '584556327', 'deepshikha459@gmail.com', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '800001', '', ''),
(200, 'EMP-F-169', '1', '', 'Sr', 'Esly', '', 'PWC', '', '', '', '1', '', 1479, '800001', 99, 1, '2000-07-17', 19, 1, NULL, '', '584556327', 'elsy.office@patnawomenscollege.in', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '800001', '', ''),
(201, 'EMP-f-170', '1', '', 'Soofia', 'H.O.D', '', 'PWC', '', '', '', '1', '', 1479, '', 99, 1, '2000-12-25', 19, 1, NULL, '9079003238', '9079003238', 'hod@finesse.com', 1, '...', '', '', '', '', '', 'PWC', '', '', 99, 1479, '', '', ''),
(202, 'EMP-f-171', '1', '', 'test user', '', 'user', 'patna', 'patna', '', '', '1', '', 1479, '', 99, 1, '2001-04-05', 19, 1, NULL, '09874563210', '9874563210', 'test@gmail.com', 1, '...', '', '', '', '', '', 'patna', 'patna', 'patna', 99, 1479, '80001', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `fa_kv_empl_job`
--

CREATE TABLE `fa_kv_empl_job` (
  `id` int(10) NOT NULL,
  `empl_id` varchar(10) NOT NULL,
  `employee_type` int(11) NOT NULL,
  `eligible_hra` int(11) NOT NULL,
  `grade` tinyint(2) NOT NULL,
  `department` tinyint(2) NOT NULL,
  `desig_group` tinyint(2) NOT NULL,
  `desig` varchar(40) NOT NULL,
  `joining` date NOT NULL,
  `empl_type` tinyint(2) NOT NULL,
  `working_branch` tinyint(2) NOT NULL,
  `mod_of_pay` int(2) NOT NULL,
  `ifsc_code` varchar(100) NOT NULL,
  `bank_name` varchar(40) NOT NULL,
  `act_holder_name` varchar(150) DEFAULT NULL,
  `acc_no` varchar(30) NOT NULL,
  `gross_pay_annum` int(20) NOT NULL,
  `gross` varchar(10) DEFAULT NULL,
  `5` varchar(15) DEFAULT NULL,
  `6` varchar(15) DEFAULT NULL,
  `2` varchar(15) DEFAULT NULL,
  `3` varchar(15) DEFAULT NULL,
  `4` varchar(15) DEFAULT NULL,
  `1` varchar(11) DEFAULT NULL,
  `8` varchar(11) DEFAULT NULL,
  `contract_end_date` varchar(100) DEFAULT NULL,
  `contract_duration` varchar(100) DEFAULT '0',
  `10` varchar(15) DEFAULT NULL,
  `12` varchar(15) DEFAULT NULL,
  `13` varchar(10) DEFAULT NULL,
  `14` varchar(10) DEFAULT NULL,
  `15` varchar(10) DEFAULT NULL,
  `16` varchar(10) DEFAULT NULL,
  `17` varchar(10) DEFAULT NULL,
  `18` varchar(10) DEFAULT NULL,
  `19` varchar(10) DEFAULT NULL,
  `20` varchar(10) DEFAULT NULL,
  `21` varchar(10) DEFAULT NULL,
  `22` varchar(10) DEFAULT NULL,
  `23` varchar(10) DEFAULT NULL,
  `24` varchar(10) DEFAULT NULL,
  `25` varchar(10) DEFAULT NULL,
  `26` varchar(10) DEFAULT NULL,
  `27` varchar(10) DEFAULT NULL,
  `28` varchar(10) DEFAULT NULL,
  `29` varchar(10) DEFAULT NULL,
  `30` varchar(10) DEFAULT NULL,
  `31` varchar(10) DEFAULT NULL,
  `32` varchar(10) DEFAULT NULL,
  `33` varchar(10) DEFAULT NULL,
  `34` varchar(10) DEFAULT NULL,
  `35` varchar(10) DEFAULT NULL,
  `36` varchar(10) DEFAULT NULL,
  `37` varchar(10) DEFAULT NULL,
  `38` varchar(10) DEFAULT NULL,
  `pre_basic_pay` int(10) DEFAULT 0,
  `pre_grade_pay` int(10) DEFAULT 0,
  `pre_da` int(10) DEFAULT 0,
  `pre_hra` int(10) DEFAULT 0,
  `pre_conveyance` int(10) DEFAULT 0,
  `pre_sas` int(10) DEFAULT 0,
  `pre_prof_tax` int(10) DEFAULT 0,
  `pre_pf` int(10) DEFAULT 0,
  `pre_tds` int(10) DEFAULT 0,
  `pre_financial_year` tinyint(4) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 0,
  `ctc` double DEFAULT 0,
  `39` varchar(10) DEFAULT NULL,
  `40` varchar(10) DEFAULT NULL,
  `41` varchar(10) DEFAULT NULL,
  `42` varchar(10) DEFAULT NULL,
  `43` varchar(10) DEFAULT NULL,
  `44` varchar(10) DEFAULT NULL,
  `45` varchar(10) DEFAULT NULL,
  `46` varchar(10) DEFAULT NULL,
  `47` varchar(10) DEFAULT NULL,
  `48` varchar(10) DEFAULT NULL,
  `49` varchar(10) DEFAULT NULL,
  `50` varchar(11) DEFAULT NULL,
  `51` varchar(11) DEFAULT NULL,
  `52` varchar(11) DEFAULT NULL,
  `eligible_esi` tinyint(4) DEFAULT 0,
  `effective_date` varchar(100) DEFAULT '0000-00-00',
  `0` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fa_kv_empl_job`
--

INSERT INTO `fa_kv_empl_job` (`id`, `empl_id`, `employee_type`, `eligible_hra`, `grade`, `department`, `desig_group`, `desig`, `joining`, `empl_type`, `working_branch`, `mod_of_pay`, `ifsc_code`, `bank_name`, `act_holder_name`, `acc_no`, `gross_pay_annum`, `gross`, `5`, `6`, `2`, `3`, `4`, `1`, `8`, `contract_end_date`, `contract_duration`, `10`, `12`, `13`, `14`, `15`, `16`, `17`, `18`, `19`, `20`, `21`, `22`, `23`, `24`, `25`, `26`, `27`, `28`, `29`, `30`, `31`, `32`, `33`, `34`, `35`, `36`, `37`, `38`, `pre_basic_pay`, `pre_grade_pay`, `pre_da`, `pre_hra`, `pre_conveyance`, `pre_sas`, `pre_prof_tax`, `pre_pf`, `pre_tds`, `pre_financial_year`, `status`, `ctc`, `39`, `40`, `41`, `42`, `43`, `44`, `45`, `46`, `47`, `48`, `49`, `50`, `51`, `52`, `eligible_esi`, `effective_date`, `0`) VALUES
(21, 'EMP-F-001', 1, 1, 0, 2, 7, '15', '2020-01-01', 2, 1, 1, '', 'sbi ', '', '9874563210', 360000, '30000', NULL, NULL, NULL, NULL, '4800', '12000', NULL, '', '', '', '1440', '', '', '', '', '', '', '', '', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, '30000', '', '1357', NULL, '1357', '', NULL, '', '10403', NULL, '500', NULL, '', '1440', 1, '0000-00-00', 0),
(22, 'EMP-F-002', 1, 1, 0, 2, 7, '15', '2020-01-01', 2, 1, 1, '', 'sbi ', '', '9874563210', 360000, '30000', NULL, NULL, NULL, NULL, '4800', '12000', NULL, '', '', '', '1440', '', '', '', '', '', '', '', '', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, '30000', '', '1357', NULL, '1357', '', NULL, '', '10403', NULL, '500', NULL, '', '1440', 1, '0000-00-00', 0),
(23, 'EMP-F-003', 1, 1, 0, 2, 7, '15', '2020-01-01', 2, 1, 1, '', 'sbi ', '', '9874563210', 360000, '30000', NULL, NULL, NULL, NULL, '4800', '12000', NULL, '', '', '', '1440', '', '', '', '', '', '', '', '', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, '30000', '', '1357', NULL, '1357', '', NULL, '', '10403', NULL, '500', NULL, '', '1440', 1, '0000-00-00', 0),
(24, 'EMP-F-004', 1, 1, 0, 1, 2, '3', '2020-07-16', 2, 1, 1, '', 'sbi', '', '356987743', 1200000, '100000', NULL, NULL, NULL, NULL, '16000', '40000', NULL, '', '', '', '1800', '', '', '', '', '', '', '', '', '', NULL, '', '', '', '', '', '', '150000', '', '', '', '', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 5, 0, 0, '100000', '', '', NULL, '0', '', NULL, '', '42200', NULL, '0', NULL, '', '1800', 2, '2021-12-10', 0),
(25, 'EMP-F-005', 1, 1, 0, 1, 1, '11', '2020-07-17', 1, 1, 1, '', 'SBI', '', '2457899', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(26, 'EMP-F-006', 1, 1, 0, 1, 1, '11', '2020-07-17', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(27, 'EMP-F-007', 1, 1, 0, 1, 1, '11', '2020-07-17', 2, 1, 1, '', 'SBI', '', '124566', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(28, 'EMP-F-008', 1, 1, 0, 1, 1, '11', '2020-07-17', 2, 1, 1, '', 'SBI', '', '124566', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(29, 'EMP-F-009', 1, 1, 0, 1, 1, '11', '2020-07-17', 2, 1, 1, '', 'SBI', '', '124566', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(30, 'EMP-F-010', 1, 1, 0, 1, 1, '11', '2020-07-17', 2, 1, 1, '', 'SBI', '', '124566', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(31, 'EMP-F-011', 1, 1, 0, 1, 1, '11', '2020-07-17', 2, 1, 1, '', 'SBI', '', '124566', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(32, 'EMP-F-012', 1, 1, 0, 1, 1, '11', '2020-07-17', 2, 1, 1, '', 'SBI', '', '124566', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(33, 'EMP-F-013', 1, 1, 0, 1, 1, '11', '2020-07-17', 2, 1, 1, '', 'SBI', '', '124566', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(34, 'EMP-F-014', 1, 1, 0, 1, 1, '11', '2020-07-17', 1, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(35, 'EMP-F-015', 1, 1, 0, 1, 1, '11', '2020-07-17', 1, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(36, 'EMP-F-016', 1, 1, 0, 1, 1, '11', '2020-07-17', 1, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(37, 'EMP-F-017', 1, 1, 0, 1, 1, '11', '2020-07-17', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(38, 'EMP-F-018', 1, 1, 0, 1, 1, '11', '2020-07-17', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(39, 'EMP-F-019', 1, 1, 0, 1, 1, '11', '2020-07-17', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(40, 'EMP-F-020', 1, 1, 0, 1, 1, '11', '2020-07-17', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(41, 'EMP-F-021', 1, 1, 0, 1, 1, '11', '2020-07-17', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(42, 'EMP-F-022', 1, 1, 0, 1, 1, '11', '2020-07-17', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(43, 'EMP-F-023', 1, 1, 0, 1, 1, '11', '2020-07-17', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(44, 'EMP-F-024', 1, 1, 0, 1, 1, '11', '2020-07-17', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(45, 'EMP-F-025', 1, 1, 0, 1, 1, '11', '2020-07-17', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(46, 'EMP-F-026', 1, 1, 0, 1, 1, '11', '2020-07-17', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(47, 'EMP-F-027', 1, 1, 0, 1, 1, '11', '2020-07-17', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(48, 'EMP-F-028', 1, 1, 0, 1, 1, '11', '2020-07-17', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(49, 'EMP-F-029', 1, 1, 0, 1, 1, '11', '2020-07-17', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(50, 'EMP-F-030', 1, 1, 0, 1, 1, '11', '2020-07-17', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(51, 'EMP-F-031', 1, 1, 0, 1, 1, '11', '2020-07-17', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(52, 'EMP-F-032', 1, 1, 0, 1, 1, '11', '2020-07-17', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(53, 'EMP-F-033', 1, 1, 0, 1, 1, '11', '2020-07-17', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(54, 'EMP-F-034', 1, 1, 0, 1, 1, '11', '2020-07-17', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(55, 'EMP-F-035', 1, 1, 0, 1, 1, '11', '2020-07-17', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(56, 'EMP-F-036', 1, 1, 0, 1, 1, '11', '2020-07-17', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(57, 'EMP-F-037', 1, 1, 0, 1, 1, '11', '2020-07-17', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(58, 'EMP-F-038', 1, 1, 0, 1, 1, '11', '2020-07-17', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(59, 'EMP-F-039', 1, 1, 0, 1, 1, '11', '2020-07-21', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(60, 'EMP-F-040', 1, 1, 0, 1, 1, '11', '2020-07-21', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(61, 'EMP-F-041', 1, 1, 0, 1, 1, '11', '2020-07-21', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(62, 'EMP-F-042', 1, 1, 0, 1, 1, '11', '2020-07-21', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(63, 'EMP-F-043', 1, 1, 0, 1, 1, '11', '2020-07-21', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(64, 'EMP-F-044', 1, 1, 0, 1, 1, '11', '2020-07-21', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(65, 'EMP-F-045', 1, 1, 0, 1, 1, '11', '2020-07-21', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(66, 'EMP-F-046', 1, 1, 0, 1, 1, '11', '2020-07-21', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(67, 'EMP-F-047', 1, 1, 0, 1, 1, '11', '2020-07-21', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(68, 'EMP-F-048', 1, 1, 0, 1, 1, '11', '2020-07-21', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(69, 'EMP-F-049', 1, 1, 0, 1, 1, '11', '2020-07-21', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(70, 'EMP-F-050', 1, 1, 0, 1, 1, '11', '2020-07-21', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(71, 'EMP-F-051', 1, 1, 0, 1, 1, '11', '2020-07-21', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(72, 'EMP-F-052', 1, 1, 0, 1, 1, '11', '2020-07-21', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(73, 'EMP-F-053', 1, 1, 0, 1, 1, '11', '2020-07-21', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(74, 'EMP-F-054', 1, 1, 0, 1, 1, '11', '2020-07-21', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(75, 'EMP-F-055', 1, 1, 0, 1, 1, '11', '2020-07-21', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(76, 'EMP-F-056', 1, 1, 0, 1, 1, '11', '2020-07-21', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(77, 'EMP-F-057', 1, 1, 0, 1, 1, '11', '2020-07-21', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(78, 'EMP-F-058', 1, 1, 0, 1, 1, '11', '2020-07-21', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(79, 'EMP-F-059', 1, 1, 0, 1, 1, '11', '2020-07-21', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(80, 'EMP-F-060', 1, 1, 0, 1, 1, '11', '2020-07-21', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(81, 'EMP-F-061', 1, 1, 0, 1, 1, '11', '2020-07-21', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(82, 'EMP-F-062', 1, 1, 0, 1, 1, '11', '2020-07-21', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(83, 'EMP-F-063', 1, 1, 0, 1, 1, '11', '2020-07-21', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(84, 'EMP-F-064', 1, 1, 0, 1, 1, '11', '2020-07-21', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(85, 'EMP-F-065', 1, 1, 0, 1, 1, '11', '2020-07-21', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(86, 'EMP-F-066', 1, 1, 0, 1, 1, '11', '2020-07-21', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(87, 'EMP-F-067', 1, 1, 0, 1, 1, '11', '2020-07-21', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(88, 'EMP-F-068', 1, 1, 0, 1, 1, '11', '2020-07-21', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(89, 'EMP-F-069', 1, 1, 0, 1, 1, '11', '2020-07-21', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(90, 'EMP-F-070', 1, 1, 0, 1, 1, '11', '2020-07-21', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(91, 'EMP-F-071', 1, 1, 0, 1, 1, '11', '2020-07-21', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(92, 'EMP-F-072', 1, 1, 0, 1, 1, '11', '2020-07-21', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(93, 'EMP-F-073', 1, 1, 0, 1, 1, '11', '2020-07-21', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(94, 'EMP-F-074', 1, 1, 0, 1, 1, '11', '2020-07-21', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(95, 'EMP-F-075', 1, 1, 0, 1, 1, '11', '2020-07-21', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(96, 'EMP-F-076', 1, 1, 0, 1, 1, '11', '2020-07-21', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(97, 'EMP-F-077', 1, 1, 0, 1, 1, '11', '2020-07-21', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(98, 'EMP-F-078', 1, 1, 0, 1, 1, '11', '2020-07-21', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(99, 'EMP-F-079', 1, 1, 0, 1, 1, '11', '2020-07-21', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(100, 'EMP-F-080', 1, 1, 0, 1, 1, '11', '2020-07-21', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(101, 'EMP-F-081', 1, 1, 0, 1, 1, '11', '2020-07-21', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(102, 'EMP-F-082', 1, 1, 0, 1, 1, '11', '2020-07-21', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(103, 'EMP-F-083', 1, 1, 0, 1, 1, '11', '2020-07-21', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(104, 'EMP-F-084', 1, 1, 0, 1, 1, '11', '2020-07-21', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(105, 'EMP-F-085', 1, 1, 0, 1, 1, '11', '2020-07-21', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(106, 'EMP-F-086', 1, 1, 0, 1, 1, '11', '2020-07-21', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(107, 'EMP-F-087', 1, 1, 0, 1, 1, '11', '2020-07-21', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(108, 'EMP-F-088', 1, 1, 0, 1, 1, '11', '2020-07-21', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(109, 'EMP-F-089', 1, 1, 0, 1, 1, '11', '2020-07-21', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(110, 'EMP-F-090', 1, 1, 0, 1, 1, '11', '2020-07-21', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(111, 'EMP-F-091', 1, 1, 0, 1, 1, '11', '2020-07-22', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(112, 'EMP-F-092', 1, 1, 0, 1, 1, '11', '2020-07-22', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(113, 'EMP-F-093', 1, 1, 0, 1, 1, '11', '2020-07-22', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(114, 'EMP-F-094', 1, 1, 0, 1, 1, '11', '2020-07-22', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(115, 'EMP-F-095', 1, 1, 0, 1, 1, '11', '2020-07-22', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(116, 'EMP-F-096', 1, 1, 0, 1, 1, '11', '2020-07-22', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(117, 'EMP-F-097', 1, 1, 0, 1, 1, '11', '2020-07-22', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(118, 'EMP-F-098', 1, 1, 0, 1, 1, '11', '2020-07-22', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(119, 'EMP-F-099', 1, 1, 0, 1, 1, '11', '2020-07-22', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(120, 'EMP-f-100', 1, 1, 0, 1, 1, '11', '2020-07-22', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(121, 'EMP-f-101', 1, 1, 0, 1, 1, '11', '2020-07-22', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(122, 'EMP-f-102', 1, 1, 0, 1, 1, '11', '2020-07-22', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(123, 'EMP-f-103', 1, 1, 0, 1, 1, '11', '2020-07-22', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(124, 'EMP-f-104', 1, 1, 0, 1, 1, '11', '2020-07-22', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(125, 'EMP-f-105', 1, 1, 0, 1, 1, '11', '2020-07-22', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(126, 'EMP-f-106', 1, 1, 0, 1, 1, '11', '2020-07-22', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(127, 'EMP-f-107', 1, 1, 0, 1, 1, '11', '2020-07-22', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(128, 'EMP-f-108', 1, 1, 0, 1, 1, '11', '2020-07-22', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(129, 'EMP-f-109', 1, 1, 0, 1, 1, '11', '2020-07-22', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(130, 'EMP-f-110', 1, 1, 0, 1, 1, '11', '2020-07-22', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(131, 'EMP-f-111', 1, 1, 0, 1, 1, '11', '2020-07-22', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(132, 'EMP-f-112', 1, 1, 0, 1, 1, '11', '2020-07-22', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0);
INSERT INTO `fa_kv_empl_job` (`id`, `empl_id`, `employee_type`, `eligible_hra`, `grade`, `department`, `desig_group`, `desig`, `joining`, `empl_type`, `working_branch`, `mod_of_pay`, `ifsc_code`, `bank_name`, `act_holder_name`, `acc_no`, `gross_pay_annum`, `gross`, `5`, `6`, `2`, `3`, `4`, `1`, `8`, `contract_end_date`, `contract_duration`, `10`, `12`, `13`, `14`, `15`, `16`, `17`, `18`, `19`, `20`, `21`, `22`, `23`, `24`, `25`, `26`, `27`, `28`, `29`, `30`, `31`, `32`, `33`, `34`, `35`, `36`, `37`, `38`, `pre_basic_pay`, `pre_grade_pay`, `pre_da`, `pre_hra`, `pre_conveyance`, `pre_sas`, `pre_prof_tax`, `pre_pf`, `pre_tds`, `pre_financial_year`, `status`, `ctc`, `39`, `40`, `41`, `42`, `43`, `44`, `45`, `46`, `47`, `48`, `49`, `50`, `51`, `52`, `eligible_esi`, `effective_date`, `0`) VALUES
(133, 'EMP-f-113', 1, 1, 0, 1, 1, '11', '2020-07-22', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(134, 'EMP-f-114', 1, 1, 0, 1, 1, '11', '2020-07-22', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(135, 'EMP-f-115', 1, 1, 0, 1, 1, '11', '2020-07-22', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(136, 'EMP-f-116', 1, 1, 0, 1, 1, '11', '2020-07-22', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(137, 'EMP-f-117', 1, 1, 0, 1, 1, '11', '2020-07-22', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(138, 'EMP-f-118', 1, 1, 0, 1, 1, '11', '2020-07-22', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(139, 'EMP-f-119', 1, 1, 0, 1, 1, '11', '2020-07-22', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(140, 'EMP-f-120', 1, 1, 0, 1, 1, '11', '2020-07-22', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(141, 'EMP-f-121', 1, 1, 0, 1, 1, '11', '2020-07-22', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(142, 'EMP-f-122', 1, 1, 0, 1, 1, '11', '2020-07-22', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(143, 'EMP-f-123', 1, 1, 0, 1, 1, '11', '2020-07-22', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(144, 'EMP-f-124', 1, 1, 0, 1, 1, '11', '2020-07-22', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(145, 'EMP-f-125', 1, 1, 0, 1, 1, '11', '2020-07-22', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(146, 'EMP-f-126', 1, 1, 0, 1, 1, '11', '2020-07-22', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(147, 'EMP-f-127', 1, 1, 0, 1, 1, '11', '2020-07-22', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(148, 'EMP-f-128', 1, 1, 0, 1, 1, '11', '2020-07-22', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(149, 'EMP-f-129', 1, 1, 0, 1, 1, '11', '2020-07-22', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(150, 'EMP-f-130', 1, 1, 0, 1, 1, '11', '2020-07-22', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(151, 'EMP-f-131', 1, 1, 0, 1, 1, '11', '2020-07-22', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(152, 'EMP-f-132', 1, 1, 0, 1, 1, '11', '2020-07-22', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(153, 'EMP-f-133', 1, 1, 0, 1, 1, '11', '2020-07-22', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(154, 'EMP-f-134', 1, 1, 0, 1, 1, '11', '2020-07-22', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(155, 'EMP-f-135', 1, 1, 0, 1, 1, '11', '2020-07-22', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(156, 'EMP-f-136', 1, 1, 0, 1, 1, '11', '2020-07-22', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(157, 'EMP-f-137', 1, 1, 0, 1, 1, '11', '2020-07-22', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(158, 'EMP-f-138', 1, 1, 0, 1, 1, '11', '2020-07-22', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(159, 'EMP-f-139', 1, 1, 0, 1, 1, '11', '2020-07-22', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(160, 'EMP-f-140', 1, 1, 0, 1, 1, '11', '2020-07-22', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(161, 'EMP-f-141', 1, 1, 0, 1, 1, '11', '2020-07-22', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(162, 'EMP-f-142', 1, 1, 0, 1, 1, '11', '2020-07-22', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(163, 'EMP-f-143', 1, 1, 0, 1, 1, '11', '2020-07-22', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(164, 'EMP-f-144', 1, 1, 0, 1, 1, '11', '2020-07-22', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(165, 'EMP-f-145', 1, 1, 0, 1, 1, '11', '2020-07-22', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(166, 'EMP-f-146', 1, 1, 0, 1, 1, '11', '2020-07-22', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(167, 'EMP-f-147', 1, 1, 0, 1, 1, '11', '2020-07-22', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(168, 'EMP-f-148', 1, 1, 0, 1, 1, '11', '2020-07-22', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(169, 'EMP-f-149', 1, 1, 0, 1, 1, '1', '2020-07-22', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', '', '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(170, 'EMP-f-150', 1, 1, 0, 1, 1, '11', '2020-07-22', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(171, 'EMP-f-151', 1, 1, 0, 1, 1, '11', '2020-07-22', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(172, 'EMP-f-152', 1, 1, 0, 1, 1, '11', '2020-07-22', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(173, 'EMP-f-153', 1, 1, 0, 1, 1, '11', '2020-07-22', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(174, 'EMP-f-154', 1, 1, 0, 1, 1, '11', '2020-07-22', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(175, 'EMP-f-155', 1, 1, 0, 1, 1, '11', '2020-07-22', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(176, 'EMP-f-156', 1, 1, 0, 1, 1, '11', '2020-07-22', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(177, 'EMP-f-157', 1, 1, 0, 1, 1, '11', '2020-07-22', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(178, 'EMP-f-158', 1, 1, 0, 1, 1, '11', '2020-07-22', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(179, 'EMP-f-159', 1, 1, 0, 1, 1, '11', '2020-07-22', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(180, 'EMP-f-160', 1, 1, 0, 1, 1, '11', '2020-07-22', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(181, 'EMP-f-161', 1, 1, 0, 1, 1, '11', '2020-07-22', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(182, 'EMP-f-162', 1, 1, 0, 1, 1, '11', '2020-07-22', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(183, 'EMP-f-163', 1, 1, 0, 1, 1, '11', '2020-07-22', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(184, 'EMP-f-164', 1, 1, 0, 1, 1, '11', '2020-07-22', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(185, 'EMP-f-165', 1, 1, 0, 1, 1, '11', '2020-07-22', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(186, 'EMP-f-166', 1, 1, 0, 1, 1, '11', '2020-07-22', 2, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(187, 'EMP-F-167', 1, 1, 0, 1, 1, '11', '2020-07-17', 1, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(188, 'EMP-F-168', 1, 1, 0, 1, 1, '11', '2020-07-17', 1, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(189, 'EMP-F-169', 1, 1, 0, 1, 1, '11', '2020-07-17', 1, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00', 0),
(190, 'EMP-f-170', 1, 1, 0, 1, 8, '16', '2020-12-25', 1, 1, 2, 'GDFC12344', 'HDFC', 'Soofia', '12345689', 0, '0', NULL, NULL, NULL, NULL, '', '', NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, '', NULL, '', NULL, NULL, '', NULL, '', '', NULL, NULL, NULL, NULL, '', 1, '0000-00-00', 0),
(191, 'EMP-f-171', 1, 1, 0, 1, 2, '3', '2021-04-05', 1, 1, 1, '', '', '', '', 0, '0', NULL, NULL, NULL, NULL, '', '', NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, '', NULL, '', NULL, NULL, '', NULL, '', '', NULL, NULL, NULL, NULL, '', 1, '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `fa_kv_empl_loan`
--

CREATE TABLE `fa_kv_empl_loan` (
  `id` int(10) NOT NULL,
  `empl_id` varchar(10) NOT NULL,
  `date` date NOT NULL,
  `loan_amount` decimal(15,2) NOT NULL,
  `loan_type_id` int(5) NOT NULL,
  `periods` int(5) NOT NULL,
  `monthly_pay` decimal(15,2) NOT NULL,
  `periods_paid` int(5) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `fa_kv_empl_option`
--

CREATE TABLE `fa_kv_empl_option` (
  `id` int(20) NOT NULL,
  `option_name` varchar(150) NOT NULL,
  `option_value` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fa_kv_empl_option`
--

INSERT INTO `fa_kv_empl_option` (`id`, `option_name`, `option_value`) VALUES
(1, 'weekly_off', 'Sat,Sun'),
(2, 'empl_ref_type', '0'),
(3, 'salary_account', ''),
(4, 'paid_from_account', ''),
(5, 'expd_percentage_amt', '30'),
(6, 'weekly_off', 'Sat,Sun'),
(7, 'empl_ref_type', '0'),
(8, 'next_empl_id', '1'),
(9, 'weekly_off', 'Sat,Sun'),
(10, 'empl_ref_type', '0'),
(11, 'weekly_off', 'Sat,Sun'),
(12, 'empl_ref_type', '0'),
(13, 'weekly_off', 'Sat,Sun'),
(14, 'empl_ref_type', '0'),
(15, 'weekly_off', 'Sat,Sun'),
(16, 'empl_ref_type', '0'),
(17, 'weekly_off', 'Sat,Sun'),
(18, 'empl_ref_type', '0'),
(19, 'weekly_off', 'Sat,Sun'),
(20, 'empl_ref_type', '0'),
(21, 'weekly_off', 'Sat,Sun'),
(22, 'empl_ref_type', '0'),
(23, 'weekly_off', 'Sat,Sun'),
(24, 'empl_ref_type', '0'),
(25, 'weekly_off', 'Sat,Sun'),
(26, 'empl_ref_type', '0'),
(27, 'weekly_off', 'Sat,Sun'),
(28, 'empl_ref_type', '0'),
(29, 'weekly_off', 'Sat,Sun'),
(30, 'empl_ref_type', '0'),
(31, 'weekly_off', 'Sat,Sun'),
(32, 'empl_ref_type', '0'),
(33, 'salary_account', ''),
(34, 'paid_from_account', ''),
(35, 'weekly_off', 'Sat,Sun'),
(36, 'empl_ref_type', '0'),
(37, 'salary_account', ''),
(38, 'paid_from_account', ''),
(0, 'weekly_off', 'Sat,Sun'),
(0, 'empl_ref_type', '0'),
(0, 'salary_account', ''),
(0, 'paid_from_account', ''),
(0, 'weekly_off', 'Sat,Sun'),
(0, 'empl_ref_type', '0'),
(0, 'salary_account', ''),
(0, 'paid_from_account', ''),
(0, 'weekly_off', 'Sun'),
(0, 'empl_ref_type', '0'),
(0, 'salary_account', '5410'),
(0, 'paid_from_account', '1060'),
(0, 'weekly_off', 'Sun'),
(0, 'empl_ref_type', '0'),
(0, 'salary_account', '5410'),
(0, 'paid_from_account', '1060'),
(0, 'weekly_off', 'Sun'),
(0, 'empl_ref_type', '0'),
(0, 'salary_account', '5410'),
(0, 'paid_from_account', '1060'),
(0, 'weekly_off', 'Sun'),
(0, 'empl_ref_type', '0'),
(0, 'salary_account', '5410'),
(0, 'paid_from_account', '1060'),
(0, 'weekly_off', 'Sun'),
(0, 'empl_ref_type', '0'),
(0, 'salary_account', '5410'),
(0, 'paid_from_account', '1060');

-- --------------------------------------------------------

--
-- Table structure for table `fa_kv_empl_salary`
--

CREATE TABLE `fa_kv_empl_salary` (
  `id` int(20) NOT NULL,
  `empl_id` varchar(10) NOT NULL,
  `month` int(2) NOT NULL,
  `year` int(2) NOT NULL,
  `date` date NOT NULL,
  `gross` int(15) NOT NULL,
  `deduct_tot` float NOT NULL,
  `lop_amount` int(10) NOT NULL,
  `loan` int(10) NOT NULL,
  `adv_sal` int(10) NOT NULL,
  `net_pay` int(10) NOT NULL,
  `misc` int(10) NOT NULL,
  `ot_other_allowance` int(10) NOT NULL,
  `conveyance_allowance` float NOT NULL,
  `leave_encashment` float NOT NULL,
  `tds` float NOT NULL,
  `accom_hra_by_org` int(11) DEFAULT NULL,
  `is_arrear` tinyint(1) DEFAULT NULL,
  `paid_for_months_list` char(50) DEFAULT NULL,
  `paid_for_f_year` tinyint(4) DEFAULT NULL,
  `2` int(15) NOT NULL,
  `6` int(15) NOT NULL,
  `1` int(15) NOT NULL,
  `3` int(15) NOT NULL,
  `4` int(15) NOT NULL,
  `5` int(15) NOT NULL,
  `8` int(15) NOT NULL,
  `10` int(15) NOT NULL,
  `12` int(15) NOT NULL,
  `13` int(10) NOT NULL,
  `14` int(10) NOT NULL,
  `15` int(10) NOT NULL,
  `16` int(10) NOT NULL,
  `17` int(10) NOT NULL,
  `18` int(10) NOT NULL,
  `19` int(10) NOT NULL,
  `20` int(10) NOT NULL,
  `21` int(10) NOT NULL,
  `22` int(10) NOT NULL,
  `23` int(10) NOT NULL,
  `24` int(10) NOT NULL,
  `25` int(10) NOT NULL,
  `26` int(10) NOT NULL,
  `27` int(10) NOT NULL,
  `28` int(10) NOT NULL,
  `29` int(10) NOT NULL,
  `30` int(10) NOT NULL,
  `31` int(10) NOT NULL,
  `32` int(10) NOT NULL,
  `33` int(10) NOT NULL,
  `34` int(10) NOT NULL,
  `35` int(10) NOT NULL,
  `36` int(10) NOT NULL,
  `37` int(10) NOT NULL,
  `38` int(10) NOT NULL,
  `39` int(11) NOT NULL DEFAULT 0,
  `40` int(11) NOT NULL DEFAULT 0,
  `41` int(11) NOT NULL DEFAULT 0,
  `42` int(11) NOT NULL DEFAULT 0,
  `43` int(11) NOT NULL DEFAULT 0,
  `44` int(11) NOT NULL DEFAULT 0,
  `45` int(11) NOT NULL DEFAULT 0,
  `46` int(11) NOT NULL DEFAULT 0,
  `47` int(11) NOT NULL DEFAULT 0,
  `48` int(11) NOT NULL DEFAULT 0,
  `49` int(11) NOT NULL DEFAULT 0,
  `50` int(11) NOT NULL DEFAULT 0,
  `51` int(11) NOT NULL DEFAULT 0,
  `52` int(11) NOT NULL DEFAULT 0,
  `eligible_esi` tinyint(4) NOT NULL DEFAULT 0,
  `0` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fa_kv_empl_salary`
--

INSERT INTO `fa_kv_empl_salary` (`id`, `empl_id`, `month`, `year`, `date`, `gross`, `deduct_tot`, `lop_amount`, `loan`, `adv_sal`, `net_pay`, `misc`, `ot_other_allowance`, `conveyance_allowance`, `leave_encashment`, `tds`, `accom_hra_by_org`, `is_arrear`, `paid_for_months_list`, `paid_for_f_year`, `2`, `6`, `1`, `3`, `4`, `5`, `8`, `10`, `12`, `13`, `14`, `15`, `16`, `17`, `18`, `19`, `20`, `21`, `22`, `23`, `24`, `25`, `26`, `27`, `28`, `29`, `30`, `31`, `32`, `33`, `34`, `35`, `36`, `37`, `38`, `39`, `40`, `41`, `42`, `43`, `44`, `45`, `46`, `47`, `48`, `49`, `50`, `51`, `52`, `eligible_esi`, `0`) VALUES
(0, 'EMP-F-004', 2, 4, '2021-04-12', 100000, 13988, 0, 0, 0, 86012, 0, 0, 0, 0, 10388, 1, NULL, NULL, NULL, 0, 0, 40000, 0, 16000, 0, 0, 0, 1800, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 150000, 0, 0, 0, 0, 0, 0, 0, 0, 0, 100000, 0, 0, 0, 0, 0, 0, 0, 42200, 0, 0, 0, 0, 1800, 2, 0),
(1, '0', 12, 3, '2020-01-27', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(2, 'EMP-F-001', 1, 3, '2020-01-27', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `fa_kv_empl_salary_arear_by_month`
--

CREATE TABLE `fa_kv_empl_salary_arear_by_month` (
  `id` int(20) NOT NULL,
  `empl_id` varchar(10) NOT NULL,
  `sal_id` int(11) NOT NULL,
  `month` int(2) NOT NULL,
  `year` int(2) NOT NULL,
  `date` date NOT NULL,
  `gross` int(15) NOT NULL,
  `deduct_tot` float NOT NULL,
  `lop_amount` int(10) NOT NULL,
  `loan` int(10) NOT NULL,
  `adv_sal` int(10) NOT NULL,
  `net_pay` int(10) NOT NULL,
  `misc` int(10) NOT NULL,
  `ot_other_allowance` int(10) NOT NULL,
  `conveyance_allowance` float NOT NULL,
  `leave_encashment` float NOT NULL,
  `tds` float NOT NULL,
  `accom_hra_by_org` int(11) DEFAULT NULL,
  `is_arrear` tinyint(1) DEFAULT NULL,
  `paid_for_months_list` char(50) DEFAULT NULL,
  `paid_for_f_year` tinyint(4) DEFAULT NULL,
  `2` int(15) NOT NULL,
  `6` int(15) NOT NULL,
  `1` int(15) NOT NULL,
  `3` int(15) NOT NULL,
  `4` int(15) NOT NULL,
  `5` int(15) NOT NULL,
  `8` int(15) NOT NULL,
  `10` int(15) NOT NULL,
  `12` int(15) NOT NULL,
  `13` int(10) NOT NULL,
  `14` int(10) NOT NULL,
  `15` int(10) NOT NULL,
  `16` int(10) NOT NULL,
  `17` int(10) NOT NULL,
  `18` int(10) NOT NULL,
  `19` int(10) NOT NULL,
  `20` int(10) NOT NULL,
  `21` int(10) NOT NULL,
  `22` int(10) NOT NULL,
  `23` int(10) NOT NULL,
  `24` int(10) NOT NULL,
  `25` int(10) NOT NULL,
  `26` int(10) NOT NULL,
  `27` int(10) NOT NULL,
  `28` int(10) NOT NULL,
  `29` int(10) NOT NULL,
  `30` int(10) NOT NULL,
  `31` int(10) NOT NULL,
  `32` int(10) NOT NULL,
  `33` int(10) NOT NULL,
  `34` int(10) NOT NULL,
  `35` int(10) NOT NULL,
  `36` int(10) NOT NULL,
  `37` int(10) NOT NULL,
  `38` int(10) NOT NULL,
  `39` int(11) NOT NULL DEFAULT 0,
  `40` int(11) NOT NULL DEFAULT 0,
  `41` int(11) NOT NULL DEFAULT 0,
  `42` int(11) NOT NULL DEFAULT 0,
  `43` int(11) NOT NULL DEFAULT 0,
  `44` int(11) NOT NULL DEFAULT 0,
  `45` int(11) NOT NULL DEFAULT 0,
  `46` int(11) NOT NULL DEFAULT 0,
  `47` int(11) NOT NULL DEFAULT 0,
  `48` int(11) NOT NULL DEFAULT 0,
  `49` int(11) NOT NULL DEFAULT 0,
  `50` int(11) NOT NULL DEFAULT 0,
  `51` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `fa_kv_empl_training`
--

CREATE TABLE `fa_kv_empl_training` (
  `id` int(5) NOT NULL,
  `empl_id` varchar(10) NOT NULL,
  `training_desc` varchar(60) NOT NULL,
  `course` varchar(50) NOT NULL,
  `cost` varchar(50) NOT NULL,
  `institute` varchar(60) NOT NULL,
  `s_date` date NOT NULL,
  `e_date` date NOT NULL,
  `notes` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fa_kv_empl_training`
--

INSERT INTO `fa_kv_empl_training` (`id`, `empl_id`, `training_desc`, `course`, `cost`, `institute`, `s_date`, `e_date`, `notes`) VALUES
(1, 'EMP-F-001', 'realestate software and php ', 'php', '10000', 'api', '2014-01-01', '2014-06-08', 'this is type of industrial');

-- --------------------------------------------------------

--
-- Table structure for table `fa_kv_encashment_request`
--

CREATE TABLE `fa_kv_encashment_request` (
  `id` int(11) NOT NULL,
  `request_id` varchar(50) NOT NULL,
  `empl_id` varchar(50) NOT NULL,
  `leave_type` int(10) NOT NULL,
  `encash_days` int(10) NOT NULL,
  `encash_amt` int(10) NOT NULL,
  `encash_request_date` date NOT NULL,
  `remarks` text NOT NULL,
  `inactive` tinyint(4) NOT NULL DEFAULT 0,
  `reason` varchar(200) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `no_of_days_approved` int(10) NOT NULL,
  `approved_date` date NOT NULL,
  `comments` text NOT NULL,
  `approved_amount` int(11) NOT NULL,
  `left_days` int(11) NOT NULL,
  `is_paid` tinyint(4) NOT NULL DEFAULT 0,
  `cal_year` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fa_kv_encashment_request`
--

INSERT INTO `fa_kv_encashment_request` (`id`, `request_id`, `empl_id`, `leave_type`, `encash_days`, `encash_amt`, `encash_request_date`, `remarks`, `inactive`, `reason`, `status`, `no_of_days_approved`, `approved_date`, `comments`, `approved_amount`, `left_days`, `is_paid`, `cal_year`) VALUES
(1, 'r-1', 'EMP-S-002', 11, 11, 7634, '2019-05-22', '', 0, '1', 2, 10, '2019-05-22', '', 6940, 1, 0, 2019),
(2, 'r-2', 'EMP-F-005', 11, 10, 6770, '2019-05-22', '', 0, '1', 1, 0, '0000-00-00', '', 0, 0, 0, 2019),
(3, 'r-3', 'EMP-S-003', 11, 11, 4268, '2019-05-22', '', 0, '1', 5, 0, '0000-00-00', '', 0, 0, 0, 2019),
(4, 'r-4', 'EMP-S-003', 11, 11, 7953, '2019-05-22', '', 0, '1', 2, 5, '2019-06-07', '', 6575, 6, 1, 2019),
(5, 'r-5', 'EMP-F-001', 2, 5, 8220, '2019-05-28', '2019', 0, '2', 2, 5, '2019-05-28', '', 8220, 0, 1, 2019),
(6, 'r-6', 'EMP-F-001', 2, 5, 8220, '2020-05-29', '', 0, '2', 5, 0, '0000-00-00', '', 0, 0, 0, 2020),
(7, 'r-7', 'EMP-F-001', 11, 0, 0, '2019-05-29', '', 0, '3', 1, 0, '0000-00-00', '', 0, 0, 0, 2019),
(8, 'r-8', 'EMP-F-011', 2, 4, 6576, '2019-06-07', '', 0, '2', 2, 4, '2019-06-07', '', 6576, 0, 1, 2019);

-- --------------------------------------------------------

--
-- Table structure for table `fa_kv_holiday_master`
--

CREATE TABLE `fa_kv_holiday_master` (
  `holiday_id` int(11) NOT NULL,
  `fisc_year` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `descpt` text NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `inactive` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fa_kv_holiday_master`
--

INSERT INTO `fa_kv_holiday_master` (`holiday_id`, `fisc_year`, `name`, `descpt`, `from_date`, `to_date`, `inactive`) VALUES
(1, 5, 'Eid', 'EID', '2021-05-14', '2021-05-14', 0),
(2, 7, 'chritmas day', 'chritmas day', '2023-12-25', '2023-12-25', 0);

-- --------------------------------------------------------

--
-- Table structure for table `fa_kv_hrm_finance_setup`
--

CREATE TABLE `fa_kv_hrm_finance_setup` (
  `id` int(10) NOT NULL,
  `description` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `allowance_debit_gl_code` int(11) NOT NULL DEFAULT 0,
  `allowance_credit_gl_code` int(11) NOT NULL DEFAULT 0,
  `inactive` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fa_kv_hrm_finance_setup`
--

INSERT INTO `fa_kv_hrm_finance_setup` (`id`, `description`, `type`, `allowance_debit_gl_code`, `allowance_credit_gl_code`, `inactive`) VALUES
(0, 'testing data', 'Salary', 0, 0, 0),
(1, 'Basic Pay', 'Salary', 4111, 0, 0),
(2, 'HRA', 'Salary', 4114, 0, 0),
(3, 'Special Allowance', 'Salary', 4116, 0, 0),
(4, 'Food Coupon', 'Salary', 4120, 0, 0),
(5, 'TDS', 'Salary', 0, 1223, 0),
(6, 'PLI', 'Salary', 4121, 0, 0),
(7, 'EPF-Employer&#039;s contribution', 'Salary', 0, 1214, 0),
(8, 'EPF-Employee&#039;s contribution', 'Salary', 0, 1214, 0),
(9, 'ESIC-Employer&#039;s Contribution', 'Salary', 0, 1222, 0),
(10, 'ESIC-Employee&#039;s contribution', 'Salary', 0, 1222, 0),
(11, 'Salary Advance', 'Salary', 2217, 0, 0),
(12, 'Food coupon Payable', 'Salary', 0, 1224, 0),
(13, 'EPF-Employeer&#039;s contribution', 'Salary', 4119, 0, 0),
(14, 'Prof Taxt', 'Salary', 0, 1225, 0),
(15, 'Salary Payable', 'Salary', 0, 1219, 0),
(16, 'ESIC-Employer&#039;s Contribution', 'Salary', 4113, 0, 0),
(17, 'Leave Encashment', 'Salary', 4122, 0, 0),
(18, 'tuition_fee', 'Course-Fee', 7125, 0, 0),
(19, 'test', 'Salary', 1060, 1065, 1);

-- --------------------------------------------------------

--
-- Table structure for table `fa_kv_hrm_tax`
--

CREATE TABLE `fa_kv_hrm_tax` (
  `id` int(10) NOT NULL,
  `min_sal` int(10) NOT NULL,
  `max_sal` int(10) NOT NULL,
  `percentage` int(10) NOT NULL,
  `offset` int(10) NOT NULL,
  `year` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `fa_kv_leave_days`
--

CREATE TABLE `fa_kv_leave_days` (
  `id` smallint(6) UNSIGNED NOT NULL,
  `employee_type` tinyint(1) NOT NULL DEFAULT 0,
  `leave_type` tinyint(1) NOT NULL DEFAULT 0,
  `accural_days` smallint(6) UNSIGNED DEFAULT NULL,
  `weekend_status` tinyint(1) NOT NULL DEFAULT 0,
  `max_accumulation` smallint(6) UNSIGNED DEFAULT NULL,
  `avail_leaves` smallint(6) UNSIGNED DEFAULT NULL,
  `max_days` smallint(6) UNSIGNED DEFAULT NULL,
  `min_days` smallint(6) UNSIGNED DEFAULT NULL,
  `max_times_in_cal_year` int(10) UNSIGNED DEFAULT NULL,
  `max_encash` smallint(6) UNSIGNED DEFAULT NULL,
  `min_encash` smallint(6) UNSIGNED DEFAULT NULL,
  `cal_year` int(10) UNSIGNED DEFAULT NULL,
  `inactive` tinyint(1) NOT NULL DEFAULT 0,
  `c_f` tinyint(4) NOT NULL DEFAULT 0,
  `merg_status` tinyint(4) NOT NULL DEFAULT 0,
  `merg_to` int(10) NOT NULL DEFAULT 0,
  `merg_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fa_kv_leave_days`
--

INSERT INTO `fa_kv_leave_days` (`id`, `employee_type`, `leave_type`, `accural_days`, `weekend_status`, `max_accumulation`, `avail_leaves`, `max_days`, `min_days`, `max_times_in_cal_year`, `max_encash`, `min_encash`, `cal_year`, `inactive`, `c_f`, `merg_status`, `merg_to`, `merg_date`) VALUES
(1, 1, 1, 16, 1, 10, 2, 0, 0, 2, 0, 0, 2023, 0, 1, 1, 1, '2023-01-01'),
(2, 1, 2, 16, 1, 10, 2, 0, 0, 2, 0, 0, 2023, 0, 1, 1, 2, '2023-01-01');

-- --------------------------------------------------------

--
-- Table structure for table `fa_kv_leave_encash`
--

CREATE TABLE `fa_kv_leave_encash` (
  `id` int(11) NOT NULL,
  `employee_type` int(10) NOT NULL,
  `leave_type` int(10) NOT NULL,
  `occas_encash` varchar(100) CHARACTER SET latin1 NOT NULL,
  `freq` int(10) NOT NULL,
  `max_encash` int(10) NOT NULL,
  `min_encash` int(10) NOT NULL,
  `min_bal` double(4,2) NOT NULL,
  `inactive` tinyint(4) NOT NULL DEFAULT 0,
  `encash_based` varchar(100) CHARACTER SET latin1 NOT NULL,
  `cal_year` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

-- --------------------------------------------------------

--
-- Table structure for table `fa_kv_leave_master`
--

CREATE TABLE `fa_kv_leave_master` (
  `leave_id` int(11) NOT NULL,
  `designation_group_id` int(11) NOT NULL DEFAULT 0,
  `desig_id` int(11) DEFAULT 0,
  `dept_id` int(11) NOT NULL DEFAULT 0,
  `type_leave` int(11) NOT NULL DEFAULT 0,
  `no_of_cls` decimal(8,1) NOT NULL,
  `no_of_pls` decimal(8,1) NOT NULL,
  `no_of_medical_ls` decimal(8,1) NOT NULL,
  `no_of_el` decimal(8,1) NOT NULL,
  `no_of_spl_cls` decimal(8,1) NOT NULL,
  `no_of_spl_cls_female` decimal(8,1) NOT NULL,
  `no_of_mat_ls` decimal(8,1) NOT NULL,
  `no_of_patern_ls` decimal(8,1) NOT NULL,
  `inactive` int(11) NOT NULL DEFAULT 0,
  `fisc_year` int(11) NOT NULL DEFAULT 0,
  `cal_year` varchar(11) DEFAULT NULL,
  `empl_id` char(30) DEFAULT NULL,
  `updated_date_ml` varchar(50) DEFAULT NULL,
  `updated_date_vl` varchar(50) DEFAULT NULL,
  `updated_date_el` varchar(50) DEFAULT NULL,
  `updated_date` varchar(50) DEFAULT NULL,
  `acess_cl` varchar(50) DEFAULT NULL,
  `acess_vl` varchar(50) DEFAULT NULL,
  `acess_ml` varchar(40) DEFAULT NULL,
  `acess_el` varchar(40) DEFAULT NULL,
  `acess_spl_male` varchar(40) DEFAULT NULL,
  `acess_spl_female` varchar(40) DEFAULT NULL,
  `acess_mat` varchar(40) DEFAULT NULL,
  `acess_pat` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fa_kv_leave_master`
--

INSERT INTO `fa_kv_leave_master` (`leave_id`, `designation_group_id`, `desig_id`, `dept_id`, `type_leave`, `no_of_cls`, `no_of_pls`, `no_of_medical_ls`, `no_of_el`, `no_of_spl_cls`, `no_of_spl_cls_female`, `no_of_mat_ls`, `no_of_patern_ls`, `inactive`, `fisc_year`, `cal_year`, `empl_id`, `updated_date_ml`, `updated_date_vl`, `updated_date_el`, `updated_date`, `acess_cl`, `acess_vl`, `acess_ml`, `acess_el`, `acess_spl_male`, `acess_spl_female`, `acess_mat`, `acess_pat`) VALUES
(1, 0, 0, 0, 0, '16.0', '2.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', 0, 6, '2022', 'EMP-f-171', '2023-01-10', '2022-04-01', '2023-01-10', '2022-04-01', '1', '1', '1', '1', '', '', '', ''),
(6, 0, 0, 0, 0, '16.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', 0, 6, '2023', 'EMP-f-171', '2023-01-13', '2023-01-13', '2023-01-13', '2023-01-13', '1', '1', '1', '1', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `fa_kv_leave_request_status`
--

CREATE TABLE `fa_kv_leave_request_status` (
  `status_id` int(11) NOT NULL,
  `status_name` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fa_kv_leave_request_status`
--

INSERT INTO `fa_kv_leave_request_status` (`status_id`, `status_name`) VALUES
(1, 'Waiting'),
(2, 'Approved'),
(3, 'Rejected'),
(4, 'Cancel Leave Request'),
(5, 'Approved Cancel Request');

-- --------------------------------------------------------

--
-- Table structure for table `fa_kv_loan_types`
--

CREATE TABLE `fa_kv_loan_types` (
  `id` int(10) NOT NULL,
  `loan_name` varchar(200) NOT NULL,
  `interest_rate` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `fa_kv_occasion_master`
--

CREATE TABLE `fa_kv_occasion_master` (
  `id` int(11) NOT NULL,
  `occ_name` varchar(255) NOT NULL,
  `yes_no` tinyint(4) NOT NULL DEFAULT 0,
  `inactive` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fa_kv_occasion_master`
--

INSERT INTO `fa_kv_occasion_master` (`id`, `occ_name`, `yes_no`, `inactive`) VALUES
(1, 'Retirement', 1, 0),
(2, 'Medical', 1, 0),
(3, 'LTC', 1, 0),
(4, 'Regular', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `fa_kv_states`
--

CREATE TABLE `fa_kv_states` (
  `state_id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  `state_code` varchar(32) COLLATE utf8_bin NOT NULL,
  `state_name` varchar(128) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `fa_kv_states`
--

INSERT INTO `fa_kv_states` (`state_id`, `country_id`, `state_code`, `state_name`) VALUES
(1, 1, 'BDS', 'Badakhshan'),
(2, 1, 'BDG', 'Badghis'),
(3, 1, 'BGL', 'Baghlan'),
(4, 1, 'BAL', 'Balkh'),
(5, 1, 'BAM', 'Bamian'),
(6, 1, 'FRA', 'Farah'),
(7, 1, 'FYB', 'Faryab'),
(8, 1, 'GHA', 'Ghazni'),
(9, 1, 'GHO', 'Ghowr'),
(10, 1, 'HEL', 'Helmand'),
(11, 1, 'HER', 'Delhi'),
(12, 1, 'JOW', 'Jowzjan'),
(13, 1, 'KAB', 'Kabul'),
(14, 1, 'KAN', 'Kandahar'),
(15, 1, 'KAP', 'Kapisa'),
(16, 1, 'KHO', 'Khost'),
(17, 1, 'KNR', 'Konar'),
(18, 1, 'KDZ', 'Kondoz'),
(19, 1, 'LAG', 'Laghman'),
(20, 1, 'LOW', 'Lowgar'),
(21, 1, 'NAN', 'Nangrahar'),
(22, 1, 'NIM', 'Nimruz'),
(23, 1, 'NUR', 'Nurestan'),
(24, 1, 'ORU', 'Oruzgan'),
(25, 1, 'PIA', 'Paktia'),
(26, 1, 'PKA', 'Paktika'),
(27, 1, 'PAR', 'Parwan'),
(28, 1, 'SAM', 'Samangan'),
(29, 1, 'SAR', 'Sar-e Pol'),
(30, 1, 'TAK', 'Takhar'),
(31, 1, 'WAR', 'Wardak'),
(32, 1, 'ZAB', 'Zabol'),
(33, 2, 'BR', 'Berat'),
(34, 2, 'BU', 'Bulqize'),
(35, 2, 'DL', 'Delvine'),
(36, 2, 'DV', 'Devoll'),
(37, 2, 'DI', 'Diber'),
(38, 2, 'DR', 'Durres'),
(39, 2, 'EL', 'Elbasan'),
(40, 2, 'ER', 'Kolonje'),
(41, 2, 'FR', 'Fier'),
(42, 2, 'GJ', 'Gjirokaster'),
(43, 2, 'GR', 'Gramsh'),
(44, 2, 'HA', 'Has'),
(45, 2, 'KA', 'Kavaje'),
(46, 2, 'KB', 'Kurbin'),
(47, 2, 'KC', 'Kucove'),
(48, 2, 'KO', 'Korce'),
(49, 2, 'KR', 'Kruje'),
(50, 2, 'KU', 'Kukes'),
(51, 2, 'LB', 'Librazhd'),
(52, 2, 'LE', 'Lezhe'),
(53, 2, 'LU', 'Lushnje'),
(54, 2, 'MM', 'Malesi e Madhe'),
(55, 2, 'MK', 'Mallakaster'),
(56, 2, 'MT', 'Mat'),
(57, 2, 'MR', 'Mirdite'),
(58, 2, 'PQ', 'Peqin'),
(59, 2, 'PR', 'Permet'),
(60, 2, 'PG', 'Pogradec'),
(61, 2, 'PU', 'Puke'),
(62, 2, 'SH', 'Shkoder'),
(63, 2, 'SK', 'Skrapar'),
(64, 2, 'SR', 'Sarande'),
(65, 2, 'TE', 'Tepelene'),
(66, 2, 'TP', 'Tropoje'),
(67, 2, 'TR', 'Tirane'),
(68, 2, 'VL', 'Vlore'),
(69, 3, 'ADR', 'Adrar'),
(70, 3, 'ADE', 'Ain Defla'),
(71, 3, 'ATE', 'Ain Temouchent'),
(72, 3, 'ALG', 'Alger'),
(73, 3, 'ANN', 'Annaba'),
(74, 3, 'BAT', 'Batna'),
(75, 3, 'BEC', 'Bechar'),
(76, 3, 'BEJ', 'Bejaia'),
(77, 3, 'BIS', 'Biskra'),
(78, 3, 'BLI', 'Blida'),
(79, 3, 'BBA', 'Bordj Bou Arreridj'),
(80, 3, 'BOA', 'Bouira'),
(81, 3, 'BMD', 'Boumerdes'),
(82, 3, 'CHL', 'Chlef'),
(83, 3, 'CON', 'Constantine'),
(84, 3, 'DJE', 'Djelfa'),
(85, 3, 'EBA', 'El Bayadh'),
(86, 3, 'EOU', 'El Oued'),
(87, 3, 'ETA', 'El Tarf'),
(88, 3, 'GHA', 'Ghardaia'),
(89, 3, 'GUE', 'Guelma'),
(90, 3, 'ILL', 'Illizi'),
(91, 3, 'JIJ', 'Jijel'),
(92, 3, 'KHE', 'Khenchela'),
(93, 3, 'LAG', 'Laghouat'),
(94, 3, 'MUA', 'Muaskar'),
(95, 3, 'MED', 'Medea'),
(96, 3, 'MIL', 'Mila'),
(97, 3, 'MOS', 'Mostaganem'),
(98, 3, 'MSI', 'M\'Sila'),
(99, 3, 'NAA', 'Naama'),
(100, 3, 'ORA', 'Oran'),
(101, 3, 'OUA', 'Ouargla'),
(102, 3, 'OEB', 'Oum el-Bouaghi'),
(103, 3, 'REL', 'Relizane'),
(104, 3, 'SAI', 'Saida'),
(105, 3, 'SET', 'Setif'),
(106, 3, 'SBA', 'Sidi Bel Abbes'),
(107, 3, 'SKI', 'Skikda'),
(108, 3, 'SAH', 'Souk Ahras'),
(109, 3, 'TAM', 'Tamanghasset'),
(110, 3, 'TEB', 'Tebessa'),
(111, 3, 'TIA', 'Tiaret'),
(112, 3, 'TIN', 'Tindouf'),
(113, 3, 'TIP', 'Tipaza'),
(114, 3, 'TIS', 'Tissemsilt'),
(115, 3, 'TOU', 'Tizi Ouzou'),
(116, 3, 'TLE', 'Tlemcen'),
(117, 4, 'E', 'Eastern'),
(118, 4, 'M', 'Manu\'a'),
(119, 4, 'R', 'Rose Island'),
(120, 4, 'S', 'Swains Island'),
(121, 4, 'W', 'Western'),
(122, 5, 'ALV', 'Andorra la Vella'),
(123, 5, 'CAN', 'Canillo'),
(124, 5, 'ENC', 'Encamp'),
(125, 5, 'ESE', 'Escaldes-Engordany'),
(126, 5, 'LMA', 'La Massana'),
(127, 5, 'ORD', 'Ordino'),
(128, 5, 'SJL', 'Sant Julia de Loria'),
(129, 6, 'BGO', 'Bengo'),
(130, 6, 'BGU', 'Benguela'),
(131, 6, 'BIE', 'Bie'),
(132, 6, 'CAB', 'Cabinda'),
(133, 6, 'CCU', 'Cuando-Cubango'),
(134, 6, 'CNO', 'Cuanza Norte'),
(135, 6, 'CUS', 'Cuanza Sul'),
(136, 6, 'CNN', 'Cunene'),
(137, 6, 'HUA', 'Huambo'),
(138, 6, 'HUI', 'Huila'),
(139, 6, 'LUA', 'Luanda'),
(140, 6, 'LNO', 'Lunda Norte'),
(141, 6, 'LSU', 'Lunda Sul'),
(142, 6, 'MAL', 'Malange'),
(143, 6, 'MOX', 'Moxico'),
(144, 6, 'NAM', 'Namibe'),
(145, 6, 'UIG', 'Uige'),
(146, 6, 'ZAI', 'Zaire'),
(147, 9, 'ASG', 'Saint George'),
(148, 9, 'ASJ', 'Saint John'),
(149, 9, 'ASM', 'Saint Mary'),
(150, 9, 'ASL', 'Saint Paul'),
(151, 9, 'ASR', 'Saint Peter'),
(152, 9, 'ASH', 'Saint Philip'),
(153, 9, 'BAR', 'Barbuda'),
(154, 9, 'RED', 'Redonda'),
(155, 10, 'AN', 'Antartida e Islas del Atlantico'),
(156, 10, 'BA', 'Buenos Aires'),
(157, 10, 'CA', 'Catamarca'),
(158, 10, 'CH', 'Chaco'),
(159, 10, 'CU', 'Chubut'),
(160, 10, 'CO', 'Cordoba'),
(161, 10, 'CR', 'Corrientes'),
(162, 10, 'DF', 'Distrito Federal'),
(163, 10, 'ER', 'Entre Rios'),
(164, 10, 'FO', 'Formosa'),
(165, 10, 'JU', 'Jujuy'),
(166, 10, 'LP', 'La Pampa'),
(167, 10, 'LR', 'La Rioja'),
(168, 10, 'ME', 'Mendoza'),
(169, 10, 'MI', 'Misiones'),
(170, 10, 'NE', 'Neuquen'),
(171, 10, 'RN', 'Rio Negro'),
(172, 10, 'SA', 'Salta'),
(173, 10, 'SJ', 'San Juan'),
(174, 10, 'SL', 'San Luis'),
(175, 10, 'SC', 'Santa Cruz'),
(176, 10, 'SF', 'Santa Fe'),
(177, 10, 'SD', 'Santiago del Estero'),
(178, 10, 'TF', 'Tierra del Fuego'),
(179, 10, 'TU', 'Tucuman'),
(180, 11, 'AGT', 'Aragatsotn'),
(181, 11, 'ARR', 'Ararat'),
(182, 11, 'ARM', 'Armavir'),
(183, 11, 'GEG', 'Geghark\'unik\''),
(184, 11, 'KOT', 'Kotayk\''),
(185, 11, 'LOR', 'Lorri'),
(186, 11, 'SHI', 'Shirak'),
(187, 11, 'SYU', 'Syunik\''),
(188, 11, 'TAV', 'Tavush'),
(189, 11, 'VAY', 'Vayots\' Dzor'),
(190, 11, 'YER', 'Yerevan'),
(191, 13, 'ACT', 'Australian Capital Territory'),
(192, 13, 'NSW', 'New South Wales'),
(193, 13, 'NT', 'Northern Territory'),
(194, 13, 'QLD', 'Queensland'),
(195, 13, 'SA', 'South Australia'),
(196, 13, 'TAS', 'Tasmania'),
(197, 13, 'VIC', 'Victoria'),
(198, 13, 'WA', 'Western Australia'),
(199, 14, 'BUR', 'Burgenland'),
(200, 14, 'KAR', 'Kärnten'),
(201, 14, 'NOS', 'Nieder&ouml;sterreich'),
(202, 14, 'OOS', 'Ober&ouml;sterreich'),
(203, 14, 'SAL', 'Salzburg'),
(204, 14, 'STE', 'Steiermark'),
(205, 14, 'TIR', 'Tirol'),
(206, 14, 'VOR', 'Vorarlberg'),
(207, 14, 'WIE', 'Wien'),
(208, 15, 'AB', 'Ali Bayramli'),
(209, 15, 'ABS', 'Abseron'),
(210, 15, 'AGC', 'AgcabAdi'),
(211, 15, 'AGM', 'Agdam'),
(212, 15, 'AGS', 'Agdas'),
(213, 15, 'AGA', 'Agstafa'),
(214, 15, 'AGU', 'Agsu'),
(215, 15, 'AST', 'Astara'),
(216, 15, 'BA', 'Baki'),
(217, 15, 'BAB', 'BabAk'),
(218, 15, 'BAL', 'BalakAn'),
(219, 15, 'BAR', 'BArdA'),
(220, 15, 'BEY', 'Beylaqan'),
(221, 15, 'BIL', 'Bilasuvar'),
(222, 15, 'CAB', 'Cabrayil'),
(223, 15, 'CAL', 'Calilabab'),
(224, 15, 'CUL', 'Culfa'),
(225, 15, 'DAS', 'Daskasan'),
(226, 15, 'DAV', 'Davaci'),
(227, 15, 'FUZ', 'Fuzuli'),
(228, 15, 'GA', 'Ganca'),
(229, 15, 'GAD', 'Gadabay'),
(230, 15, 'GOR', 'Goranboy'),
(231, 15, 'GOY', 'Goycay'),
(232, 15, 'HAC', 'Haciqabul'),
(233, 15, 'IMI', 'Imisli'),
(234, 15, 'ISM', 'Ismayilli'),
(235, 15, 'KAL', 'Kalbacar'),
(236, 15, 'KUR', 'Kurdamir'),
(237, 15, 'LA', 'Lankaran'),
(238, 15, 'LAC', 'Lacin'),
(239, 15, 'LAN', 'Lankaran'),
(240, 15, 'LER', 'Lerik'),
(241, 15, 'MAS', 'Masalli'),
(242, 15, 'MI', 'Mingacevir'),
(243, 15, 'NA', 'Naftalan'),
(244, 15, 'NEF', 'Neftcala'),
(245, 15, 'OGU', 'Oguz'),
(246, 15, 'ORD', 'Ordubad'),
(247, 15, 'QAB', 'Qabala'),
(248, 15, 'QAX', 'Qax'),
(249, 15, 'QAZ', 'Qazax'),
(250, 15, 'QOB', 'Qobustan'),
(251, 15, 'QBA', 'Quba'),
(252, 15, 'QBI', 'Qubadli'),
(253, 15, 'QUS', 'Qusar'),
(254, 15, 'SA', 'Saki'),
(255, 15, 'SAT', 'Saatli'),
(256, 15, 'SAB', 'Sabirabad'),
(257, 15, 'SAD', 'Sadarak'),
(258, 15, 'SAH', 'Sahbuz'),
(259, 15, 'SAK', 'Saki'),
(260, 15, 'SAL', 'Salyan'),
(261, 15, 'SM', 'Sumqayit'),
(262, 15, 'SMI', 'Samaxi'),
(263, 15, 'SKR', 'Samkir'),
(264, 15, 'SMX', 'Samux'),
(265, 15, 'SAR', 'Sarur'),
(266, 15, 'SIY', 'Siyazan'),
(267, 15, 'SS', 'Susa'),
(268, 15, 'SUS', 'Susa'),
(269, 15, 'TAR', 'Tartar'),
(270, 15, 'TOV', 'Tovuz'),
(271, 15, 'UCA', 'Ucar'),
(272, 15, 'XA', 'Xankandi'),
(273, 15, 'XAC', 'Xacmaz'),
(274, 15, 'XAN', 'Xanlar'),
(275, 15, 'XIZ', 'Xizi'),
(276, 15, 'XCI', 'Xocali'),
(277, 15, 'XVD', 'Xocavand'),
(278, 15, 'YAR', 'Yardimli'),
(279, 15, 'YEV', 'Yevlax'),
(280, 15, 'ZAN', 'Zangilan'),
(281, 15, 'ZAQ', 'Zaqatala'),
(282, 15, 'ZAR', 'Zardab'),
(283, 15, 'NX', 'Naxcivan'),
(284, 16, 'ACK', 'Acklins'),
(285, 16, 'BER', 'Berry Islands'),
(286, 16, 'BIM', 'Bimini'),
(287, 16, 'BLK', 'Black Point'),
(288, 16, 'CAT', 'Cat Island'),
(289, 16, 'CAB', 'Central Abaco'),
(290, 16, 'CAN', 'Central Andros'),
(291, 16, 'CEL', 'Central Eleuthera'),
(292, 16, 'FRE', 'City of Freeport'),
(293, 16, 'CRO', 'Crooked Island'),
(294, 16, 'EGB', 'East Grand Bahama'),
(295, 16, 'EXU', 'Exuma'),
(296, 16, 'GRD', 'Grand Cay'),
(297, 16, 'HAR', 'Harbour Island'),
(298, 16, 'HOP', 'Hope Town'),
(299, 16, 'INA', 'Inagua'),
(300, 16, 'LNG', 'Long Island'),
(301, 16, 'MAN', 'Mangrove Cay'),
(302, 16, 'MAY', 'Mayaguana'),
(303, 16, 'MOO', 'Moore\'s Island'),
(304, 16, 'NAB', 'North Abaco'),
(305, 16, 'NAN', 'North Andros'),
(306, 16, 'NEL', 'North Eleuthera'),
(307, 16, 'RAG', 'Ragged Island'),
(308, 16, 'RUM', 'Rum Cay'),
(309, 16, 'SAL', 'San Salvador'),
(310, 16, 'SAB', 'South Abaco'),
(311, 16, 'SAN', 'South Andros'),
(312, 16, 'SEL', 'South Eleuthera'),
(313, 16, 'SWE', 'Spanish Wells'),
(314, 16, 'WGB', 'West Grand Bahama'),
(315, 17, 'CAP', 'Capital'),
(316, 17, 'CEN', 'Central'),
(317, 17, 'MUH', 'Muharraq'),
(318, 17, 'NOR', 'Northern'),
(319, 17, 'SOU', 'Southern'),
(320, 18, 'BAR', 'Barisal'),
(321, 18, 'CHI', 'Chittagong'),
(322, 18, 'DHA', 'Dhaka'),
(323, 18, 'KHU', 'Khulna'),
(324, 18, 'RAJ', 'Rajshahi'),
(325, 18, 'SYL', 'Sylhet'),
(326, 19, 'CC', 'Christ Church'),
(327, 19, 'AND', 'Saint Andrew'),
(328, 19, 'GEO', 'Saint George'),
(329, 19, 'JAM', 'Saint James'),
(330, 19, 'JOH', 'Saint John'),
(331, 19, 'JOS', 'Saint Joseph'),
(332, 19, 'LUC', 'Saint Lucy'),
(333, 19, 'MIC', 'Saint Michael'),
(334, 19, 'PET', 'Saint Peter'),
(335, 19, 'PHI', 'Saint Philip'),
(336, 19, 'THO', 'Saint Thomas'),
(337, 20, 'BR', 'Brestskaya (Brest)'),
(338, 20, 'HO', 'Homyel\'skaya (Homyel\')'),
(339, 20, 'HM', 'Horad Minsk'),
(340, 20, 'HR', 'Hrodzyenskaya (Hrodna)'),
(341, 20, 'MA', 'Mahilyowskaya (Mahilyow)'),
(342, 20, 'MI', 'Minskaya'),
(343, 20, 'VI', 'Vitsyebskaya (Vitsyebsk)'),
(344, 21, 'VAN', 'Antwerpen'),
(345, 21, 'WBR', 'Brabant Wallon'),
(346, 21, 'WHT', 'Hainaut'),
(347, 21, 'WLG', 'Liege'),
(348, 21, 'VLI', 'Limburg'),
(349, 21, 'WLX', 'Luxembourg'),
(350, 21, 'WNA', 'Namur'),
(351, 21, 'VOV', 'Oost-Vlaanderen'),
(352, 21, 'VBR', 'Vlaams Brabant'),
(353, 21, 'VWV', 'West-Vlaanderen'),
(354, 22, 'BZ', 'Belize'),
(355, 22, 'CY', 'Cayo'),
(356, 22, 'CR', 'Corozal'),
(357, 22, 'OW', 'Orange Walk'),
(358, 22, 'SC', 'Stann Creek'),
(359, 22, 'TO', 'Toledo'),
(360, 23, 'AL', 'Alibori'),
(361, 23, 'AK', 'Atakora'),
(362, 23, 'AQ', 'Atlantique'),
(363, 23, 'BO', 'Borgou'),
(364, 23, 'CO', 'Collines'),
(365, 23, 'DO', 'Donga'),
(366, 23, 'KO', 'Kouffo'),
(367, 23, 'LI', 'Littoral'),
(368, 23, 'MO', 'Mono'),
(369, 23, 'OU', 'Oueme'),
(370, 23, 'PL', 'Plateau'),
(371, 23, 'ZO', 'Zou'),
(372, 24, 'DS', 'Devonshire'),
(373, 24, 'HC', 'Hamilton City'),
(374, 24, 'HA', 'Hamilton'),
(375, 24, 'PG', 'Paget'),
(376, 24, 'PB', 'Pembroke'),
(377, 24, 'GC', 'Saint George City'),
(378, 24, 'SG', 'Saint George\'s'),
(379, 24, 'SA', 'Sandys'),
(380, 24, 'SM', 'Smith\'s'),
(381, 24, 'SH', 'Southampton'),
(382, 24, 'WA', 'Warwick'),
(383, 25, 'BUM', 'Bumthang'),
(384, 25, 'CHU', 'Chukha'),
(385, 25, 'DAG', 'Dagana'),
(386, 25, 'GAS', 'Gasa'),
(387, 25, 'HAA', 'Haa'),
(388, 25, 'LHU', 'Lhuntse'),
(389, 25, 'MON', 'Mongar'),
(390, 25, 'PAR', 'Paro'),
(391, 25, 'PEM', 'Pemagatshel'),
(392, 25, 'PUN', 'Punakha'),
(393, 25, 'SJO', 'Samdrup Jongkhar'),
(394, 25, 'SAT', 'Samtse'),
(395, 25, 'SAR', 'Sarpang'),
(396, 25, 'THI', 'Thimphu'),
(397, 25, 'TRG', 'Trashigang'),
(398, 25, 'TRY', 'Trashiyangste'),
(399, 25, 'TRO', 'Trongsa'),
(400, 25, 'TSI', 'Tsirang'),
(401, 25, 'WPH', 'Wangdue Phodrang'),
(402, 25, 'ZHE', 'Zhemgang'),
(403, 26, 'BEN', 'Beni'),
(404, 26, 'CHU', 'Chuquisaca'),
(405, 26, 'COC', 'Cochabamba'),
(406, 26, 'LPZ', 'La Paz'),
(407, 26, 'ORU', 'Oruro'),
(408, 26, 'PAN', 'Pando'),
(409, 26, 'POT', 'Potosi'),
(410, 26, 'SCZ', 'Santa Cruz'),
(411, 26, 'TAR', 'Tarija'),
(412, 27, 'BRO', 'Brcko district'),
(413, 27, 'FUS', 'Unsko-Sanski Kanton'),
(414, 27, 'FPO', 'Posavski Kanton'),
(415, 27, 'FTU', 'Tuzlanski Kanton'),
(416, 27, 'FZE', 'Zenicko-Dobojski Kanton'),
(417, 27, 'FBP', 'Bosanskopodrinjski Kanton'),
(418, 27, 'FSB', 'Srednjebosanski Kanton'),
(419, 27, 'FHN', 'Hercegovacko-neretvanski Kanton'),
(420, 27, 'FZH', 'Zapadnohercegovacka Zupanija'),
(421, 27, 'FSA', 'Kanton Sarajevo'),
(422, 27, 'FZA', 'Zapadnobosanska'),
(423, 27, 'SBL', 'Banja Luka'),
(424, 27, 'SDO', 'Doboj'),
(425, 27, 'SBI', 'Bijeljina'),
(426, 27, 'SVL', 'Vlasenica'),
(427, 27, 'SSR', 'Sarajevo-Romanija or Sokolac'),
(428, 27, 'SFO', 'Foca'),
(429, 27, 'STR', 'Trebinje'),
(430, 28, 'CE', 'Central'),
(431, 28, 'GH', 'Ghanzi'),
(432, 28, 'KD', 'Kgalagadi'),
(433, 28, 'KT', 'Kgatleng'),
(434, 28, 'KW', 'Kweneng'),
(435, 28, 'NG', 'Ngamiland'),
(436, 28, 'NE', 'North East'),
(437, 28, 'NW', 'North West'),
(438, 28, 'SE', 'South East'),
(439, 28, 'SO', 'Southern'),
(440, 30, 'AC', 'Acre'),
(441, 30, 'AL', 'Alagoas'),
(442, 30, 'AP', 'Amapa'),
(443, 30, 'AM', 'Amazonas'),
(444, 30, 'BA', 'Bahia'),
(445, 30, 'CE', 'Ceara'),
(446, 30, 'DF', 'Distrito Federal'),
(447, 30, 'ES', 'Espirito Santo'),
(448, 30, 'GO', 'Goias'),
(449, 30, 'MA', 'Maranhao'),
(450, 30, 'MT', 'Mato Grosso'),
(451, 30, 'MS', 'Mato Grosso do Sul'),
(452, 30, 'MG', 'Minas Gerais'),
(453, 30, 'PA', 'Para'),
(454, 30, 'PB', 'Paraiba'),
(455, 30, 'PR', 'Parana'),
(456, 30, 'PE', 'Pernambuco'),
(457, 30, 'PI', 'Piaui'),
(458, 30, 'RJ', 'Rio de Janeiro'),
(459, 30, 'RN', 'Rio Grande do Norte'),
(460, 30, 'RS', 'Rio Grande do Sul'),
(461, 30, 'RO', 'Rondonia'),
(462, 30, 'RR', 'Roraima'),
(463, 30, 'SC', 'Santa Catarina'),
(464, 30, 'SP', 'Sao Paulo'),
(465, 30, 'SE', 'Sergipe'),
(466, 30, 'TO', 'Tocantins'),
(467, 31, 'PB', 'Peros Banhos'),
(468, 31, 'SI', 'Salomon Islands'),
(469, 31, 'NI', 'Nelsons Island'),
(470, 31, 'TB', 'Three Brothers'),
(471, 31, 'EA', 'Eagle Islands'),
(472, 31, 'DI', 'Danger Island'),
(473, 31, 'EG', 'Egmont Islands'),
(474, 31, 'DG', 'Diego Garcia'),
(475, 32, 'BEL', 'Belait'),
(476, 32, 'BRM', 'Brunei and Muara'),
(477, 32, 'TEM', 'Temburong'),
(478, 32, 'TUT', 'Tutong'),
(479, 33, '', 'Blagoevgrad'),
(480, 33, '', 'Burgas'),
(481, 33, '', 'Dobrich'),
(482, 33, '', 'Gabrovo'),
(483, 33, '', 'Haskovo'),
(484, 33, '', 'Kardjali'),
(485, 33, '', 'Kyustendil'),
(486, 33, '', 'Lovech'),
(487, 33, '', 'Montana'),
(488, 33, '', 'Pazardjik'),
(489, 33, '', 'Pernik'),
(490, 33, '', 'Pleven'),
(491, 33, '', 'Plovdiv'),
(492, 33, '', 'Razgrad'),
(493, 33, '', 'Shumen'),
(494, 33, '', 'Silistra'),
(495, 33, '', 'Sliven'),
(496, 33, '', 'Smolyan'),
(497, 33, '', 'Sofia'),
(498, 33, '', 'Sofia - town'),
(499, 33, '', 'Stara Zagora'),
(500, 33, '', 'Targovishte'),
(501, 33, '', 'Varna'),
(502, 33, '', 'Veliko Tarnovo'),
(503, 33, '', 'Vidin'),
(504, 33, '', 'Vratza'),
(505, 33, '', 'Yambol'),
(506, 34, 'BAL', 'Bale'),
(507, 34, 'BAM', 'Bam'),
(508, 34, 'BAN', 'Banwa'),
(509, 34, 'BAZ', 'Bazega'),
(510, 34, 'BOR', 'Bougouriba'),
(511, 34, 'BLG', 'Boulgou'),
(512, 34, 'BOK', 'Boulkiemde'),
(513, 34, 'COM', 'Comoe'),
(514, 34, 'GAN', 'Ganzourgou'),
(515, 34, 'GNA', 'Gnagna'),
(516, 34, 'GOU', 'Gourma'),
(517, 34, 'HOU', 'Houet'),
(518, 34, 'IOA', 'Ioba'),
(519, 34, 'KAD', 'Kadiogo'),
(520, 34, 'KEN', 'Kenedougou'),
(521, 34, 'KOD', 'Komondjari'),
(522, 34, 'KOP', 'Kompienga'),
(523, 34, 'KOS', 'Kossi'),
(524, 34, 'KOL', 'Koulpelogo'),
(525, 34, 'KOT', 'Kouritenga'),
(526, 34, 'KOW', 'Kourweogo'),
(527, 34, 'LER', 'Leraba'),
(528, 34, 'LOR', 'Loroum'),
(529, 34, 'MOU', 'Mouhoun'),
(530, 34, 'NAH', 'Nahouri'),
(531, 34, 'NAM', 'Namentenga'),
(532, 34, 'NAY', 'Nayala'),
(533, 34, 'NOU', 'Noumbiel'),
(534, 34, 'OUB', 'Oubritenga'),
(535, 34, 'OUD', 'Oudalan'),
(536, 34, 'PAS', 'Passore'),
(537, 34, 'PON', 'Poni'),
(538, 34, 'SAG', 'Sanguie'),
(539, 34, 'SAM', 'Sanmatenga'),
(540, 34, 'SEN', 'Seno'),
(541, 34, 'SIS', 'Sissili'),
(542, 34, 'SOM', 'Soum'),
(543, 34, 'SOR', 'Sourou'),
(544, 34, 'TAP', 'Tapoa'),
(545, 34, 'TUY', 'Tuy'),
(546, 34, 'YAG', 'Yagha'),
(547, 34, 'YAT', 'Yatenga'),
(548, 34, 'ZIR', 'Ziro'),
(549, 34, 'ZOD', 'Zondoma'),
(550, 34, 'ZOW', 'Zoundweogo'),
(551, 35, 'BB', 'Bubanza'),
(552, 35, 'BJ', 'Bujumbura'),
(553, 35, 'BR', 'Bururi'),
(554, 35, 'CA', 'Cankuzo'),
(555, 35, 'CI', 'Cibitoke'),
(556, 35, 'GI', 'Gitega'),
(557, 35, 'KR', 'Karuzi'),
(558, 35, 'KY', 'Kayanza'),
(559, 35, 'KI', 'Kirundo'),
(560, 35, 'MA', 'Makamba'),
(561, 35, 'MU', 'Muramvya'),
(562, 35, 'MY', 'Muyinga'),
(563, 35, 'MW', 'Mwaro'),
(564, 35, 'NG', 'Ngozi'),
(565, 35, 'RT', 'Rutana'),
(566, 35, 'RY', 'Ruyigi'),
(567, 36, 'PP', 'Phnom Penh'),
(568, 36, 'PS', 'Preah Seihanu (Kompong Som or Sihanoukville)'),
(569, 36, 'PA', 'Pailin'),
(570, 36, 'KB', 'Keb'),
(571, 36, 'BM', 'Banteay Meanchey'),
(572, 36, 'BA', 'Battambang'),
(573, 36, 'KM', 'Kampong Cham'),
(574, 36, 'KN', 'Kampong Chhnang'),
(575, 36, 'KU', 'Kampong Speu'),
(576, 36, 'KO', 'Kampong Som'),
(577, 36, 'KT', 'Kampong Thom'),
(578, 36, 'KP', 'Kampot'),
(579, 36, 'KL', 'Kandal'),
(580, 36, 'KK', 'Kaoh Kong'),
(581, 36, 'KR', 'Kratie'),
(582, 36, 'MK', 'Mondul Kiri'),
(583, 36, 'OM', 'Oddar Meancheay'),
(584, 36, 'PU', 'Pursat'),
(585, 36, 'PR', 'Preah Vihear'),
(586, 36, 'PG', 'Prey Veng'),
(587, 36, 'RK', 'Ratanak Kiri'),
(588, 36, 'SI', 'Siemreap'),
(589, 36, 'ST', 'Stung Treng'),
(590, 36, 'SR', 'Svay Rieng'),
(591, 36, 'TK', 'Takeo'),
(592, 37, 'ADA', 'Adamawa (Adamaoua)'),
(593, 37, 'CEN', 'Centre'),
(594, 37, 'EST', 'East (Est)'),
(595, 37, 'EXN', 'Extreme North (Extreme-Nord)'),
(596, 37, 'LIT', 'Littoral'),
(597, 37, 'NOR', 'North (Nord)'),
(598, 37, 'NOT', 'Northwest (Nord-Ouest)'),
(599, 37, 'OUE', 'West (Ouest)'),
(600, 37, 'SUD', 'South (Sud)'),
(601, 37, 'SOU', 'Southwest (Sud-Ouest).'),
(602, 38, 'AB', 'Alberta'),
(603, 38, 'BC', 'British Columbia'),
(604, 38, 'MB', 'Manitoba'),
(605, 38, 'NB', 'New Brunswick'),
(606, 38, 'NL', 'Newfoundland and Labrador'),
(607, 38, 'NT', 'Northwest Territories'),
(608, 38, 'NS', 'Nova Scotia'),
(609, 38, 'NU', 'Nunavut'),
(610, 38, 'ON', 'Ontario'),
(611, 38, 'PE', 'Prince Edward Island'),
(612, 38, 'QC', 'Qu&eacute;bec'),
(613, 38, 'SK', 'Saskatchewan'),
(614, 38, 'YT', 'Yukon Territory'),
(615, 39, 'BV', 'Boa Vista'),
(616, 39, 'BR', 'Brava'),
(617, 39, 'CS', 'Calheta de Sao Miguel'),
(618, 39, 'MA', 'Maio'),
(619, 39, 'MO', 'Mosteiros'),
(620, 39, 'PA', 'Paul'),
(621, 39, 'PN', 'Porto Novo'),
(622, 39, 'PR', 'Praia'),
(623, 39, 'RG', 'Ribeira Grande'),
(624, 39, 'SL', 'Sal'),
(625, 39, 'CA', 'Santa Catarina'),
(626, 39, 'CR', 'Santa Cruz'),
(627, 39, 'SD', 'Sao Domingos'),
(628, 39, 'SF', 'Sao Filipe'),
(629, 39, 'SN', 'Sao Nicolau'),
(630, 39, 'SV', 'Sao Vicente'),
(631, 39, 'TA', 'Tarrafal'),
(632, 40, 'CR', 'Creek'),
(633, 40, 'EA', 'Eastern'),
(634, 40, 'ML', 'Midland'),
(635, 40, 'ST', 'South Town'),
(636, 40, 'SP', 'Spot Bay'),
(637, 40, 'SK', 'Stake Bay'),
(638, 40, 'WD', 'West End'),
(639, 40, 'WN', 'Western'),
(640, 41, 'BBA', 'Bamingui-Bangoran'),
(641, 41, 'BKO', 'Basse-Kotto'),
(642, 41, 'HKO', 'Haute-Kotto'),
(643, 41, 'HMB', 'Haut-Mbomou'),
(644, 41, 'KEM', 'Kemo'),
(645, 41, 'LOB', 'Lobaye'),
(646, 41, 'MKD', 'Mambere-KadeÔ'),
(647, 41, 'MBO', 'Mbomou'),
(648, 41, 'NMM', 'Nana-Mambere'),
(649, 41, 'OMP', 'Ombella-M\'Poko'),
(650, 41, 'OUK', 'Ouaka'),
(651, 41, 'OUH', 'Ouham'),
(652, 41, 'OPE', 'Ouham-Pende'),
(653, 41, 'VAK', 'Vakaga'),
(654, 41, 'NGR', 'Nana-Grebizi'),
(655, 41, 'SMB', 'Sangha-Mbaere'),
(656, 41, 'BAN', 'Bangui'),
(657, 42, 'BA', 'Batha'),
(658, 42, 'BI', 'Biltine'),
(659, 42, 'BE', 'Borkou-Ennedi-Tibesti'),
(660, 42, 'CB', 'Chari-Baguirmi'),
(661, 42, 'GU', 'Guera'),
(662, 42, 'KA', 'Kanem'),
(663, 42, 'LA', 'Lac'),
(664, 42, 'LC', 'Logone Occidental'),
(665, 42, 'LR', 'Logone Oriental'),
(666, 42, 'MK', 'Mayo-Kebbi'),
(667, 42, 'MC', 'Moyen-Chari'),
(668, 42, 'OU', 'Ouaddai'),
(669, 42, 'SA', 'Salamat'),
(670, 42, 'TA', 'Tandjile'),
(671, 43, 'AI', 'Aisen del General Carlos Ibanez'),
(672, 43, 'AN', 'Antofagasta'),
(673, 43, 'AR', 'Araucania'),
(674, 43, 'AT', 'Atacama'),
(675, 43, 'BI', 'Bio-Bio'),
(676, 43, 'CO', 'Coquimbo'),
(677, 43, 'LI', 'Libertador General Bernardo O\'Hi'),
(678, 43, 'LL', 'Los Lagos'),
(679, 43, 'MA', 'Magallanes y de la Antartica Chi'),
(680, 43, 'ML', 'Maule'),
(681, 43, 'RM', 'Region Metropolitana'),
(682, 43, 'TA', 'Tarapaca'),
(683, 43, 'VS', 'Valparaiso'),
(684, 44, 'AN', 'Anhui'),
(685, 44, 'BE', 'Beijing'),
(686, 44, 'CH', 'Chongqing'),
(687, 44, 'FU', 'Fujian'),
(688, 44, 'GA', 'Gansu'),
(689, 44, 'GU', 'Guangdong'),
(690, 44, 'GX', 'Guangxi'),
(691, 44, 'GZ', 'Guizhou'),
(692, 44, 'HA', 'Hainan'),
(693, 44, 'HB', 'Hebei'),
(694, 44, 'HL', 'Heilongjiang'),
(695, 44, 'HE', 'Henan'),
(696, 44, 'HK', 'Hong Kong'),
(697, 44, 'HU', 'Hubei'),
(698, 44, 'HN', 'Hunan'),
(699, 44, 'IM', 'Inner Mongolia'),
(700, 44, 'JI', 'Jiangsu'),
(701, 44, 'JX', 'Jiangxi'),
(702, 44, 'JL', 'Jilin'),
(703, 44, 'LI', 'Liaoning'),
(704, 44, 'MA', 'Macau'),
(705, 44, 'NI', 'Ningxia'),
(706, 44, 'SH', 'Shaanxi'),
(707, 44, 'SA', 'Shandong'),
(708, 44, 'SG', 'Shanghai'),
(709, 44, 'SX', 'Shanxi'),
(710, 44, 'SI', 'Sichuan'),
(711, 44, 'TI', 'Tianjin'),
(712, 44, 'XI', 'Xinjiang'),
(713, 44, 'YU', 'Yunnan'),
(714, 44, 'ZH', 'Zhejiang'),
(715, 46, 'D', 'Direction Island'),
(716, 46, 'H', 'Home Island'),
(717, 46, 'O', 'Horsburgh Island'),
(718, 46, 'S', 'South Island'),
(719, 46, 'W', 'West Island'),
(720, 47, 'AMZ', 'Amazonas'),
(721, 47, 'ANT', 'Antioquia'),
(722, 47, 'ARA', 'Arauca'),
(723, 47, 'ATL', 'Atlantico'),
(724, 47, 'BDC', 'Bogota D.C.'),
(725, 47, 'BOL', 'Bolivar'),
(726, 47, 'BOY', 'Boyaca'),
(727, 47, 'CAL', 'Caldas'),
(728, 47, 'CAQ', 'Caqueta'),
(729, 47, 'CAS', 'Casanare'),
(730, 47, 'CAU', 'Cauca'),
(731, 47, 'CES', 'Cesar'),
(732, 47, 'CHO', 'Choco'),
(733, 47, 'COR', 'Cordoba'),
(734, 47, 'CAM', 'Cundinamarca'),
(735, 47, 'GNA', 'Guainia'),
(736, 47, 'GJR', 'Guajira'),
(737, 47, 'GVR', 'Guaviare'),
(738, 47, 'HUI', 'Huila'),
(739, 47, 'MAG', 'Magdalena'),
(740, 47, 'MET', 'Meta'),
(741, 47, 'NAR', 'Narino'),
(742, 47, 'NDS', 'Norte de Santander'),
(743, 47, 'PUT', 'Putumayo'),
(744, 47, 'QUI', 'Quindio'),
(745, 47, 'RIS', 'Risaralda'),
(746, 47, 'SAP', 'San Andres y Providencia'),
(747, 47, 'SAN', 'Santander'),
(748, 47, 'SUC', 'Sucre'),
(749, 47, 'TOL', 'Tolima'),
(750, 47, 'VDC', 'Valle del Cauca'),
(751, 47, 'VAU', 'Vaupes'),
(752, 47, 'VIC', 'Vichada'),
(753, 48, 'G', 'Grande Comore'),
(754, 48, 'A', 'Anjouan'),
(755, 48, 'M', 'Moheli'),
(756, 49, 'BO', 'Bouenza'),
(757, 49, 'BR', 'Brazzaville'),
(758, 49, 'CU', 'Cuvette'),
(759, 49, 'CO', 'Cuvette-Ouest'),
(760, 49, 'KO', 'Kouilou'),
(761, 49, 'LE', 'Lekoumou'),
(762, 49, 'LI', 'Likouala'),
(763, 49, 'NI', 'Niari'),
(764, 49, 'PL', 'Plateaux'),
(765, 49, 'PO', 'Pool'),
(766, 49, 'SA', 'Sangha'),
(767, 50, 'PU', 'Pukapuka'),
(768, 50, 'RK', 'Rakahanga'),
(769, 50, 'MK', 'Manihiki'),
(770, 50, 'PE', 'Penrhyn'),
(771, 50, 'NI', 'Nassau Island'),
(772, 50, 'SU', 'Surwarrow'),
(773, 50, 'PA', 'Palmerston'),
(774, 50, 'AI', 'Aitutaki'),
(775, 50, 'MA', 'Manuae'),
(776, 50, 'TA', 'Takutea'),
(777, 50, 'MT', 'Mitiaro'),
(778, 50, 'AT', 'Atiu'),
(779, 50, 'MU', 'Mauke'),
(780, 50, 'RR', 'Rarotonga'),
(781, 50, 'MG', 'Mangaia'),
(782, 51, 'AL', 'Alajuela'),
(783, 51, 'CA', 'Cartago'),
(784, 51, 'GU', 'Guanacaste'),
(785, 51, 'HE', 'Heredia'),
(786, 51, 'LI', 'Limon'),
(787, 51, 'PU', 'Puntarenas'),
(788, 51, 'SJ', 'San Jose'),
(789, 52, 'ABE', 'Abengourou'),
(790, 52, 'ABI', 'Abidjan'),
(791, 52, 'ABO', 'Aboisso'),
(792, 52, 'ADI', 'Adiake'),
(793, 52, 'ADZ', 'Adzope'),
(794, 52, 'AGB', 'Agboville'),
(795, 52, 'AGN', 'Agnibilekrou'),
(796, 52, 'ALE', 'Alepe'),
(797, 52, 'BOC', 'Bocanda'),
(798, 52, 'BAN', 'Bangolo'),
(799, 52, 'BEO', 'Beoumi'),
(800, 52, 'BIA', 'Biankouma'),
(801, 52, 'BDK', 'Bondoukou'),
(802, 52, 'BGN', 'Bongouanou'),
(803, 52, 'BFL', 'Bouafle'),
(804, 52, 'BKE', 'Bouake'),
(805, 52, 'BNA', 'Bouna'),
(806, 52, 'BDL', 'Boundiali'),
(807, 52, 'DKL', 'Dabakala'),
(808, 52, 'DBU', 'Dabou'),
(809, 52, 'DAL', 'Daloa'),
(810, 52, 'DAN', 'Danane'),
(811, 52, 'DAO', 'Daoukro'),
(812, 52, 'DIM', 'Dimbokro'),
(813, 52, 'DIV', 'Divo'),
(814, 52, 'DUE', 'Duekoue'),
(815, 52, 'FER', 'Ferkessedougou'),
(816, 52, 'GAG', 'Gagnoa'),
(817, 52, 'GBA', 'Grand-Bassam'),
(818, 52, 'GLA', 'Grand-Lahou'),
(819, 52, 'GUI', 'Guiglo'),
(820, 52, 'ISS', 'Issia'),
(821, 52, 'JAC', 'Jacqueville'),
(822, 52, 'KAT', 'Katiola'),
(823, 52, 'KOR', 'Korhogo'),
(824, 52, 'LAK', 'Lakota'),
(825, 52, 'MAN', 'Man'),
(826, 52, 'MKN', 'Mankono'),
(827, 52, 'MBA', 'Mbahiakro'),
(828, 52, 'ODI', 'Odienne'),
(829, 52, 'OUM', 'Oume'),
(830, 52, 'SAK', 'Sakassou'),
(831, 52, 'SPE', 'San-Pedro'),
(832, 52, 'SAS', 'Sassandra'),
(833, 52, 'SEG', 'Seguela'),
(834, 52, 'SIN', 'Sinfra'),
(835, 52, 'SOU', 'Soubre'),
(836, 52, 'TAB', 'Tabou'),
(837, 52, 'TAN', 'Tanda'),
(838, 52, 'TIE', 'Tiebissou'),
(839, 52, 'TIN', 'Tingrela'),
(840, 52, 'TIA', 'Tiassale'),
(841, 52, 'TBA', 'Touba'),
(842, 52, 'TLP', 'Toulepleu'),
(843, 52, 'TMD', 'Toumodi'),
(844, 52, 'VAV', 'Vavoua'),
(845, 52, 'YAM', 'Yamoussoukro'),
(846, 52, 'ZUE', 'Zuenoula'),
(847, 53, 'BB', 'Bjelovar-Bilogora'),
(848, 53, 'CZ', 'City of Zagreb'),
(849, 53, 'DN', 'Dubrovnik-Neretva'),
(850, 53, 'IS', 'Istra'),
(851, 53, 'KA', 'Karlovac'),
(852, 53, 'KK', 'Koprivnica-Krizevci'),
(853, 53, 'KZ', 'Krapina-Zagorje'),
(854, 53, 'LS', 'Lika-Senj'),
(855, 53, 'ME', 'Medimurje'),
(856, 53, 'OB', 'Osijek-Baranja'),
(857, 53, 'PS', 'Pozega-Slavonia'),
(858, 53, 'PG', 'Primorje-Gorski Kotar'),
(859, 53, 'SI', 'Sibenik'),
(860, 53, 'SM', 'Sisak-Moslavina'),
(861, 53, 'SB', 'Slavonski Brod-Posavina'),
(862, 53, 'SD', 'Split-Dalmatia'),
(863, 53, 'VA', 'Varazdin'),
(864, 53, 'VP', 'Virovitica-Podravina'),
(865, 53, 'VS', 'Vukovar-Srijem'),
(866, 53, 'ZK', 'Zadar-Knin'),
(867, 53, 'ZA', 'Zagreb'),
(868, 54, 'CA', 'Camaguey'),
(869, 54, 'CD', 'Ciego de Avila'),
(870, 54, 'CI', 'Cienfuegos'),
(871, 54, 'CH', 'Ciudad de La Habana'),
(872, 54, 'GR', 'Granma'),
(873, 54, 'GU', 'Guantanamo'),
(874, 54, 'HO', 'Holguin'),
(875, 54, 'IJ', 'Isla de la Juventud'),
(876, 54, 'LH', 'La Habana'),
(877, 54, 'LT', 'Las Tunas'),
(878, 54, 'MA', 'Matanzas'),
(879, 54, 'PR', 'Pinar del Rio'),
(880, 54, 'SS', 'Sancti Spiritus'),
(881, 54, 'SC', 'Santiago de Cuba'),
(882, 54, 'VC', 'Villa Clara'),
(883, 55, 'F', 'Famagusta'),
(884, 55, 'K', 'Kyrenia'),
(885, 55, 'A', 'Larnaca'),
(886, 55, 'I', 'Limassol'),
(887, 55, 'N', 'Nicosia'),
(888, 55, 'P', 'Paphos'),
(889, 56, 'U', 'Ustecky'),
(890, 56, 'C', 'Jihocesky'),
(891, 56, 'B', 'Jihomoravsky'),
(892, 56, 'K', 'Karlovarsky'),
(893, 56, 'H', 'Kralovehradecky'),
(894, 56, 'L', 'Liberecky'),
(895, 56, 'T', 'Moravskoslezsky'),
(896, 56, 'M', 'Olomoucky'),
(897, 56, 'E', 'Pardubicky'),
(898, 56, 'P', 'Plzensky'),
(899, 56, 'A', 'Praha'),
(900, 56, 'S', 'Stredocesky'),
(901, 56, 'J', 'Vysocina'),
(902, 56, 'Z', 'Zlinsky'),
(903, 57, 'AR', 'Arhus'),
(904, 57, 'BH', 'Bornholm'),
(905, 57, 'CO', 'Copenhagen'),
(906, 57, 'FO', 'Faroe Islands'),
(907, 57, 'FR', 'Frederiksborg'),
(908, 57, 'FY', 'Fyn'),
(909, 57, 'KO', 'Kobenhavn'),
(910, 57, 'NO', 'Nordjylland'),
(911, 57, 'RI', 'Ribe'),
(912, 57, 'RK', 'Ringkobing'),
(913, 57, 'RO', 'Roskilde'),
(914, 57, 'SO', 'Sonderjylland'),
(915, 57, 'ST', 'Storstrom'),
(916, 57, 'VK', 'Vejle'),
(917, 57, 'VJ', 'Vestj&aelig;lland'),
(918, 57, 'VB', 'Viborg'),
(919, 58, 'S', '`Ali Sabih'),
(920, 58, 'K', 'Dikhil'),
(921, 58, 'J', 'Djibouti'),
(922, 58, 'O', 'Obock'),
(923, 58, 'T', 'Tadjoura'),
(924, 59, 'AND', 'Saint Andrew Parish'),
(925, 59, 'DAV', 'Saint David Parish'),
(926, 59, 'GEO', 'Saint George Parish'),
(927, 59, 'JOH', 'Saint John Parish'),
(928, 59, 'JOS', 'Saint Joseph Parish'),
(929, 59, 'LUK', 'Saint Luke Parish'),
(930, 59, 'MAR', 'Saint Mark Parish'),
(931, 59, 'PAT', 'Saint Patrick Parish'),
(932, 59, 'PAU', 'Saint Paul Parish'),
(933, 59, 'PET', 'Saint Peter Parish'),
(934, 60, 'DN', 'Distrito Nacional'),
(935, 60, 'AZ', 'Azua'),
(936, 60, 'BC', 'Baoruco'),
(937, 60, 'BH', 'Barahona'),
(938, 60, 'DJ', 'Dajabon'),
(939, 60, 'DU', 'Duarte'),
(940, 60, 'EL', 'Elias Pina'),
(941, 60, 'SY', 'El Seybo'),
(942, 60, 'ET', 'Espaillat'),
(943, 60, 'HM', 'Hato Mayor'),
(944, 60, 'IN', 'Independencia'),
(945, 60, 'AL', 'La Altagracia'),
(946, 60, 'RO', 'La Romana'),
(947, 60, 'VE', 'La Vega'),
(948, 60, 'MT', 'Maria Trinidad Sanchez'),
(949, 60, 'MN', 'Monsenor Nouel'),
(950, 60, 'MC', 'Monte Cristi'),
(951, 60, 'MP', 'Monte Plata'),
(952, 60, 'PD', 'Pedernales'),
(953, 60, 'PR', 'Peravia (Bani)'),
(954, 60, 'PP', 'Puerto Plata'),
(955, 60, 'SL', 'Salcedo'),
(956, 60, 'SM', 'Samana'),
(957, 60, 'SH', 'Sanchez Ramirez'),
(958, 60, 'SC', 'San Cristobal'),
(959, 60, 'JO', 'San Jose de Ocoa'),
(960, 60, 'SJ', 'San Juan'),
(961, 60, 'PM', 'San Pedro de Macoris'),
(962, 60, 'SA', 'Santiago'),
(963, 60, 'ST', 'Santiago Rodriguez'),
(964, 60, 'SD', 'Santo Domingo'),
(965, 60, 'VA', 'Valverde'),
(966, 61, 'AL', 'Aileu'),
(967, 61, 'AN', 'Ainaro'),
(968, 61, 'BA', 'Baucau'),
(969, 61, 'BO', 'Bobonaro'),
(970, 61, 'CO', 'Cova Lima'),
(971, 61, 'DI', 'Dili'),
(972, 61, 'ER', 'Ermera'),
(973, 61, 'LA', 'Lautem'),
(974, 61, 'LI', 'Liquica'),
(975, 61, 'MT', 'Manatuto'),
(976, 61, 'MF', 'Manufahi'),
(977, 61, 'OE', 'Oecussi'),
(978, 61, 'VI', 'Viqueque'),
(979, 62, 'AZU', 'Azuay'),
(980, 62, 'BOL', 'Bolivar'),
(981, 62, 'CAN', 'Ca&ntilde;ar'),
(982, 62, 'CAR', 'Carchi'),
(983, 62, 'CHI', 'Chimborazo'),
(984, 62, 'COT', 'Cotopaxi'),
(985, 62, 'EOR', 'El Oro'),
(986, 62, 'ESM', 'Esmeraldas'),
(987, 62, 'GPS', 'Gal&aacute;pagos'),
(988, 62, 'GUA', 'Guayas'),
(989, 62, 'IMB', 'Imbabura'),
(990, 62, 'LOJ', 'Loja'),
(991, 62, 'LRO', 'Los Rios'),
(992, 62, 'MAN', 'Manab&iacute;'),
(993, 62, 'MSA', 'Morona Santiago'),
(994, 62, 'NAP', 'Napo'),
(995, 62, 'ORE', 'Orellana'),
(996, 62, 'PAS', 'Pastaza'),
(997, 62, 'PIC', 'Pichincha'),
(998, 62, 'SUC', 'Sucumb&iacute;os'),
(999, 62, 'TUN', 'Tungurahua'),
(1000, 62, 'ZCH', 'Zamora Chinchipe'),
(1001, 63, 'DHY', 'Ad Daqahliyah'),
(1002, 63, 'BAM', 'Al Bahr al Ahmar'),
(1003, 63, 'BHY', 'Al Buhayrah'),
(1004, 63, 'FYM', 'Al Fayyum'),
(1005, 63, 'GBY', 'Al Gharbiyah'),
(1006, 63, 'IDR', 'Al Iskandariyah'),
(1007, 63, 'IML', 'Al Isma\'iliyah'),
(1008, 63, 'JZH', 'Al Jizah'),
(1009, 63, 'MFY', 'Al Minufiyah'),
(1010, 63, 'MNY', 'Al Minya'),
(1011, 63, 'QHR', 'Al Qahirah'),
(1012, 63, 'QLY', 'Al Qalyubiyah'),
(1013, 63, 'WJD', 'Al Wadi al Jadid'),
(1014, 63, 'SHQ', 'Ash Sharqiyah'),
(1015, 63, 'SWY', 'As Suways'),
(1016, 63, 'ASW', 'Aswan'),
(1017, 63, 'ASY', 'Asyut'),
(1018, 63, 'BSW', 'Bani Suwayf'),
(1019, 63, 'BSD', 'Bur Sa\'id'),
(1020, 63, 'DMY', 'Dumyat'),
(1021, 63, 'JNS', 'Janub Sina\''),
(1022, 63, 'KSH', 'Kafr ash Shaykh'),
(1023, 63, 'MAT', 'Matruh'),
(1024, 63, 'QIN', 'Qina'),
(1025, 63, 'SHS', 'Shamal Sina\''),
(1026, 63, 'SUH', 'Suhaj'),
(1027, 64, 'AH', 'Ahuachapan'),
(1028, 64, 'CA', 'Cabanas'),
(1029, 64, 'CH', 'Chalatenango'),
(1030, 64, 'CU', 'Cuscatlan'),
(1031, 64, 'LB', 'La Libertad'),
(1032, 64, 'PZ', 'La Paz'),
(1033, 64, 'UN', 'La Union'),
(1034, 64, 'MO', 'Morazan'),
(1035, 64, 'SM', 'San Miguel'),
(1036, 64, 'SS', 'San Salvador'),
(1037, 64, 'SV', 'San Vicente'),
(1038, 64, 'SA', 'Santa Ana'),
(1039, 64, 'SO', 'Sonsonate'),
(1040, 64, 'US', 'Usulutan'),
(1041, 65, 'AN', 'Provincia Annobon'),
(1042, 65, 'BN', 'Provincia Bioko Norte'),
(1043, 65, 'BS', 'Provincia Bioko Sur'),
(1044, 65, 'CS', 'Provincia Centro Sur'),
(1045, 65, 'KN', 'Provincia Kie-Ntem'),
(1046, 65, 'LI', 'Provincia Litoral'),
(1047, 65, 'WN', 'Provincia Wele-Nzas'),
(1048, 66, 'MA', 'Central (Maekel)'),
(1049, 66, 'KE', 'Anseba (Keren)'),
(1050, 66, 'DK', 'Southern Red Sea (Debub-Keih-Bahri)'),
(1051, 66, 'SK', 'Northern Red Sea (Semien-Keih-Bahri)'),
(1052, 66, 'DE', 'Southern (Debub)'),
(1053, 66, 'BR', 'Gash-Barka (Barentu)'),
(1054, 67, 'HA', 'Harjumaa (Tallinn)'),
(1055, 67, 'HI', 'Hiiumaa (Kardla)'),
(1056, 67, 'IV', 'Ida-Virumaa (Johvi)'),
(1057, 67, 'JA', 'Jarvamaa (Paide)'),
(1058, 67, 'JO', 'Jogevamaa (Jogeva)'),
(1059, 67, 'LV', 'Laane-Virumaa (Rakvere)'),
(1060, 67, 'LA', 'Laanemaa (Haapsalu)'),
(1061, 67, 'PA', 'Parnumaa (Parnu)'),
(1062, 67, 'PO', 'Polvamaa (Polva)'),
(1063, 67, 'RA', 'Raplamaa (Rapla)'),
(1064, 67, 'SA', 'Saaremaa (Kuessaare)'),
(1065, 67, 'TA', 'Tartumaa (Tartu)'),
(1066, 67, 'VA', 'Valgamaa (Valga)'),
(1067, 67, 'VI', 'Viljandimaa (Viljandi)'),
(1068, 67, 'VO', 'Vorumaa (Voru)'),
(1069, 68, 'AF', 'Afar'),
(1070, 68, 'AH', 'Amhara'),
(1071, 68, 'BG', 'Benishangul-Gumaz'),
(1072, 68, 'GB', 'Gambela'),
(1073, 68, 'HR', 'Hariai'),
(1074, 68, 'OR', 'Oromia'),
(1075, 68, 'SM', 'Somali'),
(1076, 68, 'SN', 'Southern Nations - Nationalities and Peoples Region'),
(1077, 68, 'TG', 'Tigray'),
(1078, 68, 'AA', 'Addis Ababa'),
(1079, 68, 'DD', 'Dire Dawa'),
(1080, 71, 'C', 'Central Division'),
(1081, 71, 'N', 'Northern Division'),
(1082, 71, 'E', 'Eastern Division'),
(1083, 71, 'W', 'Western Division'),
(1084, 71, 'R', 'Rotuma'),
(1085, 72, 'AL', 'Ahvenanmaan Laani'),
(1086, 72, 'ES', 'Etela-Suomen Laani'),
(1087, 72, 'IS', 'Ita-Suomen Laani'),
(1088, 72, 'LS', 'Lansi-Suomen Laani'),
(1089, 72, 'LA', 'Lapin Lanani'),
(1090, 72, 'OU', 'Oulun Laani'),
(1091, 73, 'AL', 'Alsace'),
(1092, 73, 'AQ', 'Aquitaine'),
(1093, 73, 'AU', 'Auvergne'),
(1094, 73, 'BR', 'Brittany'),
(1095, 73, 'BU', 'Burgundy'),
(1096, 73, 'CE', 'Center Loire Valley'),
(1097, 73, 'CH', 'Champagne'),
(1098, 73, 'CO', 'Corse'),
(1099, 73, 'FR', 'France Comte'),
(1100, 73, 'LA', 'Languedoc Roussillon'),
(1101, 73, 'LI', 'Limousin'),
(1102, 73, 'LO', 'Lorraine'),
(1103, 73, 'MI', 'Midi Pyrenees'),
(1104, 73, 'NO', 'Nord Pas de Calais'),
(1105, 73, 'NR', 'Normandy'),
(1106, 73, 'PA', 'Paris / Ill de France'),
(1107, 73, 'PI', 'Picardie'),
(1108, 73, 'PO', 'Poitou Charente'),
(1109, 73, 'PR', 'Provence'),
(1110, 73, 'RH', 'Rhone Alps'),
(1111, 73, 'RI', 'Riviera'),
(1112, 73, 'WE', 'Western Loire Valley'),
(1113, 74, 'Et', 'Etranger'),
(1114, 74, '01', 'Ain'),
(1115, 74, '02', 'Aisne'),
(1116, 74, '03', 'Allier'),
(1117, 74, '04', 'Alpes de Haute Provence'),
(1118, 74, '05', 'Hautes-Alpes'),
(1119, 74, '06', 'Alpes Maritimes'),
(1120, 74, '07', 'Ard&egrave;che'),
(1121, 74, '08', 'Ardennes'),
(1122, 74, '09', 'Ari&egrave;ge'),
(1123, 74, '10', 'Aube'),
(1124, 74, '11', 'Aude'),
(1125, 74, '12', 'Aveyron'),
(1126, 74, '13', 'Bouches du Rh&ocirc;ne'),
(1127, 74, '14', 'Calvados'),
(1128, 74, '15', 'Cantal'),
(1129, 74, '16', 'Charente'),
(1130, 74, '17', 'Charente Maritime'),
(1131, 74, '18', 'Cher'),
(1132, 74, '19', 'Corr&egrave;ze'),
(1133, 74, '2A', 'Corse du Sud'),
(1134, 74, '2B', 'Haute Corse'),
(1135, 74, '21', 'C&ocirc;te d&#039;or'),
(1136, 74, '22', 'C&ocirc;tes d&#039;Armor'),
(1137, 74, '23', 'Creuse'),
(1138, 74, '24', 'Dordogne'),
(1139, 74, '25', 'Doubs'),
(1140, 74, '26', 'Dr&ocirc;me'),
(1141, 74, '27', 'Eure'),
(1142, 74, '28', 'Eure et Loir'),
(1143, 74, '29', 'Finist&egrave;re'),
(1144, 74, '30', 'Gard'),
(1145, 74, '31', 'Haute Garonne'),
(1146, 74, '32', 'Gers'),
(1147, 74, '33', 'Gironde'),
(1148, 74, '34', 'H&eacute;rault'),
(1149, 74, '35', 'Ille et Vilaine'),
(1150, 74, '36', 'Indre'),
(1151, 74, '37', 'Indre et Loire'),
(1152, 74, '38', 'Is&eacute;re'),
(1153, 74, '39', 'Jura'),
(1154, 74, '40', 'Landes'),
(1155, 74, '41', 'Loir et Cher'),
(1156, 74, '42', 'Loire'),
(1157, 74, '43', 'Haute Loire'),
(1158, 74, '44', 'Loire Atlantique'),
(1159, 74, '45', 'Loiret'),
(1160, 74, '46', 'Lot'),
(1161, 74, '47', 'Lot et Garonne'),
(1162, 74, '48', 'Loz&egrave;re'),
(1163, 74, '49', 'Maine et Loire'),
(1164, 74, '50', 'Manche'),
(1165, 74, '51', 'Marne'),
(1166, 74, '52', 'Haute Marne'),
(1167, 74, '53', 'Mayenne'),
(1168, 74, '54', 'Meurthe et Moselle'),
(1169, 74, '55', 'Meuse'),
(1170, 74, '56', 'Morbihan'),
(1171, 74, '57', 'Moselle'),
(1172, 74, '58', 'Ni&egrave;vre'),
(1173, 74, '59', 'Nord'),
(1174, 74, '60', 'Oise'),
(1175, 74, '61', 'Orne'),
(1176, 74, '62', 'Pas de Calais'),
(1177, 74, '63', 'Puy de D&ocirc;me'),
(1178, 74, '64', 'Pyr&eacute;n&eacute;es Atlantiques'),
(1179, 74, '65', 'Hautes Pyr&eacute;n&eacute;es'),
(1180, 74, '66', 'Pyr&eacute;n&eacute;es Orientales'),
(1181, 74, '67', 'Bas Rhin'),
(1182, 74, '68', 'Haut Rhin'),
(1183, 74, '69', 'Rh&ocirc;ne'),
(1184, 74, '70', 'Haute Sa&ocirc;ne'),
(1185, 74, '71', 'Sa&ocirc;ne et Loire'),
(1186, 74, '72', 'Sarthe'),
(1187, 74, '73', 'Savoie'),
(1188, 74, '74', 'Haute Savoie'),
(1189, 74, '75', 'Paris'),
(1190, 74, '76', 'Seine Maritime'),
(1191, 74, '77', 'Seine et Marne'),
(1192, 74, '78', 'Yvelines'),
(1193, 74, '79', 'Deux S&egrave;vres'),
(1194, 74, '80', 'Somme'),
(1195, 74, '81', 'Tarn'),
(1196, 74, '82', 'Tarn et Garonne'),
(1197, 74, '83', 'Var'),
(1198, 74, '84', 'Vaucluse'),
(1199, 74, '85', 'Vend&eacute;e'),
(1200, 74, '86', 'Vienne'),
(1201, 74, '87', 'Haute Vienne'),
(1202, 74, '88', 'Vosges'),
(1203, 74, '89', 'Yonne'),
(1204, 74, '90', 'Territoire de Belfort'),
(1205, 74, '91', 'Essonne'),
(1206, 74, '92', 'Hauts de Seine'),
(1207, 74, '93', 'Seine St-Denis'),
(1208, 74, '94', 'Val de Marne'),
(1209, 74, '95', 'Val d\'Oise'),
(1210, 76, 'M', 'Archipel des Marquises'),
(1211, 76, 'T', 'Archipel des Tuamotu'),
(1212, 76, 'I', 'Archipel des Tubuai'),
(1213, 76, 'V', 'Iles du Vent'),
(1214, 76, 'S', 'Iles Sous-le-Vent'),
(1215, 77, 'C', 'Iles Crozet'),
(1216, 77, 'K', 'Iles Kerguelen'),
(1217, 77, 'A', 'Ile Amsterdam'),
(1218, 77, 'P', 'Ile Saint-Paul'),
(1219, 77, 'D', 'Adelie Land'),
(1220, 78, 'ES', 'Estuaire'),
(1221, 78, 'HO', 'Haut-Ogooue'),
(1222, 78, 'MO', 'Moyen-Ogooue'),
(1223, 78, 'NG', 'Ngounie'),
(1224, 78, 'NY', 'Nyanga'),
(1225, 78, 'OI', 'Ogooue-Ivindo'),
(1226, 78, 'OL', 'Ogooue-Lolo'),
(1227, 78, 'OM', 'Ogooue-Maritime'),
(1228, 78, 'WN', 'Woleu-Ntem'),
(1229, 79, 'BJ', 'Banjul'),
(1230, 79, 'BS', 'Basse'),
(1231, 79, 'BR', 'Brikama'),
(1232, 79, 'JA', 'Janjangbure'),
(1233, 79, 'KA', 'Kanifeng'),
(1234, 79, 'KE', 'Kerewan'),
(1235, 79, 'KU', 'Kuntaur'),
(1236, 79, 'MA', 'Mansakonko'),
(1237, 79, 'LR', 'Lower River'),
(1238, 79, 'CR', 'Central River'),
(1239, 79, 'NB', 'North Bank'),
(1240, 79, 'UR', 'Upper River'),
(1241, 79, 'WE', 'Western'),
(1242, 80, 'AB', 'Abkhazia'),
(1243, 80, 'AJ', 'Ajaria'),
(1244, 80, 'TB', 'Tbilisi'),
(1245, 80, 'GU', 'Guria'),
(1246, 80, 'IM', 'Imereti'),
(1247, 80, 'KA', 'Kakheti'),
(1248, 80, 'KK', 'Kvemo Kartli'),
(1249, 80, 'MM', 'Mtskheta-Mtianeti'),
(1250, 80, 'RL', 'Racha Lechkhumi and Kvemo Svanet'),
(1251, 80, 'SZ', 'Samegrelo-Zemo Svaneti'),
(1252, 80, 'SJ', 'Samtskhe-Javakheti'),
(1253, 80, 'SK', 'Shida Kartli'),
(1254, 81, 'BAW', 'Baden-W&uuml;rttemberg'),
(1255, 81, 'BAY', 'Bayern'),
(1256, 81, 'BER', 'Berlin'),
(1257, 81, 'BRG', 'Brandenburg'),
(1258, 81, 'BRE', 'Bremen'),
(1259, 81, 'HAM', 'Hamburg'),
(1260, 81, 'HES', 'Hessen'),
(1261, 81, 'MEC', 'Mecklenburg-Vorpommern'),
(1262, 81, 'NDS', 'Niedersachsen'),
(1263, 81, 'NRW', 'Nordrhein-Westfalen'),
(1264, 81, 'RHE', 'Rheinland-Pfalz'),
(1265, 81, 'SAR', 'Saarland'),
(1266, 81, 'SAS', 'Sachsen'),
(1267, 81, 'SAC', 'Sachsen-Anhalt'),
(1268, 81, 'SCN', 'Schleswig-Holstein'),
(1269, 81, 'THE', 'Th&uuml;ringen'),
(1270, 82, 'AS', 'Ashanti Region'),
(1271, 82, 'BA', 'Brong-Ahafo Region'),
(1272, 82, 'CE', 'Central Region'),
(1273, 82, 'EA', 'Eastern Region'),
(1274, 82, 'GA', 'Greater Accra Region'),
(1275, 82, 'NO', 'Northern Region'),
(1276, 82, 'UE', 'Upper East Region'),
(1277, 82, 'UW', 'Upper West Region'),
(1278, 82, 'VO', 'Volta Region'),
(1279, 82, 'WE', 'Western Region'),
(1280, 84, 'AT', 'Attica'),
(1281, 84, 'CN', 'Central Greece'),
(1282, 84, 'CM', 'Central Macedonia'),
(1283, 84, 'CR', 'Crete'),
(1284, 84, 'EM', 'East Macedonia and Thrace'),
(1285, 84, 'EP', 'Epirus'),
(1286, 84, 'II', 'Ionian Islands'),
(1287, 84, 'NA', 'North Aegean'),
(1288, 84, 'PP', 'Peloponnesos'),
(1289, 84, 'SA', 'South Aegean'),
(1290, 84, 'TH', 'Thessaly'),
(1291, 84, 'WG', 'West Greece'),
(1292, 84, 'WM', 'West Macedonia'),
(1293, 85, 'A', 'Avannaa'),
(1294, 85, 'T', 'Tunu'),
(1295, 85, 'K', 'Kitaa'),
(1296, 86, 'A', 'Saint Andrew'),
(1297, 86, 'D', 'Saint David'),
(1298, 86, 'G', 'Saint George'),
(1299, 86, 'J', 'Saint John'),
(1300, 86, 'M', 'Saint Mark'),
(1301, 86, 'P', 'Saint Patrick'),
(1302, 86, 'C', 'Carriacou'),
(1303, 86, 'Q', 'Petit Martinique'),
(1304, 89, 'AV', 'Alta Verapaz'),
(1305, 89, 'BV', 'Baja Verapaz'),
(1306, 89, 'CM', 'Chimaltenango'),
(1307, 89, 'CQ', 'Chiquimula'),
(1308, 89, 'PE', 'El Peten'),
(1309, 89, 'PR', 'El Progreso'),
(1310, 89, 'QC', 'El Quiche'),
(1311, 89, 'ES', 'Escuintla'),
(1312, 89, 'GU', 'Guatemala'),
(1313, 89, 'HU', 'Huehuetenango'),
(1314, 89, 'IZ', 'Izabal'),
(1315, 89, 'JA', 'Jalapa'),
(1316, 89, 'JU', 'Jutiapa'),
(1317, 89, 'QZ', 'Quetzaltenango'),
(1318, 89, 'RE', 'Retalhuleu'),
(1319, 89, 'ST', 'Sacatepequez'),
(1320, 89, 'SM', 'San Marcos'),
(1321, 89, 'SR', 'Santa Rosa'),
(1322, 89, 'SO', 'Solola'),
(1323, 89, 'SU', 'Suchitepequez'),
(1324, 89, 'TO', 'Totonicapan'),
(1325, 89, 'ZA', 'Zacapa'),
(1326, 90, 'CNK', 'Conakry'),
(1327, 90, 'BYL', 'Beyla'),
(1328, 90, 'BFA', 'Boffa'),
(1329, 90, 'BOK', 'Boke'),
(1330, 90, 'COY', 'Coyah'),
(1331, 90, 'DBL', 'Dabola'),
(1332, 90, 'DLB', 'Dalaba'),
(1333, 90, 'DGR', 'Dinguiraye'),
(1334, 90, 'DBR', 'Dubreka'),
(1335, 90, 'FRN', 'Faranah'),
(1336, 90, 'FRC', 'Forecariah'),
(1337, 90, 'FRI', 'Fria'),
(1338, 90, 'GAO', 'Gaoual'),
(1339, 90, 'GCD', 'Gueckedou'),
(1340, 90, 'KNK', 'Kankan'),
(1341, 90, 'KRN', 'Kerouane'),
(1342, 90, 'KND', 'Kindia'),
(1343, 90, 'KSD', 'Kissidougou'),
(1344, 90, 'KBA', 'Koubia'),
(1345, 90, 'KDA', 'Koundara'),
(1346, 90, 'KRA', 'Kouroussa'),
(1347, 90, 'LAB', 'Labe'),
(1348, 90, 'LLM', 'Lelouma'),
(1349, 90, 'LOL', 'Lola'),
(1350, 90, 'MCT', 'Macenta'),
(1351, 90, 'MAL', 'Mali'),
(1352, 90, 'MAM', 'Mamou'),
(1353, 90, 'MAN', 'Mandiana'),
(1354, 90, 'NZR', 'Nzerekore'),
(1355, 90, 'PIT', 'Pita'),
(1356, 90, 'SIG', 'Siguiri'),
(1357, 90, 'TLM', 'Telimele'),
(1358, 90, 'TOG', 'Tougue'),
(1359, 90, 'YOM', 'Yomou'),
(1360, 91, 'BF', 'Bafata Region'),
(1361, 91, 'BB', 'Biombo Region'),
(1362, 91, 'BS', 'Bissau Region'),
(1363, 91, 'BL', 'Bolama Region'),
(1364, 91, 'CA', 'Cacheu Region'),
(1365, 91, 'GA', 'Gabu Region'),
(1366, 91, 'OI', 'Oio Region'),
(1367, 91, 'QU', 'Quinara Region'),
(1368, 91, 'TO', 'Tombali Region'),
(1369, 92, 'BW', 'Barima-Waini'),
(1370, 92, 'CM', 'Cuyuni-Mazaruni'),
(1371, 92, 'DM', 'Demerara-Mahaica'),
(1372, 92, 'EC', 'East Berbice-Corentyne'),
(1373, 92, 'EW', 'Essequibo Islands-West Demerara'),
(1374, 92, 'MB', 'Mahaica-Berbice'),
(1375, 92, 'PM', 'Pomeroon-Supenaam'),
(1376, 92, 'PI', 'Potaro-Siparuni'),
(1377, 92, 'UD', 'Upper Demerara-Berbice'),
(1378, 92, 'UT', 'Upper Takutu-Upper Essequibo'),
(1379, 93, 'AR', 'Artibonite'),
(1380, 93, 'CE', 'Centre'),
(1381, 93, 'GA', 'Grand\'Anse'),
(1382, 93, 'ND', 'Nord'),
(1383, 93, 'NE', 'Nord-Est'),
(1384, 93, 'NO', 'Nord-Ouest'),
(1385, 93, 'OU', 'Ouest'),
(1386, 93, 'SD', 'Sud'),
(1387, 93, 'SE', 'Sud-Est'),
(1388, 94, 'F', 'Flat Island'),
(1389, 94, 'M', 'McDonald Island'),
(1390, 94, 'S', 'Shag Island'),
(1391, 94, 'H', 'Heard Island'),
(1392, 95, 'AT', 'Atlantida'),
(1393, 95, 'CH', 'Choluteca'),
(1394, 95, 'CL', 'Colon'),
(1395, 95, 'CM', 'Comayagua'),
(1396, 95, 'CP', 'Copan'),
(1397, 95, 'CR', 'Cortes'),
(1398, 95, 'PA', 'El Paraiso'),
(1399, 95, 'FM', 'Francisco Morazan'),
(1400, 95, 'GD', 'Gracias a Dios'),
(1401, 95, 'IN', 'Intibuca'),
(1402, 95, 'IB', 'Islas de la Bahia (Bay Islands)'),
(1403, 95, 'PZ', 'La Paz'),
(1404, 95, 'LE', 'Lempira'),
(1405, 95, 'OC', 'Ocotepeque'),
(1406, 95, 'OL', 'Olancho'),
(1407, 95, 'SB', 'Santa Barbara'),
(1408, 95, 'VA', 'Valle'),
(1409, 95, 'YO', 'Yoro'),
(1410, 96, 'HCW', 'Central and Western Hong Kong Island'),
(1411, 96, 'HEA', 'Eastern Hong Kong Island'),
(1412, 96, 'HSO', 'Southern Hong Kong Island'),
(1413, 96, 'HWC', 'Wan Chai Hong Kong Island'),
(1414, 96, 'KKC', 'Kowloon City Kowloon'),
(1415, 96, 'KKT', 'Kwun Tong Kowloon'),
(1416, 96, 'KSS', 'Sham Shui Po Kowloon'),
(1417, 96, 'KWT', 'Wong Tai Sin Kowloon'),
(1418, 96, 'KYT', 'Yau Tsim Mong Kowloon'),
(1419, 96, 'NIS', 'Islands New Territories'),
(1420, 96, 'NKT', 'Kwai Tsing New Territories'),
(1421, 96, 'NNO', 'North New Territories'),
(1422, 96, 'NSK', 'Sai Kung New Territories'),
(1423, 96, 'NST', 'Sha Tin New Territories'),
(1424, 96, 'NTP', 'Tai Po New Territories'),
(1425, 96, 'NTW', 'Tsuen Wan New Territories'),
(1426, 96, 'NTM', 'Tuen Mun New Territories'),
(1427, 96, 'NYL', 'Yuen Long New Territories'),
(1428, 97, 'BK', 'Bacs-Kiskun'),
(1429, 97, 'BA', 'Baranya'),
(1430, 97, 'BE', 'Bekes'),
(1431, 97, 'BS', 'Bekescsaba'),
(1432, 97, 'BZ', 'Borsod-Abauj-Zemplen'),
(1433, 97, 'BU', 'Budapest'),
(1434, 97, 'CS', 'Csongrad'),
(1435, 97, 'DE', 'Debrecen'),
(1436, 97, 'DU', 'Dunaujvaros'),
(1437, 97, 'EG', 'Eger'),
(1438, 97, 'FE', 'Fejer'),
(1439, 97, 'GY', 'Gyor'),
(1440, 97, 'GM', 'Gyor-Moson-Sopron'),
(1441, 97, 'HB', 'Hajdu-Bihar'),
(1442, 97, 'HE', 'Heves'),
(1443, 97, 'HO', 'Hodmezovasarhely'),
(1444, 97, 'JN', 'Jasz-Nagykun-Szolnok'),
(1445, 97, 'KA', 'Kaposvar'),
(1446, 97, 'KE', 'Kecskemet'),
(1447, 97, 'KO', 'Komarom-Esztergom'),
(1448, 97, 'MI', 'Miskolc'),
(1449, 97, 'NA', 'Nagykanizsa'),
(1450, 97, 'NO', 'Nograd'),
(1451, 97, 'NY', 'Nyiregyhaza'),
(1452, 97, 'PE', 'Pecs'),
(1453, 97, 'PS', 'Pest'),
(1454, 97, 'SO', 'Somogy'),
(1455, 97, 'SP', 'Sopron'),
(1456, 97, 'SS', 'Szabolcs-Szatmar-Bereg'),
(1457, 97, 'SZ', 'Szeged'),
(1458, 97, 'SE', 'Szekesfehervar'),
(1459, 97, 'SL', 'Szolnok'),
(1460, 97, 'SM', 'Szombathely'),
(1461, 97, 'TA', 'Tatabanya'),
(1462, 97, 'TO', 'Tolna'),
(1463, 97, 'VA', 'Vas'),
(1464, 97, 'VE', 'Veszprem'),
(1465, 97, 'ZA', 'Zala'),
(1466, 97, 'ZZ', 'Zalaegerszeg'),
(1467, 98, 'AL', 'Austurland'),
(1468, 98, 'HF', 'Hofuoborgarsvaeoi'),
(1469, 98, 'NE', 'Norourland eystra'),
(1470, 98, 'NV', 'Norourland vestra'),
(1471, 98, 'SL', 'Suourland'),
(1472, 98, 'SN', 'Suournes'),
(1473, 98, 'VF', 'Vestfiroir'),
(1474, 98, 'VL', 'Vesturland'),
(1475, 99, 'AN', 'Andaman and Nicobar Islands'),
(1476, 99, 'AP', 'Andhra Pradesh'),
(1477, 99, 'AR', 'Arunachal Pradesh'),
(1478, 99, 'AS', 'Assam'),
(1479, 99, 'BI', 'Bihar'),
(1480, 99, 'CH', 'Chandigarh'),
(1481, 99, 'DA', 'Dadra and Nagar Haveli'),
(1482, 99, 'DM', 'Daman and Diu'),
(1483, 99, 'DE', 'Delhi'),
(1484, 99, 'GO', 'Goa'),
(1485, 99, 'GU', 'Gujarat'),
(1486, 99, 'HA', 'Haryana'),
(1487, 99, 'HP', 'Himachal Pradesh'),
(1488, 99, 'JA', 'Jammu and Kashmir'),
(1489, 99, 'KA', 'Karnataka'),
(1490, 99, 'KE', 'Kerala'),
(1491, 99, 'LI', 'Lakshadweep Islands'),
(1492, 99, 'MP', 'Madhya Pradesh'),
(1493, 99, 'MA', 'Maharashtra'),
(1494, 99, 'MN', 'Manipur'),
(1495, 99, 'ME', 'Meghalaya'),
(1496, 99, 'MI', 'Mizoram'),
(1497, 99, 'NA', 'Nagaland'),
(1498, 99, 'OR', 'Orissa'),
(1499, 99, 'PO', 'Pondicherry'),
(1500, 99, 'PU', 'Punjab'),
(1501, 99, 'RA', 'Rajasthan'),
(1502, 99, 'SI', 'Sikkim'),
(1503, 99, 'TN', 'Tamil Nadu'),
(1504, 99, 'TR', 'Tripura'),
(1505, 99, 'UP', 'Uttar Pradesh'),
(1506, 99, 'WB', 'West Bengal'),
(1507, 100, 'AC', 'Aceh'),
(1508, 100, 'BA', 'Bali'),
(1509, 100, 'BT', 'Banten'),
(1510, 100, 'BE', 'Bengkulu'),
(1511, 100, 'BD', 'BoDeTaBek'),
(1512, 100, 'GO', 'Gorontalo'),
(1513, 100, 'JK', 'Jakarta Raya'),
(1514, 100, 'JA', 'Jambi'),
(1515, 100, 'JB', 'Jawa Barat'),
(1516, 100, 'JT', 'Jawa Tengah'),
(1517, 100, 'JI', 'Jawa Timur'),
(1518, 100, 'KB', 'Kalimantan Barat'),
(1519, 100, 'KS', 'Kalimantan Selatan'),
(1520, 100, 'KT', 'Kalimantan Tengah'),
(1521, 100, 'KI', 'Kalimantan Timur'),
(1522, 100, 'BB', 'Kepulauan Bangka Belitung'),
(1523, 100, 'LA', 'Lampung'),
(1524, 100, 'MA', 'Maluku'),
(1525, 100, 'MU', 'Maluku Utara'),
(1526, 100, 'NB', 'Nusa Tenggara Barat'),
(1527, 100, 'NT', 'Nusa Tenggara Timur'),
(1528, 100, 'PA', 'Papua'),
(1529, 100, 'RI', 'Riau'),
(1530, 100, 'SN', 'Sulawesi Selatan'),
(1531, 100, 'ST', 'Sulawesi Tengah'),
(1532, 100, 'SG', 'Sulawesi Tenggara'),
(1533, 100, 'SA', 'Sulawesi Utara'),
(1534, 100, 'SB', 'Sumatera Barat'),
(1535, 100, 'SS', 'Sumatera Selatan'),
(1536, 100, 'SU', 'Sumatera Utara'),
(1537, 100, 'YO', 'Yogyakarta'),
(1538, 101, 'TEH', 'Tehran'),
(1539, 101, 'QOM', 'Qom'),
(1540, 101, 'MKZ', 'Markazi'),
(1541, 101, 'QAZ', 'Qazvin'),
(1542, 101, 'GIL', 'Gilan'),
(1543, 101, 'ARD', 'Ardabil'),
(1544, 101, 'ZAN', 'Zanjan'),
(1545, 101, 'EAZ', 'East Azarbaijan'),
(1546, 101, 'WEZ', 'West Azarbaijan'),
(1547, 101, 'KRD', 'Kurdistan'),
(1548, 101, 'HMD', 'Hamadan'),
(1549, 101, 'KRM', 'Kermanshah'),
(1550, 101, 'ILM', 'Ilam'),
(1551, 101, 'LRS', 'Lorestan'),
(1552, 101, 'KZT', 'Khuzestan'),
(1553, 101, 'CMB', 'Chahar Mahaal and Bakhtiari'),
(1554, 101, 'KBA', 'Kohkiluyeh and Buyer Ahmad'),
(1555, 101, 'BSH', 'Bushehr'),
(1556, 101, 'FAR', 'Fars'),
(1557, 101, 'HRM', 'Hormozgan'),
(1558, 101, 'SBL', 'Sistan and Baluchistan'),
(1559, 101, 'KRB', 'Kerman'),
(1560, 101, 'YZD', 'Yazd'),
(1561, 101, 'EFH', 'Esfahan'),
(1562, 101, 'SMN', 'Semnan'),
(1563, 101, 'MZD', 'Mazandaran'),
(1564, 101, 'GLS', 'Golestan'),
(1565, 101, 'NKH', 'North Khorasan'),
(1566, 101, 'RKH', 'Razavi Khorasan'),
(1567, 101, 'SKH', 'South Khorasan'),
(1568, 102, 'BD', 'Baghdad'),
(1569, 102, 'SD', 'Salah ad Din'),
(1570, 102, 'DY', 'Diyala'),
(1571, 102, 'WS', 'Wasit'),
(1572, 102, 'MY', 'Maysan'),
(1573, 102, 'BA', 'Al Basrah'),
(1574, 102, 'DQ', 'Dhi Qar'),
(1575, 102, 'MU', 'Al Muthanna'),
(1576, 102, 'QA', 'Al Qadisyah'),
(1577, 102, 'BB', 'Babil'),
(1578, 102, 'KB', 'Al Karbala'),
(1579, 102, 'NJ', 'An Najaf'),
(1580, 102, 'AB', 'Al Anbar'),
(1581, 102, 'NN', 'Ninawa'),
(1582, 102, 'DH', 'Dahuk'),
(1583, 102, 'AL', 'Arbil'),
(1584, 102, 'TM', 'At Ta\'mim'),
(1585, 102, 'SL', 'As Sulaymaniyah'),
(1586, 103, 'CA', 'Carlow'),
(1587, 103, 'CV', 'Cavan'),
(1588, 103, 'CL', 'Clare'),
(1589, 103, 'CO', 'Cork'),
(1590, 103, 'DO', 'Donegal'),
(1591, 103, 'DU', 'Dublin'),
(1592, 103, 'GA', 'Galway'),
(1593, 103, 'KE', 'Kerry'),
(1594, 103, 'KI', 'Kildare'),
(1595, 103, 'KL', 'Kilkenny'),
(1596, 103, 'LA', 'Laois'),
(1597, 103, 'LE', 'Leitrim'),
(1598, 103, 'LI', 'Limerick'),
(1599, 103, 'LO', 'Longford'),
(1600, 103, 'LU', 'Louth'),
(1601, 103, 'MA', 'Mayo'),
(1602, 103, 'ME', 'Meath'),
(1603, 103, 'MO', 'Monaghan'),
(1604, 103, 'OF', 'Offaly'),
(1605, 103, 'RO', 'Roscommon'),
(1606, 103, 'SL', 'Sligo'),
(1607, 103, 'TI', 'Tipperary'),
(1608, 103, 'WA', 'Waterford'),
(1609, 103, 'WE', 'Westmeath'),
(1610, 103, 'WX', 'Wexford'),
(1611, 103, 'WI', 'Wicklow'),
(1612, 104, 'BS', 'Be\'er Sheva'),
(1613, 104, 'BH', 'Bika\'at Hayarden'),
(1614, 104, 'EA', 'Eilat and Arava'),
(1615, 104, 'GA', 'Galil'),
(1616, 104, 'HA', 'Haifa'),
(1617, 104, 'JM', 'Jehuda Mountains'),
(1618, 104, 'JE', 'Jerusalem'),
(1619, 104, 'NE', 'Negev'),
(1620, 104, 'SE', 'Semaria'),
(1621, 104, 'SH', 'Sharon'),
(1622, 104, 'TA', 'Tel Aviv (Gosh Dan)'),
(1643, 106, 'CLA', 'Clarendon Parish'),
(1644, 106, 'HAN', 'Hanover Parish'),
(1645, 106, 'KIN', 'Kingston Parish'),
(1646, 106, 'MAN', 'Manchester Parish'),
(1647, 106, 'POR', 'Portland Parish'),
(1648, 106, 'AND', 'Saint Andrew Parish'),
(1649, 106, 'ANN', 'Saint Ann Parish'),
(1650, 106, 'CAT', 'Saint Catherine Parish'),
(1651, 106, 'ELI', 'Saint Elizabeth Parish'),
(1652, 106, 'JAM', 'Saint James Parish'),
(1653, 106, 'MAR', 'Saint Mary Parish'),
(1654, 106, 'THO', 'Saint Thomas Parish'),
(1655, 106, 'TRL', 'Trelawny Parish'),
(1656, 106, 'WML', 'Westmoreland Parish'),
(1657, 107, 'AI', 'Aichi'),
(1658, 107, 'AK', 'Akita'),
(1659, 107, 'AO', 'Aomori'),
(1660, 107, 'CH', 'Chiba'),
(1661, 107, 'EH', 'Ehime'),
(1662, 107, 'FK', 'Fukui'),
(1663, 107, 'FU', 'Fukuoka'),
(1664, 107, 'FS', 'Fukushima'),
(1665, 107, 'GI', 'Gifu'),
(1666, 107, 'GU', 'Gumma'),
(1667, 107, 'HI', 'Hiroshima'),
(1668, 107, 'HO', 'Hokkaido'),
(1669, 107, 'HY', 'Hyogo'),
(1670, 107, 'IB', 'Ibaraki'),
(1671, 107, 'IS', 'Ishikawa'),
(1672, 107, 'IW', 'Iwate'),
(1673, 107, 'KA', 'Kagawa'),
(1674, 107, 'KG', 'Kagoshima'),
(1675, 107, 'KN', 'Kanagawa'),
(1676, 107, 'KO', 'Kochi'),
(1677, 107, 'KU', 'Kumamoto'),
(1678, 107, 'KY', 'Kyoto'),
(1679, 107, 'MI', 'Mie'),
(1680, 107, 'MY', 'Miyagi'),
(1681, 107, 'MZ', 'Miyazaki'),
(1682, 107, 'NA', 'Nagano'),
(1683, 107, 'NG', 'Nagasaki'),
(1684, 107, 'NR', 'Nara'),
(1685, 107, 'NI', 'Niigata'),
(1686, 107, 'OI', 'Oita'),
(1687, 107, 'OK', 'Okayama'),
(1688, 107, 'ON', 'Okinawa'),
(1689, 107, 'OS', 'Osaka'),
(1690, 107, 'SA', 'Saga'),
(1691, 107, 'SI', 'Saitama'),
(1692, 107, 'SH', 'Shiga'),
(1693, 107, 'SM', 'Shimane'),
(1694, 107, 'SZ', 'Shizuoka'),
(1695, 107, 'TO', 'Tochigi'),
(1696, 107, 'TS', 'Tokushima'),
(1697, 107, 'TK', 'Tokyo'),
(1698, 107, 'TT', 'Tottori'),
(1699, 107, 'TY', 'Toyama'),
(1700, 107, 'WA', 'Wakayama'),
(1701, 107, 'YA', 'Yamagata'),
(1702, 107, 'YM', 'Yamaguchi'),
(1703, 107, 'YN', 'Yamanashi'),
(1704, 108, 'AM', '\'Amman'),
(1705, 108, 'AJ', 'Ajlun'),
(1706, 108, 'AA', 'Al \'Aqabah'),
(1707, 108, 'AB', 'Al Balqa\''),
(1708, 108, 'AK', 'Al Karak'),
(1709, 108, 'AL', 'Al Mafraq'),
(1710, 108, 'AT', 'At Tafilah');
INSERT INTO `fa_kv_states` (`state_id`, `country_id`, `state_code`, `state_name`) VALUES
(1711, 108, 'AZ', 'Az Zarqa\''),
(1712, 108, 'IR', 'Irbid'),
(1713, 108, 'JA', 'Jarash'),
(1714, 108, 'MA', 'Ma\'an'),
(1715, 108, 'MD', 'Madaba'),
(1716, 109, 'AL', 'Almaty'),
(1717, 109, 'AC', 'Almaty City'),
(1718, 109, 'AM', 'Aqmola'),
(1719, 109, 'AQ', 'Aqtobe'),
(1720, 109, 'AS', 'Astana City'),
(1721, 109, 'AT', 'Atyrau'),
(1722, 109, 'BA', 'Batys Qazaqstan'),
(1723, 109, 'BY', 'Bayqongyr City'),
(1724, 109, 'MA', 'Mangghystau'),
(1725, 109, 'ON', 'Ongtustik Qazaqstan'),
(1726, 109, 'PA', 'Pavlodar'),
(1727, 109, 'QA', 'Qaraghandy'),
(1728, 109, 'QO', 'Qostanay'),
(1729, 109, 'QY', 'Qyzylorda'),
(1730, 109, 'SH', 'Shyghys Qazaqstan'),
(1731, 109, 'SO', 'Soltustik Qazaqstan'),
(1732, 109, 'ZH', 'Zhambyl'),
(1733, 110, 'CE', 'Central'),
(1734, 110, 'CO', 'Coast'),
(1735, 110, 'EA', 'Eastern'),
(1736, 110, 'NA', 'Nairobi Area'),
(1737, 110, 'NE', 'North Eastern'),
(1738, 110, 'NY', 'Nyanza'),
(1739, 110, 'RV', 'Rift Valley'),
(1740, 110, 'WE', 'Western'),
(1741, 111, 'AG', 'Abaiang'),
(1742, 111, 'AM', 'Abemama'),
(1743, 111, 'AK', 'Aranuka'),
(1744, 111, 'AO', 'Arorae'),
(1745, 111, 'BA', 'Banaba'),
(1746, 111, 'BE', 'Beru'),
(1747, 111, 'bT', 'Butaritari'),
(1748, 111, 'KA', 'Kanton'),
(1749, 111, 'KR', 'Kiritimati'),
(1750, 111, 'KU', 'Kuria'),
(1751, 111, 'MI', 'Maiana'),
(1752, 111, 'MN', 'Makin'),
(1753, 111, 'ME', 'Marakei'),
(1754, 111, 'NI', 'Nikunau'),
(1755, 111, 'NO', 'Nonouti'),
(1756, 111, 'ON', 'Onotoa'),
(1757, 111, 'TT', 'Tabiteuea'),
(1758, 111, 'TR', 'Tabuaeran'),
(1759, 111, 'TM', 'Tamana'),
(1760, 111, 'TW', 'Tarawa'),
(1761, 111, 'TE', 'Teraina'),
(1762, 112, 'CHA', 'Chagang-do'),
(1763, 112, 'HAB', 'Hamgyong-bukto'),
(1764, 112, 'HAN', 'Hamgyong-namdo'),
(1765, 112, 'HWB', 'Hwanghae-bukto'),
(1766, 112, 'HWN', 'Hwanghae-namdo'),
(1767, 112, 'KAN', 'Kangwon-do'),
(1768, 112, 'PYB', 'P\'yongan-bukto'),
(1769, 112, 'PYN', 'P\'yongan-namdo'),
(1770, 112, 'YAN', 'Ryanggang-do (Yanggang-do)'),
(1771, 112, 'NAJ', 'Rason Directly Governed City'),
(1772, 112, 'PYO', 'P\'yongyang Special City'),
(1773, 113, 'CO', 'Ch\'ungch\'ong-bukto'),
(1774, 113, 'CH', 'Ch\'ungch\'ong-namdo'),
(1775, 113, 'CD', 'Cheju-do'),
(1776, 113, 'CB', 'Cholla-bukto'),
(1777, 113, 'CN', 'Cholla-namdo'),
(1778, 113, 'IG', 'Inch\'on-gwangyoksi'),
(1779, 113, 'KA', 'Kangwon-do'),
(1780, 113, 'KG', 'Kwangju-gwangyoksi'),
(1781, 113, 'KD', 'Kyonggi-do'),
(1782, 113, 'KB', 'Kyongsang-bukto'),
(1783, 113, 'KN', 'Kyongsang-namdo'),
(1784, 113, 'PG', 'Pusan-gwangyoksi'),
(1785, 113, 'SO', 'Soul-t\'ukpyolsi'),
(1786, 113, 'TA', 'Taegu-gwangyoksi'),
(1787, 113, 'TG', 'Taejon-gwangyoksi'),
(1788, 114, 'AL', 'Al \'Asimah'),
(1789, 114, 'AA', 'Al Ahmadi'),
(1790, 114, 'AF', 'Al Farwaniyah'),
(1791, 114, 'AJ', 'Al Jahra\''),
(1792, 114, 'HA', 'Hawalli'),
(1793, 115, 'GB', 'Bishkek'),
(1794, 115, 'B', 'Batken'),
(1795, 115, 'C', 'Chu'),
(1796, 115, 'J', 'Jalal-Abad'),
(1797, 115, 'N', 'Naryn'),
(1798, 115, 'O', 'Osh'),
(1799, 115, 'T', 'Talas'),
(1800, 115, 'Y', 'Ysyk-Kol'),
(1801, 116, 'VT', 'Vientiane'),
(1802, 116, 'AT', 'Attapu'),
(1803, 116, 'BK', 'Bokeo'),
(1804, 116, 'BL', 'Bolikhamxai'),
(1805, 116, 'CH', 'Champasak'),
(1806, 116, 'HO', 'Houaphan'),
(1807, 116, 'KH', 'Khammouan'),
(1808, 116, 'LM', 'Louang Namtha'),
(1809, 116, 'LP', 'Louangphabang'),
(1810, 116, 'OU', 'Oudomxai'),
(1811, 116, 'PH', 'Phongsali'),
(1812, 116, 'SL', 'Salavan'),
(1813, 116, 'SV', 'Savannakhet'),
(1814, 116, 'VI', 'Vientiane'),
(1815, 116, 'XA', 'Xaignabouli'),
(1816, 116, 'XE', 'Xekong'),
(1817, 116, 'XI', 'Xiangkhoang'),
(1818, 116, 'XN', 'Xaisomboun'),
(1819, 117, 'AIZ', 'Aizkraukles Rajons'),
(1820, 117, 'ALU', 'Aluksnes Rajons'),
(1821, 117, 'BAL', 'Balvu Rajons'),
(1822, 117, 'BAU', 'Bauskas Rajons'),
(1823, 117, 'CES', 'Cesu Rajons'),
(1824, 117, 'DGR', 'Daugavpils Rajons'),
(1825, 117, 'DOB', 'Dobeles Rajons'),
(1826, 117, 'GUL', 'Gulbenes Rajons'),
(1827, 117, 'JEK', 'Jekabpils Rajons'),
(1828, 117, 'JGR', 'Jelgavas Rajons'),
(1829, 117, 'KRA', 'Kraslavas Rajons'),
(1830, 117, 'KUL', 'Kuldigas Rajons'),
(1831, 117, 'LPR', 'Liepajas Rajons'),
(1832, 117, 'LIM', 'Limbazu Rajons'),
(1833, 117, 'LUD', 'Ludzas Rajons'),
(1834, 117, 'MAD', 'Madonas Rajons'),
(1835, 117, 'OGR', 'Ogres Rajons'),
(1836, 117, 'PRE', 'Preilu Rajons'),
(1837, 117, 'RZR', 'Rezeknes Rajons'),
(1838, 117, 'RGR', 'Rigas Rajons'),
(1839, 117, 'SAL', 'Saldus Rajons'),
(1840, 117, 'TAL', 'Talsu Rajons'),
(1841, 117, 'TUK', 'Tukuma Rajons'),
(1842, 117, 'VLK', 'Valkas Rajons'),
(1843, 117, 'VLM', 'Valmieras Rajons'),
(1844, 117, 'VSR', 'Ventspils Rajons'),
(1845, 117, 'DGV', 'Daugavpils'),
(1846, 117, 'JGV', 'Jelgava'),
(1847, 117, 'JUR', 'Jurmala'),
(1848, 117, 'LPK', 'Liepaja'),
(1849, 117, 'RZK', 'Rezekne'),
(1850, 117, 'RGA', 'Riga'),
(1851, 117, 'VSL', 'Ventspils'),
(1852, 119, 'BE', 'Berea'),
(1853, 119, 'BB', 'Butha-Buthe'),
(1854, 119, 'LE', 'Leribe'),
(1855, 119, 'MF', 'Mafeteng'),
(1856, 119, 'MS', 'Maseru'),
(1857, 119, 'MH', 'Mohale\'s Hoek'),
(1858, 119, 'MK', 'Mokhotlong'),
(1859, 119, 'QN', 'Qacha\'s Nek'),
(1860, 119, 'QT', 'Quthing'),
(1861, 119, 'TT', 'Thaba-Tseka'),
(1862, 120, 'BI', 'Bomi'),
(1863, 120, 'BG', 'Bong'),
(1864, 120, 'GB', 'Grand Bassa'),
(1865, 120, 'CM', 'Grand Cape Mount'),
(1866, 120, 'GG', 'Grand Gedeh'),
(1867, 120, 'GK', 'Grand Kru'),
(1868, 120, 'LO', 'Lofa'),
(1869, 120, 'MG', 'Margibi'),
(1870, 120, 'ML', 'Maryland'),
(1871, 120, 'MS', 'Montserrado'),
(1872, 120, 'NB', 'Nimba'),
(1873, 120, 'RC', 'River Cess'),
(1874, 120, 'SN', 'Sinoe'),
(1875, 121, 'AJ', 'Ajdabiya'),
(1876, 121, 'AZ', 'Al \'Aziziyah'),
(1877, 121, 'FA', 'Al Fatih'),
(1878, 121, 'JA', 'Al Jabal al Akhdar'),
(1879, 121, 'JU', 'Al Jufrah'),
(1880, 121, 'KH', 'Al Khums'),
(1881, 121, 'KU', 'Al Kufrah'),
(1882, 121, 'NK', 'An Nuqat al Khams'),
(1883, 121, 'AS', 'Ash Shati\''),
(1884, 121, 'AW', 'Awbari'),
(1885, 121, 'ZA', 'Az Zawiyah'),
(1886, 121, 'BA', 'Banghazi'),
(1887, 121, 'DA', 'Darnah'),
(1888, 121, 'GD', 'Ghadamis'),
(1889, 121, 'GY', 'Gharyan'),
(1890, 121, 'MI', 'Misratah'),
(1891, 121, 'MZ', 'Murzuq'),
(1892, 121, 'SB', 'Sabha'),
(1893, 121, 'SW', 'Sawfajjin'),
(1894, 121, 'SU', 'Surt'),
(1895, 121, 'TL', 'Tarabulus (Tripoli)'),
(1896, 121, 'TH', 'Tarhunah'),
(1897, 121, 'TU', 'Tubruq'),
(1898, 121, 'YA', 'Yafran'),
(1899, 121, 'ZL', 'Zlitan'),
(1900, 122, 'V', 'Vaduz'),
(1901, 122, 'A', 'Schaan'),
(1902, 122, 'B', 'Balzers'),
(1903, 122, 'N', 'Triesen'),
(1904, 122, 'E', 'Eschen'),
(1905, 122, 'M', 'Mauren'),
(1906, 122, 'T', 'Triesenberg'),
(1907, 122, 'R', 'Ruggell'),
(1908, 122, 'G', 'Gamprin'),
(1909, 122, 'L', 'Schellenberg'),
(1910, 122, 'P', 'Planken'),
(1911, 123, 'AL', 'Alytus'),
(1912, 123, 'KA', 'Kaunas'),
(1913, 123, 'KL', 'Klaipeda'),
(1914, 123, 'MA', 'Marijampole'),
(1915, 123, 'PA', 'Panevezys'),
(1916, 123, 'SI', 'Siauliai'),
(1917, 123, 'TA', 'Taurage'),
(1918, 123, 'TE', 'Telsiai'),
(1919, 123, 'UT', 'Utena'),
(1920, 123, 'VI', 'Vilnius'),
(1921, 124, 'DD', 'Diekirch'),
(1922, 124, 'DC', 'Clervaux'),
(1923, 124, 'DR', 'Redange'),
(1924, 124, 'DV', 'Vianden'),
(1925, 124, 'DW', 'Wiltz'),
(1926, 124, 'GG', 'Grevenmacher'),
(1927, 124, 'GE', 'Echternach'),
(1928, 124, 'GR', 'Remich'),
(1929, 124, 'LL', 'Luxembourg'),
(1930, 124, 'LC', 'Capellen'),
(1931, 124, 'LE', 'Esch-sur-Alzette'),
(1932, 124, 'LM', 'Mersch'),
(1933, 125, 'OLF', 'Our Lady Fatima Parish'),
(1934, 125, 'ANT', 'St. Anthony Parish'),
(1935, 125, 'LAZ', 'St. Lazarus Parish'),
(1936, 125, 'CAT', 'Cathedral Parish'),
(1937, 125, 'LAW', 'St. Lawrence Parish'),
(1938, 127, 'AN', 'Antananarivo'),
(1939, 127, 'AS', 'Antsiranana'),
(1940, 127, 'FN', 'Fianarantsoa'),
(1941, 127, 'MJ', 'Mahajanga'),
(1942, 127, 'TM', 'Toamasina'),
(1943, 127, 'TL', 'Toliara'),
(1944, 128, 'BLK', 'Balaka'),
(1945, 128, 'BLT', 'Blantyre'),
(1946, 128, 'CKW', 'Chikwawa'),
(1947, 128, 'CRD', 'Chiradzulu'),
(1948, 128, 'CTP', 'Chitipa'),
(1949, 128, 'DDZ', 'Dedza'),
(1950, 128, 'DWA', 'Dowa'),
(1951, 128, 'KRG', 'Karonga'),
(1952, 128, 'KSG', 'Kasungu'),
(1953, 128, 'LKM', 'Likoma'),
(1954, 128, 'LLG', 'Lilongwe'),
(1955, 128, 'MCG', 'Machinga'),
(1956, 128, 'MGC', 'Mangochi'),
(1957, 128, 'MCH', 'Mchinji'),
(1958, 128, 'MLJ', 'Mulanje'),
(1959, 128, 'MWZ', 'Mwanza'),
(1960, 128, 'MZM', 'Mzimba'),
(1961, 128, 'NTU', 'Ntcheu'),
(1962, 128, 'NKB', 'Nkhata Bay'),
(1963, 128, 'NKH', 'Nkhotakota'),
(1964, 128, 'NSJ', 'Nsanje'),
(1965, 128, 'NTI', 'Ntchisi'),
(1966, 128, 'PHL', 'Phalombe'),
(1967, 128, 'RMP', 'Rumphi'),
(1968, 128, 'SLM', 'Salima'),
(1969, 128, 'THY', 'Thyolo'),
(1970, 128, 'ZBA', 'Zomba'),
(1971, 129, 'JO', 'Johor'),
(1972, 129, 'KE', 'Kedah'),
(1973, 129, 'KL', 'Kelantan'),
(1974, 129, 'LA', 'Labuan'),
(1975, 129, 'ME', 'Melaka'),
(1976, 129, 'NS', 'Negeri Sembilan'),
(1977, 129, 'PA', 'Pahang'),
(1978, 129, 'PE', 'Perak'),
(1979, 129, 'PR', 'Perlis'),
(1980, 129, 'PP', 'Pulau Pinang'),
(1981, 129, 'SA', 'Sabah'),
(1982, 129, 'SR', 'Sarawak'),
(1983, 129, 'SE', 'Selangor'),
(1984, 129, 'TE', 'Terengganu'),
(1985, 129, 'WP', 'Wilayah Persekutuan'),
(1986, 130, 'THU', 'Thiladhunmathi Uthuru'),
(1987, 130, 'THD', 'Thiladhunmathi Dhekunu'),
(1988, 130, 'MLU', 'Miladhunmadulu Uthuru'),
(1989, 130, 'MLD', 'Miladhunmadulu Dhekunu'),
(1990, 130, 'MAU', 'Maalhosmadulu Uthuru'),
(1991, 130, 'MAD', 'Maalhosmadulu Dhekunu'),
(1992, 130, 'FAA', 'Faadhippolhu'),
(1993, 130, 'MAA', 'Male Atoll'),
(1994, 130, 'AAU', 'Ari Atoll Uthuru'),
(1995, 130, 'AAD', 'Ari Atoll Dheknu'),
(1996, 130, 'FEA', 'Felidhe Atoll'),
(1997, 130, 'MUA', 'Mulaku Atoll'),
(1998, 130, 'NAU', 'Nilandhe Atoll Uthuru'),
(1999, 130, 'NAD', 'Nilandhe Atoll Dhekunu'),
(2000, 130, 'KLH', 'Kolhumadulu'),
(2001, 130, 'HDH', 'Hadhdhunmathi'),
(2002, 130, 'HAU', 'Huvadhu Atoll Uthuru'),
(2003, 130, 'HAD', 'Huvadhu Atoll Dhekunu'),
(2004, 130, 'FMU', 'Fua Mulaku'),
(2005, 130, 'ADD', 'Addu'),
(2006, 131, 'GA', 'Gao'),
(2007, 131, 'KY', 'Kayes'),
(2008, 131, 'KD', 'Kidal'),
(2009, 131, 'KL', 'Koulikoro'),
(2010, 131, 'MP', 'Mopti'),
(2011, 131, 'SG', 'Segou'),
(2012, 131, 'SK', 'Sikasso'),
(2013, 131, 'TB', 'Tombouctou'),
(2014, 131, 'CD', 'Bamako Capital District'),
(2015, 132, 'ATT', 'Attard'),
(2016, 132, 'BAL', 'Balzan'),
(2017, 132, 'BGU', 'Birgu'),
(2018, 132, 'BKK', 'Birkirkara'),
(2019, 132, 'BRZ', 'Birzebbuga'),
(2020, 132, 'BOR', 'Bormla'),
(2021, 132, 'DIN', 'Dingli'),
(2022, 132, 'FGU', 'Fgura'),
(2023, 132, 'FLO', 'Floriana'),
(2024, 132, 'GDJ', 'Gudja'),
(2025, 132, 'GZR', 'Gzira'),
(2026, 132, 'GRG', 'Gargur'),
(2027, 132, 'GXQ', 'Gaxaq'),
(2028, 132, 'HMR', 'Hamrun'),
(2029, 132, 'IKL', 'Iklin'),
(2030, 132, 'ISL', 'Isla'),
(2031, 132, 'KLK', 'Kalkara'),
(2032, 132, 'KRK', 'Kirkop'),
(2033, 132, 'LIJ', 'Lija'),
(2034, 132, 'LUQ', 'Luqa'),
(2035, 132, 'MRS', 'Marsa'),
(2036, 132, 'MKL', 'Marsaskala'),
(2037, 132, 'MXL', 'Marsaxlokk'),
(2038, 132, 'MDN', 'Mdina'),
(2039, 132, 'MEL', 'Melliea'),
(2040, 132, 'MGR', 'Mgarr'),
(2041, 132, 'MST', 'Mosta'),
(2042, 132, 'MQA', 'Mqabba'),
(2043, 132, 'MSI', 'Msida'),
(2044, 132, 'MTF', 'Mtarfa'),
(2045, 132, 'NAX', 'Naxxar'),
(2046, 132, 'PAO', 'Paola'),
(2047, 132, 'PEM', 'Pembroke'),
(2048, 132, 'PIE', 'Pieta'),
(2049, 132, 'QOR', 'Qormi'),
(2050, 132, 'QRE', 'Qrendi'),
(2051, 132, 'RAB', 'Rabat'),
(2053, 99, 'TEL', 'Telangana'),
(2054, 1, 'JD', 'MD'),
(2055, 99, 'JH', 'Jharkhand');

-- --------------------------------------------------------

--
-- Table structure for table `fa_kv_tour_request`
--

CREATE TABLE `fa_kv_tour_request` (
  `tr_id` int(11) NOT NULL,
  `tr_request_id` char(25) DEFAULT NULL,
  `tr_emp_desig_id` smallint(6) NOT NULL,
  `tr_emp_dept_id` smallint(6) NOT NULL,
  `tr_emp_desig_group_id` smallint(6) NOT NULL,
  `tr_employee_id` char(20) DEFAULT NULL,
  `tr_single_group` tinyint(1) NOT NULL,
  `tr_request_for` tinyint(1) NOT NULL,
  `tr_no_of_paxs` smallint(4) NOT NULL,
  `tr_request_date` date NOT NULL,
  `tr_place_of_visit` varchar(300) NOT NULL,
  `tr_fromdate` datetime NOT NULL,
  `tr_todate` datetime NOT NULL,
  `tr_no_of_days` smallint(3) NOT NULL,
  `tr_purpose_of_visit` varchar(1000) NOT NULL,
  `tr_transport_by_company` tinyint(1) NOT NULL,
  `tr_mode_of_transport` varchar(50) DEFAULT NULL,
  `tr_accommodation_by` tinyint(2) DEFAULT NULL,
  `tr_advance_required` decimal(10,2) DEFAULT NULL,
  `tr_advance_in` tinyint(2) DEFAULT NULL,
  `tr_comment_by_approval` varchar(500) DEFAULT NULL,
  `tr_status` tinyint(2) NOT NULL DEFAULT 1,
  `tr_attachment_path` varchar(300) DEFAULT NULL,
  `tr_added_date` datetime NOT NULL,
  `tr_last_updated` datetime DEFAULT NULL,
  `tr_updated_by` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fa_kv_tour_request`
--

INSERT INTO `fa_kv_tour_request` (`tr_id`, `tr_request_id`, `tr_emp_desig_id`, `tr_emp_dept_id`, `tr_emp_desig_group_id`, `tr_employee_id`, `tr_single_group`, `tr_request_for`, `tr_no_of_paxs`, `tr_request_date`, `tr_place_of_visit`, `tr_fromdate`, `tr_todate`, `tr_no_of_days`, `tr_purpose_of_visit`, `tr_transport_by_company`, `tr_mode_of_transport`, `tr_accommodation_by`, `tr_advance_required`, `tr_advance_in`, `tr_comment_by_approval`, `tr_status`, `tr_attachment_path`, `tr_added_date`, `tr_last_updated`, `tr_updated_by`) VALUES
(1, 'TR-01-2019-002', 1, 1, 1, 'EMP-S-002', 1, 1, 1, '2019-01-15', 'HYD', '2019-01-21 12:00:00', '2019-01-25 12:00:00', 5, 'Skill Development', 0, '', 1, '0.00', 1, 'Approved', 2, '2019/01/TR-01-2019-002.pdf', '2019-01-15 08:11:34', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `fa_kv_tour_requestform`
--

CREATE TABLE `fa_kv_tour_requestform` (
  `id` int(11) NOT NULL,
  `from_place` varchar(50) NOT NULL,
  `fdate_time` varchar(50) NOT NULL,
  `to_place` varchar(50) NOT NULL,
  `tdate_time` varchar(50) NOT NULL,
  `des_mode` varchar(50) NOT NULL,
  `class` varchar(50) NOT NULL,
  `amount` varchar(50) NOT NULL,
  `updated_amount` float NOT NULL,
  `remark` varchar(50) NOT NULL,
  `file` varchar(50) NOT NULL,
  `purpose` varchar(50) NOT NULL,
  `tour_id` varchar(50) NOT NULL,
  `bill_id` varchar(50) NOT NULL,
  `submit_date` date NOT NULL,
  `status` int(10) NOT NULL DEFAULT 0,
  `admin_remark` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fa_kv_tour_requestform`
--

INSERT INTO `fa_kv_tour_requestform` (`id`, `from_place`, `fdate_time`, `to_place`, `tdate_time`, `des_mode`, `class`, `amount`, `updated_amount`, `remark`, `file`, `purpose`, `tour_id`, `bill_id`, `submit_date`, `status`, `admin_remark`) VALUES
(144, 'patna', '2019-07-05 10:05', 'Delhi', '2019-07-05 21:30', 'Flight', 'Eco', '5600', 5600, '', '', 'transport', 'TRD-07-2019-117', 'T_Bill_TRD-07-2019-117', '2019-07-05', 3, 'Approved'),
(145, 'Office dfs', '2019-08-26 09:00', 'PWC d', '2019-08-26 18:05', 'Bike df', '', '000', 0, 'Own Bike ert', '', 'conveyance', 'TRD-08-2019-118', 'T_Bill_TRD-08-2019-118', '2019-08-26', 0, NULL),
(146, 'patna', '2020-01-25 16:00', 'delhi', '2020-01-28 09:55', 'meeting', '', '1350', 0, '', '', 'food', 'TRD-01-2020-119', 'T_Bill_TRD-01-2020-119', '2020-01-27', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `fa_kv_type_leave_master`
--

CREATE TABLE `fa_kv_type_leave_master` (
  `type_id` int(11) NOT NULL,
  `leave_type` varchar(120) NOT NULL,
  `desciption` text NOT NULL,
  `inactive` int(11) NOT NULL DEFAULT 0,
  `field_name` varchar(100) NOT NULL,
  `code` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fa_kv_type_leave_master`
--

INSERT INTO `fa_kv_type_leave_master` (`type_id`, `leave_type`, `desciption`, `inactive`, `field_name`, `code`) VALUES
(1, 'Casual Leave', 'Casual Leave', 0, '', 'CL'),
(2, 'Medical Leave', 'Medical Leave', 0, '', 'ML'),
(3, 'Vacation Leave', 'Vacation Leave', 0, '', 'VL'),
(4, 'Special Casual Leave', 'Special Casual Leave', 0, '', 'SCL'),
(5, 'Maternity Leave', 'Maternity Leave', 0, '', 'MTL'),
(6, 'Paternity leave', 'Paternity leave', 0, '', 'PTL'),
(7, 'Compensatory Leave', 'Comp off', 0, '', 'WO'),
(9, 'Half Day CL', 'Half Day Casual Leave', 0, '', 'HCL'),
(11, 'Earned Leave', 'Earned Leave', 0, '', 'EL');

-- --------------------------------------------------------

--
-- Table structure for table `fa_locations`
--

CREATE TABLE `fa_locations` (
  `loc_code` varchar(5) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `location_name` varchar(60) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `delivery_address` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `phone2` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fax` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `contact` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fixed_asset` tinyint(1) NOT NULL DEFAULT 0,
  `inactive` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fa_locations`
--

INSERT INTO `fa_locations` (`loc_code`, `location_name`, `delivery_address`, `phone`, `phone2`, `fax`, `email`, `contact`, `fixed_asset`, `inactive`) VALUES
('PAT', 'Patna', '258, Nehru Nagar', '2568977', '2457899', '', '', 'Shreekant', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `fa_loc_stock`
--

CREATE TABLE `fa_loc_stock` (
  `loc_code` char(5) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `stock_id` char(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `reorder_level` double NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fa_loc_stock`
--

INSERT INTO `fa_loc_stock` (`loc_code`, `stock_id`, `reorder_level`) VALUES
('PAT', 'cpui3', 0);

-- --------------------------------------------------------

--
-- Table structure for table `fa_maintenance_department`
--

CREATE TABLE `fa_maintenance_department` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `depart_id` int(11) NOT NULL,
  `desiggroup_id` int(11) NOT NULL,
  `designation_id` int(11) NOT NULL,
  `empl_id` varchar(11) NOT NULL,
  `inactive` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `fa_maintenance_help_desk`
--

CREATE TABLE `fa_maintenance_help_desk` (
  `help_id` int(11) NOT NULL,
  `helpdesk_date` varchar(40) NOT NULL,
  `category` int(11) NOT NULL,
  `dept_id` int(11) NOT NULL,
  `desgroup_id` int(11) NOT NULL,
  `desig_id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `stu_name` varchar(120) NOT NULL,
  `issues` text NOT NULL,
  `maintain_dept_id` int(11) NOT NULL,
  `status` int(2) NOT NULL,
  `inactive` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fa_maintenance_help_desk`
--

INSERT INTO `fa_maintenance_help_desk` (`help_id`, `helpdesk_date`, `category`, `dept_id`, `desgroup_id`, `desig_id`, `emp_id`, `stu_name`, `issues`, `maintain_dept_id`, `status`, `inactive`) VALUES
(1, '01/16/2019', 1, 1, 2, 3, 0, '', 'Battery backup issue', 1, 0, 0),
(2, '21-01-2020', 1, 1, 2, 3, 0, '', '', 1, 0, 0),
(3, '21-01-2020', 1, 2, 7, 15, 0, '', 'xghfgh', 2, 0, 0),
(4, '27-01-2022', 1, 1, 1, 1, 0, '', 'System Not Working', 0, 0, 0),
(5, '08-02-2022', 1, 1, 2, 3, 0, '', 'System not working', 9, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `fa_manual_sal_deduction`
--

CREATE TABLE `fa_manual_sal_deduction` (
  `id` int(10) NOT NULL,
  `leave_type` int(10) NOT NULL,
  `leave_count` float(4,1) NOT NULL DEFAULT 0.0,
  `leave_adjusted` float(4,1) NOT NULL DEFAULT 0.0,
  `days_deducted` float(4,1) NOT NULL DEFAULT 0.0,
  `updated_date` date NOT NULL,
  `added_date` date NOT NULL,
  `remarks` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `empl_id` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `fa_movement_types`
--

CREATE TABLE `fa_movement_types` (
  `id` int(11) NOT NULL,
  `name` varchar(60) NOT NULL DEFAULT '',
  `inactive` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fa_movement_types`
--

INSERT INTO `fa_movement_types` (`id`, `name`, `inactive`) VALUES
(1, 'local', 0),
(2, 'User', 0),
(3, 'Technical', 0),
(4, 'Non-technical', 0);

-- --------------------------------------------------------

--
-- Table structure for table `fa_name_return_master`
--

CREATE TABLE `fa_name_return_master` (
  `id` int(11) NOT NULL,
  `return_name` varchar(150) NOT NULL,
  `return_desc` varchar(150) NOT NULL,
  `inactive` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fa_name_return_master`
--

INSERT INTO `fa_name_return_master` (`id`, `return_name`, `return_desc`, `inactive`) VALUES
(1, 'Bihar Govt.', 'Bihar Govt. Dept.', 0),
(2, 'Central Depts', 'Central Department', 0),
(3, 'Income Tax', 'Income Tax Department', 0),
(4, 'Company Registar', 'Company Registar', 0),
(5, 'Quarterly Board Meeting', 'Quarterly Board Meeting', 0),
(6, 'Monthly Board meeting', 'Monthly Board meeting', 0),
(7, 'Monthly Review Meeting', 'Monthly Review Meeting', 0),
(8, 'Monthly Team Meeting', 'Monthly Team Meeting', 1),
(9, 'One', 'one teex', 0),
(10, 'Two', 'sesdf', 0),
(11, 'Yjty', 'tyty', 0);

-- --------------------------------------------------------

--
-- Table structure for table `fa_overtime`
--

CREATE TABLE `fa_overtime` (
  `overtime_id` int(11) NOT NULL,
  `overtime_name` varchar(100) NOT NULL,
  `overtime_rate` float NOT NULL,
  `inactive` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `fa_payment_terms`
--

CREATE TABLE `fa_payment_terms` (
  `terms_indicator` int(11) NOT NULL,
  `terms` char(80) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `days_before_due` smallint(6) NOT NULL DEFAULT 0,
  `day_in_following_month` smallint(6) NOT NULL DEFAULT 0,
  `inactive` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fa_payment_terms`
--

INSERT INTO `fa_payment_terms` (`terms_indicator`, `terms`, `days_before_due`, `day_in_following_month`, `inactive`) VALUES
(1, 'Due 15th Of the Following Month', 0, 17, 0),
(2, 'Due By End Of The Following Month', 0, 30, 0),
(3, 'Payment due within 10 days', 10, 0, 0),
(4, 'Cash Only', 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `fa_payroll_account`
--

CREATE TABLE `fa_payroll_account` (
  `account_id` int(11) NOT NULL,
  `account_code` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `fa_payroll_structure`
--

CREATE TABLE `fa_payroll_structure` (
  `salary_scale_id` int(11) NOT NULL,
  `payroll_rule` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `fa_payslip`
--

CREATE TABLE `fa_payslip` (
  `payslip_no` int(11) NOT NULL,
  `trans_no` int(11) NOT NULL DEFAULT 0,
  `emp_id` int(11) NOT NULL,
  `generated_date` date NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `leaves` int(11) NOT NULL,
  `deductable_leaves` int(11) NOT NULL,
  `payable_amount` double NOT NULL DEFAULT 0,
  `salary_amount` double NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `fa_payslip_details`
--

CREATE TABLE `fa_payslip_details` (
  `payslip_no` int(11) NOT NULL,
  `detail` int(11) NOT NULL DEFAULT 0,
  `amount` double NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `fa_preventmaintain_entry_items`
--

CREATE TABLE `fa_preventmaintain_entry_items` (
  `items_id` int(11) NOT NULL,
  `prevent_id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `sub_cat_id` int(11) NOT NULL,
  `item_id` varchar(100) NOT NULL,
  `quantity` float NOT NULL,
  `stock_qty` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fa_preventmaintain_entry_items`
--

INSERT INTO `fa_preventmaintain_entry_items` (`items_id`, `prevent_id`, `cat_id`, `sub_cat_id`, `item_id`, `quantity`, `stock_qty`) VALUES
(1, 2, 0, 0, 'Select', 0, 0),
(2, 3, 1, 1, 'ITC001', 0, 100),
(3, 5, 1, 1, 'ITC001', 100, 100),
(4, 8, 4, 2, 'Car', 1, 3),
(5, 9, 4, 2, 'Car', 1, 2),
(6, 10, 4, 2, 'Car', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `fa_prevent_maintain_entry`
--

CREATE TABLE `fa_prevent_maintain_entry` (
  `prevent_id` int(11) NOT NULL,
  `maintain_date` varchar(30) NOT NULL,
  `utility_id` int(11) NOT NULL,
  `frequency_id` int(11) NOT NULL,
  `contractor_id` int(11) NOT NULL,
  `prv_ob_date` varchar(30) NOT NULL,
  `prv_ob_1` text NOT NULL,
  `prv_ob_2` text NOT NULL,
  `prv_ob_3` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fa_prevent_maintain_entry`
--

INSERT INTO `fa_prevent_maintain_entry` (`prevent_id`, `maintain_date`, `utility_id`, `frequency_id`, `contractor_id`, `prv_ob_date`, `prv_ob_1`, `prv_ob_2`, `prv_ob_3`) VALUES
(1, '01-05-2017', 2, 0, 1, '', '', '', ''),
(2, '01-05-2017', 3, 1, 1, '', '', '', ''),
(3, '', 0, 1, 1, '', '', '', ''),
(4, '13-01-2018', 0, 0, 2, '', '', '', ''),
(5, '22-02-2018', 0, 1, 1, '22-02-2018', 'Some wheels are loose.', 'All wheels to be checked and tightened', 'Contractor contacted.'),
(6, '08-02-2022', 5, 2, 2, '27-01-2022', 'Oil leakage', 'Top Up Brake Oil', 'Change Brake Oil'),
(7, '08-02-2022', 5, 2, 2, '27-01-2022', 'Oil leakage', 'Top Up Brake Oil', 'Change Brake Oil'),
(8, '08-02-2022', 5, 2, 2, '27-01-2022', 'Oil leakage', 'Top Up Brake Oil', 'Change Brake Oil'),
(9, '08-02-2022', 5, 2, 4, '08-02-2022', 'Engine Oil Leakage', 'Top Up E Oil', 'Top Up E Oil'),
(10, '10-02-2022', 10, 5, 2, '08-11-2021', 'test', 'testsugges', 'testinit');

-- --------------------------------------------------------

--
-- Table structure for table `fa_prevent_maintain_params`
--

CREATE TABLE `fa_prevent_maintain_params` (
  `param_id` int(11) NOT NULL,
  `prevent_id` int(11) NOT NULL,
  `parameters` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fa_prevent_maintain_params`
--

INSERT INTO `fa_prevent_maintain_params` (`param_id`, `prevent_id`, `parameters`) VALUES
(1, 10, 10),
(2, 10, 15);

-- --------------------------------------------------------

--
-- Table structure for table `fa_prevent_new_items`
--

CREATE TABLE `fa_prevent_new_items` (
  `new_item_id` int(11) NOT NULL,
  `prevent_id` int(11) NOT NULL,
  `n_item` varchar(100) NOT NULL,
  `n_qty` float NOT NULL,
  `n_bill_date` varchar(30) NOT NULL,
  `n_billno` varchar(100) NOT NULL,
  `n_contractor` varchar(100) NOT NULL,
  `n_comments` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `fa_prices`
--

CREATE TABLE `fa_prices` (
  `id` int(11) NOT NULL,
  `stock_id` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `sales_type_id` int(11) NOT NULL DEFAULT 0,
  `curr_abrev` char(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `price` double NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fa_prices`
--

INSERT INTO `fa_prices` (`id`, `stock_id`, `sales_type_id`, `curr_abrev`, `price`) VALUES
(0, '003', 1, 'INR', 500);

-- --------------------------------------------------------

--
-- Table structure for table `fa_printers`
--

CREATE TABLE `fa_printers` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `queue` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `host` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `port` smallint(11) UNSIGNED NOT NULL,
  `timeout` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fa_printers`
--

INSERT INTO `fa_printers` (`id`, `name`, `description`, `queue`, `host`, `port`, `timeout`) VALUES
(1, 'QL500', 'Label printer', 'QL500', 'server', 127, 20),
(2, 'Samsung', 'Main network printer', 'scx4521F', 'server', 515, 5),
(3, 'Local', 'Local print server at user IP', 'lp', '', 515, 10);

-- --------------------------------------------------------

--
-- Table structure for table `fa_print_profiles`
--

CREATE TABLE `fa_print_profiles` (
  `id` smallint(6) UNSIGNED NOT NULL,
  `profile` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `report` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `printer` tinyint(3) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fa_product_master`
--

CREATE TABLE `fa_product_master` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `code` varchar(100) NOT NULL,
  `inactive` tinyint(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fa_product_master`
--

INSERT INTO `fa_product_master` (`id`, `name`, `code`, `inactive`) VALUES
(1, 'managment', '', 0),
(2, 'Raushan', '', 0),
(3, 'Development', '', 0),
(4, 'IT  Building', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `fa_publisher`
--

CREATE TABLE `fa_publisher` (
  `pub_id` int(11) NOT NULL,
  `pub_code` varchar(50) NOT NULL,
  `pub_name` varchar(100) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fa_publisher`
--

INSERT INTO `fa_publisher` (`pub_id`, `pub_code`, `pub_name`, `status`) VALUES
(1, 'BB', 'BHARTI BHAVAN', 1),
(2, 'SCC', 'S.CHAND & COMPANY', 1),
(3, 'EPH', 'EURASIA PUB HOUSE', 1),
(4, 'N', 'NCERT', 1),
(5, 'PRP', 'PRACHI PUBLICATION', 1),
(6, 'SOP', 'SOUVENIR PUB', 1),
(7, 'TRB', 'TRUMAN BOOK CO', 1),
(8, 'PRA', 'PRADEEP PUB', 1),
(9, 'DRC', 'DHANPAT RAI & CO', 1),
(10, 'RKP', 'RAJ KAMAL PRAKASHAN', 1),
(11, 'RP', 'RADHAKRISHN PRAKASHN', 1),
(12, 'LOK', 'LOK BHARTI', 1),
(13, 'BEB', 'BEST BOOK PUB', 1),
(14, 'RS', 'RACHANA SAGAR', 1),
(15, 'EP', 'EVERGREEN PUBLICATION', 1),
(16, 'OUP', 'OXFORD UNIVERSITY PRESS', 1),
(17, 'SCH', 'SULTAN CHAND', 1),
(18, 'SWH', 'SARASWATI HOUSE', 1),
(19, 'SRI', 'SRIJAN PUBLICATION', 1),
(20, 'OAS', 'OASIS EDUCATIONAL SERVICES P L', 1),
(21, 'HIN', 'HOLIFAITH INTER NATIONAL', 1),
(22, 'CBS', 'C.B.S.EDUCATION', 1),
(23, 'GR1', 'G R BATHLA & SONS', 1),
(24, 'JWS', 'JOHN WELL &SONS CO', 1),
(25, 'MOP', 'MODERN PUBLICATION', 1),
(26, 'PE2', 'PEARSON EDUCATION', 1),
(27, 'GKB', 'G.K.BATHLA & SONS', 1),
(28, 'TMH', 'TMH', 1),
(29, 'TRU', 'TRUMANS PUBLICATION', 1),
(30, 'SC1', 'S CHAND & CO', 1),
(31, 'PTP', 'PITAMBER PUBLICATION', 1),
(32, 'RAT', 'RATNA SAGAR', 1),
(33, 'HFT', 'HOLI FAITH', 1),
(34, 'AP7', 'ARCHANA PRAKASHAN', 1),
(36, 'LUX', 'LUXMI PUBLICATION', 1),
(37, 'MBT', 'MBT  N DELHI', 1),
(38, 'NP', 'NAVDEEP PUBLICATION', 1),
(39, 'GOY', 'GOYAL PUB', 1),
(40, 'NEP', 'NEELAM PUBLICATION', 1),
(41, 'LAX', 'LAXMI PUBLICATION', 1),
(42, 'PP', 'PITAMBER PRAKASHAN', 1),
(43, 'OP', 'OSWAL PUBLICATION', 1),
(44, 'SA2', 'SARASWATI', 1),
(45, 'OXU', 'OXFORD UNIVERSIT PRESS', 1),
(46, 'OES', 'OASI EDUCATIONAL SERVICE LTD', 1),
(47, 'GPP', 'GONAL PRINTER & PUBLICATION', 1),
(48, 'SDS', 'SHIV DAS & SONS', 1),
(49, 'MB3', 'MBD', 1),
(50, 'JP1', 'JIWAN PUBLICATION', 1),
(51, 'ASP', 'ASHOKA PUBLISHING HOUSE', 1),
(52, 'YP', 'YURESHIYA PUBLISHING', 1),
(53, 'APB', 'ARYA PUBLICATION', 1),
(54, 'GB', 'GOYAL BROTHERS', 1),
(55, 'ABD', 'ARYA BOOK DEPOT', 1),
(56, 'SAC', 'SULTANCHAND AND COMPANY', 1),
(57, 'TMP', 'TATA MACROHILL PUBLICATION', 1),
(58, 'VI2', 'VIDYA PRAKASHAN', 1),
(59, 'KM', 'KITAB MAHAL', 1),
(60, 'S&P', 'SUCHNA & PRASARAN MANTRALAY', 1),
(61, 'IEE', 'INDIAN EDULT EDU ASSCIATION', 1),
(62, 'IIO', 'INDIAN INSTI OF PUBL ADM', 1),
(63, 'NBC', 'NALANDA BOOK CENTER', 1),
(64, 'CSD', 'COOPRATIVE & SUGARCAME DEPT', 1),
(65, 'GPL', 'GYANPETH PVT LTD', 1),
(66, 'TLA', 'THE LIBRAL ART PRESS', 1),
(67, 'PB5', 'PIRAMID BOOK', 1),
(68, 'VP9', 'VEENA PUSTAK MANDIR', 1),
(69, 'IP', 'INTERNATIONAL PRAKASHAN', 1),
(70, 'FLP', 'FOREIGN LANGUAGE PUBLICATION', 1),
(71, 'NB1', 'NBT', 1),
(72, 'OT', 'ORRISA TOURISM', 1),
(73, 'LPP', 'LUXMI PUSTKALAY PATNA', 1),
(74, 'RPV', 'RAMESHWAR PRASAD VISHWABANDHU', 1),
(75, 'SF', 'STUDENT FRENDS', 1),
(76, 'CBE', 'C B S E N D', 1),
(77, 'BLO', 'BLOSSOMS', 1),
(78, 'AB2', 'ARYA BOOK DEPO', 1),
(79, 'JSW', 'JANMUKTI SANGHARSH WAHINI', 1),
(80, 'SPM', 'SHARMA PUSTAK MANDIR', 1),
(81, 'SJC', 'SARAN JELA CONGRES S S SAMITI', 1),
(82, 'ADP', 'ADHUNIK PRAKASHAN', 1),
(83, 'RP;', 'RADHA PUBLICATION', 1),
(84, 'KN', 'KALA NIKETAN', 1),
(85, 'HMK', 'HND MADHYAM KARYANWAYN NIDESH', 1),
(86, 'SA5', 'SAHITYAGAR', 1),
(87, 'PP;', 'PEPULAS PUBLICATION HOUSE', 1),
(88, 'SP.', 'SHAYAM PRAKASHAN', 1),
(89, 'W&C', 'WADHA & CO', 1),
(90, 'SPU', 'SAHETYA BHAWAN PUB', 1),
(91, 'NPP', 'NOVOSTI PRESS PUBLISHING', 1),
(92, 'P&S', 'PRAKASH & SANS', 1),
(93, 'WI', 'WILY INDIA', 1),
(94, 'CBC', 'CHILDREN BOOK CENTRE', 1),
(95, 'PR2', 'PREMIER PUBLICATION', 1),
(96, 'ALP', 'ALLIED PUBLICATION', 1),
(97, 'PI', 'PRACHI INDIA', 1),
(98, 'D&C', 'DINESH & CO', 1),
(99, 'BR2', 'BIHAR RASTRABHASA PARESAD', 1),
(100, 'GS2', 'GANDHI SANGHRALAY', 1),
(101, 'NBT', 'NATIONAL BOOK TRUST', 1),
(102, 'AP6', 'ARAVIND PRAKASHAN', 1),
(103, 'RP\\', 'RAJA POCKET BOOKS', 1),
(104, 'ABK', 'AKHIL BHARTIYA KALA KENDRA', 1),
(105, 'SS8', 'S SAHJANAND S', 1),
(106, 'PB6', 'PRAKASHAN BIBHAG', 1),
(107, 'UP2', 'UMESH PRAKASHAN', 1),
(108, 'ORL', 'ORIENT LANGMAN', 1),
(109, 'RK.', 'RADHA KRISHAN PRAKASHAN', 1),
(110, 'SP\'', 'SHAKTI PRAKASHAN', 1),
(111, 'RKN', 'RAMKRISHNA MATH', 1),
(112, 'R&S', 'RAJPAL & SONS', 1),
(113, 'PD', 'PUBLICATION DEVISION', 1),
(114, 'ANP', 'ANAMIKA PUBLISHERS', 1),
(115, 'LBP', 'LOK BHARTI PRAKASHAN', 1),
(116, 'JKP', 'J K PRINTERS', 1),
(117, 'SS0', 'SARWODAY SAHITYA PUB', 1),
(118, 'SAA', 'SAHITY AKADAMI', 1),
(119, 'HP5', 'HIND POCKET BOOKS', 1),
(120, 'SPH', 'SCHOLAR PUBLISHING HOUSE', 1),
(121, 'BVB', 'BAL VIGYAN BHARATI', 1),
(122, 'HPP', 'HINDI PRACHARAK PRAKASHAN', 1),
(123, 'NPH', 'NATIONAL PUBLIC HOUSE', 1),
(124, 'MAH', 'MAHESH PRAKASHAN', 1),
(125, 'RKM', 'RAM KRISHN MATH', 1),
(126, 'PP2', 'PRABHAT PRAKASHAN', 1),
(127, 'RH', 'RAJ PUB. HOUSE', 1),
(128, 'TAR', 'TARUN PUB', 1),
(129, 'AP2', 'ARTI PRAKAHAN', 1),
(130, 'GK', 'GRANTHMALA KARYALAY', 1),
(131, 'AP8', 'ASHOK PRAKASHAN', 1),
(132, 'RAN', 'RANJAN PRAKASHAN', 1),
(133, 'SP', 'SAKUN PRAKASHAN', 1),
(134, 'BSP', 'BAL SAHITY PRAKASHAN', 1),
(135, 'SS5', 'SUBODH SAHITYA PRAKASHAN', 1),
(136, 'PC', 'PRACHARAK CLUB', 1),
(137, 'BHG', 'BIHAR HINDI GRANTH AKADAMI', 1),
(138, 'APG', 'ASHA PRAKASHAN GREH', 1),
(139, 'SB3', 'SARASWATI BHANDAR', 1),
(140, 'BN', 'BHARTI NIKETAN', 1),
(141, 'OP5', 'OJHA PRAKASHAN', 1),
(142, 'BPH', 'BHARAT PUB HOUSE', 1),
(143, 'VP', 'VIKASH PRAKASHAN', 1),
(144, 'PPO', 'POONAM PRAKASHAN MANDIR', 1),
(145, 'NP1', 'NAGRI PRACHARNI SANSTHA', 1),
(146, 'RB2', 'REGAL BOOK DEPO', 1),
(147, 'KP', 'KRITI PRAKAHAN', 1),
(148, 'AVI', 'AVICHAL PUB HOUSE', 1),
(149, 'BW', 'BROWN WATSON', 1),
(150, 'GOO', 'GOODWILL PUB.', 1),
(151, 'H', 'HEINEMAN', 1),
(152, 'BPM', 'BINOD PUSTAK MANDIR', 1),
(153, 'KHS', 'KENDRIYA HINDI SANSTHAN', 1),
(154, 'RAH', 'RAHUL PRAKASHAN', 1),
(155, 'MB2', 'MALHOTRA BOOK DEPOT', 1),
(156, 'PS6', 'PRAKASAN SANSTHAN', 1),
(157, 'GM', 'GOOD MAN', 1),
(158, 'HPC', 'HINDI PRAKASHAN CHAPRA', 1),
(159, 'SS6', 'SANGET SADAN PRAKASHAN', 1),
(160, 'GG', 'GANGA GRAMASAR', 1),
(161, 'RP-', 'RUBY PRAKASHAN', 1),
(162, 'DFB', 'DELHI FOOD BOOK CENTER', 1),
(163, 'HP3', 'HINDI POCKET BOOKS', 1),
(164, 'PUR', 'PURWANCHAL PRAASHAN', 1),
(165, 'RAA', 'R S A A PRAKASAN', 1),
(166, 'BGN', 'BHARTIYA GRAM NIKETAN', 1),
(167, 'HPS', 'HINDI PRCHARAK SANKHYA', 1),
(168, 'BG2', 'BHARTIYA GRANTH NIKETAN', 1),
(169, 'RAS', 'RAJPAL AND SANS', 1),
(170, 'MPW', 'MAYUR PAPER WORKS', 1),
(171, 'PP.', 'PREM PRAKASAN MANDER', 1),
(172, 'ASH', 'ASHA PRAKASHAN', 1),
(173, 'SS', 'SAHITY SADAN', 1),
(174, 'DP9', 'DHINGRA PUB HOUSE', 1),
(175, 'SAH', 'SAHNI PUBLICATION', 1),
(176, 'PM', 'PUSTAK MAHAL', 1),
(177, 'JP4', 'JAWAHAR PRAKASHAN', 1),
(178, 'PG', 'PRACHARAK GRANTHAWALI', 1),
(179, 'VM', 'VANI MANDIR', 1),
(180, 'ABP', 'ABHIWAYAKTI PRAKASHAN', 1),
(181, 'PS', 'PRAKASHAN SANSTHAN', 1),
(182, 'USA', 'U S A INTERNATIONAL', 1),
(183, 'GP2', 'GYANDA PRAKASHAN', 1),
(184, 'SP[', 'SOWENIYAR PUBLICATION', 1),
(185, 'AP;', 'AMIT PRAKASHA', 1),
(186, 'HPB', 'HINDI PAKET BOOKS', 1),
(187, 'SS3', 'SAHITYA SGAR', 1),
(188, 'SUK', 'SUKRITI PRAKASHAN', 1),
(189, 'RP1', 'RAJKAMAL PRAKASHAN', 1),
(190, 'FRA', 'FRANK BROS & CO', 1),
(191, 'BS2', 'BAL SADAN', 1),
(192, 'PP\'', 'PARAG PRAKASHAN', 1),
(193, 'RK3', 'RADHA KRISHN PRAKASHAN', 1),
(194, 'RNB', 'RASTREYA NATYA BIDYALAY', 1),
(195, 'RST', 'RAJENDRA SMARAK TRUST', 1),
(196, 'JEV', 'JEEVAN PRAKASHAN', 1),
(197, 'BC5', 'BRIGHT CAREAR', 1),
(198, 'SD1', 'S DINESH & CO', 1),
(199, 'SON', 'SONI PUBLICATION', 1),
(200, 'NCT', 'N C E R T', 1),
(201, 'CSL', 'CURENT SAENTEFIC LITRECHER', 1),
(202, 'HP4', 'HIMACHAL PUSTAK BHANDAR', 1),
(203, 'AP0', 'ANKUR PRAKASHAN', 1),
(204, 'SPT', 'SMT PARMATMA TAPOVAN', 1),
(205, 'VP2', 'VANI PRAKASHAN', 1),
(206, 'SPA', 'SAHITYANJALI PRA ALLAHABAD', 1),
(207, 'SK', 'SANGET KARYALAY', 1),
(208, 'HP2', 'HEM PRAKASHAN', 1),
(209, 'ALK', 'ALKA PRAKASHAN', 1),
(210, 'DPB', 'DAYMAND PAKET BOOK', 1),
(211, 'MB6', 'MITTAL BOOK DEPO', 1),
(212, 'CB2', 'COSMOS BOOKLINE', 1),
(213, 'CBL', 'COSMOS BOOK LINE', 1),
(214, 'JCP', 'JAY CEE PUBLICATION', 1),
(215, 'VP1', 'VOHRA PUBLISHERS', 1),
(216, 'AP\'', 'ACADEMIC PUBLICATION', 1),
(217, 'SEP', 'SEASONS PUBLICATION', 1),
(218, 'JM', 'JEEVAN MANDIR', 1),
(219, 'KNF', 'KAPITAL NEWS & FEATURS', 1),
(220, 'SP5', 'SAHITY PARIHAD', 1),
(221, 'GM2', 'GYAN MANDIR', 1),
(222, 'PR4', 'PRAGATI PRAKASHAN', 1),
(223, 'PB7', 'PRAKASHAN BIBHAG S & P M', 1),
(224, 'SSS', 'SARV SEVA SANGH PRAKASHAN', 1),
(225, 'BTA', 'BHEKHARI THAKUR ASRAM', 1),
(226, 'GJS', 'GANDHI JANM SHATABDI S G PRA', 1),
(227, 'SB', 'SHIKSHA BHARATI', 1),
(228, 'ANU', 'ANUPAM PRAKASHAN', 1),
(229, 'RBP', 'RASTRA BHASA PRAKASHAN', 1),
(230, 'RDG', 'RAMJEEDAS GUPTA', 1),
(231, 'KB1', 'KABIR BICHAR', 1),
(232, 'CBT', 'CHILDREN BOOK TRUST', 1),
(233, 'BSM', 'BHARATIYAN SAHITY MANDIR', 1),
(234, 'MAM', 'MAC MILLIAM', 1),
(235, 'LP1', 'LEARNER PRESS', 1),
(236, 'V', 'VARUN PUBLICATION', 1),
(237, 'SP+', 'SHYAM PRAKASHAN', 1),
(238, 'M&G', 'MORRISON & GISS LTD', 1),
(239, 'OPB', 'ORIENT PAPER BOOKS', 1),
(240, 'ABH', 'ABHAY PUBLICATION', 1),
(241, 'BVP', 'BHARTIYA VIDYA PUBLICATION', 1),
(242, 'INW', 'IVOR NICHOLSON & WATSON', 1),
(243, 'GGH', 'GEORGE G HARRAP CO LTD', 1),
(244, 'TNS', 'THOMAS NELSON & SONS LTD', 1),
(245, 'GS1', 'GHANSHYAM SAHAN', 1),
(246, 'RMV', 'RAMKRISHN MISHAN VIVEKANAND', 1),
(247, 'TS5', 'THE STUDENT STERES', 1),
(248, 'NJP', 'NAV JEEVAN PUBLICATION', 1),
(249, 'FL1', 'FOREIGN LANGUAGE PUBLI', 1),
(250, 'NB2', 'NEW BOOK COMPENY', 1),
(251, 'UP', 'UNIVERSITY PRESS', 1),
(252, 'VPB', 'VIKING PONGUIN BOOKS INDIA', 1),
(253, 'DP6', 'DAYNAMIC PRAKASHAN', 1),
(254, 'RB', 'ROLI BOOKS', 1),
(255, 'DWS', 'DR WULKE SMIRTI GRANTH SAMITE', 1),
(256, 'SS-', 'S S S HETKARI SAMAJ', 1),
(257, 'HP7', 'HINDI PRACHARAK PUB PVT LTD', 1),
(258, 'VPD', 'VOHRA PUB & DISTEBUTERS', 1),
(259, 'BST', 'BIHAR STATE TEST BOOK PUB CORP', 1),
(260, 'MAD', 'MAHANT AWADHESNATH D N DAS', 1),
(261, 'JSM', 'JEEVAN SEKSHA MUDRANALAY', 1),
(262, 'P&', 'PRASAD & SANTATI', 1),
(263, 'KAP', 'KAMAL PRAKASHAN', 1),
(264, 'RPB', 'RAJA PAKE BOOKS', 1),
(265, 'BB3', 'BISHWA BIJAY PRAKASHAN', 1),
(266, 'RV', 'RAWANG VILAS', 1),
(267, 'DB', 'DAYMOND BOOKS', 1),
(268, 'MP1', 'MARUTI PRAKASH', 1),
(269, 'NL2', 'NEW LIGHT PUB', 1),
(270, 'TTP', 'TINY TOT PUBLICATION', 1),
(271, 'SC4', 'SCHOLASTIC', 1),
(272, 'R&C', 'RUPA & CO', 1),
(273, 'PUF', 'PUFFIN', 1),
(274, 'SRS', 'SHRISTI PUB', 1),
(275, 'PP', 'PROGRESS PUBLICATION', 1),
(276, '', 'RADUGA PUBLICATION', 1),
(277, 'RP2', 'DHINGRA PUBLICATION', 1),
(278, 'DP', 'LEARNERS PRES PVT LTD', 1),
(279, 'LP5', 'REBO PUBLICATION', 1),
(280, 'REP', 'OUATEL BOOKS LTD', 1),
(281, 'OBL', 'WALDMAN & SONS', 1),
(282, 'W&S', 'A TEMPLAR BOOK', 1),
(283, 'ATB', 'GUL MOHAR ORIENT LONGMAN', 1),
(284, 'GMO', 'MANOJ PAKET BOOKS', 1),
(285, 'MPB', 'RAM NARAYAN LAL BENI PD', 1),
(286, 'RNL', 'FATHES MULARS HOMEO POER DESP', 1),
(287, 'HMH', 'U P HND GRANTH AKADMI', 1),
(288, 'UPH', 'J & J D KAME LABOURATERY', 1),
(289, 'J&J', 'MACMILLAN INDIA', 1),
(290, 'MI', 'MANISHA', 1),
(291, 'MAN', 'AFFILIATED CASWEST PRES P LTD', 1),
(292, 'ACP', 'NATIONAL ACADEMY OF SC', 1),
(293, 'NAO', 'MAYA PRAKASHAN', 1),
(294, 'MP9', 'H B C FOR SC ED', 1),
(295, 'HB2', 'SHEKHAR PHATAK & ASO', 1),
(296, 'SP&', 'RASTREYA VIG & PRO SAN PARESA', 1),
(297, 'HVP', 'WAWLENTERY H ASSO OF INDIA', 1),
(298, 'WHI', 'VIGYAN PRASAR', 1),
(299, 'VIP', 'SHRIJ BINDESHWARI SINGH', 1),
(300, 'SB7', 'MODERN PAPER BOOKS', 1),
(301, 'MP7', 'JAGAT SANKHDHER', 1),
(302, 'JS', 'THE ENGLISH BOOK DEPO', 1),
(303, 'TEB', 'D B TARAPELA & OTHERS', 1),
(304, 'DBT', 'ROUTLDGE & KEGAN PAUL  LTD', 1),
(305, 'R&K', 'RAJSTHAN PRAKASHAN', 1),
(306, 'RS5', 'MITCHELL BEAZLEY', 1),
(307, 'MB5', 'HEALTH HARNONY', 1),
(308, 'HH1', 'NARSERY PUBLICATION HOME', 1),
(309, 'NP3', 'KIRAN PUB', 1),
(310, 'KP6', 'STERLING PUB', 1),
(311, 'SP', 'UNIVERN BOOKS', 1),
(312, '', 'SASTA SAHITYA MANDAL', 1),
(313, 'UB2', 'NEW SAHETYA', 1),
(314, 'SSM', 'GERG BROTHERS', 1),
(315, 'NS2', 'MOTILAL VANARASI DAS', 1),
(316, 'GB2', 'ATMARAM & SONS', 1),
(317, 'MVD', 'PENGUIN BOOK DEPO', 1),
(318, 'A&S', 'IROR NICHOLSAN WATSEN', 1),
(319, 'PB8', 'GANDHI S P V A P KENDRA', 1),
(320, 'IN1', 'GHUGH PUBLICATION', 1),
(321, 'GSP', 'JANKI PRAKASHAN', 1),
(322, 'GP3', 'I I OF I TRADE', 1),
(323, 'JP6', 'INTERNATIONAL LAW ASSOCEATION', 1),
(324, 'II1', 'CRONECAL BOOKS', 1),
(325, 'ILA', 'MALYALA MANORAMA COMPANY', 1),
(326, 'CB4', 'MINESTRY OF FINANSE', 1),
(327, 'MMC', 'NEW VEKASH PUB', 1),
(328, 'MOF', 'GAURAV PUB HOUSE', 1),
(329, 'NV2', 'MANNU GRAPHIC', 1),
(330, 'GPH', 'I C O A R', 1),
(331, 'MG', 'GAURAV PUB.', 1),
(332, 'ICO', 'BHOOMGUSY PUB', 1),
(333, 'GAU', 'SHAYAM PRESS', 1),
(334, 'BGP', 'ENCYCLOPAEDIA BRITANICA', 1),
(335, 'SH1', 'BRIJBASI ART PRESS', 1),
(336, 'ENC', 'PENTAGON PRESS', 1),
(337, 'BAP', 'GOODS & GROES', 1),
(338, 'PEN', 'PARRAGAN PUBLIHING', 1),
(339, 'G&G', 'POPULAR PRAKASHAN', 1),
(340, 'PP3', 'ARUN SHOURIE', 1),
(341, 'PP1', 'SARAN JILA BHAJPA', 1),
(342, 'AS5', 'LIONS CLUB CHAPRA', 1),
(343, 'SJB', 'JAGDAM MAHAVIDYALAY', 1),
(344, 'LCC', 'VISHWAJEET COMPUTER', 1),
(345, 'JM1', 'RAJYA STAREYA BAL VIGYAN', 1),
(346, 'VC', 'AKHAND MAHAYOG SANSTHAN', 1),
(347, 'RSB', 'BHARGAW BOOK DEPO', 1),
(348, 'AMS', 'SHAHNI PUB', 1),
(349, 'BBD', 'ANMOL PUB', 1),
(350, 'SP]', 'LANDMARK BOOKS', 1),
(351, 'ANM', 'SAHNI BROTHERS', 1),
(352, 'LAN', 'THE STUDENT STORES', 1),
(353, 'SBR', 'WORDS WORTH CLAME', 1),
(354, 'TS1', 'WATERMILL CLAMEC', 1),
(355, 'WWE', 'PINKY BOOK DISTRIBUTORS', 1),
(356, 'WC', 'KRISHNAMURTI FOUNDATION INDIA', 1),
(357, 'PBD', 'ARCLAIBALD CONSTABLE', 1),
(358, 'KFI', 'PARICHAY OVERSEN', 1),
(359, 'AC', 'UBS PUB DISTRIBUTION', 1),
(360, 'PO', 'SURJEET PUB', 1),
(361, 'UPD', 'JAICO PUBLICATION', 1),
(362, 'SUR', 'HARPER COLLINS PUBLICATION', 1),
(363, 'JP5', 'HARCOURT BRAK & COMPANY', 1),
(364, 'HCP', 'VIKING', 1),
(365, 'HB7', 'WORDS WORTH CLANIC', 1),
(366, 'VIK', 'RADHA PUB HOUSE', 1),
(367, 'WWC', '2M PUBLICATION HOUSE', 1),
(368, 'R P', 'BLOOMSBURY', 1),
(369, '2MP', 'VIDYA BIHAR', 1),
(370, 'BL2', 'MAHESHWARI BEERCHAND MISHR', 1),
(371, 'VB', 'RAJHANSH PRAKASHAN', 1),
(372, 'MBM', 'LOKBHRATI PRAKASHAN', 1),
(373, 'RP8', 'GREMRATNEM', 1),
(374, 'LP', 'MADHUBAN PUBLI', 1),
(375, 'GRE', 'GOLDEN G PUB.', 1),
(376, 'MP5', 'DREAM LAND PUB', 1),
(377, 'GOP', 'SIKSHA BHARTI', 1),
(378, 'DL1', 'ATUL PUB', 1),
(379, 'SB5', 'UNICORN BOOKS', 1),
(380, 'ATU', 'BPB PUB', 1),
(381, 'UB', 'PRENTIS HALL OF INDIA', 1),
(382, 'BPB', 'NAVDEEP PRAKASHAN', 1),
(383, 'PHO', 'TARAN PRAKASHAN', 1),
(384, 'NAP', 'THREE STAR PUB', 1),
(385, 'TRP', 'FLAMING BOOKS', 1),
(386, 'THS', 'ARTI PUBLICATION', 1),
(387, 'FLB', 'PRACHI INDIA LTD', 1),
(388, 'ART', 'G G P', 1),
(389, 'PIL', 'POCKET BOOKS', 1),
(390, 'GGP', 'HENRY FROWDE', 1),
(391, 'POB', 'INDIAN ACADIMY OF SCIENCE', 1),
(392, 'HF', 'THE NATIONAL ACADMEY OF SCI', 1),
(393, 'ICS', 'MINISTRY OF NONCONVEN ENE SOU', 1),
(394, 'TNA', 'NELKAMAL PUBLICATION', 1),
(395, 'MON', 'SOCIETY OF LIFE SCIENCE', 1),
(396, 'NKP', 'CONSTABLE & CO', 1),
(397, 'SOL', 'GRAND RICHERDS', 1),
(398, 'C&C', 'REDFOX', 1),
(399, 'GR', 'CROST PUB HOUSE', 1),
(400, 'RED', 'TANNU BOOKS', 1),
(401, 'CP2', 'UBS PUBLICATION', 1),
(402, 'TB', 'PURNELL BOOK PREDUETION', 1),
(403, 'UBS', 'BOOK PALACE', 1),
(404, 'PB0', 'A WATERMIL CLAMIC', 1),
(405, 'BOK', 'PUNEET ENTERPRISES', 1),
(406, 'AWC', 'BLACKIE & SON', 1),
(407, 'PE5', 'A MINSTREL BOOK', 1),
(408, 'BS', 'HWARD PUB.', 1),
(409, 'AM2', 'ST MARTINS PAPER BOOK', 1),
(410, 'HWP', 'A TARGET BOOK', 1),
(411, 'SMP', 'AN ARCHWEY PAPER BOOK', 1),
(412, 'AT2', 'SUMAN PRAKASHAN', 1),
(413, 'AAP', 'LIPEK PRESS', 1),
(414, 'SP7', 'GYANPETH PAPER BOOK', 1),
(415, 'LP6', 'AKCHHAR PRAKASHAN PVT.LTD', 1),
(416, 'GP5', 'DENMAN PRAKASDHAN', 1),
(417, 'APL', 'HANS PRAKASHAN', 1),
(418, 'DP0', 'SAMYEK PRAKASHAN', 1),
(419, 'HP6', 'ARUNODYA PRAKASHAN', 1),
(420, 'SAM', 'NIDHI PRAKASHAN', 1),
(421, 'ARU', 'SUKHLAL GUPTA', 1),
(422, 'NP7', 'SADHNA POCKET BOOKS', 1),
(423, 'SG', 'PUSTAK BOOK CLUB', 1),
(424, 'SDN', 'KUMAR PRENTING PRESS', 1),
(425, 'P[B', 'BHARTIYA GYANPETH', 1),
(426, 'KPP', 'STAR PUBLICATION', 1),
(427, 'BGY', 'DIAMND POCKET BOOKS', 1),
(428, 'SPC', 'SUMAN PUBLICATION', 1),
(429, 'DP8', 'JAN PRINTING PRESS', 1),
(430, 'SU2', 'GOOD LUCK PUB', 1),
(431, 'JPP', 'FUTURE KIDS', 1),
(432, 'GOD', 'ORIENT LONGMAN', 1),
(433, 'FUT', 'VIDDYARTHI PUB', 1),
(434, 'OR1', 'FLAMINGO BOOKS', 1),
(435, 'VID', 'PEARL PUB', 1),
(436, 'FB6', 'AMBER PRAKASHAN', 1),
(437, 'PEP', 'RADICAL BOOKS', 1),
(438, 'AP5', 'TRISEA PUBLICATION', 1),
(439, 'RB7', 'KISHOR BHARTI', 1),
(440, 'TP5', 'DELHI PATHYA PUSTAK', 1),
(441, 'KIB', 'APM PUBLICATION', 1),
(442, 'DPP', 'SARASWATI PRESS', 1),
(443, 'APM', 'HAR ANAND PUBLICA', 1),
(444, 'SA8', 'APM PUB', 1),
(445, 'HA2', 'USBORNE PUBLICATION', 1),
(446, 'APP', 'BHOJPURI AKADME', 1),
(447, 'UP6', 'TULIKA PRAKASHAN', 1),
(448, 'BA', 'NAOBHARAT PRAKASHAN', 1),
(449, 'TP2', 'SAHITYA AKADME', 1),
(450, 'NBP', 'AMEDHA PRAKASHAN', 1),
(451, 'SA', 'RAJAT PRAKASHAN', 1),
(452, 'AME', 'MARUTI PRAKASHAN', 1),
(453, 'RAJ', 'POONA PRAKASHAN', 1),
(454, 'MP6', 'SATSAHITY PRAKASHAN', 1),
(455, 'PP/', 'SUMDA PRAKASHAN', 1),
(456, 'SP8', 'SHIKSHAN SANSTHAN', 1),
(457, 'SU4', 'JEEVAN JYOTI PRAKASHAN', 1),
(458, 'SKN', 'PARAMHANS PRAKASHAN', 1),
(459, 'JJP', 'KADEMBRE PRAKASHAN', 1),
(460, 'P P', 'PRAGYA PRAKASHAN', 1),
(461, 'KP8', 'BHARAT PUBLISHING', 1),
(462, 'PRG', 'SCHOLARS PUBLICATIN', 1),
(463, 'BP2', 'BHARTI PRAKASHAN', 1),
(464, 'SC5', 'CRISEAA PUB.', 1),
(465, 'BHA', 'MACKMILAN BANGLORE', 1),
(466, 'CRI', 'RACHNA SAGAR', 1),
(467, 'MAC', 'ROYAL BOOK DEPO', 1),
(468, 'RA1', 'RAMESH PUB HOUSE', 1),
(469, 'RBD', 'VIDYA PUBLICATION', 1),
(470, 'RP=', 'NEW LIGHT PRAKASHAN', 1),
(471, 'VP7', 'SECLY AND COMPANY', 1),
(472, 'NL1', 'READICAL BOOK', 1),
(473, 'SA4', 'MEGHA BOOKS', 1),
(474, 'REB', 'OCTOPUS INDIA LONDON', 1),
(475, 'MB4', 'MAHILA CHARKHA SAMITE', 1),
(476, 'OCI', 'R K EDUCATION', 1),
(477, 'MCS', 'COLLIENS', 1),
(478, 'RK1', 'SRI N SINGH', 1),
(479, 'COL', 'SAHITYIK PRAKASHAN', 1),
(480, 'SNS', 'ALLADIN PAPER BOOK', 1),
(481, 'SAP', 'INDRA PUB HOUSE', 1),
(482, 'ALD', 'EROKIDS PVT LTD', 1),
(483, 'IND', 'NAVNEET PUBLICATION', 1),
(484, 'EPL', 'KYLE CATHIE LTD LONDON', 1),
(485, 'NAV', 'PATNA [BIHAR]', 1),
(486, 'KCL', 'F.K.PUBLICATION', 1),
(487, 'PAT', 'RADICAL PUB', 1),
(488, 'FKP', 'MODERN PUB', 1),
(489, 'RAD', 'BLASSOMS VIDYA PUB', 1),
(490, 'MOD', 'MADHUBAN PUBLICATION', 1),
(491, 'BLV', 'ARROW PUB', 1),
(492, 'MAP', 'RASTOGI PUB', 1),
(493, 'ARP', 'V K CINDIEJ', 1),
(494, 'RAP', 'V K GLOBAL PUB', 1),
(495, 'VKC', 'SHAIL PRAKASHAN', 1),
(496, 'VKG', 'TEXT BOOK PATNA', 1),
(497, 'SP1', 'FLAMINGO PUBLICATION', 1),
(498, 'TEX', 'SATISH & BROTHERS', 1),
(499, 'FMP', 'AADEMS BOOKS', 1),
(500, 'S&B', 'INSPIRATION', 1);

-- --------------------------------------------------------

--
-- Table structure for table `fa_purch_data`
--

CREATE TABLE `fa_purch_data` (
  `supplier_id` int(11) NOT NULL,
  `stock_id` char(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `price` double NOT NULL DEFAULT 0,
  `suppliers_uom` char(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `conversion_factor` double NOT NULL DEFAULT 1,
  `supplier_description` char(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fa_purch_orders`
--

CREATE TABLE `fa_purch_orders` (
  `order_no` int(11) NOT NULL,
  `trans_type` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL DEFAULT 0,
  `desig_group` int(11) NOT NULL,
  `designation_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `filename` text COLLATE utf8_unicode_ci NOT NULL,
  `comments` tinytext COLLATE utf8_unicode_ci DEFAULT NULL,
  `ord_date` date NOT NULL DEFAULT '0000-00-00',
  `employee_type` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `reference` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `requisition_no` tinytext COLLATE utf8_unicode_ci DEFAULT NULL,
  `into_stock_location` varchar(5) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `delivery_address` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `total` double NOT NULL DEFAULT 0,
  `tax_included` tinyint(1) NOT NULL DEFAULT 0,
  `login_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `approved_status` int(11) NOT NULL,
  `suppliers_id` text CHARACTER SET utf8 NOT NULL,
  `enq_ref` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `quotation` int(8) NOT NULL DEFAULT 0,
  `submitorder` int(8) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fa_purch_orders`
--

INSERT INTO `fa_purch_orders` (`order_no`, `trans_type`, `supplier_id`, `desig_group`, `designation_id`, `department_id`, `employee_id`, `filename`, `comments`, `ord_date`, `employee_type`, `reference`, `requisition_no`, `into_stock_location`, `delivery_address`, `total`, `tax_included`, `login_id`, `approved_status`, `suppliers_id`, `enq_ref`, `quotation`, `submitorder`) VALUES
(1, 25, 28, 0, 0, 0, 0, '', '', '2022-04-07', '', '1', 'S-AC-129', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '28', '', 0, 0),
(2, 25, 28, 0, 0, 0, 0, '', '', '2022-07-26', '', '2', 'S-AC-130', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '28', '', 0, 0),
(10, 25, 20, 0, 0, 0, 0, '', '', '2022-12-16', '', '3', 'GAU/0221/20-21', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '20', '', 0, 0),
(11, 25, 20, 0, 0, 0, 0, '', '', '2022-12-16', '', '4', 'GAU/0221/20-21-', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '20', '', 0, 0),
(12, 25, 5, 0, 0, 0, 0, '', '', '2022-12-16', '', '5', 'ITV/1068/22-23', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '5', '', 0, 0),
(13, 25, 14, 0, 0, 0, 0, '', '', '2022-12-16', '', '6', '215-262', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '14', '', 0, 0),
(14, 25, 14, 0, 0, 0, 0, '', '', '2022-12-16', '', '7', '48', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '14', '', 0, 0),
(15, 25, 18, 0, 0, 0, 0, '', '', '2022-12-16', '', '8', '345', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '18', '', 0, 0),
(16, 25, 19, 0, 0, 0, 0, '', '', '2022-12-16', '', '9', '2355', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '19', '', 0, 0),
(17, 25, 21, 0, 0, 0, 0, '', '', '2022-12-16', '', '10', '229', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '21', '', 0, 0),
(18, 25, 14, 0, 0, 0, 0, '', '', '2022-12-16', '', '11', '167', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '14', '', 0, 0),
(19, 25, 5, 0, 0, 0, 0, '', '', '2022-12-16', '', '12', 'ITV/1854/21-22', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '5', '', 0, 0),
(20, 25, 26, 0, 0, 0, 0, '', '', '2022-12-16', '', '13', '231', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '26', '', 0, 0),
(21, 25, 26, 0, 0, 0, 0, '', '', '2022-12-16', '', '14', '71', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '26', '', 0, 0),
(22, 25, 5, 0, 0, 0, 0, '', '', '2022-12-16', '', '15', 'ITV/881/22-23', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '5', '', 0, 0),
(23, 25, 13, 0, 0, 0, 0, '', '', '2022-12-16', '', '16', 'AY01', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '13', '', 0, 0),
(24, 25, 13, 0, 0, 0, 0, '', '', '2022-12-16', '', '17', 'AY02', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '13', '', 0, 0),
(25, 25, 13, 0, 0, 0, 0, '', '', '2022-12-16', '', '18', 'AY03', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '13', '', 0, 0),
(26, 25, 25, 0, 0, 0, 0, '', '', '2022-12-16', '', '19', 'TSIN-22-23/0 50', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '25', '', 0, 0),
(27, 25, 25, 0, 0, 0, 0, '', '', '2022-12-16', '', '20', 'TSIN-22-23/0 50', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '25', '', 0, 0),
(28, 25, 27, 0, 0, 0, 0, '', '', '2022-12-16', '', '21', 'SUPF01', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '27', '', 0, 0),
(29, 25, 5, 0, 0, 0, 0, '', '', '2022-12-16', '', '22', 'ITV/1056/22-23', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '5', '', 0, 0),
(30, 25, 5, 0, 0, 0, 0, '', '', '2022-12-16', '', '23', 'ITV/1674/22-23', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '5', '', 0, 0),
(31, 25, 11, 0, 0, 0, 0, '', '', '2022-12-16', '', '24', 'MA/TI/639/22-23', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '11', '', 0, 0),
(32, 25, 11, 0, 0, 0, 0, '', '', '2022-12-16', '', '25', 'MA/TI/733/22-23', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '11', '', 0, 0),
(33, 25, 11, 0, 0, 0, 0, '', '', '2022-12-16', '', '26', 'MA/TI/1415/19-2', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '11', '', 0, 0),
(34, 25, 11, 0, 0, 0, 0, '', '', '2022-12-16', '', '27', 'MA/TI/324/21-22', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '11', '', 0, 0),
(35, 25, 11, 0, 0, 0, 0, '', '', '2022-12-16', '', '28', 'MA/TI/750/21-22', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '11', '', 0, 0),
(36, 25, 11, 0, 0, 0, 0, '', '', '2022-12-16', '', '29', 'MA/TI/737/22-23', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '11', '', 0, 0),
(37, 25, 11, 0, 0, 0, 0, '', '', '2022-12-16', '', '30', 'MA/TI/237/22-23', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '11', '', 0, 0),
(38, 25, 13, 0, 0, 0, 0, '', '', '2022-12-16', '', '31', 'AYC01', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '13', '', 0, 0),
(39, 25, 11, 0, 0, 0, 0, '', '', '2022-12-16', '', '32', 'MA/TI/240/22-23', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '11', '', 0, 0),
(40, 25, 11, 0, 0, 0, 0, '', '', '2022-12-16', '', '33', 'MA/TI/237/22-23', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '11', '', 0, 0),
(41, 25, 14, 0, 0, 0, 0, '', '', '2022-12-16', '', '34', '215', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '14', '', 0, 0),
(42, 25, 14, 0, 0, 0, 0, '', '', '2022-12-16', '', '35', '262', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '14', '', 0, 0),
(43, 25, 19, 0, 0, 0, 0, '', '', '2022-12-16', '', '36', '3193', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '19', '', 0, 0),
(44, 25, 12, 0, 0, 0, 0, '', '', '2022-12-16', '', '37', 'AMD1-25152', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '12', '', 0, 0),
(45, 25, 12, 0, 0, 0, 0, '', '', '2022-12-16', '', '38', 'BLR7-536956', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '12', '', 0, 0),
(46, 25, 12, 0, 0, 0, 0, '', '', '2022-12-16', '', '39', 'BOM5-981995', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '12', '', 0, 0),
(47, 25, 12, 0, 0, 0, 0, '', '', '2022-12-16', '', '40', 'CCU1-166', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '12', '', 0, 0),
(48, 25, 12, 0, 0, 0, 0, '', '', '2022-12-16', '', '41', 'CCU1-775873', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '12', '', 0, 0),
(49, 25, 12, 0, 0, 0, 0, '', '', '2022-12-16', '', '42', 'DEL2-1482255', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '12', '', 0, 0),
(50, 25, 12, 0, 0, 0, 0, '', '', '2022-12-16', '', '43', 'DEL4-1910588', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '12', '', 0, 0),
(51, 25, 12, 0, 0, 0, 0, '', '', '2022-12-16', '', '44', 'DEL4-303360', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '12', '', 0, 0),
(52, 25, 12, 0, 0, 0, 0, '', '', '2022-12-16', '', '45', 'DEL5-15469697', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '12', '', 0, 0),
(53, 25, 24, 0, 0, 0, 0, '', '', '2022-12-16', '', '46', 'GST-08340/21-22', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '24', '', 0, 0),
(54, 25, 24, 0, 0, 0, 0, '', '', '2022-12-16', '', '47', 'GST-09720/21-22', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '24', '', 0, 0),
(55, 25, 12, 0, 0, 0, 0, '', '', '2022-12-16', '', '48', 'HR-DEL5-1034-18', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '12', '', 0, 0),
(56, 25, 12, 0, 0, 0, 0, '', '', '2022-12-16', '', '49', 'IN-15884', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '12', '', 0, 0),
(57, 25, 12, 0, 0, 0, 0, '', '', '2022-12-16', '', '50', 'IN-SCCG-1086002', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '12', '', 0, 0),
(58, 25, 12, 0, 0, 0, 0, '', '', '2022-12-16', '', '51', 'IN-SCCG-1086004', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '12', '', 0, 0),
(59, 25, 12, 0, 0, 0, 0, '', '', '2022-12-16', '', '52', 'IN-SDEF-407', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '12', '', 0, 0),
(60, 25, 5, 0, 0, 0, 0, '', '', '2022-12-16', '', '53', 'ITV/047122-23', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '5', '', 0, 0),
(61, 25, 5, 0, 0, 0, 0, '', '', '2022-12-16', '', '54', 'ITV/076/22-23', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '5', '', 0, 0),
(62, 25, 5, 0, 0, 0, 0, '', '', '2022-12-16', '', '55', 'ITV/1223/21-22', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '5', '', 0, 0),
(63, 25, 5, 0, 0, 0, 0, '', '', '2022-12-16', '', '56', 'ITV/1223/21-22', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '5', '', 0, 0),
(64, 25, 5, 0, 0, 0, 0, '', '', '2022-12-16', '', '57', 'ITV/1233/22-23', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '5', '', 0, 0),
(65, 25, 5, 0, 0, 0, 0, '', '', '2022-12-16', '', '58', 'ITV/1237/20-21', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '5', '', 0, 0),
(66, 25, 5, 0, 0, 0, 0, '', '', '2022-12-16', '', '59', 'ITV/1334/21-22', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '5', '', 0, 0),
(67, 25, 5, 0, 0, 0, 0, '', '', '2022-12-16', '', '60', 'ITV/1533/21-22', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '5', '', 0, 0),
(68, 25, 5, 0, 0, 0, 0, '', '', '2022-12-16', '', '61', 'ITV/1543/21-22', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '5', '', 0, 0),
(69, 25, 5, 0, 0, 0, 0, '', '', '2022-12-16', '', '62', 'ITV/1572/21-22', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '5', '', 0, 0),
(70, 25, 5, 0, 0, 0, 0, '', '', '2022-12-16', '', '63', 'ITV/1585/21-22', 'PAT', '203, Lake Shore Towers\r\n', 0, 0, '', 0, '5', '', 0, 0),
(71, 25, 5, 0, 0, 0, 0, '', '', '2022-12-16', '', '64', 'ITV/1603/21-22', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '5', '', 0, 0),
(72, 25, 5, 0, 0, 0, 0, '', '', '2022-12-16', '', '65', 'ITV/1627/21-22', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '5', '', 0, 0),
(73, 25, 5, 0, 0, 0, 0, '', '', '2022-12-16', '', '66', 'ITV/1674/22-23', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '5', '', 0, 0),
(74, 25, 5, 0, 0, 0, 0, '', '', '2022-12-16', '', '67', 'ITV/1676/21-22', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '5', '', 0, 0),
(75, 25, 5, 0, 0, 0, 0, '', '', '2022-12-16', '', '68', 'ITV/1830/21-22', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '5', '', 0, 0),
(76, 25, 5, 0, 0, 0, 0, '', '', '2022-12-16', '', '69', 'ITV/1854/21-22', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '5', '', 0, 0),
(77, 25, 5, 0, 0, 0, 0, '', '', '2022-12-16', '', '70', 'ITV/1861/21-22', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '5', '', 0, 0),
(78, 25, 5, 0, 0, 0, 0, '', '', '2022-12-16', '', '71', 'ITV/2092/20-21', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '5', '', 0, 0),
(79, 25, 5, 0, 0, 0, 0, '', '', '2022-12-16', '', '72', 'ITV/2287/21-22', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '5', '', 0, 0),
(80, 25, 5, 0, 0, 0, 0, '', '', '2022-12-16', '', '73', 'ITV/2495/21-22', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '5', '', 0, 0),
(81, 25, 5, 0, 0, 0, 0, '', '', '2022-12-16', '', '74', 'ITV/254/21-22', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '5', '', 0, 0),
(82, 25, 5, 0, 0, 0, 0, '', '', '2022-12-16', '', '75', 'ITV/305/21-22', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '5', '', 0, 0),
(83, 25, 5, 0, 0, 0, 0, '', '', '2022-12-16', '', '76', 'ITV/481/21-22', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '5', '', 0, 0),
(84, 25, 5, 0, 0, 0, 0, '', '', '2022-12-16', '', '77', 'ITV/649/21-22', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '5', '', 0, 0),
(85, 25, 5, 0, 0, 0, 0, '', '', '2022-12-16', '', '78', 'ITV/775/22-23', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '5', '', 0, 0),
(86, 25, 5, 0, 0, 0, 0, '', '', '2022-12-16', '', '79', 'ITV/801/22-23', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '5', '', 0, 0),
(87, 25, 5, 0, 0, 0, 0, '', '', '2022-12-16', '', '80', 'ITV/870/22-23', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '5', '', 0, 0),
(88, 25, 5, 0, 0, 0, 0, '', '', '2022-12-16', '', '81', 'ITV/881/22-23', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '5', '', 0, 0),
(89, 25, 5, 0, 0, 0, 0, '', '', '2022-12-16', '', '82', 'ITV/924/21-22', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '5', '', 0, 0),
(90, 25, 12, 0, 0, 0, 0, '', '', '2022-12-16', '', '83', 'KA-419509905-2122\r\n', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '12', '', 0, 0),
(91, 25, 12, 0, 0, 0, 0, '', '', '2022-12-16', '', '84', 'LKO1-138483', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '12', '', 0, 0),
(92, 25, 12, 0, 0, 0, 0, '', '', '2022-12-16', '', '85', 'LKO1-1417389', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '12', '', 0, 0),
(93, 25, 12, 0, 0, 0, 0, '', '', '2022-12-16', '', '86', 'LKO1-1417436', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '12', '', 0, 0),
(94, 25, 11, 0, 0, 0, 0, '', '', '2022-12-16', '', '87', 'MA/TI/1002/20-21\r\n', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '11', '', 0, 0),
(95, 25, 11, 0, 0, 0, 0, '', '', '2022-12-16', '', '88', 'MA/TI/1131/22-23\r\n', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '11', '', 0, 0),
(96, 25, 11, 0, 0, 0, 0, '', '', '2022-12-16', '', '89', 'MA/TI/1152/19-20\r\n', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '11', '', 0, 0),
(97, 25, 11, 0, 0, 0, 0, '', '', '2022-12-16', '', '90', 'MA/TI/120/22-23', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '12', '', 0, 0),
(98, 25, 11, 0, 0, 0, 0, '', '', '2022-12-16', '', '91', 'MA/TI/1255/19-20', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '11', '', 0, 0),
(99, 25, 11, 0, 0, 0, 0, '', '', '2022-12-16', '', '92', 'MA/TI/1388/19-20', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '11', '', 0, 0),
(100, 25, 11, 0, 0, 0, 0, '', '', '2022-12-16', '', '93', 'MA/TI/1437/19-20', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '11', '', 0, 0),
(101, 25, 11, 0, 0, 0, 0, '', '', '2022-12-16', '', '94', 'MA/TI/1556/19-20', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '11', '', 0, 0),
(102, 25, 11, 0, 0, 0, 0, '', '', '2022-12-16', '', '95', 'MA/TI/1635/18-19', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '11', '', 0, 0),
(103, 25, 11, 0, 0, 0, 0, '', '', '2022-12-16', '', '96', 'MA/TI/1639/18-19', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '11', '', 0, 0),
(104, 25, 11, 0, 0, 0, 0, '', '', '2022-12-16', '', '97', 'MA/TI/1649/20-21', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '11', '', 0, 0),
(105, 25, 11, 0, 0, 0, 0, '', '', '2022-12-16', '', '98', 'MA/TI/1660/19-20', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '11', '', 0, 0),
(106, 25, 11, 0, 0, 0, 0, '', '', '2022-12-16', '', '99', 'MA/TI/1674/19-20', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '11', '', 0, 0),
(107, 25, 11, 0, 0, 0, 0, '', '', '2022-12-16', '', '100', 'MA/TI/1678/20-21', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '11', '', 0, 0),
(108, 25, 11, 0, 0, 0, 0, '', '', '2022-12-16', '', '101', 'MA/TI/1712/21-22', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '11', '', 0, 0),
(109, 25, 11, 0, 0, 0, 0, '', '', '2022-12-16', '', '102', 'MA/TI/1758/21-22', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '11', '', 0, 0),
(110, 25, 11, 0, 0, 0, 0, '', '', '2022-12-16', '', '103', 'MA/TI/1766/18-19', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '11', '', 0, 0),
(111, 25, 11, 0, 0, 0, 0, '', '', '2022-12-16', '', '104', 'MA/TI/183/22-23', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '11', '', 0, 0),
(112, 25, 11, 0, 0, 0, 0, '', '', '2022-12-16', '', '105', 'MA/TI/2202/20-21', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '11', '', 0, 0),
(113, 25, 11, 0, 0, 0, 0, '', '', '2022-12-16', '', '106', 'MA/TI/225/20-21', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '11', '', 0, 0),
(114, 25, 11, 0, 0, 0, 0, '', '', '2022-12-16', '', '107', 'MA/TI/2331/20-21', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '11', '', 0, 0),
(115, 25, 11, 0, 0, 0, 0, '', '', '2022-12-19', '', '108', 'MA/TI/240/22-23', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '11', '', 0, 0),
(116, 25, 11, 0, 0, 0, 0, '', '', '2022-12-19', '', '109', 'MA/TI/2540/20-21', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '11', '', 0, 0),
(117, 25, 11, 0, 0, 0, 0, '', '', '2022-12-19', '', '110', 'MA/TI/273/19-20', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '11', '', 0, 0),
(118, 25, 11, 0, 0, 0, 0, '', '', '2022-12-19', '', '111', 'MA/TI/311/19-20', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '11', '', 0, 0),
(119, 25, 11, 0, 0, 0, 0, '', '', '2022-12-19', '', '112', 'MA/TI/324/21-22', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '11', '', 0, 0),
(120, 25, 11, 0, 0, 0, 0, '', '', '2022-12-19', '', '113', 'MA/TI/364/20-21', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '11', '', 0, 0),
(121, 25, 11, 0, 0, 0, 0, '', '', '2022-12-19', '', '114', 'MA/TI/415/19-20', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '11', '', 0, 0),
(122, 25, 11, 0, 0, 0, 0, '', '', '2022-12-19', '', '115', 'MA/TI/460/19-20', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '11', '', 0, 0),
(123, 25, 11, 0, 0, 0, 0, '', '', '2022-12-19', '', '116', 'MA/TI/691/19-20', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '11', '', 0, 0),
(124, 25, 11, 0, 0, 0, 0, '', '', '2022-12-19', '', '117', 'MA/TI/737/22-23', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '11', '', 0, 0),
(125, 25, 11, 0, 0, 0, 0, '', '', '2022-12-19', '', '118', 'MA/TI/774/21-22', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '11', '', 0, 0),
(126, 25, 11, 0, 0, 0, 0, '', '', '2022-12-19', '', '119', 'MA/TI/799/21-22', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '11', '', 0, 0),
(127, 25, 11, 0, 0, 0, 0, '', '', '2022-12-19', '', '120', 'MA/TI/837/20-21', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '11', '', 0, 0),
(128, 25, 11, 0, 0, 0, 0, '', '', '2022-12-19', '', '121', 'MA/TI/974/19-20', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '11', '', 0, 0),
(129, 25, 12, 0, 0, 0, 0, '', '', '2022-12-19', '', '122', 'MT201819BLR9039', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '12', '', 0, 0),
(130, 25, 12, 0, 0, 0, 0, '', '', '2022-12-19', '', '123', 'QEBJ-14194', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '12', '', 0, 0),
(131, 25, 12, 0, 0, 0, 0, '', '', '2022-12-19', '', '124', 'QEBJ-15980', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '12', '', 0, 0),
(132, 25, 12, 0, 0, 0, 0, '', '', '2022-12-19', '', '125', 'QSAI-10346', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '12', '', 0, 0),
(133, 25, 12, 0, 0, 0, 0, '', '', '2022-12-19', '', '126', 'SCCC-867093', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '12', '', 0, 0),
(134, 25, 12, 0, 0, 0, 0, '', '', '2022-12-19', '', '127', 'SCCF-716488', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '12', '', 0, 0),
(135, 25, 12, 0, 0, 0, 0, '', '', '2022-12-19', '', '128', 'SCCG-387838', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '12', '', 0, 0),
(136, 25, 12, 0, 0, 0, 0, '', '', '2022-12-19', '', '129', 'SCCH-395941', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '12', '', 0, 0),
(137, 25, 12, 0, 0, 0, 0, '', '', '2022-12-19', '', '130', 'SCCH-565550', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '12', '', 0, 0),
(138, 25, 12, 0, 0, 0, 0, '', '', '2022-12-19', '', '131', 'SLKA-1129', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '12', '', 0, 0),
(139, 25, 12, 0, 0, 0, 0, '', '', '2022-12-19', '', '132', 'SLKA-580656', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '12', '', 0, 0),
(140, 25, 12, 0, 0, 0, 0, '', '', '2022-12-19', '', '133', 'SPNA-3445', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '12', '', 0, 0),
(141, 25, 5, 0, 0, 0, 0, '', '', '2022-12-19', '', '134', 'tTv /927 t20-21', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '5', '', 0, 0),
(142, 25, 12, 0, 0, 0, 0, '', '', '2022-12-19', '', '135', 'ZNKL-8705', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '12', '', 0, 0),
(143, 25, 8, 0, 0, 0, 0, '', '', '2022-12-19', '', '136', 'AIMT/2122/1738', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '8', '', 0, 0),
(144, 25, 5, 0, 0, 0, 0, '', '', '2022-12-19', '', '137', 'ITV/047122-23', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '5', '', 0, 0),
(145, 25, 5, 0, 0, 0, 0, '', '', '2022-12-19', '', '138', 'ITV/2495/21-22', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '5', '', 0, 0),
(146, 25, 5, 0, 0, 0, 0, '', '', '2022-12-19', '', '139', 'ITV/775/22-23', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '5', '', 0, 0),
(147, 25, 11, 0, 0, 0, 0, '', '', '2022-12-19', '', '140', 'MA/TI/1712/21-22', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '11', '', 0, 0),
(148, 25, 11, 0, 0, 0, 0, '', '', '2022-12-19', '', '141', 'MA/TI/1758/21-22', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '11', '', 0, 0),
(149, 25, 11, 0, 0, 0, 0, '', '', '2022-12-19', '', '142', 'MA/TI/415/19-20', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '11', '', 0, 0),
(150, 25, 2, 0, 0, 0, 0, '', '', '2022-12-19', '', '143', 'SI001', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '2', '', 0, 0),
(151, 25, 15, 0, 0, 0, 0, '', '', '2022-12-19', '', '144', '07/ 19-20', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '15', '', 0, 0),
(152, 25, 14, 0, 0, 0, 0, '', '', '2022-12-19', '', '145', '262', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '14', '', 0, 0),
(153, 25, 12, 0, 0, 0, 0, '', '', '2022-12-19', '', '146', 'DEL5-1916845', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '12', '', 0, 0),
(154, 25, 16, 0, 0, 0, 0, '', '', '2022-12-19', '', '147', 'FAAAWR2002583202', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '16', '', 0, 0),
(155, 25, 16, 0, 0, 0, 0, '', '', '2022-12-19', '', '148', 'FAC9TA2102097845', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '16', '', 0, 0),
(156, 25, 19, 0, 0, 0, 0, '', '', '2022-12-19', '', '149', '2355', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '19', '', 0, 0),
(157, 25, 12, 0, 0, 0, 0, '', '', '2022-12-19', '', '150', 'MP-1668490485-2223', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '12', '', 0, 0),
(158, 25, 11, 0, 0, 0, 0, '', '', '2022-12-19', '', '151', 'MA/TI/639/22-23', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '11', '', 0, 0),
(159, 25, 11, 0, 0, 0, 0, '', '', '2022-12-19', '', '152', 'MA/TI/733/22-23', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '11', '', 0, 0),
(160, 25, 5, 0, 0, 0, 0, '', '', '2022-12-19', '', '153', 'ITV/1068/22-23,ITV/1619/22-23', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '5', '', 0, 0),
(161, 25, 11, 0, 0, 0, 0, '', '', '2022-12-19', '', '154', 'MA/TI/1336/22-23', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '11', '', 0, 0),
(162, 25, 5, 0, 0, 0, 0, '', '', '2022-12-19', '', '155', 'ITV/1068/22-23', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '5', '', 0, 0),
(163, 25, 5, 0, 0, 0, 0, '', '', '2022-12-19', '', '156', 'ITV/1674/22-23', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '5', '', 0, 0),
(164, 25, 5, 0, 0, 0, 0, '', '', '2022-12-19', '', '157', 'ITV/881/22-23', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '5', '', 0, 0),
(165, 25, 13, 0, 0, 0, 0, '', '', '2022-12-19', '', '158', 'Ayam001', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '13', '', 0, 0),
(166, 25, 22, 0, 0, 0, 0, '', '', '2022-12-19', '', '159', 'C011890002690126', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '22', '', 0, 0),
(167, 25, 12, 0, 0, 0, 0, '', '', '2022-12-19', '', '160', 'DEL5-659301', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '12', '', 0, 0),
(168, 25, 23, 0, 0, 0, 0, '', '', '2022-12-19', '', '161', 'T0000777', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '23', '', 0, 0),
(169, 25, 12, 0, 0, 0, 0, '', '', '2022-12-19', '', '162', 'CCU1-2700464', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '12', '', 0, 0),
(170, 25, 12, 0, 0, 0, 0, '', '', '2022-12-19', '', '163', 'DL-ZNOJ-172051021-2223', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '12', '', 0, 0),
(171, 25, 24, 0, 0, 0, 0, '', '', '2022-12-19', '', '164', 'GST-10157/21-22', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '24', '', 0, 0),
(172, 25, 12, 0, 0, 0, 0, '', '', '2022-12-19', '', '165', 'IN-1', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '12', '', 0, 0),
(173, 25, 12, 0, 0, 0, 0, '', '', '2022-12-19', '', '166', 'IN-SCCH-1511984', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '12', '', 0, 0),
(174, 25, 12, 0, 0, 0, 0, '', '', '2022-12-19', '', '167', 'IN-SCCH-1549404', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '12', '', 0, 0),
(175, 25, 12, 0, 0, 0, 0, '', '', '2022-12-19', '', '168', 'IN-SCCH-1652220', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '12', '', 0, 0),
(176, 25, 5, 0, 0, 0, 0, '', '', '2022-12-19', '', '169', 'ITV/1393/21-22', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '5', '', 0, 0),
(177, 25, 5, 0, 0, 0, 0, '', '', '2022-12-19', '', '170', 'ITV/683/21-22', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '5', '', 0, 0),
(178, 25, 5, 0, 0, 0, 0, '', '', '2022-12-19', '', '171', 'ITV/977/21-22', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '5', '', 0, 0),
(179, 25, 11, 0, 0, 0, 0, '', '', '2022-12-19', '', '172', 'MA/TI/237/22-23', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '11', '', 0, 0),
(180, 25, 11, 0, 0, 0, 0, '', '', '2022-12-19', '', '173', 'MA/TI/324/21-22', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '11', '', 0, 0),
(181, 25, 17, 0, 0, 0, 0, '', '', '2022-12-19', '', '174', 'NTC/GST/3805', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '17', '', 0, 0),
(182, 25, 11, 0, 0, 0, 0, '', '', '2022-12-19', '', '175', 'AM001', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '11', '', 0, 0),
(183, 25, 11, 0, 0, 0, 0, '', '', '2022-12-19', '', '176', 'MA/TI/237/22-23', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '11', '', 0, 0),
(184, 25, 11, 0, 0, 0, 0, '', '', '2023-01-30', '', '177', '', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '11', '', 0, 0),
(185, 25, 9, 0, 0, 0, 0, '', '', '2023-01-31', '', '178', '', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '9', '', 0, 0),
(186, 25, 9, 0, 0, 0, 0, '', '', '2023-02-01', '', '179', '', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '9', '', 0, 0),
(187, 25, 9, 0, 0, 0, 0, '', '', '2023-02-01', '', '180', '', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '9', '', 0, 0),
(188, 25, 9, 0, 0, 0, 0, '', '', '2023-02-01', '', '181', '', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '9', '', 0, 0),
(189, 25, 9, 0, 0, 0, 0, '', '', '2023-02-01', '', '182', '', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '9', '', 0, 0),
(190, 25, 9, 0, 0, 0, 0, '', '', '2023-02-02', '', '183', '', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '9', '', 0, 0),
(191, 25, 5, 0, 0, 0, 0, '', '', '2023-02-02', '', '184', '', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '5', '', 0, 0),
(192, 25, 0, 0, 0, 0, 0, '', '', '2023-02-02', '', '185', '', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '', '', 0, 0),
(193, 25, 9, 0, 0, 0, 0, '', '', '2023-02-03', '', '186', '', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '9', '', 0, 0),
(194, 25, 9, 0, 0, 0, 0, '', '', '2023-02-03', '', '187', '', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '9', '', 0, 0),
(195, 25, 9, 0, 0, 0, 0, '', '', '2023-02-03', '', '188', '', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '9', '', 0, 0),
(196, 25, 9, 0, 0, 0, 0, '', '', '2023-02-03', '', '189', '', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '9', '', 0, 0),
(197, 25, 9, 0, 0, 0, 0, '', '', '2023-02-03', '', '190', '', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '9', '', 0, 0),
(198, 25, 9, 0, 0, 0, 0, '', '', '2023-02-03', '', '191', '', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '9', '', 0, 0),
(199, 25, 9, 0, 0, 0, 0, '', '', '2023-02-03', '', '192', '', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '9', '', 0, 0),
(200, 25, 9, 0, 0, 0, 0, '', '', '2023-02-03', '', '193', '', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '9', '', 0, 0),
(201, 25, 9, 0, 0, 0, 0, '', '', '2023-02-03', '', '194', '', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '9', '', 0, 0),
(202, 25, 9, 0, 0, 0, 0, '', '', '2023-02-06', '', '195', '', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '9', '', 0, 0),
(203, 25, 9, 0, 0, 0, 0, '', '', '2023-02-06', '', '196', '', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '9', '', 0, 0),
(204, 25, 9, 0, 0, 0, 0, '', '', '2023-02-06', '', '197', '', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '9', '', 0, 0),
(205, 25, 9, 0, 0, 0, 0, '', '', '2023-02-06', '', '198', '', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '9', '', 0, 0),
(206, 25, 9, 0, 0, 0, 0, '', '', '2023-02-06', '', '199', '', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '9', '', 0, 0),
(207, 25, 9, 0, 0, 0, 0, '', '', '2023-02-06', '', '200', '', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '9', '', 0, 0),
(208, 25, 9, 0, 0, 0, 0, '', '', '2023-02-06', '', '201', '', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '9', '', 0, 0),
(209, 25, 9, 0, 0, 0, 0, '', '', '2023-02-06', '', '202', '', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '9', '', 0, 0),
(210, 25, 9, 0, 0, 0, 0, '', '', '2023-02-06', '', '203', '', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '9', '', 0, 0),
(211, 25, 9, 0, 0, 0, 0, '', '', '2023-02-06', '', '204', '', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '9', '', 0, 0),
(212, 25, 9, 0, 0, 0, 0, '', '', '2023-02-06', '', '205', '', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '9', '', 0, 0),
(213, 25, 9, 0, 0, 0, 0, '', '', '2023-02-06', '', '206', '', 'HYD', '203, Lake Shore Towers\r\n', 0, 0, '', 0, '9', '', 0, 0),
(214, 25, 9, 0, 0, 0, 0, '', '', '2023-02-06', '', '207', '', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '9', '', 0, 0),
(215, 25, 9, 0, 0, 0, 0, '', '', '2023-02-06', '', '208', '', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '9', '', 0, 0),
(216, 25, 9, 0, 0, 0, 0, '', '', '2023-02-06', '', '209', '', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '9', '', 0, 0),
(217, 25, 9, 0, 0, 0, 0, '', '', '2023-02-06', '', '210', '', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '9', '', 0, 0),
(218, 25, 9, 0, 0, 0, 0, '', '', '2023-02-06', '', '211', '', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '9', '', 0, 0),
(219, 25, 9, 0, 0, 0, 0, '', '', '2023-02-06', '', '212', '', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '9', '', 0, 0),
(220, 25, 9, 0, 0, 0, 0, '', '', '2023-02-06', '', '213', '', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '9', '', 0, 0),
(221, 25, 9, 0, 0, 0, 0, '', '', '2023-02-06', '', '214', '', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '9', '', 0, 0),
(222, 25, 9, 0, 0, 0, 0, '', '', '2023-02-06', '', '215', '', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '9', '', 0, 0),
(223, 25, 9, 0, 0, 0, 0, '', '', '2023-02-06', '', '216', '', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '9', '', 0, 0),
(224, 25, 9, 0, 0, 0, 0, '', '', '2023-02-07', '', '217', '', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '9', '', 0, 0),
(225, 25, 9, 0, 0, 0, 0, '', '', '2023-02-07', '', '218', '', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '9', '', 0, 0),
(226, 25, 9, 0, 0, 0, 0, '', '', '2023-02-07', '', '219', '', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '9', '', 0, 0),
(227, 25, 9, 0, 0, 0, 0, '', '', '2023-02-07', '', '220', '', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '9', '', 0, 0),
(228, 25, 9, 0, 0, 0, 0, '', '', '2023-02-07', '', '221', '', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '9', '', 0, 0),
(229, 25, 5, 0, 0, 0, 0, '', '', '2023-02-07', '', '222', '', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '5', '', 0, 0),
(230, 25, 9, 0, 0, 0, 0, '', '', '2023-02-07', '', '223', '', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '9', '', 0, 0),
(231, 25, 9, 0, 0, 0, 0, '', '', '2023-02-07', '', '224', '', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '9', '', 0, 0),
(232, 25, 9, 0, 0, 0, 0, '', '', '2023-02-07', '', '225', '', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '9', '', 0, 0),
(233, 25, 9, 0, 0, 0, 0, '', '', '2023-02-07', '', '226', '', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '9', '', 0, 0),
(234, 25, 9, 0, 0, 0, 0, '', '', '2023-02-07', '', '227', '', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '9', '', 0, 0),
(235, 25, 9, 0, 0, 0, 0, '', '', '2023-02-07', '', '228', '', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '9', '', 0, 0),
(236, 25, 9, 0, 0, 0, 0, '', '', '2023-02-07', '', '229', '', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '9', '', 0, 0),
(237, 25, 9, 0, 0, 0, 0, '', '', '2023-02-07', '', '230', '', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '9', '', 0, 0),
(238, 25, 9, 0, 0, 0, 0, '', '', '2023-02-07', '', '231', '', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '9', '', 0, 0),
(239, 25, 9, 0, 0, 0, 0, '', '', '2023-02-07', '', '232', '', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '9', '', 0, 0),
(240, 25, 9, 0, 0, 0, 0, '', '', '2023-02-07', '', '233', '', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '9', '', 0, 0),
(241, 25, 9, 0, 0, 0, 0, '', '', '2023-02-07', '', '234', '', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '9', '', 0, 0),
(242, 25, 9, 0, 0, 0, 0, '', '', '2023-02-07', '', '235', '', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '9', '', 0, 0),
(243, 25, 9, 0, 0, 0, 0, '', '', '2023-02-07', '', '236', '', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '9', '', 0, 0),
(244, 25, 9, 0, 0, 0, 0, '', '', '2023-02-07', '', '237', '', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '9', '', 0, 0),
(245, 25, 9, 0, 0, 0, 0, '', '', '2023-02-07', '', '238', '', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '9', '', 0, 0),
(246, 25, 9, 0, 0, 0, 0, '', '', '2023-02-07', '', '239', '', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '9', '', 0, 0),
(247, 25, 9, 0, 0, 0, 0, '', '', '2023-02-07', '', '240', '', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '9', '', 0, 0),
(248, 25, 9, 0, 0, 0, 0, '', '', '2023-02-07', '', '241', '', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '9', '', 0, 0),
(249, 25, 9, 0, 0, 0, 0, '', '', '2023-02-07', '', '242', '', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '9', '', 0, 0),
(250, 25, 9, 0, 0, 0, 0, '', '', '2023-02-07', '', '243', '', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '9', '', 0, 0),
(251, 25, 9, 0, 0, 0, 0, '', '', '2023-02-07', '', '244', '', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '9', '', 0, 0),
(252, 25, 9, 0, 0, 0, 0, '', '', '2023-02-07', '', '245', '', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '9', '', 0, 0),
(253, 25, 9, 0, 0, 0, 0, '', '', '2023-02-07', '', '246', '', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '9', '', 0, 0),
(254, 25, 9, 0, 0, 0, 0, '', '', '2023-02-07', '', '247', '', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '9', '', 0, 0),
(255, 25, 0, 0, 0, 0, 0, '', '', '2023-02-07', '', '248', '', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '9', '', 0, 0),
(256, 25, 9, 0, 0, 0, 0, '', '', '2023-02-07', '', '249', '', 'PAT', '1', 0, 0, '', 0, '9', '', 0, 0),
(257, 25, 9, 0, 0, 0, 0, '', '', '2023-02-07', '', '250', '', 'PAT', '1', 0, 0, '', 0, '9', '', 0, 0),
(258, 25, 9, 0, 0, 0, 0, '', '', '2023-02-07', '', '251', '', 'PAT', '1', 0, 0, '', 0, '9', '', 0, 0),
(259, 25, 9, 0, 0, 0, 0, '', '', '2023-02-07', '', '252', '', 'PAT', '1', 0, 0, '', 0, '9', '', 0, 0),
(260, 25, 9, 0, 0, 0, 0, '', '', '2023-02-07', '', '253', '', 'PAT', '1', 0, 0, '', 0, '9', '', 0, 0),
(261, 25, 9, 0, 0, 0, 0, '', '', '2023-02-07', '', '254', '', 'PAT', '1', 0, 0, '', 0, '9', '', 0, 0),
(262, 25, 9, 0, 0, 0, 0, '', '', '2023-02-07', '', '255', '', 'PAT', '1', 0, 0, '', 0, '9', '', 0, 0),
(263, 25, 9, 0, 0, 0, 0, '', '', '2023-02-07', '', '256', '', 'PAT', '1', 0, 0, '', 0, '9', '', 0, 0),
(264, 25, 9, 0, 0, 0, 0, '', '', '2023-02-07', '', '257', '', 'PAT', '1', 0, 0, '', 0, '9', '', 0, 0),
(265, 25, 9, 0, 0, 0, 0, '', '', '2023-02-07', '', '258', '', 'PAT', '1', 0, 0, '', 0, '9', '', 0, 0),
(266, 25, 9, 0, 0, 0, 0, '', '', '2023-02-07', '', '259', '', 'PAT', '1', 0, 0, '', 0, '9', '', 0, 0),
(267, 25, 9, 0, 0, 0, 0, '', '', '2023-02-07', '', '260', '', 'PAT', '1', 0, 0, '', 0, '9', '', 0, 0),
(268, 25, 9, 0, 0, 0, 0, '', '', '2023-02-07', '', '261', '', 'PAT', '1', 0, 0, '', 0, '9', '', 0, 0),
(269, 25, 9, 0, 0, 0, 0, '', '', '2023-02-07', '', '262', '', 'PAT', '1', 0, 0, '', 0, '9', '', 0, 0),
(270, 25, 9, 0, 0, 0, 0, '', '', '2023-02-07', '', '263', '', 'PAT', '1', 0, 0, '', 0, '9', '', 0, 0),
(271, 25, 9, 0, 0, 0, 0, '', '', '2023-02-07', '', '264', '', 'PAT', '1', 0, 0, '', 0, '9', '', 0, 0),
(272, 25, 9, 0, 0, 0, 0, '', '', '2023-02-07', '', '265', '', 'HYD', '2', 0, 0, '', 0, '9', '', 0, 0),
(273, 25, 9, 0, 0, 0, 0, '', '', '2023-02-07', '', '266', '', 'PAT', '1', 0, 0, '', 0, '9', '', 0, 0),
(274, 25, 9, 0, 0, 0, 0, '', '', '2023-02-07', '', '267', '', 'PAT', '1', 0, 0, '', 0, '9', '', 0, 0),
(275, 25, 9, 0, 0, 0, 0, '', '', '2023-02-07', '', '268', '', 'PAT', '1', 0, 0, '', 0, '9', '', 0, 0),
(276, 25, 9, 0, 0, 0, 0, '', '', '2023-02-07', '', '269', '', 'PAT', '1', 0, 0, '', 0, '9', '', 0, 0),
(277, 25, 9, 0, 0, 0, 0, '', '', '2023-02-07', '', '270', '', 'PAT', '1', 0, 0, '', 0, '9', '', 0, 0),
(278, 25, 9, 0, 0, 0, 0, '', '', '2023-02-07', '', '271', '', 'PAT', '1', 0, 0, '', 0, '9', '', 0, 0),
(279, 25, 9, 0, 0, 0, 0, '', '', '2023-02-07', '', '272', '', 'PAT', '1', 0, 0, '', 0, '9', '', 0, 0),
(280, 25, 9, 0, 0, 0, 0, '', '', '2023-02-07', '', '273', '', 'PAT', '1', 0, 0, '', 0, '9', '', 0, 0),
(281, 25, 9, 0, 0, 0, 0, '', '', '2023-02-07', '', '274', '', 'PAT', '1', 0, 0, '', 0, '9', '', 0, 0),
(282, 25, 9, 0, 0, 0, 0, '', '', '2023-02-07', '', '275', '', 'PAT', '1', 0, 0, '', 0, '9', '', 0, 0),
(283, 25, 9, 0, 0, 0, 0, '', '', '2023-02-07', '', '276', '', 'PAT', '1', 0, 0, '', 0, '9', '', 0, 0),
(284, 25, 9, 0, 0, 0, 0, '', '', '2023-02-07', '', '277', '', 'PAT', '1', 0, 0, '', 0, '9', '', 0, 0),
(285, 25, 9, 0, 0, 0, 0, '', '', '2023-02-07', '', '278', '', 'PAT', '1', 0, 0, '', 0, '9', '', 0, 0),
(286, 25, 9, 0, 0, 0, 0, '', '', '2023-02-07', '', '279', '', 'PAT', '1', 0, 0, '', 0, '9', '', 0, 0),
(287, 25, 0, 0, 0, 0, 0, '', '', '2023-02-07', '', '280', '', 'PAT', '1', 0, 0, '', 0, '', '', 0, 0),
(288, 25, 9, 0, 0, 0, 0, '', '', '2023-02-07', '', '281', '', 'PAT', '1', 0, 0, '', 0, '9', '', 0, 0),
(289, 25, 9, 0, 0, 0, 0, '', '', '2023-02-07', '', '282', '', 'PAT', '1', 0, 0, '', 0, '9', '', 0, 0),
(290, 25, 9, 0, 0, 0, 0, '', '', '2023-02-07', '', '283', '', 'PAT', '1', 0, 0, '', 0, '9', '', 0, 0),
(291, 25, 9, 0, 0, 0, 0, '', '', '2023-02-07', '', '284', '', 'PAT', '1', 0, 0, '', 0, '9', '', 0, 0),
(292, 25, 9, 0, 0, 0, 0, '', '', '2023-02-07', '', '285', '', 'PAT', '1', 0, 0, '', 0, '9', '', 0, 0),
(293, 25, 9, 0, 0, 0, 0, '', '', '2023-02-07', '', '286', '', 'PAT', '1', 0, 0, '', 0, '9', '', 0, 0),
(294, 25, 9, 0, 0, 0, 0, '', '', '2023-02-07', '', '287', '', 'PAT', '1', 0, 0, '', 0, '9', '', 0, 0),
(295, 25, 9, 0, 0, 0, 0, '', '', '2023-02-07', '', '288', '', 'PAT', '1', 0, 0, '', 0, '9', '', 0, 0),
(296, 25, 9, 0, 0, 0, 0, '', '', '2023-02-07', '', '289', '', 'PAT', '1', 0, 0, '', 0, '9', '', 0, 0),
(297, 25, 9, 0, 0, 0, 0, '', '', '2023-02-07', '', '290', '', 'PAT', '1', 0, 0, '', 0, '9', '', 0, 0),
(298, 25, 9, 0, 0, 0, 0, '', '', '2023-02-07', '', '291', '', 'PAT', '1', 0, 0, '', 0, '9', '', 0, 0),
(299, 25, 9, 0, 0, 0, 0, '', '', '2023-02-07', '', '292', '', 'PAT', '1', 0, 0, '', 0, '9', '', 0, 0),
(300, 25, 9, 0, 0, 0, 0, '', '', '2023-02-07', '', '293', '', 'PAT', '1', 0, 0, '', 0, '9', '', 0, 0),
(301, 25, 9, 0, 0, 0, 0, '', '', '2023-02-07', '', '294', '', 'PAT', '1', 0, 0, '', 0, '9', '', 0, 0),
(302, 25, 9, 0, 0, 0, 0, '', '', '2023-02-07', '', '295', '', 'PAT', '1', 0, 0, '', 0, '9', '', 0, 0),
(303, 25, 9, 0, 0, 0, 0, '', '', '2023-02-07', '', '296', '', 'PAT', '1', 0, 0, '', 0, '9', '', 0, 0),
(304, 25, 5, 0, 0, 0, 0, '', '', '2023-02-08', '', '297', '', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '5', '', 0, 0),
(305, 25, 5, 0, 0, 0, 0, '', '', '2023-02-08', '', '298', '', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '5', '', 0, 0),
(306, 25, 9, 0, 0, 0, 0, '', '', '2023-02-08', '', '299', '', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '9', '', 0, 0),
(307, 25, 9, 0, 0, 0, 0, '', '', '2023-02-08', '', '300', '', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '9', '', 0, 0),
(308, 25, 5, 0, 0, 0, 0, '', '', '2023-02-09', '', '301', '', 'PAT', '258 Nehru Nagar Patna 800013', 0, 0, '', 0, '5', '', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `fa_purch_order_details`
--

CREATE TABLE `fa_purch_order_details` (
  `po_detail_item` int(11) NOT NULL,
  `order_no` int(11) NOT NULL DEFAULT 0,
  `item_code` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `description` tinytext COLLATE utf8_unicode_ci DEFAULT NULL,
  `delivery_date` date NOT NULL DEFAULT '0000-00-00',
  `qty_invoiced` double NOT NULL DEFAULT 0,
  `unit_price` double NOT NULL DEFAULT 0,
  `act_price` double NOT NULL DEFAULT 0,
  `std_cost_unit` double NOT NULL DEFAULT 0,
  `quantity_ordered` double NOT NULL DEFAULT 0,
  `quantity_received` double NOT NULL DEFAULT 0,
  `trans_type` int(11) NOT NULL,
  `gst` float NOT NULL,
  `cst` float NOT NULL,
  `ist` float NOT NULL,
  `gst_amt` double NOT NULL,
  `cst_amt` double NOT NULL,
  `ist_amt` double NOT NULL,
  `hsn_no` int(11) NOT NULL,
  `currency` int(11) NOT NULL,
  `pro_type` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'PO'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fa_purch_order_details`
--

INSERT INTO `fa_purch_order_details` (`po_detail_item`, `order_no`, `item_code`, `description`, `delivery_date`, `qty_invoiced`, `unit_price`, `act_price`, `std_cost_unit`, `quantity_ordered`, `quantity_received`, `trans_type`, `gst`, `cst`, `ist`, `gst_amt`, `cst_amt`, `ist_amt`, `hsn_no`, `currency`, `pro_type`) VALUES
(1, 1, 'AC-STAR-EMP-SPLIT', 'Star Emperiya CX SPLIT AC', '2022-04-07', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(2, 2, 'AC-SUM-AA128Y4ZAPGNN', 'Samsung Ac (AA128Y4ZAPGNNA)', '2022-07-26', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(32, 10, 'L-BAG-LP-BLUE', 'Bag (HS.CANVOBNP L P 01 Blue)', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(33, 11, 'L-BAG-LP-GRAY', 'Bag (HS.CANVOBNP L P 01 Gray)', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(34, 12, 'L-BAG-HP', 'Laptop Bag for Hp Pavillion ', '2022-12-16', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(35, 13, 'BAT-42AH-E', 'Exide 24 Nos Battery ( 42 AH )', '2022-12-16', 0, 0, 0, 0, 26, 26, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(36, 14, 'BAT-EP65-12-E', 'EXIDE EP 65-12 BATTERY', '2022-12-16', 0, 0, 0, 0, 16, 16, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(37, 15, 'BAT-LAP-HPOA04', 'Lap care battery (HPOA04)', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(38, 16, 'BAT-LAP-INEX', 'Dell inspiron laptop battery (Lapkit inex)', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(39, 17, 'BAT-150AH-T-E', 'Exide inva tall tublar battery  150 AH , 12 V (FEMO-IMTT1500)', '2022-12-16', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(40, 18, 'BAT-65AH-E', 'Development Floor Ups 16 Battery (Exide 65 Ah Powersafe Plus) 2 Year Warranty ', '2022-12-16', 0, 0, 0, 0, 16, 16, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(41, 19, 'BAT-LAP-OA04', 'Lapcare Compatible battery ( OA04)', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(42, 20, 'BAT-UPS-HB1875', '                     MICROTEK SINE WAVE INVERTER UPS HB1875', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(43, 21, 'BAT-150AH-T-E', 'Exide inva tall tublar battery  150 AH , 12 V (FEMO-IMTT1500)', '2022-12-16', 0, 0, 0, 0, 4, 4, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(44, 22, 'BAT-LAP-LAOBT6C2196', 'Laptop Battery for Acer Laptop (LAOBT6C2196)', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(45, 23, 'ESSL-AM-X990', 'Attandance Machine Essl  (Model no :-  X990 + ID)', '2022-12-16', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(46, 24, 'ESSL-FR1200 ', 'Fingure Reaer Essl ( Modal no :- FR1200 , RS 485 )', '2022-12-16', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(47, 25, 'BIOCARD', 'Biometric Card Access ', '2022-12-16', 0, 0, 0, 0, 6, 6, 25, 0, 0, 0, 0, 0, 0, 5248, 0, 'PO'),
(48, 26, 'ESSL-AM-X990', 'Attandance Machine Essl  (Model no :-  X990 + ID)', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(49, 27, 'ESSL-FR1200 ', 'Fingure Reaer Essl ( Modal no :- FR1200 , RS 485 )', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(50, 28, 'CAB-POWER', 'Laptop power cable ( Dell )', '2022-12-16', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(51, 29, 'CAB-HDMI', 'MERCURY HDMI CABLE 20 MTR', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(52, 30, 'CAB-POWER', 'Laptop power cable ( Dell )', '2022-12-16', 0, 0, 0, 0, 5, 5, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(53, 31, 'L-BAG-LENOVO', 'Lenovo Bagpack ', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(54, 32, 'L-BAG-HP', 'Laptop Bag for Hp Pavillion ', '2022-12-16', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(55, 33, 'BAT-LAP-B', 'Laptop Battery For Bimlesh ', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(56, 34, 'BAT-LAP-N4010', 'Dell laptop Battery(DELL Inspiron 14R(N4010) 6 Cell Laptop Battery)', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(57, 35, 'BAT-MICRO-L', 'Micro Lithium ion Battery  ', '2022-12-16', 0, 0, 0, 0, 10, 10, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(58, 36, 'BAT-LAP-TC-3817U', 'Laptop Battery for standby laptop Thoshiba ( Modal no :- TC-3817U', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(59, 37, 'CAB-HDMI', 'MERCURY HDMI CABLE 20 MTR', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(60, 38, 'DS-2CE1AC0T-IRPF', 'Hikvision Bullet camera ( Modal no :- DS-2CE1AC0T-IRPF = 1 Mp ) ', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 2324, 0, 'PO'),
(61, 39, 'DS-2CD1323G0E-I ', 'Hikvision Dome Camera Moadl no :- ( DS-2CD1323G0E-I )', '2022-12-16', 0, 0, 0, 0, 24, 24, 25, 0, 0, 0, 0, 0, 0, 2324, 0, 'PO'),
(62, 40, 'DS-2CD2023G2-IU', 'Hikvision Bullet Camea:- Modal no :- ( DS-2CD2023G2-IU )', '2022-12-16', 0, 0, 0, 0, 3, 3, 25, 0, 0, 0, 0, 0, 0, 2324, 0, 'PO'),
(63, 41, 'UPS-10-KVA', 'ON LINE UPS ( I -Max 10 KVA/192 V )', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(64, 42, 'UPS-10-KVA', 'ON LINE UPS ( I -Max 10 KVA/192 V )', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(65, 43, 'KEYBOARD', 'Dell vostro 2520 Keyboard (Newtrix)', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(66, 44, 'HDMI-CONVERTER', 'Display port to Feamle HDMI converter ', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(67, 45, 'USB-PENDRIVE-64GB', 'SanDisk Ultra 64 GB USB Pen Drives (SDDDC2-064G-I35, Black, Silver) | B01EZ0X3L8 ', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(68, 45, 'HDD-SATA-2TB', 'Samsung 870 EVO  - 2TB SATA SSD (MZ-77E2T0)', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(69, 46, 'ADAP-WIRELESS-T2U', 'Tp-Link Nano usb wireless adaptor (archer t2u nano us ver 1.0)', '2022-12-16', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 525416, 0, 'PO'),
(70, 47, 'ADAP-CONVERTER-TC', 'Type C to USB Converter Adaptor ', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 525416, 0, 'PO'),
(71, 48, 'ADAP-NT-UE300C-TC', 'Type C to RJ45 Gigabit Network Adapter (Model :- UE300C(UN)', '2022-12-16', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 525416, 0, 'PO'),
(72, 48, 'ADAP-NT-UE300C-USB3', 'USB 3.0 to Gigabyte Etherney Adapter (Model :- UE300C(UN)', '2022-12-16', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 525416, 0, 'PO'),
(73, 48, 'USB-PORT-HUB4', 'USB 3.1 Gen:1    4 Port Hub (  QZ-HB03)', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(74, 48, 'ADAP-USB-T3-QZ-AD11', 'USB 3.1 Type C to Type a Converter (QZ AD11)', '2022-12-16', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 525416, 0, 'PO'),
(75, 49, 'MON-GW2480-T-24', 'BenQ GW2480 24-inch', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(76, 50, 'MON-24MK600M-24', 'Lg 24MK600M 24&quot;', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(77, 51, 'MON-GW2480-T-24', 'Benq Monitor 24&quot; (GW2480-B)', '2022-12-16', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(78, 52, 'PRECISION-110', 'Screwdriver 110 in 1 set Precision ', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(79, 53, 'CAB-FING-SMPS', 'Fingures Cabinet with SMPS ', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 21235, 0, 'PO'),
(80, 53, 'CPU-I5-10400', 'CPU i5 2.9 Ghz ( 10400)', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(81, 53, 'MTB-B460M-DS3H-AC', 'Gigabyte MBD ( B460M DS3H AC )', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(82, 53, 'RAM-DDR4-16GB', '16 GB 3000 Mhz DDR4 CORSIAR VEN RAM', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(83, 53, 'HDD-SSD-500GB', 'SSD  SAMSUNG 98O EVO NVME 5OOGB ( MZ-V8V500BW )', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(84, 53, 'HDD-HDD-1TB', 'HDD Segate 1 TB Barracudda ', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(85, 53, 'MON-E2421HN-24', 'MONITOR DELL 24 Modal No :- (E2421HN) WITH VGA+HDMI', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(86, 54, 'HDD-SSD-500GB', 'SSD  SAMSUNG 98O EVO NVME 5OOGB ( MZ-V8V500BW )', '2022-12-16', 0, 0, 0, 0, 6, 6, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(87, 55, 'HEADPHONE-G231', 'Logitech gaming headphone G231 prodigy ', '2022-12-16', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(88, 56, 'USB-SOUND', 'Usb sound card ', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(89, 57, 'MON-GW2480-T-24', 'BenQ GW2480 24-inch', '2022-12-16', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(90, 58, 'MON-GW2480-T-24', 'BenQ GW2480 24-inch', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(91, 59, 'M-PHONE-BY-M1', 'Boya ( BY-M1) Microphone ', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(92, 60, 'RAM-DDR4-16GB', '16 GB 3000 Mhz DDR4 CORSIAR VEN RAM', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(93, 61, 'HDD-SSD-500GB', 'SSD  SAMSUNG 98O EVO NVME 5OOGB ( MZ-V8V500BW )', '2022-12-16', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(94, 62, 'CPU-I5-10400', 'CPU i5 2.9 Ghz ( 10400)', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(95, 63, 'MTB-H470M-DS3H', 'Gigabyte Motherboard Modal No :- (H470M DS3H)', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(96, 63, 'RAM-DDR4-16GB', '16 GB 3000 Mhz DDR4 CORSIAR VEN RAM', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(97, 63, 'HDD-SSD-500GB', 'SSD  SAMSUNG 98O EVO NVME 5OOGB ( MZ-V8V500BW )', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(98, 63, 'HDD-HDD-1TB', 'HDD Segate 1 TB Barracudda ', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(99, 63, 'CAB-FING-SMPS', 'Fingures Cabinet with SMPS ', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 21235, 0, 'PO'),
(100, 63, 'HDD-SSD-480GB', 'WD Green 480 GB SSD ', '2022-12-16', 0, 0, 0, 0, 5, 5, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(101, 64, 'MOUSE-WIRELESS', 'Logitech MK275 Wireless Keyboard &amp; Mouse ', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(102, 64, 'HEADPHONE-G340', 'Ligitech H340 usb headphone ', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(103, 65, 'CAB-CORSIAR', 'Corsiar Cabinet', '2022-12-16', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 21235, 0, 'PO'),
(104, 65, 'RAM-DDR4-16GB', '16 GB 3000 Mhz DDR4 CORSIAR VEN RAM', '2022-12-16', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(105, 65, 'CPU-I5-10400', 'CPU i5 2.9 Ghz ( 10400)', '2022-12-16', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(106, 65, 'HDD-500GB', 'NVME Kingston 500 GB ', '2022-12-16', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(107, 65, 'HDD-HDD-1TB', 'HDD Segate 1 TB Barracudda ', '2022-12-16', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(108, 65, 'MTB-Z490', 'Gigabyte Z490 Mtb', '2022-12-16', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(109, 65, 'HDD-SSD-480GB', 'WD Green 480 GB SSD ', '2022-12-16', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(110, 65, 'SMPS-CORSIAR-450', 'Corsiar 450 Watt smps ', '2022-12-16', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(111, 66, 'SMPS-F-P-400', 'Finger&#039;s Polonium-400', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(112, 66, 'SMPS-F-G-12-407', 'SMPS Fingers gama-12-407', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(113, 66, 'MON-FRONTECH', 'Frontech', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(114, 67, 'HDD-SSD-500GB', 'SSD  SAMSUNG 98O EVO NVME 5OOGB ( MZ-V8V500BW )', '2022-12-16', 0, 0, 0, 0, 5, 5, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(115, 68, 'SMPS-F-G-401', 'SMPS Finger&#039;s Gamma-401 ', '2022-12-16', 0, 0, 0, 0, 5, 5, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(116, 69, 'CPU-I3-10105', 'Cpu core i3-10105 3.7 GHZ 6 MB Cache ', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(117, 69, 'MTB-B460M-DS3H-V2', 'Gigabyte B460M DS3H V2', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(118, 69, 'RAM-DDR4-8GB', 'Corsiar DDR 4 RAM 8 GB 3000 Mhz', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(119, 69, 'HDD-500GB', 'NVME Kingston 500 GB ', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(120, 70, 'CPU-I3-10105', 'Cpu core i3-10105 3.7 GHZ 6 MB Cache ', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(121, 70, 'MTB-B460M-DS3H-V2', 'Gigabyte B460M DS3H V2', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(122, 70, 'RAM-DDR4-8GB', 'Corsiar DDR 4 RAM 8 GB 3000 Mhz', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(123, 70, 'HDD-500GB', 'NVME Kingston 500 GB ', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(124, 70, 'MON-22MP68VQ-22', 'Lg 22&quot; ips monitor modal no :- 22MP68VQ', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(125, 70, 'CAB-FING-SMPS', 'Fingures Cabinet with SMPS ', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 21235, 0, 'PO'),
(126, 71, 'CPU-I3-10105', 'Cpu core i3-10105 3.7 GHZ 6 MB Cache ', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(127, 71, 'RAM-DDR4-8GB', 'Corsiar DDR 4 RAM 8 GB 3000 Mhz', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(128, 71, 'HDD-500GB', 'NVME Kingston 500 GB ', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(129, 71, 'MTB-B460M-DS3H-V2', 'Gigabyte B460M DS3H V2', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(130, 71, 'MON-22MP68VQ-22', 'Lg 22&quot; ips monitor modal no :- 22MP68VQ', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(131, 71, 'CAB-FING-SMPS', 'Fingures Cabinet with SMPS ', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 21235, 0, 'PO'),
(132, 72, 'CPU-I3-10105', 'Cpu core i3-10105 3.7 GHZ 6 MB Cache ', '2022-12-16', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(133, 72, 'MTB-H470M-DS3H', 'Gigabyte Motherboard Modal No :- (H470M DS3H)', '2022-12-16', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(134, 72, 'RAM-DDR4-8GB', 'Corsiar DDR 4 RAM 8 GB 3000 Mhz', '2022-12-16', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(135, 72, 'HDD-500GB', 'NVME Kingston 500 GB ', '2022-12-16', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(136, 72, 'CAB-FING-SMPS', 'Fingures Cabinet with SMPS ', '2022-12-16', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 21235, 0, 'PO'),
(137, 73, 'MOUSE-PAD', 'Mouse pad', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(138, 73, 'HEADPHONE-F5', 'Finger&#039;s F5 Single jack headphone (Showstopper)', '2022-12-16', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(139, 74, 'SMPS-FA-C3', 'Cabinet Finger&#039;s Ascend c3 with SMPS ', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(140, 74, 'CPU-I5-10400', 'CPU i5 2.9 Ghz ( 10400)', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(141, 74, 'MTB-B56OM-DS3H-AC', 'Motherboard Gigabyte  Modal No :-(B56OM-DS3H:AC) ', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(142, 74, 'RAM-DDR4-16GB', '16 GB 3000 Mhz DDR4 CORSIAR VEN RAM', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(143, 74, 'HDD-SSD-500GB', 'SSD  SAMSUNG 98O EVO NVME 5OOGB ( MZ-V8V500BW )', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(144, 74, 'HDD-HDD-1TB', 'HDD Segate 1 TB Barracudda ', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(145, 74, 'MON-S2421HN-24', 'Monitor dell 24&quot; Modal No: ( S2421HN )', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(146, 75, 'RAM-DDR4-16GB', '16 GB 3000 Mhz DDR4 CORSIAR VEN RAM', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(147, 75, 'HDD-SSD-500GB', 'SSD  SAMSUNG 98O EVO NVME 5OOGB ( MZ-V8V500BW )', '2022-12-16', 0, 0, 0, 0, 5, 5, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(148, 76, 'HDD-SSD-500GB', 'SSD  SAMSUNG 98O EVO NVME 5OOGB ( MZ-V8V500BW )', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(149, 77, 'MON-22MP68VQ-22', 'Lg 22&quot; ips monitor modal no :- 22MP68VQ', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(150, 78, 'MTB-H110', 'Gigabyte H110 M/b', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(151, 78, 'MON-22MP68VQ-22', 'Lg 22&quot; ips monitor modal no :- 22MP68VQ', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(152, 79, 'HEADPHONE-H5', 'Finger&#039;s show stoper H5', '2022-12-16', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(153, 80, 'CAB-FING-SMPS', 'Fingures Cabinet with SMPS ', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 21235, 0, 'PO'),
(154, 80, 'MTB- B560M-AE', ' Motherboard (Gigabyte B560M Aorus Elite) ', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(155, 80, 'RAM-DDR4-16GB', '16 GB 3000 Mhz DDR4 CORSIAR VEN RAM', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(156, 80, 'HDD-SSD-500GB', 'SSD  SAMSUNG 98O EVO NVME 5OOGB ( MZ-V8V500BW )', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(157, 80, 'MON-22MP68VQ-22', 'Lg 22&quot; ips monitor modal no :- 22MP68VQ', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(158, 81, 'HDD-SSD-480GB', 'WD Green 480 GB SSD ', '2022-12-16', 0, 0, 0, 0, 5, 5, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(159, 82, 'HEADPHONE-H-340', 'Ligitech H340 usb headphone ', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(160, 82, 'HEADPHONE-H9', 'Finger&#039;s Usb-Tonic H9 Hedaphone', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(161, 83, 'MTB-B460M-DS3H-V2', 'Gigabyte B460M DS3H V2', '2022-12-16', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(162, 83, 'CPU-I5-10400', 'CPU i5 2.9 Ghz ( 10400)', '2022-12-16', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(163, 83, 'RAM-DDR4-16GB', '16 GB 3000 Mhz DDR4 CORSIAR VEN RAM', '2022-12-16', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(164, 83, 'HDD-SSD-500GB', 'SSD  SAMSUNG 98O EVO NVME 5OOGB ( MZ-V8V500BW )', '2022-12-16', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(165, 83, 'HDD-HDD-1TB', 'HDD Segate 1 TB Barracudda ', '2022-12-16', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(166, 83, 'CAB-FING-SMPS', 'Fingures Cabinet with SMPS ', '2022-12-16', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 21235, 0, 'PO'),
(168, 84, 'MTB-B460M-DS3H-V2', 'Gigabyte B460M DS3H V2', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(169, 84, 'CPU-I5-10400', 'CPU i5 2.9 Ghz ( 10400)', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(170, 84, 'RAM-DDR4-8GB', 'Corsiar DDR 4 RAM 8 GB 3000 Mhz', '2022-12-16', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(171, 84, 'HDD-SSD-500GB', 'SSD  SAMSUNG 98O EVO NVME 5OOGB ( MZ-V8V500BW )', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(172, 84, 'HDD-HDD-1TB', 'HDD Segate 1 TB Barracudda ', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(173, 84, 'CAB-FING-SMPS', 'Fingures Cabinet with SMPS ', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 21235, 0, 'PO'),
(174, 84, 'MON-22MP68VQ-22', 'Lg 22&quot; ips monitor modal no :- 22MP68VQ', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(175, 85, 'MTB- B560M-AE', ' Motherboard (Gigabyte B560M Aorus Elite) ', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(176, 85, 'HDD-500GB', 'NVME Kingston 500 GB ', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(177, 85, 'HDD-HDD-2TB', 'Segate 2 TB HDD ', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(178, 86, 'SMPS-S-H5', 'Finger&#039;s show stoper H5', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(179, 86, 'HEADPHONE-G340', 'Ligitech H340 usb headphone ', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(180, 87, 'HEADPHONE-H-111', 'Logitech H111 Singal jack Headphone ', '2022-12-16', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(181, 88, 'HDD-SSD-500GB', 'SSD  SAMSUNG 98O EVO NVME 5OOGB ( MZ-V8V500BW )', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(182, 89, 'CPU-I5-10400', 'CPU i5 2.9 Ghz ( 10400)', '2022-12-16', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(183, 89, 'CAB-FING-SMPS', 'Fingures Cabinet with SMPS ', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 21235, 0, 'PO'),
(184, 89, 'MTB-B460M-DS3H-V2', 'Gigabyte B460M DS3H V2', '2022-12-16', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(185, 89, 'HDD-SSD-500GB', 'SSD  SAMSUNG 98O EVO NVME 5OOGB ( MZ-V8V500BW )', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(186, 89, 'RAM-DDR4-16GB', '16 GB 3000 Mhz DDR4 CORSIAR VEN RAM', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(187, 89, 'HDD-HDD-1TB', 'HDD Segate 1 TB Barracudda ', '2022-12-16', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(188, 90, 'FOOTPEDAL-ODIN', 'Odin FootPedal ', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(189, 91, 'ZEB-CRYSTAL-WEBCAM ', 'Zebronics Web Camera ( Modal No :- ZEB-CRYSTAL CLEAR )', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(190, 92, 'HEADPHONE-F-10', 'Finger&#039;s F10 Headphone ', '2022-12-16', 0, 0, 0, 0, 5, 5, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(191, 93, 'MON-22MP68VQ-22', 'Lg 22&quot; ips monitor modal no :- 22MP68VQ', '2022-12-16', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(192, 94, 'HEADPHONE-H-340', 'Ligitech H340 usb headphone ', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(193, 95, 'HDD-SSD-1TB', 'USB SSD :- 1 TB Samsung Protable SSD T5 ( Modal No :- MU-PA1T0B )', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(194, 95, 'ADAP-USB-T3-VIBOTON', 'M2 Casing Type C to usb 3.0 (VIBOTON)', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 525416, 0, 'PO'),
(195, 95, 'ADAP-USB-SATA', 'Xcess Sata Usb casing', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 525416, 0, 'PO'),
(196, 96, 'HEADPHONE-D3', 'Usb Headphone i ball upbeat d3 with mic ', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(197, 97, 'HEADPHONE-F10', 'Finger&#039;s F10 Headphone ', '2022-12-16', 0, 0, 0, 0, 5, 5, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(198, 98, 'HDD-HDD-1TB', 'HDD Segate 1 TB Barracudda ', '2022-12-16', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(199, 99, 'MTB-B365M D3H', 'MBD :- Gigabyte ( B365M D3H )', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(200, 99, 'CPU-I3-8100', 'CPUi3-8100   8th Gen  ', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(201, 99, 'RAM-DDR4-8GB', 'Corsiar DDR 4 RAM 8 GB 3000 Mhz', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(202, 99, 'CAB-IBALL', 'I ball cabinet', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 21235, 0, 'PO'),
(203, 99, 'HDD-SSD-250GB', 'SSD Segate Barracuda 250 GB ', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(204, 99, 'MON-GW2480-T-24', 'BenQ GW2480 24-inch', '2022-12-16', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(205, 99, 'RAM-DDR3-8GB', 'RAM DDR-3    8 GB Kingston 1333 Mhz', '2022-12-16', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(206, 100, 'MTB-B365M D3H', 'MBD :- Gigabyte ( B365M D3H )', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(207, 100, 'CPU-I5-8400', 'I5-8400 Cpu', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(208, 100, 'RAM-DDR4-16GB', '16 GB 3000 Mhz DDR4 CORSIAR VEN RAM', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(209, 100, 'CAB-IBALL', 'I ball cabinet', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 21235, 0, 'PO'),
(210, 100, 'MON-GW2480-T-24', 'BenQ GW2480 24-inch', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(211, 100, 'HDD-SSD-500GB', 'SSD  SAMSUNG 98O EVO NVME 5OOGB ( MZ-V8V500BW )', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(212, 101, 'HDD-SSD-500GB', 'SSD  SAMSUNG 98O EVO NVME 5OOGB ( MZ-V8V500BW )', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(213, 102, 'MTB-B360M-D3H', 'Gigabyte B360M-D3H Motherboard', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(214, 102, 'CPU-I5-8400', 'I5-8400 Cpu', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(215, 102, 'RAM-DDR4-16GB', '16 GB 3000 Mhz DDR4 CORSIAR VEN RAM', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(216, 102, 'HDD-1TB', 'Segate 1 TB Barracaudda Hdd', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(217, 102, 'CAB-IBALL', 'I ball cabinet', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 21235, 0, 'PO'),
(218, 102, 'RAM-DDR3-16GB', 'Corsiar value set DDR3 1600 RAM', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(219, 103, 'LOGI-WEBCAM-C270', 'Logitech Web Cam ( C270 )', '2022-12-16', 0, 0, 0, 0, 3, 3, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(220, 104, 'MTB-B360M-D3H', 'Gigabyte B360M-D3H Motherboard', '2022-12-16', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(221, 104, 'RAM-DDR4-8GB', 'Corsiar DDR 4 RAM 8 GB 3000 Mhz', '2022-12-16', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(222, 104, 'HDD-500GB', 'NVME Kingston 500 GB ', '2022-12-16', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(223, 104, 'CPU-I3-BX8070110100', 'i3 10th Gen 3.2Ghz (BX8070110100 )', '2022-12-16', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(224, 104, 'CAB-FING-SMPS', 'Fingures Cabinet with SMPS ', '2022-12-16', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 21235, 0, 'PO'),
(225, 104, 'SMPS-F-GAMA-401', 'Fingures SMPS (GAMA-401)', '2022-12-16', 0, 0, 0, 0, 4, 4, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(226, 105, 'HDD-SSD-500GB', 'SSD  SAMSUNG 98O EVO NVME 5OOGB ( MZ-V8V500BW )', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(227, 106, 'HDD-HDD-1TB', 'HDD Segate 1 TB Barracudda ', '2022-12-16', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(228, 106, 'SMPS-I-ZPS-281', 'SMPS  I Ball :- ZPS-281 ', '2022-12-16', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(229, 107, 'MTB-B460M-DS3H-AC', 'Gigabyte MBD ( B460M DS3H AC )', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(230, 107, 'HDD-HDD-1TB', 'HDD Segate 1 TB Barracudda ', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(231, 107, 'RAM-DDR4-16GB', '16 GB 3000 Mhz DDR4 CORSIAR VEN RAM', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(232, 107, 'CPU-I5-10400', 'CPU i5 2.9 Ghz ( 10400)', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(233, 107, 'HDD-HDD-1TB', 'HDD Segate 1 TB Barracudda ', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(234, 107, 'CAB-FING-SMPS', 'Fingures Cabinet with SMPS ', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 21235, 0, 'PO'),
(235, 107, 'MON-GW2480-T-24', 'BenQ GW2480 24-inch', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(236, 108, 'MTB- B560M-AE', ' Motherboard (Gigabyte B560M Aorus Elite) ', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(237, 108, 'MTB-B560M-DS3H-AC', 'Motherboard (Gigabyte B560M DS3H AC) ', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(238, 108, 'RAM-DDR4-16GB', '16 GB 3000 Mhz DDR4 CORSIAR VEN RAM', '2022-12-16', 0, 0, 0, 0, 3, 3, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(239, 108, 'HDD-SSD-500GB', 'SSD  SAMSUNG 98O EVO NVME 5OOGB ( MZ-V8V500BW )', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(240, 108, 'MON-S2421H-24', 'Dell 24&quot; Ips Monitor Modal No :- S2421H ', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(241, 108, 'CAB-FING-SMPS', 'Fingures Cabinet with SMPS ', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 21235, 0, 'PO'),
(242, 109, 'CAB-FING-SMPS', 'Fingures Cabinet with SMPS ', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 21235, 0, 'PO'),
(243, 109, 'MTB- B560M-AE', ' Motherboard (Gigabyte B560M Aorus Elite) ', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(244, 109, 'RAM-DDR4-16GB', '16 GB 3000 Mhz DDR4 CORSIAR VEN RAM', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(245, 109, 'HDD-SSD-500GB', 'SSD  SAMSUNG 98O EVO NVME 5OOGB ( MZ-V8V500BW )', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(246, 109, 'MON-S2421H-24', 'Dell 24&quot; Ips Monitor Modal No :- S2421H ', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(247, 110, 'MTB-B360M-D3H', 'Gigabyte B360M-D3H Motherboard', '2022-12-16', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(248, 110, 'CPU-I5-8400', 'I5-8400 Cpu', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(249, 110, 'CPU-I3-8100', 'CPUi3-8100   8th Gen  ', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(250, 110, 'RAM-DDR4-16GB', '16 GB 3000 Mhz DDR4 CORSIAR VEN RAM', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(251, 110, 'RAM-DDR4-8GB', 'Corsiar DDR 4 RAM 8 GB 3000 Mhz', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(252, 110, 'HDD-1TB', 'Segate 1 TB Barracaudda Hdd', '2022-12-16', 0, 0, 0, 0, 4, 4, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(253, 110, 'CAB-IBALL', 'I ball cabinet', '2022-12-16', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 21235, 0, 'PO'),
(254, 110, 'ADAP-LAPCARE', 'Laptop Adapter Lap care', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 525416, 0, 'PO'),
(255, 111, 'MOUSE-USB-M90', 'Logitech Usb Mouse (M90)', '2022-12-16', 0, 0, 0, 0, 5, 5, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(256, 112, 'CAB-FINGERS', 'Fingers cabinet ', '2022-12-16', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 21235, 0, 'PO'),
(257, 112, 'CPU-I5-10400', 'CPU i5 2.9 Ghz ( 10400)', '2022-12-16', 0, 0, 0, 0, 3, 3, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(258, 112, 'MTB-B460M-DS3H-V2', 'Gigabyte B460M DS3H V2', '2022-12-16', 0, 0, 0, 0, 3, 3, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(259, 112, 'RAM-DDR4-16GB', '16 GB 3000 Mhz DDR4 CORSIAR VEN RAM', '2022-12-16', 0, 0, 0, 0, 3, 3, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(260, 112, 'HDD-SSD-500GB', 'SSD  SAMSUNG 98O EVO NVME 5OOGB ( MZ-V8V500BW )', '2022-12-16', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(261, 112, 'HDD-HDD-1TB', 'HDD Segate 1 TB Barracudda ', '2022-12-16', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(262, 112, 'MON-GW2480-B-24', 'Benq Monitor 24&quot; (GW2480-B)', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(263, 113, 'RAM-DDR4-16GB', '16 GB 3000 Mhz DDR4 CORSIAR VEN RAM', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(264, 113, 'HDD-SSD-500GB', 'SSD  SAMSUNG 98O EVO NVME 5OOGB ( MZ-V8V500BW )', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(265, 113, 'HDD-HDD-1TB', 'HDD Segate 1 TB Barracudda ', '2022-12-16', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(266, 113, 'SMPS-I-ZPS-281', 'SMPS  I Ball :- ZPS-281 ', '2022-12-16', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(267, 114, 'CAB-CORSIAR', 'Corsiar Cabinet', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 21235, 0, 'PO'),
(268, 114, 'SMPS-ANTEC-VP-450', 'ANTEC VP 450 SMPS (VP450P PLUS IN V3000A200H-18) 450 Watt ', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(269, 114, 'CPU-I5-10400', 'CPU i5 2.9 Ghz ( 10400)', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(270, 114, 'MTB-B460M-DS3H-AC', 'Gigabyte MBD ( B460M DS3H AC )', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(271, 114, 'GR-CARD-Z-GTX-1050', 'Graphics Card 4 GB ,128 BIT ,GDDR5  Zotac Modal No :- (Zotac Geforce GTX 1050 Ti oc)', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(272, 114, 'RAM-DDR4-16GB', '16 GB 3000 Mhz DDR4 CORSIAR VEN RAM', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(273, 114, 'HDD-500GB', 'NVME Kingston 500 GB ', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(274, 114, 'HDD-HDD-1TB', 'HDD Segate 1 TB Barracudda ', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(275, 114, 'MOUSE-USB', 'Logitech Combo Mk-120 Keyboard &amp; Mouse ', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(276, 114, 'MON-GW2480-B-24', 'Benq Monitor 24&quot; (GW2480-B)', '2022-12-16', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(277, 115, 'HDD-SATA-8TB', 'HDD 8TB SATA SEGATE SURVILLANCE', '2022-12-19', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(278, 116, 'CPU-I5-10400', 'CPU i5 2.9 Ghz ( 10400)', '2022-12-19', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(279, 116, 'CAB-FING-SMPS', 'Fingures Cabinet with SMPS ', '2022-12-19', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 21235, 0, 'PO'),
(280, 116, 'MTB-B460M-DS3H-AC', 'Gigabyte MBD ( B460M DS3H AC )', '2022-12-19', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(281, 116, 'HDD-500GB', 'NVME Kingston 500 GB ', '2022-12-19', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(282, 116, 'HDD-HDD-1TB', 'HDD Segate 1 TB Barracudda ', '2022-12-19', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(283, 116, 'MOUSE-USB', 'Logitech Combo Mk-120 Keyboard &amp; Mouse ', '2022-12-19', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(284, 116, 'MON-GW2480-B-24', 'Benq Monitor 24&quot; (GW2480-B)', '2022-12-19', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(285, 116, 'RAM-DDR4-16GB', '16 GB 3000 Mhz DDR4 CORSIAR VEN RAM', '2022-12-19', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(286, 117, 'MON-GW2480-T-24', 'BenQ GW2480 24-inch', '2022-12-19', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(287, 117, 'CPU-I5-9400', 'Core I5 9400F 2.9 Ghz', '2022-12-19', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(288, 117, 'RAM-DDR4-16GB', '16 GB 3000 Mhz DDR4 CORSIAR VEN RAM', '2022-12-19', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(289, 117, 'MTB-B360M-D3H', 'Gigabyte B360M-D3H Motherboard', '2022-12-19', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(290, 117, 'CAB-IBALL', 'I ball cabinet', '2022-12-19', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 21235, 0, 'PO'),
(291, 117, 'GR-CARD-N-GT-70', 'Nvidia Geforce GT 70 Graphics card ', '2022-12-19', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(292, 118, 'HDD-1TB', 'Segate 1 TB Barracaudda Hdd', '2022-12-19', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(293, 119, 'HDD-HDD-1TB', 'HDD Segate 1 TB Barracudda ', '2022-12-19', 0, 0, 0, 0, 5, 5, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(294, 120, 'HDD-SSD-500GB', 'SSD  SAMSUNG 98O EVO NVME 5OOGB ( MZ-V8V500BW )', '2022-12-19', 0, 0, 0, 0, 3, 3, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(295, 121, 'MTB-B360M-D3H', 'Gigabyte B360M-D3H Motherboard', '2022-12-19', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(296, 121, 'RAM-DDR4-16GB', '16 GB 3000 Mhz DDR4 CORSIAR VEN RAM', '2022-12-19', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(297, 121, 'HDD-SSD-240GB', 'Wd green M2 ssd 240 GB ( M.2 2280  WDC WDS240G2GOB )', '2022-12-19', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(298, 121, 'CAB-IBALL', 'I ball cabinet', '2022-12-19', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 21235, 0, 'PO'),
(299, 121, 'MON-GW2480-T-24', 'BenQ GW2480 24-inch', '2022-12-19', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(300, 121, 'RAM-DDR4-8GB', 'Corsiar DDR 4 RAM 8 GB 3000 Mhz', '2022-12-19', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(301, 122, 'HDD-1TB', 'HDD Segate 1 TB Barracudda ', '2022-12-19', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(302, 122, 'RAM-DDR4-8GB', 'Corsiar DDR 4 RAM 8 GB 3000 Mhz', '2022-12-19', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(303, 122, 'RAM-DDR4-16GB', '16 GB 3000 Mhz DDR4 CORSIAR VEN RAM', '2022-12-19', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(304, 123, 'MTB-B360M-D3H', 'MBD :- Gigabyte ( B365M D3H )', '2022-12-19', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(305, 123, 'CPU-I5-8400', 'I5-8400 Cpu', '2022-12-19', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(306, 123, 'RAM-DDR4-16GB', '16 GB 3000 Mhz DDR4 CORSIAR VEN RAM', '2022-12-19', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(307, 123, 'CAB-IBALL', 'I ball cabinet', '2022-12-19', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 21235, 0, 'PO'),
(308, 123, 'MON-GW2480-T-24', 'BenQ GW2480 24-inch', '2022-12-19', 0, 0, 0, 0, 3, 3, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(309, 123, 'CPU-I3-8100', 'CPUi3-8100   8th Gen  ', '2022-12-19', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(310, 123, 'HDD-SSD-500GB', 'SSD  SAMSUNG 98O EVO NVME 5OOGB ( MZ-V8V500BW )', '2022-12-19', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(311, 124, 'RAM-DDR4-16GB', '16 GB 3000 Mhz DDR4 CORSIAR VEN RAM', '2022-12-19', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(312, 124, 'MOUSE-USB', 'Logitech Combo Mk-120 Keyboard &amp; Mouse ', '2022-12-19', 0, 0, 0, 0, 5, 5, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(313, 125, 'MTB-B460M-DS3H-V2', 'Gigabyte B460M DS3H V2', '2022-12-19', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(314, 125, 'CPU-I5-10400', 'CPU i5 2.9 Ghz ( 10400)', '2022-12-19', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(315, 125, 'RAM-DDR4-16GB', '16 GB 3000 Mhz DDR4 CORSIAR VEN RAM', '2022-12-19', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(316, 125, 'CAB-FING-SMPS', 'Fingures Cabinet with SMPS ', '2022-12-19', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 21235, 0, 'PO'),
(317, 125, 'HDD-SSD-500GB', 'SSD  SAMSUNG 98O EVO NVME 5OOGB ( MZ-V8V500BW )', '2022-12-19', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(318, 125, 'HDD-HDD-1TB', 'HDD Segate 1 TB Barracudda ', '2022-12-19', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(319, 125, 'MON-LED-LF24T352FHWXXL-24', 'SAMSUNG 24&quot; LED MONITOR (Modal No :- LF24T352FHWXXL)', '2022-12-19', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(320, 126, 'HDD-HDD-1TB', 'HDD Segate 1 TB Barracudda ', '2022-12-19', 0, 0, 0, 0, 5, 5, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(321, 127, 'UPS-600-VA', 'UPS LUMINIOUS 600VA', '2022-12-19', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(322, 128, 'HDD-HDD-1TB', 'HDD Segate 1 TB Barracudda ', '2022-12-19', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(323, 128, 'SMPS-I-ZPS-281', 'SMPS  I Ball :- ZPS-281 ', '2022-12-19', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(324, 128, 'MON-GW2480-T-24', 'BenQ GW2480 24-inch', '2022-12-19', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(325, 128, 'HDD-SSD-500GB', 'SSD  SAMSUNG 98O EVO NVME 5OOGB ( MZ-V8V500BW )', '2022-12-19', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(326, 129, 'RAM-DDR3-8GB', 'RAM DDR-3    8 GB Kingston 1333 Mhz', '2022-12-19', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(327, 130, 'MON-GW2280-B-22', 'Benq GW2280-B 22&quot; ', '2022-12-19', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(328, 131, 'MON-GW2480-T-24', 'BenQ GW2480 24-inch', '2022-12-19', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(329, 132, 'HDD-SSD-500GB', 'SSD  SAMSUNG 98O EVO NVME 5OOGB ( MZ-V8V500BW )', '2022-12-19', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(330, 133, 'USB-LINK-HUB', 'Usb ( 1 Gbps Lan + 3.1 Usb ) Tp link Hub', '2022-12-19', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 525416, 0, 'PO'),
(331, 134, 'MON-GW2480-T-24', 'BenQ GW2480 24-inch', '2022-12-19', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(332, 135, 'HDD-SSD-1TB', 'USB SSD :- 1 TB Samsung Protable SSD T5 ( Modal No :- MU-PA1T0B )', '2022-12-19', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(333, 136, 'MON-GW2480-T-24', 'BenQ GW2480 24-inch', '2022-12-19', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(334, 137, 'MON-22MP68VQ-22', 'Lg 22&quot; ips monitor modal no :- 22MP68VQ', '2022-12-19', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(335, 138, 'HDD-SSD-500GB', 'SSD  SAMSUNG 98O EVO NVME 5OOGB ( MZ-V8V500BW )', '2022-12-19', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(336, 139, 'HDD-SSD-500GB', 'SSD  SAMSUNG 98O EVO NVME 5OOGB ( MZ-V8V500BW )', '2022-12-19', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(337, 140, 'MON-GW2480-T-24', 'BenQ GW2480 24-inch', '2022-12-19', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(338, 141, 'HDD-HDD-1TB', 'HDD Segate 1 TB Barracudda ', '2022-12-19', 0, 0, 0, 0, 4, 4, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(339, 142, 'MUSIC-WOOFER', 'Zook Woofer + Wireless Mic (ZB-Rocker Thunder XL)', '2022-12-19', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(340, 143, 'FIREWALL-FGT-80F', 'Fortinet 80F Firewall with 3 Years fotigaurd suscribition  ', '2022-12-19', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(341, 144, 'PRO-I5-11GEN', 'Processor i5 11th gen 2.6 GHZ LGA 1200 ( i5-11400 BX8070811400) ', '2022-12-19', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(342, 145, 'PRO-I5-11GEN', 'Processor i5 11th gen 2.6 GHZ LGA 1200 ( i5-11400 BX8070811400) ', '2022-12-19', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(343, 146, 'PRO-I5-11GEN', 'Processor i5 11th gen 2.6 GHZ LGA 1200 ( i5-11400 BX8070811400) ', '2022-12-19', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(344, 147, 'PRO-I5-11GEN', 'Processor i5 11th gen 2.6 GHZ LGA 1200 ( i5-11400 BX8070811400) ', '2022-12-19', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(345, 148, 'PRO-I5-11GEN', 'Processor i5 11th gen 2.6 GHZ LGA 1200 ( i5-11400 BX8070811400) ', '2022-12-19', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(346, 149, 'PRO-I3-8GEN', 'I3 8th gen processor', '2022-12-19', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(347, 150, 'FIREWALL-FGT-60F', 'Fortigate 60 F Model :- ( FG-60F)', '2022-12-19', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(348, 151, 'GEN-JSPF-35X-3PH', '35 KVA Jakson Cummions Gen-set  3 Phase ( JSPF-35X (3PH)', '2022-12-19', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(349, 152, 'GEN-SNMP-MCY-EN', 'SNMP CARD ( SNMP web pro   Modal no :- SNMP-MCY-EN )', '2022-12-19', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(350, 153, 'LAP-IPAD-A1893', 'Apple i pad  (Modal no :-A1893)', '2022-12-19', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(351, 154, 'LAP-HP-15Q', 'Laptop HP 15Q core i5 8th gen 8 GB ', '2022-12-19', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(352, 155, 'LAP-ASUS-X509J', 'Asus Laptop vivo book ( X509J )', '2022-12-19', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(353, 156, 'LAP-DELL-14', 'Dell inspiron laptop ( 14&quot; paper 40 pin )', '2022-12-19', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(354, 157, 'LAP-DELL-IP-3511', 'Dell New 2022 Inspiron 3511 (Modal No:- Inspiron 3511, i3 11th gen, 8GB DDR4,256 GB Nvme,1TB HDD)', '2022-12-19', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(355, 158, 'LAP-IPAD-L14ITL6 ', 'Lenovo IdeaPad 5 Pro 14ITL6 ( i7-1165G7 2.80Ghz , 16 GB RAM ,500GB NVME)', '2022-12-19', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(356, 159, 'LAP-HP-15-EG2039TU', 'Hp Pavillion Laptop :- 15-EG2039TU ( i7-1260P . 16 GB RAM , 1 TB NVME 15.6&quot; Display )', '2022-12-19', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(357, 160, 'LAP-HP-EG2039TU', 'Hp Pavillion Laptop :- 15-EG2039TU ( i7-1260P . 16 GB RAM , 1 TB NVME 15.6&quot; Display )', '2022-12-19', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(358, 161, 'LAP-HP-EG2039TU', 'Hp Pavillion Laptop :- 15-EG2039TU ( i7-1260P . 16 GB RAM , 1 TB NVME 15.6&quot; Display )', '2022-12-19', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(359, 162, 'LAPCARE-LCP-111', 'Laptop Cooling Pad (Lapcare :- LCP-111)', '2022-12-19', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 26, 0, 'PO'),
(360, 163, 'LAPCARE-LCP-111', 'Laptop Cooling Pad (Lapcare :- LCP-111)', '2022-12-19', 0, 0, 0, 0, 3, 3, 25, 0, 0, 0, 0, 0, 0, 26, 0, 'PO'),
(361, 164, 'LAPCARE-LCP-111', 'Laptop Cooling Pad (Lapcare :- LCP-111)', '2022-12-19', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 26, 0, 'PO'),
(362, 165, 'DL-ESSL-EML600-2', 'Door Lock Essl Em ( Modal No :- EML600-2 )', '2022-12-19', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(363, 166, 'M-CHARGE-MI', 'Mi Sonic Charger 2.0 Modal No :- MDY-11-EL ', '2022-12-19', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(364, 167, 'M-REDMI-9', 'Redmi 9 Power Modal No :- M2010J19SI (Electric Green, 4GB RAM, 64GB Storage) - 6000mAh Battery B089MS8HPF                         ( REDMI9PWGREEN-4+64GB )', '2022-12-19', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(365, 168, 'M-MICROMAX-412', 'Micromax x412 Mobile Phone with Adaptor ( ACC05C14)', '2022-12-19', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(366, 169, 'ROUT-WIFI-A-RT-AX55', 'Wi-Fi Router With Mac binding feature Asus Modal No :- ( RT-AX55)', '2022-12-19', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(367, 170, 'ROUT-D--DGS-1210-28', 'D-Link Systems 28-Port Gigabit Web Smart (DGS-1210-28)', '2022-12-19', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(368, 171, 'ROUT-D-DGS-1210-52', 'D LINK 48PORT SWITCH (DGS-1210-52)', '2022-12-19', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(369, 171, 'RACK-2U', 'D.LINK 2U RACK', '2022-12-19', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(370, 172, 'ROUT-D-WIFI-001-DIR-', 'D-Link DIR-825 AC 1200 Wi-Fi Dual-Band Gigabit (LAN/WAN) Router | B098DTPWSM ( IT-ROUTER-001-DIR-825 )', '2022-12-19', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(371, 173, 'ROUT-TP-UE300', 'TP-Link UE300 USB 3.0 to RJ45 Gigabit Ethernet (UE300)', '2022-12-19', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(372, 174, 'ROUT-TP-UE300', 'TP-Link UE300 USB 3.0 to RJ45 Gigabit Ethernet (UE300)', '2022-12-19', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(373, 175, 'ROUT-TP-AC600', 'TP-Link AC600 (Modal No :- Archer T2U Plus ver 1.0)', '2022-12-19', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(374, 176, 'ROUT-WIFI-A-RT-AX55', 'Wi-Fi Router With Mac binding feature Asus Modal No :- ( RT-AX55)', '2022-12-19', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(375, 177, 'RACK-D-2U', 'D-Link 2U Rack ', '2022-12-19', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(376, 178, 'ROUT-D-DGS-1210-52', 'D LINK 48PORT SWITCH (DGS-1210-52)', '2022-12-19', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(377, 179, 'ROUT-H-DS-7632NI-K2', 'Hikvision Embeded NVR Modal No :- ( DS-7632NI-K2)', '2022-12-19', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(378, 179, 'ROUT-H-DS-3E0510P-E/', 'Hikvision 8 Port Gigabit Poe Unmangged switch :-Modal No :- DS-3E0510P-E/M ', '2022-12-19', 0, 0, 0, 0, 6, 6, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(379, 179, 'RACK-2U', 'D.LINK 2U RACK', '2022-12-19', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(380, 180, 'ROUT-D-DGS-1210-5', 'Dlink 52 Port switch( 52-Port Gigabit Smart Managed Switch DGS-1210-5)', '2022-12-19', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(381, 181, 'ROUT-D-DGS-1210-52', 'D LINK 48PORT SWITCH (DGS-1210-52)', '2022-12-19', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(382, 182, 'ROUT-TP-WN823N', 'Tp-Link 300 Mbps (TP-WN823N)', '2022-12-19', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(383, 183, 'REALME-TV-32', 'REALME 32&quot; INCH ANDROID TV', '2022-12-19', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(384, 184, 'LOGITECH-KEYB', 'logitech keyboard', '2023-01-30', 0, 0, 0, 0, 100, 100, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(385, 184, 'LOGITECH-MOUSE', 'logitech mouse', '2023-01-30', 0, 0, 0, 0, 100, 100, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(386, 185, 'CPUMI3', 'i3 cpu manufacture ', '2023-01-31', 0, 0, 0, 0, 4, 4, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(387, 186, 'CPUI3-3210', 'CPU- i3-3210-3.20GHz', '2023-02-01', 0, 0, 0, 0, 4, 4, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(388, 187, 'RAM-DDR4-12GB', 'Ram 12 gb', '2023-02-01', 0, 0, 0, 0, 10, 10, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(389, 188, 'FB-CPUMI3', 'FB-CPUMI3', '2023-02-01', 0, 0, 0, 0, 4, 4, 25, 0, 0, 0, 0, 0, 0, 0, 0, 'MO'),
(390, 189, 'CPUI3-3210-16GB', 'cpu i3 3210 16 gb', '2023-02-01', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(391, 190, 'CPUI3-3210-8GB', 'cpu i3 3210 8gb', '2023-02-02', 0, 0, 0, 0, 12, 12, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(392, 191, 'RAM-DDR4-8GB', 'Corsiar DDR 4 RAM 8 GB 3000 Mhz', '2023-02-02', 0, 0, 0, 0, 20, 20, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(393, 192, 'M-CPUI3-3210-8GB', 'M-CPUI3-3210-8GB', '2023-02-02', 0, 0, 0, 0, 12, 12, 25, 0, 0, 0, 0, 0, 0, 0, 0, 'MO'),
(394, 193, 'CPUi3-6098P-3.60GH', 'CPUi3-6098P-3.60GHz', '2023-02-03', 0, 0, 0, 0, 12, 12, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(395, 194, 'CPU-I3-6098P-8GB', 'CPU- i3-6098P-3.60GHz, RAM-8GB', '2023-02-03', 0, 0, 0, 0, 11, 11, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(396, 195, 'CPUI36098P', 'CPUI3-240GB', '2023-02-03', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(397, 196, 'HDD-SSD-240GBM', 'HDD-SSD-240GBM', '2023-02-03', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(398, 197, 'RAM-DDR4-8GB', 'Corsiar DDR 4 RAM 8 GB 3000 Mhz', '2023-02-03', 0, 0, 0, 0, 20, 20, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(399, 198, 'HDD-SSD-500GB', 'SSD  SAMSUNG 98O EVO NVME 5OOGB ( MZ-V8V500BW )', '2023-02-03', 0, 0, 0, 0, 50, 50, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(400, 199, 'RAM-DDR4-8GB', 'Corsiar DDR 4 RAM 8 GB 3000 Mhz', '2023-02-03', 0, 0, 0, 0, 10, 10, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(401, 200, 'CPU-i5-10400-2.90GH', 'CPU-i5-10400-2.90GHz', '2023-02-03', 0, 0, 0, 0, 10, 10, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(402, 201, 'CPUI52310-2.90', 'CPUI5-2310-2.90 8GB', '2023-02-03', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(403, 202, 'CPUI5-11400-2.60GH', 'CPU-i5-11400-2.60GHz, RAM-16GB', '2023-02-06', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO');
INSERT INTO `fa_purch_order_details` (`po_detail_item`, `order_no`, `item_code`, `description`, `delivery_date`, `qty_invoiced`, `unit_price`, `act_price`, `std_cost_unit`, `quantity_ordered`, `quantity_received`, `trans_type`, `gst`, `cst`, `ist`, `gst_amt`, `cst_amt`, `ist_amt`, `hsn_no`, `currency`, `pro_type`) VALUES
(404, 203, 'CPUI5-9400F-2.90GH', 'CPU-I5-9400F-2.90GHz 16GB Ram', '2023-02-06', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(405, 204, 'CPUI3-3210-3.20GH-12', 'CPU-i3-3210-3.20GHz, RAM-12GB,', '2023-02-06', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(406, 204, 'LAP-HP-I5', 'LAP-HP-I5-8GB', '2023-02-06', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(407, 205, 'CPUI5-3210-2.20GHz', 'CPU- i5-3210-2.20GHz, RAM-8GB', '2023-02-06', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(408, 206, 'CPUI5-8400-2.80-16GB', 'CPU- i5-8400-2.80GHz, RAM-16GB,', '2023-02-06', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(409, 207, 'CPUI5-10400-2.90-16G', 'CPU- i5-10400-2.90GHz, RAM-16GB,', '2023-02-06', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(410, 208, 'CPUI3-10400-3.20-16G', 'CPUI3-10400-3.20GHz,RAM-16GB', '2023-02-06', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(411, 209, 'CPUI3-6098P-3.60-16G', 'CPU- i3-6098P-3.60GHz, RAM-16GB, SSD-250 GB,HDD-1TB', '2023-02-06', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(412, 210, 'HDD-SSD-250GB', 'SSD Segate Barracuda 250 GB ', '2023-02-06', 0, 0, 0, 0, 10, 10, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(413, 211, 'CPUI5-10400-2.9-16GB', 'CPUI5-10400-2.90-16GB-500GB-1TB', '2023-02-06', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(414, 212, 'CPU-I7-7700k-4.20GH', 'CPU-I7-7700K-4.20GHz, RAM-32GB,', '2023-02-06', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(415, 213, 'RAM-32GB', 'RAM-32GB', '2023-02-06', 0, 0, 0, 0, 5, 5, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(416, 214, 'RAM-32GB', 'RAM-32GB', '2023-02-06', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(417, 215, 'CPU-I5-10400-2.9G16G', 'CPU- i5-10400-2.90GHz, RAM-16GB', '2023-02-06', 0, 0, 0, 0, 6, 6, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(418, 216, 'CPU-I7-8700K-3.70GH', 'CPU-I7-8700K-3.70GHz', '2023-02-06', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(419, 217, 'CPU-I5-8400-2.80GHz', 'CPU- i5-8400-2.80GHz,RAM-16GB,SSD250', '2023-02-06', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(420, 218, 'CPUI5-11400-2.6GH16G', 'CPU- i5-11400-2.60GHz, RAM-16GB, SSD-500 GB', '2023-02-06', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(421, 219, 'CPU-I3-3210-3.2GH16', 'CPU- i3-3210-3.20GHz, Ram 16GB', '2023-02-06', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(422, 220, 'HDD-4TB', 'HDD-4TB', '2023-02-06', 0, 0, 0, 0, 5, 5, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(423, 221, 'RAM-DDR4-16GB', '16 GB 3000 Mhz DDR4 CORSIAR VEN RAM', '2023-02-06', 0, 0, 0, 0, 10, 10, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(424, 222, 'CPU-I3-8100-3.6GH-16', 'CPU- i3-8100-3.60GHz, RAM-16GB', '2023-02-06', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(425, 223, 'CPUI3-2120-3.2G-12GB', 'CPU- i3-2120-3.20GHz, RAM-12GB,', '2023-02-06', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(426, 224, 'CPU-I3-3210-3.2-1TB', 'CPU- i3-3210-3.20GHz 1TB', '2023-02-07', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(427, 225, 'CPU-I5-8400-2.8G32GB', 'CPU- i5-8400-2.80GHz,RAM-32GB 2TB', '2023-02-07', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(428, 226, 'RAM-32GB', 'RAM-32GB', '2023-02-07', 0, 0, 0, 0, 5, 5, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(429, 227, 'CPU-I3-2120-3.3G-16G', 'CPU- i3-2120-3.30GHz,RAM-16GB SSD-500GB', '2023-02-07', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(430, 228, 'CPUI7-1260P-RAM-16G', 'CPU- i7-1260P, RAM-16GB, SSD- 1TB', '2023-02-07', 0, 0, 0, 0, 4, 4, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(431, 229, 'HDD-SSD-1TB', 'USB SSD :- 1 TB Samsung Protable SSD T5 ( Modal No :- MU-PA1T0B )', '2023-02-07', 0, 0, 0, 0, 5, 5, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(432, 230, 'CPUI7-1165G7-RAM-16G', 'CPU- i7-1165G7,RAM-16GB, SSD-500GB', '2023-02-07', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(433, 231, 'CPUI5-9400F-2.9G-16G', 'CPU- i5-9400F-2.90GHz, RAM-16GB, SSD-500 GB,HDD-1TB', '2023-02-07', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(434, 232, 'CPUI3-8100-3.6G-16GB', 'CPU- i3-8100-3.60GHz, RAM-16GB, SSD-250 GB,HDD- 1TB', '2023-02-07', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(435, 233, 'CPUI3-3210-3.2G-16GB', 'CPU- i3-3210-3.20GHz, RAM-16GB, SSD-500 GB', '2023-02-07', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(436, 234, 'CPUI5-10400-2.9G-16G', 'CPU- i5-10400-2.90GHz, RAM-16GB, SSD-500 GB,HDD- 1TB', '2023-02-07', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(437, 235, 'CPUI3-6098P-3.60-16G', 'CPU- i3-6098P-3.60GHz, RAM-16GB, SSD-250 GB,HDD-1TB', '2023-02-07', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(438, 236, 'RAM-DDR4-16GB', '16 GB 3000 Mhz DDR4 CORSIAR VEN RAM', '2023-02-07', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(439, 237, 'CPUI5-8400-2.80GHz', 'CPU- i5-8400-2.80GHz, RAM-16GB, SSD-500 GB,HDD- 1TB', '2023-02-07', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(440, 238, 'CPU-I5-11400-2.6-16G', 'CPU- i5-11400-2.60GHz, RAM-16GB, SSD-250 GB, ', '2023-02-07', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(441, 239, 'CPU-I5-2400-3.1G-16G', 'CPU- i5-2400-3.10GHz, RAM-16GB, SSD-500 GB,HDD- 1TB, ', '2023-02-07', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(442, 240, 'CPU-I5-10400-2.90-16', 'CPU- i5-10400-2.90GHz, RAM-16GB, SSD-500 GB', '2023-02-07', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(443, 241, 'CPU-I3-8100-3.6-16Gb', 'CPU- i3-8100-3.60GHz, RAM-16GB, SSD-500GB,HDD-1TB,', '2023-02-07', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(444, 242, 'CPU-I5-11400-2.6-16', 'CPU- i5-11400-2.60GHz, RAM-16GB, SSD-500 GB', '2023-02-07', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(445, 243, 'CPU-I5-10400-2.90-16', 'CPU- i5-10400-2.90GHz, RAM-16GB, SSD-500 GB', '2023-02-07', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(446, 244, 'CPU-I5-10400-2.9-16', 'CPU- i5-10400-2.90GHz, RAM-16GB, SSD-500 GB,HDD-1TB,', '2023-02-07', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(447, 245, 'CPUI5-11400-2.6-16G', 'CPU- i5-11400-2.60GHz, RAM-16GB, SSD-250 GB, HDD-1TB,', '2023-02-07', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(448, 246, 'CPUI3-6098P-3.6-16', 'CPU- i3-6098P-3.60GHz, RAM-16GB, SSD-500GB,HDD-1TB', '2023-02-07', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(449, 247, 'CPU-I3-4005U-1.70GH', 'CPU- i3-4005U-1.70GHz, RAM-12GB, SSD-500 GB (HP 15 Notebook Laptop),', '2023-02-07', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(450, 248, 'CPU-I3-10100-3.6-8GB', 'CPU- i3-10100-3.60GHz, RAM-8GB, SSD-240 GB, HDD-1TB, ', '2023-02-07', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(451, 249, 'CPU-I3-2330M-2.20-L', 'CPU- i3-2330M-2.20GHz, RAM-8GB, SSD-500 GB (Acer Laptop)', '2023-02-07', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(452, 250, 'CPU-I3-6100U-2.30-L', 'CPU- i3-6100U-2.30GHz, RAM-8GB, SSD-500 GB (Lenevo Laptop)', '2023-02-07', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(453, 251, 'CPU-I5-1035G1-1.0-L', 'CPU- i5-1035G1-1.00GHz, RAM-8GB, SSD-500 GB ', '2023-02-07', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(454, 252, 'Cpu-i3-2.4G-4gb-LAP', 'Cpu-i3 2.4 Ghz, RAM-4GB,SSD-240 GB ( Stand by Laptop )', '2023-02-07', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(455, 253, 'CPU-I3-3210-3.20G-16', 'CPU- i3-3210-3.20GHz, RAM-16GB, SSD-250 GB,MBD-Gigabyte.', '2023-02-07', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(456, 254, 'CPU-I5-10400-2.9-16G', 'CPU- i5-10400-2.90GHz, RAM-16GB, SSD-500 GB', '2023-02-07', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(457, 255, 'M-CPUI5-10400-8Gb', 'M-CPUI5-10400-8Gb', '2023-02-07', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 0, 0, 'MO'),
(458, 256, 'M-CPUI52310-2.90', 'M-CPUI52310-2.90', '2023-02-07', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 0, 0, 'MO'),
(459, 257, 'CPUI5-11400-2.60-16GB', 'CPUI5-11400-2.60-16GB', '2023-02-07', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 0, 0, 'MO'),
(460, 258, 'CPUI5-9400F 2.9 GH 16 GB', 'CPUI5-9400F 2.9 GH 16 GB', '2023-02-07', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 0, 0, 'MO'),
(461, 259, 'M-CPUI3-3210-3.2-12', 'M-CPUI3-3210-3.2-12', '2023-02-07', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 0, 0, 'MO'),
(462, 260, 'M-CPUI5-3210-2.20-8GB', 'M-CPUI5-3210-2.20-8GB', '2023-02-07', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 0, 0, 'MO'),
(463, 261, 'M-CPUI5-8400-2.8-16GB', 'M-CPUI5-8400-2.8-16GB', '2023-02-07', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 0, 0, 'MO'),
(464, 262, 'M-CPUI510400-2.90GHz', 'M-CPUI510400-2.90GHz', '2023-02-07', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 0, 0, 'MO'),
(465, 263, 'M-CPUI3-10400-16G', 'M-CPUI3-10400-16G', '2023-02-07', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 0, 0, 'MO'),
(466, 264, 'M-CPUI3-6098P-3.60-16G', 'M-CPUI3-6098P-3.60-16G', '2023-02-07', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 0, 0, 'MO'),
(467, 265, 'M-CPUI3-3210', 'M-CPUI3-3210', '2023-02-07', 0, 0, 0, 0, 4, 4, 25, 0, 0, 0, 0, 0, 0, 0, 0, 'MO'),
(468, 266, 'M-CPUI5-10400-500GB-16GB', 'M-CPUI5-10400-500GB-16GB', '2023-02-07', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 0, 0, 'MO'),
(469, 267, 'M-CPU-I7-32GB', 'M-CPU-I7-32GB', '2023-02-07', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 0, 0, 'MO'),
(470, 268, 'M-CPU-I5-10100-16gb', 'M-CPU-I5-10100-16gb', '2023-02-07', 0, 0, 0, 0, 6, 6, 25, 0, 0, 0, 0, 0, 0, 0, 0, 'MO'),
(471, 269, 'M-CPUI7-8700K-32GB', 'M-CPUI7-8700K-32GB', '2023-02-07', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 0, 0, 'MO'),
(472, 270, 'CPUI5-8400-2.8GH-16GB', 'CPUI5-8400-2.8GH-16GB', '2023-02-07', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 0, 0, 'MO'),
(473, 271, 'M-CPU- i5-11400-2.60GH 16GB ', 'M-CPU- i5-11400-2.60GH 16GB ', '2023-02-07', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 0, 0, 'MO'),
(474, 272, 'M-CPUI3-3210-16GB-SSD500GB', 'M-CPUI3-3210-16GB-SSD500GB', '2023-02-07', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 0, 0, 'MO'),
(475, 273, 'M-CPUI3-8100-3.6 16GB', 'M-CPUI3-8100-3.6 16GB', '2023-02-07', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 0, 0, 'MO'),
(476, 274, 'M-CPUI3-3.2-2120-12GB', 'M-CPUI3-3.2-2120-12GB', '2023-02-07', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 0, 0, 'MO'),
(477, 275, 'M-CPUI3-3210-1TBHDD', 'M-CPUI3-3210-1TBHDD', '2023-02-07', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 0, 0, 'MO'),
(478, 276, 'M-CPUI5-8400-2.8GH 32GB 2TB', 'M-CPUI5-8400-2.8GH 32GB 2TB', '2023-02-07', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 0, 0, 'MO'),
(479, 277, 'M-CPUI3-2120-16GB-500GB', 'M-CPUI3-2120-16GB-500GB', '2023-02-07', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 0, 0, 'MO'),
(480, 278, 'M-CPUI7-1165G7-16GB-500GB', 'M-CPUI7-1165G7-16GB-500GB', '2023-02-07', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 0, 0, 'MO'),
(481, 279, 'M-CPUI7-1260P-16GB-1TB', 'M-CPUI7-1260P-16GB-1TB', '2023-02-07', 0, 0, 0, 0, 4, 4, 25, 0, 0, 0, 0, 0, 0, 0, 0, 'MO'),
(482, 280, 'M-CPUI5-9400F-16GB-500GB-1TB', 'M-CPUI5-9400F-16GB-500GB-1TB', '2023-02-07', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 0, 0, 'MO'),
(483, 281, 'M-CPUI3-8100-3.6G-16GB-250GB', 'M-CPUI3-8100-3.6G-16GB-250GB', '2023-02-07', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 0, 0, 'MO'),
(484, 282, 'M-CPI3-3210-16GB-500GB ', 'M-CPI3-3210-16GB-500GB ', '2023-02-07', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 0, 0, 'MO'),
(485, 283, 'M-CPUI510400-2.9G-16G-500GB-1TB', 'M-CPUI510400-2.9G-16G-500GB-1TB', '2023-02-07', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 0, 0, 'MO'),
(486, 284, 'M-CPUI3-6089-3.6-16G-250GB-1TB', 'M-CPUI3-6089-3.6-16G-250GB-1TB', '2023-02-07', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 0, 0, 'MO'),
(487, 285, 'M-CPUI5-8400-2.8G-12GB-500GB-1TB', 'M-CPUI5-8400-2.8G-12GB-500GB-1TB', '2023-02-07', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 0, 0, 'MO'),
(488, 286, 'M-CPUI3-16GB', 'M-CPUI3-16GB', '2023-02-07', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 0, 0, 'MO'),
(489, 287, 'M-CPUI3-10105-3.7G-16GB-500GB-1tb', 'M-CPUI3-10105-3.7G-16GB-500GB-1tb', '2023-02-07', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 0, 0, 'MO'),
(490, 288, 'M-CPUI5-11400-2.6-16GB-250GB', 'M-CPUI5-11400-2.6-16GB-250GB', '2023-02-07', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 0, 0, 'MO'),
(491, 289, 'M-CPUI5-2400-3.1G-16G-500GB-SSD-1TB-HDD', 'M-CPUI5-2400-3.1G-16G-500GB-SSD-1TB-HDD', '2023-02-07', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 0, 0, 'MO'),
(492, 290, 'M-CPUI5-10400-2.9-16GB-SSD-500GB', 'M-CPUI5-10400-2.9-16GB-SSD-500GB', '2023-02-07', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 0, 0, 'MO'),
(493, 291, 'M-CPUI3-8100-3.6-16GB-500-SSD', 'M-CPUI3-8100-3.6-16GB-500-SSD', '2023-02-07', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 0, 0, 'MO'),
(494, 292, 'M-CPUI5-11400-2.6-16Gb-SSD-500GB', 'M-CPUI5-11400-2.6-16Gb-SSD-500GB', '2023-02-07', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 0, 0, 'MO'),
(495, 293, 'M-CPUI5-10400-2.9-16GB-SSD500Gb-', 'M-CPUI5-10400-2.9-16GB-SSD500Gb-', '2023-02-07', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 0, 0, 'MO'),
(496, 294, 'M-CPUI5-11400-2.6-16GB-SSD-250GB-1TB', 'M-CPUI5-11400-2.6-16GB-SSD-250GB-1TB', '2023-02-07', 0, 0, 0, 0, 2, 2, 25, 0, 0, 0, 0, 0, 0, 0, 0, 'MO'),
(497, 295, 'M-CPUI3-6098P-3.6-16GB-500GB', 'M-CPUI3-6098P-3.6-16GB-500GB', '2023-02-07', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 0, 0, 'MO'),
(498, 296, 'M-CPUI3-10100-3.6-8GB-SSD-240GB', 'M-CPUI3-10100-3.6-8GB-SSD-240GB', '2023-02-07', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 0, 0, 'MO'),
(499, 297, 'CPUI3-6098P', 'CPUI3-6098P', '2023-02-07', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 0, 0, 'MO'),
(500, 298, 'M-CPUI3-3210-3.2G-16GB-SSD-250GB', 'M-CPUI3-3210-3.2G-16GB-SSD-250GB', '2023-02-07', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 0, 0, 'MO'),
(501, 299, 'M-CPUI5-10400-2.9-16GB-500GB-SSD', 'M-CPUI5-10400-2.9-16GB-500GB-SSD', '2023-02-07', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 0, 0, 'MO'),
(502, 300, 'CPUI3-6098P8GB', 'CPUI3-6098P8GB', '2023-02-07', 0, 0, 0, 0, 10, 10, 25, 0, 0, 0, 0, 0, 0, 0, 0, 'MO'),
(503, 301, 'CPUI3-6098P-240GB', 'CPUI3-6098P-240GB', '2023-02-07', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 0, 0, 'MO'),
(504, 302, 'M-CPU-I3-8100', 'M-CPU-I3-8100', '2023-02-07', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 0, 0, 'MO'),
(505, 303, 'M-CPUI5-10400', 'M-CPUI5-10400', '2023-02-07', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 0, 0, 'MO'),
(506, 304, 'LAP-HP-I5-2.2-8GB', 'CPU- i5-5200U-2.20GHz, RAM-8GB, SSD-500 GB', '2023-02-08', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(507, 305, 'LAP-DELL-I3-8GB-1TB', 'CPU- i3-1115G4-3.00GHz, RAM-8GB, SSD-1TB,', '2023-02-08', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(508, 306, 'LAP-I7-16GB-500GB', 'CPU-I7-1165G7,RAM-16GB, SSD-500GB ', '2023-02-08', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(509, 307, 'LAP-I5-16GB-SSD-500G', 'CPU- i5-10400-2.90GHz, RAM-16GB, ', '2023-02-08', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO'),
(510, 308, 'delll-lap', 'dell inspiration', '2023-02-09', 0, 0, 0, 0, 1, 1, 25, 0, 0, 0, 0, 0, 0, 258, 0, 'PO');

-- --------------------------------------------------------

--
-- Table structure for table `fa_quick_entries`
--

CREATE TABLE `fa_quick_entries` (
  `id` smallint(6) UNSIGNED NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 0,
  `description` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `usage` varchar(120) COLLATE utf8_unicode_ci DEFAULT NULL,
  `base_amount` double NOT NULL DEFAULT 0,
  `base_desc` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bal_type` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fa_quick_entry_lines`
--

CREATE TABLE `fa_quick_entry_lines` (
  `id` smallint(6) UNSIGNED NOT NULL,
  `qid` smallint(6) UNSIGNED NOT NULL,
  `amount` double DEFAULT 0,
  `memo` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `action` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `dest_id` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `dimension_id` smallint(6) UNSIGNED DEFAULT NULL,
  `dimension2_id` smallint(6) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fa_recieved_management`
--

CREATE TABLE `fa_recieved_management` (
  `id` int(11) NOT NULL,
  `ref_id` varchar(255) NOT NULL,
  `issue_no` varchar(255) DEFAULT NULL,
  `subject_title` varchar(255) NOT NULL,
  `recieved_date` datetime NOT NULL,
  `recieve_mode` varchar(255) NOT NULL,
  `document_type` varchar(255) NOT NULL,
  `sender_person` varchar(255) NOT NULL,
  `sender_designation` varchar(255) NOT NULL,
  `sender_department` varchar(255) NOT NULL,
  `remarks` varchar(100) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fa_recieved_management`
--

INSERT INTO `fa_recieved_management` (`id`, `ref_id`, `issue_no`, `subject_title`, `recieved_date`, `recieve_mode`, `document_type`, `sender_person`, `sender_designation`, `sender_department`, `remarks`, `status`) VALUES
(1, 'rev-001', '', '', '2020-01-22 00:00:00', '', '', '', '', '', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `fa_recurrent_invoices`
--

CREATE TABLE `fa_recurrent_invoices` (
  `id` smallint(6) UNSIGNED NOT NULL,
  `description` varchar(60) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `order_no` int(11) UNSIGNED NOT NULL,
  `debtor_no` int(11) UNSIGNED DEFAULT NULL,
  `group_no` smallint(6) UNSIGNED DEFAULT NULL,
  `days` int(11) NOT NULL DEFAULT 0,
  `monthly` int(11) NOT NULL DEFAULT 0,
  `begin` date NOT NULL DEFAULT '0000-00-00',
  `end` date NOT NULL DEFAULT '0000-00-00',
  `last_sent` date NOT NULL DEFAULT '0000-00-00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fa_reflines`
--

CREATE TABLE `fa_reflines` (
  `id` int(11) NOT NULL,
  `trans_type` int(11) NOT NULL,
  `prefix` char(5) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `pattern` varchar(35) COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `description` varchar(60) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `default` tinyint(1) NOT NULL DEFAULT 0,
  `inactive` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fa_reflines`
--

INSERT INTO `fa_reflines` (`id`, `trans_type`, `prefix`, `pattern`, `description`, `default`, `inactive`) VALUES
(1, 0, '', '1', '', 1, 0),
(2, 1, '', '1', '', 1, 0),
(3, 2, '', '1', '', 1, 0),
(4, 4, '', '1', '', 1, 0),
(5, 10, '', '9', '', 1, 0),
(6, 11, '', '1', '', 1, 0),
(7, 12, '', '1', '', 1, 0),
(8, 13, '', '1', '', 1, 0),
(9, 16, '', '1', '', 1, 0),
(10, 17, '', '1', '', 1, 0),
(11, 18, '', '1', '', 1, 0),
(12, 20, '', '1', '', 1, 0),
(13, 21, '', '1', '', 1, 0),
(14, 22, '', '1', '', 1, 0),
(15, 25, '', '11', '', 1, 0),
(16, 26, '', '5', '', 1, 0),
(18, 29, '', '1', '', 1, 0),
(19, 30, '', '1', '', 1, 0),
(20, 32, '', '1', '', 1, 0),
(21, 35, '', '1', '', 1, 0),
(22, 40, '', '1', '', 1, 0),
(23, 28, '', '14', '', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `fa_refs`
--

CREATE TABLE `fa_refs` (
  `id` int(11) NOT NULL,
  `type` int(11) NOT NULL DEFAULT 0,
  `reference` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fa_refs`
--

INSERT INTO `fa_refs` (`id`, `type`, `reference`) VALUES
(1, 28, '13'),
(2, 28, '11'),
(3, 25, '9'),
(4, 25, '10'),
(5, 25, '1'),
(6, 25, '2'),
(7, 25, '3'),
(8, 25, '5'),
(9, 25, '6'),
(10, 25, '7'),
(11, 25, '8'),
(12, 25, '9'),
(13, 25, '10'),
(24, 29, '1'),
(25, 29, '46'),
(32, 29, '2'),
(33, 29, '55'),
(34, 29, '2'),
(35, 29, '3');

-- --------------------------------------------------------

--
-- Table structure for table `fa_refs1`
--

CREATE TABLE `fa_refs1` (
  `id` int(11) NOT NULL,
  `type` int(11) NOT NULL DEFAULT 0,
  `reference` varchar(100) CHARACTER SET utf8 NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `fa_return`
--

CREATE TABLE `fa_return` (
  `id` int(11) NOT NULL,
  `stock_id` varchar(100) NOT NULL,
  `building` int(11) NOT NULL,
  `floor` int(11) NOT NULL,
  `room` int(11) NOT NULL,
  `department` int(11) NOT NULL,
  `seat` int(11) NOT NULL,
  `return_status` varchar(50) NOT NULL DEFAULT '0',
  `return_date` date NOT NULL,
  `item_status` varchar(50) NOT NULL,
  `sl_no` varchar(100) NOT NULL,
  `qty` int(11) NOT NULL DEFAULT 1,
  `loc_code` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fa_return`
--

INSERT INTO `fa_return` (`id`, `stock_id`, `building`, `floor`, `room`, `department`, `seat`, `return_status`, `return_date`, `item_status`, `sl_no`, `qty`, `loc_code`) VALUES
(1, 'WTANK', 3, 0, 0, 0, 0, '1', '2022-12-02', '1', 'WT101', 1, 'PAT');

-- --------------------------------------------------------

--
-- Table structure for table `fa_return_policy`
--

CREATE TABLE `fa_return_policy` (
  `id` int(11) NOT NULL,
  `ref_id` varchar(50) NOT NULL,
  `return_policy` varchar(100) NOT NULL,
  `no_day` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fa_return_policy`
--

INSERT INTO `fa_return_policy` (`id`, `ref_id`, `return_policy`, `no_day`, `status`) VALUES
(3, 'No-001', 'Staff', 10, 0),
(4, 'No-002', 'Student', 5, 0);

-- --------------------------------------------------------

--
-- Table structure for table `fa_room_issues`
--

CREATE TABLE `fa_room_issues` (
  `issue_no` int(11) NOT NULL,
  `workorder_id` int(11) NOT NULL DEFAULT 0,
  `reference` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `issue_date` date DEFAULT NULL,
  `loc_code` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `workcentre_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fa_room_issues`
--

INSERT INTO `fa_room_issues` (`issue_no`, `workorder_id`, `reference`, `issue_date`, `loc_code`, `workcentre_id`) VALUES
(1, 0, '13', '2023-03-23', 'PAT', 2);

-- --------------------------------------------------------

--
-- Table structure for table `fa_room_issue_items`
--

CREATE TABLE `fa_room_issue_items` (
  `id` int(11) NOT NULL,
  `stock_id` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `issue_id` int(11) DEFAULT NULL,
  `qty_issued` double DEFAULT NULL,
  `unit_cost` double NOT NULL DEFAULT 0,
  `sl_no` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `department_id` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'NA',
  `seat_no` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'NA'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fa_room_issue_items`
--

INSERT INTO `fa_room_issue_items` (`id`, `stock_id`, `issue_id`, `qty_issued`, `unit_cost`, `sl_no`, `department_id`, `seat_no`) VALUES
(1, 'DL-ESSL-EML600-2', 1, 1, 0, 'FB-DOOR-L-001', 'NA', 'NA');

-- --------------------------------------------------------

--
-- Table structure for table `fa_room_main`
--

CREATE TABLE `fa_room_main` (
  `id` int(10) NOT NULL,
  `asset_id` int(10) NOT NULL,
  `room_no` varchar(50) NOT NULL,
  `qty` int(10) NOT NULL,
  `inactive` tinyint(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fa_room_main`
--

INSERT INTO `fa_room_main` (`id`, `asset_id`, `room_no`, `qty`, `inactive`) VALUES
(1, 3, '101', 1, 0),
(2, 3, '102', 10, 0),
(3, 3, '103', 10, 0),
(4, 3, '104', 10, 0),
(5, 8, '102', 10, 0),
(6, 4, '103', 1, 0),
(7, 2, 'R001', 6, 0),
(8, 2, 'R002', 1, 0),
(9, 2, 'R003', 1, 0),
(10, 2, 'R004', 1, 0),
(11, 2, 'R005', 1, 0),
(12, 2, 'R006', 1, 0),
(13, 4, '104', 1, 0),
(14, 4, '105', 1, 0),
(15, 4, '102', 1, 0),
(16, 8, '101', 1, 0),
(17, 9, '101', 1, 0),
(18, 9, '102', 1, 0),
(19, 9, '103', 1, 0),
(20, 9, '104', 1, 0),
(21, 9, '105', 1, 0),
(22, 8, '103', 1, 0),
(23, 8, '104', 1, 0),
(24, 8, '105', 1, 0),
(25, 8, '106', 1, 0),
(26, 8, '107', 1, 0),
(27, 8, '108', 1, 0),
(28, 8, '109', 1, 0),
(29, 8, '110', 1, 0),
(30, 7, 'r101', 1, 0),
(31, 7, 'r102', 1, 0),
(32, 7, 'r103', 1, 0),
(33, 7, 'r104', 1, 0),
(34, 7, 'r105', 1, 0),
(35, 5, 'r3001', 1, 0),
(36, 5, 'r3002', 1, 0),
(37, 5, 'r3003', 1, 0),
(38, 5, 'r3004', 1, 0),
(39, 4, '101', 1, 0),
(40, 1, 'DF-101', 5, 0),
(41, 1, 'DF-102', 5, 0),
(42, 1, 'DF-103', 5, 0),
(43, 1, 'DF-104', 5, 0),
(44, 1, 'DF-105', 5, 0);

-- --------------------------------------------------------

--
-- Table structure for table `fa_room_master`
--

CREATE TABLE `fa_room_master` (
  `room_id` int(11) NOT NULL,
  `room_des` char(100) DEFAULT NULL,
  `room_no` char(25) DEFAULT NULL,
  `room_type` varchar(11) DEFAULT NULL,
  `ac_avil` tinyint(11) DEFAULT NULL,
  `status` tinyint(11) DEFAULT NULL,
  `inactive` tinyint(4) NOT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `fa_room_transition`
--

CREATE TABLE `fa_room_transition` (
  `id` int(11) NOT NULL,
  `room_id` int(11) DEFAULT NULL,
  `bed_no` varchar(50) DEFAULT NULL,
  `fee_type` char(11) DEFAULT NULL,
  `charge` float DEFAULT NULL,
  `inactive` tinyint(4) NOT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fa_room_transition`
--

INSERT INTO `fa_room_transition` (`id`, `room_id`, `bed_no`, `fee_type`, `charge`, `inactive`, `deleted`) VALUES
(2, 1, '10', '1', 50, 0, 0),
(3, 2, '10', '1', 100, 0, 0),
(4, 5, '10', '1', 150, 0, 0),
(5, 3, '10', '1', 200, 0, 0),
(6, 4, '10', '1', 20, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `fa_route`
--

CREATE TABLE `fa_route` (
  `id` int(11) NOT NULL,
  `route_id` varchar(50) NOT NULL,
  `route_name` varchar(100) NOT NULL,
  `source` varchar(50) NOT NULL,
  `destination` varchar(100) NOT NULL,
  `status` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fa_route`
--

INSERT INTO `fa_route` (`id`, `route_id`, `route_name`, `source`, `destination`, `status`) VALUES
(1, 'route-001', 'SCH-DPUR', 'Danapur Cant', 'School', 1),
(2, 'route-002', 'SCH-PCITY', 'Patna City', 'School', 1),
(3, 'route-003', 'SCH-RLYST', 'Railway Station', 'School', 2),
(4, 'route-004', 'DUPLICATE', 'IIT', 'School', 1),
(5, 'route-005', 'test', 'test', 'test', 1),
(6, 'route-006', 'test', 'test', 'test', 1),
(7, 'route-007', 'test', 'test', 'test', 1),
(8, 'route-008', 'fdg', 'fg', 'fg', 2);

-- --------------------------------------------------------

--
-- Table structure for table `fa_routeconfig_detail`
--

CREATE TABLE `fa_routeconfig_detail` (
  `id` int(11) NOT NULL,
  `config_id` varchar(50) NOT NULL,
  `s_name` varchar(100) NOT NULL,
  `sequence` int(10) NOT NULL,
  `exp_time` time NOT NULL,
  `drop_time` time NOT NULL,
  `cost` int(11) NOT NULL,
  `status` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fa_routeconfig_detail`
--

INSERT INTO `fa_routeconfig_detail` (`id`, `config_id`, `s_name`, `sequence`, `exp_time`, `drop_time`, `cost`, `status`) VALUES
(21, 'config-001', '1', 1, '06:30:00', '14:30:00', 500, 1),
(22, 'config-001', '2', 2, '06:40:00', '14:40:00', 500, 1),
(23, 'config-001', '3', 3, '06:50:00', '14:50:00', 500, 1),
(24, 'config-001', '4', 4, '07:00:00', '15:00:00', 500, 1),
(30, 'config-002', '4', 1, '06:50:00', '14:50:00', 500, 1),
(31, 'config-002', '5', 2, '07:00:00', '15:00:00', 500, 1),
(32, 'config-002', '6', 3, '07:10:00', '15:15:00', 500, 1),
(33, 'config-003', '', 0, '00:00:00', '00:00:00', 0, 1),
(34, 'config-004', '', 0, '00:00:00', '00:00:00', 0, 1),
(35, 'config-005', '', 0, '00:00:00', '00:00:00', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `fa_route_config`
--

CREATE TABLE `fa_route_config` (
  `id` int(11) NOT NULL,
  `config_id` varchar(50) NOT NULL,
  `route_name` varchar(100) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fa_route_config`
--

INSERT INTO `fa_route_config` (`id`, `config_id`, `route_name`, `status`) VALUES
(5, 'config-001', 'SCH-DPUR', 1),
(6, 'config-002', 'SCH-PCITY', 1),
(7, 'config-003', '', 1),
(8, 'config-004', '', 1),
(9, 'config-005', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `fa_salaryscale`
--

CREATE TABLE `fa_salaryscale` (
  `scale_id` int(11) NOT NULL,
  `scale_name` text NOT NULL,
  `inactive` tinyint(1) NOT NULL DEFAULT 0,
  `pay_basis` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 = monthly, 1 = daily'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `fa_salary_structure`
--

CREATE TABLE `fa_salary_structure` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `salary_scale_id` int(11) NOT NULL,
  `pay_rule_id` varchar(15) NOT NULL,
  `pay_amount` double NOT NULL,
  `type` tinyint(1) NOT NULL COMMENT '0 for credit, 1 for debit',
  `is_basic` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `fa_salesman`
--

CREATE TABLE `fa_salesman` (
  `salesman_code` int(11) NOT NULL,
  `salesman_name` char(60) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `salesman_phone` char(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `salesman_fax` char(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `salesman_email` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `provision` double NOT NULL DEFAULT 0,
  `break_pt` double NOT NULL DEFAULT 0,
  `provision2` double NOT NULL DEFAULT 0,
  `inactive` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fa_salesman`
--

INSERT INTO `fa_salesman` (`salesman_code`, `salesman_name`, `salesman_phone`, `salesman_fax`, `salesman_email`, `provision`, `break_pt`, `provision2`, `inactive`) VALUES
(1, 'Sales Person', '', '', '', 5, 20000, 4, 0);

-- --------------------------------------------------------

--
-- Table structure for table `fa_sales_orders`
--

CREATE TABLE `fa_sales_orders` (
  `order_no` int(11) NOT NULL,
  `trans_type` smallint(6) NOT NULL DEFAULT 30,
  `version` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `type` tinyint(1) NOT NULL DEFAULT 0,
  `debtor_no` int(11) NOT NULL DEFAULT 0,
  `branch_code` int(11) NOT NULL DEFAULT 0,
  `reference` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `customer_ref` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `comments` tinytext COLLATE utf8_unicode_ci DEFAULT NULL,
  `ord_date` date NOT NULL DEFAULT '0000-00-00',
  `order_type` int(11) NOT NULL DEFAULT 0,
  `ship_via` int(11) NOT NULL DEFAULT 0,
  `delivery_address` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `contact_phone` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact_email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deliver_to` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `freight_cost` double NOT NULL DEFAULT 0,
  `from_stk_loc` varchar(5) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `delivery_date` date NOT NULL DEFAULT '0000-00-00',
  `payment_terms` int(11) DEFAULT NULL,
  `total` double NOT NULL DEFAULT 0,
  `prep_amount` double NOT NULL DEFAULT 0,
  `alloc` double NOT NULL DEFAULT 0,
  `gst` double NOT NULL,
  `gst_amt` double NOT NULL,
  `cst` double NOT NULL,
  `cst_amt` double NOT NULL,
  `ist` double NOT NULL,
  `ist_amt` double NOT NULL,
  `hsn_no` int(11) NOT NULL,
  `currency` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fa_sales_orders`
--

INSERT INTO `fa_sales_orders` (`order_no`, `trans_type`, `version`, `type`, `debtor_no`, `branch_code`, `reference`, `customer_ref`, `comments`, `ord_date`, `order_type`, `ship_via`, `delivery_address`, `contact_phone`, `contact_email`, `deliver_to`, `freight_cost`, `from_stk_loc`, `delivery_date`, `payment_terms`, `total`, `prep_amount`, `alloc`, `gst`, `gst_amt`, `cst`, `cst_amt`, `ist`, `ist_amt`, `hsn_no`, `currency`) VALUES
(1, 30, 1, 0, 3, 3, 'auto', '', '', '2023-01-05', 1, 2, 'patna', '', NULL, 'Raushan Kumar', 0, 'PAT', '2023-01-06', 4, 0, 0, 0, 0, 0, 0, 0, 0, 0, 632, 0),
(2, 30, 1, 0, 3, 3, 'auto', '', '', '2023-01-05', 1, 2, 'patna', '', NULL, 'Raushan Kumar', 0, 'PAT', '2023-01-06', 4, 0, 0, 0, 0, 0, 0, 0, 0, 0, 632, 0);

-- --------------------------------------------------------

--
-- Table structure for table `fa_sales_order_details`
--

CREATE TABLE `fa_sales_order_details` (
  `id` int(11) NOT NULL,
  `order_no` int(11) NOT NULL DEFAULT 0,
  `trans_type` smallint(6) NOT NULL DEFAULT 30,
  `stk_code` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `description` tinytext COLLATE utf8_unicode_ci DEFAULT NULL,
  `qty_sent` double NOT NULL DEFAULT 0,
  `unit_price` double NOT NULL DEFAULT 0,
  `quantity` double NOT NULL DEFAULT 0,
  `invoiced` double NOT NULL DEFAULT 0,
  `discount_percent` double NOT NULL DEFAULT 0,
  `gst` int(11) NOT NULL,
  `gst_amt` int(11) NOT NULL,
  `cst` int(11) NOT NULL,
  `cst_amt` int(11) NOT NULL,
  `ist` int(11) NOT NULL,
  `ist_amt` int(11) NOT NULL,
  `hsn_no` int(11) NOT NULL,
  `currency` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fa_sales_order_details`
--

INSERT INTO `fa_sales_order_details` (`id`, `order_no`, `trans_type`, `stk_code`, `description`, `qty_sent`, `unit_price`, `quantity`, `invoiced`, `discount_percent`, `gst`, `gst_amt`, `cst`, `cst_amt`, `ist`, `ist_amt`, `hsn_no`, `currency`) VALUES
(6, 1, 30, 'head001', 'head light ', 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 632, ''),
(7, 2, 30, 'head001', 'head light ', 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 632, '');

-- --------------------------------------------------------

--
-- Table structure for table `fa_sales_pos`
--

CREATE TABLE `fa_sales_pos` (
  `id` smallint(6) UNSIGNED NOT NULL,
  `pos_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `cash_sale` tinyint(1) NOT NULL,
  `credit_sale` tinyint(1) NOT NULL,
  `pos_location` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `pos_account` smallint(6) UNSIGNED NOT NULL,
  `inactive` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fa_sales_pos`
--

INSERT INTO `fa_sales_pos` (`id`, `pos_name`, `cash_sale`, `credit_sale`, `pos_location`, `pos_account`, `inactive`) VALUES
(1, 'Default', 1, 1, 'DEF', 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `fa_sales_types`
--

CREATE TABLE `fa_sales_types` (
  `id` int(11) NOT NULL,
  `sales_type` char(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `tax_included` int(1) NOT NULL DEFAULT 0,
  `factor` double NOT NULL DEFAULT 1,
  `inactive` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fa_sales_types`
--

INSERT INTO `fa_sales_types` (`id`, `sales_type`, `tax_included`, `factor`, `inactive`) VALUES
(1, 'Retail', 1, 1, 0),
(2, 'Wholesale', 0, 0.7, 0);

-- --------------------------------------------------------

--
-- Table structure for table `fa_seat_allocation`
--

CREATE TABLE `fa_seat_allocation` (
  `id` int(11) NOT NULL,
  `master_id` int(11) NOT NULL,
  `seat_no` varchar(50) NOT NULL,
  `inactive` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fa_seat_allocation`
--

INSERT INTO `fa_seat_allocation` (`id`, `master_id`, `seat_no`, `inactive`) VALUES
(1, 1, 'FA-101', 0),
(2, 1, 'FA-102', 0),
(3, 1, 'FA-103', 0),
(4, 1, 'FA-104', 0),
(5, 1, 'FA-105', 0);

-- --------------------------------------------------------

--
-- Table structure for table `fa_seat_issues`
--

CREATE TABLE `fa_seat_issues` (
  `issue_no` int(11) NOT NULL,
  `workorder_id` int(11) NOT NULL DEFAULT 0,
  `reference` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `issue_date` date DEFAULT NULL,
  `loc_code` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `workcentre_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fa_seat_issues`
--

INSERT INTO `fa_seat_issues` (`issue_no`, `workorder_id`, `reference`, `issue_date`, `loc_code`, `workcentre_id`) VALUES
(1, 1, '12', '2023-03-22', 'PAT', 2);

-- --------------------------------------------------------

--
-- Table structure for table `fa_seat_issue_items`
--

CREATE TABLE `fa_seat_issue_items` (
  `id` int(11) NOT NULL,
  `stock_id` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `issue_id` int(11) DEFAULT NULL,
  `qty_issued` double DEFAULT NULL,
  `unit_cost` double NOT NULL DEFAULT 0,
  `sl_no` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fa_seat_issue_items`
--

INSERT INTO `fa_seat_issue_items` (`id`, `stock_id`, `issue_id`, `qty_issued`, `unit_cost`, `sl_no`) VALUES
(1, 'LAP-DELL-14', 1, 1, 0, 'FB-LAPTOP-DELL-003');

-- --------------------------------------------------------

--
-- Table structure for table `fa_seat_master`
--

CREATE TABLE `fa_seat_master` (
  `id` int(11) NOT NULL,
  `building` int(11) NOT NULL,
  `floor` int(11) NOT NULL,
  `room` int(11) NOT NULL,
  `department` int(11) NOT NULL,
  `inactive` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fa_seat_master`
--

INSERT INTO `fa_seat_master` (`id`, `building`, `floor`, `room`, `department`, `inactive`) VALUES
(1, 3, 1, 40, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `fa_security_roles`
--

CREATE TABLE `fa_security_roles` (
  `id` int(11) NOT NULL,
  `role` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sections` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `areas` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `inactive` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fa_security_roles`
--

INSERT INTO `fa_security_roles` (`id`, `role`, `description`, `sections`, `areas`, `inactive`) VALUES
(1, 'Inquiries', 'Inquiries', '28928;29440;29696;29952;30464;32256;32512;768;2816;3072;3328;5632;5888;8192;8448;10752;11008;13312;15872;16128', '28933;28943;29461;29462;32522;32525;257;258;259;260;513;514;515;516;517;518;519;520;521;522;523;524;525;773;774;775;2822;3073;3075;3076;3077;3329;3330;3331;3332;3333;3334;3335;5377;5633;5640;5889;5890;5891;7937;7938;7939;7940;8193;8194;8450;8451;10497;10753;11009;11010;11012;13313;13315;15617;15618;15619;15620;15621;15622;15623;15624;15625;15626;15873;15882;16129;16130;16131;16132', 0),
(2, 'System Administrator', 'System Administrator', '28416;28672;28928;29184;29440;29696;29952;30208;30464;32256;33280;33536;256;512;768;2816;3072;3328;5376;5632;5888;7936;8192;8448;9216;9472;9728;10496;10752;11008;13056;13312;15616;15872;16128;18176;18432;20736;418816;25856;419072;419328;419584;419840;30976;31232;31744;32000;32512', '28417;28673;28674;28675;28676;28677;28679;28682;28683;28684;28685;28686;28687;28705;28688;28689;28691;28694;28697;28700;28704;28706;28707;28708;28709;28710;28711;28712;28713;28714;28715;28929;28930;28931;28932;28933;28934;28935;28936;28937;28938;28939;28940;28941;28942;28943;29185;29187;29188;29193;29194;29195;29196;29448;29449;29445;29450;29446;29452;29453;29454;29455;29460;29461;29462;29463;29464;29465;29466;29697;29698;29699;29700;29701;29702;29953;29954;29955;30209;30210;30211;30213;32257;32259;32260;33281;33282;33537;33538;257;258;259;260;513;514;515;516;517;518;519;520;521;522;523;524;525;526;769;770;771;772;773;774;775;2817;2818;2819;2820;2821;2822;2823;3073;3074;3082;3075;3076;3077;3078;3079;3080;3081;3329;3330;3331;3332;3333;3334;3335;5377;5633;5634;5635;5642;5643;5645;5644;5636;5637;5641;5638;5639;5640;5646;5889;5890;5891;7937;7938;7939;7940;8193;8194;8195;8196;8197;8199;8198;8449;8450;8451;9217;9218;9220;9473;9474;9475;9476;9729;10497;10753;10754;10755;10756;10757;11009;11010;11011;11012;13057;13313;13314;13315;15617;15618;15619;15620;15621;15622;15623;15624;15628;15625;15626;15627;15630;15629;15873;15874;15875;15876;15877;15878;15879;15880;15883;15881;15882;15884;16129;16130;16131;16132;18177;18178;18179;18180;18181;18182;18183;18184;18185;18186;18187;18444;18445;18446;18447;18448;18449;20737;20738;20739;20740;20741;418916;418917;418918;418919;418920;418921;418922;418923;418924;418925;418926;418927;418928;418929;418930;418931;418941;418942;418945;418946;418947;418948;418949;418950;418951;418952;25857;25858;419199;419200;419209;419210;419444;419445;419446;419447;419448;419449;419450;419451;419452;419723;419724;419981;419982;419983;419984;419985;419986;419987;30977;30978;30979;30980;30981;30982;30983;30984;30985;30986;30987;31233;31234;31235;31236;31237;31745;31746;31747;31748;31750;32001;32002;32003;32004;32005;32006;32007;32008;32513;32514;32515;32516;32517;32518;32519;32520;32521;32522;32523;32524;32525', 0),
(3, 'Salesman', 'Salesman', '768;3072;5632;8192;15872', '773;774;3073;3075;3081;5633;8194;15873;775', 0),
(4, 'Stock Manager', 'Stock Manager', '2816;3072;3328;5632;5888;8192;8448;10752;11008;13312;15872;16128;768', '775', 0),
(5, 'Production Manager', 'Production Manager', '512;2816;3072;3328;5632;5888;8192;8448;10752;11008;13312;15616;15872;16128;768', '775', 0),
(6, 'Purchase Officer', 'Purchase Officer', '512;2816;3072;3328;5376;5632;5888;8192;8448;10752;11008;13312;15616;15872;16128;768', '775', 0),
(7, 'AR Officer', 'AR Officer', '512;768;2816;3072;3328;5632;5888;8192;8448;10752;11008;13312;15616;15872;16128', '521;523;524;771;773;774;2818;2819;2820;2821;2822;2823;3073;3073;3074;3075;3076;3077;3078;3079;3080;3081;3081;3329;3330;3330;3330;3331;3331;3332;3333;3334;3335;5633;5633;5634;5637;5638;5639;5640;5640;5889;5890;5891;8193;8194;8194;8196;8197;8450;8451;10753;10755;11009;11010;11012;13313;13315;15617;15619;15620;15621;15624;15624;15873;15876;15877;15878;15880;15882;16129;16130;16131;16132;775', 0),
(8, 'AP Officer', 'AP Officer', '512;2816;3072;3328;5376;5632;5888;8192;8448;10752;11008;13312;15616;15872;16128;768', '775', 0),
(9, 'Accountant', 'New Accountant', '28672;28928;29184;29440;29696;30208;30464;32512;512;768;2816;3072;3328;5376;5632;5888;8192;8448;10752;11008;13312;15616;15872;16128', '28679;28683;28705;28694;28709;28713;28714;28715;28929;28930;28931;28932;28933;28934;28935;28936;28937;28938;28939;28940;28941;29185;29186;29187;29188;29189;29190;29191;29192;29193;29194;29195;29196;29441;29448;29449;29442;29443;29444;29445;29450;29446;29447;29451;29452;29453;29454;29455;29460;29461;29462;29463;29464;29465;29697;29698;29699;29700;29701;29702;30209;30210;30211;30213;32519;32520;32521;257;258;259;260;521;523;524;771;772;773;774;775;2818;2819;2820;2821;2822;2823;3073;3074;3075;3076;3077;3078;3079;3080;3081;3329;3330;3331;3332;3333;3334;3335;5377;5633;5634;5635;5637;5638;5639;5640;5889;5890;5891;7937;7938;7939;7940;8193;8194;8196;8197;8449;8450;8451;10497;10753;10755;11009;11010;11012;13313;13315;15617;15618;15619;15620;15621;15624;15873;15876;15877;15878;15880;15882;16129;16130;16131;16132', 0),
(10, 'Sub Admin', 'Sub Admin', '29184;29440;29696;512;768;2816;3072;3328;5376;5632;5888;8192;8448;10752;11008;13312;15616;15872;16128', '29188;29195;29448;29449;29445;29450;257;258;259;260;521;523;524;771;772;773;774;775;2818;2819;2820;2821;2822;2823;3073;3074;3082;3075;3076;3077;3078;3079;3080;3081;3329;3330;3331;3332;3333;3334;3335;5377;5633;5634;5635;5637;5638;5639;5640;5889;5890;5891;7937;7938;7939;7940;8193;8194;8196;8197;8449;8450;8451;10497;10753;10755;11009;11010;11012;13057;13313;13315;15617;15619;15620;15621;15624;15873;15874;15876;15877;15878;15879;15880;15882;16129;16130;16131;16132', 0),
(11, 'library', 'Admin Library', '18176;18432', '18177;18178;18179;18180;18181;18182;18183;18184;18185;18186;18187;18444;18445;18446;18447;18448;18449', 0),
(12, 'Faculty', 'Academic Faculty', '29184;29696', '29193;29194;29700', 0),
(13, 'HOD', 'HOD admin', '28672;28928;29184;29696', '28684;28685;28686;28706;28712;28940;29185;29193;29194;29698;29699;29700;29701;29702', 0),
(14, 'BED', 'BED', '28928', '28929;28935;28936', 0),
(15, 'Principal Secretary', 'Principal Secretary', '32512', '32518', 0),
(16, 'Scruitny Officer', 'Scruitny Officer', '32512', '32517', 0),
(17, 'Payment Manager', 'Payment Manager', '32512', '32520', 0),
(18, 'Sister M', 'Sister M', '29184', '29188;29195', 0),
(19, 'Alumni', 'Alumni', '33280', '33281;33282', 0),
(20, 'Seminar', 'PWC Seminar', '33536', '33537;33538', 0);

-- --------------------------------------------------------

--
-- Table structure for table `fa_self`
--

CREATE TABLE `fa_self` (
  `id` int(11) NOT NULL,
  `floor_id` varchar(100) NOT NULL,
  `floor_aisle` varchar(50) NOT NULL,
  `self_desc` text NOT NULL,
  `self_code` varchar(50) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fa_self`
--

INSERT INTO `fa_self` (`id`, `floor_id`, `floor_aisle`, `self_desc`, `self_code`, `status`) VALUES
(1, 'GR-A/001', 'GR-AS-001', 'Computer sc.', 'GR-S001', 0),
(2, 'GR-B/001', 'GR-AS-002', 'Engg. Books', 'GR-AS-S002', 0),
(3, 'SD-A001', 'SD-A-001', 'Arts Book', 'Second Arts', 0),
(4, 'SD-A002', 'SD-B-002', 'Comp and Engg', 'Self Comp. Sc.', 0),
(5, 'LGF-01', 'LGF-01', 'one', 'one', 0);

-- --------------------------------------------------------

--
-- Table structure for table `fa_shippers`
--

CREATE TABLE `fa_shippers` (
  `shipper_id` int(11) NOT NULL,
  `shipper_name` varchar(60) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `phone` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `phone2` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `contact` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `address` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `inactive` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fa_shippers`
--

INSERT INTO `fa_shippers` (`shipper_id`, `shipper_name`, `phone`, `phone2`, `contact`, `address`, `inactive`) VALUES
(2, 'ddd', '987456320', '98745620', 'ss', 'patna', 0);

-- --------------------------------------------------------

--
-- Table structure for table `fa_sql_trail`
--

CREATE TABLE `fa_sql_trail` (
  `id` int(11) UNSIGNED NOT NULL,
  `sql` text COLLATE utf8_unicode_ci NOT NULL,
  `result` tinyint(1) NOT NULL,
  `msg` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fa_statutory_body_master`
--

CREATE TABLE `fa_statutory_body_master` (
  `id` int(11) NOT NULL,
  `statutory_name` varchar(150) NOT NULL,
  `statutory_desc` varchar(150) NOT NULL,
  `inactive` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fa_statutory_body_master`
--

INSERT INTO `fa_statutory_body_master` (`id`, `statutory_name`, `statutory_desc`, `inactive`) VALUES
(1, 'PF', 'Provident Fund', 0),
(2, 'EPF', 'Employee PF', 0),
(3, 'TDS', 'Tax', 0),
(4, 'ESI.', 'ESI', 0),
(5, 'Company Registar', 'Company Registar', 0),
(6, 'Board meeting', 'Board meeting', 0),
(7, 'Review Meeting', 'Review Meeting', 0),
(8, 'Team Meeting', 'Team Meeting', 1),
(9, 'One tt', 'One rert', 0),
(10, 'Second', 'Rwer', 0),
(11, 'Ttyy', 'Rtyrty', 0);

-- --------------------------------------------------------

--
-- Table structure for table `fa_statutory_frequency_master`
--

CREATE TABLE `fa_statutory_frequency_master` (
  `freq_id` int(11) NOT NULL,
  `frequency_name` varchar(150) NOT NULL,
  `frequency_desc` varchar(150) NOT NULL,
  `inactive` int(11) NOT NULL,
  `frequency_days` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fa_statutory_frequency_master`
--

INSERT INTO `fa_statutory_frequency_master` (`freq_id`, `frequency_name`, `frequency_desc`, `inactive`, `frequency_days`) VALUES
(1, 'Monthly', 'Monthly', 0, 30),
(2, 'Quarterly', 'Quarterly', 0, 90),
(3, 'Yearly', 'Yearly', 0, 365),
(4, 'Half Yearly', 'Half Yearly', 0, 180);

-- --------------------------------------------------------

--
-- Table structure for table `fa_statutory_main`
--

CREATE TABLE `fa_statutory_main` (
  `id` int(10) NOT NULL,
  `statutory_id` int(10) NOT NULL,
  `return_id` int(10) NOT NULL,
  `freq_id` int(10) NOT NULL,
  `remider_days` int(10) NOT NULL,
  `inactive` tinyint(4) NOT NULL DEFAULT 0,
  `statutory_desc` varchar(100) NOT NULL,
  `f_year` tinyint(4) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `updated_date` date NOT NULL,
  `empl_id` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fa_statutory_main`
--

INSERT INTO `fa_statutory_main` (`id`, `statutory_id`, `return_id`, `freq_id`, `remider_days`, `inactive`, `statutory_desc`, `f_year`, `status`, `updated_date`, `empl_id`) VALUES
(1, 1, 2, 1, 0, 0, 'done', 1, 0, '2019-01-25', ''),
(2, 4, 1, 2, 0, 0, 'done 1', 1, 0, '2019-01-29', ''),
(3, 3, 2, 3, 0, 0, 'done', 1, 0, '2019-03-31', ''),
(4, 3, 2, 3, 0, 0, 'done', 1, 0, '2019-03-31', ''),
(5, 1, 2, 1, 0, 0, 'done', 1, 0, '2020-01-22', ''),
(6, 5, 5, 2, 0, 0, 'done', 1, 0, '2019-03-02', ''),
(7, 8, 8, 1, 0, 0, 'done', 1, 0, '2019-01-29', ''),
(8, 6, 6, 1, 0, 0, '', 3, 0, '2020-01-22', ''),
(9, 6, 6, 1, 0, 0, '', 1, 0, '2020-01-22', ''),
(10, 6, 6, 1, 0, 0, 'test', 1, 0, '2020-01-22', ''),
(11, 4, 1, 2, 0, 0, '', 1, 0, '2020-01-22', ''),
(12, 4, 1, 2, 0, 0, 'done', 1, 0, '2020-01-22', '');

-- --------------------------------------------------------

--
-- Table structure for table `fa_statutory_master`
--

CREATE TABLE `fa_statutory_master` (
  `id` int(10) NOT NULL,
  `statutory_id` int(10) NOT NULL,
  `return_id` int(10) NOT NULL,
  `freq_id` int(10) NOT NULL,
  `due_date` date NOT NULL,
  `remider_days` int(10) NOT NULL,
  `inactive` tinyint(4) NOT NULL DEFAULT 0,
  `statutory_desc` varchar(100) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `effective_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fa_statutory_master`
--

INSERT INTO `fa_statutory_master` (`id`, `statutory_id`, `return_id`, `freq_id`, `due_date`, `remider_days`, `inactive`, `statutory_desc`, `status`, `effective_date`) VALUES
(1, 2, 1, 4, '2019-01-28', 26, 0, 'Half Yearly', 0, '2020-07-21'),
(2, 4, 1, 2, '2019-01-28', 20, 0, 'ESI', 0, '2020-07-21'),
(3, 1, 2, 1, '2019-01-28', 6, 0, 'PF', 0, '2019-12-24'),
(4, 3, 2, 3, '2019-01-28', 60, 0, 'TDS', 0, '2021-01-27'),
(5, 5, 5, 2, '2019-01-01', 30, 0, 'All the directors have to be present', 0, '2019-04-01'),
(6, 6, 6, 1, '2019-01-31', 5, 0, 'Monthly Board meeting Reminder', 0, '2020-04-25'),
(7, 7, 7, 1, '2019-02-28', 10, 0, 'Review meeting', 0, '2019-09-26'),
(8, 8, 8, 1, '2019-01-30', 3, 0, 'Monthly Team Meeting', 0, '2019-09-27'),
(9, 9, 9, 2, '2019-01-31', 14, 0, 'fger', 0, '2020-01-26'),
(10, 10, 10, 2, '2019-01-31', 14, 0, 'qwerwe', 0, '2020-01-26');

-- --------------------------------------------------------

--
-- Table structure for table `fa_statutory_uploads`
--

CREATE TABLE `fa_statutory_uploads` (
  `id` bigint(20) NOT NULL,
  `statutory_main_id` bigint(20) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `file_name` varchar(255) NOT NULL,
  `unique_name` varchar(255) NOT NULL,
  `updated_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fa_statutory_uploads`
--

INSERT INTO `fa_statutory_uploads` (`id`, `statutory_main_id`, `title`, `file_name`, `unique_name`, `updated_date`) VALUES
(1, 1, 'PF', 'Purchase.docx', '5c4acd709a7db', '2019-01-25'),
(2, 2, '', 'book.jpg', '5ca05babbf815', '2019-03-31'),
(3, 4, '', 'book.jpg', '5ca05bd384820', '2019-03-31'),
(4, 5, '', 'book.jpg', '5c7a2b0628ea9', '2019-03-02'),
(5, 6, 'MOM', 'book.jpg', '5c7a71c4bcfb4', '2019-03-02'),
(6, 6, 'member', 'Signature.docx', '5c7a71c4dcde8', '2019-03-02'),
(7, 2, 'esi title', 'logo.png', '5c4fec1fb9ab3', '2019-01-29'),
(8, 7, 'MOM', 'CSS.docx', '5c4fecca5fe08', '2019-01-29');

-- --------------------------------------------------------

--
-- Table structure for table `fa_stock_category`
--

CREATE TABLE `fa_stock_category` (
  `category_id` int(11) NOT NULL,
  `description` varchar(60) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `dflt_tax_type` int(11) NOT NULL DEFAULT 1,
  `dflt_units` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'each',
  `dflt_mb_flag` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'B',
  `dflt_sales_act` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `dflt_cogs_act` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `dflt_inventory_act` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `dflt_adjustment_act` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `dflt_wip_act` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `dflt_dim1` int(11) DEFAULT NULL,
  `dflt_dim2` int(11) DEFAULT NULL,
  `inactive` tinyint(1) NOT NULL DEFAULT 0,
  `dflt_no_sale` tinyint(1) NOT NULL DEFAULT 0,
  `dflt_no_purchase` tinyint(1) NOT NULL DEFAULT 0,
  `dflt_assembly_act` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fa_stock_category`
--

INSERT INTO `fa_stock_category` (`category_id`, `description`, `dflt_tax_type`, `dflt_units`, `dflt_mb_flag`, `dflt_sales_act`, `dflt_cogs_act`, `dflt_inventory_act`, `dflt_adjustment_act`, `dflt_wip_act`, `dflt_dim1`, `dflt_dim2`, `inactive`, `dflt_no_sale`, `dflt_no_purchase`, `dflt_assembly_act`) VALUES
(1, 'AC\r\n', 1, 'box', 'B', '4010', '5010', '1510', '5040', '1530', 0, 0, 0, 0, 0, ''),
(2, 'BAGPACK\r\n', 1, 'box', 'D', '4010', '5010', '1510', '5040', '1530', 0, 0, 0, 0, 0, ''),
(3, 'BATTERY\r\n', 1, 'box', 'M', '4010', '5010', '1510', '5040', '1530', 0, 0, 0, 0, 0, ''),
(4, 'BOIMETRIC\r\n', 1, 'box', 'D', '4010', '5010', '1510', '5040', '1530', 0, 0, 0, 0, 0, ''),
(5, 'Cable\r\n', 1, 'box', 'D', '4010', '5010', '1510', '5040', '1530', 0, 0, 0, 0, 0, ''),
(6, 'CCTV', 1, 'box', 'D', '4010', '5010', '1510', '5040', '1530', 0, 0, 0, 0, 0, ''),
(7, 'Computer Hardware\r\n', 1, 'box', 'D', '4010', '5010', '1510', '5040', '1530', 0, 0, 0, 0, 0, ''),
(8, 'Computer Software', 1, 'box', 'D', '4010', '5010', '1510', '5040', '1530', 0, 0, 0, 0, 0, ''),
(9, 'ELECTRONIC HARDWARE', 1, 'box', 'D', '4010', '5010', '1510', '5040', '1530', 0, 0, 0, 0, 0, ''),
(10, 'LAPTOP', 1, 'box', 'D', '4010', '5010', '1510', '5040', '1530', 0, 0, 0, 0, 0, ''),
(11, 'laptop hardware', 1, 'box', 'D', '4010', '5010', '1510', '5040', '1530', 0, 0, 0, 0, 0, ''),
(12, 'LOCK', 1, 'box', 'D', '4010', '5010', '1510', '5040', '1530', 0, 0, 0, 0, 0, ''),
(13, 'Mobile', 1, 'box', 'D', '4010', '5010', '1510', '5040', '1530', 0, 0, 0, 0, 0, ''),
(14, 'Router', 1, 'box', 'D', '4010', '5010', '1510', '5040', '1530', 0, 0, 0, 0, 0, ''),
(15, 'TV', 1, 'box', 'D', '4010', '5010', '1510', '5040', '1530', 0, 0, 0, 0, 0, ''),
(16, 'Light', 1, 'pc.', 'B', '', '', '', '', '', 0, 0, 0, 0, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `fa_stock_category_old`
--

CREATE TABLE `fa_stock_category_old` (
  `category_id` int(11) NOT NULL,
  `description` varchar(60) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `dflt_tax_type` int(11) NOT NULL DEFAULT 1,
  `dflt_units` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'each',
  `dflt_mb_flag` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'B',
  `dflt_sales_act` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `dflt_cogs_act` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `dflt_inventory_act` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `dflt_adjustment_act` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `dflt_wip_act` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `dflt_dim1` int(11) DEFAULT NULL,
  `dflt_dim2` int(11) DEFAULT NULL,
  `inactive` tinyint(1) NOT NULL DEFAULT 0,
  `dflt_no_sale` tinyint(1) NOT NULL DEFAULT 0,
  `dflt_no_purchase` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fa_stock_category_old`
--

INSERT INTO `fa_stock_category_old` (`category_id`, `description`, `dflt_tax_type`, `dflt_units`, `dflt_mb_flag`, `dflt_sales_act`, `dflt_cogs_act`, `dflt_inventory_act`, `dflt_adjustment_act`, `dflt_wip_act`, `dflt_dim1`, `dflt_dim2`, `inactive`, `dflt_no_sale`, `dflt_no_purchase`) VALUES
(1, 'Components', 1, 'each', 'B', '4010', '5010', '1510', '5040', '1530', 0, 0, 0, 0, 0),
(2, 'Charges', 1, 'each', 'D', '4010', '5010', '1510', '5040', '1530', 0, 0, 0, 0, 0),
(3, 'Systems', 1, 'each', 'M', '4010', '5010', '1510', '5040', '1530', 0, 0, 0, 0, 0),
(4, 'Services', 1, 'hrs', 'D', '4010', '5010', '1510', '5040', '1530', 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `fa_stock_fa_class`
--

CREATE TABLE `fa_stock_fa_class` (
  `fa_class_id` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `parent_id` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `description` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `long_description` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `depreciation_rate` double NOT NULL DEFAULT 0,
  `inactive` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fa_stock_master`
--

CREATE TABLE `fa_stock_master` (
  `stock_id` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `category_id` int(11) NOT NULL DEFAULT 0,
  `tax_type_id` int(11) NOT NULL DEFAULT 0,
  `description` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `long_description` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `units` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'each',
  `mb_flag` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'B',
  `sales_account` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cogs_account` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `inventory_account` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `adjustment_account` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `wip_account` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `dimension_id` int(11) DEFAULT NULL,
  `dimension2_id` int(11) DEFAULT NULL,
  `purchase_cost` double NOT NULL DEFAULT 0,
  `material_cost` double NOT NULL DEFAULT 0,
  `labour_cost` double NOT NULL DEFAULT 0,
  `overhead_cost` double NOT NULL DEFAULT 0,
  `inactive` tinyint(1) NOT NULL DEFAULT 0,
  `no_sale` tinyint(1) NOT NULL DEFAULT 0,
  `no_purchase` tinyint(1) NOT NULL DEFAULT 0,
  `editable` tinyint(1) NOT NULL DEFAULT 0,
  `depreciation_method` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'S',
  `depreciation_rate` double NOT NULL DEFAULT 0,
  `depreciation_factor` double NOT NULL DEFAULT 0,
  `depreciation_start` date NOT NULL DEFAULT '0000-00-00',
  `depreciation_date` date NOT NULL DEFAULT '0000-00-00',
  `fa_class_id` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `sub_cat_name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `types` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `warranty` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `to_date` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `from_date` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `weight` float NOT NULL,
  `assembly_account` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `sl_no` tinyint(2) NOT NULL DEFAULT 0,
  `cat_group` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fa_stock_master`
--

INSERT INTO `fa_stock_master` (`stock_id`, `category_id`, `tax_type_id`, `description`, `long_description`, `units`, `mb_flag`, `sales_account`, `cogs_account`, `inventory_account`, `adjustment_account`, `wip_account`, `dimension_id`, `dimension2_id`, `purchase_cost`, `material_cost`, `labour_cost`, `overhead_cost`, `inactive`, `no_sale`, `no_purchase`, `editable`, `depreciation_method`, `depreciation_rate`, `depreciation_factor`, `depreciation_start`, `depreciation_date`, `fa_class_id`, `sub_cat_name`, `types`, `warranty`, `to_date`, `from_date`, `weight`, `assembly_account`, `sl_no`, `cat_group`) VALUES
('AC-STAR-EMP-SPLIT', 1, 1, 'Star Emperiya CX SPLIT AC', 'Star Emperiya CX SPLIT AC', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '45', '1', '1', '', '', 1, '', 1, 0),
('AC-SUM-AA128Y4ZAPGNNA', 1, 1, 'Samsung Ac (AA128Y4ZAPGNNA)', 'Samsung Ac (AA128Y4ZAPGNNA)', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '45', '1', '1', '', '', 1, '', 1, 0),
('ADAP-CONVERTER-TC', 7, 1, 'Type C to USB Converter Adaptor ', 'Type C to USB Converter Adaptor ', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '2', '1', '1', '', '', 1, '', 1, 0),
('ADAP-EP-TA611BE-V5 ', 7, 1, 'Samsung adaptor ( EP -TA611BE V5 )     For Shivani', 'Samsung adaptor ( EP -TA611BE V5 )     For Shivani', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '2', '1', '1', '', '', 1, '', 1, 0),
('ADAP-LAP', 7, 1, 'Lapcare laptop adaptor ', 'Lapcare laptop adaptor ', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '2', '1', '1', '', '', 1, '', 1, 0),
('ADAP-LAPCARE', 7, 1, 'Laptop Adapter Lap care', 'Laptop Adapter Lap care', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '2', '1', '1', '', '', 1, '', 1, 0),
('ADAP-NT-UE300C-TC', 7, 1, 'Type C to RJ45 Gigabit Network Adapter (Model :- UE300C(UN)', 'Type C to RJ45 Gigabit Network Adapter (Model :- UE300C(UN)', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '2', '1', '1', '', '', 1, '', 1, 0),
('ADAP-NT-UE300C-USB3', 7, 1, 'USB 3.0 to Gigabyte Etherney Adapter (Model :- UE300C(UN)', 'USB 3.0 to Gigabyte Etherney Adapter (Model :- UE300C(UN)', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '2', '1', '1', '', '', 1, '', 1, 0),
('ADAP-USB-SATA', 7, 1, 'Xcess Sata Usb casing', 'Xcess Sata Usb casing', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '2', '1', '1', '', '', 1, '', 1, 0),
('ADAP-USB-T3-QZ-AD11', 7, 1, 'USB 3.1 Type C to Type a Converter (QZ AD11)', 'USB 3.1 Type C to Type a Converter (QZ AD11)', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '2', '1', '1', '', '', 1, '', 1, 0),
('ADAP-USB-T3-VIBOTON', 7, 1, 'M2 Casing Type C to usb 3.0 (VIBOTON)', 'M2 Casing Type C to usb 3.0 (VIBOTON)', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '2', '1', '1', '', '', 1, '', 1, 0),
('ADAP-WIRELESS-T2U', 7, 1, 'Tp-Link Nano usb wireless adaptor (archer t2u nano us ver 1.0)', 'Tp-Link Nano usb wireless adaptor (archer t2u nano us ver 1.0)', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '2', '1', '1', '', '', 1, '', 1, 0),
('BAT-150AH-T-E', 3, 1, 'Exide inva tall tublar battery  150 AH , 12 V (FEMO-IMTT1500)', 'Exide inva tall tublar battery  150 AH , 12 V (FEMO-IMTT1500)', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '18', '1', '1', '', '', 1, '', 1, 0),
('BAT-42AH-E', 3, 1, 'Exide 24 Nos Battery ( 42 AH )', 'Exide 24 Nos Battery ( 42 AH )', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '18', '1', '1', '', '', 1, '', 1, 0),
('BAT-65AH-E', 3, 1, 'Development Floor Ups 16 Battery (Exide 65 Ah Powersafe Plus) 2 Year Warranty ', 'Development Floor Ups 16 Battery (Exide 65 Ah Powersafe Plus) 2 Year Warranty ', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '18', '1', '1', '', '', 1, '', 1, 0),
('BAT-EP65-12-E', 3, 1, 'EXIDE EP 65-12 BATTERY', 'EXIDE EP 65-12 BATTERY', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '18', '1', '1', '', '', 1, '', 1, 0),
('BAT-LAP-B', 3, 1, 'Laptop Battery For Bimlesh ', 'Laptop Battery For Bimlesh ', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '22', '1', '1', '', '', 1, '', 1, 0),
('BAT-LAP-HPOA04', 3, 1, 'Lap care battery (HPOA04)', 'Lap care battery (HPOA04)', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '22', '1', '1', '', '', 1, '', 1, 0),
('BAT-LAP-INEX', 3, 1, 'Dell inspiron laptop battery (Lapkit inex)', 'Dell inspiron laptop battery (Lapkit inex)', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '22', '1', '1', '', '', 1, '', 1, 0),
('BAT-LAP-LAOBT6C2196', 3, 1, 'Laptop Battery for Acer Laptop (LAOBT6C2196)', 'Laptop Battery for Acer Laptop (LAOBT6C2196)', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '22', '1', '1', '', '', 1, '', 1, 0),
('BAT-LAP-N4010', 3, 1, 'Dell laptop Battery(DELL Inspiron 14R(N4010) 6 Cell Laptop Battery)', 'Dell laptop Battery(DELL Inspiron 14R(N4010) 6 Cell Laptop Battery)', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '22', '1', '1', '', '', 1, '', 1, 0),
('BAT-LAP-OA04', 3, 1, 'Lapcare Compatible battery ( OA04)', 'Lapcare Compatible battery ( OA04)', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '22', '1', '1', '', '', 1, '', 1, 0),
('BAT-LAP-TC-3817U', 3, 1, 'Laptop Battery for standby laptop Thoshiba ( Modal no :- TC-3817U', 'Laptop Battery for standby laptop Thoshiba ( Modal no :- TC-3817U', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '22', '1', '1', '', '', 1, '', 1, 0),
('BAT-MICRO-L', 3, 1, 'Micro Lithium ion Battery  ', 'Micro Lithium ion Battery  ', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '25', '1', '1', '', '', 1, '', 1, 0),
('BAT-UPS-HB1875', 3, 1, '                     MICROTEK SINE WAVE INVERTER UPS HB1875', '                     MICROTEK SINE WAVE INVERTER UPS HB1875', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '19', '1', '1', '', '', 1, '', 1, 0),
('BIOCARD', 4, 1, 'Biometric Card Access ', 'Biometric Card Access ', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '1', '1', '1', '', '', 1, '', 1, 0),
('CAB-CORSIAR', 7, 1, 'Corsiar Cabinet', 'Corsiar Cabinet', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '3', '1', '1', '', '', 1, '', 1, 0),
('CAB-FING-SMPS', 7, 1, 'Fingures Cabinet with SMPS ', 'Fingures Cabinet with SMPS ', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '3', '1', '1', '', '', 1, '', 1, 0),
('CAB-FINGERS', 7, 1, 'Fingers cabinet ', 'Fingers cabinet ', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '3', '1', '1', '', '', 1, '', 1, 0),
('CAB-HDMI', 5, 1, 'MERCURY HDMI CABLE 20 MTR', 'MERCURY HDMI CABLE 20 MTR', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '15', '1', '1', '', '', 1, '', 1, 0),
('CAB-IBALL', 7, 1, 'I ball cabinet', 'I ball cabinet', 'pc.', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '3', '1', '1', '25-01-2022', '31-01-2023', 1, '', 1, 0),
('CAB-ORSAIR', 7, 1, 'CABINETC ORSAIR (Modal no :- spec 01)', 'CABINETC ORSAIR (Modal no :- spec 01)', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '3', '1', '1', '', '', 1, '', 1, 0),
('CAB-POWER', 5, 1, 'Laptop power cable ( Dell )', 'Laptop power cable ( Dell )', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '35', '1', '1', '', '', 1, '', 1, 0),
('CAB-TYPE-C', 5, 1, 'Mi Braided USB Type -C Cable', 'Mi Braided USB Type -C Cable', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '4', '1', '1', '', '', 1, '', 1, 0),
('CPU-I3-10105', 7, 1, 'Cpu core i3-10105 3.7 GHZ 6 MB Cache ', 'Cpu core i3-10105 3.7 GHZ 6 MB Cache ', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '7', '1', '1', '', '', 1, '', 1, 0),
('CPU-I3-BX8070110100', 7, 1, 'i3 10th Gen 3.2Ghz (BX8070110100 )', 'i3 10th Gen 3.2Ghz (BX8070110100 )', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '7', '1', '1', '', '', 1, '', 1, 0),
('CPU-I5-10400', 7, 1, 'CPU i5 2.9 Ghz ( 10400)', 'CPU i5 2.9 Ghz ( 10400)', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '7', '1', '1', '', '', 1, '', 1, 0),
('CPU-I5-8400', 7, 1, 'I5-8400 Cpu', 'I5-8400 Cpu', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '7', '1', '1', '16-06-2021', '11-06-2022', 1, '', 1, 1),
('cpui3', 7, 1, 'cpu i3', 'cpu i3', 'pc.', 'M', '1001', '', '1001', '1001', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '7', '1', '1', '', '', 0, '1001', 1, 0),
('cpum', 7, 1, 'cpimi3', 'cpumi3 8gb', 'box', 'B', '', '', '', '', '', NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '7', '1', '', '', '', 0, '', 1, 0),
('DL-ESSL-EML600-2', 12, 1, 'Door Lock Essl Em ( Modal No :- EML600-2 )', 'Door Lock Essl Em ( Modal No :- EML600-2 )', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '8', '1', '1', '', '', 1, '', 1, 0),
('DS-2CD1323G0E-I ', 6, 1, 'Hikvision Dome Camera Moadl no :- ( DS-2CD1323G0E-I )', 'Hikvision Dome Camera Moadl no :- ( DS-2CD1323G0E-I )', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '5', '1', '1', '', '', 1, '', 1, 0),
('DS-2CD2023G2-IU', 6, 1, 'Hikvision Bullet Camea:- Modal no :- ( DS-2CD2023G2-IU )', 'Hikvision Bullet Camea:- Modal no :- ( DS-2CD2023G2-IU )', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '5', '1', '1', '', '', 1, '', 1, 0),
('DS-2CE1AC0T-IRPF', 6, 1, 'Hikvision Bullet camera ( Modal no :- DS-2CE1AC0T-IRPF = 1 Mp ) ', 'Hikvision Bullet camera ( Modal no :- DS-2CE1AC0T-IRPF = 1 Mp ) ', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '5', '1', '1', '', '', 1, '', 1, 0),
('ESSL-AM-X990', 4, 1, 'Attandance Machine Essl  (Model no :-  X990 + ID)', 'Attandance Machine Essl  (Model no :-  X990 + ID)', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '38', '1', '1', '', '', 1, '', 1, 0),
('ESSL-FR1200 ', 4, 1, 'Fingure Reaer Essl ( Modal no :- FR1200 , RS 485 )', 'Fingure Reaer Essl ( Modal no :- FR1200 , RS 485 )', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '9', '1', '1', '', '', 1, '', 1, 0),
('FIREWALL-FGT-60F', 8, 1, 'Fortigate 60 F Model :- ( FG-60F)', 'Fortigate 60 F Model :- ( FG-60F)', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '10', '1', '1', '', '', 1, '', 1, 0),
('FIREWALL-FGT-80F', 8, 1, 'Fortinet 80F Firewall with 3 Years fotigaurd suscribition  ', 'Fortinet 80F Firewall with 3 Years fotigaurd suscribition  ', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '10', '1', '1', '', '', 1, '', 1, 0),
('FOOTPEDAL-ODIN', 7, 1, 'Odin FootPedal ', 'Odin FootPedal ', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '11', '1', '1', '', '', 1, '', 1, 0),
('GEN-JSPF-35X-3PH', 9, 1, '35 KVA Jakson Cummions Gen-set  3 Phase ( JSPF-35X (3PH)', '35 KVA Jakson Cummions Gen-set  3 Phase ( JSPF-35X (3PH)', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '12', '1', '1', '', '', 1, '', 1, 0),
('GEN-SNMP-MCY-EN', 9, 1, 'SNMP CARD ( SNMP web pro   Modal no :- SNMP-MCY-EN )', 'SNMP CARD ( SNMP web pro   Modal no :- SNMP-MCY-EN )', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '12', '1', '1', '', '', 1, '', 1, 0),
('GR-CARD-N-GT-70', 7, 1, 'Nvidia Geforce GT 70 Graphics card ', 'Nvidia Geforce GT 70 Graphics card ', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '13', '1', '1', '', '', 1, '', 1, 0),
('GR-CARD-Z-GTX-1050', 7, 1, 'Graphics Card 4 GB ,128 BIT ,GDDR5  Zotac Modal No :- (Zotac Geforce GTX 1050 Ti oc)', 'Graphics Card 4 GB ,128 BIT ,GDDR5  Zotac Modal No :- (Zotac Geforce GTX 1050 Ti oc)', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '13', '1', '1', '', '', 1, '', 1, 0),
('HDD-1TB', 7, 1, 'Segate 1 TB Barracaudda Hdd', 'Segate 1 TB Barracaudda Hdd', 'box', 'M', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '14', '1', '1', '19-01-2022', '31-01-2023', 1, '', 1, 0),
('HDD-500GB', 7, 1, 'NVME Kingston 500 GB ', 'NVME Kingston 500 GB ', 'box', 'M', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '14', '1', '1', '', '', 1, '', 1, 0),
('HDD-HDD-1TB', 7, 1, 'HDD Segate 1 TB Barracudda ', 'HDD Segate 1 TB Barracudda ', 'box', 'M', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '14', '1', '1', '', '', 1, '', 1, 0),
('HDD-HDD-2TB', 7, 1, 'Segate 2 TB HDD ', 'Segate 2 TB HDD ', 'box', 'M', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '14', '1', '1', '', '', 1, '', 1, 0),
('HDD-SATA-2TB', 7, 1, 'Samsung 870 EVO  - 2TB SATA SSD (MZ-77E2T0)', 'Samsung 870 EVO  - 2TB SATA SSD (MZ-77E2T0)', 'box', 'M', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '14', '1', '1', '', '', 1, '', 1, 0),
('HDD-SATA-8TB', 7, 1, 'HDD 8TB SATA SEGATE SURVILLANCE', 'HDD 8TB SATA SEGATE SURVILLANCE', 'box', 'M', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '14', '1', '1', '', '', 1, '', 1, 0),
('HDD-SSD-1TB', 7, 1, 'USB SSD :- 1 TB Samsung Protable SSD T5 ( Modal No :- MU-PA1T0B )', 'USB SSD :- 1 TB Samsung Protable SSD T5 ( Modal No :- MU-PA1T0B )', 'box', 'M', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '14', '1', '1', '', '', 1, '', 1, 0),
('HDD-SSD-250GB', 7, 1, 'SSD Segate Barracuda 250 GB ', 'SSD Segate Barracuda 250 GB ', 'box', 'M', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '14', '1', '1', '', '', 1, '', 1, 0),
('HDD-SSD-2TB', 7, 1, 'Samsung 970 EVO Plus Series - 2TB PCIe NVMe - M.2 Internal SSD | B07MLJD32L', 'Samsung 970 EVO Plus Series - 2TB PCIe NVMe - M.2 Internal SSD | B07MLJD32L', 'box', 'M', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '14', '1', '1', '', '', 1, '', 1, 0),
('HDD-SSD-480GB', 7, 1, 'WD Green 480 GB SSD ', 'WD Green 480 GB SSD ', 'box', 'M', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '14', '1', '1', '', '', 1, '', 1, 0),
('HDD-SSD-500GB', 7, 1, 'SSD  SAMSUNG 98O EVO NVME 5OOGB ( MZ-V8V500BW )', 'SSD  SAMSUNG 98O EVO NVME 5OOGB ( MZ-V8V500BW )', 'box', 'M', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '14', '1', '1', '', '', 1, '', 1, 0),
('HDMI-CONVERTER', 7, 1, 'Display port to Feamle HDMI converter ', 'Display port to Feamle HDMI converter ', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '16', '1', '1', '', '', 1, '', 1, 0),
('head001', 16, 1, 'head light ', 'tata motors head light', 'pc.', 'B', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '49', '1', '', '', '', 0, '', 1, 0),
('HEADPHONE-D3', 7, 1, 'Usb Headphone i ball upbeat d3 with mic ', 'Usb Headphone i ball upbeat d3 with mic ', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '17', '1', '1', '', '', 1, '', 1, 0),
('HEADPHONE-F-10', 7, 1, 'Finger\'s F10 Headphone ', 'Finger\'s F10 Headphone ', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '17', '1', '1', '', '', 1, '', 1, 0),
('HEADPHONE-F10', 7, 1, 'Finger\'s F10 Headphone ', 'Finger\'s F10 Headphone ', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '17', '1', '1', '', '', 1, '', 1, 0),
('HEADPHONE-F5', 7, 1, 'Finger\'s F5 Single jack headphone (Showstopper)', 'Finger\'s F5 Single jack headphone (Showstopper)', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '17', '1', '1', '', '', 1, '', 1, 0),
('HEADPHONE-G231', 7, 1, 'Logitech gaming headphone G231 prodigy ', 'Logitech gaming headphone G231 prodigy ', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '17', '1', '1', '09-12-2021', '30-12-2022', 1, '', 1, 0),
('HEADPHONE-G331', 7, 1, 'Logoitech gaming headphone G331 Warranty Return of G231', 'Logoitech gaming headphone G331 Warranty Return of G231', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '17', '1', '1', '', '', 1, '', 1, 0),
('HEADPHONE-G340', 7, 1, 'Ligitech H340 usb headphone ', 'Ligitech H340 usb headphone ', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '17', '1', '1', '', '', 1, '', 1, 0),
('HEADPHONE-H-111', 7, 1, 'Logitech H111 Singal jack Headphone ', 'Logitech H111 Singal jack Headphone ', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '17', '1', '1', '', '', 1, '', 1, 0),
('HEADPHONE-H-340', 7, 1, 'Ligitech H340 usb headphone ', 'Ligitech H340 usb headphone ', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '17', '1', '1', '', '', 1, '', 1, 0),
('HEADPHONE-H5', 7, 1, 'Finger\'s show stoper H5', 'Finger\'s show stoper H5', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '17', '1', '1', '', '', 1, '', 1, 0),
('HEADPHONE-H9', 7, 1, 'Finger\'s Usb-Tonic H9 Hedaphone', 'Finger\'s Usb-Tonic H9 Hedaphone', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '17', '1', '1', '', '', 1, '', 1, 0),
('KEYBOARD', 7, 1, 'Dell vostro 2520 Keyboard (Newtrix)', 'Dell vostro 2520 Keyboard (Newtrix)', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '21', '1', '1', '', '', 1, '', 1, 0),
('L-BAG-HP', 2, 1, 'Laptop Bag for Hp Pavillion ', 'Laptop Bag for Hp Pavillion ', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '24', '1', '1', '', '', 1, '', 1, 0),
('L-BAG-LENOVO', 2, 1, 'Lenovo Bagpack ', 'Lenovo Bagpack ', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '24', '1', '1', '', '', 1, '', 1, 0),
('L-BAG-LP-BLUE', 2, 1, 'Bag (HS.CANVOBNP L P 01 Blue)', 'Bag (HS.CANVOBNP L P 01 Blue)', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '24', '1', '1', '', '', 1, '', 1, 0),
('L-BAG-LP-GRAY', 2, 1, 'Bag (HS.CANVOBNP L P 01 Gray)', 'Bag (HS.CANVOBNP L P 01 Gray)', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '24', '1', '1', '', '', 1, '', 1, 0),
('LAP-ASUS-X509J', 10, 1, 'Asus Laptop vivo book ( X509J )', 'Asus Laptop vivo book ( X509J )', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '23', '1', '1', '', '', 1, '', 1, 0),
('LAP-DELL-14', 10, 1, 'Dell inspiron laptop ( 14\" paper 40 pin )', 'Dell inspiron laptop ( 14\" paper 40 pin )', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '23', '1', '1', '', '', 1, '', 1, 0),
('LAP-DELL-IP-3511', 10, 1, 'Dell New 2022 Inspiron 3511 (Modal No:- Inspiron 3511, i3 11th gen, 8GB DDR4,256 GB Nvme,1TB HDD)', 'Dell New 2022 Inspiron 3511 (Modal No:- Inspiron 3511, i3 11th gen, 8GB DDR4,256 GB Nvme,1TB HDD)', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '23', '1', '1', '', '', 1, '', 1, 0),
('LAP-HP-15-EG2039TU', 10, 1, 'Hp Pavillion Laptop :- 15-EG2039TU ( i7-1260P . 16 GB RAM , 1 TB NVME 15.6\" Display )', 'Hp Pavillion Laptop :- 15-EG2039TU ( i7-1260P . 16 GB RAM , 1 TB NVME 15.6\" Display )', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '23', '1', '1', '', '', 1, '', 1, 0),
('LAP-HP-15Q', 10, 1, 'Laptop HP 15Q core i5 8th gen 8 GB ', 'Laptop HP 15Q core i5 8th gen 8 GB ', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '23', '1', '1', '', '', 1, '', 1, 0),
('LAP-HP-EG2039TU', 10, 1, 'Hp Pavillion Laptop :- 15-EG2039TU ( i7-1260P . 16 GB RAM , 1 TB NVME 15.6\" Display )', 'Hp Pavillion Laptop :- 15-EG2039TU ( i7-1260P . 16 GB RAM , 1 TB NVME 15.6\" Display )', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '23', '1', '1', '', '', 1, '', 1, 0),
('LAP-IPAD-A1893', 10, 1, 'Apple i pad  (Modal no :-A1893)', 'Apple i pad  (Modal no :-A1893)', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '20', '1', '1', '', '', 1, '', 1, 0),
('LAP-IPAD-L14ITL6 ', 10, 1, 'Lenovo IdeaPad 5 Pro 14ITL6 ( i7-1165G7 2.80Ghz , 16 GB RAM ,500GB NVME)', 'Lenovo IdeaPad 5 Pro 14ITL6 ( i7-1165G7 2.80Ghz , 16 GB RAM ,500GB NVME)', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '20', '1', '1', '', '', 1, '', 1, 0),
('LAP-SUM-MO1', 10, 1, 'Samsung Core MO1 ( SM -M013F/DS )   For Shivani', 'Samsung Core MO1 ( SM -M013F/DS )   For Shivani', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '23', '1', '1', '', '', 1, '', 1, 0),
('LAPCARE-LCP-111', 11, 1, 'Laptop Cooling Pad (Lapcare :- LCP-111)', 'Laptop Cooling Pad (Lapcare :- LCP-111)', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '6', '1', '1', '', '', 1, '', 1, 0),
('LOGI-WEBCAM-C270', 7, 1, 'Logitech Web Cam ( C270 )', 'Logitech Web Cam ( C270 )', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '48', '1', '1', '28-12-2021', '28-12-2021', 1, '', 1, 0),
('M-CHARGE-MI', 13, 1, 'Mi Sonic Charger 2.0 Modal No :- MDY-11-EL ', 'Mi Sonic Charger 2.0 Modal No :- MDY-11-EL ', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '28', '1', '1', '', '', 1, '', 1, 0),
('M-MICROMAX-412', 13, 1, 'Micromax x412 Mobile Phone with Adaptor ( ACC05C14)', 'Micromax x412 Mobile Phone with Adaptor ( ACC05C14)', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '27', '1', '1', '', '', 1, '', 1, 0),
('M-PHONE-BY-M1', 7, 1, 'Boya ( BY-M1) Microphone ', 'Boya ( BY-M1) Microphone ', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '26', '1', '1', '', '', 1, '', 1, 0),
('M-REDMI-9', 13, 1, 'Redmi 9 Power Modal No :- M2010J19SI (Electric Green, 4GB RAM, 64GB Storage) - 6000mAh Battery B089MS8HPF                         ( REDMI9PWGREEN-4+64GB )', 'Redmi 9 Power Modal No :- M2010J19SI (Electric Green, 4GB RAM, 64GB Storage) - 6000mAh Battery B089MS8HPF                         ( REDMI9PWGREEN-4+64GB )', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '27', '1', '1', '', '', 1, '', 1, 0),
('MON-22MP68VQ-22', 7, 1, 'Lg 22\" ips monitor modal no :- 22MP68VQ', 'Lg 22\" ips monitor modal no :- 22MP68VQ', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '29', '1', '1', '', '', 1, '', 1, 0),
('MON-24MK600M-24', 7, 1, 'Lg 24MK600M 24\"', 'Lg 24MK600M 24\"', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '29', '1', '1', '09-12-2021', '30-12-2022', 1, '', 1, 0),
('MON-E2421HN-24', 7, 1, 'MONITOR DELL 24 Modal No :- (E2421HN) WITH VGA+HDMI', 'MONITOR DELL 24 Modal No :- (E2421HN) WITH VGA+HDMI', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '29', '1', '1', '', '', 1, '', 1, 0),
('MON-FRONTECH', 7, 1, 'Frontech', 'Frontech', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '29', '1', '1', '', '', 1, '', 1, 0),
('MON-GW2280-B-22', 7, 1, 'Benq GW2280-B 22\" ', 'Benq GW2280-B 22\" ', 'pc.', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '29', '1', '1', '', '', 1, '', 1, 0),
('MON-GW2480-B-24', 7, 1, 'Benq Monitor 24\" (GW2480-B)', 'Benq Monitor 24\" (GW2480-B)', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '29', '1', '1', '', '', 1, '', 1, 0),
('MON-GW2480-T-24', 7, 1, 'BenQ GW2480 24-inch', 'BenQ GW2480 24-inch', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '29', '1', '1', '', '', 1, '', 1, 0),
('MON-LED-LF24T352FHWXXL-24', 7, 1, 'SAMSUNG 24\" LED MONITOR (Modal No :- LF24T352FHWXXL)', 'SAMSUNG 24\" LED MONITOR (Modal No :- LF24T352FHWXXL)', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '29', '1', '1', '', '', 1, '', 1, 0),
('MON-S2421H-24', 7, 1, 'Dell 24\" Ips Monitor Modal No :- S2421H ', 'Dell 24\" Ips Monitor Modal No :- S2421H ', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '29', '1', '1', '', '', 1, '', 1, 0),
('MON-S2421HN-24', 7, 1, 'Monitor dell 24\" Modal No: ( S2421HN )', 'Monitor dell 24\" Modal No: ( S2421HN )', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '29', '1', '1', '', '', 1, '', 1, 0),
('MOUSE-PAD', 7, 1, 'Mouse pad', 'Mouse pad', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '33', '1', '1', '', '', 1, '', 1, 0),
('MOUSE-USB', 7, 1, 'Logitech Combo Mk-120 Keyboard & Mouse ', 'Logitech Combo Mk-120 Keyboard & Mouse ', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '31', '1', '1', '', '', 1, '', 1, 0),
('MOUSE-USB-M90', 7, 1, 'Logitech Usb Mouse (M90)', 'Logitech Usb Mouse (M90)', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '31', '1', '1', '', '', 1, '', 1, 0),
('MOUSE-WIRELESS', 7, 1, 'Logitech MK275 Wireless Keyboard & Mouse ', 'Logitech MK275 Wireless Keyboard & Mouse ', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '31', '1', '1', '', '', 1, '', 1, 0),
('MTB- B560M-AE', 7, 1, ' Motherboard (Gigabyte B560M Aorus Elite) ', ' Motherboard (Gigabyte B560M Aorus Elite) ', 'box', 'M', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '30', '1', '1', '', '', 1, '', 1, 0),
('MTB-B360M-D3H', 7, 1, 'Gigabyte B360M-D3H Motherboard', 'Gigabyte B360M-D3H Motherboard', 'box', 'M', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '30', '1', '1', '16-06-2021', '11-06-2022', 1, '1060', 1, 0),
('MTB-B365M D3H', 7, 1, 'MBD :- Gigabyte ( B365M D3H )', 'MBD :- Gigabyte ( B365M D3H )', 'box', 'M', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '30', '1', '1', '', '', 1, '', 1, 0),
('MTB-B460M-DS3H-AC', 7, 1, 'Gigabyte MBD ( B460M DS3H AC )', 'Gigabyte MBD ( B460M DS3H AC )', 'box', 'M', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '30', '1', '1', '', '', 1, '', 1, 0),
('MTB-B460M-DS3H-V2', 7, 1, 'Gigabyte B460M DS3H V2', 'Gigabyte B460M DS3H V2', 'box', 'M', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '30', '1', '1', '', '', 1, '', 1, 0),
('MTB-B560M-AE', 7, 1, ' Motherboard (Gigabyte B560M Aorus Elite) ', ' Motherboard (Gigabyte B560M Aorus Elite) ', 'box', 'M', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '30', '1', '1', '', '', 1, '', 1, 0),
('MTB-B560M-DS3H-AC', 7, 1, 'Motherboard (Gigabyte B560M DS3H AC) ', 'Motherboard (Gigabyte B560M DS3H AC) ', 'box', 'M', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '30', '1', '1', '', '', 1, '', 1, 0),
('MTB-B56OM-DS3H-AC', 7, 1, 'Motherboard Gigabyte  Modal No :-(B56OM-DS3H:AC) ', 'Motherboard Gigabyte  Modal No :-(B56OM-DS3H:AC) ', 'box', 'M', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '30', '1', '1', '', '', 1, '', 1, 0),
('MTB-H110', 7, 1, 'Gigabyte H110 M/b', 'Gigabyte H110 M/b', 'box', 'M', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '30', '1', '1', '', '', 1, '', 1, 0),
('MTB-H470M-DS3H', 7, 1, 'Gigabyte Motherboard Modal No :- (H470M DS3H)', 'Gigabyte Motherboard Modal No :- (H470M DS3H)', 'box', 'M', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '30', '1', '1', '', '', 1, '', 1, 0),
('MTB-SNMP-MCY-EN', 7, 1, 'SNMP CARD ( SNMP web pro   Modal no :- SNMP-MCY-EN )', 'SNMP CARD ( SNMP web pro   Modal no :- SNMP-MCY-EN )', 'box', 'M', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '30', '1', '1', '', '', 1, '', 1, 0),
('MTB-Z490', 7, 1, 'Gigabyte Z490 Mtb', 'Gigabyte Z490 Mtb', 'box', 'M', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '30', '1', '1', '', '', 1, '', 1, 0),
('MUSIC-WOOFER', 7, 1, 'Zook Woofer + Wireless Mic (ZB-Rocker Thunder XL)', 'Zook Woofer + Wireless Mic (ZB-Rocker Thunder XL)', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '32', '1', '1', '', '', 1, '', 1, 0),
('PRECISION-110', 7, 1, 'Screwdriver 110 in 1 set Precision ', 'Screwdriver 110 in 1 set Precision ', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '36', '1', '1', '', '', 1, '', 1, 0),
('PRO-I3-8GEN', 8, 1, 'I3 8th gen processor', 'I3 8th gen processor', 'box', 'M', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '37', '1', '1', '', '', 1, '', 1, 0),
('PRO-I5-11GEN', 8, 1, 'Processor i5 11th gen 2.6 GHZ LGA 1200 ( i5-11400 BX8070811400) ', 'Processor i5 11th gen 2.6 GHZ LGA 1200 ( i5-11400 BX8070811400) ', 'box', 'M', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '37', '1', '1', '', '', 1, '', 1, 0),
('RACK-2U', 14, 1, 'D.LINK 2U RACK', 'D.LINK 2U RACK', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '39', '1', '1', '', '', 1, '', 1, 0),
('RACK-D-2U', 14, 1, 'D-Link 2U Rack ', 'D-Link 2U Rack ', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '39', '1', '1', '', '', 1, '', 1, 0),
('RAM-DDR3-16GB', 7, 1, 'Corsiar value set DDR3 1600 RAM', 'Corsiar value set DDR3 1600 RAM', 'box', 'M', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '40', '1', '2', '', '', 1, '', 1, 0),
('RAM-DDR3-8GB', 7, 1, 'RAM DDR-3    8 GB Kingston 1333 Mhz', 'RAM DDR-3    8 GB Kingston 1333 Mhz', 'box', 'M', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '40', '1', '1', '30-12-2021', '30-12-2021', 1, '', 1, 0),
('RAM-DDR4-16GB', 7, 1, '16 GB 3000 Mhz DDR4 CORSIAR VEN RAM', '16 GB 3000 Mhz DDR4 CORSIAR VEN RAM', 'box', 'M', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '40', '1', '1', '23-06-2021', '23-06-2022', 1, '1001', 1, 0),
('RAM-DDR4-8GB', 7, 1, 'Corsiar DDR 4 RAM 8 GB 3000 Mhz', 'Corsiar DDR 4 RAM 8 GB 3000 Mhz', 'box', 'M', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '40', '1', '1', '', '', 1, '', 1, 0),
('REALME-TV-32', 15, 1, 'REALME 32\" INCH ANDROID TV', 'REALME 32\" INCH ANDROID TV', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '42', '1', '1', '', '', 1, '', 1, 0),
('ROUT-D--DGS-1210-28', 14, 1, 'D-Link Systems 28-Port Gigabit Web Smart (DGS-1210-28)', 'D-Link Systems 28-Port Gigabit Web Smart (DGS-1210-28)', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '41', '1', '1', '', '', 1, '', 1, 0),
('ROUT-D-DGS-1210-5', 14, 1, 'Dlink 52 Port switch( 52-Port Gigabit Smart Managed Switch DGS-1210-5)', 'Dlink 52 Port switch( 52-Port Gigabit Smart Managed Switch DGS-1210-5)', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '41', '1', '1', '', '', 1, '', 1, 0),
('ROUT-D-DGS-1210-52', 14, 1, 'D LINK 48PORT SWITCH (DGS-1210-52)', 'D LINK 48PORT SWITCH (DGS-1210-52)', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '41', '1', '1', '', '', 1, '', 1, 0),
('ROUT-D-WIFI-001-DIR-825', 14, 1, 'D-Link DIR-825 AC 1200 Wi-Fi Dual-Band Gigabit (LAN/WAN) Router | B098DTPWSM ( IT-ROUTER-001-DIR-825 )', 'D-Link DIR-825 AC 1200 Wi-Fi Dual-Band Gigabit (LAN/WAN) Router | B098DTPWSM ( IT-ROUTER-001-DIR-825 )', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '41', '1', '1', '', '', 1, '', 1, 0),
('ROUT-H-DS-3E0510P-E/M ', 14, 1, 'Hikvision 8 Port Gigabit Poe Unmangged switch :-Modal No :- DS-3E0510P-E/M ', 'Hikvision 8 Port Gigabit Poe Unmangged switch :-Modal No :- DS-3E0510P-E/M ', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '41', '1', '1', '', '', 1, '', 1, 0),
('ROUT-H-DS-7632NI-K2', 14, 1, 'Hikvision Embeded NVR Modal No :- ( DS-7632NI-K2)', 'Hikvision Embeded NVR Modal No :- ( DS-7632NI-K2)', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '41', '1', '1', '', '', 1, '', 1, 0),
('ROUT-TP-AC600', 14, 1, 'TP-Link AC600 (Modal No :- Archer T2U Plus ver 1.0)', 'TP-Link AC600 (Modal No :- Archer T2U Plus ver 1.0)', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '41', '1', '1', '', '', 1, '', 1, 0),
('ROUT-TP-UE300', 14, 1, 'TP-Link UE300 USB 3.0 to RJ45 Gigabit Ethernet (UE300)', 'TP-Link UE300 USB 3.0 to RJ45 Gigabit Ethernet (UE300)', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '41', '1', '1', '', '', 1, '', 1, 0),
('ROUT-TP-WN823N', 14, 1, 'Tp-Link 300 Mbps (TP-WN823N)', 'Tp-Link 300 Mbps (TP-WN823N)', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '41', '1', '1', '', '', 1, '', 1, 0),
('ROUT-WIFI-A-RT-AX55', 14, 1, 'Wi-Fi Router With Mac binding feature Asus Modal No :- ( RT-AX55)', 'Wi-Fi Router With Mac binding feature Asus Modal No :- ( RT-AX55)', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '41', '1', '1', '', '', 1, '', 1, 0),
('SMPS-ANTEC-VP-450', 7, 1, 'ANTEC VP 450 SMPS (VP450P PLUS IN V3000A200H-18) 450 Watt ', 'ANTEC VP 450 SMPS (VP450P PLUS IN V3000A200H-18) 450 Watt ', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '43', '1', '1', '', '', 1, '', 1, 0),
('SMPS-CORSIAR-450', 7, 1, 'Corsiar 450 Watt smps ', 'Corsiar 450 Watt smps ', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '43', '1', '1', '', '', 1, '', 1, 0),
('SMPS-F-G-12-407', 7, 1, 'SMPS Fingers gama-12-407', 'SMPS Fingers gama-12-407', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '43', '1', '1', '', '', 1, '', 1, 0),
('SMPS-F-G-401', 7, 1, 'SMPS Finger\'s Gamma-401 ', 'SMPS Finger\'s Gamma-401 ', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '43', '1', '1', '', '', 1, '', 1, 0),
('SMPS-F-GAMA-401', 7, 1, 'Fingures SMPS (GAMA-401)', 'Fingures SMPS (GAMA-401)', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '43', '1', '1', '', '', 1, '', 1, 0),
('SMPS-F-P-400', 7, 1, 'Finger\'s Polonium-400', 'Finger\'s Polonium-400', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '43', '1', '1', '', '', 1, '', 1, 0),
('SMPS-FA-C3', 7, 1, 'Cabinet Finger\'s Ascend c3 with SMPS ', 'Cabinet Finger\'s Ascend c3 with SMPS ', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '43', '1', '1', '', '', 1, '', 1, 0),
('SMPS-I-ZPS-281', 7, 1, 'SMPS  I Ball :- ZPS-281 ', 'SMPS  I Ball :- ZPS-281 ', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '43', '1', '1', '', '', 1, '', 1, 0),
('SMPS-S-H5', 7, 1, 'Finger\'s show stoper H5', 'Finger\'s show stoper H5', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '43', '1', '1', '', '', 1, '', 1, 0),
('stock_id', 0, 1, 'description', 'long_description', 'units', 'm', 'sales_account', 'cogs_account', 'inventory_accou', 'adjustment_acco', 'wip_account', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'd', 0, 0, '0000-00-00', '0000-00-00', 'fa_class_id', 'sub_cat_name', 'types', 'warranty', 'to_date', 'from_date', 0, 'assembly_account', 0, 0),
('UPS-10-KVA', 7, 1, 'ON LINE UPS ( I -Max 10 KVA/192 V )', 'ON LINE UPS ( I -Max 10 KVA/192 V )', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '46', '1', '1', '', '', 1, '', 1, 0),
('UPS-600-VA', 7, 1, 'UPS LUMINIOUS 600VA', 'UPS LUMINIOUS 600VA', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '46', '1', '1', '', '', 1, '', 1, 0),
('USB-LINK-HUB', 7, 1, 'Usb ( 1 Gbps Lan + 3.1 Usb ) Tp link Hub', 'Usb ( 1 Gbps Lan + 3.1 Usb ) Tp link Hub', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '2', '1', '1', '', '', 1, '', 1, 0),
('USB-PENDRIVE-64GB', 7, 1, 'SanDisk Ultra 64 GB USB Pen Drives (SDDDC2-064G-I35, Black, Silver) | B01EZ0X3L8 ', 'SanDisk Ultra 64 GB USB Pen Drives (SDDDC2-064G-I35, Black, Silver) | B01EZ0X3L8 ', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '34', '1', '1', '', '', 1, '', 1, 0),
('USB-PORT-HUB4', 7, 1, 'USB 3.1 Gen:1    4 Port Hub (  QZ-HB03)', 'USB 3.1 Gen:1    4 Port Hub (  QZ-HB03)', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '47', '1', '1', '', '', 1, '', 1, 0),
('USB-SOUND', 7, 1, 'Usb sound card ', 'Usb sound card ', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '44', '1', '1', '', '', 1, '', 1, 0),
('ZEB-CRYSTAL-WEBCAM ', 7, 1, 'Zebronics Web Camera ( Modal No :- ZEB-CRYSTAL CLEAR )', 'Zebronics Web Camera ( Modal No :- ZEB-CRYSTAL CLEAR )', 'box', 'B', '0', '0', '0', '0', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '48', '1', '1', '', '', 1, '', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `fa_stock_master_old`
--

CREATE TABLE `fa_stock_master_old` (
  `stock_id` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `category_id` int(11) NOT NULL DEFAULT 0,
  `tax_type_id` int(11) NOT NULL DEFAULT 0,
  `description` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `long_description` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `units` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'each',
  `mb_flag` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'B',
  `sales_account` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cogs_account` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `inventory_account` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `adjustment_account` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `wip_account` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `dimension_id` int(11) DEFAULT NULL,
  `dimension2_id` int(11) DEFAULT NULL,
  `purchase_cost` double NOT NULL DEFAULT 0,
  `material_cost` double NOT NULL DEFAULT 0,
  `labour_cost` double NOT NULL DEFAULT 0,
  `overhead_cost` double NOT NULL DEFAULT 0,
  `inactive` tinyint(1) NOT NULL DEFAULT 0,
  `no_sale` tinyint(1) NOT NULL DEFAULT 0,
  `no_purchase` tinyint(1) NOT NULL DEFAULT 0,
  `editable` tinyint(1) NOT NULL DEFAULT 0,
  `depreciation_method` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'S',
  `depreciation_rate` double NOT NULL DEFAULT 0,
  `depreciation_factor` double NOT NULL DEFAULT 0,
  `depreciation_start` date NOT NULL DEFAULT '0000-00-00',
  `depreciation_date` date NOT NULL DEFAULT '0000-00-00',
  `fa_class_id` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `sub_cat_name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `types` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `warranty` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `to_date` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `from_date` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `weight` float NOT NULL,
  `assembly_account` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `sl_no` tinyint(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fa_stock_master_old`
--

INSERT INTO `fa_stock_master_old` (`stock_id`, `category_id`, `tax_type_id`, `description`, `long_description`, `units`, `mb_flag`, `sales_account`, `cogs_account`, `inventory_account`, `adjustment_account`, `wip_account`, `dimension_id`, `dimension2_id`, `purchase_cost`, `material_cost`, `labour_cost`, `overhead_cost`, `inactive`, `no_sale`, `no_purchase`, `editable`, `depreciation_method`, `depreciation_rate`, `depreciation_factor`, `depreciation_start`, `depreciation_date`, `fa_class_id`, `sub_cat_name`, `types`, `warranty`, `to_date`, `from_date`, `weight`, `assembly_account`, `sl_no`) VALUES
('1001', 5, 1, 'Fan', 'Usha Fan', 'box', 'B', '1001', '', '1001', '1001', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '3', '1', '1', '23-06-2021', '23-06-2022', 5, '1001', 0),
('Blade', 1, 1, 'Fan Blade', 'Fan Blade', 'box', 'B', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '1', '1', '1', '19-01-2022', '31-01-2023', 10, '', 0),
('Car', 4, 1, 'MARTCAR', 'Electronic Maruti Car', 'pc.', 'M', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '2', '1', '1', '25-01-2022', '31-01-2023', 0, '', 0),
('CP110', 3, 1, 'Computer Cpu', 'CPU', 'box', 'B', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '6', '1', '2', '', '', 5, '', 1),
('cpu', 1, 1, 'central processing unit', 'central processing unit', 'box', 'M', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '3', '1', '1', '28-12-2021', '28-12-2021', 0, '', 0),
('cpu250rI3/1', 1, 1, 'cpu250rI3', 'cpu250rI3', 'box', 'M', '', '', '', '', '', NULL, NULL, 0, 0.76923076923078, 0, 0, 0, 0, 0, 0, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '3', '', '', '', '', 0, '', 0),
('cpu250rI3/2', 1, 1, 'cpu250rI3', 'cpu250rI3', 'box', 'M', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '3', '1', '1', '30-12-2021', '30-12-2021', 2.5, '', 0),
('CPU8250I3', 1, 1, 'CPUI3', 'CPU with 8 GB Ram 250 HDD I3 Processor', 'box', 'B', '', '', '', '', '', 0, 0, 0, 4800, 0, 0, 0, 0, 0, 0, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '3', '1', '1', '09-12-2021', '30-12-2022', 1.05, '', 0),
('CPU8250I4', 1, 1, 'CPUI3', 'CPU with 8 GB Ram 250 HDD I3 Processor', 'box', 'B', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '3', '1', '1', '09-12-2021', '30-12-2022', 1.05, '', 0),
('CPU8250I5', 1, 1, 'CPUI10', 'CPU with 1 TB HDD', 'box', 'B', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '3', '1', '1', '09-12-2021', '30-12-2022', 2, '', 0),
('DISENGINE', 1, 1, 'Diesel Engine', 'DI Diesel Engine', 'pc.', 'B', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '7', '1', '1', '', '', 0, '', 1),
('HDD250', 1, 1, 'Hard Disk 250', 'Segate Hard Disk 250 HDD', 'box', 'B', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '3', '1', '1', '30-12-2021', '30-12-2021', 0, '', 0),
('IntelProcessor', 1, 1, 'Intel Processor 5Gz', 'Intel Processor 5Gz', 'box', 'B', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '3', '1', '1', '30-12-2021', '30-12-2021', 0, '', 0),
('MChair', 1, 1, 'Moving Chair', 'Godrej Moving Chair', 'box', 'B', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '1', '1', '2', '', '', 0, '', 1),
('MotherBoard', 1, 1, 'Mother Board', 'Mother Board Mercuiry', 'box', 'B', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '3', '1', '1', '30-12-2021', '30-12-2021', 0, '', 0),
('RAM8GB', 1, 1, 'RAM 8 GB ', 'RAM 8 GB DDR', 'box', 'B', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '3', '1', '1', '30-12-2021', '30-12-2021', 0, '', 0),
('Rotar', 1, 1, 'Fan Rotar', 'Fan Rotar', 'pc.', 'B', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '1', '1', '1', '', '', 0, '', 1),
('TableFan', 4, 1, 'Table Fan', 'Table Fan 3 blade', 'pc.', 'M', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '2', '1', '1', '19-01-2022', '31-01-2023', 10, '', 0),
('Testcpu101', 3, 1, 'Test Cpu', 'Cpu Item By test', 'box', 'B', '', '', '', '', '', NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '6', '1', '', '', '', 0, '', 1),
('VEHBATTERY', 1, 1, 'Vehicle Battery', 'Electric Vehicle Battery', 'pc.', 'B', '', '', '', '', '', 0, 0, 0, 1380, 0, 0, 0, 0, 0, 0, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '7', '1', '1', '', '', 0, '', 1),
('VEHCHASSIS', 1, 1, 'Vehicle Chassis', 'Tubular Chassis', 'pc.', 'B', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '7', '1', '1', '', '', 0, '', 1),
('WFILTER', 1, 1, 'Water Filter', 'Water Filter 50L', 'pc.', 'B', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '1', '2', '', '', '', 0, '', 1),
('WTANK', 1, 1, 'Water Tank', 'Water Tank 1000L', 'pc.', 'B', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'S', 0, 0, '0000-00-00', '0000-00-00', '', '1', '2', '', '', '', 0, '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `fa_stock_moves`
--

CREATE TABLE `fa_stock_moves` (
  `trans_id` int(11) NOT NULL,
  `trans_no` int(11) NOT NULL DEFAULT 0,
  `stock_id` char(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `type` smallint(6) NOT NULL DEFAULT 0,
  `loc_code` char(5) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `tran_date` date NOT NULL DEFAULT '0000-00-00',
  `price` double NOT NULL DEFAULT 0,
  `reference` char(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `qty` double NOT NULL DEFAULT 1,
  `standard_cost` double NOT NULL DEFAULT 0,
  `person_id` int(11) NOT NULL,
  `discount_percent` double NOT NULL,
  `visible` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fa_stock_moves`
--

INSERT INTO `fa_stock_moves` (`trans_id`, `trans_no`, `stock_id`, `type`, `loc_code`, `tran_date`, `price`, `reference`, `qty`, `standard_cost`, `person_id`, `discount_percent`, `visible`) VALUES
(1, 6, 'AC-STAR-EMP-SPLIT', 25, 'PAT', '2022-04-07', 28, '', 1, 0, 0, 0, 0),
(2, 7, 'AC-SUM-AA128Y4ZAPGNN', 25, 'PAT', '2022-07-26', 28, '', 1, 0, 0, 0, 0),
(3, 1, 'L-BAG-LP-BLUE', 25, 'PAT', '2022-12-16', 20, '', 1, 0, 0, 0, 0),
(4, 2, 'L-BAG-LP-GRAY', 25, 'PAT', '2022-12-16', 20, '', 1, 0, 0, 0, 0),
(5, 3, 'L-BAG-HP', 25, 'PAT', '2022-12-16', 5, '', 2, 0, 0, 0, 0),
(6, 4, 'BAT-42AH-E', 25, 'PAT', '2022-12-16', 14, '', 26, 0, 0, 0, 0),
(7, 5, 'BAT-EP65-12-E', 25, 'PAT', '2022-12-16', 14, '', 16, 0, 0, 0, 0),
(8, 6, 'BAT-LAP-HPOA04', 25, 'PAT', '2022-12-16', 18, '', 1, 0, 0, 0, 0),
(9, 7, 'BAT-LAP-INEX', 25, 'PAT', '2022-12-16', 19, '', 1, 0, 0, 0, 0),
(10, 8, 'BAT-150AH-T-E', 25, 'PAT', '2022-12-16', 21, '', 2, 0, 0, 0, 0),
(11, 9, 'BAT-65AH-E', 25, 'PAT', '2022-12-16', 14, '', 16, 0, 0, 0, 0),
(12, 10, 'BAT-LAP-OA04', 25, 'PAT', '2022-12-16', 5, '', 1, 0, 0, 0, 0),
(13, 11, 'BAT-UPS-HB1875', 25, 'PAT', '2022-12-16', 26, '', 1, 0, 0, 0, 0),
(14, 12, 'BAT-150AH-T-E', 25, 'PAT', '2022-12-16', 26, '', 4, 0, 0, 0, 0),
(15, 13, 'BAT-LAP-LAOBT6C2196', 25, 'PAT', '2022-12-16', 5, '', 1, 0, 0, 0, 0),
(16, 14, 'ESSL-AM-X990', 25, 'PAT', '2022-12-16', 13, '', 2, 0, 0, 0, 0),
(17, 15, 'ESSL-FR1200', 25, 'PAT', '2022-12-16', 13, '', 2, 0, 0, 0, 0),
(18, 16, 'BIOCARD', 25, 'PAT', '2022-12-16', 13, '', 6, 0, 0, 0, 0),
(19, 17, 'ESSL-AM-X990', 25, 'PAT', '2022-12-16', 25, '', 1, 0, 0, 0, 0),
(20, 18, 'ESSL-FR1200', 25, 'PAT', '2022-12-16', 25, '', 1, 0, 0, 0, 0),
(21, 19, 'CAB-POWER', 25, 'PAT', '2022-12-16', 27, '', 1, 0, 0, 0, 0),
(22, 20, 'CAB-HDMI', 25, 'PAT', '2022-12-16', 5, '', 1, 0, 0, 0, 0),
(23, 21, 'CAB-POWER', 25, 'PAT', '2022-12-16', 5, '', 5, 0, 0, 0, 0),
(24, 22, 'L-BAG-LENOVO', 25, 'PAT', '2022-12-16', 11, '', 1, 0, 0, 0, 0),
(25, 23, 'L-BAG-HP', 25, 'PAT', '2022-12-16', 11, '', 2, 0, 0, 0, 0),
(26, 24, 'BAT-LAP-B', 25, 'PAT', '2022-12-16', 11, '', 1, 0, 0, 0, 0),
(27, 25, 'BAT-LAP-N4010', 25, 'PAT', '2022-12-16', 11, '', 1, 0, 0, 0, 0),
(28, 26, 'BAT-MICRO-L', 25, 'PAT', '2022-12-16', 11, '', 10, 0, 0, 0, 0),
(29, 27, 'BAT-LAP-TC-3817U', 25, 'PAT', '2022-12-16', 11, '', 1, 0, 0, 0, 0),
(30, 28, 'CAB-HDMI', 25, 'PAT', '2022-12-16', 11, '', 1, 0, 0, 0, 0),
(31, 29, 'DS-2CE1AC0T-IRPF', 25, 'PAT', '2022-12-16', 13, '', 1, 0, 0, 0, 0),
(32, 30, 'DS-2CD1323G0E-I', 25, 'PAT', '2022-12-16', 11, '', 24, 0, 0, 0, 0),
(33, 31, 'DS-2CD2023G2-IU', 25, 'PAT', '2022-12-16', 11, '', 3, 0, 0, 0, 0),
(34, 32, 'UPS-10-KVA', 25, 'PAT', '2022-12-16', 14, '', 1, 0, 0, 0, 0),
(35, 33, 'UPS-10-KVA', 25, 'PAT', '2022-12-16', 14, '', 1, 0, 0, 0, 0),
(36, 34, 'KEYBOARD', 25, 'PAT', '2022-12-16', 19, '', 1, 0, 0, 0, 0),
(37, 35, 'HDMI-CONVERTER', 25, 'PAT', '2022-12-16', 12, '', 1, 0, 0, 0, 0),
(38, 36, 'USB-PENDRIVE-64GB', 25, 'PAT', '2022-12-16', 12, '', 1, 0, 0, 0, 0),
(39, 36, 'HDD-SATA-2TB', 25, 'PAT', '2022-12-16', 12, '', 1, 0, 0, 0, 0),
(40, 37, 'ADAP-WIRELESS-T2U', 25, 'PAT', '2022-12-16', 12, '', 2, 0, 0, 0, 0),
(41, 38, 'ADAP-CONVERTER-TC', 25, 'PAT', '2022-12-16', 12, '', 1, 0, 0, 0, 0),
(42, 39, 'ADAP-NT-UE300C-TC', 25, 'PAT', '2022-12-16', 12, '', 2, 0, 0, 0, 0),
(43, 39, 'ADAP-NT-UE300C-USB3', 25, 'PAT', '2022-12-16', 12, '', 2, 0, 0, 0, 0),
(44, 39, 'USB-PORT-HUB4', 25, 'PAT', '2022-12-16', 12, '', 1, 0, 0, 0, 0),
(45, 39, 'ADAP-USB-T3-QZ-AD11', 25, 'PAT', '2022-12-16', 12, '', 2, 0, 0, 0, 0),
(46, 40, 'MON-GW2480-T-24', 25, 'PAT', '2022-12-16', 12, '', 1, 0, 0, 0, 0),
(47, 41, 'MON-24MK600M-24', 25, 'PAT', '2022-12-16', 12, '', 1, 0, 0, 0, 0),
(48, 42, 'MON-GW2480-T-24', 25, 'PAT', '2022-12-16', 12, '', 2, 0, 0, 0, 0),
(49, 43, 'PRECISION-110', 25, 'PAT', '2022-12-16', 12, '', 1, 0, 0, 0, 0),
(50, 44, 'CAB-FING-SMPS', 25, 'PAT', '2022-12-16', 24, '', 1, 0, 0, 0, 0),
(51, 44, 'CPU-I5-10400', 25, 'PAT', '2022-12-16', 24, '', 1, 0, 0, 0, 0),
(52, 44, 'MTB-B460M-DS3H-AC', 25, 'PAT', '2022-12-16', 24, '', 1, 0, 0, 0, 0),
(53, 44, 'RAM-DDR4-16GB', 25, 'PAT', '2022-12-16', 24, '', 1, 0, 0, 0, 0),
(54, 44, 'HDD-SSD-500GB', 25, 'PAT', '2022-12-16', 24, '', 1, 0, 0, 0, 0),
(55, 44, 'HDD-HDD-1TB', 25, 'PAT', '2022-12-16', 24, '', 1, 0, 0, 0, 0),
(56, 44, 'MON-E2421HN-24', 25, 'PAT', '2022-12-16', 24, '', 1, 0, 0, 0, 0),
(57, 45, 'HDD-SSD-500GB', 25, 'PAT', '2022-12-16', 24, '', 6, 0, 0, 0, 0),
(58, 46, 'HEADPHONE-G231', 25, 'PAT', '2022-12-16', 12, '', 2, 0, 0, 0, 0),
(59, 47, 'USB-SOUND', 25, 'PAT', '2022-12-16', 12, '', 1, 0, 0, 0, 0),
(60, 48, 'MON-GW2480-T-24', 25, 'PAT', '2022-12-16', 12, '', 2, 0, 0, 0, 0),
(61, 49, 'MON-GW2480-T-24', 25, 'PAT', '2022-12-16', 12, '', 1, 0, 0, 0, 0),
(62, 50, 'M-PHONE-BY-M1', 25, 'PAT', '2022-12-16', 12, '', 1, 0, 0, 0, 0),
(63, 51, 'RAM-DDR4-16GB', 25, 'PAT', '2022-12-16', 5, '', 1, 0, 0, 0, 0),
(64, 52, 'HDD-SSD-500GB', 25, 'PAT', '2022-12-16', 5, '', 2, 0, 0, 0, 0),
(65, 53, 'CPU-I5-10400', 25, 'PAT', '2022-12-16', 5, '', 1, 0, 0, 0, 0),
(66, 54, 'MTB-H470M-DS3H', 25, 'PAT', '2022-12-16', 5, '', 1, 0, 0, 0, 0),
(67, 54, 'RAM-DDR4-16GB', 25, 'PAT', '2022-12-16', 5, '', 1, 0, 0, 0, 0),
(68, 54, 'HDD-SSD-500GB', 25, 'PAT', '2022-12-16', 5, '', 1, 0, 0, 0, 0),
(69, 54, 'HDD-HDD-1TB', 25, 'PAT', '2022-12-16', 5, '', 1, 0, 0, 0, 0),
(70, 54, 'CAB-FING-SMPS', 25, 'PAT', '2022-12-16', 5, '', 1, 0, 0, 0, 0),
(71, 54, 'HDD-SSD-480GB', 25, 'PAT', '2022-12-16', 5, '', 5, 0, 0, 0, 0),
(72, 55, 'MOUSE-WIRELESS', 25, 'PAT', '2022-12-16', 5, '', 1, 0, 0, 0, 0),
(73, 55, 'HEADPHONE-G340', 25, 'PAT', '2022-12-16', 5, '', 1, 0, 0, 0, 0),
(74, 56, 'CAB-CORSIAR', 25, 'PAT', '2022-12-16', 5, '', 2, 0, 0, 0, 0),
(75, 56, 'RAM-DDR4-16GB', 25, 'PAT', '2022-12-16', 5, '', 2, 0, 0, 0, 0),
(76, 56, 'CPU-I5-10400', 25, 'PAT', '2022-12-16', 5, '', 2, 0, 0, 0, 0),
(77, 56, 'HDD-500GB', 25, 'PAT', '2022-12-16', 5, '', 2, 0, 0, 0, 0),
(78, 56, 'HDD-HDD-1TB', 25, 'PAT', '2022-12-16', 5, '', 2, 0, 0, 0, 0),
(79, 56, 'MTB-Z490', 25, 'PAT', '2022-12-16', 5, '', 2, 0, 0, 0, 0),
(80, 56, 'HDD-SSD-480GB', 25, 'PAT', '2022-12-16', 5, '', 2, 0, 0, 0, 0),
(81, 56, 'SMPS-CORSIAR-450', 25, 'PAT', '2022-12-16', 5, '', 2, 0, 0, 0, 0),
(82, 57, 'SMPS-F-P-400', 25, 'PAT', '2022-12-16', 5, '', 1, 0, 0, 0, 0),
(83, 57, 'SMPS-F-G-12-407', 25, 'PAT', '2022-12-16', 5, '', 1, 0, 0, 0, 0),
(84, 57, 'MON-FRONTECH', 25, 'PAT', '2022-12-16', 5, '', 1, 0, 0, 0, 0),
(85, 58, 'HDD-SSD-500GB', 25, 'PAT', '2022-12-16', 5, '', 5, 0, 0, 0, 0),
(86, 59, 'SMPS-F-G-401', 25, 'PAT', '2022-12-16', 5, '', 5, 0, 0, 0, 0),
(87, 60, 'CPU-I3-10105', 25, 'PAT', '2022-12-16', 5, '', 1, 0, 0, 0, 0),
(88, 60, 'MTB-B460M-DS3H-V2', 25, 'PAT', '2022-12-16', 5, '', 1, 0, 0, 0, 0),
(89, 60, 'RAM-DDR4-8GB', 25, 'PAT', '2022-12-16', 5, '', 1, 0, 0, 0, 0),
(90, 60, 'HDD-500GB', 25, 'PAT', '2022-12-16', 5, '', 1, 0, 0, 0, 0),
(91, 61, 'CPU-I3-10105', 25, 'PAT', '2022-12-16', 5, '', 1, 0, 0, 0, 0),
(92, 61, 'MTB-B460M-DS3H-V2', 25, 'PAT', '2022-12-16', 5, '', 1, 0, 0, 0, 0),
(93, 61, 'RAM-DDR4-8GB', 25, 'PAT', '2022-12-16', 5, '', 1, 0, 0, 0, 0),
(94, 61, 'HDD-500GB', 25, 'PAT', '2022-12-16', 5, '', 1, 0, 0, 0, 0),
(95, 61, 'MON-22MP68VQ-22', 25, 'PAT', '2022-12-16', 5, '', 1, 0, 0, 0, 0),
(96, 61, 'CAB-FING-SMPS', 25, 'PAT', '2022-12-16', 5, '', 1, 0, 0, 0, 0),
(97, 62, 'CPU-I3-10105', 25, 'PAT', '2022-12-16', 5, '', 1, 0, 0, 0, 0),
(98, 62, 'RAM-DDR4-8GB', 25, 'PAT', '2022-12-16', 5, '', 1, 0, 0, 0, 0),
(99, 62, 'HDD-500GB', 25, 'PAT', '2022-12-16', 5, '', 1, 0, 0, 0, 0),
(100, 62, 'MTB-B460M-DS3H-V2', 25, 'PAT', '2022-12-16', 5, '', 1, 0, 0, 0, 0),
(101, 62, 'MON-22MP68VQ-22', 25, 'PAT', '2022-12-16', 5, '', 1, 0, 0, 0, 0),
(102, 62, 'CAB-FING-SMPS', 25, 'PAT', '2022-12-16', 5, '', 1, 0, 0, 0, 0),
(103, 63, 'CPU-I3-10105', 25, 'PAT', '2022-12-16', 5, '', 2, 0, 0, 0, 0),
(104, 63, 'MTB-H470M-DS3H', 25, 'PAT', '2022-12-16', 5, '', 2, 0, 0, 0, 0),
(105, 63, 'RAM-DDR4-8GB', 25, 'PAT', '2022-12-16', 5, '', 2, 0, 0, 0, 0),
(106, 63, 'HDD-500GB', 25, 'PAT', '2022-12-16', 5, '', 2, 0, 0, 0, 0),
(107, 63, 'CAB-FING-SMPS', 25, 'PAT', '2022-12-16', 5, '', 2, 0, 0, 0, 0),
(108, 64, 'MOUSE-PAD', 25, 'PAT', '2022-12-16', 5, '', 1, 0, 0, 0, 0),
(109, 64, 'HEADPHONE-F5', 25, 'PAT', '2022-12-16', 5, '', 2, 0, 0, 0, 0),
(110, 65, 'SMPS-FA-C3', 25, 'PAT', '2022-12-16', 5, '', 1, 0, 0, 0, 0),
(111, 65, 'CPU-I5-10400', 25, 'PAT', '2022-12-16', 5, '', 1, 0, 0, 0, 0),
(112, 65, 'MTB-B56OM-DS3H-AC', 25, 'PAT', '2022-12-16', 5, '', 1, 0, 0, 0, 0),
(113, 65, 'RAM-DDR4-16GB', 25, 'PAT', '2022-12-16', 5, '', 1, 0, 0, 0, 0),
(114, 65, 'HDD-SSD-500GB', 25, 'PAT', '2022-12-16', 5, '', 1, 0, 0, 0, 0),
(115, 65, 'HDD-HDD-1TB', 25, 'PAT', '2022-12-16', 5, '', 1, 0, 0, 0, 0),
(116, 65, 'MON-S2421HN-24', 25, 'PAT', '2022-12-16', 5, '', 1, 0, 0, 0, 0),
(117, 66, 'RAM-DDR4-16GB', 25, 'PAT', '2022-12-16', 5, '', 1, 0, 0, 0, 0),
(118, 66, 'HDD-SSD-500GB', 25, 'PAT', '2022-12-16', 5, '', 5, 0, 0, 0, 0),
(119, 67, 'HDD-SSD-500GB', 25, 'PAT', '2022-12-16', 5, '', 1, 0, 0, 0, 0),
(120, 68, 'MON-22MP68VQ-22', 25, 'PAT', '2022-12-16', 5, '', 1, 0, 0, 0, 0),
(121, 69, 'MTB-H110', 25, 'PAT', '2022-12-16', 5, '', 1, 0, 0, 0, 0),
(122, 69, 'MON-22MP68VQ-22', 25, 'PAT', '2022-12-16', 5, '', 1, 0, 0, 0, 0),
(123, 70, 'HEADPHONE-H5', 25, 'PAT', '2022-12-16', 5, '', 2, 0, 0, 0, 0),
(124, 71, 'CAB-FING-SMPS', 25, 'PAT', '2022-12-16', 5, '', 1, 0, 0, 0, 0),
(125, 71, 'MTB- B560M-AE', 25, 'PAT', '2022-12-16', 5, '', 1, 0, 0, 0, 0),
(126, 71, 'RAM-DDR4-16GB', 25, 'PAT', '2022-12-16', 5, '', 1, 0, 0, 0, 0),
(127, 71, 'HDD-SSD-500GB', 25, 'PAT', '2022-12-16', 5, '', 1, 0, 0, 0, 0),
(128, 71, 'MON-22MP68VQ-22', 25, 'PAT', '2022-12-16', 5, '', 1, 0, 0, 0, 0),
(129, 72, 'HDD-SSD-480GB', 25, 'PAT', '2022-12-16', 5, '', 5, 0, 0, 0, 0),
(130, 73, 'HEADPHONE-H-340', 25, 'PAT', '2022-12-16', 5, '', 1, 0, 0, 0, 0),
(131, 73, 'HEADPHONE-H9', 25, 'PAT', '2022-12-16', 5, '', 1, 0, 0, 0, 0),
(132, 74, 'MTB-B460M-DS3H-V2', 25, 'PAT', '2022-12-16', 5, '', 2, 0, 0, 0, 0),
(133, 74, 'CPU-I5-10400', 25, 'PAT', '2022-12-16', 5, '', 2, 0, 0, 0, 0),
(134, 74, 'RAM-DDR4-16GB', 25, 'PAT', '2022-12-16', 5, '', 2, 0, 0, 0, 0),
(135, 74, 'HDD-SSD-500GB', 25, 'PAT', '2022-12-16', 5, '', 2, 0, 0, 0, 0),
(136, 74, 'HDD-HDD-1TB', 25, 'PAT', '2022-12-16', 5, '', 2, 0, 0, 0, 0),
(137, 74, 'CAB-FING-SMPS', 25, 'PAT', '2022-12-16', 5, '', 2, 0, 0, 0, 0),
(139, 75, 'MTB-B460M-DS3H-V2', 25, 'PAT', '2022-12-16', 5, '', 1, 0, 0, 0, 0),
(140, 75, 'CPU-I5-10400', 25, 'PAT', '2022-12-16', 5, '', 1, 0, 0, 0, 0),
(141, 75, 'RAM-DDR4-8GB', 25, 'PAT', '2022-12-16', 5, '', 2, 0, 0, 0, 0),
(142, 75, 'HDD-SSD-500GB', 25, 'PAT', '2022-12-16', 5, '', 1, 0, 0, 0, 0),
(143, 75, 'HDD-HDD-1TB', 25, 'PAT', '2022-12-16', 5, '', 1, 0, 0, 0, 0),
(144, 75, 'CAB-FING-SMPS', 25, 'PAT', '2022-12-16', 5, '', 1, 0, 0, 0, 0),
(145, 75, 'MON-22MP68VQ-22', 25, 'PAT', '2022-12-16', 5, '', 1, 0, 0, 0, 0),
(146, 76, 'MTB- B560M-AE', 25, 'PAT', '2022-12-16', 5, '', 1, 0, 0, 0, 0),
(147, 76, 'HDD-500GB', 25, 'PAT', '2022-12-16', 5, '', 1, 0, 0, 0, 0),
(148, 76, 'HDD-HDD-2TB', 25, 'PAT', '2022-12-16', 5, '', 1, 0, 0, 0, 0),
(149, 77, 'SMPS-S-H5', 25, 'PAT', '2022-12-16', 5, '', 1, 0, 0, 0, 0),
(150, 77, 'HEADPHONE-G340', 25, 'PAT', '2022-12-16', 5, '', 1, 0, 0, 0, 0),
(151, 78, 'HEADPHONE-H-111', 25, 'PAT', '2022-12-16', 5, '', 2, 0, 0, 0, 0),
(152, 79, 'HDD-SSD-500GB', 25, 'PAT', '2022-12-16', 5, '', 1, 0, 0, 0, 0),
(153, 80, 'CPU-I5-10400', 25, 'PAT', '2022-12-16', 5, '', 2, 0, 0, 0, 0),
(154, 80, 'CAB-FING-SMPS', 25, 'PAT', '2022-12-16', 5, '', 1, 0, 0, 0, 0),
(155, 80, 'MTB-B460M-DS3H-V2', 25, 'PAT', '2022-12-16', 5, '', 2, 0, 0, 0, 0),
(156, 80, 'HDD-SSD-500GB', 25, 'PAT', '2022-12-16', 5, '', 1, 0, 0, 0, 0),
(157, 80, 'RAM-DDR4-16GB', 25, 'PAT', '2022-12-16', 5, '', 1, 0, 0, 0, 0),
(158, 80, 'HDD-HDD-1TB', 25, 'PAT', '2022-12-16', 5, '', 2, 0, 0, 0, 0),
(159, 81, 'FOOTPEDAL-ODIN', 25, 'PAT', '2022-12-16', 12, '', 1, 0, 0, 0, 0),
(160, 82, 'ZEB-CRYSTAL-WEBCAM', 25, 'PAT', '2022-12-16', 12, '', 1, 0, 0, 0, 0),
(161, 83, 'HEADPHONE-F-10', 25, 'PAT', '2022-12-16', 12, '', 5, 0, 0, 0, 0),
(162, 84, 'MON-22MP68VQ-22', 25, 'PAT', '2022-12-16', 12, '', 2, 0, 0, 0, 0),
(163, 85, 'HEADPHONE-H-340', 25, 'PAT', '2022-12-16', 11, '', 1, 0, 0, 0, 0),
(164, 86, 'HDD-SSD-1TB', 25, 'PAT', '2022-12-16', 11, '', 1, 0, 0, 0, 0),
(165, 86, 'ADAP-USB-T3-VIBOTON', 25, 'PAT', '2022-12-16', 11, '', 1, 0, 0, 0, 0),
(166, 86, 'ADAP-USB-SATA', 25, 'PAT', '2022-12-16', 11, '', 1, 0, 0, 0, 0),
(167, 87, 'HEADPHONE-D3', 25, 'PAT', '2022-12-16', 11, '', 1, 0, 0, 0, 0),
(168, 88, 'HEADPHONE-F10', 25, 'PAT', '2022-12-16', 12, '', 100, 0, 0, 0, 0),
(169, 89, 'HDD-HDD-1TB', 25, 'PAT', '2022-12-16', 11, '', 2, 0, 0, 0, 0),
(170, 90, 'MTB-B365M D3H', 25, 'PAT', '2022-12-16', 11, '', 1, 0, 0, 0, 0),
(171, 90, 'CPU-I3-8100', 25, 'PAT', '2022-12-16', 11, '', 1, 0, 0, 0, 0),
(172, 90, 'RAM-DDR4-8GB', 25, 'PAT', '2022-12-16', 11, '', 1, 0, 0, 0, 0),
(173, 90, 'CAB-IBALL', 25, 'PAT', '2022-12-16', 11, '', 1, 0, 0, 0, 0),
(174, 90, 'HDD-SSD-250GB', 25, 'PAT', '2022-12-16', 11, '', 1, 0, 0, 0, 0),
(175, 90, 'MON-GW2480-T-24', 25, 'PAT', '2022-12-16', 11, '', 2, 0, 0, 0, 0),
(176, 90, 'RAM-DDR3-8GB', 25, 'PAT', '2022-12-16', 11, '', 2, 0, 0, 0, 0),
(177, 91, 'MTB-B365M D3H', 25, 'PAT', '2022-12-16', 11, '', 1, 0, 0, 0, 0),
(178, 91, 'CPU-I5-8400', 25, 'PAT', '2022-12-16', 11, '', 1, 0, 0, 0, 0),
(179, 91, 'RAM-DDR4-16GB', 25, 'PAT', '2022-12-16', 11, '', 1, 0, 0, 0, 0),
(180, 91, 'CAB-IBALL', 25, 'PAT', '2022-12-16', 11, '', 1, 0, 0, 0, 0),
(181, 91, 'MON-GW2480-T-24', 25, 'PAT', '2022-12-16', 11, '', 1, 0, 0, 0, 0),
(182, 91, 'HDD-SSD-500GB', 25, 'PAT', '2022-12-16', 11, '', 1, 0, 0, 0, 0),
(183, 92, 'HDD-SSD-500GB', 25, 'PAT', '2022-12-16', 11, '', 1, 0, 0, 0, 0),
(184, 93, 'MTB-B360M-D3H', 25, 'PAT', '2022-12-16', 11, '', 1, 0, 0, 0, 0),
(185, 93, 'CPU-I5-8400', 25, 'PAT', '2022-12-16', 11, '', 1, 0, 0, 0, 0),
(186, 93, 'RAM-DDR4-16GB', 25, 'PAT', '2022-12-16', 11, '', 1, 0, 0, 0, 0),
(187, 93, 'HDD-1TB', 25, 'PAT', '2022-12-16', 11, '', 1, 0, 0, 0, 0),
(188, 93, 'CAB-IBALL', 25, 'PAT', '2022-12-16', 11, '', 1, 0, 0, 0, 0),
(189, 93, 'RAM-DDR3-16GB', 25, 'PAT', '2022-12-16', 11, '', 1, 0, 0, 0, 0),
(190, 94, 'LOGI-WEBCAM-C270', 25, 'PAT', '2022-12-16', 11, '', 3, 0, 0, 0, 0),
(191, 95, 'MTB-B460M-DS3H-AC', 25, 'PAT', '2022-12-16', 11, '', 2, 0, 0, 0, 0),
(192, 95, 'RAM-DDR4-8GB', 25, 'PAT', '2022-12-16', 11, '', 2, 0, 0, 0, 0),
(193, 95, 'HDD-500GB', 25, 'PAT', '2022-12-16', 11, '', 2, 0, 0, 0, 0),
(194, 95, 'CPU-I3-BX8070110100', 25, 'PAT', '2022-12-16', 11, '', 2, 0, 0, 0, 0),
(195, 95, 'CAB-FING-SMPS', 25, 'PAT', '2022-12-16', 11, '', 2, 0, 0, 0, 0),
(196, 95, 'SMPS-F-GAMA-401', 25, 'PAT', '2022-12-16', 11, '', 4, 0, 0, 0, 0),
(197, 96, 'HDD-SSD-500GB', 25, 'PAT', '2022-12-16', 11, '', 1, 0, 0, 0, 0),
(198, 97, 'HDD-HDD-1TB', 25, 'PAT', '2022-12-16', 11, '', 2, 0, 0, 0, 0),
(199, 97, 'SMPS-I-ZPS-281', 25, 'PAT', '2022-12-16', 11, '', 2, 0, 0, 0, 0),
(200, 98, 'MTB-B460M-DS3H-AC', 25, 'PAT', '2022-12-16', 11, '', 1, 0, 0, 0, 0),
(201, 98, 'HDD-HDD-1TB', 25, 'PAT', '2022-12-16', 11, '', 1, 0, 0, 0, 0),
(202, 98, 'RAM-DDR4-16GB', 25, 'PAT', '2022-12-16', 11, '', 1, 0, 0, 0, 0),
(203, 98, 'CPU-I5-10400', 25, 'PAT', '2022-12-16', 11, '', 1, 0, 0, 0, 0),
(204, 98, 'HDD-HDD-1TB', 25, 'PAT', '2022-12-16', 11, '', 1, 0, 0, 0, 0),
(205, 98, 'CAB-FING-SMPS', 25, 'PAT', '2022-12-16', 11, '', 1, 0, 0, 0, 0),
(206, 98, 'MON-GW2480-T-24', 25, 'PAT', '2022-12-16', 11, '', 1, 0, 0, 0, 0),
(207, 99, 'MTB- B560M-AE', 25, 'PAT', '2022-12-16', 11, '', 1, 0, 0, 0, 0),
(208, 99, 'MTB-B560M-DS3H-AC', 25, 'PAT', '2022-12-16', 11, '', 1, 0, 0, 0, 0),
(209, 99, 'RAM-DDR4-16GB', 25, 'PAT', '2022-12-16', 11, '', 3, 0, 0, 0, 0),
(210, 99, 'HDD-SSD-500GB', 25, 'PAT', '2022-12-16', 11, '', 1, 0, 0, 0, 0),
(211, 99, 'MON-S2421H-24', 25, 'PAT', '2022-12-16', 11, '', 1, 0, 0, 0, 0),
(212, 99, 'CAB-FING-SMPS', 25, 'PAT', '2022-12-16', 11, '', 1, 0, 0, 0, 0),
(213, 100, 'CAB-FING-SMPS', 25, 'PAT', '2022-12-16', 11, '', 1, 0, 0, 0, 0),
(214, 100, 'MTB- B560M-AE', 25, 'PAT', '2022-12-16', 11, '', 1, 0, 0, 0, 0),
(215, 100, 'RAM-DDR4-16GB', 25, 'PAT', '2022-12-16', 11, '', 1, 0, 0, 0, 0),
(216, 100, 'HDD-SSD-500GB', 25, 'PAT', '2022-12-16', 11, '', 1, 0, 0, 0, 0),
(217, 100, 'MON-S2421H-24', 25, 'PAT', '2022-12-16', 11, '', 1, 0, 0, 0, 0),
(218, 101, 'MTB-B360M-D3H', 25, 'PAT', '2022-12-16', 11, '', 2, 0, 0, 0, 0),
(219, 101, 'CPU-I5-8400', 25, 'PAT', '2022-12-16', 11, '', 1, 0, 0, 0, 0),
(220, 101, 'CPU-I3-8100', 25, 'PAT', '2022-12-16', 11, '', 1, 0, 0, 0, 0),
(221, 101, 'RAM-DDR4-16GB', 25, 'PAT', '2022-12-16', 11, '', 1, 0, 0, 0, 0),
(222, 101, 'RAM-DDR4-8GB', 25, 'PAT', '2022-12-16', 11, '', 1, 0, 0, 0, 0),
(223, 101, 'HDD-1TB', 25, 'PAT', '2022-12-16', 11, '', 4, 0, 0, 0, 0),
(224, 101, 'CAB-IBALL', 25, 'PAT', '2022-12-16', 11, '', 2, 0, 0, 0, 0),
(225, 101, 'ADAP-LAPCARE', 25, 'PAT', '2022-12-16', 11, '', 1, 0, 0, 0, 0),
(226, 102, 'MOUSE-USB-M90', 25, 'PAT', '2022-12-16', 11, '', 5, 0, 0, 0, 0),
(227, 103, 'CAB-FINGERS', 25, 'PAT', '2022-12-16', 11, '', 2, 0, 0, 0, 0),
(228, 103, 'CPU-I5-10400', 25, 'PAT', '2022-12-16', 11, '', 3, 0, 0, 0, 0),
(229, 103, 'MTB-B460M-DS3H-V2', 25, 'PAT', '2022-12-16', 11, '', 3, 0, 0, 0, 0),
(230, 103, 'RAM-DDR4-16GB', 25, 'PAT', '2022-12-16', 11, '', 3, 0, 0, 0, 0),
(231, 103, 'HDD-SSD-500GB', 25, 'PAT', '2022-12-16', 11, '', 2, 0, 0, 0, 0),
(232, 103, 'HDD-HDD-1TB', 25, 'PAT', '2022-12-16', 11, '', 2, 0, 0, 0, 0),
(233, 103, 'MON-GW2480-B-24', 25, 'PAT', '2022-12-16', 11, '', 1, 0, 0, 0, 0),
(234, 104, 'RAM-DDR4-16GB', 25, 'PAT', '2022-12-16', 11, '', 1, 0, 0, 0, 0),
(235, 104, 'HDD-SSD-500GB', 25, 'PAT', '2022-12-16', 11, '', 1, 0, 0, 0, 0),
(236, 104, 'HDD-HDD-1TB', 25, 'PAT', '2022-12-16', 11, '', 2, 0, 0, 0, 0),
(237, 104, 'SMPS-I-ZPS-281', 25, 'PAT', '2022-12-16', 11, '', 2, 0, 0, 0, 0),
(238, 105, 'CAB-CORSIAR', 25, 'PAT', '2022-12-16', 11, '', 1, 0, 0, 0, 0),
(239, 105, 'SMPS-ANTEC-VP-450', 25, 'PAT', '2022-12-16', 11, '', 1, 0, 0, 0, 0),
(240, 105, 'CPU-I5-10400', 25, 'PAT', '2022-12-16', 11, '', 1, 0, 0, 0, 0),
(241, 105, 'MTB-B460M-DS3H-AC', 25, 'PAT', '2022-12-16', 11, '', 1, 0, 0, 0, 0),
(242, 105, 'GR-CARD-Z-GTX-1050', 25, 'PAT', '2022-12-16', 11, '', 1, 0, 0, 0, 0),
(243, 105, 'RAM-DDR4-16GB', 25, 'PAT', '2022-12-16', 11, '', 1, 0, 0, 0, 0),
(244, 105, 'HDD-500GB', 25, 'PAT', '2022-12-16', 11, '', 1, 0, 0, 0, 0),
(245, 105, 'HDD-HDD-1TB', 25, 'PAT', '2022-12-16', 11, '', 1, 0, 0, 0, 0),
(246, 105, 'MOUSE-USB', 25, 'PAT', '2022-12-16', 11, '', 1, 0, 0, 0, 0),
(247, 105, 'MON-GW2480-B-24', 25, 'PAT', '2022-12-16', 11, '', 1, 0, 0, 0, 0),
(248, 106, 'HDD-SATA-8TB', 25, 'PAT', '2022-12-19', 11, '', 1, 0, 0, 0, 0),
(249, 107, 'CPU-I5-10400', 25, 'PAT', '2022-12-19', 11, '', 1, 0, 0, 0, 0),
(250, 107, 'CAB-FING-SMPS', 25, 'PAT', '2022-12-19', 11, '', 1, 0, 0, 0, 0),
(251, 107, 'MTB-B460M-DS3H-AC', 25, 'PAT', '2022-12-19', 11, '', 1, 0, 0, 0, 0),
(252, 107, 'HDD-SSD-500GB', 25, 'PAT', '2022-12-19', 11, '', 1, 0, 0, 0, 0),
(253, 107, 'HDD-HDD-1TB', 25, 'PAT', '2022-12-19', 11, '', 1, 0, 0, 0, 0),
(254, 107, 'MOUSE-USB', 25, 'PAT', '2022-12-19', 11, '', 1, 0, 0, 0, 0),
(255, 107, 'MON-GW2480-B-24', 25, 'PAT', '2022-12-19', 11, '', 1, 0, 0, 0, 0),
(256, 107, 'RAM-DDR4-16GB', 25, 'PAT', '2022-12-19', 11, '', 1, 0, 0, 0, 0),
(257, 108, 'MON-GW2480-T-24', 25, 'PAT', '2022-12-19', 11, '', 1, 0, 0, 0, 0),
(258, 108, 'CPU-I5-9400', 25, 'PAT', '2022-12-19', 11, '', 2, 0, 0, 0, 0),
(259, 108, 'RAM-DDR4-16GB', 25, 'PAT', '2022-12-19', 11, '', 2, 0, 0, 0, 0),
(260, 108, 'MTB-B360M-D3H', 25, 'PAT', '2022-12-19', 11, '', 2, 0, 0, 0, 0),
(261, 108, 'CAB-IBALL', 25, 'PAT', '2022-12-19', 11, '', 2, 0, 0, 0, 0),
(262, 108, 'GR-CARD-N-GT-70', 25, 'PAT', '2022-12-19', 11, '', 2, 0, 0, 0, 0),
(263, 109, 'HDD-1TB', 25, 'PAT', '2022-12-19', 11, '', 1, 0, 0, 0, 0),
(264, 110, 'HDD-HDD-1TB', 25, 'PAT', '2022-12-19', 11, '', 5, 0, 0, 0, 0),
(265, 111, 'HDD-SSD-500GB', 25, 'PAT', '2022-12-19', 11, '', 3, 0, 0, 0, 0),
(266, 112, 'MTB-B360M-D3H', 25, 'PAT', '2022-12-19', 11, '', 2, 0, 0, 0, 0),
(267, 112, 'RAM-DDR4-16GB', 25, 'PAT', '2022-12-19', 11, '', 1, 0, 0, 0, 0),
(268, 112, 'HDD-SSD-240GB', 25, 'PAT', '2022-12-19', 11, '', 2, 0, 0, 0, 0),
(269, 112, 'CAB-IBALL', 25, 'PAT', '2022-12-19', 11, '', 2, 0, 0, 0, 0),
(270, 112, 'MON-GW2480-T-24', 25, 'PAT', '2022-12-19', 11, '', 2, 0, 0, 0, 0),
(271, 112, 'RAM-DDR4-8GB', 25, 'PAT', '2022-12-19', 11, '', 1, 0, 0, 0, 0),
(272, 113, 'HDD-1TB', 25, 'PAT', '2022-12-19', 11, '', 15, 0, 0, 0, 0),
(273, 113, 'RAM-DDR4-8GB', 25, 'PAT', '2022-12-19', 11, '', 1, 0, 0, 0, 0),
(274, 113, 'RAM-DDR4-16GB', 25, 'PAT', '2022-12-19', 11, '', 1, 0, 0, 0, 0),
(275, 114, 'MTB-B360M-D3H', 25, 'PAT', '2022-12-19', 11, '', 2, 0, 0, 0, 0),
(276, 114, 'CPU-I5-8400', 25, 'PAT', '2022-12-19', 11, '', 1, 0, 0, 0, 0),
(277, 114, 'RAM-DDR4-16GB', 25, 'PAT', '2022-12-19', 11, '', 2, 0, 0, 0, 0),
(278, 114, 'CAB-IBALL', 25, 'PAT', '2022-12-19', 11, '', 2, 0, 0, 0, 0),
(279, 114, 'MON-GW2480-T-24', 25, 'PAT', '2022-12-19', 11, '', 3, 0, 0, 0, 0),
(280, 114, 'CPU-I3-8100', 25, 'PAT', '2022-12-19', 11, '', 1, 0, 0, 0, 0),
(281, 114, 'HDD-SSD-500GB', 25, 'PAT', '2022-12-19', 11, '', 1, 0, 0, 0, 0),
(282, 115, 'RAM-DDR4-16GB', 25, 'PAT', '2022-12-19', 11, '', 1, 0, 0, 0, 0),
(283, 115, 'MOUSE-USB', 25, 'PAT', '2022-12-19', 11, '', 5, 0, 0, 0, 0),
(284, 116, 'MTB-B460M-DS3H-V2', 25, 'PAT', '2022-12-19', 11, '', 2, 0, 0, 0, 0),
(285, 116, 'CPU-I5-10400', 25, 'PAT', '2022-12-19', 11, '', 2, 0, 0, 0, 0),
(286, 116, 'RAM-DDR4-16GB', 25, 'PAT', '2022-12-19', 11, '', 2, 0, 0, 0, 0),
(287, 116, 'CAB-FING-SMPS', 25, 'PAT', '2022-12-19', 11, '', 2, 0, 0, 0, 0),
(288, 116, 'HDD-500GB', 25, 'PAT', '2022-12-19', 11, '', 1, 0, 0, 0, 0),
(289, 116, 'HDD-HDD-1TB', 25, 'PAT', '2022-12-19', 11, '', 2, 0, 0, 0, 0),
(290, 116, 'MON-LED-LF24T352FHWXXL-24', 25, 'PAT', '2022-12-19', 11, '', 2, 0, 0, 0, 0),
(291, 117, 'HDD-HDD-1TB', 25, 'PAT', '2022-12-19', 11, '', 5, 0, 0, 0, 0),
(292, 118, 'UPS-600-VA', 25, 'PAT', '2022-12-19', 11, '', 1, 0, 0, 0, 0),
(293, 119, 'HDD-HDD-1TB', 25, 'PAT', '2022-12-19', 11, '', 2, 0, 0, 0, 0),
(294, 119, 'SMPS-I-ZPS-281', 25, 'PAT', '2022-12-19', 11, '', 2, 0, 0, 0, 0),
(295, 119, 'MON-GW2480-T-24', 25, 'PAT', '2022-12-19', 11, '', 1, 0, 0, 0, 0),
(296, 119, 'HDD-SSD-500GB', 25, 'PAT', '2022-12-19', 11, '', 1, 0, 0, 0, 0),
(297, 120, 'RAM-DDR3-8GB', 25, 'PAT', '2022-12-19', 12, '', 1, 0, 0, 0, 0),
(298, 121, 'MON-GW2280-B-22', 25, 'PAT', '2022-12-19', 12, '', 1, 0, 0, 0, 0),
(300, 123, 'HDD-SSD-500GB', 25, 'PAT', '2022-12-19', 12, '', 2, 0, 0, 0, 0),
(301, 124, 'USB-LINK-HUB', 25, 'PAT', '2022-12-19', 12, '', 1, 0, 0, 0, 0),
(302, 125, 'MON-GW2480-T-24', 25, 'PAT', '2022-12-19', 12, '', 1, 0, 0, 0, 0),
(303, 126, 'HDD-SSD-1TB', 25, 'PAT', '2022-12-19', 12, '', 1, 0, 0, 0, 0),
(304, 127, 'MON-GW2480-T-24', 25, 'PAT', '2022-12-19', 12, '', 1, 0, 0, 0, 0),
(305, 128, 'MON-22MP68VQ-22', 25, 'PAT', '2022-12-19', 12, '', 1, 0, 0, 0, 0),
(306, 129, 'HDD-SSD-500GB', 25, 'PAT', '2022-12-19', 12, '', 1, 0, 0, 0, 0),
(307, 130, 'HDD-SSD-500GB', 25, 'PAT', '2022-12-19', 12, '', 1, 0, 0, 0, 0),
(308, 131, 'MON-GW2480-T-24', 25, 'PAT', '2022-12-19', 12, '', 1, 0, 0, 0, 0),
(309, 132, 'HDD-HDD-1TB', 25, 'PAT', '2022-12-19', 5, '', 4, 0, 0, 0, 0),
(310, 133, 'MUSIC-WOOFER', 25, 'PAT', '2022-12-19', 12, '', 1, 0, 0, 0, 0),
(311, 134, 'FIREWALL-FGT-80F', 25, 'PAT', '2022-12-19', 8, '', 1, 0, 0, 0, 0),
(312, 135, 'PRO-I5-11GEN', 25, 'PAT', '2022-12-19', 5, '', 2, 0, 0, 0, 0),
(313, 136, 'PRO-I5-11GEN', 25, 'PAT', '2022-12-19', 5, '', 1, 0, 0, 0, 0),
(314, 137, 'PRO-I5-11GEN', 25, 'PAT', '2022-12-19', 5, '', 1, 0, 0, 0, 0),
(315, 138, 'PRO-I5-11GEN', 25, 'PAT', '2022-12-19', 11, '', 2, 0, 0, 0, 0),
(316, 139, 'PRO-I5-11GEN', 25, 'PAT', '2022-12-19', 11, '', 1, 0, 0, 0, 0),
(317, 140, 'PRO-I3-8GEN', 25, 'PAT', '2022-12-19', 11, '', 2, 0, 0, 0, 0),
(318, 141, 'FIREWALL-FGT-60F', 25, 'PAT', '2022-12-19', 2, '', 1, 0, 0, 0, 0),
(319, 142, 'GEN-JSPF-35X-3PH', 25, 'PAT', '2022-12-19', 15, '', 1, 0, 0, 0, 0),
(320, 143, 'GEN-SNMP-MCY-EN', 25, 'PAT', '2022-12-19', 14, '', 1, 0, 0, 0, 0),
(321, 144, 'LAP-IPAD-A1893', 25, 'PAT', '2022-12-19', 12, '', 1, 0, 0, 0, 0),
(322, 145, 'LAP-HP-15Q', 25, 'PAT', '2022-12-19', 16, '', 1, 0, 0, 0, 0),
(323, 146, 'LAP-ASUS-X509J', 25, 'PAT', '2022-12-19', 16, '', 1, 0, 0, 0, 0),
(324, 147, 'LAP-DELL-14', 25, 'PAT', '2022-12-19', 19, '', 1, 0, 0, 0, 0),
(325, 148, 'LAP-DELL-IP-3511', 25, 'PAT', '2022-12-19', 12, '', 1, 0, 0, 0, 0),
(326, 149, 'LAP-IPAD-L14ITL6', 25, 'PAT', '2022-12-19', 11, '', 1, 0, 0, 0, 0),
(327, 150, 'LAP-HP-15-EG2039TU', 25, 'PAT', '2022-12-19', 11, '', 1, 0, 0, 0, 0),
(328, 151, 'LAP-HP-EG2039TU', 25, 'PAT', '2022-12-19', 5, '', 2, 0, 0, 0, 0),
(329, 152, 'LAP-HP-EG2039TU', 25, 'PAT', '2022-12-19', 11, '', 1, 0, 0, 0, 0),
(330, 153, 'LAPCARE-LCP-111', 25, 'PAT', '2022-12-19', 5, '', 1, 0, 0, 0, 0),
(331, 154, 'LAPCARE-LCP-111', 25, 'PAT', '2022-12-19', 5, '', 3, 0, 0, 0, 0),
(332, 155, 'LAPCARE-LCP-111', 25, 'PAT', '2022-12-19', 5, '', 2, 0, 0, 0, 0),
(333, 156, 'DL-ESSL-EML600-2', 25, 'PAT', '2022-12-19', 13, '', 2, 0, 0, 0, 0),
(334, 157, 'M-CHARGE-MI', 25, 'PAT', '2022-12-19', 22, '', 1, 0, 0, 0, 0),
(335, 158, 'M-REDMI-9', 25, 'PAT', '2022-12-19', 12, '', 1, 0, 0, 0, 0),
(336, 159, 'M-MICROMAX-412', 25, 'PAT', '2022-12-19', 23, '', 1, 0, 0, 0, 0),
(337, 160, 'ROUT-WIFI-A-RT-AX55', 25, 'PAT', '2022-12-19', 12, '', 1, 0, 0, 0, 0),
(338, 161, 'ROUT-D--DGS-1210-28', 25, 'PAT', '2022-12-19', 12, '', 1, 0, 0, 0, 0),
(339, 162, 'ROUT-D-DGS-1210-52', 25, 'PAT', '2022-12-19', 24, '', 1, 0, 0, 0, 0),
(340, 162, 'RACK-2U', 25, 'PAT', '2022-12-19', 24, '', 1, 0, 0, 0, 0),
(341, 163, 'ROUT-D-WIFI-001-DIR-', 25, 'PAT', '2022-12-19', 12, '', 1, 0, 0, 0, 0),
(342, 164, 'ROUT-TP-UE300', 25, 'PAT', '2022-12-19', 12, '', 2, 0, 0, 0, 0),
(343, 165, 'ROUT-TP-UE300', 25, 'PAT', '2022-12-19', 12, '', 1, 0, 0, 0, 0),
(344, 166, 'ROUT-TP-AC600', 25, 'PAT', '2022-12-19', 12, '', 1, 0, 0, 0, 0),
(345, 167, 'ROUT-WIFI-A-RT-AX55', 25, 'PAT', '2022-12-19', 5, '', 2, 0, 0, 0, 0),
(346, 168, 'RACK-D-2U', 25, 'PAT', '2022-12-19', 5, '', 1, 0, 0, 0, 0),
(347, 169, 'ROUT-D-DGS-1210-52', 25, 'PAT', '2022-12-19', 5, '', 1, 0, 0, 0, 0),
(348, 170, 'ROUT-H-DS-7632NI-K2', 25, 'PAT', '2022-12-19', 11, '', 1, 0, 0, 0, 0),
(349, 170, 'ROUT-H-DS-3E0510P-E/', 25, 'PAT', '2022-12-19', 11, '', 6, 0, 0, 0, 0),
(350, 170, 'RACK-2U', 25, 'PAT', '2022-12-19', 11, '', 1, 0, 0, 0, 0),
(351, 171, 'ROUT-D-DGS-1210-5', 25, 'PAT', '2022-12-19', 11, '', 1, 0, 0, 0, 0),
(352, 172, 'ROUT-D-DGS-1210-52', 25, 'PAT', '2022-12-19', 17, '', 1, 0, 0, 0, 0),
(353, 173, 'ROUT-TP-WN823N', 25, 'PAT', '2022-12-19', 11, '', 1, 0, 0, 0, 0),
(354, 174, 'REALME-TV-32', 25, 'PAT', '2022-12-19', 11, '', 1, 0, 0, 0, 0),
(359, 175, 'LOGITECH-KEYB', 25, 'PAT', '2023-01-30', 11, '', 100, 0, 0, 0, 0),
(360, 175, 'LOGITECH-MOUSE', 25, 'PAT', '2023-01-30', 11, '', 100, 0, 0, 0, 0),
(369, 176, 'CPUMI3', 25, 'PAT', '2023-01-31', 9, '', 4, 0, 0, 0, 0),
(374, 1, 'CPUMI3', 26, 'PAT', '2023-01-31', 0, '3', 4, 0, 0, 0, 0),
(379, 1, 'CPUMI3', 26, 'PAT', '2023-01-31', 0, '3', 4, 0, 0, 0, 0),
(380, 177, 'CPUI3-3210', 25, 'PAT', '2023-02-01', 9, '', 4, 0, 0, 0, 0),
(381, 178, 'RAM-DDR4-12GB', 25, 'PAT', '2023-02-01', 9, '', 10, 0, 0, 0, 0),
(382, 0, 'HDD-SSD-500GB', 29, 'PAT', '2023-02-01', 0, '', -4, 0, 0, 0, 0),
(383, 0, 'RAM-DDR4-8GB', 29, 'PAT', '2023-02-01', 0, '', -4, 0, 0, 0, 0),
(384, 1, 'CPUMI3', 26, 'PAT', '2023-02-01', 0, '3', 4, 0, 0, 0, 0),
(385, 188, 'FB-CPUMI3', 25, 'PAT', '0000-00-00', 0, '181', 4, 0, 0, 0, 0),
(386, 0, 'HDD-SSD-500GB', 29, 'PAT', '2023-02-01', 0, '', -4, 0, 0, 0, 0),
(387, 0, 'RAM-DDR4-12GB', 29, 'PAT', '2023-02-01', 0, '', -4, 0, 0, 0, 0),
(388, 3, 'CPUI3-3210', 26, 'PAT', '2023-02-01', 0, '2', 4, 0, 0, 0, 0),
(389, 179, 'CPUI3-3210-16GB', 25, 'PAT', '2023-02-01', 9, '', 2, 0, 0, 0, 0),
(390, 0, 'HDD-SSD-500GB', 29, 'PAT', '2023-02-01', 0, '', -4, 0, 0, 0, 0),
(391, 0, 'RAM-DDR4-16GB', 29, 'PAT', '2023-02-01', 0, '', -4, 0, 0, 0, 0),
(392, 4, 'CPUI3-3210-16GB', 26, 'PAT', '2023-02-01', 0, '4', 4, 0, 0, 0, 0),
(393, 180, 'CPUI3-3210-8GB', 25, 'PAT', '2023-02-02', 9, '', 12, 0, 0, 0, 0),
(394, 181, 'RAM-DDR4-8GB', 25, 'PAT', '2023-02-02', 5, '', 20, 0, 0, 0, 0),
(395, 0, 'HDD-SSD-500GB', 29, 'PAT', '2023-02-02', 0, '', -12, 0, 0, 0, 0),
(396, 0, 'RAM-DDR4-8GB', 29, 'PAT', '2023-02-02', 0, '', -12, 0, 0, 0, 0),
(397, 5, 'CPUI3-3210-8GB', 26, 'PAT', '2023-02-02', 0, '1', 12, 0, 0, 0, 0),
(398, 192, 'M-CPUI3-3210-8GB', 25, 'PAT', '0000-00-00', 0, '185', 12, 0, 0, 0, 0),
(399, 182, 'CPUi3-6098P-3.60GH', 25, 'PAT', '2023-02-03', 9, '', 12, 0, 0, 0, 0),
(400, 183, 'CPU-I3-6098P-8GB', 25, 'PAT', '2023-02-03', 9, '', 11, 0, 0, 0, 0),
(401, 0, 'HDD-SSD-500GB', 29, 'PAT', '2023-02-03', 0, '', -1, 0, 0, 0, 0),
(402, 0, 'RAM-DDR4-16GB', 29, 'PAT', '2023-02-03', 0, '', -1, 0, 0, 0, 0),
(403, 6, 'CPUi3-6098P-3.60GH', 26, 'PAT', '2023-02-03', 0, '5', 1, 0, 0, 0, 0),
(404, 184, 'CPUI36098P', 25, 'PAT', '2023-02-03', 9, '', 1, 0, 0, 0, 0),
(405, 185, 'HDD-SSD-240GBM', 25, 'PAT', '2023-02-03', 9, '', 5, 0, 0, 0, 0),
(406, 0, 'HDD-SSD-500GB', 29, 'PAT', '2023-02-03', 0, '', -10, 0, 0, 0, 0),
(407, 0, 'RAM-DDR4-8GB', 29, 'PAT', '2023-02-03', 0, '', -10, 0, 0, 0, 0),
(408, 7, 'CPU-I3-6098P-8GB', 26, 'PAT', '2023-02-03', 0, '6', 10, 0, 0, 0, 0),
(409, 186, 'RAM-DDR4-8GB', 25, 'PAT', '2023-02-03', 9, '', 20, 0, 0, 0, 0),
(410, 0, 'HDD-SSD-240GBM', 29, 'PAT', '2023-02-03', 0, '', -1, 0, 0, 0, 0),
(411, 0, 'RAM-DDR4-8GB', 29, 'PAT', '2023-02-03', 0, '', -1, 0, 0, 0, 0),
(412, 9, 'CPUI36098P', 26, 'PAT', '2023-02-03', 0, '7', 1, 0, 0, 0, 0),
(413, 187, 'HDD-SSD-500GB', 25, 'PAT', '2023-02-03', 9, '', 50, 0, 0, 0, 0),
(414, 188, 'RAM-DDR4-8GB', 25, 'PAT', '2023-02-03', 9, '', 10, 0, 0, 0, 0),
(415, 0, 'HDD-SSD-500GB', 29, 'PAT', '2023-02-03', 0, '', -1, 0, 0, 0, 0),
(416, 0, 'RAM-DDR4-8GB', 29, 'PAT', '2023-02-03', 0, '', -1, 0, 0, 0, 0),
(417, 10, 'CPU-I3-8100', 26, 'PAT', '2023-02-03', 0, '8', 1, 0, 0, 0, 0),
(418, 189, 'CPU-i5-10400-2.90GH', 25, 'PAT', '2023-02-03', 9, '', 10, 0, 0, 0, 0),
(419, 0, 'HDD-SSD-500GB', 29, 'PAT', '2023-02-03', 0, '', -1, 0, 0, 0, 0),
(420, 0, 'RAM-DDR4-16GB', 29, 'PAT', '2023-02-03', 0, '', -1, 0, 0, 0, 0),
(421, 11, 'CPU-i5-10400-2.90GH', 26, 'PAT', '2023-02-03', 0, '9', 1, 0, 0, 0, 0),
(422, 0, 'HDD-SSD-500GB', 29, 'PAT', '2023-02-03', 0, '', -1, 0, 0, 0, 0),
(423, 0, 'RAM-DDR4-8GB', 29, 'PAT', '2023-02-03', 0, '', -1, 0, 0, 0, 0),
(424, 12, 'CPU-I5-10400', 26, 'PAT', '2023-02-03', 0, '10', 1, 0, 0, 0, 0),
(425, 190, 'CPUI52310-2.90', 25, 'PAT', '2023-02-03', 9, '', 1, 0, 0, 0, 0),
(426, 0, 'HDD-SSD-500GB', 29, 'PAT', '2023-02-03', 0, '', -1, 0, 0, 0, 0),
(427, 0, 'RAM-DDR4-8GB', 29, 'PAT', '2023-02-03', 0, '', -1, 0, 0, 0, 0),
(428, 14, 'CPUI52310-2.90', 26, 'PAT', '2023-02-03', 0, '11', 1, 0, 0, 0, 0),
(429, 191, 'CPUI5-11400-2.60GH', 25, 'PAT', '2023-02-06', 9, '', 1, 0, 0, 0, 0),
(430, 0, 'HDD-SSD-1TB', 29, 'PAT', '2023-02-06', 0, '', -1, 0, 0, 0, 0),
(431, 0, 'HDD-SSD-500GB', 29, 'PAT', '2023-02-06', 0, '', -1, 0, 0, 0, 0),
(432, 0, 'RAM-DDR4-16GB', 29, 'PAT', '2023-02-06', 0, '', -1, 0, 0, 0, 0),
(433, 15, 'CPUI5-11400-2.60GH', 26, 'PAT', '2023-02-06', 0, '12', 1, 0, 0, 0, 0),
(434, 192, 'CPUI5-9400F-2.90GH', 25, 'PAT', '2023-02-06', 9, '', 1, 0, 0, 0, 0),
(435, 0, 'HDD-SSD-500GB', 29, 'PAT', '2023-02-06', 0, '', -1, 0, 0, 0, 0),
(436, 0, 'RAM-DDR4-16GB', 29, 'PAT', '2023-02-06', 0, '', -1, 0, 0, 0, 0),
(437, 16, 'CPU-I5-9400', 26, 'PAT', '2023-02-06', 0, '13', 1, 0, 0, 0, 0),
(438, 193, 'CPUI3-3210-3.20GH-12', 25, 'PAT', '2023-02-06', 9, '', 1, 0, 0, 0, 0),
(439, 193, 'LAP-HP-I5', 25, 'PAT', '2023-02-06', 9, '', 1, 0, 0, 0, 0),
(440, 0, 'HDD-500GB', 29, 'PAT', '2023-02-06', 0, '', -1, 0, 0, 0, 0),
(441, 0, 'HDD-SSD-250GB', 29, 'PAT', '2023-02-06', 0, '', -1, 0, 0, 0, 0),
(442, 0, 'RAM-DDR4-12GB', 29, 'PAT', '2023-02-06', 0, '', -1, 0, 0, 0, 0),
(443, 17, 'CPUI3-3210-3.20GH-12', 26, 'PAT', '2023-02-06', 0, '14', 1, 0, 0, 0, 0),
(444, 194, 'CPUI5-3210-2.20GHz', 25, 'PAT', '2023-02-06', 9, '', 1, 0, 0, 0, 0),
(445, 0, 'HDD-500GB', 29, 'PAT', '2023-02-06', 0, '', -1, 0, 0, 0, 0),
(446, 0, 'RAM-DDR4-8GB', 29, 'PAT', '2023-02-06', 0, '', -1, 0, 0, 0, 0),
(447, 18, 'CPUI5-3210-2.20GHz', 26, 'PAT', '2023-02-06', 0, '15', 1, 0, 0, 0, 0),
(448, 195, 'CPUI5-8400-2.80-16GB', 25, 'PAT', '2023-02-06', 9, '', 1, 0, 0, 0, 0),
(449, 0, 'HDD-SSD-500GB', 29, 'PAT', '2023-02-06', 0, '', -1, 0, 0, 0, 0),
(450, 0, 'RAM-DDR4-16GB', 29, 'PAT', '2023-02-06', 0, '', -1, 0, 0, 0, 0),
(451, 19, 'CPUI5-8400-2.80-16GB', 26, 'PAT', '2023-02-06', 0, '16', 1, 0, 0, 0, 0),
(452, 196, 'CPUI5-10400-2.90-16G', 25, 'PAT', '2023-02-06', 9, '', 2, 0, 0, 0, 0),
(453, 0, 'HDD-HDD-1TB', 29, 'PAT', '2023-02-06', 0, '', -2, 0, 0, 0, 0),
(454, 0, 'HDD-SSD-500GB', 29, 'PAT', '2023-02-06', 0, '', -2, 0, 0, 0, 0),
(455, 0, 'RAM-DDR4-16GB', 29, 'PAT', '2023-02-06', 0, '', -2, 0, 0, 0, 0),
(456, 20, 'CPUI5-10400-2.90-16G', 26, 'PAT', '2023-02-06', 0, '17', 2, 0, 0, 0, 0),
(457, 197, 'CPUI3-10400-3.20-16G', 25, 'PAT', '2023-02-06', 9, '', 1, 0, 0, 0, 0),
(458, 0, 'HDD-SSD-500GB', 29, 'PAT', '2023-02-06', 0, '', -1, 0, 0, 0, 0),
(459, 0, 'RAM-DDR4-16GB', 29, 'PAT', '2023-02-06', 0, '', -1, 0, 0, 0, 0),
(460, 21, 'CPUI3-10400-3.20-16G', 26, 'PAT', '2023-02-06', 0, '18', 1, 0, 0, 0, 0),
(461, 198, 'CPUI3-6098P-3.60-16G', 25, 'PAT', '2023-02-06', 9, '', 1, 0, 0, 0, 0),
(462, 199, 'HDD-SSD-250GB', 25, 'PAT', '2023-02-06', 9, '', 15, 0, 0, 0, 0),
(463, 0, 'HDD-HDD-1TB', 29, 'PAT', '2023-02-06', 0, '', -1, 0, 0, 0, 0),
(464, 0, 'HDD-SSD-250GB', 29, 'PAT', '2023-02-06', 0, '', -1, 0, 0, 0, 0),
(465, 0, 'RAM-DDR4-16GB', 29, 'PAT', '2023-02-06', 0, '', -1, 0, 0, 0, 0),
(466, 22, 'CPUI3-6098P-3.60-16G', 26, 'PAT', '2023-02-06', 0, '19', 1, 0, 0, 0, 0),
(467, 200, 'CPUI5-10400-2.9-16GB', 25, 'PAT', '2023-02-06', 9, '', 2, 0, 0, 0, 0),
(468, 0, 'HDD-SSD-500GB', 29, 'PAT', '2023-02-06', 0, '', -2, 0, 0, 0, 0),
(469, 0, 'RAM-DDR4-16GB', 29, 'PAT', '2023-02-06', 0, '', -2, 0, 0, 0, 0),
(470, 23, 'CPUI5-10400-2.9-16GB', 26, 'PAT', '2023-02-06', 0, '20', 2, 0, 0, 0, 0),
(471, 201, 'CPU-I7-7700k-4.20GH', 25, 'PAT', '2023-02-06', 9, '', 1, 0, 0, 0, 0),
(472, 202, 'RAM-32GB', 25, 'PAT', '2023-02-06', 9, '', 5, 0, 0, 0, 0),
(473, 203, 'RAM-32GB', 25, 'PAT', '2023-02-06', 9, '', 2, 0, 0, 0, 0),
(474, 0, 'HDD-1TB', 29, 'PAT', '2023-02-06', 0, '', -1, 0, 0, 0, 0),
(475, 0, 'HDD-SSD-250GB', 29, 'PAT', '2023-02-06', 0, '', -1, 0, 0, 0, 0),
(476, 0, 'RAM-32GB', 29, 'PAT', '2023-02-06', 0, '', -1, 0, 0, 0, 0),
(477, 24, 'CPU-I7-7700k-4.20GH', 26, 'PAT', '2023-02-06', 0, '21', 1, 0, 0, 0, 0),
(478, 204, 'CPU-I5-10400-2.9G16G', 25, 'PAT', '2023-02-06', 9, '', 6, 0, 0, 0, 0),
(479, 0, 'HDD-HDD-1TB', 29, 'PAT', '2023-02-06', 0, '', -6, 0, 0, 0, 0),
(480, 0, 'HDD-SSD-500GB', 29, 'PAT', '2023-02-06', 0, '', -6, 0, 0, 0, 0),
(481, 0, 'RAM-DDR4-16GB', 29, 'PAT', '2023-02-06', 0, '', -6, 0, 0, 0, 0),
(482, 25, 'CPU-I5-10400-2.9G16G', 26, 'PAT', '2023-02-06', 0, '22', 6, 0, 0, 0, 0),
(483, 205, 'CPU-I7-8700K-3.70GH', 25, 'PAT', '2023-02-06', 9, '', 1, 0, 0, 0, 0),
(484, 0, 'HDD-HDD-1TB', 29, 'PAT', '2023-02-06', 0, '', -1, 0, 0, 0, 0),
(485, 0, 'HDD-SSD-250GB', 29, 'PAT', '2023-02-06', 0, '', -1, 0, 0, 0, 0),
(486, 0, 'RAM-32GB', 29, 'PAT', '2023-02-06', 0, '', -1, 0, 0, 0, 0),
(487, 27, 'CPU-I7-8700K-3.70GH', 26, 'PAT', '2023-02-06', 0, '23', 1, 0, 0, 0, 0),
(488, 206, 'CPU-I5-8400-2.80GHz', 25, 'PAT', '2023-02-06', 9, '', 1, 0, 0, 0, 0),
(489, 0, 'HDD-HDD-1TB', 29, 'PAT', '2023-02-06', 0, '', -1, 0, 0, 0, 0),
(490, 0, 'HDD-SSD-250GB', 29, 'PAT', '2023-02-06', 0, '', -1, 0, 0, 0, 0),
(491, 0, 'RAM-DDR3-16GB', 29, 'PAT', '2023-02-06', 0, '', -1, 0, 0, 0, 0),
(492, 28, 'CPU-I5-8400-2.80GHz', 26, 'PAT', '2023-02-06', 0, '24', 1, 0, 0, 0, 0),
(493, 207, 'CPUI5-11400-2.6GH16G', 25, 'PAT', '2023-02-06', 9, '', 2, 0, 0, 0, 0),
(494, 29, 'CPUI5-11400-2.6GH16G', 26, 'PAT', '2023-02-06', 0, '25', 2, 0, 0, 0, 0),
(495, 208, 'CPU-I3-3210-3.2GH16', 25, 'PAT', '2023-02-06', 9, '', 1, 0, 0, 0, 0),
(496, 209, 'HDD-4TB', 25, 'PAT', '2023-02-06', 9, '', 5, 0, 0, 0, 0),
(497, 210, 'RAM-DDR4-16GB', 25, 'PAT', '2023-02-06', 9, '', 50, 0, 0, 0, 0),
(498, 0, 'HDD-4TB', 29, 'PAT', '2023-02-06', 0, '', -1, 0, 0, 0, 0),
(499, 0, 'HDD-SSD-500GB', 29, 'PAT', '2023-02-06', 0, '', -1, 0, 0, 0, 0),
(500, 0, 'RAM-DDR4-16GB', 29, 'PAT', '2023-02-06', 0, '', -1, 0, 0, 0, 0),
(501, 30, 'CPU-I3-3210-3.2GH16', 26, 'PAT', '2023-02-06', 0, '26', 1, 0, 0, 0, 0),
(502, 211, 'CPU-I3-8100-3.6GH-16', 25, 'PAT', '2023-02-06', 9, '', 1, 0, 0, 0, 0),
(503, 0, 'HDD-SSD-500GB', 29, 'PAT', '2023-02-06', 0, '', -1, 0, 0, 0, 0),
(504, 0, 'RAM-DDR4-16GB', 29, 'PAT', '2023-02-06', 0, '', -1, 0, 0, 0, 0),
(505, 31, 'CPU-I3-8100-3.6GH-16', 26, 'PAT', '2023-02-06', 0, '27', 1, 0, 0, 0, 0),
(506, 212, 'CPUI3-2120-3.2G-12GB', 25, 'PAT', '2023-02-06', 9, '', 1, 0, 0, 0, 0),
(507, 0, 'HDD-HDD-1TB', 29, 'PAT', '2023-02-06', 0, '', -1, 0, 0, 0, 0),
(508, 0, 'HDD-SSD-500GB', 29, 'PAT', '2023-02-06', 0, '', -1, 0, 0, 0, 0),
(509, 0, 'RAM-DDR4-12GB', 29, 'PAT', '2023-02-06', 0, '', -1, 0, 0, 0, 0),
(510, 32, 'CPUI3-2120-3.2G-12GB', 26, 'PAT', '2023-02-06', 0, '28', 1, 0, 0, 0, 0),
(511, 213, 'CPU-I3-3210-3.2-1TB', 25, 'PAT', '2023-02-07', 9, '', 1, 0, 0, 0, 0),
(512, 0, 'HDD-HDD-1TB', 29, 'PAT', '2023-02-07', 0, '', -1, 0, 0, 0, 0),
(513, 0, 'RAM-DDR4-16GB', 29, 'PAT', '2023-02-07', 0, '', -1, 0, 0, 0, 0),
(514, 33, 'CPU-I3-3210-3.2-1TB', 26, 'PAT', '2023-02-07', 0, '29', 1, 0, 0, 0, 0),
(515, 214, 'CPU-I5-8400-2.8G32GB', 25, 'PAT', '2023-02-07', 9, '', 1, 0, 0, 0, 0),
(516, 215, 'RAM-32GB', 25, 'PAT', '2023-02-07', 9, '', 5, 0, 0, 0, 0),
(517, 0, 'HDD-HDD-2TB', 29, 'PAT', '2023-02-07', 0, '', -1, 0, 0, 0, 0),
(518, 0, 'RAM-32GB', 29, 'PAT', '2023-02-07', 0, '', -1, 0, 0, 0, 0),
(519, 34, 'CPU-I5-8400-2.8G32GB', 26, 'PAT', '2023-02-07', 0, '30', 1, 0, 0, 0, 0),
(520, 216, 'CPU-I3-2120-3.3G-16G', 25, 'PAT', '2023-02-07', 9, '', 1, 0, 0, 0, 0),
(521, 0, 'HDD-SSD-500GB', 29, 'PAT', '2023-02-07', 0, '', -1, 0, 0, 0, 0),
(522, 0, 'RAM-DDR4-16GB', 29, 'PAT', '2023-02-07', 0, '', -1, 0, 0, 0, 0),
(523, 35, 'CPU-I3-2120-3.3G-16G', 26, 'PAT', '2023-02-07', 0, '31', 1, 0, 0, 0, 0),
(524, 217, 'CPUI7-1260P-RAM-16G', 25, 'PAT', '2023-02-07', 9, '', 4, 0, 0, 0, 0),
(525, 218, 'HDD-SSD-1TB', 25, 'PAT', '2023-02-07', 5, '', 5, 0, 0, 0, 0),
(526, 0, 'HDD-SSD-1TB', 29, 'PAT', '2023-02-07', 0, '', -4, 0, 0, 0, 0),
(527, 0, 'RAM-DDR4-16GB', 29, 'PAT', '2023-02-07', 0, '', -4, 0, 0, 0, 0),
(528, 36, 'CPUI7-1260P-RAM-16G', 26, 'PAT', '2023-02-07', 0, '32', 4, 0, 0, 0, 0),
(529, 219, 'CPUI7-1165G7-RAM-16G', 25, 'PAT', '2023-02-07', 9, '', 1, 0, 0, 0, 0),
(530, 0, 'HDD-SSD-500GB', 29, 'PAT', '2023-02-07', 0, '', -1, 0, 0, 0, 0),
(531, 0, 'RAM-DDR4-16GB', 29, 'PAT', '2023-02-07', 0, '', -1, 0, 0, 0, 0),
(532, 37, 'CPUI7-1165G7-RAM-16G', 26, 'PAT', '2023-02-07', 0, '33', 1, 0, 0, 0, 0),
(533, 220, 'CPUI5-9400F-2.9G-16G', 25, 'PAT', '2023-02-07', 9, '', 1, 0, 0, 0, 0),
(534, 0, 'HDD-1TB', 29, 'PAT', '2023-02-07', 0, '', -1, 0, 0, 0, 0),
(535, 0, 'HDD-SSD-500GB', 29, 'PAT', '2023-02-07', 0, '', -1, 0, 0, 0, 0),
(536, 0, 'RAM-DDR4-16GB', 29, 'PAT', '2023-02-07', 0, '', -1, 0, 0, 0, 0),
(537, 38, 'CPUI5-9400F-2.9G-16G', 26, 'PAT', '2023-02-07', 0, '34', 1, 0, 0, 0, 0),
(538, 221, 'CPUI3-8100-3.6G-16GB', 25, 'PAT', '2023-02-07', 9, '', 1, 0, 0, 0, 0),
(539, 0, 'HDD-HDD-1TB', 29, 'PAT', '2023-02-07', 0, '', -1, 0, 0, 0, 0),
(540, 0, 'HDD-SSD-250GB', 29, 'PAT', '2023-02-07', 0, '', -1, 0, 0, 0, 0),
(541, 0, 'RAM-DDR4-16GB', 29, 'PAT', '2023-02-07', 0, '', -1, 0, 0, 0, 0),
(542, 39, 'CPUI3-8100-3.6G-16GB', 26, 'PAT', '2023-02-07', 0, '35', 1, 0, 0, 0, 0),
(543, 222, 'CPUI3-3210-3.2G-16GB', 25, 'PAT', '2023-02-07', 9, '', 1, 0, 0, 0, 0),
(544, 0, 'HDD-SSD-500GB', 29, 'PAT', '2023-02-07', 0, '', -1, 0, 0, 0, 0),
(545, 0, 'RAM-DDR4-16GB', 29, 'PAT', '2023-02-07', 0, '', -1, 0, 0, 0, 0),
(546, 40, 'CPUI3-3210-3.2G-16GB', 26, 'PAT', '2023-02-07', 0, '36', 1, 0, 0, 0, 0),
(547, 223, 'CPUI5-10400-2.9G-16G', 25, 'PAT', '2023-02-07', 9, '', 1, 0, 0, 0, 0),
(548, 0, 'HDD-1TB', 29, 'PAT', '2023-02-07', 0, '', -1, 0, 0, 0, 0),
(549, 0, 'HDD-SSD-500GB', 29, 'PAT', '2023-02-07', 0, '', -1, 0, 0, 0, 0),
(550, 0, 'RAM-DDR4-16GB', 29, 'PAT', '2023-02-07', 0, '', -1, 0, 0, 0, 0),
(551, 41, 'CPUI5-10400-2.9G-16G', 26, 'PAT', '2023-02-07', 0, '37', 1, 0, 0, 0, 0),
(552, 224, 'CPUI3-6098P-3.60-16G', 25, 'PAT', '2023-02-07', 9, '', 1, 0, 0, 0, 0),
(553, 225, 'RAM-DDR4-16GB', 25, 'PAT', '2023-02-07', 9, '', 1, 0, 0, 0, 0),
(554, 0, 'HDD-HDD-1TB', 29, 'PAT', '2023-02-07', 0, '', -1, 0, 0, 0, 0),
(555, 0, 'HDD-SSD-250GB', 29, 'PAT', '2023-02-07', 0, '', -1, 0, 0, 0, 0),
(556, 0, 'RAM-DDR4-16GB', 29, 'PAT', '2023-02-07', 0, '', -1, 0, 0, 0, 0),
(557, 42, 'CPU-I36098P-3.6G-16G', 26, 'PAT', '2023-02-07', 0, '38', 1, 0, 0, 0, 0),
(558, 226, 'CPUI5-8400-2.80GHz', 25, 'PAT', '2023-02-07', 9, '', 1, 0, 0, 0, 0),
(559, 0, 'HDD-1TB', 29, 'PAT', '2023-02-07', 0, '', -2, 0, 0, 0, 0),
(560, 0, 'HDD-SSD-500GB', 29, 'PAT', '2023-02-07', 0, '', -2, 0, 0, 0, 0),
(561, 0, 'RAM-DDR4-16GB', 29, 'PAT', '2023-02-07', 0, '', -2, 0, 0, 0, 0),
(562, 43, 'CPUI5-8400-2.80GHz', 26, 'PAT', '2023-02-07', 0, '39', 2, 0, 0, 0, 0),
(563, 0, 'HDD-HDD-1TB', 29, 'PAT', '2023-02-07', 0, '', -1, 0, 0, 0, 0),
(564, 0, 'HDD-SSD-500GB', 29, 'PAT', '2023-02-07', 0, '', -1, 0, 0, 0, 0),
(565, 0, 'RAM-DDR4-16GB', 29, 'PAT', '2023-02-07', 0, '', -1, 0, 0, 0, 0),
(566, 44, 'CPU-I3-10105-3.7G-16', 26, 'PAT', '2023-02-07', 0, '40', 1, 0, 0, 0, 0),
(567, 227, 'CPU-I5-11400-2.6-16G', 25, 'PAT', '2023-02-07', 9, '', 1, 0, 0, 0, 0),
(568, 0, 'HDD-SSD-250GB', 29, 'PAT', '2023-02-07', 0, '', -1, 0, 0, 0, 0),
(569, 0, 'RAM-DDR4-16GB', 29, 'PAT', '2023-02-07', 0, '', -1, 0, 0, 0, 0),
(570, 45, 'CPU-I5-11400-2.6-16G', 26, 'PAT', '2023-02-07', 0, '41', 1, 0, 0, 0, 0),
(571, 228, 'CPU-I5-2400-3.1G-16G', 25, 'PAT', '2023-02-07', 9, '', 1, 0, 0, 0, 0),
(572, 0, 'HDD-1TB', 29, 'PAT', '2023-02-07', 0, '', -1, 0, 0, 0, 0),
(573, 0, 'HDD-SSD-500GB', 29, 'PAT', '2023-02-07', 0, '', -1, 0, 0, 0, 0),
(574, 0, 'RAM-DDR4-16GB', 29, 'PAT', '2023-02-07', 0, '', -1, 0, 0, 0, 0),
(575, 46, 'CPU-I5-2400-3.1G-16G', 26, 'PAT', '2023-02-07', 0, '42', 1, 0, 0, 0, 0),
(576, 229, 'CPU-I5-10400-2.90-16', 25, 'PAT', '2023-02-07', 9, '', 2, 0, 0, 0, 0),
(577, 0, 'HDD-SSD-500GB', 29, 'PAT', '2023-02-07', 0, '', -2, 0, 0, 0, 0),
(578, 0, 'RAM-DDR4-16GB', 29, 'PAT', '2023-02-07', 0, '', -2, 0, 0, 0, 0),
(579, 47, 'CPU-I5-10400-2.90-16', 26, 'PAT', '2023-02-07', 0, '43', 2, 0, 0, 0, 0),
(580, 230, 'CPU-I3-8100-3.6-16Gb', 25, 'PAT', '2023-02-07', 9, '', 1, 0, 0, 0, 0),
(581, 0, 'HDD-1TB', 29, 'PAT', '2023-02-07', 0, '', -1, 0, 0, 0, 0),
(582, 0, 'HDD-SSD-500GB', 29, 'PAT', '2023-02-07', 0, '', -1, 0, 0, 0, 0),
(583, 0, 'RAM-DDR4-16GB', 29, 'PAT', '2023-02-07', 0, '', -1, 0, 0, 0, 0),
(584, 48, 'CPU-I3-8100-3.6-16Gb', 26, 'PAT', '2023-02-07', 0, '44', 1, 0, 0, 0, 0),
(585, 231, 'CPU-I5-11400-2.6-16', 25, 'PAT', '2023-02-07', 9, '', 1, 0, 0, 0, 0),
(586, 0, 'HDD-SSD-500GB', 29, 'PAT', '2023-02-07', 0, '', -1, 0, 0, 0, 0),
(587, 0, 'RAM-DDR4-16GB', 29, 'PAT', '2023-02-07', 0, '', -1, 0, 0, 0, 0),
(588, 49, 'CPU-I5-11400-2.6-16', 26, 'PAT', '2023-02-07', 0, '45', 1, 0, 0, 0, 0),
(589, 232, 'CPU-I5-10400-2.90-16', 25, 'PAT', '2023-02-07', 9, '', 1, 0, 0, 0, 0),
(590, 233, 'CPU-I5-10400-2.9-16', 25, 'PAT', '2023-02-07', 9, '', 1, 0, 0, 0, 0),
(591, 0, 'HDD-1TB', 29, 'PAT', '2023-02-07', 0, '', -1, 0, 0, 0, 0),
(592, 0, 'HDD-SSD-500GB', 29, 'PAT', '2023-02-07', 0, '', -1, 0, 0, 0, 0),
(593, 0, 'RAM-DDR4-16GB', 29, 'PAT', '2023-02-07', 0, '', -1, 0, 0, 0, 0),
(594, 50, 'CPU-I5-10400-2.9-16', 26, 'PAT', '2023-02-07', 0, '46', 1, 0, 0, 0, 0),
(595, 234, 'CPUI5-11400-2.6-16G', 25, 'PAT', '2023-02-07', 9, '', 2, 0, 0, 0, 0),
(596, 0, 'HDD-1TB', 29, 'PAT', '2023-02-07', 0, '', -2, 0, 0, 0, 0),
(597, 0, 'HDD-SSD-250GB', 29, 'PAT', '2023-02-07', 0, '', -2, 0, 0, 0, 0),
(598, 0, 'RAM-DDR4-16GB', 29, 'PAT', '2023-02-07', 0, '', -2, 0, 0, 0, 0),
(599, 51, 'CPUI5-11400-2.6-16G', 26, 'PAT', '2023-02-07', 0, '47', 2, 0, 0, 0, 0),
(600, 235, 'CPUI3-6098P-3.6-16', 25, 'PAT', '2023-02-07', 9, '', 1, 0, 0, 0, 0),
(601, 0, 'HDD-HDD-1TB', 29, 'PAT', '2023-02-07', 0, '', -1, 0, 0, 0, 0),
(602, 0, 'HDD-SSD-500GB', 29, 'PAT', '2023-02-07', 0, '', -1, 0, 0, 0, 0),
(603, 0, 'RAM-DDR4-16GB', 29, 'PAT', '2023-02-07', 0, '', -1, 0, 0, 0, 0),
(604, 52, 'CPUI3-6098P-3.6-16', 26, 'PAT', '2023-02-07', 0, '48', 1, 0, 0, 0, 0),
(605, 236, 'CPU-I3-4005U-1.70GH', 25, 'PAT', '2023-02-07', 9, '', 1, 0, 0, 0, 0),
(606, 237, 'CPU-I3-10100-3.6-8GB', 25, 'PAT', '2023-02-07', 9, '', 1, 0, 0, 0, 0),
(607, 0, 'HDD-1TB', 29, 'PAT', '2023-02-07', 0, '', -1, 0, 0, 0, 0),
(608, 0, 'HDD-SSD-240GBM', 29, 'PAT', '2023-02-07', 0, '', -1, 0, 0, 0, 0),
(609, 0, 'RAM-DDR4-8GB', 29, 'PAT', '2023-02-07', 0, '', -1, 0, 0, 0, 0),
(610, 53, 'CPU-I3-10100-3.6-8GB', 26, 'PAT', '2023-02-07', 0, '49', 1, 0, 0, 0, 0),
(611, 238, 'CPU-I3-2330M-2.20-L', 25, 'PAT', '2023-02-07', 9, '', 1, 0, 0, 0, 0),
(612, 239, 'CPU-I3-6100U-2.30-L', 25, 'PAT', '2023-02-07', 9, '', 1, 0, 0, 0, 0),
(613, 240, 'CPU-I5-1035G1-1.0-L', 25, 'PAT', '2023-02-07', 9, '', 1, 0, 0, 0, 0),
(614, 241, 'Cpu-i3-2.4G-4gb-LAP', 25, 'PAT', '2023-02-07', 9, '', 1, 0, 0, 0, 0),
(615, 242, 'CPU-I3-3210-3.20G-16', 25, 'PAT', '2023-02-07', 9, '', 1, 0, 0, 0, 0),
(616, 0, 'HDD-SSD-250GB', 29, 'PAT', '2023-02-07', 0, '', -1, 0, 0, 0, 0),
(617, 0, 'RAM-DDR4-16GB', 29, 'PAT', '2023-02-07', 0, '', -1, 0, 0, 0, 0),
(618, 54, 'CPU-I3-3210-3.20G-16', 26, 'PAT', '2023-02-07', 0, '50', 1, 0, 0, 0, 0),
(619, 243, 'CPU-I5-10400-2.9-16G', 25, 'PAT', '2023-02-07', 9, '', 1, 0, 0, 0, 0),
(620, 0, 'HDD-SSD-500GB', 29, 'PAT', '2023-02-07', 0, '', -1, 0, 0, 0, 0),
(621, 0, 'RAM-DDR4-16GB', 29, 'PAT', '2023-02-07', 0, '', -1, 0, 0, 0, 0),
(622, 55, 'CPU-I5-10400-2.9-16G', 26, 'PAT', '2023-02-07', 0, '51', 1, 0, 0, 0, 0),
(623, 255, 'M-CPUI5-10400-8Gb', 25, 'HYD', '0000-00-00', 0, '248', 1, 0, 0, 0, 0),
(624, 256, 'M-CPUI52310-2.90', 25, 'PAT', '0000-00-00', 0, '249', 1, 0, 0, 0, 0),
(625, 257, 'CPUI5-11400-2.60-16GB', 25, 'PAT', '0000-00-00', 0, '250', 1, 0, 0, 0, 0),
(626, 258, 'CPUI5-9400F 2.9 GH 16 GB', 25, 'PAT', '0000-00-00', 0, '251', 1, 0, 0, 0, 0),
(627, 259, 'M-CPUI3-3210-3.2-12', 25, 'PAT', '0000-00-00', 0, '252', 1, 0, 0, 0, 0),
(628, 260, 'M-CPUI5-3210-2.20-8GB', 25, 'PAT', '0000-00-00', 0, '253', 1, 0, 0, 0, 0),
(629, 261, 'M-CPUI5-8400-2.8-16GB', 25, 'PAT', '0000-00-00', 0, '254', 1, 0, 0, 0, 0),
(630, 262, 'M-CPUI510400-2.90GHz', 25, 'PAT', '0000-00-00', 0, '255', 2, 0, 0, 0, 0),
(631, 263, 'M-CPUI3-10400-16G', 25, 'PAT', '0000-00-00', 0, '256', 1, 0, 0, 0, 0),
(632, 264, 'M-CPUI3-6098P-3.60-16G', 25, 'PAT', '0000-00-00', 0, '257', 1, 0, 0, 0, 0),
(633, 265, 'M-CPUI3-3210', 25, 'PAT', '0000-00-00', 0, '258', 4, 0, 0, 0, 0),
(634, 266, 'M-CPUI5-10400-500GB-16GB', 25, 'PAT', '0000-00-00', 0, '259', 2, 0, 0, 0, 0),
(635, 267, 'M-CPU-I7-32GB', 25, 'PAT', '0000-00-00', 0, '260', 1, 0, 0, 0, 0),
(636, 268, 'M-CPU-I5-10100-16gb', 25, 'PAT', '0000-00-00', 0, '261', 6, 0, 0, 0, 0),
(637, 269, 'M-CPUI7-8700K-32GB', 25, 'PAT', '0000-00-00', 0, '262', 1, 0, 0, 0, 0),
(638, 270, 'CPUI5-8400-2.8GH-16GB', 25, 'PAT', '0000-00-00', 0, '263', 1, 0, 0, 0, 0),
(639, 271, 'M-CPU- i5-11400-2.60GH 16GB', 25, 'PAT', '0000-00-00', 0, '264', 2, 0, 0, 0, 0),
(640, 272, 'M-CPUI3-3210-16GB-SSD500GB', 25, 'HYD', '0000-00-00', 0, '265', 1, 0, 0, 0, 0),
(641, 273, 'M-CPUI3-8100-3.6 16GB', 25, 'PAT', '0000-00-00', 0, '266', 1, 0, 0, 0, 0),
(642, 274, 'M-CPUI3-3.2-2120-12GB', 25, 'PAT', '0000-00-00', 0, '267', 1, 0, 0, 0, 0),
(643, 275, 'M-CPUI3-3210-1TBHDD', 25, 'PAT', '0000-00-00', 0, '268', 1, 0, 0, 0, 0),
(644, 276, 'M-CPUI5-8400-2.8GH 32GB 2TB', 25, 'PAT', '0000-00-00', 0, '269', 1, 0, 0, 0, 0),
(645, 277, 'M-CPUI3-2120-16GB-500GB', 25, 'PAT', '0000-00-00', 0, '270', 1, 0, 0, 0, 0),
(646, 278, 'M-CPUI7-1165G7-16GB-500GB', 25, 'PAT', '0000-00-00', 0, '271', 1, 0, 0, 0, 0),
(647, 279, 'M-CPUI7-1260P-16GB-1TB', 25, 'PAT', '0000-00-00', 0, '272', 4, 0, 0, 0, 0),
(648, 280, 'M-CPUI5-9400F-16GB-500GB-1TB', 25, 'PAT', '0000-00-00', 0, '273', 1, 0, 0, 0, 0),
(649, 281, 'M-CPUI3-8100-3.6G-16GB-250GB', 25, 'PAT', '0000-00-00', 0, '274', 1, 0, 0, 0, 0),
(650, 282, 'M-CPI3-3210-16GB-500GB', 25, 'PAT', '0000-00-00', 0, '275', 1, 0, 0, 0, 0),
(651, 283, 'M-CPUI510400-2.9G-16G-500GB-1TB', 25, 'PAT', '0000-00-00', 0, '276', 1, 0, 0, 0, 0),
(652, 284, 'M-CPUI3-6089-3.6-16G-250GB-1TB', 25, 'PAT', '0000-00-00', 0, '277', 1, 0, 0, 0, 0),
(653, 285, 'M-CPUI5-8400-2.8G-12GB-500GB-1TB', 25, 'PAT', '0000-00-00', 0, '278', 2, 0, 0, 0, 0),
(654, 286, 'M-CPUI3-16GB', 25, 'PAT', '0000-00-00', 0, '279', 4, 0, 0, 0, 0),
(655, 287, 'M-CPUI3-10105-3.7G-16GB-500GB-1tb', 25, 'PAT', '0000-00-00', 0, '280', 1, 0, 0, 0, 0),
(656, 288, 'M-CPUI5-11400-2.6-16GB-250GB', 25, 'PAT', '0000-00-00', 0, '281', 1, 0, 0, 0, 0),
(657, 289, 'M-CPUI5-2400-3.1G-16G-500GB-SSD-1TB-HDD', 25, 'PAT', '0000-00-00', 0, '282', 1, 0, 0, 0, 0),
(658, 290, 'M-CPUI5-10400-2.9-16GB-SSD-500GB', 25, 'PAT', '0000-00-00', 0, '283', 2, 0, 0, 0, 0),
(659, 291, 'M-CPUI3-8100-3.6-16GB-500-SSD', 25, 'PAT', '0000-00-00', 0, '284', 1, 0, 0, 0, 0),
(660, 292, 'M-CPUI5-11400-2.6-16Gb-SSD-500GB', 25, 'PAT', '0000-00-00', 0, '285', 1, 0, 0, 0, 0),
(661, 293, 'M-CPUI5-10400-2.9-16GB-SSD500Gb-', 25, 'PAT', '0000-00-00', 0, '286', 1, 0, 0, 0, 0),
(662, 294, 'M-CPUI5-11400-2.6-16GB-SSD-250GB-1TB', 25, 'PAT', '0000-00-00', 0, '287', 2, 0, 0, 0, 0),
(663, 295, 'M-CPUI3-6098P-3.6-16GB-500GB', 25, 'PAT', '0000-00-00', 0, '288', 1, 0, 0, 0, 0),
(664, 296, 'M-CPUI3-10100-3.6-8GB-SSD-240GB', 25, 'PAT', '0000-00-00', 0, '289', 1, 0, 0, 0, 0),
(665, 297, 'CPUI3-6098P', 25, 'PAT', '0000-00-00', 0, '290', 1, 0, 0, 0, 0),
(666, 298, 'M-CPUI3-3210-3.2G-16GB-SSD-250GB', 25, 'PAT', '0000-00-00', 0, '291', 1, 0, 0, 0, 0),
(667, 299, 'M-CPUI5-10400-2.9-16GB-500GB-SSD', 25, 'PAT', '0000-00-00', 0, '292', 1, 0, 0, 0, 0),
(668, 300, 'CPUI3-6098P8GB', 25, 'PAT', '0000-00-00', 0, '293', 10, 0, 0, 0, 0),
(669, 301, 'CPUI3-6098P-240GB', 25, 'PAT', '0000-00-00', 0, '294', 1, 0, 0, 0, 0),
(670, 302, 'M-CPU-I3-8100', 25, 'PAT', '0000-00-00', 0, '295', 1, 0, 0, 0, 0),
(671, 303, 'M-CPUI5-10400', 25, 'PAT', '0000-00-00', 0, '296', 1, 0, 0, 0, 0),
(672, 244, 'LAP-HP-I5-2.2-8GB', 25, 'PAT', '2023-02-08', 5, '', 1, 0, 0, 0, 0),
(673, 245, 'LAP-DELL-I3-8GB-1TB', 25, 'PAT', '2023-02-08', 5, '', 1, 0, 0, 0, 0),
(674, 246, 'LAP-I7-16GB-500GB', 25, 'PAT', '2023-02-08', 9, '', 1, 0, 0, 0, 0),
(675, 247, 'LAP-I5-16GB-SSD-500G', 25, 'PAT', '2023-02-08', 9, '', 1, 0, 0, 0, 0),
(676, 3, 'FB-CPUMI3', 28, 'PAT', '2023-02-09', 0, '', -1, 0, 0, 0, 0),
(677, 4, 'M-CPUI5-10400', 28, 'PAT', '2023-02-09', 0, '', -1, 0, 0, 0, 0),
(678, 248, 'delll-lap', 25, 'PAT', '2023-02-09', 5, '', 1, 0, 0, 0, 0),
(679, 0, 'RAM-DDR4-8GB', 26, 'PAT', '0000-00-00', 0, '', -1, 0, 0, 0, 0),
(680, 0, 'CPU-I3-10105', 26, 'PAT', '0000-00-00', 0, '', -1, 0, 0, 0, 0),
(681, 0, 'HDD-SSD-500GB', 26, 'PAT', '0000-00-00', 0, '', -1, 0, 0, 0, 0),
(682, 0, 'HEADPHONE-F10', 26, 'PAT', '0000-00-00', 0, '', -1, 0, 0, 0, 0);
INSERT INTO `fa_stock_moves` (`trans_id`, `trans_no`, `stock_id`, `type`, `loc_code`, `tran_date`, `price`, `reference`, `qty`, `standard_cost`, `person_id`, `discount_percent`, `visible`) VALUES
(683, 0, 'KEYBOARD', 26, 'PAT', '0000-00-00', 0, '', -1, 0, 0, 0, 0),
(684, 0, 'MOUSE-USB', 26, 'PAT', '0000-00-00', 0, '', -1, 0, 0, 0, 0),
(685, 0, 'MON-LED-LF24T352FHWXXL-24', 26, 'PAT', '0000-00-00', 0, '', -1, 0, 0, 0, 0),
(686, 0, 'AC-STAR-EMP-SPLIT', 26, 'PAT', '0000-00-00', 0, '', -1, 0, 0, 0, 0),
(687, 0, 'MON-LED-LF24T352FHWXXL-24', 26, 'PAT', '0000-00-00', 0, '', -1, 0, 0, 0, 0),
(688, 0, 'MON-LED-LF24T352FHWXXL-24', 26, 'PAT', '0000-00-00', 0, '', -1, 0, 0, 0, 0),
(689, 0, 'MON-LED-LF24T352FHWXXL-24', 26, 'PAT', '0000-00-00', 0, '', -1, 0, 0, 0, 0),
(690, 0, 'MON-LED-LF24T352FHWXXL-24', 26, 'PAT', '0000-00-00', 0, '', -1, 0, 0, 0, 0),
(691, 0, '', 26, '', '0000-00-00', 0, '', 0, 0, 0, 0, 0),
(692, 1, 'MOUSE-USB', 28, 'PAT', '2023-03-20', 0, '', -1, 0, 0, 0, 0),
(693, 1, 'RAM-DDR4-8GB', 28, 'PAT', '2023-03-20', 0, '', -1, 0, 0, 0, 0),
(694, 0, 'RAM-DDR4-8GB', 26, 'PAT', '0000-00-00', 0, '', -1, 0, 0, 0, 0),
(695, 0, 'RAM-DDR4-8GB', 26, 'PAT', '0000-00-00', 0, '', -1, 0, 0, 0, 0),
(696, 0, 'AC-STAR-EMP-SPLIT', 26, 'PAT', '0000-00-00', 0, '', -1, 0, 0, 0, 0),
(697, 0, 'L-BAG-LP-GRAY', 26, 'PAT', '0000-00-00', 0, '', -1, 0, 0, 0, 0),
(698, 0, 'HDD-500GB', 26, 'PAT', '0000-00-00', 0, '', -1, 0, 0, 0, 0),
(699, 0, 'RAM-DDR3-16GB', 26, 'PAT', '0000-00-00', 0, '', -1, 0, 0, 0, 0),
(700, 0, 'HDD-SSD-500GB', 26, 'PAT', '0000-00-00', 0, '', -1, 0, 0, 0, 0),
(701, 0, 'RAM-DDR4-8GB', 26, 'PAT', '0000-00-00', 0, '', -1, 0, 0, 0, 0),
(702, 2, 'HDD-500GB', 28, 'PAT', '2023-03-21', 0, '', -1, 0, 0, 0, 0),
(703, 1, 'LAP-DELL-14', 28, 'PAT', '2023-03-22', 0, '', -1, 0, 0, 0, 0),
(704, 1, 'DL-ESSL-EML600-2', 28, 'PAT', '2023-03-23', 0, '', -1, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `fa_stock_retruns`
--

CREATE TABLE `fa_stock_retruns` (
  `trans_id` int(11) NOT NULL,
  `trans_no` int(11) NOT NULL DEFAULT 0,
  `stock_id` char(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `type` smallint(6) NOT NULL DEFAULT 0,
  `loc_code` char(5) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `tran_date` date NOT NULL DEFAULT '0000-00-00',
  `price` double NOT NULL DEFAULT 0,
  `reference` char(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `qty` double NOT NULL DEFAULT 1,
  `standard_cost` double NOT NULL DEFAULT 0,
  `person_id` int(11) NOT NULL,
  `discount_percent` double NOT NULL,
  `visible` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fa_stock_retruns`
--

INSERT INTO `fa_stock_retruns` (`trans_id`, `trans_no`, `stock_id`, `type`, `loc_code`, `tran_date`, `price`, `reference`, `qty`, `standard_cost`, `person_id`, `discount_percent`, `visible`) VALUES
(1, 0, 'RAM-DDR4-8GB', 26, 'PAT', '0000-00-00', 0, '0', 2, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `fa_stock_serial_no`
--

CREATE TABLE `fa_stock_serial_no` (
  `id` int(11) NOT NULL,
  `assmbl_id` int(11) NOT NULL,
  `serial_no` int(11) NOT NULL,
  `inactive` int(11) NOT NULL,
  `asset_id` int(11) NOT NULL,
  `sub_asset_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `fa_stock_sub_category`
--

CREATE TABLE `fa_stock_sub_category` (
  `sub_cat_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `sub_cat_name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `inactive` tinyint(11) NOT NULL,
  `slab_id` int(11) NOT NULL,
  `effective_date` date NOT NULL,
  `code` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fa_stock_sub_category`
--

INSERT INTO `fa_stock_sub_category` (`sub_cat_id`, `category_id`, `sub_cat_name`, `description`, `inactive`, `slab_id`, `effective_date`, `code`) VALUES
(1, 4, 'ACCESS CARD', 'ACCESS CARD', 0, 2, '2021-05-07', 5248),
(2, 7, 'ADAPTOR\r\n', 'ADAPTOR\r\n', 0, 7, '2021-05-07', 525416),
(3, 7, 'CABINET', 'CABINET', 0, 2, '2021-12-09', 21235),
(4, 5, 'CABLE C TYPE', 'CABLE C TYPE\r\n', 0, 4, '2021-05-07', 25355),
(5, 6, 'CCTV', 'CCTV\r\n', 0, 3, '2021-05-07', 2324),
(6, 11, 'COOLING PAD\r\n', 'CPU Assemble', 0, 1, '2022-01-19', 26),
(7, 7, 'CPU\r\n', 'Electric Vehicle', 0, 1, '2022-01-25', 258),
(8, 12, 'DOOR LOCK\r\n', 'DOOR LOCK', 0, 1, '2022-01-25', 258),
(9, 4, 'FINGURE REAER\r\n', 'FINGURE REAER', 0, 1, '2022-01-25', 258),
(10, 8, 'FIREWALL', 'FIREWALL', 0, 1, '2022-01-25', 258),
(11, 7, 'FOOTPEDAL', 'FOOTPEDAL', 0, 1, '2022-01-25', 258),
(12, 9, 'GENERATER', 'GENERATER\r\n', 0, 1, '2022-01-25', 258),
(13, 7, 'GRAPHIC CARD', 'GRAPHIC CARD\r\n', 0, 1, '2022-01-25', 258),
(14, 7, 'HDD\r\n', 'HDD', 0, 1, '2022-01-25', 258),
(15, 5, 'HDMI CABLE', 'HDMI CABLE', 0, 1, '2022-01-25', 258),
(16, 7, 'HDMI CONVERTER', 'HDMI CONVERTER', 0, 1, '2022-01-25', 258),
(17, 7, 'HEADPHONE', 'HEADPHONE', 0, 1, '2022-01-25', 258),
(18, 3, 'INVERTER BATTERY', 'INVERTER BATTERY', 0, 1, '2022-01-25', 258),
(19, 3, 'INVERTER UPS', 'INVERTER UPS', 0, 1, '2022-01-25', 258),
(20, 10, 'IPAD\r\n', 'IPAD\r\n', 0, 1, '2022-01-25', 258),
(21, 7, 'KEYBOARD\r\n', 'KEYBOARD\r\n', 0, 1, '2022-01-25', 258),
(22, 3, 'LAP BATTERY\r\n', 'LAP BATTERY\r\n', 0, 1, '2022-01-25', 258),
(23, 10, 'LAPTOP\r\n', 'LAPTOP\r\n', 0, 1, '2022-01-25', 258),
(24, 2, 'LAPTOP BAG\r\n', 'LAPTOP BAG\r\n', 0, 1, '2022-01-25', 258),
(25, 3, 'MICRO BATTERY\r\n\r\n', 'MICRO BATTERY\r\n\r\n', 0, 1, '2022-01-25', 258),
(26, 7, 'MICROPHONE', 'MICROPHONE', 0, 1, '2022-01-25', 258),
(27, 13, 'MOBILE', 'MOBILE', 0, 1, '2022-01-25', 258),
(28, 13, 'MOBILE CHARGER', 'MOBILE CHARGER', 0, 1, '2022-01-25', 258),
(29, 7, 'MONITOR', 'MONITOR\r\n', 0, 1, '2022-01-25', 258),
(30, 7, 'Motherboard', 'Motherboard', 0, 1, '2022-01-25', 258),
(31, 7, 'MOUSE\r\n', 'MOUSE', 0, 1, '2022-01-25', 258),
(32, 7, 'MUSIC SYSTEM\r\n', 'MUSIC SYSTEM', 0, 1, '2022-01-25', 258),
(33, 7, 'PAD\r\n', 'PAD', 0, 1, '2022-01-25', 258),
(34, 7, 'PEN DRIVE\r\n', 'PEN DRIVE', 0, 1, '2022-01-25', 258),
(35, 5, 'POWER CABLE\r\n', 'POWER CABLE', 0, 1, '2022-01-25', 258),
(36, 7, 'PRECISION\r\n', 'PRECISION\r\n', 0, 1, '2022-01-25', 258),
(37, 8, 'PROCESSOR\r\n', 'PROCESSOR\r\n', 0, 1, '2022-01-25', 258),
(38, 4, 'PUNCH MACHINE\r\n', 'PUNCH MACHINE\r\n', 0, 1, '2022-01-25', 258),
(39, 14, 'RACK\r\n', 'RACK\r\n', 0, 1, '2022-01-25', 258),
(40, 7, 'RAM\r\n', 'RAM\r\n', 0, 1, '2022-01-25', 258),
(41, 14, 'ROUTER\r\n', 'ROUTER\r\n', 0, 1, '2022-01-25', 258),
(42, 15, 'Smart TV\r\n', 'Smart TV\r\n', 0, 1, '2022-01-25', 258),
(43, 7, 'SMPS\r\n', 'SMPS\r\n', 0, 1, '2022-01-25', 258),
(44, 7, 'SOUND CARD\r\n', 'SOUND CARD\r\n', 0, 1, '2022-01-25', 258),
(45, 1, 'Split AC\r\n', 'Split AC\r\n', 0, 1, '2022-01-25', 258),
(46, 7, 'UPS\r\n', 'UPS\r\n', 0, 1, '2022-01-25', 258),
(47, 7, 'USB PORT\r\n', 'USB PORT\r\n', 0, 1, '2022-01-25', 258),
(48, 7, 'WEB CAM\r\n', 'WEB CAM\r\n', 0, 1, '2022-01-25', 258),
(49, 16, 'Head light', 'car head light', 0, 2, '2023-01-02', 632);

-- --------------------------------------------------------

--
-- Table structure for table `fa_stock_sub_category_old`
--

CREATE TABLE `fa_stock_sub_category_old` (
  `sub_cat_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `sub_cat_name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `inactive` tinyint(11) NOT NULL,
  `slab_id` int(11) NOT NULL,
  `effective_date` date NOT NULL,
  `code` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fa_stock_sub_category_old`
--

INSERT INTO `fa_stock_sub_category_old` (`sub_cat_id`, `category_id`, `sub_cat_name`, `description`, `inactive`, `slab_id`, `effective_date`, `code`) VALUES
(1, 1, 'sds', 'df', 0, 2, '2021-05-07', 5248),
(2, 4, 'electronic', 'this is test', 0, 7, '2021-05-07', 525416),
(3, 1, 'computer harware', 'this is one', 0, 2, '2021-12-09', 21235),
(4, 2, 'bike', 'test', 0, 4, '2021-05-07', 25355),
(5, 3, 'fan', 'this is test', 0, 3, '2021-05-07', 2324),
(6, 3, 'CPU Assemble', 'CPU Assemble', 0, 1, '2022-01-19', 26),
(7, 1, 'Eclectic Vehicle', 'Electric Vehicle', 0, 1, '2022-01-25', 258);

-- --------------------------------------------------------

--
-- Table structure for table `fa_stop`
--

CREATE TABLE `fa_stop` (
  `id` int(11) NOT NULL,
  `stop_id` varchar(50) NOT NULL,
  `stop_name` varchar(100) NOT NULL,
  `status` int(8) NOT NULL,
  `total_student` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fa_stop`
--

INSERT INTO `fa_stop` (`id`, `stop_id`, `stop_name`, `status`, `total_student`) VALUES
(1, 'stop-001', 'ST-001', 1, 0),
(2, 'stop-002', 'ST-002', 1, 0),
(3, 'stop-003', 'ST-003', 1, 0),
(4, 'stop-004', 'ST-004', 1, 0),
(5, 'stop-005', 'ST-005', 1, 0),
(6, 'stop-006', 'ST-006', 1, 0),
(7, 'stop-007', 'ST-007', 1, 0),
(8, 'stop-008', 'ST-008', 2, 0),
(9, 'stop-009', 'ST-009', 2, 0),
(10, 'stop-010', 'ST-010', 2, 0),
(11, 'stop-011', 'ST-011', 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `fa_store_location`
--

CREATE TABLE `fa_store_location` (
  `id` int(11) NOT NULL,
  `location` varchar(100) NOT NULL,
  `store` varchar(50) NOT NULL,
  `store_desc` varchar(100) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fa_store_location`
--

INSERT INTO `fa_store_location` (`id`, `location`, `store`, `store_desc`, `status`) VALUES
(1, 'PAT', 'G Motors', 'G Tata Motors', 1),
(2, 'PAT', 'g motors', 'tata motors', 1);

-- --------------------------------------------------------

--
-- Table structure for table `fa_sub_asset_master`
--

CREATE TABLE `fa_sub_asset_master` (
  `sub_asset_id` int(11) NOT NULL,
  `asset_id` int(11) NOT NULL,
  `code` varchar(100) NOT NULL,
  `inactive` int(11) NOT NULL DEFAULT 0,
  `cat_id` int(11) NOT NULL,
  `sub_cat_id` int(11) NOT NULL,
  `units` varchar(10) NOT NULL,
  `mb_flag` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fa_sub_asset_master`
--

INSERT INTO `fa_sub_asset_master` (`sub_asset_id`, `asset_id`, `code`, `inactive`, `cat_id`, `sub_cat_id`, `units`, `mb_flag`) VALUES
(3, 1, 'cpu250rI3/1', 0, 1, 3, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `fa_suppliers`
--

CREATE TABLE `fa_suppliers` (
  `supplier_id` int(11) NOT NULL,
  `supp_name` varchar(60) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `supp_ref` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `address` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `supp_address` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `gst_no` varchar(25) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `contact` varchar(60) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `supp_account_no` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `website` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `bank_account` varchar(60) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `curr_code` char(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `payment_terms` int(11) DEFAULT NULL,
  `tax_included` tinyint(1) NOT NULL DEFAULT 0,
  `dimension_id` int(11) DEFAULT 0,
  `dimension2_id` int(11) DEFAULT 0,
  `tax_group_id` int(11) DEFAULT NULL,
  `credit_limit` double NOT NULL DEFAULT 0,
  `purchase_account` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `payable_account` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `payment_discount_account` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `notes` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `inactive` tinyint(1) NOT NULL DEFAULT 0,
  `vendor_type` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `address_pin` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `supp_address_pin` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `address_state` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `supp_address_state` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `bank_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `bank_account_number` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `bank_ifsc` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `address_country` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `supp_country` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fa_suppliers`
--

INSERT INTO `fa_suppliers` (`supplier_id`, `supp_name`, `supp_ref`, `address`, `supp_address`, `gst_no`, `contact`, `supp_account_no`, `website`, `bank_account`, `curr_code`, `payment_terms`, `tax_included`, `dimension_id`, `dimension2_id`, `tax_group_id`, `credit_limit`, `purchase_account`, `payable_account`, `payment_discount_account`, `notes`, `inactive`, `vendor_type`, `address_pin`, `supp_address_pin`, `address_state`, `supp_address_state`, `bank_name`, `bank_account_number`, `bank_ifsc`, `address_country`, `supp_country`) VALUES
(5, 'test user2', 'test', 'patna', '', 'gist', '', '', '', '', 'INR', 4, 0, 0, 0, 1, 0, '4303', '2212', '', '', 0, 'vendor-001', '800001', '80001', '1479', '1479', 'test', '3248000', 'sbi000335', '99', '99'),
(6, 'Finesse Enterprises PVT ', 'Finesse', '', '', '10AAACF5596K1ZK', '', '', 'Finesse.com', '', 'INR', 4, 0, 0, 0, 1, 0, '', '', '', '', 0, 'vendor-001', '', '', '1475', '', '', '', '', '1475', '1475');

-- --------------------------------------------------------

--
-- Table structure for table `fa_supp_allocations`
--

CREATE TABLE `fa_supp_allocations` (
  `id` int(11) NOT NULL,
  `person_id` int(11) DEFAULT NULL,
  `amt` double UNSIGNED DEFAULT NULL,
  `date_alloc` date NOT NULL DEFAULT '0000-00-00',
  `trans_no_from` int(11) DEFAULT NULL,
  `trans_type_from` int(11) DEFAULT NULL,
  `trans_no_to` int(11) DEFAULT NULL,
  `trans_type_to` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fa_supp_invoice_items`
--

CREATE TABLE `fa_supp_invoice_items` (
  `id` int(11) NOT NULL,
  `supp_trans_no` int(11) DEFAULT NULL,
  `supp_trans_type` int(11) DEFAULT NULL,
  `gl_code` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `grn_item_id` int(11) DEFAULT NULL,
  `po_detail_item_id` int(11) DEFAULT NULL,
  `stock_id` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `description` tinytext COLLATE utf8_unicode_ci DEFAULT NULL,
  `quantity` double NOT NULL DEFAULT 0,
  `unit_price` double NOT NULL DEFAULT 0,
  `unit_tax` double NOT NULL DEFAULT 0,
  `memo_` tinytext COLLATE utf8_unicode_ci DEFAULT NULL,
  `dimension_id` int(11) NOT NULL DEFAULT 0,
  `dimension2_id` int(11) NOT NULL DEFAULT 0,
  `gst` double NOT NULL,
  `gst_amt` double NOT NULL,
  `cst` double NOT NULL,
  `cst_amt` double NOT NULL,
  `ist` double NOT NULL,
  `ist_amt` double NOT NULL,
  `hsn_no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fa_supp_trans`
--

CREATE TABLE `fa_supp_trans` (
  `trans_no` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `type` smallint(6) UNSIGNED NOT NULL DEFAULT 0,
  `supplier_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `reference` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `supp_reference` varchar(60) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `tran_date` date NOT NULL DEFAULT '0000-00-00',
  `due_date` date NOT NULL DEFAULT '0000-00-00',
  `ov_amount` double NOT NULL DEFAULT 0,
  `ov_discount` double NOT NULL DEFAULT 0,
  `ov_gst` double NOT NULL DEFAULT 0,
  `rate` double NOT NULL DEFAULT 1,
  `alloc` double NOT NULL DEFAULT 0,
  `tax_included` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fa_sys_group`
--

CREATE TABLE `fa_sys_group` (
  `id` int(11) NOT NULL,
  `group_name` varchar(100) NOT NULL,
  `component` varchar(100) NOT NULL,
  `work_center` varchar(100) NOT NULL,
  `loc_code` varchar(100) NOT NULL,
  `quantity` double NOT NULL,
  `serial_no` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fa_sys_group`
--

INSERT INTO `fa_sys_group` (`id`, `group_name`, `component`, `work_center`, `loc_code`, `quantity`, `serial_no`) VALUES
(2, '1', 'CPU-I3-10105', '2', 'PAT', 1, ''),
(3, '1', 'HDD-SSD-500GB', '2', 'PAT', 1, ''),
(4, '1', 'HEADPHONE-F10', '2', 'PAT', 1, ''),
(5, '1', 'KEYBOARD', '2', 'PAT', 1, ''),
(6, '1', 'MOUSE-USB', '2', 'PAT', 1, ''),
(16, '1', 'RAM-DDR4-8GB', '2', 'PAT', 1, ''),
(17, '2', 'AC-STAR-EMP-SPLIT', '2', 'PAT', 1, ''),
(18, '2', 'L-BAG-LP-GRAY', '2', 'PAT', 1, ''),
(19, '2', 'HDD-500GB', '2', 'PAT', 1, ''),
(20, '2', 'RAM-DDR3-16GB', '2', 'PAT', 1, ''),
(21, '2', 'HDD-SSD-500GB', '2', 'PAT', 1, ''),
(22, '2', 'RAM-DDR4-8GB', '2', 'PAT', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `fa_sys_prefs`
--

CREATE TABLE `fa_sys_prefs` (
  `name` varchar(35) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `category` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `length` smallint(6) DEFAULT NULL,
  `value` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fa_sys_prefs`
--

INSERT INTO `fa_sys_prefs` (`name`, `category`, `type`, `length`, `value`) VALUES
('accounts_alpha', 'glsetup.general', 'tinyint', 1, '0'),
('accumulate_shipping', 'glsetup.customer', 'tinyint', 1, '0'),
('add_pct', 'setup.company', 'int', 5, '-1'),
('allow_negative_prices', 'glsetup.inventory', 'tinyint', 1, '1'),
('allow_negative_stock', 'glsetup.inventory', 'tinyint', 1, '0'),
('alternative_tax_include_on_docs', 'setup.company', 'tinyint', 1, ''),
('auto_curr_reval', 'setup.company', 'smallint', 6, '1'),
('bank_charge_act', 'glsetup.general', 'varchar', 15, '5690'),
('barcodes_on_stock', 'setup.company', 'tinyint', 1, '0'),
('base_sales', 'setup.company', 'int', 11, '1'),
('bcc_email', 'setup.company', 'varchar', 100, ''),
('company_logo_report', 'setup.company', 'tinyint', 1, '0'),
('coy_logo', 'setup.company', 'varchar', 100, 'logo.png'),
('coy_name', 'setup.company', 'varchar', 60, 'TESTERP'),
('coy_no', 'setup.company', 'varchar', 25, '123456789'),
('creditors_act', 'glsetup.purchase', 'varchar', 15, '2100'),
('curr_default', 'setup.company', 'char', 3, 'INR'),
('debtors_act', 'glsetup.sales', 'varchar', 15, '1200'),
('default_adj_act', 'glsetup.items', 'varchar', 15, '5040'),
('default_cogs_act', 'glsetup.items', 'varchar', 15, '5010'),
('default_credit_limit', 'glsetup.customer', 'int', 11, '1000'),
('default_delivery_required', 'glsetup.sales', 'smallint', 6, '1'),
('default_dim_required', 'glsetup.dims', 'int', 11, '20'),
('default_inv_sales_act', 'glsetup.items', 'varchar', 15, '4010'),
('default_inventory_act', 'glsetup.items', 'varchar', 15, '1510'),
('default_loss_on_asset_disposal_act', 'glsetup.items', 'varchar', 15, '5660'),
('default_prompt_payment_act', 'glsetup.sales', 'varchar', 15, '4500'),
('default_quote_valid_days', 'glsetup.sales', 'smallint', 6, '30'),
('default_receival_required', 'glsetup.purchase', 'smallint', 6, '10'),
('default_sales_act', 'glsetup.sales', 'varchar', 15, '4010'),
('default_sales_discount_act', 'glsetup.sales', 'varchar', 15, '4510'),
('default_wip_act', 'glsetup.items', 'varchar', 15, '1530'),
('default_workorder_required', 'glsetup.manuf', 'int', 11, '20'),
('deferred_income_act', 'glsetup.sales', 'varchar', 15, ''),
('depreciation_period', 'glsetup.company', 'tinyint', 1, '1'),
('domicile', 'setup.company', 'varchar', 55, ''),
('email', 'setup.company', 'varchar', 100, 'accounts@domain.com'),
('exchange_diff_act', 'glsetup.general', 'varchar', 15, '4450'),
('f_year', 'setup.company', 'int', 11, '7'),
('fax', 'setup.company', 'varchar', 30, '+91 (44) 2222-2221'),
('freight_act', 'glsetup.customer', 'varchar', 15, '4430'),
('gl_closing_date', 'setup.closing_date', 'date', 8, '2022-03-31'),
('grn_clearing_act', 'glsetup.purchase', 'varchar', 15, '0'),
('gst_no', 'setup.company', 'varchar', 25, '9876543'),
('legal_text', 'glsetup.customer', 'tinytext', 0, ''),
('loc_notification', 'glsetup.inventory', 'tinyint', 1, '0'),
('login_tout', 'setup.company', 'smallint', 6, '600'),
('no_customer_list', 'setup.company', 'tinyint', 1, '0'),
('no_item_list', 'setup.company', 'tinyint', 1, '0'),
('no_supplier_list', 'setup.company', 'tinyint', 1, '0'),
('no_zero_lines_amount', 'glsetup.sales', 'tinyint', 1, '1'),
('past_due_days', 'glsetup.general', 'int', 11, '30'),
('payroll_deductleave_act', NULL, 'int', NULL, '5410'),
('payroll_month_work_days', NULL, 'float', NULL, '26'),
('payroll_overtime_act', NULL, 'int', NULL, '5420'),
('payroll_payable_act', NULL, 'int', NULL, '2100'),
('payroll_work_hours', NULL, 'float', NULL, '8'),
('phone', 'setup.company', 'varchar', 30, '+91 (44) 2222-2222'),
('po_over_charge', 'glsetup.purchase', 'int', 11, '10'),
('po_over_receive', 'glsetup.purchase', 'int', 11, '10'),
('postal_address', 'setup.company', 'tinytext', 0, 'Address 1\r\nAddress 2\r\nAddress 3'),
('print_dialog_direct', 'setup.company', 'tinyint', 1, '0'),
('print_invoice_no', 'glsetup.sales', 'tinyint', 1, '0'),
('print_item_images_on_quote', 'glsetup.inventory', 'tinyint', 1, '0'),
('profit_loss_year_act', 'glsetup.general', 'varchar', 15, '9990'),
('pyt_discount_act', 'glsetup.purchase', 'varchar', 15, '5060'),
('ref_no_auto_increase', 'setup.company', 'tinyint', 1, '0'),
('retained_earnings_act', 'glsetup.general', 'varchar', 15, '3590'),
('round_to', 'setup.company', 'int', 5, '1'),
('shortname_name_in_list', 'setup.company', 'tinyint', 1, ''),
('show_po_item_codes', 'glsetup.purchase', 'tinyint', 1, '0'),
('state', NULL, '', NULL, '1479'),
('suppress_tax_rates', 'setup.company', 'tinyint', 1, ''),
('tax_algorithm', 'glsetup.customer', 'tinyint', 1, '1'),
('tax_last', 'setup.company', 'int', 11, '1'),
('tax_prd', 'setup.company', 'int', 11, '1'),
('time_zone', 'setup.company', 'tinyint', 1, '1'),
('use_dimension', 'setup.company', 'tinyint', 1, '1'),
('use_fixed_assets', 'setup.company', 'tinyint', 1, '1'),
('use_manufacturing', 'setup.company', 'tinyint', 1, '1'),
('version_id', 'system', 'varchar', 11, '2.4.1');

-- --------------------------------------------------------

--
-- Table structure for table `fa_sys_types`
--

CREATE TABLE `fa_sys_types` (
  `type_id` smallint(6) NOT NULL DEFAULT 0,
  `type_no` int(11) NOT NULL DEFAULT 1,
  `next_reference` varchar(100) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fa_sys_types`
--

INSERT INTO `fa_sys_types` (`type_id`, `type_no`, `next_reference`) VALUES
(1, 0, '1'),
(2, 0, '1'),
(4, 0, '1'),
(10, 0, '1'),
(11, 0, '1'),
(12, 0, '1'),
(13, 0, '1'),
(16, 0, '1'),
(17, 0, '1'),
(18, 0, '1'),
(20, 0, '1'),
(21, 0, '1'),
(22, 0, '1'),
(25, 0, '1'),
(26, 0, '1'),
(28, 0, '1'),
(29, 0, '1'),
(30, 0, '1'),
(32, 0, '1'),
(35, 0, '1'),
(40, 0, '1'),
(50, 0, '1'),
(60, 0, '1'),
(70, 0, '1'),
(90, 0, '1'),
(92, 0, '1'),
(94, 0, '1'),
(95, 0, '1'),
(100, 0, '1');

-- --------------------------------------------------------

--
-- Table structure for table `fa_tags`
--

CREATE TABLE `fa_tags` (
  `id` int(11) NOT NULL,
  `type` smallint(6) NOT NULL,
  `name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `inactive` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fa_tag_associations`
--

CREATE TABLE `fa_tag_associations` (
  `record_id` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fa_tax_groups`
--

CREATE TABLE `fa_tax_groups` (
  `id` int(11) NOT NULL,
  `name` varchar(60) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `inactive` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fa_tax_groups`
--

INSERT INTO `fa_tax_groups` (`id`, `name`, `inactive`) VALUES
(1, 'Tax', 0),
(2, 'Tax Exempt', 0);

-- --------------------------------------------------------

--
-- Table structure for table `fa_tax_group_items`
--

CREATE TABLE `fa_tax_group_items` (
  `tax_group_id` int(11) NOT NULL DEFAULT 0,
  `tax_type_id` int(11) NOT NULL DEFAULT 0,
  `tax_shipping` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fa_tax_group_items`
--

INSERT INTO `fa_tax_group_items` (`tax_group_id`, `tax_type_id`, `tax_shipping`) VALUES
(1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `fa_tax_slab`
--

CREATE TABLE `fa_tax_slab` (
  `slab_id` int(11) NOT NULL,
  `tax_rate` int(11) NOT NULL,
  `tax_description` varchar(150) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fa_tax_slab`
--

INSERT INTO `fa_tax_slab` (`slab_id`, `tax_rate`, `tax_description`, `status`) VALUES
(1, 0, 'GST One', 1),
(2, 5, 'test2', 1),
(3, 12, 'test3', 1),
(4, 18, 'test4', 1),
(7, 28, 'text0', 1);

-- --------------------------------------------------------

--
-- Table structure for table `fa_tax_types`
--

CREATE TABLE `fa_tax_types` (
  `id` int(11) NOT NULL,
  `rate` double NOT NULL DEFAULT 0,
  `sales_gl_code` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `purchasing_gl_code` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `name` varchar(60) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `inactive` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fa_tax_types`
--

INSERT INTO `fa_tax_types` (`id`, `rate`, `sales_gl_code`, `purchasing_gl_code`, `name`, `inactive`) VALUES
(1, 12.36, '2150', '2145', 'VAT', 0);

-- --------------------------------------------------------

--
-- Table structure for table `fa_tour_request_details`
--

CREATE TABLE `fa_tour_request_details` (
  `id` int(11) NOT NULL,
  `place` varchar(50) NOT NULL,
  `purpose` varchar(50) NOT NULL,
  `auth_by` varchar(40) NOT NULL,
  `departure_date` datetime NOT NULL,
  `arrival_date` datetime NOT NULL,
  `name` varchar(50) NOT NULL,
  `emp_id` varchar(50) NOT NULL,
  `tour_id` varchar(50) NOT NULL,
  `bill_id` varchar(50) NOT NULL,
  `total_amount` float NOT NULL,
  `submit_date` date NOT NULL,
  `status` int(10) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fa_tour_request_details`
--

INSERT INTO `fa_tour_request_details` (`id`, `place`, `purpose`, `auth_by`, `departure_date`, `arrival_date`, `name`, `emp_id`, `tour_id`, `bill_id`, `total_amount`, `submit_date`, `status`) VALUES
(116, 'patna', 'meeting', 'Ritika', '2019-07-05 10:00:00', '2019-07-05 23:00:00', 'Today', 'EMP-F-008', 'TRD-07-2019-117', 'T_Bill_TRD-07-2019-117', 0, '2019-07-05', 1),
(117, 'patna', 'For Demo', 'Shreekant', '2019-08-26 09:00:00', '2019-08-26 16:50:00', 'Omprakash', 'EMP-F-001', 'TRD-08-2019-118', 'T_Bill_TRD-08-2019-118', 0, '2019-08-26', 0),
(118, 'delhi', 'meeting', 'manager', '2020-01-25 16:00:00', '2020-01-26 16:00:00', 'Administrator', '', 'TRD-01-2020-119', 'T_Bill_TRD-01-2020-119', 0, '2020-01-27', 0);

-- --------------------------------------------------------

--
-- Table structure for table `fa_trans_tax_details`
--

CREATE TABLE `fa_trans_tax_details` (
  `id` int(11) NOT NULL,
  `trans_type` smallint(6) DEFAULT NULL,
  `trans_no` int(11) DEFAULT NULL,
  `tran_date` date NOT NULL,
  `tax_type_id` int(11) NOT NULL DEFAULT 0,
  `rate` double NOT NULL DEFAULT 0,
  `ex_rate` double NOT NULL DEFAULT 1,
  `included_in_price` tinyint(1) NOT NULL DEFAULT 0,
  `net_amount` double NOT NULL DEFAULT 0,
  `amount` double NOT NULL DEFAULT 0,
  `memo` tinytext COLLATE utf8_unicode_ci DEFAULT NULL,
  `reg_type` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fa_type`
--

CREATE TABLE `fa_type` (
  `id` int(11) NOT NULL,
  `name` varchar(80) NOT NULL,
  `inactive` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fa_type`
--

INSERT INTO `fa_type` (`id`, `name`, `inactive`) VALUES
(1, 'Amc', 0),
(2, 'Non Amc', 0);

-- --------------------------------------------------------

--
-- Table structure for table `fa_type_maintenance`
--

CREATE TABLE `fa_type_maintenance` (
  `type_id` int(11) NOT NULL,
  `maintain_type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fa_type_maintenance`
--

INSERT INTO `fa_type_maintenance` (`type_id`, `maintain_type`) VALUES
(1, 'Preventive'),
(2, 'N/A'),
(3, 'Breakdown');

-- --------------------------------------------------------

--
-- Table structure for table `fa_useronline`
--

CREATE TABLE `fa_useronline` (
  `id` int(11) NOT NULL,
  `timestamp` int(15) NOT NULL DEFAULT 0,
  `ip` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `file` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fa_users`
--

CREATE TABLE `fa_users` (
  `id` smallint(6) NOT NULL,
  `user_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `password` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `real_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `role_id` int(11) NOT NULL DEFAULT 1,
  `phone` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `language` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_format` tinyint(1) NOT NULL DEFAULT 0,
  `date_sep` tinyint(1) NOT NULL DEFAULT 0,
  `tho_sep` tinyint(1) NOT NULL DEFAULT 0,
  `dec_sep` tinyint(1) NOT NULL DEFAULT 0,
  `theme` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'default',
  `page_size` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'A4',
  `prices_dec` smallint(6) NOT NULL DEFAULT 2,
  `qty_dec` smallint(6) NOT NULL DEFAULT 2,
  `rates_dec` smallint(6) NOT NULL DEFAULT 4,
  `percent_dec` smallint(6) NOT NULL DEFAULT 1,
  `show_gl` tinyint(1) NOT NULL DEFAULT 1,
  `show_codes` tinyint(1) NOT NULL DEFAULT 0,
  `show_hints` tinyint(1) NOT NULL DEFAULT 0,
  `last_visit_date` datetime DEFAULT NULL,
  `query_size` tinyint(1) UNSIGNED NOT NULL DEFAULT 10,
  `graphic_links` tinyint(1) DEFAULT 1,
  `pos` smallint(6) DEFAULT 1,
  `print_profile` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `rep_popup` tinyint(1) DEFAULT 1,
  `sticky_doc_date` tinyint(1) DEFAULT 0,
  `startup_tab` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `transaction_days` int(6) NOT NULL DEFAULT 30 COMMENT 'Transaction days',
  `save_report_selections` smallint(6) NOT NULL DEFAULT 0 COMMENT 'Save Report Selection Days',
  `use_date_picker` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'Use Date Picker for all Date Values',
  `def_print_destination` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Default Report Destination',
  `def_print_orientation` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Default Report Orientation',
  `inactive` tinyint(1) NOT NULL DEFAULT 0,
  `empl_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `in_time` date DEFAULT NULL,
  `out_time` date DEFAULT NULL,
  `attempts` int(11) DEFAULT NULL,
  `frgt_status` tinyint(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fa_users`
--

INSERT INTO `fa_users` (`id`, `user_id`, `password`, `real_name`, `role_id`, `phone`, `email`, `language`, `date_format`, `date_sep`, `tho_sep`, `dec_sep`, `theme`, `page_size`, `prices_dec`, `qty_dec`, `rates_dec`, `percent_dec`, `show_gl`, `show_codes`, `show_hints`, `last_visit_date`, `query_size`, `graphic_links`, `pos`, `print_profile`, `rep_popup`, `sticky_doc_date`, `startup_tab`, `transaction_days`, `save_report_selections`, `use_date_picker`, `def_print_destination`, `def_print_orientation`, `inactive`, `empl_id`, `in_time`, `out_time`, `attempts`, `frgt_status`) VALUES
(1, 'admin', 'e10adc3949ba59abbe56e057f20f883e', 'Administrator', 2, '9874563210', 'admin@gmail.com', 'en_IN', 1, 2, 0, 0, 'dynamic', 'A4', 2, 2, 4, 1, 1, 1, 1, '2023-08-30 00:00:00', 10, 1, 1, '', 1, 0, 'extendedhrm', 30, 0, 1, 0, 0, 0, 'EMP-f-110', NULL, NULL, 0, 0),
(439, 'Soofia', 'e10adc3949ba59abbe56e057f20f883e', 'Soofia', 13, '9079003238', 'soofia@finesse.com', 'en_IN', 1, 2, 0, 0, 'dynamic', 'A4', 2, 2, 4, 1, 1, 1, 1, '2022-07-18 09:49:14', 10, 1, 1, '', 1, 0, 'extendedhrm', 30, 0, 1, 0, 0, 0, 'EMP-f-170', NULL, NULL, 0, 0),
(442, 'testuser', 'e10adc3949ba59abbe56e057f20f883e', 'test user', 12, '9874563210', 'test@gmail.com', 'en_IN', 1, 2, 0, 0, 'dynamic', 'A4', 2, 2, 4, 1, 1, 1, 1, '2023-06-19 10:14:42', 10, 1, 1, '', 1, 0, 'extendedhrm', 30, 0, 1, 0, 0, 0, 'EMP-F-004', NULL, NULL, NULL, 0),
(443, 'jyoti', 'e10adc3949ba59abbe56e057f20f883e', 'Jyoti', 12, '5896332147', 'jyoti@gmail.com', 'en_IN', 1, 2, 0, 0, 'dynamic', 'A4', 2, 2, 4, 1, 1, 1, 1, '2020-12-29 00:00:00', 10, 1, 1, '', 1, 0, 'extendedhrm', 30, 0, 1, 0, 0, 0, 'EMP-F-028', NULL, NULL, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `fa_user_assign_group`
--

CREATE TABLE `fa_user_assign_group` (
  `id` int(11) NOT NULL,
  `group_id` varchar(100) NOT NULL,
  `user_id` varchar(100) NOT NULL,
  `added_date` date NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fa_user_assign_group`
--

INSERT INTO `fa_user_assign_group` (`id`, `group_id`, `user_id`, `added_date`, `status`) VALUES
(1, '2', 'EMP-F-047', '2023-03-22', 0);

-- --------------------------------------------------------

--
-- Table structure for table `fa_user_attendance`
--

CREATE TABLE `fa_user_attendance` (
  `w_id` int(11) NOT NULL,
  `empl_id` varchar(100) NOT NULL,
  `a_in_time` datetime DEFAULT NULL,
  `a_out_time` datetime DEFAULT NULL,
  `working_hours` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fa_user_attendance`
--

INSERT INTO `fa_user_attendance` (`w_id`, `empl_id`, `a_in_time`, `a_out_time`, `working_hours`) VALUES
(1, '', '2020-01-22 16:08:38', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `fa_user_issues`
--

CREATE TABLE `fa_user_issues` (
  `id` int(11) NOT NULL,
  `name` int(11) NOT NULL DEFAULT 0,
  `floor` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `room` int(11) NOT NULL,
  `department` int(11) NOT NULL,
  `seat` int(11) NOT NULL,
  `issue_date` date DEFAULT NULL,
  `department_id` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `employee_id` varchar(110) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fa_user_issues`
--

INSERT INTO `fa_user_issues` (`id`, `name`, `floor`, `room`, `department`, `seat`, `issue_date`, `department_id`, `employee_id`) VALUES
(1, 3, '1', 40, 1, 1, '2023-03-22', '1', 'EMP-F-047');

-- --------------------------------------------------------

--
-- Table structure for table `fa_user_issue_items`
--

CREATE TABLE `fa_user_issue_items` (
  `id` int(11) NOT NULL,
  `stock_id` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `issue_id` int(11) DEFAULT NULL,
  `qty_issued` double DEFAULT NULL,
  `unit_cost` double NOT NULL DEFAULT 0,
  `sl_no` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fa_user_workinghours`
--

CREATE TABLE `fa_user_workinghours` (
  `id` int(11) NOT NULL,
  `full_day` float NOT NULL,
  `half_day` float NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fa_user_workinghours`
--

INSERT INTO `fa_user_workinghours` (`id`, `full_day`, `half_day`, `status`) VALUES
(1, 8.5, 4.5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `fa_utility`
--

CREATE TABLE `fa_utility` (
  `id` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `sub_cat_id` int(11) NOT NULL,
  `items_id` text NOT NULL,
  `name` varchar(50) NOT NULL,
  `maintenance_type_id` int(2) NOT NULL,
  `description` varchar(100) NOT NULL,
  `freq_id` text NOT NULL,
  `inactive` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fa_utility`
--

INSERT INTO `fa_utility` (`id`, `type`, `category_id`, `sub_cat_id`, `items_id`, `name`, `maintenance_type_id`, `description`, `freq_id`, `inactive`) VALUES
(3, 2, 0, 0, '', 'Process 1', 1, 'mot bike', '1', 0),
(4, 1, 1, 3, 'cpu', '', 1, 'Servicing', '5', 0),
(5, 1, 4, 2, 'TableFan', '', 1, 'Servicing ', '2', 0),
(7, 2, 0, 0, '', 'First Servicing', 1, 'Lubrications and Cleaning', '1', 0),
(8, 1, 1, 3, 'MotherBoard', '', 3, 'Breakdown System', '4', 0),
(9, 1, 1, 3, 'HDD250', '', 3, 'HDD', '3', 0),
(10, 1, 1, 7, 'DISENGINE', '', 1, 'Free Service 1', '5', 0),
(11, 1, 1, 7, 'VEHBATTERY', '', 1, 'Check Charging', '5', 0),
(12, 1, 1, 7, 'DISENGINE', '', 1, 'Service 1', '2,5', 0),
(13, 2, 0, 0, '', 'Hardware Issue', 3, 'CPU not working', '1', 0),
(14, 2, 0, 0, '', 'RAM Issue', 3, 'System slow', '2', 0),
(15, 2, 0, 0, '', 'RAM Issue', 1, 'System is slow', '2', 0);

-- --------------------------------------------------------

--
-- Table structure for table `fa_utility_category`
--

CREATE TABLE `fa_utility_category` (
  `cats_id` int(11) NOT NULL,
  `category` varchar(100) NOT NULL,
  `inactive` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fa_utility_category`
--

INSERT INTO `fa_utility_category` (`cats_id`, `category`, `inactive`) VALUES
(1, 'Utility', 0),
(2, 'Process', 0);

-- --------------------------------------------------------

--
-- Table structure for table `fa_utility_maintenance`
--

CREATE TABLE `fa_utility_maintenance` (
  `ut_maintain_id` int(11) NOT NULL,
  `utility_id` int(11) NOT NULL,
  `frequency_id` int(11) NOT NULL,
  `ut_check1` int(2) NOT NULL,
  `ut_check2` int(2) NOT NULL,
  `ut_check3` int(2) NOT NULL,
  `ut_check4` int(2) NOT NULL,
  `ut_check5` int(2) NOT NULL,
  `ut_check6` int(2) NOT NULL,
  `obv_date` text NOT NULL,
  `obv_1` varchar(200) NOT NULL,
  `obv_2` varchar(200) NOT NULL,
  `obv_3` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `fa_utility_parameters_master`
--

CREATE TABLE `fa_utility_parameters_master` (
  `ut_param_id` int(11) NOT NULL,
  `utly_type` int(11) NOT NULL,
  `utly_cat_id` int(11) NOT NULL,
  `utly_sub_cat_id` int(11) NOT NULL,
  `utilitys_id` int(11) NOT NULL,
  `type_maintenance_id` int(2) NOT NULL,
  `frequency_id` int(11) NOT NULL,
  `inactive` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fa_utility_parameters_master`
--

INSERT INTO `fa_utility_parameters_master` (`ut_param_id`, `utly_type`, `utly_cat_id`, `utly_sub_cat_id`, `utilitys_id`, `type_maintenance_id`, `frequency_id`, `inactive`) VALUES
(1, 2, 0, 0, 1, 2, 1, 0),
(2, 1, 1, 23, 1, 1, 2, 0),
(3, 2, 0, 0, 3, 1, 1, 0),
(4, 1, 3, 24, 2, 1, 5, 0),
(5, 1, 4, 3, 4, 1, 5, 0),
(6, 1, 4, 2, 5, 1, 2, 0),
(7, 1, 1, 3, 9, 3, 3, 0),
(8, 1, 1, 3, 8, 3, 4, 0),
(9, 1, 1, 7, 10, 1, 5, 0),
(10, 2, 0, 0, 13, 3, 1, 0),
(11, 2, 0, 0, 14, 3, 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `fa_utility_parameter_items`
--

CREATE TABLE `fa_utility_parameter_items` (
  `items_id` int(11) NOT NULL,
  `ut_param_id` int(11) NOT NULL,
  `param_title` text NOT NULL,
  `param_desc` text NOT NULL,
  `inactive` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fa_utility_parameter_items`
--

INSERT INTO `fa_utility_parameter_items` (`items_id`, `ut_param_id`, `param_title`, `param_desc`, `inactive`) VALUES
(1, 1, 'Cutting', 'Cutting   ytftyr', 0),
(2, 2, 'Scope of work : Regular maintenance', 'Regular maintenance', 0),
(3, 3, 'process 1', 'process  desc', 0),
(4, 4, 'rwerw', 'werwe', 0),
(5, 2, 'Battery Replacement', 'Battery Replacement', 0),
(6, 5, 'Regular Servicing', 'Regular Servicing &amp; Oil Top up', 0),
(7, 6, 'Oil Change', 'Greasing', 0),
(8, 7, 'Replace Under Warranty', 'Sent to Vendor for Replacement', 0),
(9, 8, 'Replace Under Warranty', 'Sent to Vendor for Replacement', 0),
(10, 9, 'sercvicing', 'sercvicing', 0),
(11, 10, 'Replace Under Warranty', 'Replace Under Warranty', 0),
(12, 11, 'Scrap it and replace with new item', 'Scrap it and replace with new item', 0),
(13, 9, 'Second Servicing', 'Second Servicing', 0),
(14, 9, 'Third Servicing', 'Third Servicing', 0),
(15, 9, 'Oil Change', 'Oil Change', 0);

-- --------------------------------------------------------

--
-- Table structure for table `fa_vehicle`
--

CREATE TABLE `fa_vehicle` (
  `id` int(11) NOT NULL,
  `vehicle_id` varchar(50) NOT NULL,
  `vehicle_no` varchar(50) NOT NULL,
  `reg_no` varchar(50) NOT NULL,
  `seating_capacity` int(11) NOT NULL,
  `driver_name` varchar(50) NOT NULL,
  `status` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fa_vehicle`
--

INSERT INTO `fa_vehicle` (`id`, `vehicle_id`, `vehicle_no`, `reg_no`, `seating_capacity`, `driver_name`, `status`) VALUES
(0, 'vehicle-007', '20', '1', 7, '', 1),
(1, 'vehicle-001', 'R-001', '1', 7, 'Ritika kumari pd', 1),
(2, 'vehicle-001', 'M-11', '1', 7, 'Ritika kumari pd', 1),
(3, 'vehicle-002', 'M-12', '4', 5, 'kundan33', 1),
(4, 'vehicle-003', 'M-13', '12', 6, 'Kundan', 1),
(5, 'vehicle-004', 'M-13', '1', 7, 'Ritika kumari pd', 1),
(6, 'vehicle-005', 'M-12', '2', 4, 'Ritika kumari', 1),
(7, 'vehicle-006', 'M24636', '1', 7, 'Ritika kumari pd', 1);

-- --------------------------------------------------------

--
-- Table structure for table `fa_vendor_details`
--

CREATE TABLE `fa_vendor_details` (
  `id` int(11) NOT NULL,
  `cat_id` varchar(80) NOT NULL,
  `fascial_year` int(10) NOT NULL,
  `vendor_type` varchar(100) NOT NULL,
  `cumulative_payment` int(10) NOT NULL,
  `single_payment` int(10) NOT NULL,
  `percentage` int(10) NOT NULL DEFAULT 1,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fa_vendor_details`
--

INSERT INTO `fa_vendor_details` (`id`, `cat_id`, `fascial_year`, `vendor_type`, `cumulative_payment`, `single_payment`, `percentage`, `status`) VALUES
(4, 'vendor-001', 2, 'test', 2000, 700, 8, 1),
(5, 'vendor-002', 3, 'test21', 10001, 8001, 23, 1);

-- --------------------------------------------------------

--
-- Table structure for table `fa_visitor_management`
--

CREATE TABLE `fa_visitor_management` (
  `vistitor_id` int(11) NOT NULL,
  `ref_id` varchar(50) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `to_meet` varchar(100) NOT NULL,
  `company` varchar(100) NOT NULL,
  `coming_from` varchar(100) NOT NULL,
  `purpose` varchar(100) NOT NULL,
  `contact_number` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `tr_fromdate` datetime DEFAULT NULL,
  `tr_todate` datetime DEFAULT NULL,
  `remarks` text NOT NULL,
  `inserted_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fa_visitor_management`
--

INSERT INTO `fa_visitor_management` (`vistitor_id`, `ref_id`, `first_name`, `last_name`, `to_meet`, `company`, `coming_from`, `purpose`, `contact_number`, `email`, `tr_fromdate`, `tr_todate`, `remarks`, `inserted_date`) VALUES
(1, 'ref-001', 'Ritika', 'Kumari', 'HR', 'Finessewebtech', 'kidwaipuri', 'meeting', '6200104322', 'test@test.com', '2019-07-15 12:39:00', NULL, 'meeting regarding job', '2019-07-15'),
(2, 'ref-002', 'tsq', 'dsd', 'ss', 'ddfd', 'd', 'dd', '9874563210', 'ssdf@gmail.com', '2020-01-21 18:02:00', NULL, 'jhvjhkj', '2020-01-21');

-- --------------------------------------------------------

--
-- Table structure for table `fa_voided`
--

CREATE TABLE `fa_voided` (
  `type` int(11) NOT NULL DEFAULT 0,
  `id` int(11) NOT NULL,
  `date_` date NOT NULL DEFAULT '0000-00-00',
  `memo_` tinytext COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fa_workcentres`
--

CREATE TABLE `fa_workcentres` (
  `id` int(11) NOT NULL,
  `name` char(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `description` char(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `inactive` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fa_workcentres`
--

INSERT INTO `fa_workcentres` (`id`, `name`, `description`, `inactive`) VALUES
(1, 'Workshop', 'Workshop in Town', 0),
(2, 'Patna', 'Nehru Nagar', 0);

-- --------------------------------------------------------

--
-- Table structure for table `fa_workorders`
--

CREATE TABLE `fa_workorders` (
  `id` int(11) NOT NULL,
  `wo_ref` varchar(60) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `loc_code` varchar(5) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `units_reqd` double NOT NULL DEFAULT 1,
  `stock_id` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `date_` date NOT NULL DEFAULT '0000-00-00',
  `type` tinyint(4) NOT NULL DEFAULT 0,
  `required_by` date NOT NULL DEFAULT '0000-00-00',
  `released_date` date NOT NULL DEFAULT '0000-00-00',
  `units_issued` double NOT NULL DEFAULT 0,
  `closed` tinyint(1) NOT NULL DEFAULT 0,
  `released` tinyint(1) NOT NULL DEFAULT 0,
  `additional_costs` double NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fa_workorders`
--

INSERT INTO `fa_workorders` (`id`, `wo_ref`, `loc_code`, `units_reqd`, `stock_id`, `date_`, `type`, `required_by`, `released_date`, `units_issued`, `closed`, `released`, `additional_costs`) VALUES
(1, '1', 'DEF', 1, 'cpu', '2022-11-01', 2, '2022-11-21', '2022-11-01', 1, 1, 1, 0),
(2, '2', 'DEF', 5, 'cpu', '2022-11-30', 2, '2022-12-20', '2022-11-30', 0, 0, 1, 0),
(3, '3', 'PAT', 4, 'cpui3', '2023-02-01', 2, '2023-02-21', '2023-02-01', 4, 1, 1, 0),
(4, '4', 'PAT', 1, 'HDD-500GB', '0000-00-00', 2, '0000-00-00', '2023-03-14', 0, 0, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `fa_wo_costing`
--

CREATE TABLE `fa_wo_costing` (
  `id` int(11) NOT NULL,
  `workorder_id` int(11) NOT NULL DEFAULT 0,
  `cost_type` tinyint(1) NOT NULL DEFAULT 0,
  `trans_type` int(11) NOT NULL DEFAULT 0,
  `trans_no` int(11) NOT NULL DEFAULT 0,
  `factor` double NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fa_wo_issues`
--

CREATE TABLE `fa_wo_issues` (
  `issue_no` int(11) NOT NULL,
  `workorder_id` int(11) NOT NULL DEFAULT 0,
  `reference` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `issue_date` date DEFAULT NULL,
  `loc_code` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `workcentre_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fa_wo_issues`
--

INSERT INTO `fa_wo_issues` (`issue_no`, `workorder_id`, `reference`, `issue_date`, `loc_code`, `workcentre_id`) VALUES
(1, 1, '2', '2022-11-01', 'DEF', 2);

-- --------------------------------------------------------

--
-- Table structure for table `fa_wo_issue_items`
--

CREATE TABLE `fa_wo_issue_items` (
  `id` int(11) NOT NULL,
  `stock_id` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `issue_id` int(11) DEFAULT NULL,
  `qty_issued` double DEFAULT NULL,
  `unit_cost` double NOT NULL DEFAULT 0,
  `sl_no` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fa_wo_issue_items`
--

INSERT INTO `fa_wo_issue_items` (`id`, `stock_id`, `issue_id`, `qty_issued`, `unit_cost`, `sl_no`) VALUES
(1, 'CP110', 1, 1, 0, 'cpu102');

-- --------------------------------------------------------

--
-- Table structure for table `fa_wo_manufacture`
--

CREATE TABLE `fa_wo_manufacture` (
  `id` int(11) NOT NULL,
  `reference` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `workorder_id` int(11) NOT NULL DEFAULT 0,
  `quantity` double NOT NULL DEFAULT 0,
  `date_` date NOT NULL DEFAULT '0000-00-00',
  `item_code` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `stock_status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fa_wo_manufacture`
--

INSERT INTO `fa_wo_manufacture` (`id`, `reference`, `workorder_id`, `quantity`, `date_`, `item_code`, `stock_status`) VALUES
(1, '2', 1, 1, '2022-11-01', 'Testcpu101', 1),
(2, '3', 3, 4, '2023-02-01', 'cpum', 0);

-- --------------------------------------------------------

--
-- Table structure for table `fa_wo_requirements`
--

CREATE TABLE `fa_wo_requirements` (
  `id` int(11) NOT NULL,
  `workorder_id` int(11) NOT NULL DEFAULT 0,
  `stock_id` char(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `workcentre` int(11) NOT NULL DEFAULT 0,
  `units_req` double NOT NULL DEFAULT 1,
  `unit_cost` double NOT NULL DEFAULT 0,
  `loc_code` char(5) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `units_issued` double NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fa_wo_requirements`
--

INSERT INTO `fa_wo_requirements` (`id`, `workorder_id`, `stock_id`, `workcentre`, `units_req`, `unit_cost`, `loc_code`, `units_issued`) VALUES
(1, 1, 'CP110', 2, 1, 0, 'DEF', 1),
(2, 2, 'CP110', 2, 1, 0, 'DEF', 0),
(3, 3, 'HDD-SSD-500GB', 2, 1, 0, 'PAT', 4),
(4, 3, 'RAM-DDR4-8GB', 2, 1, 0, 'PAT', 4);

-- --------------------------------------------------------

--
-- Table structure for table `tax_setup`
--

CREATE TABLE `tax_setup` (
  `id` int(11) NOT NULL,
  `description` varchar(110) NOT NULL,
  `type` varchar(50) NOT NULL,
  `allowance_credit_gl_code` varchar(50) NOT NULL,
  `allowance_debit_gl_code` varchar(50) NOT NULL,
  `inactive` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tblbooking`
--

CREATE TABLE `tblbooking` (
  `id` int(11) NOT NULL,
  `userEmail` varchar(100) DEFAULT NULL,
  `VehicleId` int(11) DEFAULT NULL,
  `FromDate` varchar(20) DEFAULT NULL,
  `ToDate` varchar(20) DEFAULT NULL,
  `message` varchar(255) DEFAULT NULL,
  `Status` int(11) DEFAULT NULL,
  `PostingDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `username` varchar(150) NOT NULL,
  `fromplace` varchar(50) NOT NULL,
  `toplace` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `booked_by` varchar(50) NOT NULL,
  `department` varchar(50) NOT NULL,
  `designation` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblbooking`
--

INSERT INTO `tblbooking` (`id`, `userEmail`, `VehicleId`, `FromDate`, `ToDate`, `message`, `Status`, `PostingDate`, `username`, `fromplace`, `toplace`, `name`, `booked_by`, `department`, `designation`) VALUES
(1, 'admin@domain.com', 15, '2020-01-22 18:19', '2020-01-22 18:19', 'ffff', 2, '2020-01-22 12:49:33', '', 'patna', 'boaring road', 'test user', 'Administrator', 'test', 'test');

-- --------------------------------------------------------

--
-- Table structure for table `tblbrands`
--

CREATE TABLE `tblbrands` (
  `id` int(11) NOT NULL,
  `BrandName` varchar(120) NOT NULL,
  `CreationDate` timestamp NULL DEFAULT current_timestamp(),
  `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblbrands`
--

INSERT INTO `tblbrands` (`id`, `BrandName`, `CreationDate`, `UpdationDate`) VALUES
(1, 'Maruti', '2017-06-18 16:24:34', '2017-06-19 06:42:23'),
(2, 'BMW', '2017-06-18 16:24:50', NULL),
(3, 'Audi', '2017-06-18 16:25:03', NULL),
(4, 'Nissan', '2017-06-18 16:25:13', NULL),
(5, 'Toyota', '2017-06-18 16:25:24', NULL),
(7, 'Marutiu', '2017-06-19 06:22:13', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tblvehicles`
--

CREATE TABLE `tblvehicles` (
  `id` int(11) NOT NULL,
  `VehiclesTitle` varchar(150) DEFAULT NULL,
  `VehiclesBrand` int(11) DEFAULT NULL,
  `VehiclesOverview` longtext DEFAULT NULL,
  `PricePerDay` int(11) DEFAULT NULL,
  `FuelType` varchar(100) DEFAULT NULL,
  `ModelYear` varchar(80) DEFAULT NULL,
  `SeatingCapacity` int(11) DEFAULT NULL,
  `Vimage1` varchar(120) DEFAULT NULL,
  `Vimage2` varchar(120) DEFAULT NULL,
  `Vimage3` varchar(120) DEFAULT NULL,
  `Vimage4` varchar(120) DEFAULT NULL,
  `Vimage5` varchar(120) DEFAULT NULL,
  `AirConditioner` int(11) DEFAULT NULL,
  `PowerDoorLocks` int(11) DEFAULT NULL,
  `AntiLockBrakingSystem` int(11) DEFAULT NULL,
  `BrakeAssist` int(11) DEFAULT NULL,
  `PowerSteering` int(11) DEFAULT NULL,
  `DriverAirbag` int(11) DEFAULT NULL,
  `PassengerAirbag` int(11) DEFAULT NULL,
  `PowerWindows` int(11) DEFAULT NULL,
  `CDPlayer` int(11) DEFAULT NULL,
  `CentralLocking` int(11) DEFAULT NULL,
  `CrashSensor` int(11) DEFAULT NULL,
  `LeatherSeats` int(11) DEFAULT NULL,
  `RegDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `DriverId` int(11) NOT NULL,
  `available` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblvehicles`
--

INSERT INTO `tblvehicles` (`id`, `VehiclesTitle`, `VehiclesBrand`, `VehiclesOverview`, `PricePerDay`, `FuelType`, `ModelYear`, `SeatingCapacity`, `Vimage1`, `Vimage2`, `Vimage3`, `Vimage4`, `Vimage5`, `AirConditioner`, `PowerDoorLocks`, `AntiLockBrakingSystem`, `BrakeAssist`, `PowerSteering`, `DriverAirbag`, `PassengerAirbag`, `PowerWindows`, `CDPlayer`, `CentralLocking`, `CrashSensor`, `LeatherSeats`, `RegDate`, `UpdationDate`, `DriverId`, `available`) VALUES
(1, 'Demo1', 2, 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable.', 345345, 'Petrol', 'teye3453', 7, 'knowledge_base_bg.jpg', '20170523_145633.jpg', 'phpgurukul-1.png', 'social-icons.png', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, '2017-06-19 11:46:23', '2019-06-25 11:10:22', 3, 1),
(2, 'Demo2', 2, 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Nam nibh. Nunc varius facilisis eros. Sed erat. In in velit quis arcu ornare laoreet. Curabitur adipiscing luctus massa. Integer ut purus ac augue commodo commodo. Nunc nec mi eu justo tempor consectetuer. Etiam vitae nisl. In dignissim lacus ut ante. Cras elit lectus, bibendum a, adipiscing vitae, commodo et, dui. Ut tincidunt tortor. Donec nonummy, enim in lacinia pulvinar, velit tellus scelerisque augue, ac posuere libero urna eget neque. Cras ipsum. Vestibulum pretium, lectus nec venenatis volutpat, purus lectus ultrices risus, a condimentum risus mi et quam. Pellentesque auctor fringilla neque. Duis eu massa ut lorem iaculis vestibulum. Maecenas facilisis elit sed justo. Quisque volutpat malesuada velit. ', 859, 'CNG', 'reye2015', 4, 'car_755x430.png', 'looking-used-car.png', 'banner-image.jpg', 'about_services_faq_bg.jpg', '', 1, 1, 1, 1, 1, 1, 1, NULL, 1, 1, NULL, NULL, '2017-06-19 16:16:17', '2019-06-25 11:10:26', 3, 0),
(3, 'Demo3', 4, 'Lorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsum', 563, 'CNG', 'reyy2012', 5, 'featured-img-3.jpg', 'dealer-logo.jpg', 'img_390x390.jpg', 'listing_img3.jpg', '', 1, 1, 1, 1, 1, 1, NULL, 1, 1, NULL, NULL, NULL, '2017-06-19 16:18:20', '2019-06-25 11:10:31', 1, 1),
(4, 'Demo4', 1, 'Lorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsum', 5636, 'CNG', 'BR-2012', 5, 'featured-img-3.jpg', 'featured-img-1.jpg', 'featured-img-1.jpg', 'featured-img-1.jpg', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, NULL, NULL, NULL, '2017-06-19 16:18:43', '2019-07-12 10:34:57', 2, 1),
(12, 'BREZZA', 1, 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, ', 567, 'Petrol', 'BR-01-2017', 6, 'alesia-kazantceva-283288-unsplash.jpg', NULL, NULL, NULL, NULL, 1, 1, 1, NULL, 1, 1, 1, NULL, 1, 1, 1, 1, '2019-01-02 09:52:50', '2019-07-12 10:35:24', 6, 1),
(13, 'vehicle ', 2, 'Test', NULL, 'Petrol', 'Test45666', 12, 'apple-car-3-970x647-c-3-720x720.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-06-25 11:05:31', '2019-06-25 11:08:21', 2, 1),
(14, 'we', 2, 'er', NULL, 'Petrol', 'werwe', 3, 'download.jpg', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-01-22 12:43:06', NULL, 7, 1),
(15, 'we', 2, 'thrrr', NULL, 'Petrol', '233erer', 3, 'tblbrands.sql', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 1, NULL, NULL, 1, NULL, NULL, NULL, '2020-01-22 12:43:58', NULL, 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_holdbook`
--

CREATE TABLE `user_holdbook` (
  `id` int(11) NOT NULL,
  `user_id` int(10) NOT NULL,
  `empl_id` varchar(100) DEFAULT NULL,
  `username` varchar(80) NOT NULL,
  `ISBN` varchar(100) NOT NULL,
  `book_title` varchar(100) NOT NULL,
  `copies_no` varchar(100) NOT NULL,
  `hold_date` date DEFAULT NULL,
  `issue_request_date` date DEFAULT NULL,
  `direct_issue` int(10) DEFAULT 0,
  `requested_date` datetime NOT NULL DEFAULT current_timestamp(),
  `author` varchar(100) NOT NULL,
  `publisher` varchar(100) NOT NULL,
  `edition` varchar(100) NOT NULL,
  `issueReqId` varchar(150) NOT NULL,
  `status` int(10) DEFAULT 0,
  `bookReturndDate` date NOT NULL,
  `bookIssueDate` date NOT NULL,
  `ext_date` date DEFAULT NULL,
  `book_condition` int(10) NOT NULL DEFAULT 1,
  `returnon` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_holdbook`
--

INSERT INTO `user_holdbook` (`id`, `user_id`, `empl_id`, `username`, `ISBN`, `book_title`, `copies_no`, `hold_date`, `issue_request_date`, `direct_issue`, `requested_date`, `author`, `publisher`, `edition`, `issueReqId`, `status`, `bookReturndDate`, `bookIssueDate`, `ext_date`, `book_condition`, `returnon`) VALUES
(0, 1, NULL, 'SIMRAN SINGH', 'ISBN-002', 'MATH', 'COPY002', NULL, NULL, 0, '2020-12-24 04:00:09', 'A K RMANUJAM', 'ALLIED PUBLICATION', 'IST', 'IssueId-001', 1, '2020-12-29', '2020-12-24', NULL, 1, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fa_alloted_room`
--
ALTER TABLE `fa_alloted_room`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fa_allowed_book`
--
ALTER TABLE `fa_allowed_book`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fa_areas`
--
ALTER TABLE `fa_areas`
  ADD PRIMARY KEY (`area_code`),
  ADD UNIQUE KEY `description` (`description`);

--
-- Indexes for table `fa_assembled_assets`
--
ALTER TABLE `fa_assembled_assets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_category_id` (`item_category_id`),
  ADD KEY `item_sub_category_id` (`item_sub_category_id`),
  ADD KEY `asset_id` (`asset_id`);

--
-- Indexes for table `fa_asset_issue_items`
--
ALTER TABLE `fa_asset_issue_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fa_asset_master`
--
ALTER TABLE `fa_asset_master`
  ADD PRIMARY KEY (`asset_id`);

--
-- Indexes for table `fa_attachments`
--
ALTER TABLE `fa_attachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type_no` (`type_no`,`trans_no`);

--
-- Indexes for table `fa_attendance`
--
ALTER TABLE `fa_attendance`
  ADD PRIMARY KEY (`emp_id`,`overtime_id`,`att_date`);

--
-- Indexes for table `fa_audit_trail`
--
ALTER TABLE `fa_audit_trail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Seq` (`fiscal_year`,`gl_date`,`gl_seq`),
  ADD KEY `Type_and_Number` (`type`,`trans_no`);

--
-- Indexes for table `fa_author_details`
--
ALTER TABLE `fa_author_details`
  ADD PRIMARY KEY (`auth_id`);

--
-- Indexes for table `fa_bank_accounts`
--
ALTER TABLE `fa_bank_accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bank_account_name` (`bank_account_name`),
  ADD KEY `bank_account_number` (`bank_account_number`),
  ADD KEY `account_code` (`account_code`);

--
-- Indexes for table `fa_bank_trans`
--
ALTER TABLE `fa_bank_trans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bank_act` (`bank_act`,`ref`),
  ADD KEY `type` (`type`,`trans_no`),
  ADD KEY `bank_act_2` (`bank_act`,`reconciled`),
  ADD KEY `bank_act_3` (`bank_act`,`trans_date`);

--
-- Indexes for table `fa_bom`
--
ALTER TABLE `fa_bom`
  ADD PRIMARY KEY (`parent`,`component`,`workcentre_added`,`loc_code`),
  ADD KEY `component` (`component`),
  ADD KEY `id` (`id`),
  ADD KEY `loc_code` (`loc_code`),
  ADD KEY `parent` (`parent`,`loc_code`),
  ADD KEY `workcentre_added` (`workcentre_added`);

--
-- Indexes for table `fa_bom_drawings`
--
ALTER TABLE `fa_bom_drawings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fa_books`
--
ALTER TABLE `fa_books`
  ADD PRIMARY KEY (`book_id`);

--
-- Indexes for table `fa_books_copies`
--
ALTER TABLE `fa_books_copies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fa_book_category`
--
ALTER TABLE `fa_book_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fa_book_fine`
--
ALTER TABLE `fa_book_fine`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fa_book_location`
--
ALTER TABLE `fa_book_location`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fa_book_map`
--
ALTER TABLE `fa_book_map`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fa_breakdown_maintain_items`
--
ALTER TABLE `fa_breakdown_maintain_items`
  ADD PRIMARY KEY (`items_id`);

--
-- Indexes for table `fa_breakdown_maintenance`
--
ALTER TABLE `fa_breakdown_maintenance`
  ADD PRIMARY KEY (`break_id`);

--
-- Indexes for table `fa_breakdown_new_items`
--
ALTER TABLE `fa_breakdown_new_items`
  ADD PRIMARY KEY (`new_items_id`);

--
-- Indexes for table `fa_building_issues`
--
ALTER TABLE `fa_building_issues`
  ADD PRIMARY KEY (`issue_no`);

--
-- Indexes for table `fa_carry_forward_leave`
--
ALTER TABLE `fa_carry_forward_leave`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fa_cat_group`
--
ALTER TABLE `fa_cat_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fa_chart_class`
--
ALTER TABLE `fa_chart_class`
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `fa_chart_master`
--
ALTER TABLE `fa_chart_master`
  ADD PRIMARY KEY (`account_code`);

--
-- Indexes for table `fa_chart_types`
--
ALTER TABLE `fa_chart_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fa_comments`
--
ALTER TABLE `fa_comments`
  ADD KEY `type` (`type`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `fa_contractor`
--
ALTER TABLE `fa_contractor`
  ADD PRIMARY KEY (`supplier_id`);

--
-- Indexes for table `fa_cost_centre`
--
ALTER TABLE `fa_cost_centre`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fa_crm_categories`
--
ALTER TABLE `fa_crm_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fa_crm_contacts`
--
ALTER TABLE `fa_crm_contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fa_crm_persons`
--
ALTER TABLE `fa_crm_persons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fa_cust_branch`
--
ALTER TABLE `fa_cust_branch`
  ADD PRIMARY KEY (`branch_code`);

--
-- Indexes for table `fa_debtors_master`
--
ALTER TABLE `fa_debtors_master`
  ADD PRIMARY KEY (`debtor_no`);

--
-- Indexes for table `fa_debtor_trans`
--
ALTER TABLE `fa_debtor_trans`
  ADD PRIMARY KEY (`type`,`trans_no`,`debtor_no`),
  ADD KEY `debtor_no` (`debtor_no`,`branch_code`),
  ADD KEY `tran_date` (`tran_date`),
  ADD KEY `order_` (`order_`);

--
-- Indexes for table `fa_debtor_trans_details`
--
ALTER TABLE `fa_debtor_trans_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `debtor_trans_no` (`debtor_trans_no`),
  ADD KEY `debtor_trans_type` (`debtor_trans_type`);

--
-- Indexes for table `fa_department`
--
ALTER TABLE `fa_department`
  ADD PRIMARY KEY (`dept_id`);

--
-- Indexes for table `fa_department_allocation`
--
ALTER TABLE `fa_department_allocation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `master_id` (`master_id`);

--
-- Indexes for table `fa_department_master`
--
ALTER TABLE `fa_department_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fa_dept_issues`
--
ALTER TABLE `fa_dept_issues`
  ADD PRIMARY KEY (`issue_no`);

--
-- Indexes for table `fa_dept_issue_items`
--
ALTER TABLE `fa_dept_issue_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fa_designation_master`
--
ALTER TABLE `fa_designation_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fa_fiscal_year`
--
ALTER TABLE `fa_fiscal_year`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fa_floor_aisle`
--
ALTER TABLE `fa_floor_aisle`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fa_floor_issues`
--
ALTER TABLE `fa_floor_issues`
  ADD PRIMARY KEY (`issue_no`);

--
-- Indexes for table `fa_floor_issue_items`
--
ALTER TABLE `fa_floor_issue_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fa_gl_trans`
--
ALTER TABLE `fa_gl_trans`
  ADD PRIMARY KEY (`counter`);

--
-- Indexes for table `fa_grn_batch`
--
ALTER TABLE `fa_grn_batch`
  ADD PRIMARY KEY (`id`),
  ADD KEY `delivery_date` (`delivery_date`),
  ADD KEY `purch_order_no` (`purch_order_no`);

--
-- Indexes for table `fa_grn_items`
--
ALTER TABLE `fa_grn_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `grn_batch_id` (`grn_batch_id`);

--
-- Indexes for table `fa_grn_serial_no`
--
ALTER TABLE `fa_grn_serial_no`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fa_group`
--
ALTER TABLE `fa_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fa_groups`
--
ALTER TABLE `fa_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fa_guest_registration`
--
ALTER TABLE `fa_guest_registration`
  ADD PRIMARY KEY (`guest_id`);

--
-- Indexes for table `fa_kv_allocation_request`
--
ALTER TABLE `fa_kv_allocation_request`
  ADD PRIMARY KEY (`allocate_id`);

--
-- Indexes for table `fa_kv_departments`
--
ALTER TABLE `fa_kv_departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fa_kv_empl_attendancee`
--
ALTER TABLE `fa_kv_empl_attendancee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fa_kv_empl_info`
--
ALTER TABLE `fa_kv_empl_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fa_kv_empl_job`
--
ALTER TABLE `fa_kv_empl_job`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fa_kv_holiday_master`
--
ALTER TABLE `fa_kv_holiday_master`
  ADD PRIMARY KEY (`holiday_id`);

--
-- Indexes for table `fa_kv_leave_days`
--
ALTER TABLE `fa_kv_leave_days`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fa_kv_leave_encash`
--
ALTER TABLE `fa_kv_leave_encash`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fa_kv_leave_master`
--
ALTER TABLE `fa_kv_leave_master`
  ADD PRIMARY KEY (`leave_id`);

--
-- Indexes for table `fa_kv_leave_request_status`
--
ALTER TABLE `fa_kv_leave_request_status`
  ADD PRIMARY KEY (`status_id`);

--
-- Indexes for table `fa_kv_type_leave_master`
--
ALTER TABLE `fa_kv_type_leave_master`
  ADD PRIMARY KEY (`type_id`);

--
-- Indexes for table `fa_locations`
--
ALTER TABLE `fa_locations`
  ADD PRIMARY KEY (`loc_code`);

--
-- Indexes for table `fa_product_master`
--
ALTER TABLE `fa_product_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fa_purch_data`
--
ALTER TABLE `fa_purch_data`
  ADD PRIMARY KEY (`supplier_id`);

--
-- Indexes for table `fa_purch_orders`
--
ALTER TABLE `fa_purch_orders`
  ADD PRIMARY KEY (`order_no`),
  ADD KEY `ord_date` (`ord_date`);

--
-- Indexes for table `fa_purch_order_details`
--
ALTER TABLE `fa_purch_order_details`
  ADD PRIMARY KEY (`po_detail_item`),
  ADD KEY `order` (`order_no`,`po_detail_item`),
  ADD KEY `itemcode` (`item_code`);

--
-- Indexes for table `fa_reflines`
--
ALTER TABLE `fa_reflines`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fa_refs`
--
ALTER TABLE `fa_refs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fa_return`
--
ALTER TABLE `fa_return`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fa_room_issues`
--
ALTER TABLE `fa_room_issues`
  ADD PRIMARY KEY (`issue_no`);

--
-- Indexes for table `fa_room_issue_items`
--
ALTER TABLE `fa_room_issue_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fa_room_main`
--
ALTER TABLE `fa_room_main`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fa_room_master`
--
ALTER TABLE `fa_room_master`
  ADD PRIMARY KEY (`room_id`);

--
-- Indexes for table `fa_room_transition`
--
ALTER TABLE `fa_room_transition`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fa_sales_orders`
--
ALTER TABLE `fa_sales_orders`
  ADD PRIMARY KEY (`order_no`);

--
-- Indexes for table `fa_sales_order_details`
--
ALTER TABLE `fa_sales_order_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fa_seat_allocation`
--
ALTER TABLE `fa_seat_allocation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fa_seat_issues`
--
ALTER TABLE `fa_seat_issues`
  ADD PRIMARY KEY (`issue_no`);

--
-- Indexes for table `fa_seat_issue_items`
--
ALTER TABLE `fa_seat_issue_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fa_seat_master`
--
ALTER TABLE `fa_seat_master`
  ADD PRIMARY KEY (`id`),
  ADD KEY `building` (`building`),
  ADD KEY `floor` (`floor`),
  ADD KEY `room` (`room`);

--
-- Indexes for table `fa_security_roles`
--
ALTER TABLE `fa_security_roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fa_stock_category`
--
ALTER TABLE `fa_stock_category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `fa_stock_category_old`
--
ALTER TABLE `fa_stock_category_old`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `fa_stock_master`
--
ALTER TABLE `fa_stock_master`
  ADD PRIMARY KEY (`stock_id`);

--
-- Indexes for table `fa_stock_master_old`
--
ALTER TABLE `fa_stock_master_old`
  ADD PRIMARY KEY (`stock_id`);

--
-- Indexes for table `fa_stock_moves`
--
ALTER TABLE `fa_stock_moves`
  ADD PRIMARY KEY (`trans_id`);

--
-- Indexes for table `fa_stock_retruns`
--
ALTER TABLE `fa_stock_retruns`
  ADD PRIMARY KEY (`trans_id`);

--
-- Indexes for table `fa_stock_serial_no`
--
ALTER TABLE `fa_stock_serial_no`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fa_stock_sub_category`
--
ALTER TABLE `fa_stock_sub_category`
  ADD PRIMARY KEY (`sub_cat_id`);

--
-- Indexes for table `fa_stock_sub_category_old`
--
ALTER TABLE `fa_stock_sub_category_old`
  ADD PRIMARY KEY (`sub_cat_id`);

--
-- Indexes for table `fa_store_location`
--
ALTER TABLE `fa_store_location`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fa_sub_asset_master`
--
ALTER TABLE `fa_sub_asset_master`
  ADD PRIMARY KEY (`sub_asset_id`);

--
-- Indexes for table `fa_sys_group`
--
ALTER TABLE `fa_sys_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fa_sys_types`
--
ALTER TABLE `fa_sys_types`
  ADD PRIMARY KEY (`type_id`);

--
-- Indexes for table `fa_users`
--
ALTER TABLE `fa_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fa_user_assign_group`
--
ALTER TABLE `fa_user_assign_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fa_user_issues`
--
ALTER TABLE `fa_user_issues`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fa_user_issue_items`
--
ALTER TABLE `fa_user_issue_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fa_workcentres`
--
ALTER TABLE `fa_workcentres`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fa_workorders`
--
ALTER TABLE `fa_workorders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fa_wo_issues`
--
ALTER TABLE `fa_wo_issues`
  ADD PRIMARY KEY (`issue_no`);

--
-- Indexes for table `fa_wo_issue_items`
--
ALTER TABLE `fa_wo_issue_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fa_wo_manufacture`
--
ALTER TABLE `fa_wo_manufacture`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fa_wo_requirements`
--
ALTER TABLE `fa_wo_requirements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tax_setup`
--
ALTER TABLE `tax_setup`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fa_alloted_room`
--
ALTER TABLE `fa_alloted_room`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fa_allowed_book`
--
ALTER TABLE `fa_allowed_book`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `fa_areas`
--
ALTER TABLE `fa_areas`
  MODIFY `area_code` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `fa_assembled_assets`
--
ALTER TABLE `fa_assembled_assets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `fa_asset_issue_items`
--
ALTER TABLE `fa_asset_issue_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fa_asset_master`
--
ALTER TABLE `fa_asset_master`
  MODIFY `asset_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `fa_attachments`
--
ALTER TABLE `fa_attachments`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fa_audit_trail`
--
ALTER TABLE `fa_audit_trail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=296;

--
-- AUTO_INCREMENT for table `fa_bom`
--
ALTER TABLE `fa_bom`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `fa_bom_drawings`
--
ALTER TABLE `fa_bom_drawings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fa_books_copies`
--
ALTER TABLE `fa_books_copies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=143;

--
-- AUTO_INCREMENT for table `fa_building_issues`
--
ALTER TABLE `fa_building_issues`
  MODIFY `issue_no` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fa_carry_forward_leave`
--
ALTER TABLE `fa_carry_forward_leave`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fa_cat_group`
--
ALTER TABLE `fa_cat_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fa_chart_class`
--
ALTER TABLE `fa_chart_class`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fa_contractor`
--
ALTER TABLE `fa_contractor`
  MODIFY `supplier_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fa_cost_centre`
--
ALTER TABLE `fa_cost_centre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fa_crm_categories`
--
ALTER TABLE `fa_crm_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'pure technical key';

--
-- AUTO_INCREMENT for table `fa_crm_contacts`
--
ALTER TABLE `fa_crm_contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fa_crm_persons`
--
ALTER TABLE `fa_crm_persons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fa_cust_branch`
--
ALTER TABLE `fa_cust_branch`
  MODIFY `branch_code` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fa_debtors_master`
--
ALTER TABLE `fa_debtors_master`
  MODIFY `debtor_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `fa_debtor_trans_details`
--
ALTER TABLE `fa_debtor_trans_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `fa_department`
--
ALTER TABLE `fa_department`
  MODIFY `dept_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `fa_department_allocation`
--
ALTER TABLE `fa_department_allocation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `fa_department_master`
--
ALTER TABLE `fa_department_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `fa_dept_issues`
--
ALTER TABLE `fa_dept_issues`
  MODIFY `issue_no` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fa_dept_issue_items`
--
ALTER TABLE `fa_dept_issue_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fa_designation_master`
--
ALTER TABLE `fa_designation_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `fa_fiscal_year`
--
ALTER TABLE `fa_fiscal_year`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `fa_floor_aisle`
--
ALTER TABLE `fa_floor_aisle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fa_floor_issues`
--
ALTER TABLE `fa_floor_issues`
  MODIFY `issue_no` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fa_floor_issue_items`
--
ALTER TABLE `fa_floor_issue_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fa_gl_trans`
--
ALTER TABLE `fa_gl_trans`
  MODIFY `counter` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fa_grn_batch`
--
ALTER TABLE `fa_grn_batch`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=249;

--
-- AUTO_INCREMENT for table `fa_grn_items`
--
ALTER TABLE `fa_grn_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=429;

--
-- AUTO_INCREMENT for table `fa_grn_serial_no`
--
ALTER TABLE `fa_grn_serial_no`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1051;

--
-- AUTO_INCREMENT for table `fa_group`
--
ALTER TABLE `fa_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `fa_groups`
--
ALTER TABLE `fa_groups`
  MODIFY `id` smallint(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `fa_guest_registration`
--
ALTER TABLE `fa_guest_registration`
  MODIFY `guest_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fa_kv_allocation_request`
--
ALTER TABLE `fa_kv_allocation_request`
  MODIFY `allocate_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `fa_kv_departments`
--
ALTER TABLE `fa_kv_departments`
  MODIFY `id` smallint(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `fa_kv_empl_attendancee`
--
ALTER TABLE `fa_kv_empl_attendancee`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=207;

--
-- AUTO_INCREMENT for table `fa_kv_empl_info`
--
ALTER TABLE `fa_kv_empl_info`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=203;

--
-- AUTO_INCREMENT for table `fa_kv_empl_job`
--
ALTER TABLE `fa_kv_empl_job`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=192;

--
-- AUTO_INCREMENT for table `fa_kv_holiday_master`
--
ALTER TABLE `fa_kv_holiday_master`
  MODIFY `holiday_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `fa_kv_leave_days`
--
ALTER TABLE `fa_kv_leave_days`
  MODIFY `id` smallint(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `fa_kv_leave_encash`
--
ALTER TABLE `fa_kv_leave_encash`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fa_kv_leave_master`
--
ALTER TABLE `fa_kv_leave_master`
  MODIFY `leave_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `fa_kv_leave_request_status`
--
ALTER TABLE `fa_kv_leave_request_status`
  MODIFY `status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `fa_kv_type_leave_master`
--
ALTER TABLE `fa_kv_type_leave_master`
  MODIFY `type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `fa_product_master`
--
ALTER TABLE `fa_product_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `fa_purch_data`
--
ALTER TABLE `fa_purch_data`
  MODIFY `supplier_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fa_purch_orders`
--
ALTER TABLE `fa_purch_orders`
  MODIFY `order_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=309;

--
-- AUTO_INCREMENT for table `fa_purch_order_details`
--
ALTER TABLE `fa_purch_order_details`
  MODIFY `po_detail_item` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=511;

--
-- AUTO_INCREMENT for table `fa_reflines`
--
ALTER TABLE `fa_reflines`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `fa_refs`
--
ALTER TABLE `fa_refs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `fa_return`
--
ALTER TABLE `fa_return`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `fa_room_issues`
--
ALTER TABLE `fa_room_issues`
  MODIFY `issue_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `fa_room_issue_items`
--
ALTER TABLE `fa_room_issue_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `fa_room_main`
--
ALTER TABLE `fa_room_main`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `fa_room_master`
--
ALTER TABLE `fa_room_master`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fa_room_transition`
--
ALTER TABLE `fa_room_transition`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `fa_sales_order_details`
--
ALTER TABLE `fa_sales_order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `fa_seat_allocation`
--
ALTER TABLE `fa_seat_allocation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `fa_seat_issues`
--
ALTER TABLE `fa_seat_issues`
  MODIFY `issue_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `fa_seat_issue_items`
--
ALTER TABLE `fa_seat_issue_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `fa_seat_master`
--
ALTER TABLE `fa_seat_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `fa_security_roles`
--
ALTER TABLE `fa_security_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `fa_stock_category`
--
ALTER TABLE `fa_stock_category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `fa_stock_category_old`
--
ALTER TABLE `fa_stock_category_old`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `fa_stock_moves`
--
ALTER TABLE `fa_stock_moves`
  MODIFY `trans_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=705;

--
-- AUTO_INCREMENT for table `fa_stock_retruns`
--
ALTER TABLE `fa_stock_retruns`
  MODIFY `trans_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `fa_stock_serial_no`
--
ALTER TABLE `fa_stock_serial_no`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fa_stock_sub_category`
--
ALTER TABLE `fa_stock_sub_category`
  MODIFY `sub_cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `fa_stock_sub_category_old`
--
ALTER TABLE `fa_stock_sub_category_old`
  MODIFY `sub_cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `fa_store_location`
--
ALTER TABLE `fa_store_location`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `fa_sub_asset_master`
--
ALTER TABLE `fa_sub_asset_master`
  MODIFY `sub_asset_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `fa_sys_group`
--
ALTER TABLE `fa_sys_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `fa_user_assign_group`
--
ALTER TABLE `fa_user_assign_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `fa_user_issues`
--
ALTER TABLE `fa_user_issues`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `fa_user_issue_items`
--
ALTER TABLE `fa_user_issue_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fa_workorders`
--
ALTER TABLE `fa_workorders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `fa_wo_issues`
--
ALTER TABLE `fa_wo_issues`
  MODIFY `issue_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `fa_wo_issue_items`
--
ALTER TABLE `fa_wo_issue_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `fa_wo_manufacture`
--
ALTER TABLE `fa_wo_manufacture`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `fa_wo_requirements`
--
ALTER TABLE `fa_wo_requirements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tax_setup`
--
ALTER TABLE `tax_setup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
