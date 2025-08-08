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
-- Struktur dari tabel `tv_channel`
--

CREATE TABLE IF NOT EXISTS `tv_channel` (
  `seq` int(11) NOT NULL AUTO_INCREMENT,
  `catea` int(11) NOT NULL DEFAULT '0',
  `cateb` int(11) NOT NULL DEFAULT '0',
  `catec` int(11) NOT NULL DEFAULT '0',
  `channelid` varchar(5) NOT NULL DEFAULT '0',
  `genrelist` varchar(200) DEFAULT NULL,
  `sortid` int(3) NOT NULL DEFAULT '0',
  `title` varchar(128) DEFAULT NULL,
  `description` varchar(1024) DEFAULT NULL,
  `file1` varchar(128) DEFAULT NULL,
  `file2` varchar(128) DEFAULT NULL,
  `file3` varchar(128) DEFAULT NULL,
  `file4` varchar(128) DEFAULT NULL,
  `play_url` varchar(256) DEFAULT NULL,
  `play_url_stb` varchar(256) DEFAULT NULL,
  `play_url_ios_phone` varchar(256) DEFAULT NULL,
  `play_url_ios_pad` varchar(256) DEFAULT NULL,
  `play_url_android_phone` varchar(256) DEFAULT NULL,
  `play_url_android_pad` varchar(256) DEFAULT NULL,
  `tvod_url` varchar(256) DEFAULT NULL,
  `tvod_url_stb` varchar(256) DEFAULT NULL,
  `tvod_url_ios_phone` varchar(256) DEFAULT NULL,
  `tvod_url_ios_pad` varchar(256) DEFAULT NULL,
  `tvod_url_android_phone` varchar(256) DEFAULT NULL,
  `tvod_url_android_pad` varchar(256) DEFAULT NULL,
  `trailer_url` varchar(200) DEFAULT NULL,
  `watching` int(11) NOT NULL DEFAULT '3600' COMMENT 'trial periode (seconds)',
  `price` int(11) NOT NULL DEFAULT '0',
  `price2` int(10) NOT NULL DEFAULT '0',
  `date1` datetime DEFAULT '0000-00-00 00:00:00',
  `date2` datetime DEFAULT '0000-00-00 00:00:00',
  `visible` enum('Y','N') NOT NULL DEFAULT 'N',
  `flag` bit(6) NOT NULL DEFAULT b'0' COMMENT '1:visible,2:Catchup,3:PC:4,5:ios,6:android',
  `update_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `member_area` varchar(100) DEFAULT NULL,
  `member_id` varchar(100) DEFAULT NULL,
  `octpass` varchar(16) DEFAULT '0' COMMENT 'Octoshape Password',
  `play_url_octoshape` varchar(200) DEFAULT NULL,
  `dens_id` varchar(64) DEFAULT NULL COMMENT 'Channell ads for user',
  `catchup_day_limit` int(4) NOT NULL DEFAULT '7777' COMMENT 'catchup day limit 1:web, 2:stb, 3:android, 4:ios',
  `banner_url` varchar(255) DEFAULT NULL,
  `event` varchar(25) NOT NULL DEFAULT '0' COMMENT '0:no event',
  `link_url` varchar(255) DEFAULT NULL,
  `limit_access` varchar(25) DEFAULT NULL,
  `owner` varchar(255) DEFAULT NULL COMMENT 'id_client from tb_client_app',
  PRIMARY KEY (`seq`),
  KEY `idx_genrelist` (`genrelist`),
  KEY `idx_visible` (`visible`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
