-- phpMyAdmin SQL Dump
-- version 4.0.10.20
-- https://www.phpmyadmin.net
--
-- Inang: 10.0.1.60
-- Waktu pembuatan: 12 Agu 2025 pada 14.26
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
-- Struktur dari tabel `streams`
--

CREATE TABLE IF NOT EXISTS `streams` (
  `stream_id` int(11) NOT NULL AUTO_INCREMENT,
  `stream_type` varchar(8) NOT NULL COMMENT 'mng_code.code_parent=41',
  `stream_screen` varchar(3) NOT NULL COMMENT 'mng_code.code_parent=57',
  `stream_length` int(3) DEFAULT NULL,
  `product_id` varchar(10) NOT NULL,
  `stream_visible` enum('Y','N') NOT NULL DEFAULT 'N',
  `stream_pass` varchar(8) DEFAULT NULL,
  `stream_url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`stream_id`),
  KEY `streams_visible` (`stream_visible`),
  KEY `streams_screen` (`stream_screen`),
  KEY `streams_product_id` (`product_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
