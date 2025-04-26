-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 19, 2023 at 08:52 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `safa_cafe_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_categories`
--

CREATE TABLE `tbl_categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `category_image` varchar(255) NOT NULL,
  `category_status` enum('A','B') NOT NULL DEFAULT 'A',
  `category_createdDate` datetime NOT NULL DEFAULT current_timestamp(),
  `category_updatedDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_categories`
--

INSERT INTO `tbl_categories` (`category_id`, `category_name`, `category_image`, `category_status`, `category_createdDate`, `category_updatedDate`) VALUES
(1, 'New', 'uploads/1678358778-a-removebg-preview.png', 'A', '2023-03-09 11:46:18', NULL),
(3, 'Fast Food', 'uploads/1679482488-3.jpg', 'A', '2023-03-22 11:54:48', NULL),
(4, 'Test', 'uploads/1680810518-face16.jpg', 'A', '2023-04-06 21:48:38', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_notifications`
--

CREATE TABLE `tbl_notifications` (
  `notification_id` int(11) NOT NULL,
  `notification_title` varchar(255) NOT NULL,
  `notification_for` enum('A','S','U') NOT NULL,
  `notification_forID` int(11) NOT NULL,
  `notification_type` enum('O','T') NOT NULL,
  `notification_typeID` int(11) NOT NULL,
  `notification_date` datetime NOT NULL,
  `notification_status` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_notifications`
--

INSERT INTO `tbl_notifications` (`notification_id`, `notification_title`, `notification_for`, `notification_forID`, `notification_type`, `notification_typeID`, `notification_date`, `notification_status`) VALUES
(1, 'New notification', 'S', 6, 'O', 5, '2023-04-26 05:47:05', '1'),
(2, 'New notification', 'A', 1, 'O', 5, '2023-04-26 05:47:05', '1'),
(3, 'Ammad- Place New Pre Booking Order # JR3632', 'S', 6, 'O', 6, '2023-04-27 06:55:26', '0'),
(4, 'Ammad- Place New Pre Booking Order # JR3632', 'A', 1, 'O', 6, '2023-04-27 06:55:26', '1'),
(8, 'Your Instant Order # PA1785 has been Deliverd ByKhalid Mehmood', 'U', 4, 'O', 5, '2023-04-30 22:08:43', '1'),
(9, 'Your Instant Order # PA1785 has been Deliverd ByKhalid Mehmood', 'U', 4, 'O', 5, '2023-04-30 22:08:48', '1'),
(10, 'Your Instant Order # QY8700 has been Deliverd ByKhalid Mehmood', 'U', 4, 'O', 1, '2023-04-30 22:10:07', '1'),
(11, 'Your Instant Order # QY8700 has been Deliverd ByKhalid Mehmood', 'U', 4, 'O', 1, '2023-04-30 22:10:19', '1'),
(38, ' Sends Request for Table Resrvation', 'A', 1, 'T', 1, '2023-05-05 01:39:15', '1'),
(39, ' Sends Request for Table Resrvation', 'A', 1, 'T', 1, '2023-05-05 01:39:15', '1'),
(40, ' Sends Request for Table Resrvation', 'A', 1, 'T', 2, '2023-05-05 01:39:28', '0'),
(41, ' Sends Request for Table Resrvation', 'A', 1, 'T', 2, '2023-05-05 01:39:28', '0'),
(42, ' Sends Request for Table Resrvation', 'A', 1, 'T', 3, '2023-05-05 01:40:39', '1'),
(43, ' Sends Request for Table Resrvation', 'A', 1, 'T', 3, '2023-05-05 01:40:39', '1'),
(44, ' Sends Request for Table Resrvation', 'A', 1, 'T', 4, '2023-05-09 01:16:30', '1'),
(45, ' Sends Request for Table Resrvation', 'A', 1, 'T', 4, '2023-05-09 01:16:30', '1'),
(46, 'Your Table Reservation Request for table Two Person Table has been Approved By Safa Cafe Admin', 'U', 4, 'T', 4, '2023-05-09 02:15:07', '1'),
(47, 'Ammad - Place New Instant Order # OQ0193', 'S', 6, 'O', 7, '2023-05-09 02:33:11', '0'),
(48, 'Ammad - Place New Instant Order # OQ0193', 'A', 1, 'O', 7, '2023-05-09 02:33:11', '1'),
(49, 'Your Instant Order # OQ0193 has been Deliverd By Safa Cafe Admin', 'U', 4, 'O', 7, '2023-05-09 02:33:28', '1'),
(50, ' Sends Request for Table Resrvation', 'A', 1, 'T', 5, '2023-05-09 13:46:01', '0'),
(51, ' Sends Request for Table Resrvation', 'A', 1, 'T', 5, '2023-05-09 13:46:01', '1'),
(52, 'Your Table Reservation Request for table Two Person Table has been Approved By Safa Cafe Admin', 'U', 4, 'T', 5, '2023-05-09 13:46:54', '1'),
(53, 'Ammad - Place New Pre Booking Order # DU7650', 'S', 6, 'O', 8, '2023-05-09 01:49:18', '1'),
(54, 'Ammad - Place New Pre Booking Order # DU7650', 'A', 1, 'O', 8, '2023-05-09 01:49:18', '0'),
(55, 'Ammad - Place New Instant Order # VB8334', 'S', 6, 'O', 9, '2023-05-09 01:52:27', '1'),
(56, 'Ammad - Place New Instant Order # VB8334', 'A', 1, 'O', 9, '2023-05-09 01:52:27', '1'),
(57, 'Your Instant Order # VB8334 has been Deliverd By Khalid Mehmood', 'U', 4, 'O', 9, '2023-05-09 13:52:57', '1'),
(58, 'Ammad - Place New Pre Booking Order # VB2191', 'S', 6, 'O', 10, '2023-05-22 01:33:29', '0'),
(59, 'Ammad - Place New Pre Booking Order # VB2191', 'A', 1, 'O', 10, '2023-05-22 01:33:29', '0'),
(60, 'Ammad - Place New Instant Order # YW5357', 'S', 6, 'O', 11, '2023-05-22 01:58:29', '0'),
(61, 'Ammad - Place New Instant Order # YW5357', 'A', 1, 'O', 11, '2023-05-22 01:58:29', '1'),
(62, ' Sends Request for Table Resrvation', 'A', 1, 'T', 6, '2023-05-25 02:20:29', '0'),
(63, ' Sends Request for Table Resrvation', 'A', 1, 'T', 6, '2023-05-25 02:20:29', '1'),
(64, 'Ammad - Place New Instant Order # PS1827', 'S', 6, 'O', 12, '2023-05-29 09:43:52', '1'),
(65, 'Ammad - Place New Instant Order # PS1827', 'A', 1, 'O', 12, '2023-05-29 09:43:52', '0');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_orders`
--

CREATE TABLE `tbl_orders` (
  `order_id` int(11) NOT NULL,
  `order_no` varchar(50) NOT NULL,
  `order_customerID` int(11) NOT NULL,
  `order_description` text DEFAULT NULL,
  `order_customerName` varchar(255) NOT NULL,
  `order_customerEmail` varchar(255) DEFAULT NULL,
  `order_customerContact` varchar(50) NOT NULL,
  `order_customerAddress` text NOT NULL,
  `order_date` datetime NOT NULL DEFAULT current_timestamp(),
  `order_type` enum('IO','PBO') NOT NULL DEFAULT 'IO',
  `order_deliveryDate` date DEFAULT NULL,
  `order_deliveryTime` time DEFAULT NULL,
  `order_totalAmount` int(11) DEFAULT NULL,
  `order_status` enum('P','D','C','A') NOT NULL DEFAULT 'P',
  `order_deliveredDate` datetime DEFAULT NULL,
  `order_staffID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_orders`
--

INSERT INTO `tbl_orders` (`order_id`, `order_no`, `order_customerID`, `order_description`, `order_customerName`, `order_customerEmail`, `order_customerContact`, `order_customerAddress`, `order_date`, `order_type`, `order_deliveryDate`, `order_deliveryTime`, `order_totalAmount`, `order_status`, `order_deliveredDate`, `order_staffID`) VALUES
(1, 'QY8700', 4, NULL, 'Haider', 'um_h@gmail.com', '05122365987', 'sadsad', '2023-04-12 01:22:43', 'IO', '0000-00-00', '00:00:00', 4410, 'D', '2023-04-30 22:10:19', 6),
(2, 'NO2738', 4, NULL, 'Ammad', 'ammad@gmail.com', '05122365987', 'Test', '2023-04-14 08:20:13', 'IO', '0000-00-00', '00:00:00', 2910, 'P', NULL, NULL),
(3, 'DK7077', 4, NULL, 'Ali', 'ali@gmail.com', '05155369887', 'H#519B Shah G Road Misrial Rawalpindi', '2023-04-19 07:47:43', 'PBO', '2023-04-25', '16:45:00', 4410, 'P', NULL, NULL),
(4, 'FH3293', 4, NULL, 'Haider', 'ab@gmail.com', '03302569554', 'Rawalpindi', '2023-04-19 09:37:29', 'PBO', '2023-05-06', '18:00:00', 1500, 'P', NULL, NULL),
(5, 'PA1785', 4, NULL, 'Khawaja Ammad', 'ammad@gmail.com', '05122365987', 'Rawalpindi', '2023-04-26 05:47:05', 'IO', '0000-00-00', '00:00:00', 1410, 'D', '2023-04-30 22:08:48', 6),
(6, 'JR3632', 4, NULL, 'Haider', 'um_h@gmail.com', '0332056911', 'G10', '2023-04-27 06:55:26', 'PBO', '2023-04-29', '21:00:00', 1410, 'P', NULL, NULL),
(7, 'OQ0193', 4, NULL, 'Ammad', 'um_h@gmail.com', '03325698774', 'Rawalpindi', '2023-05-09 02:33:11', 'IO', '0000-00-00', '00:00:00', 1410, 'D', '2023-05-09 02:33:28', 1),
(8, 'DU7650', 4, NULL, 'Ammad', 'ammad@gmail.com', '03302569554', 'Rawalpindi', '2023-05-09 01:49:18', 'PBO', '2023-05-10', '14:50:00', 2820, 'D', '2023-05-10 02:31:39', NULL),
(9, 'VB8334', 4, NULL, 'Haider', 'ammad@gmail.com', '05122365987', 'Rawalpindi', '2023-05-09 01:52:27', 'IO', '0000-00-00', '00:00:00', 1500, 'D', '2023-05-09 13:52:57', 6),
(10, 'VB2191', 4, 'This is dummy Description', 'Ammad', 'ammad@gmail.com', '05122365987', 'Rawalpindi', '2023-05-22 01:33:29', 'PBO', '2023-05-24', '13:35:00', 2910, 'P', NULL, NULL),
(11, 'YW5357', 4, 'This is my order description kindly read this carefully i need my food exactly as per my description, thank you.', 'Ammad', 'ammad@gmail.com', '05122365987', 'Rawalpindi', '2023-05-22 01:58:29', 'IO', '0000-00-00', '00:00:00', 2820, 'P', NULL, NULL),
(12, 'PS1827', 4, 'This is my order', 'Ammad', 'ammad@gmail.com', '05122365987', 'Rawalpindi', '2023-05-30 09:43:52', 'IO', '0000-00-00', '00:00:00', 500, 'P', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order_details`
--

CREATE TABLE `tbl_order_details` (
  `order_detail_id` int(11) NOT NULL,
  `order_detail_orderID` int(11) NOT NULL,
  `order_detail_productID` int(11) NOT NULL,
  `order_detail_productQty` int(11) NOT NULL,
  `order_detail_productPrice` int(11) NOT NULL,
  `order_detail_createdDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_order_details`
--

INSERT INTO `tbl_order_details` (`order_detail_id`, `order_detail_orderID`, `order_detail_productID`, `order_detail_productQty`, `order_detail_productPrice`, `order_detail_createdDate`) VALUES
(1, 1, 2, 1, 1410, '2023-04-12 01:22:43'),
(2, 1, 3, 2, 1500, '2023-04-12 01:22:43'),
(3, 2, 2, 1, 1410, '2023-04-14 08:20:13'),
(4, 2, 3, 1, 1500, '2023-04-14 08:20:13'),
(5, 3, 2, 1, 1410, '2023-04-19 07:47:43'),
(6, 3, 3, 2, 1500, '2023-04-19 07:47:43'),
(7, 4, 3, 1, 1500, '2023-04-19 09:37:29'),
(8, 5, 2, 1, 1410, '2023-04-26 05:47:05'),
(9, 6, 2, 1, 1410, '2023-04-27 06:55:26'),
(10, 7, 2, 1, 1410, '2023-05-09 02:33:11'),
(11, 8, 2, 2, 1410, '2023-05-09 01:49:18'),
(12, 9, 3, 1, 1500, '2023-05-09 01:52:27'),
(13, 10, 2, 1, 1410, '2023-05-22 01:33:29'),
(14, 10, 3, 1, 1500, '2023-05-22 01:33:29'),
(15, 11, 2, 2, 1410, '2023-05-22 01:58:29'),
(16, 12, 5, 1, 500, '2023-05-29 09:43:52');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_products`
--

CREATE TABLE `tbl_products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_categoryID` int(11) NOT NULL,
  `product_subCategoryID` int(11) NOT NULL,
  `product_image` varchar(255) NOT NULL,
  `product_price` int(11) NOT NULL,
  `product_discount` int(11) NOT NULL DEFAULT 0,
  `product_description` text NOT NULL,
  `product_status` enum('A','B') NOT NULL DEFAULT 'A',
  `product_createdDate` datetime NOT NULL DEFAULT current_timestamp(),
  `product_updatedDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_products`
--

INSERT INTO `tbl_products` (`product_id`, `product_name`, `product_categoryID`, `product_subCategoryID`, `product_image`, `product_price`, `product_discount`, `product_description`, `product_status`, `product_createdDate`, `product_updatedDate`) VALUES
(2, 'NewProduct', 1, 0, 'uploads/1681074188-f5.png', 1500, 6, 'This is dummy data This is dummy data This is dummy data This is dummy data This is dummy data This is dummy data This is dummy data This is dummy data This is dummy data This is dummy data ', 'A', '2023-03-15 07:30:31', '2023-04-09 23:03:08'),
(3, 'Chicken Tika Pizza Large', 3, 0, 'uploads/1681074153-f3.png', 1500, 0, 'This is dummy Data This is dummy Data This is dummy Data This is dummy Data This is dummy Data This is dummy Data This is dummy Data This is dummy Data This is dummy Data This is dummy Data This is dummy Data This is dummy Data This is dummy Data This is dummy Data This is dummy Data This is dummy Data This is dummy Data This is dummy Data This is dummy Data This is dummy Data ', 'A', '2023-03-22 11:56:41', '2023-04-09 23:02:33'),
(4, 'Slide Product 1', 4, 0, 'uploads/1685378546-careers.jpg', 1500, 15, 'This is dummy data for slider prodcutThis is dummy data for slider prodcutThis is dummy data for slider prodcutThis is dummy data for slider prodcutThis is dummy data for slider prodcutThis is dummy data for slider prodcutThis is dummy data for slider prodcutThis is dummy data for slider prodcutThis is dummy data for slider prodcutThis is dummy data for slider prodcutThis is dummy data for slider prodcutThis is dummy data for slider prodcutThis is dummy data for slider prodcutThis is dummy data for slider prodcutThis is dummy data for slider prodcutThis is dummy data for slider prodcutThis is dummy data for slider prodcutThis is dummy data for slider prodcutThis is dummy data for slider prodcutThis is dummy data for slider prodcut', 'A', '2023-05-29 21:42:26', NULL),
(5, 'Slider product 2', 3, 0, 'uploads/1685378595-o1.jpg', 500, 0, 'This is dummy data for slider prodcutThis is dummy data for slider prodcutThis is dummy data for slider prodcutThis is dummy data for slider prodcutThis is dummy data for slider prodcutThis is dummy data for slider prodcutThis is dummy data for slider prodcutThis is dummy data for slider prodcutThis is dummy data for slider prodcutThis is dummy data for slider prodcutThis is dummy data for slider prodcutThis is dummy data for slider prodcutThis is dummy data for slider prodcutThis is dummy data for slider prodcutThis is dummy data for slider prodcutThis is dummy data for slider prodcutThis is dummy data for slider prodcutThis is dummy data for slider prodcutThis is dummy data for slider prodcutThis is dummy data for slider prodcutThis is dummy data for slider prodcutThis is dummy data for slider prodcutThis is dummy data for slider prodcutThis is dummy data for slider prodcutThis is dummy data for slider prodcutThis is dummy data for slider prodcutThis is dummy data for slider prodcutThis is dummy data for slider prodcutThis is dummy data for slider prodcutThis is dummy data for slider prodcutThis is dummy data for slider prodcutThis is dummy data for slider prodcutThis is dummy data for slider prodcutThis is dummy data for slider prodcutThis is dummy data for slider prodcutThis is dummy data for slider prodcut', 'A', '2023-05-29 21:43:15', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_ratings`
--

CREATE TABLE `tbl_ratings` (
  `rating_id` int(11) NOT NULL,
  `rating_orderID` int(11) NOT NULL,
  `rating_userID` int(11) NOT NULL,
  `rating_stars` int(11) NOT NULL,
  `rating_description` text NOT NULL,
  `rating_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_ratings`
--

INSERT INTO `tbl_ratings` (`rating_id`, `rating_orderID`, `rating_userID`, `rating_stars`, `rating_description`, `rating_date`) VALUES
(1, 8, 4, 5, 'This is my dummy data This is my dummy data This is my dummy data This is my dummy data This is my dummy data ', '2023-05-25 01:48:49'),
(2, 9, 4, 3, 'this is our dummy data', '2023-05-25 01:52:42');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_subcategories`
--

CREATE TABLE `tbl_subcategories` (
  `subcategory_id` int(11) NOT NULL,
  `subcategory_categoryID` int(11) NOT NULL,
  `subcategory_name` varchar(255) NOT NULL,
  `subcategory_image` varchar(255) NOT NULL,
  `subcategory_status` enum('A','B') NOT NULL DEFAULT 'A',
  `subcategory_createdDate` datetime NOT NULL DEFAULT current_timestamp(),
  `subcategory_updatedDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_subcategories`
--

INSERT INTO `tbl_subcategories` (`subcategory_id`, `subcategory_categoryID`, `subcategory_name`, `subcategory_image`, `subcategory_status`, `subcategory_createdDate`, `subcategory_updatedDate`) VALUES
(3, 1, 'new one', 'uploads/1678792147-13Rajab-removebg-preview.png', 'A', '2023-03-14 12:09:07', '2023-03-14 12:10:44'),
(4, 1, 'Testq', 'uploads/1678792259-a-removebg-preview.png', 'A', '2023-03-14 12:10:59', '2023-03-14 12:11:43'),
(5, 1, 'maa', 'uploads/1678792326-a-removebg-preview.png', 'A', '2023-03-14 12:12:06', NULL),
(6, 3, 'Chicken Tika Pizza 15 inch', 'uploads/1679482530-2.jpg', 'A', '2023-03-22 11:55:30', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tables`
--

CREATE TABLE `tbl_tables` (
  `table_id` int(11) NOT NULL,
  `table_title` varchar(255) NOT NULL,
  `table_sittingCapacity` int(11) NOT NULL,
  `table_status` enum('A','B') NOT NULL,
  `table_createdDate` datetime NOT NULL DEFAULT current_timestamp(),
  `table_updatedDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_tables`
--

INSERT INTO `tbl_tables` (`table_id`, `table_title`, `table_sittingCapacity`, `table_status`, `table_createdDate`, `table_updatedDate`) VALUES
(1, 'Corner Table', 7, 'A', '2023-05-04 22:34:22', NULL),
(2, 'Two Person Table', 2, 'A', '2023-05-04 22:34:34', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_table_bookings`
--

CREATE TABLE `tbl_table_bookings` (
  `table_booking_id` int(11) NOT NULL,
  `table_booking_tabelID` int(11) NOT NULL,
  `table_booking_userID` int(11) NOT NULL,
  `table_booking_receipt` varchar(255) NOT NULL,
  `table_booking_date` date NOT NULL,
  `table_booking_time` time NOT NULL,
  `table_booking_status` enum('P','A','R') NOT NULL DEFAULT 'P',
  `table_booking_createdDate` datetime NOT NULL DEFAULT current_timestamp(),
  `table_booking_updatedDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_table_bookings`
--

INSERT INTO `tbl_table_bookings` (`table_booking_id`, `table_booking_tabelID`, `table_booking_userID`, `table_booking_receipt`, `table_booking_date`, `table_booking_time`, `table_booking_status`, `table_booking_createdDate`, `table_booking_updatedDate`) VALUES
(1, 1, 4, '', '2023-05-07', '22:00:00', 'P', '2023-05-05 01:39:15', NULL),
(2, 1, 4, '', '2023-05-07', '22:05:00', 'P', '2023-05-05 01:39:28', NULL),
(3, 1, 4, '', '2023-05-07', '22:15:00', 'P', '2023-05-05 01:40:39', NULL),
(4, 2, 4, '', '2023-05-09', '17:20:00', 'A', '2023-05-09 01:16:30', '2023-05-09 02:15:07'),
(5, 2, 4, '', '2023-05-10', '13:45:00', 'A', '2023-05-09 13:46:01', '2023-05-09 13:46:54'),
(6, 2, 4, 'uploads/1684963229-screencapture-localhost-8080-safa-cafe-myOrderDetails-php-2023-05-25-02_02_56.png', '2023-05-27', '14:20:00', 'P', '2023-05-25 02:20:29', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_type` enum('A','C','S') NOT NULL DEFAULT 'C',
  `user_image` varchar(255) DEFAULT NULL,
  `user_contactno` varchar(50) DEFAULT NULL,
  `user_address` text DEFAULT NULL,
  `user_status` enum('A','B') NOT NULL DEFAULT 'A',
  `user_createdDate` datetime NOT NULL,
  `user_updatedDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`user_id`, `user_name`, `user_email`, `user_password`, `user_type`, `user_image`, `user_contactno`, `user_address`, `user_status`, `user_createdDate`, `user_updatedDate`) VALUES
(1, 'Safa Cafe Admin', 'admin@admin.com', '21232f297a57a5a743894a0e4a801fc3', 'A', 'uploads/1679305069-profile.png', NULL, NULL, 'A', '2023-03-09 11:21:04', '2023-03-25 05:58:34'),
(2, 'Usman Khan', 'usman@gmail.com', '8b70ad3af8b2ec57cbaf86ce81a1227e', 'S', 'uploads/1680263265-face25.jpg', '03320569221', 'G10/3, Street # 20, Islamabad, Pakistan', 'B', '2023-03-31 13:16:37', '2023-04-19 09:50:27'),
(3, 'Usman Haider', 'um_h@gmail.com', '912ec803b2ce49e4a541068d495ab570', 'C', 'uploads/1681073582-face27.jpg', '0332056911', 'Rawalpindi', 'A', '2023-04-09 22:08:21', '2023-04-09 23:01:19'),
(4, 'Ammad', 'ammad@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'C', 'uploads/1681159605-client2.jpg', '05122365987', 'Rawalpindi', 'A', '2023-04-10 22:46:45', '0000-00-00 00:00:00'),
(5, 'Haider', 'h@gmai.com', 'b195aa233dd8b3264a5fe258c331dd9c', 'S', '', '05122365987', 'asdada', 'B', '2023-04-19 09:40:12', '2023-04-19 09:50:27'),
(6, 'Khalid Mehmood', 'khalid@ymail.com', 'e10adc3949ba59abbe56e057f20f883e', 'S', 'uploads/1681891160-client2.jpg', '0223456992', 'Rawalpindi, main khana market', 'A', '2023-04-19 09:50:27', '2023-04-19 09:59:56');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_categories`
--
ALTER TABLE `tbl_categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `tbl_notifications`
--
ALTER TABLE `tbl_notifications`
  ADD PRIMARY KEY (`notification_id`);

--
-- Indexes for table `tbl_orders`
--
ALTER TABLE `tbl_orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `tbl_order_details`
--
ALTER TABLE `tbl_order_details`
  ADD PRIMARY KEY (`order_detail_id`);

--
-- Indexes for table `tbl_products`
--
ALTER TABLE `tbl_products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `tbl_ratings`
--
ALTER TABLE `tbl_ratings`
  ADD PRIMARY KEY (`rating_id`);

--
-- Indexes for table `tbl_subcategories`
--
ALTER TABLE `tbl_subcategories`
  ADD PRIMARY KEY (`subcategory_id`);

--
-- Indexes for table `tbl_tables`
--
ALTER TABLE `tbl_tables`
  ADD PRIMARY KEY (`table_id`);

--
-- Indexes for table `tbl_table_bookings`
--
ALTER TABLE `tbl_table_bookings`
  ADD PRIMARY KEY (`table_booking_id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_categories`
--
ALTER TABLE `tbl_categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_notifications`
--
ALTER TABLE `tbl_notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `tbl_orders`
--
ALTER TABLE `tbl_orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_order_details`
--
ALTER TABLE `tbl_order_details`
  MODIFY `order_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tbl_products`
--
ALTER TABLE `tbl_products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_ratings`
--
ALTER TABLE `tbl_ratings`
  MODIFY `rating_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_subcategories`
--
ALTER TABLE `tbl_subcategories`
  MODIFY `subcategory_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_tables`
--
ALTER TABLE `tbl_tables`
  MODIFY `table_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_table_bookings`
--
ALTER TABLE `tbl_table_bookings`
  MODIFY `table_booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
