-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 21 Apr 2017 pada 04.52
-- Versi Server: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `pamsimas`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `golongan`
--

CREATE TABLE IF NOT EXISTS `golongan` (
`id_gol` int(11) NOT NULL,
  `nama_gol` varchar(50) NOT NULL,
  `tarif` int(6) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data untuk tabel `golongan`
--

INSERT INTO `golongan` (`id_gol`, `nama_gol`, `tarif`) VALUES
(8, 'Rumah Tangga', 1800),
(9, 'Sosial', 1200),
(10, 'Perusahaan', 2000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelanggan`
--

CREATE TABLE IF NOT EXISTS `pelanggan` (
  `no_pelanggan` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` varchar(150) NOT NULL,
  `telp` varchar(13) NOT NULL,
  `id_golongan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pelanggan`
--

INSERT INTO `pelanggan` (`no_pelanggan`, `nama`, `alamat`, `telp`, `id_golongan`) VALUES
(31701, 'Joko', 'RT01/RW02', '082138434924', 8),
(41702, 'Budi', 'RT02/RW02', '082314492697', 8),
(41703, 'Bambang', 'RT02/RW03', '087830684777', 8),
(41704, 'Udin', 'RT01/RW01', '087830684732', 8);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembayaran`
--

CREATE TABLE IF NOT EXISTS `pembayaran` (
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
-- Dumping data untuk tabel `pembayaran`
--

INSERT INTO `pembayaran` (`id_pembayaran`, `no_rekening`, `pemakaian`, `bulan`, `tahun`, `tgl_pembayaran`, `adm`, `bayar_angsuran`, `denda`, `id_user`, `tagihan_air`) VALUES
(10317001, '31701', 23, 4, 2017, '2017-03-01', 5000, 0, 0, 17, 41400),
(10317002, '31701', 1, 5, 2017, '2017-03-01', 5000, 0, 0, 17, 10000),
(150417003, '41702', 4, 5, 2017, '2017-04-15', 5000, 0, 0, 1, 7200),
(150417004, '41704', 5, 5, 2017, '2017-04-15', 5000, 200000, 0, 1, 9000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `registrasi`
--

CREATE TABLE IF NOT EXISTS `registrasi` (
  `no_rekening` varchar(15) NOT NULL,
  `no_pelanggan` int(11) NOT NULL,
  `angsuran` int(11) NOT NULL,
  `tgl_registrasi` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `registrasi`
--

INSERT INTO `registrasi` (`no_rekening`, `no_pelanggan`, `angsuran`, `tgl_registrasi`) VALUES
('31701', 31701, 400000, '2017-03-01'),
('41702', 41702, 400000, '2017-04-13'),
('41703', 41703, 400000, '2017-04-15'),
('41704', 41704, 200000, '2017-04-15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `stand`
--

CREATE TABLE IF NOT EXISTS `stand` (
`id` int(11) NOT NULL,
  `no_rekening` varchar(15) NOT NULL,
  `stand_awal` int(5) NOT NULL,
  `stand_akhir` int(5) NOT NULL,
  `bulan` int(2) NOT NULL,
  `tahun` int(4) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data untuk tabel `stand`
--

INSERT INTO `stand` (`id`, `no_rekening`, `stand_awal`, `stand_akhir`, `bulan`, `tahun`) VALUES
(1, '31701', 0, 0, 3, 2017),
(2, '31701', 0, 23, 4, 2017),
(3, '31701', 23, 24, 5, 2017),
(4, '41702', 0, 0, 4, 2017),
(5, '41702', 0, 4, 5, 2017),
(8, '41703', 0, 0, 4, 2017),
(9, '41704', 0, 0, 4, 2017),
(10, '41704', 0, 5, 5, 2017);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE IF NOT EXISTS `user` (
`id_user` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(35) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data untuk tabel `user`
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
 ADD PRIMARY KEY (`no_pelanggan`), ADD KEY `id_golongan` (`id_golongan`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
 ADD PRIMARY KEY (`id_pembayaran`), ADD KEY `no_rekening` (`no_rekening`), ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `registrasi`
--
ALTER TABLE `registrasi`
 ADD PRIMARY KEY (`no_rekening`), ADD KEY `no_pelanggan` (`no_pelanggan`);

--
-- Indexes for table `stand`
--
ALTER TABLE `stand`
 ADD PRIMARY KEY (`id`), ADD KEY `no_rekening` (`no_rekening`);

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
MODIFY `id_gol` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `stand`
--
ALTER TABLE `stand`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
ADD CONSTRAINT `fk_golongan_id` FOREIGN KEY (`id_golongan`) REFERENCES `golongan` (`id_gol`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`no_rekening`) REFERENCES `registrasi` (`no_rekening`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `registrasi`
--
ALTER TABLE `registrasi`
ADD CONSTRAINT `fk_no_pelanggan_fk` FOREIGN KEY (`no_pelanggan`) REFERENCES `pelanggan` (`no_pelanggan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `stand`
--
ALTER TABLE `stand`
ADD CONSTRAINT `fk_n_rekening_id` FOREIGN KEY (`no_rekening`) REFERENCES `registrasi` (`no_rekening`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
