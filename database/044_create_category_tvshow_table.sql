-- phpMyAdmin SQL Dump
-- version 4.0.10.20
-- https://www.phpmyadmin.net
--
-- Inang: 10.0.1.60
-- Waktu pembuatan: 12 Okt 2026 pada 09.56
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
-- Struktur dari tabel `category_tvshow`
--

CREATE TABLE IF NOT EXISTS `category_tvshow` (
  `category_tvshow_id` int(11) NOT NULL AUTO_INCREMENT,
  `title_tvshow` varchar(255) NOT NULL,
  `sort` varchar(50) NOT NULL,
  `show_number` enum('Y','N') NOT NULL DEFAULT 'N',
  `model` varchar(100) DEFAULT NULL COMMENT 'nama tabel relasi',
  `visible` enum('Y','N') NOT NULL DEFAULT 'N',
  `create_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `update_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ctrloc` varchar(255) NOT NULL,
  PRIMARY KEY (`category_tvshow_id`),
  KEY `idxmodel` (`model`),
  KEY `idxvisible` (`visible`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data untuk tabel `category_tvshow`
--

INSERT INTO `category_tvshow` (`category_tvshow_id`, `title_tvshow`, `sort`, `show_number`, `model`, `visible`, `create_date`, `update_date`, `ctrloc`) VALUES
(1, 'Weekly Top 10 TV Show', '1', 'Y', 'top_tvshow', 'Y', '2022-06-14 10:57:00', '2023-07-11 10:22:32', 'category_tvshow'),
(2, 'KOREAN LOVERS', '', 'N', 'top_tvshow', 'N', '2022-06-14 10:57:00', '2023-07-11 10:22:36', '/top/top_tvshow/inactivated_category'),
(3, 'Motorvision Special', '4', 'N', 'top_tvshow', 'Y', '2022-06-14 23:31:38', '2023-07-11 10:22:38', '/top/top_tvshow/insert_category_tvshow'),
(4, 'Cleaning Up Promo Video', '5', 'N', 'top_tvshow', 'Y', '2022-06-23 13:54:14', '2023-07-11 10:22:41', '/top/top_tvshow/insert_category_tvshow'),
(5, 'Spooktober', '', 'N', 'top_tvshow', 'N', '2022-10-19 14:05:12', '2023-07-11 10:22:44', '/top/top_tvshow/inactivated_category'),
(6, 'Hocus Pocus', '6', 'N', 'top_tvshow', 'Y', '2022-10-19 14:05:51', '2023-07-11 10:22:49', '/top/top_tvshow/insert_category_tvshow'),
(7, 'Killer on the Loose', '7', 'N', 'top_tvshow', 'Y', '2022-10-19 14:29:16', '2023-07-11 10:22:55', '/top/top_tvshow/insert_category_tvshow'),
(8, 'Haunted Zone', '8', 'N', 'top_tvshow', 'Y', '2022-10-19 15:20:26', '2023-07-11 10:22:58', '/top/top_tvshow/insert_category_tvshow'),
(9, 'Episodes That You''ve Missed', '2', 'N', 'top_tvshow', 'Y', '2023-06-06 16:04:01', '2023-07-11 10:23:01', '/top/top_tvshow/insert_category_tvshow'),
(10, 'Catch-up Marathon', '3', 'N', 'top_tvshow', 'Y', '2023-06-12 10:40:00', '2023-07-11 10:23:04', '/top/top_tvshow/insert_category_tvshow'),
(11, 'Weekly Top 10 Premium Channel', '2', 'N', 'top_channel', 'Y', '2023-07-11 19:13:37', '2023-07-13 09:53:06', '/top/top_channel_v2/insert_category_toptv'),
(12, 'vhjvjh', '', 'N', 'top_channel', 'N', '2023-07-12 11:37:36', '2023-07-12 04:38:08', '/top/top_channel_v2/inactivated_category'),
(13, 'Weekly Top 10 All TV Channel', '1', 'N', 'top_channel', 'Y', '2023-07-13 10:18:03', '2023-07-13 09:53:06', '/top/top_channel_v2/insert_category_toptv');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
