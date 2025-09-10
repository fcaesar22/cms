-- phpMyAdmin SQL Dump
-- version 4.0.10.20
-- https://www.phpmyadmin.net
--
-- Inang: 10.0.1.60
-- Waktu pembuatan: 10 Sep 2025 pada 14.11
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
-- Struktur dari tabel `model_tag`
--

CREATE TABLE IF NOT EXISTS `model_tag` (
  `tag_id` int(10) NOT NULL,
  `id` int(10) NOT NULL,
  `model` varchar(100) NOT NULL COMMENT 'nama table relasi',
  KEY `model_tag_tag_id_model_id` (`id`,`model`) USING BTREE,
  KEY `model_tag_tag_id_tag_id_foreign` (`tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `model_tag`
--

INSERT INTO `model_tag` (`tag_id`, `id`, `model`) VALUES
(1, 8, 'catchup'),
(2, 9, 'catchup'),
(2, 24, 'catchup_content'),
(2, 23, 'catchup_content'),
(2, 30, 'catchup_content'),
(2, 31, 'catchup_content'),
(2, 3, 'catchup_content'),
(1, 3, 'catchup_content'),
(1, 4, 'catchup_content'),
(2, 7, 'catchup_content'),
(1, 21, 'catchup_content'),
(5, 40, 'catchup_content'),
(5, 39, 'catchup_content'),
(1, 34, 'catchup_content'),
(4, 34, 'catchup_content'),
(2, 6, 'catchup_content'),
(2, 5, 'catchup_content'),
(2, 43, 'catchup_content'),
(2, 42, 'catchup_content'),
(2, 41, 'catchup_content'),
(2, 45, 'catchup_content'),
(2, 33, 'catchup_content'),
(2, 32, 'catchup_content'),
(1, 36, 'catchup_content'),
(4, 36, 'catchup_content'),
(1, 35, 'catchup_content'),
(4, 35, 'catchup_content'),
(5, 38, 'catchup_content'),
(2, 38, 'catchup_content'),
(5, 37, 'catchup_content'),
(2, 37, 'catchup_content'),
(1, 22, 'catchup_content'),
(1, 2, 'catchup'),
(1, 2, 'catchup_content'),
(1, 1, 'catchup'),
(1, 1, 'catchup_content'),
(2, 3, 'catchup'),
(2, 47, 'catchup_content'),
(3, 44, 'catchup_content'),
(3, 48, 'catchup_content'),
(2, 49, 'catchup_content'),
(3, 50, 'catchup_content'),
(2, 7, 'catchup'),
(1, 6, 'catchup'),
(4, 6, 'catchup'),
(1, 19, 'catchup_content'),
(4, 19, 'catchup_content'),
(1, 20, 'catchup_content'),
(4, 20, 'catchup_content'),
(2, 5, 'catchup'),
(2, 18, 'catchup_content'),
(2, 17, 'catchup_content'),
(2, 16, 'catchup_content'),
(2, 4, 'catchup'),
(2, 15, 'catchup_content'),
(2, 13, 'catchup_content'),
(2, 12, 'catchup_content'),
(3, 24, 'catchup'),
(3, 10, 'catchup'),
(3, 25, 'catchup_content'),
(3, 11, 'catchup'),
(3, 26, 'catchup_content'),
(1, 12, 'catchup'),
(4, 12, 'catchup'),
(1, 27, 'catchup_content'),
(4, 27, 'catchup_content'),
(2, 13, 'catchup'),
(2, 28, 'catchup_content'),
(2, 14, 'catchup'),
(2, 29, 'catchup_content'),
(2, 21, 'catchup'),
(3, 23, 'catchup'),
(2, 16, 'catchup'),
(5, 18, 'catchup'),
(2, 18, 'catchup'),
(5, 19, 'catchup'),
(2, 15, 'catchup'),
(3, 20, 'catchup'),
(3, 0, 'catchup_content'),
(6, 30, 'catchup'),
(6, 63, 'catchup_content'),
(6, 29, 'catchup'),
(6, 62, 'catchup_content'),
(6, 28, 'catchup'),
(6, 61, 'catchup_content'),
(3, 27, 'catchup'),
(3, 60, 'catchup_content'),
(2, 57, 'catchup_content'),
(2, 58, 'catchup_content'),
(2, 56, 'catchup_content'),
(2, 55, 'catchup_content'),
(2, 54, 'catchup_content'),
(2, 53, 'catchup_content'),
(2, 52, 'catchup_content'),
(2, 51, 'catchup_content'),
(2, 64, 'catchup_content'),
(2, 65, 'catchup_content'),
(4, 32, 'catchup'),
(4, 67, 'catchup_content'),
(4, 31, 'catchup'),
(4, 68, 'catchup_content'),
(4, 66, 'catchup_content'),
(3, 33, 'catchup'),
(3, 69, 'catchup_content'),
(6, 34, 'catchup'),
(6, 70, 'catchup_content'),
(6, 35, 'catchup'),
(6, 71, 'catchup_content'),
(3, 26, 'catchup'),
(3, 59, 'catchup_content'),
(2, 72, 'catchup_content'),
(2, 73, 'catchup_content'),
(2, 36, 'catchup'),
(7, 36, 'catchup'),
(2, 74, 'catchup_content'),
(7, 74, 'catchup_content'),
(4, 17, 'catchup'),
(1, 17, 'catchup'),
(2, 75, 'catchup_content'),
(2, 76, 'catchup_content'),
(2, 77, 'catchup_content'),
(2, 78, 'catchup_content'),
(8, 79, 'catchup_content'),
(8, 37, 'catchup'),
(2, 38, 'catchup'),
(9, 38, 'catchup'),
(2, 80, 'catchup_content'),
(9, 80, 'catchup_content'),
(7, 39, 'catchup'),
(2, 39, 'catchup'),
(8, 39, 'catchup'),
(7, 81, 'catchup_content'),
(2, 81, 'catchup_content'),
(8, 81, 'catchup_content'),
(6, 40, 'catchup'),
(6, 82, 'catchup_content'),
(6, 41, 'catchup'),
(6, 83, 'catchup_content'),
(2, 84, 'catchup_content'),
(2, 85, 'catchup_content'),
(2, 86, 'catchup_content'),
(7, 86, 'catchup_content'),
(2, 87, 'catchup_content'),
(7, 87, 'catchup_content'),
(2, 42, 'catchup'),
(7, 42, 'catchup'),
(10, 43, 'catchup'),
(10, 89, 'catchup_content'),
(2, 90, 'catchup_content'),
(2, 91, 'catchup_content'),
(2, 92, 'catchup_content'),
(7, 92, 'catchup_content'),
(2, 93, 'catchup_content'),
(7, 93, 'catchup_content'),
(8, 94, 'catchup_content'),
(8, 88, 'catchup_content'),
(4, 44, 'catchup'),
(4, 95, 'catchup_content'),
(4, 96, 'catchup_content'),
(4, 97, 'catchup_content'),
(2, 98, 'catchup_content'),
(9, 98, 'catchup_content'),
(2, 99, 'catchup_content'),
(9, 99, 'catchup_content'),
(11, 45, 'catchup'),
(11, 100, 'catchup_content'),
(1, 46, 'catchup'),
(1, 101, 'catchup_content'),
(6, 47, 'catchup'),
(6, 102, 'catchup_content'),
(6, 49, 'catchup'),
(6, 104, 'catchup_content'),
(6, 48, 'catchup'),
(6, 103, 'catchup_content'),
(2, 25, 'catchup'),
(6, 1, 'videos'),
(6, 1, 'videos_content'),
(6, 2, 'videos'),
(6, 2, 'videos_content'),
(6, 3, 'videos_content'),
(6, 4, 'videos_content');

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `model_tag`
--
ALTER TABLE `model_tag`
  ADD CONSTRAINT `model_tag_tag_id_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
