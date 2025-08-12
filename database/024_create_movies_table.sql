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
-- Struktur dari tabel `movies`
--

CREATE TABLE IF NOT EXISTS `movies` (
  `movie_id` int(11) NOT NULL AUTO_INCREMENT,
  `movie_code` varchar(128) DEFAULT NULL,
  `movie_sort` int(4) NOT NULL DEFAULT '0',
  `movie_title` varchar(128) DEFAULT NULL,
  `movie_description` text,
  `movie_seq` int(11) NOT NULL DEFAULT '0',
  `movie_actor` varchar(255) DEFAULT NULL,
  `movie_director` varchar(128) DEFAULT NULL,
  `movie_language` varchar(3) DEFAULT NULL,
  `movie_keywords` varchar(1024) DEFAULT NULL,
  `movie_rating` varchar(8) DEFAULT NULL COMMENT 'Parental Controll ',
  `movie_year` varchar(4) DEFAULT '0',
  `movie_trailer` varchar(255) DEFAULT NULL,
  `movie_watching` int(11) DEFAULT '30',
  `movie_price` int(10) NOT NULL DEFAULT '0',
  `movie_date1` datetime DEFAULT '0000-00-00 00:00:00',
  `movie_date2` datetime DEFAULT '0000-00-00 00:00:00',
  `movie_visible` enum('Y','N') NOT NULL DEFAULT 'N',
  `movie_allowapps` varchar(4) NOT NULL DEFAULT '1111' COMMENT 'WEB,STB,IOS,Android',
  `movie_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `movie_type` varchar(3) DEFAULT NULL,
  `movie_parent_id` int(11) DEFAULT NULL,
  `movie_parentype` varchar(3) NOT NULL,
  `movie_childtype` varchar(3) NOT NULL,
  `movie_payable` int(1) DEFAULT '1' COMMENT '2:coming soon,1:true,0:false',
  `stream_stat` varchar(6) DEFAULT '111111' COMMENT 'web,stb,android,ios',
  PRIMARY KEY (`movie_id`),
  UNIQUE KEY `TV_PROGRAM_CODE_I` (`movie_code`),
  KEY `movies_movie_parent_id` (`movie_parent_id`),
  KEY `movies_visible` (`movie_visible`),
  KEY `movies_movie_parentype` (`movie_parentype`),
  KEY `movies_movie_visible` (`movie_visible`),
  KEY `movies_type` (`movie_type`),
  KEY `movies_movie_type` (`movie_type`),
  KEY `movies_movie_childtype` (`movie_childtype`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
