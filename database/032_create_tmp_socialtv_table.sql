-- phpMyAdmin SQL Dump
-- version 4.0.10.20
-- https://www.phpmyadmin.net
--
-- Inang: 10.0.1.60
-- Waktu pembuatan: 19 Agu 2025 pada 17.41
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
-- Struktur dari tabel `tmp_socialtv`
--

CREATE TABLE IF NOT EXISTS `tmp_socialtv` (
  `socialtv_id` int(11) NOT NULL AUTO_INCREMENT,
  `socialtv_name` varchar(225) NOT NULL,
  `description` varchar(225) DEFAULT NULL,
  `channel_id` varchar(225) NOT NULL,
  `source` varchar(225) DEFAULT NULL COMMENT 'keyword_ref: SSC',
  `sortid` int(5) NOT NULL,
  `visible` enum('Y','N') NOT NULL DEFAULT 'N',
  `keyword_parent_id` varchar(225) NOT NULL COMMENT 'keywords.keyword_id',
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(30) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(30) DEFAULT NULL,
  `ctrloc` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`socialtv_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
