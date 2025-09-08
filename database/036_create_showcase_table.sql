-- phpMyAdmin SQL Dump
-- version 4.0.10.20
-- https://www.phpmyadmin.net
--
-- Inang: 10.0.1.60
-- Waktu pembuatan: 08 Sep 2025 pada 14.21
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
-- Struktur dari tabel `showcase`
--

CREATE TABLE IF NOT EXISTS `showcase` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(500) NOT NULL,
  `detail_url` varchar(500) NOT NULL,
  `category_id` varchar(300) NOT NULL,
  `poster_url` varchar(500) NOT NULL,
  `poster_type` varchar(50) NOT NULL,
  `order_number` varchar(250) NOT NULL,
  `barcode_url` varchar(255) DEFAULT NULL,
  `visible` enum('N','Y') NOT NULL DEFAULT 'Y',
  `active` enum('N','Y') NOT NULL DEFAULT 'Y',
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `sort` varchar(50) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `created_by` varchar(250) NOT NULL,
  `ctrloc` varchar(500) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=72 ;

--
-- Dumping data untuk tabel `showcase`
--

INSERT INTO `showcase` (`id`, `title`, `detail_url`, `category_id`, `poster_url`, `poster_type`, `order_number`, `barcode_url`, `visible`, `active`, `start_date`, `end_date`, `sort`, `created_at`, `created_by`, `ctrloc`) VALUES
(18, 'CBN Fiber', 'http://stage.dens.tv', '1', 'http://showcase.dens.tv/assets/images/c4510f587efa7e3e74231fab2119728f.jpg', '1280x720', '', NULL, 'N', 'N', '2022-11-07', '2023-12-07', NULL, '2022-11-07 08:11:05', '', '/showcase/showcase/insert_showcase'),
(19, 'Router Vaganza', 'http://stage.dens.tv', '1', 'http://showcase.dens.tv/assets/images/00b519d1787d33d328b8c30edf3e0f65.jpg', '1280x720', '', NULL, 'Y', 'N', '2022-11-07', '2023-12-07', NULL, '2022-11-07 08:18:27', '', '/showcase/showcase/insert_showcase'),
(20, 'Special Collaboration', 'http://stage.dens.tv', '1', 'http://showcase.dens.tv/assets/images/2fda6aafe349e06a5dc81aef10dac2f6.jpg', '1280x720', '', NULL, 'Y', 'N', '2022-11-07', '2023-12-07', NULL, '2022-11-07 08:19:26', '', '/showcase/showcase/insert_showcase'),
(21, '9.9 Lazada', 'http://stage.dens.tv', '2', 'http://showcase.dens.tv/assets/images/0a1b4df8c22ba690dbc6366b4872558c.png', '1280x720', '', 'https://me-qr.com/ueqbE8aw', 'N', 'N', '2022-11-07', '2023-12-07', NULL, '2022-11-07 08:30:48', '', '/showcase/showcase/insert_showcase'),
(22, 'Imaginers', 'http://stage.dens.tv', '2', 'http://showcase.dens.tv/assets/images/da6072af2dea4e676cde5976ff438937.jpeg', '1280x720', '', NULL, 'Y', 'N', '2022-11-07', '2023-12-07', NULL, '2022-11-07 08:32:07', '', '/showcase/showcase/insert_showcase'),
(23, 'Imaginers 2', 'http://stage.dens.tv', '2', 'http://showcase.dens.tv/assets/images/6df872cb79513be64421bc1808f502f4.jpeg', '1280x720', '', NULL, 'Y', 'N', '2022-11-07', '2023-12-07', NULL, '2022-11-07 08:33:15', '', '/showcase/showcase/insert_showcase'),
(24, 'MARHENJ New Launch Product', 'http://stage.dens.tv', '2', 'http://showcase.dens.tv/assets/images/225f35f0c75a1675418d3034ce15768d.jpg', '1280x720', '', NULL, 'Y', 'Y', '2022-11-07', '2023-12-07', '1', '2022-11-07 08:34:49', '', '/showcase/showcase/insert_showcase'),
(25, 'Tech Tuesday Lazada', 'http://stage.dens.tv', '2', 'http://showcase.dens.tv/assets/images/f36b391e3ad60a42a688908c05ba8ef6.png', '1280x720', '', 'www.dens.tv', 'Y', 'Y', '2022-11-07', '2023-12-07', '1', '2022-11-07 08:35:30', '', '/showcase/showcase/insert_showcase'),
(26, 'Banner Promo Short TV', 'http://stage.dens.tv', '2', 'http://showcase.dens.tv/assets/images/7e22c38c8d55521256f10d07aeb50c1f.jpg', '1280x720', '', NULL, 'Y', 'Y', '2022-11-07', '2023-11-07', '1', '2022-11-07 08:37:04', '', '/showcase/showcase/insert_showcase'),
(27, 'Ngemall Aman dari Rumah', 'http://stage.dens.tv', '2', 'http://showcase.dens.tv/assets/images/dcc2dccca061a0f7659d8e10e0b2c396.jpg', '1280x720', '', NULL, 'Y', 'N', '2022-11-07', '2023-12-07', NULL, '2022-11-07 08:37:52', '', '/showcase/showcase/insert_showcase'),
(28, 'Motor Vision TV', 'http://stage.dens.tv', '2', 'http://showcase.dens.tv/assets/images/1c74b85be83553aed2f819e97be01e86.jpg', '1280x720', '', NULL, 'Y', 'Y', '2022-11-07', '2023-12-07', '1', '2022-11-07 08:39:57', '', '/showcase/showcase/insert_showcase'),
(29, 'DensTV Europhia', 'http://stage.dens.tv', '2', 'http://showcase.dens.tv/assets/images/b2c9e25628a8b7fe2c77de1974bcf3ef.jpg', '1280x720', '', NULL, 'Y', 'Y', '2022-11-07', '2023-12-07', '1', '2022-11-07 08:40:54', '', '/showcase/showcase/insert_showcase'),
(30, 'Flazz Promo', '', '3', 'http://showcase.dens.tv/assets/images/e4d195ce4741e41802254806ffb9d7b9.jpg', '1280x720', '', '', 'Y', 'Y', '2023-08-08', '2025-12-31', '4', '2023-08-08 16:26:37', 'superadmin', '/showcase/showcase/update_showcase'),
(31, 'Red & White Wonderland', '', '3', 'http://showcase.dens.tv/assets/images/4bfaa767b2d559783d6a350cb37ddfa4.jpg', '1280x720', '', 'https://me-qr.com/59W5Igx8', 'N', 'N', '2023-08-08', '2023-09-30', NULL, '2023-08-08 16:30:52', 'superadmin', '/showcase/showcase/insert_showcase'),
(32, 'DensPlay Game Key', '', '3', 'http://showcase.dens.tv/assets/images/6e16f166bc17a19d07e9bbe98b6ba975.jpg', '1280x720', '', 'https://shopee.co.id/densplaystore', 'Y', 'Y', '2023-08-08', '2025-12-31', '6', '2023-08-08 16:37:18', 'superadmin', '/showcase/showcase/update_showcase'),
(33, 'Biomeek', '', '3', 'http://showcase.dens.tv/assets/images/3822d1b9c4fc66c53fe71131d035cdcb.jpg', '1280x720', '', 'https://me-qr.com/n1m3l2HC', 'N', 'N', '2023-08-08', '2023-09-30', NULL, '2023-08-08 16:39:29', 'superadmin', '/showcase/showcase/insert_showcase'),
(34, 'Century Recipes', '', '3', 'http://showcase.dens.tv/assets/images/6a76433da0036ba300fe40b463521a03.jpg', '1280x720', '', 'https://me-qr.com/UiMcfYEG', 'N', 'N', '2023-08-08', '2023-09-30', NULL, '2023-08-08 16:41:21', 'superadmin', '/showcase/showcase/insert_showcase'),
(35, 'Shorts TV', '', '3', 'http://showcase.dens.tv/assets/images/94fcf1a030ea881e4d318dd68d460722.jpg', '1280x720', '', 'https://dens.tv/packages/step/01/0', 'N', 'N', '2023-08-08', '2025-12-31', NULL, '2023-08-08 16:42:46', 'superadmin', '/showcase/showcase/update_showcase'),
(36, 'Motorvision.TV', '', '3', 'http://showcase.dens.tv/assets/images/0464a092f8bb5609568bcf2933b139c1.jpg', '1280x720', '', 'https://dens.tv/packages/step/01/0', 'N', 'N', '2023-08-08', '2025-12-31', NULL, '2023-08-08 16:44:31', 'superadmin', '/showcase/showcase/update_showcase'),
(37, 'Gold Energy', '', '3', 'http://showcase.dens.tv/assets/images/d37dd2b9a48d210973df576184752a8e.jpg', '1280x720', '', 'https://me-qr.com/5UkXIVnA', 'N', 'N', '2023-08-08', '2023-09-30', NULL, '2023-08-08 16:45:57', 'superadmin', '/showcase/showcase/update_showcase'),
(38, 'Gluire', '', '3', 'http://showcase.dens.tv/assets/images/94c2e39457c3f11d6c538c456d9fa45e.jpg', '1280x720', '', 'https://me-qr.com/QsRVfg50', 'N', 'N', '2023-08-08', '2023-09-30', NULL, '2023-08-08 16:48:08', 'superadmin', '/showcase/showcase/update_showcase'),
(39, 'Hot Beauty Trends', '', '3', 'http://showcase.dens.tv/assets/images/0792439d29a4ca021483215696743f51.jpg', '1280x720', '', 'https://me-qr.com/2iMu8RrB', 'N', 'N', '2023-08-08', '2023-09-30', NULL, '2023-08-08 16:49:59', 'superadmin', '/showcase/showcase/insert_showcase'),
(40, 'Imanginers', '', '3', 'http://showcase.dens.tv/assets/images/53f1d5794e8e0a600157d3c38f42ba72.jpeg', '1280x720', '', 'https://www.tokopedia.com/imanginers', 'Y', 'Y', '2023-08-08', '2025-12-31', '5', '2023-08-08 16:52:57', 'superadmin', '/showcase/showcase/update_showcase'),
(41, 'Jin Jung Sung', '', '3', 'http://showcase.dens.tv/assets/images/bda25f4a075e9fda407bef5123e2b429.jpg', '1280x720', '', 'https://m.istyle.id/promo-korean-beauty-secret-000000165954', 'N', 'N', '2023-08-15', '2023-09-15', NULL, '2023-08-15 14:01:02', 'admin', '/showcase/showcase/insert_showcase'),
(42, 'Jin Jung Sung', '', '3', 'http://showcase.dens.tv/assets/images/bda25f4a075e9fda407bef5123e2b429.jpg', '1280x720', '', 'https://m.istyle.id/promo-korean-beauty-secret-000000165954', 'N', 'N', '2023-08-15', '2023-09-15', NULL, '2023-08-15 14:01:05', 'admin', '/showcase/showcase/insert_showcase'),
(43, 'Jin Jung Sung', '', '3', 'http://showcase.dens.tv/assets/images/bda25f4a075e9fda407bef5123e2b429.jpg', '1280x720', '', 'https://m.istyle.id/promo-korean-beauty-secret-000000165954', 'N', 'N', '2023-08-15', '2023-09-15', NULL, '2023-08-15 14:01:10', 'admin', '/showcase/showcase/insert_showcase'),
(44, 'FINI', '', '3', 'http://showcase.dens.tv/assets/images/1d36ecb5832c613cc8fc812bbdd3cc63.jpg', '1280x720', '', 'https://m.istyle.id/promo-juicylicious-everyday-fini-000000165955', 'N', 'N', '2023-08-15', '2023-09-15', NULL, '2023-08-15 14:09:54', 'admin', '/showcase/showcase/insert_showcase'),
(45, 'EVERYTHING AT 9', '', '3', 'http://showcase.dens.tv/assets/images/0f118a427f68e234da16391314a3c278.jpg', '1280x720', '', 'https://www.istyle.id/promo-everything-at-9-000000166573', 'N', 'N', '2023-09-01', '2023-09-30', NULL, '2023-09-07 18:48:10', 'superadmin', '/showcase/showcase/insert_showcase'),
(46, 'KOTRA - DISCOVER YOUR HEALTHY & BEAUTIFUL SKINS', '', '3', 'http://showcase.dens.tv/assets/images/5421fdbc09c8e87fe8ca061fca29d82b.jpg', '1280x720', '', 'https://www.istyle.id/promo-kotra-discover-your-healthy-beautiful-skins-000000166571', 'N', 'N', '2023-09-01', '2023-09-30', NULL, '2023-09-07 18:51:19', 'superadmin', '/showcase/showcase/insert_showcase'),
(47, 'JIGOTT', '', '3', 'http://showcase.dens.tv/assets/images/bee5bb7bfab34d1feffe6154b1a321a1.jpg', '1280x720', '', 'https://www.istyle.id/promo-jigott-fallen-with-perfect-you-000000166534', 'N', 'N', '2023-09-01', '2023-09-30', NULL, '2023-09-07 18:53:21', 'superadmin', '/showcase/showcase/insert_showcase'),
(48, 'I''m Unau', '', '3', 'http://showcase.dens.tv/assets/images/df0ed8f29dc83273a09429efbf3d6a0e.jpg', '1280x720', '', 'https://bit.ly/3ZVlcL7', 'Y', 'N', '2023-10-01', '2023-11-01', NULL, '2023-10-03 10:34:36', 'admin', '/showcase/showcase/update_showcase'),
(49, 'Sermo', '', '3', 'http://showcase.dens.tv/assets/images/40997cd92823d9d6154715e7dc2d9181.jpg', '1280x720', '', 'https://bit.ly/3Qf2c72', 'Y', 'N', '2023-10-01', '2023-11-01', NULL, '2023-10-03 10:39:47', 'admin', '/showcase/showcase/update_showcase'),
(50, 'Amazing Korean Festive', '', '3', 'http://showcase.dens.tv/assets/images/e8dea9828dcdaaadee9bf70943c47e8e.jpg', '1280x720', '', 'https://bit.ly/46Qejx5', 'N', 'N', '2023-10-01', '2023-11-01', NULL, '2023-10-03 10:42:57', 'admin', '/showcase/showcase/update_showcase'),
(51, 'Carin & New Jeans', '', '3', 'http://showcase.dens.tv/assets/images/6a3337fb1d4409677b122df7aad51edc.jpg', '1280x720', '', 'https://bit.ly/3ttPwR5', 'Y', 'N', '2023-10-10', '2023-11-01', NULL, '2023-10-10 10:09:56', 'admin', '/showcase/showcase/update_showcase'),
(52, 'Homerose', '', '3', 'http://showcase.dens.tv/assets/images/2ee40a58c4528efcad4f49117622ec74.jpg', '1280x720', '', 'https://bit.ly/3ZWlilV', 'Y', 'N', '2023-10-15', '2023-11-16', NULL, '2023-10-13 16:11:07', 'admin', '/showcase/showcase/update_showcase'),
(53, 'Carin', '', '3', 'http://showcase.dens.tv/assets/images/152ad0982fb1b317a61cc8a16fd905d8.jpg', '1280x720', '', 'https://bit.ly/49m7qWo', 'Y', 'N', '2023-11-03', '2023-12-01', NULL, '2023-11-03 09:50:50', 'admin', '/showcase/showcase/insert_showcase'),
(54, 'KCII', '', '3', 'http://showcase.dens.tv/assets/images/347519863200cd08f2ad22284c709d62.jpg', '1280x720', '', 'https://bit.ly/40lSy64', 'Y', 'N', '2023-11-15', '2023-12-01', NULL, '2023-11-03 09:54:02', 'admin', '/showcase/showcase/update_showcase'),
(55, 'Pime November', '', '3', 'http://showcase.dens.tv/assets/images/83ed54ccae76077059c81005bf1e8675.jpg', '1280x720', '', 'https://bit.ly/3Spn5Ok', 'Y', 'N', '2023-11-07', '2023-12-01', NULL, '2023-11-03 09:58:20', 'admin', '/showcase/showcase/update_showcase'),
(56, 'Qyou-Qyou', '', '3', 'http://showcase.dens.tv/assets/images/20a7d3c378fe2f54aed498a003669ed3.jpg', '1280x720', '', 'https://bit.ly/3SFkyzL', 'Y', 'N', '2023-11-15', '2023-12-16', NULL, '2023-11-14 13:39:15', 'admin', '/showcase/showcase/update_showcase'),
(57, 'Pasar Game', '', '3', 'http://showcase.dens.tv/assets/images/8e5404e9dfaad16b862741989a3106de.jpg', '1280x720', '', 'https://bit.ly/46SoWif', 'Y', 'N', '2023-12-11', '2023-12-17', NULL, '2023-12-11 17:19:42', 'admin', '/showcase/showcase/update_showcase'),
(58, 'Pasar Games December', '', '3', 'http://showcase.dens.tv/assets/images/504eb5ad1b77f721644f78be150e200b.jpg', '1280x720', '', 'https://bit.ly/47cFP7A', 'Y', 'N', '2023-12-20', '2024-01-01', NULL, '2023-12-20 18:05:42', 'admin', '/showcase/showcase/insert_showcase'),
(59, 'Promo 20ribu', '', '3', 'http://showcase.dens.tv/assets/images/f6e0151aaea38bdce9c71a9e11c65e54.jpg', '1280x720', '', 'https://bit.ly/3S6HCFP', 'N', 'N', '2024-01-24', '2024-03-01', NULL, '2024-01-24 11:22:19', 'admin', '/showcase/showcase/update_showcase'),
(60, 'Promo Disc 20%', '', '3', 'http://showcase.dens.tv/assets/images/67a117225d9bec443d46db6c19d21271.jpg', '1280x720', '', 'https://bit.ly/42gZPVN', 'Y', 'N', '2024-01-24', '2024-03-01', NULL, '2024-01-24 11:23:27', 'admin', '/showcase/showcase/update_showcase'),
(61, 'Steam Wallet Promo 5%', '', '3', 'http://showcase.dens.tv/assets/images/c27a7f12ec913f4941a1a3edffae0a7d.jpg', '1280x720', '', 'https://bit.ly/3u33w4H', 'Y', 'N', '2024-01-24', '2024-03-01', NULL, '2024-01-24 11:24:39', 'admin', '/showcase/showcase/update_showcase'),
(62, 'The Sounds Project', '', '3', 'http://showcase.dens.tv/assets/images/02a1b83cdbd486aed087c85b661d4d04.jpg', '1280x720', '', 'https://megatix.co.id/events/TSP7', 'N', 'N', '2024-07-12', '2024-08-11', NULL, '2024-07-12 09:05:03', 'admin', '/showcase/showcase/insert_showcase'),
(63, 'IGX : Indonesia Game Expo 2024', '', '3', 'http://showcase.dens.tv/assets/images/9971b61281798e51817e9b3c1b692a60.jpg', '1280x720', '', '', 'Y', 'N', '2024-10-19', '2024-10-28', NULL, '2024-10-17 16:06:55', 'admin', '/showcase/showcase/update_showcase'),
(64, 'IDE : Indonesia Diecast Expo 2024', '', '3', 'http://showcase.dens.tv/assets/images/bdda97ba4001e6385f9f46c9d806a34d.jpg', '1280x720', '', 'https://www.instagram.com/indonesiadiecastexpo?igsh=MTBsYmxkZHZpeGM0Zw== ', 'Y', 'N', '2024-10-19', '2024-10-28', NULL, '2024-10-17 16:25:32', 'admin', '/showcase/showcase/insert_showcase'),
(65, 'Predator League 2024', '', '3', 'http://showcase.dens.tv/assets/images/4ea6f78821016014b7376c082b3fe372.jpg', '1280x720', '', 'https://predator-league.com/', 'N', 'N', '2024-11-02', '2024-11-10', NULL, '2024-11-01 14:08:58', 'admin', '/showcase/showcase/insert_showcase'),
(66, 'Kayan Indonesia Kita Putra Sang Maestro', '', '3', 'http://showcase.dens.tv/assets/images/e59274cf08ed45b6f98b74a7bb526371.jpg', '1280x720', '', 'https://www.kayan.co.id ', 'Y', 'N', '2024-11-19', '2024-11-20', NULL, '2024-11-08 17:36:17', 'admin', '/showcase/showcase/update_showcase'),
(67, 'High School Fest', '', '3', 'http://showcase.dens.tv/assets/images/05e826faf752f7a6f6891dac7bb0095e.jpg', '1280x720', '', 'https://www.goersapp.com/events/schedules/high-school-festival-2024--hsf2024/2024-11-23', 'Y', 'Y', '2024-11-15', '2024-11-23', '1', '2024-11-15 16:42:32', 'admin', '/showcase/showcase/insert_showcase'),
(68, 'Lapak Gaming', '', '3', 'http://showcase.dens.tv/assets/images/4cccb8e675802724c584887014c8266d.jpg', '1280x720', '', 'https://www.tix.id/ ', 'Y', 'Y', '2024-11-24', '2024-12-01', '1', '2024-11-22 13:48:14', 'admin', '/showcase/showcase/insert_showcase'),
(69, ' Indonesia Game Festival', '', '3', 'http://showcase.dens.tv/assets/images/aba20576ef412265f25c35979d49e5f7.jpg', '1280x720', '', 'https://bit.ly/igf-evos', 'Y', 'Y', '2024-12-03', '2024-12-08', '1', '2024-12-03 16:23:22', 'admin', '/showcase/showcase/insert_showcase'),
(70, ' Big Bang Festival', '', '3', 'http://showcase.dens.tv/assets/images/d2931f681a11cbe2a4e1fb11fcd2802b.jpg', '1280x720', '', 'https://bbo.co.id/jual/bbj2024', 'Y', 'Y', '2024-12-14', '2025-01-02', '1', '2024-12-23 10:14:50', 'admin', '/showcase/showcase/update_showcase'),
(71, 'Sparkling Ramadan', '', '3', 'http://showcase.dens.tv/assets/images/1d475715b0d0e38c2053827eb32077e3.jpg', '1280x720', '', 'www.oktix.co.id', 'Y', 'Y', '2025-03-18', '2025-03-24', '1', '2025-03-18 15:50:27', 'admin', '/showcase/showcase/insert_showcase');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
