-- phpMyAdmin SQL Dump
-- version 4.0.10.20
-- https://www.phpmyadmin.net
--
-- Inang: 10.0.1.60
-- Waktu pembuatan: 12 Agu 2025 pada 14.21
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
-- Struktur dari tabel `keywords`
--

CREATE TABLE IF NOT EXISTS `keywords` (
  `keyword_id` int(11) NOT NULL AUTO_INCREMENT,
  `keyword_name` varchar(50) NOT NULL,
  `keyword_sort` int(1) DEFAULT NULL,
  `keyword_child` varchar(3) DEFAULT NULL COMMENT 'mng_code.code_parent=1',
  `keyword_sub` enum('Y','N') DEFAULT NULL COMMENT 'sub keyword',
  `keyword_ref` varchar(3) NOT NULL COMMENT 'mng_code.code_parent=2',
  `keyword_visible` enum('Y','N') NOT NULL DEFAULT 'N',
  `keyword_parentid` varchar(20) DEFAULT NULL COMMENT 'keyword id parent',
  `icon` varchar(50) DEFAULT NULL COMMENT 'icon keyword',
  `color_background` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`keyword_id`),
  KEY `keywords_keyword_name` (`keyword_name`),
  KEY `keywords_keyword_visible` (`keyword_visible`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
