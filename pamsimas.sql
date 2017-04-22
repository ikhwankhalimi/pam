-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 22, 2017 at 09:46 AM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.5.37

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pamsimas`
--

-- --------------------------------------------------------

--
-- Table structure for table `golongan`
--

CREATE TABLE `golongan` (
  `id_gol` int(11) NOT NULL,
  `nama_gol` varchar(50) NOT NULL,
  `tarif` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `golongan`
--

INSERT INTO `golongan` (`id_gol`, `nama_gol`, `tarif`) VALUES
(8, 'Rumah Tangga', 1800),
(9, 'Sosial', 1200),
(10, 'Perusahaan', 2000);

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `no_pelanggan` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` varchar(150) NOT NULL,
  `telp` varchar(13) NOT NULL,
  `id_golongan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`no_pelanggan`, `nama`, `alamat`, `telp`, `id_golongan`) VALUES
(41701, 'ikhwan', 'Jl. H. Siraj No. 17', '0823', 8);

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_pembayaran` int(10) NOT NULL,
  `no_rekening` varchar(15) NOT NULL,
  `pemakaian` int(5) NOT NULL,
  `bulan` int(2) NOT NULL,
  `tahun` int(4) NOT NULL,
  `tgl_pembayaran` date NOT NULL,
  `adm` int(7) NOT NULL,
  `bayar_angsuran` int(7) DEFAULT '0',
  `denda` int(6) NOT NULL,
  `id_user` int(11) NOT NULL,
  `tagihan_air` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`id_pembayaran`, `no_rekening`, `pemakaian`, `bulan`, `tahun`, `tgl_pembayaran`, `adm`, `bayar_angsuran`, `denda`, `id_user`, `tagihan_air`) VALUES
(220417001, '41701', 12, 1, 2017, '2017-04-22', 5000, 0, 3000, 17, 21600),
(220417002, '41701', 1, 2, 2017, '2017-04-22', 5000, 0, 3000, 17, 7200);

-- --------------------------------------------------------

--
-- Table structure for table `registrasi`
--

CREATE TABLE `registrasi` (
  `no_rekening` varchar(15) NOT NULL,
  `no_pelanggan` int(11) NOT NULL,
  `angsuran` int(11) NOT NULL,
  `tgl_registrasi` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `registrasi`
--

INSERT INTO `registrasi` (`no_rekening`, `no_pelanggan`, `angsuran`, `tgl_registrasi`) VALUES
('41701', 41701, 400000, '2017-04-22');

-- --------------------------------------------------------

--
-- Table structure for table `stand`
--

CREATE TABLE `stand` (
  `id` int(11) NOT NULL,
  `no_rekening` varchar(15) NOT NULL,
  `stand_awal` int(5) NOT NULL,
  `stand_akhir` int(5) NOT NULL,
  `bulan` int(2) NOT NULL,
  `tahun` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stand`
--

INSERT INTO `stand` (`id`, `no_rekening`, `stand_awal`, `stand_akhir`, `bulan`, `tahun`) VALUES
(1, '41701', 0, 0, 4, 2017),
(2, '41701', 0, 12, 1, 2017),
(3, '41701', 12, 13, 2, 2017);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `nama`, `email`, `username`, `password`) VALUES
(1, 'fadli', 'fadli123@gmail.com', 'fadli', '0a539e9da09b0ab58fd282832c07b6ab'),
(17, 'a', 'a', 'a', '0cc175b9c0f1b6a831c399e269772661');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `golongan`
--
ALTER TABLE `golongan`
  ADD PRIMARY KEY (`id_gol`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`no_pelanggan`),
  ADD KEY `id_golongan` (`id_golongan`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`),
  ADD KEY `no_rekening` (`no_rekening`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `registrasi`
--
ALTER TABLE `registrasi`
  ADD PRIMARY KEY (`no_rekening`),
  ADD KEY `no_pelanggan` (`no_pelanggan`);

--
-- Indexes for table `stand`
--
ALTER TABLE `stand`
  ADD PRIMARY KEY (`id`),
  ADD KEY `no_rekening` (`no_rekening`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `golongan`
--
ALTER TABLE `golongan`
  MODIFY `id_gol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `stand`
--
ALTER TABLE `stand`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD CONSTRAINT `fk_golongan_id` FOREIGN KEY (`id_golongan`) REFERENCES `golongan` (`id_gol`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`no_rekening`) REFERENCES `registrasi` (`no_rekening`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `registrasi`
--
ALTER TABLE `registrasi`
  ADD CONSTRAINT `fk_no_pelanggan_fk` FOREIGN KEY (`no_pelanggan`) REFERENCES `pelanggan` (`no_pelanggan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `stand`
--
ALTER TABLE `stand`
  ADD CONSTRAINT `fk_n_rekening_id` FOREIGN KEY (`no_rekening`) REFERENCES `registrasi` (`no_rekening`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
