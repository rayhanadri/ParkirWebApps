-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 20, 2024 at 09:42 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbparkir`
--

-- --------------------------------------------------------

--
-- Table structure for table `monitorkendaraan_tt`
--

CREATE TABLE `monitorkendaraan_tt` (
  `id` int(11) NOT NULL,
  `waktuMasuk` datetime DEFAULT NULL,
  `waktuKeluar` datetime DEFAULT NULL,
  `jenisKendaraan` varchar(255) DEFAULT NULL,
  `nomorPolisi` varchar(45) DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `lastChangeDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `monitorkendaraan_tt`
--

INSERT INTO `monitorkendaraan_tt` (`id`, `waktuMasuk`, `waktuKeluar`, `jenisKendaraan`, `nomorPolisi`, `status`, `lastChangeDate`) VALUES
(1, '2023-02-06 22:35:27', NULL, 'Motor', 'A123B', 'MASUK', '2023-02-06 22:35:27'),
(2, '2023-02-06 22:36:57', NULL, 'Mobil Penumpang', 'A111Q', 'MASUK', '2023-02-06 22:36:57'),
(3, '2023-02-06 21:27:32', '2023-02-06 22:38:51', 'Mobil Barang', 'B11Q', 'KELUAR', '2023-02-06 22:38:51'),
(4, '2023-02-06 21:34:17', NULL, 'Mobil Barang', 'B22F', 'MASUK', '2023-02-06 21:34:17'),
(5, '2023-02-06 21:35:40', '2023-02-06 22:40:48', 'Motor', 'A33C', 'KELUAR', '2023-02-06 22:40:48'),
(6, '2023-02-06 21:11:19', '2023-02-06 22:41:26', 'Motor', 'A55V', 'KELUAR', '2023-02-06 22:41:26'),
(7, '2023-02-05 21:41:43', '2023-02-06 22:42:23', 'Mobil Barang', 'C44S', 'KELUAR', '2023-02-06 22:42:23'),
(8, '2023-02-06 21:33:12', NULL, 'Mobil Penumpang', 'A44Q', 'MASUK', '2023-02-06 21:33:12'),
(9, '2023-02-06 21:35:11', '2023-02-06 23:31:53', 'Mobil Penumpang', 'A123W', 'KELUAR', '2023-02-06 23:31:53'),
(10, '2023-02-07 18:05:41', '2023-02-07 18:05:48', 'Motor', 'A23Q', 'KELUAR', '2023-02-07 18:05:48'),
(11, '2023-02-08 15:29:46', '2023-02-08 15:30:26', 'Mobil Penumpang', 'A444B', 'KELUAR', '2023-02-08 15:30:26'),
(12, '2023-02-08 15:35:18', '2023-02-08 15:35:38', 'Motor', 'W11Q', 'KELUAR', '2023-02-08 15:35:38');

-- --------------------------------------------------------

--
-- Table structure for table `parkirconfigjeniskendaraan_tm`
--

CREATE TABLE `parkirconfigjeniskendaraan_tm` (
  `id` int(11) NOT NULL,
  `jenisKendaraan` varchar(255) DEFAULT NULL,
  `biayaPerJam` decimal(10,0) DEFAULT NULL,
  `maxBiaya` decimal(10,0) DEFAULT NULL,
  `lastChangeDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `parkirconfigjeniskendaraan_tm`
--

INSERT INTO `parkirconfigjeniskendaraan_tm` (`id`, `jenisKendaraan`, `biayaPerJam`, `maxBiaya`, `lastChangeDate`) VALUES
(1, 'Motor', '2000', '3000', '2023-02-08 15:35:03'),
(2, 'Mobil Penumpang', '2000', '6000', '2023-02-04 12:53:59'),
(3, 'Mobil Barang', '3000', '9000', '2023-02-04 19:28:51');

-- --------------------------------------------------------

--
-- Table structure for table `parkircontrol_tm`
--

CREATE TABLE `parkircontrol_tm` (
  `id` int(11) NOT NULL,
  `minMenitStlh1Jam` decimal(10,0) DEFAULT NULL,
  `lastChangeDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `parkircontrol_tm`
--

INSERT INTO `parkircontrol_tm` (`id`, `minMenitStlh1Jam`, `lastChangeDate`) VALUES
(1, '20', '2023-02-08 15:36:14');

-- --------------------------------------------------------

--
-- Table structure for table `parkirtiketconfig_tm`
--

CREATE TABLE `parkirtiketconfig_tm` (
  `id` int(11) NOT NULL,
  `jenisTiket` varchar(45) DEFAULT NULL,
  `tiketTextTemplate` longtext DEFAULT NULL,
  `lastChangeDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `parkirtiketconfig_tm`
--

INSERT INTO `parkirtiketconfig_tm` (`id`, `jenisTiket`, `tiketTextTemplate`, `lastChangeDate`) VALUES
(1, 'MASUK', '<h1>TIKET MASUK PARKIR</h1><br>\r\nMASUK : @@DATE_MASUK@@<br>\r\nNO POLISI : @@NOPOL@@<br>\r\nJENIS KENDARAAN : @@JENIS_KENDARAAN@@<br>\r\n<br>\r\n---SELAMAT DATANG---<br>\r\nHARAP TIKET INI JANGAN HILANG', '2023-02-11 14:39:18'),
(2, 'KELUAR', '<h1>TIKET KELUAR PARKIR</h1><br><br>\r\nMASUK : @@DATE_MASUK@@<br>\r\nKELUAR : @@DATE_KELUAR@@<br><br>\r\nNO POLISI : @@NOPOL@@<br>\r\nJENIS KENDARAAN : @@JENIS_KENDARAAN@@<br><br>\r\nTOTAL WAKTU PARKIR : @@TOTAL_WAKTU@@<br>\r\nTOTAL BAYAR : <span id=\"currency\">@@TOTAL_BIAYA@@</span><br>\r\n<br>\r\n---TERIMA KASIH---<br>', '2023-02-04 14:44:33'),
(3, 'ERROR', '<h1>TIKET ERROR</h1><br><br>\r\n@@ERR_MSG@@<br>\r\n<br>\r\n---TERJADI KESALAHAN PROSES TIKET PARKIR, SILAKAN HUBUNGI PETUGAS---<br>', '2023-02-04 17:07:41');

-- --------------------------------------------------------

--
-- Table structure for table `parkirtiket_tt`
--

CREATE TABLE `parkirtiket_tt` (
  `id` int(11) NOT NULL,
  `jenisTiket` varchar(45) DEFAULT NULL,
  `transactionIdMasuk` int(11) DEFAULT NULL,
  `transactionIdKeluar` int(11) DEFAULT NULL,
  `jenisKendaraan` varchar(255) DEFAULT NULL,
  `configControlId` int(11) DEFAULT NULL,
  `parkirTiketConfigId` int(11) DEFAULT NULL,
  `totalBiaya` decimal(10,0) DEFAULT NULL,
  `tiketText` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `parkirtiket_tt`
--

INSERT INTO `parkirtiket_tt` (`id`, `jenisTiket`, `transactionIdMasuk`, `transactionIdKeluar`, `jenisKendaraan`, `configControlId`, `parkirTiketConfigId`, `totalBiaya`, `tiketText`) VALUES
(1, 'MASUK', 1, NULL, 'Motor', 1, 1, '0', '<h1>TIKET MASUK PARKIR</h1><br>\r\nMASUK : 2023-02-06 22:35:27<br>\r\nNO POLISI : A123B<br>\r\nJENIS KENDARAAN : Motor<br>\r\n<br>\r\n---SELAMAT DATANG---<br>\r\nHARAP TIKET INI JANGAN HILANG'),
(2, 'MASUK', 2, NULL, 'Mobil Penumpang', 1, 1, '0', '<h1>TIKET MASUK PARKIR</h1><br>\r\nMASUK : 2023-02-06 22:36:57<br>\r\nNO POLISI : A111Q<br>\r\nJENIS KENDARAAN : Mobil Penumpang<br>\r\n<br>\r\n---SELAMAT DATANG---<br>\r\nHARAP TIKET INI JANGAN HILANG'),
(3, 'MASUK', 3, NULL, 'Mobil Barang', 1, 1, '0', '<h1>TIKET MASUK PARKIR</h1><br>\r\nMASUK : 2023-02-06 21:27:32<br>\r\nNO POLISI : B11Q<br>\r\nJENIS KENDARAAN : Mobil Barang<br>\r\n<br>\r\n---SELAMAT DATANG---<br>\r\nHARAP TIKET INI JANGAN HILANG'),
(4, 'KELUAR', 3, 4, 'Mobil Barang', 1, 2, '6000', '<h1>TIKET KELUAR PARKIR</h1><br><br>\r\nMASUK : 2023-02-06 21:27:32<br>\r\nKELUAR : 2023-02-06 22:38:51<br><br>\r\nNO POLISI : B11Q<br>\r\nJENIS KENDARAAN : Mobil Barang<br><br>\r\nTOTAL WAKTU PARKIR : 1 jam, 11 menit<br>\r\nTOTAL BAYAR : <span id=\"currency\">6000</span><br>\r\n<br>\r\n---TERIMA KASIH---<br>'),
(5, 'MASUK', 5, NULL, 'Mobil Barang', 1, 1, '0', '<h1>TIKET MASUK PARKIR</h1><br>\r\nMASUK : 2023-02-06 21:34:17<br>\r\nNO POLISI : B22F<br>\r\nJENIS KENDARAAN : Mobil Barang<br>\r\n<br>\r\n---SELAMAT DATANG---<br>\r\nHARAP TIKET INI JANGAN HILANG'),
(6, 'MASUK', 6, NULL, 'Motor', 1, 1, '0', '<h1>TIKET MASUK PARKIR</h1><br>\r\nMASUK : 2023-02-06 21:35:40<br>\r\nNO POLISI : A33C<br>\r\nJENIS KENDARAAN : Motor<br>\r\n<br>\r\n---SELAMAT DATANG---<br>\r\nHARAP TIKET INI JANGAN HILANG'),
(7, 'KELUAR', 6, 7, 'Motor', 1, 2, '1000', '<h1>TIKET KELUAR PARKIR</h1><br><br>\r\nMASUK : 2023-02-06 21:35:40<br>\r\nKELUAR : 2023-02-06 22:40:48<br><br>\r\nNO POLISI : A33C<br>\r\nJENIS KENDARAAN : Motor<br><br>\r\nTOTAL WAKTU PARKIR : 1 jam, 5 menit<br>\r\nTOTAL BAYAR : <span id=\"currency\">1000</span><br>\r\n<br>\r\n---TERIMA KASIH---<br>'),
(8, 'MASUK', 8, NULL, 'Motor', 1, 1, '0', '<h1>TIKET MASUK PARKIR</h1><br>\r\nMASUK : 2023-02-06 21:11:19<br>\r\nNO POLISI : A55V<br>\r\nJENIS KENDARAAN : Motor<br>\r\n<br>\r\n---SELAMAT DATANG---<br>\r\nHARAP TIKET INI JANGAN HILANG'),
(9, 'KELUAR', 8, 9, 'Motor', 1, 2, '2000', '<h1>TIKET KELUAR PARKIR</h1><br><br>\r\nMASUK : 2023-02-06 21:11:19<br>\r\nKELUAR : 2023-02-06 22:41:26<br><br>\r\nNO POLISI : A55V<br>\r\nJENIS KENDARAAN : Motor<br><br>\r\nTOTAL WAKTU PARKIR : 1 jam, 30 menit<br>\r\nTOTAL BAYAR : <span id=\"currency\">2000</span><br>\r\n<br>\r\n---TERIMA KASIH---<br>'),
(10, 'MASUK', 10, NULL, 'Mobil Barang', 1, 1, '0', '<h1>TIKET MASUK PARKIR</h1><br>\r\nMASUK : 2023-02-05 21:41:43<br>\r\nNO POLISI : C44S<br>\r\nJENIS KENDARAAN : Mobil Barang<br>\r\n<br>\r\n---SELAMAT DATANG---<br>\r\nHARAP TIKET INI JANGAN HILANG'),
(11, 'KELUAR', 10, 11, 'Mobil Barang', 1, 2, '12000', '<h1>TIKET KELUAR PARKIR</h1><br><br>\r\nMASUK : 2023-02-05 21:41:43<br>\r\nKELUAR : 2023-02-06 22:42:23<br><br>\r\nNO POLISI : C44S<br>\r\nJENIS KENDARAAN : Mobil Barang<br><br>\r\nTOTAL WAKTU PARKIR : 1 hari, 1 jam, 0 menit<br>\r\nTOTAL BAYAR : <span id=\"currency\">12000</span><br>\r\n<br>\r\n---TERIMA KASIH---<br>'),
(12, 'MASUK', 12, NULL, 'Mobil Penumpang', 1, 1, '0', '<h1>TIKET MASUK PARKIR</h1><br>\r\nMASUK : 2023-02-06 21:33:12<br>\r\nNO POLISI : A44Q<br>\r\nJENIS KENDARAAN : Mobil Penumpang<br>\r\n<br>\r\n---SELAMAT DATANG---<br>\r\nHARAP TIKET INI JANGAN HILANG'),
(13, 'MASUK', 13, NULL, 'Mobil Penumpang', 1, 1, '0', '<h1>TIKET MASUK PARKIR</h1><br>\r\nMASUK : 2023-02-06 21:35:11<br>\r\nNO POLISI : A123W<br>\r\nJENIS KENDARAAN : Mobil Penumpang<br>\r\n<br>\r\n---SELAMAT DATANG---<br>\r\nHARAP TIKET INI JANGAN HILANG'),
(14, 'KELUAR', 13, 14, 'Mobil Penumpang', 1, 2, '4000', '<h1>TIKET KELUAR PARKIR</h1><br><br>\r\nMASUK : 2023-02-06 21:35:11<br>\r\nKELUAR : 2023-02-06 23:31:53<br><br>\r\nNO POLISI : A123W<br>\r\nJENIS KENDARAAN : Mobil Penumpang<br><br>\r\nTOTAL WAKTU PARKIR : 1 jam, 56 menit<br>\r\nTOTAL BAYAR : <span id=\"currency\">4000</span><br>\r\n<br>\r\n---TERIMA KASIH---<br>'),
(15, 'MASUK', 15, NULL, 'Motor', 1, 1, '0', '<h1>TIKET MASUK PARKIR</h1><br>\r\nMASUK : 2023-02-07 18:05:41<br>\r\nNO POLISI : A23Q<br>\r\nJENIS KENDARAAN : Motor<br>\r\n<br>\r\n---SELAMAT DATANG---<br>\r\nHARAP TIKET INI JANGAN HILANG'),
(16, 'KELUAR', 15, 16, 'Motor', 1, 2, '2000', '<h1>TIKET KELUAR PARKIR</h1><br><br>\r\nMASUK : 2023-02-07 18:05:41<br>\r\nKELUAR : 2023-02-07 18:05:48<br><br>\r\nNO POLISI : A23Q<br>\r\nJENIS KENDARAAN : Motor<br><br>\r\nTOTAL WAKTU PARKIR : 0 jam, 0 menit<br>\r\nTOTAL BAYAR : <span id=\"currency\">2000</span><br>\r\n<br>\r\n---TERIMA KASIH---<br>'),
(17, 'MASUK', 17, NULL, 'Mobil Penumpang', 1, 1, '0', '<h1>TIKET MASUK PARKIR</h1><br>\r\nMASUK : 2023-02-08 15:29:46<br>\r\nNO POLISI : A444B<br>\r\nJENIS KENDARAAN : Mobil Penumpang<br>\r\n<br>\r\n---SELAMAT DATANG---<br>\r\nHARAP TIKET INI JANGAN HILANG'),
(18, 'KELUAR', 17, 18, 'Mobil Penumpang', 1, 2, '2000', '<h1>TIKET KELUAR PARKIR</h1><br><br>\r\nMASUK : 2023-02-08 15:29:46<br>\r\nKELUAR : 2023-02-08 15:30:26<br><br>\r\nNO POLISI : A444B<br>\r\nJENIS KENDARAAN : Mobil Penumpang<br><br>\r\nTOTAL WAKTU PARKIR : 0 jam, 0 menit<br>\r\nTOTAL BAYAR : <span id=\"currency\">2000</span><br>\r\n<br>\r\n---TERIMA KASIH---<br>'),
(19, 'MASUK', 19, NULL, 'Motor', 1, 1, '0', '<h1>TIKET MASUK PARKIR</h1><br>\r\nMASUK : 2023-02-08 15:35:18<br>\r\nNO POLISI : W11Q<br>\r\nJENIS KENDARAAN : Motor<br>\r\n<br>\r\n---SELAMAT DATANG---<br>\r\nHARAP TIKET INI JANGAN HILANG'),
(20, 'KELUAR', 19, 20, 'Motor', 1, 2, '2000', '<h1>TIKET KELUAR PARKIR</h1><br><br>\r\nMASUK : 2023-02-08 15:35:18<br>\r\nKELUAR : 2023-02-08 15:35:38<br><br>\r\nNO POLISI : W11Q<br>\r\nJENIS KENDARAAN : Motor<br><br>\r\nTOTAL WAKTU PARKIR : 0 jam, 0 menit<br>\r\nTOTAL BAYAR : <span id=\"currency\">2000</span><br>\r\n<br>\r\n---TERIMA KASIH---<br>');

-- --------------------------------------------------------

--
-- Table structure for table `parkirtransaction_tt`
--

CREATE TABLE `parkirtransaction_tt` (
  `id` int(11) NOT NULL,
  `waktu` datetime DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `jenisKendaraan` varchar(255) DEFAULT NULL,
  `nomorPolisi` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `parkirtransaction_tt`
--

INSERT INTO `parkirtransaction_tt` (`id`, `waktu`, `status`, `jenisKendaraan`, `nomorPolisi`) VALUES
(1, '2023-02-06 22:35:27', 'MASUK', 'Motor', 'A123B'),
(2, '2023-02-06 22:36:57', 'MASUK', 'Mobil Penumpang', 'A111Q'),
(3, '2023-02-06 21:27:32', 'MASUK', 'Mobil Barang', 'B11Q'),
(4, '2023-02-06 22:38:51', 'KELUAR', 'Mobil Barang', 'B11Q'),
(5, '2023-02-06 21:34:17', 'MASUK', 'Mobil Barang', 'B22F'),
(6, '2023-02-06 21:35:40', 'MASUK', 'Motor', 'A33C'),
(7, '2023-02-06 22:40:48', 'KELUAR', 'Motor', 'A33C'),
(8, '2023-02-06 21:11:19', 'MASUK', 'Motor', 'A55V'),
(9, '2023-02-06 22:41:26', 'KELUAR', 'Motor', 'A55V'),
(10, '2023-02-05 21:41:43', 'MASUK', 'Mobil Barang', 'C44S'),
(11, '2023-02-06 22:42:23', 'KELUAR', 'Mobil Barang', 'C44S'),
(12, '2023-02-06 21:33:12', 'MASUK', 'Mobil Penumpang', 'A44Q'),
(13, '2023-02-06 21:35:11', 'MASUK', 'Mobil Penumpang', 'A123W'),
(14, '2023-02-06 23:31:53', 'KELUAR', 'Mobil Penumpang', 'A123W'),
(15, '2023-02-07 18:05:41', 'MASUK', 'Motor', 'A23Q'),
(16, '2023-02-07 18:05:48', 'KELUAR', 'Motor', 'A23Q'),
(17, '2023-02-08 15:29:46', 'MASUK', 'Mobil Penumpang', 'A444B'),
(18, '2023-02-08 15:30:26', 'KELUAR', 'Mobil Penumpang', 'A444B'),
(19, '2023-02-08 15:35:18', 'MASUK', 'Motor', 'W11Q'),
(20, '2023-02-08 15:35:38', 'KELUAR', 'Motor', 'W11Q');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `monitorkendaraan_tt`
--
ALTER TABLE `monitorkendaraan_tt`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parkirconfigjeniskendaraan_tm`
--
ALTER TABLE `parkirconfigjeniskendaraan_tm`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parkircontrol_tm`
--
ALTER TABLE `parkircontrol_tm`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parkirtiketconfig_tm`
--
ALTER TABLE `parkirtiketconfig_tm`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parkirtiket_tt`
--
ALTER TABLE `parkirtiket_tt`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parkirtransaction_tt`
--
ALTER TABLE `parkirtransaction_tt`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `monitorkendaraan_tt`
--
ALTER TABLE `monitorkendaraan_tt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `parkirconfigjeniskendaraan_tm`
--
ALTER TABLE `parkirconfigjeniskendaraan_tm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `parkircontrol_tm`
--
ALTER TABLE `parkircontrol_tm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `parkirtiketconfig_tm`
--
ALTER TABLE `parkirtiketconfig_tm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `parkirtiket_tt`
--
ALTER TABLE `parkirtiket_tt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `parkirtransaction_tt`
--
ALTER TABLE `parkirtransaction_tt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
