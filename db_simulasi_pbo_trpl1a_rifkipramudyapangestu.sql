-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 19, 2026 at 02:57 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_simulasi_pbo_trpl1a_rifkipramudyapangestu`
--

-- --------------------------------------------------------

--
-- Table structure for table `tabel_pendaftaran`
--

CREATE TABLE `tabel_pendaftaran` (
  `id_pendaftaran` int NOT NULL,
  `nama_calon` varchar(100) NOT NULL,
  `asal_sekolah` varchar(100) NOT NULL,
  `nilai_ujian` float NOT NULL,
  `biaya_pendaftaran_dasar` int NOT NULL,
  `jalur_pendaftaran` enum('Reguler','Prestasi','Kedinasan') NOT NULL,
  `pilihan_prodi` varchar(50) DEFAULT NULL,
  `lokasi_kampus` varchar(50) DEFAULT NULL,
  `jenis_prestasi` varchar(50) DEFAULT NULL,
  `tingkat_prestasi` varchar(50) DEFAULT NULL,
  `sk_ikatan_dinas` varchar(50) DEFAULT NULL,
  `instansi_sponsor` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tabel_pendaftaran`
--

INSERT INTO `tabel_pendaftaran` (`id_pendaftaran`, `nama_calon`, `asal_sekolah`, `nilai_ujian`, `biaya_pendaftaran_dasar`, `jalur_pendaftaran`, `pilihan_prodi`, `lokasi_kampus`, `jenis_prestasi`, `tingkat_prestasi`, `sk_ikatan_dinas`, `instansi_sponsor`) VALUES
(1, 'Budi Santoso', 'SMA 1 Jakarta', 85, 200000, 'Reguler', 'Informatika', 'Kampus A', NULL, NULL, NULL, NULL),
(2, 'Siti Aminah', 'SMA 2 Bandung', 78.5, 200000, 'Reguler', 'Sistem Informasi', 'Kampus B', NULL, NULL, NULL, NULL),
(3, 'Andi Wijaya', 'SMA 3 Surabaya', 90, 200000, 'Reguler', 'Informatika', 'Kampus A', NULL, NULL, NULL, NULL),
(4, 'Dewi Lestari', 'SMA 4 Medan', 82, 200000, 'Reguler', 'Teknik Komputer', 'Kampus B', NULL, NULL, NULL, NULL),
(5, 'Eko Prasetyo', 'SMA 5 Makassar', 75, 200000, 'Reguler', 'Informatika', 'Kampus A', NULL, NULL, NULL, NULL),
(6, 'Fani Kurnia', 'SMA 6 Yogyakarta', 88, 200000, 'Reguler', 'Sistem Informasi', 'Kampus A', NULL, NULL, NULL, NULL),
(7, 'Gani Ramadhan', 'SMA 7 Semarang', 81.5, 200000, 'Reguler', 'Teknik Komputer', 'Kampus B', NULL, NULL, NULL, NULL),
(8, 'Haniyah Putri', 'SMA 8 Bali', 92, 200000, 'Prestasi', NULL, NULL, 'Olimpiade Matematika', 'Nasional', NULL, NULL),
(9, 'Irfan Hakim', 'SMA 9 Solo', 95, 200000, 'Prestasi', NULL, NULL, 'Juara Catur', 'Provinsi', NULL, NULL),
(10, 'Jaka Sembung', 'SMA 10 Palembang', 89, 200000, 'Prestasi', NULL, NULL, 'Debat Bahasa Inggris', 'Nasional', NULL, NULL),
(11, 'Karin Indah', 'SMA 11 Malang', 91, 200000, 'Prestasi', NULL, NULL, 'Robotik', 'Internasional', NULL, NULL),
(12, 'Lutfi Azis', 'SMA 12 Lampung', 87, 200000, 'Prestasi', NULL, NULL, 'Atletik', 'Kabupaten', NULL, NULL),
(13, 'Maya Sari', 'SMA 13 Bekasi', 93, 200000, 'Prestasi', NULL, NULL, 'Olimpiade Fisika', 'Nasional', NULL, NULL),
(14, 'Nanda Putra', 'SMA 14 Bogor', 94, 200000, 'Prestasi', NULL, NULL, 'Karya Tulis Ilmiah', 'Provinsi', NULL, NULL),
(15, 'Oscar Wilde', 'SMA 15 Padang', 80, 200000, 'Kedinasan', NULL, NULL, NULL, NULL, 'SK-001', 'Kemenhub'),
(16, 'Putri Cantika', 'SMA 16 Pontianak', 86, 200000, 'Kedinasan', NULL, NULL, NULL, NULL, 'SK-002', 'Kemenkeu'),
(17, 'Qori Febrian', 'SMA 17 Samarinda', 79, 200000, 'Kedinasan', NULL, NULL, NULL, NULL, 'SK-003', 'Kemenkes'),
(18, 'Rian Hidayat', 'SMA 18 Manado', 83, 200000, 'Kedinasan', NULL, NULL, NULL, NULL, 'SK-004', 'Kemenhub'),
(19, 'Siska Amelia', 'SMA 19 Ambon', 84, 200000, 'Kedinasan', NULL, NULL, NULL, NULL, 'SK-005', 'Kemenkeu'),
(20, 'Taufik Hidayat', 'SMA 20 Papua', 82, 200000, 'Kedinasan', NULL, NULL, NULL, NULL, 'SK-006', 'Kemenhub');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tabel_pendaftaran`
--
ALTER TABLE `tabel_pendaftaran`
  ADD PRIMARY KEY (`id_pendaftaran`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tabel_pendaftaran`
--
ALTER TABLE `tabel_pendaftaran`
  MODIFY `id_pendaftaran` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
