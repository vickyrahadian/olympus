-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 24, 2014 at 10:25 PM
-- Server version: 5.6.16
-- PHP Version: 5.5.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `olympus`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE IF NOT EXISTS `barang` (
  `id_barang` int(11) NOT NULL AUTO_INCREMENT,
  `kode` varchar(32) NOT NULL,
  `barcode` varchar(25) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `harga_ecer` double NOT NULL,
  `stok_terjual` int(11) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `id_satuan` int(11) NOT NULL,
  `harga_beli` int(11) NOT NULL DEFAULT '0',
  `stok` int(11) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL,
  `createddate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdby` int(11) NOT NULL,
  `updateddate` timestamp NULL DEFAULT NULL,
  `updatedby` int(11) DEFAULT NULL,
  `gambar` varchar(100) NOT NULL,
  PRIMARY KEY (`id_barang`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=245 ;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id_barang`, `kode`, `barcode`, `nama`, `harga_ecer`, `stok_terjual`, `id_kategori`, `id_satuan`, `harga_beli`, `stok`, `status`, `createddate`, `createdby`, `updateddate`, `updatedby`, `gambar`) VALUES
(55, 'ALAT0002', '9584738273849384', 'Waterpass 60 Cm', 25000, 0, 37, 2, 0, 0, 1, '2014-02-13 02:06:30', 0, NULL, 0, 'admin-75e6cc3837583727e23fe3464348090e.jpg'),
(56, 'ALAT0001', '8787364536273827', 'Meteran Oni 5 Meter', 15000, 0, 37, 2, 0, 0, 1, '2014-02-13 02:06:59', 0, NULL, 0, 'admin-3e6ae94916d40b75efba325ef8d712ed.jpg'),
(57, 'BENA0001', '9827355672635267', 'Benang Warna Putih', 2500, 0, 38, 2, 1000, 1000, 1, '2014-02-13 02:07:54', 0, '2014-06-30 01:35:47', 1, 'admin-c6c3d27683bea5202a216deb9efb0124.jpg'),
(58, 'BENA0007', '5658523212585632', 'Benang Warna Cokelat', 2500, 0, 38, 2, 1000, 1000, 1, '2014-02-13 02:08:22', 0, '2014-03-15 20:32:41', 1, 'admin-e33b24b458b9eedf04d7f4312fb23a1b.jpg'),
(59, 'BENA0010', '8372637625361723', 'Benang Bangunan', 2500, 0, 38, 2, 800, 998, 1, '2014-02-13 02:08:53', 0, '2014-03-15 23:08:57', 1, 'admin-7c5210f608714b48b6862a781b8304bf.jpg'),
(60, 'DRAW0001', '1213432345342464', 'Rel Laci / Drawer Runner 60cm', 28000, 0, 39, 2, 0, 0, 1, '2014-02-14 01:50:58', 0, '2014-02-14 01:52:38', 0, 'admin-170a52bba30f8770e8278febd2e19d0d.jpg'),
(61, 'DRAW0008', '6445223347120111', 'Rel Laci / Drawer Runner 50cm', 26000, 0, 39, 2, 0, 0, 1, '2014-02-14 09:18:28', 0, '2014-03-20 02:55:47', 1, 'admin-68d1f303ab34281e63a321ab5b43d0c6.jpg'),
(63, 'DRAW0003', '6445223347120079', 'Rel Laci / Drawer Runner 45cm', 24000, 0, 39, 2, 0, 0, 1, '2014-02-27 00:05:45', 0, NULL, 0, 'admin-0b9e027d4c64fe6d896727aaab87cad2.jpg'),
(64, 'DRAW0004', '7620039740900477', 'Rel Laci / Drawer Runner 40cm', 22000, 0, 39, 2, 0, 0, 1, '2014-02-27 00:06:45', 0, NULL, 0, 'admin-5ec45f16aa49eda0b7793fe88647af1d.jpg'),
(65, 'DRAW0005', '4191393538763343', 'Rel Laci / Drawer Runner 35cm', 20000, 0, 39, 2, 0, 0, 1, '2014-02-27 00:07:12', 0, NULL, 0, 'admin-7037a86e95be31f0a79a72206c9bca66.jpg'),
(66, 'DRAW0006', '1333855963726213', 'Rel Laci / Drawer Runner 30cm', 18000, 0, 39, 2, 0, 0, 1, '2014-02-27 00:07:39', 0, NULL, 0, 'admin-1c0ccf647bf357bac5b1235a7171a2db.jpg'),
(67, 'DRAW0007', '8897836931090860', 'Rel Laci / Drawer Runner 25cm', 15000, 0, 39, 2, 0, 0, 1, '2014-02-27 00:08:03', 0, NULL, 0, 'admin-96087d2d38580f09ac00c519d7179c64.jpg'),
(68, 'GEMB0010', '9414929389233309', 'Gembok Shengji 40mm', 25000, 0, 40, 2, 0, 0, 1, '2014-02-27 00:09:30', 0, '2014-03-15 20:26:29', 1, 'admin-5ef0e328b4e37b19eb70ec6d0f6a163c.jpg'),
(69, 'GEMB0002', '2280720751419202', 'Gembok Hunter 60mml Panjang', 40000, 0, 40, 2, 0, 0, 1, '2014-02-27 00:10:08', 0, NULL, 0, 'admin-57c7d4fe66814936898a1d394c0f587b.jpg'),
(70, 'GEMB0003', '7864405181822565', 'Gembok Hunter 60mm', 30000, 0, 40, 2, 0, 0, 1, '2014-02-27 00:10:34', 0, NULL, 0, 'admin-465015a21af82daa396e072a7e09d15c.jpg'),
(71, 'GEMB0004', '1828188519753081', 'Gembok Exito 50mm', 20000, 0, 40, 2, 0, 0, 1, '2014-02-27 00:11:01', 0, NULL, 0, 'admin-0750ae16fbb05c1ceaba9e82600c19ef.jpg'),
(72, 'GEMB0005', '8187565033110547', 'Gembok Exito 40mm', 15000, 0, 40, 2, 0, 0, 1, '2014-02-27 00:11:24', 0, NULL, 0, 'admin-849985d5f0bdb76883b30a432acc40a9.jpg'),
(73, 'GEMB0006', '6743759674085103', 'Gembok Exito 30mm', 10000, 0, 40, 2, 0, 0, 1, '2014-02-27 00:11:50', 0, NULL, 0, 'admin-c9eec725ee5deb860641ce0fc5460e52.jpg'),
(74, 'GEMB0008', '4895037460268757', 'Gembok Exito 20mm / Gembok Koper', 7000, 0, 40, 2, 0, 0, 1, '2014-02-27 00:12:11', 0, '2014-02-27 00:12:24', 0, 'admin-1836409704db3713bacb58bd0f18644b.jpg'),
(75, 'HELM0001', '7440002806745899', 'Helm Proyek', 25000, 0, 41, 2, 0, 0, 1, '2014-02-27 00:14:20', 0, NULL, 0, 'admin-f03b49e7a755709ce71c34e746cd5e7c.jpg'),
(76, 'KABE0017', '4288142400239119', 'Sigma Ties Cs100 10cm', 50000, 0, 42, 41, 0, 0, 1, '2014-02-27 00:16:12', 0, '2014-03-09 12:33:11', 0, 'admin-8c572bb1da48c854721b47b6f6b4c231.jpg'),
(77, 'KABE0015', '6274785796713166', 'Sigma Ties Cs - 200l 20cm', 30000, 0, 42, 41, 0, 0, 1, '2014-02-27 00:16:40', 0, '2014-03-09 12:32:54', 0, 'admin-3fba8584e8bbde24bd7cfe672020d1b7.jpg'),
(78, 'KABE0016', '7064145166301030', 'Sigma Ties Cs - 390l (bungkus)', 65000, 0, 42, 41, 0, 0, 1, '2014-02-27 00:17:29', 0, '2014-03-09 12:33:05', 0, 'admin-daa9e735ad73fc92c4d421463a81ec26.jpg'),
(79, 'KABE0014', '3524355885387137', 'Nylon Cable Tie 20cm', 25000, 0, 42, 41, 0, 0, 1, '2014-02-27 00:17:53', 0, '2014-03-09 12:32:48', 0, 'admin-d8cfacbc14eebe3ef2660edbbb97f386.jpg'),
(80, 'KABE0013', '6451753686168474', 'Nylon Cable Tie 15cm', 15000, 0, 42, 41, 0, 0, 1, '2014-02-27 00:18:17', 0, '2014-03-09 12:32:42', 0, 'admin-88f477b3e1368f5db321d1d4a637878a.jpg'),
(81, 'KABE0012', '7202073360139746', 'Nylon Cable Tie 10cm', 7500, 0, 42, 41, 0, 0, 1, '2014-02-27 00:18:41', 0, '2014-03-09 12:32:33', 0, 'admin-4b5650839998909c0c82f40a7a4e3928.jpg'),
(82, 'KABE0011', '6798742890202979', 'Harden Cable Tie Hitam 15cm (bungkus)', 10000, 0, 42, 41, 0, 0, 1, '2014-02-27 00:19:07', 0, '2014-03-09 12:32:21', 0, 'admin-4dcf4885d3c91c16817908787bc69b41.jpg'),
(83, 'KABE0010', '9051220548543589', 'Harden Cable Tie 30cm', 25000, 0, 42, 41, 0, 0, 1, '2014-02-27 00:19:26', 0, '2014-03-09 12:32:12', 0, 'admin-7b6987f23e458af6d0d7d20f5d91e88c.jpg'),
(84, 'AMPL0001', '123', 'Tes1', 1, 0, 120, 5, 0, 0, 0, '2014-03-04 01:12:40', 0, '2014-03-04 01:12:54', 0, 'admin-2abda775c90775e1fe3523d099d7c96e.jpg'),
(85, 'WATE0004', '1234', 'Nama', 10000, 0, 83, 1, 0, 0, 0, '2014-03-15 20:23:27', 1, '2014-03-15 22:09:19', 1, '1-a41f3b28a0d441c75e9c56502397db39.jpg'),
(86, 'AMPL0002', '456', 'Tes2', 2, 0, 120, 41, 0, 0, 0, '2014-03-15 20:30:47', 1, '2014-03-15 20:31:00', 1, 'admin-8041c77e784316f677384bb20b415141.jpg'),
(87, 'ALAT0006', '456', 'Tes3', 3, 0, 37, 2, 0, 0, 0, '2014-03-15 21:54:23', 1, '2014-03-15 22:06:56', 1, ''),
(88, 'BALL0001', '3565362452453', 'Wdasdaw', 111, 0, 128, 2, 0, 0, 1, '2014-04-16 22:33:32', 1, '2014-06-17 09:58:33', 1, '1-3389f858f2a858e67c019dea43d2ef68.jpg'),
(89, 'KATR0001', '4497152387590421', 'Katrol', 35000, 0, 43, 2, 0, 0, 1, '2014-04-17 21:38:19', 1, NULL, 0, '1-7ffc94cbade88d30ca3ef3c3a0752b33.jpg'),
(90, 'KAWA0001', '0144386100503486', 'Kawat Las Nikko Steel(kg)', 28000, 0, 44, 2, 0, 0, 1, '2014-04-17 21:39:12', 1, NULL, 0, '1-6c9ce46bff10ca7c1d406eeefab4f97c.jpg'),
(91, 'KAWA0002', '3826278844118847', 'Kawat Las Nikko Steel (kotak 5kg)', 135000, 0, 44, 2, 0, 0, 1, '2014-04-17 21:39:42', 1, NULL, 0, '1-45c6b288d724f28a6de6d523ae77f622.jpg'),
(92, 'KLEM0001', '6497688653949752', 'Klem Selang Stainless 5/8-1 1/4', 4000, 0, 45, 2, 0, 0, 1, '2014-04-17 21:40:51', 1, NULL, 0, ''),
(93, 'KLEM0002', '', 'Klem Selang Stainless 3/4', 3000, 0, 45, 2, 0, 0, 1, '2014-04-17 21:41:35', 1, NULL, 0, ''),
(94, 'KLEM0003', '', 'Klem Selang Stainless 2', 6000, 0, 45, 2, 0, 0, 1, '2014-04-17 21:41:55', 1, NULL, 0, ''),
(95, 'KLEM0004', '', 'Klem Selang Stainless 1/2', 2000, 0, 45, 2, 0, 0, 1, '2014-04-17 21:42:13', 1, NULL, 0, ''),
(96, 'KLEM0005', '', 'Klem Selang Stainless 1-1 1/2', 5000, 0, 45, 2, 0, 0, 1, '2014-04-17 21:42:32', 1, NULL, 0, ''),
(97, 'KUAS0001', '', 'Rolset 33 Kuas Rol 9', 25000, 0, 46, 2, 0, 0, 1, '2014-04-17 21:43:10', 1, NULL, 0, ''),
(98, 'KUAS0002', '', 'Kuas Roll Supra', 15000, 0, 46, 2, 0, 0, 1, '2014-04-17 21:43:21', 1, NULL, 0, ''),
(99, 'KUAS0003', '', 'Kuas Rol Kecil Rolset 4', 15000, 0, 46, 2, 0, 0, 1, '2014-04-17 21:43:32', 1, NULL, 0, ''),
(100, 'KUAS0004', '', 'Kuas Eterna 4', 20000, 0, 46, 2, 0, 0, 1, '2014-04-17 21:43:46', 1, NULL, 0, ''),
(101, 'KUAS0005', '', 'Kuas Eterna 3', 12000, 0, 46, 2, 0, 0, 1, '2014-04-17 21:43:58', 1, NULL, 0, ''),
(102, 'KUAS0006', '', 'Kuas Eterna 2', 8000, 0, 46, 2, 0, 0, 1, '2014-04-17 21:44:16', 1, NULL, 0, ''),
(103, 'KUAS0007', '', 'Kuas Eterna 2 1/2', 10000, 0, 46, 2, 0, 0, 1, '2014-04-17 21:44:27', 1, NULL, 0, ''),
(104, 'KUAS0008', '', 'Kuas Eterna 1', 4000, 0, 46, 2, 0, 0, 1, '2014-04-17 21:44:41', 1, NULL, 0, ''),
(105, 'KUAS0009', '', 'Kuas Eterna 1 1/2', 6000, 0, 46, 2, 0, 0, 1, '2014-04-17 21:44:51', 1, NULL, 0, ''),
(106, 'KUNC0001', '', 'Kunci Kaca / Etalase. Show Windows Lock', 20000, 0, 47, 2, 0, 0, 1, '2014-04-17 21:45:59', 1, NULL, 0, ''),
(107, 'PAKU0002', '-', 'Paku Tembak Etona F 25 (box)', 35000, 0, 48, 45, 0, 0, 1, '2014-04-17 21:46:16', 1, '2014-04-17 21:46:58', 1, ''),
(108, 'PAKU0003', '', 'Paku Payung / Paku Seng 7cm (kg)', 25000, 0, 48, 34, 0, 0, 1, '2014-04-17 21:47:25', 1, NULL, 0, ''),
(109, 'PAKU0004', '', 'Paku Payung / Paku Seng 5cm (kg)', 25000, 0, 48, 34, 0, 0, 1, '2014-04-17 21:47:43', 1, NULL, 0, ''),
(110, 'PAKU0005', '', 'Paku 7cm (kg)', 14000, 0, 48, 34, 0, 0, 1, '2014-04-17 21:48:00', 1, NULL, 0, ''),
(111, 'PAKU0006', '', 'Paku 5cm (kg)', 14000, 0, 48, 34, 0, 0, 1, '2014-04-17 21:48:25', 1, NULL, 0, ''),
(112, 'PAKU0007', '', 'Paku 4cm (kg)', 15000, 0, 48, 34, 0, 0, 1, '2014-04-17 21:48:43', 1, NULL, 0, ''),
(113, 'PAKU0008', '', 'Paku 3cm (kg)', 16000, 0, 48, 34, 0, 0, 1, '2014-04-17 21:48:59', 1, NULL, 0, ''),
(114, 'PAKU0009', '', 'Paku 2cm (kg)', 18000, 0, 48, 34, 0, 0, 1, '2014-04-17 21:49:13', 1, NULL, 0, ''),
(115, 'PAKU0010', '', 'Paku 2.5cm (kg)', 18000, 0, 48, 34, 0, 0, 1, '2014-04-17 21:49:29', 1, NULL, 0, ''),
(116, 'PAKU0011', '', 'Paku 10cm (kg)', 14000, 0, 48, 34, 0, 0, 1, '2014-04-17 21:49:42', 1, NULL, 0, ''),
(117, 'PALU0001', '', 'Palu Sedang', 25000, 0, 49, 2, 0, 0, 1, '2014-04-17 21:50:25', 1, NULL, 0, ''),
(118, 'PALU0002', '', 'Palu Kecil', 20000, 0, 49, 2, 0, 0, 1, '2014-04-17 21:50:39', 1, NULL, 0, ''),
(119, 'PALU0003', '', 'Palu Karet', 20000, 0, 49, 2, 0, 0, 1, '2014-04-17 21:50:58', 1, NULL, 0, ''),
(120, 'PALU0004', '', 'Palu Kambing Tnk High Quality', 30000, 0, 49, 2, 0, 0, 1, '2014-04-17 21:51:13', 1, NULL, 0, ''),
(121, 'PALU0005', '', 'Palu Besar 2lb', 30000, 0, 49, 2, 0, 0, 1, '2014-04-17 21:51:26', 1, NULL, 0, ''),
(122, 'PEKA0001', '', 'Winson 6 Needle Nose Liers', 20000, 0, 52, 2, 0, 0, 1, '2014-04-17 21:52:36', 1, NULL, 0, ''),
(123, 'PEKA0002', '', 'Sunmax Cutter', 15000, 0, 52, 41, 0, 0, 1, '2014-04-17 21:54:06', 1, NULL, 0, ''),
(124, 'PEKA0003', '', 'Pahat Kayu Gagang Fiber Stamvick', 30000, 0, 52, 41, 0, 0, 1, '2014-04-17 21:54:41', 1, NULL, 0, ''),
(125, 'PEKA0004', '', 'Mata Serut Stamvick 1 1/2', 19800, 0, 52, 41, 0, 0, 1, '2014-04-17 21:55:12', 1, NULL, 0, ''),
(126, 'PEKA0005', '', 'Mata Gergaji Besi Sandflex', 12000, 0, 52, 2, 0, 0, 1, '2014-04-17 21:55:29', 1, NULL, 0, ''),
(127, 'PEKA0006', '', 'Kunci Pipa 14 Inch', 50000, 0, 52, 2, 0, 0, 1, '2014-04-17 21:55:43', 1, NULL, 0, ''),
(128, 'PEKA0007', '', 'Kunci L (hexagon Key Wrench) Set', 15000, 0, 52, 41, 0, 0, 1, '2014-04-17 21:55:55', 1, NULL, 0, ''),
(129, 'PEKA0010', '-', 'Gegep / Pincers', 28000, 0, 52, 2, 0, 0, 1, '2014-04-17 21:56:06', 1, '2014-04-17 22:07:00', 1, ''),
(130, 'PEKA0009', '', '6 Bull Combination Pliers', 20000, 0, 52, 41, 8000, 346, 1, '2014-04-17 21:56:17', 1, NULL, 0, ''),
(131, 'EMBE0001', '', 'Ember Plastik Hitam 2lt', 4500, 0, 147, 2, 0, 0, 1, '2014-04-17 21:57:15', 1, NULL, 0, ''),
(132, 'EMBE0002', '', 'Ember Plastik Hijau 5lt', 8500, 0, 147, 2, 0, 0, 1, '2014-04-17 21:57:34', 1, NULL, 0, ''),
(133, 'EMBE0003', '', 'Ember Plastik Hijau 2lt', 5500, 0, 147, 2, 0, 0, 1, '2014-04-17 21:57:48', 1, NULL, 0, ''),
(134, 'KAPI0001', '', 'Kapi Plastik 7', 5000, 0, 148, 2, 0, 0, 1, '2014-04-17 22:00:40', 1, NULL, 0, ''),
(135, 'KAPI0002', '', 'Kapi Plastik 5', 5000, 0, 148, 2, 0, 0, 1, '2014-04-17 22:00:56', 1, NULL, 0, ''),
(136, 'KAPI0003', '', 'Kape Sgs 5,8,10,12cm Set', 11000, 0, 148, 2, 0, 0, 1, '2014-04-17 22:01:19', 1, NULL, 0, ''),
(137, 'KAPI0004', '', 'Japan Flachen Spachte / 4 Kape Set', 13000, 0, 148, 2, 0, 0, 1, '2014-04-17 22:01:37', 1, NULL, 0, ''),
(138, 'KAPI0005', '', 'Flachenspachteln Nug Kape 4 Set', 25000, 0, 148, 2, 0, 0, 1, '2014-04-17 22:01:48', 1, NULL, 0, ''),
(139, 'KIKI0001', '', 'Kikir Stamvick 100mm / 4', 15000, 0, 149, 2, 0, 0, 1, '2014-04-17 22:02:10', 1, NULL, 0, ''),
(140, 'KIKI0002', '', 'Kikir Jason 4', 15000, 0, 149, 2, 0, 0, 1, '2014-04-17 22:02:22', 1, NULL, 0, ''),
(141, 'KIKI0003', '', 'Kikir Bahco 4 / 100mm', 25000, 0, 149, 2, 0, 0, 1, '2014-04-17 22:02:34', 1, NULL, 0, ''),
(142, 'MATA0001', '', 'Pisau Potong Keramik Dsk 110mm', 20000, 0, 150, 41, 0, 0, 1, '2014-04-17 22:05:01', 1, NULL, 0, ''),
(143, 'MATA0002', '', 'Pisau Potong Keramik Bosch 4 / 105mm', 115000, 0, 150, 41, 0, 0, 1, '2014-04-17 22:05:18', 1, NULL, 0, ''),
(144, 'MATA0003', '', 'Pisau Gerinda Potong Nippon Resibon 4', 15000, 0, 150, 41, 0, 0, 1, '2014-04-17 22:05:37', 1, NULL, 0, ''),
(145, 'MATA0004', '', 'Pisau Cutter', 5000, 0, 150, 2, 0, 0, 1, '2014-04-17 22:05:50', 1, NULL, 0, ''),
(146, 'MATA0005', '', 'Mata Gerinda', 12000, 0, 150, 41, 0, 0, 1, '2014-04-17 22:06:02', 1, NULL, 0, ''),
(147, 'PELA0001', '', 'Radar Pelampung Air', 60000, 0, 53, 2, 0, 0, 1, '2014-04-17 22:06:48', 1, NULL, 0, ''),
(148, 'PELA0002', '', 'Penguin Switch Ps 70ab', 50000, 0, 53, 2, 0, 0, 1, '2014-04-17 22:08:18', 1, NULL, 0, ''),
(149, 'PELA0003', '', 'Kido Liquid Level Control Switch', 70000, 0, 53, 2, 0, 0, 1, '2014-04-17 22:08:33', 1, NULL, 0, ''),
(150, 'RANT0001', '', 'Rantai Kecil 1cm', 10000, 0, 54, 26, 0, 0, 1, '2014-04-17 22:09:01', 1, NULL, 0, ''),
(151, 'RANT0002', '', 'Rantai Kecil 1,5cm', 12000, 0, 54, 26, 0, 0, 1, '2014-04-17 22:09:12', 1, NULL, 0, ''),
(152, 'RANT0003', '', 'Rantai Anjing Pet Product', 20000, 0, 54, 26, 0, 0, 1, '2014-04-17 22:09:24', 1, NULL, 0, ''),
(153, 'RANT0005', '-', 'Rantai Anjing 128cm', 20000, 0, 54, 2, 0, 0, 1, '2014-04-17 22:09:38', 1, '2014-04-17 22:10:03', 1, ''),
(154, 'RANT0006', '', 'Rantai Anjing / Dog Chain', 20000, 0, 54, 2, 0, 0, 1, '2014-04-17 22:10:11', 1, NULL, 0, ''),
(155, 'RANT0007', '', 'Rantai 5cm Rantai 5cm', 45000, 0, 54, 26, 0, 0, 1, '2014-04-17 22:10:23', 1, NULL, 0, ''),
(156, 'RANT0008', '', 'Rantai 4cm', 35000, 0, 54, 26, 0, 0, 1, '2014-04-17 22:10:39', 1, NULL, 0, ''),
(157, 'RANT0009', '', 'Rantai 3cm', 20000, 0, 54, 26, 0, 0, 1, '2014-04-17 22:10:55', 1, NULL, 0, ''),
(158, 'RODA0001', '', 'Roda Pagar Diameter 8cm', 55000, 0, 55, 2, 0, 0, 1, '2014-04-17 22:11:29', 1, NULL, 0, ''),
(159, 'RODA0002', '', 'Roda Pagar Diameter 7cm', 50000, 0, 55, 2, 0, 0, 1, '2014-04-17 22:11:49', 1, NULL, 0, ''),
(160, 'RODA0003', '', 'Roda Pagar Diameter 10cm', 70000, 0, 55, 2, 0, 0, 1, '2014-04-17 22:11:59', 1, NULL, 0, ''),
(161, 'SAMB0001', '', 'Sambungan Selang Standart', 5000, 0, 56, 2, 0, 0, 1, '2014-04-17 22:12:26', 1, NULL, 0, '1-0c33af0e0031298fab261ec3fbcdff02.jpg'),
(162, 'SAMB0002', '', 'Sambungan Selang', 6000, 0, 56, 2, 0, 0, 1, '2014-04-17 22:12:51', 1, NULL, 0, '1-79ee800191e2c7cf7a7d51e5af2e66bf.jpg'),
(163, 'SARU0001', '', 'Sarung Tangan Karet', 12500, 0, 57, 2, 0, 0, 1, '2014-04-17 22:13:15', 1, NULL, 0, ''),
(164, 'SARU0002', '', 'Sarung Tangan Bintik-bintik Karet', 7000, 0, 57, 2, 0, 0, 1, '2014-04-17 22:13:26', 1, NULL, 0, ''),
(165, 'SARU0003', '', 'Sarung Tangan Benang Putih', 5000, 0, 57, 2, 0, 0, 1, '2014-04-17 22:13:36', 1, NULL, 0, ''),
(166, 'SCRE0005', '3253214611765740', '10 Pieces Screwdriver Set', 45000, 0, 58, 41, 30000, 113, 1, '2014-04-17 22:13:59', 1, '2014-05-25 02:50:32', 1, '1-8ed891d9ccaf759984869bcdbf695525.jpg'),
(167, 'SEAL0001', '', 'Tachi Ptfe Thread Seal Tape', 1300, 0, 59, 2, 0, 0, 1, '2014-04-17 22:14:17', 1, NULL, 0, ''),
(168, 'SEAL0002', '', 'Seal Tape Sanho', 2000, 0, 59, 2, 0, 0, 1, '2014-04-17 22:14:25', 1, NULL, 0, ''),
(169, 'SEAL0003', '', 'Onda Seal Tape', 3000, 0, 59, 2, 0, 0, 1, '2014-04-17 22:14:43', 1, NULL, 0, ''),
(170, 'SEKR0001', '', 'Skrup 3cm', 7500, 0, 60, 41, 0, 0, 1, '2014-04-17 22:14:59', 1, NULL, 0, ''),
(171, 'SEKR0002', '', 'Skrup 2cm', 5000, 0, 60, 41, 0, 0, 1, '2014-04-17 22:15:09', 1, NULL, 0, ''),
(172, 'SEKG0001', '', 'Skrup Gypsum Sunray 8x3', 85000, 0, 62, 41, 0, 0, 1, '2014-04-17 22:17:18', 1, NULL, 0, ''),
(173, 'SEKG0002', '', 'Skrup Gypsum Sunray 6x2', 80000, 0, 62, 41, 0, 0, 1, '2014-04-17 22:17:35', 1, NULL, 0, ''),
(174, 'SEKG0003', '', 'Skrup Gypsum Sunray 6x1" (box)', 110000, 0, 62, 41, 0, 0, 1, '2014-04-17 22:17:48', 1, NULL, 0, ''),
(175, 'SEKG0004', '', 'Skrup Gypsum Sunray 6x1 1/4"', 110000, 0, 62, 41, 0, 0, 1, '2014-04-17 22:18:05', 1, NULL, 0, ''),
(176, 'SEKG0005', '', 'Skrup Gypsum Sunray 6x1 1/2"', 90000, 0, 62, 41, 0, 0, 1, '2014-04-17 22:18:18', 1, NULL, 0, ''),
(177, 'SEKG0006', '', 'Skrup Gypsum Bungkus 5cm', 15000, 0, 62, 41, 0, 0, 1, '2014-04-17 22:18:29', 1, NULL, 0, ''),
(178, 'SEKG0007', '', 'Skrup Gypsum Bungkus 3cm', 10000, 0, 62, 41, 0, 0, 1, '2014-04-17 22:18:39', 1, NULL, 0, ''),
(179, 'SEKG0008', '', 'Skrup Gypsum Bungkus 2cm', 7500, 0, 62, 41, 0, 0, 1, '2014-04-17 22:18:53', 1, NULL, 0, ''),
(180, 'SELA0001', '', 'Selang Air Warna 5/8"', 6500, 0, 63, 26, 0, 0, 1, '2014-04-17 22:19:58', 1, NULL, 0, ''),
(181, 'SELA0002', '', 'Selang Air Warna 3/4"', 8500, 0, 63, 26, 0, 0, 1, '2014-04-17 22:20:13', 1, NULL, 0, ''),
(182, 'SELA0003', '', 'Selang Air Warna 1/2"', 5500, 0, 63, 26, 0, 0, 1, '2014-04-17 22:20:27', 1, NULL, 0, ''),
(183, 'SELA0004', '', 'Selang Air Warna 1"', 11000, 0, 63, 26, 0, 0, 1, '2014-04-17 22:20:42', 1, NULL, 0, ''),
(184, 'SELA0005', '', 'Selang Air Benang 5/8"', 9000, 0, 63, 26, 0, 0, 1, '2014-04-17 22:20:56', 1, NULL, 0, ''),
(185, 'SELA0006', '', 'Selang Air Benang 3/4"', 11000, 0, 63, 26, 0, 0, 1, '2014-04-17 22:21:12', 1, NULL, 0, ''),
(186, 'SELA0007', '', 'Selang Air Benang 1/2"', 7500, 0, 63, 26, 0, 0, 1, '2014-04-17 22:21:23', 1, NULL, 0, ''),
(187, 'SELA0008', '', 'Selang Air Benang 1"', 16000, 0, 63, 26, 0, 0, 1, '2014-04-17 22:21:32', 1, NULL, 0, ''),
(188, 'SERA0001', '', 'Serat Fiber', 3000, 0, 64, 41, 0, 0, 1, '2014-04-17 22:21:51', 1, NULL, 0, ''),
(189, 'SIKU0001', '', 'Siku Rak 8x10" (per Pasang)', 14500, 0, 65, 2, 0, 0, 1, '2014-04-17 22:22:19', 1, NULL, 0, ''),
(190, 'SIKU0002', '', 'Siku Rak 6x8" Siku Rak 6x8" (per Pasang)', 10000, 0, 65, 2, 0, 0, 1, '2014-04-17 22:22:30', 1, NULL, 0, ''),
(191, 'SIKU0003', '', 'Siku Rak 5x6" (per Pasang)', 8000, 0, 65, 2, 0, 0, 1, '2014-04-17 22:22:40', 1, NULL, 0, ''),
(192, 'SIKU0004', '', 'Siku Rak 4x5"', 5500, 0, 65, 2, 0, 0, 1, '2014-04-17 22:22:51', 1, NULL, 0, ''),
(193, 'SIKU0005', '', 'Siku Rak 3x4"', 4000, 0, 65, 2, 0, 0, 1, '2014-04-17 22:23:04', 1, NULL, 0, ''),
(194, 'SIKU0006', '', 'Siku Rak 12x14" (per Pasang)', 24000, 0, 65, 2, 0, 0, 1, '2014-04-17 22:23:18', 1, NULL, 0, ''),
(195, 'SIKU0007', '', 'Siku Rak 10x12" (per Pasang)', 20000, 0, 65, 2, 0, 0, 1, '2014-04-17 22:23:27', 1, NULL, 0, ''),
(196, 'SIKU0008', '', 'Gun Bracket / Braket Pistol 50cm', 30000, 0, 65, 2, 0, 0, 1, '2014-04-17 22:23:43', 1, NULL, 0, ''),
(197, 'SPRA0001', '', 'Hose Nozzle', 35000, 0, 66, 2, 0, 0, 1, '2014-04-17 22:24:41', 1, NULL, 0, ''),
(198, 'TALI0001', '', 'Tali Tambang 8mm', 45000, 0, 67, 34, 0, 0, 1, '2014-04-17 22:25:01', 1, NULL, 0, ''),
(199, 'TALI0002', '', 'Tali Tambang 6mm', 45000, 0, 67, 34, 0, 0, 1, '2014-04-17 22:25:14', 1, NULL, 0, ''),
(200, 'TANG0002', '-', 'Bak Mandi Uk. 66cm', 240000, 0, 68, 2, 150000, 48, 1, '2014-04-17 22:25:36', 1, '2014-06-30 01:45:33', 1, ''),
(201, 'ANTI0001', '', 'Seiv Flintkote Undercover Agent (1 Lt)', 35000, 0, 69, 3, 0, 0, 1, '2014-04-17 22:26:16', 1, NULL, 0, ''),
(202, 'CATA0002', '-', 'Avian Aluminium Paint Chrome Finish 100cc', 10000, 0, 70, 3, 4000, 87, 1, '2014-04-18 03:00:03', 1, '2014-04-18 03:00:41', 1, ''),
(203, 'CATA0001', '-', 'Avian Aluminium Paint Chrome Finish', 45000, 0, 70, 3, 40000, 84, 1, '2014-04-18 03:00:17', 1, '2014-04-18 03:00:32', 1, ''),
(204, 'CATB0001', '', 'Mowilex Precoat Varnish Batu Alam 2.5lt', 130000, 0, 71, 3, 0, 0, 1, '2014-04-18 03:09:42', 1, NULL, 0, ''),
(205, 'CATB0002', '', 'Mowilex Precoat Varnish Batu Alam 1lt', 60000, 0, 71, 3, 0, 0, 1, '2014-04-18 03:09:55', 1, NULL, 0, ''),
(206, 'CATG0001', '', 'Cat Genteng & Asbes Vitalux (warna Standar)', 100000, 0, 72, 3, 0, 0, 1, '2014-04-18 03:10:21', 1, '2014-06-30 01:35:51', 1, ''),
(207, 'CATK0001', '', 'Seiv Wrought Iron Paint (cat Besi Tempa) 1lt', 95000, 0, 73, 3, 0, 0, 1, '2014-04-18 03:10:40', 1, NULL, 0, ''),
(208, 'CATK0002', '', 'Seiv Wrought Iron (cat Besi Tempa) 250ml', 30000, 0, 73, 3, 0, 0, 1, '2014-04-18 03:10:56', 1, NULL, 0, ''),
(209, 'CATK0003', '', 'Glotex Cat Kayu & Besi 0.9lt', 51000, 0, 73, 3, 0, 0, 1, '2014-04-18 03:11:13', 1, NULL, 0, ''),
(210, 'CATK0004', '', 'Globe Cat Kayu Dan Besi Super Gloss 0.85lt', 35000, 0, 73, 3, 0, 0, 1, '2014-04-18 03:11:32', 1, NULL, 0, ''),
(211, 'CATK0005', '', 'Ftalit Cat Besi Dan Kayu 1lt', 50000, 0, 73, 3, 0, 0, 1, '2014-04-18 03:11:44', 1, NULL, 0, ''),
(212, 'CATK0006', '', 'Cat Synthetic Kuda Terbang 0.1lt', 9000, 0, 73, 3, 0, 0, 1, '2014-04-18 03:11:56', 1, NULL, 0, ''),
(213, 'CATK0007', '', 'Cat Kayu & Besi Seiv Synthetic Enamel Gloss Warna Standar', 50000, 0, 73, 3, 0, 0, 1, '2014-04-18 03:12:14', 1, NULL, 0, ''),
(214, 'CATK0008', '', 'Cat Impra Nc 141 Clear Gloss 1 Liter', 54000, 0, 73, 3, 0, 0, 1, '2014-04-18 03:12:32', 1, NULL, 0, ''),
(215, 'CATK0009', '', 'Cat Besi & Kayu Avian High Gloss Enamel 0.9lt', 51000, 0, 73, 3, 45000, 509, 1, '2014-04-18 03:12:51', 1, NULL, 0, ''),
(216, 'CATK0010', '', 'Avian High Gloss Enamel 100cc', 10000, 0, 73, 3, 4500, 1000, 1, '2014-04-18 03:13:03', 1, NULL, 0, ''),
(217, 'CATM0001', '', 'Cat Impra Sanding Sealer Melamine Ml-131 1lt', 54000, 0, 74, 3, 0, 0, 1, '2014-04-18 03:13:38', 1, NULL, 0, ''),
(218, 'CATS0001', '', 'Rj Hi-temp Cat Semprot 400cc', 45000, 0, 75, 3, 0, 0, 1, '2014-04-18 03:13:57', 1, NULL, 0, ''),
(219, 'CATS0002', '', 'Rj Chrome Cat Semprot', 35000, 0, 75, 3, 0, 0, 1, '2014-04-18 03:14:06', 1, NULL, 0, ''),
(220, 'CATS0003', '', 'Rj Acrylic Epoxy Spray Paint 400cc', 25000, 0, 75, 3, 0, 0, 1, '2014-04-18 03:14:16', 1, NULL, 0, ''),
(221, 'CATS0004', '', 'Rj Acrylic Epoxy Spray Paint 300cc', 22000, 0, 75, 3, 0, 0, 1, '2014-04-18 03:14:25', 1, NULL, 0, ''),
(222, 'CATT0001', '', 'Metrolite Cat Tembok 3 Liter', 88000, 0, 76, 3, 0, 0, 1, '2014-04-18 03:14:48', 1, NULL, 0, ''),
(223, 'CATT0002', '', 'Metrolite Cat Tembok 1kg', 30000, 0, 76, 3, 0, 0, 1, '2014-04-18 03:14:59', 1, NULL, 0, ''),
(224, 'CATT0003', '', 'Metrolite Cat Tembok (pail) 16ll', 420000, 0, 76, 3, 0, 0, 1, '2014-04-18 03:15:13', 1, NULL, 0, ''),
(225, 'CATT0004', '', 'Dulux Weathershield Pro Cat Tembok (brilliant White) 2.5lt', 215000, 0, 76, 3, 0, 0, 1, '2014-04-18 03:15:37', 1, NULL, 0, ''),
(226, 'CATT0005', '', 'Dulux Pentalite (standar Colour) Cat Tembok 2.5lt', 140000, 0, 76, 3, 0, 0, 1, '2014-04-18 03:16:09', 1, NULL, 0, ''),
(227, 'CATT0006', '', 'Dulux Pearl Glo 2.5 Liter', 180000, 0, 76, 3, 0, 0, 1, '2014-04-18 03:16:37', 1, NULL, 0, ''),
(228, 'CATT0007', '', 'Dulux Catylac Cat Tembok 5kg', 100000, 0, 76, 3, 0, 0, 1, '2014-04-18 03:16:47', 1, NULL, 0, ''),
(229, 'CATT0008', '', 'Dulux Catylac Cat Tembok 25kg', 480000, 0, 76, 3, 0, 0, 1, '2014-04-18 03:17:01', 1, NULL, 0, ''),
(230, 'CATT0009', '', 'Cat Tembok Vinilex 5000 1kg', 35000, 0, 76, 3, 0, 0, 1, '2014-04-18 03:17:14', 1, NULL, 0, ''),
(231, 'CATT0010', '', 'Cat Tembok Vinilex 5000 (5kg)', 105000, 0, 76, 3, 0, 0, 1, '2014-04-18 03:17:26', 1, NULL, 0, ''),
(232, 'CATT0011', '', 'Cat Tembok Mowilex 2.5lt Warna Standar', 135000, 0, 76, 3, 0, 0, 1, '2014-04-18 03:17:41', 1, NULL, 0, ''),
(233, 'CATT0012', '', 'Cat Tembok Mowilex 1lt Warna Standar', 68000, 0, 76, 3, 0, 0, 1, '2014-04-18 03:18:01', 1, NULL, 0, ''),
(234, 'CATT0013', '', 'Cat Tembok Cola Tex 5kg', 50000, 0, 76, 3, 0, 0, 1, '2014-04-18 03:18:12', 1, NULL, 0, ''),
(235, 'CATT0014', '', 'Cat Tembok Cola Tex 25kg', 225000, 0, 76, 3, 0, 0, 1, '2014-04-18 03:18:23', 1, NULL, 0, ''),
(236, 'CATT0015', '', 'Cat Tembok Cola Tex 1kg', 20000, 0, 76, 3, 0, 0, 1, '2014-04-18 03:18:33', 1, NULL, 0, ''),
(237, 'CATT0016', '', 'Cat Tembok Avitex 5kg', 80000, 0, 76, 3, 0, 0, 1, '2014-04-18 03:18:41', 1, NULL, 0, ''),
(238, 'DEMP0001', '', 'San Polac 4kg', 110000, 0, 78, 3, 0, 0, 1, '2014-04-18 03:19:11', 1, NULL, 0, ''),
(239, 'DEMP0002', '', 'San Polac 250g', 15000, 0, 78, 3, 0, 0, 1, '2014-04-18 03:19:20', 1, NULL, 0, ''),
(240, 'DEMP0003', '', 'San Polac 1kg', 34000, 0, 78, 3, 0, 0, 1, '2014-04-18 03:19:33', 1, NULL, 0, ''),
(241, 'DEMP0004', '', 'Isamu Lacquer 1kg', 50000, 0, 78, 3, 0, 0, 1, '2014-04-18 03:19:40', 1, NULL, 0, ''),
(242, 'DEMP0005', '', 'Isamu 250g Isamu Lacquer 1/4kg', 21000, 0, 78, 3, 0, 0, 1, '2014-04-18 03:19:50', 1, NULL, 0, ''),
(243, 'ALAT0007', '1', 'A', 1, 0, 37, 41, 0, 0, 0, '2014-04-21 02:57:45', 1, '2014-06-30 01:48:11', 1, ''),
(244, 'ALAT0008', 'BBBBBB', 'Bbbbbb', 12345, 0, 37, 41, 0, 0, 0, '2014-06-30 01:44:46', 1, '2014-06-30 01:45:20', 1, '1-c1ce4fd09ea367566c98faf104197766.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `barang_kategori`
--

CREATE TABLE IF NOT EXISTS `barang_kategori` (
  `id_barangkategori` int(11) NOT NULL AUTO_INCREMENT,
  `kode` varchar(4) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `createddate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdby` int(11) NOT NULL,
  `updateddate` timestamp NULL DEFAULT NULL,
  `updatedby` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_barangkategori`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=151 ;

--
-- Dumping data for table `barang_kategori`
--

INSERT INTO `barang_kategori` (`id_barangkategori`, `kode`, `nama`, `status`, `createddate`, `createdby`, `updateddate`, `updatedby`) VALUES
(37, 'ALAT', 'Alat Ukur / Meteran / Mistar', 1, '2014-02-12 09:42:27', 0, '2014-03-15 21:48:22', 1),
(38, 'BENA', 'Benang', 1, '2014-02-12 09:42:50', 0, NULL, NULL),
(39, 'DRAW', 'Drawer Runner / Rel Laci', 1, '2014-02-12 10:04:01', 0, '2014-02-12 10:04:21', 0),
(40, 'GEMB', 'Gembok', 1, '2014-02-12 10:08:25', 0, NULL, 0),
(41, 'HELM', 'Helm Proyek', 1, '2014-02-12 10:14:37', 0, NULL, 0),
(42, 'KABE', 'Kabel Tie / Tie Cable', 1, '2014-02-12 10:14:54', 0, NULL, 0),
(43, 'KATR', 'Katrol', 1, '2014-02-12 10:15:05', 0, NULL, 0),
(44, 'KAWA', 'Kawat Las', 1, '2014-02-12 10:15:19', 0, NULL, 0),
(45, 'KLEM', 'Klem Selang', 1, '2014-02-12 10:25:57', 0, NULL, 0),
(46, 'KUAS', 'Kuas', 1, '2014-02-12 10:27:37', 0, NULL, 0),
(47, 'KUNC', 'Kunci / Lock', 1, '2014-02-12 10:27:50', 0, NULL, 0),
(48, 'PAKU', 'Paku', 1, '2014-02-12 10:29:27', 0, NULL, 0),
(49, 'PALU', 'Palu', 1, '2014-02-12 10:29:32', 0, NULL, 0),
(52, 'PEKA', 'Pekakas Tukang / Tools', 1, '2014-02-13 01:33:42', 0, NULL, 0),
(53, 'PELA', 'Pelampung Air', 1, '2014-02-13 01:33:53', 0, NULL, 0),
(54, 'RANT', 'Rantai / Chain', 1, '2014-02-13 01:34:08', 0, NULL, 0),
(55, 'RODA', 'Roda', 1, '2014-02-13 01:36:38', 0, NULL, 0),
(56, 'SAMB', 'Sambungan Selang', 1, '2014-02-13 01:37:35', 0, NULL, 0),
(57, 'SARU', 'Sarung Tangan / Gloves', 1, '2014-02-13 01:37:44', 0, NULL, 0),
(58, 'SCRE', 'Screwdriver / Obeng', 1, '2014-02-13 01:37:58', 0, NULL, 0),
(59, 'SEAL', 'Seal Tape', 1, '2014-02-13 01:38:05', 0, NULL, 0),
(60, 'SEKR', 'Sekrup', 1, '2014-02-13 01:38:10', 0, NULL, 0),
(62, 'SEKG', 'Sekrup Gypsum', 1, '2014-02-13 01:44:26', 0, NULL, 0),
(63, 'SELA', 'Selang', 1, '2014-02-13 01:44:33', 0, NULL, 0),
(64, 'SERA', 'Serat Fier', 1, '2014-02-13 01:44:46', 0, NULL, 0),
(65, 'SIKU', 'Siku Rak / Shelf Bracket', 1, '2014-02-13 01:44:57', 0, NULL, 0),
(66, 'SPRA', 'Spray / Semprotan Air', 1, '2014-02-13 01:45:04', 0, NULL, 0),
(67, 'TALI', 'Tali Tambang', 1, '2014-02-13 01:45:12', 0, NULL, 0),
(68, 'TANG', 'Tangki Air / Toran', 1, '2014-02-13 01:45:19', 0, NULL, 0),
(69, 'ANTI', 'Anti Karat', 1, '2014-02-13 01:45:41', 0, NULL, 0),
(70, 'CATA', 'Cat Alumunium', 1, '2014-02-13 01:45:51', 0, NULL, 0),
(71, 'CATB', 'Cat Batu Alam', 1, '2014-02-13 01:45:58', 0, NULL, 0),
(72, 'CATG', 'Cat Genteng', 1, '2014-02-13 01:46:02', 0, NULL, 0),
(73, 'CATK', 'Cat Kayu Dan Besi', 1, '2014-02-13 01:46:13', 0, NULL, 0),
(74, 'CATM', 'Cat Melamine', 1, '2014-02-13 01:46:19', 0, NULL, 0),
(75, 'CATS', 'Cat Semprot', 1, '2014-02-13 01:46:25', 0, NULL, 0),
(76, 'CATT', 'Cat Tembok', 1, '2014-02-13 01:46:32', 0, NULL, 0),
(77, 'CATC', 'Cat Coating', 1, '2014-02-13 01:46:39', 0, NULL, 0),
(78, 'DEMP', 'Dempul', 1, '2014-02-13 01:46:45', 0, NULL, 0),
(79, 'PENG', 'Pengencer Cat', 1, '2014-02-13 01:46:52', 0, NULL, 0),
(80, 'PENI', 'Penghilang Cat / Paint Remover', 1, '2014-02-13 01:47:07', 0, NULL, 0),
(81, 'POLI', 'Politur Kayu', 1, '2014-02-13 01:47:13', 0, NULL, 0),
(82, 'WALL', 'Wall Filler / Putty', 1, '2014-02-13 01:47:22', 0, NULL, 0),
(83, 'WATE', 'Waterproofing / Anti Bocor', 1, '2014-02-13 01:47:32', 0, NULL, 0),
(84, 'EXTE', 'Etendsion Cord', 1, '2014-02-13 01:48:00', 0, NULL, 0),
(85, 'FITT', 'Fitting Lampu', 1, '2014-02-13 01:48:12', 0, NULL, 0),
(86, 'KABL', 'Kabel', 1, '2014-02-13 01:49:19', 0, NULL, 0),
(87, 'KABR', 'Kabell Roll', 1, '2014-02-13 01:54:01', 0, NULL, 0),
(88, 'KLEK', 'Klem Kabel', 1, '2014-02-13 01:54:15', 0, NULL, 0),
(89, 'LAMP', 'Lampu', 1, '2014-02-13 01:54:21', 0, NULL, 0),
(90, 'MCBB', 'Mini Circuit Breakers', 1, '2014-02-13 01:54:41', 0, NULL, 0),
(91, 'PENK', 'Pengaman Kabel', 1, '2014-02-13 01:55:01', 0, NULL, 0),
(92, 'SAKL', 'Saklar & Stop Kontak', 1, '2014-02-13 01:55:09', 0, NULL, 0),
(93, 'SOLA', 'Solasi Listrik', 1, '2014-02-13 01:55:16', 0, NULL, 0),
(94, 'KAYU', 'Kayu Kaso', 1, '2014-02-13 01:55:34', 0, NULL, 0),
(95, 'MDFB', 'Medium Density Fibreboard / M D F', 1, '2014-02-13 01:55:55', 0, '2014-03-01 04:41:37', 0),
(96, 'MELA', 'Melamine', 1, '2014-02-13 01:56:08', 0, NULL, 0),
(97, 'PAPA', 'Papan Cor', 1, '2014-02-13 01:56:14', 0, '2014-03-09 08:16:15', 0),
(98, 'PAPG', 'Papan Gypsum', 1, '2014-02-13 01:56:30', 0, NULL, 0),
(99, 'PNKY', 'Pengawet Kayu', 1, '2014-02-13 01:56:48', 0, NULL, 0),
(100, 'TRIP', 'Triplex', 1, '2014-02-13 01:56:55', 0, NULL, 0),
(101, 'KERA', 'Keramik Dinding', 1, '2014-02-13 01:57:11', 0, NULL, 0),
(102, 'KERL', 'Keramik Lantai', 1, '2014-02-13 01:57:17', 0, NULL, 0),
(103, 'ANTR', 'Anti Rayap', 1, '2014-02-13 01:57:41', 0, NULL, 0),
(104, 'PELU', 'Pelumas', 1, '2014-02-13 01:57:47', 0, NULL, 0),
(105, 'PEMB', 'Pembersih', 1, '2014-02-13 01:57:55', 0, NULL, 0),
(106, 'POLS', 'Polish', 1, '2014-02-13 01:58:30', 0, NULL, 0),
(107, 'SODA', 'Soda Api', 1, '2014-02-13 01:58:35', 0, NULL, 0),
(108, 'SPIR', 'Spirtus', 1, '2014-02-13 01:58:43', 0, NULL, 0),
(109, 'TALC', 'Talc Duco / Lioning', 1, '2014-02-13 01:58:51', 0, NULL, 0),
(110, 'FOIL', 'Foil Tape', 1, '2014-02-13 01:59:07', 0, NULL, 0),
(111, 'LEMB', 'Lem Besi / Baja', 1, '2014-02-13 01:59:14', 0, NULL, 0),
(112, 'LEMF', 'Lem Fiber / Glass', 1, '2014-02-13 01:59:21', 0, NULL, 0),
(113, 'LEMK', 'Lem Karpet Talang', 1, '2014-02-13 01:59:30', 0, NULL, 0),
(114, 'LEKA', 'Lem Kayu / Karet', 1, '2014-02-13 01:59:40', 0, NULL, 0),
(115, 'LEKE', 'Lem Keramik', 1, '2014-02-13 01:59:46', 0, NULL, 0),
(116, 'LEKR', 'Lem Kertas', 1, '2014-02-13 01:59:56', 0, NULL, 0),
(117, 'LEMP', 'Lem Pipa / P V C', 1, '2014-02-13 02:00:05', 0, '2014-03-09 08:19:02', 0),
(118, 'LEMS', 'Lem Serbaguna', 1, '2014-02-13 02:00:12', 0, NULL, 0),
(119, 'LEMT', 'Lem Tikus', 1, '2014-02-13 02:00:16', 0, NULL, 0),
(120, 'AMPL', 'Amplas / Abrasive', 1, '2014-02-13 02:00:48', 0, '2014-03-15 19:49:58', 1),
(121, 'BATA', 'Bata', 1, '2014-02-13 02:00:54', 0, NULL, 0),
(122, 'BATU', 'Batu / Split', 1, '2014-02-13 02:01:06', 0, NULL, 0),
(123, 'BESI', 'Besi', 1, '2014-02-13 02:01:11', 0, NULL, 0),
(124, 'CORN', 'Cornice / Adhesive', 1, '2014-02-13 02:01:27', 0, NULL, 0),
(125, 'PASI', 'Pasir', 1, '2014-02-13 02:01:36', 0, NULL, 0),
(126, 'SEME', 'Semen', 1, '2014-02-13 02:01:41', 0, NULL, 0),
(127, 'CAMP', 'Campuran Semen', 1, '2014-02-13 02:01:49', 0, NULL, 0),
(128, 'BALL', 'Ball Valve', 1, '2014-02-13 02:02:03', 0, NULL, 0),
(129, 'INCR', 'Increaser / Reducer', 1, '2014-02-13 02:02:12', 0, NULL, 0),
(130, 'PIPA', 'Pipa', 1, '2014-02-13 02:02:30', 0, NULL, 0),
(131, 'PVCD', 'Pvc Door', 1, '2014-02-13 02:02:39', 0, NULL, 0),
(132, 'SOCK', 'Socket Pvc', 1, '2014-02-13 02:02:46', 0, NULL, 0),
(133, 'TEEP', 'Tee Pvc', 1, '2014-02-13 02:02:53', 0, NULL, 0),
(134, 'WATM', 'Water Mur', 1, '2014-02-13 02:03:03', 0, NULL, 0),
(135, 'FLEX', 'Flexible Hose', 1, '2014-02-13 02:03:19', 0, NULL, 0),
(136, 'JETS', 'Jet Shower', 1, '2014-02-13 02:03:25', 0, NULL, 0),
(137, 'KRAN', 'Kran Tembok', 1, '2014-02-13 02:03:31', 0, NULL, 0),
(138, 'KRAW', 'Kran Washtafel', 1, '2014-02-13 02:03:40', 0, NULL, 0),
(139, 'SHOW', 'Shower Mandi', 1, '2014-02-13 02:03:47', 0, NULL, 0),
(140, 'WASH', 'Washtafel Sifon', 1, '2014-02-13 02:03:58', 0, NULL, 0),
(142, 'TESS', 'Tess', 0, '2014-03-01 12:27:04', 0, '2014-03-01 12:27:13', 0),
(143, 'ASUS', 'Asus Tes', 0, '2014-03-03 23:59:33', 0, '2014-03-03 23:59:42', 0),
(144, 'H', '', 0, '2014-03-03 23:59:55', 0, '2014-03-04 00:00:01', 0),
(145, 'ASUP', 'Tes Lagi', 0, '2014-03-15 19:51:41', 1, '2014-03-15 19:51:54', 1),
(146, 'AAAA', 'Aaaaaa', 0, '2014-03-15 21:48:32', 1, '2014-03-15 21:48:36', 1),
(147, 'EMBE', 'Ember Semen', 1, '2014-04-17 21:57:01', 1, NULL, 0),
(148, 'KAPI', 'Kapi / Kape', 1, '2014-04-17 22:00:02', 1, NULL, 0),
(149, 'KIKI', 'Kikir / Saw File', 1, '2014-04-17 22:00:13', 1, NULL, 0),
(150, 'MATA', 'Mata Pisau Potong', 1, '2014-04-17 22:00:23', 1, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `barang_persediaan`
--

CREATE TABLE IF NOT EXISTS `barang_persediaan` (
  `id_barangpersediaan` int(11) NOT NULL AUTO_INCREMENT,
  `id_barang` int(11) NOT NULL,
  `id_pembelian` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `stok_awal` int(11) NOT NULL,
  `stok_maksimal` int(11) NOT NULL,
  `stok_sisa` int(11) NOT NULL,
  `createddate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `createdby` int(11) NOT NULL,
  PRIMARY KEY (`id_barangpersediaan`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `barang_persediaan`
--

INSERT INTO `barang_persediaan` (`id_barangpersediaan`, `id_barang`, `id_pembelian`, `harga`, `stok_awal`, `stok_maksimal`, `stok_sisa`, `createddate`, `createdby`) VALUES
(1, 166, 1, 30000, 500, 500, 113, '2014-07-19 17:31:52', 1),
(2, 130, 1, 8000, 1000, 1000, 346, '2014-06-10 07:37:48', 1),
(3, 203, 1, 26000, 500, 500, 0, '2013-09-06 07:29:36', 1),
(4, 202, 1, 4000, 1000, 1000, 87, '2014-06-10 07:37:48', 1),
(5, 216, 1, 4500, 1000, 1000, 1000, '2012-07-19 06:41:27', 1),
(6, 215, 2, 35000, 500, 500, 500, '2012-07-19 06:42:09', 1),
(7, 57, 2, 1000, 1000, 1000, 1000, '2012-07-19 06:42:10', 1),
(8, 58, 2, 1000, 1000, 1000, 1000, '2012-07-19 06:42:10', 1),
(9, 59, 2, 800, 1000, 1000, 998, '2014-07-22 02:06:27', 1),
(10, 200, 2, 150000, 48, 48, 48, '2012-07-19 06:42:10', 1),
(11, 203, 3, 30000, 100, 100, 0, '2013-12-18 07:32:17', 1),
(12, 203, 4, 35000, 300, 300, 0, '2014-07-14 12:48:22', 1),
(13, 203, 5, 40000, 100, 100, 84, '2014-07-14 12:48:22', 1),
(14, 215, 6, 45000, 10, 9, 9, '2014-07-23 15:59:43', 1);

-- --------------------------------------------------------

--
-- Table structure for table `barang_satuan`
--

CREATE TABLE IF NOT EXISTS `barang_satuan` (
  `id_barangsatuan` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) NOT NULL,
  `status` int(11) NOT NULL,
  `createddate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `createdby` int(11) NOT NULL,
  `updateddate` timestamp NULL DEFAULT NULL,
  `updatedby` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_barangsatuan`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=46 ;

--
-- Dumping data for table `barang_satuan`
--

INSERT INTO `barang_satuan` (`id_barangsatuan`, `nama`, `status`, `createddate`, `createdby`, `updateddate`, `updatedby`) VALUES
(1, 'Zak', 1, '2014-03-15 18:35:22', 0, '2014-03-15 18:35:22', 1),
(2, 'Pcs', 1, '2014-04-17 22:07:55', 0, '2014-04-17 22:07:55', 1),
(3, 'Kaleng', 1, '2014-01-29 14:26:37', 0, '2014-01-29 14:26:37', 0),
(4, 'Meter Kubik (m3)', 1, '2014-01-29 03:26:20', 0, '2014-01-29 03:26:20', 0),
(5, 'Pcs', 0, '2014-04-17 22:07:23', 0, '2014-04-17 22:07:23', 1),
(25, 'Meter Persegi (m2)', 1, '2014-01-30 04:29:06', 0, '2014-01-30 04:29:06', 0),
(26, 'Meter', 1, '2014-01-29 03:21:35', 0, NULL, 0),
(27, 'Centimeter (cm)', 1, '2014-01-29 03:29:02', 0, NULL, 0),
(32, 'Centimeter Persegi (cm2)', 1, '2014-01-29 14:26:58', 0, NULL, 0),
(33, 'Centimeter Kubik (cm3)', 1, '2014-01-29 14:27:13', 0, NULL, 0),
(34, 'Kilogram (kg)', 1, '2014-01-29 14:27:42', 0, NULL, 0),
(35, 'Gram (g)', 1, '2014-01-30 00:31:47', 0, '2014-01-30 00:31:47', 0),
(36, 'Liter', 1, '2014-01-29 22:22:23', 0, NULL, 0),
(38, 'Tes', 0, '2014-03-01 12:20:30', 0, '2014-03-01 12:20:30', 0),
(39, 'Tes Kedua', 0, '2014-03-03 23:43:22', 0, '2014-03-03 23:43:22', 0),
(40, 'Tes2', 0, '2014-03-09 08:14:27', 0, '2014-03-09 08:14:27', 0),
(41, 'Bungkus', 1, '2014-03-09 12:31:56', 0, NULL, 0),
(42, 'Tes Lagi', 0, '2014-03-15 18:38:49', 1, '2014-03-15 18:38:49', 1),
(43, 'Tes3', 0, '2014-03-15 21:50:37', 1, '2014-03-15 21:50:37', 1),
(44, 'Tessssss', 0, '2014-04-17 21:46:35', 1, '2014-04-17 21:46:35', 1),
(45, 'Box', 0, '2014-04-17 22:07:17', 1, '2014-04-17 22:07:17', 1);

-- --------------------------------------------------------

--
-- Table structure for table `barang_transaksi`
--

CREATE TABLE IF NOT EXISTS `barang_transaksi` (
  `id_barangtransaksi` int(11) NOT NULL AUTO_INCREMENT,
  `id_pemasok` int(11) NOT NULL DEFAULT '0',
  `id_pelanggan` int(11) NOT NULL DEFAULT '0',
  `id_kategori` int(11) NOT NULL DEFAULT '0',
  `id_pembelian` int(11) NOT NULL DEFAULT '0',
  `id_returbeli` int(11) NOT NULL DEFAULT '0',
  `id_penjualan` int(11) NOT NULL DEFAULT '0',
  `id_returjual` int(11) NOT NULL DEFAULT '0',
  `id_stokopname` int(11) NOT NULL DEFAULT '0',
  `id_barang` int(11) NOT NULL DEFAULT '0',
  `jumlah_masuk` int(11) NOT NULL DEFAULT '0',
  `jumlah_keluar` int(11) NOT NULL DEFAULT '0',
  `harga` int(11) NOT NULL,
  `createddate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdby` int(11) NOT NULL,
  `updateddate` timestamp NULL DEFAULT NULL,
  `updatedby` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_barangtransaksi`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=119 ;

--
-- Dumping data for table `barang_transaksi`
--

INSERT INTO `barang_transaksi` (`id_barangtransaksi`, `id_pemasok`, `id_pelanggan`, `id_kategori`, `id_pembelian`, `id_returbeli`, `id_penjualan`, `id_returjual`, `id_stokopname`, `id_barang`, `jumlah_masuk`, `jumlah_keluar`, `harga`, `createddate`, `createdby`, `updateddate`, `updatedby`) VALUES
(1, 7, 0, 1, 1, 0, 0, 0, 0, 166, 500, 0, 30000, '2012-07-19 06:41:26', 1, NULL, NULL),
(2, 7, 0, 1, 1, 0, 0, 0, 0, 130, 1000, 0, 8000, '2012-07-19 06:41:26', 1, NULL, NULL),
(3, 7, 0, 1, 1, 0, 0, 0, 0, 203, 500, 0, 26000, '2012-07-19 06:41:27', 1, NULL, NULL),
(4, 7, 0, 1, 1, 0, 0, 0, 0, 202, 1000, 0, 4000, '2012-07-19 06:41:27', 1, NULL, NULL),
(5, 7, 0, 1, 1, 0, 0, 0, 0, 216, 1000, 0, 4500, '2012-07-19 06:41:27', 1, NULL, NULL),
(6, 11, 0, 1, 2, 0, 0, 0, 0, 215, 500, 0, 35000, '2012-07-19 06:42:09', 1, NULL, NULL),
(7, 11, 0, 1, 2, 0, 0, 0, 0, 57, 1000, 0, 1000, '2012-07-19 06:42:10', 1, NULL, NULL),
(8, 11, 0, 1, 2, 0, 0, 0, 0, 58, 1000, 0, 1000, '2012-07-19 06:42:10', 1, NULL, NULL),
(9, 11, 0, 1, 2, 0, 0, 0, 0, 59, 1000, 0, 800, '2012-07-19 06:42:10', 1, NULL, NULL),
(10, 11, 0, 1, 2, 0, 0, 0, 0, 200, 48, 0, 150000, '2012-07-19 06:42:10', 1, NULL, NULL),
(11, 0, 0, 2, 0, 0, 1, 0, 0, 166, 0, 20, 45000, '2012-07-19 06:42:44', 1, NULL, NULL),
(12, 0, 0, 2, 0, 0, 1, 0, 0, 130, 0, 15, 20000, '2012-07-19 06:42:45', 1, NULL, NULL),
(13, 0, 0, 2, 0, 0, 1, 0, 0, 203, 0, 30, 45000, '2012-07-19 06:42:45', 1, NULL, NULL),
(14, 0, 0, 2, 0, 0, 1, 0, 0, 202, 0, 20, 10000, '2012-07-19 06:42:45', 1, NULL, NULL),
(15, 0, 3, 2, 0, 0, 2, 0, 0, 166, 0, 29, 45000, '2012-08-08 06:44:07', 1, NULL, NULL),
(16, 0, 3, 2, 0, 0, 2, 0, 0, 130, 0, 17, 20000, '2012-08-08 06:44:07', 1, NULL, NULL),
(17, 0, 3, 2, 0, 0, 2, 0, 0, 203, 0, 34, 45000, '2012-08-08 06:44:07', 1, NULL, NULL),
(18, 0, 3, 2, 0, 0, 2, 0, 0, 202, 0, 22, 10000, '2012-08-08 06:44:07', 1, NULL, NULL),
(19, 0, 0, 2, 0, 0, 3, 0, 0, 166, 0, 10, 45000, '2012-09-14 06:45:22', 1, NULL, NULL),
(20, 0, 0, 2, 0, 0, 3, 0, 0, 130, 0, 19, 20000, '2012-09-14 06:45:22', 1, NULL, NULL),
(21, 0, 0, 2, 0, 0, 3, 0, 0, 203, 0, 40, 45000, '2012-09-14 06:45:22', 1, NULL, NULL),
(22, 0, 0, 2, 0, 0, 3, 0, 0, 202, 0, 25, 10000, '2012-09-14 06:45:23', 1, NULL, NULL),
(23, 0, 0, 2, 0, 0, 4, 0, 0, 166, 0, 8, 45000, '2012-10-10 06:46:35', 1, NULL, NULL),
(24, 0, 0, 2, 0, 0, 4, 0, 0, 130, 0, 21, 20000, '2012-10-10 06:46:35', 1, NULL, NULL),
(25, 0, 0, 2, 0, 0, 4, 0, 0, 203, 0, 37, 45000, '2012-10-10 06:46:35', 1, NULL, NULL),
(26, 0, 0, 2, 0, 0, 4, 0, 0, 202, 0, 27, 10000, '2012-10-10 06:46:36', 1, NULL, NULL),
(27, 0, 0, 2, 0, 0, 5, 0, 0, 166, 0, 5, 45000, '2012-11-20 07:04:55', 1, NULL, NULL),
(28, 0, 0, 2, 0, 0, 5, 0, 0, 130, 0, 22, 20000, '2012-11-20 07:04:55', 1, NULL, NULL),
(29, 0, 0, 2, 0, 0, 5, 0, 0, 203, 0, 31, 45000, '2012-11-20 07:04:55', 1, NULL, NULL),
(30, 0, 0, 2, 0, 0, 5, 0, 0, 202, 0, 25, 10000, '2012-11-20 07:04:55', 1, NULL, NULL),
(31, 0, 0, 2, 0, 0, 6, 0, 0, 166, 0, 10, 45000, '2012-12-15 07:05:53', 1, NULL, NULL),
(32, 0, 0, 2, 0, 0, 6, 0, 0, 130, 0, 22, 20000, '2012-12-15 07:05:53', 1, NULL, NULL),
(33, 0, 0, 2, 0, 0, 6, 0, 0, 203, 0, 37, 45000, '2012-12-15 07:05:53', 1, NULL, NULL),
(34, 0, 0, 2, 0, 0, 6, 0, 0, 202, 0, 20, 10000, '2012-12-15 07:05:53', 1, NULL, NULL),
(35, 0, 0, 2, 0, 0, 7, 0, 0, 166, 0, 30, 45000, '2013-01-16 07:07:05', 1, NULL, NULL),
(36, 0, 0, 2, 0, 0, 7, 0, 0, 130, 0, 23, 20000, '2013-01-16 07:07:05', 1, NULL, NULL),
(37, 0, 0, 2, 0, 0, 7, 0, 0, 203, 0, 29, 45000, '2013-01-16 07:07:05', 1, NULL, NULL),
(38, 0, 0, 2, 0, 0, 7, 0, 0, 202, 0, 40, 10000, '2013-01-16 07:07:06', 1, NULL, NULL),
(39, 0, 0, 2, 0, 0, 8, 0, 0, 166, 0, 20, 45000, '2013-02-20 07:08:05', 1, NULL, NULL),
(40, 0, 0, 2, 0, 0, 8, 0, 0, 130, 0, 25, 20000, '2013-02-20 07:08:05', 1, NULL, NULL),
(41, 0, 0, 2, 0, 0, 8, 0, 0, 203, 0, 32, 45000, '2013-02-20 07:08:05', 1, NULL, NULL),
(42, 0, 0, 2, 0, 0, 8, 0, 0, 202, 0, 44, 10000, '2013-02-20 07:08:05', 1, NULL, NULL),
(43, 0, 0, 2, 0, 0, 9, 0, 0, 166, 0, 5, 45000, '2013-03-06 07:21:38', 1, NULL, NULL),
(44, 0, 0, 2, 0, 0, 9, 0, 0, 130, 0, 27, 20000, '2013-03-06 07:21:38', 1, NULL, NULL),
(45, 0, 0, 2, 0, 0, 9, 0, 0, 203, 0, 35, 45000, '2013-03-06 07:21:39', 1, NULL, NULL),
(46, 0, 0, 2, 0, 0, 9, 0, 0, 202, 0, 50, 10000, '2013-03-06 07:21:39', 1, NULL, NULL),
(47, 0, 0, 2, 0, 0, 10, 0, 0, 166, 0, 10, 45000, '2013-04-11 07:22:36', 1, NULL, NULL),
(48, 0, 0, 2, 0, 0, 10, 0, 0, 130, 0, 27, 20000, '2013-04-11 07:22:36', 1, NULL, NULL),
(49, 0, 0, 2, 0, 0, 10, 0, 0, 203, 0, 31, 45000, '2013-04-11 07:22:36', 1, NULL, NULL),
(50, 0, 0, 2, 0, 0, 10, 0, 0, 202, 0, 54, 10000, '2013-04-11 07:22:36', 1, NULL, NULL),
(51, 0, 0, 2, 0, 0, 11, 0, 0, 166, 0, 5, 45000, '2013-05-23 07:23:28', 1, NULL, NULL),
(52, 0, 0, 2, 0, 0, 11, 0, 0, 130, 0, 25, 20000, '2013-05-23 07:23:28', 1, NULL, NULL),
(53, 0, 0, 2, 0, 0, 11, 0, 0, 203, 0, 36, 45000, '2013-05-23 07:23:29', 1, NULL, NULL),
(54, 0, 0, 2, 0, 0, 11, 0, 0, 202, 0, 50, 10000, '2013-05-23 07:23:29', 1, NULL, NULL),
(55, 0, 0, 2, 0, 0, 12, 0, 0, 166, 0, 15, 45000, '2013-05-31 07:24:58', 1, NULL, NULL),
(56, 0, 0, 2, 0, 0, 12, 0, 0, 130, 0, 28, 20000, '2013-05-31 07:24:58', 1, NULL, NULL),
(57, 0, 0, 2, 0, 0, 12, 0, 0, 203, 0, 39, 45000, '2013-05-31 07:24:58', 1, NULL, NULL),
(58, 0, 0, 2, 0, 0, 12, 0, 0, 202, 0, 40, 10000, '2013-05-31 07:24:58', 1, NULL, NULL),
(59, 0, 0, 2, 0, 0, 13, 0, 0, 166, 0, 25, 45000, '2013-07-16 07:25:44', 1, NULL, NULL),
(60, 0, 0, 2, 0, 0, 13, 0, 0, 130, 0, 29, 20000, '2013-07-16 07:25:45', 1, NULL, NULL),
(61, 0, 0, 2, 0, 0, 13, 0, 0, 203, 0, 41, 45000, '2013-07-16 07:25:45', 1, NULL, NULL),
(62, 0, 0, 2, 0, 0, 13, 0, 0, 202, 0, 30, 10000, '2013-07-16 07:25:45', 1, NULL, NULL),
(63, 0, 0, 2, 0, 0, 14, 0, 0, 166, 0, 30, 45000, '2013-08-15 07:27:34', 1, NULL, NULL),
(64, 0, 0, 2, 0, 0, 14, 0, 0, 130, 0, 30, 20000, '2013-08-15 07:27:34', 1, NULL, NULL),
(65, 0, 0, 2, 0, 0, 14, 0, 0, 203, 0, 35, 45000, '2013-08-15 07:27:34', 1, NULL, NULL),
(66, 0, 0, 2, 0, 0, 14, 0, 0, 202, 0, 34, 10000, '2013-08-15 07:27:35', 1, NULL, NULL),
(67, 3, 0, 1, 3, 0, 0, 0, 0, 203, 100, 0, 30000, '2013-09-06 07:28:55', 1, NULL, NULL),
(68, 0, 0, 2, 0, 0, 15, 0, 0, 166, 0, 15, 45000, '2013-09-06 07:29:35', 1, NULL, NULL),
(69, 0, 0, 2, 0, 0, 15, 0, 0, 130, 0, 28, 20000, '2013-09-06 07:29:36', 1, NULL, NULL),
(70, 0, 0, 2, 0, 0, 15, 0, 0, 203, 0, 30, 45000, '2013-09-06 07:29:36', 1, NULL, NULL),
(71, 0, 0, 2, 0, 0, 15, 0, 0, 202, 0, 40, 10000, '2013-09-06 07:29:36', 1, NULL, NULL),
(72, 0, 0, 2, 0, 0, 16, 0, 0, 166, 0, 15, 45000, '2013-10-29 07:30:12', 1, NULL, NULL),
(73, 0, 0, 2, 0, 0, 16, 0, 0, 130, 0, 31, 20000, '2013-10-29 07:30:13', 1, NULL, NULL),
(74, 0, 0, 2, 0, 0, 16, 0, 0, 203, 0, 32, 45000, '2013-10-29 07:30:13', 1, NULL, NULL),
(75, 0, 0, 2, 0, 0, 16, 0, 0, 202, 0, 44, 10000, '2013-10-29 07:30:13', 1, NULL, NULL),
(76, 11, 0, 1, 4, 0, 0, 0, 0, 203, 300, 0, 35000, '2013-10-29 07:30:35', 1, NULL, NULL),
(77, 0, 0, 2, 0, 0, 17, 0, 0, 166, 0, 10, 45000, '2013-11-13 07:31:51', 1, NULL, NULL),
(78, 0, 0, 2, 0, 0, 17, 0, 0, 130, 0, 32, 20000, '2013-11-13 07:31:51', 1, NULL, NULL),
(79, 0, 0, 2, 0, 0, 17, 0, 0, 203, 0, 36, 45000, '2013-11-13 07:31:51', 1, NULL, NULL),
(80, 0, 0, 2, 0, 0, 17, 0, 0, 202, 0, 40, 10000, '2013-11-13 07:31:51', 1, NULL, NULL),
(81, 0, 0, 2, 0, 0, 18, 0, 0, 166, 0, 15, 45000, '2013-12-18 07:32:16', 1, NULL, NULL),
(82, 0, 0, 2, 0, 0, 18, 0, 0, 130, 0, 30, 20000, '2013-12-18 07:32:17', 1, NULL, NULL),
(83, 0, 0, 2, 0, 0, 18, 0, 0, 203, 0, 39, 45000, '2013-12-18 07:32:17', 1, NULL, NULL),
(84, 0, 0, 2, 0, 0, 18, 0, 0, 202, 0, 30, 10000, '2013-12-18 07:32:17', 1, NULL, NULL),
(85, 0, 0, 2, 0, 0, 19, 0, 0, 166, 0, 21, 45000, '2014-01-30 07:33:11', 1, NULL, NULL),
(86, 0, 0, 2, 0, 0, 19, 0, 0, 130, 0, 31, 20000, '2014-01-30 07:33:11', 1, NULL, NULL),
(87, 0, 0, 2, 0, 0, 19, 0, 0, 203, 0, 40, 45000, '2014-01-30 07:33:11', 1, NULL, NULL),
(88, 0, 0, 2, 0, 0, 19, 0, 0, 202, 0, 40, 10000, '2014-01-30 07:33:11', 1, NULL, NULL),
(89, 0, 0, 2, 0, 0, 20, 0, 0, 166, 0, 32, 45000, '2014-02-12 07:33:54', 1, NULL, NULL),
(90, 0, 0, 2, 0, 0, 20, 0, 0, 130, 0, 30, 20000, '2014-02-12 07:33:55', 1, NULL, NULL),
(91, 0, 0, 2, 0, 0, 20, 0, 0, 203, 0, 35, 45000, '2014-02-12 07:33:55', 1, NULL, NULL),
(92, 0, 0, 2, 0, 0, 20, 0, 0, 202, 0, 44, 10000, '2014-02-12 07:33:55', 1, NULL, NULL),
(93, 0, 0, 2, 0, 0, 21, 0, 0, 166, 0, 17, 45000, '2014-03-11 07:35:01', 1, NULL, NULL),
(94, 0, 0, 2, 0, 0, 21, 0, 0, 130, 0, 32, 20000, '2014-03-11 07:35:01', 1, NULL, NULL),
(95, 0, 0, 2, 0, 0, 21, 0, 0, 203, 0, 33, 45000, '2014-03-11 07:35:01', 1, NULL, NULL),
(96, 0, 0, 2, 0, 0, 21, 0, 0, 202, 0, 50, 10000, '2014-03-11 07:35:01', 1, NULL, NULL),
(97, 0, 0, 2, 0, 0, 22, 0, 0, 166, 0, 10, 45000, '2014-04-17 07:36:03', 1, NULL, NULL),
(98, 0, 0, 2, 0, 0, 22, 0, 0, 130, 0, 35, 20000, '2014-04-17 07:36:03', 1, NULL, NULL),
(99, 0, 0, 2, 0, 0, 22, 0, 0, 203, 0, 34, 45000, '2014-04-17 07:36:03', 1, NULL, NULL),
(100, 0, 0, 2, 0, 0, 22, 0, 0, 202, 0, 54, 10000, '2014-04-17 07:36:03', 1, NULL, NULL),
(101, 0, 0, 2, 0, 0, 23, 0, 0, 166, 0, 5, 45000, '2014-05-28 07:37:05', 1, NULL, NULL),
(102, 0, 0, 2, 0, 0, 23, 0, 0, 130, 0, 36, 20000, '2014-05-28 07:37:05', 1, NULL, NULL),
(103, 0, 0, 2, 0, 0, 23, 0, 0, 203, 0, 31, 45000, '2014-05-28 07:37:06', 1, NULL, NULL),
(104, 0, 0, 2, 0, 0, 23, 0, 0, 202, 0, 50, 10000, '2014-05-28 07:37:06', 1, NULL, NULL),
(105, 0, 0, 2, 0, 0, 24, 0, 0, 166, 0, 10, 45000, '2014-06-10 07:37:48', 1, NULL, NULL),
(106, 0, 0, 2, 0, 0, 24, 0, 0, 130, 0, 39, 20000, '2014-06-10 07:37:48', 1, NULL, NULL),
(107, 0, 0, 2, 0, 0, 24, 0, 0, 203, 0, 29, 45000, '2014-06-10 07:37:48', 1, NULL, NULL),
(108, 0, 0, 2, 0, 0, 24, 0, 0, 202, 0, 40, 10000, '2014-06-10 07:37:48', 1, NULL, NULL),
(109, 0, 1, 4, 0, 0, 24, 1, 0, 166, 1, 0, 45000, '2014-07-14 09:37:41', 1, NULL, NULL),
(110, 0, 0, 2, 0, 0, 25, 0, 0, 166, 0, 10, 45000, '2014-07-14 10:00:48', 1, NULL, NULL),
(111, 0, 0, 2, 0, 0, 26, 0, 0, 166, 0, 15, 45000, '2014-07-14 12:27:29', 1, NULL, NULL),
(112, 0, 1, 4, 0, 0, 26, 2, 0, 166, 10, 0, 45000, '2014-07-14 12:30:42', 1, NULL, NULL),
(113, 11, 0, 1, 5, 0, 0, 0, 0, 203, 100, 0, 40000, '2014-07-14 12:47:46', 1, NULL, NULL),
(114, 0, 0, 2, 0, 0, 27, 0, 0, 203, 0, 90, 45000, '2014-07-14 12:48:22', 1, NULL, NULL),
(115, 11, 0, 1, 6, 0, 0, 0, 0, 215, 10, 0, 45000, '2014-07-19 17:28:12', 1, NULL, NULL),
(116, 0, 0, 2, 0, 0, 28, 0, 0, 166, 0, 1, 45000, '2014-07-19 17:31:51', 1, NULL, NULL),
(117, 0, 0, 2, 0, 0, 29, 0, 0, 59, 0, 2, 2500, '2014-07-22 02:06:27', 1, NULL, NULL),
(118, 11, 0, 3, 6, 1, 0, 0, 0, 215, 0, 1, 45000, '2014-07-23 15:59:43', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `barang_transaksi_kategori`
--

CREATE TABLE IF NOT EXISTS `barang_transaksi_kategori` (
  `id_barang_transaksi_kategori` int(11) NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(50) NOT NULL,
  PRIMARY KEY (`id_barang_transaksi_kategori`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `barang_transaksi_kategori`
--

INSERT INTO `barang_transaksi_kategori` (`id_barang_transaksi_kategori`, `nama_kategori`) VALUES
(1, 'Pembelian'),
(2, 'Penjualan'),
(3, 'Retur Beli'),
(4, 'Retur Jual'),
(5, 'Opname Stok Hilang'),
(6, 'Opname Stok Rusak');

-- --------------------------------------------------------

--
-- Table structure for table `daftar_akun`
--

CREATE TABLE IF NOT EXISTS `daftar_akun` (
  `id_daftarakun` int(11) NOT NULL AUTO_INCREMENT,
  `kode_akun` varchar(25) NOT NULL,
  `nama_akun` varchar(125) NOT NULL,
  `status` int(1) NOT NULL,
  `createddate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdby` int(11) NOT NULL DEFAULT '1',
  `updateddate` timestamp NULL DEFAULT NULL,
  `updatedby` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_daftarakun`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `daftar_akun`
--

INSERT INTO `daftar_akun` (`id_daftarakun`, `kode_akun`, `nama_akun`, `status`, `createddate`, `createdby`, `updateddate`, `updatedby`) VALUES
(1, '1.1.1', 'Kas', 1, '2014-04-18 14:50:16', 1, NULL, NULL),
(2, '1.1.2', 'Piutang Dagang', 1, '2014-04-18 14:53:00', 1, NULL, NULL),
(3, '1.1.3', 'Persediaan', 1, '2014-04-18 14:53:00', 1, NULL, NULL),
(4, '2.1.1', 'Utang Dagang', 1, '2014-04-18 14:53:00', 1, NULL, NULL),
(5, '4.1.1', 'Pendapatan Penjualan', 1, '2014-04-18 14:53:00', 1, NULL, NULL),
(6, '4.1.2', 'Retur dan Pengurangan Penjualan', 1, '2014-04-18 14:53:00', 1, NULL, NULL),
(7, '4.1.4', 'Biaya Angkut Penjualan', 1, '2014-04-18 14:53:00', 1, NULL, NULL),
(8, '5.1.1', 'Pembelian', 1, '2014-04-18 14:53:00', 1, NULL, NULL),
(9, '5.1.2', 'Retur Pembelian', 1, '2014-04-18 14:53:00', 1, NULL, NULL),
(10, '5.1.4', 'Beban Angkut Pembelian', 1, '2014-04-18 14:53:00', 1, NULL, NULL),
(11, '1.1.4', 'Harga Pokok Penjualan', 0, '2014-07-10 13:59:16', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `hutang`
--

CREATE TABLE IF NOT EXISTS `hutang` (
  `id_hutang` int(11) NOT NULL AUTO_INCREMENT,
  `no_nota` varchar(255) NOT NULL,
  `tanggal_pembayaran` date NOT NULL,
  `total` int(11) NOT NULL,
  `keterangan` varchar(255) NOT NULL DEFAULT '',
  `id_pemasok` int(11) NOT NULL,
  `createddate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdby` int(11) NOT NULL,
  PRIMARY KEY (`id_hutang`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `hutang`
--

INSERT INTO `hutang` (`id_hutang`, `no_nota`, `tanggal_pembayaran`, `total`, `keterangan`, `id_pemasok`, `createddate`, `createdby`) VALUES
(1, 'PJ/H/20140715/0001', '2014-07-15', 20000000, '', 11, '2014-07-14 12:28:59', 1),
(2, 'PJ/H/20140720/0002', '2014-07-20', 1000000, 'tes', 11, '2014-07-19 20:58:23', 1);

-- --------------------------------------------------------

--
-- Table structure for table `hutang_detail`
--

CREATE TABLE IF NOT EXISTS `hutang_detail` (
  `id_hutangdetail` int(11) NOT NULL AUTO_INCREMENT,
  `id_hutang` int(11) NOT NULL,
  `id_pembelian` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `sisa` int(11) NOT NULL,
  PRIMARY KEY (`id_hutangdetail`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `hutang_detail`
--

INSERT INTO `hutang_detail` (`id_hutangdetail`, `id_hutang`, `id_pembelian`, `total`, `sisa`) VALUES
(1, 1, 2, 20000000, 7500000),
(2, 2, 2, 1000000, 6500000);

-- --------------------------------------------------------

--
-- Table structure for table `jurnal_umum`
--

CREATE TABLE IF NOT EXISTS `jurnal_umum` (
  `id_jurnalumum` int(11) NOT NULL AUTO_INCREMENT,
  `id_kodeakun` int(11) NOT NULL,
  `id_pembelian` int(11) NOT NULL DEFAULT '0',
  `id_returbeli` int(11) NOT NULL DEFAULT '0',
  `id_hutang` int(11) NOT NULL DEFAULT '0',
  `id_penjualan` int(11) NOT NULL DEFAULT '0',
  `id_returjual` int(11) NOT NULL DEFAULT '0',
  `id_piutang` int(11) NOT NULL DEFAULT '0',
  `id_stokopname` int(11) NOT NULL DEFAULT '0',
  `tanggal` date NOT NULL,
  `debit` int(11) NOT NULL,
  `kredit` int(11) NOT NULL,
  `createddate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdby` int(11) NOT NULL,
  PRIMARY KEY (`id_jurnalumum`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=149 ;

--
-- Dumping data for table `jurnal_umum`
--

INSERT INTO `jurnal_umum` (`id_jurnalumum`, `id_kodeakun`, `id_pembelian`, `id_returbeli`, `id_hutang`, `id_penjualan`, `id_returjual`, `id_piutang`, `id_stokopname`, `tanggal`, `debit`, `kredit`, `createddate`, `createdby`) VALUES
(1, 3, 1, 0, 0, 0, 0, 0, 0, '2012-07-20', 44500000, 0, '2012-07-19 06:41:26', 1),
(2, 1, 1, 0, 0, 0, 0, 0, 0, '2012-07-20', 0, 44500000, '2012-07-19 06:41:26', 1),
(3, 3, 2, 0, 0, 0, 0, 0, 0, '2012-07-20', 27500000, 0, '2012-07-19 06:42:09', 1),
(4, 4, 2, 0, 0, 0, 0, 0, 0, '2012-07-20', 0, 27500000, '2012-07-19 06:42:09', 1),
(5, 1, 0, 0, 0, 1, 0, 0, 0, '2012-07-20', 2750000, 0, '2012-07-19 06:42:45', 1),
(6, 5, 0, 0, 0, 1, 0, 0, 0, '2012-07-20', 0, 2750000, '2012-07-19 06:42:45', 1),
(7, 11, 0, 0, 0, 1, 0, 0, 0, '2012-07-20', 1580000, 0, '2012-07-19 06:42:45', 1),
(8, 3, 0, 0, 0, 1, 0, 0, 0, '2012-07-20', 0, 1580000, '2012-07-19 06:42:45', 1),
(9, 2, 0, 0, 0, 2, 0, 0, 0, '2012-08-09', 3395000, 0, '2012-08-08 06:44:08', 1),
(10, 5, 0, 0, 0, 2, 0, 0, 0, '2012-08-09', 0, 3395000, '2012-08-08 06:44:08', 1),
(11, 11, 0, 0, 0, 2, 0, 0, 0, '2012-08-09', 1978000, 0, '2012-08-08 06:44:08', 1),
(12, 3, 0, 0, 0, 2, 0, 0, 0, '2012-08-09', 0, 1978000, '2012-08-08 06:44:08', 1),
(13, 1, 0, 0, 0, 3, 0, 0, 0, '2012-09-15', 2880000, 0, '2012-09-14 06:45:23', 1),
(14, 5, 0, 0, 0, 3, 0, 0, 0, '2012-09-15', 0, 2880000, '2012-09-14 06:45:23', 1),
(15, 11, 0, 0, 0, 3, 0, 0, 0, '2012-09-15', 1592000, 0, '2012-09-14 06:45:23', 1),
(16, 3, 0, 0, 0, 3, 0, 0, 0, '2012-09-15', 0, 1592000, '2012-09-14 06:45:23', 1),
(17, 1, 0, 0, 0, 4, 0, 0, 0, '2012-10-11', 2715000, 0, '2012-10-10 06:46:36', 1),
(18, 5, 0, 0, 0, 4, 0, 0, 0, '2012-10-11', 0, 2715000, '2012-10-10 06:46:36', 1),
(19, 11, 0, 0, 0, 4, 0, 0, 0, '2012-10-11', 1478000, 0, '2012-10-10 06:46:36', 1),
(20, 3, 0, 0, 0, 4, 0, 0, 0, '2012-10-11', 0, 1478000, '2012-10-10 06:46:36', 1),
(21, 1, 0, 0, 0, 5, 0, 0, 0, '2012-11-21', 2310000, 0, '2012-11-20 07:04:55', 1),
(22, 5, 0, 0, 0, 5, 0, 0, 0, '2012-11-21', 0, 2310000, '2012-11-20 07:04:55', 1),
(23, 11, 0, 0, 0, 5, 0, 0, 0, '2012-11-21', 1232000, 0, '2012-11-20 07:04:55', 1),
(24, 3, 0, 0, 0, 5, 0, 0, 0, '2012-11-21', 0, 1232000, '2012-11-20 07:04:56', 1),
(25, 1, 0, 0, 0, 6, 0, 0, 0, '2012-12-16', 2755000, 0, '2012-12-15 07:05:54', 1),
(26, 5, 0, 0, 0, 6, 0, 0, 0, '2012-12-16', 0, 2755000, '2012-12-15 07:05:54', 1),
(27, 11, 0, 0, 0, 6, 0, 0, 0, '2012-12-16', 1518000, 0, '2012-12-15 07:05:54', 1),
(28, 3, 0, 0, 0, 6, 0, 0, 0, '2012-12-16', 0, 1518000, '2012-12-15 07:05:54', 1),
(29, 1, 0, 0, 0, 7, 0, 0, 0, '2013-01-17', 3515000, 0, '2013-01-16 07:07:06', 1),
(30, 5, 0, 0, 0, 7, 0, 0, 0, '2013-01-17', 0, 3515000, '2013-01-16 07:07:06', 1),
(31, 11, 0, 0, 0, 7, 0, 0, 0, '2013-01-17', 1998000, 0, '2013-01-16 07:07:06', 1),
(32, 3, 0, 0, 0, 7, 0, 0, 0, '2013-01-17', 0, 1998000, '2013-01-16 07:07:06', 1),
(33, 1, 0, 0, 0, 8, 0, 0, 0, '2013-02-21', 3280000, 0, '2013-02-20 07:08:05', 1),
(34, 5, 0, 0, 0, 8, 0, 0, 0, '2013-02-21', 0, 3280000, '2013-02-20 07:08:05', 1),
(35, 11, 0, 0, 0, 8, 0, 0, 0, '2013-02-21', 1808000, 0, '2013-02-20 07:08:05', 1),
(36, 3, 0, 0, 0, 8, 0, 0, 0, '2013-02-21', 0, 1808000, '2013-02-20 07:08:05', 1),
(37, 1, 0, 0, 0, 9, 0, 0, 0, '2013-03-07', 2840000, 0, '2013-03-06 07:21:39', 1),
(38, 5, 0, 0, 0, 9, 0, 0, 0, '2013-03-07', 0, 2840000, '2013-03-06 07:21:39', 1),
(39, 11, 0, 0, 0, 9, 0, 0, 0, '2013-03-07', 1476000, 0, '2013-03-06 07:21:39', 1),
(40, 3, 0, 0, 0, 9, 0, 0, 0, '2013-03-07', 0, 1476000, '2013-03-06 07:21:39', 1),
(41, 1, 0, 0, 0, 10, 0, 0, 0, '2013-04-12', 2925000, 0, '2013-04-11 07:22:36', 1),
(42, 5, 0, 0, 0, 10, 0, 0, 0, '2013-04-12', 0, 2925000, '2013-04-11 07:22:36', 1),
(43, 11, 0, 0, 0, 10, 0, 0, 0, '2013-04-12', 1538000, 0, '2013-04-11 07:22:36', 1),
(44, 3, 0, 0, 0, 10, 0, 0, 0, '2013-04-12', 0, 1538000, '2013-04-11 07:22:36', 1),
(45, 1, 0, 0, 0, 11, 0, 0, 0, '2013-05-24', 2845000, 0, '2013-05-23 07:23:29', 1),
(46, 5, 0, 0, 0, 11, 0, 0, 0, '2013-05-24', 0, 2845000, '2013-05-23 07:23:29', 1),
(47, 11, 0, 0, 0, 11, 0, 0, 0, '2013-05-24', 1486000, 0, '2013-05-23 07:23:29', 1),
(48, 3, 0, 0, 0, 11, 0, 0, 0, '2013-05-24', 0, 1486000, '2013-05-23 07:23:29', 1),
(49, 1, 0, 0, 0, 12, 0, 0, 0, '2013-06-01', 3390000, 0, '2013-05-31 07:24:59', 1),
(50, 5, 0, 0, 0, 12, 0, 0, 0, '2013-06-01', 0, 3390000, '2013-05-31 07:24:59', 1),
(51, 11, 0, 0, 0, 12, 0, 0, 0, '2013-06-01', 1848000, 0, '2013-05-31 07:24:59', 1),
(52, 3, 0, 0, 0, 12, 0, 0, 0, '2013-06-01', 0, 1848000, '2013-05-31 07:24:59', 1),
(53, 1, 0, 0, 0, 13, 0, 0, 0, '2013-07-17', 3850000, 0, '2013-07-16 07:25:45', 1),
(54, 5, 0, 0, 0, 13, 0, 0, 0, '2013-07-17', 0, 3850000, '2013-07-16 07:25:45', 1),
(55, 11, 0, 0, 0, 13, 0, 0, 0, '2013-07-17', 2168000, 0, '2013-07-16 07:25:45', 1),
(56, 3, 0, 0, 0, 13, 0, 0, 0, '2013-07-17', 0, 2168000, '2013-07-16 07:25:45', 1),
(57, 1, 0, 0, 0, 14, 0, 0, 0, '2013-08-16', 3865000, 0, '2013-08-15 07:27:35', 1),
(58, 5, 0, 0, 0, 14, 0, 0, 0, '2013-08-16', 0, 3865000, '2013-08-15 07:27:35', 1),
(59, 11, 0, 0, 0, 14, 0, 0, 0, '2013-08-16', 2186000, 0, '2013-08-15 07:27:35', 1),
(60, 3, 0, 0, 0, 14, 0, 0, 0, '2013-08-16', 0, 2186000, '2013-08-15 07:27:35', 1),
(61, 3, 3, 0, 0, 0, 0, 0, 0, '2013-09-07', 3000000, 0, '2013-09-06 07:28:55', 1),
(62, 1, 3, 0, 0, 0, 0, 0, 0, '2013-09-07', 0, 3000000, '2013-09-06 07:28:55', 1),
(63, 1, 0, 0, 0, 15, 0, 0, 0, '2013-09-07', 2985000, 0, '2013-09-06 07:29:36', 1),
(64, 5, 0, 0, 0, 15, 0, 0, 0, '2013-09-07', 0, 2985000, '2013-09-06 07:29:36', 1),
(65, 11, 0, 0, 0, 15, 0, 0, 0, '2013-09-07', 1682000, 0, '2013-09-06 07:29:36', 1),
(66, 3, 0, 0, 0, 15, 0, 0, 0, '2013-09-07', 0, 1682000, '2013-09-06 07:29:36', 1),
(67, 1, 0, 0, 0, 16, 0, 0, 0, '2013-10-30', 3175000, 0, '2013-10-29 07:30:13', 1),
(68, 5, 0, 0, 0, 16, 0, 0, 0, '2013-10-30', 0, 3175000, '2013-10-29 07:30:13', 1),
(69, 11, 0, 0, 0, 16, 0, 0, 0, '2013-10-30', 1834000, 0, '2013-10-29 07:30:13', 1),
(70, 3, 0, 0, 0, 16, 0, 0, 0, '2013-10-30', 0, 1834000, '2013-10-29 07:30:13', 1),
(71, 3, 4, 0, 0, 0, 0, 0, 0, '2013-10-30', 10500000, 0, '2013-10-29 07:30:35', 1),
(72, 1, 4, 0, 0, 0, 0, 0, 0, '2013-10-30', 0, 10500000, '2013-10-29 07:30:35', 1),
(73, 1, 0, 0, 0, 17, 0, 0, 0, '2013-11-14', 3110000, 0, '2013-11-13 07:31:51', 1),
(74, 5, 0, 0, 0, 17, 0, 0, 0, '2013-11-14', 0, 3110000, '2013-11-13 07:31:51', 1),
(75, 11, 0, 0, 0, 17, 0, 0, 0, '2013-11-14', 1796000, 0, '2013-11-13 07:31:51', 1),
(76, 3, 0, 0, 0, 17, 0, 0, 0, '2013-11-14', 0, 1796000, '2013-11-13 07:31:51', 1),
(77, 1, 0, 0, 0, 18, 0, 0, 0, '2013-12-19', 3330000, 0, '2013-12-18 07:32:17', 1),
(78, 5, 0, 0, 0, 18, 0, 0, 0, '2013-12-19', 0, 3330000, '2013-12-18 07:32:17', 1),
(79, 11, 0, 0, 0, 18, 0, 0, 0, '2013-12-19', 2100000, 0, '2013-12-18 07:32:17', 1),
(80, 3, 0, 0, 0, 18, 0, 0, 0, '2013-12-19', 0, 2100000, '2013-12-18 07:32:17', 1),
(81, 1, 0, 0, 0, 19, 0, 0, 0, '2014-01-31', 3765000, 0, '2014-01-30 07:33:11', 1),
(82, 5, 0, 0, 0, 19, 0, 0, 0, '2014-01-31', 0, 3765000, '2014-01-30 07:33:11', 1),
(83, 11, 0, 0, 0, 19, 0, 0, 0, '2014-01-31', 2438000, 0, '2014-01-30 07:33:11', 1),
(84, 3, 0, 0, 0, 19, 0, 0, 0, '2014-01-31', 0, 2438000, '2014-01-30 07:33:11', 1),
(85, 1, 0, 0, 0, 20, 0, 0, 0, '2014-02-13', 4055000, 0, '2014-02-12 07:33:55', 1),
(86, 5, 0, 0, 0, 20, 0, 0, 0, '2014-02-13', 0, 4055000, '2014-02-12 07:33:55', 1),
(87, 11, 0, 0, 0, 20, 0, 0, 0, '2014-02-13', 2601000, 0, '2014-02-12 07:33:55', 1),
(88, 3, 0, 0, 0, 20, 0, 0, 0, '2014-02-13', 0, 2601000, '2014-02-12 07:33:55', 1),
(89, 1, 0, 0, 0, 21, 0, 0, 0, '2014-03-12', 3390000, 0, '2014-03-11 07:35:02', 1),
(90, 5, 0, 0, 0, 21, 0, 0, 0, '2014-03-12', 0, 3390000, '2014-03-11 07:35:02', 1),
(91, 11, 0, 0, 0, 21, 0, 0, 0, '2014-03-12', 2121000, 0, '2014-03-11 07:35:02', 1),
(92, 3, 0, 0, 0, 21, 0, 0, 0, '2014-03-12', 0, 2121000, '2014-03-11 07:35:02', 1),
(93, 1, 0, 0, 0, 22, 0, 0, 0, '2014-04-18', 3220000, 0, '2014-04-17 07:36:03', 1),
(94, 5, 0, 0, 0, 22, 0, 0, 0, '2014-04-18', 0, 3220000, '2014-04-17 07:36:03', 1),
(95, 11, 0, 0, 0, 22, 0, 0, 0, '2014-04-18', 1986000, 0, '2014-04-17 07:36:03', 1),
(96, 3, 0, 0, 0, 22, 0, 0, 0, '2014-04-18', 0, 1986000, '2014-04-17 07:36:03', 1),
(97, 1, 0, 0, 0, 23, 0, 0, 0, '2014-05-29', 2840000, 0, '2014-05-28 07:37:06', 1),
(98, 5, 0, 0, 0, 23, 0, 0, 0, '2014-05-29', 0, 2840000, '2014-05-28 07:37:06', 1),
(99, 11, 0, 0, 0, 23, 0, 0, 0, '2014-05-29', 1723000, 0, '2014-05-28 07:37:06', 1),
(100, 3, 0, 0, 0, 23, 0, 0, 0, '2014-05-29', 0, 1723000, '2014-05-28 07:37:06', 1),
(101, 1, 0, 0, 0, 24, 0, 0, 0, '2014-06-11', 2935000, 0, '2014-06-10 07:37:48', 1),
(102, 5, 0, 0, 0, 24, 0, 0, 0, '2014-06-11', 0, 2935000, '2014-06-10 07:37:48', 1),
(103, 11, 0, 0, 0, 24, 0, 0, 0, '2014-06-11', 1787000, 0, '2014-06-10 07:37:48', 1),
(104, 3, 0, 0, 0, 24, 0, 0, 0, '2014-06-11', 0, 1787000, '2014-06-10 07:37:48', 1),
(105, 1, 0, 0, 0, 0, 0, 1, 0, '2014-07-15', 1000000, 0, '2014-07-14 09:37:00', 1),
(106, 2, 0, 0, 0, 0, 0, 1, 0, '2014-07-15', 0, 1000000, '2014-07-14 09:37:00', 1),
(107, 6, 0, 0, 0, 0, 1, 0, 0, '2014-07-15', 45000, 0, '2014-07-14 09:37:41', 1),
(108, 1, 0, 0, 0, 0, 1, 0, 0, '2014-07-15', 0, 45000, '2014-07-14 09:37:41', 1),
(109, 3, 0, 0, 0, 0, 1, 0, 0, '2014-07-15', 30000, 0, '2014-07-14 09:37:41', 1),
(110, 11, 0, 0, 0, 0, 1, 0, 0, '2014-07-15', 0, 30000, '2014-07-14 09:37:41', 1),
(111, 1, 0, 0, 0, 25, 0, 0, 0, '2014-07-15', 450000, 0, '2014-07-14 10:00:48', 1),
(112, 5, 0, 0, 0, 25, 0, 0, 0, '2014-07-15', 0, 450000, '2014-07-14 10:00:48', 1),
(113, 11, 0, 0, 0, 25, 0, 0, 0, '2014-07-15', 300000, 0, '2014-07-14 10:00:48', 1),
(114, 3, 0, 0, 0, 25, 0, 0, 0, '2014-07-15', 0, 300000, '2014-07-14 10:00:48', 1),
(115, 1, 0, 0, 0, 26, 0, 0, 0, '2014-07-15', 675000, 0, '2014-07-14 12:27:29', 1),
(116, 5, 0, 0, 0, 26, 0, 0, 0, '2014-07-15', 0, 675000, '2014-07-14 12:27:29', 1),
(117, 11, 0, 0, 0, 26, 0, 0, 0, '2014-07-15', 450000, 0, '2014-07-14 12:27:29', 1),
(118, 3, 0, 0, 0, 26, 0, 0, 0, '2014-07-15', 0, 450000, '2014-07-14 12:27:29', 1),
(119, 4, 0, 0, 1, 0, 0, 0, 0, '2014-07-15', 20000000, 0, '2014-07-14 12:28:59', 1),
(120, 1, 0, 0, 1, 0, 0, 0, 0, '2014-07-15', 0, 20000000, '2014-07-14 12:28:59', 1),
(121, 6, 0, 0, 0, 0, 2, 0, 0, '2014-07-15', 450000, 0, '2014-07-14 12:30:43', 1),
(122, 2, 0, 0, 0, 0, 2, 0, 0, '2014-07-15', 0, 450000, '2014-07-14 12:30:43', 1),
(123, 3, 0, 0, 0, 0, 2, 0, 0, '2014-07-15', 300000, 0, '2014-07-14 12:30:43', 1),
(124, 11, 0, 0, 0, 0, 2, 0, 0, '2014-07-15', 0, 300000, '2014-07-14 12:30:43', 1),
(125, 3, 5, 0, 0, 0, 0, 0, 0, '2014-07-15', 4000000, 0, '2014-07-14 12:47:46', 1),
(126, 1, 5, 0, 0, 0, 0, 0, 0, '2014-07-15', 0, 4000000, '2014-07-14 12:47:46', 1),
(127, 1, 0, 0, 0, 27, 0, 0, 0, '2014-07-15', 4050000, 0, '2014-07-14 12:48:22', 1),
(128, 5, 0, 0, 0, 27, 0, 0, 0, '2014-07-15', 0, 4050000, '2014-07-14 12:48:22', 1),
(129, 11, 0, 0, 0, 27, 0, 0, 0, '2014-07-15', 3230000, 0, '2014-07-14 12:48:22', 1),
(130, 3, 0, 0, 0, 27, 0, 0, 0, '2014-07-15', 0, 3230000, '2014-07-14 12:48:22', 1),
(131, 3, 6, 0, 0, 0, 0, 0, 0, '2014-07-20', 450000, 0, '2014-07-19 17:28:12', 1),
(132, 1, 6, 0, 0, 0, 0, 0, 0, '2014-07-20', 0, 450000, '2014-07-19 17:28:12', 1),
(133, 10, 6, 0, 0, 0, 0, 0, 0, '2014-07-20', 50000, 0, '2014-07-19 17:28:12', 1),
(134, 1, 6, 0, 0, 0, 0, 0, 0, '2014-07-20', 0, 50000, '2014-07-19 17:28:12', 1),
(135, 1, 0, 0, 0, 28, 0, 0, 0, '2014-07-20', 45000, 0, '2014-07-19 17:31:52', 1),
(136, 5, 0, 0, 0, 28, 0, 0, 0, '2014-07-20', 0, 45000, '2014-07-19 17:31:52', 1),
(137, 11, 0, 0, 0, 28, 0, 0, 0, '2014-07-20', 30000, 0, '2014-07-19 17:31:52', 1),
(138, 3, 0, 0, 0, 28, 0, 0, 0, '2014-07-20', 0, 30000, '2014-07-19 17:31:52', 1),
(139, 4, 0, 0, 2, 0, 0, 0, 0, '2014-07-20', 1000000, 0, '2014-07-19 20:58:23', 1),
(140, 1, 0, 0, 2, 0, 0, 0, 0, '2014-07-20', 0, 1000000, '2014-07-19 20:58:23', 1),
(141, 1, 0, 0, 0, 0, 0, 2, 0, '2014-07-20', 1000000, 0, '2014-07-19 20:59:04', 1),
(142, 2, 0, 0, 0, 0, 0, 2, 0, '2014-07-20', 0, 1000000, '2014-07-19 20:59:04', 1),
(143, 1, 0, 0, 0, 29, 0, 0, 0, '2014-07-22', 5000, 0, '2014-07-22 02:06:27', 1),
(144, 5, 0, 0, 0, 29, 0, 0, 0, '2014-07-22', 0, 5000, '2014-07-22 02:06:27', 1),
(145, 11, 0, 0, 0, 29, 0, 0, 0, '2014-07-22', 1600, 0, '2014-07-22 02:06:27', 1),
(146, 3, 0, 0, 0, 29, 0, 0, 0, '2014-07-22', 0, 1600, '2014-07-22 02:06:27', 1),
(147, 1, 0, 1, 0, 0, 0, 0, 0, '2014-07-23', 45000, 0, '2014-07-23 15:59:43', 1),
(148, 3, 0, 1, 0, 0, 0, 0, 0, '2014-07-23', 0, 45000, '2014-07-23 15:59:43', 1);

-- --------------------------------------------------------

--
-- Table structure for table `kendaraan`
--

CREATE TABLE IF NOT EXISTS `kendaraan` (
  `id_kendaraan` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) NOT NULL,
  `no_plat` varchar(50) NOT NULL,
  `status` int(11) NOT NULL,
  `createddate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdby` int(11) NOT NULL,
  `updateddate` timestamp NULL DEFAULT NULL,
  `updatedby` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_kendaraan`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `kendaraan`
--

INSERT INTO `kendaraan` (`id_kendaraan`, `nama`, `no_plat`, `status`, `createddate`, `createdby`, `updateddate`, `updatedby`) VALUES
(1, 'Suzuki Carry Pickup 1.5', 'D1645VR', 1, '2014-05-20 16:37:52', 1, '2014-05-20 16:48:36', 1),
(2, 'Hino Truck Sedang', 'D6819Y', 1, '2014-07-01 17:09:44', 1, '2014-07-01 18:27:30', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pegawai`
--

CREATE TABLE IF NOT EXISTS `pegawai` (
  `id_pegawai` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(25) NOT NULL,
  `password` varchar(32) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `telepon` varchar(25) NOT NULL,
  `id_posisi` int(11) NOT NULL,
  `status` int(1) NOT NULL,
  `createddate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdby` int(1) NOT NULL,
  `updateddate` timestamp NULL DEFAULT NULL,
  `updatedby` int(1) DEFAULT NULL,
  `gambar` varchar(100) NOT NULL,
  PRIMARY KEY (`id_pegawai`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `pegawai`
--

INSERT INTO `pegawai` (`id_pegawai`, `username`, `password`, `nama`, `alamat`, `telepon`, `id_posisi`, `status`, `createddate`, `createdby`, `updateddate`, `updatedby`, `gambar`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Vicky Rahadian F.', 'Cicalengka', '08984763146', 1, 1, '2013-11-15 18:23:36', 0, '2014-03-21 16:53:41', 1, 'admin-6f9101005d9665bd81248957b6543c97.jpg'),
(2, 'superadmin', 'de95b43bceeb4b998aed4aed5cef1ae7', 'Super Administrator', 'Super Administrator', '0', 1, 0, '2014-02-28 04:53:12', 0, '2014-03-15 22:51:20', 1, 'superadmin-c9ca6742fc8745e75afa4e9ac23cc96c.jpg'),
(3, 'sendi', '8b15d7aecb51a9e61b91a8348757676e', 'Sendi Budiawan', 'Cicalengka', '08565229391', 4, 0, '2014-03-01 15:15:07', 0, '2014-03-15 22:45:56', 1, 'admin-deae8081dc370a29a02a88cf8f1f0367.jpg'),
(4, 'johanca', '808fb9dd2092ea10615b9eac8805f7c7', 'Johan Cabaye', 'Newcastle', '1', 1, 0, '2014-03-15 22:37:46', 1, '2014-03-15 22:46:06', 1, '1-62ad8bbf681a78c26f07e92543054582.jpg'),
(5, 'alexis', '81dc9bdb52d04dc20036dbd8313ed055', 'Alexis Sanchez', 'Spanyol', '123', 2, 0, '2014-03-15 22:48:10', 1, '2014-03-15 22:48:44', 1, '1-b491546e6b8ada86d9b6571afe6df4f8.jpg'),
(6, 'soleh', 'a08e7920aa24da147fe58c2710dc646a', 'M. Solehpati', 'Cihanjuang', '-', 4, 1, '2014-05-16 12:39:43', 1, '2014-06-07 09:09:19', 1, '1-10a2b77492a2a2237017488ba0f1becf.jpg'),
(7, 'asepn', 'dc855efb0dc7476760afaa1b281665f1', 'Asep Nugraha', 'Cikancung', '08956485474', 3, 1, '2014-06-09 03:38:27', 1, '2014-06-09 03:43:26', 1, '1-158956ecd4fb0a5c671913daf0dbebf7.jpg'),
(8, 'indah', 'f3385c508ce54d577fd205a1b2ecdfb7', 'Indah Pratiwi', 'Cicalengka', '08956548752', 5, 1, '2014-06-09 03:39:35', 1, NULL, 0, '1-8df547efa7ee13b4086a6e448a883ebb.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `pegawai_posisi`
--

CREATE TABLE IF NOT EXISTS `pegawai_posisi` (
  `id_posisi` int(11) NOT NULL AUTO_INCREMENT,
  `nama_posisi` varchar(25) NOT NULL,
  `kode_posisi` varchar(25) NOT NULL,
  PRIMARY KEY (`id_posisi`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `pegawai_posisi`
--

INSERT INTO `pegawai_posisi` (`id_posisi`, `nama_posisi`, `kode_posisi`) VALUES
(1, 'Administrator', 'adm'),
(2, 'Pemilik', 'own'),
(3, 'Bagian Penjualan', 'csh'),
(4, 'Bagian Gudang / Inventori', 'inv'),
(5, 'Keuangan', 'fin');

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE IF NOT EXISTS `pelanggan` (
  `id_pelanggan` int(11) NOT NULL AUTO_INCREMENT,
  `kode` varchar(25) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `kontak` varchar(50) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `kota` varchar(25) NOT NULL,
  `kodepos` varchar(5) NOT NULL,
  `telepon` varchar(25) NOT NULL,
  `fax` varchar(25) NOT NULL,
  `email` varchar(255) NOT NULL,
  `website` varchar(255) NOT NULL,
  `gambar` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `createddate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdby` int(11) NOT NULL,
  `updateddate` timestamp NULL DEFAULT NULL,
  `updatedby` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_pelanggan`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `kode`, `nama`, `kontak`, `alamat`, `kota`, `kodepos`, `telepon`, `fax`, `email`, `website`, `gambar`, `status`, `createddate`, `createdby`, `updateddate`, `updatedby`) VALUES
(1, '', '-', '-', '-', '-', '-', '-', '-', '', '', '1-7a2bc546847c4fd64ea17fbe5257b509.jpg', 1, '2014-03-21 05:15:15', 1, '2014-07-19 17:13:39', 1),
(2, 'C0001', 'CV Maju Mundur', 'Vicky Rahadian Firmansyah  ', 'Jl. Dewi Sartika 16 Cicalengka', 'Bandung  ', '40395', '08984763146', '', '', '', '1-d3d8256706f723295d592be19346c083.jpg', 1, '2013-11-23 17:03:23', 0, '2014-03-15 16:12:52', 1),
(3, 'C0002', 'CV Pasanda', 'Christine Hermon  Pasanda  ', 'Gang Babakan Ciamis  ', 'Bandung', '41283', '085659239052', '', '', '', '1-2ba94a60145d614ab409836148bfea0e.jpg', 1, '2013-12-12 02:39:23', 0, '2014-04-16 22:03:47', 1),
(4, 'C0003', 'Tesss', 'Tes Kontakss', 'Alamat Tesss', 'Kota Tessss', '1234', '1234', '4567', 'tes@gmail.coms', 'tes.coms', '1-917a54f9acb50a246834fee3d46b584e.jpg', 0, '2014-03-30 21:24:09', 1, '2014-03-30 21:27:33', 1),
(5, 'C0004', 'Tes Again', 'Kontak Tes Again', 'Alamat Tes Again', 'Kota Tes Again', '54321', '321', '654', 'tesagain@gmail.com', 'tesagain.com', '1-d3d8256706f723295d592be19346c083.jpg', 0, '2014-03-30 21:25:33', 1, '2014-03-30 21:25:53', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pemasok`
--

CREATE TABLE IF NOT EXISTS `pemasok` (
  `id_pemasok` int(11) NOT NULL AUTO_INCREMENT,
  `kode` varchar(25) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `kontak` varchar(50) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `kota` varchar(25) NOT NULL,
  `kodepos` varchar(5) NOT NULL,
  `telepon` varchar(25) NOT NULL,
  `fax` varchar(25) NOT NULL,
  `email` varchar(255) NOT NULL,
  `website` varchar(255) NOT NULL,
  `gambar` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `createddate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdby` int(11) NOT NULL,
  `updateddate` timestamp NULL DEFAULT NULL,
  `updatedby` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_pemasok`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `pemasok`
--

INSERT INTO `pemasok` (`id_pemasok`, `kode`, `nama`, `kontak`, `alamat`, `kota`, `kodepos`, `telepon`, `fax`, `email`, `website`, `gambar`, `status`, `createddate`, `createdby`, `updateddate`, `updatedby`) VALUES
(1, 'V0002', 'PT Samudera Tunggal Utama', 'Rahmat', 'Jl. Raya Kopo 455, Cirangrang, Babakan Ciparay', 'Bandung ', '42122', '0225416461', '', '', '', 'admin-375722e382a092f6ac9a7212155acd01.jpg', 1, '2013-12-17 03:07:43', 0, '2014-03-28 15:47:52', 1),
(3, 'V0003', 'CV Avipen Adhitama', 'Bayu', 'Jl. Raya Pasar Kemis Km. 7 No 39', 'Tangerang', '14321', '0215928880', '0215905529', '', '', 'admin-51aaf112a22c6f503e8e2ba991acbb7f.jpg', 1, '2014-01-10 19:02:42', 0, '2014-03-28 19:07:47', 1),
(4, 'V0004', 'PT Geotechnical Systemindo', 'Arif', 'Menara Mth, Mezzanine Floor, Suite 01 Jl. Mt. Haryono Kav. 23', 'Jakarta', '13321', '02183782609', '', '', '', 'admin-cae5683d0011fa9902e26c8d777c56ad.jpg', 1, '2014-01-27 00:07:10', 0, '2014-04-05 01:13:26', 1),
(5, 'V0005', 'CV Sekar Sion ', 'Bagus', 'Bambu Duri Xi No 4 Pondok Bambu - Duren Sawit', 'Jakarta', '13212', '0218611740', '', '', '', 'admin-7d7507dedaceb1c2eb28dd315229c31b.jpg', 1, '2014-01-27 00:21:26', 0, '2014-03-28 15:47:38', 1),
(7, 'V0001', 'Agis Jaya Steels', 'Agus', 'Jl. Melong No 23 A Blok Hegarmanah', 'Cimahi', '12345', '02276844305', '02276844312', 'aegisjs@gmail.com', 'www.aegis.com', '1-8ed0c8611401f22d74ba5a84523a0507.jpg', 1, '2014-02-26 10:24:50', 0, '2014-03-28 18:51:15', 1),
(9, 'V0008', 'Nama2', 'Kontak2', 'Alamat2', 'Kota2', '12345', 'Telp2', 'Fax2', 'email@email.email2', 'website.com2', '1-b491546e6b8ada86d9b6571afe6df4f8.jpg', 0, '2014-03-28 15:35:09', 1, '2014-03-28 18:51:10', 1),
(10, 'V0010', 'CV Maju Mundur', 'Mundur', 'Bangun', 'Bandung', '11111', '123456', '1234567', '', '123.com', '', 0, '2014-03-29 22:19:05', 1, '2014-04-08 06:56:27', 1),
(11, 'V0011', 'PT Laminatech Kreasi Sarana', 'Ayu', 'Graha Vivere 5 Th Floor, Jl. Letjend S. Parman No. 6 ', 'Jakarta ', '11480', '0215365 1578', '0215365 1607', 'info.lks@vivere.co.id', 'http://lks.co.id', '1-e3edfc3bfdc61ce7ca118842555746d4.jpg', 1, '2014-04-08 06:55:41', 1, '2014-04-08 06:56:09', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pembelian`
--

CREATE TABLE IF NOT EXISTS `pembelian` (
  `id_pembelian` int(11) NOT NULL AUTO_INCREMENT,
  `no_nota` varchar(255) NOT NULL,
  `no_faktur` varchar(255) NOT NULL,
  `subtotal` int(11) NOT NULL,
  `biaya_kirim` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `bayar` int(11) NOT NULL,
  `status_pembayaran` int(1) NOT NULL DEFAULT '0',
  `keterangan` varchar(255) NOT NULL,
  `id_pemasok` int(11) NOT NULL,
  `tanggal_pembelian` date NOT NULL,
  `jatuh_tempo` date NOT NULL,
  `createddate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdby` int(11) NOT NULL,
  `islunas` int(1) NOT NULL DEFAULT '0',
  `id_purchaseorder` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_pembelian`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `pembelian`
--

INSERT INTO `pembelian` (`id_pembelian`, `no_nota`, `no_faktur`, `subtotal`, `biaya_kirim`, `total`, `bayar`, `status_pembayaran`, `keterangan`, `id_pemasok`, `tanggal_pembelian`, `jatuh_tempo`, `createddate`, `createdby`, `islunas`, `id_purchaseorder`) VALUES
(1, 'PJ/1/20120719/0001', 'A', 44500000, 0, 44500000, 44500000, 1, '', 7, '2012-07-20', '2012-07-20', '2012-07-19 06:41:26', 1, 1, 0),
(2, 'PJ/1/20120719/0002', 'B', 27500000, 0, 27500000, 0, 0, '', 11, '2012-07-20', '2012-08-09', '2012-07-19 06:42:09', 1, 0, 0),
(3, 'PJ/1/20130906/0003', 'SD', 3000000, 0, 3000000, 3000000, 1, '', 3, '2013-09-07', '2013-09-07', '2013-09-06 07:28:55', 1, 1, 0),
(4, 'PJ/1/20131029/0004', 'ASDW', 10500000, 0, 10500000, 10500000, 1, '', 11, '2013-10-30', '2013-10-30', '2013-10-29 07:30:35', 1, 1, 0),
(5, 'PJ/1/20140715/0005', 'OSAJD', 4000000, 0, 4000000, 4000000, 1, '', 11, '2014-07-15', '2014-07-15', '2014-07-14 12:47:46', 1, 1, 0),
(6, 'PJ/1/20140720/0006', 'A', 450000, 50000, 500000, 500000, 1, 'TES', 11, '2014-07-20', '2014-07-20', '2014-07-19 17:28:12', 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `pembelian_detail`
--

CREATE TABLE IF NOT EXISTS `pembelian_detail` (
  `id_pembeliandetail` int(11) NOT NULL AUTO_INCREMENT,
  `id_pembelian` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `harga` double NOT NULL,
  `jumlah` int(11) NOT NULL,
  PRIMARY KEY (`id_pembeliandetail`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `pembelian_detail`
--

INSERT INTO `pembelian_detail` (`id_pembeliandetail`, `id_pembelian`, `id_barang`, `harga`, `jumlah`) VALUES
(1, 1, 166, 30000, 500),
(2, 1, 130, 8000, 1000),
(3, 1, 203, 26000, 500),
(4, 1, 202, 4000, 1000),
(5, 1, 216, 4500, 1000),
(6, 2, 215, 35000, 500),
(7, 2, 57, 1000, 1000),
(8, 2, 58, 1000, 1000),
(9, 2, 59, 800, 1000),
(10, 2, 200, 150000, 48),
(11, 3, 203, 30000, 100),
(12, 4, 203, 35000, 300),
(13, 5, 203, 40000, 100),
(14, 6, 215, 45000, 10);

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

CREATE TABLE IF NOT EXISTS `penjualan` (
  `id_penjualan` int(11) NOT NULL AUTO_INCREMENT,
  `no_faktur` varchar(255) NOT NULL,
  `subtotal` int(11) NOT NULL,
  `biaya_kirim` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `bayar` int(11) NOT NULL,
  `kembali` int(11) NOT NULL,
  `status_pembayaran` int(1) NOT NULL DEFAULT '0',
  `keterangan` varchar(255) NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `tanggal_penjualan` date NOT NULL,
  `jatuh_tempo` date NOT NULL,
  `createddate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdby` int(11) NOT NULL,
  `islunas` int(1) NOT NULL DEFAULT '0',
  `id_kendaraan` int(11) NOT NULL,
  PRIMARY KEY (`id_penjualan`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=30 ;

--
-- Dumping data for table `penjualan`
--

INSERT INTO `penjualan` (`id_penjualan`, `no_faktur`, `subtotal`, `biaya_kirim`, `total`, `bayar`, `kembali`, `status_pembayaran`, `keterangan`, `id_pelanggan`, `tanggal_penjualan`, `jatuh_tempo`, `createddate`, `createdby`, `islunas`, `id_kendaraan`) VALUES
(1, 'PJ/2/20120719/0001', 2750000, 0, 2750000, 2750000, 0, 1, 'tes', 1, '2012-07-20', '2012-07-20', '2012-07-19 06:42:44', 1, 1, 0),
(2, 'PJ/2/20120808/0002', 3395000, 0, 3395000, 0, 0, 0, '', 3, '2012-08-09', '2012-08-09', '2012-08-08 06:44:07', 1, 0, 0),
(3, 'PJ/2/20120914/0003', 2880000, 0, 2880000, 2880000, 0, 1, '', 1, '2012-09-15', '2012-09-15', '2012-09-14 06:45:22', 1, 1, 0),
(4, 'PJ/2/20121010/0004', 2715000, 0, 2715000, 2715000, 0, 1, '', 1, '2012-10-11', '2012-10-11', '2012-10-10 06:46:35', 1, 1, 0),
(5, 'PJ/2/20121120/0005', 2310000, 0, 2310000, 2310000, 0, 1, '', 1, '2012-11-21', '2012-11-21', '2012-11-20 07:04:55', 1, 1, 0),
(6, 'PJ/2/20121215/0006', 2755000, 0, 2755000, 3000000, 245000, 1, '', 1, '2012-12-16', '2012-12-16', '2012-12-15 07:05:53', 1, 1, 0),
(7, 'PJ/2/20130116/0007', 3515000, 0, 3515000, 3515000, 0, 1, '', 1, '2013-01-17', '2013-01-17', '2013-01-16 07:07:05', 1, 1, 0),
(8, 'PJ/2/20130220/0008', 3280000, 0, 3280000, 3280000, 0, 1, '', 1, '2013-02-21', '2013-02-21', '2013-02-20 07:08:04', 1, 1, 0),
(9, 'PJ/2/20130306/0009', 2840000, 0, 2840000, 2840000, 0, 1, '', 1, '2013-03-07', '2013-03-07', '2013-03-06 07:21:38', 1, 1, 0),
(10, 'PJ/2/20130411/0010', 2925000, 0, 2925000, 2925000, 0, 1, '', 1, '2013-04-12', '2013-04-12', '2013-04-11 07:22:35', 1, 1, 0),
(11, 'PJ/2/20130523/0011', 2845000, 0, 2845000, 2845000, 0, 1, '', 1, '2013-05-24', '2013-05-24', '2013-05-23 07:23:28', 1, 1, 0),
(12, 'PJ/2/20130531/0012', 3390000, 0, 3390000, 3390000, 0, 1, '', 1, '2013-06-01', '2013-06-01', '2013-05-31 07:24:58', 1, 1, 0),
(13, 'PJ/2/20130716/0013', 3850000, 0, 3850000, 3850000, 0, 1, '', 1, '2013-07-17', '2013-07-17', '2013-07-16 07:25:44', 1, 1, 0),
(14, 'PJ/2/20130815/0014', 3865000, 0, 3865000, 3865000, 0, 1, '', 1, '2013-08-16', '2013-08-16', '2013-08-15 07:27:34', 1, 1, 0),
(15, 'PJ/2/20130906/0015', 2985000, 0, 2985000, 2985000, 0, 1, '', 1, '2013-09-07', '2013-09-07', '2013-09-06 07:29:35', 1, 1, 0),
(16, 'PJ/2/20131029/0016', 3175000, 0, 3175000, 3175000, 0, 1, '', 1, '2013-10-30', '2013-10-30', '2013-10-29 07:30:12', 1, 1, 0),
(17, 'PJ/2/20131113/0017', 3110000, 0, 3110000, 3110000, 0, 1, '', 1, '2013-11-14', '2013-11-14', '2013-11-13 07:31:50', 1, 1, 0),
(18, 'PJ/2/20131218/0018', 3330000, 0, 3330000, 3330000, 0, 1, '', 1, '2013-12-19', '2013-12-19', '2013-12-18 07:32:16', 1, 1, 0),
(19, 'PJ/2/20140130/0019', 3765000, 0, 3765000, 3765000, 0, 1, '', 1, '2014-01-31', '2014-01-31', '2014-01-30 07:33:10', 1, 1, 0),
(20, 'PJ/2/20140212/0020', 4055000, 0, 4055000, 4055000, 0, 1, '', 1, '2014-02-13', '2014-02-13', '2014-02-12 07:33:54', 1, 1, 0),
(21, 'PJ/2/20140311/0021', 3390000, 0, 3390000, 3390000, 0, 1, '', 1, '2014-03-12', '2014-03-12', '2014-03-11 07:35:01', 1, 1, 0),
(22, 'PJ/2/20140417/0022', 3220000, 0, 3220000, 3220000, 0, 1, '', 1, '2014-04-18', '2014-04-18', '2014-04-17 07:36:02', 1, 1, 0),
(23, 'PJ/2/20140528/0023', 2840000, 0, 2840000, 2840000, 0, 1, '', 1, '2014-05-29', '2014-05-29', '2014-05-28 07:37:05', 1, 1, 0),
(24, 'PJ/2/20140610/0024', 2935000, 0, 2935000, 2935000, 0, 1, '', 1, '2014-06-11', '2014-06-11', '2014-06-10 07:37:47', 1, 1, 0),
(25, 'PJ/2/20140715/0025', 450000, 0, 450000, 450000, 0, 1, '', 1, '2014-07-15', '2014-07-15', '2014-07-14 10:00:48', 1, 1, 0),
(26, 'PJ/2/20140715/0026', 675000, 0, 675000, 675000, 0, 1, '', 1, '2014-07-15', '2014-07-15', '2014-07-14 12:27:29', 1, 1, 2),
(27, 'PJ/2/20140715/0027', 4050000, 0, 4050000, 4050000, 0, 1, '', 1, '2014-07-15', '2014-07-15', '2014-07-14 12:48:22', 1, 1, 0),
(28, 'PJ/2/20140720/0028', 45000, 0, 45000, 50000, 5000, 1, '', 1, '2014-07-20', '2014-07-20', '2014-07-19 17:31:51', 1, 1, 0),
(29, 'PJ/2/20140722/0029', 5000, 0, 5000, 5000, 0, 1, '', 1, '2014-07-22', '2014-07-22', '2014-07-22 02:06:27', 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `penjualan_detail`
--

CREATE TABLE IF NOT EXISTS `penjualan_detail` (
  `id_penjualandetail` int(11) NOT NULL AUTO_INCREMENT,
  `id_penjualan` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `id_persediaan` int(11) NOT NULL,
  `harga` double NOT NULL,
  `jumlah` int(11) NOT NULL,
  `retur` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_penjualandetail`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=105 ;

--
-- Dumping data for table `penjualan_detail`
--

INSERT INTO `penjualan_detail` (`id_penjualandetail`, `id_penjualan`, `id_barang`, `id_persediaan`, `harga`, `jumlah`, `retur`) VALUES
(1, 1, 166, 1, 45000, 20, 11),
(2, 1, 130, 2, 20000, 15, 0),
(3, 1, 203, 3, 45000, 30, 0),
(4, 1, 202, 4, 10000, 20, 0),
(5, 2, 166, 1, 45000, 29, 11),
(6, 2, 130, 2, 20000, 17, 0),
(7, 2, 203, 3, 45000, 34, 0),
(8, 2, 202, 4, 10000, 22, 0),
(9, 3, 166, 1, 45000, 10, 11),
(10, 3, 130, 2, 20000, 19, 0),
(11, 3, 203, 3, 45000, 40, 0),
(12, 3, 202, 4, 10000, 25, 0),
(13, 4, 166, 1, 45000, 8, 11),
(14, 4, 130, 2, 20000, 21, 0),
(15, 4, 203, 3, 45000, 37, 0),
(16, 4, 202, 4, 10000, 27, 0),
(17, 5, 166, 1, 45000, 5, 11),
(18, 5, 130, 2, 20000, 22, 0),
(19, 5, 203, 3, 45000, 31, 0),
(20, 5, 202, 4, 10000, 25, 0),
(21, 6, 166, 1, 45000, 10, 11),
(22, 6, 130, 2, 20000, 22, 0),
(23, 6, 203, 3, 45000, 37, 0),
(24, 6, 202, 4, 10000, 20, 0),
(25, 7, 166, 1, 45000, 30, 11),
(26, 7, 130, 2, 20000, 23, 0),
(27, 7, 203, 3, 45000, 29, 0),
(28, 7, 202, 4, 10000, 40, 0),
(29, 8, 166, 1, 45000, 20, 11),
(30, 8, 130, 2, 20000, 25, 0),
(31, 8, 203, 3, 45000, 32, 0),
(32, 8, 202, 4, 10000, 44, 0),
(33, 9, 166, 1, 45000, 5, 11),
(34, 9, 130, 2, 20000, 27, 0),
(35, 9, 203, 3, 45000, 35, 0),
(36, 9, 202, 4, 10000, 50, 0),
(37, 10, 166, 1, 45000, 10, 11),
(38, 10, 130, 2, 20000, 27, 0),
(39, 10, 203, 3, 45000, 31, 0),
(40, 10, 202, 4, 10000, 54, 0),
(41, 11, 166, 1, 45000, 5, 11),
(42, 11, 130, 2, 20000, 25, 0),
(43, 11, 203, 3, 45000, 36, 0),
(44, 11, 202, 4, 10000, 50, 0),
(45, 12, 166, 1, 45000, 15, 11),
(46, 12, 130, 2, 20000, 28, 0),
(47, 12, 203, 3, 45000, 39, 0),
(48, 12, 202, 4, 10000, 40, 0),
(49, 13, 166, 1, 45000, 25, 11),
(50, 13, 130, 2, 20000, 29, 0),
(51, 13, 203, 3, 45000, 41, 0),
(52, 13, 202, 4, 10000, 30, 0),
(53, 14, 166, 1, 45000, 30, 11),
(54, 14, 130, 2, 20000, 30, 0),
(55, 14, 203, 3, 45000, 35, 0),
(56, 14, 202, 4, 10000, 34, 0),
(57, 15, 166, 1, 45000, 15, 11),
(58, 15, 130, 2, 20000, 28, 0),
(59, 15, 203, 3, 45000, 13, 0),
(60, 15, 203, 11, 45000, 17, 0),
(61, 15, 202, 4, 10000, 40, 0),
(62, 16, 166, 1, 45000, 15, 11),
(63, 16, 130, 2, 20000, 31, 0),
(64, 16, 203, 11, 45000, 32, 0),
(65, 16, 202, 4, 10000, 44, 0),
(66, 17, 166, 1, 45000, 10, 11),
(67, 17, 130, 2, 20000, 32, 0),
(68, 17, 203, 11, 45000, 36, 0),
(69, 17, 202, 4, 10000, 40, 0),
(70, 18, 166, 1, 45000, 15, 11),
(71, 18, 130, 2, 20000, 30, 0),
(72, 18, 203, 11, 45000, 15, 0),
(73, 18, 203, 12, 45000, 24, 0),
(74, 18, 202, 4, 10000, 30, 0),
(75, 19, 166, 1, 45000, 21, 11),
(76, 19, 130, 2, 20000, 31, 0),
(77, 19, 203, 12, 45000, 40, 0),
(78, 19, 202, 4, 10000, 40, 0),
(79, 20, 166, 1, 45000, 32, 11),
(80, 20, 130, 2, 20000, 30, 0),
(81, 20, 203, 12, 45000, 35, 0),
(82, 20, 202, 4, 10000, 44, 0),
(83, 21, 166, 1, 45000, 17, 11),
(84, 21, 130, 2, 20000, 32, 0),
(85, 21, 203, 12, 45000, 33, 0),
(86, 21, 202, 4, 10000, 50, 0),
(87, 22, 166, 1, 45000, 10, 11),
(88, 22, 130, 2, 20000, 35, 0),
(89, 22, 203, 12, 45000, 34, 0),
(90, 22, 202, 4, 10000, 54, 0),
(91, 23, 166, 1, 45000, 5, 11),
(92, 23, 130, 2, 20000, 36, 0),
(93, 23, 203, 12, 45000, 31, 0),
(94, 23, 202, 4, 10000, 50, 0),
(95, 24, 166, 1, 45000, 10, 11),
(96, 24, 130, 2, 20000, 39, 0),
(97, 24, 203, 12, 45000, 29, 0),
(98, 24, 202, 4, 10000, 40, 0),
(99, 25, 166, 1, 45000, 10, 10),
(100, 26, 166, 1, 45000, 15, 10),
(101, 27, 203, 12, 45000, 74, 0),
(102, 27, 203, 13, 45000, 16, 0),
(103, 28, 166, 1, 45000, 1, 0),
(104, 29, 59, 9, 2500, 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `piutang`
--

CREATE TABLE IF NOT EXISTS `piutang` (
  `id_piutang` int(11) NOT NULL AUTO_INCREMENT,
  `no_nota` varchar(255) NOT NULL,
  `tanggal_pembayaran` date NOT NULL,
  `total` int(11) NOT NULL,
  `keterangan` varchar(255) NOT NULL DEFAULT '',
  `id_pelanggan` int(11) NOT NULL,
  `createddate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdby` int(11) NOT NULL,
  PRIMARY KEY (`id_piutang`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `piutang`
--

INSERT INTO `piutang` (`id_piutang`, `no_nota`, `tanggal_pembayaran`, `total`, `keterangan`, `id_pelanggan`, `createddate`, `createdby`) VALUES
(1, 'PJ/P/20140714/0001', '2014-07-15', 1000000, '', 3, '2014-07-14 09:37:00', 1),
(2, 'PJ/P/20140720/0002', '2014-07-20', 1000000, '', 3, '2014-07-19 20:59:04', 1);

-- --------------------------------------------------------

--
-- Table structure for table `piutang_detail`
--

CREATE TABLE IF NOT EXISTS `piutang_detail` (
  `id_piutangdetail` int(11) NOT NULL AUTO_INCREMENT,
  `id_piutang` int(11) NOT NULL,
  `id_penjualan` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `sisa` int(11) NOT NULL,
  PRIMARY KEY (`id_piutangdetail`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `piutang_detail`
--

INSERT INTO `piutang_detail` (`id_piutangdetail`, `id_piutang`, `id_penjualan`, `total`, `sisa`) VALUES
(1, 1, 2, 1000000, 2395000),
(2, 2, 2, 1000000, 1395000);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_order`
--

CREATE TABLE IF NOT EXISTS `purchase_order` (
  `id_purchaseorder` int(11) NOT NULL AUTO_INCREMENT,
  `no_nota` varchar(255) NOT NULL,
  `total` int(11) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `id_pemasok` int(11) NOT NULL,
  `tanggal_order` date NOT NULL,
  `createddate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdby` int(11) NOT NULL,
  `isaccepted` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_purchaseorder`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `purchase_order`
--

INSERT INTO `purchase_order` (`id_purchaseorder`, `no_nota`, `total`, `keterangan`, `id_pemasok`, `tanggal_order`, `createddate`, `createdby`, `isaccepted`) VALUES
(1, 'PJ/PO/20140720/0001', 2435000, 'keterangan', 5, '2014-07-20', '2014-07-19 17:30:02', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_order_detail`
--

CREATE TABLE IF NOT EXISTS `purchase_order_detail` (
  `id_purchaseorderdetail` int(11) NOT NULL AUTO_INCREMENT,
  `id_purchaseorder` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `harga` double NOT NULL,
  `jumlah` int(11) NOT NULL,
  PRIMARY KEY (`id_purchaseorderdetail`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `purchase_order_detail`
--

INSERT INTO `purchase_order_detail` (`id_purchaseorderdetail`, `id_purchaseorder`, `id_barang`, `harga`, `jumlah`) VALUES
(1, 1, 166, 35000, 1),
(2, 1, 200, 200000, 12);

-- --------------------------------------------------------

--
-- Table structure for table `retur_beli`
--

CREATE TABLE IF NOT EXISTS `retur_beli` (
  `id_returbeli` int(11) NOT NULL AUTO_INCREMENT,
  `no_nota` varchar(255) NOT NULL,
  `tanggal_retur` date NOT NULL,
  `total` int(11) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `id_pembelian` int(11) NOT NULL,
  `createddate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdby` int(11) NOT NULL,
  PRIMARY KEY (`id_returbeli`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `retur_beli`
--

INSERT INTO `retur_beli` (`id_returbeli`, `no_nota`, `tanggal_retur`, `total`, `keterangan`, `id_pembelian`, `createddate`, `createdby`) VALUES
(1, 'PJ/3/20140723/0001', '2014-07-23', 45000, 'tes', 6, '2014-07-23 15:59:43', 1);

-- --------------------------------------------------------

--
-- Table structure for table `retur_beli_detail`
--

CREATE TABLE IF NOT EXISTS `retur_beli_detail` (
  `id_returbelidetail` int(11) NOT NULL AUTO_INCREMENT,
  `id_returbeli` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  PRIMARY KEY (`id_returbelidetail`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `retur_beli_detail`
--

INSERT INTO `retur_beli_detail` (`id_returbelidetail`, `id_returbeli`, `id_barang`, `harga`, `jumlah`) VALUES
(1, 1, 215, 45000, 1);

-- --------------------------------------------------------

--
-- Table structure for table `retur_jual`
--

CREATE TABLE IF NOT EXISTS `retur_jual` (
  `id_returjual` int(11) NOT NULL AUTO_INCREMENT,
  `no_nota` varchar(255) NOT NULL,
  `tanggal_retur` date NOT NULL,
  `total` int(11) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `id_penjualan` int(11) NOT NULL,
  `createddate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdby` int(11) NOT NULL,
  PRIMARY KEY (`id_returjual`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `retur_jual`
--

INSERT INTO `retur_jual` (`id_returjual`, `no_nota`, `tanggal_retur`, `total`, `keterangan`, `id_penjualan`, `createddate`, `createdby`) VALUES
(1, 'PJ/4/20140714/0001', '2014-07-15', 45000, '', 24, '2014-07-14 09:37:40', 1),
(2, 'PJ/4/20140715/0002', '2014-07-15', 450000, '', 26, '2014-07-14 12:30:42', 1);

-- --------------------------------------------------------

--
-- Table structure for table `retur_jual_detail`
--

CREATE TABLE IF NOT EXISTS `retur_jual_detail` (
  `id_returjualdetail` int(11) NOT NULL AUTO_INCREMENT,
  `id_returjual` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  PRIMARY KEY (`id_returjualdetail`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `retur_jual_detail`
--

INSERT INTO `retur_jual_detail` (`id_returjualdetail`, `id_returjual`, `id_barang`, `harga`, `jumlah`) VALUES
(1, 1, 166, 45000, 1),
(2, 2, 166, 45000, 10);

-- --------------------------------------------------------

--
-- Table structure for table `sys_setting`
--

CREATE TABLE IF NOT EXISTS `sys_setting` (
  `id_sys_setting` int(11) NOT NULL AUTO_INCREMENT,
  `setting_name` varchar(255) NOT NULL,
  `setting_value` varchar(255) NOT NULL,
  `note` varchar(255) NOT NULL,
  PRIMARY KEY (`id_sys_setting`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `sys_setting`
--

INSERT INTO `sys_setting` (`id_sys_setting`, `setting_name`, `setting_value`, `note`) VALUES
(1, 'companyname', 'TOKO BAHAN BANGUNAN PALANGJAYA', ''),
(2, 'companyaddress', 'Jl. Raya Barat 149 Cicalengka 40395', ''),
(3, 'companycity', 'Kabupaten Bandung', ''),
(4, 'companypostcode', '40395', ''),
(5, 'companyphone', '(022) 7948337\r\n', ''),
(6, 'companyname2', 'Palangjaya', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
