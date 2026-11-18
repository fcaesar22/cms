-- phpMyAdmin SQL Dump
-- version 4.0.10.20
-- https://www.phpmyadmin.net
--
-- Inang: 10.0.1.60
-- Waktu pembuatan: 09 Nov 2026 pada 13.29
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
-- Struktur dari tabel `tab_popup`
--

CREATE TABLE IF NOT EXISTS `tab_popup` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `img_url` varchar(255) DEFAULT NULL,
  `img_url_ios` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `location_id` bigint(10) DEFAULT NULL COMMENT 'where the popup show',
  `status` enum('active','not_active','trash') DEFAULT 'active',
  `device` enum('all','website','android','ios','stb') DEFAULT 'all',
  `category` enum('external','tv','vod') DEFAULT 'external' COMMENT '''external'',''tv'',''vod''',
  `content_id` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL,
  `ctrloc` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data untuk tabel `tab_popup`
--

INSERT INTO `tab_popup` (`id`, `img_url`, `img_url_ios`, `link`, `location_id`, `status`, `device`, `category`, `content_id`, `created_at`, `created_by`, `updated_at`, `updated_by`, `ctrloc`) VALUES
(1, 'https://pic.dens.tv/wp/img/adv_asset_1_1/575x1028/Pop-Up-Playhub.png', 'https://pic.dens.tv/wp/img/adv_asset_1_1/575x1028/Pop-Up-Playhub.png', 'https://www.dens.tv/tv-local/watch/107/densplay', 1, 'active', 'all', 'tv', '107', '2021-07-27 05:18:06', 'admin', '2026-11-09 04:02:43', 'admin', NULL),
(2, 'https://pic.dens.tv//wp/img/adv_asset_1_1/1280x720/1650611662_adv_asset_1_1.png', 'https://pic.dens.tv//wp/img/adv_asset_1_1/1280x720/1650611662_adv_asset_1_1.png', NULL, 2, 'active', 'all', 'external', '', '2021-12-28 09:08:12', 'superadmin', '2026-03-30 06:46:00', 'admin', NULL),
(3, 'https://op-svod.dens.tv/04/ss/qwestrebranding21112025.mp4', 'https://op-svod.dens.tv/04/ss/qwestrebranding21112025.mp4', NULL, 3, 'active', 'all', 'external', '', '2021-12-29 04:22:01', 'admin', '2025-11-21 11:21:45', 'admin', NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
