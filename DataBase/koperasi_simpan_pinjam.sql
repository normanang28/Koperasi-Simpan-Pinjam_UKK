-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 09, 2023 at 06:06 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `koperasi_simpan_pinjam`
--

-- --------------------------------------------------------

--
-- Table structure for table `anggota`
--

CREATE TABLE `anggota` (
  `id_anggota` int(4) NOT NULL,
  `id_anggota_user` int(4) NOT NULL,
  `nama_anggota` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `no_telp` varchar(14) NOT NULL,
  `ttl` text NOT NULL,
  `jk` varchar(20) NOT NULL,
  `status_anggota` varchar(30) NOT NULL,
  `tanggal_anggota` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `anggota`
--

INSERT INTO `anggota` (`id_anggota`, `id_anggota_user`, `nama_anggota`, `alamat`, `no_telp`, `ttl`, `jk`, `status_anggota`, `tanggal_anggota`) VALUES
(1, 5, ' Norman ang', 'Wisma Buana Indah Blok A, No.20 Batam Center', '081371035253', 'batam, 28 oktober 2006', 'Female', 'Active', '2023-10-03 19:49:17'),
(11, 17, 'Octarianto Lika Ng', 'Golden City, Bengkong, Batam, Kep. Riau ', '086556465478', 'batam, 29 oktober 2006', 'Male', 'Not Active', '2023-10-04 14:13:05'),
(12, 19, 'ong yan da', '42H4+77X, Baloi Indah, Kec. Lubuk Baja, Kota Batam, Kepulauan Riau 29444', '086546756566', 'singapore, 10 mei 2006', 'Male', 'Active', '2023-10-04 21:57:52'),
(15, 24, 'Jelvino Chou', '~', '08', '~', 'Male', 'Active', '2023-10-05 18:48:01');

-- --------------------------------------------------------

--
-- Table structure for table `angsuran`
--

CREATE TABLE `angsuran` (
  `id_angsuran` int(4) NOT NULL,
  `id_angsuran_peminjaman` int(4) NOT NULL,
  `id_angsuran_kategori` int(4) NOT NULL,
  `tanggal_pembayaran` datetime NOT NULL DEFAULT current_timestamp(),
  `angsuran_ke` text NOT NULL,
  `nominal_angsuran` text NOT NULL,
  `keterangan_angsuran` text NOT NULL,
  `bukti` text NOT NULL,
  `maker_angsuran` int(4) NOT NULL,
  `angsuran_laporan` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `angsuran`
--

INSERT INTO `angsuran` (`id_angsuran`, `id_angsuran_peminjaman`, `id_angsuran_kategori`, `tanggal_pembayaran`, `angsuran_ke`, `nominal_angsuran`, `keterangan_angsuran`, `bukti`, `maker_angsuran`, `angsuran_laporan`) VALUES
(18, 43, 11, '2023-10-06 19:34:13', 'installments 1', '10000000', '-', '1696595653_23309478658de1c2bb53.jpg', 18, '2023-10-06');

--
-- Triggers `angsuran`
--
DELIMITER $$
CREATE TRIGGER `hapus` AFTER DELETE ON `angsuran` FOR EACH ROW UPDATE pinjaman SET nominal = nominal+old.nominal_angsuran WHERE id_pinjaman = old.id_angsuran_peminjaman
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `peminjaman` AFTER INSERT ON `angsuran` FOR EACH ROW UPDATE pinjaman SET nominal = nominal-new.nominal_angsuran WHERE id_pinjaman = new.id_angsuran_peminjaman
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `katagori_pinjaman`
--

CREATE TABLE `katagori_pinjaman` (
  `id_katagori` int(4) NOT NULL,
  `nama_katagori` varchar(100) NOT NULL,
  `keterangan_kategori` text NOT NULL,
  `tanggal_kategori` datetime NOT NULL DEFAULT current_timestamp(),
  `maker_maker` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `katagori_pinjaman`
--

INSERT INTO `katagori_pinjaman` (`id_katagori`, `nama_katagori`, `keterangan_kategori`, `tanggal_kategori`, `maker_maker`) VALUES
(11, 'Village Unit Savings and Loans Cooperative', 'Village Unit Savings and Loans Cooperative (KUD) is a type of cooperative that operates at the village or rural level. KUD has several tasks and functions to collect savings funds', '2023-10-06 09:52:50', 18),
(12, 'Multi-Business Cooperative', 'Multi-Business Cooperative (Multi Business Cooperative) is a type of cooperative that has various businesses or economic activities under the same cooperative entity.', '2023-10-06 09:59:30', 18);

-- --------------------------------------------------------

--
-- Table structure for table `log_activity`
--

CREATE TABLE `log_activity` (
  `id_log` int(4) NOT NULL,
  `id_log_user` int(4) NOT NULL,
  `activity` text NOT NULL,
  `waktu` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `log_activity`
--

INSERT INTO `log_activity` (`id_log`, `id_log_user`, `activity`, `waktu`) VALUES
(1, 18, 'Add a loan category table  ', '2023-10-05 22:51:43'),
(2, 18, 'Edit the loan category table  with ID 13', '2023-10-05 22:51:48'),
(3, 18, 'Delete the loan category table  with ID 13', '2023-10-05 22:51:50'),
(4, 18, 'Add a loan category table 1 ', '2023-10-05 22:53:48'),
(5, 18, 'Add a loan category table 1 ', '2023-10-05 22:53:48'),
(6, 18, 'Edit the loan category table 12 with ID 14', '2023-10-05 22:53:53'),
(7, 18, 'Delete the loan category table  with ID 14', '2023-10-05 22:53:55'),
(8, 18, 'Add a savings table 12', '2023-10-05 22:55:39'),
(9, 18, 'Delete the savings table with ID 14', '2023-10-05 22:55:43'),
(10, 18, 'Delete the savings table with ID 11', '2023-10-05 22:55:47'),
(11, 18, 'Add a loan table 9', '2023-10-05 22:59:51'),
(12, 18, 'Add a loan table 10', '2023-10-05 23:00:55'),
(13, 18, 'Add a loan table 1', '2023-10-05 23:01:16'),
(14, 18, 'Add a loan table 1', '2023-10-05 23:01:16'),
(15, 18, 'Approved status in the loan table with ID 38', '2023-10-05 23:03:13'),
(16, 18, 'Approved status in the loan table with ID 33', '2023-10-05 23:03:13'),
(17, 18, 'Add a loan table 1', '2023-10-05 23:05:32'),
(18, 18, 'Delete the loan table with ID 39', '2023-10-05 23:05:36'),
(19, 18, 'Add a loan table 12', '2023-10-05 23:07:16'),
(20, 18, 'Approved status on the loan table with ID 40', '2023-10-05 23:07:19'),
(21, 18, 'Add a loan table 1', '2023-10-05 23:07:54'),
(22, 18, 'Add a loan table 2', '2023-10-05 23:08:03'),
(23, 18, 'Approved status on the loan table with ID 41', '2023-10-05 23:08:08'),
(24, 18, 'Add a installments table 2 ', '2023-10-05 23:10:25'),
(25, 18, 'Delete a installments table with ID 17 ', '2023-10-05 23:10:33'),
(26, 5, 'Login on the system with ID  ', '2023-10-05 23:16:19'),
(27, 5, 'Edit Profile  Norman ang ', '2023-10-05 23:25:16'),
(28, 5, 'Edit Profile  Norman ang ', '2023-10-05 23:25:22'),
(29, 5, 'Edit Profile  Norman ang ', '2023-10-05 23:25:24'),
(30, 5, 'Edit Profile  Norman ang ', '2023-10-05 23:25:38'),
(31, 5, 'Edit Profile  Norman ang ', '2023-10-05 23:26:09'),
(32, 5, 'Log out on the system with ID 5 ', '2023-10-05 23:26:09'),
(33, 5, 'Login on the system with ID  ', '2023-10-05 23:26:19'),
(34, 5, 'Edit password with ID 5 ', '2023-10-05 23:26:39'),
(35, 5, 'Log out on the system with ID 5 ', '2023-10-05 23:26:39'),
(36, 5, 'Login on the system with ID  ', '2023-10-05 23:26:51'),
(37, 5, 'Edit password with ID 5 ', '2023-10-05 23:27:08'),
(38, 5, 'Log out on the system with ID 5 ', '2023-10-05 23:27:08'),
(39, 5, 'Login on the system with ID  ', '2023-10-05 23:27:22'),
(40, 5, 'Edit Profile  Norman ang ', '2023-10-05 23:27:28'),
(41, 5, 'Log out on the system with ID 5 ', '2023-10-05 23:27:28'),
(42, 5, 'Login on the system with ID  ', '2023-10-05 23:27:47'),
(43, 5, 'Log out on the system with ID 5 ', '2023-10-05 23:28:01'),
(44, 18, 'Log out on the system with ID 18 ', '2023-10-05 23:29:16'),
(45, 1, 'Login on the system with ID 1 ', '2023-10-05 23:29:26'),
(46, 1, 'Add account cooperative officer 1 ', '2023-10-05 23:42:13'),
(47, 1, 'Reset Password account cooperative officer with ID 26 ', '2023-10-05 23:42:24'),
(48, 1, 'Delete account cooperative officer with ID 26', '2023-10-05 23:42:35'),
(49, 1, 'Status not active account member with ID 24', '2023-10-05 23:44:53'),
(50, 1, 'Status active account member with ID 17', '2023-10-05 23:45:02'),
(51, 1, 'Status not active account member with ID 24', '2023-10-05 23:45:05'),
(52, 1, 'Add account member 1', '2023-10-05 23:45:14'),
(53, 1, 'Reset Password account member with ID 27 ', '2023-10-05 23:45:26'),
(54, 1, 'Status not active account member with ID 27', '2023-10-05 23:46:05'),
(55, 1, 'Status active account member with ID 27', '2023-10-05 23:46:22'),
(56, 1, 'Status not active account member with ID 27', '2023-10-05 23:46:25'),
(57, 1, 'Status active account member with ID 27', '2023-10-05 23:46:27'),
(58, 1, 'Delete account member with ID 27', '2023-10-05 23:46:36'),
(59, 1, 'Add account cooperative officer 11 ', '2023-10-05 23:53:36'),
(60, 1, 'Reset Password account cooperative officer with ID 28 ', '2023-10-05 23:53:42'),
(61, 1, 'Edit account cooperative officer 12 with ID 28 ', '2023-10-05 23:53:50'),
(62, 1, 'Delete account cooperative officer with ID 28', '2023-10-05 23:54:02'),
(63, 1, 'Add account member 1', '2023-10-05 23:54:35'),
(64, 1, 'Status not active account member with ID 29', '2023-10-05 23:54:39'),
(65, 1, 'Status active account member with ID 29', '2023-10-05 23:54:42'),
(66, 1, 'Reset Password account member with ID 29 ', '2023-10-05 23:54:46'),
(67, 1, 'Edit account member 12 with ID 29', '2023-10-05 23:54:56'),
(68, 1, 'Delete account member with ID 29', '2023-10-05 23:55:00'),
(69, 5, 'Login on the system with ID  ', '2023-10-06 00:31:17'),
(70, 5, 'Log out on the system with ID 5 ', '2023-10-06 00:42:34'),
(71, 1, 'Log out on the system with ID 1 ', '2023-10-06 00:53:42'),
(72, 1, 'Login on the system with ID 1 ', '2023-10-06 00:55:41'),
(73, 1, 'Log out on the system with ID 1 ', '2023-10-06 01:08:14'),
(74, 1, 'Login on the system with ID 1 ', '2023-10-06 01:13:06'),
(75, 5, 'Login on the system with ID  ', '2023-10-06 01:21:27'),
(76, 5, 'Log out on the system with ID 5 ', '2023-10-06 01:33:35'),
(77, 5, 'Login on the system with ID  ', '2023-10-06 01:33:43'),
(78, 1, 'Log out on the system with ID 1 ', '2023-10-06 01:35:11'),
(79, 5, 'Log out on the system with ID 5 ', '2023-10-06 01:36:53'),
(80, 5, 'Login on the system with ID  ', '2023-10-06 01:37:07'),
(81, 5, 'Log out on the system with ID 5 ', '2023-10-06 01:40:26'),
(82, 5, 'Login on the system with ID  ', '2023-10-06 01:40:38'),
(83, 5, 'Log out on the system with ID 5 ', '2023-10-06 01:40:53'),
(84, 5, 'Login on the system with ID  ', '2023-10-06 01:41:01'),
(85, 18, 'Login on the system with ID 18 ', '2023-10-06 02:21:25'),
(86, 18, 'Log out on the system with ID 18 ', '2023-10-06 02:31:33'),
(87, 18, 'Login on the system with ID 18 ', '2023-10-06 03:31:05'),
(88, 18, 'Displays Savings and Loans Cooperative Reports in Printed Format', '2023-10-06 03:51:53'),
(89, 18, 'Displays Savings and Loans Cooperative Reports in Printed Format', '2023-10-06 03:52:10'),
(90, 18, 'Displays Savings and Loans Cooperative Reports in Printed Format', '2023-10-06 03:52:29'),
(91, 18, 'Displays Savings and Loans Cooperative Reports in Printed Format', '2023-10-06 03:53:09'),
(92, 18, 'Displays Savings and Loans Cooperative Reports in Printed Format', '2023-10-06 03:53:15'),
(93, 18, 'Displays Savings and Loans Cooperative Reports in Printed Format', '2023-10-06 03:53:54'),
(94, 18, 'Displays Savings and Loans Cooperative Reports in Printed Format', '2023-10-06 03:53:59'),
(95, 18, 'Displays Savings and Loans Cooperative Reports in PDF Format', '2023-10-06 03:54:29'),
(96, 18, 'Displays Savings and Loans Cooperative Reports in Excel Format', '2023-10-06 03:54:39'),
(97, 18, 'Displays Savings and Loans Cooperative Reports in Excel Format', '2023-10-06 03:58:42'),
(98, 18, 'Displays Savings and Loans Cooperative Reports in PDF Format', '2023-10-06 03:59:16'),
(99, 18, 'Displays Savings and Loans Cooperative Reports in Excel Format', '2023-10-06 03:59:22'),
(100, 18, 'Displays Savings and Loans Cooperative Reports in Excel Format', '2023-10-06 04:03:33'),
(101, 18, 'Displays Savings and Loans Cooperative Reports in Printed Format', '2023-10-06 04:04:01'),
(102, 18, 'Displays Savings and Loans Cooperative Reports in Printed Format', '2023-10-06 04:11:22'),
(103, 18, 'Displays Savings and Loans Cooperative Reports in PDF Format', '2023-10-06 04:11:26'),
(104, 18, 'Displays Savings and Loans Cooperative Reports in Excel Format', '2023-10-06 04:11:30'),
(105, 18, 'Displays Savings and Loans Cooperative Reports in Excel Format', '2023-10-06 04:12:08'),
(106, 5, 'Login on the system with ID  ', '2023-10-06 04:12:32'),
(107, 5, 'Displays Savings and Loans Cooperative Reports in Printed Format', '2023-10-06 04:12:51'),
(108, 5, 'Displays Savings and Loans Cooperative Reports in PDF Format', '2023-10-06 04:12:57'),
(109, 5, 'Displays Savings and Loans Cooperative Reports in Excel Format', '2023-10-06 04:13:00'),
(110, 18, 'Displays Savings and Loans Cooperative Reports in Printed Format', '2023-10-06 04:15:31'),
(111, 18, 'Displays Savings and Loans Cooperative Reports in Printed Format ~ Loan', '2023-10-06 04:25:54'),
(112, 5, 'Login on the system with ID  ', '2023-10-06 04:26:10'),
(113, 5, 'Displays Savings and Loans Cooperative Reports in Printed Format ~ Loan', '2023-10-06 04:26:21'),
(114, 5, 'Displays Savings and Loans Cooperative Reports in PDF Format ~ Loan', '2023-10-06 04:26:25'),
(115, 5, 'Displays Savings and Loans Cooperative Reports in Excel Format ~ Loan', '2023-10-06 04:26:32'),
(116, 18, 'Displays Savings and Loans Cooperative Reports in PDF Format ~ Loan', '2023-10-06 04:26:52'),
(117, 18, 'Displays Savings and Loans Cooperative Reports in Excel Format ~ Loan', '2023-10-06 04:26:56'),
(118, 5, 'Log out on the system with ID 5 ', '2023-10-06 04:53:33'),
(119, 5, 'Login on the system with ID  ', '2023-10-06 04:53:43'),
(120, 18, 'Displays Savings and Loans Cooperative Reports in Printed Format ~ Installments', '2023-10-06 04:57:50'),
(121, 18, 'Displays Savings and Loans Cooperative Reports in Printed Format ~ Installments', '2023-10-06 04:57:54'),
(122, 18, 'Displays Savings and Loans Cooperative Reports in PDF Format ~ Installments', '2023-10-06 04:57:58'),
(123, 18, 'Displays Savings and Loans Cooperative Reports in Excel Format ~ Installments', '2023-10-06 04:58:02'),
(124, 5, 'Displays Savings and Loans Cooperative Reports in Printed Format ~ Installments', '2023-10-06 04:58:19'),
(125, 5, 'Displays Savings and Loans Cooperative Reports in PDF Format ~ Installments', '2023-10-06 04:58:24'),
(126, 5, 'Displays Savings and Loans Cooperative Reports in Excel Format ~ Installments', '2023-10-06 04:58:28'),
(127, 5, 'Displays Savings and Loans Cooperative Reports in Printed Format ~ Savings', '2023-10-06 05:00:28'),
(128, 5, 'Displays Savings and Loans Cooperative Reports in PDF Format ~ Savings', '2023-10-06 05:00:31'),
(129, 5, 'Displays Savings and Loans Cooperative Reports in Excel Format ~ Savings', '2023-10-06 05:00:35'),
(130, 1, 'Login on the system with ID 1 ', '2023-10-06 05:10:15'),
(131, 18, 'Log out on the system with ID 18 ', '2023-10-06 05:10:47'),
(132, 5, 'Login on the system with ID  ', '2023-10-06 05:10:56'),
(133, 5, 'Log out on the system with ID 5 ', '2023-10-06 05:11:09'),
(134, 1, 'Login on the system with ID 1 ', '2023-10-06 05:12:55'),
(135, 1, 'Log out on the system with ID 1 ', '2023-10-06 05:14:02'),
(136, 1, 'Login on the system with ID 1 ', '2023-10-06 05:14:23'),
(137, 1, 'Log out on the system with ID 1 ', '2023-10-06 05:24:31'),
(138, 1, 'Login on the system with ID 1 ', '2023-10-06 06:16:32'),
(139, 1, 'Edit Profile asep sumanto ', '2023-10-06 06:29:15'),
(140, 1, 'Log out on the system with ID 1 ', '2023-10-06 06:29:15'),
(141, 1, 'Login on the system with ID 1 ', '2023-10-06 06:29:28'),
(142, 1, 'Edit Profile asep sumanto ', '2023-10-06 06:39:19'),
(143, 1, 'Edit Profile asep sumanto ', '2023-10-06 06:39:30'),
(144, 1, 'Log out on the system with ID 1 ', '2023-10-06 06:39:52'),
(145, 5, 'Login on the system with ID  ', '2023-10-06 06:40:12'),
(146, 5, 'Edit Profile  Norman ang ', '2023-10-06 06:40:26'),
(147, 5, 'Log out on the system with ID 5 ', '2023-10-06 06:40:26'),
(148, 5, 'Login on the system with ID  ', '2023-10-06 06:40:38'),
(149, 5, 'Log out on the system with ID 5 ', '2023-10-06 06:40:47'),
(150, 1, 'Login on the system with ID 1 ', '2023-10-06 06:40:55'),
(151, 1, 'Log out on the system with ID 1 ', '2023-10-06 06:40:57'),
(152, 18, 'Login on the system with ID 18 ', '2023-10-06 06:41:05'),
(153, 18, 'Log out on the system with ID 18 ', '2023-10-06 06:46:43'),
(154, 18, 'Login on the system with ID 18 ', '2023-10-06 06:46:51'),
(155, 18, 'Log out on the system with ID 18 ', '2023-10-06 07:08:14'),
(156, 18, 'Login on the system with ID 18 ', '2023-10-06 07:19:06'),
(157, 18, 'Log out on the system with ID 18 ', '2023-10-06 07:21:02'),
(158, 18, 'Login on the system with ID 18 ', '2023-10-06 07:21:13'),
(159, 18, 'Add a loan table 1', '2023-10-06 07:33:11'),
(160, 18, 'Add a loan table 2', '2023-10-06 07:33:35'),
(161, 18, 'Approved status on the loan table with ID 43', '2023-10-06 07:33:38'),
(162, 18, 'Add a installments table 1 ', '2023-10-06 07:34:13'),
(163, 18, 'Log out on the system with ID 18 ', '2023-10-06 07:52:01'),
(164, 1, 'Login on the system with ID 1 ', '2023-10-06 07:52:14'),
(165, 1, 'Log out on the system with ID 1 ', '2023-10-06 07:53:03'),
(166, 5, 'Login on the system with ID  ', '2023-10-06 07:53:19'),
(167, 5, 'Log out on the system with ID 5 ', '2023-10-06 07:53:33'),
(168, 5, 'Login on the system with ID  ', '2023-10-06 08:14:06');

-- --------------------------------------------------------

--
-- Table structure for table `petugas_koperasi`
--

CREATE TABLE `petugas_koperasi` (
  `id_petugas` int(4) NOT NULL,
  `id_petugas_user` int(4) NOT NULL,
  `nik` varchar(16) NOT NULL,
  `nama_petugas` text NOT NULL,
  `alamat` text NOT NULL,
  `no_telp` varchar(14) NOT NULL,
  `ttl` text NOT NULL,
  `jk` varchar(30) NOT NULL,
  `tanggal_petugas` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `petugas_koperasi`
--

INSERT INTO `petugas_koperasi` (`id_petugas`, `id_petugas_user`, `nik`, `nama_petugas`, `alamat`, `no_telp`, `ttl`, `jk`, `tanggal_petugas`) VALUES
(1, 1, '1234567891012149', 'asep sumanto', 'Kelurahan Gondangdia, Menteng, Jakarta Pusat', '081371035253', 'batam, 8 January 2004', 'Male', '2023-10-03 18:52:52'),
(5, 18, '1987654321098', 'test test 01', '4XGC+X29, Patam Lestari, Sekupang, Batam City, Riau Islands', '0812435345333', 'batam, 01 oktober 2003', 'Female', '2023-10-04 17:37:31'),
(6, 20, '977236609786', 'Test 01', 'Permata Baloi Blok F7 No. 22B ', '0867566426534', 'batam, 28 desember 2005', 'Male', '2023-10-05 10:49:53');

-- --------------------------------------------------------

--
-- Table structure for table `pinjaman`
--

CREATE TABLE `pinjaman` (
  `id_pinjaman` int(4) NOT NULL,
  `nama_pinjaman` varchar(255) NOT NULL,
  `nominal` text NOT NULL,
  `tanggal_peminjaman` datetime NOT NULL DEFAULT current_timestamp(),
  `status_acc` varchar(20) NOT NULL,
  `tanggal_pelunasan` date NOT NULL DEFAULT current_timestamp(),
  `keterangan_pelunasan` text NOT NULL,
  `maker_pinjaman` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pinjaman`
--

INSERT INTO `pinjaman` (`id_pinjaman`, `nama_pinjaman`, `nominal`, `tanggal_peminjaman`, `status_acc`, `tanggal_pelunasan`, `keterangan_pelunasan`, `maker_pinjaman`) VALUES
(43, 'Loan 1', '10000000', '2023-10-06 19:33:11', 'Approved', '2023-10-31', '-', 18),
(44, 'Loan 2', '1000000', '2023-10-06 19:33:35', 'Process', '2023-10-31', '-', 18);

-- --------------------------------------------------------

--
-- Table structure for table `pinjaman_laporan`
--

CREATE TABLE `pinjaman_laporan` (
  `id_pinjaman` int(4) NOT NULL,
  `nama_pinjaman` varchar(255) NOT NULL,
  `nominal` text NOT NULL,
  `tanggal_peminjaman` datetime NOT NULL DEFAULT current_timestamp(),
  `status_acc` varchar(20) NOT NULL,
  `tanggal_pelunasan` date NOT NULL DEFAULT current_timestamp(),
  `keterangan_pelunasan` text NOT NULL,
  `maker_pinjaman` int(4) NOT NULL,
  `pinjaman_laporan` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pinjaman_laporan`
--

INSERT INTO `pinjaman_laporan` (`id_pinjaman`, `nama_pinjaman`, `nominal`, `tanggal_peminjaman`, `status_acc`, `tanggal_pelunasan`, `keterangan_pelunasan`, `maker_pinjaman`, `pinjaman_laporan`) VALUES
(43, 'Loan 1', '20000000', '2023-10-06 19:33:11', 'Approved', '2023-10-31', '-', 18, '2023-10-06'),
(44, 'Loan 2', '1000000', '2023-10-06 19:33:35', 'Process', '2023-10-31', '-', 18, '2023-10-06');

-- --------------------------------------------------------

--
-- Table structure for table `settings_website`
--

CREATE TABLE `settings_website` (
  `id_settings` int(4) NOT NULL,
  `foto` text NOT NULL,
  `text` text NOT NULL,
  `login` text NOT NULL,
  `nama_website` text NOT NULL,
  `dipakai` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `settings_website`
--

INSERT INTO `settings_website` (`id_settings`, `foto`, `text`, `login`, `nama_website`, `dipakai`) VALUES
(1, '1696470639_73f1f780cfee10c9cebd.png', '1696470664_cf810b8d96c6e807c127.png', '1.gif', 'Saving and Loan Cooperative ', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `simpanan`
--

CREATE TABLE `simpanan` (
  `id_simpanan` int(4) NOT NULL,
  `nama_simpanan` text NOT NULL,
  `tanggal_simpanan` datetime NOT NULL DEFAULT current_timestamp(),
  `nominal_simpanan` text NOT NULL,
  `keterangan_simpanan` text NOT NULL,
  `maker_simpanan` int(4) NOT NULL,
  `simpanan_laporan` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `simpanan`
--

INSERT INTO `simpanan` (`id_simpanan`, `nama_simpanan`, `tanggal_simpanan`, `nominal_simpanan`, `keterangan_simpanan`, `maker_simpanan`, `simpanan_laporan`) VALUES
(7, 'UVERS college registration', '2023-10-05 20:01:25', '4500000', '-', 18, '2023-10-06'),
(8, 'PH school registration', '2023-10-05 20:06:24', '8000000', '-', 18, '2023-10-06'),
(10, 'test', '2023-10-05 20:48:53', '10000', '-', 5, '2023-10-06');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(4) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `level` int(1) NOT NULL,
  `foto` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `level`, `foto`) VALUES
(1, 'admin', '3dcf34a6023633a0d92521ec9c8d5ae4', 1, '1696592370_4c1fa2116371798e7a87.jpg'),
(5, 'norman', '3dcf34a6023633a0d92521ec9c8d5ae4', 3, '1696592426_776d33955f99d2e34927.jpg'),
(17, 'octa', '3dcf34a6023633a0d92521ec9c8d5ae4', 3, ''),
(18, 'Test', '3dcf34a6023633a0d92521ec9c8d5ae4', 2, '1696487472_124dc32f7f64c7e0c0ae.jpeg'),
(19, 'yanda', '3dcf34a6023633a0d92521ec9c8d5ae4', 3, ''),
(20, 'test 01', '3dcf34a6023633a0d92521ec9c8d5ae4', 2, ''),
(24, 'Jelvino', '3dcf34a6023633a0d92521ec9c8d5ae4', 3, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `anggota`
--
ALTER TABLE `anggota`
  ADD PRIMARY KEY (`id_anggota`);

--
-- Indexes for table `angsuran`
--
ALTER TABLE `angsuran`
  ADD PRIMARY KEY (`id_angsuran`);

--
-- Indexes for table `katagori_pinjaman`
--
ALTER TABLE `katagori_pinjaman`
  ADD PRIMARY KEY (`id_katagori`),
  ADD UNIQUE KEY `KATAGORI` (`nama_katagori`);

--
-- Indexes for table `log_activity`
--
ALTER TABLE `log_activity`
  ADD PRIMARY KEY (`id_log`);

--
-- Indexes for table `petugas_koperasi`
--
ALTER TABLE `petugas_koperasi`
  ADD PRIMARY KEY (`id_petugas`),
  ADD UNIQUE KEY `TELP` (`no_telp`);

--
-- Indexes for table `pinjaman`
--
ALTER TABLE `pinjaman`
  ADD PRIMARY KEY (`id_pinjaman`);

--
-- Indexes for table `pinjaman_laporan`
--
ALTER TABLE `pinjaman_laporan`
  ADD PRIMARY KEY (`id_pinjaman`);

--
-- Indexes for table `settings_website`
--
ALTER TABLE `settings_website`
  ADD PRIMARY KEY (`id_settings`);

--
-- Indexes for table `simpanan`
--
ALTER TABLE `simpanan`
  ADD PRIMARY KEY (`id_simpanan`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `USERNAME` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `anggota`
--
ALTER TABLE `anggota`
  MODIFY `id_anggota` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `angsuran`
--
ALTER TABLE `angsuran`
  MODIFY `id_angsuran` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `katagori_pinjaman`
--
ALTER TABLE `katagori_pinjaman`
  MODIFY `id_katagori` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `log_activity`
--
ALTER TABLE `log_activity`
  MODIFY `id_log` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=169;

--
-- AUTO_INCREMENT for table `petugas_koperasi`
--
ALTER TABLE `petugas_koperasi`
  MODIFY `id_petugas` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `pinjaman`
--
ALTER TABLE `pinjaman`
  MODIFY `id_pinjaman` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `pinjaman_laporan`
--
ALTER TABLE `pinjaman_laporan`
  MODIFY `id_pinjaman` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `settings_website`
--
ALTER TABLE `settings_website`
  MODIFY `id_settings` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `simpanan`
--
ALTER TABLE `simpanan`
  MODIFY `id_simpanan` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
