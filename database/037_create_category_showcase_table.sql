-- phpMyAdmin SQL Dump
-- version 4.0.10.20
-- https://www.phpmyadmin.net
--
-- Inang: 10.0.1.60
-- Waktu pembuatan: 08 Sep 2025 pada 14.21
-- Versi Server: 5.6.51-log
-- Versi PHP: 5.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Basis data: `denstv`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `category_showcase`
--

CREATE TABLE IF NOT EXISTS `category_showcase` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sort` int(11) DEFAULT NULL,
  `category_name` varchar(250) NOT NULL,
  `visible` enum('N','Y') DEFAULT 'Y',
  `active` enum('N','Y') DEFAULT 'Y',
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(250) DEFAULT NULL,
  `ctrloc` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=4 ;

--
-- Dumping data untuk tabel `category_showcase`
--

INSERT INTO `category_showcase` (`id`, `sort`, `category_name`, `visible`, `active`, `created_at`, `created_by`, `ctrloc`) VALUES
(1, 1, 'Official Dens.TV Merchandise', 'Y', 'Y', NULL, NULL, NULL),
(2, 2, 'Others', 'N', 'Y', NULL, NULL, NULL),
(3, NULL, 'Website', 'Y', 'Y', '2023-08-08 16:20:47', NULL, '/showcase/showcase/insert_category_showcase');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
