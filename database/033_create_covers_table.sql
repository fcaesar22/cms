-- phpMyAdmin SQL Dump
-- version 4.0.10.20
-- https://www.phpmyadmin.net
--
-- Inang: 10.0.1.60
-- Waktu pembuatan: 20 Agu 2025 pada 18.15
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
-- Struktur dari tabel `covers`
--

CREATE TABLE IF NOT EXISTS `covers` (
  `covers_id` int(11) NOT NULL AUTO_INCREMENT,
  `images` varchar(225) NOT NULL COMMENT 'id posters',
  `type_goto` int(11) NOT NULL COMMENT 'keyword_ref: TYC',
  `id_goto` int(11) NOT NULL,
  `category_covers` int(11) NOT NULL COMMENT 'keyword_ref: CYC',
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `url_image_potrait` varchar(255) DEFAULT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`covers_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
