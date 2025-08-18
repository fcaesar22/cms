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
-- Struktur dari tabel `podcast_recommendation`
--

CREATE TABLE IF NOT EXISTS `podcast_recommendation` (
  `podcast_recommendation_id` int(11) NOT NULL AUTO_INCREMENT,
  `podcast_id` int(11) NOT NULL,
  `start_periode` date NOT NULL,
  `end_periode` date NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL,
  `ctrloc` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`podcast_recommendation_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
