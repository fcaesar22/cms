-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 09, 2026 at 08:46 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cms`
--

-- --------------------------------------------------------

--
-- Table structure for table `stb`
--

CREATE TABLE `stb` (
  `seq` int(11) NOT NULL,
  `serial_number` varchar(36) NOT NULL,
  `model` varchar(50) NOT NULL,
  `status` int(10) NOT NULL COMMENT '1:ready,2:Login,3:dismantle,4:used',
  `user` varchar(50) NOT NULL COMMENT 'userid',
  `current_version` int(5) DEFAULT 0,
  `mac` varchar(17) NOT NULL,
  `contype` varchar(1) DEFAULT NULL,
  `area` varchar(50) NOT NULL,
  `support` varchar(50) NOT NULL,
  `update_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `active_date` datetime DEFAULT '0000-00-00 00:00:00',
  `void_date` datetime DEFAULT '0000-00-00 00:00:00',
  `updto_version` int(4) DEFAULT NULL COMMENT 'push update to',
  `except_update` int(1) NOT NULL DEFAULT 0,
  `device_product` varchar(255) DEFAULT NULL,
  `ctrloc` varchar(512) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `stb`
--

INSERT INTO `stb` (`seq`, `serial_number`, `model`, `status`, `user`, `current_version`, `mac`, `contype`, `area`, `support`, `update_date`, `active_date`, `void_date`, `updto_version`, `except_update`, `device_product`, `ctrloc`) VALUES
(254039, 'T35TMNC', 'MNC', 1, '', 1, '', NULL, 'SINGLE', 'cms aid/edit', '2026-11-09 04:57:04', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, 0, NULL, 'cms aid/stb/edit');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `stb`
--
ALTER TABLE `stb`
  ADD PRIMARY KEY (`seq`),
  ADD UNIQUE KEY `serial_number` (`serial_number`),
  ADD KEY `idx_sn` (`serial_number`),
  ADD KEY `idx_user` (`user`),
  ADD KEY `idx_status` (`status`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `stb`
--
ALTER TABLE `stb`
  MODIFY `seq` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=254040;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
