-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 26, 2025 at 06:13 PM
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
-- Database: `fasttrack`
--

-- --------------------------------------------------------

--
-- Table structure for table `assing_drivers`
--

CREATE TABLE `assing_drivers` (
  `id` int(100) NOT NULL,
  `driver_id` int(100) NOT NULL,
  `vehicle` varchar(100) NOT NULL,
  `order_id` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assing_drivers`
--

INSERT INTO `assing_drivers` (`id`, `driver_id`, `vehicle`, `order_id`) VALUES
(18, 26, 'Truck 101', '61'),
(19, 26, 'Truck 101', '71'),
(20, 27, 'Truck 101', '101');

-- --------------------------------------------------------

--
-- Table structure for table `branch`
--

CREATE TABLE `branch` (
  `branch_id` int(11) NOT NULL,
  `branch_name` varchar(111) NOT NULL,
  `branch_code` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `branch`
--

INSERT INTO `branch` (`branch_id`, `branch_name`, `branch_code`) VALUES
(1, 'Dhaka', '1207'),
(2, 'Noakhali', '3836'),
(4, 'Magura', '4545'),
(5, 'Barisal', '4533'),
(6, 'Comilla\r\n', '3909'),
(7, 'Chittagong', '2323'),
(8, 'Chandpur', '2444'),
(9, 'Gazipur', '6766'),
(10, 'Narayanganj', '3454');

-- --------------------------------------------------------

--
-- Table structure for table `customer_section`
--

CREATE TABLE `customer_section` (
  `id` int(100) NOT NULL,
  `service_type` varchar(100) NOT NULL,
  `sender_name` varchar(100) NOT NULL,
  `sender_address` varchar(100) NOT NULL,
  `sender_phone` varchar(100) NOT NULL,
  `receiver_name` varchar(100) NOT NULL,
  `receiver_address` varchar(100) NOT NULL,
  `receiver_phone` varchar(100) NOT NULL,
  `product` varchar(100) NOT NULL,
  `weight` int(100) NOT NULL,
  `date_of_order` varchar(100) NOT NULL,
  `money` int(100) NOT NULL,
  `status` varchar(100) NOT NULL,
  `order_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer_section`
--

INSERT INTO `customer_section` (`id`, `service_type`, `sender_name`, `sender_address`, `sender_phone`, `receiver_name`, `receiver_address`, `receiver_phone`, `product`, `weight`, `date_of_order`, `money`, `status`, `order_time`) VALUES
(99, 'Express', 'Rahat', '6 Comilla\r\n', '345345', 'rafi', '2 Noakhali', '3873823', 'wer', 9000, '12-10-2025', 1800, 'Received', '2025-01-25 04:23:21'),
(100, 'Express', 'Rafi', '1 Dhaka', '37982437', 'rajib', '2 Noakhali', '3873823', '345', 9000, '15-01-2025', 1800, 'pending', '2025-01-25 04:25:30'),
(101, 'Express', 'Shahriar', '1 Dhaka', '01301441194', 'Yasin', '2 Noakhali', '01301441198', 'a red box', 8000, '25-01-2025', 1800, 'Received', '2025-01-25 14:32:36');

-- --------------------------------------------------------

--
-- Table structure for table `driver_management`
--

CREATE TABLE `driver_management` (
  `id` int(100) NOT NULL,
  `driver_name` varchar(100) NOT NULL,
  `driver_phone` varchar(100) NOT NULL,
  `available` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `driver_management`
--

INSERT INTO `driver_management` (`id`, `driver_name`, `driver_phone`, `available`) VALUES
(25, 'hasibul', '02324234', 'unavailable'),
(26, 'MUNNA', '4564', 'available'),
(27, 'naim', '35345', 'available');

-- --------------------------------------------------------

--
-- Table structure for table `parcel_recived_location`
--

CREATE TABLE `parcel_recived_location` (
  `id` int(100) NOT NULL,
  `order_id` int(100) NOT NULL,
  `receiver_location` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `received`
--

CREATE TABLE `received` (
  `id` int(100) NOT NULL,
  `order_id` int(100) NOT NULL,
  `recived_location` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `received`
--

INSERT INTO `received` (`id`, `order_id`, `recived_location`, `status`) VALUES
(3, 62, '2', 'Received'),
(5, 63, '4', 'Received'),
(6, 64, '2', 'Received'),
(7, 65, '5', 'Received'),
(8, 71, '2', 'Received'),
(10, 72, '6', 'Received'),
(11, 79, '6', 'Received'),
(12, 101, '2', 'Received');

-- --------------------------------------------------------

--
-- Table structure for table `register_staf`
--

CREATE TABLE `register_staf` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobail` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` varchar(232) NOT NULL,
  `gendar` varchar(232) NOT NULL,
  `country` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `register_staf`
--

INSERT INTO `register_staf` (`id`, `name`, `email`, `mobail`, `password`, `role`, `gendar`, `country`) VALUES
(23, 'Raiyan', 'raiyan@gmail.com', '092340234', '$2y$10$z4uHJ6.gFiqil.wiDaTzy.wBSzUY.j.khGqw2WqYv7QoIyv.MxnQu', 'user', 'Male', 'Bangladesh');

-- --------------------------------------------------------

--
-- Table structure for table `registration`
--

CREATE TABLE `registration` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobail` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `gendar` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registration`
--

INSERT INTO `registration` (`id`, `name`, `email`, `mobail`, `password`, `gendar`, `country`) VALUES
(8, 'rafi', 'rafi@gmail.com', '01301441194', '$2y$10$P9NCQ57SCItdloyilKUlO..eQw2a0gI8I4/eHQVOtUs3i.L/Ynogu', 'Male', 'Bangladesh'),
(9, 'Raiyan', 'rafiyan@gmail.com', '01301441194', '$2y$10$UOpaIt/bqa3O1qYPrk7ddes02cd14mdoXOEmlfz9qzAr6gG1fLtOu', 'Male', 'Afganistan');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assing_drivers`
--
ALTER TABLE `assing_drivers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `branch`
--
ALTER TABLE `branch`
  ADD PRIMARY KEY (`branch_id`);

--
-- Indexes for table `customer_section`
--
ALTER TABLE `customer_section`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `driver_management`
--
ALTER TABLE `driver_management`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parcel_recived_location`
--
ALTER TABLE `parcel_recived_location`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `received`
--
ALTER TABLE `received`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `register_staf`
--
ALTER TABLE `register_staf`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registration`
--
ALTER TABLE `registration`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assing_drivers`
--
ALTER TABLE `assing_drivers`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `branch`
--
ALTER TABLE `branch`
  MODIFY `branch_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `customer_section`
--
ALTER TABLE `customer_section`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `driver_management`
--
ALTER TABLE `driver_management`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `parcel_recived_location`
--
ALTER TABLE `parcel_recived_location`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `received`
--
ALTER TABLE `received`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `register_staf`
--
ALTER TABLE `register_staf`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `registration`
--
ALTER TABLE `registration`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
