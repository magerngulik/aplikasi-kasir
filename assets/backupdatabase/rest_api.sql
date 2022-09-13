-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 13, 2022 at 10:11 PM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 7.4.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rest_api`
--

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `image` varchar(128) NOT NULL,
  `password` varchar(256) NOT NULL,
  `role_id` int(11) NOT NULL,
  `is_active` int(1) NOT NULL,
  `date_created` int(11) NOT NULL,
  `id_pegawai` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `image`, `password`, `role_id`, `is_active`, `date_created`, `id_pegawai`) VALUES
(12, 'admin', 'admin', 'default.jpg', '$2y$10$NwpU5an0YlY3Uw0AUGCMXu31EuUcgPRqJmCaON7HIKvCP7HkauFWK', 1, 1, 1660051020, 'PEG-001'),
(16, 'Kasirgraha', 'Kasirgraha', 'default.jpg', '$2y$10$TCWoqi/TpB8OwugXO4k7wOcx/UOQLWu07Ps5n1zQuLcYbsHWtqnYW', 2, 1, 1661221953, 'PEG-002'),
(17, 'admingraha', 'admingraha', 'default.jpg', '$2y$10$NwpU5an0YlY3Uw0AUGCMXu31EuUcgPRqJmCaON7HIKvCP7HkauFWK', 3, 1, 1660051020, 'PEG-001');

-- --------------------------------------------------------

--
-- Table structure for table `user_access_menu`
--

CREATE TABLE `user_access_menu` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_access_menu`
--

INSERT INTO `user_access_menu` (`id`, `role_id`, `menu_id`) VALUES
(1, 1, 1),
(3, 2, 2),
(19, 2, 15),
(22, 1, 16),
(23, 1, 5),
(25, 1, 14),
(38, 3, 5),
(39, 3, 14),
(40, 3, 16),
(41, 3, 2),
(42, 1, 3),
(43, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `user_menu`
--

CREATE TABLE `user_menu` (
  `id` int(11) NOT NULL,
  `menu` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_menu`
--

INSERT INTO `user_menu` (`id`, `menu`) VALUES
(1, 'Admin'),
(2, 'User'),
(3, 'Menu'),
(5, 'Data Master'),
(13, 'Testing'),
(14, 'Transaksi'),
(15, 'Kasir'),
(16, 'Laporan'),
(17, 'Pengaturan');

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `id` int(11) NOT NULL,
  `role` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id`, `role`) VALUES
(1, 'Administrator'),
(2, 'Kasirgraha'),
(3, 'Admingraha');

-- --------------------------------------------------------

--
-- Table structure for table `user_sub_menu`
--

CREATE TABLE `user_sub_menu` (
  `id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `title` varchar(128) NOT NULL,
  `url` varchar(128) NOT NULL,
  `icon` varchar(128) NOT NULL,
  `is_active` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_sub_menu`
--

INSERT INTO `user_sub_menu` (`id`, `menu_id`, `title`, `url`, `icon`, `is_active`) VALUES
(1, 1, 'Dashboard', 'admin', 'fas fa-fw fa-tachometer-alt', 1),
(2, 2, 'My Profile', 'user', 'fas fa-fw fa-user', 1),
(3, 2, 'Edit Profile', 'user/edit', 'fas fa-fw fa-user-edit', 1),
(4, 3, 'Menu Management', 'menu', 'fas fa-fw fa-folder', 1),
(5, 3, 'Submenu Management', 'menu/submenu', 'fas fa-fw fa-folder-open', 1),
(7, 1, 'Role', 'admin/role', 'fas fa-fw fa-user-tie', 1),
(8, 2, 'Change Password', 'user/changepassword', 'fas fa-fw fa-key', 1),
(16, 5, 'Kategori', 'data/kategori', 'fas fa-fw fa-list', 1),
(17, 5, 'Suppiler', 'data/suppiler', 'fas fa-fw fa-list', 1),
(18, 5, 'Konsumen', 'data/konsumen', 'fas fa-fw fa-list', 1),
(19, 5, 'Pegawai', 'data/pegawai', 'fas fa-fw fa-list', 1),
(20, 13, 'Push Array', 'testing', 'fas fa-fw-fa-list', 1),
(21, 14, 'Pembelian', 'transaksi', 'fas fa-money-check', 1),
(22, 14, 'Penjualan', 'transaksi/penjualan', 'fas fa-money-bill ', 1),
(23, 14, 'Cek Harga', 'transaksi/cekharga', 'fas fa-money-bill', 1),
(24, 15, 'Penjualan', 'transaksi/penjualan', 'fas fa-money-check', 1),
(25, 15, 'Pembelian', 'transaksi', 'fas fa-money-check', 1),
(26, 15, 'Cek Harga', 'transaksi/cekharga', 'fas fa-money-check', 1),
(27, 16, 'Data Barang', 'laporan', 'fas fa-money-check', 1),
(28, 16, 'Data Pelangan', 'laporan/datapelanggan', 'fas fa-book', 1),
(29, 16, 'Data Pembelian', 'laporan/datapembelian', 'fas fa-book', 1),
(30, 16, 'Data Penjualan', 'laporan/datapenjualan', 'fas fa-book', 1),
(31, 16, 'Stok Minus Barang', 'laporan/stokminus', 'fas fa-book', 1),
(32, 17, 'Recovery Pembelian', 'pengaturan', 'fas fa-book', 1),
(33, 17, 'Recovery Penjualan', 'pengaturan/penjualan', 'fas fa-book', 1),
(34, 16, 'Backup Database', 'laporan/backup', 'fas fa-book', 1),
(35, 5, 'Barang', 'data', 'fas fa-fw fa-boxes', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_token`
--

CREATE TABLE `user_token` (
  `id` int(11) NOT NULL,
  `email` varchar(128) NOT NULL,
  `token` varchar(128) NOT NULL,
  `date_created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_token`
--

INSERT INTO `user_token` (`id`, `email`, `token`, `date_created`) VALUES
(9, 'admin@admin.com', '1Dnvr01Fcz1DOAO+CZ8hU43gHync9LHAkZd++MxQY5U=', 1660051020);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_access_menu`
--
ALTER TABLE `user_access_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_menu`
--
ALTER TABLE `user_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_token`
--
ALTER TABLE `user_token`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `user_access_menu`
--
ALTER TABLE `user_access_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `user_menu`
--
ALTER TABLE `user_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `user_token`
--
ALTER TABLE `user_token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
