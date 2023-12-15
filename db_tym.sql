-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 15, 2023 at 12:17 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_tym`
--
CREATE DATABASE IF NOT EXISTS `db_tym` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `db_tym`;

-- --------------------------------------------------------

--
-- Table structure for table `tb_batasan_pengeluaran`
--

CREATE TABLE `tb_batasan_pengeluaran` (
  `id` int(11) NOT NULL,
  `kategori` varchar(255) NOT NULL,
  `nominal` varchar(100) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `bulan_tahun` varchar(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_catatpeng`
--

CREATE TABLE `tb_catatpeng` (
  `id` int(11) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `pengeluaran` varchar(100) NOT NULL,
  `kategori` varchar(255) NOT NULL,
  `nominal` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_kategori`
--

CREATE TABLE `tb_kategori` (
  `id` int(11) NOT NULL,
  `nama_kategori` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_kategori`
--

INSERT INTO `tb_kategori` (`id`, `nama_kategori`) VALUES
(1, 'Belanja Bulanan'),
(8, 'Dana Darurat'),
(5, 'Edukasi'),
(2, 'Hiburan'),
(3, 'Kesehatan'),
(6, 'Makanan dan minuman'),
(7, 'Paket digital'),
(4, 'Transportasi                                                                           ');

-- --------------------------------------------------------

--
-- Table structure for table `tb_pengingat`
--

CREATE TABLE `tb_pengingat` (
  `id` int(11) NOT NULL,
  `nama_pengingat` varchar(255) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `nominal_pengingat` varchar(255) NOT NULL,
  `tanggal_pengingat` date NOT NULL,
  `status` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `no_telp` varchar(30) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `pass` varchar(255) NOT NULL,
  `reset_timestamp` int(11) DEFAULT NULL,
  `reset_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_batasan_pengeluaran`
--
ALTER TABLE `tb_batasan_pengeluaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `fk_kategori_batasan` (`kategori`);

--
-- Indexes for table `tb_catatpeng`
--
ALTER TABLE `tb_catatpeng`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user_tb` (`user_id`),
  ADD KEY `tb_kategori` (`kategori`);

--
-- Indexes for table `tb_kategori`
--
ALTER TABLE `tb_kategori`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama_kategori` (`nama_kategori`),
  ADD KEY `idx_nama_kategori` (`nama_kategori`);

--
-- Indexes for table `tb_pengingat`
--
ALTER TABLE `tb_pengingat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username_id` (`user_id`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`),
  ADD KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_batasan_pengeluaran`
--
ALTER TABLE `tb_batasan_pengeluaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT for table `tb_catatpeng`
--
ALTER TABLE `tb_catatpeng`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=414;

--
-- AUTO_INCREMENT for table `tb_kategori`
--
ALTER TABLE `tb_kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tb_pengingat`
--
ALTER TABLE `tb_pengingat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_batasan_pengeluaran`
--
ALTER TABLE `tb_batasan_pengeluaran`
  ADD CONSTRAINT `fk_kategori_batasan` FOREIGN KEY (`kategori`) REFERENCES `tb_kategori` (`nama_kategori`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_batasan_pengeluaran_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tb_user` (`id`);

--
-- Constraints for table `tb_catatpeng`
--
ALTER TABLE `tb_catatpeng`
  ADD CONSTRAINT `id_user_tb` FOREIGN KEY (`user_id`) REFERENCES `tb_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_kategori` FOREIGN KEY (`kategori`) REFERENCES `tb_kategori` (`nama_kategori`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tb_pengingat`
--
ALTER TABLE `tb_pengingat`
  ADD CONSTRAINT `username_id` FOREIGN KEY (`user_id`) REFERENCES `tb_user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
