-- phpMyAdmin SQL Dump
-- version 4.0.10.20
-- https://www.phpmyadmin.net
--
-- Inang: 10.0.1.60
-- Waktu pembuatan: 16 Nov 2026 pada 14.13
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
-- Struktur dari tabel `list_payment`
--

CREATE TABLE IF NOT EXISTS `list_payment` (
  `payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `payment_title` varchar(255) NOT NULL,
  `payment_description` text NOT NULL,
  `payment_image` varchar(255) NOT NULL,
  `payment_channel` varchar(50) NOT NULL,
  `payment_category` varchar(255) NOT NULL,
  `api_url` varchar(255) NOT NULL,
  `api_url_status` varchar(255) NOT NULL,
  `admin_fee` varchar(50) NOT NULL,
  `admin_fee_type` enum('percent','nominal') NOT NULL DEFAULT 'nominal',
  `bank_code` varchar(50) DEFAULT NULL,
  `sort` varchar(50) NOT NULL,
  `visible` enum('Y','N') NOT NULL DEFAULT 'N',
  `create_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `update_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ctrloc` varchar(255) NOT NULL,
  PRIMARY KEY (`payment_id`),
  KEY `payment_channel` (`payment_channel`),
  KEY `visible` (`visible`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data untuk tabel `list_payment`
--

INSERT INTO `list_payment` (`payment_id`, `payment_title`, `payment_description`, `payment_image`, `payment_channel`, `payment_category`, `api_url`, `api_url_status`, `admin_fee`, `admin_fee_type`, `bank_code`, `sort`, `visible`, `create_date`, `update_date`, `ctrloc`) VALUES
(1, 'QRIS by OttoPay', '', 'https://picture.dens.tv/wp/img/paymentch_v1/ottopay.png', '07', '1', 'https://payment.dens.tv/index.php/otto/transaction/', 'https://payment.dens.tv/index.php/otto/status/', '0.7', 'percent', NULL, '1', 'Y', '2022-07-19 22:59:01', '2024-06-25 08:34:05', '/payment/list_payment_v2/update_payment'),
(2, 'KASPRO', '', 'https://picture.dens.tv/wp/img/paymentch_v1/200x100/1658247325_paymentch_v1.png', '08', '2', 'https://payment.dens.tv/index.php/kaspro/transaction/transaction_payment', '', '', 'nominal', NULL, '', 'N', '2022-07-19 23:11:28', '2024-05-02 08:41:07', '/payment/list_payment_v2/inactivated_payment'),
(3, 'Virtual Account', '', 'https://picture.dens.tv/wp/img/paymentch_v1/10000x535/thumbnail/1714620104_paymentch_v1.png', '02', '3', 'http://10.0.1.21:80/adaptera.dens.tv/web/index.php/v2020/h02_coupon_prima_v1/index', '', '5500', 'nominal', NULL, '', 'N', '2022-07-19 23:23:14', '2024-05-07 11:15:59', '/payment/list_payment_v2/inactivated_payment'),
(4, 'Credit Card', '', 'https://picture.dens.tv/wp/img/paymentch_v1/cc.png', '04015', '4', 'https://payment.dens.tv/index.php/DOKU/Adp_gen_orders_v1/index', '', '2.6', 'percent', '', '6', 'Y', '2022-07-19 23:40:42', '2024-06-25 08:33:07', '/payment/list_payment_v2/update_payment'),
(5, 'BCA KlikPay', '', 'https://picture.dens.tv/wp/img/paymentch_v1/200x100/1658250853_paymentch_v1.png', '04018', '5', '', '', '', 'nominal', NULL, '', 'N', '2022-07-20 00:05:16', '2024-05-02 08:41:28', '/payment/list_payment_v2/inactivated_payment'),
(6, 'Doku Wallet', '', 'https://picture.dens.tv/wp/img/paymentch_v1/200x100/1658250895_paymentch_v1.png', '04004', '5', '', '', '', 'nominal', NULL, '', 'N', '2022-07-20 00:05:58', '2024-05-02 08:41:34', '/payment/list_payment_v2/inactivated_payment'),
(7, 'DANA', '', 'https://picture.dens.tv/wp/img/paymentch_v1/200x100/1658250971_paymentch_v1.png', '06', '5', '', '', '', 'nominal', NULL, '', 'N', '2022-07-20 00:07:16', '2024-05-02 08:41:46', '/payment/list_payment_v2/inactivated_payment'),
(8, 'IBI Danamon', '', 'https://picture.dens.tv/wp/img/paymentch_v1/200x100/1658251018_paymentch_v1.png', '04026', '5', '', '', '', 'nominal', NULL, '', 'N', '2022-07-20 00:08:01', '2024-05-02 08:41:55', '/payment/list_payment_v2/inactivated_payment'),
(9, 'Permata Net', '', 'https://picture.dens.tv/wp/img/paymentch_v1/200x100/1658251068_paymentch_v1.png', '04028', '5', '', '', '', 'nominal', NULL, '', 'N', '2022-07-20 00:08:50', '2024-05-02 08:42:03', '/payment/list_payment_v2/inactivated_payment'),
(10, 'Indomaret', '', 'https://picture.dens.tv/wp/img/paymentch_v1/200x100/1658251349_paymentch_v1.png', '05', '6', '', '', '', 'nominal', NULL, '', 'N', '2022-07-20 00:13:32', '2024-05-02 08:42:16', '/payment/list_payment_v2/inactivated_payment'),
(11, 'Alfamart', '', 'https://picture.dens.tv/wp/img/paymentch_v1/200x100/1658251395_paymentch_v1.png', '04035', '6', '', '', '', 'nominal', NULL, '', 'N', '2022-07-20 00:14:19', '2024-05-02 08:42:28', '/payment/list_payment_v2/inactivated_payment'),
(12, 'test payment 1', '', 'https://picture.dens.tv/wp/img/paymentch_v1/200x100/ccexist.png', '', '', 'domain', '', '2500', 'nominal', NULL, '', 'N', '2024-04-30 14:20:40', '2024-04-30 07:20:40', '/payment/list_payment_v2/insert_payment'),
(13, 'test payment 2', '', 'https://picture.dens.tv/wp/img/paymentch_v1/200x100/Credit Card.png', '', '', 'domaintransaction', 'domainstatus', '0.75', 'percent', NULL, '', 'N', '2024-04-30 14:23:35', '2024-04-30 07:23:35', '/payment/list_payment_v2/insert_payment'),
(14, 'BCA VA', '', 'https://picture.dens.tv/wp/img/paymentch_v1/bca.png', '02', '', 'http://10.0.1.21:80/adaptera.dens.tv/web/index.php/v2020/h02_coupon_prima_v1/index', '', '5000', 'nominal', '10063', '2', 'Y', '2024-05-07 18:18:41', '2024-06-25 08:18:44', '/payment/list_payment_v2/update_payment'),
(15, 'Mandiri VA', '', 'https://picture.dens.tv/wp/img/paymentch_v1/mandiri.png', '02', '', 'http://10.0.1.21:80/adaptera.dens.tv/web/index.php/v2020/h02_coupon_prima_v1/index', '', '5500', 'nominal', '50120', '3', 'Y', '2024-05-07 18:19:57', '2024-06-25 08:19:04', '/payment/list_payment_v2/update_payment'),
(16, 'KB Bukopin VA', '', 'https://picture.dens.tv/wp/img/paymentch_v1/bukopin.png', '02', '', 'http://10.0.1.21:80/adaptera.dens.tv/web/index.php/v2020/h02_coupon_prima_v1/index', '', '5500', 'nominal', '10063', '4', 'Y', '2024-05-07 18:21:03', '2024-06-25 08:19:16', '/payment/list_payment_v2/update_payment'),
(17, 'CIMB VA', '', 'https://picture.dens.tv/wp/img/paymentch_v1/cimb.png', '02', '', 'http://10.0.1.21:80/adaptera.dens.tv/web/index.php/v2020/h02_coupon_prima_v1/index', '', '5500', 'nominal', '', '5', 'Y', '2024-05-07 18:21:56', '2024-06-25 08:19:28', '/payment/list_payment_v2/update_payment');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
