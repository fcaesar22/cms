-- phpMyAdmin SQL Dump
-- version 4.0.10.20
-- https://www.phpmyadmin.net
--
-- Inang: 10.0.1.60
-- Waktu pembuatan: 18 Agu 2025 pada 15.46
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
-- Struktur dari tabel `podcast_data`
--

CREATE TABLE IF NOT EXISTS `podcast_data` (
  `podcast_data_id` int(11) NOT NULL AUTO_INCREMENT,
  `podcast_id` int(11) NOT NULL,
  `podcast_title` text NOT NULL,
  `podcast_desc` text,
  `podcast_link` varchar(255) NOT NULL,
  `podcast_image` varchar(255) NOT NULL,
  `podcast_author` varchar(150) NOT NULL,
  `podcast_copyright` varchar(150) NOT NULL,
  `podcast_builddate` varchar(150) NOT NULL,
  `podcast_lang` varchar(5) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `ctrloc` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`podcast_data_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
