-- phpMyAdmin SQL Dump
-- version 4.0.10.20
-- https://www.phpmyadmin.net
--
-- Inang: 10.0.1.60
-- Waktu pembuatan: 08 Sep 2025 pada 14.22
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
-- Struktur dari tabel `banner_showcase`
--

CREATE TABLE IF NOT EXISTS `banner_showcase` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `poster_url` varchar(500) NOT NULL,
  `visible` enum('N','Y') NOT NULL DEFAULT 'Y',
  `active` enum('N','Y') DEFAULT 'Y',
  `link_url_web` varchar(500) NOT NULL,
  `link_url_mobile` varchar(500) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` varchar(300) NOT NULL,
  `ctrloc` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data untuk tabel `banner_showcase`
--

INSERT INTO `banner_showcase` (`id`, `start_date`, `end_date`, `poster_url`, `visible`, `active`, `link_url_web`, `link_url_mobile`, `created_at`, `created_by`, `ctrloc`) VALUES
(8, '2022-11-07', '2023-12-07', 'http://showcase.dens.tv/assets/images/d4a134bb106873169a677b23ec4369af.jpg', 'Y', 'Y', 'http://stage.dens.tv/showcase', 'http://stage.dens.tv/showcase', '2022-11-07 08:04:36', '', '/showcase/showcase/insert_banner_showcase'),
(9, '2022-11-07', '2023-12-07', 'http://showcase.dens.tv/assets/images/101b81dddf897447d753aec7831a193c.jpg', 'Y', 'Y', 'http://stage.dens.tv/showcase', 'http://stage.dens.tv/showcase', '2022-11-07 08:05:18', '', '/showcase/showcase/insert_banner_showcase'),
(10, '2022-11-07', '2023-12-07', 'http://showcase.dens.tv/assets/images/5d963f87ff4e9c4549f7a9d8f0059a25.jpg', 'Y', 'Y', 'http://stage.dens.tv', 'http://stage.dens.tv', '2022-11-07 08:09:13', '', '/showcase/showcase/insert_banner_showcase');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
