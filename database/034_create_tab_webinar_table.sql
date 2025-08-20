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
-- Struktur dari tabel `tab_webinar`
--

CREATE TABLE IF NOT EXISTS `tab_webinar` (
  `webinar_id` int(10) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(50) DEFAULT NULL COMMENT 'unique webinar id',
  `webinarID` varchar(50) DEFAULT NULL COMMENT 'webinar id',
  `webinarPassword` varchar(20) DEFAULT NULL COMMENT 'webinar password',
  `host_id` varchar(50) DEFAULT NULL COMMENT 'user host id',
  `host_email` varchar(50) DEFAULT NULL COMMENT 'user host email',
  `keyword_id` varchar(255) DEFAULT NULL COMMENT 'keyword_id',
  `topic` varchar(255) DEFAULT NULL COMMENT 'webinar title',
  `agenda` text COMMENT 'webinar desc',
  `vendor` varchar(255) DEFAULT NULL,
  `email_confirmation` text,
  `start_time` datetime DEFAULT NULL COMMENT 'yyyy-MM-dd''T''HH:mm:ss.SSS''Z''',
  `duration` int(5) DEFAULT NULL COMMENT 'minutes',
  `end_time` datetime DEFAULT NULL COMMENT 'yyyy-MM-dd''T''HH:mm:ss.SSS''Z''',
  `join_url` varchar(255) DEFAULT NULL,
  `registration_url` varchar(255) DEFAULT NULL,
  `dens_join_url` varchar(255) DEFAULT NULL,
  `dens_regis_url` varchar(255) DEFAULT NULL,
  `record_url` varchar(255) DEFAULT NULL,
  `vod_url` varchar(255) DEFAULT NULL,
  `is_visible` enum('Y','N') DEFAULT NULL,
  `views` int(11) DEFAULT '0',
  `flag` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL,
  `ctrloc` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`webinar_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
