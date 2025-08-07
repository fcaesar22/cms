-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 07 Agu 2025 pada 13.03
-- Versi server: 10.4.22-MariaDB
-- Versi PHP: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cms`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `whatson`
--

CREATE TABLE `whatson` (
  `whatson_id` int(11) NOT NULL AUTO_INCREMENT,
  `whatson_type` enum('1','2','3') NOT NULL,
  `category_whatson_id` int(11) NOT NULL,
  `sub_category_whatson_id` int(11) NOT NULL,
  `channel_whatson_id` int(11) NOT NULL,
  `thumbnail_whatson_id` int(11) NOT NULL,
  `whatson_banner_active` enum('0','1') NOT NULL COMMENT '0=unactive,1=active',
  `content_id` varchar(11) NOT NULL,
  `content_url` varchar(255) NOT NULL,
  `content_url_image` varchar(255) NOT NULL,
  `whatson_title` varchar(100) NOT NULL,
  `whatson_description` text NOT NULL,
  `whatson_image` text NOT NULL,
  `whatson_image_potrait` text NOT NULL,
  `whatson_thumbnail` text NOT NULL,
  `whatson_video` text NOT NULL,
  `whatson_schedule_time` datetime NOT NULL,
  `created_date_whatson` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted` enum('0','1') NOT NULL COMMENT '0=undeleted,1=deleted',
  `whatson_purpose` int(2) DEFAULT 0 COMMENT '0: Main, 1: Densplay',
  `link_url` varchar(255) DEFAULT NULL COMMENT 'go to link url untuk banner homepage',
  `is_pinned` int(1) NOT NULL DEFAULT 0 COMMENT 'pinned homepage (1,0)',
  PRIMARY KEY (`whatson_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
