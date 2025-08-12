-- phpMyAdmin SQL Dump
-- version 4.0.10.20
-- https://www.phpmyadmin.net
--
-- Inang: 10.0.1.60
-- Waktu pembuatan: 12 Agu 2025 pada 14.23
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
-- Struktur dari tabel `poster`
--

CREATE TABLE IF NOT EXISTS `poster` (
  `poster_id` int(11) NOT NULL AUTO_INCREMENT,
  `poster_type` varchar(20) DEFAULT NULL,
  `poster_url` varchar(255) DEFAULT NULL,
  `poster_visible` enum('Y','N') DEFAULT NULL,
  `product_id` varchar(20) DEFAULT NULL,
  `poster_update` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`poster_id`),
  KEY `poster_product_id` (`product_id`),
  KEY `poster_poster_type` (`poster_type`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
