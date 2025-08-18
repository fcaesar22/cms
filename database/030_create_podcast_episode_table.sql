-- phpMyAdmin SQL Dump
-- version 4.0.10.20
-- https://www.phpmyadmin.net
--
-- Inang: 10.0.1.60
-- Waktu pembuatan: 18 Agu 2025 pada 15.47
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
-- Struktur dari tabel `podcast_episode`
--

CREATE TABLE IF NOT EXISTS `podcast_episode` (
  `podcast_episode_id` int(11) NOT NULL AUTO_INCREMENT,
  `podcast_data_id` int(11) NOT NULL,
  `episode_title` text NOT NULL,
  `episode_desc` text NOT NULL,
  `episode_pubdate` varchar(150) NOT NULL,
  `episode_enclosure_link` varchar(255) NOT NULL,
  `episode_length` varchar(45) NOT NULL,
  `episode_image` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `ctrloc` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`podcast_episode_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10308 ;
