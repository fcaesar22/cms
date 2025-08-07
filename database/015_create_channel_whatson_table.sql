-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 07 Agu 2025 pada 12.57
-- Versi server: 10.4.22-MariaDB
-- Versi PHP: 7.4.27

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
-- Struktur dari tabel `channel_whatson`
--

CREATE TABLE `channel_whatson` (
  `channel_whatson_id` int(11) NOT NULL AUTO_INCREMENT,
  `channel_whatson_name` varchar(50) NOT NULL,
  `channel_whatson_description` text NOT NULL,
  `channel_whatson_logo` varchar(50) NOT NULL,
  `deleted` enum('0','1') NOT NULL COMMENT '0=undeleted,1=deleted',
  PRIMARY KEY (`channel_whatson_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;
