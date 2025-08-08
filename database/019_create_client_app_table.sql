-- phpMyAdmin SQL Dump
-- version 4.0.10.20
-- https://www.phpmyadmin.net
--
-- Inang: 10.0.1.60
-- Waktu pembuatan: 08 Agu 2025 pada 09.11
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
-- Struktur dari tabel `client_app`
--

CREATE TABLE IF NOT EXISTS `client_app` (
  `id_client` int(11) NOT NULL AUTO_INCREMENT,
  `name_client` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `client_id` varchar(255) NOT NULL,
  `secret_id` varchar(255) NOT NULL,
  `genre_tv_id` varchar(255) DEFAULT NULL COMMENT 'seq from tb_genre_tv',
  `visible` enum('Y','N') NOT NULL DEFAULT 'N',
  `create_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `update_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ctrloc` varchar(255) NOT NULL,
  PRIMARY KEY (`id_client`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;
