-- phpMyAdmin SQL Dump
-- version 4.0.10.20
-- https://www.phpmyadmin.net
--
-- Inang: 10.0.1.60
-- Waktu pembuatan: 10 Sep 2025 pada 14.11
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
-- Struktur dari tabel `category_catchup`
--

CREATE TABLE IF NOT EXISTS `category_catchup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `visible` enum('Y','N') NOT NULL DEFAULT 'N',
  `create_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `update_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data untuk tabel `category_catchup`
--

INSERT INTO `category_catchup` (`id`, `title`, `visible`, `create_date`, `update_date`) VALUES
(1, 'Single', 'Y', '2023-06-27 00:00:00', '2023-06-27 10:25:04'),
(2, 'Season', 'Y', '2023-06-27 00:00:00', '2023-06-27 10:25:04'),
(3, 'Trailer', 'Y', '2023-06-27 00:00:00', '2023-06-27 10:25:23'),
(4, 'Sequels', 'Y', '0000-00-00 00:00:00', '2023-08-04 11:27:46');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
